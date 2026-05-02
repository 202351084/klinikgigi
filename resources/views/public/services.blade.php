@extends('layouts.app', ['title' => 'Layanan'])

@section('body')
    @include('public.partials.nav')
    <main class="container">
        <div class="panel">
            <h1>Layanan Klinik</h1>
            <p class="muted">Data layanan ini dikendalikan dari halaman dokter.</p>
        </div>
        <section class="grid grid-2" style="margin-top:24px;">
            @foreach($layananList as $layanan)
                <article class="card">
                    <h3>{{ $layanan->nama_layanan }}</h3>
                    <p class="muted">{{ $layanan->deskripsi_layanan }}</p>
                    <p>Biaya estimasi Rp{{ number_format($layanan->harga_estimasi_biaya, 0, ',', '.') }}</p>
                    <p>Durasi {{ $layanan->durasi_layanan }} menit</p>
                </article>
            @endforeach
        </section>
    </main>
    @include('public.partials.footer')
@endsection
