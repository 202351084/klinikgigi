<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasien_user', function (Blueprint $table) {
            $table->id('id_pasien_user');
            $table->unsignedBigInteger('id_pasien')->unique();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();

            $table->foreign('id_pasien')->references('id_pasien')->on('pasien')->cascadeOnDelete();
        });

        Schema::create('dokter_user', function (Blueprint $table) {
            $table->id('id_dokter_user');
            $table->unsignedBigInteger('id_dokter')->unique();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();

            $table->foreign('id_dokter')->references('id_dokter')->on('dokter')->cascadeOnDelete();
        });

        Schema::create('klinik_dokter', function (Blueprint $table) {
            $table->id('id_klinik_dokter');
            $table->unsignedBigInteger('id_klinik');
            $table->unsignedBigInteger('id_dokter');

            $table->unique(['id_klinik', 'id_dokter']);
            $table->foreign('id_klinik')->references('id_klinik')->on('klinik')->cascadeOnDelete();
            $table->foreign('id_dokter')->references('id_dokter')->on('dokter')->cascadeOnDelete();
        });

        Schema::create('klinik_jam_operasional', function (Blueprint $table) {
            $table->id('id_klinik_jam_operasional');
            $table->unsignedBigInteger('id_klinik');
            $table->unsignedBigInteger('id_jam_operasional');

            $table->unique(['id_klinik', 'id_jam_operasional'], 'klinik_jam_operasional_unique');
            $table->foreign('id_klinik')->references('id_klinik')->on('klinik')->cascadeOnDelete();
            $table->foreign('id_jam_operasional')->references('id_jam_operasional')->on('jam_operasional')->cascadeOnDelete();
        });

        Schema::create('klinik_pengaturan_reservasi', function (Blueprint $table) {
            $table->id('id_klinik_pengaturan_reservasi');
            $table->unsignedBigInteger('id_klinik')->unique();
            $table->unsignedBigInteger('id_pengaturan_reservasi')->unique();

            $table->foreign('id_klinik')->references('id_klinik')->on('klinik')->cascadeOnDelete();
            $table->foreign('id_pengaturan_reservasi')->references('id_pengaturan_reservasi')->on('pengaturan_reservasi')->cascadeOnDelete();
        });

        Schema::create('klinik_banner_promo', function (Blueprint $table) {
            $table->id('id_klinik_banner_promo');
            $table->unsignedBigInteger('id_klinik');
            $table->unsignedBigInteger('id_banner');

            $table->unique(['id_klinik', 'id_banner']);
            $table->foreign('id_klinik')->references('id_klinik')->on('klinik')->cascadeOnDelete();
            $table->foreign('id_banner')->references('id_banner')->on('banner_promo')->cascadeOnDelete();
        });

        Schema::create('klinik_faq', function (Blueprint $table) {
            $table->id('id_klinik_faq');
            $table->unsignedBigInteger('id_klinik');
            $table->unsignedBigInteger('id_faq');

            $table->unique(['id_klinik', 'id_faq']);
            $table->foreign('id_klinik')->references('id_klinik')->on('klinik')->cascadeOnDelete();
            $table->foreign('id_faq')->references('id_faq')->on('faq')->cascadeOnDelete();
        });

        Schema::create('klinik_kontak', function (Blueprint $table) {
            $table->id('id_kontak');
            $table->unsignedBigInteger('id_klinik')->unique();
            $table->string('nomor_telepon', 30)->nullable();
            $table->string('email_klinik')->nullable();

            $table->foreign('id_klinik')->references('id_klinik')->on('klinik')->cascadeOnDelete();
        });

        Schema::create('banner_promo_detail', function (Blueprint $table) {
            $table->id('id_banner_detail');
            $table->unsignedBigInteger('id_banner')->unique();
            $table->string('judul_promo')->nullable();
            $table->text('deskripsi_promo')->nullable();
            $table->date('masa_berlaku_mulai')->nullable();
            $table->date('masa_berlaku_selesai')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->integer('urutan')->default(1);

            $table->foreign('id_banner')->references('id_banner')->on('banner_promo')->cascadeOnDelete();
        });

        Schema::create('faq_pengaturan', function (Blueprint $table) {
            $table->id('id_faq_pengaturan');
            $table->unsignedBigInteger('id_faq')->unique();
            $table->integer('urutan')->default(1);

            $table->foreign('id_faq')->references('id_faq')->on('faq')->cascadeOnDelete();
        });

        Schema::create('reservasi_relasi', function (Blueprint $table) {
            $table->id('id_reservasi_relasi');
            $table->unsignedBigInteger('id_reservasi')->unique();
            $table->unsignedBigInteger('id_pasien');
            $table->unsignedBigInteger('id_dokter');
            $table->unsignedBigInteger('id_layanan');
            $table->unsignedBigInteger('id_jadwal');

            $table->foreign('id_reservasi')->references('id_reservasi')->on('reservasi')->cascadeOnDelete();
            $table->foreign('id_pasien')->references('id_pasien')->on('pasien')->cascadeOnDelete();
            $table->foreign('id_dokter')->references('id_dokter')->on('dokter')->cascadeOnDelete();
            $table->foreign('id_layanan')->references('id_layanan')->on('layanan')->restrictOnDelete();
            $table->foreign('id_jadwal')->references('id_jadwal')->on('jadwal_praktik')->restrictOnDelete();
            $table->index(['id_pasien', 'id_dokter', 'id_layanan', 'id_jadwal'], 'reservasi_relasi_lookup_index');
        });

        Schema::create('reservasi_reschedule', function (Blueprint $table) {
            $table->id('id_reservasi_reschedule');
            $table->unsignedBigInteger('id_reservasi')->unique();
            $table->date('usulan_tanggal_reschedule')->nullable();
            $table->time('usulan_jam_reschedule')->nullable();
            $table->text('catatan_dokter')->nullable();
            $table->string('status_tanggapan_pasien', 40)->nullable();

            $table->foreign('id_reservasi')->references('id_reservasi')->on('reservasi')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi_reschedule');
        Schema::dropIfExists('reservasi_relasi');
        Schema::dropIfExists('faq_pengaturan');
        Schema::dropIfExists('banner_promo_detail');
        Schema::dropIfExists('klinik_kontak');
        Schema::dropIfExists('klinik_faq');
        Schema::dropIfExists('klinik_banner_promo');
        Schema::dropIfExists('klinik_pengaturan_reservasi');
        Schema::dropIfExists('klinik_jam_operasional');
        Schema::dropIfExists('klinik_dokter');
        Schema::dropIfExists('dokter_user');
        Schema::dropIfExists('pasien_user');
    }
};
