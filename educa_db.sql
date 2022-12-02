-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Des 2022 pada 07.35
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 7.4.33

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_admissions`
--

INSERT INTO `tbl_admissions` (`id_admission`, `id_user`, `admission_date`) VALUES
(1, 2, '2022-12-01'),
(2, 3, '2022-12-01'),
(3, 4, '2022-12-01'),
(4, 5, '2022-10-06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_attendances`
--

CREATE TABLE `tbl_attendances` (
  `id_attendance` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `att_in` timestamp NOT NULL DEFAULT current_timestamp(),
  `att_out` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_books`
--

CREATE TABLE `tbl_books` (
  `id_book` int(11) NOT NULL,
  `name_book` varchar(50) NOT NULL,
  `category_book` varchar(50) NOT NULL,
  `writer_book` varchar(50) NOT NULL,
  `class` varchar(50) NOT NULL,
  `publish_date` date NOT NULL,
  `upload_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_classes`
--

CREATE TABLE `tbl_classes` (
  `id_class` int(11) NOT NULL,
  `id_section` int(11) NOT NULL,
  `class` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_classes`
--

INSERT INTO `tbl_classes` (`id_class`, `id_section`, `class`) VALUES
(1, 1, 'X'),
(2, 1, 'XI'),
(3, 1, 'XII');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_class_routines`
--

CREATE TABLE `tbl_class_routines` (
  `id_class_routine` int(11) NOT NULL,
  `id_class` int(11) NOT NULL,
  `id_subject` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_class_routines`
--

INSERT INTO `tbl_class_routines` (`id_class_routine`, `id_class`, `id_subject`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_exams`
--

CREATE TABLE `tbl_exams` (
  `id_exam` int(11) NOT NULL,
  `id_class` int(11) NOT NULL,
  `exam_name` varchar(50) NOT NULL,
  `exam_date` date DEFAULT NULL,
  `exam_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_exams`
--

INSERT INTO `tbl_exams` (`id_exam`, `id_class`, `exam_name`, `exam_date`, `exam_time`) VALUES
(1, 1, 'Ujian Semester 1 X-A', '2022-12-01', '01:00:00'),
(2, 2, 'Ujian Semester XI-A', '2022-12-01', '01:00:00');

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
  `id_section` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `date_result` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_exam_results`
--

INSERT INTO `tbl_exam_results` (`id_result`, `id_user`, `id_exam`, `id_subject`, `id_class`, `id_section`, `score`, `date_result`) VALUES
(3, 2, 1, 2, 1, 1, 80, '2022-12-01'),
(4, 3, 2, 1, 2, 1, 90, '2022-12-01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_finances`
--

CREATE TABLE `tbl_finances` (
  `id_finance` int(11) NOT NULL,
  `id_payment_type` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `amount_payment` int(11) NOT NULL,
  `status` enum('Dibayar','Belum Bayar','','') NOT NULL,
  `date_payment` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_finances`
--

INSERT INTO `tbl_finances` (`id_finance`, `id_payment_type`, `id_user`, `amount_payment`, `status`, `date_payment`) VALUES
(1, 1, 14, 2000000, 'Dibayar', '1988-02-09'),
(2, 1, 9, 2000000, 'Dibayar', '1990-04-23'),
(3, 1, 5, 2000000, 'Dibayar', '1996-03-06'),
(4, 1, 5, 2000000, 'Dibayar', '1981-04-24'),
(5, 1, 2, 2000000, 'Dibayar', '1995-03-19'),
(6, 1, 3, 2000000, 'Belum Bayar', '1981-07-01'),
(7, 1, 4, 2000000, 'Dibayar', '1989-07-21'),
(8, 1, 9, 2000000, 'Belum Bayar', '1974-07-14'),
(9, 1, 11, 2000000, 'Belum Bayar', '1993-10-05'),
(10, 1, 10, 2000000, 'Belum Bayar', '1985-06-24'),
(11, 1, 10, 2000000, 'Dibayar', '1983-07-18'),
(12, 1, 4, 2000000, 'Belum Bayar', '1999-03-24'),
(13, 1, 17, 2000000, 'Dibayar', '2022-04-12'),
(14, 1, 18, 2000000, 'Dibayar', '1977-02-24'),
(15, 1, 5, 2000000, 'Dibayar', '1993-02-03'),
(16, 1, 14, 2000000, 'Dibayar', '1988-02-07'),
(17, 1, 9, 2000000, 'Dibayar', '1982-04-20'),
(18, 1, 9, 2000000, 'Belum Bayar', '1975-07-05'),
(19, 1, 2, 2000000, 'Dibayar', '1991-09-21'),
(20, 1, 8, 2000000, 'Dibayar', '2010-01-11'),
(21, 1, 8, 2000000, 'Dibayar', '2000-08-07'),
(22, 1, 18, 2000000, 'Dibayar', '1978-11-09'),
(23, 1, 7, 2000000, 'Belum Bayar', '2021-05-26'),
(24, 1, 13, 2000000, 'Belum Bayar', '2008-10-12'),
(25, 1, 5, 2000000, 'Dibayar', '2000-02-28'),
(26, 1, 2, 2000000, 'Dibayar', '1991-12-12'),
(27, 1, 6, 2000000, 'Belum Bayar', '1998-09-13'),
(28, 1, 17, 2000000, 'Dibayar', '1986-09-15'),
(29, 1, 10, 2000000, 'Dibayar', '2014-04-24'),
(30, 1, 18, 2000000, 'Dibayar', '1999-01-21'),
(31, 1, 20, 2000000, 'Dibayar', '2008-02-03'),
(32, 1, 2, 2000000, 'Dibayar', '2012-05-30'),
(33, 1, 6, 2000000, 'Belum Bayar', '1982-11-14'),
(34, 1, 4, 2000000, 'Belum Bayar', '1976-04-11'),
(35, 1, 18, 2000000, 'Dibayar', '1992-02-27'),
(36, 1, 17, 2000000, 'Dibayar', '1973-07-27'),
(37, 1, 9, 2000000, 'Dibayar', '1981-06-16'),
(38, 1, 13, 2000000, 'Belum Bayar', '2018-07-16'),
(39, 1, 9, 2000000, 'Belum Bayar', '1995-02-23'),
(40, 1, 11, 2000000, 'Belum Bayar', '1972-10-11'),
(41, 1, 18, 2000000, 'Dibayar', '2019-10-17'),
(42, 1, 18, 2000000, 'Dibayar', '1990-10-02'),
(43, 1, 9, 2000000, 'Dibayar', '1974-01-04'),
(44, 1, 5, 2000000, 'Dibayar', '1978-08-01'),
(45, 1, 11, 2000000, 'Dibayar', '2001-11-22'),
(46, 1, 15, 2000000, 'Dibayar', '2005-06-03'),
(47, 1, 20, 2000000, 'Dibayar', '2000-07-29'),
(48, 1, 19, 2000000, 'Belum Bayar', '2000-09-04'),
(49, 1, 4, 2000000, 'Dibayar', '2017-01-11'),
(50, 1, 14, 2000000, 'Belum Bayar', '2017-03-10'),
(51, 1, 18, 2000000, 'Dibayar', '2002-01-19'),
(52, 1, 14, 2000000, 'Dibayar', '1976-01-12'),
(53, 1, 7, 2000000, 'Belum Bayar', '1994-10-07'),
(54, 1, 11, 2000000, 'Belum Bayar', '2015-10-08'),
(55, 1, 18, 2000000, 'Belum Bayar', '2020-02-02'),
(56, 1, 7, 2000000, 'Dibayar', '2006-03-23'),
(57, 1, 10, 2000000, 'Belum Bayar', '1977-10-29'),
(58, 1, 4, 2000000, 'Belum Bayar', '1972-04-03'),
(59, 1, 5, 2000000, 'Dibayar', '2003-06-09'),
(60, 1, 9, 2000000, 'Belum Bayar', '1975-05-13'),
(61, 1, 11, 2000000, 'Belum Bayar', '1999-08-11'),
(62, 1, 11, 2000000, 'Dibayar', '1998-12-28'),
(63, 1, 12, 2000000, 'Belum Bayar', '2006-09-15'),
(64, 1, 4, 2000000, 'Dibayar', '2006-06-09'),
(65, 1, 5, 2000000, 'Dibayar', '1975-12-30'),
(66, 1, 10, 2000000, 'Dibayar', '2021-07-12'),
(67, 1, 19, 2000000, 'Dibayar', '1987-11-28'),
(68, 1, 2, 2000000, 'Belum Bayar', '1970-02-23'),
(69, 1, 11, 2000000, 'Belum Bayar', '1989-12-06'),
(70, 1, 15, 2000000, 'Dibayar', '2008-01-31'),
(71, 1, 11, 2000000, 'Belum Bayar', '1989-02-12'),
(72, 1, 5, 2000000, 'Belum Bayar', '1981-01-13'),
(73, 1, 16, 2000000, 'Belum Bayar', '1986-06-02'),
(74, 1, 5, 2000000, 'Belum Bayar', '1985-08-05'),
(75, 1, 19, 2000000, 'Dibayar', '2014-11-19'),
(76, 1, 9, 2000000, 'Belum Bayar', '1995-12-24'),
(77, 1, 5, 2000000, 'Belum Bayar', '1989-11-11'),
(78, 1, 15, 2000000, 'Belum Bayar', '2013-03-22'),
(79, 1, 19, 2000000, 'Dibayar', '1991-03-31'),
(80, 1, 18, 2000000, 'Dibayar', '1989-01-23'),
(81, 1, 13, 2000000, 'Dibayar', '1976-07-28'),
(82, 1, 7, 2000000, 'Belum Bayar', '2012-10-24'),
(83, 1, 6, 2000000, 'Belum Bayar', '1996-12-09'),
(84, 1, 2, 2000000, 'Dibayar', '2009-07-13'),
(85, 1, 7, 2000000, 'Dibayar', '2003-05-26'),
(86, 1, 20, 2000000, 'Belum Bayar', '2021-03-27'),
(87, 1, 2, 2000000, 'Dibayar', '1997-07-31'),
(88, 1, 2, 2000000, 'Belum Bayar', '1972-12-16'),
(89, 1, 16, 2000000, 'Belum Bayar', '1995-10-18'),
(90, 1, 4, 2000000, 'Dibayar', '1970-04-21'),
(91, 1, 11, 2000000, 'Dibayar', '2020-10-26'),
(92, 1, 20, 2000000, 'Dibayar', '1991-02-04'),
(93, 1, 6, 2000000, 'Dibayar', '1983-01-09'),
(94, 1, 16, 2000000, 'Dibayar', '2014-07-10'),
(95, 1, 15, 2000000, 'Dibayar', '1983-01-01'),
(96, 1, 7, 2000000, 'Belum Bayar', '1994-01-10'),
(97, 1, 12, 2000000, 'Belum Bayar', '1973-09-01'),
(98, 1, 14, 2000000, 'Dibayar', '1973-08-19'),
(99, 1, 14, 2000000, 'Dibayar', '1978-03-20'),
(100, 1, 11, 2000000, 'Dibayar', '2012-03-07'),
(101, 3, 30, 1500000, 'Belum Bayar', '1978-02-25'),
(102, 3, 35, 1500000, 'Dibayar', '1970-04-03'),
(103, 3, 30, 1500000, 'Belum Bayar', '1971-07-11'),
(104, 3, 56, 1500000, 'Dibayar', '1998-10-24'),
(105, 3, 56, 1500000, 'Dibayar', '2022-06-25'),
(106, 3, 34, 1500000, 'Belum Bayar', '2018-11-06'),
(107, 3, 56, 1500000, 'Dibayar', '2016-02-02'),
(108, 3, 35, 1500000, 'Dibayar', '1970-08-05'),
(109, 3, 59, 1500000, 'Belum Bayar', '1970-05-26'),
(110, 3, 34, 1500000, 'Dibayar', '1979-01-24'),
(111, 3, 35, 1500000, 'Dibayar', '1992-09-04'),
(112, 3, 34, 1500000, 'Belum Bayar', '2017-05-27'),
(113, 3, 35, 1500000, 'Belum Bayar', '2001-04-14'),
(114, 3, 41, 1500000, 'Belum Bayar', '2008-10-08'),
(116, 3, 59, 1500000, 'Belum Bayar', '1988-08-25'),
(117, 3, 47, 1500000, 'Dibayar', '1983-04-15'),
(118, 3, 57, 1500000, 'Belum Bayar', '2013-11-20'),
(119, 3, 63, 1500000, 'Belum Bayar', '2019-03-22'),
(120, 3, 41, 1500000, 'Belum Bayar', '2010-08-31');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `terbaca` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_notifications`
--

CREATE TABLE `tbl_notifications` (
  `id_notification` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `details` varchar(100) NOT NULL,
  `posted_by` varchar(50) NOT NULL,
  `date_notice` datetime NOT NULL,
  `terbaca` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_notifications`
--

INSERT INTO `tbl_notifications` (`id_notification`, `id_user`, `title`, `details`, `posted_by`, `date_notice`, `terbaca`) VALUES
(3, 48, 'Biaya Semester ', 'Jatuh Tempo Biaya Semester Bulan Desember Siswa A', 'Admin', '2022-10-08 10:00:00', ''),
(4, 48, 'Biaya Semester ', 'Jatuh Tempo Biaya Semester Bulan Desember Siswa B', 'Admin', '2022-12-01 05:00:00', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_payment_types`
--

CREATE TABLE `tbl_payment_types` (
  `id_payment_type` int(11) NOT NULL,
  `payment_type_name` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_payment_types`
--

INSERT INTO `tbl_payment_types` (`id_payment_type`, `payment_type_name`) VALUES
(1, 'Biaya Semester'),
(2, 'Biaya Ujian');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_sections`
--

CREATE TABLE `tbl_sections` (
  `id_section` int(11) NOT NULL,
  `section` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_sections`
--

INSERT INTO `tbl_sections` (`id_section`, `section`) VALUES
(1, 'A'),
(2, 'B');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_subjects`
--

CREATE TABLE `tbl_subjects` (
  `id_subject` int(11) NOT NULL,
  `subject_name` varchar(25) NOT NULL,
  `subject_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_subjects`
--

INSERT INTO `tbl_subjects` (`id_subject`, `subject_name`, `subject_type`) VALUES
(1, 'English', ''),
(2, 'Accounting', '');

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
  `phone_number` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_transports`
--

INSERT INTO `tbl_transports` (`id_transport`, `route_name`, `vehicle_number`, `driver_name`, `license_number`, `phone_number`) VALUES
(1, 'Jl Patimura - Jl Diponogoro', 'AD 5772 CA', 'Raihan', 'A8908989AAA100', '0866239377774');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id_user` int(11) NOT NULL,
  `id_class` int(11) NOT NULL,
  `id_hostel` int(11) NOT NULL,
  `id_trans` int(11) NOT NULL,
  `id_user_type` int(11) NOT NULL,
  `id_parent` int(11) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `gender` enum('Laki-laki','Perempuan','','') NOT NULL,
  `date_of_birth` date NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `religion` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `NISN` int(11) NOT NULL,
  `photo_user` varchar(255) DEFAULT NULL,
  `blood_group` char(5) DEFAULT NULL,
  `occupation` varchar(10) DEFAULT NULL,
  `phone_user` varchar(25) NOT NULL,
  `address_user` text,
  `short_bio` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_users`
--

INSERT INTO `tbl_users` (`id_user`, `id_class`, `id_hostel`, `id_trans`, `id_user_type`, `id_parent`, `first_name`, `last_name`, `gender`, `date_of_birth`, `username`, `password`, `religion`, `email`, `NISN`, `photo_user`, `blood_group`, `occupation`, `phone_user`, `address_user`, `class`, `short_bio`) VALUES
(2, 1, 0, 1, 1, 25, 'doni', 'billar', 'Laki-laki', '2012-11-15', 'random', 'random', 'other', 'oniworld@oniworld.com', 9987, NULL, NULL, NULL, '+628963333930', 'random', '1', 'random'),
(3, 2, 0, 1, 1, 29, 'Art', 'Ankunding', 'Perempuan', NULL, 'gaylord.schoen', '3e9cab5ae2ae061f1654f0d141bb77f0693f615f', 'hindu', 'moore.eveline@example.net', 9864, 'tmp//0c0b1966f594adf3e3548ba4738d7ba9.jpg', 'b', NULL, '793-284-4861', '5934 Jacinto Crossroad Apt. 364 Olsonmouth, KS 30988', '1', 'Necessitatibus error atque delectus ipsa libero. Harum quasi assumenda quos illum. Maiores et ipsam iusto at ea qui quibusdam. Eligendi iure libero aut quia quia vero autem.'),
(4, 1, 0, 1, 1, 31, 'Emily', 'Aufderhar', 'Perempuan', NULL, 'so\'keefe', 'ab3a0ba6b3d3ffc9834f76574dd2c3ec9438a795', 'kristen', 'briana.weimann@example.net', 9861, 'tmp//184b1663b228823109b0066812619c89.jpg', NULL, NULL, '1-688-563-2931x133', '1691 Rice Underpass North Valentinamouth, ID 91399', '1', 'Dolore inventore iure repudiandae qui consequatur accusamus. Recusandae dolorem quam est saepe sed unde soluta. Atque id qui deleniti aut repellat. Maxime quaerat ut corrupti et et enim sint.'),
(5, 1, 0, 1, 1, 32, 'Ida', 'Roberts', 'Perempuan', NULL, 'swilderman', '2e54bd48cabbb48a57c87ecc6575d6871117c177', 'islam', 'clifford61@example.com', 0, 'tmp//10b7a7183fbc71a337164a22ae71c68b.jpg', NULL, NULL, '1-357-343-0969x83055', '002 Connelly Canyon Apt. 917 New Joyburgh, WA 46394', '1', 'Libero earum dolor possimus accusantium vitae fugiat ratione. Cumque cumque tempore et est dolore rerum voluptatem molestiae. Quas sunt omnis asperiores dolor provident culpa inventore.'),
(6, 1, 0, 1, 1, 36, 'Eloisa', 'Langworth', 'Laki-laki', NULL, 'hyman77', 'a8a88f3f74ee5c0c2efc29a71e94c9b8b7ad6f1a', 'hindu', 'rod.willms@example.org', 0, 'tmp//30f9aff2f4249e484c81c55e64461172.jpg', 'o', NULL, '8833275468', '1265 Johns Valley Suite 874 Samsonshire, OR 34497', '1', 'Porro ipsa nam harum. Perferendis similique voluptatem incidunt nisi facilis et ratione. Voluptatum tenetur qui sit rerum quam quasi similique. Impedit et corporis repellendus est.'),
(7, 1, 0, 1, 1, 38, 'Gail', 'Kris', 'Perempuan', NULL, 'lcarroll', '96c515f5a56c27e6a0c448b29192db24935423b9', 'buddha', 'nakia.greenfelder@example.net', 0, 'tmp//d1ebc014690575b67a5c7504606316be.jpg', NULL, NULL, '190-759-4362x6965', '63471 Kamren Ridge Apt. 498 Pollichstad, DC 10284-9138', '1', 'Sint nam aut quasi autem at. Fuga nesciunt aut dolorem numquam tempore autem. Quia sequi sapiente sunt minima. Et excepturi aut odio tempore.'),
(8, 1, 0, 1, 1, 40, 'Frederik', 'Kunde', 'Perempuan', NULL, 'colleen24', '69868ac46b02f7ffae2eb1bd1cff488388c5d020', 'konghucu', 'angelica.yundt@example.org', 0, 'tmp//4d6c45e013f3fc46d6944a230700cf43.jpg', 'a', NULL, '+14(0)3210550981', '61488 Abbott Greens Suite 690 North Rashad, AZ 41490-7600', '1', 'Dolor dolores sed tempore nesciunt id neque. Provident velit officiis error laudantium recusandae ipsam. Amet quod qui animi repudiandae. Nesciunt nulla omnis aut inventore impedit.'),
(9, 1, 0, 1, 1, 43, 'Jean', 'Volkman', 'Perempuan', NULL, 'adan25', '7cc4177c712afc05f20e4d358d7eb7a6c2286550', 'katholik', 'larry.greenfelder@example.com', 0, 'tmp//149f77211076a3a8108dfb56a62d95e0.jpg', 'a', NULL, '921-106-9611x9156', '584 Erik Freeway Suite 364 Lake Hollieshire, HI 68610-6011', '1', 'Quis omnis consequatur non mollitia. Eos quae inventore quia vero voluptates. Quia eos rerum sunt.'),
(10, 1, 0, 1, 1, 48, 'Melisa', 'Shanahan', 'Laki-laki', NULL, 'jeffrey.mosciski', '28cf1e15aa2e3461e1f9a4bc98e002c882d15da9', 'islam', 'odell04@example.com', 0, 'tmp//8339637f6f375d0c451418dec544216f.jpg', 'b', NULL, '840.286.9973', '0004 Mallie Spur Boehmmouth, TN 31023-9628', '1', 'Quaerat rerum voluptatem sint veritatis blanditiis. Deserunt debitis quae at sequi unde nam id.'),
(11, 1, 0, 1, 1, 50, 'Dorthy', 'Quigley', 'Perempuan', NULL, 'irogahn', 'aa7cacb06d1e3770a2b81c3470b9e6137e81b40a', 'konghucu', 'kamron67@example.com', 0, 'tmp//bb4ad883ead456bd7211d390ba96fda3.jpg', NULL, NULL, '872-446-3268', '898 Pansy Grove Marcoview, ID 86792-6245', '1', 'Sed praesentium cumque quisquam nesciunt velit et molestiae. Autem qui error sapiente id maiores enim. Voluptatibus harum quo repellat quo sed sed.'),
(12, 1, 0, 1, 1, 52, 'Trudie', 'Gerlach', 'Laki-laki', NULL, 'reyes74', '8f71b1d2c199ffda748d368d58e578c7e35d436a', 'islam', 'howell.chaya@example.com', 0, 'tmp//d670a37a226c716b1a1c684c3686000f.jpg', 'a', NULL, '1-276-435-9103', '6849 Larissa Knoll Suite 868 Jannieburgh, HI 51665-4430', '1', 'Qui ea et pariatur ea enim illo. At facere sit ipsam autem reiciendis in. Veniam aut hic non in vel.'),
(13, 1, 0, 1, 1, 54, 'Izabella', 'Schmidt', 'Laki-laki', NULL, 'crooks.fritz', '4c99e6c2171fe3a1462663720d340af9503ef4f3', 'kristen', 'willie72@example.com', 0, 'tmp//a925f6ab9573b3ce5f043edd6239ef20.jpg', 'b', NULL, '1-334-146-0072', '5091 Einar Causeway Suite 165 Wainoland, NE 06708', '1', 'Cumque in at sapiente minima vel sapiente. Ad corporis voluptatem ut animi. Ut minima impedit reprehenderit dolorum dolor et harum est.'),
(14, 1, 0, 1, 1, 58, 'Guadalupe', 'Orn', 'Perempuan', NULL, 'xzulauf', '70d0aa8285a282c7b251c3813f2fddb87b150f6c', 'kristen', 'yvette13@example.org', 0, 'tmp//46f583a1a2dcf3b63ffac548d02d20f1.jpg', NULL, NULL, '+20(7)5881288361', '21645 Hane Station New Buster, ND 97672', '1', 'Labore sunt quidem corrupti enim nesciunt. Voluptas autem repudiandae distinctio asperiores et perferendis. Repellat ab est eaque excepturi odio maxime provident. Eaque aut ut eos alias.'),
(15, 1, 0, 1, 1, 60, 'Savannah', 'Pfannerstill', 'Laki-laki', NULL, 'tchristiansen', '35c7b3bbd2688f9c29499795e8b24e092eae6132', 'kristen', 'bernhard45@example.com', 0, 'tmp//e323c2dfdb25789c044f80c803002572.jpg', 'b', NULL, '991278584', '182 Rose Trail Suite 818 Marinahaven, CO 75392-6357', '1', 'Non cupiditate fuga veniam. Voluptates ut quis autem in fugiat nemo enim. Distinctio voluptatem vero enim animi possimus et.'),
(16, 1, 0, 1, 1, 62, 'Oscar', 'Stehr', 'Laki-laki', NULL, 'powlowski.korey', '5c83f10d3da20e5bf8c8d14c2f9c499a3da58dca', 'katholik', 'carmen96@example.net', 0, 'tmp//d20e63988f32c0221639d572689dcd4a.jpg', 'ab', NULL, '(249)159-6429', '0916 Alyson Junction West Harley, UT 43822', '1', 'Asperiores assumenda laboriosam tempore corporis quia nihil. Doloribus voluptatem et sit omnis. A dolor at error pariatur. Sequi est et dolor repellat quia.'),
(17, 1, 0, 1, 1, 64, 'Izabella', 'Parisian', 'Perempuan', NULL, 'eleanora89', '2e4a08821aada9291e9484516c9531ad9b11b648', 'konghucu', 'gerda12@example.com', 0, 'tmp//914a7b112617517c5ebdc3370274ba69.jpg', 'o', NULL, '354558932', '737 Hudson Canyon Apt. 058 Baumbachland, UT 53383', '1', 'Quo earum magni consequuntur voluptatem. In qui maxime aperiam et ut. Rem deserunt odio aut excepturi consectetur aut.'),
(18, 1, 0, 1, 1, 70, 'Alexandrea', 'Mosciski', 'Perempuan', NULL, 'wmills', '96cbae4ba80125bc739e61f1994e19eea406f0ea', 'konghucu', 'ekulas@example.com', 0, 'tmp//50befa15c98c252a2e1dd2bcb50f0a78.jpg', NULL, NULL, '6741080428', '708 Richmond Mews West Alessandroton, NH 32783', '1', 'Eveniet inventore qui rerum omnis. Quibusdam facere possimus atque sit laboriosam enim. A suscipit numquam fuga tenetur dolor. Voluptas odio aliquid consequuntur quam.'),
(19, 1, 0, 1, 1, 73, 'Damion', 'Davis', 'Perempuan', NULL, 'ariane.schulist', 'a363db3b0533f6e473c9f44095a427655fe6edbf', 'konghucu', 'mboehm@example.com', 0, 'tmp//393af76655672f5590d25c714b479e29.jpg', 'ab', NULL, '1-252-674-9635x226', '75115 Rau Junctions Sengerhaven, NV 27007-3248', '1', 'Consequatur esse vel facilis maxime nisi. Eos tenetur sapiente ea quo. Nemo ipsam reprehenderit quaerat consequatur.'),
(20, 1, 0, 1, 1, 75, 'Burdette', 'Murphy', 'Perempuan', NULL, 'yazmin.ruecker', '5f5b6074b09ce7954e33be1ffa5cf67b9e7364d8', 'buddha', 'nlemke@example.com', 0, 'tmp//619e0f4a83a0b2c3cb5352e028286fb1.jpg', 'o', NULL, '7654229082', '5859 Collins Causeway Suite 842 South Evanshaven, ND 35538', '1', 'Sit explicabo omnis excepturi modi asperiores voluptatem. Aliquid non rerum cumque est. Cumque eum quo reiciendis minima quibusdam explicabo. Omnis nisi natus fugit omnis.'),
(21, 1, 0, 1, 1, 76, 'Gustave', 'Toy', 'Perempuan', NULL, 'bbechtelar', '0b02e2bcb97d0ad8b963cda4af77fd5ad9edaca3', 'katholik', 'shakira27@example.net', 0, 'tmp//8538c631b16d8f874ccbe82850b436eb.jpg', 'a', NULL, '1-078-171-2509x85539', '701 Gardner Forks Lake Hankfort, MO 55880-4799', '1', 'Beatae aliquam quo enim omnis natus ipsum. Fuga ipsa porro deleniti. Alias et cum ex tempore possimus. Rerum iusto aut fugit totam.'),
(22, 2, 0, 1, 1, 80, 'Leonard', 'Gerhold', 'Perempuan', NULL, 'myah37', '4473432a89fb25a49404e2cf9ded30ab4f6bc4db', 'konghucu', 'rubye97@example.org', 0, 'tmp//463c5a46198a5a4a1cf61dad217e88bc.jpg', 'b', NULL, '+47(6)2868941917', '6881 Wunsch Island Suite 700 West Lurline, OH 96248', '1', 'Quia laudantium aut architecto voluptas consectetur iure aut odit. Esse aspernatur dolorum qui error ratione dolores voluptate.'),
(23, 2, 0, 1, 2, 0, 'Dennis', 'Maggio', 'Laki-laki', '0000-00-00', 'osinski.gwendoly', '0df21a268baf4278d1045d279017de0734a28437', 'konghucu', 'sophie44@example.org', 0, 'tmp//4cca3be62c22e099d50d51bdefb875a0.jpg', 'ab', '', '(772)694-3622x00197', '894 Eliza Ridge\r\nWest Eldred, NC 94050-2424', '1', 'At cupiditate animi quaerat qui. Eius in beatae aperiam eos. Nulla dolorum ipsam quia aut repudiandae. Culpa at rerum odit ab veritatis.'),
(24, 3, 0, 1, 1, 82, 'Concepcion', 'Bins', 'Laki-laki', NULL, 'kmclaughlin', '5ce4f6afa04eb7cb1cd814aececa7dca222150ff', 'hindu', 'gorczany.josh@example.com', 0, 'tmp//4004b91d5c26dbd3079cb938c7559d72.jpg', 'o', NULL, '1-022-903-7435x40047', '54004 Kirlin Greens New Anastasiatown, WY 99939', '1', 'Ut omnis hic vel deserunt ducimus culpa et ratione. Consequuntur iste ducimus nesciunt voluptatem. Tenetur animi quidem velit id eligendi. Cum qui aut voluptatem quia quas earum.'),
(25, 2, 1, 1, 4, 0, 'Dawson', 'Gerlach', 'Perempuan', '0000-00-00', 'leuschke.constan', '8f30827d3f1d3e57eeec6303f712ba8ce5a33fc1', 'budda', 'ischiller@example.com', 0, 'tmp//8d45f6b774f8676f79854982be43c73d.jpg', 'b', '', '443-604-3760x7204', '424 Prosacco Roads Apt. 594\r\nWest Vena, IA 04021-9280', '1', 'Quis nihil a inventore quis quia. Quo cum harum expedita quo. Non eligendi blanditiis in voluptatem voluptate et sed.'),
(26, 1, 1, 1, 1, 91, 'Krystel', 'Robel', 'Perempuan', NULL, 'floy19', 'f2122e13c932b514efed8f2b0e4f383765ee56c0', 'budda', 'lavon.kiehn@example.com', 0, 'tmp//cd95c9f3ad57e0ad65fe618981868117.jpg', 'o', NULL, '(734)811-3853x015', '775 Marcella Turnpike Maeview, CA 39576-7115', '1', 'Sint in nisi mollitia sint aut et mollitia. Et id consectetur eum voluptatum numquam consequatur. Quas iste excepturi a ea. Nemo amet qui voluptatem recusandae et.'),
(27, 2, 0, 1, 1, 94, 'Dee', 'Abbott', 'Laki-laki', NULL, 'christine.moore', '0f65af079fe9a13ed8b827235be62d73adc58486', 'kristen', 'ullrich.scarlett@example.com', 0, 'tmp//26a8c5158373caa33facbe21abdb999b.jpg', 'b', NULL, '1-338-236-4642', '61777 Norene Parkway Suite 119 Lazarohaven, VT 40702', '1', 'Quo vel et atque doloribus. Facere et magnam recusandae debitis.'),
(28, 2, 0, 1, 3, 0, 'Vesta', 'Ebert', 'Laki-laki', '0000-00-00', 'ali.cormier', 'bb181ba1b9c89851bbb99ef2615b1d300436c16f', 'katholik', 'harber.tyshawn@example.com', 0, 'tmp//1c2d93e04f1e55155d30a5073c9ac4c5.jpg', 'ab', '', '1-809-594-5107', '519 Kacey Creek Suite 626\r\nHyattburgh, WY 71503', '1', 'Numquam et ullam est et. Quam rerum mollitia nihil distinctio.'),
(29, 1, 1, 1, 4, 0, 'Ola', 'Wyman', 'Laki-laki', '0000-00-00', 'kennith.rath', '89c9827671d15d5d41c3f05e1c76343ed9a0fd8d', 'islam', 'julia13@example.org', 0, 'tmp//2ed83790e09faa38a841e985e4eddcdf.jpg', 'ab', '', '918.562.6265x9591', '308 Morar Cliffs Apt. 992\r\nTamaratown, KY 32634', '1', 'Aspernatur est sunt doloribus quasi. Nobis beatae sed rerum voluptas impedit aliquam debitis consectetur. Voluptate eveniet autem dolor enim. Est id tempore ipsum. Voluptas aut amet minus similique'),
(30, 2, 0, 1, 2, 0, 'Bobbie', 'O\'Kon', 'Laki-laki', '0000-00-00', 'koss.melyna', 'ea236da1580ef013d8d483b9832b6ea3f3b57853', 'konghucu', 'wisozk.jasen@example.com', 0, 'tmp//807916a98abe5abdb3693921abfc8eae.jpg', 'a', '', '1-791-343-0739x7746', '41544 Windler Coves\r\nEast Henderson, MN 64250', '1', 'Cupiditate quod qui consectetur nihil aperiam voluptatem molestiae. Facilis aut quos debitis earum velit. Repellat accusantium soluta reprehenderit ut.'),
(31, 3, 1, 1, 4, 0, 'Beulah', 'Jast', 'Laki-laki', '0000-00-00', 'ruby.gulgowski', '97493d6cdd00a2e10d2819ea90f088c17c80df2b', 'hindu', 'mpowlowski@example.org', 0, 'tmp//01972a8109a77c7b62c555380866546c.jpg', 'b', '', '983.603.0136x3525', '28148 Angie Trail\r\nSouth Gabriel, WY 69863', '1', 'Blanditiis debitis repellendus adipisci soluta occaecati illum. Hic porro quia dolorum maxime eos tempora.'),
(32, 1, 1, 1, 4, 0, 'Roberta', 'Zboncak', 'Laki-laki', '0000-00-00', 'dawn50', 'fb7b2bbc440068aa07a945f0bd64860783d33e04', 'kristen', 'mallory38@example.org', 0, 'tmp//34d51eddfdde2438c61b35958a660b3b.jpg', 'b', '', '945.376.7830', '9545 O\'Connell Branch\r\nAlexandreaport, TX 50847', '1', 'Ut placeat voluptatem totam velit. Incidunt vel qui eos.'),
(33, 1, 1, 1, 3, 0, 'River', 'Price', 'Laki-laki', '0000-00-00', 'vonrueden.gregor', '68d7309a0b21637c1446fb79e9a979b6f58bcbd8', 'hindu', 'o\'conner.hilario@example.net', 0, 'tmp//57659336743c1b0117d2271b6c6dbf1f.jpg', 'b', '', '(295)695-0717x38707', '18056 Filiberto Junctions\r\nWest Gunnarberg, SC 45720-9408', '1', 'Est corrupti mollitia et quisquam non. Reiciendis nisi consequatur nisi vel ducimus necessitatibus impedit. Eos labore soluta a.'),
(34, 3, 1, 1, 2, 0, 'Morris', 'Bins', 'Perempuan', '0000-00-00', 'kparker', '0fe79b49e31b1b675b237d1344ec9e7fa171835b', 'hindu', 'weber.hollis@example.com', 0, 'tmp//0c680fc8caf94911d423f4afb3862469.jpg', 'ab', '', '064-708-6688', '2697 Haag Meadow\r\nWindlertown, WV 35174', '1', 'Et consequatur exercitationem aut et non dolorem. Et id deleniti sit maxime reprehenderit asperiores hic. Odio odio magnam enim eum libero. Consequatur eos reprehenderit delectus perferendis quidem'),
(35, 3, 1, 1, 2, 0, 'Rosina', 'Mertz', 'Laki-laki', '0000-00-00', 'lonzo.conroy', 'b2afe30a2b0b4c09797b59298675770c4da3e46e', 'konghucu', 'jimmy21@example.net', 0, 'tmp//8afc7cd7c7097c1d54cf47d0ccd7e5e9.jpg', 'ab', '', '+35(9)1535087533', '45732 Hoppe Club Apt. 522\r\nNorth Julio, IA 63468', '1', 'In commodi molestias eos iure distinctio nesciunt ratione. Voluptatem quaerat in autem et consequatur alias quam blanditiis. Atque voluptatum doloribus minima adipisci voluptatem in eos rerum.'),
(36, 1, 0, 1, 4, 0, 'Filomena', 'Russel', 'Perempuan', '0000-00-00', 'qhowell', '4b9166d15fbd97696ce4b6be4d08bc4a44774a9b', 'budda', 'ypurdy@example.net', 0, 'tmp//43c6791418d4ef628c78e76d967a1e15.jpg', 'b', '', '384-461-1789x49450', '727 Bo Motorway\r\nKathlynview, ME 94561', '1', 'Et at dicta quo. Velit nemo sint rerum et in et deleniti ex. Possimus nisi nihil animi corporis voluptatum delectus inventore.'),
(37, 1, 1, 1, 3, 0, 'Clarabelle', 'Doyle', 'Laki-laki', '0000-00-00', 'johnathan61', '0f8e4c73b8bed115ed9e0db8554068fd34f5c4ee', 'budda', 'keven05@example.org', 0, 'tmp//70fee78ef870bc36241697302bd892ce.jpg', 'ab', '', '339.842.4786x72097', '78548 Metz Ridges\r\nSouth Jeff, CA 95702-8039', '1', 'Expedita rerum qui qui voluptatem deleniti. Quia quidem et optio illum. Quia quidem mollitia quo.'),
(38, 2, 1, 1, 4, 0, 'Cathryn', 'Moen', 'Laki-laki', '0000-00-00', 'davon.smith', '0c8fee95bc07f2cfef467aadfcf7c9985cde0bc8', 'hindu', 'pouros.mireya@example.com', 0, 'tmp//4c54325aa3f68147b1e806160b1295aa.jpg', 'ab', '', '270.722.2115x872', '1776 Aurelie Junctions Apt. 155\r\nGardnerville, ME 83614', '1', 'Ut ut laboriosam necessitatibus delectus voluptas. Deleniti illum est sed. Quidem nesciunt repudiandae maxime rerum veritatis aliquid est. Cupiditate quis inventore libero adipisci et et voluptatem'),
(39, 1, 1, 1, 2, 0, 'Gianni', 'Hamill', 'Perempuan', '0000-00-00', 'abshire.dagmar', 'aceef3f81b2e1996e87d6e5893f518637950b4c0', 'hindu', 'cortez.pfeffer@example.org', 0, 'tmp//6663199aa7a74810ef5ef920350e496c.jpg', 'o', '', '(602)969-1586x47582', '28684 Yundt Motorway Apt. 244\r\nJamaalberg, NH 22751-3241', '1', 'Eos possimus neque necessitatibus animi quae sit qui. Pariatur iste deleniti harum expedita iusto. Est molestiae minima veritatis quos ut.'),
(40, 1, 1, 1, 4, 0, 'Mac', 'Dooley', 'Laki-laki', '0000-00-00', 'mbotsford', 'e3b6bba43132c563d2ba7c45d969a220d5d765f6', 'islam', 'herminia.towne@example.net', 0, 'tmp//baa586d36b4c599b2a9ef2b6c3591906.jpg', 'b', '', '7735747152', '2193 Lakin Glens\r\nNorth Brandyn, WV 03653', '1', 'Aliquid aliquam necessitatibus at esse sed. Quibusdam inventore aspernatur vel dolorem dolore in sed. Dolorum ut nihil dolorem aperiam.'),
(41, 2, 1, 1, 2, 0, 'Mellie', 'Purdy', 'Perempuan', '0000-00-00', 'tbuckridge', '32dfeb5ca247d949eed023b51dd62cf862bff9cf', 'konghucu', 'gbartoletti@example.net', 0, 'tmp//1d40367dc2f984843c847c5ea8f7cc4a.jpg', 'a', '', '(211)988-9461x932', '7061 Julien Mall Apt. 633\r\nNew Rosaleestad, WA 81371', '1', 'Est et inventore qui dolorem numquam error nesciunt corrupti. Et nobis eos quia non facilis. Voluptates sunt incidunt labore magnam reiciendis molestiae.'),
(42, 3, 0, 1, 3, 0, 'Myron', 'Schaefer', 'Laki-laki', '0000-00-00', 'gorczany.kenna', '61f0e5e421265188b9e4bb5f11dc0fc47118640d', 'budda', 'hlang@example.com', 0, 'tmp//a33fa455e9be79af34d19ed02a3931c8.jpg', 'ab', '', '(914)575-2607', '014 Durgan Springs Apt. 483\r\nChamplinhaven, WV 88447-3640', '1', 'Voluptatem accusantium dolore eaque delectus molestiae eos quis. Laudantium eos possimus et quos qui dolores omnis quis. Libero provident officia atque consequatur pariatur aperiam officiis.'),
(43, 3, 1, 1, 4, 0, 'Violet', 'Waelchi', 'Laki-laki', '0000-00-00', 'ykoch', '87884ec8ef5064d124f372f2470b60ab86ea0d12', 'islam', 'gaetano48@example.net', 0, 'tmp//27e74b079a11acbff1a45f6f0cfa72f0.jpg', 'a', '', '987.642.4961x6324', '196 Christiansen Ports Apt. 544\r\nLake Zechariah, VT 52664', '1', 'Nesciunt ipsam qui qui id sit delectus ab omnis. Atque totam quis quibusdam. Adipisci qui aut est maxime.'),
(44, 2, 1, 1, 1, 95, 'Alice', 'Hand', 'Perempuan', NULL, 'larson.creola', '61fd24dbb1823d94145a3023097af56244dead6b', 'kristen', 'walsh.pearlie@example.org', 0, 'tmp//c9c4d779b64867304ccf2b26523d5c31.jpg', 'ab', NULL, '(107)804-7166', '39590 Zelma Views West Anneberg, IL 86307-9429', '1', 'At et suscipit at aliquid qui quia. Qui mollitia ut occaecati voluptatem optio aut architecto. Molestiae et omnis quos reprehenderit sunt eos. In hic omnis repudiandae. Sequi rerum minus et sit iur'),
(45, 3, 1, 1, 3, 0, 'Queenie', 'Dare', 'Perempuan', '0000-00-00', 'ubraun', '06740159b88ca02af7e98707eec096ce022fd2bd', 'konghucu', 'qhowell@example.com', 0, 'tmp//4cc9ac66fb57194269329633f9733a8c.jpg', 'a', '', '(277)668-0913', '150 Destinee Park\r\nAbagailtown, TX 82605-7785', '1', 'Temporibus suscipit aspernatur et praesentium corrupti sint id et. Nihil error et et cum. Voluptates eveniet tenetur impedit sapiente. Nisi cumque sed voluptatem consequatur. Possimus quam repellen'),
(46, 1, 0, 1, 3, 0, 'Brenden', 'Swaniawski', 'Laki-laki', '0000-00-00', 'kailyn.shanahan', '21915eadf695b3f7142e456c78ffe0e4760748b7', 'katholik', 'corkery.llewellyn@example.org', 0, 'tmp//eb669dac724a9674ee420400b51d91ea.jpg', 'o', '', '738.358.7331x0550', '707 Miguel Mountain\r\nSouth Clotildebury, MT 28756', '1', 'Tempora ullam doloremque blanditiis nulla. Esse asperiores voluptatem et enim cum at. Delectus nisi voluptatibus sit qui aut. Voluptatem nihil facere est magnam sed.'),
(47, 2, 1, 1, 2, 0, 'Maximus', 'Kreiger', 'Perempuan', '0000-00-00', 'okuneva.braden', '2ca66a8abe85cd7f263ac31112cb8e080a225939', 'katholik', 'kuhlman.hollis@example.com', 0, 'tmp//b4c3dfb440898fd948bf3fa51f477684.jpg', 'a', '', '1-161-987-6381x320', '2016 Schultz Ways Suite 118\r\nO\'Haratown, NC 42649', '1', 'Pariatur nobis et quisquam ullam possimus earum ratione. Nemo deleniti ullam qui voluptate. Aut et ut sit non.'),
(48, 3, 1, 1, 4, 0, 'Gerald', 'Feil', 'Laki-laki', '0000-00-00', 'imante', '11111', 'hindu', 'dkoss@example.net', 0, 'tmp//2236b84b9ac61a0d908e2a5b3f8dc01a.jpg', 'b', '', '567-662-5114x7908', '709 Porter Route\r\nElsieberg, KS 69757', '1', 'Cumque id aliquid ab esse odio officiis quis. Pariatur aperiam dolores vitae voluptatem ipsam enim. Sint maxime nesciunt beatae ipsum.'),
(49, 1, 0, 1, 3, 0, 'Shaniya', 'Schmeler', 'Laki-laki', '0000-00-00', 'maximo26', 'bbe536688037fcc4002a41538c1e90c158090ab1', 'konghucu', 'shana.lynch@example.com', 0, 'tmp//febe89fe95cfdbcfa515bf7766661f0b.jpg', 'ab', '', '1-609-841-4199', '161 Stevie Corners\r\nLake Bridgetport, IA 38827-2489', '1', 'Nostrum error eum libero eos repellat reprehenderit. Eveniet sit soluta harum pariatur expedita minus iusto. Atque harum impedit quo consequatur veritatis impedit.'),
(50, 3, 0, 1, 4, 0, 'Maxwell', 'Swift', 'Perempuan', '0000-00-00', 'vbailey', '5573e33ccbe25e49fd7df58fffd484192ec9bc60', 'kristen', 'cecelia42@example.net', 0, 'tmp//33461cb007d11c382e1873fe2f336116.jpg', 'a', '', '381.499.8037x4064', '590 Brekke Curve Suite 529\r\nChaddstad, MT 21354', '1', 'Modi inventore itaque nemo blanditiis quas quibusdam molestiae. Deserunt perferendis aliquid doloremque rerum. Nobis quam voluptatem occaecati nisi natus veniam. Nobis reiciendis in libero. Quae re'),
(51, 3, 1, 1, 3, 0, 'Don', 'Dibbert', 'Perempuan', '0000-00-00', 'mills.verda', '25f4da2de420249e20aa84dcb3b35b65b96b1db6', 'hindu', 'jarred07@example.org', 0, 'tmp//64bec61a40f7051796428d9159910f97.jpg', 'ab', '', '(577)154-0711', '339 Shyanne Flat Suite 962\r\nJalynhaven, AR 86445-0491', '1', 'Ex ipsam earum praesentium itaque voluptatum. Sunt perspiciatis magnam a sit nobis non voluptatem assumenda. Tempora sunt labore sit ea.'),
(52, 2, 1, 1, 4, 0, 'Osborne', 'Denesik', 'Perempuan', '0000-00-00', 'florian.lubowitz', '70e94d373c8f2b38afacec458732a1e9f7c9c746', 'hindu', 'otowne@example.com', 0, 'tmp//3b45832d7ec3311516d0d7afe0d1cf95.jpg', 'o', '', '(441)161-7605x73161', '18149 McClure Centers Apt. 622\r\nSouth Codychester, MO 12219', '1', 'Quas praesentium tempore animi rerum non perferendis qui velit. Est voluptatum at doloribus nihil. Tempore qui impedit nam sapiente porro.'),
(53, 1, 1, 1, 3, 0, 'Antwon', 'Turner', 'Perempuan', '0000-00-00', 'raphaelle.kuhic', '09e30007e42a6c2ff00fdaf1cb78f52d79596ed8', 'konghucu', 'johnathan16@example.net', 0, 'tmp//f135e282fd90129956992418432ea016.jpg', 'b', '', '639437654', '50966 Oberbrunner Plains Suite 675\r\nKshlerinside, KY 67435-5414', '1', 'Est nostrum deserunt a fugit. Aspernatur corporis quidem exercitationem eligendi. Ex culpa eligendi nihil quaerat voluptatem consequatur.'),
(54, 3, 0, 1, 4, 0, 'Pattie', 'Dietrich', 'Perempuan', '0000-00-00', 'rauer', '0578e6d96afec7098e0a2708f6ca395e472f66c5', 'islam', 'morar.leonie@example.org', 0, 'tmp//d8c32f185d367714f664ce46ec8375e7.jpg', 'a', '', '185-166-6647', '5321 Jensen Walks\r\nLake Keshaunland, IL 64922', '1', 'Perferendis dolore voluptatibus error earum sed ut alias. Sunt nisi sed sed harum dolorem qui. Expedita est hic et ut nihil nihil adipisci.'),
(55, 1, 0, 1, 1, 98, 'Margarete', 'Abshire', 'Laki-laki', NULL, 'koelpin.shany', '09025d5bee3e95f46b0804baab7e371cc9fd436a', 'islam', 'epowlowski@example.org', 0, 'tmp//a6b2dc667502a89370d60573e6a45924.jpg', 'b', NULL, '(889)557-7513x70590', '42509 Kaycee Glens West Madaline, TN 22033', '1', 'Quos dolorem aut nihil et quasi deleniti excepturi voluptatem. Dolores deserunt quas aperiam odio temporibus. Voluptatem doloribus itaque dolor deleniti voluptate accusantium non provident. Unde ex'),
(56, 3, 0, 1, 2, 0, 'Golda', 'Fritsch', 'Perempuan', '0000-00-00', 'thiel.kallie', 'df135fa95f4772994785b26b10ecdd62a4ec35ff', 'hindu', 'zoila.kuhic@example.com', 0, 'tmp//1959abac9ef52305f376b01c21fc6625.jpg', 'ab', '', '3694579473', '11592 Elton Inlet\r\nLake Robb, KY 67888', '1', 'Quis inventore non id quae nesciunt blanditiis corrupti. Quibusdam omnis soluta tenetur. Pariatur est a sed quos non sunt impedit.'),
(57, 2, 1, 1, 2, 0, 'Yesenia', 'Ratke', 'Laki-laki', '0000-00-00', 'dahlia.kuphal', '34a5785e5a913ba73758753800098ea7d0984c7b', 'budda', 'schulist.leslie@example.net', 0, 'tmp//20760e71df6a7fa1b71faca573231302.jpg', 'o', '', '5381836391', '1701 Ashlee Unions\r\nCamilamouth, ND 94638', '1', 'Sunt maiores ex cumque qui eaque. Repellat ut ut et voluptas a. Voluptas veniam ipsa ipsum non.'),
(58, 1, 0, 1, 4, 0, 'Joseph', 'Mosciski', 'Perempuan', '0000-00-00', 'hackett.nestor', '47c41c88ac2fa6c85582ac3a9d99cfebb82b0f22', 'kristen', 'jacobs.giovani@example.com', 0, 'tmp//1b428d706c03bbd37728cd9fa41a6987.jpg', 'a', '', '(359)377-0828', '35521 Hoppe Stream\r\nNew Sammieborough, KY 15342-5117', '1', 'Perspiciatis totam quia quo recusandae voluptatum ad. Minima reprehenderit corrupti dolore voluptas illo numquam. Aut possimus sit voluptatibus voluptatibus.'),
(59, 2, 1, 1, 2, 0, 'Aurore', 'Watsica', 'Perempuan', '0000-00-00', 'xpagac', '6a4d9f439f23c0ee5fe517ad8dc2abf68d49800c', 'kristen', 'braulio08@example.com', 0, 'tmp//e4de5133ac50a7930d9de367c36335d1.jpg', 'ab', '', '199-288-6890', '7812 Nadia Plains Apt. 279\r\nBlickville, MN 53433', '1', 'Illum rerum illo neque voluptatum iure deserunt sequi. Voluptates sequi voluptas officiis inventore distinctio voluptas. Qui rerum voluptatibus similique sed laborum in vel. Laudantium impedit dolo'),
(60, 3, 0, 1, 4, 0, 'Carroll', 'Metz', 'Perempuan', '0000-00-00', 'aimee.lehner', '3716044cf6a2cf441d1b96b5fb6643a943926628', 'katholik', 'wisoky.sonya@example.org', 0, 'tmp//2434dcf2c15b68a5d15a0ee4517e7fb7.jpg', 'a', '', '(508)181-7365x0413', '541 Bahringer Cliff Apt. 444\r\nLauramouth, DC 87038-7542', '1', 'Esse mollitia adipisci ut ullam dolores dolorem nemo numquam. Vel atque modi quod. Animi qui laboriosam molestiae asperiores et aut voluptas.'),
(61, 2, 1, 1, 1, 100, 'Letha', 'Kuhn', 'Perempuan', NULL, 'wkassulke', '4db1e8d8a6aa3a925e8ab7421fa82c58b83d287e', 'kristen', 'lauriane14@example.net', 0, 'tmp//0ad0cdba3a0377f1469bd2bb506c35a2.jpg', 'a', NULL, '1-460-588-3379', '80930 Lulu Unions Suite 023 Klingmouth, GA 51413-0744', '1', 'Magni animi excepturi explicabo reprehenderit eum velit accusantium. Provident rerum doloremque accusantium velit ut minus totam. Molestias nemo id quidem impedit nihil ullam debitis qui. Quia qui'),
(62, 3, 0, 1, 4, 0, 'Easton', 'Ebert', 'Laki-laki', '0000-00-00', 'leilani33', '93d2b2a89022602de886b685fff54356af32e9ba', 'islam', 'gay.frami@example.org', 0, 'tmp//bdc4524c64200ec1af6ce553df263109.jpg', 'b', '', '(461)402-5241', '366 Thiel Trace\r\nHackettmouth, NY 90937-7372', '1', 'Neque praesentium inventore atque autem ut ut. Atque ex qui error omnis odio aperiam. Voluptatum rerum aut vero quod est.'),
(63, 3, 0, 1, 2, 0, 'Beau', 'Moen', 'Perempuan', '0000-00-00', 'buckridge.declan', 'cd05bc5adb541cc78e3d7924d48fcdedba21d901', 'hindu', 'pollich.rey@example.net', 0, 'tmp//e4d4d2d7ffb38208fc096e4c6a638bcf.jpg', 'b', '', '1-524-411-3437x376', '798 Mills Port Suite 922\r\nSchmittbury, MA 30341-3273', '1', 'Illo inventore libero ut ut qui non illo ab. Maxime iste quidem rerum optio et hic. Optio eos quibusdam et facere veritatis.'),
(64, 3, 1, 1, 4, 0, 'Jordy', 'Sporer', 'Laki-laki', '0000-00-00', 'emmett.reynolds', '5e15b4d8cd2c4de1eefad75e7e3389a66ee73a8e', 'katholik', 'abner.emard@example.net', 0, 'tmp//8b1330db95da9bb8f2de84888fa33e5c.jpg', 'ab', '', '1-183-035-1507x03759', '970 Gulgowski Field Apt. 724\r\nNorth Masonmouth, MA 41865-8673', '1', 'Expedita qui eum quia earum. Provident architecto quo modi enim veritatis reprehenderit at. Expedita dolor consequatur aperiam veritatis consequuntur repudiandae nihil.'),
(65, 2, 0, 1, 3, 0, 'Lela', 'Wintheiser', 'Perempuan', '0000-00-00', 'susan.baumbach', 'e41170445999fa21eec0805c72f919870aaad07d', 'konghucu', 'harris.keaton@example.net', 0, 'tmp//5f9994fe9cc1e9c65c241ac5f030b729.jpg', 'a', '', '(337)020-3611', '4461 Yundt Mountains Suite 793\r\nLake Alta, DC 12610', '1', 'Autem qui dolorem quia. Et eum accusantium omnis dignissimos quibusdam amet iste. Nobis quia in quia ducimus pariatur atque sunt. Quos et est saepe dolorem rerum.'),
(66, 2, 1, 1, 3, 0, 'Orrin', 'O\'Kon', 'Perempuan', '0000-00-00', 'bailey.braulio', '90093a89bfb20cedf22f83c991e430f7bc218290', 'katholik', 'blake83@example.org', 0, 'tmp//dad17fff0c5c228d43bdae7452a96b14.jpg', 'a', '', '058-663-3142x6095', '237 Rippin Inlet\r\nNorth Vance, OH 93334-7482', '1', 'Cupiditate autem ad sint debitis repudiandae. Minus dolorem mollitia nobis necessitatibus repellat consequatur temporibus. Velit ea in et quia id eius magni. Architecto iste rerum dolor eos qui.'),
(67, 3, 1, 1, 2, 0, 'Edd', 'Daugherty', 'Perempuan', '0000-00-00', 'po\'conner', 'bfd567fe34019296bd985500be01ce7a76b2e20e', 'islam', 'sledner@example.net', 0, 'tmp//16704d91de43525cae0729afe6cf6f3b.jpg', 'o', '', '311-179-2331x6974', '347 Bessie Inlet Apt. 559\r\nAricchester, PA 30274-0796', '1', 'Reprehenderit ex ut sed non earum quo. Nihil fugit dolores magnam in et. Nihil consectetur ab unde fuga veritatis modi minus. Facere totam quia aut qui omnis natus quos.'),
(68, 1, 0, 1, 3, 0, 'Telly', 'Kuhic', 'Laki-laki', '0000-00-00', 'langosh.lia', 'f3f0c8d0fb3a1c3dce2cdd9a92100c83989ec701', 'kristen', 'smann@example.org', 0, 'tmp//f8c412bfa9b8121d948ad14623818ee4.jpg', 'a', '', '1-883-940-0806x90837', '25049 Dandre Village\r\nMireilleton, NM 12627-4856', '1', 'Autem tenetur et dolor doloribus pariatur at dicta. Nisi aut voluptatem nesciunt necessitatibus iure ut. Qui est autem deserunt ut ad modi esse dignissimos.'),
(69, 1, 0, 1, 2, 0, 'Kelly', 'Paucek', 'Laki-laki', '0000-00-00', 'bessie.botsford', 'db0a870d55c105171be41db7c7f2f49943e1f3ff', 'hindu', 'tremaine75@example.net', 0, 'tmp//ecbea3a8352c0fc08af98e2a061f2b5e.jpg', 'b', '', '197.525.9331x346', '32560 Dallas Plaza\r\nLake Sylvia, NY 04448', '1', 'Voluptatibus eligendi ea est temporibus et hic vel. Ipsum minus quia dolorum ullam qui.'),
(70, 1, 0, 1, 4, 0, 'Keanu', 'Kautzer', 'Perempuan', '0000-00-00', 'heathcote.shanie', '8176d3d4e4ac2cd617c4d8fe9a8cdc2f870d37a7', 'budda', 'hirthe.melyna@example.org', 0, 'tmp//79d02ec90b147823188a662b40f91f10.jpg', 'ab', '', '(607)404-6714', '84372 Kub Flats\r\nLake Richardhaven, NY 80438-5419', '1', 'Est eaque aut sapiente facilis repellendus earum dolore. Id iure voluptas quia non. Amet dolor dignissimos ratione sed modi sint rerum.'),
(71, 1, 0, 1, 2, 0, 'Katrina', 'Jacobi', 'Perempuan', '0000-00-00', 'varmstrong', '6610ba30f18c2c0b96d0042efc34ee2a89396628', 'katholik', 'selena.wiegand@example.net', 0, 'tmp//e556d491c88b8aec46c9ce3956a15966.jpg', 'a', '', '+72(9)0625133850', '328 Schmitt Courts Apt. 998\r\nNorth Hortensetown, GA 52938', '1', 'Facilis quo corrupti sint nostrum atque aliquam itaque. Dolore sit a maxime facere aut dolorum et. Nihil illum nulla quia aut totam ut ea.'),
(72, 3, 0, 1, 2, 0, 'Esther', 'Ward', 'Perempuan', '0000-00-00', 'alexzander97', '10eda453d455f21a8aa176071dfa1e265c8f17e3', 'islam', 'mollie.lehner@example.net', 0, 'tmp//97be07b6934b121e56ac4ed8923457df.jpg', 'ab', '', '083-323-2085x884', '08083 Jena Brooks Suite 339\r\nBrennonton, KS 13646', '1', 'Sint illo velit tenetur eum. Numquam rerum recusandae asperiores amet fuga qui. Odio repellendus sequi itaque atque.'),
(73, 1, 0, 1, 4, 0, 'Tyrique', 'Schuppe', 'Laki-laki', '0000-00-00', 'jaida.botsford', '5d94a1e50a69c677fbafe22c16e80492dea3e3d9', 'hindu', 'jacklyn32@example.org', 0, 'tmp//7f8d446af5e58f25aa385423a265a609.jpg', 'b', '', '(424)589-5560', '093 Carolina Curve Suite 094\r\nTillmanmouth, KY 52554', '1', 'Porro architecto quibusdam qui officia et aperiam. Dolor dolorem officia qui ut expedita autem.'),
(74, 3, 1, 1, 2, 0, 'Hank', 'Schuppe', 'Laki-laki', '0000-00-00', 'ebert.alessandra', '7c7f329c08b6c0a457ce12ac57b5c647aadb774e', 'islam', 'valerie74@example.net', 0, 'tmp//9a3d3226fbd64149f9028c086ff9d532.jpg', 'o', '', '410.809.6965', '4545 Ethan Courts\r\nNolanberg, OH 25894', '1', 'Consectetur et ut porro qui. Itaque quod quasi ipsa fugiat eaque error voluptas. Veritatis animi dolorum dolorum maxime facere est. Eligendi sit eveniet nihil est ut blanditiis minima est.'),
(75, 3, 1, 1, 4, 0, 'Hellen', 'Kuhlman', 'Laki-laki', '0000-00-00', 'schneider.miller', 'e93726fc1b344f0113e7df814be635fa99883476', 'islam', 'renner.jennings@example.net', 0, 'tmp//fc8209a29d8ad484915b207be7c10e12.jpg', 'a', '', '734.883.3580', '857 Julian Forks\r\nKihnview, FL 80887-6395', '1', 'Quibusdam consequatur molestiae reprehenderit aut et. Aut molestiae nobis ipsum sapiente. Distinctio vel ut dignissimos sit officia. Quia iure at ab explicabo in omnis.'),
(76, 2, 1, 1, 4, 0, 'Melyssa', 'Larkin', 'Perempuan', '0000-00-00', 'ytremblay', '818aa238a9c3f914fe15570f1c0d4d5248dd45ba', 'konghucu', 'kyla08@example.com', 0, 'tmp//401aee91164effdb3b8c27ecdf632e17.jpg', 'a', '', '7284220161', '423 Weldon Meadow\r\nNorth Patienceshire, OH 40805', '1', 'Itaque possimus porro excepturi rem tempora magni. Qui harum asperiores exercitationem et omnis repellat placeat. Provident repudiandae corrupti laudantium veritatis at. Suscipit debitis et laborio'),
(77, 1, 0, 1, 1, 0, 'Alisha', 'Emard', 'Laki-laki', NULL, 'strosin.salma', '9282712bc233b19893eb52ad8e2f4381bae785ef', 'konghucu', 'june91@example.net', 0, 'tmp//9b17b0407e69d10b49b346d7129fe4c5.jpg', 'b', NULL, '906.050.3714x3323', '87882 Marquise Points Watersfort, IA 26172', '1', 'Voluptates possimus natus mollitia aut repellendus quasi et. Omnis perferendis id cupiditate qui illum reiciendis. Ullam nisi libero eaque consequatur soluta. Sit voluptatum non debitis fugiat volu'),
(78, 3, 0, 1, 3, 0, 'Shirley', 'Wolff', 'Laki-laki', '0000-00-00', 'aanderson', '3ed0de31de9d18edcce96797e94f891cf6114678', 'hindu', 'schmidt.tabitha@example.org', 0, 'tmp//a1f3efac0ce7badd16e93d2792ccdaa6.jpg', 'a', '', '394-952-7760x1067', '73565 Arnulfo Fort\r\nBeierland, NH 87661-2714', '1', 'Id ut dolore magni provident. Nemo mollitia quis omnis aut nesciunt alias. Rerum aliquid temporibus vero dolor. Enim soluta quasi illo.'),
(79, 2, 0, 1, 3, 0, 'Casimir', 'Prosacco', 'Laki-laki', '0000-00-00', 'rice.rod', 'ed6b4a90eb4e2f13b8806843eaef9675220c5679', 'katholik', 'jennie.jenkins@example.net', 0, 'tmp//1f5b95703de682359250d61120c9e598.jpg', 'b', '', '(840)639-7101x783', '652 Schmitt Valley\r\nSouth Anne, AK 97203-6971', '1', 'Dicta quo qui assumenda et. Illum impedit sequi in voluptatem recusandae deserunt incidunt. Et distinctio ut ut nobis dicta dolor.'),
(80, 2, 0, 1, 4, 0, 'Derek', 'Lehner', 'Perempuan', '0000-00-00', 'roberts.freeda', '9af0369731bac813f3d19d50b4a988471dbc08b6', 'katholik', 'mcclure.wilbert@example.org', 0, 'tmp//c680e98f015929b3276a62a04e1cdd18.jpg', 'ab', '', '1-214-742-1489x3453', '419 Myrna Dale Suite 300\r\nEast Lailaland, MD 22011-3262', '1', 'Corrupti et tenetur perferendis ipsum repellat quia. Vel illo porro sunt eos. Laboriosam ratione distinctio modi maiores id odit. Laudantium et nisi ipsum et rem culpa quia.'),
(81, 2, 0, 1, 1, 0, 'Noble', 'Bode', 'Laki-laki', NULL, 'demario.d\'amore', '7b7591ea97a5ed8409b7ca955990d03f86278756', 'kristen', 'lexi26@example.org', 0, 'tmp//3d4a94ac588237b95268d0b587c1aeb0.jpg', 'a', NULL, '806.032.7230', '0259 Shawn Gateway Noeliabury, ND 84093-5794', '1', 'In et illum asperiores iusto. Dolor ut velit eum a quo velit autem. Laudantium quo architecto necessitatibus ea dolorem maxime aut.'),
(82, 2, 0, 1, 4, 0, 'Lorenza', 'Flatley', 'Perempuan', '0000-00-00', 'romaguera.danika', '8a084488aa624da3a1dca533a4f063edd4a92727', 'kristen', 'elmira.stiedemann@example.org', 0, 'tmp//b333a5142511fad686954915024fa3f6.jpg', 'ab', '', '539-345-3226x2629', '3292 Greenfelder River Apt. 850\r\nMetzfort, KS 49962-2408', '1', 'Quidem vel dignissimos itaque doloribus facilis reiciendis quas. Nulla excepturi eveniet magni. Suscipit rem ratione corrupti aliquid et.'),
(83, 3, 0, 1, 3, 0, 'Aliza', 'Von', 'Laki-laki', '0000-00-00', 'jmohr', 'a833b216bd412f8f9750c3a8d2532ba917944bbe', 'islam', 'rosenbaum.pearline@example.com', 0, 'tmp//751dea9afbe77ff0cc07fcef8f31b55e.jpg', 'a', '', '1-247-905-4098x48774', '923 Arlo Valley\r\nGideonhaven, OR 56942', '1', 'Inventore mollitia nihil ducimus ex ut atque veniam magni. Aut et harum dolorem molestias et perspiciatis tempore. Voluptas iusto occaecati non non distinctio sint. Explicabo facilis recusandae ear'),
(84, 3, 1, 1, 2, 0, 'Morgan', 'Kiehn', 'Laki-laki', '0000-00-00', 'carlee80', '8aa204020f7525ec2ee0d3721990e11fea3351fe', 'islam', 'sarmstrong@example.org', 0, 'tmp//3ec65cd79b73e4c2bfbe554a10dad101.jpg', 'b', '', '+84(3)2026471890', '135 Lane Flats\r\nPowlowskiberg, RI 53034', '1', 'Eos enim ut nisi voluptate quae quo quia. Qui laboriosam deserunt corporis repudiandae aut velit laudantium. Temporibus libero autem aut quaerat.'),
(85, 2, 0, 1, 2, 0, 'Shemar', 'Braun', 'Laki-laki', '0000-00-00', 'glennie10', '96bc20ce22ee6f46b815cb70a290e699854643d1', 'kristen', 'dee42@example.com', 0, 'tmp//1b092754ed6374b8277ccc0c714e2e6f.jpg', 'o', '', '036-064-9428x534', '227 Keaton Gardens Suite 663\r\nMariliestad, OR 57119-1123', '1', 'Voluptas delectus perspiciatis modi animi odio a pariatur. Totam voluptate eos quia molestiae voluptatem qui. Perspiciatis itaque incidunt hic corrupti.'),
(86, 2, 0, 1, 1, 0, 'Kira', 'Harber', 'Laki-laki', NULL, 'mmacejkovic', 'b22468ec4301aa2f0cf38aaa21064a808ff18bd0', 'katholik', 'skye.gislason@example.com', 0, 'tmp//b8095b955c8bdf0ff7bb1c86ab12e7f1.jpg', 'ab', NULL, '1-672-145-5796x00275', '461 Dickinson Pass Lake Emely, OH 45323-7748', '1', 'Assumenda quia assumenda quo sit molestias doloremque reiciendis tenetur. Molestias explicabo quis ex assumenda at ullam ab. Nostrum et repellendus quidem quia facilis.'),
(87, 3, 0, 1, 3, 0, 'Coty', 'Streich', 'Perempuan', '0000-00-00', 'tsawayn', 'add260b282e2a808d52f8e5f41e19758832dc532', 'hindu', 'xmurazik@example.net', 0, 'tmp//e3f3aaf23edeca7eaf74d6da764faae7.jpg', 'b', '', '(691)282-4479x925', '497 Borer Forges\r\nNew Charlene, NH 59786', '1', 'Enim veritatis incidunt labore. Nobis esse quia quidem enim tempore totam vitae quis. Aut velit facilis saepe ab et rerum. Autem nisi et sunt asperiores.'),
(88, 2, 1, 1, 3, 0, 'Myrtice', 'Koch', 'Perempuan', '0000-00-00', 'afton.hegmann', 'f6ddb7c6adbe468e1102f7f2e0560fb2ba9b59fb', 'kristen', 'destiney25@example.org', 0, 'tmp//d701e63985d663a10d6b02af1c0ba8bc.jpg', 'b', '', '865-430-6194', '60250 Wehner Row Suite 410\r\nNew Aronport, AZ 68844', '1', 'Autem eligendi suscipit sapiente. Ut fuga rem unde ut natus. Neque id in deleniti qui est.'),
(89, 2, 1, 1, 3, 0, 'Kurt', 'Kohler', 'Perempuan', '0000-00-00', 'ayana.dooley', '7228d0eb4c44360796e52999b6a91eb8b20d5a87', 'kristen', 'jpfeffer@example.org', 0, 'tmp//77ea406b8b86fd1e50004af7013feba6.jpg', 'a', '', '168.055.1846x150', '597 Rudolph Mountains Suite 563\r\nParkerton, OR 70287', '1', 'Consectetur tenetur nisi saepe enim. Vero nesciunt consectetur voluptas ratione. Tenetur ullam molestiae nihil officiis velit nesciunt. Excepturi non id dolore aperiam ut vel. Autem libero eos qui'),
(90, 1, 0, 1, 1, 0, 'Makenzie', 'Gislason', 'Perempuan', NULL, 'miles25', 'da8c2472feb672372a91a138c696bad62a25e6ed', 'hindu', 'ryan.mina@example.org', 0, 'tmp//279861b2b6596b8e877cb37464385801.jpg', 'a', NULL, '1-824-420-4680', '865 Elza Fork Apt. 084 East Calitown, SC 61558', '1', 'Maiores libero repudiandae voluptas. In sit itaque non in qui. Suscipit sint et consequuntur sint vitae ab velit. Voluptatibus esse harum impedit quae incidunt molestiae.'),
(91, 1, 0, 1, 4, 0, 'Kendra', 'Dare', 'Perempuan', '0000-00-00', 'ylittle', 'e3db03c33d3130a1d84bca22dce51cf9edc1ac5a', 'kristen', 'isobel32@example.net', 0, 'tmp//3593628ac1f619811f7ae34009e21c56.jpg', 'a', '', '030-130-1903', '125 Destin Streets\r\nNorth Anissa, AZ 42428-1612', '1', 'Magnam expedita architecto pariatur inventore impedit sed. Aspernatur rerum perspiciatis quo et molestias. Similique qui provident et. Vel odit quisquam dolores omnis. Sit est ea aliquam.'),
(92, 2, 1, 1, 1, 0, 'Shad', 'Renner', 'Laki-laki', NULL, 'leonel45', 'acf261eb9a9ae1d46e0c6116e8ae4e7920e1d3f7', 'hindu', 'thompson.rubie@example.com', 0, 'tmp//b618418fd55a1634971135defff0941f.jpg', 'b', NULL, '6669881083', '9035 Waelchi Way Suite 659 Carterville, OK 53786-1752', '1', 'Ut itaque minima molestias maxime. Delectus dolorum deserunt pariatur.'),
(93, 2, 0, 1, 3, 0, 'Ellsworth', 'Dooley', 'Laki-laki', '0000-00-00', 'dach.katherine', '8d6c7db7fb637fde4fad1498a998b5483cea7b34', 'hindu', 'smith.adriel@example.org', 0, 'tmp//db87f6f368b70a74ae0a28b572c46ad3.jpg', 'ab', '', '891-341-5834', '3940 Hackett Station Suite 265\r\nEast Estella, ND 57843-8954', '1', 'Enim officia porro enim quaerat dicta aperiam. Aut qui laborum voluptates est non doloribus. Assumenda quam ut cumque molestiae placeat. Iste voluptatem sit totam necessitatibus ullam quis labore n'),
(94, 3, 1, 1, 4, 0, 'Imelda', 'Zemlak', 'Laki-laki', '0000-00-00', 'xharris', 'c63e4658d4467e185aa92293dc2c4e004903b76c', 'kristen', 'shanie.ondricka@example.net', 0, 'tmp//6562a7923f94483d62b16546f2846411.jpg', 'ab', '', '844.481.3978x5648', '322 Toy Manors\r\nLake Dominique, MA 05307-0162', '1', 'Dolorem praesentium qui expedita sequi sunt voluptas voluptas. Sint et quibusdam iusto est velit error temporibus. Doloribus hic omnis eos quas sunt.'),
(95, 3, 1, 1, 4, 0, 'Milan', 'Gottlieb', 'Perempuan', '0000-00-00', 'bogisich.demarcu', '35dd804fb5080f0f401667c991b4f45fd22224e1', 'katholik', 'kirstin.grady@example.org', 0, 'tmp//12a934c790e6363ffe1bc84e358772c1.jpg', 'ab', '', '7348360506', '1298 Alia Falls\r\nUllrichfort, OR 53528', '1', 'Laborum eos quisquam et est aut. Est officia qui eligendi excepturi. Quia et culpa eos soluta. Alias repellat sapiente rem et dolor.'),
(96, 1, 1, 1, 1, 0, 'Alfonzo', 'Keeling', 'Perempuan', NULL, 'martine.goyette', 'bbce897daa8da77b392d6ac132d40b1219b89d5f', 'kristen', 'zshanahan@example.com', 0, 'tmp//f45b5e815c7f3cc64e9237c9ee02658a.jpg', 'b', NULL, '1035193354', '55568 Anderson Streets Elliotland, ND 99399', '1', 'Qui possimus ex non molestias non voluptas. Quia et est qui et dolores est. Ratione alias tempora commodi rerum voluptas adipisci. Deserunt doloremque sed consequatur dolores a vel.'),
(97, 1, 0, 1, 3, 0, 'Kayleigh', 'Brakus', 'Perempuan', '0000-00-00', 'kozey.lyla', 'e45c29594a3979e437aa7388bb5ebe050a2f9fcf', 'hindu', 'haylie.schroeder@example.com', 0, 'tmp//7fe9ee012264923f50d45d9039cf858e.jpg', 'a', '', '(182)036-3710x075', '0309 David Mews\r\nEast Garett, PA 20575-4413', '1', 'Eos repellendus amet aperiam provident dolorum in dolorum. Veritatis aliquid iste aut. Eius odit est dolore quis.'),
(98, 2, 0, 1, 4, 0, 'Percy', 'Hauck', 'Perempuan', '0000-00-00', 'bennie47', '3a964cf298b6f9ec38be06b11246337bd8918afa', 'islam', 'sanford97@example.net', 0, 'tmp//d99eb6cfe6ae00419242ccc86d5e5f73.jpg', 'a', '', '(033)076-4244', '85776 O\'Reilly Parks Suite 946\r\nPort Desireeburgh, RI 21109', '1', 'Omnis facere perferendis amet soluta voluptates. Occaecati eveniet sed sed culpa. Provident nam dolorum tempore praesentium natus voluptatibus illo quis.'),
(99, 1, 1, 1, 3, 0, 'Araceli', 'Koss', 'Perempuan', '0000-00-00', 'littel.daniella', 'deb2c87bfe48c7e579cdbebdca1415104ea123b8', 'katholik', 'mercedes59@example.com', 0, 'tmp//a604a288997e84268fa78dd4b307d165.jpg', 'o', '', '467-321-6972x50539', '43317 Oberbrunner Ramp\r\nNew Verona, NJ 77057-6445', '1', 'Corporis rem ea fugiat cumque. Corrupti unde et repudiandae voluptatem sequi fugit excepturi. Et voluptas aut minus quia est sed est et. Rem sunt exercitationem facere maiores repellat.'),
(100, 2, 0, 1, 4, 0, 'Laverne', 'Morar', 'Perempuan', '0000-00-00', 'miller20', 'c97f8592befaa34057b58d44eb700d66bafb1514', 'kristen', 'clittle@example.org', 0, 'tmp//83db77ae05e5df0a2b980f20276c0669.jpg', 'o', '', '5278137898', '40666 Katlyn Shore Suite 040\r\nEast Kelli, ID 28933-3389', '1', 'Quos voluptates ab et ut ipsa sequi. Iste reiciendis vitae illum id aperiam similique cupiditate. Saepe et incidunt est delectus sit rem vel nihil. Nam architecto eligendi vero possimus totam et.'),
(101, 3, 0, 1, 3, 0, 'Maida', 'Cummings', 'Laki-laki', '0000-00-00', 'xemmerich', 'c2c8433e159ca1f1a0bd62d8cfd90d2dd64d639b', 'kristen', 'pmosciski@example.net', 0, 'tmp//a57da4e796b6a08c67428a2a9b0f9f14.jpg', 'ab', '', '(264)015-2705', '8484 Reece Tunnel Suite 836\r\nNew Julianaview, GA 57745', '1', 'Odio non et eos qui dolor saepe est eum. Harum id explicabo quis exercitationem hic. Neque architecto cupiditate ullam voluptas. Quas cumque illo illum est harum. Corrupti facilis cumque earum quo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user_types`
--

CREATE TABLE `tbl_user_types` (
  `id_user_type` int(11) NOT NULL,
  `user_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  ADD PRIMARY KEY (`id_notification`),
  ADD KEY `id_user` (`id_user`);

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
  MODIFY `id_admission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_attendances`
--
ALTER TABLE `tbl_attendances`
  MODIFY `id_attendance` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_books`
--
ALTER TABLE `tbl_books`
  MODIFY `id_book` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_classes`
--
ALTER TABLE `tbl_classes`
  MODIFY `id_class` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_class_routines`
--
ALTER TABLE `tbl_class_routines`
  MODIFY `id_class_routine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_exams`
--
ALTER TABLE `tbl_exams`
  MODIFY `id_exam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_exam_results`
--
ALTER TABLE `tbl_exam_results`
  MODIFY `id_result` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_finances`
--
ALTER TABLE `tbl_finances`
  MODIFY `id_finance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT untuk tabel `tbl_messages`
--
ALTER TABLE `tbl_messages`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `id_notification` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_payment_types`
--
ALTER TABLE `tbl_payment_types`
  MODIFY `id_payment_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_sections`
--
ALTER TABLE `tbl_sections`
  MODIFY `id_section` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  MODIFY `id_subject` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_transports`
--
ALTER TABLE `tbl_transports`
  MODIFY `id_transport` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT untuk tabel `tbl_user_types`
--
ALTER TABLE `tbl_user_types`
  MODIFY `id_user_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_admissions`
--
ALTER TABLE `tbl_admissions`
  ADD CONSTRAINT `tbl_admissions_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tbl_users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `tbl_attendances`
--
ALTER TABLE `tbl_attendances`
  ADD CONSTRAINT `tbl_attendances_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tbl_users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `tbl_classes`
--
ALTER TABLE `tbl_classes`
  ADD CONSTRAINT `tbl_classes_ibfk_1` FOREIGN KEY (`id_section`) REFERENCES `tbl_sections` (`id_section`);

--
-- Ketidakleluasaan untuk tabel `tbl_class_routines`
--
ALTER TABLE `tbl_class_routines`
  ADD CONSTRAINT `tbl_class_routines_ibfk_1` FOREIGN KEY (`id_class`) REFERENCES `tbl_classes` (`id_class`),
  ADD CONSTRAINT `tbl_class_routines_ibfk_2` FOREIGN KEY (`id_subject`) REFERENCES `tbl_subjects` (`id_subject`);

--
-- Ketidakleluasaan untuk tabel `tbl_exams`
--
ALTER TABLE `tbl_exams`
  ADD CONSTRAINT `tbl_exams_ibfk_1` FOREIGN KEY (`id_class`) REFERENCES `tbl_classes` (`id_class`);

--
-- Ketidakleluasaan untuk tabel `tbl_exam_results`
--
ALTER TABLE `tbl_exam_results`
  ADD CONSTRAINT `tbl_exam_results_ibfk_1` FOREIGN KEY (`id_exam`) REFERENCES `tbl_exams` (`id_exam`),
  ADD CONSTRAINT `tbl_exam_results_ibfk_2` FOREIGN KEY (`id_subject`) REFERENCES `tbl_subjects` (`id_subject`),
  ADD CONSTRAINT `tbl_exam_results_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `tbl_users` (`id_user`),
  ADD CONSTRAINT `tbl_exam_results_ibfk_4` FOREIGN KEY (`id_class`) REFERENCES `tbl_classes` (`id_class`);

--
-- Ketidakleluasaan untuk tabel `tbl_finances`
--
ALTER TABLE `tbl_finances`
  ADD CONSTRAINT `tbl_finances_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tbl_users` (`id_user`),
  ADD CONSTRAINT `tbl_finances_ibfk_2` FOREIGN KEY (`id_payment_type`) REFERENCES `tbl_payment_types` (`id_payment_type`);

--
-- Ketidakleluasaan untuk tabel `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  ADD CONSTRAINT `tbl_notifications_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tbl_users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD CONSTRAINT `tbl_users_ibfk_1` FOREIGN KEY (`id_hostel`) REFERENCES `tbl_hostels` (`id_hostel`),
  ADD CONSTRAINT `tbl_users_ibfk_3` FOREIGN KEY (`id_class`) REFERENCES `tbl_classes` (`id_class`),
  ADD CONSTRAINT `tbl_users_ibfk_4` FOREIGN KEY (`id_trans`) REFERENCES `tbl_transports` (`id_transport`),
  ADD CONSTRAINT `tbl_users_ibfk_5` FOREIGN KEY (`id_user_type`) REFERENCES `tbl_user_types` (`id_user_type`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;