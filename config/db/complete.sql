-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 06, 2020 at 11:04 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parkingdb`
--

CREATE DATABASE IF NOT EXISTS `parkingdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `parkingdb`;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `license_plate` varchar(15) NOT NULL,
  `owner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `course_day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `course_from` time NOT NULL,
  `course_to` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_title`, `teacher_id`, `course_day`, `course_from`, `course_to`) VALUES
(4, 'ФП', 6, 'Wednesday', '09:15:00', '12:00:00'),
(6, 'УЗ', 7, 'Monday', '10:15:00', '12:00:00'),
(7, 'АЕ', 7, 'Monday', '10:00:00', '12:00:00'),
(8, 'Алгебра', 6, 'Thursday', '16:15:00', '18:00:00'),
(9, 'ЛП', 7, 'Friday', '12:15:00', '15:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `parking_spots`
--

CREATE TABLE `parking_spots` (
  `number` int(11) NOT NULL,
  `car` varchar(15) DEFAULT NULL,
  `owner` int(11) DEFAULT NULL,
  `time_in` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `free` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parking_spots`
--

INSERT INTO `parking_spots` (`number`, `car`, `owner`, `time_in`, `duration`, `time_out`, `free`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, 1),
(2, NULL, NULL, NULL, NULL, NULL, 1),
(3, NULL, NULL, NULL, NULL, NULL, 1),
(4, NULL, NULL, NULL, NULL, NULL, 1),
(5, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_first` varchar(255) NOT NULL,
  `u_last` varchar(255) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_password` varchar(255) NOT NULL,
  `u_role` enum('admin','permanent','temporary','blocked') NOT NULL DEFAULT 'blocked',
  `u_id` int(11) NOT NULL,
  `car` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_first`, `u_last`, `u_email`, `u_password`, `u_role`, `u_id`, `car`) VALUES
('Админисандър', 'Щъркелов', 'admin@abv.bg', '$2y$10$36PFZVtgrbPgrznEhcA.M.Kn9clEk966F6fkh4hp9a42flHJApo1m', 'admin', 1, NULL),
('Невена', 'Гаджева', 'temp@abv.bg', '$2y$10$u.wQ9zr0Es/TRTdgweM/mOi1LM36/IS1RnIxBccTuj/uPChaRwz7q', 'temporary', 6, NULL),
('Трифон', 'Трифонов', 'trifonFMI@gmail.com', '$2y$10$uljynZe3M9uI7NCPZCbbDOMZcCn7bVp/wPsHKdu0/PK1qb5tV0X1G', 'permanent', 7, NULL),
('Милен', 'Петров', 'm.petrovFMI@abv.bg', '$2y$10$B8v5YexEH6TcVMW0cpL7o.AUk9aHgEgL8cC6nC6sUZifTBruwYuqS', 'permanent', 28, NULL),
('Hakan', 'Halil', 'hakansunay@abv.bg', 'parola', 'temporary', 31, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`license_plate`),
  ADD KEY `owner` (`owner`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `fk_courses_teachers` (`teacher_id`);

--
-- Indexes for table `parking_spots`
--
ALTER TABLE `parking_spots`
  ADD PRIMARY KEY (`number`),
  ADD KEY `car` (`car`),
  ADD KEY `owner` (`owner`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`subject`,`room`,`day`,`start_time`,`end_time`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `u_email` (`u_email`),
  ADD KEY `car` (`car`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`u_id`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `fk_courses_teachers` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`u_id`);

--
-- Constraints for table `parking_spots`
--
ALTER TABLE `parking_spots`
  ADD CONSTRAINT `parking_spots_ibfk_1` FOREIGN KEY (`car`) REFERENCES `cars` (`license_plate`),
  ADD CONSTRAINT `parking_spots_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `users` (`u_id`);

--
-- Constraints for table `timetable`
--
ALTER TABLE `timetable`
  ADD CONSTRAINT `timetable_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`u_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`car`) REFERENCES `cars` (`license_plate`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
