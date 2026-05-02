<?php

namespace App\Http\Controllers\Pasien;

use App\Enums\StatusReservasi;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pasien\StoreReservasiRequest;
use App\Models\Layanan;
use App\Models\Reservasi;
use App\Services\ReservasiService;
use Illuminate\Http\JsonResponse;
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

    public function create(Request $request): View
    {
        [$dokter, $pengaturan] = $this->reservasiService->getBookingContext();
        $today = now()->toDateString();
        $maxDate = now()->addDays($pengaturan->hari_booking_ke_depan)->toDateString();

        return view('pasien.reservasi.create', [
            'layananList' => Layanan::query()->where('status_layanan', 'aktif')->orderBy('nama_layanan')->get(),
            'pasien' => $request->user()->pasien,
            'pengaturan' => $pengaturan,
            'dokter' => $dokter,
            'today' => $today,
            'maxDate' => $maxDate,
        ]);
    }

    public function availableSlots(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id_layanan' => ['required', 'integer', 'exists:layanan,id_layanan'],
            'tanggal_reservasi' => ['required', 'date'],
        ]);

        try {
            $slots = $this->reservasiService->getAvailableSlots(
                (int) $validated['id_layanan'],
                $validated['tanggal_reservasi']
            );

            return response()->json([
                'slots' => $slots,
                'message' => empty($slots) ? 'Tidak ada slot tersedia pada tanggal tersebut.' : null,
            ]);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json([
                'slots' => [],
                'message' => collect($exception->errors())->flatten()->first(),
            ], 422);
        }
    }

    public function store(StoreReservasiRequest $request): RedirectResponse
    {
        $this->reservasiService->buatReservasi($request->user()->pasien, $request->validated());

        return redirect()->route('pasien.reservasi.index')->with('status', 'Reservasi berhasil dibuat dengan status menunggu.');
    }

    public function index(Request $request): View
    {
        $reservasi = Reservasi::query()
            ->with(['relasi.layanan', 'relasi.jadwalPraktik', 'reschedule'])
            ->whereHas('relasi', fn ($query) => $query->where('id_pasien', $request->user()->pasien->id_pasien))
            ->latest('tanggal_reservasi')
            ->get();

        return view('pasien.reservasi.index', compact('reservasi'));
    }

    public function batalkan(Reservasi $reservasi, Request $request): RedirectResponse
    {
        abort_unless($reservasi->id_pasien === $request->user()->pasien->id_pasien, 403);

        if (! in_array($reservasi->status_reservasi->value, [StatusReservasi::Menunggu->value, StatusReservasi::Terjadwal->value, StatusReservasi::MenungguKonfirmasiPasien->value], true)) {
            return back()->withErrors(['reservasi' => 'Reservasi tidak dapat dibatalkan.']);
        }

        $reservasi->update([
            'status_reservasi' => StatusReservasi::Dibatalkan,
        ]);

        $reservasi->jadwalPraktik?->update(['status_slot' => 'kosong']);

        return back()->with('status', 'Reservasi dibatalkan.');
    }

    public function konfirmasiReschedule(Reservasi $reservasi, Request $request): RedirectResponse
    {
        abort_unless($reservasi->id_pasien === $request->user()->pasien->id_pasien, 403);

        try {
            $this->reservasiService->konfirmasiUsulanReschedule($reservasi);
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors());
        }

        return back()->with('status', 'Jadwal terbaru dari dokter berhasil dikonfirmasi.');
    }
}
