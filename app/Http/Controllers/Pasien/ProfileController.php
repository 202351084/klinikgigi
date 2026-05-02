<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pasien\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('pasien.profile.edit', [
            'user' => $request->user(),
            'pasien' => $request->user()->pasien,
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $pasien = $user->pasien;
        $data = $request->validated();

        DB::transaction(function () use ($user, $pasien, $data) {
            $user->update([
                'name' => $data['nama_pasien'],
                'phone' => $data['nomor_hp'] ?? null,
                'address' => $data['alamat'] ?? null,
                'password' => !empty($data['password']) ? Hash::make($data['password']) : $user->password,
            ]);

            $pasien->update([
                'nama_pasien' => $data['nama_pasien'],
                'nomor_hp' => $data['nomor_hp'] ?? null,
                'alamat' => $data['alamat'] ?? null,
            ]);
        });

        return redirect()->route('pasien.profile.edit')->with('status', 'Profil pasien berhasil diperbarui.');
    }
}
