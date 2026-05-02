<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pasien\PatientLoginRequest;
use App\Http\Requests\Pasien\PatientRegisterRequest;
use App\Models\Pasien;
use App\Models\PasienUser;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function createLogin(): View
    {
        return view('pasien.auth.login');
    }

    public function storeLogin(PatientLoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (! Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'role' => 'patient',
            'is_active' => true,
        ], $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Login pasien tidak valid.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('pasien.reservasi.index');
    }

    public function createRegister(): View
    {
        return view('pasien.auth.register');
    }

    public function storeRegister(PatientRegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = DB::transaction(function () use ($data) {
            $user = User::query()->create([
                'name' => $data['nama_pasien'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => 'patient',
                'phone' => $data['nomor_hp'] ?? null,
                'address' => $data['alamat'] ?? null,
                'is_active' => true,
            ]);

            $pasien = Pasien::query()->create([
                'nama_pasien' => $data['nama_pasien'],
                'email' => $data['email'],
                'nomor_hp' => $data['nomor_hp'] ?? null,
                'alamat' => $data['alamat'] ?? null,
            ]);

            PasienUser::query()->create([
                'id_pasien' => $pasien->id_pasien,
                'user_id' => $user->id,
            ]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('pasien.reservasi.index');
    }

    public function destroy(): RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('pasien.login');
    }
}
