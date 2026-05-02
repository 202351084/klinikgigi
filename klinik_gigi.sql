-- SQL Klinik Gigi Cahaya Dental Care

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `klinik_gigi` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `klinik_gigi`;

DROP TABLE IF EXISTS `migrations`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `reservasi_reschedule`;
DROP TABLE IF EXISTS `reservasi_relasi`;
DROP TABLE IF EXISTS `faq_pengaturan`;
DROP TABLE IF EXISTS `banner_promo_detail`;
DROP TABLE IF EXISTS `klinik_kontak`;
DROP TABLE IF EXISTS `klinik_faq`;
DROP TABLE IF EXISTS `klinik_banner_promo`;
DROP TABLE IF EXISTS `klinik_pengaturan_reservasi`;
DROP TABLE IF EXISTS `klinik_jam_operasional`;
DROP TABLE IF EXISTS `klinik_dokter`;
DROP TABLE IF EXISTS `dokter_user`;
DROP TABLE IF EXISTS `pasien_user`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `reservasi`;
DROP TABLE IF EXISTS `jadwal_praktik`;
DROP TABLE IF EXISTS `layanan`;
DROP TABLE IF EXISTS `faq`;
DROP TABLE IF EXISTS `banner_promo`;
DROP TABLE IF EXISTS `pengaturan_reservasi`;
DROP TABLE IF EXISTS `jam_operasional`;
DROP TABLE IF EXISTS `dokter`;
DROP TABLE IF EXISTS `pasien`;
DROP TABLE IF EXISTS `klinik`;

CREATE TABLE `klinik` (
  `id_klinik` INT NOT NULL AUTO_INCREMENT,
  `nama_klinik` VARCHAR(255) NOT NULL,
  `logo_klinik` VARCHAR(255) DEFAULT NULL,
  `deskripsi_singkat` TEXT DEFAULT NULL,
  `alamat` TEXT DEFAULT NULL,
  `nomor_whatsapp` VARCHAR(30) DEFAULT NULL,
  PRIMARY KEY (`id_klinik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pasien` (
  `id_pasien` INT NOT NULL AUTO_INCREMENT,
  `nama_pasien` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `nomor_hp` VARCHAR(30) NOT NULL,
  `alamat` TEXT DEFAULT NULL,
  PRIMARY KEY (`id_pasien`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `dokter` (
  `id_dokter` INT NOT NULL AUTO_INCREMENT,
  `nama_dokter` VARCHAR(255) NOT NULL,
  `foto_dokter` VARCHAR(255) DEFAULT NULL,
  `gelar` VARCHAR(255) DEFAULT NULL,
  `keterangan` TEXT DEFAULT NULL,
  PRIMARY KEY (`id_dokter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jam_operasional` (
  `id_jam_operasional` INT NOT NULL AUTO_INCREMENT,
  `hari_buka` VARCHAR(20) NOT NULL,
  `jam_buka` TIME DEFAULT NULL,
  `jam_tutup` TIME DEFAULT NULL,
  `hari_libur` VARCHAR(20) DEFAULT NULL,
  PRIMARY KEY (`id_jam_operasional`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pengaturan_reservasi` (
  `id_pengaturan_reservasi` INT NOT NULL AUTO_INCREMENT,
  `batas_maksimal_booking_per_hari` INT NOT NULL,
  `interval_slot_per_jam` INT NOT NULL,
  `hari_booking_ke_depan` INT NOT NULL,
  `pasien_bisa_reschedule_sendiri` BOOLEAN NOT NULL,
  PRIMARY KEY (`id_pengaturan_reservasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `banner_promo` (
  `id_banner` INT NOT NULL AUTO_INCREMENT,
  `gambar_banner_promo` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id_banner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `faq` (
  `id_faq` INT NOT NULL AUTO_INCREMENT,
  `pertanyaan` VARCHAR(255) NOT NULL,
  `jawaban` TEXT NOT NULL,
  `status_tampil` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id_faq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `layanan` (
  `id_layanan` INT NOT NULL AUTO_INCREMENT,
  `nama_layanan` VARCHAR(255) NOT NULL,
  `gambar_layanan` VARCHAR(255) DEFAULT NULL,
  `deskripsi_layanan` TEXT DEFAULT NULL,
  `harga_estimasi_biaya` DECIMAL(12,2) NOT NULL,
  `durasi_layanan` INT NOT NULL,
  `status_layanan` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id_layanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jadwal_praktik` (
  `id_jadwal` INT NOT NULL AUTO_INCREMENT,
  `tanggal` DATE NOT NULL,
  `jam_praktik` TIME NOT NULL,
  `status_slot` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id_jadwal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `reservasi` (
  `id_reservasi` INT NOT NULL AUTO_INCREMENT,
  `kode_reservasi` VARCHAR(50) NOT NULL,
  `tanggal_reservasi` DATE NOT NULL,
  `jam_kunjungan` TIME NOT NULL,
  `keluhan_pasien` TEXT NOT NULL,
  `status_reservasi` VARCHAR(40) NOT NULL,
  `metode_pembayaran` VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (`id_reservasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(20) NOT NULL DEFAULT 'patient',
  `phone` VARCHAR(30) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `is_active` BOOLEAN NOT NULL DEFAULT TRUE,
  `remember_token` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pasien_user` (
  `id_pasien_user` INT NOT NULL AUTO_INCREMENT,
  `id_pasien` INT NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_pasien_user`),
  UNIQUE KEY `pasien_user_id_pasien_unique` (`id_pasien`),
  UNIQUE KEY `pasien_user_user_id_unique` (`user_id`),
  CONSTRAINT `pasien_user_id_pasien_foreign` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE,
  CONSTRAINT `pasien_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `dokter_user` (
  `id_dokter_user` INT NOT NULL AUTO_INCREMENT,
  `id_dokter` INT NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_dokter_user`),
  UNIQUE KEY `dokter_user_id_dokter_unique` (`id_dokter`),
  UNIQUE KEY `dokter_user_user_id_unique` (`user_id`),
  CONSTRAINT `dokter_user_id_dokter_foreign` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE CASCADE,
  CONSTRAINT `dokter_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `klinik_dokter` (
  `id_klinik_dokter` INT NOT NULL AUTO_INCREMENT,
  `id_klinik` INT NOT NULL,
  `id_dokter` INT NOT NULL,
  PRIMARY KEY (`id_klinik_dokter`),
  UNIQUE KEY `klinik_dokter_unique` (`id_klinik`, `id_dokter`),
  CONSTRAINT `klinik_dokter_id_klinik_foreign` FOREIGN KEY (`id_klinik`) REFERENCES `klinik` (`id_klinik`) ON DELETE CASCADE,
  CONSTRAINT `klinik_dokter_id_dokter_foreign` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `klinik_jam_operasional` (
  `id_klinik_jam_operasional` INT NOT NULL AUTO_INCREMENT,
  `id_klinik` INT NOT NULL,
  `id_jam_operasional` INT NOT NULL,
  PRIMARY KEY (`id_klinik_jam_operasional`),
  UNIQUE KEY `klinik_jam_operasional_unique` (`id_klinik`, `id_jam_operasional`),
  CONSTRAINT `klinik_jam_operasional_id_klinik_foreign` FOREIGN KEY (`id_klinik`) REFERENCES `klinik` (`id_klinik`) ON DELETE CASCADE,
  CONSTRAINT `klinik_jam_operasional_id_jam_foreign` FOREIGN KEY (`id_jam_operasional`) REFERENCES `jam_operasional` (`id_jam_operasional`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `klinik_pengaturan_reservasi` (
  `id_klinik_pengaturan_reservasi` INT NOT NULL AUTO_INCREMENT,
  `id_klinik` INT NOT NULL,
  `id_pengaturan_reservasi` INT NOT NULL,
  PRIMARY KEY (`id_klinik_pengaturan_reservasi`),
  UNIQUE KEY `klinik_pengaturan_reservasi_id_klinik_unique` (`id_klinik`),
  UNIQUE KEY `klinik_pengaturan_reservasi_id_pengaturan_unique` (`id_pengaturan_reservasi`),
  CONSTRAINT `klinik_pengaturan_reservasi_id_klinik_foreign` FOREIGN KEY (`id_klinik`) REFERENCES `klinik` (`id_klinik`) ON DELETE CASCADE,
  CONSTRAINT `klinik_pengaturan_reservasi_id_pengaturan_foreign` FOREIGN KEY (`id_pengaturan_reservasi`) REFERENCES `pengaturan_reservasi` (`id_pengaturan_reservasi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `klinik_banner_promo` (
  `id_klinik_banner_promo` INT NOT NULL AUTO_INCREMENT,
  `id_klinik` INT NOT NULL,
  `id_banner` INT NOT NULL,
  PRIMARY KEY (`id_klinik_banner_promo`),
  UNIQUE KEY `klinik_banner_promo_unique` (`id_klinik`, `id_banner`),
  CONSTRAINT `klinik_banner_promo_id_klinik_foreign` FOREIGN KEY (`id_klinik`) REFERENCES `klinik` (`id_klinik`) ON DELETE CASCADE,
  CONSTRAINT `klinik_banner_promo_id_banner_foreign` FOREIGN KEY (`id_banner`) REFERENCES `banner_promo` (`id_banner`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `klinik_faq` (
  `id_klinik_faq` INT NOT NULL AUTO_INCREMENT,
  `id_klinik` INT NOT NULL,
  `id_faq` INT NOT NULL,
  PRIMARY KEY (`id_klinik_faq`),
  UNIQUE KEY `klinik_faq_unique` (`id_klinik`, `id_faq`),
  CONSTRAINT `klinik_faq_id_klinik_foreign` FOREIGN KEY (`id_klinik`) REFERENCES `klinik` (`id_klinik`) ON DELETE CASCADE,
  CONSTRAINT `klinik_faq_id_faq_foreign` FOREIGN KEY (`id_faq`) REFERENCES `faq` (`id_faq`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `klinik_kontak` (
  `id_kontak` INT NOT NULL AUTO_INCREMENT,
  `id_klinik` INT NOT NULL,
  `nomor_telepon` VARCHAR(30) DEFAULT NULL,
  `email_klinik` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id_kontak`),
  UNIQUE KEY `klinik_kontak_id_klinik_unique` (`id_klinik`),
  CONSTRAINT `klinik_kontak_id_klinik_foreign` FOREIGN KEY (`id_klinik`) REFERENCES `klinik` (`id_klinik`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `banner_promo_detail` (
  `id_banner_detail` INT NOT NULL AUTO_INCREMENT,
  `id_banner` INT NOT NULL,
  `judul_promo` VARCHAR(255) DEFAULT NULL,
  `deskripsi_promo` TEXT DEFAULT NULL,
  `masa_berlaku_mulai` DATE DEFAULT NULL,
  `masa_berlaku_selesai` DATE DEFAULT NULL,
  `status_aktif` BOOLEAN NOT NULL DEFAULT TRUE,
  `urutan` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_banner_detail`),
  UNIQUE KEY `banner_promo_detail_id_banner_unique` (`id_banner`),
  CONSTRAINT `banner_promo_detail_id_banner_foreign` FOREIGN KEY (`id_banner`) REFERENCES `banner_promo` (`id_banner`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `faq_pengaturan` (
  `id_faq_pengaturan` INT NOT NULL AUTO_INCREMENT,
  `id_faq` INT NOT NULL,
  `urutan` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_faq_pengaturan`),
  UNIQUE KEY `faq_pengaturan_id_faq_unique` (`id_faq`),
  CONSTRAINT `faq_pengaturan_id_faq_foreign` FOREIGN KEY (`id_faq`) REFERENCES `faq` (`id_faq`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `reservasi_relasi` (
  `id_reservasi_relasi` INT NOT NULL AUTO_INCREMENT,
  `id_reservasi` INT NOT NULL,
  `id_pasien` INT NOT NULL,
  `id_dokter` INT NOT NULL,
  `id_layanan` INT NOT NULL,
  `id_jadwal` INT NOT NULL,
  PRIMARY KEY (`id_reservasi_relasi`),
  UNIQUE KEY `reservasi_relasi_id_reservasi_unique` (`id_reservasi`),
  KEY `reservasi_relasi_id_pasien_index` (`id_pasien`),
  KEY `reservasi_relasi_id_dokter_index` (`id_dokter`),
  KEY `reservasi_relasi_id_layanan_index` (`id_layanan`),
  KEY `reservasi_relasi_id_jadwal_index` (`id_jadwal`),
  CONSTRAINT `reservasi_relasi_id_reservasi_foreign` FOREIGN KEY (`id_reservasi`) REFERENCES `reservasi` (`id_reservasi`) ON DELETE CASCADE,
  CONSTRAINT `reservasi_relasi_id_pasien_foreign` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE,
  CONSTRAINT `reservasi_relasi_id_dokter_foreign` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE CASCADE,
  CONSTRAINT `reservasi_relasi_id_layanan_foreign` FOREIGN KEY (`id_layanan`) REFERENCES `layanan` (`id_layanan`) ON DELETE RESTRICT,
  CONSTRAINT `reservasi_relasi_id_jadwal_foreign` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_praktik` (`id_jadwal`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `reservasi_reschedule` (
  `id_reservasi_reschedule` INT NOT NULL AUTO_INCREMENT,
  `id_reservasi` INT NOT NULL,
  `usulan_tanggal_reschedule` DATE DEFAULT NULL,
  `usulan_jam_reschedule` TIME DEFAULT NULL,
  `catatan_dokter` TEXT DEFAULT NULL,
  `status_tanggapan_pasien` VARCHAR(40) DEFAULT NULL,
  PRIMARY KEY (`id_reservasi_reschedule`),
  UNIQUE KEY `reservasi_reschedule_id_reservasi_unique` (`id_reservasi`),
  CONSTRAINT `reservasi_reschedule_id_reservasi_foreign` FOREIGN KEY (`id_reservasi`) REFERENCES `reservasi` (`id_reservasi`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id` VARCHAR(255) NOT NULL,
  `user_id` BIGINT UNSIGNED DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `user_agent` TEXT DEFAULT NULL,
  `payload` LONGTEXT NOT NULL,
  `last_activity` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache` (
  `key` VARCHAR(255) NOT NULL,
  `value` MEDIUMTEXT NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` VARCHAR(255) NOT NULL,
  `owner` VARCHAR(255) NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` VARCHAR(255) NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `attempts` TINYINT UNSIGNED NOT NULL,
  `reserved_at` INT UNSIGNED DEFAULT NULL,
  `available_at` INT UNSIGNED NOT NULL,
  `created_at` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `total_jobs` INT NOT NULL,
  `pending_jobs` INT NOT NULL,
  `failed_jobs` INT NOT NULL,
  `failed_job_ids` LONGTEXT NOT NULL,
  `options` MEDIUMTEXT DEFAULT NULL,
  `cancelled_at` INT DEFAULT NULL,
  `created_at` INT NOT NULL,
  `finished_at` INT DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL,
  `connection` TEXT NOT NULL,
  `queue` TEXT NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `migrations` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;
