<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'doctor@cahayadental.test'],
            [
                'name' => 'Drg. Cahaya',
                'password' => Hash::make('klinikgigi123'),
                'role' => 'doctor',
                'phone' => '081234567890',
                'is_active' => true,
            ]
        );
    }
}
