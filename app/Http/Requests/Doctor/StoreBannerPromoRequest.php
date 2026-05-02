<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreBannerPromoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'doctor';
    }

    public function rules(): array
    {
        return [
            'judul_promo' => ['required', 'string', 'max:255'],
            'deskripsi_promo' => ['nullable', 'string'],
            'gambar_banner_promo' => ['required', 'image', 'max:4096'],
            'masa_berlaku_mulai' => ['nullable', 'date'],
            'masa_berlaku_selesai' => ['nullable', 'date', 'after_or_equal:masa_berlaku_mulai'],
            'status_aktif' => ['nullable', 'boolean'],
            'urutan' => ['required', 'integer', 'min:1'],
        ];
    }
}
