@extends('layouts.doctor', ['title' => $title])

@section('doctor_content')
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h1>{{ $title }}</h1>
        <form method="POST" action="{{ $action }}">
            @csrf
            @if($method !== 'POST') @method($method) @endif
            <div class="field"><label>Nama</label><input name="nama_layanan" value="{{ old('nama_layanan', $service->nama_layanan) }}"></div>
            <div class="field"><label>Deskripsi</label><textarea name="deskripsi_layanan" rows="4">{{ old('deskripsi_layanan', $service->deskripsi_layanan) }}</textarea></div>
            <div class="field"><label>Harga</label><input type="number" step="0.01" name="harga_estimasi_biaya" value="{{ old('harga_estimasi_biaya', $service->harga_estimasi_biaya) }}"></div>
            <div class="field"><label>Durasi (menit)</label><input type="number" name="durasi_layanan" value="{{ old('durasi_layanan', $service->durasi_layanan ?: 30) }}"></div>
            <div class="field"><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', ($service->status_layanan ?? 'aktif') === 'aktif'))> Aktif</label></div>
            <button class="btn" type="submit">Simpan</button>
        </form>
    </section>
@endsection
