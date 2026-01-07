<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true; // no roles for now
    }
    

     public function rules()
    {
        $product = $this->route('product');

        return [
            'name'              => 'required|string|max:255',
            'slug'              => 'required|string|max:255|unique:products,slug,' . ($product?->id),
            'brand'             => 'required|exists:brands,id',
            'category'          => 'required|exists:categories,id',
    

            // Product attributes
            'product_attributes'   => 'nullable|array',
            'product_attributes.*' => 'integer|exists:attributes,id',

            // Attribute values
            'product_attribute_values'   => 'nullable|array',
            'product_attribute_values.*' => 'integer|exists:attribute_values,id',

            // Product base fields
            'short_description'   => 'nullable|string|max:500',
            'description'         => 'nullable|string',
            'sku'         => 'nullable',
            'original_price' => 'nullable',
            'selling_price' => 'nullable',
             'stock' => 'nullable',
            'status'              => 'required|in:published,draft',
            'is_featured'           => 'boolean',
            'is_new_arrival'           => 'boolean',
            'is_best_seller'           => 'boolean',
            'is_active'           => 'boolean',
            'main_image'          => 'nullable|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Product name is required',
            'slug.required' => 'Slug is required',
            'brand.required' => 'Brand is required',
            'category.required' => 'Category is required',
        ];
    }
}

