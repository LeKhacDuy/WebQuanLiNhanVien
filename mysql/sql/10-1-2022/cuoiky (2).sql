-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql-server
-- Generation Time: Jan 10, 2022 at 04:00 PM
-- Server version: 8.0.1-dmr
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cuoiky`
--

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_task`
--

CREATE TABLE `chitiet_task` (
  `stt` int(11) NOT NULL,
  `ma_task` int(11) NOT NULL,
  `mota` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filenhanvien` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filetruongphong` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `duyet` int(11) DEFAULT NULL,
  `danhgia` int(11) DEFAULT NULL,
  `feedback` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nghiphep`
--

CREATE TABLE `nghiphep` (
  `id` int(11) NOT NULL,
  `manv` int(11) DEFAULT NULL,
  `mota` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trangthai` int(11) DEFAULT NULL,
  `ngaynghi` int(11) DEFAULT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ngaygui` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `manv` int(11) NOT NULL,
  `taikhoan` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `matkhau` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ten` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chucvu` int(11) DEFAULT NULL,
  `mapb` int(11) DEFAULT NULL,
  `activated` bit(1) DEFAULT b'0',
  `img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `luong` bigint(20) DEFAULT NULL,
  `ngaynghi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`manv`, `taikhoan`, `matkhau`, `ten`, `email`, `chucvu`, `mapb`, `activated`, `img`, `luong`, `ngaynghi`) VALUES
(1, 'daudangson', '$2y$11$NYqbuE4RqcHBuERTYtcMWuJlACYReRLUyaWIsmzLUrh5EOhID.ZyO', 'Đậu Đăng Sơn', 'daudangson@gmai.com', 2, 1, b'0', '../images/1641650365.png', 10000000, 24),
(3, 'dawdawd', '123', 'daw', 'daudangson123@gmail.com', 1, 2, b'0', '../images/avatar.png', 312321, 15),
(11, 'dat123', '$2y$11$wFmfILN.LADQS4i5P2pEjOkOxaEk9rHjeWHQQ4O5ldaN9jChVphge', 'Đạt', 'dat123@gmail.com', 1, 57, b'0', '../images/avatar.png', 123123, 15),
(12, 'huy123', '$2y$11$J2gmvQnoB//xbMOjFtmWAewSthvy8v3dJDd4vMYAMV3nrDVP2mSJu', 'Huy', 'huy@gmail.com', 1, 2, b'1', '../images/1641651490.gif', 123, 27),
(18, 'dawdaw', '$2y$11$yknTC9tgUD5TckqOxC/PXu4BXr06cxhOAKFRwz8mXMbyXr9RgFKGi', 'Đạt', 'daudangsonlol321@gmail.com', 0, 1, b'0', '../images/avatar.png', 12321, 12),
(19, 'vailon', '$2y$11$3WGDYkOTBzmqyyPuVKUR9.3D8VFXaI6PsRcL9CIx1echIJrWGs1Ku', 'Vãi', 'dai@gmail.com', 0, 2, b'0', '../images/1641651159.gif', 21321, 12),
(23, '465', '$2y$11$04avy4nW1aIc1aRy26xNouJdADvl4hJFBqLsNQiwSs.udPUQFYluG', '132', 'dau1@gmail.com', 0, 1, b'0', '../images/avatar.png', 12, 12),
(24, '331312333330897', '$2y$11$rDygTjdoSUas04aJNagxd./MWtaTuVzvSWNT1WVMpzaGzMHqh9TqK', 'Đạt', 'daudangson867867lol321@gmail.com', 0, 57, b'0', '../images/avatar.png', 12312, 12);

-- --------------------------------------------------------

--
-- Table structure for table `phongban`
--

CREATE TABLE `phongban` (
  `mapb` int(11) NOT NULL,
  `stt` int(11) DEFAULT NULL,
  `tenpb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mota` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `truongphong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `phongban`
--

INSERT INTO `phongban` (`mapb`, `stt`, `tenpb`, `mota`, `truongphong`) VALUES
(1, 1, 'Phòng kinh doanh ', '3123', 1),
(2, 2, 'Phòng Tài chính', '', 12),
(57, 3, 'Phòng ban kỹ thuật', '', 0),
(58, 4, 'phòng ban thiết kế', 'dawdwad', 0),
(59, 3, 'addaw', '3', 0),
(60, 32, 'Phòng kinh doanh 2222', '132312', 0);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `ma_task` int(11) NOT NULL,
  `ten` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mapb` int(11) DEFAULT NULL,
  `manv` int(11) DEFAULT NULL,
  `mota` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `trangthai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chitiet_task`
--
ALTER TABLE `chitiet_task`
  ADD PRIMARY KEY (`stt`,`ma_task`);

--
-- Indexes for table `nghiphep`
--
ALTER TABLE `nghiphep`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`manv`);

--
-- Indexes for table `phongban`
--
ALTER TABLE `phongban`
  ADD PRIMARY KEY (`mapb`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`ma_task`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chitiet_task`
--
ALTER TABLE `chitiet_task`
  MODIFY `stt` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nghiphep`
--
ALTER TABLE `nghiphep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `manv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `phongban`
--
ALTER TABLE `phongban`
  MODIFY `mapb` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `ma_task` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
