<?php

namespace Database\Seeders;

use App\Models\ClinicSetting;
use App\Models\OperationalHour;
use Illuminate\Database\Seeder;

class ClinicSettingSeeder extends Seeder
{
    public function run(): void
    {
        $setting = ClinicSetting::query()->firstOrCreate(
            ['clinic_name' => 'Cahaya Dental Care'],
            [
                'tagline' => 'Perawatan gigi keluarga yang rapi dan nyaman.',
                'about_title' => 'Klinik gigi untuk anak, dewasa, dan lansia.',
                'about_description' => 'Fokus pada pemeriksaan, tindakan dasar, dan perawatan estetika dengan alur reservasi yang sederhana.',
                'address' => 'Jl. Contoh No. 123, Jakarta',
                'whatsapp_number' => '081234567890',
                'phone_number' => '0211234567',
                'clinic_email' => 'halo@cahayadental.test',
                'doctor_name' => 'Drg. Cahaya',
                'doctor_title' => 'Dokter Gigi Utama',
                'doctor_specialty' => 'Perawatan gigi umum dan anak',
                'doctor_bio' => 'Menangani konsultasi, tambal gigi, scaling, cabut gigi biasa, dan edukasi kesehatan gigi keluarga.',
            ]
        );

        if ($setting->operationalHours()->count() === 0) {
            $days = [
                1 => 'Senin',
                2 => 'Selasa',
                3 => 'Rabu',
                4 => 'Kamis',
                5 => 'Jumat',
                6 => 'Sabtu',
                0 => 'Minggu',
            ];

            foreach ($days as $index => $name) {
                OperationalHour::query()->create([
                    'clinic_setting_id' => $setting->id,
                    'day_of_week' => $index,
                    'day_name' => $name,
                    'is_open' => $index !== 0,
                    'open_time' => $index !== 0 ? '09:00:00' : null,
                    'close_time' => $index !== 0 ? '17:00:00' : null,
                ]);
            }
        }
    }
}
