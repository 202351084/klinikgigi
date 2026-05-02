<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->id('id_pasien');
            $table->string('nama_pasien');
            $table->string('email')->unique();
            $table->string('nomor_hp', 30);
            $table->text('alamat')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
