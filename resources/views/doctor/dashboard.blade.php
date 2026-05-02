@extends('layouts.doctor', ['title' => 'Dashboard Dokter'])

@section('doctor_content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800 sm:text-3xl">Dashboard Dokter</h1>
            <p class="mt-1 text-sm text-slate-500">Ringkasan cepat untuk aktivitas klinik dan konten website publik.</p>
        </div>
        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 2xl:grid-cols-7">
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Total reservasi</div>
                <div class="mt-2 text-3xl font-semibold text-slate-800">{{ $reservationCount }}</div>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Menunggu</div>
                <div class="mt-2 text-3xl font-semibold text-amber-600">{{ $pendingReservationCount }}</div>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Terjadwal</div>
                <div class="mt-2 text-3xl font-semibold text-teal-700">{{ $scheduledReservationCount }}</div>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Selesai</div>
                <div class="mt-2 text-3xl font-semibold text-emerald-700">{{ $completedReservationCount }}</div>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Total layanan</div>
                <div class="mt-2 text-3xl font-semibold text-slate-800">{{ $serviceCount }}</div>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Layanan aktif</div>
                <div class="mt-2 text-3xl font-semibold text-slate-800">{{ $activeServiceCount }}</div>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Banner publik</div>
                <div class="mt-2 text-3xl font-semibold text-slate-800">{{ $bannerCount }}</div>
            </article>
        </section>

        <section class="mt-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-lg font-semibold text-slate-800">Ringkasan Panel Dokter</h2>
            <p class="mt-2 text-sm leading-6 text-slate-600">
                Area dokter dipakai untuk mengelola pengaturan klinik, layanan, banner publik, dan modul reservasi agar perubahan data langsung memengaruhi website publik.
            </p>
            <p class="mt-3 text-sm text-slate-700">Total pasien saat ini: <span class="font-semibold">{{ $patientCount }}</span></p>
        </section>
    </div>
@endsection
