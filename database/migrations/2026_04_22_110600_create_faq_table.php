<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faq', function (Blueprint $table) {
            $table->id('id_faq');
            $table->string('pertanyaan');
            $table->text('jawaban');
            $table->string('status_tampil', 20);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq');
    }
};
