-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Nov 2024 pada 07.25
-- Versi server: 10.4.20-MariaDB
-- Versi PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ulangan_galerifoto`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `album`
--

CREATE TABLE `album` (
  `albumid` int(11) NOT NULL,
  `namaalbum` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggaldibuat` date NOT NULL,
  `userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `album`
--

INSERT INTO `album` (`albumid`, `namaalbum`, `deskripsi`, `tanggaldibuat`, `userid`) VALUES
(9, 'candi prambanan', 'jawa timur', '2024-11-05', 1),
(13, 'pangandaran', 'jawa barat', '2024-11-05', 1),
(14, 'gunung yang indah', 'jawa timur', '2024-11-05', 1),
(15, 'candi borobudur', 'jawa tengah', '2024-11-05', 1),
(16, 'bn', 'bn', '2024-11-06', 1),
(17, 'one piece', 'anime', '2024-11-06', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `foto`
--

CREATE TABLE `foto` (
  `fotoid` int(11) NOT NULL,
  `judulfoto` varchar(255) NOT NULL,
  `deskripsifoto` text DEFAULT NULL,
  `tanggalunggah` date NOT NULL,
  `lokasifile` varchar(255) NOT NULL,
  `albumid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `foto`
--

INSERT INTO `foto` (`fotoid`, `judulfoto`, `deskripsifoto`, `tanggalunggah`, `lokasifile`, `albumid`, `userid`) VALUES
(15, 'candi', 'jawa', '2024-11-05', 'uploads/candi-prambanan_169.jpeg', NULL, 1),
(19, 'pantai', 'pangandaran', '2024-11-05', 'uploads/download.jpeg', NULL, 1),
(20, 'gunung', 'bromo', '2024-11-05', 'uploads/background1.jpg', NULL, 1),
(21, 'candi', 'borobudur', '2024-11-05', 'uploads/wisata-sejarah-1.jpg', NULL, 1),
(22, 'SEKOLAH BAKNUS', 'bn', '2024-11-06', 'uploads/download (1).png', NULL, 1),
(23, 'luffy', 'anime', '2024-11-06', 'uploads/download.png', NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar_foto`
--

CREATE TABLE `komentar_foto` (
  `komentarid` int(11) NOT NULL,
  `fotoid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `isikomentar` text NOT NULL,
  `tanggalkomentar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `komentar_foto`
--

INSERT INTO `komentar_foto` (`komentarid`, `fotoid`, `userid`, `isikomentar`, `tanggalkomentar`) VALUES
(12, 15, 1, 'wow', '2024-11-05'),
(14, 15, 1, 'keren', '2024-11-05'),
(18, 15, 1, 'keren bingit', '2024-11-05'),
(19, 19, 1, 'keren bingit', '2024-11-05'),
(20, 19, 1, 'ok', '2024-11-05'),
(21, 19, 1, 'wow', '2024-11-05'),
(22, 19, 1, 'kelaszzz', '2024-11-05'),
(23, 15, 1, 'gilakkkkkk', '2024-11-05'),
(24, 20, 1, 'kiboyyyyyyy', '2024-11-05'),
(25, 21, 1, 'gilakkk sanzzz', '2024-11-05'),
(26, 19, 1, 'wow', '2024-11-06'),
(27, 22, 1, 'ee', '2024-11-06'),
(28, 23, 1, 'kelaszzz', '2024-11-06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `likefoto`
--

CREATE TABLE `likefoto` (
  `likeid` int(11) NOT NULL,
  `fotoid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `tanggallike` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `likefoto`
--

INSERT INTO `likefoto` (`likeid`, `fotoid`, `userid`, `tanggallike`) VALUES
(33, 15, 1, '0000-00-00'),
(34, 20, 1, '0000-00-00'),
(35, 21, 1, '0000-00-00'),
(36, 19, 1, '0000-00-00'),
(37, 22, 1, '0000-00-00'),
(38, 23, 1, '0000-00-00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `namalengkap` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`userid`, `username`, `password`, `email`, `namalengkap`, `alamat`) VALUES
(1, 'user', 'user12', 'user@gmail.com', 'user asep', 'panyawangan'),
(2, 'user1', '1', 'user1@gmail.com', 'user1', 'panyawangan');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`albumid`),
  ADD KEY `userid` (`userid`);

--
-- Indeks untuk tabel `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`fotoid`),
  ADD KEY `albumid` (`albumid`),
  ADD KEY `userid` (`userid`);

--
-- Indeks untuk tabel `komentar_foto`
--
ALTER TABLE `komentar_foto`
  ADD PRIMARY KEY (`komentarid`),
  ADD KEY `fotoid` (`fotoid`),
  ADD KEY `userid` (`userid`);

--
-- Indeks untuk tabel `likefoto`
--
ALTER TABLE `likefoto`
  ADD PRIMARY KEY (`likeid`),
  ADD KEY `fotoid` (`fotoid`),
  ADD KEY `userid` (`userid`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `album`
--
ALTER TABLE `album`
  MODIFY `albumid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `foto`
--
ALTER TABLE `foto`
  MODIFY `fotoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `komentar_foto`
--
ALTER TABLE `komentar_foto`
  MODIFY `komentarid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `likefoto`
--
ALTER TABLE `likefoto`
  MODIFY `likeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `foto`
--
ALTER TABLE `foto`
  ADD CONSTRAINT `foto_ibfk_1` FOREIGN KEY (`albumid`) REFERENCES `album` (`albumid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foto_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `komentar_foto`
--
ALTER TABLE `komentar_foto`
  ADD CONSTRAINT `komentar_foto_ibfk_1` FOREIGN KEY (`fotoid`) REFERENCES `foto` (`fotoid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentar_foto_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `likefoto`
--
ALTER TABLE `likefoto`
  ADD CONSTRAINT `likefoto_ibfk_1` FOREIGN KEY (`fotoid`) REFERENCES `foto` (`fotoid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likefoto_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
