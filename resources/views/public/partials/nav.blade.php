<nav class="relative z-30 mx-auto mt-4 flex max-w-6xl items-center justify-between gap-4 rounded-2xl border border-clinic-line/80 bg-white/95 px-4 py-4 shadow-[0_18px_45px_-32px_rgba(36,65,68,0.55)] backdrop-blur sm:px-5 lg:mt-5">
    <div class="flex min-w-0 items-center gap-3">
        @if(!empty($klinik->logo_klinik))
            <img
                src="{{ asset('storage/'.$klinik->logo_klinik) }}"
                alt="Logo {{ $klinik->nama_klinik }}"
                class="h-12 w-12 rounded-xl object-cover ring-2 ring-clinic-sage/60"
            >
        @else
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-clinic-cream text-sm font-semibold text-clinic-teal ring-2 ring-clinic-sage/60">
                CDC
            </div>
        @endif

        <div class="leading-tight">
            <div class="text-lg font-bold tracking-[0.01em] text-clinic-ink">
                {{ $klinik->nama_klinik }}
            </div>
            <div class="text-xs text-clinic-moss">
                Klinik gigi keluarga dan perawatan estetika
            </div>
        </div>
    </div>

    <div class="flex shrink-0 items-center">
        <a
            href="{{ url('/pasien/login') }}"
            class="pointer-events-auto inline-flex items-center justify-center whitespace-nowrap rounded-lg border border-clinic-teal/20 bg-clinic-cream px-4 py-2 text-sm font-semibold text-clinic-teal transition hover:border-clinic-teal/40 hover:bg-clinic-sand"
        >
            Login / Register
        </a>
    </div>
</nav>
