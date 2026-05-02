<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klinik', function (Blueprint $table) {
            $table->id('id_klinik');
            $table->string('nama_klinik');
            $table->string('logo_klinik')->nullable();
            $table->text('deskripsi_singkat')->nullable();
            $table->text('alamat')->nullable();
            $table->string('nomor_whatsapp', 30)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klinik');
    }
};
