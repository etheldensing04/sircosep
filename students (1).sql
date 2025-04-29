-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2025 at 11:18 AM
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
-- Database: `student_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `assign_id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `school` varchar(255) NOT NULL,
  `school_address` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `coordinator` varchar(255) NOT NULL,
  `organization` varchar(255) NOT NULL,
  `profile_image` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `verification_code` varchar(100) NOT NULL,
  `is_verified` tinyint(4) DEFAULT 0,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`assign_id`, `student_name`, `school`, `school_address`, `contact`, `coordinator`, `organization`, `profile_image`, `email`, `password`, `verification_code`, `is_verified`, `date_created`) VALUES
(31, 'Emarie tulod', 'lapaz', 'Brgy. Dakit, Purok Cesar Cabancalan', '0926366425', '', '', 'uploads/11fd6d455852ccde878c15e11d1beb21.jpg', 'tulodemarie@gmail.com', '$2y$10$T7mJwV.rG1tpH6leYpoULegHf1madryw7Pdl1tiAKa7WDjhFHf.jK', '', 1, '0000-00-00'),
(35, 'Robinson', 'Cebu Roosevelt Memorial Colleges', 'bogo', '09916033881', '', '', NULL, 'Canamarobinsonjr@gmail.com', '$2y$10$Pnxqfsf1oMNiFYQ9Rbfr1u34lRLwz9L71U2GAeGWqwHkNA7ZDjKUy', '09282231c7b5019260736e9e784c0d89', 0, '2025-04-15'),
(36, 'louella', 'lapaz', 'Brgy. Dakit, Purok Cesar Cabancalan', '0926366425', 'Dr. Castro', 'IT', 'uploads/Angeli-Khang.jpg', 'xerihal905@f5url.com', '$2y$10$bL.mfHT4sDtr9rWVeWiGauQ0jbDlFEgrpvizufAv/CSzjG.ZvHTxu', '09c29c209618677343489d2fdfc8bc7e', 0, '0000-00-00'),
(37, 'louella', 'lapaz', 'Brgy. Dakit, Purok Cesar Cabancalan', '0926366425', 'Dr. Castro', 'IT', 'uploads/Angeli-Khang.jpg', 'xerihal905@f5url.com', '$2y$10$OFUYypiElYLWrttKiZpKx.f4rje9s6FhLXhFJ0BV3fITNE6a4qtcS', '6d696d0af96fe8e67602193b98924213', 0, '0000-00-00'),
(38, 'axsasa', 'cdsa', 'sasa', '1345456454', 'sacxs', 'sada', 'uploads/Angeli-Khang.jpg', 'emarietulodd@gmail.com', '$2y$10$Q9K0mgs99KX9rx4n5rNG2O9B5mdxERxh6UzxvyW1b3Hbgg5hCUYYW', 'e7118232804c29bbd4d021c25db12016', 0, '0000-00-00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`assign_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `assign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
