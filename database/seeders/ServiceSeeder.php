<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'nama_layanan' => 'Pemeriksaan dan Konsultasi Gigi',
                'deskripsi_layanan' => 'Pemeriksaan kondisi gigi dan mulut secara umum disertai konsultasi tindakan yang sesuai kebutuhan pasien.',
                'harga_estimasi_biaya' => 100000,
                'durasi_layanan' => 30,
            ],
            [
                'nama_layanan' => 'Tambal Gigi',
                'deskripsi_layanan' => 'Perawatan gigi berlubang ringan hingga sedang dengan bahan tambal sesuai indikasi.',
                'harga_estimasi_biaya' => 250000,
                'durasi_layanan' => 45,
            ],
            [
                'nama_layanan' => 'Scaling',
                'deskripsi_layanan' => 'Pembersihan karang gigi dan plak untuk menjaga kesehatan gusi dan mulut.',
                'harga_estimasi_biaya' => 300000,
                'durasi_layanan' => 45,
            ],
            [
                'nama_layanan' => 'Cabut Gigi Biasa',
                'deskripsi_layanan' => 'Tindakan pencabutan gigi dengan indikasi sederhana setelah pemeriksaan dokter.',
                'harga_estimasi_biaya' => 300000,
                'durasi_layanan' => 45,
            ],
            [
                'nama_layanan' => 'Perawatan Gusi Ringan',
                'deskripsi_layanan' => 'Penanganan awal pada keluhan gusi seperti bengkak ringan, iritasi, atau pembersihan area gusi.',
                'harga_estimasi_biaya' => 275000,
                'durasi_layanan' => 40,
            ],
            [
                'nama_layanan' => 'Penanganan Sakit Gigi dan Infeksi Ringan',
                'deskripsi_layanan' => 'Pemeriksaan dan penanganan awal keluhan nyeri gigi atau infeksi ringan untuk mengurangi keluhan pasien.',
                'harga_estimasi_biaya' => 200000,
                'durasi_layanan' => 30,
            ],
            [
                'nama_layanan' => 'Perawatan Saluran Akar Sederhana',
                'deskripsi_layanan' => 'Perawatan awal saluran akar sederhana berdasarkan kondisi dan indikasi klinis.',
                'harga_estimasi_biaya' => 750000,
                'durasi_layanan' => 60,
            ],
            [
                'nama_layanan' => 'Bleaching Gigi',
                'deskripsi_layanan' => 'Perawatan estetika untuk membantu mencerahkan warna gigi dengan prosedur yang aman dan terkontrol.',
                'harga_estimasi_biaya' => 1200000,
                'durasi_layanan' => 60,
            ],
            [
                'nama_layanan' => 'Perawatan Gigi Anak Dasar',
                'deskripsi_layanan' => 'Pemeriksaan dan tindakan dasar untuk pasien anak dengan pendekatan yang lebih nyaman dan ramah.',
                'harga_estimasi_biaya' => 220000,
                'durasi_layanan' => 30,
            ],
        ];

        foreach ($services as $service) {
            Layanan::query()->updateOrCreate(
                ['nama_layanan' => $service['nama_layanan']],
                $service + [
                    'gambar_layanan' => null,
                    'status_layanan' => 'aktif',
                ]
            );
        }
    }
}
