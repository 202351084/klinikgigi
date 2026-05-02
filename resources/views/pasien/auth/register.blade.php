@extends('layouts.app', ['title' => 'Register Pasien'])

@section('body')
    <main class="container" style="max-width:620px;padding-top:64px;">
        <div class="panel">
            <h1>Register Pasien</h1>
            <p class="muted">Buat akun pasien untuk booking reservasi dan mengelola data kunjungan.</p>

            <form method="POST" action="{{ route('pasien.register.store') }}">
                @csrf
                <div class="grid grid-2">
                    <div class="field">
                        <label>Nama Pasien</label>
                        <input name="nama_pasien" value="{{ old('nama_pasien') }}">
                        @error('nama_pasien') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}">
                        @error('email') <div class="error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="grid grid-2">
                    <div class="field">
                        <label>Nomor HP</label>
                        <input name="nomor_hp" value="{{ old('nomor_hp') }}">
                        @error('nomor_hp') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label>Alamat</label>
                        <input name="alamat" value="{{ old('alamat') }}">
                        @error('alamat') <div class="error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="grid grid-2">
                    <div class="field">
                        <label>Password</label>
                        <input type="password" name="password">
                        @error('password') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation">
                    </div>
                </div>

                <button class="btn" type="submit">Buat Akun Pasien</button>
            </form>

            <p class="muted" style="margin-top:16px;">
                Sudah punya akun?
                <a href="{{ route('pasien.login') }}" style="color:#127c72;font-weight:600;">Login pasien</a>
            </p>
        </div>
    </main>
@endsection
