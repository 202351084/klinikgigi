@extends('layouts.app', ['title' => 'Tentang Klinik'])

@section('body')
    @include('public.partials.nav')
    <main class="container panel">
        <h1>Tentang {{ $klinik->nama_klinik }}</h1>
        <p class="muted">{{ $klinik->deskripsi_singkat ?: 'Klinik gigi untuk konsultasi, perawatan dasar, dan kontrol kesehatan gigi keluarga.' }}</p>
        <p><strong>Alamat:</strong> {{ $klinik->alamat ?: '-' }}</p>
        @if($dokter)
            <p><strong>Dokter Utama:</strong> {{ $dokter->nama_dokter }}{{ $dokter->gelar ? ', '.$dokter->gelar : '' }}</p>
            <p>{{ $dokter->keterangan }}</p>
        @endif
    </main>
    @include('public.partials.footer')
@endsection
