<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\ServiceRequest;
use App\Models\Layanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('doctor.services.index', [
            'services' => Layanan::query()->orderBy('nama_layanan')->get(),
        ]);
    }

    public function create(): View
    {
        return view('doctor.services.create', [
            'service' => new Layanan(),
        ]);
    }

    public function store(ServiceRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['status_layanan'] = $request->boolean('is_active') ? 'aktif' : 'nonaktif';
        unset($data['is_active']);

        Layanan::query()->create($data);

        return redirect()->route('doctor.layanan.index')->with('status', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Layanan $layanan): View
    {
        return view('doctor.services.edit', ['service' => $layanan]);
    }

    public function update(ServiceRequest $request, Layanan $layanan): RedirectResponse
    {
        $data = $request->validated();
        $data['status_layanan'] = $request->boolean('is_active') ? 'aktif' : 'nonaktif';
        unset($data['is_active']);

        $layanan->update($data);

        return redirect()->route('doctor.layanan.index')->with('status', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Layanan $layanan): RedirectResponse
    {
        $layanan->delete();

        return redirect()->route('doctor.layanan.index')->with('status', 'Layanan berhasil dihapus.');
    }
}
