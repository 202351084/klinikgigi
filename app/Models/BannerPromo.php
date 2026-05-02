<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BannerPromo extends Model
{
    protected $table = 'banner_promo';
    protected $primaryKey = 'id_banner';
    public $timestamps = false;

    protected $fillable = [
        'gambar_banner_promo',
    ];

    public function detail(): HasOne
    {
        return $this->hasOne(BannerPromoDetail::class, 'id_banner', 'id_banner');
    }

    public function klinik(): BelongsToMany
    {
        return $this->belongsToMany(Klinik::class, 'klinik_banner_promo', 'id_banner', 'id_klinik');
    }

    public function getJudulPromoAttribute(): ?string
    {
        return $this->detail?->judul_promo;
    }

    public function getDeskripsiPromoAttribute(): ?string
    {
        return $this->detail?->deskripsi_promo;
    }

    public function getMasaBerlakuMulaiAttribute()
    {
        return $this->detail?->masa_berlaku_mulai;
    }

    public function getMasaBerlakuSelesaiAttribute()
    {
        return $this->detail?->masa_berlaku_selesai;
    }

    public function getStatusAktifAttribute(): bool
    {
        return (bool) ($this->detail?->status_aktif ?? true);
    }

    public function getUrutanAttribute(): int
    {
        return (int) ($this->detail?->urutan ?? 1);
    }
}
