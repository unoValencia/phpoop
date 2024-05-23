-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2024 at 07:14 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loginmethod`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `passwords` varchar(255) DEFAULT NULL,
  `first_name` varchar(225) DEFAULT NULL,
  `last_name` varchar(225) DEFAULT NULL,
  `user_email` varchar(255) NOT NULL,
  `birthday` date DEFAULT NULL,
  `sex` varchar(225) DEFAULT NULL,
  `user_profile` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `passwords`, `first_name`, `last_name`, `user_email`, `birthday`, `sex`, `user_profile`) VALUES
(2, 'Unoski', '257', 'Janine Margarette', 'Valencia', '', '2003-02-11', 'Female', ''),
(17, 'DJ', '$2y$10$tnA7SSizZn4uc7e4qA4HJ.RTnb2TBSEBS9gOqRAk1PJQWl1roJcfe', 'ashley', 'mitraabebe', 'valenciajg@students.nu-lipa.edu.ph', '2024-05-09', 'Male', 'uploads/ashley.jpg'),
(18, 'Lord Perceval', '$2y$10$jetEYt6qXBBnHNw4ThDL0e6esOE/IfGKIw6lUkzuRQajRe2t46H2q', 'Charles Marc Herve Perceval', 'Lecler', 'valenciajg@students.nu-lipa.edu.ph', '2024-05-03', 'Male', 'uploads/cl_1716354822.png'),
(19, 'Iceman', '$2y$10$TnMvwF/gHsR1RUP2EP7yBOGYGNX/ABrz1x7xsnWWg5pEeFtFp43G2', 'Kimi-Matias', 'Räikkönen', 'valenciajg@students.nu-lipa.edu.ph', '2024-05-09', 'Male', 'uploads/R.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users_address`
--

CREATE TABLE `users_address` (
  `user_add_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `Users_add_street` varchar(255) DEFAULT NULL,
  `Users_add_barangay` varchar(255) DEFAULT NULL,
  `Users_add_city` varchar(255) DEFAULT NULL,
  `User_add_province` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_address`
--

INSERT INTO `users_address` (`user_add_id`, `user_id`, `Users_add_street`, `Users_add_barangay`, `Users_add_city`, `User_add_province`) VALUES
(15, 17, 'qtpieq', 'Chanarian', 'Basco (Capital)', 'Region II (Cagayan Valley)'),
(16, 18, '1234', 'Barangay VI (Pob.)', 'Daet (Capital)', 'Region V (Bicol Region)'),
(17, 19, '1234', 'Barangay 8 (Pob.)', 'Balayan', 'Region IV-A (CALABARZON)');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users_address`
--
ALTER TABLE `users_address`
  ADD PRIMARY KEY (`user_add_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users_address`
--
ALTER TABLE `users_address`
  MODIFY `user_add_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_address`
--
ALTER TABLE `users_address`
  ADD CONSTRAINT `users_address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
