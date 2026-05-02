<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Faq extends Model
{
    protected $table = 'faq';
    protected $primaryKey = 'id_faq';
    public $timestamps = false;

    protected $fillable = [
        'pertanyaan',
        'jawaban',
        'status_tampil',
    ];

    protected function casts(): array
    {
        return [];
    }

    public function klinik(): BelongsToMany
    {
        return $this->belongsToMany(Klinik::class, 'klinik_faq', 'id_faq', 'id_klinik');
    }

    public function pengaturan(): HasOne
    {
        return $this->hasOne(FaqPengaturan::class, 'id_faq', 'id_faq');
    }

    public function getUrutanAttribute(): int
    {
        return (int) ($this->pengaturan?->urutan ?? 1);
    }

    public function getStatusTampilAttribute($value): bool
    {
        return in_array($value, [true, 1, '1', 'aktif', 'tampil'], true);
    }
}
