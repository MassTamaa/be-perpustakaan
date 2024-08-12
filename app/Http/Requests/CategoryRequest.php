<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        return [
            'name' =>'required|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama category wajib diisi',
            'name.string' => 'Nama category harus berupa string',
            'name.max' => 'Nama category maksimal 255 karakter'
        ];
    }
}
