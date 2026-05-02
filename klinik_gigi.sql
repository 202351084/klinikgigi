-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2026 at 02:44 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klinik_gigi`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner_promo`
--

CREATE TABLE `banner_promo` (
  `id_banner` bigint(20) UNSIGNED NOT NULL,
  `gambar_banner_promo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banner_promo_detail`
--

CREATE TABLE `banner_promo_detail` (
  `id_banner_detail` bigint(20) UNSIGNED NOT NULL,
  `id_banner` bigint(20) UNSIGNED NOT NULL,
  `judul_promo` varchar(255) DEFAULT NULL,
  `deskripsi_promo` text DEFAULT NULL,
  `masa_berlaku_mulai` date DEFAULT NULL,
  `masa_berlaku_selesai` date DEFAULT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `urutan` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id_dokter` bigint(20) UNSIGNED NOT NULL,
  `nama_dokter` varchar(255) NOT NULL,
  `foto_dokter` varchar(255) DEFAULT NULL,
  `gelar` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id_dokter`, `nama_dokter`, `foto_dokter`, `gelar`, `keterangan`) VALUES
(1, 'Drg. Cahaya', NULL, 'drg.', 'Dokter gigi utama yang menangani pemeriksaan, konsultasi, tindakan dasar, dan edukasi kesehatan gigi keluarga.');

-- --------------------------------------------------------

--
-- Table structure for table `dokter_user`
--

CREATE TABLE `dokter_user` (
  `id_dokter_user` bigint(20) UNSIGNED NOT NULL,
  `id_dokter` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dokter_user`
--

INSERT INTO `dokter_user` (`id_dokter_user`, `id_dokter`, `user_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id_faq` bigint(20) UNSIGNED NOT NULL,
  `pertanyaan` varchar(255) NOT NULL,
  `jawaban` text NOT NULL,
  `status_tampil` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id_faq`, `pertanyaan`, `jawaban`, `status_tampil`) VALUES
(1, 'Apakah harus membuat reservasi sebelum datang?', 'Disarankan membuat reservasi terlebih dahulu agar jadwal kunjungan lebih tertata dan pasien tidak menunggu terlalu lama.', 'aktif'),
(2, 'Apakah klinik melayani pasien anak?', 'Ya, klinik melayani perawatan dasar gigi anak dengan pendekatan yang ramah dan nyaman.', 'aktif'),
(3, 'Bagaimana cara membatalkan reservasi?', 'Pasien dapat masuk ke akun pasien, membuka menu Reservasi Saya, lalu membatalkan reservasi yang masih bisa dibatalkan.', 'aktif'),
(4, 'Apakah biaya layanan pasti sama dengan estimasi?', 'Biaya yang tampil adalah estimasi. Biaya akhir dapat berubah sesuai kondisi gigi dan tindakan yang diperlukan setelah pemeriksaan.', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `faq_pengaturan`
--

CREATE TABLE `faq_pengaturan` (
  `id_faq_pengaturan` bigint(20) UNSIGNED NOT NULL,
  `id_faq` bigint(20) UNSIGNED NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faq_pengaturan`
--

INSERT INTO `faq_pengaturan` (`id_faq_pengaturan`, `id_faq`, `urutan`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_praktik`
--

CREATE TABLE `jadwal_praktik` (
  `id_jadwal` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_praktik` time NOT NULL,
  `status_slot` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jam_operasional`
--

CREATE TABLE `jam_operasional` (
  `id_jam_operasional` bigint(20) UNSIGNED NOT NULL,
  `hari_buka` varchar(20) NOT NULL,
  `jam_buka` time DEFAULT NULL,
  `jam_tutup` time DEFAULT NULL,
  `hari_libur` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jam_operasional`
--

INSERT INTO `jam_operasional` (`id_jam_operasional`, `hari_buka`, `jam_buka`, `jam_tutup`, `hari_libur`) VALUES
(1, 'senin', '09:00:00', '17:00:00', NULL),
(2, 'selasa', '09:00:00', '17:00:00', NULL),
(3, 'rabu', '09:00:00', '17:00:00', NULL),
(4, 'kamis', '09:00:00', '17:00:00', NULL),
(5, 'jumat', '09:00:00', '17:00:00', NULL),
(6, 'sabtu', '09:00:00', '15:00:00', NULL),
(7, 'minggu', NULL, NULL, 'libur');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `klinik`
--

CREATE TABLE `klinik` (
  `id_klinik` bigint(20) UNSIGNED NOT NULL,
  `nama_klinik` varchar(255) NOT NULL,
  `logo_klinik` varchar(255) DEFAULT NULL,
  `deskripsi_singkat` text DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `nomor_whatsapp` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `klinik`
--

INSERT INTO `klinik` (`id_klinik`, `nama_klinik`, `logo_klinik`, `deskripsi_singkat`, `alamat`, `nomor_whatsapp`) VALUES
(1, 'Cahaya Dental Care', NULL, 'Klinik gigi untuk anak, dewasa, dan lansia dengan layanan reservasi online yang sederhana.', 'Jl. Contoh No. 123, Jakarta', '081234567890');

-- --------------------------------------------------------

--
-- Table structure for table `klinik_banner_promo`
--

CREATE TABLE `klinik_banner_promo` (
  `id_klinik_banner_promo` bigint(20) UNSIGNED NOT NULL,
  `id_klinik` bigint(20) UNSIGNED NOT NULL,
  `id_banner` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `klinik_dokter`
--

CREATE TABLE `klinik_dokter` (
  `id_klinik_dokter` bigint(20) UNSIGNED NOT NULL,
  `id_klinik` bigint(20) UNSIGNED NOT NULL,
  `id_dokter` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `klinik_dokter`
--

INSERT INTO `klinik_dokter` (`id_klinik_dokter`, `id_klinik`, `id_dokter`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `klinik_faq`
--

CREATE TABLE `klinik_faq` (
  `id_klinik_faq` bigint(20) UNSIGNED NOT NULL,
  `id_klinik` bigint(20) UNSIGNED NOT NULL,
  `id_faq` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `klinik_faq`
--

INSERT INTO `klinik_faq` (`id_klinik_faq`, `id_klinik`, `id_faq`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `klinik_jam_operasional`
--

CREATE TABLE `klinik_jam_operasional` (
  `id_klinik_jam_operasional` bigint(20) UNSIGNED NOT NULL,
  `id_klinik` bigint(20) UNSIGNED NOT NULL,
  `id_jam_operasional` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `klinik_jam_operasional`
--

INSERT INTO `klinik_jam_operasional` (`id_klinik_jam_operasional`, `id_klinik`, `id_jam_operasional`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `klinik_kontak`
--

CREATE TABLE `klinik_kontak` (
  `id_kontak` bigint(20) UNSIGNED NOT NULL,
  `id_klinik` bigint(20) UNSIGNED NOT NULL,
  `nomor_telepon` varchar(30) DEFAULT NULL,
  `email_klinik` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `klinik_kontak`
--

INSERT INTO `klinik_kontak` (`id_kontak`, `id_klinik`, `nomor_telepon`, `email_klinik`) VALUES
(1, 1, '081234567890', 'halo@cahayadental.com');

-- --------------------------------------------------------

--
-- Table structure for table `klinik_pengaturan_reservasi`
--

CREATE TABLE `klinik_pengaturan_reservasi` (
  `id_klinik_pengaturan_reservasi` bigint(20) UNSIGNED NOT NULL,
  `id_klinik` bigint(20) UNSIGNED NOT NULL,
  `id_pengaturan_reservasi` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `klinik_pengaturan_reservasi`
--

INSERT INTO `klinik_pengaturan_reservasi` (`id_klinik_pengaturan_reservasi`, `id_klinik`, `id_pengaturan_reservasi`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id_layanan` bigint(20) UNSIGNED NOT NULL,
  `nama_layanan` varchar(255) NOT NULL,
  `gambar_layanan` varchar(255) DEFAULT NULL,
  `deskripsi_layanan` text DEFAULT NULL,
  `harga_estimasi_biaya` decimal(12,2) NOT NULL,
  `durasi_layanan` int(11) NOT NULL,
  `status_layanan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id_layanan`, `nama_layanan`, `gambar_layanan`, `deskripsi_layanan`, `harga_estimasi_biaya`, `durasi_layanan`, `status_layanan`) VALUES
(1, 'Pemeriksaan dan Konsultasi Gigi', NULL, 'Pemeriksaan kondisi gigi dan mulut secara umum disertai konsultasi tindakan yang sesuai kebutuhan pasien.', 100000.00, 30, 'aktif'),
(2, 'Tambal Gigi', NULL, 'Perawatan gigi berlubang ringan hingga sedang dengan bahan tambal sesuai indikasi.', 250000.00, 45, 'aktif'),
(3, 'Scaling', NULL, 'Pembersihan karang gigi dan plak untuk menjaga kesehatan gusi dan mulut.', 300000.00, 45, 'aktif'),
(4, 'Cabut Gigi Biasa', NULL, 'Tindakan pencabutan gigi dengan indikasi sederhana setelah pemeriksaan dokter.', 300000.00, 45, 'aktif'),
(5, 'Perawatan Gusi Ringan', NULL, 'Penanganan awal pada keluhan gusi seperti bengkak ringan, iritasi, atau pembersihan area gusi.', 275000.00, 40, 'aktif'),
(6, 'Penanganan Sakit Gigi dan Infeksi Ringan', NULL, 'Pemeriksaan dan penanganan awal keluhan nyeri gigi atau infeksi ringan untuk mengurangi keluhan pasien.', 200000.00, 30, 'aktif'),
(7, 'Perawatan Saluran Akar Sederhana', NULL, 'Perawatan awal saluran akar sederhana berdasarkan kondisi dan indikasi klinis.', 750000.00, 60, 'aktif'),
(8, 'Bleaching Gigi', NULL, 'Perawatan estetika untuk membantu mencerahkan warna gigi dengan prosedur yang aman dan terkontrol.', 1200000.00, 60, 'aktif'),
(9, 'Perawatan Gigi Anak Dasar', NULL, 'Pemeriksaan dan tindakan dasar untuk pasien anak dengan pendekatan yang lebih nyaman dan ramah.', 220000.00, 30, 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_22_100000_add_clinic_fields_to_users_table', 1),
(5, '2026_04_22_100100_create_clinic_settings_table', 1),
(6, '2026_04_22_100200_create_operational_hours_table', 1),
(7, '2026_04_22_100300_create_services_table', 1),
(8, '2026_04_22_100400_create_banners_table', 1),
(9, '2026_04_22_110000_create_klinik_table', 1),
(10, '2026_04_22_110100_create_pasien_table', 1),
(11, '2026_04_22_110200_create_dokter_table', 1),
(12, '2026_04_22_110300_create_pengaturan_reservasi_table', 1),
(13, '2026_04_22_110400_create_jam_operasional_table', 1),
(14, '2026_04_22_110500_create_banner_promo_table', 1),
(15, '2026_04_22_110600_create_faq_table', 1),
(16, '2026_04_22_110700_create_layanan_table', 1),
(17, '2026_04_22_110800_create_jadwal_praktik_table', 1),
(18, '2026_04_22_110900_create_reservasi_table', 1),
(19, '2026_04_22_111000_add_public_content_fields', 1),
(20, '2026_04_29_120000_drop_unique_index_from_reservasi_id_jadwal', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id_pasien` bigint(20) UNSIGNED NOT NULL,
  `nama_pasien` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nomor_hp` varchar(30) NOT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id_pasien`, `nama_pasien`, `email`, `nomor_hp`, `alamat`) VALUES
(1, 'Budi Santoso', 'budi.pasien@test.com', '081298765401', 'Jl. Melati No. 12, Jakarta'),
(2, 'Siti Rahma', 'siti.pasien@test.com', '081298765402', 'Jl. Kenanga No. 8, Depok'),
(3, 'Andi Pratama', 'andi.pasien@test.com', '081298765403', 'Jl. Mawar No. 21, Bekasi'),
(4, 'Dewi Lestari', 'dewi.pasien@test.com', '081298765404', 'Jl. Anggrek No. 5, Tangerang'),
(5, 'Rizky Hidayat', 'rizky.pasien@test.com', '081298765405', 'Jl. Dahlia No. 17, Bogor');

-- --------------------------------------------------------

--
-- Table structure for table `pasien_user`
--

CREATE TABLE `pasien_user` (
  `id_pasien_user` bigint(20) UNSIGNED NOT NULL,
  `id_pasien` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pasien_user`
--

INSERT INTO `pasien_user` (`id_pasien_user`, `id_pasien`, `user_id`) VALUES
(1, 1, 2),
(2, 2, 3),
(3, 3, 4),
(4, 4, 5),
(5, 5, 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan_reservasi`
--

CREATE TABLE `pengaturan_reservasi` (
  `id_pengaturan_reservasi` bigint(20) UNSIGNED NOT NULL,
  `batas_maksimal_booking_per_hari` int(11) NOT NULL,
  `interval_slot_per_jam` int(11) NOT NULL,
  `hari_booking_ke_depan` int(11) NOT NULL,
  `pasien_bisa_reschedule_sendiri` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaturan_reservasi`
--

INSERT INTO `pengaturan_reservasi` (`id_pengaturan_reservasi`, `batas_maksimal_booking_per_hari`, `interval_slot_per_jam`, `hari_booking_ke_depan`, `pasien_bisa_reschedule_sendiri`) VALUES
(1, 20, 30, 30, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reservasi`
--

CREATE TABLE `reservasi` (
  `id_reservasi` bigint(20) UNSIGNED NOT NULL,
  `kode_reservasi` varchar(50) NOT NULL,
  `tanggal_reservasi` date NOT NULL,
  `jam_kunjungan` time NOT NULL,
  `keluhan_pasien` text NOT NULL,
  `status_reservasi` varchar(40) NOT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservasi_relasi`
--

CREATE TABLE `reservasi_relasi` (
  `id_reservasi_relasi` bigint(20) UNSIGNED NOT NULL,
  `id_reservasi` bigint(20) UNSIGNED NOT NULL,
  `id_pasien` bigint(20) UNSIGNED NOT NULL,
  `id_dokter` bigint(20) UNSIGNED NOT NULL,
  `id_layanan` bigint(20) UNSIGNED NOT NULL,
  `id_jadwal` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservasi_reschedule`
--

CREATE TABLE `reservasi_reschedule` (
  `id_reservasi_reschedule` bigint(20) UNSIGNED NOT NULL,
  `id_reservasi` bigint(20) UNSIGNED NOT NULL,
  `usulan_tanggal_reschedule` date DEFAULT NULL,
  `usulan_jam_reschedule` time DEFAULT NULL,
  `catatan_dokter` text DEFAULT NULL,
  `status_tanggapan_pasien` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1zW3mFMRLNJPwH9mPvxSvvz8OM02zrHq3l4zdche', NULL, '127.0.0.1', 'Symfony', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNmZlOGN3NVJoNDBXZFRUaXdBb1BzdVBnQVVGNmRpcDMxWmM0T2E3YyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czoxMToicHVibGljLmhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1777678382),
('63uX7Ge1rIdFcyq8wLJHr2SpkGWFBTxL1WFaulHK', NULL, '127.0.0.1', 'Symfony', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTE52VTNkSkdIdDYxQkxnTFdIUkRabkpHTUhtS1VsMmN0djhiNnhmeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly9sb2NhbGhvc3QiO3M6NToicm91dGUiO3M6MTE6InB1YmxpYy5ob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777678101),
('HZkGWQ5VkAWgEYz8gSYcg7Rf9jh223lDpIbHrxZ7', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiN2VsUUlYdzN3ZDQwcHRwOVRQcFJ4a3hISnFQclVmdEExR2FwRGIxSCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3Bhc2llbiI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvcGFzaWVuIjtzOjU6InJvdXRlIjtzOjE2OiJwYXNpZW4uZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1777678874),
('ihxY5fyN57rviT66NikLQI1u7CcQI5ZK61sPHVzZ', NULL, '127.0.0.1', 'Symfony', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZzNEWHFnaFpIZWRiakp1SGNsR2xybktOMElsQzhNWW5NTkJnWU9ERyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly9sb2NhbGhvc3QiO3M6NToicm91dGUiO3M6MTE6InB1YmxpYy5ob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777678340),
('j0eEPDZshpUFU6lNGZf36QO2uotE2zqjIIBgYzHZ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVnFFdVZOcFFXRGhRQlhDbmJnRVhLbHFGY1g1ZndnWnNOazB6UkliWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kb2t0ZXIiO3M6NToicm91dGUiO3M6MTY6ImRvY3Rvci5kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjI4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvcGFzaWVuIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1777679279),
('sg7ItOMxrLQjkAyUrXwgwsKO2CzTpPq3RHL3F10J', NULL, '127.0.0.1', 'Symfony', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR2s1ZlFmdjU0NkFSYmV4UXRpSFEwMTJqZ2VsbGxlcWdJamJnYnh2ZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly9sb2NhbGhvc3QiO3M6NToicm91dGUiO3M6MTE6InB1YmxpYy5ob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777678370);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'patient',
  `phone` varchar(30) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `phone`, `address`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Drg. Cahaya', 'doctor@cahayadental.test', NULL, '$2y$12$rG1DM3TJVGnamQZ9Q0GkDeR9eGZMusmnxCl/Wrg1TlVbGzyPNiWTW', 'doctor', '081234567890', NULL, 1, NULL, '2026-05-01 23:28:06', '2026-05-01 23:30:56'),
(2, 'Budi Santoso', 'budi.pasien@test.com', NULL, '$2y$12$S.hNYPUroWweab1Gmam0yedP6pCKpGnkxfLlzQIy6FY6NFZRSQXBO', 'patient', '081298765401', 'Jl. Melati No. 12, Jakarta', 1, NULL, '2026-05-01 23:28:07', '2026-05-01 23:28:07'),
(3, 'Siti Rahma', 'siti.pasien@test.com', NULL, '$2y$12$fDBSgTgiqMpdFt3xvD79LOYGp99SfQ36jvWeI4tx7qBKDQs7iarcq', 'patient', '081298765402', 'Jl. Kenanga No. 8, Depok', 1, NULL, '2026-05-01 23:28:07', '2026-05-01 23:33:49'),
(4, 'Andi Pratama', 'andi.pasien@test.com', NULL, '$2y$12$sOA24mlEsl6QjiLc1Nf.burC3WisRA9RJEFU0XFP8wXE4hWM9Ir2C', 'patient', '081298765403', 'Jl. Mawar No. 21, Bekasi', 1, NULL, '2026-05-01 23:28:08', '2026-05-01 23:28:08'),
(5, 'Dewi Lestari', 'dewi.pasien@test.com', NULL, '$2y$12$Owzb3i6kKDfr1o1TX6hTZu1ixlM./5IsZl2xkUjpxTv8LhT6nTjZu', 'patient', '081298765404', 'Jl. Anggrek No. 5, Tangerang', 1, NULL, '2026-05-01 23:28:08', '2026-05-01 23:28:08'),
(6, 'Rizky Hidayat', 'rizky.pasien@test.com', NULL, '$2y$12$8.jaIUkZLDSnSUMvG8aXHu02urkvMmxRgUQbxTVv32aWeD0a9Hbr2', 'patient', '081298765405', 'Jl. Dahlia No. 17, Bogor', 1, NULL, '2026-05-01 23:28:08', '2026-05-01 23:28:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner_promo`
--
ALTER TABLE `banner_promo`
  ADD PRIMARY KEY (`id_banner`);

--
-- Indexes for table `banner_promo_detail`
--
ALTER TABLE `banner_promo_detail`
  ADD PRIMARY KEY (`id_banner_detail`),
  ADD UNIQUE KEY `banner_promo_detail_id_banner_unique` (`id_banner`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id_dokter`);

--
-- Indexes for table `dokter_user`
--
ALTER TABLE `dokter_user`
  ADD PRIMARY KEY (`id_dokter_user`),
  ADD UNIQUE KEY `dokter_user_id_dokter_unique` (`id_dokter`),
  ADD UNIQUE KEY `dokter_user_user_id_unique` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id_faq`);

--
-- Indexes for table `faq_pengaturan`
--
ALTER TABLE `faq_pengaturan`
  ADD PRIMARY KEY (`id_faq_pengaturan`),
  ADD UNIQUE KEY `faq_pengaturan_id_faq_unique` (`id_faq`);

--
-- Indexes for table `jadwal_praktik`
--
ALTER TABLE `jadwal_praktik`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `jam_operasional`
--
ALTER TABLE `jam_operasional`
  ADD PRIMARY KEY (`id_jam_operasional`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `klinik`
--
ALTER TABLE `klinik`
  ADD PRIMARY KEY (`id_klinik`);

--
-- Indexes for table `klinik_banner_promo`
--
ALTER TABLE `klinik_banner_promo`
  ADD PRIMARY KEY (`id_klinik_banner_promo`),
  ADD UNIQUE KEY `klinik_banner_promo_id_klinik_id_banner_unique` (`id_klinik`,`id_banner`),
  ADD KEY `klinik_banner_promo_id_banner_foreign` (`id_banner`);

--
-- Indexes for table `klinik_dokter`
--
ALTER TABLE `klinik_dokter`
  ADD PRIMARY KEY (`id_klinik_dokter`),
  ADD UNIQUE KEY `klinik_dokter_id_klinik_id_dokter_unique` (`id_klinik`,`id_dokter`),
  ADD KEY `klinik_dokter_id_dokter_foreign` (`id_dokter`);

--
-- Indexes for table `klinik_faq`
--
ALTER TABLE `klinik_faq`
  ADD PRIMARY KEY (`id_klinik_faq`),
  ADD UNIQUE KEY `klinik_faq_id_klinik_id_faq_unique` (`id_klinik`,`id_faq`),
  ADD KEY `klinik_faq_id_faq_foreign` (`id_faq`);

--
-- Indexes for table `klinik_jam_operasional`
--
ALTER TABLE `klinik_jam_operasional`
  ADD PRIMARY KEY (`id_klinik_jam_operasional`),
  ADD UNIQUE KEY `klinik_jam_operasional_unique` (`id_klinik`,`id_jam_operasional`),
  ADD KEY `klinik_jam_operasional_id_jam_operasional_foreign` (`id_jam_operasional`);

--
-- Indexes for table `klinik_kontak`
--
ALTER TABLE `klinik_kontak`
  ADD PRIMARY KEY (`id_kontak`),
  ADD UNIQUE KEY `klinik_kontak_id_klinik_unique` (`id_klinik`);

--
-- Indexes for table `klinik_pengaturan_reservasi`
--
ALTER TABLE `klinik_pengaturan_reservasi`
  ADD PRIMARY KEY (`id_klinik_pengaturan_reservasi`),
  ADD UNIQUE KEY `klinik_pengaturan_reservasi_id_klinik_unique` (`id_klinik`),
  ADD UNIQUE KEY `klinik_pengaturan_reservasi_id_pengaturan_reservasi_unique` (`id_pengaturan_reservasi`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id_layanan`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`),
  ADD UNIQUE KEY `pasien_email_unique` (`email`);

--
-- Indexes for table `pasien_user`
--
ALTER TABLE `pasien_user`
  ADD PRIMARY KEY (`id_pasien_user`),
  ADD UNIQUE KEY `pasien_user_id_pasien_unique` (`id_pasien`),
  ADD UNIQUE KEY `pasien_user_user_id_unique` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengaturan_reservasi`
--
ALTER TABLE `pengaturan_reservasi`
  ADD PRIMARY KEY (`id_pengaturan_reservasi`);

--
-- Indexes for table `reservasi`
--
ALTER TABLE `reservasi`
  ADD PRIMARY KEY (`id_reservasi`);

--
-- Indexes for table `reservasi_relasi`
--
ALTER TABLE `reservasi_relasi`
  ADD PRIMARY KEY (`id_reservasi_relasi`),
  ADD UNIQUE KEY `reservasi_relasi_id_reservasi_unique` (`id_reservasi`),
  ADD KEY `reservasi_relasi_id_dokter_foreign` (`id_dokter`),
  ADD KEY `reservasi_relasi_id_layanan_foreign` (`id_layanan`),
  ADD KEY `reservasi_relasi_id_jadwal_foreign` (`id_jadwal`),
  ADD KEY `reservasi_relasi_lookup_index` (`id_pasien`,`id_dokter`,`id_layanan`,`id_jadwal`);

--
-- Indexes for table `reservasi_reschedule`
--
ALTER TABLE `reservasi_reschedule`
  ADD PRIMARY KEY (`id_reservasi_reschedule`),
  ADD UNIQUE KEY `reservasi_reschedule_id_reservasi_unique` (`id_reservasi`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner_promo`
--
ALTER TABLE `banner_promo`
  MODIFY `id_banner` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banner_promo_detail`
--
ALTER TABLE `banner_promo_detail`
  MODIFY `id_banner_detail` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id_dokter` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dokter_user`
--
ALTER TABLE `dokter_user`
  MODIFY `id_dokter_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id_faq` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `faq_pengaturan`
--
ALTER TABLE `faq_pengaturan`
  MODIFY `id_faq_pengaturan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jadwal_praktik`
--
ALTER TABLE `jadwal_praktik`
  MODIFY `id_jadwal` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jam_operasional`
--
ALTER TABLE `jam_operasional`
  MODIFY `id_jam_operasional` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `klinik`
--
ALTER TABLE `klinik`
  MODIFY `id_klinik` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `klinik_banner_promo`
--
ALTER TABLE `klinik_banner_promo`
  MODIFY `id_klinik_banner_promo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `klinik_dokter`
--
ALTER TABLE `klinik_dokter`
  MODIFY `id_klinik_dokter` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `klinik_faq`
--
ALTER TABLE `klinik_faq`
  MODIFY `id_klinik_faq` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `klinik_jam_operasional`
--
ALTER TABLE `klinik_jam_operasional`
  MODIFY `id_klinik_jam_operasional` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `klinik_kontak`
--
ALTER TABLE `klinik_kontak`
  MODIFY `id_kontak` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `klinik_pengaturan_reservasi`
--
ALTER TABLE `klinik_pengaturan_reservasi`
  MODIFY `id_klinik_pengaturan_reservasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id_layanan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id_pasien` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pasien_user`
--
ALTER TABLE `pasien_user`
  MODIFY `id_pasien_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengaturan_reservasi`
--
ALTER TABLE `pengaturan_reservasi`
  MODIFY `id_pengaturan_reservasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservasi`
--
ALTER TABLE `reservasi`
  MODIFY `id_reservasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservasi_relasi`
--
ALTER TABLE `reservasi_relasi`
  MODIFY `id_reservasi_relasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservasi_reschedule`
--
ALTER TABLE `reservasi_reschedule`
  MODIFY `id_reservasi_reschedule` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `banner_promo_detail`
--
ALTER TABLE `banner_promo_detail`
  ADD CONSTRAINT `banner_promo_detail_id_banner_foreign` FOREIGN KEY (`id_banner`) REFERENCES `banner_promo` (`id_banner`) ON DELETE CASCADE;

--
-- Constraints for table `dokter_user`
--
ALTER TABLE `dokter_user`
  ADD CONSTRAINT `dokter_user_id_dokter_foreign` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE CASCADE,
  ADD CONSTRAINT `dokter_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `faq_pengaturan`
--
ALTER TABLE `faq_pengaturan`
  ADD CONSTRAINT `faq_pengaturan_id_faq_foreign` FOREIGN KEY (`id_faq`) REFERENCES `faq` (`id_faq`) ON DELETE CASCADE;

--
-- Constraints for table `klinik_banner_promo`
--
ALTER TABLE `klinik_banner_promo`
  ADD CONSTRAINT `klinik_banner_promo_id_banner_foreign` FOREIGN KEY (`id_banner`) REFERENCES `banner_promo` (`id_banner`) ON DELETE CASCADE,
  ADD CONSTRAINT `klinik_banner_promo_id_klinik_foreign` FOREIGN KEY (`id_klinik`) REFERENCES `klinik` (`id_klinik`) ON DELETE CASCADE;

--
-- Constraints for table `klinik_dokter`
--
ALTER TABLE `klinik_dokter`
  ADD CONSTRAINT `klinik_dokter_id_dokter_foreign` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE CASCADE,
  ADD CONSTRAINT `klinik_dokter_id_klinik_foreign` FOREIGN KEY (`id_klinik`) REFERENCES `klinik` (`id_klinik`) ON DELETE CASCADE;

--
-- Constraints for table `klinik_faq`
--
ALTER TABLE `klinik_faq`
  ADD CONSTRAINT `klinik_faq_id_faq_foreign` FOREIGN KEY (`id_faq`) REFERENCES `faq` (`id_faq`) ON DELETE CASCADE,
  ADD CONSTRAINT `klinik_faq_id_klinik_foreign` FOREIGN KEY (`id_klinik`) REFERENCES `klinik` (`id_klinik`) ON DELETE CASCADE;

--
-- Constraints for table `klinik_jam_operasional`
--
ALTER TABLE `klinik_jam_operasional`
  ADD CONSTRAINT `klinik_jam_operasional_id_jam_operasional_foreign` FOREIGN KEY (`id_jam_operasional`) REFERENCES `jam_operasional` (`id_jam_operasional`) ON DELETE CASCADE,
  ADD CONSTRAINT `klinik_jam_operasional_id_klinik_foreign` FOREIGN KEY (`id_klinik`) REFERENCES `klinik` (`id_klinik`) ON DELETE CASCADE;

--
-- Constraints for table `klinik_kontak`
--
ALTER TABLE `klinik_kontak`
  ADD CONSTRAINT `klinik_kontak_id_klinik_foreign` FOREIGN KEY (`id_klinik`) REFERENCES `klinik` (`id_klinik`) ON DELETE CASCADE;

--
-- Constraints for table `klinik_pengaturan_reservasi`
--
ALTER TABLE `klinik_pengaturan_reservasi`
  ADD CONSTRAINT `klinik_pengaturan_reservasi_id_klinik_foreign` FOREIGN KEY (`id_klinik`) REFERENCES `klinik` (`id_klinik`) ON DELETE CASCADE,
  ADD CONSTRAINT `klinik_pengaturan_reservasi_id_pengaturan_reservasi_foreign` FOREIGN KEY (`id_pengaturan_reservasi`) REFERENCES `pengaturan_reservasi` (`id_pengaturan_reservasi`) ON DELETE CASCADE;

--
-- Constraints for table `pasien_user`
--
ALTER TABLE `pasien_user`
  ADD CONSTRAINT `pasien_user_id_pasien_foreign` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE,
  ADD CONSTRAINT `pasien_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservasi_relasi`
--
ALTER TABLE `reservasi_relasi`
  ADD CONSTRAINT `reservasi_relasi_id_dokter_foreign` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservasi_relasi_id_jadwal_foreign` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_praktik` (`id_jadwal`),
  ADD CONSTRAINT `reservasi_relasi_id_layanan_foreign` FOREIGN KEY (`id_layanan`) REFERENCES `layanan` (`id_layanan`),
  ADD CONSTRAINT `reservasi_relasi_id_pasien_foreign` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservasi_relasi_id_reservasi_foreign` FOREIGN KEY (`id_reservasi`) REFERENCES `reservasi` (`id_reservasi`) ON DELETE CASCADE;

--
-- Constraints for table `reservasi_reschedule`
--
ALTER TABLE `reservasi_reschedule`
  ADD CONSTRAINT `reservasi_reschedule_id_reservasi_foreign` FOREIGN KEY (`id_reservasi`) REFERENCES `reservasi` (`id_reservasi`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
