<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBodyAnalysisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'photo.required' => 'Foto harus diupload',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format foto harus JPG, JPEG, atau PNG',
            'photo.max' => 'Ukuran foto maksimal 5MB',
        ];
    }
}
