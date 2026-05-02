<nav class="mx-auto mt-5 flex max-w-6xl items-center justify-between rounded-xl border border-slate-200 bg-white px-5 py-4 shadow-sm">
    <div class="flex items-center gap-3">
        <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-teal-50 text-sm font-semibold text-teal-700 ring-1 ring-teal-100">
            DR
        </div>
        <div class="leading-tight">
            <div class="text-base font-semibold text-slate-800">
                Panel Dokter
            </div>
            <div class="text-xs text-slate-500">
                {{ auth()->user()->name }}
            </div>
        </div>
    </div>

    <div class="flex items-center gap-2">
        <a href="{{ route('doctor.dashboard') }}" class="rounded-md px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Dashboard</a>
        <a href="{{ route('doctor.settings.edit') }}" class="rounded-md px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Pengaturan</a>
        <a href="{{ route('doctor.layanan.index') }}" class="rounded-md px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Layanan</a>
        <a href="{{ route('doctor.settings.edit') }}#banner-promo" class="rounded-md px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Banner</a>
        <form action="{{ route('doctor.logout') }}" method="POST">
            @csrf
            <button class="rounded-md border border-teal-200 px-4 py-2 text-sm font-medium text-teal-700 transition hover:bg-teal-50" type="submit">
                Logout
            </button>
        </form>
    </div>
</nav>
