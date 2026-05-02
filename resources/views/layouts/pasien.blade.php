@extends('layouts.app', ['title' => $title ?? 'Area Pasien'])

@section('body')
    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto flex max-w-7xl gap-6 px-4 py-6 lg:px-6">
            @include('pasien.partials.sidebar')
            <main class="min-w-0 flex-1">
                @yield('pasien_content')
            </main>
        </div>
    </div>
@endsection
