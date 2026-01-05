<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class VariantInventoryController extends Controller
{
    public function index()
    {
        $variants = ProductVariant::with('product')
        ->where('is_invalid', 0)   // SHOW ONLY VALID VARIANTS
        ->orderBy('id', 'desc')
        ->get();

        $products = Product::select('id','name')->orderBy('name')->get();

       return view('admin.product.inventory.inventory-list', compact('variants','products'));

    }


        public function update(Request $request)
        {
            $request->validate([
                'variants' => 'required|array',
                'variants.*.id' => 'required|exists:product_variants,id',

                // REQUIRED fields 👇
                'variants.*.selling_price' => 'required|numeric|min:0',
                'variants.*.stock'         => 'required|integer|min:0',

                // Optional
                'variants.*.original_price' => 'nullable|numeric|min:0',
                'variants.*.status'         => 'required|boolean',
            ]);

            foreach ($request->variants as $data) {
                ProductVariant::where('id', $data['id'])->update([
                    'original_price' => $data['original_price'],
                    'selling_price'  => $data['selling_price'],
                    'stock'          => $data['stock'],
                    'status'         => $data['status'],
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Inventory saved'
            ]);
        }

}
