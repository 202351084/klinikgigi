<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreBannerPromoRequest;
use App\Http\Requests\Doctor\StoreFaqRequest;
use App\Http\Requests\Doctor\UpdateBannerPromoRequest;
use App\Http\Requests\Doctor\UpdateClinicSettingRequest;
use App\Http\Requests\Doctor\UpdateFaqRequest;
use App\Models\BannerPromo;
use App\Models\BannerPromoDetail;
use App\Models\Dokter;
use App\Models\Faq;
use App\Models\FaqPengaturan;
use App\Models\JamOperasional;
use App\Models\Klinik;
use App\Models\PengaturanReservasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DoctorSettingController extends Controller
{
    private const MAX_FAQ_ITEMS = 4;

    private const TABS = [
        'identitas',
        'kontak',
        'jam-operasional',
        'profil-dokter',
        'pengaturan-reservasi',
        'banner-promo',
        'faq',
    ];

    public function edit(): View
    {
        $klinik = Klinik::query()->with(['kontak', 'jamOperasional', 'pengaturanReservasi', 'bannerPromo.detail', 'faq.pengaturan'])->firstOrFail();
        $dokter = $klinik->dokter()->firstOrFail();
        $pengaturanReservasi = $klinik->pengaturanReservasi()->first();
        $bannerPromoList = $klinik->bannerPromo()->with('detail')->get()->sortBy('urutan')->values();
        $faqList = $klinik->faq()->with('pengaturan')->get()->sortBy('urutan')->values();
        $faqLimitReached = $faqList->count() >= self::MAX_FAQ_ITEMS;
        $activeTab = request()->query('tab', 'identitas');

        if (! in_array($activeTab, self::TABS, true)) {
            $activeTab = 'identitas';
        }

        return view('doctor.settings.edit', compact('klinik', 'dokter', 'pengaturanReservasi', 'bannerPromoList', 'faqList', 'faqLimitReached', 'activeTab'));
    }

    public function update(UpdateClinicSettingRequest $request): RedirectResponse
    {
        $klinik = Klinik::query()->with('jamOperasional', 'pengaturanReservasi')->firstOrFail();
        $dokter = $klinik->dokter()->firstOrFail();
        $pengaturanReservasi = $klinik->pengaturanReservasi()->first()
            ?? PengaturanReservasi::query()->create([
                'batas_maksimal_booking_per_hari' => 20,
                'interval_slot_per_jam' => 30,
                'hari_booking_ke_depan' => 30,
                'pasien_bisa_reschedule_sendiri' => false,
            ]);

        if (! $klinik->pengaturanReservasi()->whereKey($pengaturanReservasi->getKey())->exists()) {
            $klinik->pengaturanReservasi()->attach($pengaturanReservasi->getKey());
        }

        $data = $request->validated();
        $tab = $request->string('tab')->toString();

        if ($request->hasFile('logo')) {
            $data['logo_klinik'] = $request->file('logo')->store('clinic', 'public');
        }

        if ($request->hasFile('doctor_photo')) {
            $data['foto_dokter'] = $request->file('doctor_photo')->store('doctor', 'public');
        }

        $jamOperasional = $data['hours'] ?? [];
        unset($data['logo'], $data['doctor_photo'], $data['hours']);

        DB::transaction(function () use ($tab, $klinik, $dokter, $pengaturanReservasi, $data, $jamOperasional, $request) {
            if ($tab === 'identitas') {
                $klinik->update([
                    'nama_klinik' => $data['clinic_name'],
                    'logo_klinik' => $data['logo_klinik'] ?? $klinik->logo_klinik,
                    'deskripsi_singkat' => $data['about_description'],
                    'alamat' => $data['address'],
                ]);
            }

            if ($tab === 'kontak') {
                $klinik->update([
                    'nomor_whatsapp' => $data['whatsapp_number'],
                    'alamat' => $data['address'],
                ]);

                $klinik->kontak()->updateOrCreate(
                    ['id_klinik' => $klinik->id_klinik],
                    [
                        'nomor_telepon' => $data['phone_number'],
                        'email_klinik' => $data['clinic_email'],
                    ]
                );
            }

            if ($tab === 'profil-dokter') {
                $dokter->update([
                    'nama_dokter' => $data['doctor_name'],
                    'foto_dokter' => $data['foto_dokter'] ?? $dokter->foto_dokter,
                    'gelar' => $data['doctor_title'],
                    'keterangan' => trim(($data['doctor_specialty'] ? $data['doctor_specialty']."\n\n" : '').($data['doctor_bio'] ?? '')),
                ]);
            }

            if ($tab === 'pengaturan-reservasi') {
                $pengaturanReservasi->update([
                    'batas_maksimal_booking_per_hari' => $data['max_bookings_per_day'],
                    'interval_slot_per_jam' => $data['slot_interval_minutes'],
                    'hari_booking_ke_depan' => $data['booking_max_days_ahead'],
                    'pasien_bisa_reschedule_sendiri' => $request->boolean('patient_can_reschedule'),
                ]);
            }

            if ($tab === 'jam-operasional') {
                foreach ($jamOperasional as $hourId => $hourData) {
                    JamOperasional::query()->whereKey($hourId)->update([
                        'hari_libur' => empty($hourData['is_open']) ? 'libur' : null,
                        'jam_buka' => ! empty($hourData['is_open']) ? $hourData['open_time'] : null,
                        'jam_tutup' => ! empty($hourData['is_open']) ? $hourData['close_time'] : null,
                    ]);
                }
            }
        });

        return redirect()
            ->route('doctor.settings.edit', ['tab' => $tab])
            ->with('status', 'Pengaturan tersimpan dan halaman publik ikut diperbarui.');
    }

    public function storeBanner(StoreBannerPromoRequest $request): RedirectResponse
    {
        $klinik = Klinik::query()->firstOrFail();
        $data = $request->validated();

        $banner = BannerPromo::query()->create([
            'gambar_banner_promo' => $request->file('gambar_banner_promo')->store('banner-promo', 'public'),
        ]);
        $klinik->bannerPromo()->attach($banner->id_banner);
        BannerPromoDetail::query()->create([
            'id_banner' => $banner->id_banner,
            'judul_promo' => $data['judul_promo'],
            'deskripsi_promo' => $data['deskripsi_promo'] ?? null,
            'masa_berlaku_mulai' => $data['masa_berlaku_mulai'] ?? null,
            'masa_berlaku_selesai' => $data['masa_berlaku_selesai'] ?? null,
            'status_aktif' => $request->boolean('status_aktif'),
            'urutan' => $data['urutan'],
        ]);

        return redirect()->route('doctor.settings.edit', ['tab' => 'banner-promo'])->with('status', 'Banner promo berhasil ditambahkan dan akan tampil di homepage jika aktif.');
    }

    public function updateBanner(UpdateBannerPromoRequest $request, BannerPromo $bannerPromo): RedirectResponse
    {
        $data = $request->validated();
        $detailData = $data;
        unset($detailData['gambar_banner_promo']);
        $detailData['status_aktif'] = $request->boolean('status_aktif');

        if ($request->hasFile('gambar_banner_promo')) {
            $bannerPromo->update([
                'gambar_banner_promo' => $request->file('gambar_banner_promo')->store('banner-promo', 'public'),
            ]);
        }

        $bannerPromo->detail()->updateOrCreate(
            ['id_banner' => $bannerPromo->id_banner],
            $detailData
        );

        return redirect()->route('doctor.settings.edit', ['tab' => 'banner-promo'])->with('status', 'Banner promo berhasil diperbarui.');
    }

    public function destroyBanner(BannerPromo $bannerPromo): RedirectResponse
    {
        $bannerPromo->delete();

        return redirect()->route('doctor.settings.edit', ['tab' => 'banner-promo'])->with('status', 'Banner promo berhasil dihapus.');
    }

    public function storeFaq(StoreFaqRequest $request): RedirectResponse
    {
        $klinik = Klinik::query()->firstOrFail();

        if ($klinik->faq()->count() >= self::MAX_FAQ_ITEMS) {
            return redirect()
                ->route('doctor.settings.edit', ['tab' => 'faq'])
                ->with('status', 'FAQ sudah mencapai batas maksimal 4 item. Hapus salah satu FAQ terlebih dahulu.');
        }

        $data = $request->validated();

        $faq = Faq::query()->create([
            'pertanyaan' => $data['pertanyaan'],
            'jawaban' => $data['jawaban'],
            'status_tampil' => $request->boolean('status_tampil') ? 'aktif' : 'nonaktif',
        ]);
        $klinik->faq()->attach($faq->id_faq);
        FaqPengaturan::query()->create([
            'id_faq' => $faq->id_faq,
            'urutan' => $data['urutan'],
        ]);

        return redirect()->route('doctor.settings.edit', ['tab' => 'faq'])->with('status', 'FAQ berhasil ditambahkan.');
    }

    public function updateFaq(UpdateFaqRequest $request, Faq $faq): RedirectResponse
    {
        $data = $request->validated();
        $faq->update([
            'pertanyaan' => $data['pertanyaan'],
            'jawaban' => $data['jawaban'],
            'status_tampil' => $request->boolean('status_tampil') ? 'aktif' : 'nonaktif',
        ]);
        $faq->pengaturan()->updateOrCreate(
            ['id_faq' => $faq->id_faq],
            ['urutan' => $data['urutan']]
        );

        return redirect()->route('doctor.settings.edit', ['tab' => 'faq'])->with('status', 'FAQ berhasil diperbarui.');
    }

    public function destroyFaq(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()->route('doctor.settings.edit', ['tab' => 'faq'])->with('status', 'FAQ berhasil dihapus.');
    }
}
