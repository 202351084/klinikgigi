<?php

namespace App\Models;

use App\Enums\StatusReservasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservasi extends Model
{
    protected $table = 'reservasi';
    protected $primaryKey = 'id_reservasi';
    public $timestamps = false;

    protected $fillable = [
        'kode_reservasi',
        'tanggal_reservasi',
        'jam_kunjungan',
        'keluhan_pasien',
        'status_reservasi',
        'metode_pembayaran',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_reservasi' => 'date',
            'status_reservasi' => StatusReservasi::class,
        ];
    }

    public function relasi(): HasOne
    {
        return $this->hasOne(ReservasiRelasi::class, 'id_reservasi', 'id_reservasi');
    }

    public function reschedule(): HasOne
    {
        return $this->hasOne(ReservasiReschedule::class, 'id_reservasi', 'id_reservasi');
    }

    public function getPasienAttribute()
    {
        return $this->relasi?->pasien;
    }

    public function getDokterAttribute()
    {
        return $this->relasi?->dokter;
    }

    public function getLayananAttribute()
    {
        return $this->relasi?->layanan;
    }

    public function getJadwalPraktikAttribute()
    {
        return $this->relasi?->jadwalPraktik;
    }

    public function getIdPasienAttribute(): ?int
    {
        return $this->relasi?->id_pasien;
    }

    public function getIdDokterAttribute(): ?int
    {
        return $this->relasi?->id_dokter;
    }

    public function getIdLayananAttribute(): ?int
    {
        return $this->relasi?->id_layanan;
    }

    public function getIdJadwalAttribute(): ?int
    {
        return $this->relasi?->id_jadwal;
    }

    public function getCatatanDokterAttribute(): ?string
    {
        return $this->reschedule?->catatan_dokter;
    }

    public function getUsulanTanggalRescheduleAttribute()
    {
        return $this->reschedule?->usulan_tanggal_reschedule;
    }

    public function getUsulanJamRescheduleAttribute()
    {
        return $this->reschedule?->usulan_jam_reschedule;
    }
}
