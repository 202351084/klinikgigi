@extends('layouts.app', ['title' => 'Login Dokter'])

@section('body')
    <main class="container" style="max-width:520px;padding-top:64px;">
        <div class="panel">
            <h1>Login Dokter</h1>
            <p class="muted">Masuk ke panel dokter untuk mengubah konten website publik.</p>
            <form method="POST" action="{{ route('doctor.login.store') }}">
                @csrf
                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}">
                    @error('email') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password">
                </div>
                <button class="btn" type="submit">Masuk</button>
            </form>
            <p class="muted" style="margin-top:16px;">Seeder default: doctor@cahayadental.test / password</p>
        </div>
    </main>
@endsection
