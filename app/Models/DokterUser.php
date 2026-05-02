<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokterUser extends Model
{
    protected $table = 'dokter_user';
    protected $primaryKey = 'id_dokter_user';
    public $timestamps = false;

    protected $fillable = ['id_dokter', 'user_id'];
}
