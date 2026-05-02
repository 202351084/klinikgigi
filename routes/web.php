<?php

use App\Http\Controllers\Doctor\AuthController;
use App\Http\Controllers\Doctor\DashboardController;
use App\Http\Controllers\Doctor\DoctorSettingController;
use App\Http\Controllers\Doctor\ServiceController;
use App\Http\Controllers\Dokter\JadwalController as DokterJadwalController;
use App\Http\Controllers\Dokter\ReservasiController as DokterReservasiController;
use App\Http\Controllers\Pasien\AuthController as PasienAuthController;
use App\Http\Controllers\Pasien\DashboardController as PasienDashboardController;
use App\Http\Controllers\Pasien\ProfileController as PasienProfileController;
use App\Http\Controllers\Pasien\ReservasiController as PasienReservasiController;
use App\Http\Controllers\PublicSiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicSiteController::class, 'home'])->name('public.home');
Route::get('/tentang', [PublicSiteController::class, 'about'])->name('public.about');
Route::get('/layanan', [PublicSiteController::class, 'services'])->name('public.services');
Route::get('/profil-dokter', [PublicSiteController::class, 'doctor'])->name('public.doctor');
Route::get('/jadwal-praktik', [PublicSiteController::class, 'schedule'])->name('public.schedule');
Route::get('/faq', [PublicSiteController::class, 'faq'])->name('public.faq');
Route::get('/kontak', [PublicSiteController::class, 'contact'])->name('public.contact');

Route::prefix('dokter')->name('doctor.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'create'])->name('login');
        Route::post('/login', [AuthController::class, 'store'])->name('login.store');
    });

    Route::middleware('doctor')->group(function () {
        Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/pengaturan', [DoctorSettingController::class, 'edit'])->name('settings.edit');
        Route::put('/pengaturan', [DoctorSettingController::class, 'update'])->name('settings.update');
        Route::post('/pengaturan/banner', [DoctorSettingController::class, 'storeBanner'])->name('settings.banner.store');
        Route::patch('/pengaturan/banner/{bannerPromo}', [DoctorSettingController::class, 'updateBanner'])->name('settings.banner.update');
        Route::delete('/pengaturan/banner/{bannerPromo}', [DoctorSettingController::class, 'destroyBanner'])->name('settings.banner.destroy');
        Route::post('/pengaturan/faq', [DoctorSettingController::class, 'storeFaq'])->name('settings.faq.store');
        Route::patch('/pengaturan/faq/{faq}', [DoctorSettingController::class, 'updateFaq'])->name('settings.faq.update');
        Route::delete('/pengaturan/faq/{faq}', [DoctorSettingController::class, 'destroyFaq'])->name('settings.faq.destroy');
        Route::resource('/layanan', ServiceController::class)->except(['show']);
    });
});

Route::prefix('pasien')
    ->name('pasien.')
    ->group(function () {
        Route::middleware('guest')->group(function () {
            Route::get('/login', [PasienAuthController::class, 'createLogin'])->name('login');
            Route::post('/login', [PasienAuthController::class, 'storeLogin'])->name('login.store');
            Route::get('/register', [PasienAuthController::class, 'createRegister'])->name('register');
            Route::post('/register', [PasienAuthController::class, 'storeRegister'])->name('register.store');
        });

        Route::middleware(['auth', 'role:patient'])->group(function () {
            Route::post('/logout', [PasienAuthController::class, 'destroy'])->name('logout');
        });
    });

Route::prefix('pasien')
    ->name('pasien.')
    ->middleware(['auth', 'role:patient'])
    ->group(function () {
        Route::get('/', [PasienDashboardController::class, 'index'])->name('dashboard');
        Route::get('/reservasi', [PasienReservasiController::class, 'index'])->name('reservasi.index');
        Route::get('/reservasi/buat', [PasienReservasiController::class, 'create'])->name('reservasi.create');
        Route::get('/reservasi/slot-tersedia', [PasienReservasiController::class, 'availableSlots'])->name('reservasi.slots');
        Route::post('/reservasi', [PasienReservasiController::class, 'store'])->name('reservasi.store');
        Route::patch('/reservasi/{reservasi}/konfirmasi-reschedule', [PasienReservasiController::class, 'konfirmasiReschedule'])->name('reservasi.konfirmasi-reschedule');
        Route::patch('/reservasi/{reservasi}/batalkan', [PasienReservasiController::class, 'batalkan'])->name('reservasi.batalkan');
        Route::get('/profil', [PasienProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profil', [PasienProfileController::class, 'update'])->name('profile.update');
    });

Route::prefix('dokter')
    ->name('dokter.')
    ->middleware(['auth', 'role:doctor'])
    ->group(function () {
        Route::get('/reservasi', [DokterReservasiController::class, 'index'])->name('reservasi.index');
        Route::get('/jadwal', [DokterJadwalController::class, 'index'])->name('jadwal.index');
        Route::patch('/reservasi/{reservasi}/konfirmasi', [DokterReservasiController::class, 'konfirmasi'])->name('reservasi.konfirmasi');
        Route::patch('/reservasi/{reservasi}/tolak', [DokterReservasiController::class, 'tolak'])->name('reservasi.tolak');
        Route::patch('/reservasi/{reservasi}/batalkan', [DokterReservasiController::class, 'batalkan'])->name('reservasi.batalkan');
        Route::patch('/reservasi/{reservasi}/selesai', [DokterReservasiController::class, 'selesai'])->name('reservasi.selesai');
        Route::patch('/reservasi/{reservasi}/reschedule', [DokterReservasiController::class, 'ajukanReschedule'])->name('reservasi.reschedule');
    });
