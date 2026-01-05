<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ProductSkuGenerator;
use App\Helpers\SkuHelper;
use App\Helpers\VariantSkuGenerator;
use App\Http\Controllers\BaseCrudController;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSeoRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\VariantStoreRequest;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductVariantValue;
use App\Models\Sku;
use App\Models\Tag;
use App\Services\Datatable\ActionBuilder;
use App\Services\ImageService;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends BaseCrudController
{
    protected string $moduleKey = 'products';
    protected $productRepo;
    protected $imageService;
    public function __construct(ProductRepositoryInterface $productRepo, ImageService $imageService)
    {
        parent::__construct();
        $this->productRepo = $productRepo;
        $this->imageService = $imageService;
    }

    public function index()
    {
        if (request()->ajax()) {
            $product = $this->productRepo->allQuery()
                ->with(['category:id,name', 'brand:id,name', 'variants']);

            //----------Fitler-----------

            if ($status = request('status')) {
                $product->where('status', $status);
            }

            if ($categoryId = request('category_id')) {
                $product->where('category_id', $categoryId);
            }

            if ($brandId = request('brand_id')) {
                $product->where('brand_id', $brandId);
            }

            //----------! Fitler-----------

            return DataTables::eloquent($product)
                ->addIndexColumn()

                // PRODUCT IMAGE
                ->addColumn('image', function ($p) {
                    $img = $p->main_image
                        ? asset("storage/{$p->main_image}")
                        : asset('no-image.png');

                    return "<img src='{$img}' class='rounded' style='width:45px;height:45px;object-fit:cover;'>";
                })

                // CATEGORY
                ->addColumn('category', function ($p) {
                    return $p->category?->name ?? '--';
                })

                // BRAND
                ->addColumn('brand', function ($p) {
                    return $p->brand?->name ?? '--';
                })

                // SELLING PRICE  
                ->addColumn('price', function ($p) {
                    return "₹" . number_format($p->selling_price);
                })

                // STATUS BADGE
                ->addColumn('status', function ($p) {
                    $badge = $p->status === 'published' ? 'bg-success' : 'bg-secondary';
                    return "<span class='badge {$badge}'>" . ucfirst($p->status) . "</span>";
                })

                // ACTION
                ->addColumn('action', function ($p) {
                    return ActionBuilder::make($p, [
                        'edit' => [
                            'can' => auth()->user()->hasPermissionTo($this->moduleKey . '.edit'),
                            'url' => route('product.edit', $p->id)
                        ],
                        'delete' => [
                            'can' => auth()->user()->hasPermissionTo($this->moduleKey . '.delete'),
                            'url' => route('product.delete', $p->id)
                        ]
                    ]);
                })

                ->rawColumns(['image', 'status', 'stock', 'action'])
                ->make(true);
        }

        $categories = Category::where('status', "published")->orderBy('name')->get(['id', 'name']);
        $brands = Brand::where('status', "published")->orderBy('name')->get(['id', 'name']);

        return view('admin.product.product-list', compact('categories', 'brands'));
    }

    public function create()
    {
        return $this->formResponse();
    }

    public function edit($id)
    {
        $product = $this->productRepo->find($id);

        return $this->formResponse($product);
    }

    private function formResponse($product = null)
    {

        return view('admin.product.product-form', [
            'product' => $product,
            'categories' => Category::all(),
            'brands' => Brand::all(),
            'allTags' => Tag::pluck('name')->toArray(),
            'attributes' => Attribute::with('values')->where('is_active', 1)->get(),
        ]);
    }


    public function store(ProductStoreRequest $request)
    {
        $data = $this->mapProductData($request);

        $product = $this->productRepo->create($data);

        if (!$product->sku) {
            $product->sku = ProductSkuGenerator::generate($product->name);
            $product->save();
        }

        $this->syncTags($product, $request->tags);


        return redirect()
            ->route('product.edit', $product->id)
            ->with('success', 'Product created successfully!')
            ->with('active_tab', 'tabProduct');
    }




    public function update(ProductStoreRequest $request, Product $product)
    {

        $data = $this->mapProductData($request);


        // MUST use repo
        $updated = $this->productRepo->update($product->id, $data);

        if ($request->hasFile('main_image')) {
            $this->imageService->delete($product->main_image);
        }


        if (!$updated->sku && $updated->variants()->count() == 0) {
            $updated->sku = ProductSkuGenerator::generate($updated->name);
            $updated->save();
        }

        $this->syncTags($updated, $request->tags);


        return redirect()
            ->route('product.edit', $product->id)
            ->with('success', 'Product updated successfully!')
            ->with('active_tab', 'tabProduct');
    }


    private function mapProductData($request)
    {
        $data = $request->validated();

        $data['category_id'] = $data['category'];
        $data['brand_id'] = $data['brand'];

        if ($request->hasFile('main_image')) {
            $data['main_image'] = $this->imageService->upload(
                $request->file('main_image'),
                'products/main_image',
                $request->name
            );
        }

        return $data;
    }



    public function updateSeo(ProductSeoRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($data['meta_keywords']) {
            $k = json_decode($data['meta_keywords'], true);
            $data['meta_keywords'] = collect($k)->pluck('value')->implode(',');
        }

        $product->update($data);

        return back()
            ->with('success', 'SEO updated successfully!')
            ->with('active_tab', 'tabSEO');
    }


    public function upload(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'images.*' => 'required|image|max:2048'
        ]);

        $product = Product::findOrFail($request->product_id);

        foreach ($request->file('images') as $file) {
            $path = $file->store('products/images', 'public');

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'sort_order' => 0,
                'is_active' => 1,
            ]);
        }

        return back()
            ->with('success', 'Images uploaded successfully!')
            ->with('active_tab', 'tabImages');
    }


    public function deleteImage($id)
    {
        $img = ProductImage::findOrFail($id);

        Storage::disk('public')->delete($img->image_path);
        $img->delete();

        return response()->json(['success' => true]);
    }

    public function sortImages(Request $request)
    {
        foreach ($request->order as $item) {
            ProductImage::where('id', $item['id'])
                ->update(['sort_order' => $item['position']]);
        }

        return response()->json(['success' => true]);
    }


    public function destroy($id)
    {
        $product = $this->productRepo->find($id);

        // Delete MAIN image
        $this->imageService->delete($product->main_image);

        // Delete gallery images
        foreach ($product->images as $img) {
            $this->imageService->delete($img->image_path);
        }

        // Delete product from DB
        $this->productRepo->delete($id);

        return redirect()
            ->route('product.list')
            ->with('success', 'Product deleted successfully!');
    }






    private function syncTags(Product $product, $tagsJson)
    {
        $tags = json_decode($tagsJson, true);
        $tagIds = [];

        if ($tags) {
            foreach ($tags as $tag) {
                $name = trim($tag['value']);
                $slug = Str::slug($name);

                $tagObj = Tag::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $name, 'status' => 1]
                );

                $tagIds[] = $tagObj->id;
            }
        }

        $product->tags()->sync($tagIds);
    }



    public function saveVariants(VariantStoreRequest $request, Product $product)
    {
        DB::beginTransaction();

        try {

            $createdVariants = []; // <-- NEW

            // ---------------------------------------------------------
            // 1. SAVE PRODUCT ATTRIBUTE VALUES
            // ---------------------------------------------------------
            $this->saveProductAttributes($product, $request->selected_values ?? []);


            // ---------------------------------------------------------
            // 2. BUILD ACTIVE COMBINATIONS FROM UI
            // ---------------------------------------------------------
            $activeCombinations = $this->getActiveCombinations($request);


            // ---------------------------------------------------------
            // 3. UPDATE EXISTING VARIANTS
            // ---------------------------------------------------------
            if ($request->variants) {

                foreach ($request->variants as $variantId => $data) {

                    $variant = ProductVariant::with('values')->find($variantId);
                    if (!$variant)
                        continue;

                    // build existing combo key
                    $existingKey = $variant->values
                        ->pluck('attribute_value_id')
                        ->sort()
                        ->implode('_');

                    $isStillValid = in_array($existingKey, $activeCombinations);

                    // update variant
                    $variant->update([
                        'original_price' => $data['original_price'],
                        'selling_price' => $data['selling_price'],
                        'stock' => $data['stock'],
                        'status' => $data['status'],
                        'is_invalid' => $isStillValid ? 0 : 1,
                        'invalid_reason' => $isStillValid ? null : 'Attribute or Attribute Value removed',
                    ]);

                    // IMAGE UPDATE
                    if (!empty($data['image'])) {

                        $imageFile = is_array($data['image']) ? $data['image'][0] : $data['image'];

                        $this->imageService->delete($variant->image);

                        $variant->update([
                            'image' => $this->imageService->upload(
                                $imageFile,
                                'products/variants',
                                $product->name
                            )
                        ]);
                    }
                }
            }


            // ---------------------------------------------------------
            // 4. CREATE NEW VARIANTS
            // ---------------------------------------------------------
            if ($request->new_variants) {

                foreach ($request->new_variants as $comboKey => $data) {

                    $valueIds = explode('_', $comboKey);

                    $generatedSku = VariantSkuGenerator::generate($product->sku, $valueIds);

                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => $generatedSku,
                        'original_price' => $data['original_price'] ?? null,
                        'selling_price' => $data['selling_price'] ?? null,
                        'stock' => $data['stock'] ?? null,
                        'status' => $data['status'],
                        'is_invalid' => 0,
                    ]);

                    // store for default logic
                    $createdVariants[$comboKey] = $variant;

                    // image upload
                    if (!empty($data['image'])) {
                        $imageFile = is_array($data['image']) ? $data['image'][0] : $data['image'];

                        $variant->update([
                            'image' => $this->imageService->upload(
                                $imageFile,
                                'products/variants',
                                $product->name
                            )
                        ]);
                    }

                    // mapping attribute values
                    foreach ($valueIds as $vId) {
                        ProductVariantValue::create([
                            'product_variant_id' => $variant->id,
                            'attribute_value_id' => $vId,
                            'attribute_id' => AttributeValue::find($vId)->attribute_id,
                        ]);
                    }
                }
            }


            // ---------------------------------------------------------
            // 5. INVALIDATE / RESTORE VARIANTS
            // ---------------------------------------------------------
            foreach ($product->variants()->with('values')->get() as $variant) {

                $comboKey = $variant->values
                    ->pluck('attribute_value_id')
                    ->sort()
                    ->implode('_');

                $variant->update([
                    'is_invalid' => in_array($comboKey, $activeCombinations) ? 0 : 1,
                    'invalid_reason' => in_array($comboKey, $activeCombinations) ? null : 'Attribute or Attribute Value removed',
                ]);
            }


            // ---------------------------------------------------------
            // 6. SET DEFAULT VARIANT (FIXED)
            // ---------------------------------------------------------
            if ($request->default_variant) {

                // Remove all defaults
                $product->variants()->update(['is_default' => 0]);

                $selected = $request->default_variant;

                // If existing variant selected
                if (!str_starts_with($selected, 'new_')) {

                    ProductVariant::where('id', $selected)
                        ->update(['is_default' => 1]);
                } else {
                    // extract combo key
                    $comboKey = str_replace('new_', '', $selected);

                    if (isset($createdVariants[$comboKey])) {
                        $createdVariants[$comboKey]->update(['is_default' => 1]);
                    }
                }
            }


            DB::commit();

            return back()
                ->with('active_tab', 'tabVariants')
                ->with('success', 'Variants saved successfully.');

        } catch (\Exception $e) {

            DB::rollBack();
            \Log::error($e->getMessage());

            return back()
                ->with('active_tab', 'tabVariants')
                ->with('error', $e->getMessage());
        }
    }


    private function saveProductAttributes(Product $product, array $valueIds)
    {
        if (empty($valueIds)) {
            $product->attributeValues()->detach();
            $product->attributes()->detach();
            return;
        }

        $product->attributeValues()->sync($valueIds);

        $attributeIds = AttributeValue::whereIn('id', $valueIds)
            ->pluck('attribute_id')
            ->unique()
            ->toArray();

        $product->attributes()->sync($attributeIds);
    }

    private function getActiveCombinations(Request $request)
    {
        $valueIds = $request->selected_values ?? [];

        if (empty($valueIds)) {
            return [];
        }

        // Group values by attribute
        $grouped = AttributeValue::whereIn('id', $valueIds)
            ->get()
            ->groupBy('attribute_id')
            ->map(fn($group) => $group->pluck('id')->toArray())
            ->values()
            ->toArray();

        // Cartesian product: same as JS
        $combinations = $this->cartesian($grouped);

        // Convert each combo into keys like "46_66"
        return array_map(function ($combo) {
            sort($combo);
            return implode('_', $combo);
        }, $combinations);
    }


    private function cartesian($arrays)
    {
        $result = [[]];

        foreach ($arrays as $property => $propertyValues) {
            $tmp = [];
            foreach ($result as $resultItem) {
                foreach ($propertyValues as $propertyValue) {
                    $tmp[] = array_merge($resultItem, [$propertyValue]);
                }
            }
            $result = $tmp;
        }

        return $result;
    }




    public function deleteVariant(ProductVariant $variant)
    {
        $variant->values()->delete();
        $variant->delete();

        return back()->with('success', 'Variant deleted.');
    }


}
