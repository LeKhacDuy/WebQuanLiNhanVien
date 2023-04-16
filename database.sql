
CREATE DATABASE IF NOT EXISTS `cuoiky` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

USE `cuoiky`;

CREATE TABLE IF NOT EXISTS `nhanvien` (
    `manv` int AUTO_INCREMENT ,
    `taikhoan` varchar(64) COLLATE utf8_unicode_ci ,
    `matkhau` varchar(255) COLLATE utf8_unicode_ci ,
    `ten`varchar(255) COLLATE utf8_unicode_ci ,
    `email` varchar(64) COLLATE utf8_unicode_ci ,
    `chucvu` int,
    `mapb` int,
    `activated` bit(1) DEFAULT (false),
    `img` varchar(255) COLLATE utf8_unicode_ci,
    `luong` bigint,
    `ngaynghi` int,
    primary key(`manv`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `phongban` (
    `mapb` int AUTO_INCREMENT,
    `stt` int,
    `tenpb` varchar(255) COLLATE utf8_unicode_ci,
    `mota` varchar(255) COLLATE utf8_unicode_ci, 
    `truongphong` int,
    primary key(`mapb`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `task` (
    `ma_task` int AUTO_INCREMENT,
    `ten` varchar(255) COLLATE utf8_unicode_ci,
    `mapb` int,
    `manv` int,
    `mota` varchar(255) COLLATE utf8_unicode_ci,
    `deadline` date,
    `trangthai` int,
    primary key(`ma_task`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `chitiet_task` (
    `stt` int auto_increment,
    `ma_task` int,
    `mota` varchar(255) COLLATE utf8_unicode_ci,
    `file` varchar(255),
    `duyet` int,
    `feedback` varchar(255) COLLATE utf8_unicode_ci,
    primary key(`stt`,`ma_task`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `nghiphep` (
    `id` int AUTO_INCREMENT,
    `manv` int,
    `mota` varchar(255) COLLATE utf8_unicode_ci,
    `trangthai` int,
    `ngaynghi`int,
    `file` varchar(255) COLLATE utf8_unicode_ci,
    `ngaygui` date,
    primary key(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




