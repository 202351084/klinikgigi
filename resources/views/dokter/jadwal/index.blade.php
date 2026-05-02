@extends('layouts.doctor', ['title' => 'Kalender Jadwal'])

@section('doctor_content')
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h1>Kalender Jadwal</h1>
                <p class="mt-2 text-sm text-slate-500">Lihat slot praktik dokter per hari, termasuk slot kosong dan slot yang sudah terisi pasien.</p>
            </div>

            <form method="GET" action="{{ route('dokter.jadwal.index') }}" class="flex flex-wrap items-end gap-3">
                <div>
                    <label for="tanggal" class="mb-1 block text-sm text-slate-600">Tanggal</label>
                    <input id="tanggal" type="date" name="tanggal" value="{{ $tanggal->toDateString() }}">
                </div>
                <button class="btn btn-secondary" type="submit">Tampilkan</button>
            </form>
        </div>

        <div class="mt-5 grid gap-4 md:grid-cols-3">
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <div class="text-xs uppercase tracking-[0.2em] text-slate-500">Dokter</div>
                <div class="mt-2 font-semibold text-slate-800">{{ $dokter->nama_dokter }}</div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <div class="text-xs uppercase tracking-[0.2em] text-slate-500">Jam Operasional</div>
                <div class="mt-2 font-semibold text-slate-800">
                    @if($isLibur)
                        Libur / tidak tersedia
                    @else
                        {{ substr($jamOperasional->jam_buka, 0, 5) }} - {{ substr($jamOperasional->jam_tutup, 0, 5) }}
                    @endif
                </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                <div class="text-xs uppercase tracking-[0.2em] text-slate-500">Interval Slot</div>
                <div class="mt-2 font-semibold text-slate-800">{{ $interval }} menit</div>
            </div>
        </div>

        @if($isLibur)
            <div class="mt-5 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                Tanggal ini berada di hari libur atau jam operasional belum diatur, jadi tidak ada slot praktik yang ditampilkan.
            </div>
        @else
            <div class="mt-5 overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Jam Praktik</th>
                            <th>Status Slot</th>
                            <th>Pasien</th>
                            <th>Layanan</th>
                            <th>Status Reservasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($slots as $slot)
                            @php
                                $reservasi = $slot['reservasi'];
                                $statusSlot = $slot['status_slot'];
                                $slotClass = $statusSlot === 'terisi'
                                    ? 'background:#ecfeff;color:#0f766e;border:1px solid #99f6e4;'
                                    : 'background:#f8fafc;color:#475569;border:1px solid #cbd5e1;';
                            @endphp
                            <tr>
                                <td>{{ $slot['jam'] }}</td>
                                <td>
                                    <span style="display:inline-flex;align-items:center;border-radius:9999px;padding:4px 10px;font-size:12px;font-weight:600;{{ $slotClass }}">
                                        {{ \Illuminate\Support\Str::headline($statusSlot) }}
                                    </span>
                                </td>
                                <td>{{ $reservasi?->pasien?->nama_pasien ?: '-' }}</td>
                                <td>{{ $reservasi?->layanan?->nama_layanan ?: '-' }}</td>
                                <td>{{ $reservasi ? \Illuminate\Support\Str::headline($reservasi->status_reservasi->value) : '-' }}</td>
                                <td>
                                    @if($reservasi && $reservasi->status_reservasi->value === 'terjadwal')
                                        <a href="{{ route('dokter.reservasi.index', ['status' => 'terjadwal']) }}" class="text-sm font-medium text-teal-700 hover:text-teal-800">
                                            Pindahkan via Reschedule
                                        </a>
                                    @elseif($reservasi)
                                        <a href="{{ route('dokter.reservasi.index') }}" class="text-sm font-medium text-teal-700 hover:text-teal-800">
                                            Lihat Reservasi
                                        </a>
                                    @else
                                        <span class="text-sm text-slate-500">Slot kosong</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Belum ada slot jadwal untuk tanggal ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
