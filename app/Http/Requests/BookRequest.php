<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'title' => 'required|max:255',
            'summary' => 'required|max:255',
            'stock' => 'required',
            'poster' => 'mimes:jpg,png,jpeg',
            'genre_id' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul buku wajib diisi',
            'title.max' => 'Judul buku maksimal 255 karakter',
            'summary.required' => 'Ringkasan buku wajib diisi',
            'stock.required' => 'Jumlah stok buku wajib diisi',
            'poster.mimes' => 'Format gambar poster harus JPG, PNG, atau JPEG',
            'genre_id.required' => 'Kategori buku wajib dipilih'
        ];
    }
}
