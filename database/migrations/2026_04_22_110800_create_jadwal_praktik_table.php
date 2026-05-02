<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_praktik', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->date('tanggal');
            $table->time('jam_praktik');
            $table->string('status_slot', 20);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_praktik');
    }
};
