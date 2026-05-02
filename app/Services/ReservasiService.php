<?php

namespace App\Services;

use App\Enums\StatusReservasi;
use App\Models\Dokter;
use App\Models\JadwalPraktik;
use App\Models\JamOperasional;
use App\Models\Layanan;
use App\Models\Pasien;
use App\Models\PengaturanReservasi;
use App\Models\Reservasi;
use App\Models\ReservasiRelasi;
use App\Models\ReservasiReschedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ReservasiService
{
    public function getBookingContext(): array
    {
        $dokter = Dokter::query()->firstOrFail();
        $klinik = $dokter->klinik()->firstOrFail();
        $pengaturan = $klinik->pengaturanReservasi()->firstOrFail();

        return [$dokter, $pengaturan];
    }

    public function getAvailableSlots(int $idLayanan, string $tanggal): array
    {
        [$dokter, $pengaturan] = $this->getBookingContext();

        $layanan = Layanan::query()
            ->where('id_layanan', $idLayanan)
            ->where('status_layanan', 'aktif')
            ->firstOrFail();

        $date = Carbon::parse($tanggal)->startOfDay();

        $this->validasiBatasBooking($date, $pengaturan);
        $idKlinik = $dokter->id_klinik;
        $jamOperasional = $this->getJamOperasional($idKlinik, $date);
        $this->validasiKuotaHarian($date, $pengaturan);

        $buka = Carbon::createFromFormat('Y-m-d H:i:s', $date->toDateString().' '.$jamOperasional->jam_buka);
        $tutup = Carbon::createFromFormat('Y-m-d H:i:s', $date->toDateString().' '.$jamOperasional->jam_tutup);
        $interval = max(5, (int) $pengaturan->interval_slot_per_jam);
        $slots = [];

        for ($slot = $buka->copy(); $slot->lt($tutup); $slot->addMinutes($interval)) {
            $selesai = $slot->copy()->addMinutes($layanan->durasi_layanan);

            if ($selesai->gt($tutup)) {
                continue;
            }

            $isLewat = $this->slotSudahLewat($date, $slot);
            $isTersedia = ! $isLewat && $this->slotTersedia($dokter->id_dokter, $idKlinik, $date, $slot, $selesai);

            if (! $isTersedia && ! $isLewat) {
                continue;
            }

            $slots[] = [
                'value' => $slot->format('H:i'),
                'label' => $slot->format('H:i').' - '.$selesai->format('H:i').($isLewat ? ' (Lewat)' : ''),
                'disabled' => $isLewat,
            ];
        }

        return $slots;
    }

    public function buatReservasi(Pasien $pasien, array $payload): Reservasi
    {
        [$dokter, $pengaturan] = $this->getBookingContext();
        $layanan = Layanan::query()
            ->where('id_layanan', $payload['id_layanan'])
            ->where('status_layanan', 'aktif')
            ->firstOrFail();

        $tanggal = Carbon::parse($payload['tanggal_reservasi']);
        $jamKunjungan = Carbon::createFromFormat('Y-m-d H:i', $tanggal->format('Y-m-d').' '.$payload['jam_kunjungan']);
        $jamSelesai = (clone $jamKunjungan)->addMinutes($layanan->durasi_layanan);

        $this->validasiBatasBooking($tanggal, $pengaturan);
        $this->validasiJamBelumLewat($tanggal, $jamKunjungan);
        $idKlinik = $dokter->id_klinik;
        $this->validasiJamOperasional($idKlinik, $tanggal, $jamKunjungan, $jamSelesai);
        $this->validasiKuotaHarian($tanggal, $pengaturan);
        $this->validasiIntervalSlot($jamKunjungan, (int) $pengaturan->interval_slot_per_jam);
        $this->validasiSlotPilihan($layanan->id_layanan, $tanggal->toDateString(), $jamKunjungan->format('H:i'));

        $jadwal = JadwalPraktik::query()->firstOrCreate(
            [
                'tanggal' => $tanggal->toDateString(),
                'jam_praktik' => $jamKunjungan->format('H:i:s'),
            ],
            [
                'status_slot' => 'kosong',
            ]
        );

        if ($jadwal->status_slot !== 'kosong') {
            throw ValidationException::withMessages([
                'jam_kunjungan' => 'Slot sudah terisi atau diblok.',
            ]);
        }

        $this->validasiBentrok($dokter->id_dokter, $tanggal->toDateString(), $jamKunjungan->format('H:i:s'), $jamSelesai->format('H:i:s'));

        return DB::transaction(function () use ($pasien, $dokter, $layanan, $jadwal, $tanggal, $jamKunjungan, $payload) {
            $reservasi = Reservasi::query()->create([
                // Temporary unique code to avoid race conditions before the record has an ID.
                'kode_reservasi' => 'TMP-'.Str::upper(Str::random(20)),
                'tanggal_reservasi' => $tanggal->toDateString(),
                'jam_kunjungan' => $jamKunjungan->format('H:i:s'),
                'keluhan_pasien' => $payload['keluhan_pasien'],
                'metode_pembayaran' => strtoupper($payload['metode_pembayaran']) === 'QRIS' ? 'QRIS' : 'Cash',
                'status_reservasi' => StatusReservasi::Menunggu,
            ]);

            ReservasiRelasi::query()->create([
                'id_reservasi' => $reservasi->id_reservasi,
                'id_pasien' => $pasien->id_pasien,
                'id_dokter' => $dokter->id_dokter,
                'id_layanan' => $layanan->id_layanan,
                'id_jadwal' => $jadwal->id_jadwal,
            ]);

            $reservasi->update([
                'kode_reservasi' => $this->generateKodeReservasi($tanggal, $reservasi->id_reservasi),
            ]);

            $jadwal->update([
                'status_slot' => 'terisi',
            ]);

            return $reservasi;
        });
    }

    public function konfirmasiUsulanReschedule(Reservasi $reservasi): void
    {
        $reservasi->loadMissing(['relasi.dokter.klinik', 'relasi.layanan', 'relasi.jadwalPraktik', 'reschedule']);

        if ($reservasi->status_reservasi !== StatusReservasi::MenungguKonfirmasiPasien || ! $reservasi->usulan_tanggal_reschedule || ! $reservasi->usulan_jam_reschedule) {
            throw ValidationException::withMessages([
                'reservasi' => 'Tidak ada usulan jadwal baru yang perlu dikonfirmasi.',
            ]);
        }

        $pengaturan = $reservasi->dokter->klinik()->firstOrFail()->pengaturanReservasi()->firstOrFail();

        $tanggalUsulan = $reservasi->usulan_tanggal_reschedule->copy()->startOfDay();
        $jamUsulan = Carbon::parse($reservasi->usulan_jam_reschedule)->format('H:i:s');
        $jamKunjungan = Carbon::createFromFormat('Y-m-d H:i:s', $tanggalUsulan->toDateString().' '.$jamUsulan);
        $jamSelesai = $jamKunjungan->copy()->addMinutes($reservasi->layanan->durasi_layanan);

        $this->validasiBatasBooking($tanggalUsulan, $pengaturan);
        $this->validasiJamBelumLewat($tanggalUsulan, $jamKunjungan);
        $idKlinik = $reservasi->dokter->id_klinik;
        $this->validasiJamOperasional($idKlinik, $tanggalUsulan, $jamKunjungan, $jamSelesai);
        $this->validasiBentrok(
            $reservasi->id_dokter,
            $tanggalUsulan->toDateString(),
            $jamKunjungan->format('H:i:s'),
            $jamSelesai->format('H:i:s'),
            $reservasi->id_reservasi
        );

        $jadwalBaru = JadwalPraktik::query()->firstOrCreate(
            [
                'tanggal' => $tanggalUsulan->toDateString(),
                'jam_praktik' => $jamKunjungan->format('H:i:s'),
            ],
            [
                'status_slot' => 'kosong',
            ]
        );

        if ($jadwalBaru->status_slot !== 'kosong' && $jadwalBaru->id_jadwal !== $reservasi->id_jadwal) {
            throw ValidationException::withMessages([
                'reservasi' => 'Usulan jadwal baru sudah tidak tersedia.',
            ]);
        }

        DB::transaction(function () use ($reservasi, $tanggalUsulan, $jamKunjungan, $jadwalBaru) {
            $jadwalLama = $reservasi->jadwalPraktik;

            $reservasi->update([
                'tanggal_reservasi' => $tanggalUsulan->toDateString(),
                'jam_kunjungan' => $jamKunjungan->format('H:i:s'),
                'status_reservasi' => StatusReservasi::Terjadwal,
            ]);

            $reservasi->relasi?->update(['id_jadwal' => $jadwalBaru->id_jadwal]);
            $reservasi->reschedule?->delete();

            $jadwalBaru->update([
                'status_slot' => 'terisi',
            ]);

            if ($jadwalLama && $jadwalLama->id_jadwal !== $jadwalBaru->id_jadwal) {
                $jadwalLama->update([
                    'status_slot' => 'kosong',
                ]);
            }
        });
    }

    public function validasiUsulanReschedule(Reservasi $reservasi, string $tanggal, string $jam): void
    {
        $reservasi->loadMissing(['relasi.dokter.klinik', 'relasi.layanan']);

        $pengaturan = $reservasi->dokter->klinik()->firstOrFail()->pengaturanReservasi()->firstOrFail();

        $tanggalUsulan = Carbon::parse($tanggal)->startOfDay();
        $jamKunjungan = Carbon::createFromFormat('Y-m-d H:i', $tanggalUsulan->toDateString().' '.$jam);
        $jamSelesai = $jamKunjungan->copy()->addMinutes($reservasi->layanan->durasi_layanan);

        $this->validasiBatasBooking($tanggalUsulan, $pengaturan);
        $this->validasiJamBelumLewat($tanggalUsulan, $jamKunjungan);
        $this->validasiJamOperasional($reservasi->dokter->id_klinik, $tanggalUsulan, $jamKunjungan, $jamSelesai);
        $this->validasiKuotaHarian($tanggalUsulan, $pengaturan);
        $this->validasiBentrok(
            $reservasi->id_dokter,
            $tanggalUsulan->toDateString(),
            $jamKunjungan->format('H:i:s'),
            $jamSelesai->format('H:i:s'),
            $reservasi->id_reservasi
        );
    }

    public function validasiBentrok(int $idDokter, string $tanggal, string $jamMulai, string $jamSelesai, ?int $abaikanReservasi = null): void
    {
        $bentrok = Reservasi::query()
            ->join('reservasi_relasi', 'reservasi_relasi.id_reservasi', '=', 'reservasi.id_reservasi')
            ->join('layanan', 'layanan.id_layanan', '=', 'reservasi_relasi.id_layanan')
            ->where('reservasi_relasi.id_dokter', $idDokter)
            ->whereDate('reservasi.tanggal_reservasi', $tanggal)
            ->whereIn('reservasi.status_reservasi', StatusReservasi::aktif())
            ->when($abaikanReservasi, fn ($query) => $query->where('reservasi.id_reservasi', '!=', $abaikanReservasi))
            ->get()
            ->contains(function ($reservasi) use ($tanggal, $jamMulai, $jamSelesai) {
                $mulaiExisting = Carbon::createFromFormat('Y-m-d H:i:s', $tanggal.' '.$reservasi->jam_kunjungan);
                $selesaiExisting = (clone $mulaiExisting)->addMinutes($reservasi->durasi_layanan);
                $mulaiBaru = Carbon::createFromFormat('Y-m-d H:i:s', $tanggal.' '.$jamMulai);
                $selesaiBaru = Carbon::createFromFormat('Y-m-d H:i:s', $tanggal.' '.$jamSelesai);

                return $mulaiExisting < $selesaiBaru && $selesaiExisting > $mulaiBaru;
            });

        if ($bentrok) {
            throw ValidationException::withMessages([
                'jam_kunjungan' => 'Jadwal bentrok dengan reservasi lain.',
            ]);
        }
    }

    protected function validasiIntervalSlot(Carbon $jamMulai, int $interval): void
    {
        $interval = max(5, $interval);

        if (((int) $jamMulai->format('i')) % $interval !== 0) {
            throw ValidationException::withMessages([
                'jam_kunjungan' => 'Jam kunjungan tidak sesuai interval slot yang diatur dokter.',
            ]);
        }
    }

    protected function validasiSlotPilihan(int $idLayanan, string $tanggal, string $jam): void
    {
        $tersedia = collect($this->getAvailableSlots($idLayanan, $tanggal))
            ->contains(fn (array $slot) => $slot['value'] === $jam && empty($slot['disabled']));

        if (! $tersedia) {
            throw ValidationException::withMessages([
                'jam_kunjungan' => 'Slot yang dipilih sudah tidak tersedia.',
            ]);
        }
    }

    protected function validasiBatasBooking(Carbon $tanggal, PengaturanReservasi $pengaturan): void
    {
        $maksimal = now()->startOfDay()->addDays($pengaturan->hari_booking_ke_depan);

        if ($tanggal->lt(now()->startOfDay()) || $tanggal->gt($maksimal)) {
            throw ValidationException::withMessages([
                'tanggal_reservasi' => 'Tanggal booking di luar rentang yang diizinkan.',
            ]);
        }
    }

    protected function validasiJamOperasional(int $idKlinik, Carbon $tanggal, Carbon $jamMulai, Carbon $jamSelesai): void
    {
        $jamOperasional = $this->getJamOperasional($idKlinik, $tanggal);

        $buka = Carbon::createFromFormat('Y-m-d H:i:s', $tanggal->toDateString().' '.$jamOperasional->jam_buka);
        $tutup = Carbon::createFromFormat('Y-m-d H:i:s', $tanggal->toDateString().' '.$jamOperasional->jam_tutup);

        if ($jamMulai->lt($buka) || $jamSelesai->gt($tutup)) {
            throw ValidationException::withMessages([
                'jam_kunjungan' => 'Jam kunjungan di luar jam operasional.',
            ]);
        }
    }

    protected function validasiJamBelumLewat(Carbon $tanggal, Carbon $jamMulai): void
    {
        if ($this->slotSudahLewat($tanggal, $jamMulai)) {
            throw ValidationException::withMessages([
                'jam_kunjungan' => 'Jam kunjungan yang sudah lewat tidak bisa dipilih.',
            ]);
        }
    }

    protected function validasiKuotaHarian(Carbon $tanggal, PengaturanReservasi $pengaturan): void
    {
        $jumlah = Reservasi::query()
            ->whereDate('tanggal_reservasi', $tanggal->toDateString())
            ->whereIn('status_reservasi', StatusReservasi::aktif())
            ->count();

        if ($jumlah >= $pengaturan->batas_maksimal_booking_per_hari) {
            throw ValidationException::withMessages([
                'tanggal_reservasi' => 'Kuota booking harian sudah penuh.',
            ]);
        }
    }

    protected function generateKodeReservasi(Carbon $tanggal, int $idReservasi): string
    {
        return sprintf('RSV-%s-%06d', $tanggal->format('Ymd'), $idReservasi);
    }

    protected function getJamOperasional(int $idKlinik, Carbon $tanggal): JamOperasional
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

        $jamOperasional = JamOperasional::query()
            ->whereHas('klinik', fn ($query) => $query->where('klinik.id_klinik', $idKlinik))
            ->whereRaw('LOWER(hari_buka) = ?', [$mapHari[$tanggal->dayOfWeek]])
            ->first();

        if (! $jamOperasional || $jamOperasional->hari_libur || ! $jamOperasional->jam_buka || ! $jamOperasional->jam_tutup) {
            throw ValidationException::withMessages([
                'tanggal_reservasi' => 'Klinik libur pada hari tersebut.',
            ]);
        }

        return $jamOperasional;
    }

    protected function slotTersedia(int $idDokter, int $idKlinik, Carbon $tanggal, Carbon $jamMulai, Carbon $jamSelesai): bool
    {
        $jadwal = JadwalPraktik::query()
            ->whereDate('tanggal', $tanggal->toDateString())
            ->where('jam_praktik', $jamMulai->format('H:i:s'))
            ->first();

        if ($jadwal && $jadwal->status_slot !== 'kosong') {
            return false;
        }

        try {
            $this->validasiJamOperasional($idKlinik, $tanggal, $jamMulai, $jamSelesai);
            $this->validasiBentrok($idDokter, $tanggal->toDateString(), $jamMulai->format('H:i:s'), $jamSelesai->format('H:i:s'));
        } catch (ValidationException) {
            return false;
        }

        return true;
    }

    protected function slotSudahLewat(Carbon $tanggal, Carbon $jamMulai): bool
    {
        return $tanggal->isToday() && $jamMulai->lte(now());
    }
}
