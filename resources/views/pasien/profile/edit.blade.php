@extends('layouts.pasien', ['title' => 'Profil Saya'])

@section('pasien_content')
    <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Profil Saya</h1>
            <p class="mt-1 text-sm text-slate-500">Perbarui data pasien dan password akun Anda di sini.</p>
        </div>

        @if(session('status'))
            <div class="mt-4 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('pasien.profile.update') }}" class="mt-6 space-y-5">
            @csrf
            @method('PUT')

            <div class="grid gap-5 md:grid-cols-2">
                <div class="field">
                    <label>Nama Pasien</label>
                    <input name="nama_pasien" value="{{ old('nama_pasien', $pasien->nama_pasien) }}">
                    @error('nama_pasien') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label>Email Akun</label>
                    <input value="{{ $user->email }}" disabled>
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div class="field">
                    <label>Nomor HP</label>
                    <input name="nomor_hp" value="{{ old('nomor_hp', $pasien->nomor_hp) }}">
                    @error('nomor_hp') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label>Alamat</label>
                    <input name="alamat" value="{{ old('alamat', $pasien->alamat) }}">
                    @error('alamat') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div class="field">
                    <label>Password Baru</label>
                    <input type="password" name="password">
                    @error('password') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation">
                </div>
            </div>

            <button class="rounded-lg bg-teal-700 px-5 py-3 text-sm font-medium text-white hover:bg-teal-800" type="submit">Simpan Profil</button>
        </form>
    </section>
@endsection
