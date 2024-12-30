-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Feb 2024 pada 20.54
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ppdb_online`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `administrasi`
--

CREATE TABLE `administrasi` (
  `id_administrasi` int(11) NOT NULL,
  `id_identitas_siswa` int(11) NOT NULL,
  `status` enum('Lolos','Tidak Lolos') NOT NULL,
  `tgl_buat` datetime NOT NULL,
  `tgl_ubah` DATETIME NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `administrasi`
--

INSERT INTO `administrasi` (`id_administrasi`, `id_identitas_siswa`, `status`, `tgl_buat`, `tgl_ubah`) VALUES
(11, 10, 'Lolos', '2024-02-10', '2024-02-10');

--
-- Trigger `administrasi`
--
DELIMITER $$
CREATE TRIGGER `HapusAdministrasi` AFTER DELETE ON `administrasi` FOR EACH ROW BEGIN
  UPDATE identitas_siswa SET status_administrasi = 0 
  WHERE Id_Identitas_Siswa = OLD.id_identitas_siswa; 
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TambahAdministrasi` AFTER INSERT ON `administrasi` FOR EACH ROW BEGIN
  UPDATE identitas_siswa SET status_administrasi = 1 
  WHERE Id_Identitas_Siswa = NEW.id_identitas_siswa;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `idberita` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `judul_berita` varchar(255) NOT NULL,
  `isi_berita` text NOT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`idberita`, `iduser`, `judul_berita`, `isi_berita`, `tanggal`) VALUES
(2, 0, 'Pendafatarn', 'PPDB Dimuali Pada 14 Februari 2024', '2024-01-13'),
(3, 0, 'tes', 'tes', '2024-02-19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `identitas_siswa`
--

CREATE TABLE `identitas_siswa` (
  `Id_Identitas_Siswa` int(11) NOT NULL,
  `NISN` varchar(15) NOT NULL,
  `No_KK` varchar(20) NOT NULL,
  `NIK` varchar(16) NOT NULL,
  `Nama_Panggilan` text NOT NULL,
  `Nama_Peserta_Didik` text NOT NULL,
  `Tempat_Lahir` varchar(30) NOT NULL,
  `Tanggal_Lahir` datetime NOT NULL,
  `Jenis_Kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `Agama` varchar(9) NOT NULL,
  `Gol_Darah` varchar(5) NOT NULL,
  `Tinggi_Badan` varchar(4) NOT NULL,
  `Berat_badan` int(11) NOT NULL,
  `Status_Anak` varchar(12) NOT NULL,
  `Anak_Ke` int(2) NOT NULL,
  `Jml_Saudara` int(2) NOT NULL,
  `Jenis_Tinggal` varchar(17) NOT NULL,
  `Alamat_Tinggal` text NOT NULL,
  `Provinsi_Tinggal` varchar(30) NOT NULL,
  `Kab_Kota_Tinggal` varchar(30) NOT NULL,
  `Kec_Tinggal` varchar(30) NOT NULL,
  `Kelurahan_Tinggal` varchar(30) NOT NULL,
  `Kode_POS` varchar(6) NOT NULL,
  `Jarak_Ke_Sekolah` varchar(5) NOT NULL,
  `Riwayat_Penyakit` text NOT NULL,
  `status_ortu` tinyint(1) NOT NULL,
  `status_administrasi` tinyint(1) NOT NULL,
  `tgl_buat` datetime NOT NULL,
  `tgl_ubah` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `identitas_siswa`
--

INSERT INTO `identitas_siswa` (`Id_Identitas_Siswa`, `NISN`, `No_KK`, `NIK`, `Nama_Panggilan`, `Nama_Peserta_Didik`, `Tempat_Lahir`, `Tanggal_Lahir`, `Jenis_Kelamin`, `Agama`, `Gol_Darah`, `Tinggi_Badan`, `Berat_badan`, `Status_Anak`, `Anak_Ke`, `Jml_Saudara`, `Jenis_Tinggal`, `Alamat_Tinggal`, `Provinsi_Tinggal`, `Kab_Kota_Tinggal`, `Kec_Tinggal`, `Kelurahan_Tinggal`, `Kode_POS`, `Jarak_Ke_Sekolah`, `Riwayat_Penyakit`, `status_ortu`, `status_administrasi`, `tgl_buat`, `tgl_ubah`) VALUES
(10, '1111111111', '1111111111111111', '1111111111111111', 'Arul', 'Khairul Huda', 'Padang', '2024-02-10', 'Laki-Laki', 'Islam', 'B', '175', 56, 'Kandung', 2, 2, 'Bersama Orang tua', 'Padang', 'Sumatera Barat', 'Pariaman', 'Pariaman Utara', 'Naras Hilir', '25512', '2', '2', 0, 1, '2024-02-10', '2024-02-10'),
(11, '2222222222', '2222222222222222', '2222222222222222', 'Arul', 'Andika', 'Padang', '2024-02-10', 'Laki-Laki', 'Islam', 'B', '175', 55, 'Kandung', 2, 2, 'Bersama Orang tua', 'Padang', 'Sumatera Barat', 'Pariaman', 'Pariaman Utara', 'Naras Hilir', '25512', '2', '1', 0, 0, '2024-02-10', '2024-02-10'),
(12, '3333333333', '3333333333333333', '3333333333333333', 'Arul', 'Khairul Huda', 'Padang', '2024-02-10', 'Laki-Laki', 'Islam', 'B', '175', 56, 'Kandung', 2, 1, 'Bersama Orang tua', 'Padang', 'Sumatera Barat', 'Pariaman', 'Pariaman Utara', 'Naras Hilir', '25521', '2', '1', 0, 0, '2024-02-10', '2024-02-10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orang_tua_wali`
--

CREATE TABLE `orang_tua_wali` (
  `Id_Orang_Tua_Wali` int(11) NOT NULL,
  `Id_Identitas_Siswa` int(11) NOT NULL,
  `Nama_Ayah` varchar(30) NOT NULL,
  `Status_Ayah` varchar(10) NOT NULL,
  `Tgl_Lahir_Ayah` datetime NOT NULL,
  `Telepon_Ayah` varchar(14) NOT NULL,
  `Pendidikan_Terakhir_Ayah` varchar(20) NOT NULL,
  `Pekerjaan_Ayah` varchar(30) NOT NULL,
  `Penghasilan_Ayah` varchar(10) NOT NULL,
  `Alamat_Ayah` varchar(165) NOT NULL,
  `Nama_Ibu` varchar(30) NOT NULL,
  `Status_Ibu` varchar(10) NOT NULL,
  `Tgl_Lahir_Ibu` datetime NOT NULL,
  `Telepon_Ibu` varchar(14) NOT NULL,
  `Pendidikan_Terakhir_Ibu` varchar(20) NOT NULL,
  `Pekerjaan_Ibu` varchar(30) NOT NULL,
  `Penghasilan_Ibu` varchar(10) NOT NULL,
  `Alamat_Ibu` varchar(165) NOT NULL,
  `Nama_Wali` varchar(30) NOT NULL,
  `Status_Wali` varchar(10) NOT NULL,
  `Tgl_Lahir_Wali` datetime NOT NULL,
  `Telepon_Wali` varchar(14) NOT NULL,
  `Pendidikan_Terakhir_Wali` varchar(20) NOT NULL,
  `Pekerjaan_Wali` varchar(30) NOT NULL,
  `Penghasilan_Wali` varchar(10) NOT NULL,
  `Alamat_Wali` varchar(165) NOT NULL,
  `tgl_buat` datetime NOT NULL,
  `tgl_ubah` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Trigger `orang_tua_wali`
--
DELIMITER $$
CREATE TRIGGER `HapusOrangTuaWali` AFTER DELETE ON `orang_tua_wali` FOR EACH ROW BEGIN
  UPDATE identitas_siswa SET status_ortu = 0 
  WHERE Id_Identitas_Siswa = OLD.Id_Identitas_Siswa;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TambahOrangTuaWali` AFTER INSERT ON `orang_tua_wali` FOR EACH ROW BEGIN
  UPDATE identitas_siswa SET status_ortu = 1 
  WHERE Id_Identitas_Siswa = NEW.Id_Identitas_Siswa;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` char(45) NOT NULL,
  `username` char(65) NOT NULL,
  `password` char(125) NOT NULL,
  `hak` enum('admin','pegawai') NOT NULL,
  `status` enum('aktif','tidak aktif') NOT NULL,
  `tgl_buat` datetime NOT NULL,
  `tgl_ubah` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`, `hak`, `status`, `tgl_buat`, `tgl_ubah`) VALUES
(6, 'Administrator', 'admin1', 'admin1', 'admin', 'aktif', '2020-09-16 18:32:57', '2024-02-09 19:21:01');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `administrasi`
--
ALTER TABLE `administrasi`
  ADD PRIMARY KEY (`id_administrasi`),
  ADD KEY `id_identitas_siswa` (`id_identitas_siswa`);

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`idberita`);

--
-- Indeks untuk tabel `identitas_siswa`
--
ALTER TABLE `identitas_siswa`
  ADD PRIMARY KEY (`Id_Identitas_Siswa`),
  ADD UNIQUE KEY `NISN` (`NISN`),
  ADD UNIQUE KEY `NIK` (`NIK`);

--
-- Indeks untuk tabel `orang_tua_wali`
--
ALTER TABLE `orang_tua_wali`
  ADD PRIMARY KEY (`Id_Orang_Tua_Wali`),
  ADD KEY `Id_Identitas_Siswa` (`Id_Identitas_Siswa`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `administrasi`
--
ALTER TABLE `administrasi`
  MODIFY `id_administrasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `idberita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `identitas_siswa`
--
ALTER TABLE `identitas_siswa`
  MODIFY `Id_Identitas_Siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `orang_tua_wali`
--
ALTER TABLE `orang_tua_wali`
  MODIFY `Id_Orang_Tua_Wali` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `administrasi`
--
ALTER TABLE `administrasi`
  ADD CONSTRAINT `administrasi_ibfk_1` FOREIGN KEY (`id_identitas_siswa`) REFERENCES `identitas_siswa` (`Id_Identitas_Siswa`);

--
-- Ketidakleluasaan untuk tabel `orang_tua_wali`
--
ALTER TABLE `orang_tua_wali`
  ADD CONSTRAINT `orang_tua_wali_ibfk_1` FOREIGN KEY (`Id_Identitas_Siswa`) REFERENCES `identitas_siswa` (`Id_Identitas_Siswa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
