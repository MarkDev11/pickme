<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGrowthRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'actual_weight' => 'required|numeric|min:2|max:50',
            'actual_height' => 'required|numeric|min:40|max:200',
            'head_circumference' => 'nullable|numeric|min:20|max:70',
            'parent_notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'actual_weight.required' => 'Berat badan harus diisi',
            'actual_weight.min' => 'Berat badan minimal 2 kg',
            'actual_weight.max' => 'Berat badan maksimal 50 kg',
            'actual_height.required' => 'Tinggi badan harus diisi',
            'actual_height.min' => 'Tinggi badan minimal 40 cm',
            'actual_height.max' => 'Tinggi badan maksimal 200 cm',
        ];
    }
}
