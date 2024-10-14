-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2024 at 11:43 AM
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
-- Database: `slpolice`
--

-- --------------------------------------------------------

--
-- Table structure for table `complaint`
--

CREATE TABLE `complaint` (
  `complaint_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `district` varchar(100) NOT NULL,
  `nearest_police_station` varchar(100) NOT NULL,
  `complaint_category` varchar(100) NOT NULL,
  `name` varchar(150) NOT NULL,
  `address` text NOT NULL,
  `nic_number` varchar(12) NOT NULL,
  `email_address` varchar(150) DEFAULT NULL,
  `complaint` text NOT NULL,
  `complaint_subject` varchar(255) NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `date_added` datetime DEFAULT current_timestamp(),
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaint`
--

INSERT INTO `complaint` (`complaint_id`, `user_id`, `district`, `nearest_police_station`, `complaint_category`, `name`, `address`, `nic_number`, `email_address`, `complaint`, `complaint_subject`, `attachment`, `date_added`, `location`) VALUES
(11, 2, 'Colombo', 'Bambalapitiya Police Station', 'Theft', 'John Doe', 'No. 123, Colombo 03', '987654321V', 'johndoe@example.com', 'My phone was stolen while I was walking on the road.', 'Phone Theft', NULL, '2024-10-12 20:44:02', 'Bambalapitiya'),
(12, 2, 'Galle', 'Galle Fort Police Station', 'Burglary', 'Jane Smith', 'No. 45, Galle Road, Galle', '123456789V', 'janesmith@example.com', 'My house was broken into last night and several valuable items were stolen.', 'House Burglary', 'photo_evidence.jpg', '2024-10-12 20:44:02', 'Galle Fort'),
(13, 2, 'Kandy', 'Kandy Police Station', 'Fraud', 'Michael Fernando', 'No. 78, Peradeniya Road, Kandy', '876543210V', 'michaelf@example.com', 'I was tricked into giving money to someone who promised to invest in a fake business.', 'Investment Fraud', NULL, '2024-10-12 20:44:02', 'Peradeniya Road'),
(14, 2, 'Jaffna', 'Jaffna Town Police Station', 'Harassment', 'Samantha Perera', 'No. 20, Jaffna Town', '234567890V', 'samanthap@example.com', 'I have been harassed by a group of people in my neighborhood for the past few weeks.', 'Harassment Complaint', 'audio_evidence.mp3', '2024-10-12 20:44:02', 'Jaffna Town'),
(15, 2, 'Matara', 'Matara Police Station', 'Assault', 'David Silva', 'No. 10, Main Street, Matara', '654321098V', 'davidsilva@example.com', 'I was physically assaulted by an unknown individual at a public event.', 'Physical Assault', NULL, '2024-10-12 20:44:02', 'Main Street');

-- --------------------------------------------------------

--
-- Table structure for table `evidence`
--

CREATE TABLE `evidence` (
  `evidence_id` int(11) NOT NULL,
  `investigation_id` int(11) NOT NULL,
  `evidence_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investigation`
--

CREATE TABLE `investigation` (
  `investigation_id` int(11) NOT NULL,
  `complaint_id` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL,
  `status` varchar(50) DEFAULT 'Open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `user_type`) VALUES
(1, '1111', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin'),
(2, '2222', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'user'),
(3, '3333', '8cb2237d0679ca88db6464eac60da96345513964', 'OIC');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `complaint`
--
ALTER TABLE `complaint`
  ADD PRIMARY KEY (`complaint_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `evidence`
--
ALTER TABLE `evidence`
  ADD PRIMARY KEY (`evidence_id`),
  ADD KEY `investigation_id` (`investigation_id`);

--
-- Indexes for table `investigation`
--
ALTER TABLE `investigation`
  ADD PRIMARY KEY (`investigation_id`),
  ADD KEY `complaint_id` (`complaint_id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaint`
--
ALTER TABLE `complaint`
  MODIFY `complaint_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `evidence`
--
ALTER TABLE `evidence`
  MODIFY `evidence_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investigation`
--
ALTER TABLE `investigation`
  MODIFY `investigation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaint`
--
ALTER TABLE `complaint`
  ADD CONSTRAINT `complaint_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `evidence`
--
ALTER TABLE `evidence`
  ADD CONSTRAINT `evidence_ibfk_1` FOREIGN KEY (`investigation_id`) REFERENCES `investigation` (`investigation_id`);

--
-- Constraints for table `investigation`
--
ALTER TABLE `investigation`
  ADD CONSTRAINT `investigation_ibfk_1` FOREIGN KEY (`complaint_id`) REFERENCES `complaint` (`complaint_id`),
  ADD CONSTRAINT `investigation_ibfk_2` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
