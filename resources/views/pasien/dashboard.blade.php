@extends('layouts.pasien', ['title' => 'Dashboard Pasien'])

@section('pasien_content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Dashboard Pasien</h1>
            <p class="mt-1 text-sm text-slate-500">Ringkasan profil dan aktivitas reservasi Anda.</p>
        </div>

        <section class="grid gap-5 md:grid-cols-4">
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Nama Pasien</div>
                <div class="mt-2 text-lg font-semibold text-slate-800">{{ $pasien->nama_pasien }}</div>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Total Reservasi</div>
                <div class="mt-2 text-3xl font-semibold text-slate-800">{{ $reservationCount }}</div>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Menunggu</div>
                <div class="mt-2 text-3xl font-semibold text-amber-600">{{ $pendingCount }}</div>
            </article>
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Terjadwal</div>
                <div class="mt-2 text-3xl font-semibold text-teal-700">{{ $scheduledCount }}</div>
            </article>
        </section>

        <section class="grid gap-6 lg:grid-cols-[1fr_0.9fr]">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <h2 class="text-lg font-semibold text-slate-800">Reservasi Terbaru</h2>
                    <a href="{{ route('pasien.reservasi.create') }}" class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-medium text-white hover:bg-teal-800">Booking Baru</a>
                </div>

                @if($latestReservation)
                    <div class="mt-5 rounded-xl border border-slate-200 bg-slate-50 p-5">
                        <div class="text-sm text-slate-500">Status terbaru</div>
                        <div class="mt-2 text-xl font-semibold text-slate-800">{{ $latestReservation->status_reservasi->value }}</div>
                        <div class="mt-3 text-sm text-slate-600">{{ $latestReservation->kode_reservasi }} • {{ $latestReservation->tanggal_reservasi->format('d M Y') }} • {{ substr($latestReservation->jam_kunjungan, 0, 5) }}</div>
                        <div class="mt-1 text-sm text-slate-600">{{ $latestReservation->layanan?->nama_layanan }}</div>
                    </div>
                @else
                    <div class="mt-5 rounded-xl border border-dashed border-slate-300 bg-slate-50 p-5 text-sm text-slate-500">
                        Belum ada reservasi. Buat booking pertama Anda dari menu booking reservasi.
                    </div>
                @endif
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-800">Profil Singkat</h2>
                <div class="mt-4 space-y-3 text-sm text-slate-600">
                    <div><strong class="text-slate-800">Email:</strong> {{ auth()->user()->email }}</div>
                    <div><strong class="text-slate-800">Nomor HP:</strong> {{ $pasien->nomor_hp ?: '-' }}</div>
                    <div><strong class="text-slate-800">Alamat:</strong> {{ $pasien->alamat ?: '-' }}</div>
                </div>
                <a href="{{ route('pasien.profile.edit') }}" class="mt-5 inline-flex rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Edit Profil</a>
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-lg font-semibold text-slate-800">Daftar Reservasi Terbaru</h2>
                <a href="{{ route('pasien.reservasi.index') }}" class="text-sm font-medium text-teal-700 hover:underline">Lihat semua</a>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Layanan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentReservations as $item)
                            <tr>
                                <td>{{ $item->kode_reservasi }}</td>
                                <td>{{ $item->tanggal_reservasi->format('d M Y') }} • {{ substr($item->jam_kunjungan, 0, 5) }}</td>
                                <td>{{ $item->layanan?->nama_layanan }}</td>
                                <td>{{ $item->status_reservasi->value }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4">Belum ada reservasi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
