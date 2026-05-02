<?php

namespace App\Http\Controllers\Dokter;

use App\Enums\StatusReservasi;
use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\ReservasiReschedule;
use App\Services\ReservasiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ReservasiController extends Controller
{
    public function __construct(
        protected ReservasiService $reservasiService
    ) {
    }

    public function index(Request $request): View
    {
        $reservasi = Reservasi::query()
            ->with(['relasi.pasien', 'relasi.layanan', 'relasi.jadwalPraktik', 'reschedule'])
            ->when($request->filled('status'), fn ($query) => $query->where('status_reservasi', $request->string('status')->toString()))
            ->latest('tanggal_reservasi')
            ->get();

        return view('dokter.reservasi.index', compact('reservasi'));
    }

    public function konfirmasi(Reservasi $reservasi): RedirectResponse
    {
        if ($reservasi->status_reservasi !== StatusReservasi::Menunggu) {
            return back()->withErrors(['reservasi' => 'Hanya reservasi yang menunggu yang bisa dikonfirmasi.']);
        }

        $reservasi->update(['status_reservasi' => StatusReservasi::Terjadwal]);

        return back()->with('status', 'Reservasi dikonfirmasi.');
    }

    public function tolak(Reservasi $reservasi): RedirectResponse
    {
        if (! in_array($reservasi->status_reservasi, [StatusReservasi::Menunggu, StatusReservasi::MenungguKonfirmasiPasien], true)) {
            return back()->withErrors(['reservasi' => 'Reservasi ini tidak bisa ditolak.']);
        }

        $reservasi->update(['status_reservasi' => StatusReservasi::Ditolak]);
        $reservasi->jadwalPraktik?->update(['status_slot' => 'kosong']);

        return back()->with('status', 'Reservasi ditolak.');
    }

    public function selesai(Reservasi $reservasi): RedirectResponse
    {
        if ($reservasi->status_reservasi !== StatusReservasi::Terjadwal) {
            return back()->withErrors(['reservasi' => 'Hanya reservasi terjadwal yang bisa ditandai selesai.']);
        }

        $reservasi->update(['status_reservasi' => StatusReservasi::Selesai]);

        return back()->with('status', 'Reservasi ditandai selesai.');
    }

    public function batalkan(Reservasi $reservasi): RedirectResponse
    {
        if (! in_array($reservasi->status_reservasi, [StatusReservasi::Menunggu, StatusReservasi::Terjadwal, StatusReservasi::MenungguKonfirmasiPasien], true)) {
            return back()->withErrors(['reservasi' => 'Reservasi ini tidak bisa dibatalkan.']);
        }

        $reservasi->update([
            'status_reservasi' => StatusReservasi::Dibatalkan,
        ]);
        $reservasi->reschedule?->delete();

        $reservasi->jadwalPraktik?->update(['status_slot' => 'kosong']);

        return back()->with('status', 'Reservasi dibatalkan.');
    }

    public function ajukanReschedule(Reservasi $reservasi, Request $request): RedirectResponse
    {
        if ($reservasi->status_reservasi !== StatusReservasi::Terjadwal) {
            return back()->withErrors(['reservasi' => 'Hanya reservasi terjadwal yang bisa diajukan reschedule.']);
        }

        $data = $request->validate([
            'usulan_tanggal_reschedule' => ['required', 'date', 'after_or_equal:today'],
            'usulan_jam_reschedule' => ['required', 'date_format:H:i'],
        ]);

        try {
            $this->reservasiService->validasiUsulanReschedule(
                $reservasi,
                $data['usulan_tanggal_reschedule'],
                $data['usulan_jam_reschedule']
            );
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors());
        }

        $reservasi->update([
            'status_reservasi' => StatusReservasi::MenungguKonfirmasiPasien,
        ]);

        ReservasiReschedule::query()->updateOrCreate(
            ['id_reservasi' => $reservasi->id_reservasi],
            [
            'usulan_tanggal_reschedule' => $data['usulan_tanggal_reschedule'],
            'usulan_jam_reschedule' => $data['usulan_jam_reschedule'],
            ]
        );

        return back()->with('status', 'Usulan reschedule dikirim ke pasien.');
    }
}
