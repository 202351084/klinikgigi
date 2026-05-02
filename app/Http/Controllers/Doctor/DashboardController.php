<?php

namespace App\Http\Controllers\Doctor;

use App\Enums\StatusReservasi;
use App\Http\Controllers\Controller;
use App\Models\BannerPromo;
use App\Models\Layanan;
use App\Models\Pasien;
use App\Models\Reservasi;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('doctor.dashboard', [
            'serviceCount' => Layanan::query()->count(),
            'activeServiceCount' => Layanan::query()->where('status_layanan', 'aktif')->count(),
            'bannerCount' => BannerPromo::query()->count(),
            'patientCount' => Pasien::query()->count(),
            'reservationCount' => Reservasi::query()->count(),
            'pendingReservationCount' => Reservasi::query()->where('status_reservasi', StatusReservasi::Menunggu->value)->count(),
            'scheduledReservationCount' => Reservasi::query()->where('status_reservasi', StatusReservasi::Terjadwal->value)->count(),
            'completedReservationCount' => Reservasi::query()->where('status_reservasi', StatusReservasi::Selesai->value)->count(),
        ]);
    }
}
