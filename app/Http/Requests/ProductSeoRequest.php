<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSeoRequest extends FormRequest
{
    public function authorize()
    {
        return true; // no permissions for now
    }

    public function rules()
    {
        return [
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'meta_keywords'     => 'nullable|string', // Tagify JSON string
        ];
    }
}
