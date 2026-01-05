<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
 public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $applyType = $this->apply_type;
        $isPercent = $this->discount_type === 'percent';

        return [
            'code' => 'required|string|max:50|unique:coupons,code,' . $this->route('id'),
            'name' => 'required|string|max:255',

            'apply_type' => 'required|in:all,product,category,brand',

            'product_ids'  => $applyType === 'product'  ? 'required|array|min:1' : 'nullable|array',
            'product_ids.*'=> 'integer|exists:products,id',

            'category_ids' => $applyType === 'category' ? 'required|array|min:1' : 'nullable|array',
            'category_ids.*'=> 'integer|exists:categories,id',

            'brand_ids'    => $applyType === 'brand'    ? 'required|array|min:1' : 'nullable|array',
            'brand_ids.*'  => 'integer|exists:brands,id',

            'discount_type' => 'required|in:flat,percent',
            'discount_value' => 'required|numeric|min:0',

            'max_discount' => $isPercent ? 'required|numeric|min:0' : 'nullable',

            'min_order_amount' => 'nullable|numeric|min:0',

            'usage_limit' => 'nullable|integer|min:0',
            'usage_limit_per_user' => 'nullable|integer|min:0',

            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',

            'status' => 'required|in:0,1',
        ];
    }
}
