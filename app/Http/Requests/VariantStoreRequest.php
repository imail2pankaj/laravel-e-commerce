<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class VariantStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
  public function authorize()
    {
        return true; // allow
    }

    public function rules()
    {
        return [
            'variants.*.selling_price'  => 'required|numeric|min:1',
            'variants.*.original_price' => 'required|numeric|min:1',
            'variants.*.stock'          => 'required|integer|min:0',


            'new_variants.*.selling_price'  => 'required|numeric|min:1',
            'new_variants.*.original_price' => 'required|numeric|min:1',
            'new_variants.*.stock'          => 'required|integer|min:0',

        ];
    }



    // 🔥 This ensures error appears in correct tab
    protected function failedValidation(Validator $validator)
    {
        session()->flash('active_tab', 'tabVariants');

        throw new ValidationException($validator);
    }
}
