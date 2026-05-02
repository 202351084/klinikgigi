<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Pasien extends Model
{
    protected $table = 'pasien';
    protected $primaryKey = 'id_pasien';
    public $timestamps = false;

    protected $fillable = [
        'nama_pasien',
        'email',
        'nomor_hp',
        'alamat',
    ];

    public function user()
    {
        return $this->hasOneThrough(User::class, PasienUser::class, 'id_pasien', 'id', 'id_pasien', 'user_id');
    }

    public function reservasiRelasi(): HasMany
    {
        return $this->hasMany(ReservasiRelasi::class, 'id_pasien', 'id_pasien');
    }

    public function reservasi(): HasManyThrough
    {
        return $this->hasManyThrough(
            Reservasi::class,
            ReservasiRelasi::class,
            'id_pasien',
            'id_reservasi',
            'id_pasien',
            'id_reservasi'
        );
    }

    public function pasienUser()
    {
        return $this->hasOne(PasienUser::class, 'id_pasien', 'id_pasien');
    }

    public function getUserIdAttribute(): ?int
    {
        return $this->pasienUser?->user_id;
    }
}
