@php
    $pendingReservationCount = \App\Models\Reservasi::query()
        ->where('status_reservasi', \App\Enums\StatusReservasi::Menunggu->value)
        ->count();
@endphp

<aside class="w-full shrink-0 lg:w-72">
    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm lg:hidden">
        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-50 text-sm font-semibold text-teal-700 ring-1 ring-teal-100">
                DR
            </div>
            <div>
                <div class="text-sm font-semibold text-slate-800">Panel Dokter</div>
                <div class="text-xs text-slate-500">{{ auth()->user()->name }}</div>
            </div>
        </div>

        <nav class="mt-4 flex gap-2 overflow-x-auto pb-1">
            <a href="{{ route('doctor.dashboard') }}" class="whitespace-nowrap rounded-lg px-3 py-2 text-sm {{ request()->routeIs('doctor.dashboard') ? 'bg-teal-50 font-medium text-teal-700' : 'bg-slate-50 text-slate-700' }}">Dashboard</a>
            <a href="{{ route('dokter.reservasi.index') }}" class="whitespace-nowrap rounded-lg px-3 py-2 text-sm {{ request()->routeIs('dokter.reservasi.*') ? 'bg-teal-50 font-medium text-teal-700' : 'bg-slate-50 text-slate-700' }}">
                Reservasi
                @if($pendingReservationCount > 0)
                    <span class="ml-1 inline-flex min-w-5 items-center justify-center rounded-full bg-amber-100 px-1.5 py-0.5 text-[11px] font-semibold text-amber-700">{{ $pendingReservationCount }}</span>
                @endif
            </a>
            <a href="{{ route('dokter.jadwal.index') }}" class="whitespace-nowrap rounded-lg px-3 py-2 text-sm {{ request()->routeIs('dokter.jadwal.*') ? 'bg-teal-50 font-medium text-teal-700' : 'bg-slate-50 text-slate-700' }}">Jadwal</a>
            <a href="{{ route('doctor.layanan.index') }}" class="whitespace-nowrap rounded-lg px-3 py-2 text-sm {{ request()->routeIs('doctor.layanan.*') ? 'bg-teal-50 font-medium text-teal-700' : 'bg-slate-50 text-slate-700' }}">Layanan</a>
            <a href="{{ route('doctor.settings.edit') }}" class="whitespace-nowrap rounded-lg px-3 py-2 text-sm {{ request()->routeIs('doctor.settings.*') ? 'bg-teal-50 font-medium text-teal-700' : 'bg-slate-50 text-slate-700' }}">Pengaturan</a>
        </nav>

        @if(request()->routeIs('doctor.settings.*'))
            <nav class="mt-3 grid grid-cols-2 gap-2 sm:grid-cols-3">
                <a href="{{ route('doctor.settings.edit', ['tab' => 'identitas']) }}" class="rounded-lg px-3 py-2 text-xs {{ request('tab', 'identitas') === 'identitas' ? 'bg-slate-100 font-medium text-slate-800' : 'bg-slate-50 text-slate-500' }}">Identitas</a>
                <a href="{{ route('doctor.settings.edit', ['tab' => 'kontak']) }}" class="rounded-lg px-3 py-2 text-xs {{ request('tab') === 'kontak' ? 'bg-slate-100 font-medium text-slate-800' : 'bg-slate-50 text-slate-500' }}">Kontak</a>
                <a href="{{ route('doctor.settings.edit', ['tab' => 'jam-operasional']) }}" class="rounded-lg px-3 py-2 text-xs {{ request('tab') === 'jam-operasional' ? 'bg-slate-100 font-medium text-slate-800' : 'bg-slate-50 text-slate-500' }}">Jam Operasional</a>
                <a href="{{ route('doctor.settings.edit', ['tab' => 'profil-dokter']) }}" class="rounded-lg px-3 py-2 text-xs {{ request('tab') === 'profil-dokter' ? 'bg-slate-100 font-medium text-slate-800' : 'bg-slate-50 text-slate-500' }}">Profil Dokter</a>
                <a href="{{ route('doctor.settings.edit', ['tab' => 'pengaturan-reservasi']) }}" class="rounded-lg px-3 py-2 text-xs {{ request('tab') === 'pengaturan-reservasi' ? 'bg-slate-100 font-medium text-slate-800' : 'bg-slate-50 text-slate-500' }}">Reservasi</a>
                <a href="{{ route('doctor.settings.edit', ['tab' => 'banner-promo']) }}" class="rounded-lg px-3 py-2 text-xs {{ request('tab') === 'banner-promo' ? 'bg-slate-100 font-medium text-slate-800' : 'bg-slate-50 text-slate-500' }}">Banner</a>
                <a href="{{ route('doctor.settings.edit', ['tab' => 'faq']) }}" class="rounded-lg px-3 py-2 text-xs {{ request('tab') === 'faq' ? 'bg-slate-100 font-medium text-slate-800' : 'bg-slate-50 text-slate-500' }}">FAQ</a>
            </nav>
        @endif

        <form action="{{ route('doctor.logout') }}" method="POST" class="mt-4 border-t border-slate-100 pt-4">
            @csrf
            <button class="w-full rounded-lg border border-teal-200 px-4 py-2 text-sm font-medium text-teal-700 transition hover:bg-teal-50" type="submit">
                Logout
            </button>
        </form>
    </div>

    <div class="sticky top-6 hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:block">
        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-50 text-sm font-semibold text-teal-700 ring-1 ring-teal-100">
                DR
            </div>
            <div>
                <div class="text-sm font-semibold text-slate-800">Panel Dokter</div>
                <div class="text-xs text-slate-500">{{ auth()->user()->name }}</div>
            </div>
        </div>

        <nav class="mt-4 space-y-1">
            <a href="{{ route('doctor.dashboard') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('doctor.dashboard') ? 'bg-teal-50 font-medium text-teal-700' : 'text-slate-700 hover:bg-slate-50' }}">Dashboard</a>
            <a href="{{ route('dokter.reservasi.index') }}" class="flex items-center justify-between rounded-lg px-3 py-2 text-sm {{ request()->routeIs('dokter.reservasi.*') ? 'bg-teal-50 font-medium text-teal-700' : 'text-slate-700 hover:bg-slate-50' }}">
                <span>Kelola Reservasi</span>
                @if($pendingReservationCount > 0)
                    <span class="inline-flex min-w-6 items-center justify-center rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">
                        {{ $pendingReservationCount }}
                    </span>
                @endif
            </a>
            <a href="{{ route('dokter.jadwal.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('dokter.jadwal.*') ? 'bg-teal-50 font-medium text-teal-700' : 'text-slate-700 hover:bg-slate-50' }}">Kalender Jadwal</a>
            <a href="{{ route('doctor.layanan.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('doctor.layanan.*') ? 'bg-teal-50 font-medium text-teal-700' : 'text-slate-700 hover:bg-slate-50' }}">Kelola Layanan</a>
            <a href="{{ route('doctor.settings.edit') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('doctor.settings.*') ? 'bg-teal-50 font-medium text-teal-700' : 'text-slate-700 hover:bg-slate-50' }}">Pengaturan Klinik</a>

            @if(request()->routeIs('doctor.settings.*'))
                <div class="ml-2 mt-2 space-y-1 border-l border-slate-200 pl-3">
                    <a href="{{ route('doctor.settings.edit', ['tab' => 'identitas']) }}" class="block rounded-lg px-3 py-2 text-xs {{ request('tab', 'identitas') === 'identitas' ? 'bg-slate-100 font-medium text-slate-800' : 'text-slate-500 hover:bg-slate-50' }}">Identitas</a>
                    <a href="{{ route('doctor.settings.edit', ['tab' => 'kontak']) }}" class="block rounded-lg px-3 py-2 text-xs {{ request('tab') === 'kontak' ? 'bg-slate-100 font-medium text-slate-800' : 'text-slate-500 hover:bg-slate-50' }}">Kontak</a>
                    <a href="{{ route('doctor.settings.edit', ['tab' => 'jam-operasional']) }}" class="block rounded-lg px-3 py-2 text-xs {{ request('tab') === 'jam-operasional' ? 'bg-slate-100 font-medium text-slate-800' : 'text-slate-500 hover:bg-slate-50' }}">Jam Operasional</a>
                    <a href="{{ route('doctor.settings.edit', ['tab' => 'profil-dokter']) }}" class="block rounded-lg px-3 py-2 text-xs {{ request('tab') === 'profil-dokter' ? 'bg-slate-100 font-medium text-slate-800' : 'text-slate-500 hover:bg-slate-50' }}">Profil Dokter</a>
                    <a href="{{ route('doctor.settings.edit', ['tab' => 'pengaturan-reservasi']) }}" class="block rounded-lg px-3 py-2 text-xs {{ request('tab') === 'pengaturan-reservasi' ? 'bg-slate-100 font-medium text-slate-800' : 'text-slate-500 hover:bg-slate-50' }}">Reservasi</a>
                    <a href="{{ route('doctor.settings.edit', ['tab' => 'banner-promo']) }}" class="block rounded-lg px-3 py-2 text-xs {{ request('tab') === 'banner-promo' ? 'bg-slate-100 font-medium text-slate-800' : 'text-slate-500 hover:bg-slate-50' }}">Banner Promo</a>
                    <a href="{{ route('doctor.settings.edit', ['tab' => 'faq']) }}" class="block rounded-lg px-3 py-2 text-xs {{ request('tab') === 'faq' ? 'bg-slate-100 font-medium text-slate-800' : 'text-slate-500 hover:bg-slate-50' }}">FAQ</a>
                </div>
            @endif
        </nav>

        @if($pendingReservationCount > 0)
            <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-xs text-amber-800">
                Ada {{ $pendingReservationCount }} reservasi baru dari pasien yang menunggu tindakan.
            </div>
        @endif

        <form action="{{ route('doctor.logout') }}" method="POST" class="mt-5 border-t border-slate-100 pt-4">
            @csrf
            <button class="w-full rounded-lg border border-teal-200 px-4 py-2 text-sm font-medium text-teal-700 transition hover:bg-teal-50" type="submit">
                Logout
            </button>
        </form>
    </div>
</aside>
