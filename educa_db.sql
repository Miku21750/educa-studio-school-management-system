-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Nov 2022 pada 04.38
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_exam_results`
--

CREATE TABLE `tbl_exam_results` (
  `id_result` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_exam` int(11) NOT NULL,
  `id_subject` int(11) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_finances`
--

CREATE TABLE `tbl_finances` (
  `id_finance` int(11) NOT NULL,
  `id_payment_type` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `amount_payment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `message` varchar(255) NOT NULL
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
  `date_notice` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_payment_types`
--

CREATE TABLE `tbl_payment_types` (
  `id_payment_type` int(11) NOT NULL,
  `payment_type_name` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_transports`
--

INSERT INTO `tbl_transports` (`id_transport`, `route_name`, `vehicle_number`, `driver_name`, `license_number`, `phone_number`) VALUES
(1, 'sad', 'asda', 'adsd', 'sdadada', 'sadasd'),
(2, 'cvvvvvv', 'vsdsfs', 'sadsdasadsad', 'sadasd', 'sdadasds');

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
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `gender` enum('Laki-laki','Perempuan','','') NOT NULL,
  `date_of_birth` date NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `religion` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `photo_user` varchar(255) DEFAULT NULL,
  `blood_group` char(5) DEFAULT NULL,
  `occupation` varchar(10) NOT NULL,
  `phone_user` varchar(25) NOT NULL,
  `address_user` text DEFAULT NULL,
  `class` varchar(50) NOT NULL,
  `short_bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'student'),
(2, 'teacher'),
(3, 'admin'),
(4, 'parent');

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
  ADD KEY `id_subject` (`id_subject`);

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
  MODIFY `id_admission` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id_exam` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_exam_results`
--
ALTER TABLE `tbl_exam_results`
  MODIFY `id_result` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_finances`
--
ALTER TABLE `tbl_finances`
  MODIFY `id_finance` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_messages`
--
ALTER TABLE `tbl_messages`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `id_notification` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_payment_types`
--
ALTER TABLE `tbl_payment_types`
  MODIFY `id_payment_type` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id_transport` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `tbl_exam_results_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `tbl_users` (`id_user`);

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
  ADD CONSTRAINT `tbl_notifications_ibfk_1` FOREIGN KEY (`id_notification`) REFERENCES `tbl_users` (`id_user`);

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
