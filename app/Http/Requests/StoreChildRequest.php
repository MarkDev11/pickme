<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChildRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date|before_or_equal:today',
            'birth_place' => 'required|string|max:100',
            'birth_weight' => 'required|numeric|min:0.5|max:10',
            'birth_height' => 'required|numeric|min:25|max:65',
            'birth_type' => 'required|in:normal,cesarean',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'blood_type' => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'health_notes' => 'nullable|string|max:1000',
            'allergy_notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama anak harus diisi',
            'gender.required' => 'Jenis kelamin harus dipilih',
            'birth_date.required' => 'Tanggal lahir harus diisi',
            'birth_date.before_or_equal' => 'Tanggal lahir tidak boleh di masa depan',
            'birth_place.required' => 'Tempat lahir harus diisi',
            'birth_weight.required' => 'Berat lahir harus diisi',
            'birth_weight.min' => 'Berat lahir minimal 0.5 kg',
            'birth_height.required' => 'Tinggi lahir harus diisi',
            'birth_height.min' => 'Tinggi lahir minimal 25 cm',
            'photo.image' => 'File harus berupa gambar',
            'photo.max' => 'Ukuran foto maksimal 2MB',
        ];
    }
}
