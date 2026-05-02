@extends('layouts.pasien', ['title' => 'Reservasi Saya'])

@section('pasien_content')
    @php
        $pendingRescheduleCount = $reservasi->where('status_reservasi', \App\Enums\StatusReservasi::MenungguKonfirmasiPasien)->count();
    @endphp

    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h1>Reservasi Saya</h1>
        @if(session('status')) <div class="flash">{{ session('status') }}</div> @endif
        @if($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif
        @if($pendingRescheduleCount > 0)
            <div style="margin:16px 0;padding:12px 14px;border:1px solid #fcd34d;border-radius:12px;background:#fffbeb;color:#92400e;">
                Ada {{ $pendingRescheduleCount }} usulan jadwal terbaru dari dokter. Silakan cek dan konfirmasi di daftar reservasi.
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Layanan</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservasi as $item)
                    <tr>
                        <td>{{ $item->kode_reservasi }}</td>
                        <td>{{ $item->tanggal_reservasi->format('Y-m-d') }}</td>
                        <td>{{ substr($item->jam_kunjungan, 0, 5) }}</td>
                        <td>{{ $item->layanan->nama_layanan }}</td>
                        <td>{{ $item->metode_pembayaran ?: '-' }}</td>
                        <td>{{ \Illuminate\Support\Str::headline($item->status_reservasi->value) }}</td>
                        <td>
                            @if($item->status_reservasi->value === 'menunggu_konfirmasi_pasien' && $item->usulan_tanggal_reschedule && $item->usulan_jam_reschedule)
                                <div style="margin-bottom:8px;font-size:13px;color:#334155;">
                                    Jadwal baru dari dokter:
                                    {{ $item->usulan_tanggal_reschedule->format('Y-m-d') }}
                                    {{ substr($item->usulan_jam_reschedule, 0, 5) }}
                                </div>
                                <form method="POST" action="{{ route('pasien.reservasi.konfirmasi-reschedule', $item) }}" style="margin-bottom:8px;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" style="border:none;background:#0f766e;color:#fff;padding:8px 12px;border-radius:8px;cursor:pointer;">Konfirmasi Jadwal Baru</button>
                                </form>
                            @endif

                            @if(in_array($item->status_reservasi->value, ['menunggu', 'terjadwal', 'menunggu_konfirmasi_pasien'], true))
                                <form method="POST" action="{{ route('pasien.reservasi.batalkan', $item) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" style="border:none;background:none;color:#a62323;cursor:pointer;">Batalkan</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7">Belum ada reservasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
