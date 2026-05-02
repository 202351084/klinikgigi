<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqPengaturan extends Model
{
    protected $table = 'faq_pengaturan';
    protected $primaryKey = 'id_faq_pengaturan';
    public $timestamps = false;

    protected $fillable = ['id_faq', 'urutan'];
}
