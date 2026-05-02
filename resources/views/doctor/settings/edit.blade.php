@extends('layouts.doctor', ['title' => 'Pengaturan Klinik'])

@section('doctor_content')
    @php
        $menus = [
            'identitas' => 'Identitas Klinik',
            'kontak' => 'Kontak Klinik',
            'jam-operasional' => 'Jam Operasional',
            'profil-dokter' => 'Profil Dokter',
            'pengaturan-reservasi' => 'Pengaturan Reservasi',
            'banner-promo' => 'Banner Promo',
            'faq' => 'FAQ',
        ];
    @endphp

    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h1 class="text-xl font-semibold text-slate-800">Pengaturan Klinik</h1>
            <p class="mt-2 text-sm text-slate-500">Pilih menu pengaturan. Yang tampil hanya konten menu aktif.</p>
            @if(session('status'))
                <div class="mt-4 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
            @endif
        </div>

        <div class="grid gap-6 xl:grid-cols-[240px_minmax(0,1fr)]">
            <aside class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="text-sm font-semibold text-slate-800">Menu Pengaturan</div>
                <nav class="mt-4 space-y-1">
                    @foreach($menus as $tabKey => $tabLabel)
                        <a href="{{ route('doctor.settings.edit', ['tab' => $tabKey]) }}"
                           class="block rounded-lg px-3 py-2 text-sm {{ $activeTab === $tabKey ? 'bg-teal-50 font-medium text-teal-700' : 'text-slate-700 hover:bg-slate-50' }}">
                            {{ $tabLabel }}
                        </a>
                    @endforeach
                </nav>
            </aside>

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6 border-b border-slate-100 pb-4">
                    <div class="text-lg font-semibold text-slate-800">{{ $menus[$activeTab] }}</div>
                </div>

                @includeIf('doctor.settings.partials.'.$activeTab)
            </section>
        </div>
    </div>
@endsection
