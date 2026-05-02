@extends('layouts.doctor', ['title' => 'Kelola Reservasi'])

@section('doctor_content')
    @php
        $pendingReservationCount = $reservasi->where('status_reservasi', \App\Enums\StatusReservasi::Menunggu)->count();
    @endphp

    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h1>Kelola Reservasi Dokter</h1>
        @if(session('status')) <div class="flash">{{ session('status') }}</div> @endif
        @if($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif
        @if($pendingReservationCount > 0)
            <div style="margin:16px 0;padding:12px 14px;border:1px solid #fcd34d;border-radius:12px;background:#fffbeb;color:#92400e;">
                Ada {{ $pendingReservationCount }} reservasi baru dari pasien yang menunggu konfirmasi dokter.
            </div>
        @endif
        <form method="GET" action="{{ route('dokter.reservasi.index') }}" style="margin:16px 0;display:flex;gap:12px;align-items:end;flex-wrap:wrap;">
            <div>
                <label for="status" style="display:block;margin-bottom:6px;font-size:13px;color:#475569;">Filter status</label>
                <select id="status" name="status" style="min-width:220px;">
                    <option value="">Semua status</option>
                    @foreach (['menunggu', 'terjadwal', 'menunggu_konfirmasi_pasien', 'ditolak', 'dibatalkan', 'selesai'] as $statusOption)
                        <option value="{{ $statusOption }}" @selected(request('status') === $statusOption)>{{ \Illuminate\Support\Str::headline($statusOption) }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-secondary" type="submit">Terapkan</button>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Pasien</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Layanan</th>
                    <th>Keluhan</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservasi as $item)
                    @php
                        $statusValue = $item->status_reservasi->value;
                        $statusLabel = \Illuminate\Support\Str::headline($statusValue);
                        $statusClass = match ($statusValue) {
                            'dibatalkan', 'ditolak' => 'background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;',
                            'selesai' => 'background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;',
                            'terjadwal' => 'background:#ecfeff;color:#0f766e;border:1px solid #99f6e4;',
                            'menunggu_konfirmasi_pasien' => 'background:#fffbeb;color:#92400e;border:1px solid #fcd34d;',
                            default => 'background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;',
                        };
                    @endphp
                    <tr>
                        <td>{{ $item->kode_reservasi }}</td>
                        <td>{{ $item->pasien->nama_pasien }}</td>
                        <td>{{ $item->tanggal_reservasi->format('Y-m-d') }}</td>
                        <td>{{ substr($item->jam_kunjungan, 0, 5) }}</td>
                        <td>{{ $item->layanan->nama_layanan }}</td>
                        <td style="max-width:220px;">{{ \Illuminate\Support\Str::limit($item->keluhan_pasien, 80) }}</td>
                        <td>{{ $item->metode_pembayaran ?: '-' }}</td>
                        <td>
                            <span style="display:inline-flex;align-items:center;border-radius:9999px;padding:4px 10px;font-size:12px;font-weight:600;{{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td>
                            @if($statusValue === 'menunggu')
                                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                    <form method="POST" action="{{ route('dokter.reservasi.konfirmasi', $item) }}">@csrf @method('PATCH')<button class="btn" type="submit">Konfirmasi</button></form>
                                    <form method="POST" action="{{ route('dokter.reservasi.tolak', $item) }}">@csrf @method('PATCH')<button class="btn btn-secondary" type="submit">Tolak</button></form>
                                    <form method="POST" action="{{ route('dokter.reservasi.batalkan', $item) }}">@csrf @method('PATCH')<button class="btn btn-secondary" type="submit">Batalkan</button></form>
                                </div>
                            @elseif($statusValue === 'terjadwal')
                                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                    <form method="POST" action="{{ route('dokter.reservasi.selesai', $item) }}">@csrf @method('PATCH')<button class="btn btn-secondary" type="submit">Selesai</button></form>
                                    <form method="POST" action="{{ route('dokter.reservasi.batalkan', $item) }}">@csrf @method('PATCH')<button class="btn btn-secondary" type="submit">Batalkan</button></form>
                                </div>
                                <form method="POST" action="{{ route('dokter.reservasi.reschedule', $item) }}" style="margin-top:8px;">
                                    @csrf
                                    @method('PATCH')
                                    <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                        <input type="date" name="usulan_tanggal_reschedule">
                                        <input type="time" name="usulan_jam_reschedule">
                                        <button class="btn btn-secondary" type="submit">Ajukan Reschedule</button>
                                    </div>
                                </form>
                            @elseif($statusValue === 'menunggu_konfirmasi_pasien')
                                <div style="font-size:13px;color:#334155;">
                                    Menunggu konfirmasi pasien untuk jadwal baru
                                    @if($item->usulan_tanggal_reschedule && $item->usulan_jam_reschedule)
                                        : {{ $item->usulan_tanggal_reschedule->format('Y-m-d') }} {{ substr($item->usulan_jam_reschedule, 0, 5) }}
                                    @endif
                                </div>
                                <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:8px;">
                                    <form method="POST" action="{{ route('dokter.reservasi.tolak', $item) }}">@csrf @method('PATCH')<button class="btn btn-secondary" type="submit">Tolak</button></form>
                                    <form method="POST" action="{{ route('dokter.reservasi.batalkan', $item) }}">@csrf @method('PATCH')<button class="btn btn-secondary" type="submit">Batalkan</button></form>
                                </div>
                            @else
                                <span style="font-size:13px;color:#64748b;">Tidak ada aksi.</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9">Belum ada reservasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
