<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrowthRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:5120',
            'record_date' => 'required|date|before_or_equal:today',
            'head_circumference' => 'nullable|numeric|min:20|max:70',
            'parent_notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'photo.required' => 'Foto anak harus diupload',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format foto harus JPG, JPEG, atau PNG',
            'photo.max' => 'Ukuran foto maksimal 5MB',
            'record_date.required' => 'Tanggal pemeriksaan harus diisi',
            'record_date.before_or_equal' => 'Tanggal pemeriksaan tidak boleh di masa depan',
        ];
    }
}
