<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\DoctorLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View
    {
        return view('doctor.auth.login');
    }

    public function store(DoctorLoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (! Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'role' => 'doctor',
            'is_active' => true,
        ], $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Login dokter tidak valid.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('doctor.dashboard');
    }

    public function destroy(): RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('doctor.login');
    }
}
