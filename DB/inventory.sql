-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2023 at 10:21 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `role_type` tinyint(4) NOT NULL DEFAULT 0,
  `admin_type` tinyint(4) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `phone`, `email`, `email_verified_at`, `password`, `status`, `role_type`, `admin_type`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', NULL, 'admin@itsheba24.com', NULL, '$2y$10$HVUyZvMrzNf1OCsb9T1NZekDZ1YQlGzjWH7S6UnKBm6S2VoPkfgIe', 1, 5, 0, NULL, '2023-02-09 09:41:19', '2023-07-20 07:57:33'),
(2, 'Test-1', '01925588996', 'test@gmail.com', NULL, '$2y$10$ZKRqDlEslGhkdTADlhpmy.tL53lpHd1kH.betl9hS8mSIJYG1zbja', 1, 0, 0, NULL, '2023-02-20 09:42:26', '2023-05-31 10:32:10'),
(3, 'Test-2', '01925588996', 'test2@gmail.com', NULL, '$2y$10$azDztLED9ZR3yrmtAtqU3OjIThBBCLRWOZM.4c10VdwfaRKOo7uAi', 0, 0, 0, NULL, '2023-02-20 09:42:48', '2023-07-27 05:24:36'),
(4, 'Test-4', '01925588996', 'test4@gmail.com', NULL, '$2y$10$lg8z8DsWlCWoGlrbHDm2a.gL9rn4GlSaEaVptZhIb4I/t2hHVa1BC', 1, 0, 0, NULL, '2023-02-20 12:09:30', '2023-07-30 07:26:28'),
(5, 'Test-3', '01925588996', 'testsdasd@gmail.com', NULL, '$2y$10$cqUsH5dHYMQ2N7wX8ZhnLOE7cFKS7yjQej.h9eIsoeXy4iSCRFgF.', 1, 0, 0, NULL, '2023-05-21 07:31:24', '2023-05-31 10:32:33'),
(6, 'Sabbir Hossain', '01925588996', 'sabbir.office.it@gmail.com', NULL, '$2y$10$tifFOFbSekiURHe2x8Zcg.T6SC85bluf07EKVGA48PTMHkRenEGLC', 1, 0, 0, NULL, '2023-07-20 04:47:13', '2023-08-13 12:47:05');

-- --------------------------------------------------------

--
-- Table structure for table `admin_details`
--

CREATE TABLE `admin_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `card_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `b_group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `family_mn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `family_mp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joining_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_details`
--

INSERT INTO `admin_details` (`id`, `admin_id`, `card_no`, `designation_id`, `department_id`, `company_id`, `nid_id`, `dob`, `gender`, `religion`, `b_group`, `tin`, `address`, `ref_by`, `family_mn`, `family_mp`, `source`, `joining_date`, `admin_note`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'sup-001', '1', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1690461178.jpg', '2023-02-09 09:41:19', '2023-07-27 12:32:58'),
(2, 2, 'emp-001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-20 09:42:26', '2023-05-31 10:32:10'),
(3, 3, 'emp-0012', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-20 09:42:48', '2023-07-27 05:24:36'),
(4, 4, 'emp-004', '1', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-02-20 12:09:30', '2023-07-30 07:26:28'),
(5, 5, 'emp-00111', '3', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1690461170.jpg', '2023-05-21 07:31:24', '2023-07-30 07:26:15'),
(6, 6, 'sab-001', '1', '1', '1', '466546464', '30-07-2023', '1', '1', '1', 'sss', 'Dhaka,Bangladesh', 'adasdUpdate', 'sss', 'ss', 'sss', '04-07-2023', 'xcfdsfdsfsd', '1690461162.jpg', '2023-07-20 04:47:13', '2023-08-13 12:47:05');

-- --------------------------------------------------------

--
-- Table structure for table `blood_groups`
--

CREATE TABLE `blood_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bloodgroup_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blood_groups`
--

INSERT INTO `blood_groups` (`id`, `bloodgroup_name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'A+', 1, 1, 1, '2023-07-26 05:22:49', '2023-07-26 05:22:49');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Electronic', 1, 1, 1, '2023-02-23 09:45:27', '2023-02-23 09:45:27'),
(2, 'Food', 1, 1, 1, '2023-06-22 06:37:31', '2023-06-22 06:37:31');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'B', 1, 1, 1, '2023-05-31 04:28:38', '2023-05-31 04:28:38');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_name`, `email`, `phone`, `address`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'a', 'admin@itsheba24.com', '01925588996', 'ghdtfhft', 0, 1, 1, '2023-02-23 06:52:20', '2023-04-30 05:48:06'),
(2, 'as', 'test@gmail.com', '12312', 'ghdtfhftUpdate', 0, 1, 1, '2023-02-23 06:52:35', '2023-02-23 06:52:35'),
(3, 'dsadsa', 'test@gmail.com', '01925588996', 'ghdtfhft', 1, 1, 1, '2023-02-23 06:52:51', '2023-02-23 06:52:51'),
(4, 'dsadsa', 'test@gmail.com', '01925588996', NULL, 0, 1, 1, '2023-02-23 06:53:08', '2023-02-23 06:53:08'),
(5, NULL, NULL, '01925588996', NULL, 0, 1, 1, '2023-02-23 06:53:14', '2023-02-23 06:53:14'),
(6, NULL, NULL, '01925588996', NULL, 0, 1, 1, '2023-02-23 06:53:20', '2023-02-23 06:53:20'),
(7, NULL, NULL, '01925588996', NULL, 0, 1, 1, '2023-02-23 06:53:24', '2023-02-23 06:53:24'),
(8, NULL, NULL, '8765875687', NULL, 0, 1, 1, '2023-02-23 06:53:28', '2023-02-23 06:53:28'),
(9, NULL, NULL, '8765875687', NULL, 0, 1, 1, '2023-02-23 06:53:33', '2023-02-23 06:53:33'),
(10, NULL, NULL, '01925588996', NULL, 0, 1, 1, '2023-02-23 06:53:37', '2023-02-23 06:53:37'),
(12, NULL, 'test@gmail.com', '01925588996', NULL, 1, 1, 1, '2023-02-23 06:53:51', '2023-04-30 07:00:31'),
(13, NULL, NULL, '01925588996', NULL, 0, 1, 1, '2023-04-30 09:23:26', '2023-04-30 09:23:26'),
(14, NULL, NULL, '34324', NULL, 0, 1, 1, '2023-04-30 09:23:32', '2023-04-30 09:23:32'),
(15, 'dsadsa', 'admin@itsheba24.com', '01925588996', 'ghdtfhft', 1, 1, 1, '2023-04-30 09:50:27', '2023-04-30 09:50:27'),
(16, 'dsadsa', 'test@gmail.com', '01925588996', 'Dhaka,Bangladesh', 0, 1, 1, '2023-04-30 09:50:56', '2023-04-30 09:50:56'),
(17, 'as', 'test2@gmail.com', '8765875687', 'Dhaka,Bangladesh', 1, 1, 1, '2023-04-30 09:51:29', '2023-04-30 09:51:29'),
(18, 'dsadsa', 'test3@gmail.com', '01925588996', 'Dhaka,Bangladesh', 1, 1, 1, '2023-04-30 09:52:41', '2023-04-30 09:52:41'),
(19, 'dsadsa', 'admin@itsheba24.com', '01925588996', 'Dhaka,Bangladesh', 1, 1, 1, '2023-04-30 09:56:33', '2023-04-30 09:56:33'),
(20, 'as', 'test@gmail.com', '8765875687', 'Dhaka,Bangladesh', 1, 1, 1, '2023-04-30 10:00:22', '2023-04-30 10:00:22'),
(21, 'as', 'test2@gmail.com', '8765875687', 'ghdtfhftUpdate', 1, 1, 1, '2023-04-30 10:01:12', '2023-04-30 10:01:12'),
(22, 'as', 'test@gmail.com', '12312', 'Dhaka,Bangladesh', 1, 1, 1, '2023-04-30 10:01:40', '2023-04-30 10:01:40'),
(23, 'dsadsa', 'test@gmail.com', '01925588996', 'Dhaka,Bangladesh', 1, 1, 1, '2023-04-30 10:05:34', '2023-04-30 10:05:34'),
(24, 'dsadsa', 'admin@itsheba24.com', '01925588996', 'ghdtfhft', 1, 1, 1, '2023-04-30 10:05:56', '2023-04-30 10:05:56'),
(25, 'as', 'test@gmail.com', '01925588996', 'Dhaka,Bangladesh', 1, 1, 1, '2023-04-30 10:07:13', '2023-04-30 10:07:13'),
(26, 'dsadsa', 'test@gmail.com', '01925588996', 'Dhaka,Bangladesh', 1, 1, 1, '2023-04-30 10:07:45', '2023-04-30 10:07:45'),
(27, 'dsadsa', 'admin@itsheba24.com', '01925588996', 'ghdtfhft', 1, 1, 1, '2023-04-30 10:09:12', '2023-04-30 10:09:12'),
(28, 'i', 'test@gmail.com', '01925588996', 'Dhaka,Bangladesh', 1, 1, 1, '2023-04-30 10:17:20', '2023-04-30 10:17:20'),
(29, NULL, NULL, '01925588996', NULL, 1, 1, 1, '2023-04-30 10:17:27', '2023-04-30 10:17:27'),
(30, 'Asif', 'asif@gmail.com', '01925558996', 'Dhaka,Bangladesh', 1, 1, 1, '2023-04-30 10:52:55', '2023-04-30 10:52:55'),
(31, 'Maruf', NULL, '01925588996', NULL, 1, 1, 1, '2023-04-30 11:06:58', '2023-04-30 11:06:58'),
(32, 'Ariyan', 'ariyan@gmail.com', '01925588922', 'Dhaka,Bangladesh', 1, 1, 1, '2023-05-01 04:03:17', '2023-05-02 11:52:36'),
(33, 'A', 'a@itsheba24.com', '01925588333', 'Dhaka,Bangladesh', 1, 1, 1, '2023-05-01 04:28:49', '2023-05-01 04:28:49'),
(34, 'dsadsa', 'test@gmail.com', '01925588996', 'ghdtfhft', 1, 1, 1, '2023-05-24 06:45:57', '2023-05-24 06:45:57'),
(35, 'Asif', 'asif@gmail.com', '01925588996', 'ghdtfhft', 1, 1, 1, '2023-05-29 10:05:56', '2023-05-29 10:05:56'),
(36, 'Salman', 'salman@gmail.com', '019646464464', 'Dhaka,Bangladesh', 1, 1, 1, '2023-06-07 10:47:54', '2023-06-07 10:47:54'),
(37, NULL, NULL, '01925588996', NULL, 1, 1, 1, '2023-06-13 06:13:23', '2023-06-13 06:13:23'),
(38, NULL, NULL, '01925588996', NULL, 1, 1, 1, '2023-06-13 06:13:28', '2023-06-13 06:13:28'),
(39, 'Test', NULL, '01925588996', NULL, 1, 1, 1, '2023-06-24 04:37:37', '2023-06-24 04:37:37'),
(40, 'Shorifa Begum', NULL, '00000000000', NULL, 1, 1, 4, '2023-07-03 18:56:34', '2023-07-18 10:20:21'),
(43, 'Demo', NULL, '01925588996', NULL, 1, 6, 6, '2023-07-20 06:06:08', '2023-07-20 06:06:08'),
(44, 'Adnan Babu', 'adnan@gmail.com', '000000', NULL, 1, 1, 1, '2023-10-22 09:12:48', '2023-10-22 09:12:48'),
(45, 'Asif', 'asif@gmail.com', '0000000', NULL, 1, 1, 1, '2023-10-23 04:07:28', '2023-10-23 04:07:28');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Management', 1, 1, 1, '2023-05-31 04:28:24', '2023-07-30 06:17:57'),
(2, 'Technical Department', 1, 1, 1, '2023-07-30 07:25:14', '2023-07-30 07:25:14');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `designation_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `designation_name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'General Manager', 1, 1, 1, '2023-05-31 04:28:15', '2023-07-30 06:17:06'),
(2, 'Software Engg.', 1, 1, 1, '2023-07-30 07:24:16', '2023-07-30 07:25:46'),
(3, 'Graphic Designer', 1, 1, 1, '2023-07-30 07:24:35', '2023-07-30 07:24:35');

-- --------------------------------------------------------

--
-- Table structure for table `expense_manages`
--

CREATE TABLE `expense_manages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expense_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expense_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_manages`
--

INSERT INTO `expense_manages` (`id`, `expense_date`, `store_id`, `expense_type`, `cost`, `description`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(9, '2023-06-21', '11', '1', '323', 'sadfdsa', 1, 1, 1, '2023-06-21 12:27:12', '2023-06-21 12:27:12'),
(10, '2023-06-22', '6', '1', '10', 'ww', 1, 1, 1, '2023-06-22 11:15:40', '2023-06-22 11:15:40'),
(11, '2023-07-20', '6', '1', '200', NULL, 0, 6, 6, '2023-07-20 06:22:37', '2023-07-20 06:22:37'),
(12, '2023-07-24', '6', '1', '200', NULL, 0, 1, 1, '2023-07-24 11:08:17', '2023-07-24 11:08:17'),
(13, '2023-07-24', '6', '1', '300', NULL, 0, 1, 1, '2023-07-24 11:08:27', '2023-07-24 11:08:27'),
(14, '2023-07-25', '6', '1', '100', NULL, 0, 1, 1, '2023-07-25 07:19:08', '2023-07-25 07:19:08'),
(15, '2023-07-26', '6', '1', '100', NULL, 0, 1, 1, '2023-07-26 12:25:22', '2023-07-26 12:25:22');

-- --------------------------------------------------------

--
-- Table structure for table `expense_types`
--

CREATE TABLE `expense_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_types`
--

INSERT INTO `expense_types` (`id`, `type_name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Handcash', 1, 1, 1, '2023-05-18 05:27:13', '2023-05-18 05:27:13');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_no`, `store_id`, `date`, `description`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '1686562429', '6', '2023-06-12', NULL, 2, 1, 1, '2023-06-12 09:33:49', '2023-06-13 04:17:35'),
(2, '3373127100', '6', '2023-06-12', 'lkjlk', 2, 1, 1, '2023-06-12 10:11:11', '2023-06-13 04:15:06'),
(3, '5059757762', '6', '2023-06-13', NULL, 2, 1, 1, '2023-06-13 04:31:02', '2023-06-13 08:51:31'),
(4, '6746395724', '6', '2023-06-13', NULL, 1, 1, 1, '2023-06-13 06:32:42', '2023-06-13 06:32:42'),
(5, '8433054730', '6', '2023-06-13', NULL, 2, 1, 1, '2023-06-13 12:23:26', '2023-06-13 12:29:19'),
(6, '10119772314', '6', '2023-06-14', 'dsf', 1, 1, 1, '2023-06-14 04:39:44', '2023-06-13 18:00:00'),
(7, '11806503281', '11', '2023-05-01', NULL, 1, 1, 1, '2023-06-14 08:22:47', '2023-06-14 08:22:47'),
(8, '13493234331', '11', '2023-06-14', NULL, 1, 1, 1, '2023-06-14 08:24:10', '2023-06-14 08:24:10'),
(9, '15179965685', '11', '2023-06-14', NULL, 1, 1, 1, '2023-06-14 08:29:14', '2023-06-14 08:29:14'),
(10, '16866707127', '6', '2023-06-14', NULL, 1, 1, 1, '2023-06-14 11:17:22', '2023-06-14 11:17:22'),
(11, '18553448581', '6', '2023-06-14', NULL, 1, 1, 1, '2023-06-14 11:17:34', '2023-06-14 11:17:34'),
(12, '20240190051', '6', '2023-06-14', NULL, 1, 1, 1, '2023-06-14 11:17:50', '2023-06-14 11:17:50'),
(13, '21926931534', '6', '2023-06-14', NULL, 1, 1, 1, '2023-06-14 11:18:03', '2023-06-14 11:18:03'),
(14, '23613735311', '6', '2023-06-15', NULL, 1, 1, 1, '2023-06-15 04:36:17', '2023-06-15 04:36:17'),
(15, '25300539103', '6', '2023-06-15', NULL, 1, 1, 1, '2023-06-15 04:36:32', '2023-06-15 04:36:32'),
(16, '26987349828', '11', '2023-06-15', NULL, 1, 1, 1, '2023-06-15 06:32:05', '2023-06-15 06:32:05'),
(17, '28674411860', '6', '2023-06-18', NULL, 1, 1, 1, '2023-06-18 04:20:32', '2023-06-18 04:20:32'),
(18, '30361559210', '6', '2023-06-19', NULL, 1, 1, 1, '2023-06-19 04:02:30', '2023-06-19 04:02:30'),
(19, '32048713150', '6', '2023-06-19', NULL, 1, 1, 1, '2023-06-19 05:52:21', '2023-06-19 05:52:21'),
(20, '33735951160', '6', '2023-06-20', NULL, 1, 1, 1, '2023-06-20 05:13:30', '2023-06-20 05:13:30'),
(21, '35423290353', '6', '2023-06-21', NULL, 1, 1, 1, '2023-06-21 09:19:53', '2023-06-21 09:19:53'),
(22, '37110717791', '6', '2023-06-22', NULL, 1, 1, 1, '2023-06-22 09:50:38', '2023-06-22 09:50:38'),
(23, '38798299303', '14', '2023-06-24', NULL, 1, 1, 1, '2023-06-24 04:38:32', '2023-06-23 18:00:00'),
(24, '40486709962', '6', '2023-07-04', NULL, 1, 1, 1, '2023-07-03 18:57:39', '2023-07-03 18:57:39'),
(25, '42176543160', '6', '2023-07-20', NULL, 1, 6, 6, '2023-07-20 06:06:38', '2023-07-19 18:00:00'),
(26, '43866717492', '6', '2023-07-24', NULL, 1, 1, 1, '2023-07-24 04:52:12', '2023-07-24 04:52:12'),
(27, '45556891850', '6', '2023-07-24', NULL, 1, 1, 1, '2023-07-24 04:52:38', '2023-07-24 04:52:38'),
(28, '47247066242', '6', '2023-07-24', NULL, 2, 1, 1, '2023-07-24 04:53:12', '2023-07-24 04:53:24'),
(29, '48937327518', '6', '2023-07-25', NULL, 2, 1, 1, '2023-07-25 05:01:16', '2023-07-25 05:01:49'),
(30, '50627588898', '6', '2023-07-25', NULL, 1, 1, 1, '2023-07-25 05:03:00', '2023-07-25 05:03:00'),
(31, '52317856627', '6', '2023-07-25', NULL, 1, 1, 1, '2023-07-25 06:48:49', '2023-07-25 06:48:49'),
(32, '54008124403', '6', '2023-07-25', NULL, 1, 1, 1, '2023-07-25 06:49:36', '2023-07-25 06:49:36'),
(33, '55698400069', '6', '2023-07-25', NULL, 1, 1, 1, '2023-07-25 09:01:06', '2023-07-25 09:01:06'),
(34, '57388770363', '6', '2023-07-26', NULL, 1, 1, 1, '2023-07-26 11:18:14', '2023-07-26 11:18:14'),
(35, '59079143507', '11', '2023-07-26', NULL, 2, 1, 1, '2023-07-26 12:05:44', '2023-07-26 12:29:22'),
(36, '60769600868', '6', '2023-07-27', NULL, 1, 1, 1, '2023-07-27 11:29:21', '2023-10-14 18:00:00'),
(37, '62460309211', '6', '2023-07-30', NULL, 2, 1, 1, '2023-07-30 09:12:23', '2023-07-30 09:17:14'),
(38, '64157676707', '6', '2023-10-15', NULL, 1, 1, 1, '2023-10-15 10:58:16', '2023-10-14 18:00:00'),
(39, '65855048734', '6', '2023-10-15', NULL, 1, 1, 1, '2023-10-15 12:13:47', '2023-10-14 18:00:00'),
(40, '67552481234', '6', '2023-10-16', NULL, 1, 1, 1, '2023-10-16 05:01:40', '2023-10-15 18:00:00'),
(41, '69249914413', '6', '2023-10-16', NULL, 1, 1, 1, '2023-10-16 05:12:59', '2023-10-15 18:00:00'),
(42, '70947620666', '6', '2023-10-19', NULL, 1, 1, 1, '2023-10-19 09:04:13', '2023-10-19 09:04:13'),
(43, '72645327135', '6', '2023-10-19', NULL, 1, 1, 1, '2023-10-19 09:07:49', '2023-10-19 09:07:49'),
(44, '74343034852', '6', '2023-10-19', NULL, 1, 1, 1, '2023-10-19 09:28:37', '2023-10-19 09:28:37'),
(45, '76041001093', '6', '2023-10-22', NULL, 1, 1, 1, '2023-10-22 09:17:21', '2023-10-22 09:17:21'),
(46, '77739035200', '6', '2023-10-23', NULL, 1, 1, 1, '2023-10-23 04:08:27', '2023-10-23 04:08:27');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `unit_price` double DEFAULT NULL,
  `unit_discount` double DEFAULT NULL,
  `unit_price_wd` double DEFAULT NULL,
  `selling_price_wod` double DEFAULT NULL,
  `selling_price_wd` double DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`id`, `date`, `invoice_id`, `product_id`, `product_name`, `qty`, `unit_price`, `unit_discount`, `unit_price_wd`, `selling_price_wod`, `selling_price_wd`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '2023-06-12', 1, '29', 'Iphone12', 4, 6, 2, 5.88, 24, 23.52, 1, 1, 1, '2023-06-12 09:33:49', '2023-06-12 09:33:49'),
(2, '2023-06-12', 1, '32', 'Iphone6', 3, 12, 1, 11.88, 36, 35.64, 1, 1, 1, '2023-06-12 09:33:49', '2023-06-12 09:33:49'),
(3, '2023-06-12', 2, '33', 'Iphone7', 5, 20, 2, 19.6, 100, 98, 1, 1, 1, '2023-06-12 10:11:11', '2023-06-12 10:11:11'),
(4, '2023-06-12', 2, '33', 'Iphone7', 1, 20, 2, 19.6, 20, 19.6, 2, 1, 1, '2023-06-12 10:14:53', '2023-06-12 10:14:53'),
(5, '2023-06-12', 2, '33', 'Iphone7', 1, 20, 2, 19.6, 20, 19.6, 2, 1, 1, '2023-06-12 10:15:06', '2023-06-12 10:15:06'),
(6, '2023-06-13', 3, '33', 'Iphone7', 2, 20, 2, 19.6, 40, 39.2, 1, 1, 1, '2023-06-13 04:31:02', '2023-06-13 04:31:02'),
(7, '2023-06-13', 3, '34', 'Iphone8', 3, 10, 4, 9.6, 30, 28.8, 1, 1, 1, '2023-06-13 04:31:02', '2023-06-13 04:31:02'),
(8, '2023-06-13', 3, '33', 'Iphone7', 1, 20, 2, 19.6, 20, 19.6, 2, 1, 1, '2023-06-13 04:31:56', '2023-06-13 04:31:56'),
(9, '2023-06-13', 3, '34', 'Iphone8', 1, 10, 4, 9.6, 10, 9.6, 2, 1, 1, '2023-06-13 04:31:56', '2023-06-13 04:31:56'),
(10, '2023-06-13', 4, '32', 'Iphone6', 1, 12, 1, 11.88, 12, 11.88, 1, 1, 1, '2023-06-13 06:32:42', '2023-06-13 06:32:42'),
(11, '2023-06-13', 5, '27', 'Xiaomi-2', 5, 10, 4, 9.6, 50, 48, 1, 1, 1, '2023-06-13 12:23:26', '2023-06-13 12:23:26'),
(12, '2023-06-13', 5, '27', 'Xiaomi-2', 2, 10, 4, 9.6, 20, 19.2, 2, 1, 1, '2023-06-13 12:26:56', '2023-06-13 12:26:56'),
(13, '2023-06-14', 6, '27', 'Xiaomi-2', 2, 10, 4, 9.6, 20, 19.2, 1, 1, 1, '2023-06-14 04:39:44', '2023-06-14 04:39:44'),
(14, '2023-06-14', 6, '32', 'Iphone6', 3, 12, 1, 11.88, 36, 35.64, 1, 1, 1, '2023-06-14 04:39:44', '2023-06-14 04:39:44'),
(15, '2023-06-14', 7, '35', 'Iphone9', 10, 10, 0, 10, 100, 100, 1, 1, 1, '2023-06-14 08:22:47', '2023-06-14 08:22:47'),
(16, '2023-06-14', 8, '35', 'Iphone9', 10, 10, 0, 10, 100, 100, 1, 1, 1, '2023-06-14 08:24:10', '2023-06-14 08:24:10'),
(17, '2023-06-14', 9, '35', 'Iphone9', 1, 10, 0, 10, 10, 10, 1, 1, 1, '2023-06-14 08:29:14', '2023-06-14 08:29:14'),
(18, '2023-06-14', 6, '32', 'Iphone6', 1, 12, 1, 11.88, 12, 11.88, 2, 1, 1, '2023-06-14 11:10:22', '2023-06-14 11:10:22'),
(19, '2023-06-14', 6, '32', 'Iphone6', 2, 12, 1, 11.88, 24, 23.76, 2, 1, 1, '2023-06-14 11:11:34', '2023-06-14 11:11:34'),
(20, '2023-06-14', 10, '32', 'Iphone6', 1, 12, 1, 11.88, 12, 11.88, 1, 1, 1, '2023-06-14 11:17:22', '2023-06-14 11:17:22'),
(21, '2023-06-14', 11, '33', 'Iphone7', 1, 20, 2, 19.6, 20, 19.6, 1, 1, 1, '2023-06-14 11:17:34', '2023-06-14 11:17:34'),
(22, '2023-06-14', 12, '33', 'Iphone7', 1, 20, 2, 19.6, 20, 19.6, 1, 1, 1, '2023-06-14 11:17:50', '2023-06-14 11:17:50'),
(23, '2023-06-14', 13, '33', 'Iphone7', 1, 20, 2, 19.6, 20, 19.6, 1, 1, 1, '2023-06-14 11:18:03', '2023-06-14 11:18:03'),
(24, '2023-06-15', 14, '27', 'Xiaomi-2', 1, 10, 4, 9.6, 10, 9.6, 1, 1, 1, '2023-06-15 04:36:17', '2023-06-15 04:36:17'),
(25, '2023-06-15', 15, '34', 'Iphone8', 1, 10, 4, 9.6, 10, 9.6, 1, 1, 1, '2023-06-15 04:36:32', '2023-06-15 04:36:32'),
(26, '2023-06-15', 16, '35', 'Iphone9', 1, 10, 0, 10, 10, 10, 1, 1, 1, '2023-06-15 06:32:05', '2023-06-15 06:32:05'),
(27, '2023-06-18', 17, '32', 'Iphone6', 5, 12, 1, 11.88, 60, 59.4, 1, 1, 1, '2023-06-18 04:20:32', '2023-06-18 04:20:32'),
(28, '2023-06-19', 18, '32', 'Iphone6', 1, 12, 1, 11.88, 12, 11.88, 1, 1, 1, '2023-06-19 04:02:30', '2023-06-19 04:02:30'),
(29, '2023-06-19', 19, '33', 'Iphone7', 5, 20, 2, 19.6, 100, 98, 1, 1, 1, '2023-06-19 05:52:21', '2023-06-19 05:52:21'),
(30, '2023-06-20', 20, '27', 'Xiaomi-2', 1, 11.98, 4, 11.5008, 11.98, 11.5008, 1, 1, 1, '2023-06-20 05:13:30', '2023-06-20 05:13:30'),
(31, '2023-06-21', 21, '27', 'Xiaomi-2', 2, 5, 4, 4.8, 10, 9.6, 1, 1, 1, '2023-06-21 09:19:53', '2023-06-21 09:19:53'),
(32, '2023-06-22', 22, '37', 'Demo', 1, 20, 2, 19.6, 20, 19.6, 1, 1, 1, '2023-06-22 09:50:38', '2023-06-22 09:50:38'),
(33, '2023-06-24', 23, '27', 'Xiaomi-2', 2, 20, 0, 20, 40, 40, 1, 1, 1, '2023-06-24 04:38:32', '2023-06-24 04:38:32'),
(34, '2023-06-24', 23, '35', 'Iphone9', 2, 10, 2, 9.8, 20, 19.6, 1, 1, 1, '2023-06-24 04:38:32', '2023-06-24 04:38:32'),
(35, '2023-06-24', 23, '27', 'Xiaomi-2', 1, 20, 0, 20, 20, 20, 2, 1, 1, '2023-06-24 09:42:51', '2023-06-24 09:42:51'),
(36, '2023-07-04', 24, '27', 'Xiaomi-2', 10, 5, 4, 4.8, 50, 48, 1, 1, 1, '2023-07-03 18:57:39', '2023-07-03 18:57:39'),
(37, '2023-07-20', 25, '27', 'Xiaomi-2', 1, 5, 4, 4.8, 5, 4.8, 1, 6, 6, '2023-07-20 06:06:38', '2023-07-20 06:06:38'),
(38, '2023-07-24', 26, '25', 'dsad', 1, 10.5, 0, 10.5, 10.5, 10.5, 1, 1, 1, '2023-07-24 04:52:12', '2023-07-24 04:52:12'),
(39, '2023-07-24', 27, '27', 'Xiaomi-2', 1, 5, 4, 4.8, 5, 4.8, 1, 1, 1, '2023-07-24 04:52:38', '2023-07-24 04:52:38'),
(40, '2023-07-24', 28, '32', 'Iphone6', 1, 12, 1, 11.88, 12, 11.88, 1, 1, 1, '2023-07-24 04:53:12', '2023-07-24 04:53:12'),
(41, '2023-07-25', 29, '27', 'Xiaomi-2', 2, 5, 4, 4.8, 10, 9.6, 1, 1, 1, '2023-07-25 05:01:16', '2023-07-25 05:01:16'),
(42, '2023-07-25', 30, '27', 'Xiaomi-2', 1, 5, 4, 4.8, 5, 4.8, 1, 1, 1, '2023-07-25 05:03:00', '2023-07-25 05:03:00'),
(43, '2023-07-25', 31, '27', 'Xiaomi-2', 2, 5, 4, 4.8, 10, 9.6, 1, 1, 1, '2023-07-25 06:48:49', '2023-07-25 06:48:49'),
(44, '2023-07-25', 32, '27', 'Xiaomi-2', 2, 5, 4, 4.8, 10, 9.6, 1, 1, 1, '2023-07-25 06:49:36', '2023-07-25 06:49:36'),
(45, '2023-07-25', 33, '27', 'Xiaomi-2', 100, 5, 4, 4.8, 500, 480, 1, 1, 1, '2023-07-25 09:01:06', '2023-07-25 09:01:06'),
(46, '2023-07-26', 34, '25', 'dsad', 5, 10.5, 0, 10.5, 52.5, 52.5, 1, 1, 1, '2023-07-26 11:18:14', '2023-07-26 11:18:14'),
(47, '2023-07-26', 35, '35', 'Iphone9', 2, 10, 0, 10, 20, 20, 1, 1, 1, '2023-07-26 12:05:44', '2023-07-26 12:05:44'),
(48, '2023-07-27', 36, '27', 'Xiaomi-2', 5, 5, 4, 4.8, 25, 24, 1, 1, 1, '2023-07-27 11:29:21', '2023-07-27 11:29:21'),
(49, '2023-07-30', 37, '29', 'Iphone12', 1, 6, 2, 5.88, 6, 5.88, 1, 1, 1, '2023-07-30 09:12:23', '2023-07-30 09:12:23'),
(50, '2023-10-15', 36, '27', 'Xiaomi-2', 4, 5, 4, 4.8, 20, 19.2, 2, 1, 1, '2023-10-15 10:38:24', '2023-10-15 10:38:24'),
(51, '2023-10-15', 38, '25', 'dsad', 10, 10.5, 0, 10.5, 105, 105, 1, 1, 1, '2023-10-15 10:58:16', '2023-10-15 10:58:16'),
(52, '2023-10-15', 38, '25', 'dsad', 9, 10.5, 0, 10.5, 94.5, 94.5, 2, 1, 1, '2023-10-15 10:59:46', '2023-10-15 10:59:46'),
(53, '2023-10-15', 39, '25', 'dsad', 5, 10.5, 0, 10.5, 52.5, 52.5, 1, 1, 1, '2023-10-15 12:13:47', '2023-10-15 12:13:47'),
(54, '2023-10-15', 39, '25', 'dsad', 2, 10.5, 0, 10.5, 21, 21, 2, 1, 1, '2023-10-15 12:18:37', '2023-10-15 12:18:37'),
(55, '2023-10-15', 39, '25', 'dsad', 1, 10.5, 0, 10.5, 10.5, 10.5, 2, 1, 1, '2023-10-15 12:26:34', '2023-10-15 12:26:34'),
(56, '2023-10-16', 40, '25', 'dsad', 5, 10.5, 0, 10.5, 52.5, 52.5, 1, 1, 1, '2023-10-16 05:01:40', '2023-10-16 05:01:40'),
(57, '2023-10-16', 40, '25', 'dsad', 2, 10.5, 0, 10.5, 21, 21, 2, 1, 1, '2023-10-16 05:02:05', '2023-10-16 05:02:05'),
(58, '2023-10-16', 40, '25', 'dsad', 1, 10.5, 0, 10.5, 10.5, 10.5, 2, 1, 1, '2023-10-16 05:09:58', '2023-10-16 05:09:58'),
(59, '2023-10-16', 41, '25', 'dsad', 10, 10.5, 0, 10.5, 105, 105, 1, 1, 1, '2023-10-16 05:12:59', '2023-10-16 05:12:59'),
(60, '2023-10-16', 41, '25', 'dsad', 1, 10.5, 0, 10.5, 10.5, 10.5, 2, 1, 1, '2023-10-16 05:30:34', '2023-10-16 05:30:34'),
(61, '2023-10-16', 41, '25', 'dsad', 11, 10.5, 0, 10.5, 115.5, 115.5, 1, 1, 1, '2023-10-16 06:56:55', '2023-10-16 06:56:55'),
(62, '2023-10-16', 41, '25', 'dsad', 2, 10.5, 0, 10.5, 21, 21, 2, 1, 1, '2023-10-16 07:01:14', '2023-10-16 07:01:14'),
(63, '2023-10-19', 42, '27', 'Xiaomi-2', 1, 5, 4, 4.8, 5, 4.8, 1, 1, 1, '2023-10-19 09:04:13', '2023-10-19 09:04:13'),
(64, '2023-10-19', 43, '25', 'dsad', 1, 10.5, 0, 10.5, 10.5, 10.5, 1, 1, 1, '2023-10-19 09:07:49', '2023-10-19 09:07:49'),
(65, '2023-10-19', 43, '27', 'Xiaomi-2', 1, 5, 4, 4.8, 5, 4.8, 1, 1, 1, '2023-10-19 09:07:49', '2023-10-19 09:07:49'),
(66, '2023-10-19', 43, '29', 'Iphone12', 1, 6, 2, 5.88, 6, 5.88, 1, 1, 1, '2023-10-19 09:07:49', '2023-10-19 09:07:49'),
(67, '2023-10-19', 43, '32', 'Iphone6', 1, 12, 1, 11.88, 12, 11.88, 1, 1, 1, '2023-10-19 09:07:49', '2023-10-19 09:07:49'),
(68, '2023-10-19', 43, '33', 'Iphone7', 1, 20, 2, 19.6, 20, 19.6, 1, 1, 1, '2023-10-19 09:07:49', '2023-10-19 09:07:49'),
(69, '2023-10-19', 43, '34', 'Iphone8', 1, 10, 4, 9.6, 10, 9.6, 1, 1, 1, '2023-10-19 09:07:49', '2023-10-19 09:07:49'),
(70, '2023-10-19', 43, '35', 'Iphone9', 1, 5, 2, 4.9, 5, 4.9, 1, 1, 1, '2023-10-19 09:07:49', '2023-10-19 09:07:49'),
(71, '2023-10-19', 44, '34', 'Iphone8 aaaaaaaaaaaaaa', 1, 10, 4, 9.6, 10, 9.6, 1, 1, 1, '2023-10-19 09:28:37', '2023-10-19 09:28:37'),
(72, '2023-10-19', 44, '35', 'Iphone9 aaaaaaaaaaaaaaaaaa', 1, 5, 2, 4.9, 5, 4.9, 1, 1, 1, '2023-10-19 09:28:37', '2023-10-19 09:28:37'),
(73, '2023-10-19', 44, '33', 'Iphone7', 1, 20, 2, 19.6, 20, 19.6, 1, 1, 1, '2023-10-19 09:28:37', '2023-10-19 09:28:37'),
(74, '2023-10-19', 44, '32', 'Iphone6', 1, 12, 1, 11.88, 12, 11.88, 1, 1, 1, '2023-10-19 09:28:37', '2023-10-19 09:28:37'),
(75, '2023-10-19', 44, '29', 'Iphone12', 1, 6, 2, 5.88, 6, 5.88, 1, 1, 1, '2023-10-19 09:28:37', '2023-10-19 09:28:37'),
(76, '2023-10-19', 44, '27', 'Xiaomi-2', 1, 5, 4, 4.8, 5, 4.8, 1, 1, 1, '2023-10-19 09:28:37', '2023-10-19 09:28:37'),
(77, '2023-10-19', 44, '25', 'dsad', 1, 10.5, 0, 10.5, 10.5, 10.5, 1, 1, 1, '2023-10-19 09:28:37', '2023-10-19 09:28:37'),
(78, '2023-10-22', 45, '27', 'Xiaomi-2', 3, 5, 4, 4.8, 15, 14.4, 1, 1, 1, '2023-10-22 09:17:21', '2023-10-22 09:17:21'),
(79, '2023-10-22', 45, '29', 'Iphone12', 2, 6, 2, 5.88, 12, 11.76, 1, 1, 1, '2023-10-22 09:17:21', '2023-10-22 09:17:21'),
(80, '2023-10-22', 45, '32', 'Iphone6', 3, 12, 1, 11.88, 36, 35.64, 1, 1, 1, '2023-10-22 09:17:21', '2023-10-22 09:17:21'),
(81, '2023-10-23', 46, '27', 'Xiaomi-2', 2, 5, 4, 4.8, 10, 9.6, 1, 1, 1, '2023-10-23 04:08:27', '2023-10-23 04:08:27'),
(82, '2023-10-23', 46, '29', 'Iphone12', 3, 6, 2, 5.88, 18, 17.64, 1, 1, 1, '2023-10-23 04:08:27', '2023-10-23 04:08:27');

-- --------------------------------------------------------

--
-- Table structure for table `logo_titles`
--

CREATE TABLE `logo_titles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `website_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `validity_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logo_titles`
--

INSERT INTO `logo_titles` (`id`, `website_name`, `logo_image`, `favicon`, `address`, `contact_number`, `email`, `web_url`, `validity_date`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'ISMS', '1690461293.jpg', '1690461308.ico', 'Dhaka,Bangladesh', '0000000000', 'test@gmail.com', NULL, NULL, 1, 1, 1, '2023-06-11 04:25:53', '2023-07-27 12:35:08');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_12_28_051821_create_admins_table', 1),
(6, '2022_12_29_100616_create_permission_tables', 1),
(7, '2023_01_16_113922_create_admin_details_table', 1),
(8, '2023_01_31_065004_create_user_details_table', 1),
(9, '2023_02_07_054221_create_designations_table', 1),
(10, '2023_02_07_120647_create_departments_table', 1),
(11, '2023_02_08_052515_create_companies_table', 1),
(12, '2023_02_08_063616_create_religions_table', 1),
(13, '2023_02_08_090849_create_blood_groups_table', 1),
(14, '2023_02_12_055500_create_units_table', 2),
(15, '2023_02_12_062341_create_categories_table', 2),
(16, '2023_02_12_083709_create_customers_table', 2),
(17, '2023_02_12_104734_create_stores_table', 2),
(18, '2023_02_12_181748_create_products_table', 2),
(19, '2023_02_13_111231_create_suppliers_table', 2),
(21, '2023_02_14_184052_create_store_permissions_table', 2),
(22, '2023_02_15_182119_create_expense_types_table', 2),
(23, '2023_02_16_120746_create_expense_manages_table', 2),
(25, '2023_02_19_162624_create_store_permission_details_table', 3),
(26, '2023_02_22_122616_create_supplier_wise_stores_table', 4),
(27, '2023_02_22_122704_create_supplier_wise_store_details_table', 4),
(32, '2023_03_01_113428_create_product_details_table', 6),
(55, '2023_03_28_140114_create_payment_types_table', 12),
(71, '2023_03_30_153129_create_invoices_table', 13),
(72, '2023_03_30_153407_create_invoice_details_table', 13),
(73, '2023_03_30_153426_create_payments_table', 13),
(75, '2023_03_30_153447_create_payment_details_table', 14),
(76, '2023_02_14_120132_create_logo_titles_table', 15),
(79, '2023_03_06_153921_create_purchases_table', 16),
(80, '2023_03_06_153944_create_purchase_details_table', 16);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(6, 'App\\Models\\Admin', 1),
(8, 'App\\Models\\Admin', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('sabbir.office.it@gmail.com', 'IBwEpgBBpKF68Z6M3QzGQR2pZpMRmVC0NOeJgckFN9vEvuRD3oFVaSBFVpPGDPTG', '2023-07-20 08:06:59');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `discount_amount` double DEFAULT NULL,
  `due_amount` double DEFAULT NULL,
  `paid_status` varchar(51) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `invoice_id`, `customer_id`, `total_amount`, `paid_amount`, `discount_amount`, `due_amount`, `paid_status`, `created_at`, `updated_at`) VALUES
(1, 1, 33, 57, 10, 2, 47, '2', '2023-06-12 09:33:49', '2023-06-13 04:17:35'),
(2, 2, 26, 56, 56, 2, 0, '2', '2023-06-12 10:11:11', '2023-06-13 04:15:06'),
(3, 3, 24, 34, 0, 4, 34, '2', '2023-06-13 04:31:02', '2023-06-13 08:51:31'),
(4, 4, 38, 11, 7, 0, 4, '0', '2023-06-15 06:32:42', '2023-07-25 07:09:00'),
(5, 5, 36, 23, 10, 5, 13, '2', '2023-06-13 12:23:26', '2023-06-13 12:29:19'),
(6, 6, 33, 17, 15, 2, 2, '0', '2023-06-14 04:39:44', '2023-06-14 11:11:34'),
(7, 7, 33, 100, 25, 0, 75, '0', '2023-06-14 08:22:47', '2023-06-14 11:04:31'),
(8, 8, 34, 100, 25, 0, 75, '0', '2023-06-14 08:24:10', '2023-06-14 11:03:31'),
(9, 9, 33, 10, 10, 0, 0, '1', '2023-06-14 08:29:14', '2023-06-14 08:29:14'),
(10, 10, 35, 11, 5, 0, 6, '0', '2023-06-14 11:17:22', '2023-06-14 11:17:22'),
(11, 11, 26, 19, 2, 0, 17, '0', '2023-06-14 11:17:34', '2023-06-14 11:17:34'),
(12, 12, 22, 19, 5, 0, 14, '0', '2023-06-14 11:17:50', '2023-06-14 11:17:50'),
(13, 13, 22, 19, 2, 0, 17, '0', '2023-06-14 11:18:03', '2023-06-14 11:18:03'),
(14, 14, 35, 9, 9, 0, 0, '1', '2023-06-15 04:36:17', '2023-06-15 04:36:17'),
(15, 15, 32, 9, 9, 0, 0, '1', '2023-06-15 04:36:32', '2023-06-15 06:28:49'),
(16, 16, 34, 10, 10, 0, 0, '1', '2023-06-15 06:32:05', '2023-06-15 06:32:05'),
(17, 17, 34, 59, 59, 0, 0, '1', '2023-06-18 04:20:32', '2023-06-18 04:20:32'),
(18, 18, 34, 11, 7, 0, 4, '0', '2023-06-19 04:02:30', '2023-07-20 06:16:46'),
(19, 19, 24, 98, 98, 0, 0, '1', '2023-06-19 05:52:21', '2023-06-19 05:52:21'),
(20, 20, 36, 11, 11, 0, 0, '1', '2023-06-20 05:13:30', '2023-06-20 05:13:30'),
(21, 21, 36, 9, 9, 0, 0, '1', '2023-06-21 09:19:53', '2023-06-21 09:19:53'),
(22, 22, 36, 19, 19, 0, 0, '1', '2023-06-22 09:50:38', '2023-06-22 09:50:38'),
(23, 23, 39, 39, 39, 0, 0, '1', '2023-06-24 04:38:32', '2023-06-24 09:42:51'),
(24, 24, 40, 48, 48, 0, 0, '1', '2023-07-03 18:57:39', '2023-07-03 18:59:34'),
(25, 25, 43, 4, 4, 0, 0, '1', '2023-07-20 06:06:38', '2023-07-20 06:07:41'),
(26, 26, 40, 10, 10, 0, 0, '1', '2023-07-24 04:52:12', '2023-07-24 04:52:12'),
(27, 27, 28, 4, 0, 0, 4, '0', '2023-07-24 04:52:38', '2023-07-24 04:52:38'),
(28, 28, 27, 11, 11, 0, 0, '2', '2023-07-24 04:53:12', '2023-07-24 04:53:24'),
(29, 29, 36, 9, 9, 0, 0, '2', '2023-07-25 05:01:16', '2023-07-25 05:01:49'),
(30, 30, 40, 4, 4, 0, 0, '1', '2023-07-25 05:03:00', '2023-07-25 05:03:00'),
(31, 31, 35, 9, 9, 0, 0, '1', '2023-07-25 06:48:49', '2023-07-25 06:48:49'),
(32, 32, 35, 9, 2, 0, 7, '0', '2023-07-25 06:49:36', '2023-07-25 06:49:36'),
(33, 33, 36, 480, 10, 0, 470, '0', '2023-07-25 09:01:06', '2023-07-25 09:01:06'),
(34, 34, 36, 52, 30, 0, 22, '0', '2023-07-26 11:18:14', '2023-07-27 11:30:09'),
(35, 35, 32, 20, 10, 0, 10, '2', '2023-07-26 12:05:44', '2023-07-26 12:29:22'),
(36, 36, 40, 4, 0, 0, 4, '0', '2023-07-27 11:29:21', '2023-10-15 10:39:46'),
(37, 37, 40, 5, 5, 0, 0, '2', '2023-07-30 09:12:23', '2023-07-30 09:17:14'),
(38, 38, 40, 10, 0, 0, 10, '0', '2023-10-15 10:58:16', '2023-10-15 11:13:59'),
(39, 39, 36, 21, 21, 0, 0, '1', '2023-10-15 12:13:47', '2023-10-15 12:26:34'),
(40, 40, 40, 31, 31, 0, 0, '1', '2023-10-16 05:01:40', '2023-10-16 05:02:05'),
(41, 41, 35, 189, 189, 0, 0, '1', '2023-10-16 05:12:59', '2023-10-16 09:22:56'),
(42, 42, 35, 4, 4, 0, 0, '1', '2023-10-19 09:04:13', '2023-10-19 09:04:13'),
(43, 43, 34, 67, 67, 0, 0, '1', '2023-10-19 09:07:49', '2023-10-19 09:07:49'),
(44, 44, 34, 67, 67, 0, 0, '1', '2023-10-19 09:28:37', '2023-10-19 09:28:37'),
(45, 45, 44, 56, 56, 5, 0, '1', '2023-10-22 09:17:21', '2023-10-22 09:22:01'),
(46, 46, 45, 27, 27, 0, 0, '1', '2023-10-23 04:08:27', '2023-10-23 04:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `current_paid_amount` double DEFAULT NULL,
  `refound` double DEFAULT NULL,
  `actual_paid` double DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancel_by` int(11) DEFAULT NULL,
  `cancel_date` date DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`id`, `invoice_id`, `date`, `current_paid_amount`, `refound`, `actual_paid`, `payment_method`, `cancel_by`, `cancel_date`, `updated_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-06-12', 10, 0, 10, 'Bank', NULL, NULL, 1, 1, '2023-06-12 09:33:49', '2023-06-12 09:33:49'),
(2, 2, '2023-06-12', 100, 4, 96, 'Bank', 1, '2023-06-12', 1, 2, '2023-06-12 10:11:11', '2023-06-12 10:12:21'),
(3, 2, '2023-06-12', 100, 4, 96, 'bCash', NULL, NULL, 1, 1, '2023-06-12 10:12:51', '2023-06-12 10:12:51'),
(4, 2, '2023-06-12', 0, 20, -20, NULL, NULL, NULL, 1, 1, '2023-06-12 10:14:53', '2023-06-12 10:14:53'),
(5, 2, '2023-06-12', 0, 20, -20, NULL, NULL, NULL, 1, 1, '2023-06-12 10:15:06', '2023-06-12 10:15:06'),
(6, 3, '2023-06-13', 10, 0, 10, 'Handcash', 1, '2023-06-13', 1, 2, '2023-06-13 04:31:02', '2023-06-13 05:25:17'),
(7, 5, '2023-06-13', 10, 0, 10, NULL, NULL, NULL, 1, 1, '2023-06-13 12:23:26', '2023-06-13 12:23:26'),
(8, 6, '2023-06-14', 10, 0, 10, 'Bank', 1, '2023-06-14', 1, 2, '2023-06-14 04:39:44', '2023-06-14 04:45:32'),
(9, 6, '2023-06-14', 10, 0, 10, NULL, NULL, NULL, 1, 1, '2023-06-14 04:47:19', '2023-06-14 04:47:19'),
(10, 6, '2023-06-14', 5, 0, 5, NULL, NULL, NULL, 1, 1, '2023-06-14 04:47:38', '2023-06-14 04:47:38'),
(11, 4, '2023-06-14', 5, 0, 5, 'bCash', NULL, NULL, 1, 1, '2023-06-14 06:32:21', '2023-06-14 06:32:21'),
(12, 7, '2023-06-14', 5, 0, 5, 'Bank', NULL, NULL, 1, 1, '2023-06-14 08:22:47', '2023-06-14 08:22:47'),
(13, 8, '2023-06-14', 10, 0, 10, NULL, NULL, NULL, 1, 1, '2023-06-14 08:24:10', '2023-06-14 08:24:10'),
(14, 8, '2023-06-14', 10, 0, 10, NULL, NULL, NULL, 2, 1, '2023-06-14 08:26:14', '2023-06-14 08:26:14'),
(15, 9, '2023-06-14', 10, 0, 10, NULL, NULL, NULL, 1, 1, '2023-06-14 08:29:14', '2023-06-14 08:29:14'),
(16, 8, '2023-06-14', 5, 0, 5, 'Handcash', NULL, NULL, 2, 1, '2023-06-14 11:03:31', '2023-06-14 11:03:31'),
(17, 7, '2023-06-14', 20, 0, 20, NULL, NULL, NULL, 2, 1, '2023-06-14 11:04:31', '2023-06-14 11:04:31'),
(18, 10, '2023-06-14', 5, 0, 5, NULL, NULL, NULL, 1, 1, '2023-06-14 11:17:22', '2023-06-14 11:17:22'),
(19, 11, '2023-06-14', 2, 0, 2, NULL, NULL, NULL, 1, 1, '2023-06-14 11:17:34', '2023-06-14 11:17:34'),
(20, 12, '2023-06-14', 5, 0, 5, NULL, NULL, NULL, 1, 1, '2023-06-14 11:17:50', '2023-06-14 11:17:50'),
(21, 13, '2023-06-14', 2, 0, 2, NULL, NULL, NULL, 1, 1, '2023-06-14 11:18:03', '2023-06-14 11:18:03'),
(22, 14, '2023-06-15', 9, 0, 9, 'Handcash', NULL, NULL, 1, 1, '2023-06-15 04:36:17', '2023-06-15 04:36:17'),
(23, 15, '2023-06-15', 1, 0, 1, NULL, NULL, NULL, 1, 1, '2023-06-15 06:23:39', '2023-06-15 06:23:39'),
(24, 15, '2023-06-15', 2, 0, 2, NULL, NULL, NULL, 2, 1, '2023-06-15 06:25:44', '2023-06-15 06:25:44'),
(25, 15, '2023-06-15', 2, 0, 2, NULL, NULL, NULL, 2, 1, '2023-06-15 06:25:58', '2023-06-15 06:25:58'),
(26, 15, '2023-06-15', 5, 1, 4, NULL, NULL, NULL, 1, 1, '2023-06-15 06:28:49', '2023-06-15 06:28:49'),
(27, 16, '2023-06-15', 10, 0, 10, NULL, NULL, NULL, 1, 1, '2023-06-15 06:32:05', '2023-06-15 06:32:05'),
(28, 17, '2023-06-18', 59, 0, 59, NULL, NULL, NULL, 1, 1, '2023-06-18 04:20:32', '2023-06-18 04:20:32'),
(29, 18, '2023-06-19', 2, 0, 2, NULL, NULL, NULL, 1, 1, '2023-06-19 04:02:30', '2023-06-19 04:02:30'),
(30, 19, '2023-06-19', 98, 0, 98, 'Handcash', NULL, NULL, 1, 1, '2023-06-19 05:52:21', '2023-06-19 05:52:21'),
(31, 20, '2023-06-20', 11, 0, 11, NULL, NULL, NULL, 1, 1, '2023-06-20 05:13:30', '2023-06-20 05:13:30'),
(32, 21, '2023-06-21', 9, 0, 9, NULL, NULL, NULL, 1, 1, '2023-06-21 09:19:53', '2023-06-21 09:19:53'),
(33, 22, '2023-06-22', 19, 0, 19, NULL, NULL, NULL, 1, 1, '2023-06-22 09:50:38', '2023-06-22 09:50:38'),
(34, 23, '2023-06-24', 20, 0, 20, NULL, NULL, NULL, 1, 1, '2023-06-24 04:38:32', '2023-06-24 04:38:32'),
(35, 23, '2023-06-24', 20, 0, 20, 'Handcash', NULL, NULL, 1, 1, '2023-06-24 04:38:51', '2023-06-24 04:38:51'),
(36, 23, '2023-06-24', 20, 1, 19, 'Handcash', NULL, NULL, 1, 1, '2023-06-24 04:39:01', '2023-06-24 04:39:01'),
(37, 23, '2023-06-24', 0, 20, -20, NULL, NULL, NULL, 1, 1, '2023-06-24 09:42:51', '2023-06-24 09:42:51'),
(38, 24, '2023-07-04', 48, 0, 48, NULL, NULL, NULL, 1, 1, '2023-07-03 18:59:34', '2023-07-03 18:59:34'),
(39, 25, '2023-07-20', 1, 0, 1, 'Handcash', NULL, NULL, 6, 1, '2023-07-20 06:06:38', '2023-07-20 06:06:38'),
(40, 25, '2023-07-20', 3, 0, 3, NULL, NULL, NULL, 6, 1, '2023-07-20 06:07:41', '2023-07-20 06:07:41'),
(41, 18, '2023-07-20', 5, 0, 5, NULL, NULL, NULL, 6, 1, '2023-07-20 06:16:46', '2023-07-20 06:16:46'),
(42, 26, '2023-07-24', 10, 0, 10, NULL, NULL, NULL, 1, 1, '2023-07-24 04:52:12', '2023-07-24 04:52:12'),
(43, 28, '2023-07-24', 11, 0, 11, NULL, NULL, NULL, 1, 1, '2023-07-24 04:53:12', '2023-07-24 04:53:12'),
(44, 29, '2023-07-25', 9, 0, 9, NULL, NULL, NULL, 1, 1, '2023-07-25 05:01:16', '2023-07-25 05:01:16'),
(45, 30, '2023-07-25', 4, 0, 4, NULL, NULL, NULL, 1, 1, '2023-07-25 05:03:00', '2023-07-25 05:03:00'),
(46, 31, '2023-07-25', 10, 1, 9, NULL, NULL, NULL, 1, 1, '2023-07-25 06:48:49', '2023-07-25 06:48:49'),
(47, 32, '2023-07-25', 2, 0, 2, NULL, NULL, NULL, 1, 1, '2023-07-25 06:49:36', '2023-07-25 06:49:36'),
(48, 4, '2023-07-25', 2, 0, 2, NULL, NULL, NULL, 1, 1, '2023-07-25 07:09:00', '2023-07-25 07:09:00'),
(49, 33, '2023-07-25', 10, 0, 10, NULL, NULL, NULL, 1, 1, '2023-07-25 09:01:06', '2023-07-25 09:01:06'),
(50, 34, '2023-07-26', 10, 0, 10, NULL, NULL, NULL, 1, 1, '2023-07-26 11:18:14', '2023-07-26 11:18:14'),
(51, 35, '2023-07-26', 10, 0, 10, NULL, NULL, NULL, 1, 1, '2023-07-26 12:05:44', '2023-07-26 12:05:44'),
(52, 36, '2023-07-27', 10, 0, 10, NULL, 1, '2023-10-15', 1, 2, '2023-07-27 11:29:21', '2023-10-15 10:35:37'),
(53, 34, '2023-07-27', 20, 0, 20, NULL, NULL, NULL, 1, 1, '2023-07-27 11:30:09', '2023-07-27 11:30:09'),
(54, 37, '2023-07-30', 5, 0, 5, NULL, NULL, NULL, 1, 1, '2023-07-30 09:12:23', '2023-07-30 09:12:23'),
(55, 36, '2023-10-15', 10000, 9976, 24, 'bCash', 1, '2023-10-15', 1, 2, '2023-10-15 10:37:06', '2023-10-15 10:38:54'),
(56, 36, '2023-10-15', 0, 20, -20, NULL, 1, '2023-10-15', 1, 2, '2023-10-15 10:38:24', '2023-10-15 10:39:46'),
(57, 38, '2023-10-15', 10, 0, 10, NULL, 1, '2023-10-15', 1, 2, '2023-10-15 10:58:16', '2023-10-15 11:13:59'),
(58, 38, '2023-10-15', 95, 0, 95, NULL, 1, '2023-10-15', 1, 2, '2023-10-15 10:59:02', '2023-10-15 12:08:28'),
(59, 38, '2023-10-15', 0, 95, -95, NULL, 1, '2023-10-15', 1, 2, '2023-10-15 10:59:46', '2023-10-15 11:02:13'),
(60, 38, '2023-10-15', 0, 95, -95, NULL, 1, '2023-10-15', 1, 2, '2023-10-15 11:02:13', '2023-10-15 11:02:49'),
(61, 38, '2023-10-15', 0, 95, -95, NULL, NULL, NULL, 1, 1, '2023-10-15 11:02:49', '2023-10-15 11:02:49'),
(62, 39, '2023-10-15', 52, 0, 52, 'Bank', 1, '2023-10-15', 1, 2, '2023-10-15 12:13:47', '2023-10-15 12:46:22'),
(63, 39, '2023-10-15', 0, 21, -21, NULL, NULL, NULL, 1, 1, '2023-10-15 12:18:37', '2023-10-15 12:18:37'),
(64, 39, '2023-10-15', 0, 10, -10, NULL, NULL, NULL, 1, 1, '2023-10-15 12:26:34', '2023-10-15 12:26:34'),
(65, 40, '2023-10-16', 52, 0, 52, NULL, NULL, NULL, 1, 1, '2023-10-16 05:01:40', '2023-10-16 05:01:40'),
(66, 40, '2023-10-16', 0, 21, -21, NULL, NULL, NULL, 1, 1, '2023-10-16 05:02:05', '2023-10-16 05:02:05'),
(67, 41, '2023-10-16', 105, 0, 105, NULL, 1, '2023-10-16', 1, 2, '2023-10-16 05:12:59', '2023-10-16 09:00:21'),
(68, 41, '2023-10-16', 0, 11, -11, NULL, NULL, NULL, 1, 1, '2023-10-16 05:30:34', '2023-10-16 05:30:34'),
(69, 41, '2023-10-16', 10, 0, 10, 'Handcash', 1, '2023-10-16', 1, 2, '2023-10-16 06:57:16', '2023-10-16 07:01:38'),
(70, 41, '2023-10-16', 106, 0, 106, NULL, NULL, NULL, 1, 1, '2023-10-16 06:58:47', '2023-10-16 06:58:47'),
(71, 41, '2023-10-16', 0, 21, -21, NULL, NULL, NULL, 1, 1, '2023-10-16 07:01:14', '2023-10-16 07:01:14'),
(72, 41, '2023-10-16', 20, 0, 20, NULL, 1, '2023-10-16', 1, 2, '2023-10-16 09:22:00', '2023-10-16 09:22:29'),
(73, 41, '2023-10-16', 115, 0, 115, NULL, NULL, NULL, 1, 1, '2023-10-16 09:22:56', '2023-10-16 09:22:56'),
(74, 42, '2023-10-19', 4, 0, 4, NULL, NULL, NULL, 1, 1, '2023-10-19 09:04:13', '2023-10-19 09:04:13'),
(75, 43, '2023-10-19', 67, 0, 67, NULL, NULL, NULL, 1, 1, '2023-10-19 09:07:49', '2023-10-19 09:07:49'),
(76, 44, '2023-10-19', 67, 0, 67, 'Bank', NULL, NULL, 1, 1, '2023-10-19 09:28:37', '2023-10-19 09:28:37'),
(77, 45, '2023-10-22', 2, 0, 2, 'bCash', NULL, NULL, 1, 1, '2023-10-22 09:17:21', '2023-10-22 09:17:21'),
(78, 45, '2023-10-22', 54, 0, 54, 'bCash', NULL, NULL, 1, 1, '2023-10-22 09:22:01', '2023-10-22 09:22:01'),
(79, 46, '2023-10-23', 2, 0, 2, NULL, NULL, NULL, 1, 1, '2023-10-23 04:08:27', '2023-10-23 04:08:27'),
(80, 46, '2023-10-23', 25, 0, 25, 'Bank', NULL, NULL, 1, 1, '2023-10-23 04:10:21', '2023-10-23 04:10:21');

-- --------------------------------------------------------

--
-- Table structure for table `payment_types`
--

CREATE TABLE `payment_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_types`
--

INSERT INTO `payment_types` (`id`, `type_name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'bCash', 1, 1, 1, '2023-04-03 08:57:17', '2023-04-03 08:57:17'),
(2, 'Bank', 1, 1, 1, '2023-04-03 08:57:25', '2023-04-03 08:57:25'),
(3, 'Handcash', 1, 1, 1, '2023-04-03 08:57:32', '2023-04-03 08:57:32');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `group_name`, `guard_name`, `created_at`, `updated_at`) VALUES
(99, 'admin.menu', 'admin', 'admin', '2023-07-18 09:27:50', '2023-07-18 09:27:50'),
(100, 'admin.list', 'admin', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(101, 'admin.create', 'admin', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(102, 'admin.edit', 'admin', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(103, 'admin.delete', 'admin', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(104, 'role.permission.menu', 'role_permission', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(105, 'permission.list', 'role_permission', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(106, 'permission.create', 'role_permission', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(107, 'role.list', 'role_permission', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(108, 'role.create', 'role_permission', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(109, 'role.permission.list', 'role_permission', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(110, 'role.permission.create', 'role_permission', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(111, 'admin.store_wise_list', 'admin.store_wise_list', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(112, 'salese_manage.menu', 'salese_manage', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(113, 'salese_manage.pos', 'salese_manage', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(114, 'salese_manage.invoice_list', 'salese_manage', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(115, 'salese_manage.edit_invoice', 'salese_manage', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(116, 'salese_manage.date_wise_cashier_report', 'salese_manage', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(117, 'salese_manage.paid_invoice_list', 'salese_manage', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(118, 'salese_manage.due_list', 'salese_manage', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(119, 'salese_manage.due_collection', 'salese_manage', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(120, 'salese_manage.cancel_invoice', 'salese_manage', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(121, 'salese_manage.cancel_invoice_list', 'salese_manage', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(122, 'store_previlage.menu', 'store_previlage', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(123, 'store_previlage.list', 'store_previlage', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(124, 'store_previlage.create', 'store_previlage', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(125, 'store_previlage.edit', 'store_previlage', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(126, 'store_previlage.delete', 'store_previlage', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(127, 'purchase.menu', 'purchase', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(128, 'purchase.new_purchase', 'purchase', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(129, 'purchase.pending_list', 'purchase', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(130, 'purchase.approve', 'purchase', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(131, 'purchase.reject', 'purchase', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(132, 'purchase.delete', 'purchase', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(133, 'purchase.view', 'purchase', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(134, 'purchase.edit', 'purchase', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(135, 'purchase.list', 'purchase', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(136, 'purchase.approve_list', 'purchase', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(137, 'purchase.cancel_list', 'purchase', 'admin', '2023-07-18 09:27:51', '2023-07-18 09:27:51'),
(138, 'expense_manage.menu', 'expense_manage', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(139, 'expense_manage.list', 'expense_manage', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(140, 'expense_manage.create', 'expense_manage', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(141, 'expense_manage.edit', 'expense_manage', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(142, 'expense_manage.delete', 'expense_manage', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(143, 'report.menu', 'report', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(144, 'report.daily_sales', 'report', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(145, 'report.monthly_sales', 'report', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(146, 'report.yearly_sales', 'report', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(147, 'report.date_wise_cashier', 'report', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(148, 'report.income_summery_report', 'report', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(149, 'report.daily_purchase', 'report', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(150, 'report.daily_purchase_summery', 'report', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(151, 'report.daily_expense_report', 'report', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(152, 'report.expense_summery_report', 'report', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(153, 'report.profit_report', 'report', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(154, 'admin_setting.menu', 'Admin.Setting', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(155, 'bloodgroup.menu', 'Admin.Setting', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(156, 'bloodgroup.list', 'Admin.Setting', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(157, 'bloodgroup.create', 'Admin.Setting', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(158, 'bloodgroup.edit', 'Admin.Setting', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(159, 'bloodgroup.delete', 'Admin.Setting', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(160, 'religion.menu', 'Admin.Setting', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(161, 'religion.list', 'Admin.Setting', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(162, 'religion.create', 'Admin.Setting', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(163, 'religion.edit', 'Admin.Setting', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(164, 'religion.delete', 'Admin.Setting', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(165, 'company.menu', 'Admin.Setting', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(166, 'company.list', 'Admin.Setting', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(167, 'company.create', 'Admin.Setting', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(168, 'company.edit', 'Admin.Setting', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(169, 'company.delete', 'Admin.Setting', 'admin', '2023-07-18 09:27:52', '2023-07-18 09:27:52'),
(170, 'department.menu', 'Admin.Setting', 'admin', '2023-07-18 09:27:53', '2023-07-18 09:27:53'),
(171, 'department.list', 'Admin.Setting', 'admin', '2023-07-18 09:27:53', '2023-07-18 09:27:53'),
(172, 'department.create', 'Admin.Setting', 'admin', '2023-07-18 09:27:53', '2023-07-18 09:27:53'),
(173, 'department.edit', 'Admin.Setting', 'admin', '2023-07-18 09:27:53', '2023-07-18 09:27:53'),
(174, 'department.delete', 'Admin.Setting', 'admin', '2023-07-18 09:27:53', '2023-07-18 09:27:53'),
(175, 'designation.menu', 'Admin.Setting', 'admin', '2023-07-18 09:27:53', '2023-07-18 09:27:53'),
(176, 'designation.list', 'Admin.Setting', 'admin', '2023-07-18 09:27:53', '2023-07-18 09:27:53'),
(177, 'designation.create', 'Admin.Setting', 'admin', '2023-07-18 09:27:53', '2023-07-18 09:27:53'),
(178, 'designation.edit', 'Admin.Setting', 'admin', '2023-07-18 09:27:53', '2023-07-18 09:27:53'),
(179, 'designation.delete', 'Admin.Setting', 'admin', '2023-07-18 09:27:53', '2023-07-18 09:27:53'),
(180, 'logo.menu', 'Admin.Setting', 'admin', '2023-07-18 09:27:53', '2023-07-18 09:27:53'),
(181, 'logo.list', 'Admin.Setting', 'admin', '2023-07-18 09:27:53', '2023-07-18 09:27:53'),
(182, 'logo.create', 'Admin.Setting', 'admin', '2023-07-18 09:27:53', '2023-07-18 09:27:53'),
(183, 'logo.edit', 'Admin.Setting', 'admin', '2023-07-18 09:27:53', '2023-07-18 09:27:53'),
(184, 'logo.delete', 'Admin.Setting', 'admin', '2023-07-18 09:27:53', '2023-07-18 09:27:53'),
(185, 'invoice_setting.menu', 'Invoice.Setting', 'admin', '2023-07-18 09:40:38', '2023-07-18 09:40:38'),
(186, 'unit.menu', 'Invoice.Setting', 'admin', '2023-07-18 09:40:38', '2023-07-18 09:40:38'),
(187, 'unit.list', 'Invoice.Setting', 'admin', '2023-07-18 09:40:38', '2023-07-18 09:40:38'),
(188, 'unit.create', 'Invoice.Setting', 'admin', '2023-07-18 09:40:39', '2023-07-18 09:40:39'),
(189, 'unit.edit', 'Invoice.Setting', 'admin', '2023-07-18 09:40:39', '2023-07-18 09:40:39'),
(190, 'unit.delete', 'Invoice.Setting', 'admin', '2023-07-18 09:40:39', '2023-07-18 09:40:39'),
(191, 'category.menu', 'Invoice.Setting', 'admin', '2023-07-18 10:15:22', '2023-07-18 10:15:22'),
(192, 'category.list', 'Invoice.Setting', 'admin', '2023-07-18 10:15:22', '2023-07-18 10:15:22'),
(193, 'category.create', 'Invoice.Setting', 'admin', '2023-07-18 10:15:22', '2023-07-18 10:15:22'),
(194, 'category.edit', 'Invoice.Setting', 'admin', '2023-07-18 10:15:22', '2023-07-18 10:15:22'),
(195, 'category.delete', 'Invoice.Setting', 'admin', '2023-07-18 10:15:22', '2023-07-18 10:15:22'),
(196, 'customer.menu', 'Invoice.Setting', 'admin', '2023-07-18 11:52:39', '2023-07-18 11:52:39'),
(197, 'customer.list', 'Invoice.Setting', 'admin', '2023-07-18 11:52:39', '2023-07-18 11:52:39'),
(198, 'customer.create', 'Invoice.Setting', 'admin', '2023-07-18 11:52:39', '2023-07-18 11:52:39'),
(199, 'customer.edit', 'Invoice.Setting', 'admin', '2023-07-18 11:52:39', '2023-07-18 11:52:39'),
(200, 'customer.delete', 'Invoice.Setting', 'admin', '2023-07-18 11:52:39', '2023-07-18 11:52:39'),
(201, 'store.menu', 'Invoice.Setting', 'admin', '2023-07-18 12:00:43', '2023-07-18 12:00:43'),
(202, 'store.list', 'Invoice.Setting', 'admin', '2023-07-18 12:00:43', '2023-07-18 12:00:43'),
(203, 'store.create', 'Invoice.Setting', 'admin', '2023-07-18 12:00:43', '2023-07-18 12:00:43'),
(204, 'store.edit', 'Invoice.Setting', 'admin', '2023-07-18 12:00:43', '2023-07-18 12:00:43'),
(205, 'supplier.menu', 'Invoice.Setting', 'admin', '2023-07-18 12:09:58', '2023-07-18 12:09:58'),
(206, 'supplier.list', 'Invoice.Setting', 'admin', '2023-07-18 12:09:58', '2023-07-18 12:09:58'),
(207, 'supplier.create', 'Invoice.Setting', 'admin', '2023-07-18 12:09:58', '2023-07-18 12:09:58'),
(208, 'supplier.edit', 'Invoice.Setting', 'admin', '2023-07-18 12:09:58', '2023-07-18 12:09:58'),
(209, 'supplier.delete', 'Invoice.Setting', 'admin', '2023-07-18 12:09:58', '2023-07-18 12:09:58'),
(210, 'supplier_wise_store.menu', 'Invoice.Setting', 'admin', '2023-07-18 12:23:14', '2023-07-18 12:23:14'),
(211, 'supplier_wise_store.list', 'Invoice.Setting', 'admin', '2023-07-18 12:23:14', '2023-07-18 12:23:14'),
(212, 'supplier_wise_store.create', 'Invoice.Setting', 'admin', '2023-07-18 12:23:14', '2023-07-18 12:23:14'),
(213, 'supplier_wise_store.edit', 'Invoice.Setting', 'admin', '2023-07-18 12:23:14', '2023-07-18 12:23:14'),
(214, 'supplier_wise_store.delete', 'Invoice.Setting', 'admin', '2023-07-18 12:23:14', '2023-07-18 12:23:14'),
(215, 'product.menu', 'Invoice.Setting', 'admin', '2023-07-19 04:23:22', '2023-07-19 04:23:22'),
(216, 'product.list', 'Invoice.Setting', 'admin', '2023-07-19 04:23:22', '2023-07-19 04:23:22'),
(217, 'product.create', 'Invoice.Setting', 'admin', '2023-07-19 04:23:22', '2023-07-19 04:23:22'),
(218, 'product.edit', 'Invoice.Setting', 'admin', '2023-07-19 04:23:22', '2023-07-19 04:23:22'),
(219, 'product.product_wise_store', 'Invoice.Setting', 'admin', '2023-07-19 04:23:22', '2023-07-19 04:23:22'),
(220, 'product.store_wise_product_list', 'Invoice.Setting', 'admin', '2023-07-19 04:23:22', '2023-07-19 04:23:22'),
(221, 'product.store_wise_product_edit', 'Invoice.Setting', 'admin', '2023-07-19 04:23:22', '2023-07-19 04:23:22'),
(222, 'expense_type.menu', 'Invoice.Setting', 'admin', '2023-07-19 05:06:30', '2023-07-19 05:06:30'),
(223, 'expense_type.list', 'Invoice.Setting', 'admin', '2023-07-19 05:06:30', '2023-07-19 05:06:30'),
(224, 'expense_type.create', 'Invoice.Setting', 'admin', '2023-07-19 05:06:30', '2023-07-19 05:06:30'),
(225, 'expense_type.edit', 'Invoice.Setting', 'admin', '2023-07-19 05:06:30', '2023-07-19 05:06:30'),
(226, 'expense_type.delete', 'Invoice.Setting', 'admin', '2023-07-19 05:06:30', '2023-07-19 05:06:30'),
(227, 'payment_type.menu', 'Invoice.Setting', 'admin', '2023-07-19 05:27:33', '2023-07-19 05:27:33'),
(228, 'payment_type.list', 'Invoice.Setting', 'admin', '2023-07-19 05:27:33', '2023-07-19 05:27:33'),
(229, 'payment_type.create', 'Invoice.Setting', 'admin', '2023-07-19 05:27:33', '2023-07-19 05:27:33'),
(230, 'payment_type.edit', 'Invoice.Setting', 'admin', '2023-07-19 05:27:33', '2023-07-19 05:27:33'),
(231, 'payment_type.delete', 'Invoice.Setting', 'admin', '2023-07-19 05:27:33', '2023-07-19 05:27:33'),
(232, 'admin.dashboard', 'dashboard', 'admin', '2023-07-27 12:20:52', '2023-07-27 12:20:52'),
(233, 'store.wise.dashboard', 'dashboard', 'admin', '2023-07-27 12:20:52', '2023-07-27 12:20:52'),
(234, 'sales.dashboard', 'dashboard', 'admin', '2023-07-27 12:20:52', '2023-07-27 12:20:52'),
(235, 'report.daily_cancel_inv', 'report', 'admin', '2023-07-30 10:22:37', '2023-07-30 10:22:37');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `reorder_qty` int(12) NOT NULL DEFAULT 10,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_code`, `unit_id`, `category_id`, `description`, `status`, `reorder_qty`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(24, 'Iphone', 'pro-001', 2, 1, 'sdsad', 1, 10, 1, 1, '2023-03-02 06:00:07', '2023-03-02 06:00:07'),
(25, 'dsad', 'pro-0025', 2, 1, 'sadsad', 1, 10, 1, 1, '2023-03-02 06:00:44', '2023-03-02 06:00:44'),
(27, 'Xiaomi-2', 'pro-0026', 1, 1, 'sdsad', 1, 10, 1, 1, '2023-03-06 05:44:03', '2023-03-06 07:06:00'),
(28, 'Iphone11', 'pro-0028', 2, 1, NULL, 1, 10, 1, 1, '2023-03-06 11:13:27', '2023-03-06 11:13:56'),
(29, 'Iphone12', 'pro-0029', 2, 1, '12', 1, 10, 1, 1, '2023-03-06 11:13:44', '2023-03-06 11:13:50'),
(30, 'Iphone4', 'pro-0030', 2, 1, NULL, 1, 10, 1, 1, '2023-03-07 09:22:59', '2023-03-07 09:22:59'),
(31, 'Iphone5', 'pro-0031', 2, 1, NULL, 1, 10, 1, 1, '2023-03-07 09:23:12', '2023-03-07 09:23:12'),
(32, 'Iphone6', 'pro-0032', 2, 1, NULL, 1, 10, 1, 1, '2023-03-07 09:23:53', '2023-03-07 09:23:53'),
(33, 'Iphone7', 'pro-0033', 2, 1, NULL, 1, 10, 1, 1, '2023-03-07 09:24:18', '2023-03-07 09:24:18'),
(34, 'Iphone8 aaaaaaaaaaaaaa', 'pro-0034', 2, 1, NULL, 1, 10, 1, 1, '2023-03-07 09:24:35', '2023-10-19 09:27:13'),
(35, 'Iphone9 aaaaaaaaaaaaaaaaaa', 'pro-0035', 2, 1, NULL, 1, 15, 1, 1, '2023-03-07 09:24:55', '2023-10-23 06:07:16'),
(38, 'dsa', 'pro-0036', 2, 2, 'dsds', 1, 2, 1, 1, '2023-10-23 06:04:31', '2023-10-23 06:05:17'),
(39, 'fdsfds', 'pro-0039', 2, 2, 'dsfds', 1, 10, 1, 1, '2023-10-23 06:09:52', '2023-10-23 06:09:52');

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `current_buying_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `current_sales_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `store_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_details`
--

INSERT INTO `product_details` (`id`, `product_id`, `qty`, `current_buying_price`, `current_sales_price`, `discount`, `store_id`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 27, '21170', '2.00', '5.00', '4', '6', 1, 1, 1, '2023-03-06 10:16:44', '2023-10-23 04:08:27'),
(2, 27, '11', '8', '0', '0', '5', 1, 1, 1, '2023-03-06 10:16:52', '2023-03-15 09:27:35'),
(3, 27, '0', '0', '0', '0', '2', 1, 1, 1, '2023-03-06 10:16:57', '2023-03-06 10:16:57'),
(4, 25, '3404', '10', '10.50', '0', '6', 1, 1, 1, '2023-03-06 10:17:12', '2023-10-19 09:28:37'),
(5, 25, '3434', '0', '0', '0', '5', 1, 1, 1, '2023-03-06 10:17:18', '2023-03-06 10:17:18'),
(6, 28, '12', '7', '0', '0', '6', 1, 1, 1, '2023-03-06 11:13:27', '2023-06-07 12:05:40'),
(7, 29, '295', '5', '6', '2', '6', 1, 1, 1, '2023-03-06 12:02:32', '2023-10-23 04:08:27'),
(9, 29, '11', '6', '0', '0', '5', 1, 1, 1, '2023-03-07 08:38:53', '2023-03-07 08:38:53'),
(10, 30, '-15', '5.00', '0', '10', '6', 1, 1, 1, '2023-03-07 09:22:59', '2023-07-24 10:18:17'),
(11, 31, '18', '5', '0', '1', '6', 1, 1, 1, '2023-03-07 09:23:12', '2023-06-13 07:26:09'),
(12, 33, '28', '7', '20', '2', '6', 1, 1, 1, '2023-03-07 09:24:18', '2023-10-19 09:28:37'),
(13, 34, '9', '2.00', '10', '4', '6', 1, 1, 1, '2023-03-07 09:24:35', '2023-10-19 09:28:37'),
(14, 35, '42', '1', '5', '2', '6', 1, 1, 1, '2023-03-07 09:24:55', '2023-10-19 09:28:37'),
(15, 35, '9', '6', '0', '0', '5', 1, 1, 1, '2023-03-14 09:30:08', '2023-03-15 10:11:14'),
(16, 35, '0', '10', '15', '2', '3', 1, 1, 1, '2023-03-14 09:30:14', '2023-03-21 04:14:26'),
(17, 35, '0', '0', '0', '0', '2', 1, 1, 1, '2023-03-14 09:30:20', '2023-03-14 09:30:20'),
(19, 32, '-44', '0', '12', '1', '6', 1, 1, 1, '2023-03-14 09:35:17', '2023-10-22 09:17:21'),
(20, 32, '9', '7', '0', '0', '5', 1, 1, 1, '2023-03-14 09:35:25', '2023-03-15 10:11:14'),
(21, 32, '0', '0', '0', '0', '2', 1, 1, 1, '2023-03-14 09:39:03', '2023-03-14 09:39:03'),
(22, 35, '55', '5', '7', '9', '1', 1, 1, 1, '2023-03-16 05:26:20', '2023-03-16 05:26:43'),
(24, 35, '0', '0', '15', '0', '10', 1, 1, 1, '2023-03-16 10:37:26', '2023-06-22 10:12:23'),
(25, 35, '-22', '0', '10', '0', '11', 1, 1, 1, '2023-03-16 10:37:33', '2023-07-26 12:29:22'),
(29, 34, '50', '0', '10', '0', '3', 1, 1, 1, '2023-03-21 04:26:10', '2023-03-28 07:52:52'),
(35, 35, '0', '0', '20', '2', '9', 1, 1, 1, '2023-06-22 08:44:40', '2023-06-22 10:06:08'),
(48, 35, '0', '10', '20', '1', '7', 1, 1, 1, '2023-06-22 10:11:59', '2023-06-22 10:11:59'),
(49, 35, '-2', '0', '10', '2', '14', 1, 1, 1, '2023-06-24 04:36:51', '2023-06-24 04:38:32'),
(50, 27, '-1', '0', '20', '0', '14', 1, 1, 1, '2023-06-24 04:37:16', '2023-06-24 09:42:51'),
(51, 34, '0', '0', '0', '0', '14', 0, 1, 1, '2023-07-18 06:36:08', '2023-07-18 06:36:08'),
(52, 34, '0', '0', '0', '0', '11', 1, 1, 1, '2023-07-18 06:36:15', '2023-07-18 06:36:15'),
(53, 34, '0', '0', '0', '0', '10', 0, 1, 1, '2023-07-18 06:36:23', '2023-07-18 06:36:23'),
(54, 34, '0', '0', '0', '0', '5', 0, 4, 4, '2023-07-18 12:38:11', '2023-07-18 12:38:11'),
(55, 34, '0', '0', '0', '0', '9', 0, 4, 4, '2023-07-18 12:38:15', '2023-07-18 12:38:15'),
(56, 34, '0', '0', '0', '0', '7', 0, 4, 4, '2023-07-18 12:38:20', '2023-07-18 12:38:20'),
(57, 34, '0', '0', '0', '0', '2', 1, 4, 4, '2023-07-18 12:38:25', '2023-07-18 12:38:25');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voucher` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_cost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_cost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_cost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grand_total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `date`, `voucher`, `store`, `supplier`, `product_cost`, `tax`, `vat`, `shipping_cost`, `other_cost`, `discount`, `grand_total`, `description`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '04-07-2023', 'sadsad', '6', '2', '41', '5', '0', '0', '0', '0', '46', '', 0, 1, 1, '2023-07-04 08:56:01', '2023-07-04 10:08:43'),
(2, '04-07-2023', 'sadsad', '6', '2', '5', '0', '0', '0', '0', '0', '5', NULL, 2, 1, 1, '2023-07-04 09:50:17', '2023-07-18 05:45:21'),
(3, '20-07-2023', 'v-110', '6', '2', '6', '0', '0', '0', '0', '0', '6', NULL, 1, 6, 6, '2023-07-20 06:18:31', '2023-07-20 06:21:24'),
(4, '24-07-2023', 'v-110', '6', '2', '100', '0', '0', '0', '0', '0', '100', NULL, 2, 1, 1, '2023-07-24 10:17:33', '2023-07-24 10:50:59'),
(5, '24-07-2023', 'i', '6', '2', '35', '0', '0', '0', '0', '0', '35', NULL, 1, 1, 1, '2023-07-24 10:17:50', '2023-07-24 10:18:17'),
(6, '24-07-2023', 'sadsa', '6', '2', '10', '0', '0', '0', '0', '0', '10', NULL, 0, 1, 1, '2023-07-24 10:50:45', '2023-07-24 10:50:45'),
(7, '25-07-2023', 'v-110', '6', '2', '498', '0', '0', '0', '0', '0', '498', NULL, 0, 1, 1, '2023-07-25 05:03:40', '2023-07-25 05:03:40'),
(8, '25-07-2023', 'v-55', '6', '2', '5', '0', '0', '0', '0', '0', '5', NULL, 2, 1, 1, '2023-07-25 05:03:53', '2023-07-25 05:04:12'),
(9, '25-07-2023', 'v-55546', '6', '2', '20', '0', '0', '0', '0', '0', '20', NULL, 1, 1, 1, '2023-07-25 07:15:38', '2023-07-25 07:15:45'),
(10, '26-07-2023', 'v-55546', '6', '2', '1000', '0', '0', '0', '0', '0', '1000', NULL, 0, 1, 1, '2023-07-26 12:12:01', '2023-07-26 12:12:01'),
(11, '26-07-2023', 'i', '6', '2', '20', '0', '0', '0', '0', '0', '20', NULL, 1, 1, 1, '2023-07-26 12:12:20', '2023-07-26 12:12:44'),
(12, '26-07-2023', 'v-110', '5', '2', '10', '0', '0', '0', '0', '0', '10', NULL, 2, 1, 1, '2023-07-26 12:20:27', '2023-07-26 12:30:04');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buying_qty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upwd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`id`, `purchase_id`, `product_id`, `buying_qty`, `unit_price`, `discount`, `upwd`, `total_price`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, '27', '5', '6', '0', '6.00', '30', 1, 1, 1, '2023-07-04 08:56:01', '2023-07-04 10:08:43'),
(2, 1, '28', '5', '6', '0', '6.00', '30', 1, 1, 1, '2023-07-04 08:56:01', '2023-07-04 08:56:01'),
(3, 2, '27', '1', '5', '0', '5.00', '5', 1, 1, 1, '2023-07-04 09:50:17', '2023-07-04 09:50:17'),
(4, 3, '27', '1', '6', '0', '6.00', '6', 1, 6, 6, '2023-07-20 06:18:31', '2023-07-20 06:18:31'),
(5, 4, '27', '10', '10', '0', '10.00', '100', 1, 1, 1, '2023-07-24 10:17:33', '2023-07-24 10:17:33'),
(6, 5, '30', '7', '5', '0', '5.00', '35', 1, 1, 1, '2023-07-24 10:17:50', '2023-07-24 10:17:50'),
(7, 6, '25', '1', '10', '0', '10.00', '10', 1, 1, 1, '2023-07-24 10:50:45', '2023-07-24 10:50:45'),
(8, 7, '27', '50', '10', '2', '9.96', '498', 1, 1, 1, '2023-07-25 05:03:40', '2023-07-25 05:03:40'),
(9, 8, '28', '1', '5', '0', '5.00', '5', 1, 1, 1, '2023-07-25 05:03:53', '2023-07-25 05:03:53'),
(10, 9, '27', '10', '2', '0', '2.00', '20', 1, 1, 1, '2023-07-25 07:15:38', '2023-07-25 07:15:38'),
(11, 10, '28', '100', '10', '0', '10.00', '1000', 1, 1, 1, '2023-07-26 12:12:01', '2023-07-26 12:12:01'),
(12, 11, '34', '10', '2', '0', '2.00', '20', 1, 1, 1, '2023-07-26 12:12:20', '2023-07-26 12:12:20'),
(13, 12, '32', '1', '10', '0', '10.00', '10', 1, 1, 1, '2023-07-26 12:20:27', '2023-07-26 12:20:27');

-- --------------------------------------------------------

--
-- Table structure for table `religions`
--

CREATE TABLE `religions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `religion_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `religions`
--

INSERT INTO `religions` (`id`, `religion_name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Q', 1, 1, 1, '2023-05-31 04:28:47', '2023-05-31 04:28:47');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_type` tinyint(4) NOT NULL DEFAULT 0,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `role_type`, `guard_name`, `created_at`, `updated_at`) VALUES
(6, 'Super Admin', 5, 'admin', '2023-07-18 09:27:50', '2023-07-18 09:27:50'),
(7, 'Test', 0, 'admin', '2023-07-18 09:33:44', '2023-07-18 09:33:44'),
(8, 'Manager', 0, 'admin', '2023-07-20 06:00:53', '2023-07-20 06:00:53'),
(9, 'Sales', 0, 'admin', '2023-07-20 06:01:05', '2023-07-20 06:01:05');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(99, 6),
(99, 7),
(100, 6),
(101, 6),
(102, 6),
(103, 6),
(104, 6),
(105, 6),
(106, 6),
(107, 6),
(108, 6),
(109, 6),
(110, 6),
(111, 6),
(111, 8),
(112, 6),
(112, 8),
(112, 9),
(113, 6),
(113, 8),
(113, 9),
(114, 6),
(114, 8),
(114, 9),
(115, 6),
(115, 8),
(116, 6),
(116, 8),
(117, 6),
(117, 8),
(118, 6),
(118, 8),
(118, 9),
(119, 6),
(119, 8),
(119, 9),
(120, 6),
(120, 8),
(121, 6),
(121, 8),
(122, 6),
(123, 6),
(124, 6),
(125, 6),
(126, 6),
(127, 6),
(127, 8),
(128, 6),
(128, 8),
(129, 6),
(129, 8),
(130, 6),
(130, 8),
(131, 6),
(132, 6),
(133, 6),
(133, 8),
(134, 6),
(134, 8),
(135, 6),
(135, 8),
(136, 6),
(136, 8),
(137, 6),
(137, 8),
(138, 6),
(138, 8),
(139, 6),
(139, 8),
(140, 6),
(140, 8),
(141, 6),
(142, 6),
(143, 6),
(143, 8),
(144, 6),
(145, 6),
(146, 6),
(147, 6),
(148, 6),
(149, 6),
(150, 6),
(151, 6),
(152, 6),
(153, 6),
(154, 6),
(155, 6),
(156, 6),
(157, 6),
(158, 6),
(159, 6),
(160, 6),
(161, 6),
(162, 6),
(163, 6),
(164, 6),
(165, 6),
(166, 6),
(167, 6),
(168, 6),
(169, 6),
(170, 6),
(171, 6),
(172, 6),
(173, 6),
(174, 6),
(175, 6),
(176, 6),
(177, 6),
(178, 6),
(179, 6),
(180, 6),
(181, 6),
(182, 6),
(183, 6),
(184, 6),
(185, 6),
(186, 6),
(187, 6),
(188, 6),
(189, 6),
(190, 6),
(191, 6),
(192, 6),
(193, 6),
(194, 6),
(195, 6),
(196, 6),
(197, 6),
(198, 6),
(199, 6),
(200, 6),
(201, 6),
(202, 6),
(203, 6),
(204, 6),
(205, 6),
(206, 6),
(207, 6),
(208, 6),
(209, 6),
(210, 6),
(211, 6),
(212, 6),
(213, 6),
(214, 6),
(215, 6),
(216, 6),
(217, 6),
(218, 6),
(219, 6),
(220, 6),
(221, 6),
(222, 6),
(223, 6),
(224, 6),
(225, 6),
(226, 6),
(227, 6),
(228, 6),
(229, 6),
(230, 6),
(231, 6),
(232, 6),
(233, 6),
(234, 6),
(235, 6),
(235, 8);

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_url` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `store_name`, `phone`, `email`, `web_url`, `address`, `description`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Mirpur-1', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2023-02-20 09:43:46', '2023-05-31 10:29:53'),
(2, 'Mirpur-2', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, '2023-02-20 09:43:54', '2023-02-20 09:43:54'),
(3, 'Mirpur-3', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, '2023-02-20 09:44:01', '2023-02-20 10:44:49'),
(4, 'Mirpur-4', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2023-02-20 09:44:09', '2023-02-23 05:56:22'),
(5, 'Mirpur-5', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, '2023-02-20 09:44:17', '2023-02-23 05:54:10'),
(6, 'Mirpur-6', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, '2023-02-20 09:44:28', '2023-02-23 05:54:07'),
(7, 'Mirpur-7', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, '2023-03-16 10:36:32', '2023-03-16 10:36:32'),
(9, 'Mirpur-9', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, '2023-03-16 10:36:46', '2023-03-16 10:36:46'),
(10, 'Mirpur-10', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, '2023-03-16 10:36:53', '2023-03-16 10:36:53'),
(11, 'Mirpur-11', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, '2023-03-16 10:37:00', '2023-03-16 10:37:00'),
(12, 'fghgfh', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2023-03-16 10:37:05', '2023-04-30 06:29:13'),
(13, 'ffffffff', NULL, NULL, NULL, NULL, NULL, 0, 1, 1, '2023-03-16 10:37:10', '2023-04-30 06:29:09'),
(14, 'TEST', '01925588996', NULL, NULL, NULL, NULL, 1, 1, 1, '2023-06-24 04:33:08', '2023-06-24 04:33:08');

-- --------------------------------------------------------

--
-- Table structure for table `store_permissions`
--

CREATE TABLE `store_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sm_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_permissions`
--

INSERT INTO `store_permissions` (`id`, `sm_code`, `emp_id`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(17, 'sp-0017', 3, 1, 3, 1, '2023-03-15 05:49:48', '2023-06-21 12:15:21'),
(19, 'sp-0019', 2, 1, 1, 1, '2023-05-08 10:13:43', '2023-07-27 09:08:56'),
(20, 'sp-0020', 4, 0, 1, 1, '2023-05-31 10:34:00', '2023-07-27 04:51:14'),
(21, 'sp-0021', 5, 1, 1, 1, '2023-05-31 10:34:09', '2023-07-27 09:02:09'),
(22, 'sp-0022', 1, 1, 1, 1, '2023-05-31 10:36:33', '2023-07-26 12:30:21'),
(23, 'sp-0023', 6, 1, 1, 1, '2023-07-20 06:04:34', '2023-07-27 10:15:28');

-- --------------------------------------------------------

--
-- Table structure for table `store_permission_details`
--

CREATE TABLE `store_permission_details` (
  `sp_id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_permission_details`
--

INSERT INTO `store_permission_details` (`sp_id`, `store_id`, `created_at`, `updated_at`) VALUES
(20, 2, '2023-07-27 04:51:14', '2023-07-27 04:51:14'),
(20, 10, '2023-07-27 04:51:14', '2023-07-27 04:51:14'),
(17, 2, '2023-07-27 09:02:41', '2023-07-27 09:02:41'),
(21, 2, '2023-07-27 10:00:06', '2023-07-27 10:00:06'),
(21, 3, '2023-07-27 10:00:06', '2023-07-27 10:00:06'),
(19, 2, '2023-07-27 10:00:23', '2023-07-27 10:00:23'),
(19, 9, '2023-07-27 10:00:23', '2023-07-27 10:00:23'),
(23, 14, '2023-07-27 11:45:29', '2023-07-27 11:45:29'),
(23, 6, '2023-07-27 11:45:29', '2023-07-27 11:45:29'),
(22, 6, '2023-10-17 05:29:33', '2023-10-17 05:29:33'),
(22, 14, '2023-10-17 05:29:33', '2023-10-17 05:29:33');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `email`, `phone`, `address`, `description`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 'Beximco2', 'test3@gmail.com', '01925588996', 'ghdtfhft', 'dfgdgds', 1, 1, 1, '2023-02-22 05:44:20', '2023-02-22 07:18:24');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_wise_stores`
--

CREATE TABLE `supplier_wise_stores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sws_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_wise_stores`
--

INSERT INTO `supplier_wise_stores` (`id`, `sws_code`, `supplier_id`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(10, 'sws-001', 2, 1, 4, 1, '2023-07-18 11:57:12', '2023-07-18 12:24:50');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_wise_store_details`
--

CREATE TABLE `supplier_wise_store_details` (
  `sws_id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_wise_store_details`
--

INSERT INTO `supplier_wise_store_details` (`sws_id`, `store_id`, `created_at`, `updated_at`) VALUES
(10, 14, '2023-07-18 12:24:50', '2023-07-18 12:24:50'),
(10, 11, '2023-07-18 12:24:50', '2023-07-18 12:24:50'),
(10, 10, '2023-07-18 12:24:50', '2023-07-18 12:24:50'),
(10, 9, '2023-07-18 12:24:50', '2023-07-18 12:24:50'),
(10, 7, '2023-07-18 12:24:50', '2023-07-18 12:24:50'),
(10, 6, '2023-07-18 12:24:50', '2023-07-18 12:24:50'),
(10, 5, '2023-07-18 12:24:50', '2023-07-18 12:24:50'),
(10, 3, '2023-07-18 12:24:50', '2023-07-18 12:24:50'),
(10, 2, '2023-07-18 12:24:50', '2023-07-18 12:24:50');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `added_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit_name`, `status`, `added_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'KG', 1, 1, 1, '2023-02-23 09:45:06', '2023-02-23 09:45:06'),
(2, 'PC', 1, 1, 1, '2023-02-23 09:45:10', '2023-02-23 09:45:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `user_type` tinyint(4) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trede_license` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opening_balance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `family_member` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marketing_source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Joining_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `add_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `admin_details`
--
ALTER TABLE `admin_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_details_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `blood_groups`
--
ALTER TABLE `blood_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_manages`
--
ALTER TABLE `expense_manages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_types`
--
ALTER TABLE `expense_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logo_titles`
--
ALTER TABLE `logo_titles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_types`
--
ALTER TABLE `payment_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_details_purchase_id_foreign` (`purchase_id`);

--
-- Indexes for table `religions`
--
ALTER TABLE `religions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_permissions`
--
ALTER TABLE `store_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_wise_stores`
--
ALTER TABLE `supplier_wise_stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `admin_details`
--
ALTER TABLE `admin_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blood_groups`
--
ALTER TABLE `blood_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expense_manages`
--
ALTER TABLE `expense_manages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `expense_types`
--
ALTER TABLE `expense_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `logo_titles`
--
ALTER TABLE `logo_titles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `payment_types`
--
ALTER TABLE `payment_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `religions`
--
ALTER TABLE `religions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `store_permissions`
--
ALTER TABLE `store_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `supplier_wise_stores`
--
ALTER TABLE `supplier_wise_stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_details`
--
ALTER TABLE `admin_details`
  ADD CONSTRAINT `admin_details_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_details`
--
ALTER TABLE `product_details`
  ADD CONSTRAINT `product_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD CONSTRAINT `purchase_details_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
