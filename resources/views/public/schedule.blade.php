@extends('layouts.app', ['title' => 'Jadwal Praktik'])

@section('body')
    @include('public.partials.nav')
    <main class="container panel">
        <h1>Jadwal Praktik</h1>
        <p class="muted">Jam praktik di bawah ini berasal dari pengaturan dokter.</p>
        <table class="table">
            <thead>
                <tr><th>Hari</th><th>Status</th><th>Jam</th></tr>
            </thead>
            <tbody>
                @foreach($jamOperasionalList as $jam)
                    <tr>
                        <td>{{ ucfirst($jam->hari_buka) }}</td>
                        <td>{{ $jam->hari_libur ? 'Libur' : 'Buka' }}</td>
                        <td>{{ $jam->hari_libur ? '-' : substr($jam->jam_buka, 0, 5).' - '.substr($jam->jam_tutup, 0, 5) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
    @include('public.partials.footer')
@endsection
