<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jam_operasional', function (Blueprint $table) {
            $table->id('id_jam_operasional');
            $table->string('hari_buka', 20);
            $table->time('jam_buka')->nullable();
            $table->time('jam_tutup')->nullable();
            $table->string('hari_libur', 20)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jam_operasional');
    }
};
