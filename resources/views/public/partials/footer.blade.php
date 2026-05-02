@php
    $waNumber = $klinik->nomor_whatsapp ? preg_replace('/[^0-9]/', '', $klinik->nomor_whatsapp) : null;
    if ($waNumber && str_starts_with($waNumber, '0')) {
        $waNumber = '62'.substr($waNumber, 1);
    }
    $whatsAppLink = $waNumber ? 'https://wa.me/'.$waNumber : null;
    $phoneNumber = $klinik->nomor_telepon ? preg_replace('/[^0-9]/', '', $klinik->nomor_telepon) : null;
    if ($phoneNumber && str_starts_with($phoneNumber, '0')) {
        $phoneNumber = '62'.substr($phoneNumber, 1);
    }
    $phoneWhatsAppLink = $phoneNumber ? 'https://wa.me/'.$phoneNumber : null;
@endphp

<footer class="mx-auto mt-10 max-w-6xl rounded-[24px] border border-clinic-line/80 bg-[#f6f0df] px-5 py-5 shadow-[0_18px_40px_-34px_rgba(36,65,68,0.45)] sm:mt-12 sm:rounded-[28px] sm:px-6 sm:py-6">
    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <div class="text-lg font-bold text-clinic-ink">{{ $klinik->nama_klinik }}</div>
            <p class="mt-2 text-sm leading-6 text-clinic-moss">{{ $klinik->deskripsi_singkat ?: 'Klinik gigi keluarga dengan informasi dan reservasi online.' }}</p>
        </div>
        <div class="text-sm text-clinic-moss">
            <div><strong class="text-clinic-ink">Alamat:</strong> {{ $klinik->alamat ?: '-' }}</div>
            <div class="mt-1"><strong class="text-clinic-ink">Hubungi:</strong>
                @if($whatsAppLink)
                    <a href="{{ $whatsAppLink }}" class="text-clinic-teal hover:underline">+{{ $waNumber }}</a>
                @elseif($phoneWhatsAppLink)
                    <a href="{{ $phoneWhatsAppLink }}" class="text-clinic-teal hover:underline">+{{ $phoneNumber }}</a>
                @else
                    -
                @endif
            </div>
            <div class="mt-1"><strong class="text-clinic-ink">Email:</strong>
                @if($klinik->email_klinik)
                    <a href="mailto:{{ $klinik->email_klinik }}" class="hover:underline">{{ $klinik->email_klinik }}</a>
                @else
                    -
                @endif
            </div>
        </div>
    </div>

    <div class="mt-6 border-t border-clinic-line/80 pt-4 text-center text-sm text-clinic-moss">
        &copy; 2026 {{ $klinik->nama_klinik }}. All rights reserved.
    </div>
</footer>
