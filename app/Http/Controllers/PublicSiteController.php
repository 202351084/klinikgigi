<?php

namespace App\Http\Controllers;

use App\Models\Klinik;
use App\Models\Layanan;
use Carbon\Carbon;
use Illuminate\View\View;

class PublicSiteController extends Controller
{
    public function home(): View
    {
        $klinik = $this->klinik();
        $dokter = $klinik->dokter()->first();
        $today = Carbon::today();
        $bannerList = $klinik->bannerPromo()
            ->with('detail')
            ->get()
            ->filter(fn ($banner) => $banner->status_aktif
                && (! $banner->masa_berlaku_mulai || $banner->masa_berlaku_mulai->lte($today))
                && (! $banner->masa_berlaku_selesai || $banner->masa_berlaku_selesai->gte($today)))
            ->sortBy('urutan')
            ->values();
        $faqList = $klinik->faq()
            ->with('pengaturan')
            ->get()
            ->filter(fn ($faq) => $faq->status_tampil)
            ->sortBy('urutan')
            ->take(4)
            ->values();

        return view('public.home', [
            'klinik' => $klinik,
            'dokter' => $dokter,
            'layananList' => Layanan::query()->where('status_layanan', 'aktif')->orderBy('nama_layanan')->get(),
            'bannerList' => $bannerList,
            'jamOperasionalList' => $klinik->jamOperasional()->orderByRaw("FIELD(hari_buka, 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu')")->get(),
            'faqList' => $faqList,
        ]);
    }

    public function about(): View
    {
        $klinik = $this->klinik();

        return view('public.about', [
            'klinik' => $klinik,
            'dokter' => $klinik->dokter()->first(),
        ]);
    }

    public function services(): View
    {
        $klinik = $this->klinik();

        return view('public.services', [
            'klinik' => $klinik,
            'layananList' => Layanan::query()->where('status_layanan', 'aktif')->orderBy('nama_layanan')->get(),
        ]);
    }

    public function doctor(): View
    {
        $klinik = $this->klinik();

        return view('public.doctor', [
            'klinik' => $klinik,
            'dokter' => $klinik->dokter()->first(),
        ]);
    }

    public function schedule(): View
    {
        $klinik = $this->klinik();

        return view('public.schedule', [
            'klinik' => $klinik,
            'jamOperasionalList' => $klinik->jamOperasional()->orderByRaw("FIELD(hari_buka, 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu')")->get(),
        ]);
    }

    public function contact(): View
    {
        return view('public.contact', ['klinik' => $this->klinik()]);
    }

    public function faq(): View
    {
        $klinik = $this->klinik();

        return view('public.faq', [
            'klinik' => $klinik,
            'faqList' => $klinik->faq()
                ->with('pengaturan')
                ->get()
                ->filter(fn ($faq) => $faq->status_tampil)
                ->sortBy('urutan')
                ->values(),
        ]);
    }

    protected function klinik(): Klinik
    {
        return Klinik::query()->with(['kontak', 'bannerPromo.detail', 'jamOperasional', 'faq.pengaturan', 'pengaturanReservasi'])->firstOrFail();
    }
}
