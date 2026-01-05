<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       $id = $this->route('id');

        return [
        'name' => 'required|string|max:255',

        'slug' => 'required|string|max:255|unique:categories,slug,' . $id,

        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',

        'status' => 'required|in:published,draft,inactive',

        'is_featured' => 'nullable|boolean',

        'description' => 'nullable|string',

        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string|max:255',
        'meta_keywords' => 'nullable|string|max:255',
      ];
    }
}
