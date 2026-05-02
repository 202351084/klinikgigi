<?php

namespace App\Http\Controllers\Pasien;

use App\Enums\StatusReservasi;
use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $pasien = $request->user()->pasien;
        $reservasi = Reservasi::query()
            ->with(['relasi.layanan', 'relasi.jadwalPraktik'])
            ->whereHas('relasi', fn ($query) => $query->where('id_pasien', $pasien->id_pasien))
            ->latest('tanggal_reservasi')
            ->latest('jam_kunjungan')
            ->get();

        return view('pasien.dashboard', [
            'pasien' => $pasien,
            'reservationCount' => $reservasi->count(),
            'pendingCount' => $reservasi->where('status_reservasi', StatusReservasi::Menunggu)->count(),
            'scheduledCount' => $reservasi->where('status_reservasi', StatusReservasi::Terjadwal)->count(),
            'latestReservation' => $reservasi->first(),
            'recentReservations' => $reservasi->take(5),
        ]);
    }
}
