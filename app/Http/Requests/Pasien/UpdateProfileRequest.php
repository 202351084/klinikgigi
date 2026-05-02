<?php

namespace App\Http\Requests\Pasien;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'patient';
    }

    public function rules(): array
    {
        return [
            'nama_pasien' => ['required', 'string', 'max:255'],
            'nomor_hp' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string'],
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ];
    }
}
