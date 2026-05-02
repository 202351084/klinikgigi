<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OperationalHour extends Model
{
    protected $fillable = [
        'clinic_setting_id',
        'day_of_week',
        'day_name',
        'is_open',
        'open_time',
        'close_time',
    ];

    protected function casts(): array
    {
        return [
            'is_open' => 'boolean',
        ];
    }

    public function clinicSetting(): BelongsTo
    {
        return $this->belongsTo(ClinicSetting::class);
    }
}
