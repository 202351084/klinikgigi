@extends('layouts.app', ['title' => $klinik->nama_klinik])

@section('body')
    @php
        $whatsAppLink = $klinik->nomor_whatsapp ? 'https://wa.me/'.preg_replace('/[^0-9]/', '', $klinik->nomor_whatsapp) : null;
        $phoneWhatsAppLink = $klinik->nomor_telepon ? 'https://wa.me/'.preg_replace('/[^0-9]/', '', $klinik->nomor_telepon) : null;
        $bookingUrl = auth()->check() && auth()->user()->role === 'patient'
            ? route('pasien.reservasi.create')
            : route('pasien.register');
    @endphp

    @include('public.partials.nav')
    <main class="container space-y-6 sm:space-y-8">
        <section class="relative overflow-hidden rounded-[28px] border border-clinic-line/80 bg-[linear-gradient(135deg,#dbe1b5_0%,#ece3ca_48%,#bdeee7_100%)] px-5 py-6 shadow-[0_24px_60px_-38px_rgba(36,65,68,0.38)] sm:px-6 sm:py-7 lg:rounded-[34px] lg:px-[60px] lg:py-[56px]">
            <div class="absolute -right-16 top-0 h-56 w-56 rounded-full bg-white/25 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 h-40 w-40 rounded-full bg-clinic-mint/20 blur-2xl"></div>

            <div class="relative">
                <span class="inline-flex rounded-full border border-clinic-ink/10 bg-white/75 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.24em] text-clinic-moss sm:px-5 sm:text-xs sm:tracking-[0.28em]">
                    Klinik gigi keluarga
                </span>
            </div>

            <div class="relative mt-5 sm:mt-6">
                <div>
                    <h1 class="max-w-[560px] text-[34px] font-black leading-[1.05] tracking-[-0.03em] text-clinic-ink sm:text-[40px] md:text-[52px] lg:text-[56px]">
                        Senyum sehat,
                        <br>
                        reservasi lebih mudah.
                    </h1>
                    <p class="mt-4 max-w-[620px] text-[15px] leading-7 text-clinic-ink/80 sm:mt-5 sm:text-base sm:leading-8 md:text-[18px]">
                        Klinik gigi keluarga untuk anak, dewasa, dan lansia. Cek jadwal dokter, layanan, dan lakukan booking online dengan sederhana.
                    </p>

                    <div class="mt-5 inline-flex max-w-full rounded-[22px] border border-white/75 bg-white/78 px-4 py-3 text-sm text-clinic-ink shadow-[0_14px_28px_-24px_rgba(36,65,68,0.45)] sm:mt-6 sm:px-5 sm:py-4">
                        Dokter utama:
                        <span class="ml-2 font-bold">{{ $dokter ? $dokter->nama_dokter : 'Belum diatur' }}</span>
                    </div>

                    <div class="mt-6 flex flex-col gap-3 sm:mt-7 sm:flex-row sm:flex-wrap xl:flex-nowrap xl:items-center">
                        <a href="{{ $bookingUrl }}" class="inline-flex h-[52px] items-center justify-center whitespace-nowrap rounded-2xl bg-clinic-teal px-5 text-sm font-semibold text-white shadow-[0_18px_32px_-20px_rgba(29,159,151,0.85)] transition hover:bg-[#198d86] sm:h-[54px] sm:px-6">
                            Booking Reservasi
                        </a>
                        <a href="{{ route('public.schedule') }}" class="inline-flex h-[52px] items-center justify-center whitespace-nowrap rounded-2xl border border-clinic-ink/10 bg-white/78 px-5 text-sm font-semibold text-clinic-ink transition hover:bg-white sm:h-[54px] sm:px-6">
                            Lihat Jadwal Praktik
                        </a>
                        @if($whatsAppLink)
                            <a href="{{ $whatsAppLink }}" class="inline-flex h-[52px] items-center justify-center whitespace-nowrap rounded-2xl border border-clinic-teal/25 bg-transparent px-5 text-sm font-semibold text-clinic-teal transition hover:bg-white/60 sm:h-[54px]">
                                WhatsApp Klinik
                            </a>
                        @endif
                    </div>

                    <div class="mt-8 grid gap-4 sm:mt-10 sm:grid-cols-2 lg:grid-cols-3">
                        <div class="min-h-[114px] rounded-[24px] border border-white/75 bg-white/75 px-5 py-5 shadow-[0_16px_34px_-28px_rgba(36,65,68,0.45)]">
                            <div class="text-xs font-semibold uppercase tracking-[0.18em] text-clinic-moss">Layanan Klinik</div>
                            <div class="mt-3 text-2xl font-black text-clinic-ink">{{ $layananList->count() }}</div>
                            <div class="mt-1 text-sm text-clinic-moss">Layanan klinik</div>
                        </div>
                        <div class="min-h-[114px] rounded-[24px] border border-white/75 bg-white/75 px-5 py-5 shadow-[0_16px_34px_-28px_rgba(36,65,68,0.45)]">
                            <div class="text-xs font-semibold uppercase tracking-[0.18em] text-clinic-moss">Reservasi Online</div>
                            <div class="mt-3 text-2xl font-black text-clinic-ink">Mudah</div>
                            <div class="mt-1 text-sm text-clinic-moss">Booking online</div>
                        </div>
                        <div class="min-h-[114px] rounded-[24px] border border-white/75 bg-white/75 px-5 py-5 shadow-[0_16px_34px_-28px_rgba(36,65,68,0.45)]">
                            <div class="text-xs font-semibold uppercase tracking-[0.18em] text-clinic-moss">FAQ Lengkap</div>
                            <div class="mt-3 text-2xl font-black text-clinic-ink">{{ $faqList->count() }}</div>
                            <div class="mt-1 text-sm text-clinic-moss">Pertanyaan pasien</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if($bannerList->count() >= 1)
            <section class="rounded-[24px] border border-clinic-line/80 bg-white/90 p-5 shadow-[0_24px_50px_-40px_rgba(36,65,68,0.55)] sm:rounded-[28px] sm:p-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.24em] text-clinic-moss">Promo klinik</div>
                        <h2 class="mt-2 text-xl font-black text-clinic-ink sm:text-2xl">Informasi promo dan treatment unggulan</h2>
                    </div>
                    @if($bannerList->count() > 1)
                        <div class="flex items-center gap-2">
                            <button type="button" data-banner-prev class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-clinic-line bg-white text-lg font-semibold text-clinic-ink transition hover:bg-clinic-cream" aria-label="Banner sebelumnya">&lsaquo;</button>
                            <button type="button" data-banner-next class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-clinic-line bg-white text-lg font-semibold text-clinic-ink transition hover:bg-clinic-cream" aria-label="Banner berikutnya">&rsaquo;</button>
                        </div>
                    @endif
                </div>

                <div class="mt-5 overflow-hidden" id="banner-carousel">
                    <div class="flex transition-transform duration-300 ease-out" data-banner-track>
                        @foreach($bannerList as $banner)
                            <div class="w-full shrink-0">
                                <article class="overflow-hidden rounded-[24px] border border-clinic-line/70 bg-[#fbf7eb]">
                                    @if($banner->gambar_banner_promo)
                                        <img class="h-52 w-full object-cover sm:h-64 md:h-80" src="{{ asset('storage/'.$banner->gambar_banner_promo) }}" alt="{{ $banner->judul_promo ?: 'Banner promo' }}">
                                    @endif
                                    <div class="p-4 sm:p-5">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="rounded-full bg-clinic-mint/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-clinic-teal">Promo Klinik</span>
                                            @if($banner->masa_berlaku_selesai)
                                                <span class="rounded-full bg-clinic-cream px-3 py-1 text-xs font-semibold text-clinic-moss">
                                                    Berlaku sampai {{ $banner->masa_berlaku_selesai->format('d M Y') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="mt-4 text-xl font-black text-clinic-ink sm:text-2xl">{{ $banner->judul_promo ?: 'Promo Klinik' }}</div>
                                        <p class="mt-2 max-w-3xl text-sm leading-7 text-clinic-moss">{{ $banner->deskripsi_promo ?: 'Informasi promo perawatan gigi dari klinik.' }}</p>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if($bannerList->count() > 1)
                    <div class="mt-4 flex justify-center gap-2">
                        @foreach($bannerList as $banner)
                            <button type="button" data-banner-dot="{{ $loop->index }}" class="h-2.5 w-2.5 rounded-full bg-clinic-line transition"></button>
                        @endforeach
                    </div>
                @endif
            </section>
        @endif

        <section class="rounded-[24px] border border-clinic-line/80 bg-white/90 p-5 shadow-[0_24px_50px_-40px_rgba(36,65,68,0.55)] sm:rounded-[28px] sm:p-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <div class="text-xs font-semibold uppercase tracking-[0.24em] text-clinic-moss">Layanan klinik</div>
                    <h2 class="mt-2 text-xl font-black text-clinic-ink sm:text-2xl">Perawatan gigi umum hingga estetika dasar</h2>
                </div>
            </div>
            <div class="mt-5 grid gap-4 lg:grid-cols-3">
                @forelse($layananList as $layanan)
                    <article class="flex h-full flex-col rounded-[24px] border border-clinic-line/70 bg-[linear-gradient(180deg,#fbf7ea_0%,#ffffff_100%)] p-5">
                        <div class="inline-flex rounded-full bg-clinic-mint/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.18em] text-clinic-teal">
                            {{ $layanan->durasi_layanan }} menit
                        </div>
                        <h3 class="mt-4 text-xl font-bold text-clinic-ink">{{ $layanan->nama_layanan }}</h3>
                        <p class="mt-3 flex-1 text-sm leading-6 text-clinic-moss">{{ $layanan->deskripsi_layanan ?: 'Deskripsi layanan belum diisi.' }}</p>
                        <div class="mt-5 flex flex-col gap-2 border-t border-clinic-line/70 pt-4 sm:flex-row sm:items-center sm:justify-between">
                            <span class="text-sm text-clinic-moss">Estimasi biaya</span>
                            <span class="text-lg font-black text-clinic-teal">Rp{{ number_format($layanan->harga_estimasi_biaya, 0, ',', '.') }}</span>
                        </div>
                    </article>
                @empty
                    <div class="rounded-[24px] border border-clinic-line/70 bg-[#fbf7ea] p-5 text-clinic-moss">Belum ada layanan aktif.</div>
                @endforelse
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
            <div class="rounded-[24px] border border-clinic-line/80 bg-white/90 p-5 shadow-[0_24px_50px_-40px_rgba(36,65,68,0.55)] sm:rounded-[28px] sm:p-6">
                <div class="text-xs font-semibold uppercase tracking-[0.24em] text-clinic-moss">Profil dokter</div>
                <h2 class="mt-2 text-xl font-black text-clinic-ink sm:text-2xl">Pendampingan dokter yang jelas dan ramah</h2>

                @if($dokter)
                    <div class="mt-5 flex flex-col gap-5 sm:flex-row">
                        <div class="sm:w-44 sm:shrink-0">
                            @if($dokter->foto_dokter)
                                <img class="h-52 w-full rounded-[24px] object-cover" src="{{ asset('storage/'.$dokter->foto_dokter) }}" alt="{{ $dokter->nama_dokter }}">
                            @else
                                <div class="flex h-52 items-center justify-center rounded-[24px] bg-[linear-gradient(135deg,#dce2b8_0%,#b5f0ea_100%)] text-center text-sm font-semibold text-clinic-moss">
                                    Foto dokter belum diisi
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="text-xl font-black text-clinic-ink">{{ $dokter->nama_dokter }}</div>
                            <div class="mt-1 text-sm font-semibold text-clinic-teal">{{ $dokter->gelar ?: 'Dokter gigi' }}</div>
                            <p class="mt-4 text-sm leading-7 text-clinic-moss">{{ $dokter->keterangan ?: 'Profil dokter belum diisi.' }}</p>
                        </div>
                    </div>
                @else
                    <p class="mt-4 text-sm text-clinic-moss">Profil dokter belum diisi.</p>
                @endif
            </div>

            <div class="rounded-[24px] border border-clinic-line/80 bg-white/90 p-5 shadow-[0_24px_50px_-40px_rgba(36,65,68,0.55)] sm:rounded-[28px] sm:p-6">
                <div class="text-xs font-semibold uppercase tracking-[0.24em] text-clinic-moss">Jadwal praktik</div>
                <h2 class="mt-2 text-xl font-black text-clinic-ink sm:text-2xl">Jam operasional dari database klinik</h2>
                <div class="mt-5 space-y-3">
                    @forelse($jamOperasionalList as $jam)
                        <div class="flex flex-col gap-2 rounded-2xl border border-clinic-line/70 bg-[#fbf7ea] px-4 py-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="font-semibold capitalize text-clinic-ink">{{ $jam->hari_buka }}</div>
                            <div class="text-sm font-semibold {{ $jam->hari_libur ? 'text-rose-600' : 'text-clinic-teal' }}">
                                {{ $jam->hari_libur ? 'Libur' : substr($jam->jam_buka,0,5).' - '.substr($jam->jam_tutup,0,5) }}
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-clinic-line/70 bg-[#fbf7ea] px-4 py-4 text-sm text-clinic-moss">Jadwal belum diatur.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="rounded-[24px] border border-clinic-line/80 bg-white/90 p-5 shadow-[0_24px_50px_-40px_rgba(36,65,68,0.55)] sm:rounded-[28px] sm:p-6">
            <div class="text-xs font-semibold uppercase tracking-[0.24em] text-clinic-moss">Lokasi klinik</div>
            <h2 class="mt-2 text-xl font-black text-clinic-ink sm:text-2xl">Kunjungi Cahaya Dental Care</h2>
            <div class="mt-5 overflow-hidden rounded-[20px] border border-clinic-line/70 bg-[#fbf7ea]">
                @if($klinik->alamat)
                    <iframe 
                        width="100%" 
                        height="400" 
                        frameborder="0" 
                        scrolling="no" 
                        marginheight="0" 
                        marginwidth="0" 
                        src="https://maps.google.com/maps?q={{ urlencode($klinik->alamat) }}&t=&z=16&ie=UTF8&iwloc=&output=embed"
                        class="block w-full"
                    ></iframe>
                @else
                    <div class="flex h-[400px] items-center justify-center p-5 text-center text-sm text-clinic-moss">
                        Alamat klinik belum diisi sehingga peta tidak dapat ditampilkan.
                    </div>
                @endif
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-[1fr_0.9fr]">
            <div class="rounded-[24px] border border-clinic-line/80 bg-white/90 p-5 shadow-[0_24px_50px_-40px_rgba(36,65,68,0.55)] sm:rounded-[28px] sm:p-6">
                <div class="text-xs font-semibold uppercase tracking-[0.24em] text-clinic-moss">FAQ</div>
                <h2 class="mt-2 text-xl font-black text-clinic-ink sm:text-2xl">Pertanyaan yang sering ditanyakan pasien</h2>
                <div class="mt-5 space-y-4">
                    @forelse($faqList as $faq)
                        <article class="rounded-2xl border border-clinic-line/70 bg-[#fbf7ea] p-4">
                            <h3 class="text-base font-bold text-clinic-ink">{{ $faq->pertanyaan }}</h3>
                            <p class="mt-2 text-sm leading-6 text-clinic-moss">{{ $faq->jawaban }}</p>
                        </article>
                    @empty
                        <div class="rounded-2xl border border-clinic-line/70 bg-[#fbf7ea] p-4 text-sm text-clinic-moss">FAQ belum ditambahkan.</div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-[24px] border border-clinic-line/80 bg-[linear-gradient(180deg,#c7f1eb_0%,#f7f0dd_100%)] p-5 shadow-[0_24px_50px_-40px_rgba(36,65,68,0.55)] sm:rounded-[28px] sm:p-6">
                <div class="text-xs font-semibold uppercase tracking-[0.24em] text-clinic-moss">Kontak klinik</div>
                <h2 class="mt-2 text-xl font-black text-clinic-ink sm:text-2xl">Hubungi Cahaya Dental Care</h2>
                <p class="mt-3 text-sm leading-6 text-clinic-moss">Pasien bisa langsung menghubungi klinik lewat WhatsApp untuk tanya jadwal, layanan, atau reservasi.</p>

                <div class="mt-5 space-y-4">
                    <div class="rounded-2xl bg-white/75 px-5 py-5">
                        <div class="text-xs font-semibold uppercase tracking-[0.16em] text-clinic-moss">Alamat Klinik</div>
                        <div class="mt-3 text-base font-semibold leading-7 text-clinic-ink">{{ $klinik->alamat ?: 'Alamat klinik belum diisi.' }}</div>
                    </div>

                    <div class="rounded-2xl bg-white/80 px-5 py-5 ring-1 ring-clinic-teal/10">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs font-semibold uppercase tracking-[0.16em] text-clinic-moss">WhatsApp Admin Klinik</div>
                                <div class="mt-2 text-sm text-clinic-moss">Klik nomor atau tombol di bawah untuk langsung chat WhatsApp.</div>
                            </div>
                        </div>

                        @if($whatsAppLink)
                            <div class="mt-4">
                                <a href="{{ $whatsAppLink }}" class="inline-flex rounded-xl bg-clinic-teal px-5 py-3 text-sm font-semibold text-white hover:bg-[#198d86]">
                                    Chat via WhatsApp
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
    @include('public.partials.footer')

    @if($bannerList->count() > 1)
        <script>
            (() => {
                const root = document.getElementById('banner-carousel');
                if (!root) return;

                const track = root.querySelector('[data-banner-track]');
                const prev = document.querySelector('[data-banner-prev]');
                const next = document.querySelector('[data-banner-next]');
                const dots = Array.from(document.querySelectorAll('[data-banner-dot]'));
                const total = {{ $bannerList->count() }};
                let index = 0;
                let startX = 0;
                let autoplay = null;

                const render = () => {
                    track.style.transform = `translateX(-${index * 100}%)`;
                    dots.forEach((dot, dotIndex) => {
                        dot.className = `h-2.5 rounded-full transition ${dotIndex === index ? 'w-7 bg-clinic-teal' : 'w-2.5 bg-clinic-line'}`;
                    });
                };

                const restartAutoplay = () => {
                    if (autoplay) {
                        clearInterval(autoplay);
                    }

                    autoplay = setInterval(() => {
                        index = (index + 1) % total;
                        render();
                    }, 5000);
                };

                prev?.addEventListener('click', () => {
                    index = (index - 1 + total) % total;
                    render();
                    restartAutoplay();
                });

                next?.addEventListener('click', () => {
                    index = (index + 1) % total;
                    render();
                    restartAutoplay();
                });

                dots.forEach((dot, dotIndex) => {
                    dot.addEventListener('click', () => {
                        index = dotIndex;
                        render();
                        restartAutoplay();
                    });
                });

                root.addEventListener('touchstart', (event) => {
                    startX = event.touches[0].clientX;
                }, { passive: true });

                root.addEventListener('touchend', (event) => {
                    const diff = event.changedTouches[0].clientX - startX;
                    if (Math.abs(diff) < 40) return;

                    index = diff < 0 ? (index + 1) % total : (index - 1 + total) % total;
                    render();
                    restartAutoplay();
                }, { passive: true });

                render();
                restartAutoplay();
            })();
        </script>
    @endif
@endsection
