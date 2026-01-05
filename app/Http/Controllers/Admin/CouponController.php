<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseCrudController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponFormRequest;
use App\Interfaces\CouponRepositoryInterface;
use App\Models\CouponBrand;
use App\Models\CouponCategory;
use App\Models\CouponProduct;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Services\Datatable\ActionBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends BaseCrudController
{
   protected string $moduleKey = 'coupons';
   protected $couponRepo;
   public function __construct(CouponRepositoryInterface $couponRepo)
   {
      parent::__construct();
      $this->couponRepo = $couponRepo;
   }

   public function index()
   {
      if (request()->ajax()) {
         $query = $this->couponRepo->allQuery();


         if (filled(request('status'))) {
            $query->where('status', request('status'));
         }

         if (filled(request('apply_type'))) {
            $query->where('apply_type', request('apply_type'));
         }


         return DataTables::eloquent($query)
            ->addIndexColumn()

            ->addColumn('discount_display', function ($c) {

               if ($c->discount_type == 'flat') {
                  return "<span class='badge bg-info'>₹ {$c->discount_value} Off</span>";
               }

               return "<span class='badge bg-primary'>{$c->discount_value}% Off</span>"
                  . ($c->max_discount ? "<br><small>(Max ₹{$c->max_discount})</small>" : "");
            })

            ->addColumn('apply_type_display', function ($c) {

               return match ($c->apply_type) {
                  'all' => "<span class='badge bg-success'>All Products</span>",
                  'product' => "<span class='badge bg-primary'>Products</span>",
                  'category' => "<span class='badge bg-warning text-dark'>Categories</span>",
                  'brand' => "<span class='badge bg-info'>Brands</span>",
                  default => "<span class='badge bg-secondary'>Unknown</span>"
               };
            })

            ->addColumn('validity_display', function ($c) {
               $start = $c->start_date ? date('d M Y', strtotime($c->start_date)) : '—';
               $end = $c->end_date ? date('d M Y', strtotime($c->end_date)) : '—';

               return "<small>$start → $end</small>";
            })



            ->addColumn('status_toggle', function ($coupon) {

               $checked = $coupon->status ? 'checked' : '';

               return '
                  <label class="switch switch-primary switch-sm">
                        <input type="checkbox"
                           class="switch-input coupon-status-toggle"
                           data-url="' . route('admin.coupons.toggleStatus', $coupon->id) . '"
                           ' . $checked . '>
                        <span class="switch-toggle-slider"></span>
                  </label>
               ';
            })



            ->addColumn('action', function ($val) {
               return ActionBuilder::make($val, [
                  'edit' => [
                     'can' => auth()->user()->hasPermissionTo($this->moduleKey . '.edit'),
                     'url' => route('admin.coupons.edit', $val->id)
                  ],
                  'delete' => [
                     'can' => auth()->user()->hasPermissionTo($this->moduleKey . '.delete'),
                     'url' => route('admin.coupons.destroy', $val->id)
                  ]
               ]);
            })

            ->rawColumns([
               'discount_display',
               'apply_type_display',
               'validity_display',
               'status_toggle',
               'action'
            ])
            ->make(true);
      }

      return view('admin.coupon.coupon-list');
   }


   public function create()
   {
      $products = Product::all();
      $categories = Category::all();
      $brands = Brand::all();

      return view('admin.coupon.coupon-form', compact('products', 'categories', 'brands'));
   }

   public function store(CouponFormRequest $request)
   {
      // dd($request->all());
      // Clean & prepare data
      $data = $request->validated();
      $data['code'] = strtoupper($data['code']); // auto uppercase
      $data['created_by'] = auth()->id();

      // Save coupon using repository
      $coupon = $this->couponRepo->create($data);

      // Mapping for product/category/brand
      if ($request->apply_type == "product" && $request->product_ids) {
         foreach ($request->product_ids as $productId) {
            CouponProduct::create([
               'coupon_id' => $coupon->id,
               'product_id' => $productId,
            ]);
         }
      }

      if ($request->apply_type == "category" && $request->category_ids) {
         foreach ($request->category_ids as $categoryId) {
            CouponCategory::create([
               'coupon_id' => $coupon->id,
               'category_id' => $categoryId,
            ]);
         }
      }

      if ($request->apply_type == "brand" && $request->brand_ids) {
         foreach ($request->brand_ids as $brandId) {
            CouponBrand::create([
               'coupon_id' => $coupon->id,
               'brand_id' => $brandId,
            ]);
         }
      }

      return redirect()
         ->route('admin.coupons.index')
         ->with('success', 'Coupon created successfully!');
   }


   public function edit($id)
   {
      $products = Product::all();
      $categories = Category::all();
      $brands = Brand::all();
      $coupon = $this->couponRepo->find($id);

      return view('admin.coupon.coupon-form', compact('coupon', 'products', 'categories', 'brands'));
   }

   public function update(CouponFormRequest $request, $id)
   {
      DB::beginTransaction();

      try {

         $data = [
            'name' => $request->name,
            'apply_type' => $request->apply_type,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'max_discount' => $request->discount_type === 'percent' ? $request->max_discount : null,
            'min_order_amount' => $request->min_order_amount,
            'usage_limit' => $request->usage_limit,
            'usage_limit_per_user' => $request->usage_limit_per_user,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
         ];

         // Update main table
         $coupon = $this->couponRepo->update($id, $data);

         // Reset mappings
         $coupon->products()->delete();
         $coupon->categories()->delete();
         $coupon->brands()->delete();

         // Insert new mappings
         if ($request->apply_type === 'product') {
            foreach ($request->product_ids as $pid) {
               $coupon->products()->create(['product_id' => $pid]);
            }
         }

         if ($request->apply_type === 'category') {
            foreach ($request->category_ids as $cid) {
               $coupon->categories()->create(['category_id' => $cid]);
            }
         }

         if ($request->apply_type === 'brand') {
            foreach ($request->brand_ids as $bid) {
               $coupon->brands()->create(['brand_id' => $bid]);
            }
         }

         DB::commit();
         return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully.');

      } catch (\Exception $e) {
         DB::rollBack();
         return back()->with('error', $e->getMessage())->withInput();
      }
   }

   public function destroy($id)
   {
      $this->couponRepo->delete($id);
      return redirect()->route('admin.coupons.index')->with('success', 'Record Delete Successfully...!!');

   }

   public function toggleStatus(Request $request, $id)
   {
      if (!auth()->user()->hasPermissionTo($this->moduleKey . '.edit')) {
         return response()->json([
            'message' => 'You do not have permission to change coupon status.'
         ], 403);
      }

      $coupon = $this->couponRepo->find($id);

      $this->couponRepo->update($id, [
         'status' => $coupon->status ? 0 : 1
      ]);

      return response()->json([
         'success' => true,
         'status' => !$coupon->status,
         'message' => 'Status updated successfully'
      ]);
   }



}
