@extends('layouts.app', ['title' => 'Banner'])

@section('body')
    @include('doctor.partials.nav')
    <main class="container panel">
        @if(session('status')) <div class="flash">{{ session('status') }}</div> @endif
        <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;">
            <div><h1>Kelola Banner</h1><p class="muted">Banner aktif tampil di homepage publik.</p></div>
            <a class="btn" href="{{ route('doctor.banner.create') }}">Tambah Banner</a>
        </div>
        <table class="table">
            <thead><tr><th>Judul</th><th>Urutan</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @foreach($banners as $banner)
                    <tr>
                        <td>{{ $banner->title }}</td>
                        <td>{{ $banner->sort_order }}</td>
                        <td>{{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                        <td>
                            <a href="{{ route('doctor.banner.edit', $banner) }}">Edit</a>
                            <form action="{{ route('doctor.banner.destroy', $banner) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" style="border:none;background:none;color:#a62323;cursor:pointer;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
@endsection
