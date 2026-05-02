<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'doctor';
    }

    public function rules(): array
    {
        return [
            'nama_layanan' => ['required', 'string', 'max:255'],
            'deskripsi_layanan' => ['nullable', 'string'],
            'harga_estimasi_biaya' => ['required', 'numeric', 'min:0'],
            'durasi_layanan' => ['required', 'integer', 'min:5', 'max:360'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
