<div class="space-y-6">
    <section class="rounded-2xl border border-slate-200 bg-slate-50/60 p-5">
        <div class="flex flex-col gap-2 md:flex-row md:items-start md:justify-between">
            <div>
                <h3 class="text-base font-semibold text-slate-800">Tambah Banner Promo</h3>
                <p class="mt-1 text-sm text-slate-500">Banner aktif akan dipakai di homepage. Isi judul, gambar, urutan tampil, dan masa berlakunya di sini.</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-xs text-slate-500">
                Format terbaik: gambar landscape, fokus jelas, dan ukuran file ringan.
            </div>
        </div>

        <form method="POST" action="{{ route('doctor.settings.banner.store') }}" enctype="multipart/form-data" class="mt-5 grid gap-5 md:grid-cols-2">
            @csrf

            <div class="field">
                <label>Judul Promo</label>
                <input name="judul_promo" value="{{ old('judul_promo') }}">
            </div>

            <div class="field">
                <label>Urutan Tampil</label>
                <input type="number" name="urutan" value="{{ old('urutan', 1) }}">
            </div>

            <div class="field md:col-span-2">
                <label>Deskripsi Promo</label>
                <textarea name="deskripsi_promo" rows="4">{{ old('deskripsi_promo') }}</textarea>
            </div>

            <div class="field">
                <label>Gambar Banner Promo</label>
                <input type="file" name="gambar_banner_promo">
            </div>

            <div class="field">
                <label>Status Banner</label>
                <select name="status_aktif">
                    <option value="1" @selected(old('status_aktif', '1') == '1')>Aktif</option>
                    <option value="0" @selected(old('status_aktif') == '0')>Nonaktif</option>
                </select>
            </div>

            <div class="field">
                <label>Masa Berlaku Mulai</label>
                <input type="date" name="masa_berlaku_mulai" value="{{ old('masa_berlaku_mulai') }}">
            </div>

            <div class="field">
                <label>Masa Berlaku Selesai</label>
                <input type="date" name="masa_berlaku_selesai" value="{{ old('masa_berlaku_selesai') }}">
            </div>

            <div class="md:col-span-2">
                <button class="rounded-lg bg-teal-700 px-5 py-3 text-sm font-medium text-white transition hover:bg-teal-800" type="submit">
                    Simpan Banner Promo
                </button>
            </div>
        </form>
    </section>

    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-semibold text-slate-800">Daftar Banner Promo</h3>
            <div class="text-sm text-slate-500">{{ $bannerPromoList->count() }} banner</div>
        </div>

        @forelse($bannerPromoList as $banner)
            <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="grid gap-0 lg:grid-cols-[280px_minmax(0,1fr)]">
                    <div class="border-b border-slate-200 bg-slate-50 lg:border-b-0 lg:border-r">
                        @if($banner->gambar_banner_promo)
                            <img src="{{ asset('storage/'.$banner->gambar_banner_promo) }}" alt="Banner Promo" class="h-56 w-full object-cover">
                        @else
                            <div class="flex h-56 items-center justify-center text-sm text-slate-400">Banner belum memiliki gambar</div>
                        @endif
                    </div>

                    <div class="p-5">
                        <div class="mb-4 flex flex-wrap items-center gap-2">
                            <span class="rounded-full px-3 py-1 text-xs font-medium {{ $banner->status_aktif ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $banner->status_aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">
                                Urutan {{ $banner->urutan }}
                            </span>
                            @if($banner->masa_berlaku_mulai || $banner->masa_berlaku_selesai)
                                <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-700">
                                    {{ optional($banner->masa_berlaku_mulai)->format('d M Y') ?: '-' }} s/d {{ optional($banner->masa_berlaku_selesai)->format('d M Y') ?: '-' }}
                                </span>
                            @endif
                        </div>

                        <div class="space-y-4">
                            <form method="POST" action="{{ route('doctor.settings.banner.update', $banner) }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            @method('PATCH')

                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="field">
                                    <label>Judul Promo</label>
                                    <input name="judul_promo" value="{{ old('judul_promo', $banner->judul_promo) }}">
                                </div>

                                <div class="field">
                                    <label>Urutan Tampil</label>
                                    <input type="number" name="urutan" value="{{ old('urutan', $banner->urutan) }}">
                                </div>

                                <div class="field md:col-span-2">
                                    <label>Deskripsi Promo</label>
                                    <textarea name="deskripsi_promo" rows="3">{{ old('deskripsi_promo', $banner->deskripsi_promo) }}</textarea>
                                </div>

                                <div class="field">
                                    <label>Ganti Gambar</label>
                                    <input type="file" name="gambar_banner_promo">
                                </div>

                                <div class="field">
                                    <label>Status Banner</label>
                                    <select name="status_aktif">
                                        <option value="1" @selected(old('status_aktif', $banner->status_aktif) == 1)>Aktif</option>
                                        <option value="0" @selected(old('status_aktif', $banner->status_aktif) == 0)>Nonaktif</option>
                                    </select>
                                </div>

                                <div class="field">
                                    <label>Masa Berlaku Mulai</label>
                                    <input type="date" name="masa_berlaku_mulai" value="{{ old('masa_berlaku_mulai', optional($banner->masa_berlaku_mulai)->format('Y-m-d')) }}">
                                </div>

                                <div class="field">
                                    <label>Masa Berlaku Selesai</label>
                                    <input type="date" name="masa_berlaku_selesai" value="{{ old('masa_berlaku_selesai', optional($banner->masa_berlaku_selesai)->format('Y-m-d')) }}">
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-3 border-t border-slate-100 pt-4">
                                <button class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50" type="submit">
                                    Update Banner
                                </button>
                            </form>

                                <form method="POST" action="{{ route('doctor.settings.banner.destroy', $banner) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-lg border border-rose-200 px-4 py-2 text-sm font-medium text-rose-600 transition hover:bg-rose-50" type="submit">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-5 py-8 text-center text-sm text-slate-500">
                Belum ada banner promo. Tambahkan banner pertama untuk ditampilkan di homepage.
            </div>
        @endforelse
    </section>
</div>
