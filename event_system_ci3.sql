-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2025 at 09:25 PM
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
-- Database: `event_system_ci3`
--

-- --------------------------------------------------------

--
-- Table structure for table `approvals`
--

CREATE TABLE `approvals` (
  `id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `approved_by` int(11) NOT NULL,
  `band_id` int(11) NOT NULL,
  `decision` enum('approved','rejected','skipped') NOT NULL,
  `remarks` text DEFAULT NULL,
  `approved_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approvals`
--

INSERT INTO `approvals` (`id`, `registration_id`, `approved_by`, `band_id`, `decision`, `remarks`, `approved_at`) VALUES
(1, 1, 4, 6, 'approved', '', '2025-12-30 15:50:28'),
(2, 2, 4, 6, 'approved', '', '2025-12-30 16:46:56'),
(3, 2, 3, 9, 'approved', '', '2025-12-30 16:47:09'),
(4, 3, 4, 6, 'approved', '12', '2025-12-30 20:15:04'),
(5, 6, 3, 10, 'approved', '', '2025-12-30 20:15:52'),
(6, 5, 4, 10, 'approved', '12', '2025-12-30 20:57:39'),
(7, 3, 3, 9, 'approved', '', '2025-12-30 20:58:01'),
(8, 7, 4, 10, 'approved', '', '2025-12-31 01:50:45');

-- --------------------------------------------------------

--
-- Table structure for table `approval_bands`
--

CREATE TABLE `approval_bands` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `band_order` int(11) NOT NULL,
  `role` enum('manager','director') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approval_bands`
--

INSERT INTO `approval_bands` (`id`, `event_id`, `band_order`, `role`) VALUES
(3, 2, 1, 'director'),
(4, 3, 1, 'manager'),
(6, 5, 546456, 'director'),
(7, 1, 1, 'manager'),
(8, 1, 2, 'director'),
(9, 5, 546456, 'manager'),
(10, 6, 122, 'director'),
(11, 1, 78, 'director');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `start_date`, `end_date`) VALUES
(1, 'Soft Skills Training', 'Training for soft skills SKILLS', '2025-09-10', '2025-09-12'),
(2, 'External Guest Seminar', 'Seminar for invited guests', '2025-10-05', '2025-10-05'),
(3, 'Seminar on Technology Trends', 'Seminar for latest technology trends', '2025-10-12', '2025-10-13'),
(4, 'Test', 'test', '2001-07-07', '2023-02-12'),
(5, 'suyash kore', 'Ivent ', '5424-12-12', '2544-03-12'),
(6, 'Soft Skills Training new', 'nay', '2025-12-30', '2026-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `form_nodes`
--

CREATE TABLE `form_nodes` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `label` varchar(100) DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `field_type` enum('text','email','number','dropdown') NOT NULL,
  `field_options` text DEFAULT NULL,
  `required` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form_nodes`
--

INSERT INTO `form_nodes` (`id`, `event_id`, `label`, `field_name`, `field_type`, `field_options`, `required`) VALUES
(2, 2, 'Company Name', 'company', 'text', NULL, 1),
(3, 3, 'Topic Interest', 'topic_interest', 'dropdown', 'AI,Cloud,Security,Data Science', 1),
(6, 5, 'c', 'AS', 'email', 'SD', 1),
(7, 5, 'davdsv', 'adava', 'text', 'SSD', 1),
(13, 1, 'Department1', 'department1', 'number', '7218846352', 1),
(14, 6, 'Department1', 'department1', 'email', 'qww', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quotas`
--

CREATE TABLE `quotas` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `role` enum('employee','external','manager','director') NOT NULL,
  `max_participants` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quotas`
--

INSERT INTO `quotas` (`id`, `event_id`, `role`, `max_participants`) VALUES
(1, 1, 'employee', 50),
(2, 1, 'manager', 10),
(3, 2, 'external', 20),
(4, 3, 'employee', 30),
(5, 5, 'employee', 34),
(6, 5, 'external', 34),
(7, 5, 'manager', 34),
(8, 5, 'director', 34),
(9, 1, 'external', 12),
(10, 1, 'director', 12),
(11, 6, 'employee', 12),
(12, 6, 'external', 12),
(13, 6, 'manager', 12),
(14, 6, 'director', 12);

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('pending','approved','rejected','waitlisted') DEFAULT 'pending',
  `form_data` text DEFAULT NULL,
  `registered_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `event_id`, `user_id`, `status`, `form_data`, `registered_at`) VALUES
(1, 5, 2, 'approved', '{\"SD\":\"SDGAAD@GMAIL.COM\"}', '2025-12-30 15:47:32'),
(2, 5, 2, 'approved', '{\"AS\":\"sk@gmail.com\",\"SD\":\"SSDV\"}', '2025-12-30 16:46:10'),
(3, 5, 2, 'approved', '{\"AS\":\"sk@gmail.com\",\"adava\":\"ddh\"}', '2025-12-30 18:50:05'),
(4, 5, 2, 'pending', '{\"AS\":\"sk@gmail.com\",\"adava\":\"ddh\"}', '2025-12-30 19:16:46'),
(5, 6, 2, 'approved', '{\"department1\":\"DroneSu@gmail.com\"}', '2025-12-30 19:26:21'),
(6, 6, 2, 'approved', '{\"department1\":\"DroneSu@gmail.com\"}', '2025-12-30 20:15:34'),
(7, 6, 3, 'approved', '{\"department1\":\"DroneSu@gmail.com\"}', '2025-12-31 01:50:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','employee','manager','director','external') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`) VALUES
(1, 'Admin User', 'admin@example.com', 'admin'),
(2, 'Employee One', 'emp1@example.com', 'employee'),
(3, 'Manager Mike', 'manager@example.com', 'manager'),
(4, 'Director Dave', 'director@example.com', 'director'),
(5, 'Guest Greg', 'guest@example.com', 'external');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approvals`
--
ALTER TABLE `approvals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_app_reg` (`registration_id`),
  ADD KEY `fk_app_user` (`approved_by`),
  ADD KEY `fk_app_band` (`band_id`);

--
-- Indexes for table `approval_bands`
--
ALTER TABLE `approval_bands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_band_event` (`event_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_nodes`
--
ALTER TABLE `form_nodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_form_event` (`event_id`);

--
-- Indexes for table `quotas`
--
ALTER TABLE `quotas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_quota_event` (`event_id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reg_event` (`event_id`),
  ADD KEY `fk_reg_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approvals`
--
ALTER TABLE `approvals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `approval_bands`
--
ALTER TABLE `approval_bands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `form_nodes`
--
ALTER TABLE `form_nodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `quotas`
--
ALTER TABLE `quotas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approvals`
--
ALTER TABLE `approvals`
  ADD CONSTRAINT `fk_app_band` FOREIGN KEY (`band_id`) REFERENCES `approval_bands` (`id`),
  ADD CONSTRAINT `fk_app_reg` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_app_user` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `approval_bands`
--
ALTER TABLE `approval_bands`
  ADD CONSTRAINT `fk_band_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `form_nodes`
--
ALTER TABLE `form_nodes`
  ADD CONSTRAINT `fk_form_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quotas`
--
ALTER TABLE `quotas`
  ADD CONSTRAINT `fk_quota_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `fk_reg_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `fk_reg_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
