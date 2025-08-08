-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2025 at 10:56 AM
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
-- Table structure for table `def_dates`
--

CREATE TABLE `def_dates` (
  `id` int(11) NOT NULL,
  `defense_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `def_dates`
--

INSERT INTO `def_dates` (`id`, `defense_date`) VALUES
(1, '2025-08-06'),
(2, '2025-08-07'),
(3, '2025-08-08'),
(4, '2025-08-10'),
(5, '2025-08-11'),
(6, '2025-08-12'),
(7, '2025-08-13'),
(8, '2025-08-14'),
(9, '2025-08-15'),
(10, '2025-08-16'),
(13, '2025-08-20'),
(14, '2025-08-21'),
(12, '2025-08-22'),
(11, '2025-08-23');

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
(1, 1, 12, 'Catering Management for Jandices Catering Services (v1.0)', '/uploads/team_1/thesis_v1.0.pdf', 'application/pdf', 768789, 'Proposal', '1.0', 'Submitted', '2025-07-25 12:00:05', '2025-07-25 12:00:05'),
(2, 4, 3, '3d Mapping in Kolehiyo ng lungsod ng Dasma  (v1.0)', '/uploads/team_4/Production_Plan_Eggshell_Toothpaste_v1.0.pdf', 'application/pdf', 760308, 'Proposal', '1.0', 'Submitted', '2025-07-28 12:29:29', '2025-07-28 12:29:29'),
(3, 1, 12, 'Catering Management for Jandices Catering Services (v1.1)', '/uploads/team_1/capstone-repository-system_v1.1.pdf', 'application/pdf', 524701, 'Proposal', '1.1', 'Submitted', '2025-07-31 07:12:47', '2025-07-31 07:12:47'),
(4, 1, 6, 'Catering Management for Jandices Catering Services (v1.2)', '/uploads/team_1/thesis_v1.2.pdf', 'application/pdf', 768789, 'Proposal', '1.2', 'Submitted', '2025-08-03 11:22:53', '2025-08-03 11:22:53'),
(5, 1, 6, 'Catering Management for Jandices Catering Services (v1.3)', '/uploads/team_1/thesis_v1.3.pdf', 'application/pdf', 768789, 'Proposal', '1.3', 'Submitted', '2025-08-03 11:23:29', '2025-08-03 11:23:29'),
(6, 1, 12, 'Catering Management for Jandices Catering Services (v1.4)', '/uploads/team_1/CapsFinalReworkJimmyOnMayBayanihan_v1.4.pdf', 'application/pdf', 1353358, 'Proposal', '1.4', 'Submitted', '2025-08-04 12:54:40', '2025-08-04 12:54:40'),
(7, 1, 12, 'Catering Management for Jandices Catering Services (v1.5)', '/uploads/team_1/revision-for-mac_v1.5.pdf', 'application/pdf', 3889031, 'Proposal', '1.5', 'Submitted', '2025-08-05 06:50:00', '2025-08-05 06:50:00'),
(8, 1, 12, 'Catering Management for Jandices Catering Services (v1.6)', '/uploads/team_1/w2_DAVID_ANNEX_D_-_Daily_Time_Record_for_CFWP_-_HEI_benes[1]_v1.6.pdf', 'application/pdf', 277550, 'Proposal', '1.6', 'Submitted', '2025-08-05 08:12:40', '2025-08-05 08:12:40'),
(9, 1, 12, 'Catering Management for Jandices Catering Services (v1.7)', '/uploads/team_1/ISACEC Sports Attire-Signed_v1.7.pdf', 'application/pdf', 919814, 'Proposal', '1.7', 'Submitted', '2025-08-05 08:12:48', '2025-08-05 08:12:48'),
(10, 1, 12, 'Catering Management for Jandices Catering Services (v1.8)', '/uploads/team_1/Paper+11+(2024.6.5)+Mediating+Disputes+in…+IJLPS-1_v1.8.pdf', 'application/pdf', 321027, 'Proposal', '1.8', 'Submitted', '2025-08-05 08:12:57', '2025-08-05 08:12:57'),
(11, 3, 11, 'Development of Hotel Management System (v1.0)', '/uploads/team_3/ISACEC Sports Attire-Signed_v1.0.pdf', 'application/pdf', 919814, 'Proposal', '1.0', 'Submitted', '2025-08-06 09:50:46', '2025-08-06 09:50:46');

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
(1, 1, 5, '123', '123', '123', 'Proposal', 'approved', '2025-07-26 12:00:09', '2025-07-26 12:00:09'),
(2, 1, 5, '1234', '1234', '1234', 'Proposal', 'approved-minor', '2025-07-29 05:55:41', '2025-07-29 05:55:41'),
(3, 2, 5, '123', '123', '123', 'Proposal', 'approved', '2025-07-30 10:15:59', '2025-07-30 10:15:59'),
(4, 1, 5, '123', '123', '123', 'Proposal', 'approved', '2025-07-31 07:07:45', '2025-07-31 07:07:45'),
(5, 1, 5, 'asdfafs', 'asdfsadf', 'sadfsdfdsf', 'Proposal', 'retitle', '2025-07-31 07:08:13', '2025-07-31 07:08:13'),
(6, 1, 5, 'asdfsdaf', 'asdfsadf', 'aasdfsdfdsf', 'Proposal', 'approved', '2025-07-31 07:08:58', '2025-07-31 07:08:58'),
(7, 1, 5, 'asdfsdfdsf', 'asdfsdf', 'asdfsdfsdf', 'Proposal', 'approved', '2025-07-31 07:09:14', '2025-07-31 07:09:14'),
(8, 5, 7, 'asdasd', 'asds', 'asdasdads', 'Proposal', 'approved-major', '2025-08-04 12:06:19', '2025-08-04 12:06:19'),
(9, 7, 5, 'qwe', 'qwe', 'qwe', 'Proposal', 'approved', '2025-08-05 07:38:50', '2025-08-05 07:38:50'),
(10, 7, 5, '123123', '12321', '123123', 'Proposal', 'approved', '2025-08-05 07:39:43', '2025-08-05 07:39:43');

-- --------------------------------------------------------

--
-- Table structure for table `request_dates`
--

CREATE TABLE `request_dates` (
  `request_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `def_date` date NOT NULL,
  `def_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_dates`
--

INSERT INTO `request_dates` (`request_id`, `team_id`, `def_date`, `def_time`) VALUES
(9, 1, '2025-08-08', '17:12:00');

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
(1, 'Catering Management Group', 'Catering Management for Jandices Catering Services', 'Title Proposal', 5, 14, 7, 15, 5, 4, 'Active', '2025-07-24 04:07:53', '2025-08-08 06:40:32'),
(2, 'Repository Team', 'Development of Repository System for IMACS in KLD', 'Title Proposal', 5, 4, 5, 15, 7, 14, 'Active', '2025-07-28 05:47:33', '2025-08-04 11:38:05'),
(3, 'Hotel Management System', 'Development of Hotel Management System', 'Title Proposal', 5, 7, 5, 4, 14, 15, 'Active', '2025-07-28 05:49:51', '2025-08-05 06:25:00'),
(4, '3d Mapping', '3d Mapping in Kolehiyo ng lungsod ng Dasma ', 'Title Proposal', 5, 4, 5, 15, 7, 14, 'Active', '2025-07-28 06:06:32', '2025-08-06 13:28:02');

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
(2, 1, 12, 'member', '2025-07-24 04:07:53', NULL),
(3, 2, 13, 'leader', '2025-07-28 05:47:33', NULL),
(4, 2, 8, 'member', '2025-07-28 05:47:33', NULL),
(5, 3, 11, 'leader', '2025-07-28 05:49:51', NULL),
(6, 3, 4, 'member', '2025-07-28 05:49:51', NULL),
(7, 4, 14, 'leader', '2025-07-28 06:06:32', NULL);

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
  `user_type` enum('student','admin','faculty','coordinator') NOT NULL,
  `school_id` varchar(40) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `first_name`, `middle_name`, `last_name`, `status_`, `dept`, `user_type`, `school_id`, `specialization`, `created_at`, `updated_at`) VALUES
(3, 'user', 'pass', 'admin@gmail.com', 'John Mc ', 'Estanol', 'Villamor', 'active', 'BSIS', 'admin', 'KLD-22-000401', NULL, '2025-07-09 13:35:29', '2025-08-03 10:45:37'),
(4, 'user2', 'pass', 'mcvilla1@kld.edu.ph', 'James Albert', 'Esta', 'VIllamor', 'active', 'BSIS', 'coordinator', 'KLD-22-000402', NULL, '2025-07-09 13:35:29', '2025-08-03 16:08:36'),
(5, 'user3', 'pass', 'usersample@kld.edu.ph', 'Reggregor', 'Bautista', 'Villas', 'active', 'IMACS', 'faculty', 'KLD-22-000444', 'MIT', '2025-07-09 13:36:40', '2025-07-09 13:36:40'),
(6, 'user4', 'pass', 'jjj@kld.edu.ph', 'John Jelmer', 'Paldo', 'Datu', 'active', 'BSIS', 'student', 'KLD-22-000411', NULL, '2025-07-09 14:27:08', '2025-07-09 14:27:08'),
(7, 'user5', 'pass', 'user-kld@edu.ph', 'Mc Hail', 'Vesta', 'Cruz', 'active', 'BSIS', 'faculty', 'KLD-22-000433', NULL, '2025-07-10 00:49:47', '2025-07-16 15:16:53'),
(8, 'user6', 'pass', 'email-sample@kld.edu.ph', 'Jean', 'Monds', 'Tats', 'inactive', 'BSIS', 'student', 'KLD-22-002402', NULL, '2025-07-10 00:49:47', '2025-08-02 06:09:16'),
(11, 'user7', 'pass', 'un123213defined@gmail.com', 'John', '', 'VIlla', 'active', 'BSIS', 'student', 'KLD-22-000422', NULL, '2025-07-12 11:44:37', '2025-08-01 09:58:17'),
(12, 'user8', 'pass', 'kldnaemailpa@kld.edu.ph', 'Jean', 'Bock', 'Estanol', 'active', 'BSIS', 'student', 'KLD-22-010444', NULL, '2025-07-12 11:44:37', '2025-08-04 12:08:02'),
(13, 'user10', 'pass', 'emailnakld.edu.ph', 'jayjay', 'Paldo', 'Datos', 'inactive', 'IMACS', 'student', NULL, NULL, '2025-07-19 05:39:40', '2025-08-02 04:14:48'),
(14, 'user11', 'pass', 'undefined@gmail.com', 'Jun', 'Jun', 'Vilajun1', 'active', 'BSIS', 'faculty', 'KLD-22-010401', NULL, '2025-07-23 05:51:25', '2025-08-03 17:08:25'),
(15, 'regg', '$2y$10$l2k/Y/HToMGVhbRCif5bL.wanwF7NNUf07oawMeZ55Q2A127WDG2G', 'emackcoco08@gmail.com', 'Reggie', 'Mar', 'Decastro', 'active', 'BSIS', 'faculty', 'KLD-22-0004221', NULL, '2025-08-02 08:07:30', '2025-08-06 09:52:46'),
(17, 'user21', '$2y$10$N0eEWKniyE661vEngYGdcOzsH8qdce6B7atygOR0jU9j7ph.4UfQm', 'admin12312312@example.com', 'Mic', 'Check', 'Yo', 'active', 'BSIS3', '', 'KLD-22-0004012', NULL, '2025-08-02 08:21:34', '2025-08-06 09:52:50'),
(19, 'pass1', '$2y$10$iIjWMZ..QSRaEtdD7cagv.dwYbZTjSygo8iZbLAC3ZBrS40pm.3Vq', 'emailnakld@yahho.com', 'Jake', '', 'Jake', 'active', 'BSIS3', '', '1122233', NULL, '2025-08-02 08:23:56', '2025-08-06 09:52:53'),
(22, '123', '123', 'macvillamor02@yahoo.com', 'John', 'Estanol', 'Yo', 'active', 'BSIS', 'student', 'KLD-22-00040122222', NULL, '2025-08-05 08:28:16', '2025-08-05 08:28:58');

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
-- Indexes for table `def_dates`
--
ALTER TABLE `def_dates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `defense_date` (`defense_date`);

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
-- Indexes for table `request_dates`
--
ALTER TABLE `request_dates`
  ADD PRIMARY KEY (`request_id`),
  ADD UNIQUE KEY `team_id` (`team_id`);

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
  ADD UNIQUE KEY `student_id` (`school_id`),
  ADD UNIQUE KEY `school_id` (`school_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `capstone_phases`
--
ALTER TABLE `capstone_phases`
  MODIFY `phase_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `def_dates`
--
ALTER TABLE `def_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `document_feedback`
--
ALTER TABLE `document_feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `request_dates`
--
ALTER TABLE `request_dates`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `membership_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
