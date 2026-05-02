@extends('layouts.pasien', ['title' => 'Booking Reservasi'])

@section('pasien_content')
    <section class="space-y-6">
        <div class="rounded-3xl border border-[#d9d1b6] bg-white/90 p-6 shadow-sm">
            <h1 class="text-2xl font-semibold text-slate-900">Booking Reservasi</h1>
            @if(session('status')) <div class="flash">{{ session('status') }}</div> @endif
            <p class="mt-2 text-sm text-slate-600">Pasien: {{ $pasien->nama_pasien ?? auth()->user()->name }}</p>
        </div>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
            <section class="rounded-3xl border border-[#d9d1b6] bg-white p-6 shadow-sm">
                <form method="POST" action="{{ route('pasien.reservasi.store') }}" class="space-y-5">
            @csrf
                    <div class="grid gap-5 md:grid-cols-2">
                        <div class="field">
                            <label>Layanan</label>
                            <select name="id_layanan" id="id_layanan">
                                <option value="">Pilih layanan</option>
                                @foreach($layananList as $layanan)
                                    <option value="{{ $layanan->id_layanan }}" @selected(old('id_layanan') == $layanan->id_layanan)>
                                        {{ $layanan->nama_layanan }} - {{ $layanan->durasi_layanan }} menit
                                    </option>
                                @endforeach
                            </select>
                            @error('id_layanan') <div class="error">{{ $message }}</div> @enderror
                        </div>
                        <div class="field">
                            <label>Tanggal Reservasi</label>
                            <input
                                type="date"
                                id="tanggal_reservasi"
                                name="tanggal_reservasi"
                                value="{{ old('tanggal_reservasi') }}"
                                min="{{ $today }}"
                                max="{{ $maxDate }}"
                            >
                            @error('tanggal_reservasi') <div class="error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="field">
                        <label>Jam Kunjungan</label>
                        <select name="jam_kunjungan" id="jam_kunjungan" data-old-value="{{ old('jam_kunjungan') }}" disabled>
                            <option value="">Pilih layanan dan tanggal terlebih dahulu</option>
                        </select>
                        <p id="slot_help" class="mt-2 text-sm text-slate-500">
                            Slot jam otomatis mengikuti jam operasional, interval reservasi, durasi layanan, dan ketersediaan dokter.
                        </p>
                        @error('jam_kunjungan') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label>Metode Pembayaran</label>
                        <select name="metode_pembayaran">
                            <option value="">Pilih metode pembayaran</option>
                            <option value="cash" @selected(old('metode_pembayaran') === 'cash')>Cash (Bayar di klinik)</option>
                            <option value="qris" @selected(old('metode_pembayaran') === 'qris')>QRIS (Bayar di klinik)</option>
                        </select>
                        <p class="mt-2 text-sm text-slate-500">Pembayaran saat ini hanya melayani onsite di klinik: Cash atau QRIS.</p>
                        @error('metode_pembayaran') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label>Keluhan Pasien</label>
                        <textarea name="keluhan_pasien" rows="5">{{ old('keluhan_pasien') }}</textarea>
                        @error('keluhan_pasien') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <button class="inline-flex h-12 items-center justify-center rounded-2xl bg-teal-600 px-6 text-sm font-semibold text-white transition hover:bg-teal-700" type="submit">
                        Simpan Reservasi
                    </button>
                </form>
            </section>

            <aside class="space-y-4">
                <section class="rounded-3xl border border-[#d9d1b6] bg-[#fffaf0] p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#8b9660]">Aturan Booking</p>
                    <div class="mt-4 space-y-3 text-sm text-slate-700">
                        <div>
                            <p class="font-semibold text-slate-900">Batas booking</p>
                            <p>Maksimal {{ $pengaturan->hari_booking_ke_depan }} hari ke depan.</p>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900">Interval slot</p>
                            <p>Tersedia per {{ $pengaturan->interval_slot_per_jam }} menit sesuai pengaturan dokter.</p>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900">Kuota harian</p>
                            <p>Maksimal {{ $pengaturan->batas_maksimal_booking_per_hari }} reservasi aktif per hari.</p>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900">Pembayaran</p>
                            <p>Pembayaran reservasi dilakukan onsite di klinik via Cash atau QRIS.</p>
                        </div>
                    </div>
                </section>
                <section class="rounded-3xl border border-[#d9d1b6] bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#8b9660]">Dokter Utama</p>
                    <p class="mt-3 text-base font-semibold text-slate-900">{{ $dokter->nama_dokter }}</p>
                    <p class="text-sm text-slate-600">{{ $dokter->gelar ?: 'Dokter gigi utama klinik' }}</p>
                    <p class="mt-3 text-sm text-slate-600">Jam yang muncul di form ini mengikuti pengaturan operasional klinik yang dibuat dokter.</p>
                </section>
            </aside>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const layananSelect = document.getElementById('id_layanan');
        const tanggalInput = document.getElementById('tanggal_reservasi');
        const jamSelect = document.getElementById('jam_kunjungan');
        const slotHelp = document.getElementById('slot_help');
        let oldValue = jamSelect.dataset.oldValue || '';

        const resetSlots = (message) => {
            jamSelect.innerHTML = '';
            jamSelect.disabled = true;

            const option = document.createElement('option');
            option.value = '';
            option.textContent = message;
            jamSelect.appendChild(option);
            slotHelp.textContent = message;
        };

        const renderSlots = (slots, selectedValue = '') => {
            jamSelect.innerHTML = '';

            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = 'Pilih jam kunjungan';
            jamSelect.appendChild(placeholder);

            slots.forEach((slot) => {
                const option = document.createElement('option');
                option.value = slot.value;
                option.textContent = slot.label;
                option.disabled = Boolean(slot.disabled);

                if (!option.disabled && selectedValue && selectedValue === slot.value) {
                    option.selected = true;
                }

                jamSelect.appendChild(option);
            });

            jamSelect.disabled = slots.every((slot) => Boolean(slot.disabled));
            slotHelp.textContent = slots.length > 0
                ? 'Slot yang sudah lewat tetap ditampilkan, tetapi tidak bisa dipilih.'
                : 'Tidak ada slot tersedia pada tanggal tersebut.';
        };

        const loadSlots = async () => {
            const layanan = layananSelect.value;
            const tanggal = tanggalInput.value;

            if (!layanan || !tanggal) {
                resetSlots('Pilih layanan dan tanggal terlebih dahulu');
                return;
            }

            resetSlots('Memuat slot tersedia...');

            try {
                const params = new URLSearchParams({
                    id_layanan: layanan,
                    tanggal_reservasi: tanggal,
                });

                const response = await fetch(`{{ route('pasien.reservasi.slots') }}?${params.toString()}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                const data = await response.json();

                if (!response.ok) {
                    resetSlots(data.message || 'Slot tidak dapat dimuat.');
                    return;
                }

                renderSlots(data.slots || [], oldValue);
                oldValue = '';
            } catch (error) {
                resetSlots('Gagal memuat slot. Coba lagi.');
            }
        };

        layananSelect.addEventListener('change', loadSlots);
        tanggalInput.addEventListener('change', loadSlots);

        if (layananSelect.value && tanggalInput.value) {
            loadSlots();
        } else {
            resetSlots('Pilih layanan dan tanggal terlebih dahulu');
        }
    });
</script>
@endpush
