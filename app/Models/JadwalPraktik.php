<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalPraktik extends Model
{
    protected $table = 'jadwal_praktik';
    protected $primaryKey = 'id_jadwal';
    public $timestamps = false;

    protected $fillable = [
        'tanggal',
        'jam_praktik',
        'status_slot',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function reservasi(): HasMany
    {
        return $this->hasMany(ReservasiRelasi::class, 'id_jadwal', 'id_jadwal');
    }
}
