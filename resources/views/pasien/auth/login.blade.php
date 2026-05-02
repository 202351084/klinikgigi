@extends('layouts.app', ['title' => 'Login Pasien'])

@section('body')
    <main class="container" style="max-width:560px;padding-top:64px;">
        <div class="panel">
            <h1>Login Pasien</h1>
            <p class="muted">Masuk ke akun pasien untuk booking reservasi dan melihat riwayat kunjungan.</p>

            <form method="POST" action="{{ route('pasien.login.store') }}">
                @csrf
                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}">
                    @error('email') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password">
                    @error('password') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label><input type="checkbox" name="remember" value="1"> Ingat saya</label>
                </div>

                <button class="btn" type="submit">Masuk</button>
            </form>

            <p class="muted" style="margin-top:16px;">
                Belum punya akun?
                <a href="{{ route('pasien.register') }}" style="color:#127c72;font-weight:600;">Register pasien</a>
            </p>
        </div>
    </main>
@endsection
