-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 01 Aug 2019 la 22:28
-- Versiune server: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cunbm_afc_meliodas`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `chat_messages`
--

CREATE TABLE `chat_messages` (
  `mess_id` int(7) NOT NULL,
  `mess_to_id` int(7) NOT NULL,
  `mess_from_id` int(7) NOT NULL,
  `mess_text` text NOT NULL,
  `mess_date` datetime NOT NULL,
  `mess_status` tinyint(1) NOT NULL COMMENT '(0 - notsent, 1 - sent, 2 - seen'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `us_users`
--

CREATE TABLE `us_users` (
  `user_id` int(7) NOT NULL,
  `user_type` varchar(4) NOT NULL,
  `user_name` varchar(64) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(64) NOT NULL,
  `user_first_name` varchar(32) NOT NULL,
  `user_last_name` varchar(32) NOT NULL,
  `user_phone_number` varchar(15) NOT NULL,
  `user_city` varchar(32) NOT NULL,
  `user_year` tinyint(1) NOT NULL,
  `user_specialization` varchar(9) NOT NULL,
  `user_profile_pic` varchar(50) NOT NULL,
  `user_chat_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Salvarea datelor din tabel `us_users`
--

INSERT INTO `us_users` (`user_id`, `user_type`, `user_name`, `user_email`, `user_password`, `user_first_name`, `user_last_name`, `user_phone_number`, `user_city`, `user_year`, `user_specialization`, `user_profile_pic`, `user_chat_id`) VALUES
(1, 'std', 'admins', 'clau.sarmasi@yahoo.com', '21232f297a57a5a743894a0e4a801fc3', 'Claudiu', 'Sarmasi', '0762190393', 'Baia Mare', 4, 'CAL', 'admins_123456.jpg', 'f8QxMd8zkKc:APA91bG1YaL8B-ytNsTwCcB1tGHG9uMK9IkkjE8p4w9dD4pZxiqdxB1q7tSD-kDjSd103-vdawQBx9gbmbSpw-4_y_xd_ftSbEkf9n2Lty5FX4CFz5BUlsiGAsWS2m2AeGLaAPYmQWeJ'),
(6, 'std', 'popandrei', 'test@yahoo.com', '21232f297a57a5a743894a0e4a801fc3', 'Andrei', 'Pop', '0262480609', 'Baia Mare', 3, 'IETC', 'student_logo.png', ''),
(7, 'prof', 'adminp', 'silverdevil@yahoo.com', '21232f297a57a5a743894a0e4a801fc3', 'Silver', 'Profesor', '0769069707', 'Valea Chioarului', 0, '', 'adminp_12345.jpg', 'dK2vsp1a4Rs:APA91bFKSw5txcWKTorl7LiMKdC7NH35R3aS2XrHyLQRUHwxe3GtlXvmEpMsaYVCJ0hIySPJFIfb3S6SG_GZEavT205EgOFWX9wPFO4NaK9Mjp1tx0X7SOUu9yP485aEKyjc5qYY6lh7'),
(8, 'std', 'butuzagabi', 'gabriel@yahoo.com', '21232f297a57a5a743894a0e4a801fc3', 'Gabriel Stefan', 'Butuza', '0762190393', 'Baita de sub Codru', 4, 'CAL', 'student_logo.png', ''),
(9, 'prof', 'costeac', 'costea@yahoo.com', '21232f297a57a5a743894a0e4a801fc3', 'Cristinel', 'Costea', '0762190393', 'Baia Mare', 0, '', 'student_logo.png', ''),
(10, 'prof', 'adrianpetrovan', 'adrian_petrovan@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'Adrian', 'Petrovan', '0762190393', 'Baia Mare', 0, '', 'student_logo.png', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`mess_id`);

--
-- Indexes for table `us_users`
--
ALTER TABLE `us_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `std_user` (`user_name`),
  ADD UNIQUE KEY `std_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `mess_id` int(7) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `us_users`
--
ALTER TABLE `us_users`
  MODIFY `user_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
