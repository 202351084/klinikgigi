<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanReservasi extends Model
{
    protected $table = 'pengaturan_reservasi';
    protected $primaryKey = 'id_pengaturan_reservasi';
    public $timestamps = false;

    protected $fillable = [
        'batas_maksimal_booking_per_hari',
        'interval_slot_per_jam',
        'hari_booking_ke_depan',
        'pasien_bisa_reschedule_sendiri',
    ];

    protected function casts(): array
    {
        return [
            'batas_maksimal_booking_per_hari' => 'integer',
            'interval_slot_per_jam' => 'integer',
            'hari_booking_ke_depan' => 'integer',
            'pasien_bisa_reschedule_sendiri' => 'boolean',
        ];
    }

    public function klinik()
    {
        return $this->belongsToMany(Klinik::class, 'klinik_pengaturan_reservasi', 'id_pengaturan_reservasi', 'id_klinik');
    }
}
