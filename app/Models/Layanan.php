<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Layanan extends Model
{
    protected $table = 'layanan';
    protected $primaryKey = 'id_layanan';
    public $timestamps = false;

    protected $fillable = [
        'nama_layanan',
        'gambar_layanan',
        'deskripsi_layanan',
        'harga_estimasi_biaya',
        'durasi_layanan',
        'status_layanan',
    ];

    protected function casts(): array
    {
        return [
            'harga_estimasi_biaya' => 'decimal:2',
            'durasi_layanan' => 'integer',
        ];
    }

    public function reservasiRelasi(): HasMany
    {
        return $this->hasMany(ReservasiRelasi::class, 'id_layanan', 'id_layanan');
    }

    public function reservasi(): HasManyThrough
    {
        return $this->hasManyThrough(
            Reservasi::class,
            ReservasiRelasi::class,
            'id_layanan',
            'id_reservasi',
            'id_layanan',
            'id_reservasi'
        );
    }
}
