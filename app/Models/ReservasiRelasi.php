<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservasiRelasi extends Model
{
    protected $table = 'reservasi_relasi';
    protected $primaryKey = 'id_reservasi_relasi';
    public $timestamps = false;

    protected $fillable = ['id_reservasi', 'id_pasien', 'id_dokter', 'id_layanan', 'id_jadwal'];

    public function reservasi(): BelongsTo
    {
        return $this->belongsTo(Reservasi::class, 'id_reservasi', 'id_reservasi');
    }

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class, 'id_dokter', 'id_dokter');
    }

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class, 'id_layanan', 'id_layanan');
    }

    public function jadwalPraktik(): BelongsTo
    {
        return $this->belongsTo(JadwalPraktik::class, 'id_jadwal', 'id_jadwal');
    }
}
