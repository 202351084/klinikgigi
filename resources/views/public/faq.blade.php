@extends('layouts.app', ['title' => 'FAQ'])

@section('body')
    @include('public.partials.nav')
    <main class="container panel">
        <h1>FAQ</h1>
        <p class="muted">Pertanyaan yang sering ditanyakan pasien.</p>
        @forelse($faqList as $faq)
            <div class="card" style="margin-top:16px;">
                <strong>{{ $faq->pertanyaan }}</strong>
                <p class="muted" style="margin-top:8px;">{{ $faq->jawaban }}</p>
            </div>
        @empty
            <p class="muted">FAQ belum tersedia.</p>
        @endforelse
    </main>
    @include('public.partials.footer')
@endsection
