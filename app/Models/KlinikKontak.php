<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KlinikKontak extends Model
{
    protected $table = 'klinik_kontak';
    protected $primaryKey = 'id_kontak';
    public $timestamps = false;

    protected $fillable = ['id_klinik', 'nomor_telepon', 'email_klinik'];
}
