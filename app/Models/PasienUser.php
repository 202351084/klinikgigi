<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasienUser extends Model
{
    protected $table = 'pasien_user';
    protected $primaryKey = 'id_pasien_user';
    public $timestamps = false;

    protected $fillable = ['id_pasien', 'user_id'];
}
