-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2024 at 12:36 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bp_go`
--

-- --------------------------------------------------------

--
-- Table structure for table `old_rescripts`
--

CREATE TABLE `old_rescripts` (
  `id` int(11) NOT NULL,
  `old_id` int(11) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `edited_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `rescript_id` varchar(10) DEFAULT NULL,
  `rescript_year` int(4) DEFAULT NULL,
  `e_code` int(4) DEFAULT NULL,
  `e_name` varchar(50) DEFAULT NULL,
  `days_number` int(2) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rescripts`
--

CREATE TABLE `rescripts` (
  `id` int(11) NOT NULL,
  `number` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `edited_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `rescript_id` varchar(10) DEFAULT NULL,
  `rescript_year` int(4) DEFAULT NULL,
  `e_code` int(4) DEFAULT NULL,
  `e_name` varchar(50) DEFAULT NULL,
  `days_number` int(2) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `author` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `e_code` int(4) NOT NULL,
  `status` enum('user','admin') NOT NULL,
  `token` varchar(100) NOT NULL,
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `e_code`, `status`, `token`, `deleted`) VALUES
(3, 'Admin', '$2y$10$DSTbTyS5O5ye1g4rDSQAWux1DvmJYuzcB78AjGe/ba/F6PlW9NiOC', 1111, 'admin', 'Dm7TzotOw6lbSBz6KYCe@m5OdXLxzr4ehMzk07D9IFa0rqTBNmJhGExwGneorSB8xFWcsOZKHcwxSyCgL2B4FtUAEX5JlXDpXnGU', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `old_rescripts`
--
ALTER TABLE `old_rescripts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rescripts`
--
ALTER TABLE `rescripts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password` (`password`),
  ADD UNIQUE KEY `e_code` (`e_code`),
  ADD UNIQUE KEY `token` (`token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `old_rescripts`
--
ALTER TABLE `old_rescripts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rescripts`
--
ALTER TABLE `rescripts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
