<?php

namespace App\Http\Controllers\Dokter;

use App\Enums\StatusReservasi;
use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\JamOperasional;
use App\Models\JadwalPraktik;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalController extends Controller
{
    public function index(Request $request): View
    {
        $dokter = Dokter::query()->firstOrFail();
        $klinik = $dokter->klinik()->firstOrFail();
        $tanggal = Carbon::parse($request->string('tanggal')->toString() ?: now()->toDateString())->startOfDay();
        $pengaturan = $klinik->pengaturanReservasi()->first();
        $interval = max(5, (int) ($pengaturan?->interval_slot_per_jam ?? 30));

        $jamOperasional = $this->getJamOperasional($klinik->id_klinik, $tanggal);
        $reservasiByJadwal = Reservasi::query()
            ->with(['relasi.pasien', 'relasi.layanan', 'relasi.jadwalPraktik'])
            ->whereHas('relasi', fn ($query) => $query->where('id_dokter', $dokter->id_dokter))
            ->whereDate('tanggal_reservasi', $tanggal->toDateString())
            ->orderByDesc('id_reservasi')
            ->get()
            ->sortByDesc(fn (Reservasi $reservasi) => in_array($reservasi->status_reservasi->value, StatusReservasi::aktif(), true) ? 1 : 0)
            ->unique('id_jadwal')
            ->keyBy('id_jadwal');

        $jadwalList = JadwalPraktik::query()
            ->whereDate('tanggal', $tanggal->toDateString())
            ->get()
            ->keyBy(fn (JadwalPraktik $jadwal) => substr($jadwal->jam_praktik, 0, 5));

        $slots = [];
        $isLibur = ! $jamOperasional || $jamOperasional->hari_libur || ! $jamOperasional->jam_buka || ! $jamOperasional->jam_tutup;

        if (! $isLibur) {
            $buka = Carbon::createFromFormat('Y-m-d H:i:s', $tanggal->toDateString().' '.$jamOperasional->jam_buka);
            $tutup = Carbon::createFromFormat('Y-m-d H:i:s', $tanggal->toDateString().' '.$jamOperasional->jam_tutup);

            for ($slot = $buka->copy(); $slot->lt($tutup); $slot->addMinutes($interval)) {
                $jam = $slot->format('H:i');
                $jadwal = $jadwalList->get($jam);
                $reservasi = $jadwal ? $reservasiByJadwal->get($jadwal->id_jadwal) : null;

                $slots[] = [
                    'jam' => $jam,
                    'status_slot' => $jadwal?->status_slot ?? 'kosong',
                    'jadwal' => $jadwal,
                    'reservasi' => $reservasi,
                ];
            }
        }

        return view('dokter.jadwal.index', [
            'dokter' => $dokter,
            'tanggal' => $tanggal,
            'interval' => $interval,
            'jamOperasional' => $jamOperasional,
            'isLibur' => $isLibur,
            'slots' => $slots,
        ]);
    }

    protected function getJamOperasional(int $idKlinik, Carbon $tanggal): ?JamOperasional
    {
        $mapHari = [
            0 => 'minggu',
            1 => 'senin',
            2 => 'selasa',
            3 => 'rabu',
            4 => 'kamis',
            5 => 'jumat',
            6 => 'sabtu',
        ];

        return JamOperasional::query()
            ->whereHas('klinik', fn ($query) => $query->where('klinik.id_klinik', $idKlinik))
            ->whereRaw('LOWER(hari_buka) = ?', [$mapHari[$tanggal->dayOfWeek]])
            ->first();
    }
}
