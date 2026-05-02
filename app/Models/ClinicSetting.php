<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClinicSetting extends Model
{
    protected $fillable = [
        'clinic_name',
        'tagline',
        'logo_path',
        'about_title',
        'about_description',
        'address',
        'google_maps_embed',
        'whatsapp_number',
        'phone_number',
        'clinic_email',
        'doctor_name',
        'doctor_title',
        'doctor_specialty',
        'doctor_photo_path',
        'doctor_bio',
        'booking_max_days_ahead',
        'slot_interval_minutes',
        'max_bookings_per_day',
        'patient_can_reschedule',
    ];

    protected function casts(): array
    {
        return [
            'booking_max_days_ahead' => 'integer',
            'slot_interval_minutes' => 'integer',
            'max_bookings_per_day' => 'integer',
            'patient_can_reschedule' => 'boolean',
        ];
    }

    public function operationalHours(): HasMany
    {
        return $this->hasMany(OperationalHour::class);
    }

    public function banners(): HasMany
    {
        return $this->hasMany(Banner::class);
    }
}
