<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id('id_reservasi');
            $table->string('kode_reservasi', 50);
            $table->date('tanggal_reservasi');
            $table->time('jam_kunjungan');
            $table->text('keluhan_pasien');
            $table->string('status_reservasi', 40);
            $table->string('metode_pembayaran', 50)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
