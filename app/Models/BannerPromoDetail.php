<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerPromoDetail extends Model
{
    protected $table = 'banner_promo_detail';
    protected $primaryKey = 'id_banner_detail';
    public $timestamps = false;

    protected $fillable = [
        'id_banner',
        'judul_promo',
        'deskripsi_promo',
        'masa_berlaku_mulai',
        'masa_berlaku_selesai',
        'status_aktif',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'masa_berlaku_mulai' => 'date',
            'masa_berlaku_selesai' => 'date',
            'status_aktif' => 'boolean',
            'urutan' => 'integer',
        ];
    }
}
