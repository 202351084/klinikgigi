@extends('layouts.app', ['title' => $title])

@section('body')
    @include('doctor.partials.nav')
    <main class="container panel">
        <h1>{{ $title }}</h1>
        <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @csrf
            @if($method !== 'POST') @method($method) @endif
            <div class="field"><label>Judul</label><input name="title" value="{{ old('title', $banner->title) }}"></div>
            <div class="field"><label>Deskripsi</label><textarea name="description" rows="4">{{ old('description', $banner->description) }}</textarea></div>
            <div class="field"><label>Gambar</label><input type="file" name="image"></div>
            <div class="field"><label>Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order ?: 1) }}"></div>
            <div class="field"><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $banner->is_active ?? true))> Aktif</label></div>
            <button class="btn" type="submit">Simpan</button>
        </form>
    </main>
@endsection
