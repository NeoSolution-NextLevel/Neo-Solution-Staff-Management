-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2026 at 07:27 AM
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
-- Database: `adwanced_user_login`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail_report`
--

CREATE TABLE `audit_trail_report` (
  `id` int(11) NOT NULL,
  `ast` tinyint(1) DEFAULT NULL,
  `sdt` timestamp NULL DEFAULT NULL,
  `dis` varchar(4500) DEFAULT NULL,
  `main_user_login_email_list_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `ast` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `ast`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `email_sms_link_manament`
--

CREATE TABLE `email_sms_link_manament` (
  `id` int(11) NOT NULL,
  `state_of_view` tinyint(1) DEFAULT NULL,
  `on_short_lock` tinyint(1) DEFAULT NULL,
  `key_of_encript` varchar(450) DEFAULT NULL,
  `url_after_process` text DEFAULT NULL,
  `id_of_value` text DEFAULT NULL,
  `view_count` int(11) DEFAULT NULL,
  `state_email` tinyint(1) DEFAULT NULL,
  `state_sms` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_sms_link_view_history`
--

CREATE TABLE `email_sms_link_view_history` (
  `id` int(11) NOT NULL,
  `sdt` timestamp NULL DEFAULT NULL,
  `ast` tinyint(1) DEFAULT NULL,
  `Email_SMS_link_manament_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `main_user_account_access_level_list`
--

CREATE TABLE `main_user_account_access_level_list` (
  `id` int(11) NOT NULL,
  `type_of_access` varchar(45) DEFAULT NULL,
  `ast` tinyint(1) DEFAULT NULL,
  `sdt` timestamp NULL DEFAULT NULL,
  `url_home` varchar(4500) DEFAULT NULL,
  `dis` varchar(4500) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `job_role` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `main_user_account_access_level_list`
--

INSERT INTO `main_user_account_access_level_list` (`id`, `type_of_access`, `ast`, `sdt`, `url_home`, `dis`, `company_id`, `job_role`) VALUES
(1, 'admin', 1, '2026-08-06 05:18:39', NULL, NULL, 1, 'ADMIN');

-- --------------------------------------------------------

--
-- Table structure for table `main_user_login`
--

CREATE TABLE `main_user_login` (
  `id` int(11) NOT NULL,
  `user_name` varchar(450) DEFAULT NULL,
  `password` varchar(450) DEFAULT NULL,
  `account_active_state` tinyint(1) DEFAULT NULL,
  `ast` tinyint(1) DEFAULT NULL,
  `sdt` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `name_show` varchar(45) DEFAULT NULL,
  `email_verify` tinyint(1) DEFAULT NULL,
  `moible_verfiy` tinyint(1) DEFAULT NULL,
  `very_first_login` tinyint(1) DEFAULT NULL,
  `cook_key` varchar(4500) DEFAULT NULL,
  `ref_key` varchar(45) DEFAULT NULL,
  `temp_lock` tinyint(1) DEFAULT NULL,
  `full_block` tinyint(1) DEFAULT NULL,
  `ac_type` varchar(45) DEFAULT NULL,
  `control_account_state` tinyint(1) DEFAULT NULL,
  `main_user_account_access_level_list_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `image_url` varchar(4500) DEFAULT NULL,
  `google_id` varchar(450) DEFAULT NULL,
  `google_authentication_secret` varchar(4500) DEFAULT NULL,
  `is_google_authentication_enable` tinyint(1) DEFAULT NULL,
  `microsoft_id` varchar(450) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `dis` varchar(200) DEFAULT NULL,
  `phone_number` varchar(45) DEFAULT NULL,
  `is_two_factor_auth_enable` tinyint(1) DEFAULT NULL,
  `wrong_login_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `main_user_login`
--

INSERT INTO `main_user_login` (`id`, `user_name`, `password`, `account_active_state`, `ast`, `sdt`, `last_login`, `name_show`, `email_verify`, `moible_verfiy`, `very_first_login`, `cook_key`, `ref_key`, `temp_lock`, `full_block`, `ac_type`, `control_account_state`, `main_user_account_access_level_list_id`, `company_id`, `image_url`, `google_id`, `google_authentication_secret`, `is_google_authentication_enable`, `microsoft_id`, `first_name`, `last_name`, `dis`, `phone_number`, `is_two_factor_auth_enable`, `wrong_login_count`) VALUES
(13, 'hakula@mailinator.com', 'bTRVVmp6NklrL0d3aWdQU0dFMjJ3dz09', 1, 1, '2026-08-06 01:49:19', '2026-08-06 01:49:19', 'Whoopi Wolfe', 0, 0, 0, ' ', 'Assumenda reprehende', 0, 0, 'Nemo sint aliqua En', 0, 1, 1, '', '', NULL, 0, '', 'Whoopi', 'Wolfe', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `main_user_login_device`
--

CREATE TABLE `main_user_login_device` (
  `id` int(11) NOT NULL,
  `ast` tinyint(1) DEFAULT NULL,
  `sdt` timestamp NULL DEFAULT NULL,
  `device_type` varchar(45) DEFAULT NULL,
  `browser` varchar(45) DEFAULT NULL,
  `os` varchar(45) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `last_activity` timestamp NULL DEFAULT NULL,
  `login_time` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `main_user_login_id` int(11) NOT NULL,
  `session_token` varchar(4500) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `main_user_login_email_list`
--

CREATE TABLE `main_user_login_email_list` (
  `id` int(11) NOT NULL,
  `email_steate` tinyint(1) DEFAULT NULL,
  `key_of_email` varchar(4500) DEFAULT NULL,
  `ast` tinyint(1) DEFAULT NULL,
  `sdt` timestamp NULL DEFAULT NULL,
  `type_email` varchar(45) DEFAULT NULL,
  `main_user_login_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_trail_report`
--
ALTER TABLE `audit_trail_report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_audit_trail_report_main_user_login_email_list1_idx` (`main_user_login_email_list_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_sms_link_manament`
--
ALTER TABLE `email_sms_link_manament`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_sms_link_view_history`
--
ALTER TABLE `email_sms_link_view_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Email_SMS_link_view_history_Email_SMS_link_manament1_idx` (`Email_SMS_link_manament_id`);

--
-- Indexes for table `main_user_account_access_level_list`
--
ALTER TABLE `main_user_account_access_level_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_main_user_account_access_level_list_company1_idx` (`company_id`);

--
-- Indexes for table `main_user_login`
--
ALTER TABLE `main_user_login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_main_user_login_main_user_account_access_level_list1_idx` (`main_user_account_access_level_list_id`),
  ADD KEY `fk_main_user_login_company1_idx` (`company_id`);

--
-- Indexes for table `main_user_login_device`
--
ALTER TABLE `main_user_login_device`
  ADD PRIMARY KEY (`id`,`main_user_login_id`),
  ADD KEY `fk_main_user_login_device_main_user_login1_idx` (`main_user_login_id`);

--
-- Indexes for table `main_user_login_email_list`
--
ALTER TABLE `main_user_login_email_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_main_user_login_email_list_main_user_login2_idx` (`main_user_login_id`),
  ADD KEY `fk_main_user_login_email_list_company1_idx` (`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_trail_report`
--
ALTER TABLE `audit_trail_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `email_sms_link_manament`
--
ALTER TABLE `email_sms_link_manament`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_sms_link_view_history`
--
ALTER TABLE `email_sms_link_view_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `main_user_account_access_level_list`
--
ALTER TABLE `main_user_account_access_level_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `main_user_login`
--
ALTER TABLE `main_user_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `main_user_login_device`
--
ALTER TABLE `main_user_login_device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `main_user_login_email_list`
--
ALTER TABLE `main_user_login_email_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_trail_report`
--
ALTER TABLE `audit_trail_report`
  ADD CONSTRAINT `fk_audit_trail_report_main_user_login_email_list1` FOREIGN KEY (`main_user_login_email_list_id`) REFERENCES `main_user_login_email_list` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `email_sms_link_view_history`
--
ALTER TABLE `email_sms_link_view_history`
  ADD CONSTRAINT `fk_Email_SMS_link_view_history_Email_SMS_link_manament1` FOREIGN KEY (`Email_SMS_link_manament_id`) REFERENCES `email_sms_link_manament` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `main_user_account_access_level_list`
--
ALTER TABLE `main_user_account_access_level_list`
  ADD CONSTRAINT `fk_main_user_account_access_level_list_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `main_user_login`
--
ALTER TABLE `main_user_login`
  ADD CONSTRAINT `fk_main_user_login_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_main_user_login_main_user_account_access_level_list1` FOREIGN KEY (`main_user_account_access_level_list_id`) REFERENCES `main_user_account_access_level_list` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `main_user_login_device`
--
ALTER TABLE `main_user_login_device`
  ADD CONSTRAINT `fk_main_user_login_device_main_user_login1` FOREIGN KEY (`main_user_login_id`) REFERENCES `main_user_login` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `main_user_login_email_list`
--
ALTER TABLE `main_user_login_email_list`
  ADD CONSTRAINT `fk_main_user_login_email_list_company1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_main_user_login_email_list_main_user_login2` FOREIGN KEY (`main_user_login_id`) REFERENCES `main_user_login` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;