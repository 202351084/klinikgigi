<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamOperasional extends Model
{
    protected $table = 'jam_operasional';
    protected $primaryKey = 'id_jam_operasional';
    public $timestamps = false;

    protected $fillable = [
        'hari_buka',
        'jam_buka',
        'jam_tutup',
        'hari_libur',
    ];

    protected function casts(): array
    {
        return [];
    }

    public function klinik()
    {
        return $this->belongsToMany(Klinik::class, 'klinik_jam_operasional', 'id_jam_operasional', 'id_klinik');
    }

    public function getHariLiburAttribute($value): bool
    {
        return in_array($value, [true, 1, '1', 'libur', 'ya'], true);
    }
}
