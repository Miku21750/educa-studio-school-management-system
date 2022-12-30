-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2022 at 04:08 AM
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
-- Database: `educa_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admissions`
--

CREATE TABLE `tbl_admissions` (
  `id_admission` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `admission_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admissions`
--

INSERT INTO `tbl_admissions` (`id_admission`, `id_user`, `admission_date`) VALUES
(1, 2, '2022-12-01'),
(2, 3, '2022-12-01'),
(3, 4, '2022-12-01'),
(4, 5, '2022-10-06'),
(5, 124, '2022-12-07'),
(6, 7, '2022-12-07'),
(7, 8, '2022-12-07'),
(8, 127, '2022-12-07'),
(9, 112, '2022-12-14'),
(10, 133, '2022-12-14'),
(11, 136, '2022-12-16'),
(12, 21, '2022-12-16'),
(13, 86, '2022-12-16'),
(14, 12, '2022-12-16'),
(15, 11, '2022-12-19'),
(16, 26, '2022-12-19'),
(17, 14, '2022-12-19'),
(18, 44, '2022-12-19'),
(19, 61, '2022-12-19'),
(20, 92, '2022-12-19'),
(21, 55, '2022-12-19'),
(22, 18, '2022-12-19'),
(23, 20, '2022-12-19'),
(24, 22, '2022-12-19'),
(25, 24, '2022-12-19'),
(26, 81, '2022-12-19'),
(27, 6, '2022-12-19'),
(28, 10, '2022-12-19'),
(29, 17, '2022-12-19'),
(30, 19, '2022-12-19'),
(31, 9, '2022-12-19'),
(32, 13, '2022-12-19'),
(33, 15, '2022-12-19'),
(34, 77, '2022-12-19'),
(35, 139, '2022-12-19'),
(36, 138, '2022-12-20'),
(37, 140, '2022-12-23'),
(40, 141, '2022-12-26'),
(41, 96, '2022-12-26'),
(42, 16, '2022-12-26'),
(43, 27, '2022-12-26'),
(44, 90, '2022-12-26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendances`
--

CREATE TABLE `tbl_attendances` (
  `id_attendance` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_class` int(6) NOT NULL,
  `id_subject` int(6) NOT NULL,
  `tanggal` date NOT NULL,
  `absence` tinyint(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_attendances`
--

INSERT INTO `tbl_attendances` (`id_attendance`, `id_user`, `id_class`, `id_subject`, `tanggal`, `absence`, `created_at`, `update_at`) VALUES
(56, 0, 2, 1, '2022-12-19', 0, '2022-12-19 04:13:20', '2022-12-19 04:13:20'),
(57, 0, 1, 1, '2022-12-19', 0, '2022-12-19 04:13:29', '2022-12-19 04:13:29'),
(58, 5, 1, 1, '2022-12-19', 0, '2022-12-19 04:13:43', '2022-12-19 04:13:43'),
(59, 77, 1, 1, '2022-12-19', 1, '2022-12-19 04:13:43', '2022-12-19 04:13:43'),
(60, 92, 1, 1, '2022-12-19', 1, '2022-12-19 04:13:43', '2022-12-19 04:13:43'),
(61, 0, 8, 1, '2022-12-19', 0, '2022-12-19 04:29:41', '2022-12-19 04:29:41'),
(62, 0, 2, 1, '2022-12-20', 0, '2022-12-20 04:50:58', '2022-12-20 04:50:58'),
(63, 0, 8, 1, '2022-12-20', 0, '2022-12-20 04:51:14', '2022-12-20 04:51:14'),
(64, 6, 8, 1, '2022-12-20', 0, '2022-12-20 04:51:21', '2022-12-20 04:51:21'),
(65, 7, 8, 1, '2022-12-20', 1, '2022-12-20 04:51:21', '2022-12-20 04:51:21'),
(66, 10, 8, 1, '2022-12-20', 0, '2022-12-20 04:51:21', '2022-12-20 04:51:21'),
(67, 17, 8, 1, '2022-12-20', 0, '2022-12-20 04:51:21', '2022-12-20 04:51:21'),
(68, 19, 8, 1, '2022-12-20', 0, '2022-12-20 04:51:21', '2022-12-20 04:51:21'),
(69, 112, 8, 1, '2022-12-20', 1, '2022-12-20 04:51:21', '2022-12-20 04:51:21'),
(70, 4, 2, 1, '2022-12-20', 0, '2022-12-20 04:52:13', '2022-12-20 04:52:13'),
(71, 11, 2, 1, '2022-12-20', 1, '2022-12-20 04:52:13', '2022-12-20 04:53:14'),
(72, 26, 2, 1, '2022-12-20', 1, '2022-12-20 04:52:13', '2022-12-20 06:11:27'),
(73, 86, 2, 1, '2022-12-20', 1, '2022-12-20 04:52:13', '2022-12-20 04:52:13'),
(74, 136, 2, 1, '2022-12-20', 1, '2022-12-20 04:52:13', '2022-12-20 04:52:13'),
(75, 4, 2, 1, '2022-12-19', 0, '2022-12-20 06:10:34', '2022-12-20 06:10:34'),
(76, 11, 2, 1, '2022-12-19', 1, '2022-12-20 06:10:34', '2022-12-20 06:10:34'),
(77, 26, 2, 1, '2022-12-19', 0, '2022-12-20 06:10:34', '2022-12-20 06:10:34'),
(78, 86, 2, 1, '2022-12-19', 1, '2022-12-20 06:10:34', '2022-12-20 06:10:34'),
(79, 136, 2, 1, '2022-12-19', 0, '2022-12-20 06:10:34', '2022-12-20 06:10:34'),
(80, 0, 2, 1, '2022-12-23', 0, '2022-12-23 03:58:02', '2022-12-23 03:58:02'),
(81, 4, 2, 1, '2022-12-23', 1, '2022-12-23 03:58:08', '2022-12-23 03:58:08'),
(82, 11, 2, 1, '2022-12-23', 0, '2022-12-23 03:58:08', '2022-12-23 03:58:08'),
(83, 26, 2, 1, '2022-12-23', 0, '2022-12-23 03:58:08', '2022-12-23 03:58:08'),
(84, 86, 2, 1, '2022-12-23', 0, '2022-12-23 03:58:08', '2022-12-23 03:58:08'),
(85, 136, 2, 1, '2022-12-23', 0, '2022-12-23 03:58:08', '2022-12-23 03:58:08'),
(86, 0, 0, 0, '2022-12-23', 0, '2022-12-23 07:29:34', '2022-12-23 07:29:34'),
(87, 0, 1, 1, '2022-12-26', 0, '2022-12-26 03:53:38', '2022-12-26 03:53:38'),
(88, 2, 4, 1, '2022-12-27', 1, '2022-12-27 08:20:55', '2022-12-27 08:21:01'),
(89, 55, 4, 1, '2022-12-27', 1, '2022-12-27 08:20:55', '2022-12-27 08:21:01'),
(90, 2, 4, 1, '2022-12-20', 1, '2022-12-27 08:21:09', '2022-12-27 08:21:21'),
(91, 55, 4, 1, '2022-12-20', 1, '2022-12-27 08:21:09', '2022-12-27 08:21:21'),
(92, 2, 4, 1, '2022-12-13', 0, '2022-12-27 08:21:26', '2022-12-27 08:21:26'),
(93, 55, 4, 1, '2022-12-13', 1, '2022-12-27 08:21:26', '2022-12-27 08:21:36'),
(94, 2, 4, 1, '2022-12-06', 1, '2022-12-27 08:21:42', '2022-12-27 08:21:51'),
(95, 55, 4, 1, '2022-12-06', 1, '2022-12-27 08:21:42', '2022-12-27 08:21:51'),
(96, 2, 4, 2, '2022-12-06', 1, '2022-12-27 08:22:22', '2022-12-27 08:22:31'),
(97, 55, 4, 2, '2022-12-06', 1, '2022-12-27 08:22:22', '2022-12-27 08:22:31'),
(98, 2, 4, 2, '2022-12-13', 1, '2022-12-27 08:22:43', '2022-12-27 08:22:52'),
(99, 55, 4, 2, '2022-12-13', 1, '2022-12-27 08:22:43', '2022-12-27 08:22:52'),
(100, 2, 4, 2, '2022-12-20', 1, '2022-12-27 08:22:59', '2022-12-27 08:23:05'),
(101, 55, 4, 2, '2022-12-20', 1, '2022-12-27 08:22:59', '2022-12-27 08:23:05'),
(102, 2, 4, 2, '2022-12-27', 1, '2022-12-27 08:23:12', '2022-12-27 08:23:17'),
(103, 55, 4, 2, '2022-12-27', 1, '2022-12-27 08:23:12', '2022-12-27 08:23:17'),
(104, 2, 4, 3, '2022-12-27', 1, '2022-12-27 08:23:32', '2022-12-27 08:23:39'),
(105, 55, 4, 3, '2022-12-27', 1, '2022-12-27 08:23:32', '2022-12-27 08:23:39'),
(106, 2, 4, 3, '2022-12-20', 0, '2022-12-27 08:23:44', '2022-12-27 08:23:44'),
(107, 55, 4, 3, '2022-12-20', 1, '2022-12-27 08:23:44', '2022-12-27 08:23:49'),
(108, 2, 4, 3, '2022-12-06', 1, '2022-12-27 08:23:57', '2022-12-27 08:24:03'),
(109, 55, 4, 3, '2022-12-06', 0, '2022-12-27 08:23:57', '2022-12-27 08:23:57');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_books`
--

CREATE TABLE `tbl_books` (
  `id_book` int(11) NOT NULL,
  `name_book` varchar(50) NOT NULL,
  `kategori` varchar(25) DEFAULT NULL,
  `writer_book` varchar(50) NOT NULL,
  `publish_date` date NOT NULL,
  `upload_date` date NOT NULL,
  `code_book` varchar(15) DEFAULT NULL,
  `status_buku` enum('Ada','Dipinjam','','') NOT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_books`
--

INSERT INTO `tbl_books` (`id_book`, `name_book`, `kategori`, `writer_book`, `publish_date`, `upload_date`, `code_book`, `status_buku`, `create_at`) VALUES
(2, 'Matahari', NULL, 'Tereliye', '2005-02-18', '2022-12-09', '20221209002', 'Dipinjam', '2022-12-25 21:14:46'),
(3, 'Hujan', 'Umum', 'Tereliye', '2016-05-30', '2022-12-09', '20221209003', 'Dipinjam', '2022-12-25 21:14:46'),
(6, 'Setelah Gelap Terbitlah Terang', NULL, 'RA Kartini', '2022-12-07', '2022-12-04', '20221214001', 'Ada', '2022-12-25 21:14:46'),
(10, 'Hujan', NULL, 'Tereliye', '2022-12-01', '2022-12-14', '20221214002', 'Ada', '2022-12-25 21:14:46'),
(11, 'Bumi', NULL, 'Tere', '2022-12-01', '2022-12-14', '20221214002', 'Ada', '2022-12-25 21:14:46'),
(13, 'Bintang', NULL, 'Fulan', '2016-02-10', '2022-12-15', '20221215001', 'Ada', '2022-12-25 21:14:46'),
(149, 'Buku Bahasa Spanyol', NULL, 'Freguso', '2022-12-30', '2022-12-23', NULL, 'Ada', '2022-12-25 21:16:28'),
(150, 'awdwad', NULL, 'awdwdw', '2022-12-14', '2022-12-05', 'WDW-3-0150', 'Ada', '2022-12-25 21:29:26'),
(151, 'wadwa;23423dx', NULL, '3fwef;\'wsdf', '2022-12-06', '2022-12-29', 'WDW-1-0151', 'Ada', '2022-12-25 21:29:49'),
(152, 'Thunder Attack', NULL, 'Thunder Spirit', '2022-12-30', '2022-12-07', 'THNTTC-1-0152', 'Ada', '2022-12-25 21:31:11'),
(153, 'Teori Olaharaga', NULL, 'Thunder Spirit', '2022-12-05', '2022-12-26', 'TRLH-1-0153', 'Ada', '2022-12-25 21:32:45'),
(154, 'Bahasa Inggris XI', NULL, 'Thunder Spirit', '2022-12-08', '2022-12-21', 'BHNGX-1-0154', 'Ada', '2022-12-25 23:26:49'),
(155, 'Saya Hiyama', NULL, 'wadwadwd', '2022-12-20', '2022-12-15', 'SHM--0155', 'Ada', '2022-12-25 23:44:09'),
(156, 'wdawd', 'Buku Guru', 'awdwd', '2022-12-06', '2022-12-29', 'WD--0156', 'Ada', '2022-12-25 23:47:29'),
(157, 'Hewan', 'Umum', 'anomin', '2022-12-20', '2022-12-27', 'HW-0157', 'Ada', '2022-12-27 02:20:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_classes`
--

CREATE TABLE `tbl_classes` (
  `id_class` int(11) NOT NULL,
  `id_section` int(11) NOT NULL,
  `class` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_classes`
--

INSERT INTO `tbl_classes` (`id_class`, `id_section`, `class`) VALUES
(0, 0, 'Belum Ada'),
(1, 1, 'X'),
(2, 1, 'XI'),
(3, 1, 'XII'),
(4, 2, 'X'),
(5, 2, 'XI'),
(6, 2, 'XII'),
(7, 3, 'X'),
(8, 3, 'XI'),
(9, 3, 'XII'),
(99, 0, 'Lulus'),
(100, 0, 'Pindah'),
(101, 0, 'Keluar');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_class_routines`
--

CREATE TABLE `tbl_class_routines` (
  `id_class_routine` int(11) NOT NULL,
  `id_class` int(11) NOT NULL,
  `id_subject` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `school_day` enum('Senin','Selasa','Rabu','Kamis','Jumat') DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_class_routines`
--

INSERT INTO `tbl_class_routines` (`id_class_routine`, `id_class`, `id_subject`, `id_user`, `school_day`, `start_time`, `end_time`) VALUES
(2, 1, 2, 30, 'Selasa', '08:00:00', '09:00:00'),
(5, 1, 1, 30, 'Rabu', '15:31:00', '16:31:00'),
(6, 2, 1, 34, 'Kamis', '15:34:00', '16:34:00'),
(7, 2, 8, 39, 'Senin', '15:54:00', '16:54:00'),
(8, 2, 1, 41, 'Rabu', '17:54:00', '18:54:00'),
(12, 3, 1, 74, 'Jumat', '11:23:00', '12:23:00'),
(16, 4, 5, 34, 'Jumat', '00:21:00', '01:21:00'),
(17, 9, 6, 39, 'Senin', '16:05:00', '17:05:00'),
(19, 1, 6, 23, 'Selasa', '09:26:00', '10:26:00'),
(20, 5, 1, 23, 'Senin', '11:11:00', '11:59:00'),
(21, 2, 17, 84, 'Senin', '11:07:00', '12:07:00'),
(22, 1, 5, 30, 'Rabu', '11:10:00', '11:14:00'),
(24, 6, 15, 71, 'Senin', '13:07:00', '14:07:00'),
(25, 11, 12, 57, 'Senin', '11:01:00', '12:01:00'),
(26, 11, 19, 132, 'Jumat', '00:00:00', '12:00:00'),
(31, 13, 23, 132, 'Senin', '00:00:00', '00:00:00'),
(39, 10, 6, 59, 'Senin', '15:13:00', '16:13:00'),
(40, 2, 1, 74, 'Rabu', '15:15:00', '17:15:00'),
(41, 4, 12, 132, 'Senin', '13:17:00', '14:17:00'),
(42, 8, 18, 59, 'Senin', '07:30:00', '08:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exams`
--

CREATE TABLE `tbl_exams` (
  `id_exam` int(11) NOT NULL,
  `id_class` int(11) NOT NULL,
  `exam_type` enum('UTS','UAS') NOT NULL,
  `semester` enum('Semester 1','Semester 2') NOT NULL,
  `session` varchar(255) NOT NULL,
  `exam_date` date DEFAULT NULL,
  `exam_start` time DEFAULT NULL,
  `exam_end` time NOT NULL,
  `id_subject` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_exams`
--

INSERT INTO `tbl_exams` (`id_exam`, `id_class`, `exam_type`, `semester`, `session`, `exam_date`, `exam_start`, `exam_end`, `id_subject`) VALUES
(1, 1, '', 'Semester 1', '', '2022-12-01', '10:00:00', '11:00:00', 1),
(2, 2, '', 'Semester 1', '', '2020-10-24', '14:59:00', '15:59:00', 2),
(3, 4, 'UTS', 'Semester 1', '2023-2024', '2022-12-27', '13:00:00', '14:00:00', 1),
(4, 4, 'UTS', 'Semester 1', '2023-2024', '2022-12-28', '07:00:00', '08:00:00', 2),
(5, 4, 'UTS', 'Semester 1', '2023-2024', '2022-12-28', '08:00:00', '09:00:00', 3),
(6, 4, 'UAS', 'Semester 1', '2023-2024', '2023-01-04', '08:00:00', '09:00:00', 1),
(7, 4, 'UAS', 'Semester 1', '2023-2024', '2023-01-04', '08:00:00', '09:00:00', 2),
(8, 4, 'UAS', 'Semester 1', '2023-2024', '2023-01-04', '08:00:00', '09:00:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exam_grades`
--

CREATE TABLE `tbl_exam_grades` (
  `id_exam_grade` int(11) NOT NULL,
  `grade_name` varchar(5) NOT NULL,
  `percent_from` int(11) NOT NULL,
  `percent_upto` int(11) NOT NULL,
  `grade_desc` varchar(255) NOT NULL,
  `grade_point` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_exam_grades`
--

INSERT INTO `tbl_exam_grades` (`id_exam_grade`, `grade_name`, `percent_from`, `percent_upto`, `grade_desc`, `grade_point`) VALUES
(1, 'A+', 95, 100, 'Exceptional', 4),
(2, 'A', 90, 94, 'Excellent', 3.75),
(3, 'B+', 85, 89, 'Superior', 3.5),
(4, 'B', 80, 84, 'Very Good', 3),
(5, 'C+', 75, 79, 'Above Average', 2.5),
(6, 'C', 70, 74, 'Good', 2),
(7, 'D+', 65, 69, 'High Pass', 1.5),
(8, 'D', 60, 64, 'Pass', 1),
(9, 'F', 0, 59, 'Fail', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exam_results`
--

CREATE TABLE `tbl_exam_results` (
  `id_result` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_exam` int(11) NOT NULL,
  `id_exam_grade` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `date_result` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_exam_results`
--

INSERT INTO `tbl_exam_results` (`id_result`, `id_user`, `id_exam`, `id_exam_grade`, `score`, `date_result`) VALUES
(3, 2, 1, 3, 87, '2022-12-01'),
(4, 3, 2, 1, 95, '2022-12-01'),
(5, 4, 1, 6, 70, '2022-12-01'),
(6, 9, 1, 6, 70, '2022-12-02'),
(7, 9, 1, 0, 77, '2022-12-06'),
(16, 14, 1, 1, 100, '2022-12-13'),
(17, 11, 1, 2, 90, '2022-12-13'),
(18, 17, 1, 3, 85, '2022-12-13'),
(19, 44, 2, 1, 100, '2022-12-13'),
(20, 92, 1, 5, 78, '2022-12-13'),
(21, 81, 2, 5, 78, '2022-12-13'),
(22, 27, 2, 7, 69, '2022-12-13'),
(23, 22, 2, 3, 89, '2022-12-13'),
(26, 16, 1, 1, 100, '2022-12-13'),
(27, 20, 1, 4, 80, '2022-12-13'),
(29, 61, 2, 1, 100, '2022-12-13'),
(30, 2, 3, 3, 85, '2022-12-27'),
(31, 2, 4, 2, 90, '2022-12-27'),
(32, 2, 5, 1, 98, '2022-12-27'),
(33, 2, 6, 5, 78, '2022-12-27'),
(34, 2, 7, 3, 89, '2022-12-27'),
(35, 2, 8, 2, 93, '2022-12-27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_final_scores`
--

CREATE TABLE `tbl_final_scores` (
  `id_final_score` int(6) NOT NULL,
  `id_user` int(6) NOT NULL,
  `id_class` int(6) NOT NULL,
  `id_subject` int(6) NOT NULL,
  `nilai_abs` decimal(5,0) NOT NULL,
  `nilai_1` decimal(5,0) NOT NULL,
  `nilai_2` decimal(5,0) NOT NULL,
  `nilai_3` decimal(5,0) NOT NULL,
  `nilai_akhir` decimal(5,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_final_scores`
--

INSERT INTO `tbl_final_scores` (`id_final_score`, `id_user`, `id_class`, `id_subject`, `nilai_abs`, `nilai_1`, `nilai_2`, `nilai_3`, `nilai_akhir`) VALUES
(1, 2, 4, 1, '75', '0', '85', '78', '56'),
(2, 55, 4, 1, '100', '0', '0', '0', '10'),
(3, 2, 4, 2, '100', '0', '90', '89', '64'),
(4, 55, 4, 2, '100', '0', '0', '0', '10'),
(5, 2, 4, 3, '67', '0', '98', '93', '64'),
(6, 55, 4, 3, '67', '0', '0', '0', '7');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_finances`
--

CREATE TABLE `tbl_finances` (
  `id_finance` int(11) NOT NULL,
  `id_payment_type` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tipe_finance` enum('Pemasukan','Pengeluaran') NOT NULL,
  `amount_payment` int(11) NOT NULL,
  `status_pembayaran` enum('Dibayar','Belum Bayar','Transaksi sedang diproses','Erorr','Kadaluarsa','Dibatalkan','Ditolak') NOT NULL,
  `date_payment` date NOT NULL,
  `order_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_finances`
--

INSERT INTO `tbl_finances` (`id_finance`, `id_payment_type`, `id_user`, `tipe_finance`, `amount_payment`, `status_pembayaran`, `date_payment`, `order_id`) VALUES
(1, 1, 12, 'Pemasukan', 2000000, 'Dibayar', '2019-06-07', 0),
(3, 1, 10, 'Pemasukan', 2000000, 'Belum Bayar', '2019-12-13', 0),
(4, 1, 6, 'Pemasukan', 2000000, 'Dibayar', '2019-02-19', 0),
(5, 1, 11, 'Pemasukan', 2000000, 'Dibayar', '2019-08-10', 0),
(6, 1, 2, 'Pemasukan', 2000000, 'Belum Bayar', '2019-10-27', 0),
(7, 1, 9, 'Pemasukan', 2000000, 'Dibayar', '2019-09-19', 0),
(8, 1, 13, 'Pemasukan', 2000000, 'Dibayar', '2019-12-18', 0),
(9, 1, 7, 'Pemasukan', 2000000, 'Dibayar', '2019-05-16', 0),
(10, 1, 3, 'Pemasukan', 2000000, 'Dibayar', '2022-12-27', 31839),
(11, 1, 8, 'Pemasukan', 2000000, 'Dibayar', '2019-01-16', 0),
(12, 1, 4, 'Pemasukan', 2000000, 'Dibayar', '2022-12-27', 29080),
(13, 3, 56, 'Pengeluaran', 1500000, 'Dibayar', '2022-12-21', 0),
(14, 3, 59, 'Pengeluaran', 1500000, 'Belum Bayar', '2019-08-06', 0),
(15, 3, 41, 'Pengeluaran', 1500000, 'Dibayar', '2019-02-19', 0),
(16, 3, 57, 'Pengeluaran', 1500000, 'Dibayar', '2019-04-19', 0),
(17, 3, 34, 'Pengeluaran', 1500000, 'Belum Bayar', '2019-08-22', 0),
(18, 3, 63, 'Pengeluaran', 1500000, 'Belum Bayar', '2019-11-22', 0),
(19, 3, 35, 'Pengeluaran', 1500000, 'Dibayar', '2019-03-22', 0),
(20, 3, 47, 'Pengeluaran', 1500000, 'Dibayar', '2019-01-02', 0),
(21, 3, 23, 'Pengeluaran', 1500000, 'Dibayar', '2019-01-28', 0),
(22, 3, 30, 'Pengeluaran', 1500000, 'Belum Bayar', '2019-07-28', 0),
(23, 2, 4, 'Pemasukan', 5000000, 'Dibayar', '2020-12-18', 0),
(101, 3, 23, 'Pengeluaran', 2000000, 'Dibayar', '2022-12-16', 0),
(102, 4, 46, 'Pengeluaran', 100000, 'Dibayar', '2022-12-06', 0),
(103, 1, 138, 'Pemasukan', 1000000, 'Dibayar', '2022-12-20', 0),
(104, 2, 138, 'Pemasukan', 100000, 'Belum Bayar', '2022-12-06', 0),
(105, 1, 112, 'Pemasukan', 100000, 'Dibayar', '2022-12-23', 18921),
(106, 1, 5, 'Pemasukan', 1000000, 'Dibayar', '2022-12-27', 5565),
(107, 1, 4, 'Pemasukan', 2000000, 'Dibayar', '2022-12-27', 23306),
(108, 2, 4, 'Pemasukan', 1000000, 'Belum Bayar', '2022-12-26', 0),
(109, 1, 5, 'Pemasukan', 2000000, 'Dibayar', '2022-12-27', 0),
(110, 1, 5, 'Pemasukan', 1000000, 'Dibayar', '2022-12-27', 24049),
(111, 1, 3, 'Pemasukan', 250000, 'Transaksi sedang diproses', '2022-12-27', 7638);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hostels`
--

CREATE TABLE `tbl_hostels` (
  `id_hostel` int(11) NOT NULL,
  `hostel_name` varchar(50) NOT NULL,
  `room_number` varchar(25) NOT NULL,
  `room_type` varchar(10) NOT NULL,
  `number_of_bed` int(11) NOT NULL,
  `cost_per_bed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_hostels`
--

INSERT INTO `tbl_hostels` (`id_hostel`, `hostel_name`, `room_number`, `room_type`, `number_of_bed`, `cost_per_bed`) VALUES
(1, 'Luxury Boy', '1', 'Kecil', 1, 1500000),
(2, 'Luxury Boy', '2', 'Kecil', 1, 1500000),
(3, 'Luxury Boy', '3', 'Kecil', 1, 1500000),
(4, 'Luxury Girl', '1', 'Kecil', 1, 2000000),
(5, 'Luxury Girl', '2', 'Kecil', 1, 2000000),
(6, 'Luxury Girl', '3', 'Kecil', 1, 2000000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_messages`
--

CREATE TABLE `tbl_messages` (
  `id_message` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `receiver_email` varchar(50) NOT NULL,
  `sender_email` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `time_sended` timestamp NOT NULL DEFAULT current_timestamp(),
  `readed` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_messages`
--

INSERT INTO `tbl_messages` (`id_message`, `id_user`, `receiver_email`, `sender_email`, `title`, `message`, `time_sended`, `readed`) VALUES
(4, 111, 'rafaelfarizi1@gmail.com', 'rafaelfarizi1@gmail.com', 'AAAA', 'AAAA', '2022-12-06 07:18:55', 0),
(5, 2, 'oniworld@oniworld.com', 'rafaelfarizi1@gmail.com', 'AAAAAAAAAAA', 'AAAAA', '2022-12-06 07:18:55', 1),
(6, 111, 'rafaelfarizi1@gmail.com', 'rafaelfarizi1@gmail.com', 'AAAAAAAAAAA', 'AAAAA', '2022-12-06 07:47:57', 1),
(7, 111, 'rafaelfarizi1@gmail.com', 'harber.tyshawn@example.com', 'Miku21 Under Arrest', 'Alerting, your are under arrest for doing child predator', '2022-12-06 07:27:48', 0),
(8, 103, 'rafaelfarizi1@gmail.com', 'rafaelfarizi1@gmail.com', 'AAAA', 'AAAAAA', '2022-12-08 02:21:22', 1),
(9, 112, 'laruthm02@gmail.com', 'rafaelfarizi1@gmail.com', 'jhgjhk', 'mikuas', '2022-12-08 01:47:33', 1),
(10, 103, 'rafaelfarizi1@gmail.com', 'rafaelfarizi1@gmail.com', 'kambin', 'dsfgfdgsdfgdgs', '2022-12-05 03:06:25', 1),
(11, 103, 'rafaelfarizi1@gmail.com', 'rafaelfarizi1@gmail.com', 'iuggjhg', 'AAAAA', '2022-12-09 01:53:53', 1),
(12, 103, 'rafaelfarizi1@gmail.com', 'rafaelfarizi1@gmail.com', 'iuggjhg', 'AAAAAfadasdfasd', '2022-12-09 02:22:01', 1),
(13, 103, 'rafaelfarizi1@gmail.com', 'rafaelfarizi1@gmail.com', 'iuggjhg', 'AAAAAfadasdfasdasdfasdfas', '2022-12-09 01:56:28', 1),
(14, 103, 'rafaelfarizi1@gmail.com', 'rafaelfarizi1@gmail.com', 'AAAA', 'AAAAAA', '2022-12-09 02:20:37', 1),
(15, 137, 'miku217500@gmail.com', 'rafaelfarizi1@gmail.com', 'Exam Warning', 'Hi Frisk, Your child named Lil Didn\'t Submit his exam yesterday, please inform ASAP', '2022-12-16 04:18:21', 1),
(16, 137, 'miku217500@gmail.com', 'rafaelfarizi1@gmail.com', 'Exam Warning', 'Hi Lil , You didn\'t Submit his exam yesterday, please inform ASAP.\nI inform your mother too', '2022-12-16 04:18:54', 1),
(17, 136, 'lil_lil@example.com', 'rafaelfarizi1@gmail.com', 'Exam Warning', 'Hi Lil , You didn\'t Submit his exam yesterday, please inform ASAP.\nI inform your mother too', '2022-12-16 04:19:09', 0),
(18, 103, 'rafaelfarizi1@gmail.com', 'rafaelfarizi1@gmail.com', 'Miku21 Under Arrest', 'AAAAAAAAAAAAAAAAAAA', '2022-12-22 08:42:05', 0),
(19, 3, 'moore.eveline@example.net', 'rafaelfarizi1@gmail.com', 'Miku21 Under Arrest', 'aaaa', '2022-12-22 08:42:30', 0),
(20, 103, 'rafaelfarizi1@gmail.com', 'rafaelfarizi1@gmail.com', 'Miku21 has taken child fr', 'WEEEEEEE', '2022-12-22 08:47:21', 1),
(21, 103, 'rafaelfarizi1@gmail.com', 'rafaelfarizi1@gmail.com', 'Miku21 has taken child fr', 'nyeh', '2022-12-23 08:31:43', 0),
(22, 112, 'laruthm02@gmail.com', 'admin@example.com', 'Bayar SPP', 'Spp akan jatuh tempo pada tanggal 23 januari 2023', '2022-12-23 09:47:24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notifications`
--

CREATE TABLE `tbl_notifications` (
  `id_notification` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `details` varchar(100) NOT NULL,
  `posted_by` varchar(50) NOT NULL,
  `date_notice` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_event` datetime NOT NULL,
  `category` enum('Pengumuman_Sekolah','Event','Pembayaran_Gaji','Exam','Pembayaran_SPP') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_notifications`
--

INSERT INTO `tbl_notifications` (`id_notification`, `title`, `details`, `posted_by`, `date_notice`, `date_event`, `category`) VALUES
(1, 'Upacara Akan diadakan Segera', 'Mohon Menunggu dilapangan lebih lanjut', 'Miku21 Margareth', '2022-12-16 02:50:07', '0000-00-00 00:00:00', 'Pengumuman_Sekolah'),
(2, 'Miku21 Under Arrest', 'Miku21 Under Arrest for doing child predator', 'Admin', '2022-12-16 02:50:55', '2022-12-20 09:50:00', 'Event'),
(3, 'Get your payment at next month', 'AAAA RIP MONEY', 'Miku21 Margareth', '2022-12-16 03:21:10', '2023-01-16 10:01:00', 'Pembayaran_Gaji'),
(4, 'SPP payment deadline at April 2023', 'Please pay ASAP', 'Miku21 Margareth', '2022-12-16 03:20:32', '2023-04-10 10:02:00', 'Pembayaran_SPP'),
(5, 'Ujian Semester 2', 'Akan dilaksanakan. segera belajar', 'Admin', '2022-12-23 09:49:57', '2022-12-26 07:22:00', 'Exam');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_types`
--

CREATE TABLE `tbl_payment_types` (
  `id_payment_type` int(11) NOT NULL,
  `payment_type_name` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_payment_types`
--

INSERT INTO `tbl_payment_types` (`id_payment_type`, `payment_type_name`) VALUES
(1, 'Biaya Semester'),
(2, 'Biaya Ujian'),
(3, 'Gaji Guru'),
(4, 'Transport');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_peminjaman`
--

CREATE TABLE `tbl_peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `ket` enum('Proses','Dipinjam','Dikembalikan','Denda','Proses Pengembalian') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_peminjaman`
--

INSERT INTO `tbl_peminjaman` (`id_peminjaman`, `id_book`, `id_user`, `tgl_pinjam`, `tgl_kembali`, `ket`) VALUES
(3, 6, 4, '2022-12-04', '2022-12-11', 'Denda'),
(9, 2, 2, '2022-12-18', '2022-12-25', 'Dikembalikan'),
(12, 11, 2, '2022-12-20', '2022-12-27', 'Dikembalikan'),
(15, 3, 2, '2022-12-19', '2022-12-26', 'Dikembalikan'),
(16, 2, 112, '2022-12-19', '2022-12-26', 'Dikembalikan'),
(18, 3, 2, '2022-12-19', '2022-12-26', 'Dikembalikan'),
(19, 2, 2, '2022-12-19', '2022-12-26', 'Dikembalikan'),
(20, 3, 2, '2022-12-23', '2022-12-30', 'Dikembalikan'),
(21, 2, 2, '2022-12-26', '2023-01-02', 'Dipinjam'),
(22, 3, 4, '2022-12-26', '2023-01-02', 'Dipinjam');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sections`
--

CREATE TABLE `tbl_sections` (
  `id_section` int(11) NOT NULL,
  `section` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sections`
--

INSERT INTO `tbl_sections` (`id_section`, `section`) VALUES
(0, ''),
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subjects`
--

CREATE TABLE `tbl_subjects` (
  `id_subject` int(11) NOT NULL,
  `subject_name` varchar(25) NOT NULL,
  `subject_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_subjects`
--

INSERT INTO `tbl_subjects` (`id_subject`, `subject_name`, `subject_type`) VALUES
(0, 'Belum Ada', 'Tidak Ada'),
(1, 'English', 'Theory'),
(2, 'Accounting', 'Mathematic'),
(3, 'Bangla', 'Theory'),
(4, 'Arts', 'Theory'),
(5, 'Jawa', 'Practice'),
(6, 'IPA', 'Practice'),
(7, 'IPS', 'Theory'),
(8, 'Japan', 'Theory'),
(9, 'German', 'Practice'),
(10, 'Ekonomi', 'Mathematic'),
(11, 'Aksara Jawa Kuno', 'Theory'),
(12, 'Olahraga', 'Practice');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tasks`
--

CREATE TABLE `tbl_tasks` (
  `id_task` int(6) NOT NULL,
  `id_class` int(6) NOT NULL,
  `id_subject` int(6) NOT NULL,
  `id_user` int(6) NOT NULL,
  `task_type` varchar(5) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `score` int(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_tasks`
--

INSERT INTO `tbl_tasks` (`id_task`, `id_class`, `id_subject`, `id_user`, `task_type`, `task_name`, `score`, `created_at`, `updated_at`) VALUES
(26, 2, 1, 4, 'TGS', 'TUGAS 1', 65, '2022-12-18 21:48:44', '2022-12-21 21:50:22'),
(27, 2, 1, 11, 'TGS', 'TUGAS 1', 70, '2022-12-18 21:48:44', '2022-12-21 21:50:22'),
(28, 2, 1, 26, 'TGS', 'TUGAS 1', 100, '2022-12-18 21:48:44', '2022-12-20 02:53:39'),
(29, 2, 1, 86, 'TGS', 'TUGAS 1', 100, '2022-12-18 21:48:44', '2022-12-20 02:53:39'),
(30, 2, 1, 136, 'TGS', 'TUGAS 1', 90, '2022-12-18 21:48:44', '2022-12-20 02:53:39'),
(31, 2, 1, 4, 'TGS', 'TUGAS 2', 89, '2022-12-19 19:37:30', '2022-12-20 02:53:39'),
(32, 2, 1, 11, 'TGS', 'TUGAS 2', 100, '2022-12-19 19:37:30', '2022-12-20 02:53:39'),
(33, 2, 1, 26, 'TGS', 'TUGAS 2', 80, '2022-12-19 19:37:30', '2022-12-20 02:53:39'),
(34, 2, 1, 86, 'TGS', 'TUGAS 2', 97, '2022-12-19 19:37:30', '2022-12-20 02:53:39'),
(35, 2, 1, 136, 'TGS', 'TUGAS 2', 98, '2022-12-19 19:37:30', '2022-12-20 02:53:39'),
(41, 2, 1, 4, 'UH', 'UH 1', 0, '2022-12-19 21:33:36', '2022-12-19 21:33:36'),
(42, 2, 1, 11, 'UH', 'UH 1', 0, '2022-12-19 21:33:36', '2022-12-19 21:33:36'),
(43, 2, 1, 26, 'UH', 'UH 1', 0, '2022-12-19 21:33:36', '2022-12-19 21:33:36'),
(44, 2, 1, 86, 'UH', 'UH 1', 0, '2022-12-19 21:33:36', '2022-12-19 21:33:36'),
(45, 2, 1, 136, 'UH', 'UH 1', 0, '2022-12-19 21:33:36', '2022-12-19 21:33:36'),
(116, 2, 1, 4, 'TGS', 'TUGAS 3', 0, '2022-12-20 03:07:24', '2022-12-20 03:08:24'),
(117, 2, 1, 11, 'TGS', 'TUGAS 3', 100, '2022-12-20 03:07:24', '2022-12-20 03:08:24'),
(118, 2, 1, 26, 'TGS', 'TUGAS 3', 0, '2022-12-20 03:07:24', '2022-12-20 03:08:24'),
(119, 2, 1, 86, 'TGS', 'TUGAS 3', 100, '2022-12-20 03:07:24', '2022-12-20 03:08:24'),
(120, 2, 1, 136, 'TGS', 'TUGAS 3', 0, '2022-12-20 03:07:24', '2022-12-20 03:08:24'),
(121, 2, 1, 4, 'TGS', 'TUGAS 4', 100, '2022-12-20 03:07:28', '2022-12-20 03:08:24'),
(122, 2, 1, 11, 'TGS', 'TUGAS 4', 100, '2022-12-20 03:07:28', '2022-12-21 21:50:22'),
(123, 2, 1, 26, 'TGS', 'TUGAS 4', 100, '2022-12-20 03:07:28', '2022-12-20 03:08:24'),
(124, 2, 1, 86, 'TGS', 'TUGAS 4', 0, '2022-12-20 03:07:28', '2022-12-20 03:08:24'),
(125, 2, 1, 136, 'TGS', 'TUGAS 4', 100, '2022-12-20 03:07:28', '2022-12-20 03:08:24'),
(126, 1, 1, 5, 'TGS', 'TUGAS 1', 0, '2022-12-21 19:27:48', '2022-12-21 19:27:48'),
(127, 1, 1, 77, 'TGS', 'TUGAS 1', 0, '2022-12-21 19:27:48', '2022-12-21 19:27:48'),
(128, 1, 1, 92, 'TGS', 'TUGAS 1', 0, '2022-12-21 19:27:48', '2022-12-21 19:27:48'),
(129, 2, 1, 4, 'TGS', 'TUGAS 5', 0, '2022-12-21 21:50:25', '2022-12-21 21:50:25'),
(130, 2, 1, 11, 'TGS', 'TUGAS 5', 0, '2022-12-21 21:50:25', '2022-12-21 21:50:25'),
(131, 2, 1, 26, 'TGS', 'TUGAS 5', 0, '2022-12-21 21:50:25', '2022-12-21 21:50:25'),
(132, 2, 1, 86, 'TGS', 'TUGAS 5', 0, '2022-12-21 21:50:25', '2022-12-21 21:50:25'),
(133, 2, 1, 136, 'TGS', 'TUGAS 5', 0, '2022-12-21 21:50:25', '2022-12-21 21:50:25'),
(134, 9, 2, 8, 'UH', 'UH 1', 0, '2022-12-23 00:20:20', '2022-12-23 00:20:20'),
(135, 9, 2, 9, 'UH', 'UH 1', 0, '2022-12-23 00:20:20', '2022-12-23 00:20:20'),
(136, 9, 2, 13, 'UH', 'UH 1', 0, '2022-12-23 00:20:20', '2022-12-23 00:20:20'),
(137, 9, 2, 15, 'UH', 'UH 1', 0, '2022-12-23 00:20:20', '2022-12-23 00:20:20'),
(138, 9, 2, 16, 'UH', 'UH 1', 0, '2022-12-23 00:20:20', '2022-12-23 00:20:20'),
(139, 9, 2, 27, 'UH', 'UH 1', 0, '2022-12-23 00:20:20', '2022-12-23 00:20:20'),
(140, 9, 2, 90, 'UH', 'UH 1', 0, '2022-12-23 00:20:20', '2022-12-23 00:20:20'),
(141, 9, 2, 8, 'UH', 'UH 2', 0, '2022-12-23 00:20:23', '2022-12-23 00:20:23'),
(142, 9, 2, 9, 'UH', 'UH 2', 0, '2022-12-23 00:20:23', '2022-12-23 00:20:23'),
(143, 9, 2, 13, 'UH', 'UH 2', 0, '2022-12-23 00:20:23', '2022-12-23 00:20:23'),
(144, 9, 2, 15, 'UH', 'UH 2', 0, '2022-12-23 00:20:23', '2022-12-23 00:20:23'),
(145, 9, 2, 16, 'UH', 'UH 2', 0, '2022-12-23 00:20:23', '2022-12-23 00:20:23'),
(146, 9, 2, 27, 'UH', 'UH 2', 0, '2022-12-23 00:20:23', '2022-12-23 00:20:23'),
(147, 9, 2, 90, 'UH', 'UH 2', 0, '2022-12-23 00:20:23', '2022-12-23 00:20:23'),
(148, 1, 1, 5, 'UH', 'UH 1', 0, '2022-12-26 00:10:31', '2022-12-26 00:10:31'),
(149, 1, 1, 92, 'UH', 'UH 1', 0, '2022-12-26 00:10:31', '2022-12-26 00:10:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transports`
--

CREATE TABLE `tbl_transports` (
  `id_transport` int(10) NOT NULL,
  `route_name` varchar(100) NOT NULL,
  `vehicle_number` varchar(25) NOT NULL,
  `driver_name` varchar(50) NOT NULL,
  `license_number` varchar(25) NOT NULL,
  `phone_number` varchar(25) NOT NULL,
  `id_driver` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_transports`
--

INSERT INTO `tbl_transports` (`id_transport`, `route_name`, `vehicle_number`, `driver_name`, `license_number`, `phone_number`, `id_driver`) VALUES
(1, 'Jl. Patimura - Jl. Kalitaman', 'H 1014 ZI', 'Jono', '1357-0013-145683', '081234561234', 'A-0001'),
(2, 'Jl. Patimura - Jl. Kalitaman', 'H 9699 CT', 'Kirman', '1357-0014-098765', '08198761234', 'A-0002'),
(3, 'Jl. Patimura - Jl. Kalitaman', 'H 1218 ND', 'Hendra', '1357-0014-124785', '081397861234', 'A-0003'),
(4, 'Jl. Patimura - Pasar Raya Salatiga', 'H 4025 MK', 'Yusuf', '1357-0052-112640', '081234512466', 'A-0004'),
(5, 'Jl. Patimura - Pasar Raya Salatiga', 'H 9309 RB', 'Hidayat', '1357-0062-097501', '081942875539', 'A-0005'),
(6, 'Jl. Patimura - Pasar Raya Salatiga', 'H 6040 AV', 'Nugroho', '1357-01873-319305', '08123429876', 'A-0006'),
(7, 'Jl. Patimura - Bawen', 'H 9100 RI', 'Susilo', '1357-0092-097125', '081247502349', 'B-0001'),
(8, 'Jl. Patimura - Tingkir', 'H 9708 YD', 'Yadi', '1357-0054-107409', '08134578201', 'A-0007'),
(9, 'Jl. Patimura - Alun2 Pancasila', 'H 6030 GH', 'Hadi', '1373-0230-097509', '0812398343108', 'A-0008');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id_user` int(11) NOT NULL,
  `id_class` int(11) NOT NULL,
  `id_subject` int(11) NOT NULL,
  `id_hostel` int(11) NOT NULL,
  `id_trans` int(11) NOT NULL,
  `id_user_type` int(11) NOT NULL,
  `id_parent` int(11) NOT NULL,
  `id_student` int(11) NOT NULL,
  `session` varchar(50) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `gender` enum('Laki-laki','Perempuan') NOT NULL,
  `date_of_birth` date NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `religion` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `NISN` int(11) NOT NULL,
  `photo_user` varchar(255) DEFAULT NULL,
  `blood_group` char(5) DEFAULT NULL,
  `occupation` varchar(255) NOT NULL,
  `phone_user` varchar(25) NOT NULL,
  `address_user` text DEFAULT NULL,
  `status` tinyint(2) NOT NULL,
  `short_bio` text DEFAULT NULL,
  `admission_status` varchar(11) DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `delete_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id_user`, `id_class`, `id_subject`, `id_hostel`, `id_trans`, `id_user_type`, `id_parent`, `id_student`, `session`, `first_name`, `last_name`, `gender`, `date_of_birth`, `username`, `password`, `religion`, `email`, `NISN`, `photo_user`, `blood_group`, `occupation`, `phone_user`, `address_user`, `status`, `short_bio`, `admission_status`, `admission_date`, `create_at`, `update_at`, `delete_at`) VALUES
(0, 0, 0, 0, 0, 4, 0, 0, '0', 'Belum', 'Ada', 'Perempuan', '0000-00-00', '', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', '', '', 0, NULL, NULL, 'Wiraswasta', '', NULL, 0, NULL, NULL, NULL, '2022-12-09 06:10:34', '2022-12-22 09:52:30', NULL),
(2, 1, 0, 0, 1, 1, 0, 0, '2023-2024', 'doni', 'billar', 'Laki-laki', '2022-06-07', 'random', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'other', 'oniworld@oniworld.com', 10254, 'default.png', 'A', '', '+628963333930', 'random', 1, 'random', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(3, 6, 0, 0, 1, 1, 48, 0, '2023-2024', 'Art', 'Ankunding', 'Perempuan', '0000-00-00', 'gaylord.schoen', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'moore.eveline@example.net', 10150, 'default.png', 'B', '', '793-284-4861', '5934 Jacinto Crossroad Apt. 364Olsonmouth, KS 30988', 0, 'Necessitatibus error atque delectus ipsa libero. Harum quasi assumenda quos illum. Maiores et ipsam iusto at ea qui quibusdam. Eligendi iure libero aut quia quia vero autem.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(4, 2, 0, 0, 1, 1, 48, 0, '2023-2024', 'Emily', 'Aufderhar', 'Perempuan', '0000-00-00', 'so\'keefe', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'briana.weimann@example.net', 10280, 'default.png', NULL, '', '1-688-563-2931x133', '1691 Rice Underpass\r\nNorth Valentinamouth, ID 91399', 0, 'Dolore inventore iure repudiandae qui consequatur accusamus. Recusandae dolorem quam est saepe sed unde soluta. Atque id qui deleniti aut repellat. Maxime quaerat ut corrupti et et enim sint.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(5, 2, 0, 0, 1, 1, 48, 0, '2023-2024', 'Ida', 'Roberts', 'Perempuan', '0000-00-00', 'swilderman', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'islam', 'clifford61@example.com', 11237, 'default.png', 'A', '', '1-357-343-0969x83055', '002 Connelly Canyon Apt. 917New Joyburgh, WA 46394', 0, 'Libero earum dolor possimus accusantium vitae fugiat ratione. Cumque cumque tempore et est dolore rerum voluptatem molestiae. Quas sunt omnis asperiores dolor provident culpa inventore.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(6, 8, 0, 0, 1, 1, 143, 0, '2023-2024', 'Eloisa', 'Langworth', 'Laki-laki', '0000-00-00', 'hyman77', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'rod.willms@example.org', 15632, 'default.png', 'o', '', '8833275468', '1265 Johns Valley Suite 874\r\nSamsonshire, OR 34497', 0, 'Porro ipsa nam harum. Perferendis similique voluptatem incidunt nisi facilis et ratione. Voluptatum tenetur qui sit rerum quam quasi similique. Impedit et corporis repellendus est.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-23 09:25:56', NULL),
(7, 8, 0, 0, 1, 1, 0, 0, '2023-2024', 'Gail', 'Kris', 'Perempuan', '0000-00-00', 'lcarroll', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'buddha', 'nakia.greenfelder@example.net', 14941, 'default.png', NULL, '', '190-759-4362x6965', '63471 Kamren Ridge Apt. 498\r\nPollichstad, DC 10284-9138', 0, 'Sint nam aut quasi autem at. Fuga nesciunt aut dolorem numquam tempore autem. Quia sequi sapiente sunt minima. Et excepturi aut odio tempore.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(8, 9, 0, 0, 1, 1, 0, 0, '2023-2024', 'Frederik', 'Kunde', 'Perempuan', '0000-00-00', 'colleen24', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'konghucu', 'angelica.yundt@example.org', 18096, 'default.png', 'a', '', '+14(0)3210550981', '61488 Abbott Greens Suite 690\r\nNorth Rashad, AZ 41490-7600', 0, 'Dolor dolores sed tempore nesciunt id neque. Provident velit officiis error laudantium recusandae ipsam. Amet quod qui animi repudiandae. Nesciunt nulla omnis aut inventore impedit.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(9, 9, 0, 0, 1, 1, 0, 0, '2023-2024', 'Jean', 'Volkman', 'Perempuan', '0000-00-00', 'adan25', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'katholik', 'larry.greenfelder@example.com', 16146, 'default.png', 'a', '', '921-106-9611x9156', '584 Erik Freeway Suite 364\r\nLake Hollieshire, HI 68610-6011', 0, 'Quis omnis consequatur non mollitia. Eos quae inventore quia vero voluptates. Quia eos rerum sunt.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(10, 8, 0, 0, 1, 1, 0, 0, '2023-2024', 'Melisa', 'Shanahan', 'Laki-laki', '0000-00-00', 'jeffrey.mosciski', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'islam', 'odell04@example.com', 16733, 'default.png', 'b', '', '840.286.9973', '0004 Mallie Spur\r\nBoehmmouth, TN 31023-9628', 0, 'Quaerat rerum voluptatem sint veritatis blanditiis. Deserunt debitis quae at sequi unde nam id.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(11, 2, 0, 0, 1, 1, 0, 0, '2023-2024', 'Dorthy', 'Quigley', 'Perempuan', '0000-00-00', 'irogahn', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'konghucu', 'kamron67@example.com', 15617, 'default.png', NULL, '', '872-446-3268', '898 Pansy Grove\r\nMarcoview, ID 86792-6245', 0, 'Sed praesentium cumque quisquam nesciunt velit et molestiae. Autem qui error sapiente id maiores enim. Voluptatibus harum quo repellat quo sed sed.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(12, 7, 0, 0, 1, 1, 40, 0, '2023-2024', 'Trudie', 'Gerlach', 'Laki-laki', '2022-12-16', 'reyes74', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'islam', 'howell.chaya@example.com', 18174, 'default.png', 'AB', '', '1-276-435-9103', '6849 Larissa Knoll Suite 868Jannieburgh, HI 51665-4430', 0, 'Qui ea et pariatur ea enim illo. At facere sit ipsam autem reiciendis in. Veniam aut hic non in vel.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(13, 9, 0, 0, 1, 1, 0, 0, '2023-2024', 'Izabella', 'Schmidt', 'Laki-laki', '0000-00-00', 'crooks.fritz', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'willie72@example.com', 14510, 'default.png', 'b', '', '1-334-146-0072', '5091 Einar Causeway Suite 165\r\nWainoland, NE 06708', 0, 'Cumque in at sapiente minima vel sapiente. Ad corporis voluptatem ut animi. Ut minima impedit reprehenderit dolorum dolor et harum est.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(14, 3, 0, 0, 1, 1, 0, 0, '2023-2024', 'Guadalupe', 'Orn', 'Perempuan', '0000-00-00', 'xzulauf', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'yvette13@example.org', 18216, 'default.png', NULL, '', '+20(7)5881288361', '21645 Hane Station\r\nNew Buster, ND 97672', 0, 'Labore sunt quidem corrupti enim nesciunt. Voluptas autem repudiandae distinctio asperiores et perferendis. Repellat ab est eaque excepturi odio maxime provident. Eaque aut ut eos alias.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(15, 9, 0, 0, 1, 1, 0, 0, '2023-2024', 'Savannah', 'Pfannerstill', 'Laki-laki', '0000-00-00', 'tchristiansen', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'bernhard45@example.com', 18040, 'default.png', 'b', '', '991278584', '182 Rose Trail Suite 818\r\nMarinahaven, CO 75392-6357', 0, 'Non cupiditate fuga veniam. Voluptates ut quis autem in fugiat nemo enim. Distinctio voluptatem vero enim animi possimus et.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(16, 9, 0, 0, 1, 1, 0, 0, '2023-2024', 'Oscar', 'Stehr', 'Laki-laki', '0000-00-00', 'powlowski.korey', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'katholik', 'carmen96@example.net', 15943, 'default.png', 'ab', '', '(249)159-6429', '0916 Alyson Junction\r\nWest Harley, UT 43822', 0, 'Asperiores assumenda laboriosam tempore corporis quia nihil. Doloribus voluptatem et sit omnis. A dolor at error pariatur. Sequi est et dolor repellat quia.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(17, 8, 0, 0, 1, 1, 0, 0, '2023-2024', 'Izabella', 'Parisian', 'Perempuan', '0000-00-00', 'eleanora89', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'konghucu', 'gerda12@example.com', 15884, 'default.png', 'o', '', '354558932', '737 Hudson Canyon Apt. 058\r\nBaumbachland, UT 53383', 0, 'Quo earum magni consequuntur voluptatem. In qui maxime aperiam et ut. Rem deserunt odio aut excepturi consectetur aut.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(18, 5, 0, 0, 1, 1, 0, 0, '2023-2024', 'Alexandrea', 'Mosciski', 'Perempuan', '0000-00-00', 'wmills', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'konghucu', 'ekulas@example.com', 11979, 'default.png', NULL, '', '6741080428', '708 Richmond Mews\r\nWest Alessandroton, NH 32783', 0, 'Eveniet inventore qui rerum omnis. Quibusdam facere possimus atque sit laboriosam enim. A suscipit numquam fuga tenetur dolor. Voluptas odio aliquid consequuntur quam.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(19, 8, 0, 0, 1, 1, 0, 0, '2023-2024', 'Damion', 'Davis', 'Perempuan', '0000-00-00', 'ariane.schulist', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'konghucu', 'mboehm@example.com', 12431, 'default.png', 'ab', '', '1-252-674-9635x226', '75115 Rau Junctions\r\nSengerhaven, NV 27007-3248', 0, 'Consequatur esse vel facilis maxime nisi. Eos tenetur sapiente ea quo. Nemo ipsam reprehenderit quaerat consequatur.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(20, 5, 0, 0, 1, 1, 0, 0, '2023-2024', 'Burdette', 'Murphy', 'Perempuan', '0000-00-00', 'yazmin.ruecker', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'buddha', 'nlemke@example.com', 16507, 'default.png', 'o', '', '7654229082', '5859 Collins Causeway Suite 842\r\nSouth Evanshaven, ND 35538', 0, 'Sit explicabo omnis excepturi modi asperiores voluptatem. Aliquid non rerum cumque est. Cumque eum quo reiciendis minima quibusdam explicabo. Omnis nisi natus fugit omnis.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(21, 99, 0, 0, 1, 1, 0, 0, '2023-2024', 'Gustave', 'Toy', 'Perempuan', '2022-12-18', 'bbechtelar', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'katholik', 'shakira27@example.net', 15731, 'default.png', 'B', '', '1-078-171-2509x85539', '701 Gardner ForksLake Hankfort, MO 55880-4799', 0, 'Beatae aliquam quo enim omnis natus ipsum. Fuga ipsa porro deleniti. Alias et cum ex tempore possimus. Rerum iusto aut fugit totam.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(22, 7, 0, 0, 1, 1, 0, 0, '2023-2024', 'Leonard', 'Gerhold', 'Perempuan', '0000-00-00', 'myah37', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'konghucu', 'rubye97@example.org', 19423, 'default.png', 'b', '', '+47(6)2868941917', '6881 Wunsch Island Suite 700\r\nWest Lurline, OH 96248', 0, 'Quia laudantium aut architecto voluptas consectetur iure aut odit. Esse aspernatur dolorum qui error ratione dolores voluptate.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(23, 1, 8, 0, 1, 2, 0, 0, '0', 'Dennis', 'Maggio', 'Laki-laki', '0000-00-00', 'denis', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'konghucu', 'sophie44@example.org', 18043874, 'default.png', '', '', '(772)694-3622x00197', '894 Eliza RidgeWest Eldred, NC 94050-2424', 1, 'asdfa;mm eos. Nulla dolorum ipsam quia aut repudiandae. Culpa at rerum odit ab veritatis.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(24, 7, 0, 0, 1, 1, 0, 0, '2023-2024', 'Concepcion', 'Bins', 'Laki-laki', '0000-00-00', 'kmclaughlin', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'gorczany.josh@example.com', 10515, 'default.png', 'o', '', '1-022-903-7435x40047', '54004 Kirlin Greens\r\nNew Anastasiatown, WY 99939', 0, 'Ut omnis hic vel deserunt ducimus culpa et ratione. Consequuntur iste ducimus nesciunt voluptatem. Tenetur animi quidem velit id eligendi. Cum qui aut voluptatem quia quas earum.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(25, 0, 0, 1, 1, 4, 0, 0, '0', 'Dawson', 'Gerlach', 'Perempuan', '2022-12-16', 'leuschke.constan', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'budda', 'ischiller@example.com', 0, 'default.png', 'B', 'Buruh', '443-604-3760x7204', '424 Prosacco Roads Apt. 594West Vena, IA 04021-9280', 0, 'asd nihil a inventore quis quia. Quo cum harum expedita quo. Non eligendi blanditiis in voluptatem voluptate et sed.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(26, 2, 0, 1, 1, 1, 0, 0, '2023-2024', 'Krystel', 'Robel', 'Perempuan', '0000-00-00', 'floy19', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'budda', 'lavon.kiehn@example.com', 14293, 'default.png', 'o', '', '(734)811-3853x015', '775 Marcella Turnpike\r\nMaeview, CA 39576-7115', 0, 'Sint in nisi mollitia sint aut et mollitia. Et id consectetur eum voluptatum numquam consequatur. Quas iste excepturi a ea. Nemo amet qui voluptatem recusandae et.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(27, 9, 0, 0, 1, 1, 0, 0, '2023-2024', 'Dee', 'Abbott', 'Laki-laki', '0000-00-00', 'christine.moore', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'ullrich.scarlett@example.com', 10407, 'default.png', 'b', '', '1-338-236-4642', '61777 Norene Parkway Suite 119\r\nLazarohaven, VT 40702', 0, 'Quo vel et atque doloribus. Facere et magnam recusandae debitis.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(28, 0, 0, 0, 1, 3, 0, 0, '0', 'Vesta', 'Ebert', 'Laki-laki', '0000-00-00', 'admin', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'katholik', 'admin@example.com', 0, 'default.png', 'ab', '', '1-809-594-5107', '519 Kacey Creek Suite 626\r\nHyattburgh, WY 71503', 1, 'Numquam et ullam est et. Quam rerum mollitia nihil distinctio.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(29, 0, 0, 1, 1, 4, 0, 0, '0', 'Ola', 'Wyman', 'Laki-laki', '0000-00-00', 'kennith.rath', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'islam', 'julia13@example.org', 0, 'default.png', 'ab', 'Buruh', '918.562.6265x9591', '308 Morar Cliffs Apt. 992\r\nTamaratown, KY 32634', 0, 'Aspernatur est sunt doloribus quasi. Nobis beatae sed rerum voluptas impedit aliquam debitis consectetur. Voluptate eveniet autem dolor enim. Est id tempore ipsum. Voluptas aut amet minus similique', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(30, 2, 6, 0, 1, 2, 0, 0, '0', 'Bobbie', 'O\'Kon', 'Laki-laki', '0000-00-00', 'koss.melyna', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'konghucu', 'wisozk.jasen@example.com', 17433627, 'default.png', 'a', '', '1-791-343-0739x7746', '41544 Windler Coves\r\nEast Henderson, MN 64250', 0, 'Cupiditate quod qui consectetur nihil aperiam voluptatem molestiae. Facilis aut quos debitis earum velit. Repellat accusantium soluta reprehenderit ut.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(31, 0, 0, 1, 1, 4, 0, 0, '0', 'Beulah', 'Jast', 'Laki-laki', '0000-00-00', 'ruby.gulgowski', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'mpowlowski@example.org', 0, 'default.png', 'b', 'Buruh', '983.603.0136x3525', '28148 Angie Trail\r\nSouth Gabriel, WY 69863', 0, 'Blanditiis debitis repellendus adipisci soluta occaecati illum. Hic porro quia dolorum maxime eos tempora.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(32, 0, 0, 1, 1, 4, 0, 0, '0', 'Roberta', 'Zboncak', 'Laki-laki', '0000-00-00', 'dawn50', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'mallory38@example.org', 0, 'default.png', 'b', 'PNS', '945.376.7830', '9545 O\'Connell Branch\r\nAlexandreaport, TX 50847', 0, 'Ut placeat voluptatem totam velit. Incidunt vel qui eos.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(33, 0, 0, 1, 1, 3, 0, 0, '0', 'River', 'Price', 'Laki-laki', '0000-00-00', 'vonrueden.gregor', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'o\'conner.hilario@example.net', 0, '20221207042906-default.png', 'b', '', '(295)695-0717x38707', '18056 Filiberto JunctionsWest Gunnarberg, SC 45720-9408', 0, 'Est corrupti mollitia et quisquam non. Reiciendis nisi consequatur nisi vel ducimus necessitatibus impedit. Eos labore soluta a.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(34, 3, 6, 1, 1, 2, 0, 0, '0', 'Morris', 'Bins', 'Perempuan', '0000-00-00', 'kparker', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'weber.hollis@example.com', 21825301, 'default.png', NULL, '', '064-708-6688', '2697 Haag MeadowWindlertown, WV 35174', 0, 'Et consequatur exercitationem aut et non dolorem. Et id deleniti sit maxime reprehenderit asperiores hic. Odio odio magnam enim eum libero. Consequatur eos reprehenderit delectus perferendis quidem', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(35, 4, 1, 1, 1, 2, 0, 0, '0', 'Rosina', 'Mertz', 'Laki-laki', '0000-00-00', 'lonzo.conroy', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'konghucu', 'jimmy21@example.net', 11714784, 'default.png', 'ab', '', '+35(9)1535087533', '45732 Hoppe Club Apt. 522\r\nNorth Julio, IA 63468', 0, 'In commodi molestias eos iure distinctio nesciunt ratione. Voluptatem quaerat in autem et consequatur alias quam blanditiis. Atque voluptatum doloribus minima adipisci voluptatem in eos rerum.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(36, 0, 0, 0, 1, 4, 0, 0, '0', 'Filomena', 'Russel', 'Perempuan', '0000-00-00', 'qhowell', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'budda', 'ypurdy@example.net', 0, 'default.png', 'b', 'PNS', '384-461-1789x49450', '727 Bo Motorway\r\nKathlynview, ME 94561', 0, 'Et at dicta quo. Velit nemo sint rerum et in et deleniti ex. Possimus nisi nihil animi corporis voluptatum delectus inventore.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(37, 0, 0, 1, 1, 3, 0, 0, '0', 'Clarabelle', 'Doyle', 'Laki-laki', '0000-00-00', 'johnathan61', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'budda', 'keven05@example.org', 0, 'default.png', 'ab', '', '339.842.4786x72097', '78548 Metz Ridges\r\nSouth Jeff, CA 95702-8039', 0, 'Expedita rerum qui qui voluptatem deleniti. Quia quidem et optio illum. Quia quidem mollitia quo.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(38, 0, 0, 1, 1, 4, 0, 0, '0', 'Cathryn', 'Moen', 'Laki-laki', '0000-00-00', 'davon.smith', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'pouros.mireya@example.com', 0, 'default.png', 'ab', 'Buruh', '270.722.2115x872', '1776 Aurelie Junctions Apt. 155\r\nGardnerville, ME 83614', 0, 'Ut ut laboriosam necessitatibus delectus voluptas. Deleniti illum est sed. Quidem nesciunt repudiandae maxime rerum veritatis aliquid est. Cupiditate quis inventore libero adipisci et et voluptatem', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(39, 100, 6, 1, 1, 2, 0, 0, '0', 'Gianni', 'Hamill', 'Perempuan', '0000-00-00', 'abshire.dagmar', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'cortez.pfeffer@example.org', 15786436, 'default.png', 'o', '', '(602)969-1586x47582', '28684 Yundt Motorway Apt. 244\r\nJamaalberg, NH 22751-3241', 0, 'Eos possimus neque necessitatibus animi quae sit qui. Pariatur iste deleniti harum expedita iusto. Est molestiae minima veritatis quos ut.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(40, 0, 0, 1, 1, 4, 0, 0, '0', 'Mac', 'Dooley', 'Laki-laki', '0000-00-00', 'mbotsford', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'islam', 'herminia.towne@example.net', 0, 'default.png', 'b', 'Tani', '7735747152', '2193 Lakin Glens\r\nNorth Brandyn, WV 03653', 0, 'Aliquid aliquam necessitatibus at esse sed. Quibusdam inventore aspernatur vel dolorem dolore in sed. Dolorum ut nihil dolorem aperiam.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(41, 6, 5, 1, 1, 2, 0, 0, '0', 'Mellie', 'Purdy', 'Perempuan', '0000-00-00', 'tbuckridge', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'konghucu', 'gbartoletti@example.net', 21276742, 'default.png', 'a', '', '(211)988-9461x932', '7061 Julien Mall Apt. 633\r\nNew Rosaleestad, WA 81371', 0, 'Est et inventore qui dolorem numquam error nesciunt corrupti. Et nobis eos quia non facilis. Voluptates sunt incidunt labore magnam reiciendis molestiae.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(42, 0, 0, 0, 1, 3, 0, 0, '0', 'Myron', 'Schaefer', 'Laki-laki', '0000-00-00', 'gorczany.kenna', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'budda', 'hlang@example.com', 0, 'default.png', 'ab', '', '(914)575-2607', '014 Durgan Springs Apt. 483\r\nChamplinhaven, WV 88447-3640', 0, 'Voluptatem accusantium dolore eaque delectus molestiae eos quis. Laudantium eos possimus et quos qui dolores omnis quis. Libero provident officia atque consequatur pariatur aperiam officiis.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(43, 0, 0, 1, 1, 4, 0, 0, '0', 'Violet', 'Waelchi', 'Laki-laki', '0000-00-00', 'ykoch', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'islam', 'gaetano48@example.net', 0, 'default.png', 'a', 'Tani', '987.642.4961x6324', '196 Christiansen Ports Apt. 544\r\nLake Zechariah, VT 52664', 0, 'Nesciunt ipsam qui qui id sit delectus ab omnis. Atque totam quis quibusdam. Adipisci qui aut est maxime.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(44, 3, 0, 1, 1, 1, 0, 0, '2023-2024', 'Alice', 'Hand', 'Perempuan', '0000-00-00', 'larson.creola', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'walsh.pearlie@example.org', 19245, 'default.png', 'ab', '', '(107)804-7166', '39590 Zelma Views\r\nWest Anneberg, IL 86307-9429', 0, 'At et suscipit at aliquid qui quia. Qui mollitia ut occaecati voluptatem optio aut architecto. Molestiae et omnis quos reprehenderit sunt eos. In hic omnis repudiandae. Sequi rerum minus et sit iur', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(45, 0, 0, 1, 1, 3, 0, 0, '0', 'Queenie', 'Dare', 'Perempuan', '0000-00-00', 'ubraun', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'konghucu', 'qhowell@example.com', 0, 'default.png', 'a', '', '(277)668-0913', '150 Destinee Park\r\nAbagailtown, TX 82605-7785', 0, 'Temporibus suscipit aspernatur et praesentium corrupti sint id et. Nihil error et et cum. Voluptates eveniet tenetur impedit sapiente. Nisi cumque sed voluptatem consequatur. Possimus quam repellen', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(46, 0, 0, 0, 1, 3, 0, 0, '0', 'Brenden', 'Swaniawski', 'Laki-laki', '0000-00-00', 'kailyn.shanahan', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'katholik', 'corkery.llewellyn@example.org', 0, 'default.png', 'o', '', '738.358.7331x0550', '707 Miguel Mountain\r\nSouth Clotildebury, MT 28756', 0, 'Tempora ullam doloremque blanditiis nulla. Esse asperiores voluptatem et enim cum at. Delectus nisi voluptatibus sit qui aut. Voluptatem nihil facere est magnam sed.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(47, 7, 5, 1, 1, 2, 0, 0, '0', 'Maximus', 'Kreiger', 'Perempuan', '0000-00-00', 'okuneva.braden', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'katholik', 'kuhlman.hollis@example.com', 13913563, 'default.png', 'a', '', '1-161-987-6381x320', '2016 Schultz Ways Suite 118\r\nO\'Haratown, NC 42649', 0, 'Pariatur nobis et quisquam ullam possimus earum ratione. Nemo deleniti ullam qui voluptate. Aut et ut sit non.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(48, 0, 0, 1, 1, 4, 0, 0, '0', 'Gerald', 'Feil', 'Laki-laki', '2022-12-13', 'imante', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'dkoss@example.net', 0, 'default.png', 'B', 'PNS', '0860848132040124', '709 Porter RouteElsieberg, KS 69757', 1, 'Cumque id aliquid ab esse odio officiis quis. Pariatur aperiam dolores vitae voluptatem ipsam enim. Sint maxime nesciunt beatae ipsum.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-23 02:59:33', NULL),
(49, 0, 0, 0, 1, 3, 0, 0, '0', 'Shaniya', 'Schmeler', 'Laki-laki', '0000-00-00', 'maximo26', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'konghucu', 'shana.lynch@example.com', 0, 'default.png', 'ab', '', '1-609-841-4199', '161 Stevie Corners\r\nLake Bridgetport, IA 38827-2489', 0, 'Nostrum error eum libero eos repellat reprehenderit. Eveniet sit soluta harum pariatur expedita minus iusto. Atque harum impedit quo consequatur veritatis impedit.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(50, 0, 0, 0, 1, 4, 0, 0, '0', 'Maxwell', 'Swift', 'Perempuan', '0000-00-00', 'vbailey', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'cecelia42@example.net', 0, 'default.png', 'a', 'PNS', '381.499.8037x4064', '590 Brekke Curve Suite 529\r\nChaddstad, MT 21354', 0, 'Modi inventore itaque nemo blanditiis quas quibusdam molestiae. Deserunt perferendis aliquid doloremque rerum. Nobis quam voluptatem occaecati nisi natus veniam. Nobis reiciendis in libero. Quae re', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(51, 0, 0, 1, 1, 3, 0, 0, '0', 'Don', 'Dibbert', 'Perempuan', '0000-00-00', 'mills.verda', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'jarred07@example.org', 0, 'default.png', 'ab', '', '(577)154-0711', '339 Shyanne Flat Suite 962\r\nJalynhaven, AR 86445-0491', 0, 'Ex ipsam earum praesentium itaque voluptatum. Sunt perspiciatis magnam a sit nobis non voluptatem assumenda. Tempora sunt labore sit ea.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(52, 0, 0, 1, 1, 4, 0, 0, '0', 'Osborne', 'Denesik', 'Perempuan', '0000-00-00', 'florian.lubowitz', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'otowne@example.com', 0, 'default.png', 'o', 'Buruh', '(441)161-7605x73161', '18149 McClure Centers Apt. 622\r\nSouth Codychester, MO 12219', 0, 'Quas praesentium tempore animi rerum non perferendis qui velit. Est voluptatum at doloribus nihil. Tempore qui impedit nam sapiente porro.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(53, 0, 0, 1, 1, 3, 0, 0, '0', 'Antwon', 'Turner', 'Perempuan', '0000-00-00', 'raphaelle.kuhic', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'konghucu', 'johnathan16@example.net', 0, 'default.png', 'b', '', '639437654', '50966 Oberbrunner Plains Suite 675\r\nKshlerinside, KY 67435-5414', 0, 'Est nostrum deserunt a fugit. Aspernatur corporis quidem exercitationem eligendi. Ex culpa eligendi nihil quaerat voluptatem consequatur.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(54, 0, 0, 0, 1, 4, 0, 0, '0', 'Pattie', 'Dietrich', 'Perempuan', '0000-00-00', 'rauer', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'islam', 'morar.leonie@example.org', 0, 'default.png', 'a', 'PNS', '185-166-6647', '5321 Jensen Walks\r\nLake Keshaunland, IL 64922', 0, 'Perferendis dolore voluptatibus error earum sed ut alias. Sunt nisi sed sed harum dolorem qui. Expedita est hic et ut nihil nihil adipisci.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(55, 4, 0, 0, 1, 1, 0, 0, '2023-2024', 'Margarete', 'Abshire', 'Laki-laki', '0000-00-00', 'koelpin.shany', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'islam', 'epowlowski@example.org', 15697, 'default.png', 'b', '', '(889)557-7513x70590', '42509 Kaycee Glens\r\nWest Madaline, TN 22033', 0, 'Quos dolorem aut nihil et quasi deleniti excepturi voluptatem. Dolores deserunt quas aperiam odio temporibus. Voluptatem doloribus itaque dolor deleniti voluptate accusantium non provident. Unde ex', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(56, 8, 11, 0, 1, 2, 0, 0, '0', 'Golda', 'Fritsch', 'Perempuan', '0000-00-00', 'golda', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'zoila.kuhic@example.com', 17126128, 'default.png', 'A', '', '3694579473', '11592 Elton InletLake Robb, KY 67888', 1, 'oiskadlmaaawd', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(57, 9, 6, 1, 1, 2, 0, 0, '0', 'Yesenia', 'Ratke', 'Laki-laki', '0000-00-00', 'dahlia.kuphal', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'budda', 'schulist.leslie@example.net', 21378865, 'default.png', 'o', '', '5381836391', '1701 Ashlee Unions\r\nCamilamouth, ND 94638', 0, 'Sunt maiores ex cumque qui eaque. Repellat ut ut et voluptas a. Voluptas veniam ipsa ipsum non.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(58, 0, 0, 0, 1, 4, 0, 0, '0', 'Joseph', 'Mosciski', 'Perempuan', '0000-00-00', 'hackett.nestor', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'jacobs.giovani@example.com', 0, 'default.png', 'a', 'Tani', '(359)377-0828', '35521 Hoppe Stream\r\nNew Sammieborough, KY 15342-5117', 0, 'Perspiciatis totam quia quo recusandae voluptatum ad. Minima reprehenderit corrupti dolore voluptas illo numquam. Aut possimus sit voluptatibus voluptatibus.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(59, 0, 6, 1, 1, 2, 0, 0, '0', 'Aurore', 'Watsica', 'Perempuan', '2022-12-29', 'xpagac', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'braulio08@example.com', 21704978, 'default.png', '', '', '199-288-6890', '7812 Nadia Plains Apt. 279Blickville, MN 53433', 0, 'Illum rerum illo neque voluptatum iure deserunt sequi. Voluptates sequi voluptas officiis inventore distinctio voluptas. Qui rerum voluptatibus similique sed laborum in vel. Laudantium impedit dolo', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(60, 0, 0, 0, 1, 4, 0, 0, '0', 'Carroll', 'Metz', 'Perempuan', '0000-00-00', 'aimee.lehner', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'katholik', 'wisoky.sonya@example.org', 0, 'default.png', 'a', 'Buruh', '(508)181-7365x0413', '541 Bahringer Cliff Apt. 444\r\nLauramouth, DC 87038-7542', 0, 'Esse mollitia adipisci ut ullam dolores dolorem nemo numquam. Vel atque modi quod. Animi qui laboriosam molestiae asperiores et aut voluptas.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(61, 3, 0, 1, 1, 1, 0, 0, '2023-2024', 'Letha', 'Kuhn', 'Perempuan', '0000-00-00', 'wkassulke', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'lauriane14@example.net', 11038, 'default.png', 'a', '', '1-460-588-3379', '80930 Lulu Unions Suite 023\r\nKlingmouth, GA 51413-0744', 0, 'Magni animi excepturi explicabo reprehenderit eum velit accusantium. Provident rerum doloremque accusantium velit ut minus totam. Molestias nemo id quidem impedit nihil ullam debitis qui. Quia qui', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(62, 0, 0, 0, 1, 4, 0, 0, '0', 'Easton', 'Ebert', 'Laki-laki', '0000-00-00', 'leilani33', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'islam', 'gay.frami@example.org', 0, 'default.png', 'b', 'PNS', '(461)402-5241', '366 Thiel Trace\r\nHackettmouth, NY 90937-7372', 0, 'Neque praesentium inventore atque autem ut ut. Atque ex qui error omnis odio aperiam. Voluptatum rerum aut vero quod est.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(63, 0, 3, 0, 1, 2, 0, 0, '0', 'Beau', 'Moen', 'Perempuan', '0000-00-00', 'buckridge.declan', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'pollich.rey@example.net', 21877209, 'default.png', 'b', '', '1-524-411-3437x376', '798 Mills Port Suite 922\r\nSchmittbury, MA 30341-3273', 0, 'Illo inventore libero ut ut qui non illo ab. Maxime iste quidem rerum optio et hic. Optio eos quibusdam et facere veritatis.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(64, 0, 0, 1, 1, 4, 0, 0, '0', 'Jordy', 'Sporer', 'Laki-laki', '0000-00-00', 'emmett.reynolds', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'katholik', 'abner.emard@example.net', 0, 'default.png', 'ab', 'Wiraswasta', '1-183-035-1507x03759', '970 Gulgowski Field Apt. 724\r\nNorth Masonmouth, MA 41865-8673', 0, 'Expedita qui eum quia earum. Provident architecto quo modi enim veritatis reprehenderit at. Expedita dolor consequatur aperiam veritatis consequuntur repudiandae nihil.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(65, 0, 0, 0, 1, 3, 0, 0, '0', 'Lela', 'Wintheiser', 'Perempuan', '0000-00-00', 'susan.baumbach', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'konghucu', 'harris.keaton@example.net', 0, 'default.png', 'a', '', '(337)020-3611', '4461 Yundt Mountains Suite 793\r\nLake Alta, DC 12610', 0, 'Autem qui dolorem quia. Et eum accusantium omnis dignissimos quibusdam amet iste. Nobis quia in quia ducimus pariatur atque sunt. Quos et est saepe dolorem rerum.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(66, 0, 0, 1, 1, 3, 0, 0, '0', 'Orrin', 'O\'Kon', 'Perempuan', '0000-00-00', 'bailey.braulio', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'katholik', 'blake83@example.org', 0, 'default.png', 'a', '', '058-663-3142x6095', '237 Rippin Inlet\r\nNorth Vance, OH 93334-7482', 0, 'Cupiditate autem ad sint debitis repudiandae. Minus dolorem mollitia nobis necessitatibus repellat consequatur temporibus. Velit ea in et quia id eius magni. Architecto iste rerum dolor eos qui.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(67, 5, 5, 1, 1, 2, 0, 0, '0', 'Edd', 'Daugherty', 'Perempuan', '0000-00-00', 'po\'conner', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'islam', 'sledner@example.net', 21760024, 'default.png', 'o', '', '311-179-2331x6974', '347 Bessie Inlet Apt. 559\r\nAricchester, PA 30274-0796', 0, 'Reprehenderit ex ut sed non earum quo. Nihil fugit dolores magnam in et. Nihil consectetur ab unde fuga veritatis modi minus. Facere totam quia aut qui omnis natus quos.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(68, 0, 0, 0, 1, 3, 0, 0, '0', 'Telly', 'Kuhic', 'Laki-laki', '0000-00-00', 'langosh.lia', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'smann@example.org', 0, 'default.png', 'a', '', '1-883-940-0806x90837', '25049 Dandre Village\r\nMireilleton, NM 12627-4856', 0, 'Autem tenetur et dolor doloribus pariatur at dicta. Nisi aut voluptatem nesciunt necessitatibus iure ut. Qui est autem deserunt ut ad modi esse dignissimos.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(69, 0, 6, 0, 1, 2, 0, 0, '0', 'Kelly', 'Paucek', 'Laki-laki', '0000-00-00', 'bessie.botsford', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'tremaine75@example.net', 20657403, 'default.png', 'b', '', '197.525.9331x346', '32560 Dallas Plaza\r\nLake Sylvia, NY 04448', 0, 'Voluptatibus eligendi ea est temporibus et hic vel. Ipsum minus quia dolorum ullam qui.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(70, 0, 0, 0, 1, 4, 0, 0, '0', 'Keanu', 'Kautzer', 'Perempuan', '0000-00-00', 'heathcote.shanie', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'budda', 'hirthe.melyna@example.org', 0, 'default.png', 'ab', 'Wiraswasta', '(607)404-6714', '84372 Kub Flats\r\nLake Richardhaven, NY 80438-5419', 0, 'Est eaque aut sapiente facilis repellendus earum dolore. Id iure voluptas quia non. Amet dolor dignissimos ratione sed modi sint rerum.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(71, 0, 1, 0, 1, 2, 0, 0, '0', 'Katrina', 'Jacobi', 'Perempuan', '0000-00-00', 'varmstrong', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'katholik', 'selena.wiegand@example.net', 15495857, 'default.png', 'a', '', '+72(9)0625133850', '328 Schmitt Courts Apt. 998\r\nNorth Hortensetown, GA 52938', 0, 'Facilis quo corrupti sint nostrum atque aliquam itaque. Dolore sit a maxime facere aut dolorum et. Nihil illum nulla quia aut totam ut ea.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(72, 0, 11, 0, 1, 2, 0, 0, '0', 'Esther', 'Ward', 'Perempuan', '0000-00-00', 'alexzander97', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'islam', 'mollie.lehner@example.net', 15595739, 'default.png', 'ab', '', '083-323-2085x884', '08083 Jena Brooks Suite 339\r\nBrennonton, KS 13646', 0, 'Sint illo velit tenetur eum. Numquam rerum recusandae asperiores amet fuga qui. Odio repellendus sequi itaque atque.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(73, 0, 0, 0, 1, 4, 0, 0, '0', 'Tyrique', 'Schuppe', 'Laki-laki', '0000-00-00', 'jaida.botsford', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'jacklyn32@example.org', 0, 'default.png', 'b', 'PNS', '(424)589-5560', '093 Carolina Curve Suite 094\r\nTillmanmouth, KY 52554', 0, 'Porro architecto quibusdam qui officia et aperiam. Dolor dolorem officia qui ut expedita autem.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(74, 0, 7, 1, 1, 2, 0, 0, '0', 'Hank', 'Schuppe', 'Laki-laki', '0000-00-00', 'ebert.alessandra', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'islam', 'valerie74@example.net', 20279916, 'default.png', 'o', '', '410.809.6965', '4545 Ethan Courts\r\nNolanberg, OH 25894', 0, 'Consectetur et ut porro qui. Itaque quod quasi ipsa fugiat eaque error voluptas. Veritatis animi dolorum dolorum maxime facere est. Eligendi sit eveniet nihil est ut blanditiis minima est.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(75, 0, 0, 1, 1, 4, 0, 0, '0', 'Hellen', 'Kuhlman', 'Laki-laki', '0000-00-00', 'schneider.miller', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'islam', 'renner.jennings@example.net', 0, 'default.png', 'a', 'PNS', '734.883.3580', '857 Julian Forks\r\nKihnview, FL 80887-6395', 0, 'Quibusdam consequatur molestiae reprehenderit aut et. Aut molestiae nobis ipsum sapiente. Distinctio vel ut dignissimos sit officia. Quia iure at ab explicabo in omnis.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(76, 0, 0, 1, 1, 4, 0, 0, '0', 'Melyssa', 'Larkin', 'Perempuan', '0000-00-00', 'ytremblay', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'konghucu', 'kyla08@example.com', 0, 'default.png', 'a', 'Buruh', '7284220161', '423 Weldon Meadow\r\nNorth Patienceshire, OH 40805', 0, 'Itaque possimus porro excepturi rem tempora magni. Qui harum asperiores exercitationem et omnis repellat placeat. Provident repudiandae corrupti laudantium veritatis at. Suscipit debitis et laborio', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(77, 1, 0, 0, 1, 1, 0, 0, '2023-2024', 'Alisha', 'Emard', 'Laki-laki', '2022-12-19', 'strosin.salma', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'konghucu', 'june91@example.net', 18186, 'default.png', '', '', '906.050.3714x3323', '87882 Marquise PointsWatersfort, IA 26172', 0, 'Voluptates possimus natus mollitia aut repellendus quasi et. Omnis perferendis id cupiditate qui illum reiciendis. Ullam nisi libero eaque consequatur soluta. Sit voluptatum non debitis fugiat volu', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(78, 0, 0, 0, 1, 3, 0, 0, '0', 'Shirley', 'Wolff', 'Laki-laki', '0000-00-00', 'aanderson', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'schmidt.tabitha@example.org', 0, 'default.png', 'a', '', '394-952-7760x1067', '73565 Arnulfo Fort\r\nBeierland, NH 87661-2714', 0, 'Id ut dolore magni provident. Nemo mollitia quis omnis aut nesciunt alias. Rerum aliquid temporibus vero dolor. Enim soluta quasi illo.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(79, 0, 0, 0, 1, 3, 0, 0, '0', 'Casimir', 'Prosacco', 'Laki-laki', '0000-00-00', 'rice.rod', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'katholik', 'jennie.jenkins@example.net', 0, 'default.png', 'b', '', '(840)639-7101x783', '652 Schmitt Valley\r\nSouth Anne, AK 97203-6971', 0, 'Dicta quo qui assumenda et. Illum impedit sequi in voluptatem recusandae deserunt incidunt. Et distinctio ut ut nobis dicta dolor.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(80, 0, 0, 0, 1, 4, 0, 0, '0', 'Derek', 'Lehner', 'Perempuan', '2022-12-14', 'roberts.freeda', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'katholik', 'mcclure.wilbert@example.org', 0, 'default.png', 'A', 'Wiraswasta', '1-214-742-1489x3453', '419 Myrna Dale Suite 300East Lailaland, MD 22011-3262', 0, 'Corrupti et tenetur perferendis ipsum repellat quia. Vel illo porro sunt eos. Laboriosam ratione distinctio modi maiores id odit. Laudantium et nisi ipsum et rem culpa quia.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(81, 7, 0, 0, 1, 1, 0, 0, '2023-2024', 'Noble', 'Bode', 'Laki-laki', '0000-00-00', 'demario.d\'amore', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'lexi26@example.org', 18409, 'default.png', 'a', '', '806.032.7230', '0259 Shawn Gateway\r\nNoeliabury, ND 84093-5794', 0, 'In et illum asperiores iusto. Dolor ut velit eum a quo velit autem. Laudantium quo architecto necessitatibus ea dolorem maxime aut.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(82, 0, 0, 0, 1, 4, 0, 0, '0', 'Lorenza', 'Flatley', 'Perempuan', '0000-00-00', 'romaguera.danika', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'elmira.stiedemann@example.org', 0, 'default.png', 'ab', 'Buruh', '539-345-3226x2629', '3292 Greenfelder River Apt. 850\r\nMetzfort, KS 49962-2408', 0, 'Quidem vel dignissimos itaque doloribus facilis reiciendis quas. Nulla excepturi eveniet magni. Suscipit rem ratione corrupti aliquid et.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(83, 0, 0, 0, 1, 3, 0, 0, '0', 'Aliza', 'Von', 'Laki-laki', '0000-00-00', 'jmohr', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'islam', 'rosenbaum.pearline@example.com', 0, 'default.png', 'a', '', '1-247-905-4098x48774', '923 Arlo Valley\r\nGideonhaven, OR 56942', 0, 'Inventore mollitia nihil ducimus ex ut atque veniam magni. Aut et harum dolorem molestias et perspiciatis tempore. Voluptas iusto occaecati non non distinctio sint. Explicabo facilis recusandae ear', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(84, 0, 11, 1, 1, 2, 0, 0, '0', 'Morgan', 'Kiehn', 'Laki-laki', '0000-00-00', 'carlee80', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'islam', 'sarmstrong@example.org', 20801400, 'default.png', 'b', '', '+84(3)2026471890', '135 Lane Flats\r\nPowlowskiberg, RI 53034', 0, 'Eos enim ut nisi voluptate quae quo quia. Qui laboriosam deserunt corporis repudiandae aut velit laudantium. Temporibus libero autem aut quaerat.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(85, 0, 2, 0, 1, 2, 0, 0, '0', 'Shemar', 'Braun', 'Laki-laki', '0000-00-00', 'glennie10', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'dee42@example.com', 20656165, 'default.png', 'o', '', '036-064-9428x534', '227 Keaton Gardens Suite 663\r\nMariliestad, OR 57119-1123', 0, 'Voluptas delectus perspiciatis modi animi odio a pariatur. Totam voluptate eos quia molestiae voluptatem qui. Perspiciatis itaque incidunt hic corrupti.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(86, 2, 0, 0, 1, 1, 0, 0, '2023-2024', 'Kira', 'Harber', 'Laki-laki', '0000-00-00', 'mmacejkovic', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'katholik', 'skye.gislason@example.com', 17875, 'default.png', 'ab', '', '1-672-145-5796x00275', '461 Dickinson Pass\r\nLake Emely, OH 45323-7748', 0, 'Assumenda quia assumenda quo sit molestias doloremque reiciendis tenetur. Molestias explicabo quis ex assumenda at ullam ab. Nostrum et repellendus quidem quia facilis.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(87, 0, 0, 0, 1, 3, 0, 0, '0', 'Coty', 'Streich', 'Perempuan', '0000-00-00', 'tsawayn', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'xmurazik@example.net', 0, 'default.png', 'b', '', '(691)282-4479x925', '497 Borer Forges\r\nNew Charlene, NH 59786', 0, 'Enim veritatis incidunt labore. Nobis esse quia quidem enim tempore totam vitae quis. Aut velit facilis saepe ab et rerum. Autem nisi et sunt asperiores.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(88, 0, 0, 1, 1, 3, 0, 0, '0', 'Myrtice', 'Koch', 'Perempuan', '0000-00-00', 'afton.hegmann', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'destiney25@example.org', 0, 'default.png', 'b', '', '865-430-6194', '60250 Wehner Row Suite 410\r\nNew Aronport, AZ 68844', 0, 'Autem eligendi suscipit sapiente. Ut fuga rem unde ut natus. Neque id in deleniti qui est.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(89, 0, 0, 1, 1, 3, 0, 0, '0', 'Kurt', 'Kohler', 'Perempuan', '0000-00-00', 'ayana.dooley', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'jpfeffer@example.org', 0, 'default.png', 'a', '', '168.055.1846x150', '597 Rudolph Mountains Suite 563\r\nParkerton, OR 70287', 0, 'Consectetur tenetur nisi saepe enim. Vero nesciunt consectetur voluptas ratione. Tenetur ullam molestiae nihil officiis velit nesciunt. Excepturi non id dolore aperiam ut vel. Autem libero eos qui', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(90, 9, 0, 0, 1, 1, 0, 0, '2023-2024', 'Makenzie', 'Gislason', 'Perempuan', '0000-00-00', 'miles25', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'ryan.mina@example.org', 14539, 'default.png', 'a', '', '1-824-420-4680', '865 Elza Fork Apt. 084\r\nEast Calitown, SC 61558', 0, 'Maiores libero repudiandae voluptas. In sit itaque non in qui. Suscipit sint et consequuntur sint vitae ab velit. Voluptatibus esse harum impedit quae incidunt molestiae.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(91, 0, 0, 0, 1, 4, 0, 0, '0', 'Kendra', 'Dare', 'Perempuan', '0000-00-00', 'ylittle', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'isobel32@example.net', 0, 'default.png', 'a', 'Buruh', '030-130-1903', '125 Destin Streets\r\nNorth Anissa, AZ 42428-1612', 0, 'Magnam expedita architecto pariatur inventore impedit sed. Aspernatur rerum perspiciatis quo et molestias. Similique qui provident et. Vel odit quisquam dolores omnis. Sit est ea aliquam.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(92, 1, 0, 1, 1, 1, 0, 0, '2023-2024', 'Shad', 'Renner', 'Laki-laki', '0000-00-00', 'leonel45', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'thompson.rubie@example.com', 19257, 'default.png', 'b', '', '6669881083', '9035 Waelchi Way Suite 659\r\nCarterville, OK 53786-1752', 0, 'Ut itaque minima molestias maxime. Delectus dolorum deserunt pariatur.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL);
INSERT INTO `tbl_users` (`id_user`, `id_class`, `id_subject`, `id_hostel`, `id_trans`, `id_user_type`, `id_parent`, `id_student`, `session`, `first_name`, `last_name`, `gender`, `date_of_birth`, `username`, `password`, `religion`, `email`, `NISN`, `photo_user`, `blood_group`, `occupation`, `phone_user`, `address_user`, `status`, `short_bio`, `admission_status`, `admission_date`, `create_at`, `update_at`, `delete_at`) VALUES
(93, 0, 0, 0, 1, 3, 0, 0, '0', 'Ellsworth', 'Dooley', 'Laki-laki', '0000-00-00', 'dach.katherine', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'smith.adriel@example.org', 0, 'default.png', 'ab', '', '891-341-5834', '3940 Hackett Station Suite 265\r\nEast Estella, ND 57843-8954', 0, 'Enim officia porro enim quaerat dicta aperiam. Aut qui laborum voluptates est non doloribus. Assumenda quam ut cumque molestiae placeat. Iste voluptatem sit totam necessitatibus ullam quis labore n', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(94, 0, 0, 1, 1, 4, 0, 0, '0', 'Imelda', 'Zemlak', 'Laki-laki', '0000-00-00', 'xharris', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'shanie.ondricka@example.net', 0, 'default.png', 'ab', 'Wiraswasta', '844.481.3978x5648', '322 Toy Manors\r\nLake Dominique, MA 05307-0162', 0, 'Dolorem praesentium qui expedita sequi sunt voluptas voluptas. Sint et quibusdam iusto est velit error temporibus. Doloribus hic omnis eos quas sunt.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(95, 0, 0, 1, 1, 4, 0, 0, '0', 'Milan', 'Gottlieb', 'Perempuan', '0000-00-00', 'bogisich.demarcu', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'katholik', 'kirstin.grady@example.org', 0, 'default.png', 'ab', 'Wiraswasta', '7348360506', '1298 Alia Falls\r\nUllrichfort, OR 53528', 0, 'Laborum eos quisquam et est aut. Est officia qui eligendi excepturi. Quia et culpa eos soluta. Alias repellat sapiente rem et dolor.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(96, 6, 0, 1, 1, 1, 0, 0, '2023-2024', 'Alfonzo', 'Keeling', 'Perempuan', '0000-00-00', 'martine.goyette', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'zshanahan@example.com', 13258, 'default.png', 'b', '', '1035193354', '55568 Anderson Streets\r\nElliotland, ND 99399', 0, 'Qui possimus ex non molestias non voluptas. Quia et est qui et dolores est. Ratione alias tempora commodi rerum voluptas adipisci. Deserunt doloremque sed consequatur dolores a vel.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(97, 0, 0, 0, 1, 3, 0, 0, '0', 'Kayleigh', 'Brakus', 'Perempuan', '0000-00-00', 'kozey.lyla', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'hindu', 'haylie.schroeder@example.com', 0, 'default.png', 'a', '', '(182)036-3710x075', '0309 David Mews\r\nEast Garett, PA 20575-4413', 0, 'Eos repellendus amet aperiam provident dolorum in dolorum. Veritatis aliquid iste aut. Eius odit est dolore quis.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(98, 0, 0, 0, 1, 4, 0, 0, '0', 'Percy', 'Hauck', 'Perempuan', '0000-00-00', 'bennie47', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'islam', 'sanford97@example.net', 0, 'default.png', 'a', 'Tani', '(033)076-4244', '85776 O\'Reilly Parks Suite 946\r\nPort Desireeburgh, RI 21109', 0, 'Omnis facere perferendis amet soluta voluptates. Occaecati eveniet sed sed culpa. Provident nam dolorum tempore praesentium natus voluptatibus illo quis.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(99, 0, 0, 1, 1, 3, 0, 0, '0', 'Araceli', 'Koss', 'Perempuan', '0000-00-00', 'littel.daniella', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'katholik', 'mercedes59@example.com', 0, 'default.png', 'o', '', '467-321-6972x50539', '43317 Oberbrunner Ramp\r\nNew Verona, NJ 77057-6445', 0, 'Corporis rem ea fugiat cumque. Corrupti unde et repudiandae voluptatem sequi fugit excepturi. Et voluptas aut minus quia est sed est et. Rem sunt exercitationem facere maiores repellat.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(100, 0, 0, 0, 1, 4, 0, 0, '0', 'Laverne', 'Morar', 'Perempuan', '0000-00-00', 'miller20', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'clittle@example.org', 0, 'default.png', 'o', 'Buruh', '5278137898', '40666 Katlyn Shore Suite 040\r\nEast Kelli, ID 28933-3389', 0, 'Quos voluptates ab et ut ipsa sequi. Iste reiciendis vitae illum id aperiam similique cupiditate. Saepe et incidunt est delectus sit rem vel nihil. Nam architecto eligendi vero possimus totam et.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(101, 0, 0, 0, 1, 3, 0, 0, '0', 'Maida', 'Cummings', 'Laki-laki', '0000-00-00', 'xemmerich', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'kristen', 'pmosciski@example.net', 0, 'default.png', 'ab', '', '(264)015-2705', '8484 Reece Tunnel Suite 836\r\nNew Julianaview, GA 57745', 0, 'Odio non et eos qui dolor saepe est eum. Harum id explicabo quis exercitationem hic. Neque architecto cupiditate ullam voluptas. Quas cumque illo illum est harum. Corrupti facilis cumque earum quo', NULL, NULL, '2022-12-07 03:11:44', '2022-12-22 09:52:30', NULL),
(103, 0, 0, 0, 0, 3, 0, 0, '0', 'Miku21', 'Margareth', 'Laki-laki', '2005-04-24', 'miku21', 'a234c0cb420fa51c:35a70955f3d3ddda00a55b0c0f8b2d5f1a4b4bb8:cNxvyEbEZtznYm2yvaIFnw==', 'Attack Helicopter', 'rafaelfarizi1@gmail.com', 0, '20221223093922-20221207041949-20220929-133008.jpg', 'AB', 'Pullstack Wengdev', '6287731137512', 'Indonesia', 1, 'Miku21 wengdev on Lorem Ipsum', NULL, NULL, '2022-12-07 03:13:24', '2022-12-23 08:39:22', NULL),
(111, 0, 8, 0, 0, 2, 0, 0, '0', 'Miku', 'Margareth', 'Laki-laki', '0000-00-00', 'miku21comunity', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', '', 'aaaaa@aaaa.com', 18365536, '20221207105642-794cdf8bd464220d70698e3af1179178.jpg', '', '', '', '', 1, '', NULL, NULL, '2022-12-07 09:32:10', '2022-12-23 08:58:22', NULL),
(112, 8, 0, 0, 0, 1, 48, 0, '2023-2024', 'Leute Ruth', 'Leciepent', 'Perempuan', '2004-07-24', 'ruth02', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'Flying Dutchman', 'laruthm02@gmail.com', 18606, '20221208093903-468944.jpg', 'B', '', '62877311375121', 'Cimahi', 1, 'Ora pro nobis, sancta Dei Genitrix', NULL, NULL, '2022-12-08 08:32:27', '2022-12-22 09:52:30', NULL),
(132, 0, 11, 0, 0, 2, 0, 0, '0', 'Guru besar', '', 'Laki-laki', '0000-00-00', 'guru', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', '', 'karyawan@gmail.com', 18647975, 'default.png', '', '', '', '', 1, '', NULL, NULL, '2022-12-15 06:51:40', '2022-12-22 09:52:30', NULL),
(133, 3, 0, 0, 0, 1, 25, 0, '2023-2024', 'Uji', 'Coba', 'Laki-laki', '2022-12-19', '', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'Hindu', 'lani4@gmail.com', 13846, 'default.png', 'B', '', '213123', 'salatiga', 1, NULL, NULL, NULL, '2022-12-15 08:04:09', '2022-12-22 09:52:30', NULL),
(135, 0, 17, 0, 0, 2, 0, 0, '0', 'Baldi', 'suep', 'Laki-laki', '2018-10-29', '11213109', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'Others', 'baldi_suep@gmail.com', 11213109, '20221215090653-baldi.png', 'AB', '', '083834685279', 'Dukuh Cenang Desa Cenggini RT 03 RW 04', 1, 'I\'m hear every door your open', NULL, NULL, '2022-12-15 08:06:53', '2022-12-22 09:52:30', NULL),
(136, 2, 0, 0, 0, 1, 137, 0, '2023-2024', 'Lil', 'Lil', 'Laki-laki', '2022-12-16', '', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'Others', 'lil_lil@example.com', 240405, '20221216031135-download.jfif', 'AB', '', '083834685279', 'Universe', 1, NULL, NULL, NULL, '2022-12-16 02:11:35', '2022-12-22 09:52:30', NULL),
(137, 0, 0, 0, 0, 4, 0, 0, '0', 'Frisk', 'Leciepent', 'Perempuan', '2003-09-27', '240405', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'Buddish', 'miku217500@gmail.com', 0, '20221216031347-download.jfif', 'AB', 'Pullstack Wengdev', '083834685279', 'Dukuh Cenang Desa Cenggini RT 03 RW 04', 1, 'AAAAAAAAAAAAAAAA', NULL, NULL, '2022-12-16 02:13:47', '2022-12-22 09:52:30', NULL),
(138, 1, 0, 0, 0, 1, 139, 0, '2023-2024', 'Anonim', 'Bro', 'Perempuan', '2022-12-15', '', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'Islam', 'anonim@example.com', 11111, 'default.png', 'A', '', '123213', 'saD', 1, NULL, NULL, NULL, '2022-12-20 08:55:05', '2022-12-22 09:52:30', NULL),
(139, 0, 0, 0, 0, 4, 0, 0, '', 'Anonim ', 'Ortu', 'Laki-laki', '2022-12-20', '11111', 'f958a1795386020d:7417ed7a19f2ab6e970cc798fd331d6793485aec:H4pa2hpa3/jrXFPVd9w4Jg==', 'Christian', 'Ortu@gmail.com', 0, 'default.png', 'B', 'ONS', '123213', 'sdaf', 1, 'asdasd', NULL, NULL, '2022-12-20 09:48:34', '2022-12-22 09:52:30', NULL),
(140, 99, 0, 0, 0, 1, 0, 0, '2023-2024', 'Najib', 'Dani', 'Laki-laki', '0000-00-00', 'Najib', 'fe77383011c9e35d:821a5053a8638ed3ad99a6851b7bd03e854fcab2:q61gLxFykMetQ4eq7ibOMA==', '', 'mikucomunity21@gmail.com', 0, '20221223101415-20221215090653-baldi.png', '', '', '', '', 1, 'A}BLABLABL', NULL, NULL, '2022-12-23 09:12:47', '2022-12-23 09:19:13', NULL),
(141, 1, 0, 0, 0, 1, 32, 0, '2023-2024', 'Iwan', 'Janang', 'Laki-laki', '2010-10-10', '', '99090', 'Islam', 'lani@gmail.com', 99090, '20221223102054-20221207042841-naruto aaaaa.jpg', 'B', '', '0890989098', 'salatiga', 1, NULL, NULL, NULL, '2022-12-23 09:20:54', '2022-12-26 04:32:16', NULL),
(142, 0, 1, 0, 0, 2, 0, 0, '', 'Ahmad', 'Catur', 'Laki-laki', '1998-01-23', '11111', '11111', 'Islam', 'lani4@gmail.com', 11111, '20221223102345-20221206041916-profil.jpeg', 'B', '', '1231314124', 'salatiga', 1, 'Guru IPA', NULL, NULL, '2022-12-23 09:23:45', NULL, NULL),
(143, 0, 0, 0, 0, 4, 0, 0, '', 'Miku', '23', 'Laki-laki', '2022-12-23', '15632', '15632', 'Islam', 'lani@gmail.com', 0, 'default.png', 'A', 'PNS', '1231314124', 'dassad', 1, 'bioo', NULL, NULL, '2022-12-23 09:25:56', NULL, NULL),
(144, 0, 0, 0, 0, 1, 0, 0, '2023-2024', 'Coba', 'Siswa', 'Laki-laki', '2022-12-26', '', '91231', 'Islam', 'adaa@example.com', 91231, 'default.png', 'A', '', '123123123', 'Salatiga', 1, NULL, NULL, NULL, '2022-12-26 03:46:53', NULL, NULL),
(145, 0, 0, 0, 0, 1, 48, 0, '2023-2024', 'Andik', 'Udang', 'Laki-laki', '2022-12-11', '', '91312', 'Islam', 'andi@example.com', 91312, 'default.png', 'A', '', '12312312', 'Salatiga', 1, '', NULL, NULL, '2022-12-26 04:33:34', '2022-12-26 05:00:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_types`
--

CREATE TABLE `tbl_user_types` (
  `id_user_type` int(11) NOT NULL,
  `user_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user_types`
--

INSERT INTO `tbl_user_types` (`id_user_type`, `user_type`) VALUES
(1, 'Student'),
(2, 'Teacher'),
(3, 'Admin'),
(4, 'Parent');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admissions`
--
ALTER TABLE `tbl_admissions`
  ADD PRIMARY KEY (`id_admission`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tbl_attendances`
--
ALTER TABLE `tbl_attendances`
  ADD PRIMARY KEY (`id_attendance`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tbl_books`
--
ALTER TABLE `tbl_books`
  ADD PRIMARY KEY (`id_book`);

--
-- Indexes for table `tbl_classes`
--
ALTER TABLE `tbl_classes`
  ADD PRIMARY KEY (`id_class`),
  ADD KEY `id_section_2` (`id_section`);

--
-- Indexes for table `tbl_class_routines`
--
ALTER TABLE `tbl_class_routines`
  ADD PRIMARY KEY (`id_class_routine`),
  ADD KEY `id_class` (`id_class`),
  ADD KEY `id_subject` (`id_subject`);

--
-- Indexes for table `tbl_exams`
--
ALTER TABLE `tbl_exams`
  ADD PRIMARY KEY (`id_exam`),
  ADD KEY `id_class` (`id_class`);

--
-- Indexes for table `tbl_exam_grades`
--
ALTER TABLE `tbl_exam_grades`
  ADD PRIMARY KEY (`id_exam_grade`);

--
-- Indexes for table `tbl_exam_results`
--
ALTER TABLE `tbl_exam_results`
  ADD PRIMARY KEY (`id_result`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_exam` (`id_exam`);

--
-- Indexes for table `tbl_final_scores`
--
ALTER TABLE `tbl_final_scores`
  ADD PRIMARY KEY (`id_final_score`);

--
-- Indexes for table `tbl_finances`
--
ALTER TABLE `tbl_finances`
  ADD PRIMARY KEY (`id_finance`),
  ADD KEY `id_payment_type` (`id_payment_type`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tbl_hostels`
--
ALTER TABLE `tbl_hostels`
  ADD PRIMARY KEY (`id_hostel`);

--
-- Indexes for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  ADD PRIMARY KEY (`id_message`);

--
-- Indexes for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  ADD PRIMARY KEY (`id_notification`);

--
-- Indexes for table `tbl_payment_types`
--
ALTER TABLE `tbl_payment_types`
  ADD PRIMARY KEY (`id_payment_type`);

--
-- Indexes for table `tbl_peminjaman`
--
ALTER TABLE `tbl_peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`);

--
-- Indexes for table `tbl_sections`
--
ALTER TABLE `tbl_sections`
  ADD PRIMARY KEY (`id_section`);

--
-- Indexes for table `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  ADD PRIMARY KEY (`id_subject`);

--
-- Indexes for table `tbl_tasks`
--
ALTER TABLE `tbl_tasks`
  ADD PRIMARY KEY (`id_task`);

--
-- Indexes for table `tbl_transports`
--
ALTER TABLE `tbl_transports`
  ADD PRIMARY KEY (`id_transport`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_hostel` (`id_hostel`),
  ADD KEY `id_user_type` (`id_user_type`),
  ADD KEY `id_class` (`id_class`),
  ADD KEY `id_trans` (`id_trans`);

--
-- Indexes for table `tbl_user_types`
--
ALTER TABLE `tbl_user_types`
  ADD PRIMARY KEY (`id_user_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admissions`
--
ALTER TABLE `tbl_admissions`
  MODIFY `id_admission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tbl_attendances`
--
ALTER TABLE `tbl_attendances`
  MODIFY `id_attendance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `tbl_books`
--
ALTER TABLE `tbl_books`
  MODIFY `id_book` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `tbl_classes`
--
ALTER TABLE `tbl_classes`
  MODIFY `id_class` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `tbl_class_routines`
--
ALTER TABLE `tbl_class_routines`
  MODIFY `id_class_routine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tbl_exams`
--
ALTER TABLE `tbl_exams`
  MODIFY `id_exam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_exam_grades`
--
ALTER TABLE `tbl_exam_grades`
  MODIFY `id_exam_grade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_exam_results`
--
ALTER TABLE `tbl_exam_results`
  MODIFY `id_result` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_final_scores`
--
ALTER TABLE `tbl_final_scores`
  MODIFY `id_final_score` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tbl_finances`
--
ALTER TABLE `tbl_finances`
  MODIFY `id_finance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `tbl_hostels`
--
ALTER TABLE `tbl_hostels`
  MODIFY `id_hostel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `id_notification` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_payment_types`
--
ALTER TABLE `tbl_payment_types`
  MODIFY `id_payment_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_peminjaman`
--
ALTER TABLE `tbl_peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_sections`
--
ALTER TABLE `tbl_sections`
  MODIFY `id_section` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  MODIFY `id_subject` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_tasks`
--
ALTER TABLE `tbl_tasks`
  MODIFY `id_task` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `tbl_transports`
--
ALTER TABLE `tbl_transports`
  MODIFY `id_transport` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `tbl_user_types`
--
ALTER TABLE `tbl_user_types`
  MODIFY `id_user_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
