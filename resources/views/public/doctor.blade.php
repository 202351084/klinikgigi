@extends('layouts.app', ['title' => 'Profil Dokter'])

@section('body')
    @include('public.partials.nav')
    <main class="container panel">
        <h1>{{ $dokter?->nama_dokter ?? 'Profil dokter belum tersedia' }}</h1>
        <p><strong>{{ $dokter?->gelar }}</strong></p>
        <p>{{ $dokter?->keterangan }}</p>
        @if($dokter?->foto_dokter)
            <img class="media" style="max-width:320px;margin-top:16px;" src="{{ asset('storage/'.$dokter->foto_dokter) }}" alt="{{ $dokter->nama_dokter }}">
        @endif
    </main>
    @include('public.partials.footer')
@endsection
