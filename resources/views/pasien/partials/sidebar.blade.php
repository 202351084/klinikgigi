@php
    $pendingRescheduleCount = auth()->user()
        ->pasien
        ?->reservasi()
        ->where('status_reservasi', 'menunggu_konfirmasi_pasien')
        ->count() ?? 0;
@endphp

<aside class="hidden w-72 shrink-0 lg:block">
    <div class="sticky top-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-50 text-sm font-semibold text-teal-700 ring-1 ring-teal-100">
                PS
            </div>
            <div>
                <div class="text-sm font-semibold text-slate-800">Area Pasien</div>
                <div class="text-xs text-slate-500">{{ auth()->user()->name }}</div>
            </div>
        </div>

        <nav class="mt-4 space-y-1">
            <a href="{{ route('pasien.dashboard') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('pasien.dashboard') ? 'bg-teal-50 font-medium text-teal-700' : 'text-slate-700 hover:bg-slate-50' }}">Dashboard</a>
            <a href="{{ route('pasien.reservasi.create') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('pasien.reservasi.create') ? 'bg-teal-50 font-medium text-teal-700' : 'text-slate-700 hover:bg-slate-50' }}">Booking Reservasi</a>
            <a href="{{ route('pasien.reservasi.index') }}" class="flex items-center justify-between rounded-lg px-3 py-2 text-sm {{ request()->routeIs('pasien.reservasi.index') ? 'bg-teal-50 font-medium text-teal-700' : 'text-slate-700 hover:bg-slate-50' }}">
                <span>Reservasi Saya</span>
                @if($pendingRescheduleCount > 0)
                    <span class="inline-flex min-w-6 items-center justify-center rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">
                        {{ $pendingRescheduleCount }}
                    </span>
                @endif
            </a>
            <a href="{{ route('pasien.profile.edit') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('pasien.profile.*') ? 'bg-teal-50 font-medium text-teal-700' : 'text-slate-700 hover:bg-slate-50' }}">Profil Saya</a>
        </nav>

        @if($pendingRescheduleCount > 0)
            <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-xs text-amber-800">
                Ada {{ $pendingRescheduleCount }} usulan jadwal baru dari dokter yang menunggu konfirmasi.
            </div>
        @endif

        <form action="{{ route('pasien.logout') }}" method="POST" class="mt-5 border-t border-slate-100 pt-4">
            @csrf
            <button class="w-full rounded-lg border border-teal-200 px-4 py-2 text-sm font-medium text-teal-700 transition hover:bg-teal-50" type="submit">
                Logout
            </button>
        </form>
    </div>
</aside>
