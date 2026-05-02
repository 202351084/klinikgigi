@extends('layouts.doctor', ['title' => 'Layanan'])

@section('doctor_content')
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        @if(session('status')) <div class="flash">{{ session('status') }}</div> @endif
        <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;">
            <div><h1>Kelola Layanan</h1><p class="muted">Layanan aktif otomatis tampil di halaman publik.</p></div>
            <a class="btn" href="{{ route('doctor.layanan.create') }}">Tambah Layanan</a>
        </div>
        <table class="table">
            <thead><tr><th>Nama</th><th>Harga</th><th>Durasi</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($services as $service)
                    <tr>
                        <td>{{ $service->nama_layanan }}</td>
                        <td>Rp{{ number_format($service->harga_estimasi_biaya, 0, ',', '.') }}</td>
                        <td>{{ $service->durasi_layanan }} menit</td>
                        <td>{{ $service->status_layanan === 'aktif' ? 'Aktif' : 'Nonaktif' }}</td>
                        <td>
                            <a href="{{ route('doctor.layanan.edit', $service) }}">Edit</a>
                            <form action="{{ route('doctor.layanan.destroy', $service) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" style="border:none;background:none;color:#a62323;cursor:pointer;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="muted">Belum ada layanan. Halaman publik juga akan kosong sampai dokter menambahkan layanan di sini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
