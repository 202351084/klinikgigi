<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Dokter extends Model
{
    protected $table = 'dokter';
    protected $primaryKey = 'id_dokter';
    public $timestamps = false;

    protected $fillable = [
        'nama_dokter',
        'foto_dokter',
        'gelar',
        'keterangan',
    ];

    public function user()
    {
        return $this->hasOneThrough(User::class, DokterUser::class, 'id_dokter', 'id', 'id_dokter', 'user_id');
    }

    public function klinik(): BelongsToMany
    {
        return $this->belongsToMany(Klinik::class, 'klinik_dokter', 'id_dokter', 'id_klinik');
    }

    public function dokterUser(): HasOne
    {
        return $this->hasOne(DokterUser::class, 'id_dokter', 'id_dokter');
    }

    public function getUserIdAttribute(): ?int
    {
        return $this->dokterUser?->user_id;
    }

    public function getIdKlinikAttribute(): ?int
    {
        return $this->klinik()->value('klinik.id_klinik');
    }

    public function reservasiRelasi(): HasMany
    {
        return $this->hasMany(ReservasiRelasi::class, 'id_dokter', 'id_dokter');
    }

    public function reservasi(): HasManyThrough
    {
        return $this->hasManyThrough(
            Reservasi::class,
            ReservasiRelasi::class,
            'id_dokter',
            'id_reservasi',
            'id_dokter',
            'id_reservasi'
        );
    }

    public function jadwalPraktik(): HasManyThrough
    {
        return $this->hasManyThrough(
            JadwalPraktik::class,
            ReservasiRelasi::class,
            'id_dokter',
            'id_jadwal',
            'id_dokter',
            'id_jadwal'
        );
    }
}
