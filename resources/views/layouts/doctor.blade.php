@extends('layouts.app', ['title' => $title ?? 'Panel Dokter'])

@section('body')
    <div class="min-h-screen bg-slate-50">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 py-4 sm:py-6 lg:flex-row lg:px-6">
            @include('doctor.partials.sidebar')
            <main class="min-w-0 flex-1">
                @yield('doctor_content')
            </main>
        </div>
    </div>
@endsection
