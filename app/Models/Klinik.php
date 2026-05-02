<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Klinik extends Model
{
    protected $table = 'klinik';
    protected $primaryKey = 'id_klinik';
    public $timestamps = false;

    protected $fillable = [
        'nama_klinik',
        'logo_klinik',
        'deskripsi_singkat',
        'alamat',
        'nomor_whatsapp',
    ];

    public function dokter(): BelongsToMany
    {
        return $this->belongsToMany(Dokter::class, 'klinik_dokter', 'id_klinik', 'id_dokter');
    }

    public function jamOperasional(): BelongsToMany
    {
        return $this->belongsToMany(JamOperasional::class, 'klinik_jam_operasional', 'id_klinik', 'id_jam_operasional');
    }

    public function pengaturanReservasi(): BelongsToMany
    {
        return $this->belongsToMany(PengaturanReservasi::class, 'klinik_pengaturan_reservasi', 'id_klinik', 'id_pengaturan_reservasi');
    }

    public function bannerPromo(): BelongsToMany
    {
        return $this->belongsToMany(BannerPromo::class, 'klinik_banner_promo', 'id_klinik', 'id_banner');
    }

    public function faq(): BelongsToMany
    {
        return $this->belongsToMany(Faq::class, 'klinik_faq', 'id_klinik', 'id_faq');
    }

    public function kontak(): HasOne
    {
        return $this->hasOne(KlinikKontak::class, 'id_klinik', 'id_klinik');
    }

    public function getNomorTeleponAttribute(): ?string
    {
        return $this->kontak?->nomor_telepon;
    }

    public function getEmailKlinikAttribute(): ?string
    {
        return $this->kontak?->email_klinik;
    }
}
