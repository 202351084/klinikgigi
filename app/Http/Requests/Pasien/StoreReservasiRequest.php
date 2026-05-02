<?php

namespace App\Http\Requests\Pasien;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'patient';
    }

    public function rules(): array
    {
        return [
            'id_layanan' => ['required', 'integer', 'exists:layanan,id_layanan'],
            'tanggal_reservasi' => ['required', 'date', 'after_or_equal:today'],
            'jam_kunjungan' => ['required', 'date_format:H:i'],
            'metode_pembayaran' => ['required', 'in:cash,qris'],
            'keluhan_pasien' => ['required', 'string', 'min:5', 'max:1000'],
        ];
    }
}
