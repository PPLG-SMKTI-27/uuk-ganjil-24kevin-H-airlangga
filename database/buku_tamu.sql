-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Nov 18, 2025 at 05:55 AM
-- Server version: 10.5.29-MariaDB-ubu2004
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `buku_tamu`
--

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id_guru` int(11) NOT NULL,
  `nama_guru` varchar(255) NOT NULL,
  `nip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id_guru`, `nama_guru`, `nip`) VALUES
(2, 'Ibni SPD', '821381273892132'),
(3, 'kepin wahyuk dokter', '2312313');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_kunjungan`
--

CREATE TABLE `jenis_kunjungan` (
  `id_jenis` int(11) NOT NULL,
  `nama_jenis` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_kunjungan`
--

INSERT INTO `jenis_kunjungan` (`id_jenis`, `nama_jenis`, `deskripsi`) VALUES
(1, 'Pertemuan Orang Tua', 'Orang tua siswa bertemu dengan guru'),
(2, 'Informasi Pendaftaran', 'Calon orang tua/siswa bertanya tentang pendaftaran'),
(3, 'Penelitian', 'Mahasiswa melakukan penelitian'),
(4, 'Sosialisasi Kampus', 'Perwakilan kampus melakukan sosialisasi'),
(5, 'Urusan Administrasi', 'Urusan administrasi dengan TU'),
(6, 'Lainnya', 'Kunjungan lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_log` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `tabel_terkait` varchar(50) NOT NULL,
  `id_record` int(11) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id_log`, `id_pengguna`, `aktivitas`, `tabel_terkait`, `id_record`, `ip_address`, `user_agent`, `created_at`, `updated_at`, `waktu`) VALUES
(1, 3, 'Login ke sistem', 'pengguna', 3, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-18 11:14:09', '2025-11-18 11:14:09', '2025-11-18 03:14:09'),
(2, 3, 'Mengupdate profile', 'pengguna', 3, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-18 11:14:40', '2025-11-18 11:14:40', '2025-11-18 03:14:40'),
(3, 3, 'Menambah data guru: kepin wahyuk dokter', 'guru', 3, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-18 11:17:58', '2025-11-18 11:17:58', '2025-11-18 03:17:58'),
(4, 3, 'Login ke sistem', 'pengguna', 3, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-18 11:50:26', '2025-11-18 11:50:26', '2025-11-18 03:50:26'),
(5, 3, 'Login ke sistem', 'pengguna', 3, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 13_0_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36', '2025-11-18 11:58:46', '2025-11-18 11:58:46', '2025-11-18 03:58:46'),
(6, 3, 'Login ke sistem', 'pengguna', 3, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 8.1.0; SM-T837A) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.80 Safari/537.36', '2025-11-18 11:58:46', '2025-11-18 11:58:46', '2025-11-18 03:58:46'),
(7, 3, 'Login ke sistem', 'pengguna', 3, '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.0 Mobile/15E148 Safari/604.1', '2025-11-18 11:58:47', '2025-11-18 11:58:47', '2025-11-18 03:58:47'),
(8, 3, 'Login ke sistem', 'pengguna', 3, '127.0.0.1', 'Mozilla/5.0 (iPad; CPU OS 11_0 like Mac OS X) AppleWebKit/604.1.34 (KHTML, like Gecko) Version/11.0 Mobile/15A5341f Safari/604.1', '2025-11-18 11:58:47', '2025-11-18 11:58:47', '2025-11-18 03:58:47'),
(9, 3, 'Login ke sistem', 'pengguna', 3, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.120 Mobile Safari/537.36', '2025-11-18 11:58:47', '2025-11-18 11:58:47', '2025-11-18 03:58:47'),
(10, 3, 'Login ke sistem', 'pengguna', 3, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-18 13:04:21', '2025-11-18 13:04:21', '2025-11-18 05:04:21'),
(11, 3, 'Login ke sistem', 'pengguna', 3, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-18 13:29:23', '2025-11-18 13:29:23', '2025-11-18 05:29:23'),
(12, 3, 'Update status kunjungan tamu Kevin Hermansyah menjadi: selesai', 'tamu', 6, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-18 13:29:37', '2025-11-18 13:29:37', '2025-11-18 05:29:37'),
(13, 3, 'Update status kunjungan tamu dfdssddssdffdsfsd menjadi: dibatalkan', 'tamu', 5, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-18 13:29:39', '2025-11-18 13:29:39', '2025-11-18 05:29:39'),
(14, 1, 'Login ke sistem', 'pengguna', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', '2025-11-18 13:54:40', '2025-11-18 13:54:40', '2025-11-18 05:54:40');

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
(4, '2025_11_18_105921_add_timestamps_to_tamu_table', 2),
(5, '2025_11_18_110758_add_fields_to_log_aktivitas_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `peran_id` int(11) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama`, `email`, `password`, `peran_id`, `last_login`) VALUES
(1, 'Kevin Admin', 'kevinadmin@gmail.com', '$2y$10$6CsPCN08K.lUSIrK5px9w.mqgELjASewM/XMijvvsgKFQ17fTtx8.', 1, '2025-11-18 13:54:40'),
(2, 'Kevin TU', 'kevintu@gmail.com', '$2y$10$qUlLbAW7Xzm8LEw4lW2vJelpH8.q1Iz97If8O0POhfN8QzRX/7ajW', 2, NULL),
(3, 'kevin admin1', 'kevin@gmail.com', '$2y$10$YHGXIX/6aTKoKlK6/59ibuo5GuW7nvmxUpEC5BXpEK60RVeNwnZ92', 1, '2025-11-18 13:29:23');

-- --------------------------------------------------------

--
-- Table structure for table `peran`
--

CREATE TABLE `peran` (
  `id_peran` int(11) NOT NULL,
  `nama_peran` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peran`
--

INSERT INTO `peran` (`id_peran`, `nama_peran`) VALUES
(1, 'Admin'),
(2, 'Staff TU');

-- --------------------------------------------------------

--
-- Table structure for table `tamu`
--

CREATE TABLE `tamu` (
  `id_tamu` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `telepon` varchar(50) NOT NULL,
  `status` varchar(100) NOT NULL,
  `id_jenis` int(11) DEFAULT NULL,
  `tujuan` text NOT NULL,
  `guru_tujuan` int(11) DEFAULT NULL,
  `alamat` text NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `waktu_masuk` time DEFAULT NULL,
  `waktu_keluar` time DEFAULT NULL,
  `status_kunjungan` enum('proses','selesai','dibatalkan') DEFAULT 'proses',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tamu`
--

INSERT INTO `tamu` (`id_tamu`, `nama`, `telepon`, `status`, `id_jenis`, `tujuan`, `guru_tujuan`, `alamat`, `keterangan`, `tanggal_kunjungan`, `waktu_masuk`, `waktu_keluar`, `status_kunjungan`, `created_at`, `updated_at`, `created_by`, `deleted_at`) VALUES
(5, 'dfdssddssdffdsfsd', '23432324', 'Orang Tua/Wali', 1, 'sdfsddsdf', 2, 'dsfsdfdssdfsfdds', 'sfdsfdsdffddsfsd', '2025-11-18', '03:24:00', NULL, 'dibatalkan', '2025-11-18 02:56:30', '2025-11-18 13:29:39', 3, NULL),
(6, 'Kevin Hermansyah', '12321313', 'Orang Tua/Wali', 1, 'dsfdsfdsfdsfdsfd', 3, 'sadasdasdasdasd', 'aasdasdassaddas', '2025-11-18', '12:32:00', '13:29:37', 'selesai', '2025-11-18 13:29:09', '2025-11-18 13:29:37', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `jenis_kunjungan`
--
ALTER TABLE `jenis_kunjungan`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `FK_pengguna_peran` (`peran_id`);

--
-- Indexes for table `peran`
--
ALTER TABLE `peran`
  ADD PRIMARY KEY (`id_peran`);

--
-- Indexes for table `tamu`
--
ALTER TABLE `tamu`
  ADD PRIMARY KEY (`id_tamu`),
  ADD KEY `fk_guru` (`guru_tujuan`),
  ADD KEY `fk_jenis_kunjungan` (`id_jenis`),
  ADD KEY `fk_created_by` (`created_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jenis_kunjungan`
--
ALTER TABLE `jenis_kunjungan`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `peran`
--
ALTER TABLE `peran`
  MODIFY `id_peran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tamu`
--
ALTER TABLE `tamu`
  MODIFY `id_tamu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);

--
-- Constraints for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD CONSTRAINT `FK_pengguna_peran` FOREIGN KEY (`peran_id`) REFERENCES `peran` (`id_peran`);

--
-- Constraints for table `tamu`
--
ALTER TABLE `tamu`
  ADD CONSTRAINT `fk_created_by` FOREIGN KEY (`created_by`) REFERENCES `pengguna` (`id_pengguna`),
  ADD CONSTRAINT `fk_guru` FOREIGN KEY (`guru_tujuan`) REFERENCES `guru` (`id_guru`),
  ADD CONSTRAINT `fk_jenis_kunjungan` FOREIGN KEY (`id_jenis`) REFERENCES `jenis_kunjungan` (`id_jenis`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
