<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClinicSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'doctor';
    }

    public function rules(): array
    {
        $tab = $this->input('tab', 'identitas');

        $rules = [
            'tab' => ['required', 'string'],
        ];

        if ($tab === 'identitas') {
            $rules += [
                'clinic_name' => ['required', 'string', 'max:255'],
                'logo' => ['nullable', 'image', 'max:2048'],
                'about_description' => ['nullable', 'string'],
                'address' => ['nullable', 'string'],
            ];
        }

        if ($tab === 'kontak') {
            $rules += [
                'whatsapp_number' => ['nullable', 'string', 'max:30'],
                'phone_number' => ['nullable', 'string', 'max:30'],
                'clinic_email' => ['nullable', 'email'],
                'address' => ['nullable', 'string'],
            ];
        }

        if ($tab === 'profil-dokter') {
            $rules += [
                'doctor_name' => ['required', 'string', 'max:255'],
                'doctor_title' => ['nullable', 'string', 'max:255'],
                'doctor_specialty' => ['nullable', 'string', 'max:255'],
                'doctor_photo' => ['nullable', 'image', 'max:2048'],
                'doctor_bio' => ['nullable', 'string'],
            ];
        }

        if ($tab === 'pengaturan-reservasi') {
            $rules += [
                'booking_max_days_ahead' => ['required', 'integer', 'min:1', 'max:365'],
                'slot_interval_minutes' => ['required', 'integer', 'min:5', 'max:180'],
                'max_bookings_per_day' => ['required', 'integer', 'min:1', 'max:200'],
                'patient_can_reschedule' => ['nullable', 'boolean'],
            ];
        }

        if ($tab === 'jam-operasional') {
            $rules += [
                'hours' => ['required', 'array'],
                'hours.*.is_open' => ['nullable', 'boolean'],
                'hours.*.open_time' => ['nullable', 'date_format:H:i'],
                'hours.*.close_time' => ['nullable', 'date_format:H:i'],
            ];
        }

        return $rules;
    }
}
