<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FaqPengaturan;
use App\Models\Klinik;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $klinik = Klinik::query()->firstOrFail();

        $items = [
            [
                'pertanyaan' => 'Apakah harus membuat reservasi sebelum datang?',
                'jawaban' => 'Disarankan membuat reservasi terlebih dahulu agar jadwal kunjungan lebih tertata dan pasien tidak menunggu terlalu lama.',
            ],
            [
                'pertanyaan' => 'Apakah klinik melayani pasien anak?',
                'jawaban' => 'Ya, klinik melayani perawatan dasar gigi anak dengan pendekatan yang ramah dan nyaman.',
            ],
            [
                'pertanyaan' => 'Bagaimana cara membatalkan reservasi?',
                'jawaban' => 'Pasien dapat masuk ke akun pasien, membuka menu Reservasi Saya, lalu membatalkan reservasi yang masih bisa dibatalkan.',
            ],
            [
                'pertanyaan' => 'Apakah biaya layanan pasti sama dengan estimasi?',
                'jawaban' => 'Biaya yang tampil adalah estimasi. Biaya akhir dapat berubah sesuai kondisi gigi dan tindakan yang diperlukan setelah pemeriksaan.',
            ],
        ];

        foreach ($items as $index => $item) {
            $faq = Faq::query()->updateOrCreate(
                ['pertanyaan' => $item['pertanyaan']],
                [
                    'jawaban' => $item['jawaban'],
                    'status_tampil' => 'aktif',
                ]
            );

            $klinik->faq()->syncWithoutDetaching([$faq->id_faq]);
            FaqPengaturan::query()->updateOrCreate(
                ['id_faq' => $faq->id_faq],
                ['urutan' => $index + 1]
            );
        }
    }
}
