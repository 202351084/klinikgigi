<?php

namespace Database\Seeders;

use App\Models\Pasien;
use App\Models\PasienUser;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'nama_pasien' => 'Budi Santoso',
                'email' => 'budi.pasien@test.com',
                'nomor_hp' => '081298765401',
                'alamat' => 'Jl. Melati No. 12, Jakarta',
            ],
            [
                'nama_pasien' => 'Siti Rahma',
                'email' => 'siti.pasien@test.com',
                'nomor_hp' => '081298765402',
                'alamat' => 'Jl. Kenanga No. 8, Depok',
            ],
            [
                'nama_pasien' => 'Andi Pratama',
                'email' => 'andi.pasien@test.com',
                'nomor_hp' => '081298765403',
                'alamat' => 'Jl. Mawar No. 21, Bekasi',
            ],
            [
                'nama_pasien' => 'Dewi Lestari',
                'email' => 'dewi.pasien@test.com',
                'nomor_hp' => '081298765404',
                'alamat' => 'Jl. Anggrek No. 5, Tangerang',
            ],
            [
                'nama_pasien' => 'Rizky Hidayat',
                'email' => 'rizky.pasien@test.com',
                'nomor_hp' => '081298765405',
                'alamat' => 'Jl. Dahlia No. 17, Bogor',
            ],
        ];

        foreach ($items as $item) {
            $user = User::query()->updateOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['nama_pasien'],
                    'password' => Hash::make('pasien12345'),
                    'role' => 'patient',
                    'phone' => $item['nomor_hp'],
                    'address' => $item['alamat'],
                    'is_active' => true,
                ]
            );

            $pasien = Pasien::query()->updateOrCreate(
                ['email' => $item['email']],
                [
                    'nama_pasien' => $item['nama_pasien'],
                    'nomor_hp' => $item['nomor_hp'],
                    'alamat' => $item['alamat'],
                ]
            );

            PasienUser::query()->updateOrCreate(
                ['id_pasien' => $pasien->id_pasien],
                ['user_id' => $user->id]
            );
        }
    }
}
