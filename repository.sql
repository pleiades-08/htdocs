-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2025 at 04:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `repository`
--

-- --------------------------------------------------------

--
-- Table structure for table `capstone_phases`
--

CREATE TABLE `capstone_phases` (
  `phase_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `phase_type` enum('Proposal','Chapter 1','Chapter 2','Chapter 3','Chapter 4','Chapter 5','Final Defense') NOT NULL,
  `status` enum('Not Started','In Progress','For Review','Approved','Revisions Needed') DEFAULT 'Not Started',
  `due_date` date DEFAULT NULL,
  `completion_date` date DEFAULT NULL,
  `adviser_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `document_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `uploader_id` int(11) NOT NULL,
  `document_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `file_size` int(11) NOT NULL,
  `chapter` enum('1','2','3','4','5','Proposal','Final') NOT NULL DEFAULT 'Proposal',
  `version` varchar(10) DEFAULT '1',
  `status` enum('Draft','Submitted','Under Review','Reviewed','Needs Revision') DEFAULT 'Draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`document_id`, `team_id`, `uploader_id`, `document_name`, `file_path`, `file_type`, `file_size`, `chapter`, `version`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 12, 'Catering Management for Jandices Catering Services (v1.0)', '/uploads/team_1/thesis_v1.0.pdf', 'application/pdf', 768789, 'Proposal', '1.0', 'Submitted', '2025-07-25 12:00:05', '2025-07-25 12:00:05');

-- --------------------------------------------------------

--
-- Table structure for table `document_feedback`
--

CREATE TABLE `document_feedback` (
  `feedback_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `reviewer_id` int(11) NOT NULL,
  `comments` text NOT NULL,
  `suggestions` text NOT NULL,
  `required_revisions` text NOT NULL,
  `chapter_no` enum('1','2','3','4','5','Proposal','Final') DEFAULT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document_feedback`
--

INSERT INTO `document_feedback` (`feedback_id`, `document_id`, `reviewer_id`, `comments`, `suggestions`, `required_revisions`, `chapter_no`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '123', '123', '123', 'Proposal', 'approved', '2025-07-26 12:00:09', '2025-07-26 12:00:09');

-- --------------------------------------------------------

--
-- Table structure for table `student_documents`
--
-- Error reading structure for table repository.student_documents: #1932 - Table &#039;repository.student_documents&#039; doesn&#039;t exist in engine
-- Error reading data for table repository.student_documents: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `repository`.`student_documents`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `setting_id` int(11) NOT NULL,
  `setting_name` varchar(50) NOT NULL,
  `setting_value` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`setting_id`, `setting_name`, `setting_value`, `description`, `updated_at`) VALUES
(1, 'max_team_members', '5', 'Maximum number of members per team', '2025-07-09 12:40:20'),
(2, 'min_team_members', '3', 'Minimum number of members required to form a team', '2025-07-09 12:40:20'),
(3, 'max_adviser_teams', '5', 'Maximum number of teams an adviser can supervise', '2025-07-09 12:40:20'),
(4, 'document_max_size_mb', '20', 'Maximum document upload size in MB', '2025-07-09 12:40:20'),
(5, 'title_proposal_deadline', '2023-12-15', 'Deadline for title proposal submissions', '2025-07-09 12:40:20');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `team_id` int(11) NOT NULL,
  `team_name` varchar(100) NOT NULL,
  `capstone_title` varchar(255) NOT NULL,
  `capstone_type` enum('Title Proposal','Capstone 1','Capstone 2') NOT NULL,
  `adviser_id` int(11) NOT NULL,
  `technical_id` int(11) DEFAULT NULL,
  `chairperson_id` int(11) DEFAULT NULL,
  `panelist_id` int(11) DEFAULT NULL,
  `major_id` int(11) DEFAULT NULL,
  `minor_id` int(11) DEFAULT NULL,
  `status` enum('Active','Completed','Archived') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`team_id`, `team_name`, `capstone_title`, `capstone_type`, `adviser_id`, `technical_id`, `chairperson_id`, `panelist_id`, `major_id`, `minor_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Catering Management Group', 'Catering Management for Jandices Catering Services', 'Title Proposal', 5, NULL, NULL, NULL, NULL, NULL, 'Active', '2025-07-24 04:07:53', '2025-07-26 06:12:55');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `membership_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` enum('leader','member') DEFAULT 'member',
  `join_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `member_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`membership_id`, `team_id`, `user_id`, `role`, `join_date`, `member_name`) VALUES
(1, 1, 6, 'leader', '2025-07-24 04:07:53', NULL),
(2, 1, 12, 'member', '2025-07-24 04:07:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `status_` varchar(50) NOT NULL,
  `dept` varchar(50) NOT NULL,
  `user_type` enum('student','admin','faculty') NOT NULL,
  `student_id` varchar(40) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `first_name`, `middle_name`, `last_name`, `status_`, `dept`, `user_type`, `student_id`, `specialization`, `created_at`, `updated_at`) VALUES
(3, 'user', 'pass', 'mcvilla@kld.edu.ph', 'John Mc ', 'Estanol', 'Villamor', 'active', 'BSIS', 'student', 'KLD-22-000401', NULL, '2025-07-09 13:35:29', '2025-07-09 13:35:29'),
(4, 'user2', 'pass', 'mcvilla1@kld.edu.ph', 'James Albert', 'Esta', 'VIllamor', 'active', 'BSIS', 'student', 'KLD-22-000402', NULL, '2025-07-09 13:35:29', '2025-07-09 13:35:29'),
(5, 'user3', 'pass', 'usersample@kld.edu.ph', 'Reggregor', 'Bautista', 'Villas', 'active', 'IMACS', 'faculty', 'KLD-22-000444', 'MIT', '2025-07-09 13:36:40', '2025-07-09 13:36:40'),
(6, 'user4', 'pass', 'jjj@kld.edu.ph', 'John Jelmer', 'Paldo', 'Datu', 'active', 'BSIS', 'student', 'KLD-22-000411', NULL, '2025-07-09 14:27:08', '2025-07-09 14:27:08'),
(7, 'user5', 'pass', 'user-kld@edu.ph', 'Mc Hail', 'Vesta', 'Cruz', 'active', 'BSIS', 'faculty', 'KLD-22-000433', NULL, '2025-07-10 00:49:47', '2025-07-16 15:16:53'),
(8, 'user6', 'pass', 'email-sample@kld.edu.ph', 'Jean', 'Monds', 'Tats', 'active', 'BSIS', 'student', 'KLD-22-002402', NULL, '2025-07-10 00:49:47', '2025-07-10 00:49:47'),
(11, 'user7', 'pass', 'emailnakld@kld.edu.ph', 'John', NULL, 'VIlla', 'active', 'BSIS', 'student', 'KLD-22-000422', NULL, '2025-07-12 11:44:37', '2025-07-12 11:44:37'),
(12, 'user8', 'pass', 'kldnaemailpa@kld.edu.ph', 'Jean', 'Bock', 'Estanol', 'active', 'BSIS', 'student', 'KLD-22-010444', NULL, '2025-07-12 11:44:37', '2025-07-12 11:44:37'),
(13, 'user10', 'pass', 'emailnakld.edu.ph', 'jayjay', 'Paldo', 'Datos', 'active', 'IMACS', 'student', NULL, NULL, '2025-07-19 05:39:40', '2025-07-19 05:39:40'),
(14, 'user11', 'PASS', 'halimbawa@kld.edu.ph', 'Jun', 'Jun', 'Vilajun', 'active', 'BSIS', 'student', 'KLD-22-010401', NULL, '2025-07-23 05:51:25', '2025-07-23 05:51:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `capstone_phases`
--
ALTER TABLE `capstone_phases`
  ADD PRIMARY KEY (`phase_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`document_id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `uploader_id` (`uploader_id`);

--
-- Indexes for table `document_feedback`
--
ALTER TABLE `document_feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `document_id` (`document_id`),
  ADD KEY `reviewer_id` (`reviewer_id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD UNIQUE KEY `setting_name` (`setting_name`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`team_id`),
  ADD UNIQUE KEY `unique_team_name` (`team_name`),
  ADD KEY `adviser_id` (`adviser_id`),
  ADD KEY `chairperson_id` (`chairperson_id`),
  ADD KEY `panelist_id` (`panelist_id`),
  ADD KEY `major_id` (`major_id`),
  ADD KEY `minor_id` (`minor_id`),
  ADD KEY `fk_teams_technical_user` (`technical_id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`membership_id`),
  ADD UNIQUE KEY `unique_member_per_team` (`user_id`,`team_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `capstone_phases`
--
ALTER TABLE `capstone_phases`
  MODIFY `phase_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `document_feedback`
--
ALTER TABLE `document_feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `membership_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `capstone_phases`
--
ALTER TABLE `capstone_phases`
  ADD CONSTRAINT `capstone_phases_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`team_id`) ON DELETE CASCADE;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`team_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documents_ibfk_2` FOREIGN KEY (`uploader_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `document_feedback`
--
ALTER TABLE `document_feedback`
  ADD CONSTRAINT `document_feedback_ibfk_1` FOREIGN KEY (`document_id`) REFERENCES `documents` (`document_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `document_feedback_ibfk_2` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `fk_teams_technical_user` FOREIGN KEY (`technical_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`adviser_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `teams_ibfk_2` FOREIGN KEY (`chairperson_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `teams_ibfk_3` FOREIGN KEY (`panelist_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `teams_ibfk_4` FOREIGN KEY (`major_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `teams_ibfk_5` FOREIGN KEY (`minor_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `team_members`
--
ALTER TABLE `team_members`
  ADD CONSTRAINT `team_members_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`team_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `team_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
