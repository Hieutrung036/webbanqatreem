-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th1 17, 2025 lúc 05:53 AM
-- Phiên bản máy phục vụ: 8.3.0
-- Phiên bản PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webbanqatreem1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `idadmin` int NOT NULL AUTO_INCREMENT,
  `ten` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `matkhau` varchar(100) NOT NULL,
  PRIMARY KEY (`idadmin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`idadmin`, `ten`, `email`, `matkhau`) VALUES
(2, 'hieu1', '1tinhyeu@gmail.com', '$2y$10$dyqrZE5D/8bLTnJUYdOdUOUw6KFYD3mtt3wdxHODoMQJ6Frmwlwum');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chat`
--

DROP TABLE IF EXISTS `chat`;
CREATE TABLE IF NOT EXISTS `chat` (
  `idc` int NOT NULL AUTO_INCREMENT,
  `noidung` varchar(255) NOT NULL,
  `thoigian` date NOT NULL,
  `idkh` int DEFAULT NULL,
  `idnv` int DEFAULT NULL,
  `loai_nguoi_gui` enum('khachhang','nhanvien') NOT NULL,
  `da_xem` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`idc`),
  KEY `chat_ibfk_1` (`idkh`),
  KEY `chat_ibfk_2` (`idnv`)
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `chat`
--

INSERT INTO `chat` (`idc`, `noidung`, `thoigian`, `idkh`, `idnv`, `loai_nguoi_gui`, `da_xem`) VALUES
(157, 'ádada', '2025-01-05', 49, 1, 'khachhang', 1),
(159, 'v', '2025-01-06', 49, 1, 'nhanvien', 1),
(162, 'cc', '2025-01-06', 49, 1, 'khachhang', 1),
(163, 'không có gì', '2025-01-06', 49, 1, 'nhanvien', 1),
(164, '1', '2025-01-06', 49, 1, 'khachhang', 1),
(165, 'ccc', '2025-01-06', 49, 1, 'khachhang', 1),
(166, 'không có gì', '2025-01-06', 49, 1, 'nhanvien', 1),
(167, 'ccasca', '2025-01-06', 50, 1, 'khachhang', 1),
(168, 'dđ', '2025-01-06', 50, 1, 'nhanvien', 1),
(169, 'd', '2025-01-07', 49, 1, 'nhanvien', 1),
(170, 'xin chào', '2025-01-07', 50, 1, 'nhanvien', 1),
(171, 'xin chào', '2025-01-07', 49, NULL, 'khachhang', 1),
(172, 'có gì không', '2025-01-07', 49, 1, 'nhanvien', 1),
(173, 'không có gì', '2025-01-07', 49, NULL, 'khachhang', 1),
(174, 'c', '2025-01-07', 49, 1, 'nhanvien', 1),
(175, 'a', '2025-01-07', 49, NULL, 'khachhang', 1),
(176, 'a', '2025-01-07', 49, NULL, 'khachhang', 1),
(177, 'a', '2025-01-07', 49, NULL, 'khachhang', 1),
(178, 'c', '2025-01-07', 49, NULL, 'khachhang', 1),
(179, 'alo', '2025-01-07', 49, NULL, 'khachhang', 1),
(180, 'gì', '2025-01-07', 49, 1, 'nhanvien', 1),
(181, 'ko có gisssssss', '2025-01-07', 49, NULL, 'khachhang', 1),
(182, 'eee', '2025-01-07', 49, 1, 'nhanvien', 1),
(183, 'a', '2025-01-07', 49, NULL, 'khachhang', 1),
(184, 'ffff', '2025-01-07', 49, 1, 'nhanvien', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietgiohang`
--

DROP TABLE IF EXISTS `chitietgiohang`;
CREATE TABLE IF NOT EXISTS `chitietgiohang` (
  `idctgh` int NOT NULL AUTO_INCREMENT,
  `soluong` int NOT NULL,
  `idgh` int NOT NULL,
  `idctsp` int NOT NULL,
  PRIMARY KEY (`idctgh`),
  KEY `idctsp` (`idctsp`),
  KEY `idgh` (`idgh`)
) ENGINE=InnoDB AUTO_INCREMENT=272 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietgiohang`
--

INSERT INTO `chitietgiohang` (`idctgh`, `soluong`, `idgh`, `idctsp`) VALUES
(153, 2, 5, 53),
(270, 4, 4, 47),
(271, 1, 4, 49);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiethoadon`
--

DROP TABLE IF EXISTS `chitiethoadon`;
CREATE TABLE IF NOT EXISTS `chitiethoadon` (
  `idcthd` int NOT NULL AUTO_INCREMENT,
  `soluong` int NOT NULL,
  `idhd` int DEFAULT NULL,
  `idctsp` int NOT NULL,
  PRIMARY KEY (`idcthd`),
  KEY `idctsp` (`idctsp`),
  KEY `iddh` (`idhd`)
) ENGINE=InnoDB AUTO_INCREMENT=404 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiethoadon`
--

INSERT INTO `chitiethoadon` (`idcthd`, `soluong`, `idhd`, `idctsp`) VALUES
(284, 1, 243, 53),
(285, 1, 244, 47),
(287, 1, 246, 47),
(288, 1, 246, 49),
(326, 1, 284, 47),
(327, 5, 285, 47),
(328, 1, 285, 49),
(329, 1, 285, 50),
(330, 1, 286, 54),
(331, 1, 286, 55),
(332, 1, 287, 47),
(336, 11, 293, 47),
(337, 9, 294, 47),
(338, 10, 296, 47),
(339, 10, 297, 47),
(340, 1, 299, 48),
(341, 2, 300, 47),
(342, 3, 301, 47),
(343, 1, 302, 47),
(348, 2, 307, 47),
(349, 4, 308, 47),
(391, 3, 421, 47),
(397, 4, 427, 47),
(401, 3, 432, 47),
(402, 5, 433, 47),
(403, 1, 434, 47);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietsanpham`
--

DROP TABLE IF EXISTS `chitietsanpham`;
CREATE TABLE IF NOT EXISTS `chitietsanpham` (
  `idctsp` int NOT NULL AUTO_INCREMENT,
  `soluong` int NOT NULL,
  `idsp` int DEFAULT NULL,
  `idkt` int DEFAULT NULL,
  `idm` int DEFAULT NULL,
  PRIMARY KEY (`idctsp`),
  KEY `idsp` (`idsp`),
  KEY `idkt` (`idkt`),
  KEY `idm` (`idm`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietsanpham`
--

INSERT INTO `chitietsanpham` (`idctsp`, `soluong`, `idsp`, `idkt`, `idm`) VALUES
(47, 950, 31, 15, 23),
(48, 0, 31, 15, 20),
(49, 1, 31, 17, 23),
(50, 0, 31, 18, 23),
(53, 0, 32, 15, 23),
(54, 0, 32, 15, 22),
(55, 0, 32, 16, 23),
(56, 0, 33, 15, 23),
(58, 0, 33, 16, 23),
(59, 4444, 34, 15, 20),
(60, 10, 33, 15, 20);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgia`
--

DROP TABLE IF EXISTS `danhgia`;
CREATE TABLE IF NOT EXISTS `danhgia` (
  `iddg` int NOT NULL AUTO_INCREMENT,
  `sosao` int NOT NULL,
  `noidung` varchar(255) NOT NULL,
  `thoigian` date DEFAULT NULL,
  `idkh` int NOT NULL,
  `idctsp` int DEFAULT NULL,
  PRIMARY KEY (`iddg`),
  KEY `idctsp` (`idctsp`),
  KEY `idnd` (`idkh`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `danhgia`
--

INSERT INTO `danhgia` (`iddg`, `sosao`, `noidung`, `thoigian`, `idkh`, `idctsp`) VALUES
(15, 5, 'aaaaaaaaa', '2025-01-10', 49, 53),
(16, 4, 'aaaaaaa', '2025-01-10', 50, 54),
(18, 5, 'aaaaaaaa', '2025-01-10', 49, 47),
(19, 5, 'aaaaaaa', '2025-01-10', 49, 49),
(20, 4, 'aaaaaaaaaaaaacccccccccccc', '2025-01-10', 49, 53);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmucsanpham`
--

DROP TABLE IF EXISTS `danhmucsanpham`;
CREATE TABLE IF NOT EXISTS `danhmucsanpham` (
  `iddm` int NOT NULL AUTO_INCREMENT,
  `ten` varchar(100) NOT NULL,
  `gioitinh` tinyint NOT NULL,
  PRIMARY KEY (`iddm`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmucsanpham`
--

INSERT INTO `danhmucsanpham` (`iddm`, `ten`, `gioitinh`) VALUES
(1, 'Áo bé trai', 0),
(2, 'Quần bé trai', 0),
(6, 'Áo bé gái', 1),
(8, 'Set đồ bé trai', 0),
(9, 'Set đồ bé gái', 1),
(10, 'Quần bé gái', 1),
(12, 'Đầm váy bé gái', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diachi`
--

DROP TABLE IF EXISTS `diachi`;
CREATE TABLE IF NOT EXISTS `diachi` (
  `iddc` int NOT NULL AUTO_INCREMENT,
  `tennguoinhan` varchar(100) NOT NULL,
  `sdt` int NOT NULL,
  `diachi` varchar(100) NOT NULL,
  `phuongxa` varchar(100) NOT NULL,
  `quanhuyen` varchar(100) NOT NULL,
  `tinhthanhpho` varchar(100) NOT NULL,
  `idkh` int DEFAULT NULL,
  PRIMARY KEY (`iddc`),
  KEY `idkh` (`idkh`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `diachi`
--

INSERT INTO `diachi` (`iddc`, `tennguoinhan`, `sdt`, `diachi`, `phuongxa`, `quanhuyen`, `tinhthanhpho`, `idkh`) VALUES
(43, 'bbb', 363575163, 'b', 'b', 'b', 'aaaaaaaaaaa', 49),
(44, 'ddddd', 363575163, 'c', 'd', 'd', 'ddd', 49),
(69, 'anh 13', 988412441, '1222 Cao Lỗ', 'Phường 8', 'Quận 8', 'TPHCM', NULL),
(70, 'anh 14', 988412323, '1444 Cao Lỗ', 'Phường 8', 'Quận 8', 'T', NULL),
(71, 'anh 15', 988412441, '1442 Cao Lỗ', 'Phường 8', 'Quận 8', 'TPHCM', 63),
(73, 'anh hiếu', 363575163, '180 Cao Lỗ', 'Phường 8', 'Quận 8', 'TPHCM', NULL),
(76, 'anh tùng', 363575163, '12133 Cao Lỗ', 'Phường 8', 'Quận 8', 'TPHCM', NULL),
(77, 'anh 156', 988412441, '1442 Cao Lỗ', 'Phường 8', 'Quận 8', 'TPHCM', 66),
(78, 'bbb', 363575163, 'b', 'b', 'b', 'aaaaaaaaaaa', NULL),
(79, 'bbb', 363575163, 'b', 'b', 'b', 'aaaaaaaaaaa', NULL),
(80, 'bbb', 363575163, 'b', 'b', 'b', 'aaaaaaaaaaa', NULL),
(81, 'bbb', 363575163, 'b', 'b', 'b', 'aaaaaaaaaaa', NULL),
(82, 'bbb1', 363575163, 'b1', 'b1', 'b1', 'aaaaaaaaaaa1', NULL),
(83, 'bbb1', 363575163, 'b1', 'b1', 'b1', 'aaaaaaaaaaa1', NULL),
(84, 'bbb1', 363575163, 'b1', 'b1', 'b1', 'aaaaaaaaaaa1', NULL),
(85, 'bbb1', 363575163, 'b1', 'b1', 'b1', 'aaaaaaaaaaa1', NULL),
(86, 'bbb12', 363575163, 'b12', 'b12', 'b12', 'aaaaaaaaaaa12', NULL),
(87, 'bbb12', 363575163, 'b12', 'b12', 'b12', 'aaaaaaaaaaa12', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donvivanchuyen`
--

DROP TABLE IF EXISTS `donvivanchuyen`;
CREATE TABLE IF NOT EXISTS `donvivanchuyen` (
  `iddvvc` int NOT NULL AUTO_INCREMENT,
  `ten` varchar(200) NOT NULL,
  PRIMARY KEY (`iddvvc`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `donvivanchuyen`
--

INSERT INTO `donvivanchuyen` (`iddvvc`, `ten`) VALUES
(2, 'Giao hàng tiết kiệm'),
(3, 'Grab'),
(6, 'Giao hàng nhanh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giamgia`
--

DROP TABLE IF EXISTS `giamgia`;
CREATE TABLE IF NOT EXISTS `giamgia` (
  `idgg` int NOT NULL AUTO_INCREMENT,
  `code` varchar(100) DEFAULT NULL,
  `phantram` int NOT NULL,
  `mota` varchar(255) NOT NULL,
  `soluong` int NOT NULL,
  `ngaybatdau` date NOT NULL,
  `ngayketthuc` date NOT NULL,
  PRIMARY KEY (`idgg`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `giamgia`
--

INSERT INTO `giamgia` (`idgg`, `code`, `phantram`, `mota`, `soluong`, `ngaybatdau`, `ngayketthuc`) VALUES
(5, 'không giảm', 0, 'đây là mã không có giảm giá', 10000000, '2024-11-07', '2024-12-14'),
(7, 'GIANGSINH2024', 20, 'Mã giảm giáng sinh', 10000, '2024-12-01', '2024-12-31'),
(8, 'TRUYANKHACHHANG', 5, 'Dành cho 1 số sản phẩm mới', 10000, '2024-10-29', '2028-10-29'),
(9, 'TONKHO', 10, 'Giảm giá cho 1 số sản phẩm tồn kho', 500, '2024-10-29', '2024-11-29'),
(10, 'aa', 100, 'aaaaaaaaaaa', 10, '0000-00-00', '0000-00-00'),
(11, 'FREESHIP', 0, 'Mã free ship', 10000, '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

DROP TABLE IF EXISTS `giohang`;
CREATE TABLE IF NOT EXISTS `giohang` (
  `idgh` int NOT NULL AUTO_INCREMENT,
  `idkh` int NOT NULL,
  PRIMARY KEY (`idgh`),
  KEY `idnd` (`idkh`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `giohang`
--

INSERT INTO `giohang` (`idgh`, `idkh`) VALUES
(4, 49),
(5, 50);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hinhanh`
--

DROP TABLE IF EXISTS `hinhanh`;
CREATE TABLE IF NOT EXISTS `hinhanh` (
  `idh` int NOT NULL AUTO_INCREMENT,
  `duongdan` varchar(255) NOT NULL,
  `idsp` int DEFAULT NULL,
  `idctsp` int DEFAULT NULL,
  PRIMARY KEY (`idh`),
  KEY `idsp` (`idsp`) USING BTREE,
  KEY `idctsp` (`idctsp`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=297 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `hinhanh`
--

INSERT INTO `hinhanh` (`idh`, `duongdan`, `idsp`, `idctsp`) VALUES
(259, '1736281414-hinhchinh.png', 31, NULL),
(271, '1736318919-hinhchinh.png', 33, NULL),
(278, '1736319333-hinhchinh.png', 32, NULL),
(286, '1736321446-hinhphu.png', NULL, 47),
(287, '1736321454-hinhphu.png', NULL, 49),
(288, '1736321462-hinhphu.png', NULL, 50),
(289, '1736321472-hinhphu.png', NULL, 48),
(291, '1736323142-hinhphu.png', NULL, 53),
(292, '1736323208-hinhphu.jpeg', NULL, 56),
(293, '1736323373-hinhphu.png', NULL, 54),
(294, '1736323382-hinhphu.png', NULL, 55),
(295, '1736587690-hinhphu.jpg', NULL, 58),
(296, '1736620446-hinhphu.png', NULL, 60);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadon`
--

DROP TABLE IF EXISTS `hoadon`;
CREATE TABLE IF NOT EXISTS `hoadon` (
  `idhd` int NOT NULL AUTO_INCREMENT,
  `tongtien` int DEFAULT NULL,
  `ngaydathang` date DEFAULT NULL,
  `ngaynhanhang` date DEFAULT NULL,
  `ngaylap` date DEFAULT NULL,
  `idgg` int DEFAULT NULL,
  `idpttt` int NOT NULL,
  `idttdh` int NOT NULL,
  `idkh` int DEFAULT NULL,
  `iddc` int NOT NULL,
  `idptgh` int NOT NULL,
  `idnv` int DEFAULT NULL,
  PRIMARY KEY (`idhd`),
  KEY `idgg` (`idgg`) USING BTREE,
  KEY `idptgh` (`idptgh`) USING BTREE,
  KEY `idpttt` (`idpttt`) USING BTREE,
  KEY `idttdh` (`idttdh`) USING BTREE,
  KEY `idnd` (`idkh`) USING BTREE,
  KEY `iddc` (`iddc`) USING BTREE,
  KEY `idnv` (`idnv`)
) ENGINE=InnoDB AUTO_INCREMENT=435 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `hoadon`
--

INSERT INTO `hoadon` (`idhd`, `tongtien`, `ngaydathang`, `ngaynhanhang`, `ngaylap`, `idgg`, `idpttt`, `idttdh`, `idkh`, `iddc`, `idptgh`, `idnv`) VALUES
(243, 112000, '2025-01-08', '2025-01-13', '2025-01-08', NULL, 2, 9, 49, 44, 5, NULL),
(244, 105000, '2025-01-08', '2025-01-11', '2025-01-08', NULL, 2, 5, 49, 43, 6, NULL),
(246, 172000, '2025-01-10', '2025-01-15', '2025-01-10', NULL, 2, 6, 49, 43, 5, NULL),
(284, 92000, '2025-01-11', '2025-01-16', '2025-01-11', NULL, 2, 5, 49, 43, 5, NULL),
(285, 572000, '2025-01-11', '2025-01-16', '2025-01-11', NULL, 2, 9, 49, 44, 5, NULL),
(286, 212000, '2025-01-11', '2025-01-16', '2025-01-11', NULL, 2, 9, 49, 44, 5, NULL),
(287, 92000, '2025-01-11', '2025-01-16', '2025-01-11', NULL, 2, 9, 49, 44, 5, NULL),
(297, 800000, '2025-01-13', '2025-01-13', '2025-01-13', NULL, 1, 13, NULL, 69, 3, 1),
(299, 80000, '2025-01-14', '2025-01-14', '2025-01-14', NULL, 1, 13, NULL, 70, 3, 5),
(302, 80000, '2025-01-14', '2025-01-14', '2025-01-14', NULL, 1, 13, 63, 71, 3, 1),
(307, 172000, '2025-01-15', '2025-01-20', NULL, NULL, 2, 1, 65, 76, 5, NULL),
(308, 320000, '2025-01-15', '2025-01-15', '2025-01-15', NULL, 1, 13, 66, 77, 3, NULL),
(421, 252000, '2025-01-16', '2025-01-21', NULL, NULL, 2, 5, 49, 44, 5, NULL),
(427, 345000, '2025-01-16', '2025-01-19', NULL, NULL, 3, 1, 69, 80, 6, NULL),
(432, 350000, '2025-01-16', '2025-01-17', NULL, NULL, 2, 1, 74, 85, 7, NULL),
(433, 510000, '2025-01-16', '2025-01-17', NULL, NULL, 2, 1, 75, 86, 7, NULL),
(434, 105000, '2025-01-16', '2025-01-19', NULL, NULL, 3, 1, 76, 87, 6, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

DROP TABLE IF EXISTS `khachhang`;
CREATE TABLE IF NOT EXISTS `khachhang` (
  `idkh` int NOT NULL AUTO_INCREMENT,
  `ten` varchar(100) DEFAULT NULL,
  `sdt` int DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `matkhau` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `block` tinyint DEFAULT NULL,
  PRIMARY KEY (`idkh`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`idkh`, `ten`, `sdt`, `email`, `matkhau`, `block`) VALUES
(49, 'hiu12346', 363573333, 'nhocty21@gmail.com', '$2y$10$rpDmGhSN5mE/ppams984euLumTu6uF0VAUHPhuqbXU8PySmk5gOg6', 0),
(50, 'hiu2', 363575163, 'minhnhat2@gmail.com', '$2y$10$cpJfXEjnynU5kECUhiJjJepTp9f.NwExPkIB9tp9pg4GHaLT7MJIK', 0),
(51, 'hiu3', 363575163, 'minhnhat3@gmail.com', '$2y$10$2.EAsIfl9wXEKb9wnPU1COyY8cJD6cQK/./cM50PmGe87LIVbAyZW', 0),
(52, 'hiu4', 363575163, 'minhnhat4@gmail.com', '$2y$10$u/01hC8ArjMkaWT9C2Mhy.6ulv5IdoOhgGB3C6xmYtjSjTvth2OUi', 0),
(53, 'hiu5', 363575163, 'minhnhat5@gmail.com', '$2y$10$0R3mvbGzRPdfgj.0IBIWoe.AAJzax0mxsj3N/zkhBZY0GF5hBvy0i', 0),
(54, 'hiu6', 363575163, 'minhnhat6@gmail.com', '$2y$10$/FZMGboy2ajGHZrrqRMpo.1r3f62LgHIVQcq9qTx5DLIylOdljR/2', 0),
(55, 'hiu7', 363575163, 'minhnhat7@gmail.com', '$2y$10$FVNZDWioNU9cAikiFnuu1Om78TvDJJ/KABfjOfs92fX6jhvglQAxe', 0),
(56, 'hiu8', 363575163, 'minhnhat8@gmail.com', '$2y$10$b/51HS.gLtPK/vSjoqZ6O.vh1dvpaGkxVt.Zg7tTeJHp5khcJrE4q', 0),
(57, 'hiu9', 363575163, 'minhnhat9@gmail.com', '$2y$10$zEL8q6jZI8AJnqHdIlhlPuh34lUWNyd/SX4c9Y/FfysQHnrcyIU4S', 0),
(60, 'anh trai 1', 363575163, 'trungvu@gmail.com', '$2y$10$yqEQtqMpMeJL42PFUf5GiO.RgdhpIrUQLuOKTUuqpY4GI/CptwOgq', 1),
(62, 'hieunguyen12', 363575163, 'adadad@gmail.com', '$2y$10$GxT2CkZIcmacTCAqQA0LAeXbwQeFdkOPTkWctPp8flA9RqhZPYYPW', 0),
(63, 'anh 15', 988412441, NULL, NULL, NULL),
(64, 'anh tùng', 363575163, 'asdhjaaa@gmail.com', NULL, NULL),
(65, 'anh tùng', 363575163, 'liema4000@gmail.com', NULL, NULL),
(66, 'anh 156', 988412441, NULL, NULL, NULL),
(74, 'bbb1', 363575163, 'hieu.dh51903588@gmail.com', NULL, NULL),
(75, 'bbb12', 363575163, 'hieu.dh51903588@gmail.com', NULL, NULL),
(76, 'bbb12', 363575163, 'hieu.dh51903588@gmail.com', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khohang`
--

DROP TABLE IF EXISTS `khohang`;
CREATE TABLE IF NOT EXISTS `khohang` (
  `idkho` int NOT NULL AUTO_INCREMENT,
  `soluong` int NOT NULL,
  `ngaycapnhat` datetime NOT NULL,
  `nhacungcap` varchar(100) NOT NULL,
  `idsp` int DEFAULT NULL,
  PRIMARY KEY (`idkho`),
  KEY `idsp` (`idsp`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `kichthuoc`
--

DROP TABLE IF EXISTS `kichthuoc`;
CREATE TABLE IF NOT EXISTS `kichthuoc` (
  `idkt` int NOT NULL AUTO_INCREMENT,
  `ten` varchar(100) NOT NULL,
  `mota` varchar(255) NOT NULL,
  PRIMARY KEY (`idkt`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `kichthuoc`
--

INSERT INTO `kichthuoc` (`idkt`, `ten`, `mota`) VALUES
(15, 's1', '0-2 tuổi'),
(16, 's2', '2-3 tuổi'),
(17, 's3', '3-5 tuổi'),
(18, 's4', '5-7 tuổi');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisanpham`
--

DROP TABLE IF EXISTS `loaisanpham`;
CREATE TABLE IF NOT EXISTS `loaisanpham` (
  `idlsp` int NOT NULL AUTO_INCREMENT,
  `ten` varchar(100) NOT NULL,
  `iddm` int DEFAULT NULL,
  PRIMARY KEY (`idlsp`),
  KEY `iddm` (`iddm`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `loaisanpham`
--

INSERT INTO `loaisanpham` (`idlsp`, `ten`, `iddm`) VALUES
(1, 'Áo thun', 1),
(46, 'Quần jeans', 2),
(47, 'Quần kaki', 2),
(48, 'Áo khoác', 1),
(49, 'Áo thun', 6),
(50, 'Set đồ', 8),
(51, 'Áo sơ mi', 1),
(52, 'Áo khoác', 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaitintuc`
--

DROP TABLE IF EXISTS `loaitintuc`;
CREATE TABLE IF NOT EXISTS `loaitintuc` (
  `idltt` int NOT NULL AUTO_INCREMENT,
  `ten` varchar(100) NOT NULL,
  `mota` varchar(255) NOT NULL,
  PRIMARY KEY (`idltt`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `loaitintuc`
--

INSERT INTO `loaitintuc` (`idltt`, `ten`, `mota`) VALUES
(20, 'Thời trang cho bé', 'aaaaaaaaaaaaaaa'),
(21, 'Tin tức Nizi', 'bbbbbbbbbbbbbb'),
(23, 'Tin khuyến mãi', '11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mau`
--

DROP TABLE IF EXISTS `mau`;
CREATE TABLE IF NOT EXISTS `mau` (
  `idm` int NOT NULL AUTO_INCREMENT,
  `ten` varchar(100) NOT NULL,
  PRIMARY KEY (`idm`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `mau`
--

INSERT INTO `mau` (`idm`, `ten`) VALUES
(20, 'Xanh Than'),
(21, 'Đen'),
(22, 'Xám'),
(23, 'Trắng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

DROP TABLE IF EXISTS `nhanvien`;
CREATE TABLE IF NOT EXISTS `nhanvien` (
  `idnv` int NOT NULL AUTO_INCREMENT,
  `ten` varchar(100) NOT NULL,
  `chucvu` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `matkhau` varchar(100) NOT NULL,
  `sdt` int NOT NULL,
  PRIMARY KEY (`idnv`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`idnv`, `ten`, `chucvu`, `email`, `matkhau`, `sdt`) VALUES
(1, 'hải yến1', 'Nhân viên bán hàng', 'haiyen@gmail.com', '$2y$10$mj8KrS.Bc58OxbrTAwVmMuMK/mjJjNNvP9jGRjokcgzHom5Zaugl.', 399114313),
(2, 'aaaaaaa', 'Nhân viên kho', 'vandat@gmail.com', '$2y$10$f1vjBAeO.0bV/jAhz7UPherzBc7KcmqyQC35t7U5GxwIFMNpf9p82', 363575163),
(5, 'quỳnh ly', 'Nhân viên bán hàng', 'quynhly@gmail.com', '$2y$10$nTwYj1IPi0iSguT53HkzAu6YQNSCa79JABHyeuHXCVtidFqDVOnFy', 363575555);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phanhoi`
--

DROP TABLE IF EXISTS `phanhoi`;
CREATE TABLE IF NOT EXISTS `phanhoi` (
  `idph` int NOT NULL AUTO_INCREMENT,
  `noidung` varchar(255) NOT NULL,
  `thoigian` date NOT NULL,
  `idnv` int NOT NULL,
  `iddg` int NOT NULL,
  PRIMARY KEY (`idph`),
  KEY `idnd` (`idnv`) USING BTREE,
  KEY `iddg` (`iddg`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `phanhoi`
--

INSERT INTO `phanhoi` (`idph`, `noidung`, `thoigian`, `idnv`, `iddg`) VALUES
(6, 'ok', '2025-01-11', 1, 20),
(7, 'okssssss', '2025-01-14', 5, 19);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieugiaohang`
--

DROP TABLE IF EXISTS `phieugiaohang`;
CREATE TABLE IF NOT EXISTS `phieugiaohang` (
  `idpgh` int NOT NULL AUTO_INCREMENT,
  `iddvvc` int NOT NULL,
  `ghichu` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `idhd` int NOT NULL,
  `iddc` int NOT NULL,
  PRIMARY KEY (`idpgh`),
  KEY `iddh` (`idhd`),
  KEY `iddc` (`iddc`),
  KEY `iddvvc` (`iddvvc`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `phieugiaohang`
--

INSERT INTO `phieugiaohang` (`idpgh`, `iddvvc`, `ghichu`, `idhd`, `iddc`) VALUES
(24, 6, '1', 243, 44),
(26, 2, 'aaaaaaa', 246, 43),
(27, 2, '', 285, 44),
(28, 2, '', 286, 44),
(29, 3, '', 287, 44);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phuongthucgiaohang`
--

DROP TABLE IF EXISTS `phuongthucgiaohang`;
CREATE TABLE IF NOT EXISTS `phuongthucgiaohang` (
  `idptgh` int NOT NULL AUTO_INCREMENT,
  `ten` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `phigiaohang` int NOT NULL,
  `ngaydukien` int NOT NULL,
  `mota` varchar(255) NOT NULL,
  PRIMARY KEY (`idptgh`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `phuongthucgiaohang`
--

INSERT INTO `phuongthucgiaohang` (`idptgh`, `ten`, `phigiaohang`, `ngaydukien`, `mota`) VALUES
(3, 'Tại cửa hàng', 0, 0, 'Dành cho những khách hàng mua tại cửa hàng'),
(5, 'Thường', 12000, 5, 'Giao hàng từ 3-5 ngày'),
(6, 'Nhanh', 25000, 3, 'Giao hàng từ 1-3 ngày'),
(7, 'Siêu tốc', 110000, 1, 'Giao hàng từ 3-5 giờ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phuongthucthanhtoan`
--

DROP TABLE IF EXISTS `phuongthucthanhtoan`;
CREATE TABLE IF NOT EXISTS `phuongthucthanhtoan` (
  `idpttt` int NOT NULL AUTO_INCREMENT,
  `ten` varchar(100) NOT NULL,
  `mota` varchar(255) NOT NULL,
  PRIMARY KEY (`idpttt`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `phuongthucthanhtoan`
--

INSERT INTO `phuongthucthanhtoan` (`idpttt`, `ten`, `mota`) VALUES
(1, 'Tại cửa hàng', 'Dành cho khách hàng mua tại cửa hàng'),
(2, 'Thanh toán COD', 'Khi đơn hàng đến địa chỉ của bạn, bạn sẽ nhận được nó từ nhà vận chuyển. Bạn sẽ thanh toán số tiền mua hàng và phí vận chuyển cho nhân viên giao hàng trực tiếp bằng tiền mặt'),
(3, 'VNPay', 'Giao hàng từ 1 đến 3 ngày');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

DROP TABLE IF EXISTS `sanpham`;
CREATE TABLE IF NOT EXISTS `sanpham` (
  `idsp` int NOT NULL AUTO_INCREMENT,
  `ten` varchar(100) NOT NULL,
  `mota` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `soluong` int DEFAULT NULL,
  `gia` int NOT NULL,
  `chatlieu` varchar(100) NOT NULL,
  `moi` tinyint NOT NULL,
  `noibat` tinyint NOT NULL,
  `idgg` int DEFAULT NULL,
  `idth` int DEFAULT NULL,
  `idlsp` int DEFAULT NULL,
  PRIMARY KEY (`idsp`),
  KEY `idgg` (`idgg`) USING BTREE,
  KEY `idlsp` (`idlsp`) USING BTREE,
  KEY `idth` (`idth`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`idsp`, `ten`, `mota`, `soluong`, `gia`, `chatlieu`, `moi`, `noibat`, `idgg`, `idth`, `idlsp`) VALUES
(31, 'Áo khoác nỉ mũ dài tay TOKYO', '`1', NULL, 100000, 'vải coton', 1, 1, 7, 16, 48),
(32, 'Áo thun bé gái Tokyo', 'Áo thun bé gái Tokyo', NULL, 100000, 'vải coton', 1, 0, 5, 17, 49),
(33, 'Áo sơ mi dài tay thô Hàn', 'Áo sơ mi bé trai', NULL, 200000, 'vải coton', 0, 0, 5, 18, 51),
(34, 'Áo khoác Smile', 'Áo khoác Smile', NULL, 150000, '100% cotton', 0, 0, 5, 16, 48),
(35, 'Quần Kaki trẻ em M1', 'Quần Kaki trẻ em M1', NULL, 80000, 'vải coton', 0, 0, 5, 18, 47),
(36, 'Quần Kaki trẻ em NKJ', 'Quần Kaki trẻ em NKJ', NULL, 329000, 'vải coton', 0, 0, 5, 19, 47),
(37, 'Áo sơ mi dài tay thô Hàn M2', 'Áo sơ mi dài tay thô Hàn M2', NULL, 200000, 'vải coton', 0, 0, 5, 18, 51),
(38, 'Áo sơ mi dài tay MKK', 'Áo sơ mi dài tay MKK', NULL, 100000, 'Polyester', 0, 0, 5, 16, 51);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thuonghieu`
--

DROP TABLE IF EXISTS `thuonghieu`;
CREATE TABLE IF NOT EXISTS `thuonghieu` (
  `idth` int NOT NULL AUTO_INCREMENT,
  `ten` varchar(100) NOT NULL,
  PRIMARY KEY (`idth`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `thuonghieu`
--

INSERT INTO `thuonghieu` (`idth`, `ten`) VALUES
(16, 'Abikids'),
(17, 'Mizi'),
(18, 'Kidkuls'),
(19, 'MCBB');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tintuc`
--

DROP TABLE IF EXISTS `tintuc`;
CREATE TABLE IF NOT EXISTS `tintuc` (
  `idtt` int NOT NULL AUTO_INCREMENT,
  `tieude` varchar(100) NOT NULL,
  `noidung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ngaydang` datetime NOT NULL,
  `hinhanh` varchar(255) NOT NULL,
  `noibat` tinyint NOT NULL,
  `idltt` int DEFAULT NULL,
  PRIMARY KEY (`idtt`),
  KEY `idltt` (`idltt`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `tintuc`
--

INSERT INTO `tintuc` (`idtt`, `tieude`, `noidung`, `ngaydang`, `hinhanh`, `noibat`, `idltt`) VALUES
(77, 'Thời trang cho bé 1', 'Mùa xuân hè 2025, thời trang cho các bé yêu sẽ không còn đơn điệu với bộ sưu tập thiếu nhi mới đầy màu sắc và sáng tạo. Các thiết kế trong bộ sưu tập năm nay không chỉ chú trọng đến sự thoải mái, dễ chịu mà còn mang lại vẻ ngoài tươi mới, năng động cho các bé.<br /><br /><br /><br />\r\n<br /><br /><br /><br />\r\nVới sự kết hợp giữa các gam màu pastel nhẹ nhàng và họa tiết đáng yêu như hình thú, hoa lá hay các nhân vật hoạt hình, những bộ đồ này sẽ khiến các bé luôn nổi bật và tự tin khi chơi đùa cả ngày dài. Chất liệu vải mềm mại, thoáng khí như cotton, linen, cùng thiết kế thông minh giúp bé thoải mái vận động và vui chơi suốt mùa hè.<br /><br /><br /><br />\r\n<br /><br /><br /><br />\r\nNhững xu hướng thời trang thiếu nhi nổi bật xuân hè 2025:<br /><br /><br /><br />\r\n<br /><br /><br /><br />\r\nÁo thun họa tiết: Với hình ảnh sinh động và vui nhộn, những chiếc áo thun này sẽ là sự lựa chọn hoàn hảo cho những ngày hè sôi động.<br /><br /><br /><br />\r\nVáy xòe và đầm bồng bềnh: Đặc biệt dành cho các bé gái, với các chi tiết như ren, thêu, và nơ xinh xắn.<br /><br /><br /><br />\r\nQuần short và áo sơ mi: Thiết kế thoải mái, mát mẻ, lý tưởng cho các bé trai thích vận động.<br /><br /><br /><br />\r\nMàu sắc tươi sáng: Các tông màu như xanh da trời, hồng phấn, vàng chanh, mang lại sự vui tươi cho mùa hè.<br /><br /><br /><br />\r\nHãy đến cửa hàng của chúng tôi để khám phá những bộ sưu tập thời trang thiếu nhi mới nhất, giúp bé yêu của bạn luôn tự tin và phong cách trong mùa hè này!<br /><br /><br /><br />\r\n<br /><br /><br /><br />\r\nMẫu này mang lại cái nhìn tổng quan về thời trang thiếu nhi xuân hè 2025, với các xu hướng dễ thương, thoải mái và năng động cho các bé.', '2025-01-17 00:56:23', '1737049501-tintuc.png', 1, 20),
(78, 'Thời trang cho bé 2', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br /><br /><br /><br /><br />\r\n<br /><br /><br /><br /><br />\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2024-11-01 13:53:48', '1737049506-tintuc.png', 1, 20),
(79, 'Thời trang cho bé 3', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2024-11-01 14:25:30', '1737049535-tintuc.png', 1, 20),
(83, 'Thời trang cho bé 4', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br />', '2024-11-02 07:52:35', '1737049569-tintuc.png', 1, 20),
(84, 'Tin tức Nizi 1', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2024-11-08 14:46:18', '1737049814-tintuc.jpg', 0, 21),
(85, 'Tin tức Nizi 2', 'aaaaaaaaaaaaaaaaaaaaaaaaa', '2025-01-17 00:53:14', '1737049819-tintuc.jpg', 0, 21),
(86, 'Tin khuyến mãi 1', 'aaaaaaaaaaaaaaaaaa1', '2025-01-17 00:53:06', '1737049851-tintuc.jpg', 0, 23);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trangthaidonhang`
--

DROP TABLE IF EXISTS `trangthaidonhang`;
CREATE TABLE IF NOT EXISTS `trangthaidonhang` (
  `idttdh` int NOT NULL AUTO_INCREMENT,
  `ten` varchar(100) NOT NULL,
  `mota` varchar(255) NOT NULL,
  PRIMARY KEY (`idttdh`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `trangthaidonhang`
--

INSERT INTO `trangthaidonhang` (`idttdh`, `ten`, `mota`) VALUES
(1, 'Chờ xác nhận', 'Đơn hàng đã được đặt và đang chờ xác nhận từ phía cửa hàng hoặc người bán.'),
(5, 'Đã xác nhận', 'Đơn hàng đã được xác nhận.'),
(6, 'Đã hủy', 'Hủy đơn hàng'),
(7, 'Đã bàn giao cho đơn vị vận chuyển', 'Đơn hàng đã được bàn giao cho đơn vị vận chuyển. Vui lòng theo dõi đơn hàng'),
(8, 'Đang vận chuyển', 'Đơn hàng đang vận chuyển và không thể hủy. Vui lòng theo dõi đơn hàng'),
(9, 'Giao hàng thành công', 'Đơn hàng đã được giao tới.'),
(10, 'Đã đóng gói', 'Đơn hàng đã được đóng gói.'),
(11, 'Hoàn tiền thành công', 'Khách hàng hoàn tiền sản phẩm bị lỗi'),
(12, 'Yêu cầu hoàn tiền', 'Yêu cầu hoàn tiền'),
(13, 'Mua hàng thành công', 'Mua hàng thành công');

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`idkh`) REFERENCES `khachhang` (`idkh`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`idnv`) REFERENCES `nhanvien` (`idnv`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Các ràng buộc cho bảng `chitietsanpham`
--
ALTER TABLE `chitietsanpham`
  ADD CONSTRAINT `chitietsanpham_ibfk_1` FOREIGN KEY (`idkt`) REFERENCES `kichthuoc` (`idkt`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `chitietsanpham_ibfk_2` FOREIGN KEY (`idm`) REFERENCES `mau` (`idm`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `chitietsanpham_ibfk_3` FOREIGN KEY (`idsp`) REFERENCES `sanpham` (`idsp`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
