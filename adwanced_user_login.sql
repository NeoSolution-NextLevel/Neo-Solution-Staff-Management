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
Database: `user_login_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail_report`
--

CREATE TABLE `audit_trail_report` (
  `id` int NOT NULL,
  `ast` tinyint(1) DEFAULT NULL,
  `sdt` timestamp NULL DEFAULT NULL,
  `dis` varchar(4500) DEFAULT NULL,
  `main_user_login_id` int NOT NULL,
  `main_user_login_email_list_id` int(11) NOT NULL,
  `company_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int NOT NULL
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
  `id` int NOT NULL,
  `ast` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `ast`) VALUES
(1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_sms_link_manament`
--

CREATE TABLE `email_sms_link_manament` (
  `id` int NOT NULL,
  `state_of_view` tinyint(1) DEFAULT NULL,
  `on_short_lock` tinyint(1) DEFAULT NULL,
  `key_of_encript` varchar(450) DEFAULT NULL,
  `url_after_process` text DEFAULT NULL,
  `id_of_value` text DEFAULT NULL,
  `view_count` int(11) DEFAULT NULL,
  `state_email` tinyint(1) DEFAULT NULL,
  `state_sms` tinyint(1) DEFAULT NULL,
  `company_id` int NOT NULL,
  `branch_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_sms_link_view_history`
--

CREATE TABLE `email_sms_link_view_history` (
  `id` int NOT NULL,
  `sdt` timestamp NULL DEFAULT NULL,
  `ast` tinyint(1) DEFAULT NULL,
  `Email_SMS_link_manament_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `main_user_account_access_level_list`
--

CREATE TABLE `main_user_account_access_level_list` (
  `id` int NOT NULL,
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
(1, 'Admin', 1, '2026-08-06 05:18:39', 'UxUi/Admin_user_dashboard.php', 'Administrator', 1, 'ADMIN'),
(2, 'Employee', 1, '2026-08-06 05:18:39', 'UxUi/Employee_user_dashboard.php', 'Employee', 1, 'EMPLOYEE');

-- --------------------------------------------------------

--
-- Table structure for table `main_user_login`
--

CREATE TABLE `main_user_login` (
  `id` int NOT NULL,
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
  `id` int NOT NULL,
  `ast` tinyint(1) DEFAULT NULL,
  `sdt` timestamp NULL DEFAULT NULL,
  `device_type` varchar(45) DEFAULT NULL,
  `browser` varchar(45) DEFAULT NULL,
  `os` varchar(45) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `last_address` varchar(45) DEFAULT NULL,
  `last_activity` timestamp NULL DEFAULT NULL,
  `login_time` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `main_user_login_id` int(11) NOT NULL,
  `session_token` varchar(4500) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Daily employee activity. Employment status remains stored separately.
CREATE TABLE `daily_employee_presence` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `employee_profile_id` int DEFAULT NULL,
  `presence_date` date NOT NULL,
  `first_seen_at` datetime NOT NULL,
  `last_seen_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_presence_date` (`user_id`,`presence_date`),
  KEY `idx_presence_date` (`presence_date`),
  KEY `idx_presence_profile` (`employee_profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Employee-authored daily work plan, one editable plan per employee per day.
CREATE TABLE `daily_employee_work_plans` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `employee_profile_id` int DEFAULT NULL,
  `plan_date` date NOT NULL,
  `plan_text` text NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'submitted',
  `started_at` datetime DEFAULT NULL,
  `submitted_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_plan_date` (`user_id`,`plan_date`),
  KEY `idx_work_plan_date` (`plan_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_details`
--

CREATE TABLE `bank_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ast` varchar(10) DEFAULT '1',
  `sdt` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT 1,
  `employee_id` varchar(50) DEFAULT 'EMP-001',
  `employee_name` varchar(255) DEFAULT '',
  `holder_name` varchar(255) DEFAULT '',
  `bank_name` varchar(255) DEFAULT '',
  `branch` varchar(255) DEFAULT '',
  `bank_account_number` varchar(100) DEFAULT '',
  `account_number` varchar(100) DEFAULT '',
  `status` varchar(50) DEFAULT 'Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `main_user_login_email_list`
--

CREATE TABLE `main_user_login_email_list` (
  `id` int NOT NULL,
  `email_steate` tinyint(1) DEFAULT NULL,
  `key_of_email` varchar(4500) DEFAULT NULL,
  `ast` tinyint(1) DEFAULT NULL,
  `sdt` timestamp NULL DEFAULT NULL,
  `type_email` varchar(45) DEFAULT NULL,
  `main_user_login_id` int NOT NULL,
  `company_id` int NOT NULL
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
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `email_sms_link_manament`
--
ALTER TABLE `email_sms_link_manament`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_sms_link_view_history`
--
ALTER TABLE `email_sms_link_view_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `main_user_account_access_level_list`
--
ALTER TABLE `main_user_account_access_level_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `main_user_login`
--
ALTER TABLE `main_user_login`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `main_user_login_device`
--
ALTER TABLE `main_user_login_device`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `main_user_login_email_list`
--
ALTER TABLE `main_user_login_email_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

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

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ast` varchar(10) DEFAULT '1',
  `sdt` datetime DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(255) NOT NULL,
  `head` varchar(255) DEFAULT '',
  `employees` int DEFAULT 0,
  `color` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_roles`
--

CREATE TABLE IF NOT EXISTS `job_roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ast` varchar(10) DEFAULT '1',
  `sdt` datetime DEFAULT CURRENT_TIMESTAMP,
  `job_title` varchar(255) NOT NULL,
  `departments` varchar(255) DEFAULT '',
  `number_of_employees` int DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT 1,
  `employee_id` varchar(50) DEFAULT 'EMP-001',
  `employee_name` varchar(255) DEFAULT '',
  `doc_type` varchar(255) DEFAULT 'Document',
  `file_name` varchar(255) DEFAULT '',
  `file_path` varchar(500) DEFAULT '',
  `file_size` varchar(50) DEFAULT '1.0 MB',
  `status` varchar(50) DEFAULT 'Uploaded',
  `uploaded_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `ast` varchar(10) DEFAULT '1',
  `sdt` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE IF NOT EXISTS `leave_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ast` varchar(10) DEFAULT '1',
  `sdt` datetime DEFAULT CURRENT_TIMESTAMP,
  `employee_id` varchar(50) DEFAULT '',
  `employee_name` varchar(255) DEFAULT '',
  `leave_type` varchar(100) DEFAULT 'Annual Leave',
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `days` int DEFAULT 1,
  `reason` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `approved_by` varchar(255) DEFAULT NULL,
  `approved_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_management`
--

CREATE TABLE IF NOT EXISTS `task_management` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_title` varchar(255) NOT NULL,
  `department` varchar(255) DEFAULT '',
  `assigned_employee` varchar(255) DEFAULT '',
  `work_mode` varchar(50) DEFAULT 'Onsite',
  `deadline` varchar(100) DEFAULT '',
  `priority` varchar(50) DEFAULT 'Medium',
  `status` varchar(50) DEFAULT 'Pending',
  `ast` varchar(10) DEFAULT '1',
  `sdt` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_notifications`
--

CREATE TABLE IF NOT EXISTS `system_notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `recipient_role` varchar(50) DEFAULT 'admin',
  `recipient_name` varchar(150) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) DEFAULT 'general',
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings`
--

CREATE TABLE IF NOT EXISTS `admin_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) NOT NULL,
  `email_notifications` tinyint(1) NOT NULL DEFAULT 1,
  `task_updates` tinyint(1) NOT NULL DEFAULT 1,
  `leave_status` tinyint(1) NOT NULL DEFAULT 1,
  `system_alerts` tinyint(1) NOT NULL DEFAULT 0,
  `profile_visibility` tinyint(1) NOT NULL DEFAULT 1,
  `activity_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_admin_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_settings`
--

CREATE TABLE IF NOT EXISTS `employee_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) NOT NULL,
  `email_notifications` tinyint(1) NOT NULL DEFAULT 1,
  `task_updates` tinyint(1) NOT NULL DEFAULT 1,
  `leave_status` tinyint(1) NOT NULL DEFAULT 1,
  `system_alerts` tinyint(1) NOT NULL DEFAULT 0,
  `profile_visibility` tinyint(1) NOT NULL DEFAULT 1,
  `activity_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_employee_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_profiles`
--

CREATE TABLE IF NOT EXISTS `employee_profiles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `job_title` varchar(100) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `nic` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_phone` varchar(50) DEFAULT NULL,
  `employee_id_code` varchar(50) DEFAULT NULL,
  `employment_type` varchar(50) DEFAULT NULL,
  `work_location` varchar(100) DEFAULT NULL,
  `work_shift` varchar(100) DEFAULT NULL,
  `working_days` varchar(255) DEFAULT NULL,
  `weekly_roster` text DEFAULT NULL,
  `schedule_start_date` date DEFAULT NULL,
  `schedule_end_date` date DEFAULT NULL,
  `work_mode` varchar(100) DEFAULT NULL,
  `probation_status` varchar(100) DEFAULT NULL,
  `probation_start_date` date DEFAULT NULL,
  `probation_end_date` date DEFAULT NULL,
  `official_start_date` date DEFAULT NULL,
  `attendance_days` int DEFAULT 0,
  `last_attendance_date` date DEFAULT NULL,
  `profile_pic` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_payments`
--

CREATE TABLE IF NOT EXISTS `salary_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `receipt_no` varchar(50) NOT NULL,
  `employee_id` varchar(50) DEFAULT 'EMP-001',
  `user_id` int DEFAULT 1,
  `employee_name` varchar(255) DEFAULT '',
  `department` varchar(100) DEFAULT 'General',
  `job_title` varchar(100) DEFAULT 'Staff',
  `bank_name` varchar(255) DEFAULT '',
  `branch` varchar(255) DEFAULT '',
  `account_number` varchar(100) DEFAULT '',
  `basic_salary` decimal(12,2) DEFAULT 0.00,
  `allowances` decimal(12,2) DEFAULT 0.00,
  `deductions` decimal(12,2) DEFAULT 0.00,
  `epf_employee` decimal(12,2) DEFAULT 0.00,
  `net_salary` decimal(12,2) DEFAULT 0.00,
  `payment_month` varchar(50) DEFAULT '',
  `payment_date` date DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT 'Bank Transfer',
  `reference_no` varchar(100) DEFAULT '',
  `notes` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Paid',
  `paid_by` varchar(100) DEFAULT 'Admin',
  `ast` varchar(10) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_receipt_no` (`receipt_no`),
  KEY `idx_emp_id` (`employee_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_pay_month` (`payment_month`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;