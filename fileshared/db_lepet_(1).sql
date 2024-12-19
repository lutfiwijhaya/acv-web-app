-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 02:39 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_lepet`
--

-- --------------------------------------------------------

--
-- Table structure for table `file_shared`
--

CREATE TABLE `file_shared` (
  `id` int(11) NOT NULL,
  `level1` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `name_file` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `size` varchar(255) DEFAULT NULL,
  `type_file` varchar(255) DEFAULT NULL,
  `link` text NOT NULL,
  `remark` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `file_shared`
--

INSERT INTO `file_shared` (`id`, `level1`, `Description`, `name_file`, `upload_date`, `size`, `type_file`, `link`, `remark`) VALUES
(33, 'Piping', 'List', 'DRAWING LIST.xlsx', '2024-11-24 15:48:58', '3.04 MB', 'Excel Document', 'https://www.achivon.co.id/fileshared/DRAWING_LIST.xlsx', ''),
(34, 'Piping', 'CAD Drawing', '2C02400-42-2-0018 (220).dwg', '2024-11-24 15:49:53', '0.10 MB', 'AutoCAD File', 'https://www.achivon.co.id/fileshared/2C02400-42-2-0018_(220).dwg', 'File Folder A'),
(35, 'Equipment', 'Equipment List', 'Structure Drawing List.xlsx', '2024-11-29 16:06:35', '0.04 MB', 'Excel Document', 'http://localhost/cka-pot-master/fileshared/Structure_Drawing_List.xlsx', ''),
(36, 'Equipment', 'Inspection Report', '20241128 - Drawing List Status - QTY.xlsx', '2024-11-29 16:06:46', '0.06 MB', 'Excel Document', 'http://localhost/cka-pot-master/fileshared/20241128_-_Drawing_List_Status_-_QTY.xlsx', '');

-- --------------------------------------------------------

--
-- Table structure for table `params`
--

CREATE TABLE `params` (
  `id` int(11) NOT NULL,
  `param_name` varchar(255) NOT NULL,
  `param_group` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` int(30) DEFAULT NULL,
  `delete_at` int(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `params`
--

INSERT INTO `params` (`id`, `param_name`, `param_group`, `status`, `remark`, `created_at`, `updated_at`, `is_deleted`, `delete_at`) VALUES
(16, 'TCS', 'category', '', 'Tools Control System', '2024-09-10 04:19:29', '2024-09-19 02:36:25', NULL, NULL),
(17, 'CCS', 'category', '', 'Consumable Control System', '2024-09-10 04:19:42', '2024-09-19 02:36:38', NULL, NULL),
(18, 'EA', 'inisial_kuantitas', '', '', '2024-09-10 06:49:06', '2024-09-10 06:49:06', NULL, NULL),
(19, 'Meter', 'inisial_kuantitas', '', '', '2024-09-10 06:49:23', '2024-09-10 06:49:23', NULL, NULL),
(20, 'Kg', 'inisial_kuantitas', '', '', '2024-09-10 06:49:43', '2024-09-10 06:49:43', NULL, NULL),
(31, 'Warehouse', 'distribution_value', '', 'wh_warehouse', '2024-09-18 01:39:06', '2024-09-18 01:39:06', NULL, NULL),
(32, 'Employee', 'distribution_value', '', 'tbl_user', '2024-09-18 01:39:33', '2024-09-18 01:39:33', NULL, NULL),
(33, 'Supplier', 'distribution_value', '', 'tbl_suplayer', '2024-09-18 01:40:05', '2024-09-23 09:14:24', NULL, NULL),
(34, 'ECS', 'category', '', '', '2024-09-19 02:35:41', '2024-09-19 02:35:41', NULL, NULL),
(35, 'MCS', 'category', '', '', '2024-09-19 02:35:49', '2024-09-19 02:35:49', NULL, NULL),
(36, 'SCS', 'category', '', '', '2024-09-19 02:36:03', '2024-09-19 02:36:03', NULL, NULL),
(37, 'Power Tools', 'wh_level_1', '1', '', '2024-09-19 02:49:58', '2024-09-19 02:49:58', NULL, NULL),
(38, 'Non Power Tools', 'wh_level_1', '2', '', '2024-09-19 02:50:16', '2024-09-19 02:50:16', NULL, NULL),
(39, 'Wire', 'wh_level_2', '10', 'Power Tools', '2024-09-19 02:51:50', '2024-09-19 07:45:06', NULL, NULL),
(40, 'Wireless', 'wh_level_2', '20', 'Power Tools', '2024-09-19 02:52:27', '2024-09-19 02:52:27', NULL, NULL),
(41, 'Non Power Tools', 'wh_level_2', '10', 'Non Power Tools', '2024-09-19 06:47:00', '2024-09-19 06:47:00', NULL, NULL),
(42, 'Kunci Inggris', 'wh_level_3', '100', 'Non Power Tools', '2024-09-19 06:48:54', '2024-09-19 06:48:54', NULL, NULL),
(43, '6\"', 'wh_level_4', '10', 'Kunci Inggris', '2024-09-19 06:49:33', '2024-09-19 06:49:33', NULL, NULL),
(44, '8\"', 'wh_level_4', '11', 'Kunci Inggris', '2024-09-19 06:51:02', '2024-09-19 06:51:02', NULL, NULL),
(45, '10\"', 'wh_level_4', '12', 'Kunci Inggris', '2024-09-19 06:51:26', '2024-09-19 06:51:26', NULL, NULL),
(46, '12\"', 'wh_level_4', '13', 'Kunci Inggris', '2024-09-19 06:59:03', '2024-09-19 06:59:03', NULL, NULL),
(47, '15\"', 'wh_level_4', '14', 'Kunci Inggris', '2024-09-19 06:59:33', '2024-09-19 06:59:33', NULL, NULL),
(48, '18\"', 'wh_level_4', '15', 'Kunci Inggris', '2024-09-19 06:59:53', '2024-09-19 06:59:53', NULL, NULL),
(49, '24\"', 'wh_level_4', '16', 'Kunci Inggris', '2024-09-19 07:00:23', '2024-09-19 07:00:23', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `procurement_po`
--

CREATE TABLE `procurement_po` (
  `id` int(30) NOT NULL,
  `po_number` int(255) NOT NULL,
  `Supplier_id` int(30) NOT NULL,
  `po_date` date NOT NULL,
  `expeted_date` date NOT NULL,
  `total_amount` int(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `_id` int(11) NOT NULL,
  `kode_barang` char(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `harga_barang` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_barang`
--

INSERT INTO `tbl_barang` (`_id`, `kode_barang`, `nama_barang`, `harga_barang`, `stok`, `created_at`) VALUES
(1, 'P-001', 'Panci Ajaib', 700000, 80, '2021-02-14 04:18:50'),
(2, 'P-002', 'Panci Kurang Ajaib Tapi Boong', 1000000, 128, '2021-01-28 15:41:06'),
(3, 'P-003', 'Panci Anti Perang', 1500000, 149, '2021-02-13 14:41:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang_masuk`
--

CREATE TABLE `tbl_barang_masuk` (
  `_id` int(11) NOT NULL,
  `kode_faktur` char(15) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_barang_masuk`
--

INSERT INTO `tbl_barang_masuk` (`_id`, `kode_faktur`, `id_barang`, `jumlah`, `tgl_masuk`, `created_at`) VALUES
(24, 'm-001', 1, 50, '2021-01-20', '2021-01-20 15:53:53'),
(25, 'M-002', 3, 50, '2021-02-13', '2021-02-13 14:41:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_catatan`
--

CREATE TABLE `tbl_catatan` (
  `_id` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_catatan`
--

INSERT INTO `tbl_catatan` (`_id`, `id_penjualan`, `catatan`) VALUES
(1, 1, 'test'),
(2, 1, 'dfgdkfghdlfgh');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_levels`
--

CREATE TABLE `tbl_levels` (
  `_id` int(11) NOT NULL,
  `id_posisi` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_levels`
--

INSERT INTO `tbl_levels` (`_id`, `id_posisi`, `id_menu`) VALUES
(2, 1, 2),
(3, 1, 3),
(4, 1, 5),
(5, 1, 6),
(6, 1, 7),
(7, 1, 9),
(8, 1, 8),
(9, 1, 10),
(10, 1, 13),
(11, 1, 14),
(12, 1, 15),
(13, 1, 1),
(14, 2, 1),
(15, 2, 2),
(16, 2, 5),
(23, 5, 5),
(24, 5, 7),
(25, 5, 8),
(26, 5, 9),
(27, 6, 8),
(28, 6, 10),
(29, 8, 5),
(30, 8, 6),
(31, 8, 7),
(32, 1, 16),
(33, 1, 17),
(34, 1, 18),
(35, 1, 19),
(36, 1, 20),
(37, 2, 17),
(38, 2, 19),
(39, 2, 16),
(40, 1, 21),
(42, 1, 22),
(43, 1, 23),
(44, 1, 24);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menus`
--

CREATE TABLE `tbl_menus` (
  `_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `is_main` int(11) NOT NULL,
  `is_aktif` int(11) NOT NULL,
  `ordinal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_menus`
--

INSERT INTO `tbl_menus` (`_id`, `title`, `uri`, `icon`, `is_main`, `is_aktif`, `ordinal`) VALUES
(1, 'Users', '#', 'fa fa-users', 0, 1, 1),
(2, 'Pegawai', 'admin/users', 'fa fa-user', 1, 1, 1),
(3, 'Posisi', 'admin/posisi', 'fas fa-user-shield', 1, 1, 2),
(5, 'Warehouse', '#', 'fa fa-warehouse', 0, 1, 3),
(6, 'Barang masuk', 'admin/barang', 'fa fa-truck-loading', 5, 0, 1),
(7, 'Barang', 'admin/barang', 'fas fa-boxes', 5, 0, 2),
(8, 'Transaksi', '#', 'fa fa-cash-register', 0, 0, 3),
(9, 'Penjualan', 'admin/penjualan', 'fa fa-file-invoice-dollar', 8, 1, 1),
(10, 'Penagihan', 'admin/penagihan', 'fas fa-receipt', 8, 0, 2),
(13, 'Laporan', '#', 'fa fa-file-invoice-dollar', 0, 0, 4),
(14, 'Aplikasi', '#', 'fas fa-cog', 0, 1, 0),
(15, 'Menu Aplikasi', 'admin/menu', 'fas fa-cog', 14, 1, 1),
(16, 'Items Management', 'admin/stock', 'fas fa-boxes', 5, 1, 1),
(17, 'Distribution Management', 'admin/distribution', 'fas fa-boxes', 5, 1, 2),
(18, 'Report', '#', 'fas fa-boxes', 5, 0, 6),
(19, 'Warehouse Management', '#', 'fas fa-boxes', 5, 1, 5),
(20, 'Params', 'admin/params', 'fas fa-cog', 14, 1, 2),
(21, 'Request Item', 'admin/requestitem', 'fas fa-clipboard-list', 5, 1, 4),
(22, 'Supplier', 'admin/supplier', 'far fa-handshake', 23, 1, 1),
(23, 'Procurement', '#', 'fa fa-shopping-basket', 0, 1, 1),
(24, 'Purchase Order', 'admin/po', 'fas fa-cart-plus', 23, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penagihan`
--

CREATE TABLE `tbl_penagihan` (
  `_id` int(11) NOT NULL,
  `kode_bayar` char(11) NOT NULL,
  `no_faktur` char(11) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `id_user` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_penagihan`
--

INSERT INTO `tbl_penagihan` (`_id`, `kode_bayar`, `no_faktur`, `total_bayar`, `tgl_bayar`, `id_user`, `status`, `created_at`) VALUES
(1, 'F-001-1', 'F-001', 100000, '2021-02-01', 1, '1', '2021-02-14 05:23:00'),
(2, 'F-001-2', 'F-001', 500000, '2021-02-11', 1, '0', '2021-02-11 14:16:54'),
(3, 'F-002-1', 'F-002', 70000, '2021-02-11', 1, '0', '2021-02-11 14:19:30'),
(4, 'F-001-3', 'F-001', 70000, '2021-02-11', 1, '0', '2021-01-01 14:20:40'),
(5, 'F-001-4', 'F-001', 50000, '2021-02-11', 1, '0', '2021-02-11 14:58:25'),
(6, 'F-004-1', 'F-004', 700000, '2021-02-12', 1, '0', '2021-02-12 15:00:21'),
(7, 'F-001-5', 'F-001', 50000, '2021-02-13', 1, '0', '2021-02-13 14:04:05'),
(8, 'F-005-1', 'F-005', 100000, '2021-01-01', 1, '0', '2021-02-13 14:05:37'),
(9, 'F-006-1', 'F-006', 700000, '2021-02-13', 1, '0', '2021-02-13 14:06:21'),
(10, 'F-007-1', 'F-007', 300000, '2021-01-14', 1, '0', '2021-02-13 14:41:45'),
(12, 'F-008-1', 'F-008', 70000, '2021-02-14', 1, '0', '2021-02-14 04:18:50'),
(13, 'F-008-2', 'F-008', 70000, '2021-02-14', 1, '0', '2021-02-14 04:24:05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penjualan`
--

CREATE TABLE `tbl_penjualan` (
  `_id` int(11) NOT NULL,
  `no_faktur` char(11) NOT NULL,
  `nama_pembeli` varchar(255) NOT NULL,
  `alamat` longtext NOT NULL,
  `no_telp` varchar(50) NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_user` char(11) NOT NULL,
  `id_penagih` int(11) NOT NULL,
  `status_bayar` enum('0','1','2') NOT NULL,
  `status_penjualan` int(11) NOT NULL,
  `tgl_tempo` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `status_approve` enum('0','1') NOT NULL DEFAULT '0',
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_penjualan`
--

INSERT INTO `tbl_penjualan` (`_id`, `no_faktur`, `nama_pembeli`, `alamat`, `no_telp`, `tgl_transaksi`, `id_barang`, `id_user`, `id_penagih`, `status_bayar`, `status_penjualan`, `tgl_tempo`, `total`, `status_approve`, `last_update`) VALUES
(1, 'F-001', 'Lukman', 'test', '213', '2021-02-01', 1, '1', 5, '1', 7, 6, 700000, '1', '2021-02-11 14:22:04'),
(2, 'F-002', 'L', 'kjkj', '4293792834', '2021-02-11', 1, '1', 6, '1', 10, 10, 700000, '1', '2021-02-14 04:56:52'),
(4, 'F-003', 'Hadi', 'Mars', '123123123', '2021-02-12', 1, '1', 7, '0', 0, 0, 700000, '1', '2021-02-12 14:54:00'),
(5, 'F-004', 'Lukman Hadi', 'TEST', '3412341234', '2021-02-12', 1, '1', 7, '0', 0, 0, 700000, '1', '2021-02-12 15:00:44'),
(6, 'F-005', 'JUPLe', 'glc', '555', '2021-01-01', 1, '1', 6, '1', 7, 5, 700000, '1', '2021-02-13 14:45:33'),
(7, 'F-006', 'JUPLe', 'glc', '555', '2021-02-13', 1, '1', 7, '0', 0, 0, 700000, '1', '2021-02-13 14:06:36'),
(8, 'F-007', 'TEST JUAl;', 'LSKDSJKJ', '1212', '2021-01-14', 3, '1', 5, '1', 5, 5, 1500000, '1', '2021-02-13 14:45:45'),
(9, 'F-008', 'TEST APPROVE', 'TEST APPROVE', '123123', '2021-02-14', 1, '1', 5, '1', 10, 5, 700000, '1', '2021-02-14 04:18:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_perusahaan`
--

CREATE TABLE `tbl_perusahaan` (
  `_id` int(11) NOT NULL,
  `nama_perusahaan` varchar(100) NOT NULL,
  `telp` char(13) NOT NULL,
  `alamat` longtext NOT NULL,
  `logo` varchar(50) NOT NULL,
  `nama_apps` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_po`
--

CREATE TABLE `tbl_po` (
  `id` int(255) NOT NULL,
  `po_number` varchar(255) NOT NULL,
  `Supplier_id` int(255) NOT NULL,
  `expeted_date` date NOT NULL,
  `total_amount` bigint(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `po_date` date NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `po_description` varchar(255) NOT NULL,
  `item_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_po`
--

INSERT INTO `tbl_po` (`id`, `po_number`, `Supplier_id`, `expeted_date`, `total_amount`, `status`, `po_date`, `file`, `po_description`, `item_description`) VALUES
(1, '123', 1, '0000-00-00', 123, '3231', '0000-00-00', 'http://localhost/cka-pot-master/uploads/po-files/1232.jpg', '123', NULL),
(2, 'Test 2', 1, '2024-10-01', 12000, '123', '2024-10-01', 'http://localhost/cka-pot-master/uploads/po-files/Test_2.jpg', 'Test 2', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_posisi`
--

CREATE TABLE `tbl_posisi` (
  `_id` int(11) NOT NULL,
  `posisi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_posisi`
--

INSERT INTO `tbl_posisi` (`_id`, `posisi`) VALUES
(1, 'Superadmin'),
(2, 'Admin'),
(3, 'Supervisor'),
(4, 'Owner'),
(5, 'Manager'),
(6, 'Helper'),
(8, 'Foreman'),
(10, 'Welder');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `id` int(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `PIC_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `bank_account` varchar(255) DEFAULT NULL,
  `rek_bank` varchar(255) DEFAULT NULL,
  `tax` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`id`, `nama`, `PIC_name`, `email`, `phone`, `address`, `bank_account`, `rek_bank`, `tax`, `status`, `created_at`, `update_at`) VALUES
(1, 'PT. Bina Mas Teknik', 'AAL', 'Testemail@gmail.com', '085280446016', 'Jl. Raya Merak No. 10 Cilegon - Banten', 'Mandir', '123123123123', '123123123123', '1', '2024-09-30 13:54:06', '2024-09-30 10:51:51'),
(3, 'PT. Anugerah Kota Baja', 'Budi Supriyanto', 'Budi@anugerahkotabaja.co.id', '081316313661', 'Metro Cilegon Blok N14 No.8 Kota Cilegon - Banten', 'Mandiri', '08123212312', '123123123', '1', '2024-10-01 10:26:15', '2024-10-01 15:26:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `_id` int(11) NOT NULL,
  `nik` char(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `tgl_masuk` date NOT NULL,
  `posisi` char(11) NOT NULL,
  `alamat` longtext NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_aktif` enum('0','1') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `no_hp` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '-',
  `marital` varchar(30) NOT NULL,
  `npwp` varchar(30) NOT NULL DEFAULT '-',
  `bpjs_ks` varchar(30) NOT NULL DEFAULT '-',
  `bpjs_kt` varchar(30) NOT NULL DEFAULT '-',
  `path_foto` varchar(255) NOT NULL,
  `employee-id` varchar(30) NOT NULL DEFAULT '-',
  `superior_id` varchar(30) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`_id`, `nik`, `nama`, `jk`, `tempat_lahir`, `tgl_lahir`, `tgl_masuk`, `posisi`, `alamat`, `password`, `is_aktif`, `created_at`, `no_hp`, `email`, `marital`, `npwp`, `bpjs_ks`, `bpjs_kt`, `path_foto`, `employee-id`, `superior_id`) VALUES
(14, '1', 'LUTFI WIJAYA', 'L', 'Serang', '2024-09-07', '2024-09-07', '1', 'Kp. Babakan Sompok RT 11 RW 05', '$2y$04$R8vOyZhkTaKbcv9WKUwlnOPCo.9ubE1HPwbbX8fsq2DWJol7V3BZC', '1', '2024-09-07 03:01:57', '082248951236', 'lutfiwijhaya@gmail.com', 'K', '', '', '', 'http://localhost/cka-pot-master/uploads/Lutfi.png', 'h-000023', '0'),
(15, '123', 'Cecep Adhinugraha', 'L', 'Serang', '2024-09-07', '2024-09-07', '2', 'Kp. Babakan Sompok RT 11 RW 05', '$2y$04$R8vOyZhkTaKbcv9WKUwlnOPCo.9ubE1HPwbbX8fsq2DWJol7V3BZC', '1', '2024-09-07 05:19:15', '082248951236', '', 'Kawin', '', '', '', 'http://localhost/cka-pot-master/uploads/Screenshot_2024-09-07_121858.png', 'H-123', '0');

-- --------------------------------------------------------

--
-- Table structure for table `wh_distribution`
--

CREATE TABLE `wh_distribution` (
  `id` int(30) NOT NULL,
  `item_id` int(30) NOT NULL,
  `from_warehouse_id` int(30) DEFAULT NULL,
  `to_warehouse_id` int(30) DEFAULT NULL,
  `employee_id_from` int(30) DEFAULT NULL,
  `employee_id_to` int(30) DEFAULT NULL,
  `qty` int(30) NOT NULL,
  `distribution_date` date NOT NULL,
  `distribution_type` varchar(255) NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `from_suplier_id` int(30) DEFAULT NULL,
  `to_suplier_id` int(30) DEFAULT NULL,
  `po_id` int(30) DEFAULT NULL,
  `request_id` int(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wh_distribution`
--

INSERT INTO `wh_distribution` (`id`, `item_id`, `from_warehouse_id`, `to_warehouse_id`, `employee_id_from`, `employee_id_to`, `qty`, `distribution_date`, `distribution_type`, `remark`, `from_suplier_id`, `to_suplier_id`, `po_id`, `request_id`) VALUES
(2, 1, 1, NULL, NULL, 14, 1, '2024-09-09', 'Loan', '', NULL, NULL, NULL, NULL),
(3, 10, 2, NULL, NULL, 15, 1, '2024-09-24', 'Loan', 'Adjustble wrech', NULL, NULL, 1, 1),
(4, 10, 1, NULL, NULL, 15, 1, '2024-09-24', 'Loan', 'Adjustble wrech', NULL, NULL, 1, 1),
(5, 10, 1, 2, NULL, NULL, 1, '2024-09-24', 'Loan', 'Adjustble wrech', NULL, NULL, 0, 0),
(6, 10, 1, NULL, NULL, 15, 1, '2024-09-24', 'Loan', 'Adjustble wrech', NULL, NULL, 0, 0),
(7, 10, 1, NULL, NULL, 15, 1, '2024-09-24', 'Loan', 'Adjustble wrech', NULL, NULL, 0, 0),
(8, 10, 1, NULL, NULL, 15, 1, '2024-09-24', 'Loan', 'Adjustble wrech', NULL, NULL, 0, 0),
(9, 10, 1, NULL, NULL, 15, 1, '2024-09-24', 'Loan', 'Adjustble wrech', NULL, NULL, 0, 0),
(10, 10, 1, NULL, NULL, 15, 1, '2024-09-24', 'Loan', 'Adjustble wrech', NULL, NULL, 0, 0),
(11, 10, 1, NULL, NULL, 15, 1, '2024-09-24', 'Loan', 'Adjustble wrech', NULL, NULL, 0, 0),
(12, 10, NULL, NULL, 15, 14, 1, '2024-09-24', 'Loan', 'Adjustble wrech', NULL, NULL, 0, 0),
(13, 10, 1, 2, NULL, NULL, 1, '2024-09-24', 'Loan', 'Adjustble wrech', NULL, NULL, 0, 0),
(14, 10, 1, 2, NULL, NULL, 1, '2024-09-24', 'Loan', 'Adjustble wrech', NULL, NULL, 0, 0),
(15, 10, 2, NULL, NULL, 15, 1, '2024-09-24', 'Consumable', '', NULL, NULL, 0, 0),
(16, 10, 2, NULL, NULL, 14, 1, '2024-09-24', 'Consumable', '', NULL, NULL, 0, 0),
(17, 10, 2, NULL, NULL, 15, 1, '2024-09-24', 'Consumable', '', NULL, NULL, 0, 0),
(18, 11, 1, 2, NULL, NULL, 23, '2024-09-30', 'New', '', NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wh_items`
--

CREATE TABLE `wh_items` (
  `id` int(30) NOT NULL,
  `kode_barang` varchar(100) NOT NULL,
  `category` varchar(30) NOT NULL,
  `inisial_kuantitas` varchar(30) NOT NULL,
  `Level_1` varchar(255) DEFAULT NULL,
  `level_2` varchar(255) DEFAULT '-',
  `level_3` varchar(255) DEFAULT '-',
  `level_4` varchar(255) DEFAULT '-',
  `remark` varchar(255) NOT NULL DEFAULT '-',
  `is_deleted` int(3) NOT NULL DEFAULT 0,
  `path_foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wh_items`
--

INSERT INTO `wh_items` (`id`, `kode_barang`, `category`, `inisial_kuantitas`, `Level_1`, `level_2`, `level_3`, `level_4`, `remark`, `is_deleted`, `path_foto`) VALUES
(1, 'H-01', 'inventory', 'EA', 'Office Electronic', 'Laptop', 'Asus', '-', '-', 1, ''),
(2, 'H-02', 'inventory', 'EA', 'Office Electronic', 'Laptop', 'HP', '-', '-', 1, ''),
(3, 'H-03', 'Consumable', 'EA', 'Office Stationary', 'Bolpoint', 'Standart', '-', '-', 1, ''),
(4, 'OE-0003', 'Consumable', 'EA', 'Office Electronic', 'Laptop', '', '', '', 1, ''),
(5, 'OE-0004', 'Inventory', 'Meter', 'Office Electronic', 'Laptop', '', '', '', 1, ''),
(6, 'OE-0005', 'Inventory', 'Meter', 'Office Electronic', 'Laptop', 'Test', '', '', 1, ''),
(7, 'MT-0001', 'Consumable', 'Meter', 'Material', 'Galvaniz', 'Pipe', '5\" 5M', '', 1, 'http://localhost/cka-pot-master/uploads/foto-items/MT-0001.png'),
(8, 'EQ-0001', 'Inventory', 'EA', 'Equipment', 'ID Bedge', '', '', '', 1, 'http://localhost/cka-pot-master/uploads/foto-items/EQ-0001.jpg'),
(9, '2-10-100-12', 'CCS', 'EA', 'Equipment', 'ID Bedge', 'Doosan', '-', '-', 0, 'http://localhost/cka-pot-master/uploads/foto-items/2-10-100-121.png'),
(10, '2-10-100-12', 'TCS', 'EA', 'Non Power Tools', 'Non Power Tools', 'Kunci Inggris', '18\"', 'Adjustble wrech', 0, 'http://localhost/cka-pot-master/uploads/foto-items/2-10-100-12.png'),
(11, '2-10-100-10', 'TCS', 'EA', 'Non Power Tools', 'Non Power Tools', 'Kunci Inggris', '6\"', 're', 0, NULL),
(12, '2-10-100-14', 'TCS', 'EA', 'Non Power Tools', 'Non Power Tools', 'Kunci Inggris', '15\"', '', 0, NULL),
(13, '2-10-100-13', 'TCS', 'EA', 'Non Power Tools', 'Non Power Tools', 'Kunci Inggris', '12\"', '231', 0, 'http://localhost/cka-pot-master/uploads/foto-items/2-10-100-13.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `wh_items_stock`
--

CREATE TABLE `wh_items_stock` (
  `id` int(30) NOT NULL,
  `item_id` int(30) NOT NULL,
  `warehouse_id` int(30) DEFAULT NULL,
  `employee_id` int(30) DEFAULT NULL,
  `quantity` int(30) NOT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wh_items_stock`
--

INSERT INTO `wh_items_stock` (`id`, `item_id`, `warehouse_id`, `employee_id`, `quantity`, `status`) VALUES
(1, 10, 1, NULL, 0, ''),
(4, 10, 2, NULL, 1, ''),
(5, 10, NULL, 14, 2, 'Loan'),
(6, 2, 1, NULL, 8, ''),
(7, 2, 2, NULL, 1, ''),
(8, 10, NULL, 15, 1, 'Loan'),
(9, 11, 2, NULL, 23, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wh_item_set`
--

CREATE TABLE `wh_item_set` (
  `id` int(30) NOT NULL,
  `item_id` int(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `qty` int(30) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `doc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wh_item_set`
--

INSERT INTO `wh_item_set` (`id`, `item_id`, `name`, `qty`, `status`, `remark`, `doc`) VALUES
(1, 11, 'Certificate', 1, 'Status', 'Remark', NULL),
(2, 11, 'Certificate 2', 1, NULL, NULL, NULL),
(3, 11, 'test', 11, '11', '11', NULL),
(7, 2, 'TCS', 0, 'Non Power Tools', 'Non Power Tools', NULL),
(8, 2, 'TCS', 0, 'Non Power Tools', 'Non Power Tools', 'http://localhost/cka-pot-master/uploads/foto-items-set/2-10-100-12.jpg'),
(9, 2, 'TCS', 0, 'Non Power Tools', 'Non Power Tools', NULL),
(10, 2, 'TCS', 0, 'Non Power Tools', 'Non Power Tools', NULL),
(11, 2, 'TCS', 0, 'Non Power Tools', 'Non Power Tools', NULL),
(12, 11, '1', 1, '1', '1', NULL),
(13, 11, '2', 2, '2', '2', NULL),
(14, 11, '1', 1, '1', '1', NULL),
(15, 123, '1', 1, '1', '1', NULL),
(16, 12333, '1', 1, '1', '1', NULL),
(17, 444, '44', 44, '4', '4', NULL),
(18, 32, '33', 3, '3', '3', NULL),
(19, 32, '33', 3, '3', '3', NULL),
(20, 32, '33', 3, '3', '3', NULL),
(21, 2, '2', 2, '2', '2', NULL),
(22, 2, '2', 2, '2', '2', NULL),
(23, 2, '2', 2, '2', '2', NULL),
(24, 2, '2', 2, '2', '2', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wh_request`
--

CREATE TABLE `wh_request` (
  `id` int(30) NOT NULL,
  `item_id` int(30) NOT NULL,
  `from_warehouse_id` int(30) DEFAULT NULL,
  `to_warehouse_id` int(30) DEFAULT NULL,
  `employee_id_from` int(30) DEFAULT NULL,
  `employee_id_to` int(30) DEFAULT NULL,
  `quantity` int(255) NOT NULL,
  `for_date` date NOT NULL,
  `back_date` date DEFAULT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `reason` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wh_warehouse`
--

CREATE TABLE `wh_warehouse` (
  `id` int(30) NOT NULL,
  `wh_name` varchar(100) NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wh_warehouse`
--

INSERT INTO `wh_warehouse` (`id`, `wh_name`, `location`) VALUES
(1, 'Warehouse Office (Damkar Cilegon)', 'Office Damkar (Cilegon)'),
(2, 'Container 20Ft 1', 'Office Damkar (Cilegon)');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `file_shared`
--
ALTER TABLE `file_shared`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `params`
--
ALTER TABLE `params`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `tbl_barang_masuk`
--
ALTER TABLE `tbl_barang_masuk`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `tbl_catatan`
--
ALTER TABLE `tbl_catatan`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `tbl_levels`
--
ALTER TABLE `tbl_levels`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `tbl_menus`
--
ALTER TABLE `tbl_menus`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `tbl_penagihan`
--
ALTER TABLE `tbl_penagihan`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `kode_bayar` (`kode_bayar`);

--
-- Indexes for table `tbl_penjualan`
--
ALTER TABLE `tbl_penjualan`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `no_faktur` (`no_faktur`);

--
-- Indexes for table `tbl_perusahaan`
--
ALTER TABLE `tbl_perusahaan`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `tbl_po`
--
ALTER TABLE `tbl_po`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_posisi`
--
ALTER TABLE `tbl_posisi`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indexes for table `wh_distribution`
--
ALTER TABLE `wh_distribution`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wh_items`
--
ALTER TABLE `wh_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wh_items_stock`
--
ALTER TABLE `wh_items_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wh_item_set`
--
ALTER TABLE `wh_item_set`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wh_warehouse`
--
ALTER TABLE `wh_warehouse`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `params`
--
ALTER TABLE `params`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_barang_masuk`
--
ALTER TABLE `tbl_barang_masuk`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_catatan`
--
ALTER TABLE `tbl_catatan`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_levels`
--
ALTER TABLE `tbl_levels`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tbl_menus`
--
ALTER TABLE `tbl_menus`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_penagihan`
--
ALTER TABLE `tbl_penagihan`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_penjualan`
--
ALTER TABLE `tbl_penjualan`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_perusahaan`
--
ALTER TABLE `tbl_perusahaan`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_po`
--
ALTER TABLE `tbl_po`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_posisi`
--
ALTER TABLE `tbl_posisi`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `wh_distribution`
--
ALTER TABLE `wh_distribution`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `wh_items`
--
ALTER TABLE `wh_items`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `wh_items_stock`
--
ALTER TABLE `wh_items_stock`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wh_item_set`
--
ALTER TABLE `wh_item_set`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `wh_warehouse`
--
ALTER TABLE `wh_warehouse`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
