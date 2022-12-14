-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Des 2022 pada 10.11
-- Versi server: 10.1.37-MariaDB
-- Versi PHP: 7.0.33

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
-- Struktur dari tabel `tbl_admissions`
--

CREATE TABLE `tbl_admissions` (
  `id_admission` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `admission_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_admissions`
--

INSERT INTO `tbl_admissions` (`id_admission`, `id_user`, `admission_date`) VALUES
(1, 2, '2022-12-01'),
(2, 3, '2022-12-01'),
(3, 4, '2022-12-01'),
(4, 5, '2022-10-06'),
(5, 124, '2022-12-07'),
(6, 7, '2022-12-07'),
(7, 8, '2022-12-07'),
(8, 127, '2022-12-07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_attendances`
--

CREATE TABLE `tbl_attendances` (
  `id_attendance` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `absence` tinyint(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_attendances`
--

INSERT INTO `tbl_attendances` (`id_attendance`, `id_user`, `id_subject`, `tanggal`, `absence`, `created_at`, `update_at`) VALUES
(31, 0, 1, '2022-12-14', 0, '2022-12-14 08:11:33', '2022-12-14 08:11:33'),
(32, 2, 1, '2022-12-14', 0, '2022-12-14 08:17:53', '2022-12-14 08:17:53'),
(33, 112, 1, '2022-12-14', 1, '2022-12-14 08:17:53', '2022-12-14 08:37:03'),
(34, 0, 2, '2022-12-14', 0, '2022-12-14 08:30:59', '2022-12-14 08:30:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_books`
--

CREATE TABLE `tbl_books` (
  `id_book` int(11) NOT NULL,
  `name_book` varchar(50) NOT NULL,
  `id_subject` int(11) NOT NULL,
  `writer_book` varchar(50) NOT NULL,
  `id_class` int(5) NOT NULL,
  `publish_date` date NOT NULL,
  `upload_date` date NOT NULL,
  `code_book` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_books`
--

INSERT INTO `tbl_books` (`id_book`, `name_book`, `id_subject`, `writer_book`, `id_class`, `publish_date`, `upload_date`, `code_book`) VALUES
(2, 'Matahari', 2, 'Tereliye', 1, '2005-02-18', '2022-12-09', '20221209002'),
(3, 'Hujan', 5, 'Tereliye', 2, '2016-05-30', '2022-12-09', '20221209003'),
(6, 'Setelah Gelap Terbitlah Terang', 6, 'RA Kartini', 1, '2022-12-07', '2022-12-04', '20221214001'),
(10, 'Hujan', 8, 'Tereliye', 2, '2022-12-01', '2022-12-14', '20221214002'),
(11, 'Bumi', 12, 'Tere', 2, '2022-12-01', '2022-12-14', '20221214002');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_classes`
--

CREATE TABLE `tbl_classes` (
  `id_class` int(11) NOT NULL,
  `id_section` int(11) NOT NULL,
  `class` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_classes`
--

INSERT INTO `tbl_classes` (`id_class`, `id_section`, `class`) VALUES
(0, 0, 'Belum Ada'),
(1, 1, 'X'),
(2, 1, 'XI'),
(3, 1, 'XII'),
(4, 2, 'X'),
(5, 2, 'XI'),
(6, 2, 'XII');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_class_routines`
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
-- Dumping data untuk tabel `tbl_class_routines`
--

INSERT INTO `tbl_class_routines` (`id_class_routine`, `id_class`, `id_subject`, `id_user`, `school_day`, `start_time`, `end_time`) VALUES
(1, 1, 1, 23, 'Senin', '07:00:00', '08:00:00'),
(2, 1, 2, 23, 'Selasa', '08:00:00', '09:00:00'),
(5, 1, 1, 30, 'Rabu', '15:31:00', '16:31:00'),
(6, 2, 1, 34, 'Kamis', '15:34:00', '16:34:00'),
(7, 2, 8, 39, 'Senin', '15:54:00', '16:54:00'),
(8, 2, 1, 41, 'Rabu', '17:54:00', '18:54:00'),
(12, 3, 1, 74, 'Jumat', '11:23:00', '12:23:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_exams`
--

CREATE TABLE `tbl_exams` (
  `id_exam` int(11) NOT NULL,
  `id_class` int(11) NOT NULL,
  `exam_name` varchar(50) NOT NULL,
  `exam_date` date DEFAULT NULL,
  `exam_start` time DEFAULT NULL,
  `exam_end` time NOT NULL,
  `id_subject` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_exams`
--

INSERT INTO `tbl_exams` (`id_exam`, `id_class`, `exam_name`, `exam_date`, `exam_start`, `exam_end`, `id_subject`) VALUES
(1, 1, 'Ujian Semester 1 X-A', '2022-12-01', '10:00:00', '11:00:00', 1),
(2, 2, 'Ujian Semester XI-A', '2020-10-24', '14:59:00', '15:59:00', 2),
(3, 3, 'Ujian Hidup', '0000-00-00', '00:00:00', '00:00:00', 4),
(4, 2, 'Ujian Hidup', '2022-12-22', '12:00:00', '13:00:00', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_exam_grades`
--

CREATE TABLE `tbl_exam_grades` (
  `id_exam_grade` int(11) NOT NULL,
  `grade_name` varchar(5) NOT NULL,
  `percent_from` int(11) NOT NULL,
  `percent_upto` int(11) NOT NULL,
  `grade_desc` varchar(20) NOT NULL,
  `grade_point` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_exam_grades`
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
-- Struktur dari tabel `tbl_exam_results`
--

CREATE TABLE `tbl_exam_results` (
  `id_result` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_exam` int(11) NOT NULL,
  `id_subject` int(11) NOT NULL,
  `id_class` int(11) NOT NULL,
  `id_section` int(11) DEFAULT NULL,
  `score` int(11) NOT NULL,
  `date_result` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_exam_results`
--

INSERT INTO `tbl_exam_results` (`id_result`, `id_user`, `id_exam`, `id_subject`, `id_class`, `id_section`, `score`, `date_result`) VALUES
(3, 2, 1, 2, 1, 1, 80, '2022-12-01'),
(4, 3, 2, 1, 2, 1, 90, '2022-12-01'),
(5, 9, 1, 2, 1, 1, 67, '2022-12-01'),
(6, 9, 1, 1, 1, 1, 55, '2022-12-02'),
(7, 9, 1, 2, 1, 1, 77, '2022-12-06'),
(8, 9, 1, 1, 1, 1, 100, '2022-12-07'),
(9, 9, 1, 1, 1, 1, 89, '2022-12-08'),
(10, 9, 1, 2, 1, 1, 79, '2022-12-08'),
(11, 9, 1, 1, 1, 1, 86, '2022-12-09'),
(12, 9, 1, 1, 1, 1, 36, '2022-12-09'),
(13, 9, 1, 1, 1, 1, 66, '2022-12-09'),
(14, 9, 1, 2, 1, 1, 15, '2022-12-09'),
(15, 9, 1, 1, 1, 1, 78, '2022-12-07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_finances`
--

CREATE TABLE `tbl_finances` (
  `id_finance` int(11) NOT NULL,
  `id_payment_type` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tipe_finance` enum('Pemasukan','Pengeluaran') NOT NULL,
  `amount_payment` int(11) NOT NULL,
  `status_pembayaran` enum('Dibayar','Belum Bayar') NOT NULL,
  `date_payment` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_finances`
--

INSERT INTO `tbl_finances` (`id_finance`, `id_payment_type`, `id_user`, `tipe_finance`, `amount_payment`, `status_pembayaran`, `date_payment`) VALUES
(1, 1, 12, 'Pemasukan', 2000000, 'Dibayar', '2019-06-07'),
(2, 1, 5, 'Pemasukan', 2000000, 'Dibayar', '2019-11-07'),
(3, 1, 10, 'Pemasukan', 2000000, 'Dibayar', '2019-12-13'),
(4, 1, 6, 'Pemasukan', 2000000, 'Dibayar', '2019-02-19'),
(5, 1, 11, 'Pemasukan', 2000000, 'Dibayar', '2019-08-10'),
(6, 1, 2, 'Pemasukan', 2000000, 'Dibayar', '2019-10-27'),
(7, 1, 9, 'Pemasukan', 2000000, 'Dibayar', '2019-09-19'),
(8, 1, 13, 'Pemasukan', 2000000, 'Dibayar', '2019-12-18'),
(9, 1, 7, 'Pemasukan', 2000000, 'Dibayar', '2019-05-16'),
(10, 1, 3, 'Pemasukan', 2000000, 'Dibayar', '2019-07-12'),
(11, 1, 8, 'Pemasukan', 2000000, 'Dibayar', '2019-01-16'),
(12, 1, 4, 'Pemasukan', 2000000, 'Dibayar', '2019-04-09'),
(13, 3, 56, 'Pengeluaran', 1500000, 'Dibayar', '2019-06-18'),
(14, 3, 59, 'Pengeluaran', 1500000, 'Dibayar', '2019-08-06'),
(15, 3, 41, 'Pengeluaran', 1500000, 'Dibayar', '2019-02-19'),
(16, 3, 57, 'Pengeluaran', 1500000, 'Dibayar', '2019-04-19'),
(17, 3, 34, 'Pengeluaran', 1500000, 'Dibayar', '2019-08-22'),
(18, 3, 63, 'Pengeluaran', 1500000, 'Dibayar', '2019-11-22'),
(19, 3, 35, 'Pengeluaran', 1500000, 'Dibayar', '2019-03-22'),
(20, 3, 47, 'Pengeluaran', 1500000, 'Dibayar', '2019-01-02'),
(21, 3, 23, 'Pengeluaran', 1500000, 'Dibayar', '2019-01-28'),
(22, 3, 30, 'Pengeluaran', 1500000, 'Dibayar', '2019-07-28'),
(23, 2, 4, 'Pemasukan', 5000000, 'Dibayar', '2020-12-18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_hostels`
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
-- Dumping data untuk tabel `tbl_hostels`
--

INSERT INTO `tbl_hostels` (`id_hostel`, `hostel_name`, `room_number`, `room_type`, `number_of_bed`, `cost_per_bed`) VALUES
(0, 'Luxury Boy', '1', 'single', 1, 1500000),
(1, 'Luxury Boy', '1', 'single', 1, 1500000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_messages`
--

CREATE TABLE `tbl_messages` (
  `id_message` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `receiver_email` varchar(50) NOT NULL,
  `sender_email` varchar(50) NOT NULL,
  `title` varchar(25) NOT NULL,
  `message` varchar(255) NOT NULL,
  `time_sended` timestamp NOT NULL DEFAULT current_timestamp(),
  `readed` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_messages`
--

INSERT INTO `tbl_messages` (`id_message`, `id_user`, `receiver_email`, `sender_email`, `title`, `message`, `time_sended`, `readed`) VALUES
(4, 111, 'rafaelfarizi1@gmail.com', 'rafaelfarizi1@gmail.com', 'AAAA', 'AAAA', '2022-12-06 07:18:55', 0),
(5, 2, 'oniworld@oniworld.com', 'rafaelfarizi1@gmail.com', 'AAAAAAAAAAA', 'AAAAA', '2022-12-06 07:18:55', 0),
(6, 111, 'rafaelfarizi1@gmail.com', 'rafaelfarizi1@gmail.com', 'AAAAAAAAAAA', 'AAAAA', '2022-12-06 07:47:57', 1),
(7, 111, 'rafaelfarizi1@gmail.com', 'harber.tyshawn@example.com', 'Miku21 Under Arrest', 'Alerting, your are under arrest for doing child predator', '2022-12-06 07:27:48', 0),
(8, 103, 'rafaelfarizi1@gmail.com', 'rafaelfarizi1@gmail.com', 'AAAA', 'AAAAAA', '2022-12-08 02:21:22', 1),
(9, 112, 'laruthm02@gmail.com', 'rafaelfarizi1@gmail.com', 'jhgjhk', 'mikuas', '2022-12-08 01:47:33', 0),
(10, 103, 'rafaelfarizi1@gmail.com', 'rafaelfarizi1@gmail.com', 'kambin', 'dsfgfdgsdfgdgs', '2022-12-05 03:06:25', 1),
(11, 103, 'rafaelfarizi1@gmail.com', 'rafaelfarizi1@gmail.com', 'iuggjhg', 'AAAAA', '2022-12-09 01:53:53', 0),
(12, 103, 'rafaelfarizi1@gmail.com', 'rafaelfarizi1@gmail.com', 'iuggjhg', 'AAAAAfadasdfasd', '2022-12-09 02:22:01', 1),
(13, 103, 'rafaelfarizi1@gmail.com', 'rafaelfarizi1@gmail.com', 'iuggjhg', 'AAAAAfadasdfasdasdfasdfas', '2022-12-09 01:56:28', 0),
(14, 103, 'rafaelfarizi1@gmail.com', 'rafaelfarizi1@gmail.com', 'AAAA', 'AAAAAA', '2022-12-09 02:20:37', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_notifications`
--

CREATE TABLE `tbl_notifications` (
  `id_notification` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `details` varchar(100) NOT NULL,
  `posted_by` varchar(50) NOT NULL,
  `date_notice` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `terbaca` tinyint(2) NOT NULL,
  `category` enum('Pengumuman_Sekolah','Event','Pembayaran','Exam') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_notifications`
--

INSERT INTO `tbl_notifications` (`id_notification`, `title`, `details`, `posted_by`, `date_notice`, `terbaca`, `category`) VALUES
(3, 'Biaya Semester ', 'Jatuh Tempo Biaya Semester Bulan Desember Siswa A', 'Admin', '2022-10-08 03:00:00', 0, 'Pembayaran'),
(4, 'Biaya Semester B', 'Jatuh Tempo Biaya Semester Bulan Desember Siswa B', 'Admin', '2022-12-07 06:49:25', 0, 'Pembayaran'),
(9, 'Miku21 Under Arrest', 'Miku21 Under Arrest for doing child predator', 'Miku21 Margareth', '2022-12-07 07:18:09', 0, 'Event'),
(10, 'Exam is coming', 'BROOOOOOOO', 'Miku21 Margareth', '2022-12-08 03:30:56', 0, 'Exam'),
(11, 'Upacara besok', 'BROOOOOOOO', 'Miku21 Margareth', '2022-12-08 03:31:45', 0, 'Pengumuman_Sekolah'),
(12, 'Miku21 Free from arrest', 'But still hunting children free, be warning guys', 'Miku21 Margareth', '2022-12-09 04:03:47', 0, 'Event');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_payment_types`
--

CREATE TABLE `tbl_payment_types` (
  `id_payment_type` int(11) NOT NULL,
  `payment_type_name` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_payment_types`
--

INSERT INTO `tbl_payment_types` (`id_payment_type`, `payment_type_name`) VALUES
(1, 'Biaya Semester'),
(2, 'Biaya Ujian'),
(3, 'Gaji Guru'),
(4, 'Transport');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_sections`
--

CREATE TABLE `tbl_sections` (
  `id_section` int(11) NOT NULL,
  `section` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_sections`
--

INSERT INTO `tbl_sections` (`id_section`, `section`) VALUES
(0, ''),
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_subjects`
--

CREATE TABLE `tbl_subjects` (
  `id_subject` int(11) NOT NULL,
  `subject_name` varchar(25) NOT NULL,
  `subject_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_subjects`
--

INSERT INTO `tbl_subjects` (`id_subject`, `subject_name`, `subject_type`) VALUES
(0, 'Belum Ada', 'Tidak Ada'),
(1, 'English', 'Theory'),
(2, 'Accounting', 'Mathematic'),
(5, 'Bangla', 'Theory'),
(6, 'Arts', 'Theory'),
(8, 'Jawa', 'Theory'),
(9, 'Jawa', 'Practice'),
(11, 'IPA', 'Practice'),
(12, 'IPS', 'Theory'),
(15, 'Japan', 'Theory'),
(17, 'German', 'Practice'),
(18, 'Accounting', 'Mathematic'),
(19, 'Aksara Jawa Kuno', 'Theory');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_transports`
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
-- Dumping data untuk tabel `tbl_transports`
--

INSERT INTO `tbl_transports` (`id_transport`, `route_name`, `vehicle_number`, `driver_name`, `license_number`, `phone_number`, `id_driver`) VALUES
(1, 'Jl Patimura - Jl Diponogoro', 'AD 5772 CA', 'Raihan', 'A8908989AAA100', '0866239377774', 'A22-06'),
(4, 'Semarang - Jogja', 'H-1231-KL', 'Zaqi', '33221122445566', '1343325', 'A-1222'),
(5, 'Semarang - Jogja', 'sdvwdv', 'sojdnvwoin', 'sodinvwoi', '1343325', 'qwd'),
(6, 'Semarang - Jogja', 'sdvwdv', 'sojdnvwoin', 'sodinvwoi', '1343325', 'qwd'),
(7, 'Semarang - Jogja', 'sdvwdv', 'sojdnvwoin', 'sodinvwoi', '1343325', 'qwd'),
(8, 'Semarang - Jogja', 'sdvwdv', 'sojdnvwoin', 'sodinvwoi', '12312433431', 'qwerty'),
(9, 'Semarang - Jogja', 'H 1234 ML', 'Zaqi', '112233445566', '0987654321', 'A2206'),
(10, 'Semarang - Jogja', 'H 1234 ML', 'Zaqi', '112233445566', '0987654321', 'A2206'),
(11, 'Semarang - Jogja', 'sdvwdv', 'sojdnvwoin', 'sodinvwoi', '1343325', 'qwd');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id_user` int(11) NOT NULL,
  `id_class` int(11) NOT NULL,
  `id_section` int(11) NOT NULL,
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
  `class` varchar(255) DEFAULT NULL,
  `status` tinyint(2) NOT NULL,
  `short_bio` text DEFAULT NULL,
  `admission_status` varchar(11) DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `delete_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_users`
--

INSERT INTO `tbl_users` (`id_user`, `id_class`, `id_section`, `id_subject`, `id_hostel`, `id_trans`, `id_user_type`, `id_parent`, `id_student`, `session`, `first_name`, `last_name`, `gender`, `date_of_birth`, `username`, `password`, `religion`, `email`, `NISN`, `photo_user`, `blood_group`, `occupation`, `phone_user`, `address_user`, `class`, `status`, `short_bio`, `admission_status`, `admission_date`, `create_at`, `update_at`, `delete_at`) VALUES
(2, 1, 0, 0, 0, 1, 1, 48, 0, '', 'doni', 'billar', 'Laki-laki', '2012-11-15', 'random', 'random', 'other', 'oniworld@oniworld.com', 9987, 'default.png', NULL, '', '+628963333930', 'random', '1', 0, 'random', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(3, 0, 0, 0, 0, 1, 1, 48, 0, '', 'Art', 'Ankunding', 'Perempuan', '0000-00-00', 'gaylord.schoen', '3e9cab5ae2ae061f1654f0d141bb77f0693f615f', 'hindu', 'moore.eveline@example.net', 9864, 'default.png', 'b', '', '793-284-4861', '5934 Jacinto Crossroad Apt. 364\r\nOlsonmouth, KS 30988', '1', 0, 'Necessitatibus error atque delectus ipsa libero. Harum quasi assumenda quos illum. Maiores et ipsam iusto at ea qui quibusdam. Eligendi iure libero aut quia quia vero autem.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-09 06:11:39', NULL),
(4, 1, 0, 0, 0, 1, 1, 48, 0, '', 'Emily', 'Aufderhar', 'Perempuan', '0000-00-00', 'so\'keefe', 'ab3a0ba6b3d3ffc9834f76574dd2c3ec9438a795', 'kristen', 'briana.weimann@example.net', 9861, 'default.png', NULL, '', '1-688-563-2931x133', '1691 Rice Underpass\r\nNorth Valentinamouth, ID 91399', '1', 0, 'Dolore inventore iure repudiandae qui consequatur accusamus. Recusandae dolorem quam est saepe sed unde soluta. Atque id qui deleniti aut repellat. Maxime quaerat ut corrupti et et enim sint.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(5, 1, 0, 0, 0, 1, 1, 48, 0, '', 'Ida', 'Roberts', 'Perempuan', '0000-00-00', 'swilderman', '2e54bd48cabbb48a57c87ecc6575d6871117c177', 'islam', 'clifford61@example.com', 0, 'default.png', NULL, '', '1-357-343-0969x83055', '002 Connelly Canyon Apt. 917\r\nNew Joyburgh, WA 46394', '1', 0, 'Libero earum dolor possimus accusantium vitae fugiat ratione. Cumque cumque tempore et est dolore rerum voluptatem molestiae. Quas sunt omnis asperiores dolor provident culpa inventore.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(6, 1, 0, 0, 0, 1, 1, 0, 0, '', 'Eloisa', 'Langworth', 'Laki-laki', '0000-00-00', 'hyman77', 'a8a88f3f74ee5c0c2efc29a71e94c9b8b7ad6f1a', 'hindu', 'rod.willms@example.org', 0, 'default.png', 'o', '', '8833275468', '1265 Johns Valley Suite 874\r\nSamsonshire, OR 34497', '1', 0, 'Porro ipsa nam harum. Perferendis similique voluptatem incidunt nisi facilis et ratione. Voluptatum tenetur qui sit rerum quam quasi similique. Impedit et corporis repellendus est.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(7, 1, 0, 0, 0, 1, 1, 0, 0, '', 'Gail', 'Kris', 'Perempuan', '0000-00-00', 'lcarroll', '96c515f5a56c27e6a0c448b29192db24935423b9', 'buddha', 'nakia.greenfelder@example.net', 0, 'default.png', NULL, '', '190-759-4362x6965', '63471 Kamren Ridge Apt. 498\r\nPollichstad, DC 10284-9138', '1', 0, 'Sint nam aut quasi autem at. Fuga nesciunt aut dolorem numquam tempore autem. Quia sequi sapiente sunt minima. Et excepturi aut odio tempore.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(8, 1, 0, 0, 0, 1, 1, 0, 0, '', 'Frederik', 'Kunde', 'Perempuan', '0000-00-00', 'colleen24', '69868ac46b02f7ffae2eb1bd1cff488388c5d020', 'konghucu', 'angelica.yundt@example.org', 0, 'default.png', 'a', '', '+14(0)3210550981', '61488 Abbott Greens Suite 690\r\nNorth Rashad, AZ 41490-7600', '1', 0, 'Dolor dolores sed tempore nesciunt id neque. Provident velit officiis error laudantium recusandae ipsam. Amet quod qui animi repudiandae. Nesciunt nulla omnis aut inventore impedit.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(9, 1, 0, 0, 0, 1, 1, 0, 0, '', 'Jean', 'Volkman', 'Perempuan', '0000-00-00', 'adan25', '7cc4177c712afc05f20e4d358d7eb7a6c2286550', 'katholik', 'larry.greenfelder@example.com', 0, 'default.png', 'a', '', '921-106-9611x9156', '584 Erik Freeway Suite 364\r\nLake Hollieshire, HI 68610-6011', '1', 0, 'Quis omnis consequatur non mollitia. Eos quae inventore quia vero voluptates. Quia eos rerum sunt.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(10, 1, 0, 0, 0, 1, 1, 0, 0, '', 'Melisa', 'Shanahan', 'Laki-laki', '0000-00-00', 'jeffrey.mosciski', '28cf1e15aa2e3461e1f9a4bc98e002c882d15da9', 'islam', 'odell04@example.com', 0, 'default.png', 'b', '', '840.286.9973', '0004 Mallie Spur\r\nBoehmmouth, TN 31023-9628', '1', 0, 'Quaerat rerum voluptatem sint veritatis blanditiis. Deserunt debitis quae at sequi unde nam id.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(11, 1, 0, 0, 0, 1, 1, 0, 0, '', 'Dorthy', 'Quigley', 'Perempuan', '0000-00-00', 'irogahn', 'aa7cacb06d1e3770a2b81c3470b9e6137e81b40a', 'konghucu', 'kamron67@example.com', 0, 'default.png', NULL, '', '872-446-3268', '898 Pansy Grove\r\nMarcoview, ID 86792-6245', '1', 0, 'Sed praesentium cumque quisquam nesciunt velit et molestiae. Autem qui error sapiente id maiores enim. Voluptatibus harum quo repellat quo sed sed.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(12, 1, 0, 0, 0, 1, 1, 0, 0, '', 'Trudie', 'Gerlach', 'Laki-laki', '0000-00-00', 'reyes74', '8f71b1d2c199ffda748d368d58e578c7e35d436a', 'islam', 'howell.chaya@example.com', 0, 'default.png', 'a', '', '1-276-435-9103', '6849 Larissa Knoll Suite 868\r\nJannieburgh, HI 51665-4430', '1', 0, 'Qui ea et pariatur ea enim illo. At facere sit ipsam autem reiciendis in. Veniam aut hic non in vel.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(13, 1, 0, 0, 0, 1, 1, 0, 0, '', 'Izabella', 'Schmidt', 'Laki-laki', '0000-00-00', 'crooks.fritz', '4c99e6c2171fe3a1462663720d340af9503ef4f3', 'kristen', 'willie72@example.com', 0, 'default.png', 'b', '', '1-334-146-0072', '5091 Einar Causeway Suite 165\r\nWainoland, NE 06708', '1', 0, 'Cumque in at sapiente minima vel sapiente. Ad corporis voluptatem ut animi. Ut minima impedit reprehenderit dolorum dolor et harum est.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(14, 1, 0, 0, 0, 1, 1, 0, 0, '', 'Guadalupe', 'Orn', 'Perempuan', '0000-00-00', 'xzulauf', '70d0aa8285a282c7b251c3813f2fddb87b150f6c', 'kristen', 'yvette13@example.org', 0, 'default.png', NULL, '', '+20(7)5881288361', '21645 Hane Station\r\nNew Buster, ND 97672', '1', 0, 'Labore sunt quidem corrupti enim nesciunt. Voluptas autem repudiandae distinctio asperiores et perferendis. Repellat ab est eaque excepturi odio maxime provident. Eaque aut ut eos alias.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(15, 1, 0, 0, 0, 1, 1, 0, 0, '', 'Savannah', 'Pfannerstill', 'Laki-laki', '0000-00-00', 'tchristiansen', '35c7b3bbd2688f9c29499795e8b24e092eae6132', 'kristen', 'bernhard45@example.com', 0, 'default.png', 'b', '', '991278584', '182 Rose Trail Suite 818\r\nMarinahaven, CO 75392-6357', '1', 0, 'Non cupiditate fuga veniam. Voluptates ut quis autem in fugiat nemo enim. Distinctio voluptatem vero enim animi possimus et.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(16, 1, 0, 0, 0, 1, 1, 0, 0, '', 'Oscar', 'Stehr', 'Laki-laki', '0000-00-00', 'powlowski.korey', '5c83f10d3da20e5bf8c8d14c2f9c499a3da58dca', 'katholik', 'carmen96@example.net', 0, 'default.png', 'ab', '', '(249)159-6429', '0916 Alyson Junction\r\nWest Harley, UT 43822', '1', 0, 'Asperiores assumenda laboriosam tempore corporis quia nihil. Doloribus voluptatem et sit omnis. A dolor at error pariatur. Sequi est et dolor repellat quia.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(17, 1, 0, 0, 0, 1, 1, 0, 0, '', 'Izabella', 'Parisian', 'Perempuan', '0000-00-00', 'eleanora89', '2e4a08821aada9291e9484516c9531ad9b11b648', 'konghucu', 'gerda12@example.com', 0, 'default.png', 'o', '', '354558932', '737 Hudson Canyon Apt. 058\r\nBaumbachland, UT 53383', '1', 0, 'Quo earum magni consequuntur voluptatem. In qui maxime aperiam et ut. Rem deserunt odio aut excepturi consectetur aut.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(18, 1, 0, 0, 0, 1, 1, 0, 0, '', 'Alexandrea', 'Mosciski', 'Perempuan', '0000-00-00', 'wmills', '96cbae4ba80125bc739e61f1994e19eea406f0ea', 'konghucu', 'ekulas@example.com', 0, 'default.png', NULL, '', '6741080428', '708 Richmond Mews\r\nWest Alessandroton, NH 32783', '1', 0, 'Eveniet inventore qui rerum omnis. Quibusdam facere possimus atque sit laboriosam enim. A suscipit numquam fuga tenetur dolor. Voluptas odio aliquid consequuntur quam.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(19, 1, 0, 0, 0, 1, 1, 0, 0, '', 'Damion', 'Davis', 'Perempuan', '0000-00-00', 'ariane.schulist', 'a363db3b0533f6e473c9f44095a427655fe6edbf', 'konghucu', 'mboehm@example.com', 0, 'default.png', 'ab', '', '1-252-674-9635x226', '75115 Rau Junctions\r\nSengerhaven, NV 27007-3248', '1', 0, 'Consequatur esse vel facilis maxime nisi. Eos tenetur sapiente ea quo. Nemo ipsam reprehenderit quaerat consequatur.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(20, 1, 0, 0, 0, 1, 1, 0, 0, '', 'Burdette', 'Murphy', 'Perempuan', '0000-00-00', 'yazmin.ruecker', '5f5b6074b09ce7954e33be1ffa5cf67b9e7364d8', 'buddha', 'nlemke@example.com', 0, 'default.png', 'o', '', '7654229082', '5859 Collins Causeway Suite 842\r\nSouth Evanshaven, ND 35538', '1', 0, 'Sit explicabo omnis excepturi modi asperiores voluptatem. Aliquid non rerum cumque est. Cumque eum quo reiciendis minima quibusdam explicabo. Omnis nisi natus fugit omnis.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(21, 1, 0, 0, 0, 1, 1, 0, 0, '', 'Gustave', 'Toy', 'Perempuan', '0000-00-00', 'bbechtelar', '0b02e2bcb97d0ad8b963cda4af77fd5ad9edaca3', 'katholik', 'shakira27@example.net', 0, 'default.png', 'a', '', '1-078-171-2509x85539', '701 Gardner Forks\r\nLake Hankfort, MO 55880-4799', '1', 0, 'Beatae aliquam quo enim omnis natus ipsum. Fuga ipsa porro deleniti. Alias et cum ex tempore possimus. Rerum iusto aut fugit totam.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(22, 2, 0, 0, 0, 1, 1, 0, 0, '', 'Leonard', 'Gerhold', 'Perempuan', '0000-00-00', 'myah37', '4473432a89fb25a49404e2cf9ded30ab4f6bc4db', 'konghucu', 'rubye97@example.org', 0, 'default.png', 'b', '', '+47(6)2868941917', '6881 Wunsch Island Suite 700\r\nWest Lurline, OH 96248', '1', 0, 'Quia laudantium aut architecto voluptas consectetur iure aut odit. Esse aspernatur dolorum qui error ratione dolores voluptate.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(23, 2, 0, 0, 0, 1, 2, 0, 0, '', 'Dennis', 'Maggio', 'Laki-laki', '0000-00-00', 'teacher', 'teacher', 'konghucu', 'sophie44@example.org', 0, 'default.png', 'ab', '', '(772)694-3622x00197', '894 Eliza Ridge\r\nWest Eldred, NC 94050-2424', '1', 1, 'At cupiditate animi quaerat qui. Eius in beatae aperiam eos. Nulla dolorum ipsam quia aut repudiandae. Culpa at rerum odit ab veritatis.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-14 07:27:58', NULL),
(24, 3, 0, 0, 0, 1, 1, 0, 0, '', 'Concepcion', 'Bins', 'Laki-laki', '0000-00-00', 'kmclaughlin', '5ce4f6afa04eb7cb1cd814aececa7dca222150ff', 'hindu', 'gorczany.josh@example.com', 0, 'default.png', 'o', '', '1-022-903-7435x40047', '54004 Kirlin Greens\r\nNew Anastasiatown, WY 99939', '1', 0, 'Ut omnis hic vel deserunt ducimus culpa et ratione. Consequuntur iste ducimus nesciunt voluptatem. Tenetur animi quidem velit id eligendi. Cum qui aut voluptatem quia quas earum.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(25, 2, 0, 0, 1, 1, 4, 0, 0, '', 'Dawson', 'Gerlach', 'Perempuan', '0000-00-00', 'leuschke.constan', '8f30827d3f1d3e57eeec6303f712ba8ce5a33fc1', 'budda', 'ischiller@example.com', 0, 'default.png', 'b', '', '443-604-3760x7204', '424 Prosacco Roads Apt. 594\r\nWest Vena, IA 04021-9280', '1', 0, 'Quis nihil a inventore quis quia. Quo cum harum expedita quo. Non eligendi blanditiis in voluptatem voluptate et sed.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(26, 1, 0, 0, 1, 1, 1, 0, 0, '', 'Krystel', 'Robel', 'Perempuan', '0000-00-00', 'floy19', 'f2122e13c932b514efed8f2b0e4f383765ee56c0', 'budda', 'lavon.kiehn@example.com', 0, 'default.png', 'o', '', '(734)811-3853x015', '775 Marcella Turnpike\r\nMaeview, CA 39576-7115', '1', 0, 'Sint in nisi mollitia sint aut et mollitia. Et id consectetur eum voluptatum numquam consequatur. Quas iste excepturi a ea. Nemo amet qui voluptatem recusandae et.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(27, 2, 0, 0, 0, 1, 1, 0, 0, '', 'Dee', 'Abbott', 'Laki-laki', '0000-00-00', 'christine.moore', '0f65af079fe9a13ed8b827235be62d73adc58486', 'kristen', 'ullrich.scarlett@example.com', 0, 'default.png', 'b', '', '1-338-236-4642', '61777 Norene Parkway Suite 119\r\nLazarohaven, VT 40702', '1', 0, 'Quo vel et atque doloribus. Facere et magnam recusandae debitis.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(28, 2, 0, 0, 0, 1, 3, 0, 0, '', 'Vesta', 'Ebert', 'Laki-laki', '0000-00-00', 'admin', 'admin', 'katholik', 'harber.tyshawn@example.com', 0, 'default.png', 'ab', '', '1-809-594-5107', '519 Kacey Creek Suite 626\r\nHyattburgh, WY 71503', '1', 1, 'Numquam et ullam est et. Quam rerum mollitia nihil distinctio.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-12 02:11:38', NULL),
(29, 1, 0, 0, 1, 1, 4, 0, 0, '', 'Ola', 'Wyman', 'Laki-laki', '0000-00-00', 'kennith.rath', '89c9827671d15d5d41c3f05e1c76343ed9a0fd8d', 'islam', 'julia13@example.org', 0, 'default.png', 'ab', '', '918.562.6265x9591', '308 Morar Cliffs Apt. 992\r\nTamaratown, KY 32634', '1', 0, 'Aspernatur est sunt doloribus quasi. Nobis beatae sed rerum voluptas impedit aliquam debitis consectetur. Voluptate eveniet autem dolor enim. Est id tempore ipsum. Voluptas aut amet minus similique', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(30, 2, 0, 0, 0, 1, 2, 0, 0, '', 'Bobbie', 'O\'Kon', 'Laki-laki', '0000-00-00', 'koss.melyna', 'ea236da1580ef013d8d483b9832b6ea3f3b57853', 'konghucu', 'wisozk.jasen@example.com', 0, 'default.png', 'a', '', '1-791-343-0739x7746', '41544 Windler Coves\r\nEast Henderson, MN 64250', '1', 0, 'Cupiditate quod qui consectetur nihil aperiam voluptatem molestiae. Facilis aut quos debitis earum velit. Repellat accusantium soluta reprehenderit ut.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(31, 3, 0, 0, 1, 1, 4, 0, 0, '', 'Beulah', 'Jast', 'Laki-laki', '0000-00-00', 'ruby.gulgowski', '97493d6cdd00a2e10d2819ea90f088c17c80df2b', 'hindu', 'mpowlowski@example.org', 0, 'default.png', 'b', '', '983.603.0136x3525', '28148 Angie Trail\r\nSouth Gabriel, WY 69863', '1', 0, 'Blanditiis debitis repellendus adipisci soluta occaecati illum. Hic porro quia dolorum maxime eos tempora.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(32, 1, 0, 0, 1, 1, 4, 0, 0, '', 'Roberta', 'Zboncak', 'Laki-laki', '0000-00-00', 'dawn50', 'fb7b2bbc440068aa07a945f0bd64860783d33e04', 'kristen', 'mallory38@example.org', 0, 'default.png', 'b', '', '945.376.7830', '9545 O\'Connell Branch\r\nAlexandreaport, TX 50847', '1', 0, 'Ut placeat voluptatem totam velit. Incidunt vel qui eos.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(33, 1, 0, 0, 1, 1, 3, 0, 0, '', 'River', 'Price', 'Laki-laki', '0000-00-00', 'vonrueden.gregor', '68d7309a0b21637c1446fb79e9a979b6f58bcbd8', 'hindu', 'o\'conner.hilario@example.net', 0, '20221207042906-default.png', 'b', '', '(295)695-0717x38707', '18056 Filiberto JunctionsWest Gunnarberg, SC 45720-9408', '1', 0, 'Est corrupti mollitia et quisquam non. Reiciendis nisi consequatur nisi vel ducimus necessitatibus impedit. Eos labore soluta a.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:29:06', NULL),
(34, 3, 0, 0, 1, 1, 2, 0, 0, '', 'Morris', 'Bins', 'Perempuan', '0000-00-00', 'kparker', '0fe79b49e31b1b675b237d1344ec9e7fa171835b', 'hindu', 'weber.hollis@example.com', 0, 'default.png', 'ab', '', '064-708-6688', '2697 Haag Meadow\r\nWindlertown, WV 35174', '1', 0, 'Et consequatur exercitationem aut et non dolorem. Et id deleniti sit maxime reprehenderit asperiores hic. Odio odio magnam enim eum libero. Consequatur eos reprehenderit delectus perferendis quidem', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(35, 3, 0, 0, 1, 1, 2, 0, 0, '', 'Rosina', 'Mertz', 'Laki-laki', '0000-00-00', 'lonzo.conroy', 'b2afe30a2b0b4c09797b59298675770c4da3e46e', 'konghucu', 'jimmy21@example.net', 0, 'default.png', 'ab', '', '+35(9)1535087533', '45732 Hoppe Club Apt. 522\r\nNorth Julio, IA 63468', '1', 0, 'In commodi molestias eos iure distinctio nesciunt ratione. Voluptatem quaerat in autem et consequatur alias quam blanditiis. Atque voluptatum doloribus minima adipisci voluptatem in eos rerum.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(36, 1, 0, 0, 0, 1, 4, 0, 0, '', 'Filomena', 'Russel', 'Perempuan', '0000-00-00', 'qhowell', '4b9166d15fbd97696ce4b6be4d08bc4a44774a9b', 'budda', 'ypurdy@example.net', 0, 'default.png', 'b', '', '384-461-1789x49450', '727 Bo Motorway\r\nKathlynview, ME 94561', '1', 0, 'Et at dicta quo. Velit nemo sint rerum et in et deleniti ex. Possimus nisi nihil animi corporis voluptatum delectus inventore.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(37, 1, 0, 0, 1, 1, 3, 0, 0, '', 'Clarabelle', 'Doyle', 'Laki-laki', '0000-00-00', 'johnathan61', '0f8e4c73b8bed115ed9e0db8554068fd34f5c4ee', 'budda', 'keven05@example.org', 0, 'default.png', 'ab', '', '339.842.4786x72097', '78548 Metz Ridges\r\nSouth Jeff, CA 95702-8039', '1', 0, 'Expedita rerum qui qui voluptatem deleniti. Quia quidem et optio illum. Quia quidem mollitia quo.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(38, 2, 0, 0, 1, 1, 4, 0, 0, '', 'Cathryn', 'Moen', 'Laki-laki', '0000-00-00', 'davon.smith', '0c8fee95bc07f2cfef467aadfcf7c9985cde0bc8', 'hindu', 'pouros.mireya@example.com', 0, 'default.png', 'ab', '', '270.722.2115x872', '1776 Aurelie Junctions Apt. 155\r\nGardnerville, ME 83614', '1', 0, 'Ut ut laboriosam necessitatibus delectus voluptas. Deleniti illum est sed. Quidem nesciunt repudiandae maxime rerum veritatis aliquid est. Cupiditate quis inventore libero adipisci et et voluptatem', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(39, 1, 0, 0, 1, 1, 2, 0, 0, '', 'Gianni', 'Hamill', 'Perempuan', '0000-00-00', 'abshire.dagmar', 'aceef3f81b2e1996e87d6e5893f518637950b4c0', 'hindu', 'cortez.pfeffer@example.org', 0, 'default.png', 'o', '', '(602)969-1586x47582', '28684 Yundt Motorway Apt. 244\r\nJamaalberg, NH 22751-3241', '1', 0, 'Eos possimus neque necessitatibus animi quae sit qui. Pariatur iste deleniti harum expedita iusto. Est molestiae minima veritatis quos ut.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(40, 1, 0, 0, 1, 1, 4, 0, 0, '', 'Mac', 'Dooley', 'Laki-laki', '0000-00-00', 'mbotsford', 'e3b6bba43132c563d2ba7c45d969a220d5d765f6', 'islam', 'herminia.towne@example.net', 0, 'default.png', 'b', '', '7735747152', '2193 Lakin Glens\r\nNorth Brandyn, WV 03653', '1', 0, 'Aliquid aliquam necessitatibus at esse sed. Quibusdam inventore aspernatur vel dolorem dolore in sed. Dolorum ut nihil dolorem aperiam.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(41, 2, 0, 0, 1, 1, 2, 0, 0, '', 'Mellie', 'Purdy', 'Perempuan', '0000-00-00', 'tbuckridge', '32dfeb5ca247d949eed023b51dd62cf862bff9cf', 'konghucu', 'gbartoletti@example.net', 0, 'default.png', 'a', '', '(211)988-9461x932', '7061 Julien Mall Apt. 633\r\nNew Rosaleestad, WA 81371', '1', 0, 'Est et inventore qui dolorem numquam error nesciunt corrupti. Et nobis eos quia non facilis. Voluptates sunt incidunt labore magnam reiciendis molestiae.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(42, 3, 0, 0, 0, 1, 3, 0, 0, '', 'Myron', 'Schaefer', 'Laki-laki', '0000-00-00', 'gorczany.kenna', '61f0e5e421265188b9e4bb5f11dc0fc47118640d', 'budda', 'hlang@example.com', 0, 'default.png', 'ab', '', '(914)575-2607', '014 Durgan Springs Apt. 483\r\nChamplinhaven, WV 88447-3640', '1', 0, 'Voluptatem accusantium dolore eaque delectus molestiae eos quis. Laudantium eos possimus et quos qui dolores omnis quis. Libero provident officia atque consequatur pariatur aperiam officiis.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(43, 3, 0, 0, 1, 1, 4, 0, 0, '', 'Violet', 'Waelchi', 'Laki-laki', '0000-00-00', 'ykoch', '87884ec8ef5064d124f372f2470b60ab86ea0d12', 'islam', 'gaetano48@example.net', 0, 'default.png', 'a', '', '987.642.4961x6324', '196 Christiansen Ports Apt. 544\r\nLake Zechariah, VT 52664', '1', 0, 'Nesciunt ipsam qui qui id sit delectus ab omnis. Atque totam quis quibusdam. Adipisci qui aut est maxime.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(44, 2, 0, 0, 1, 1, 1, 0, 0, '', 'Alice', 'Hand', 'Perempuan', '0000-00-00', 'larson.creola', '61fd24dbb1823d94145a3023097af56244dead6b', 'kristen', 'walsh.pearlie@example.org', 0, 'default.png', 'ab', '', '(107)804-7166', '39590 Zelma Views\r\nWest Anneberg, IL 86307-9429', '1', 0, 'At et suscipit at aliquid qui quia. Qui mollitia ut occaecati voluptatem optio aut architecto. Molestiae et omnis quos reprehenderit sunt eos. In hic omnis repudiandae. Sequi rerum minus et sit iur', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(45, 3, 0, 0, 1, 1, 3, 0, 0, '', 'Queenie', 'Dare', 'Perempuan', '0000-00-00', 'ubraun', '06740159b88ca02af7e98707eec096ce022fd2bd', 'konghucu', 'qhowell@example.com', 0, 'default.png', 'a', '', '(277)668-0913', '150 Destinee Park\r\nAbagailtown, TX 82605-7785', '1', 0, 'Temporibus suscipit aspernatur et praesentium corrupti sint id et. Nihil error et et cum. Voluptates eveniet tenetur impedit sapiente. Nisi cumque sed voluptatem consequatur. Possimus quam repellen', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(46, 1, 0, 0, 0, 1, 3, 0, 0, '', 'Brenden', 'Swaniawski', 'Laki-laki', '0000-00-00', 'kailyn.shanahan', '21915eadf695b3f7142e456c78ffe0e4760748b7', 'katholik', 'corkery.llewellyn@example.org', 0, 'default.png', 'o', '', '738.358.7331x0550', '707 Miguel Mountain\r\nSouth Clotildebury, MT 28756', '1', 0, 'Tempora ullam doloremque blanditiis nulla. Esse asperiores voluptatem et enim cum at. Delectus nisi voluptatibus sit qui aut. Voluptatem nihil facere est magnam sed.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(47, 2, 0, 0, 1, 1, 2, 0, 0, '', 'Maximus', 'Kreiger', 'Perempuan', '0000-00-00', 'okuneva.braden', '2ca66a8abe85cd7f263ac31112cb8e080a225939', 'katholik', 'kuhlman.hollis@example.com', 0, 'default.png', 'a', '', '1-161-987-6381x320', '2016 Schultz Ways Suite 118\r\nO\'Haratown, NC 42649', '1', 0, 'Pariatur nobis et quisquam ullam possimus earum ratione. Nemo deleniti ullam qui voluptate. Aut et ut sit non.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(48, 3, 0, 0, 1, 1, 4, 0, 0, '', 'Gerald', 'Feil', 'Laki-laki', '0000-00-00', 'imante', '11111', 'hindu', 'dkoss@example.net', 0, 'default.png', 'b', '', '567-662-5114x7908', '709 Porter Route\r\nElsieberg, KS 69757', '1', 0, 'Cumque id aliquid ab esse odio officiis quis. Pariatur aperiam dolores vitae voluptatem ipsam enim. Sint maxime nesciunt beatae ipsum.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(49, 1, 0, 0, 0, 1, 3, 0, 0, '', 'Shaniya', 'Schmeler', 'Laki-laki', '0000-00-00', 'maximo26', 'bbe536688037fcc4002a41538c1e90c158090ab1', 'konghucu', 'shana.lynch@example.com', 0, 'default.png', 'ab', '', '1-609-841-4199', '161 Stevie Corners\r\nLake Bridgetport, IA 38827-2489', '1', 0, 'Nostrum error eum libero eos repellat reprehenderit. Eveniet sit soluta harum pariatur expedita minus iusto. Atque harum impedit quo consequatur veritatis impedit.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(50, 3, 0, 0, 0, 1, 4, 0, 0, '', 'Maxwell', 'Swift', 'Perempuan', '0000-00-00', 'vbailey', '5573e33ccbe25e49fd7df58fffd484192ec9bc60', 'kristen', 'cecelia42@example.net', 0, 'default.png', 'a', '', '381.499.8037x4064', '590 Brekke Curve Suite 529\r\nChaddstad, MT 21354', '1', 0, 'Modi inventore itaque nemo blanditiis quas quibusdam molestiae. Deserunt perferendis aliquid doloremque rerum. Nobis quam voluptatem occaecati nisi natus veniam. Nobis reiciendis in libero. Quae re', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(51, 3, 0, 0, 1, 1, 3, 0, 0, '', 'Don', 'Dibbert', 'Perempuan', '0000-00-00', 'mills.verda', '25f4da2de420249e20aa84dcb3b35b65b96b1db6', 'hindu', 'jarred07@example.org', 0, 'default.png', 'ab', '', '(577)154-0711', '339 Shyanne Flat Suite 962\r\nJalynhaven, AR 86445-0491', '1', 0, 'Ex ipsam earum praesentium itaque voluptatum. Sunt perspiciatis magnam a sit nobis non voluptatem assumenda. Tempora sunt labore sit ea.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(52, 2, 0, 0, 1, 1, 4, 0, 0, '', 'Osborne', 'Denesik', 'Perempuan', '0000-00-00', 'florian.lubowitz', '70e94d373c8f2b38afacec458732a1e9f7c9c746', 'hindu', 'otowne@example.com', 0, 'default.png', 'o', '', '(441)161-7605x73161', '18149 McClure Centers Apt. 622\r\nSouth Codychester, MO 12219', '1', 0, 'Quas praesentium tempore animi rerum non perferendis qui velit. Est voluptatum at doloribus nihil. Tempore qui impedit nam sapiente porro.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(53, 1, 0, 0, 1, 1, 3, 0, 0, '', 'Antwon', 'Turner', 'Perempuan', '0000-00-00', 'raphaelle.kuhic', '09e30007e42a6c2ff00fdaf1cb78f52d79596ed8', 'konghucu', 'johnathan16@example.net', 0, 'default.png', 'b', '', '639437654', '50966 Oberbrunner Plains Suite 675\r\nKshlerinside, KY 67435-5414', '1', 0, 'Est nostrum deserunt a fugit. Aspernatur corporis quidem exercitationem eligendi. Ex culpa eligendi nihil quaerat voluptatem consequatur.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(54, 3, 0, 0, 0, 1, 4, 0, 0, '', 'Pattie', 'Dietrich', 'Perempuan', '0000-00-00', 'rauer', '0578e6d96afec7098e0a2708f6ca395e472f66c5', 'islam', 'morar.leonie@example.org', 0, 'default.png', 'a', '', '185-166-6647', '5321 Jensen Walks\r\nLake Keshaunland, IL 64922', '1', 0, 'Perferendis dolore voluptatibus error earum sed ut alias. Sunt nisi sed sed harum dolorem qui. Expedita est hic et ut nihil nihil adipisci.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(55, 1, 0, 0, 0, 1, 1, 0, 0, '', 'Margarete', 'Abshire', 'Laki-laki', '0000-00-00', 'koelpin.shany', '09025d5bee3e95f46b0804baab7e371cc9fd436a', 'islam', 'epowlowski@example.org', 0, 'default.png', 'b', '', '(889)557-7513x70590', '42509 Kaycee Glens\r\nWest Madaline, TN 22033', '1', 0, 'Quos dolorem aut nihil et quasi deleniti excepturi voluptatem. Dolores deserunt quas aperiam odio temporibus. Voluptatem doloribus itaque dolor deleniti voluptate accusantium non provident. Unde ex', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(56, 3, 0, 0, 0, 1, 2, 0, 0, '', 'Golda', 'Fritsch', 'Perempuan', '0000-00-00', 'thiel.kallie', 'df135fa95f4772994785b26b10ecdd62a4ec35ff', 'hindu', 'zoila.kuhic@example.com', 0, 'default.png', 'ab', '', '3694579473', '11592 Elton Inlet\r\nLake Robb, KY 67888', '1', 0, 'Quis inventore non id quae nesciunt blanditiis corrupti. Quibusdam omnis soluta tenetur. Pariatur est a sed quos non sunt impedit.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(57, 2, 0, 0, 1, 1, 2, 0, 0, '', 'Yesenia', 'Ratke', 'Laki-laki', '0000-00-00', 'dahlia.kuphal', '34a5785e5a913ba73758753800098ea7d0984c7b', 'budda', 'schulist.leslie@example.net', 0, 'default.png', 'o', '', '5381836391', '1701 Ashlee Unions\r\nCamilamouth, ND 94638', '1', 0, 'Sunt maiores ex cumque qui eaque. Repellat ut ut et voluptas a. Voluptas veniam ipsa ipsum non.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(58, 1, 0, 0, 0, 1, 4, 0, 0, '', 'Joseph', 'Mosciski', 'Perempuan', '0000-00-00', 'hackett.nestor', '47c41c88ac2fa6c85582ac3a9d99cfebb82b0f22', 'kristen', 'jacobs.giovani@example.com', 0, 'default.png', 'a', '', '(359)377-0828', '35521 Hoppe Stream\r\nNew Sammieborough, KY 15342-5117', '1', 0, 'Perspiciatis totam quia quo recusandae voluptatum ad. Minima reprehenderit corrupti dolore voluptas illo numquam. Aut possimus sit voluptatibus voluptatibus.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(59, 2, 0, 0, 1, 1, 2, 0, 0, '', 'Aurore', 'Watsica', 'Perempuan', '0000-00-00', 'xpagac', '6a4d9f439f23c0ee5fe517ad8dc2abf68d49800c', 'kristen', 'braulio08@example.com', 0, 'default.png', 'ab', '', '199-288-6890', '7812 Nadia Plains Apt. 279\r\nBlickville, MN 53433', '1', 0, 'Illum rerum illo neque voluptatum iure deserunt sequi. Voluptates sequi voluptas officiis inventore distinctio voluptas. Qui rerum voluptatibus similique sed laborum in vel. Laudantium impedit dolo', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(60, 3, 0, 0, 0, 1, 4, 0, 0, '', 'Carroll', 'Metz', 'Perempuan', '0000-00-00', 'aimee.lehner', '3716044cf6a2cf441d1b96b5fb6643a943926628', 'katholik', 'wisoky.sonya@example.org', 0, 'default.png', 'a', '', '(508)181-7365x0413', '541 Bahringer Cliff Apt. 444\r\nLauramouth, DC 87038-7542', '1', 0, 'Esse mollitia adipisci ut ullam dolores dolorem nemo numquam. Vel atque modi quod. Animi qui laboriosam molestiae asperiores et aut voluptas.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(61, 2, 0, 0, 1, 1, 1, 0, 0, '', 'Letha', 'Kuhn', 'Perempuan', '0000-00-00', 'wkassulke', '4db1e8d8a6aa3a925e8ab7421fa82c58b83d287e', 'kristen', 'lauriane14@example.net', 0, 'default.png', 'a', '', '1-460-588-3379', '80930 Lulu Unions Suite 023\r\nKlingmouth, GA 51413-0744', '1', 0, 'Magni animi excepturi explicabo reprehenderit eum velit accusantium. Provident rerum doloremque accusantium velit ut minus totam. Molestias nemo id quidem impedit nihil ullam debitis qui. Quia qui', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(62, 3, 0, 0, 0, 1, 4, 0, 0, '', 'Easton', 'Ebert', 'Laki-laki', '0000-00-00', 'leilani33', '93d2b2a89022602de886b685fff54356af32e9ba', 'islam', 'gay.frami@example.org', 0, 'default.png', 'b', '', '(461)402-5241', '366 Thiel Trace\r\nHackettmouth, NY 90937-7372', '1', 0, 'Neque praesentium inventore atque autem ut ut. Atque ex qui error omnis odio aperiam. Voluptatum rerum aut vero quod est.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(63, 3, 0, 0, 0, 1, 2, 0, 0, '', 'Beau', 'Moen', 'Perempuan', '0000-00-00', 'buckridge.declan', 'cd05bc5adb541cc78e3d7924d48fcdedba21d901', 'hindu', 'pollich.rey@example.net', 0, 'default.png', 'b', '', '1-524-411-3437x376', '798 Mills Port Suite 922\r\nSchmittbury, MA 30341-3273', '1', 0, 'Illo inventore libero ut ut qui non illo ab. Maxime iste quidem rerum optio et hic. Optio eos quibusdam et facere veritatis.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(64, 3, 0, 0, 1, 1, 4, 0, 0, '', 'Jordy', 'Sporer', 'Laki-laki', '0000-00-00', 'emmett.reynolds', '5e15b4d8cd2c4de1eefad75e7e3389a66ee73a8e', 'katholik', 'abner.emard@example.net', 0, 'default.png', 'ab', '', '1-183-035-1507x03759', '970 Gulgowski Field Apt. 724\r\nNorth Masonmouth, MA 41865-8673', '1', 0, 'Expedita qui eum quia earum. Provident architecto quo modi enim veritatis reprehenderit at. Expedita dolor consequatur aperiam veritatis consequuntur repudiandae nihil.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(65, 2, 0, 0, 0, 1, 3, 0, 0, '', 'Lela', 'Wintheiser', 'Perempuan', '0000-00-00', 'susan.baumbach', 'e41170445999fa21eec0805c72f919870aaad07d', 'konghucu', 'harris.keaton@example.net', 0, 'default.png', 'a', '', '(337)020-3611', '4461 Yundt Mountains Suite 793\r\nLake Alta, DC 12610', '1', 0, 'Autem qui dolorem quia. Et eum accusantium omnis dignissimos quibusdam amet iste. Nobis quia in quia ducimus pariatur atque sunt. Quos et est saepe dolorem rerum.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(66, 2, 0, 0, 1, 1, 3, 0, 0, '', 'Orrin', 'O\'Kon', 'Perempuan', '0000-00-00', 'bailey.braulio', '90093a89bfb20cedf22f83c991e430f7bc218290', 'katholik', 'blake83@example.org', 0, 'default.png', 'a', '', '058-663-3142x6095', '237 Rippin Inlet\r\nNorth Vance, OH 93334-7482', '1', 0, 'Cupiditate autem ad sint debitis repudiandae. Minus dolorem mollitia nobis necessitatibus repellat consequatur temporibus. Velit ea in et quia id eius magni. Architecto iste rerum dolor eos qui.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(67, 3, 0, 0, 1, 1, 2, 0, 0, '', 'Edd', 'Daugherty', 'Perempuan', '0000-00-00', 'po\'conner', 'bfd567fe34019296bd985500be01ce7a76b2e20e', 'islam', 'sledner@example.net', 0, 'default.png', 'o', '', '311-179-2331x6974', '347 Bessie Inlet Apt. 559\r\nAricchester, PA 30274-0796', '1', 0, 'Reprehenderit ex ut sed non earum quo. Nihil fugit dolores magnam in et. Nihil consectetur ab unde fuga veritatis modi minus. Facere totam quia aut qui omnis natus quos.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(68, 1, 0, 0, 0, 1, 3, 0, 0, '', 'Telly', 'Kuhic', 'Laki-laki', '0000-00-00', 'langosh.lia', 'f3f0c8d0fb3a1c3dce2cdd9a92100c83989ec701', 'kristen', 'smann@example.org', 0, 'default.png', 'a', '', '1-883-940-0806x90837', '25049 Dandre Village\r\nMireilleton, NM 12627-4856', '1', 0, 'Autem tenetur et dolor doloribus pariatur at dicta. Nisi aut voluptatem nesciunt necessitatibus iure ut. Qui est autem deserunt ut ad modi esse dignissimos.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(69, 1, 0, 0, 0, 1, 2, 0, 0, '', 'Kelly', 'Paucek', 'Laki-laki', '0000-00-00', 'bessie.botsford', 'db0a870d55c105171be41db7c7f2f49943e1f3ff', 'hindu', 'tremaine75@example.net', 0, 'default.png', 'b', '', '197.525.9331x346', '32560 Dallas Plaza\r\nLake Sylvia, NY 04448', '1', 0, 'Voluptatibus eligendi ea est temporibus et hic vel. Ipsum minus quia dolorum ullam qui.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(70, 1, 0, 0, 0, 1, 4, 0, 0, '', 'Keanu', 'Kautzer', 'Perempuan', '0000-00-00', 'heathcote.shanie', '8176d3d4e4ac2cd617c4d8fe9a8cdc2f870d37a7', 'budda', 'hirthe.melyna@example.org', 0, 'default.png', 'ab', '', '(607)404-6714', '84372 Kub Flats\r\nLake Richardhaven, NY 80438-5419', '1', 0, 'Est eaque aut sapiente facilis repellendus earum dolore. Id iure voluptas quia non. Amet dolor dignissimos ratione sed modi sint rerum.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(71, 1, 0, 0, 0, 1, 2, 0, 0, '', 'Katrina', 'Jacobi', 'Perempuan', '0000-00-00', 'varmstrong', '6610ba30f18c2c0b96d0042efc34ee2a89396628', 'katholik', 'selena.wiegand@example.net', 0, 'default.png', 'a', '', '+72(9)0625133850', '328 Schmitt Courts Apt. 998\r\nNorth Hortensetown, GA 52938', '1', 0, 'Facilis quo corrupti sint nostrum atque aliquam itaque. Dolore sit a maxime facere aut dolorum et. Nihil illum nulla quia aut totam ut ea.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(72, 3, 0, 0, 0, 1, 2, 0, 0, '', 'Esther', 'Ward', 'Perempuan', '0000-00-00', 'alexzander97', '10eda453d455f21a8aa176071dfa1e265c8f17e3', 'islam', 'mollie.lehner@example.net', 0, 'default.png', 'ab', '', '083-323-2085x884', '08083 Jena Brooks Suite 339\r\nBrennonton, KS 13646', '1', 0, 'Sint illo velit tenetur eum. Numquam rerum recusandae asperiores amet fuga qui. Odio repellendus sequi itaque atque.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(73, 1, 0, 0, 0, 1, 4, 0, 0, '', 'Tyrique', 'Schuppe', 'Laki-laki', '0000-00-00', 'jaida.botsford', '5d94a1e50a69c677fbafe22c16e80492dea3e3d9', 'hindu', 'jacklyn32@example.org', 0, 'default.png', 'b', '', '(424)589-5560', '093 Carolina Curve Suite 094\r\nTillmanmouth, KY 52554', '1', 0, 'Porro architecto quibusdam qui officia et aperiam. Dolor dolorem officia qui ut expedita autem.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(74, 3, 0, 0, 1, 1, 2, 0, 0, '', 'Hank', 'Schuppe', 'Laki-laki', '0000-00-00', 'ebert.alessandra', '7c7f329c08b6c0a457ce12ac57b5c647aadb774e', 'islam', 'valerie74@example.net', 0, 'default.png', 'o', '', '410.809.6965', '4545 Ethan Courts\r\nNolanberg, OH 25894', '1', 0, 'Consectetur et ut porro qui. Itaque quod quasi ipsa fugiat eaque error voluptas. Veritatis animi dolorum dolorum maxime facere est. Eligendi sit eveniet nihil est ut blanditiis minima est.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(75, 3, 0, 0, 1, 1, 4, 0, 0, '', 'Hellen', 'Kuhlman', 'Laki-laki', '0000-00-00', 'schneider.miller', 'e93726fc1b344f0113e7df814be635fa99883476', 'islam', 'renner.jennings@example.net', 0, 'default.png', 'a', '', '734.883.3580', '857 Julian Forks\r\nKihnview, FL 80887-6395', '1', 0, 'Quibusdam consequatur molestiae reprehenderit aut et. Aut molestiae nobis ipsum sapiente. Distinctio vel ut dignissimos sit officia. Quia iure at ab explicabo in omnis.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(76, 2, 0, 0, 1, 1, 4, 0, 0, '', 'Melyssa', 'Larkin', 'Perempuan', '0000-00-00', 'ytremblay', '818aa238a9c3f914fe15570f1c0d4d5248dd45ba', 'konghucu', 'kyla08@example.com', 0, 'default.png', 'a', '', '7284220161', '423 Weldon Meadow\r\nNorth Patienceshire, OH 40805', '1', 0, 'Itaque possimus porro excepturi rem tempora magni. Qui harum asperiores exercitationem et omnis repellat placeat. Provident repudiandae corrupti laudantium veritatis at. Suscipit debitis et laborio', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(77, 1, 0, 0, 0, 1, 1, 0, 0, '', 'Alisha', 'Emard', 'Laki-laki', '0000-00-00', 'strosin.salma', '9282712bc233b19893eb52ad8e2f4381bae785ef', 'konghucu', 'june91@example.net', 0, 'default.png', 'b', '', '906.050.3714x3323', '87882 Marquise Points\r\nWatersfort, IA 26172', '1', 0, 'Voluptates possimus natus mollitia aut repellendus quasi et. Omnis perferendis id cupiditate qui illum reiciendis. Ullam nisi libero eaque consequatur soluta. Sit voluptatum non debitis fugiat volu', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(78, 3, 0, 0, 0, 1, 3, 0, 0, '', 'Shirley', 'Wolff', 'Laki-laki', '0000-00-00', 'aanderson', '3ed0de31de9d18edcce96797e94f891cf6114678', 'hindu', 'schmidt.tabitha@example.org', 0, 'default.png', 'a', '', '394-952-7760x1067', '73565 Arnulfo Fort\r\nBeierland, NH 87661-2714', '1', 0, 'Id ut dolore magni provident. Nemo mollitia quis omnis aut nesciunt alias. Rerum aliquid temporibus vero dolor. Enim soluta quasi illo.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(79, 2, 0, 0, 0, 1, 3, 0, 0, '', 'Casimir', 'Prosacco', 'Laki-laki', '0000-00-00', 'rice.rod', 'ed6b4a90eb4e2f13b8806843eaef9675220c5679', 'katholik', 'jennie.jenkins@example.net', 0, 'default.png', 'b', '', '(840)639-7101x783', '652 Schmitt Valley\r\nSouth Anne, AK 97203-6971', '1', 0, 'Dicta quo qui assumenda et. Illum impedit sequi in voluptatem recusandae deserunt incidunt. Et distinctio ut ut nobis dicta dolor.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(80, 2, 0, 0, 0, 1, 4, 0, 0, '', 'Derek', 'Lehner', 'Perempuan', '0000-00-00', 'roberts.freeda', '9af0369731bac813f3d19d50b4a988471dbc08b6', 'katholik', 'mcclure.wilbert@example.org', 0, 'default.png', 'ab', '', '1-214-742-1489x3453', '419 Myrna Dale Suite 300\r\nEast Lailaland, MD 22011-3262', '1', 0, 'Corrupti et tenetur perferendis ipsum repellat quia. Vel illo porro sunt eos. Laboriosam ratione distinctio modi maiores id odit. Laudantium et nisi ipsum et rem culpa quia.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(81, 2, 0, 0, 0, 1, 1, 0, 0, '', 'Noble', 'Bode', 'Laki-laki', '0000-00-00', 'demario.d\'amore', '7b7591ea97a5ed8409b7ca955990d03f86278756', 'kristen', 'lexi26@example.org', 0, 'default.png', 'a', '', '806.032.7230', '0259 Shawn Gateway\r\nNoeliabury, ND 84093-5794', '1', 0, 'In et illum asperiores iusto. Dolor ut velit eum a quo velit autem. Laudantium quo architecto necessitatibus ea dolorem maxime aut.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(82, 2, 0, 0, 0, 1, 4, 0, 0, '', 'Lorenza', 'Flatley', 'Perempuan', '0000-00-00', 'romaguera.danika', '8a084488aa624da3a1dca533a4f063edd4a92727', 'kristen', 'elmira.stiedemann@example.org', 0, 'default.png', 'ab', '', '539-345-3226x2629', '3292 Greenfelder River Apt. 850\r\nMetzfort, KS 49962-2408', '1', 0, 'Quidem vel dignissimos itaque doloribus facilis reiciendis quas. Nulla excepturi eveniet magni. Suscipit rem ratione corrupti aliquid et.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(83, 3, 0, 0, 0, 1, 3, 0, 0, '', 'Aliza', 'Von', 'Laki-laki', '0000-00-00', 'jmohr', 'a833b216bd412f8f9750c3a8d2532ba917944bbe', 'islam', 'rosenbaum.pearline@example.com', 0, 'default.png', 'a', '', '1-247-905-4098x48774', '923 Arlo Valley\r\nGideonhaven, OR 56942', '1', 0, 'Inventore mollitia nihil ducimus ex ut atque veniam magni. Aut et harum dolorem molestias et perspiciatis tempore. Voluptas iusto occaecati non non distinctio sint. Explicabo facilis recusandae ear', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(84, 3, 0, 0, 1, 1, 2, 0, 0, '', 'Morgan', 'Kiehn', 'Laki-laki', '0000-00-00', 'carlee80', '8aa204020f7525ec2ee0d3721990e11fea3351fe', 'islam', 'sarmstrong@example.org', 0, 'default.png', 'b', '', '+84(3)2026471890', '135 Lane Flats\r\nPowlowskiberg, RI 53034', '1', 0, 'Eos enim ut nisi voluptate quae quo quia. Qui laboriosam deserunt corporis repudiandae aut velit laudantium. Temporibus libero autem aut quaerat.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(85, 2, 0, 0, 0, 1, 2, 0, 0, '', 'Shemar', 'Braun', 'Laki-laki', '0000-00-00', 'glennie10', '96bc20ce22ee6f46b815cb70a290e699854643d1', 'kristen', 'dee42@example.com', 0, 'default.png', 'o', '', '036-064-9428x534', '227 Keaton Gardens Suite 663\r\nMariliestad, OR 57119-1123', '1', 0, 'Voluptas delectus perspiciatis modi animi odio a pariatur. Totam voluptate eos quia molestiae voluptatem qui. Perspiciatis itaque incidunt hic corrupti.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(86, 2, 0, 0, 0, 1, 1, 0, 0, '', 'Kira', 'Harber', 'Laki-laki', '0000-00-00', 'mmacejkovic', 'b22468ec4301aa2f0cf38aaa21064a808ff18bd0', 'katholik', 'skye.gislason@example.com', 0, 'default.png', 'ab', '', '1-672-145-5796x00275', '461 Dickinson Pass\r\nLake Emely, OH 45323-7748', '1', 0, 'Assumenda quia assumenda quo sit molestias doloremque reiciendis tenetur. Molestias explicabo quis ex assumenda at ullam ab. Nostrum et repellendus quidem quia facilis.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(87, 3, 0, 0, 0, 1, 3, 0, 0, '', 'Coty', 'Streich', 'Perempuan', '0000-00-00', 'tsawayn', 'add260b282e2a808d52f8e5f41e19758832dc532', 'hindu', 'xmurazik@example.net', 0, 'default.png', 'b', '', '(691)282-4479x925', '497 Borer Forges\r\nNew Charlene, NH 59786', '1', 0, 'Enim veritatis incidunt labore. Nobis esse quia quidem enim tempore totam vitae quis. Aut velit facilis saepe ab et rerum. Autem nisi et sunt asperiores.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(88, 2, 0, 0, 1, 1, 3, 0, 0, '', 'Myrtice', 'Koch', 'Perempuan', '0000-00-00', 'afton.hegmann', 'f6ddb7c6adbe468e1102f7f2e0560fb2ba9b59fb', 'kristen', 'destiney25@example.org', 0, 'default.png', 'b', '', '865-430-6194', '60250 Wehner Row Suite 410\r\nNew Aronport, AZ 68844', '1', 0, 'Autem eligendi suscipit sapiente. Ut fuga rem unde ut natus. Neque id in deleniti qui est.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(89, 2, 0, 0, 1, 1, 3, 0, 0, '', 'Kurt', 'Kohler', 'Perempuan', '0000-00-00', 'ayana.dooley', '7228d0eb4c44360796e52999b6a91eb8b20d5a87', 'kristen', 'jpfeffer@example.org', 0, 'default.png', 'a', '', '168.055.1846x150', '597 Rudolph Mountains Suite 563\r\nParkerton, OR 70287', '1', 0, 'Consectetur tenetur nisi saepe enim. Vero nesciunt consectetur voluptas ratione. Tenetur ullam molestiae nihil officiis velit nesciunt. Excepturi non id dolore aperiam ut vel. Autem libero eos qui', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(90, 1, 0, 0, 0, 1, 1, 0, 0, '', 'Makenzie', 'Gislason', 'Perempuan', '0000-00-00', 'miles25', 'da8c2472feb672372a91a138c696bad62a25e6ed', 'hindu', 'ryan.mina@example.org', 0, 'default.png', 'a', '', '1-824-420-4680', '865 Elza Fork Apt. 084\r\nEast Calitown, SC 61558', '1', 0, 'Maiores libero repudiandae voluptas. In sit itaque non in qui. Suscipit sint et consequuntur sint vitae ab velit. Voluptatibus esse harum impedit quae incidunt molestiae.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(91, 1, 0, 0, 0, 1, 4, 0, 0, '', 'Kendra', 'Dare', 'Perempuan', '0000-00-00', 'ylittle', 'e3db03c33d3130a1d84bca22dce51cf9edc1ac5a', 'kristen', 'isobel32@example.net', 0, 'default.png', 'a', '', '030-130-1903', '125 Destin Streets\r\nNorth Anissa, AZ 42428-1612', '1', 0, 'Magnam expedita architecto pariatur inventore impedit sed. Aspernatur rerum perspiciatis quo et molestias. Similique qui provident et. Vel odit quisquam dolores omnis. Sit est ea aliquam.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(92, 2, 0, 0, 1, 1, 1, 0, 0, '', 'Shad', 'Renner', 'Laki-laki', '0000-00-00', 'leonel45', 'acf261eb9a9ae1d46e0c6116e8ae4e7920e1d3f7', 'hindu', 'thompson.rubie@example.com', 0, 'default.png', 'b', '', '6669881083', '9035 Waelchi Way Suite 659\r\nCarterville, OK 53786-1752', '1', 0, 'Ut itaque minima molestias maxime. Delectus dolorum deserunt pariatur.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(93, 2, 0, 0, 0, 1, 3, 0, 0, '', 'Ellsworth', 'Dooley', 'Laki-laki', '0000-00-00', 'dach.katherine', '8d6c7db7fb637fde4fad1498a998b5483cea7b34', 'hindu', 'smith.adriel@example.org', 0, 'default.png', 'ab', '', '891-341-5834', '3940 Hackett Station Suite 265\r\nEast Estella, ND 57843-8954', '1', 0, 'Enim officia porro enim quaerat dicta aperiam. Aut qui laborum voluptates est non doloribus. Assumenda quam ut cumque molestiae placeat. Iste voluptatem sit totam necessitatibus ullam quis labore n', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(94, 3, 0, 0, 1, 1, 4, 0, 0, '', 'Imelda', 'Zemlak', 'Laki-laki', '0000-00-00', 'xharris', 'c63e4658d4467e185aa92293dc2c4e004903b76c', 'kristen', 'shanie.ondricka@example.net', 0, 'default.png', 'ab', '', '844.481.3978x5648', '322 Toy Manors\r\nLake Dominique, MA 05307-0162', '1', 0, 'Dolorem praesentium qui expedita sequi sunt voluptas voluptas. Sint et quibusdam iusto est velit error temporibus. Doloribus hic omnis eos quas sunt.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(95, 3, 0, 0, 1, 1, 4, 0, 0, '', 'Milan', 'Gottlieb', 'Perempuan', '0000-00-00', 'bogisich.demarcu', '35dd804fb5080f0f401667c991b4f45fd22224e1', 'katholik', 'kirstin.grady@example.org', 0, 'default.png', 'ab', '', '7348360506', '1298 Alia Falls\r\nUllrichfort, OR 53528', '1', 0, 'Laborum eos quisquam et est aut. Est officia qui eligendi excepturi. Quia et culpa eos soluta. Alias repellat sapiente rem et dolor.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(96, 1, 0, 0, 1, 1, 1, 0, 0, '', 'Alfonzo', 'Keeling', 'Perempuan', '0000-00-00', 'martine.goyette', 'bbce897daa8da77b392d6ac132d40b1219b89d5f', 'kristen', 'zshanahan@example.com', 0, 'default.png', 'b', '', '1035193354', '55568 Anderson Streets\r\nElliotland, ND 99399', '1', 0, 'Qui possimus ex non molestias non voluptas. Quia et est qui et dolores est. Ratione alias tempora commodi rerum voluptas adipisci. Deserunt doloremque sed consequatur dolores a vel.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(97, 1, 0, 0, 0, 1, 3, 0, 0, '', 'Kayleigh', 'Brakus', 'Perempuan', '0000-00-00', 'kozey.lyla', 'e45c29594a3979e437aa7388bb5ebe050a2f9fcf', 'hindu', 'haylie.schroeder@example.com', 0, 'default.png', 'a', '', '(182)036-3710x075', '0309 David Mews\r\nEast Garett, PA 20575-4413', '1', 0, 'Eos repellendus amet aperiam provident dolorum in dolorum. Veritatis aliquid iste aut. Eius odit est dolore quis.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(98, 2, 0, 0, 0, 1, 4, 0, 0, '', 'Percy', 'Hauck', 'Perempuan', '0000-00-00', 'bennie47', '3a964cf298b6f9ec38be06b11246337bd8918afa', 'islam', 'sanford97@example.net', 0, 'default.png', 'a', '', '(033)076-4244', '85776 O\'Reilly Parks Suite 946\r\nPort Desireeburgh, RI 21109', '1', 0, 'Omnis facere perferendis amet soluta voluptates. Occaecati eveniet sed sed culpa. Provident nam dolorum tempore praesentium natus voluptatibus illo quis.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(99, 1, 0, 0, 1, 1, 3, 0, 0, '', 'Araceli', 'Koss', 'Perempuan', '0000-00-00', 'littel.daniella', 'deb2c87bfe48c7e579cdbebdca1415104ea123b8', 'katholik', 'mercedes59@example.com', 0, 'default.png', 'o', '', '467-321-6972x50539', '43317 Oberbrunner Ramp\r\nNew Verona, NJ 77057-6445', '1', 0, 'Corporis rem ea fugiat cumque. Corrupti unde et repudiandae voluptatem sequi fugit excepturi. Et voluptas aut minus quia est sed est et. Rem sunt exercitationem facere maiores repellat.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(100, 2, 0, 0, 0, 1, 4, 0, 0, '', 'Laverne', 'Morar', 'Perempuan', '0000-00-00', 'miller20', 'c97f8592befaa34057b58d44eb700d66bafb1514', 'kristen', 'clittle@example.org', 0, 'default.png', 'o', '', '5278137898', '40666 Katlyn Shore Suite 040\r\nEast Kelli, ID 28933-3389', '1', 0, 'Quos voluptates ab et ut ipsa sequi. Iste reiciendis vitae illum id aperiam similique cupiditate. Saepe et incidunt est delectus sit rem vel nihil. Nam architecto eligendi vero possimus totam et.', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL);
INSERT INTO `tbl_users` (`id_user`, `id_class`, `id_section`, `id_subject`, `id_hostel`, `id_trans`, `id_user_type`, `id_parent`, `id_student`, `session`, `first_name`, `last_name`, `gender`, `date_of_birth`, `username`, `password`, `religion`, `email`, `NISN`, `photo_user`, `blood_group`, `occupation`, `phone_user`, `address_user`, `class`, `status`, `short_bio`, `admission_status`, `admission_date`, `create_at`, `update_at`, `delete_at`) VALUES
(101, 3, 0, 0, 0, 1, 3, 0, 0, '', 'Maida', 'Cummings', 'Laki-laki', '0000-00-00', 'xemmerich', 'c2c8433e159ca1f1a0bd62d8cfd90d2dd64d639b', 'kristen', 'pmosciski@example.net', 0, 'default.png', 'ab', '', '(264)015-2705', '8484 Reece Tunnel Suite 836\r\nNew Julianaview, GA 57745', '1', 0, 'Odio non et eos qui dolor saepe est eum. Harum id explicabo quis exercitationem hic. Neque architecto cupiditate ullam voluptas. Quas cumque illo illum est harum. Corrupti facilis cumque earum quo', NULL, NULL, '2022-12-07 03:11:44', '2022-12-07 03:24:51', NULL),
(103, 0, 0, 0, 0, 0, 3, 0, 0, '', 'Miku21', 'Margareth', 'Laki-laki', '2005-04-24', 'miku21', 'miku21', 'Attack Helicopter', 'rafaelfarizi1@gmail.com', 0, '20221207042526-20220929-133008.jpg', 'AB', 'Pullstack Wengdev', '6287731137512', 'Indonesia', NULL, 1, 'Miku21 wengdev on Lorem Ipsum', NULL, NULL, '2022-12-07 03:13:24', '2022-12-07 03:25:26', NULL),
(111, 0, 0, 0, 0, 0, 2, 0, 0, '', '', '', 'Laki-laki', '0000-00-00', 'miku21comunity', 'miku21', '', 'mikucomunity21@gmail.com', 0, '20221207105642-794cdf8bd464220d70698e3af1179178.jpg', '', '', '', '', NULL, 1, '', NULL, NULL, '2022-12-07 09:32:10', '2022-12-07 10:00:05', NULL),
(112, 0, 0, 0, 0, 0, 1, 0, 0, '', 'Leute Ruth', 'Leciepent', '', '2004-07-24', 'ruth02', 'ruth02cans', 'Flying Dutchman', 'laruthm02@gmail.com', 0, '20221208093903-468944.jpg', 'B', 'Sinner', '62877311375121', 'Cimahi', NULL, 1, 'Ora pro nobis, sancta Dei Genitrix', NULL, NULL, '2022-12-08 08:32:27', '2022-12-08 08:39:03', NULL),
(113, 0, 0, 0, 0, 0, 4, 0, 0, '', 'Belum', 'Ada', '', '0000-00-00', '', '', '', '', 0, NULL, NULL, '', '', NULL, NULL, 0, NULL, NULL, NULL, '2022-12-09 06:10:34', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user_types`
--

CREATE TABLE `tbl_user_types` (
  `id_user_type` int(11) NOT NULL,
  `user_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_user_types`
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
-- Indeks untuk tabel `tbl_admissions`
--
ALTER TABLE `tbl_admissions`
  ADD PRIMARY KEY (`id_admission`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `tbl_attendances`
--
ALTER TABLE `tbl_attendances`
  ADD PRIMARY KEY (`id_attendance`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `tbl_books`
--
ALTER TABLE `tbl_books`
  ADD PRIMARY KEY (`id_book`);

--
-- Indeks untuk tabel `tbl_classes`
--
ALTER TABLE `tbl_classes`
  ADD PRIMARY KEY (`id_class`),
  ADD KEY `id_section_2` (`id_section`);

--
-- Indeks untuk tabel `tbl_class_routines`
--
ALTER TABLE `tbl_class_routines`
  ADD PRIMARY KEY (`id_class_routine`),
  ADD KEY `id_class` (`id_class`),
  ADD KEY `id_subject` (`id_subject`);

--
-- Indeks untuk tabel `tbl_exams`
--
ALTER TABLE `tbl_exams`
  ADD PRIMARY KEY (`id_exam`),
  ADD KEY `id_class` (`id_class`);

--
-- Indeks untuk tabel `tbl_exam_grades`
--
ALTER TABLE `tbl_exam_grades`
  ADD PRIMARY KEY (`id_exam_grade`);

--
-- Indeks untuk tabel `tbl_exam_results`
--
ALTER TABLE `tbl_exam_results`
  ADD PRIMARY KEY (`id_result`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_exam` (`id_exam`),
  ADD KEY `id_subject` (`id_subject`),
  ADD KEY `id_class` (`id_class`),
  ADD KEY `id_section` (`id_section`);

--
-- Indeks untuk tabel `tbl_finances`
--
ALTER TABLE `tbl_finances`
  ADD PRIMARY KEY (`id_finance`),
  ADD KEY `id_payment_type` (`id_payment_type`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `tbl_hostels`
--
ALTER TABLE `tbl_hostels`
  ADD PRIMARY KEY (`id_hostel`);

--
-- Indeks untuk tabel `tbl_messages`
--
ALTER TABLE `tbl_messages`
  ADD PRIMARY KEY (`id_message`);

--
-- Indeks untuk tabel `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  ADD PRIMARY KEY (`id_notification`);

--
-- Indeks untuk tabel `tbl_payment_types`
--
ALTER TABLE `tbl_payment_types`
  ADD PRIMARY KEY (`id_payment_type`);

--
-- Indeks untuk tabel `tbl_sections`
--
ALTER TABLE `tbl_sections`
  ADD PRIMARY KEY (`id_section`);

--
-- Indeks untuk tabel `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  ADD PRIMARY KEY (`id_subject`);

--
-- Indeks untuk tabel `tbl_transports`
--
ALTER TABLE `tbl_transports`
  ADD PRIMARY KEY (`id_transport`);

--
-- Indeks untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_hostel` (`id_hostel`),
  ADD KEY `id_user_type` (`id_user_type`),
  ADD KEY `id_class` (`id_class`),
  ADD KEY `id_trans` (`id_trans`);

--
-- Indeks untuk tabel `tbl_user_types`
--
ALTER TABLE `tbl_user_types`
  ADD PRIMARY KEY (`id_user_type`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_admissions`
--
ALTER TABLE `tbl_admissions`
  MODIFY `id_admission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tbl_attendances`
--
ALTER TABLE `tbl_attendances`
  MODIFY `id_attendance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `tbl_books`
--
ALTER TABLE `tbl_books`
  MODIFY `id_book` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tbl_classes`
--
ALTER TABLE `tbl_classes`
  MODIFY `id_class` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tbl_class_routines`
--
ALTER TABLE `tbl_class_routines`
  MODIFY `id_class_routine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tbl_exams`
--
ALTER TABLE `tbl_exams`
  MODIFY `id_exam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tbl_exam_grades`
--
ALTER TABLE `tbl_exam_grades`
  MODIFY `id_exam_grade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tbl_exam_results`
--
ALTER TABLE `tbl_exam_results`
  MODIFY `id_result` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tbl_finances`
--
ALTER TABLE `tbl_finances`
  MODIFY `id_finance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `tbl_messages`
--
ALTER TABLE `tbl_messages`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `id_notification` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tbl_payment_types`
--
ALTER TABLE `tbl_payment_types`
  MODIFY `id_payment_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_sections`
--
ALTER TABLE `tbl_sections`
  MODIFY `id_section` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  MODIFY `id_subject` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tbl_transports`
--
ALTER TABLE `tbl_transports`
  MODIFY `id_transport` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT untuk tabel `tbl_user_types`
--
ALTER TABLE `tbl_user_types`
  MODIFY `id_user_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
