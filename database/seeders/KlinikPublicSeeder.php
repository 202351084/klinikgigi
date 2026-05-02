<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\JamOperasional;
use App\Models\Klinik;
use App\Models\KlinikKontak;
use App\Models\PengaturanReservasi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KlinikPublicSeeder extends Seeder
{
    public function run(): void
    {
        $klinik = Klinik::query()->firstOrCreate(
            ['nama_klinik' => 'Cahaya Dental Care'],
            [
                'deskripsi_singkat' => 'Klinik gigi untuk anak, dewasa, dan lansia dengan layanan reservasi online yang sederhana.',
                'alamat' => 'Jl. Contoh No. 123, Jakarta',
                'nomor_whatsapp' => '081234567890',
            ]
        );

        $userDokter = User::query()->firstOrCreate(
            ['email' => 'doctor@cahayadental.test'],
            [
                'name' => 'Drg. Cahaya',
                'password' => Hash::make('klinikgigi123'),
                'role' => 'doctor',
                'phone' => '081234567890',
                'is_active' => true,
            ]
        );
        $userDokter->update([
            'name' => 'Drg. Cahaya',
            'role' => 'doctor',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        $dokter = Dokter::query()->updateOrCreate(
            ['nama_dokter' => 'Drg. Cahaya'],
            [
                'gelar' => 'drg.',
                'keterangan' => 'Dokter gigi utama yang menangani pemeriksaan, konsultasi, tindakan dasar, dan edukasi kesehatan gigi keluarga.',
            ]
        );

        $dokter->dokterUser()->updateOrCreate(
            ['id_dokter' => $dokter->id_dokter],
            ['user_id' => $userDokter->id]
        );
        $klinik->dokter()->syncWithoutDetaching([$dokter->id_dokter]);

        KlinikKontak::query()->updateOrCreate(
            ['id_klinik' => $klinik->id_klinik],
            [
                'nomor_telepon' => '081234567890',
                'email_klinik' => 'halo@cahayadental.com',
            ]
        );

        $pengaturan = PengaturanReservasi::query()->firstOrCreate(
            [
                'batas_maksimal_booking_per_hari' => 20,
                'interval_slot_per_jam' => 30,
                'hari_booking_ke_depan' => 30,
                'pasien_bisa_reschedule_sendiri' => false,
            ],
            [
                'batas_maksimal_booking_per_hari' => 20,
                'interval_slot_per_jam' => 30,
                'hari_booking_ke_depan' => 30,
                'pasien_bisa_reschedule_sendiri' => false,
            ]
        );
        $klinik->pengaturanReservasi()->sync([$pengaturan->id_pengaturan_reservasi]);

        $jamData = [
            ['hari_buka' => 'senin', 'jam_buka' => '09:00:00', 'jam_tutup' => '17:00:00', 'hari_libur' => false],
            ['hari_buka' => 'selasa', 'jam_buka' => '09:00:00', 'jam_tutup' => '17:00:00', 'hari_libur' => false],
            ['hari_buka' => 'rabu', 'jam_buka' => '09:00:00', 'jam_tutup' => '17:00:00', 'hari_libur' => false],
            ['hari_buka' => 'kamis', 'jam_buka' => '09:00:00', 'jam_tutup' => '17:00:00', 'hari_libur' => false],
            ['hari_buka' => 'jumat', 'jam_buka' => '09:00:00', 'jam_tutup' => '17:00:00', 'hari_libur' => false],
            ['hari_buka' => 'sabtu', 'jam_buka' => '09:00:00', 'jam_tutup' => '15:00:00', 'hari_libur' => false],
            ['hari_buka' => 'minggu', 'jam_buka' => null, 'jam_tutup' => null, 'hari_libur' => true],
        ];

        foreach ($jamData as $jam) {
            $jamOperasional = JamOperasional::query()->updateOrCreate(
                ['hari_buka' => $jam['hari_buka']],
                [
                    'jam_buka' => $jam['jam_buka'],
                    'jam_tutup' => $jam['jam_tutup'],
                    'hari_libur' => $jam['hari_libur'] ? 'libur' : null,
                ]
            );
            $klinik->jamOperasional()->syncWithoutDetaching([$jamOperasional->id_jam_operasional]);
        }

    }
}
