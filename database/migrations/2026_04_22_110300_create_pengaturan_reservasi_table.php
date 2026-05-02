<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_reservasi', function (Blueprint $table) {
            $table->id('id_pengaturan_reservasi');
            $table->integer('batas_maksimal_booking_per_hari');
            $table->integer('interval_slot_per_jam');
            $table->integer('hari_booking_ke_depan');
            $table->boolean('pasien_bisa_reschedule_sendiri');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_reservasi');
    }
};
