-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 10:47 PM
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
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `loan_type_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `interest_rate` decimal(5,2) NOT NULL,
  `duration` int(11) NOT NULL,
  `status` enum('pending','approved','rejected','disbursed','fully repaid') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `user_id`, `loan_type_id`, `amount`, `interest_rate`, `duration`, `status`, `created_at`, `updated_at`, `approved_at`) VALUES
(1, 1, 1, 250000.00, 5.00, 6, 'approved', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(3, 1, 1, 260000.00, 7.00, 2, 'approved', NULL, '2024-12-16 13:59:00', '2024-12-16 13:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `loan_types`
--

CREATE TABLE `loan_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `min_amount` decimal(10,2) NOT NULL,
  `max_amount` decimal(10,2) NOT NULL,
  `default_interest_rate` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_types`
--

INSERT INTO `loan_types` (`id`, `name`, `description`, `min_amount`, `max_amount`, `default_interest_rate`, `created_at`, `updated_at`) VALUES
(1, 'Home Loan', 'A loan for purchasing or renovating a home, with longer repayment terms.', 500000.00, 25000000.00, 9.00, NULL, '2024-12-14 09:23:51'),
(15, 'Personal Loan', 'A loan for personal use with flexible repayment terms.', 150000.00, 900000.00, 12.50, '2024-12-16 21:41:51', '2024-12-16 21:41:51'),
(16, 'Student Loan', 'A loan for funding education expenses, typically with longer repayment terms and lower interest rates.', 50000.00, 300000.00, 5.00, '2024-12-16 21:41:51', '2024-12-16 21:41:51'),
(17, 'Business Loan', 'A loan to fund business operations or expansion, usually requiring a solid business plan and financial history.', 100000.00, 20000000.00, 8.00, '2024-12-16 21:41:51', '2024-12-16 21:41:51');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_10_31_062910_create_products_table', 1),
(6, '2024_12_10_111941_add_role_to_users_table', 2),
(7, '2024_12_14_022802_create_loan_types_table', 3),
(8, '2024_12_14_103433_add_details_to_users_table', 4),
(9, '2024_12_14_163045_create_loans_table', 5),
(10, '2024_12_14_163107_create_repayments_table', 5),
(11, '2024_12_14_163116_create_payments_table', 5),
(12, '2024_12_14_173703_add_yearly_salary_and_profession_to_users_table', 6),
(13, '2024_12_16_111737_update_payments_table_add_transaction_id_and_pending_status', 7),
(14, '2024_12_16_195538_add_approved_at_to_loans_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `repayment_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` enum('bkash','nagad','rocket','bank') NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `status` enum('pending','completed','failed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `repayment_id`, `user_id`, `amount`, `method`, `transaction_id`, `status`, `created_at`, `updated_at`) VALUES
(11, 105, 1, 5000.00, 'bkash', 'TXN1234555', 'completed', '2024-12-16 11:38:24', '2024-12-16 13:26:57'),
(12, 109, 1, 15000.00, 'nagad', 'TXN123457', 'pending', '2024-12-16 11:38:24', '2024-12-16 05:39:42'),
(13, 110, 1, 10000.00, 'rocket', 'TXN123458', 'pending', '2024-12-16 11:38:24', '2024-12-16 13:15:18'),
(14, 111, 1, 20000.00, 'bank', 'TXN123459', 'pending', '2024-12-16 11:38:24', '2024-12-16 13:15:18'),
(15, 112, 1, 25000.00, 'bkash', 'TXN123460', 'pending', '2024-12-16 11:38:24', '2024-12-16 13:15:18'),
(16, 113, 1, 5000.00, 'nagad', 'TXN123461', 'pending', '2024-12-16 11:38:24', '2024-12-16 13:15:25'),
(17, 114, 1, 3000.00, 'rocket', 'TXN123462', 'pending', '2024-12-16 11:38:24', '2024-12-16 13:15:30'),
(18, 115, 1, 12000.00, 'bank', 'TXN123463', 'pending', '2024-12-16 11:38:24', '2024-12-16 06:26:11'),
(19, 116, 1, 11000.00, 'bkash', 'TXN123464', 'completed', '2024-12-16 11:38:24', '2024-12-16 11:38:24'),
(21, 120, 1, 12350.00, 'nagad', '', 'pending', '2024-12-16 10:36:17', '2024-12-16 10:36:17'),
(22, 122, 1, 12350.00, 'bkash', '', 'completed', '2024-12-16 10:37:22', '2024-12-16 10:37:22'),
(23, 120, 1, 12350.00, 'nagad', 'dfdfdfd', 'completed', '2024-12-16 10:42:50', '2024-12-16 10:42:50');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `repayments`
--

CREATE TABLE `repayments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_id` bigint(20) UNSIGNED NOT NULL,
  `installment_number` int(11) NOT NULL,
  `due_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','overdue') NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `repayments`
--

INSERT INTO `repayments` (`id`, `loan_id`, `installment_number`, `due_date`, `amount`, `status`, `paid_at`, `created_at`, `updated_at`) VALUES
(101, 3, 3, '2025-03-03', 12350.00, 'paid', '2024-12-16 14:31:27', '2024-12-15 11:35:39', '2024-12-16 14:31:27'),
(103, 3, 5, '2025-05-15', 12350.00, 'paid', NULL, '2024-12-15 11:35:39', '2024-12-16 03:14:20'),
(104, 3, 6, '2025-06-15', 12350.00, 'paid', NULL, '2024-12-15 11:35:39', '2024-12-16 03:15:48'),
(105, 3, 7, '2025-07-15', 12350.00, 'paid', NULL, '2024-12-15 11:35:39', '2024-12-16 13:26:57'),
(106, 3, 8, '2025-08-15', 12350.00, 'paid', NULL, '2024-12-15 11:35:39', '2024-12-16 03:20:50'),
(107, 3, 9, '2025-09-15', 12350.00, 'paid', NULL, '2024-12-15 11:35:39', '2024-12-16 04:00:21'),
(108, 3, 10, '2025-10-15', 12350.00, 'paid', NULL, '2024-12-15 11:35:39', '2024-12-16 04:00:49'),
(109, 3, 11, '2025-11-15', 12350.00, 'paid', NULL, '2024-12-15 11:35:39', '2024-12-16 14:28:26'),
(110, 3, 12, '2025-12-15', 12350.00, 'pending', NULL, '2024-12-15 11:35:39', '2024-12-15 11:35:39'),
(111, 3, 13, '2026-01-15', 12350.00, 'pending', NULL, '2024-12-15 11:35:39', '2024-12-15 11:35:39'),
(112, 3, 14, '2026-02-15', 12350.00, 'pending', NULL, '2024-12-15 11:35:39', '2024-12-15 11:35:39'),
(113, 3, 15, '2026-03-15', 12350.00, 'pending', NULL, '2024-12-15 11:35:39', '2024-12-15 11:35:39'),
(114, 3, 16, '2026-04-15', 12350.00, 'pending', NULL, '2024-12-15 11:35:39', '2024-12-15 11:35:39'),
(115, 3, 17, '2026-05-15', 12350.00, 'pending', NULL, '2024-12-15 11:35:39', '2024-12-15 11:35:39'),
(116, 3, 18, '2026-06-15', 12350.00, 'pending', NULL, '2024-12-15 11:35:39', '2024-12-15 11:35:39'),
(117, 3, 19, '2026-07-15', 12350.00, 'pending', NULL, '2024-12-15 11:35:39', '2024-12-15 11:35:39'),
(118, 3, 20, '2026-08-15', 12350.00, 'pending', NULL, '2024-12-15 11:35:39', '2024-12-15 11:35:39'),
(119, 3, 21, '2026-09-15', 12350.00, 'pending', NULL, '2024-12-15 11:35:39', '2024-12-15 11:35:39'),
(120, 3, 22, '2026-10-15', 12350.00, 'pending', NULL, '2024-12-15 11:35:39', '2024-12-15 11:35:39'),
(121, 3, 23, '2026-11-15', 12350.00, 'pending', NULL, '2024-12-15 11:35:39', '2024-12-15 11:35:39'),
(122, 3, 24, '2026-12-15', 12350.00, 'pending', NULL, '2024-12-15 11:35:39', '2024-12-15 11:35:39'),
(123, 3, 4, '2025-01-15', 12473.50, 'pending', NULL, '2024-12-16 01:33:22', '2024-12-16 01:33:22'),
(124, 3, 4, '2025-01-15', 12473.50, 'pending', NULL, '2024-12-16 01:34:16', '2024-12-16 01:34:16'),
(125, 3, 4, '2025-01-16', 12473.50, 'pending', NULL, '2024-12-16 02:55:37', '2024-12-16 02:55:37'),
(126, 3, 4, '2025-01-16', 12473.50, 'pending', NULL, '2024-12-16 03:02:06', '2024-12-16 03:02:06'),
(127, 3, 4, '2025-01-16', 12473.50, 'pending', NULL, '2024-12-16 03:02:56', '2024-12-16 03:02:56'),
(128, 3, 10, '2025-01-16', 12473.50, 'pending', NULL, '2024-12-16 03:20:59', '2024-12-16 03:20:59'),
(129, 3, 11, '2025-01-16', 12473.50, 'pending', NULL, '2024-12-16 04:00:39', '2024-12-16 04:00:39'),
(130, 1, 1, '2025-01-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(131, 1, 2, '2025-02-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(132, 1, 3, '2025-03-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(133, 1, 4, '2025-04-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(134, 1, 5, '2025-05-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(135, 1, 6, '2025-06-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(136, 1, 7, '2025-07-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(137, 1, 8, '2025-08-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(138, 1, 9, '2025-09-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(139, 1, 10, '2025-10-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(140, 1, 11, '2025-11-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(141, 1, 12, '2025-12-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(142, 1, 13, '2026-01-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(143, 1, 14, '2026-02-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(144, 1, 15, '2026-03-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(145, 1, 16, '2026-04-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(146, 1, 17, '2026-05-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(147, 1, 18, '2026-06-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(148, 1, 19, '2026-07-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(149, 1, 20, '2026-08-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(150, 1, 21, '2026-09-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(151, 1, 22, '2026-10-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(152, 1, 23, '2026-11-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(153, 1, 24, '2026-12-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(154, 1, 25, '2027-01-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(155, 1, 26, '2027-02-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(156, 1, 27, '2027-03-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(157, 1, 28, '2027-04-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(158, 1, 29, '2027-05-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(159, 1, 30, '2027-06-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(160, 1, 31, '2027-07-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(161, 1, 32, '2027-08-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(162, 1, 33, '2027-09-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(163, 1, 34, '2027-10-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(164, 1, 35, '2027-11-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(165, 1, 36, '2027-12-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(166, 1, 37, '2028-01-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(167, 1, 38, '2028-02-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(168, 1, 39, '2028-03-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(169, 1, 40, '2028-04-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(170, 1, 41, '2028-05-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(171, 1, 42, '2028-06-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(172, 1, 43, '2028-07-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(173, 1, 44, '2028-08-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(174, 1, 45, '2028-09-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(175, 1, 46, '2028-10-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(176, 1, 47, '2028-11-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(177, 1, 48, '2028-12-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(178, 1, 49, '2029-01-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(179, 1, 50, '2029-02-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(180, 1, 51, '2029-03-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(181, 1, 52, '2029-04-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(182, 1, 53, '2029-05-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(183, 1, 54, '2029-06-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(184, 1, 55, '2029-07-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(185, 1, 56, '2029-08-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(186, 1, 57, '2029-09-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(187, 1, 58, '2029-10-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(188, 1, 59, '2029-11-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(189, 1, 60, '2029-12-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(190, 1, 61, '2030-01-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(191, 1, 62, '2030-02-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(192, 1, 63, '2030-03-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(193, 1, 64, '2030-04-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(194, 1, 65, '2030-05-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(195, 1, 66, '2030-06-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(196, 1, 67, '2030-07-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(197, 1, 68, '2030-08-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(198, 1, 69, '2030-09-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(199, 1, 70, '2030-10-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(200, 1, 71, '2030-11-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37'),
(201, 1, 72, '2030-12-16', 4513.89, 'pending', NULL, '2024-12-16 13:58:37', '2024-12-16 13:58:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `date_of_birth` date DEFAULT NULL,
  `marital_status` enum('single','married') DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `present_address` text DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `yearly_salary` decimal(10,2) DEFAULT NULL,
  `profession` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `date_of_birth`, `marital_status`, `mobile_number`, `present_address`, `state`, `city`, `postal_code`, `image`, `yearly_salary`, `profession`) VALUES
(1, 'NazmulJoy', 'admin@gmail.com', NULL, '$2y$10$sOrFs9TDrIRjxZcw5PXlUOiTfv7Dk4fhxN3khBvmZxW.z.7Dpl6xm', NULL, '2024-12-10 05:38:00', '2024-12-14 09:24:51', 'admin', '1998-04-16', 'single', '01674450396', 'Kadamtoli,keraniganj,dhaka', 'Keraniganj', 'Dhaka', '1210', 'PV-71940.jpg', 1500000.00, 'Student'),
(6, 'John Doe', 'johndoe@example.com', NULL, '$2y$10$vYL8TxuVzuUHJUvzI4BTpOeq4.HBTnoVwEYBNbctPIOuCbe3IvUwW', NULL, '2024-12-16 21:45:44', '2024-12-16 21:45:44', 'user', '1990-04-15', 'single', '1234567890', '123 Elm St', 'California', 'Los Angeles', '90001', NULL, 55000.00, 'Software Engineer'),
(7, 'Emily Smith', 'emilysmith@example.com', NULL, '$2y$10$.eCbbujfzRfIl0QSa5YkH.4N13njBxE9SACOboV/hAc.Hu82eGLca', NULL, '2024-12-16 21:45:44', '2024-12-16 21:45:44', 'user', '1985-11-20', 'married', '2345678901', '456 Oak St', 'Texas', 'Houston', '77001', NULL, 75000.00, 'Teacher'),
(8, 'Michael Brown', 'michaelbrown@example.com', NULL, '$2y$10$Ofpj.U0hCxM4sVRqQO1wZOaLCJ0yd9pgMwotp5sK8Zn0RS6v.3Hve', NULL, '2024-12-16 21:45:44', '2024-12-16 21:45:44', 'user', '1992-07-09', 'married', '3456789012', '789 Pine St', 'Florida', 'Miami', '33101', NULL, 65000.00, 'Sales Manager'),
(9, 'Sarah Johnson', 'sarahjohnson@example.com', NULL, '$2y$10$HpGw6bUMYRWknQ0L3XGMXOxaKrLG.bu66grbO.rOjWV7ltTbh6PTC', NULL, '2024-12-16 21:45:44', '2024-12-16 21:45:44', 'user', '1995-02-25', 'single', '4567890123', '101 Maple St', 'New York', 'New York', '10001', NULL, 45000.00, 'Nurse');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loans_user_id_foreign` (`user_id`),
  ADD KEY `loans_loan_type_id_foreign` (`loan_type_id`);

--
-- Indexes for table `loan_types`
--
ALTER TABLE `loan_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_repayment_id_foreign` (`repayment_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `repayments`
--
ALTER TABLE `repayments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `repayments_loan_id_foreign` (`loan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `loan_types`
--
ALTER TABLE `loan_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `repayments`
--
ALTER TABLE `repayments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_loan_type_id_foreign` FOREIGN KEY (`loan_type_id`) REFERENCES `loan_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_repayment_id_foreign` FOREIGN KEY (`repayment_id`) REFERENCES `repayments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `repayments`
--
ALTER TABLE `repayments`
  ADD CONSTRAINT `repayments_loan_id_foreign` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
