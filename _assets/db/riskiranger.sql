-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Des 2024 pada 10.44
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `riskiranger`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_risk`
--

CREATE TABLE `tb_risk` (
  `id_risk` int(11) NOT NULL,
  `tujuan` varchar(200) NOT NULL,
  `kode_risk` varchar(4) NOT NULL,
  `jenis_risk` enum('strategis','finansial','operasional') NOT NULL,
  `bisnis_risk` enum('akademik','keuangan','kepegawaian') NOT NULL,
  `sumber_risk` enum('internal','eksternal') NOT NULL,
  `uraian_risk` varchar(200) NOT NULL,
  `penyebab_risk` varchar(200) NOT NULL,
  `kualitatif_risk` varchar(200) NOT NULL,
  `kuantitatif_risk` varchar(20) NOT NULL,
  `risk_owner` varchar(30) NOT NULL,
  `unit_terkait` varchar(30) NOT NULL,
  `hood_inh` int(11) NOT NULL,
  `imp_inh` int(11) NOT NULL,
  `risk_inh` int(11) NOT NULL,
  `control` enum('ada','tidak') NOT NULL,
  `memadai` enum('memadai','belum') NOT NULL,
  `dijalankan` enum('100%','50%','<50%') NOT NULL,
  `hood_res` int(11) NOT NULL,
  `imp_res` int(11) NOT NULL,
  `risk_res` int(11) NOT NULL,
  `perlakuan` enum('accept','reduce') NOT NULL,
  `mitigasi` varchar(50) NOT NULL,
  `hood_mit` int(11) NOT NULL,
  `imp_mit` int(11) NOT NULL,
  `risk_mit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_risk`
--

INSERT INTO `tb_risk` (`id_risk`, `tujuan`, `kode_risk`, `jenis_risk`, `bisnis_risk`, `sumber_risk`, `uraian_risk`, `penyebab_risk`, `kualitatif_risk`, `kuantitatif_risk`, `risk_owner`, `unit_terkait`, `hood_inh`, `imp_inh`, `risk_inh`, `control`, `memadai`, `dijalankan`, `hood_res`, `imp_res`, `risk_res`, `perlakuan`, `mitigasi`, `hood_mit`, `imp_mit`, `risk_mit`) VALUES
(1, 'kehilangan traksi untuk menjadi lebih baik', 'R1', 'strategis', 'akademik', 'internal', 'target tidak terpenuhi', 'kompetensi akademik writing rendah', 'menurunnya reputasi universitas', '0', 'WR 1', 'Biro AAKK', 4, 3, 12, 'ada', 'memadai', '100%', 1, 3, 3, 'accept', 'menerapkan pola hidup sehat', 1, 2, 2),
(6, 'target PNPB 2021 sebesar Rp135.000.000.000', 'R2', 'finansial', 'keuangan', 'eksternal', 'target tidak terpenuhi', 'mahasiswa banyak yang telat bayar dan cuti karena pandemi', 'tingkat maturitas BLU turun', '12.000.000.000', 'WR bidang keuangan', 'Biro AUK', 4, 5, 20, 'ada', 'memadai', '100%', 4, 3, 12, 'accept', 'mencari dana yang sesuai', 4, 3, 12),
(14, 'wasdasd', 'R23', 'strategis', 'akademik', 'eksternal', 'asdasd', 'asdasd', 'asdasd', '2323', 'sdasd', 'asdads', 5, 5, 25, 'tidak', 'belum', '100%', 2, 3, 6, 'reduce', 'dsfdfsdf', 5, 3, 15);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` enum('Admin','Fakultas') NOT NULL,
  `unit_terkait` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `password`, `level`, `unit_terkait`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', 'PTIPD'),
(2, 'fstuin', 'adc9f15de0c1c39899d6d1e9d1d0aeee', 'Fakultas', 'Fakultas Sains dan Teknologi'),
(3, 'febiuin', '48384420228eaf2ca4533ff7ac1cd673', 'Fakultas', 'Fakultas Ekonomi dan Bisnis Islam'),
(4, 'fdkuin', '7882e8704ecd5515fdb6cac9215738ff', 'Fakultas', 'Fakultas Dakwah dan Komunikasi'),
(5, 'fishumuin', 'ed9397ababe26629601d49fbd850ea24', 'Fakultas', 'Fakultas Ilmu Sosial dan Humaniora'),
(6, 'fitkuin', '099f40b02590e5ac1b475a35977a7c80', 'Fakultas', 'Fakultas Ilmu Tarbiyah dan Keguruan'),
(7, 'fupiuin', '82c1d73625c72857f4d173da097be372', 'Fakultas', 'Fakultas Ushuluddin dan Pemikiran Islam'),
(8, 'fshuin', 'e0203368a954aaab519b98194613ee6c', 'Fakultas', 'Fakultas Syariah dan Hukum');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_risk`
--
ALTER TABLE `tb_risk`
  ADD PRIMARY KEY (`id_risk`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_risk`
--
ALTER TABLE `tb_risk`
  MODIFY `id_risk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
