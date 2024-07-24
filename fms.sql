-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2024 at 05:30 PM
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
-- Database: `fms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(11, 'Railway Board'),
(12, 'Accounts'),
(13, 'Personnel'),
(14, 'S&T'),
(15, 'RPF'),
(16, 'Commercial'),
(17, 'Operating'),
(18, 'Mechanical'),
(27, 'it');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `serial_number` int(11) NOT NULL,
  `custom_name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `subcategory_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `serial_number`, `custom_name`, `file_name`, `uploaded_at`, `subcategory_id`, `file_path`) VALUES
(1, 1, 'Group', 'GROUP.pdf', '2024-07-23 10:03:47', 2, ''),
(2, 2, 'CMS', 'CMS.pdf', '2024-07-23 19:56:28', 2, ''),
(3, 3, 'CV', 'Tanushree Das CV.docx', '2024-07-23 19:57:00', 2, ''),
(4, 4, 'Duty List', 'duty sept.docx', '2024-07-23 19:59:25', 2, ''),
(5, 5, 'Coursera', 'Coursera_IBM.pdf', '2024-07-23 20:00:12', 3, ''),
(6, 6, 'Work_Up_List', '2_Pretransplant_Work_up_Checklist.docx', '2024-07-23 20:01:58', 3, ''),
(7, 7, 'Experiment', 'EXP.docx', '2024-07-23 20:02:43', 3, ''),
(8, 8, 'Case-Study', 'iot_case_study_GRP9.pdf', '2024-07-23 20:03:55', 3, ''),
(9, 9, 'Research-Paper', 'Star_Research_paper.pdf', '2024-07-23 20:04:31', 7, ''),
(10, 10, 'CV', 'Tanushree Das CV.docx', '2024-07-23 20:04:48', 7, ''),
(11, 11, 'Order-6474', 'Order-6474.PDF', '2024-07-23 20:05:30', 7, ''),
(12, 12, 'Blank-pre-tx-summary', 'BLANK .PRE-TX.SUMMARY.2004.doc', '2024-07-23 20:06:42', 8, ''),
(13, 13, 'UX-Design', 'Coursera-4.pdf', '2024-07-23 20:07:18', 8, ''),
(14, 14, 'Receipt', 'CollectionReceipt.pdf', '2024-07-23 20:08:02', 8, ''),
(15, 15, 'FMS', 'FMS.pdf', '2024-07-23 20:08:47', 8, ''),
(16, 16, 'Duty List', 'duty sept.docx', '2024-07-23 21:32:08', 8, ''),
(17, 17, 'Result', '6th sem-result.pdf', '2024-07-24 10:38:22', 13, '');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `email`, `phone_number`) VALUES
(3, 'Shree', '1234', '2101020481@cgu-odisha.ac.in', '6371234567');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `name`, `category_id`) VALUES
(2, 'POLICY', 11),
(3, 'NOTICE', 11),
(7, 'RECRUITEMENT', 11),
(8, 'OFFICE-ORDER', 11),
(13, 'ABC', 27);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategory_id` (`subcategory_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`);

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
