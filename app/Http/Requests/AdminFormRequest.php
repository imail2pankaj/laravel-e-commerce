<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminFormRequest extends FormRequest
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
        // Detect if update request → get ID from route
        $id = $this->route('id');

        return [
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'unique:admins,email,' . $id,   // ignore current admin on update
            ],

            'password' => $id
                ? 'nullable|min:6'             // update → optional
                : 'required|min:6',            // store → required

            'role'     => 'required|exists:roles,name'    
        ];
    }

}    
