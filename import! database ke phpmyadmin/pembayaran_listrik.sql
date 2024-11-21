-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2024 at 12:35 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pembayaran_listrik`
--

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` varchar(11) NOT NULL,
  `no_meter` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `tenggang` varchar(2) DEFAULT NULL,
  `id_tarif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `no_meter`, `nama`, `alamat`, `tenggang`, `id_tarif`) VALUES
('PLG-61553', '240730956992', 'Pelanggan Baru', 'news pelanggan', '30', 2),
('PLG-86306', '240728526351', 'Andre Reyhan', 'jatibening', '20', 2),
('PLG-97182', '240728406784', 'Rifat Ramadhan', 'jatibening', '28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_tagihan` varchar(11) NOT NULL,
  `id_penggunaan` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `id_pelanggan` varchar(11) NOT NULL,
  `no_meter` varchar(50) NOT NULL,
  `meter_awal` int(11) NOT NULL,
  `meter_akhir` int(11) NOT NULL,
  `kode_tarif` varchar(50) NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `jumlah_meter` int(11) NOT NULL,
  `tarif_perkwh` decimal(10,2) NOT NULL,
  `tagihan_listrik` decimal(10,2) NOT NULL,
  `biaya_admin` decimal(10,2) NOT NULL,
  `denda` decimal(10,2) NOT NULL,
  `total_bayar` decimal(10,2) NOT NULL,
  `jumlah_uang` decimal(10,2) NOT NULL,
  `uang_kembali` decimal(10,2) NOT NULL,
  `tanggal_pembayaran` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_tagihan`, `id_penggunaan`, `id_petugas`, `id_pelanggan`, `no_meter`, `meter_awal`, `meter_akhir`, `kode_tarif`, `bulan`, `tahun`, `nama_pelanggan`, `jumlah_meter`, `tarif_perkwh`, `tagihan_listrik`, `biaya_admin`, `denda`, `total_bayar`, `jumlah_uang`, `uang_kembali`, `tanggal_pembayaran`) VALUES
(27, 'BYR-87166', 14, 2, 'PLG-86306', '240728526351', 321, 333, 'R2-1000', 7, 2024, 'Andre Reyhan', 12, '1300.00', '15600.00', '4000.00', '5500.00', '25100.00', '30000.00', '4900.00', '2024-07-30 04:31:52'),
(28, 'BYR-56202', 19, 2, 'PLG-97182', '240728406784', 213, 333, 'R1-900', 8, 2024, 'Rifat Ramadhan', 120, '1200.00', '144000.00', '4000.00', '5500.00', '153500.00', '155000.00', '1500.00', '2024-07-30 09:35:12'),
(29, 'BYR-57514', 20, 2, 'PLG-61553', '240730956992', 2022, 2222, 'R2-1000', 5, 2024, 'Pelanggan Baru', 200, '1300.00', '260000.00', '4000.00', '0.00', '264000.00', '300000.00', '36000.00', '2024-07-30 10:26:48');

-- --------------------------------------------------------

--
-- Table structure for table `penggunaan`
--

CREATE TABLE `penggunaan` (
  `id_penggunaan` int(11) NOT NULL,
  `id_pelanggan` varchar(11) NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `meter_awal` decimal(10,0) NOT NULL,
  `meter_akhir` decimal(10,0) NOT NULL,
  `tgl_cek` date NOT NULL,
  `id_petugas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penggunaan`
--

INSERT INTO `penggunaan` (`id_penggunaan`, `id_pelanggan`, `bulan`, `tahun`, `meter_awal`, `meter_akhir`, `tgl_cek`, `id_petugas`) VALUES
(11, 'PLG-97182', 2, 2024, '321', '421', '2024-07-29', 1),
(14, 'PLG-86306', 7, 2024, '321', '333', '2024-07-29', 2),
(15, 'PLG-86306', 6, 2024, '123', '333', '2024-07-29', 1),
(18, 'PLG-86306', 7, 2024, '983', '1000', '2024-07-30', 2),
(19, 'PLG-97182', 8, 2024, '213', '333', '2024-07-30', 2),
(20, 'PLG-61553', 5, 2024, '2022', '2222', '2024-07-30', 2);

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `nama_petugas` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_telepon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jk` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_profil` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biaya_admin` decimal(10,0) NOT NULL,
  `akses` enum('Petugas','Agen') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama_petugas`, `alamat`, `no_telepon`, `jk`, `foto_profil`, `username`, `password`, `biaya_admin`, `akses`, `session_id`) VALUES
(1, 'Rifat', 'BSI Kalimalangs', '08312321121', 'Laki-laki', NULL, 'admin', NULL, '3000', 'Petugas', '-'),
(2, 'Andre', 'agen', '123122112', 'Perempuan', NULL, 'agen', '941730a7089d81c58c743a7577a51640', '4000', 'Agen', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tagihan`
--

CREATE TABLE `tagihan` (
  `id_tagihan` varchar(20) NOT NULL,
  `id_pelanggan` varchar(11) NOT NULL,
  `bulan` varchar(2) NOT NULL,
  `tahun` year(4) NOT NULL,
  `jumlah_meter` int(11) NOT NULL,
  `tarif_perkwh` decimal(10,0) NOT NULL,
  `jumlah_bayar` decimal(10,0) NOT NULL,
  `status` varchar(15) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `id_penggunaan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tagihan`
--

INSERT INTO `tagihan` (`id_tagihan`, `id_pelanggan`, `bulan`, `tahun`, `jumlah_meter`, `tarif_perkwh`, `jumlah_bayar`, `status`, `id_petugas`, `id_penggunaan`) VALUES
('BYR-46978', 'PLG-86306', '6', 2024, 210, '1300', '273000', 'Belum Dibayar', 1, 15),
('BYR-56202', 'PLG-97182', '8', 2024, 120, '1200', '144000', 'Sudah Terbayar', 2, 19),
('BYR-57514', 'PLG-61553', '5', 2024, 200, '1300', '260000', 'Sudah Terbayar', 2, 20),
('BYR-70635', 'PLG-86306', '7', 2024, 17, '1300', '22100', 'Belum Dibayar', 2, 18),
('BYR-87166', 'PLG-86306', '7', 2024, 12, '1300', '15600', 'Sudah Terbayar', 2, 14),
('BYR-92109', 'PLG-97182', '2', 2024, 100, '1200', '120000', 'Belum Dibayar', 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `tarif`
--

CREATE TABLE `tarif` (
  `id_tarif` int(11) NOT NULL,
  `kode_tarif` varchar(50) NOT NULL,
  `golongan` varchar(50) NOT NULL,
  `daya` varchar(20) NOT NULL,
  `tarif_perkwh` decimal(15,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tarif`
--

INSERT INTO `tarif` (`id_tarif`, `kode_tarif`, `golongan`, `daya`, `tarif_perkwh`) VALUES
(1, 'R1-900', 'R1', '900', '1200'),
(2, 'R2-1000', 'R2', '1000', '1300');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD KEY `id_tarif` (`id_tarif`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_tagihan` (`id_tagihan`),
  ADD KEY `id_penggunaan` (`id_penggunaan`),
  ADD KEY `id_petugas` (`id_petugas`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `penggunaan`
--
ALTER TABLE `penggunaan`
  ADD PRIMARY KEY (`id_penggunaan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indexes for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id_tagihan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_petugas` (`id_petugas`),
  ADD KEY `id_penggunaan` (`id_penggunaan`);

--
-- Indexes for table `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`id_tarif`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `penggunaan`
--
ALTER TABLE `penggunaan`
  MODIFY `id_penggunaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tarif`
--
ALTER TABLE `tarif`
  MODIFY `id_tarif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD CONSTRAINT `pelanggan_ibfk_1` FOREIGN KEY (`id_tarif`) REFERENCES `tarif` (`id_tarif`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_tagihan`) REFERENCES `tagihan` (`id_tagihan`),
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_penggunaan`) REFERENCES `penggunaan` (`id_penggunaan`),
  ADD CONSTRAINT `pembayaran_ibfk_3` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`),
  ADD CONSTRAINT `pembayaran_ibfk_4` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`);

--
-- Constraints for table `penggunaan`
--
ALTER TABLE `penggunaan`
  ADD CONSTRAINT `penggunaan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `penggunaan_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`);

--
-- Constraints for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD CONSTRAINT `tagihan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `tagihan_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`),
  ADD CONSTRAINT `tagihan_ibfk_3` FOREIGN KEY (`id_penggunaan`) REFERENCES `penggunaan` (`id_penggunaan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
