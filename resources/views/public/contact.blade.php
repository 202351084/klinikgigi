@extends('layouts.app', ['title' => 'Kontak'])

@section('body')
    @php
        $waNumber = $klinik->nomor_whatsapp ? preg_replace('/[^0-9]/', '', $klinik->nomor_whatsapp) : null;
        if ($waNumber && str_starts_with($waNumber, '0')) {
            $waNumber = '62'.substr($waNumber, 1);
        }
        $phoneNumber = $klinik->nomor_telepon ? preg_replace('/[^0-9]/', '', $klinik->nomor_telepon) : null;
        if ($phoneNumber && str_starts_with($phoneNumber, '0')) {
            $phoneNumber = '62'.substr($phoneNumber, 1);
        }
        $whatsAppLink = $waNumber ? 'https://wa.me/'.$waNumber : null;
        $phoneWhatsAppLink = $phoneNumber ? 'https://wa.me/'.$phoneNumber : null;
    @endphp

    @include('public.partials.nav')
    <main class="container panel">
        <h1>Kontak Klinik</h1>
        <p><strong>WhatsApp:</strong>
            @if($whatsAppLink)
                <a href="{{ $whatsAppLink }}" class="text-clinic-teal hover:underline">+{{ $waNumber }}</a>
            @else
                -
            @endif
        </p>
        <p><strong>Telepon:</strong>
            @if($phoneWhatsAppLink)
                <a href="{{ $phoneWhatsAppLink }}" class="text-clinic-teal hover:underline">+{{ $phoneNumber }}</a>
            @else
                -
            @endif
        </p>
        <p><strong>Email:</strong>
            @if($klinik->email_klinik)
                <a href="mailto:{{ $klinik->email_klinik }}" class="text-clinic-teal hover:underline">{{ $klinik->email_klinik }}</a>
            @else
                -
            @endif
        </p>
        <p><strong>Alamat:</strong> {{ $klinik->alamat ?: '-' }}</p>
    </main>
    @include('public.partials.footer')
@endsection
