<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id('id_layanan');
            $table->string('nama_layanan');
            $table->string('gambar_layanan')->nullable();
            $table->text('deskripsi_layanan')->nullable();
            $table->decimal('harga_estimasi_biaya', 12, 2);
            $table->integer('durasi_layanan');
            $table->string('status_layanan', 20);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};
