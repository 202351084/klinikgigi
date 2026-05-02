<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banner_promo', function (Blueprint $table) {
            $table->id('id_banner');
            $table->string('gambar_banner_promo')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banner_promo');
    }
};
