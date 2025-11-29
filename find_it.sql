-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2025 at 01:05 PM
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
-- Database: `find_it`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `related_id` bigint(20) UNSIGNED DEFAULT NULL,
  `related_type` varchar(255) DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`id`, `user_id`, `title`, `message`, `type`, `status`, `label`, `is_read`, `related_id`, `related_type`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Test Alert', 'This is just a test.', 'test', NULL, NULL, 1, NULL, NULL, '2025-11-02 03:01:02', '2025-11-01 04:19:10', '2025-11-02 03:01:02'),
(2, 1, 'Claim Submitted', 'Your claim for \"dfdf\" has been sent and is pending admin approval.', 'claim_submitted', NULL, NULL, 1, 1, 'App\\Models\\Claim', '2025-11-02 03:01:07', '2025-11-01 04:28:12', '2025-11-02 03:01:07'),
(3, 1, 'Test Report Alert', 'This is a test alert for report submission.', 'report_submitted', NULL, NULL, 1, 1, 'App\\Models\\Item', '2025-11-02 03:01:06', '2025-11-01 21:46:49', '2025-11-02 03:01:06'),
(4, 1, 'Claim Submitted', 'Your claim for \"xcxc\" has been sent and is pending admin approval.', 'claim_submitted', NULL, NULL, 1, 2, 'App\\Models\\Claim', '2025-11-02 03:01:06', '2025-11-02 02:40:47', '2025-11-02 03:01:06'),
(5, 1, 'Report Submitted', 'Your Lost report for \"ttyytyt\" has been submitted and is pending approval.', 'report_submitted', NULL, NULL, 1, 15, 'App\\Models\\Item', '2025-11-02 03:01:05', '2025-11-02 02:50:17', '2025-11-02 03:01:05'),
(6, 1, 'Report Submitted', 'Your Found report for \"ulet\" has been submitted and is pending approval.', 'report_submitted', NULL, NULL, 1, 16, 'App\\Models\\Item', '2025-11-02 03:01:05', '2025-11-02 02:50:58', '2025-11-02 03:01:05'),
(7, 1, 'Report Submitted', 'Your Lost report for \"YAYAYYAYA\" has been submitted and is pending approval.', 'report_submitted', NULL, NULL, 1, 17, 'App\\Models\\Item', '2025-11-02 03:01:05', '2025-11-02 02:53:44', '2025-11-02 03:01:05'),
(8, 1, 'Report Submitted', 'Your Lost report for \"a17\" has been submitted and is pending approval.', 'report_submitted', 'pending', 'lost', 1, 18, 'App\\Models\\Item', '2025-11-09 03:08:33', '2025-11-02 03:07:12', '2025-11-09 03:08:33'),
(9, 1, 'Claim Submitted', 'Your claim for \"sdfsdf\" is pending review.', 'claim_submitted', 'pending', 'claim', 0, 3, 'App\\Models\\Claim', NULL, '2025-11-02 03:16:55', '2025-11-02 03:16:55'),
(10, 1, 'Report Submitted', 'Your Found report for \"5y567\" is pending approval.', 'report_submitted', 'pending', 'found', 0, 19, 'App\\Models\\Item', NULL, '2025-11-04 04:01:25', '2025-11-04 04:01:25'),
(11, 1, 'Report Submitted', 'Your Found report for \"22332\" is pending approval.', 'report_submitted', 'pending', 'found', 0, 20, 'App\\Models\\Item', NULL, '2025-11-04 04:11:57', '2025-11-04 04:11:57'),
(12, 1, 'Report Submitted', 'Your Lost report for \"4t3t3434t\" is pending approval.', 'report_submitted', 'pending', 'lost', 0, 21, 'App\\Models\\Item', NULL, '2025-11-04 04:21:18', '2025-11-04 04:21:18'),
(13, 1, 'Report Submitted', 'Your Lost report for \"23423\" is pending approval.', 'report_submitted', 'pending', 'lost', 0, 22, 'App\\Models\\Item', NULL, '2025-11-04 12:05:06', '2025-11-04 12:05:06'),
(14, 1, 'Report Submitted', 'Your Lost report for \"id\" is pending approval.', 'report_submitted', 'pending', 'lost', 0, 23, 'App\\Models\\Item', NULL, '2025-11-04 12:11:21', '2025-11-04 12:11:21'),
(15, 1, 'Claim Submitted', 'Your claim for \"aa\" is pending review.', 'claim_submitted', 'pending', 'claim', 0, 4, 'App\\Models\\Claim', NULL, '2025-11-04 12:14:51', '2025-11-04 12:14:51'),
(16, 1, 'Report Submitted', 'Your Lost report for \"hello\" is pending approval.', 'report_submitted', 'pending', 'lost', 0, 24, 'App\\Models\\Item', NULL, '2025-11-04 12:18:19', '2025-11-04 12:18:19'),
(17, 1, 'Claim Submitted', 'Your claim for \"EWRWERTE\" is pending review.', 'claim_submitted', 'pending', 'claim', 0, 5, 'App\\Models\\Claim', NULL, '2025-11-09 03:08:22', '2025-11-09 03:08:22'),
(18, 1, 'Report Submitted', 'Your Lost report for \"MAcbook air\" is pending approval.', 'report_submitted', 'pending', 'lost', 0, 25, 'App\\Models\\Item', NULL, '2025-11-09 03:09:57', '2025-11-09 03:09:57'),
(19, 1, 'Report Submitted', 'Your Lost report for \"iPhone 17\" is pending approval.', 'report_submitted', 'pending', 'lost', 0, 26, 'App\\Models\\Item', NULL, '2025-11-09 03:16:29', '2025-11-09 03:16:29'),
(20, 1, 'Claim Submitted', 'Your claim for \"rdtert4ert\" is pending review.', 'claim_submitted', 'pending', 'claim', 0, 6, 'App\\Models\\Claim', NULL, '2025-11-09 03:17:09', '2025-11-09 03:17:09'),
(21, 1, 'Report Submitted', 'Your Lost report for \"weew\" is pending approval.', 'report_submitted', 'pending', 'lost', 0, NULL, 'App\\Models\\Item', NULL, '2025-11-11 03:50:37', '2025-11-11 03:50:37'),
(22, 1, 'Report Submitted', 'Your Lost report for \"fan\" is pending approval.', 'report_submitted', 'pending', 'lost', 0, 28, 'App\\Models\\Item', NULL, '2025-11-11 06:04:02', '2025-11-11 06:04:02'),
(23, 1, 'Report Approved', 'Your report for \"22332\" has been approved.', 'report_approved', 'approved', 'found', 0, 20, 'App\\Models\\Item', NULL, '2025-11-21 19:11:25', '2025-11-21 19:11:25'),
(24, 1, 'Report Approved', 'Your report for \"22332\" has been approved.', 'report_approved', 'approved', 'found', 0, 20, 'App\\Models\\Item', NULL, '2025-11-21 19:15:08', '2025-11-21 19:15:08'),
(25, 1, 'Report Approved', 'Your report for \"22332\" has been approved.', 'report_approved', 'approved', 'found', 0, 20, 'App\\Models\\Item', NULL, '2025-11-21 19:16:13', '2025-11-21 19:16:13'),
(26, 1, 'Report Approved', 'Your report for \"4534\" has been approved.', 'report_approved', 'approved', 'lost', 0, 13, 'App\\Models\\Item', NULL, '2025-11-21 19:16:18', '2025-11-21 19:16:18'),
(27, 1, 'Report Approved', 'Your report for \"sws\" has been approved.', 'report_approved', 'approved', 'lost', 0, 6, 'App\\Models\\Item', NULL, '2025-11-21 19:29:44', '2025-11-21 19:29:44'),
(28, 1, 'Report Deleted', 'Your report for \"wewe\" has been deleted.', 'report_deleted', 'deleted', 'lost', 0, 5, 'App\\Models\\Item', NULL, '2025-11-21 19:31:44', '2025-11-21 19:31:44'),
(29, 1, 'Claim Approved', 'Your claim for \"xcxc\" has been approved.', 'claim_approved', 'approved', 'claim', 0, 2, 'App\\Models\\Claim', NULL, '2025-11-21 19:31:58', '2025-11-21 19:31:58'),
(30, 1, 'Claim Approved', 'Your claim for \"sdfsdf\" has been approved.', 'claim_approved', 'approved', 'claim', 0, 3, 'App\\Models\\Claim', NULL, '2025-11-21 19:32:08', '2025-11-21 19:32:08'),
(31, 1, 'Report Submitted', 'Your Lost report for \"Iphone 17\" is pending approval.', 'report_submitted', 'pending', 'lost', 0, 29, 'App\\Models\\Item', NULL, '2025-11-22 04:32:35', '2025-11-22 04:32:35'),
(32, 1, 'Report Submitted', 'Your Found report for \"Iphone 17\" is pending approval.', 'report_submitted', 'pending', 'found', 1, 30, 'App\\Models\\Item', '2025-11-22 04:33:31', '2025-11-22 04:33:11', '2025-11-22 04:33:31'),
(33, 1, 'Potential Match Found', 'A potential match for your found item \"Iphone 17\" has been found. Please check and claim if it\'s yours.', 'match_found', 'matched', 'found', 1, 29, 'App\\Models\\Item', '2025-11-22 05:25:03', '2025-11-22 04:33:11', '2025-11-22 05:25:03'),
(34, 1, 'Potential Match Found', 'Someone reported a found item that might match your lost report for \"Iphone 17\".', 'match_found', 'matched', 'lost', 1, 30, 'App\\Models\\Item', '2025-11-22 05:25:10', '2025-11-22 04:33:11', '2025-11-22 05:25:10'),
(35, 1, 'Report Submitted', 'Your Found report for \"Samsung s25\" is pending approval.', 'report_submitted', 'pending', 'found', 0, 31, 'App\\Models\\Item', NULL, '2025-11-22 05:35:16', '2025-11-22 05:35:16'),
(36, 1, 'Report Submitted', 'Your Lost report for \"Samsung s25\" is pending approval.', 'report_submitted', 'pending', 'lost', 0, 32, 'App\\Models\\Item', NULL, '2025-11-22 05:36:20', '2025-11-22 05:36:20'),
(37, 1, 'Report Submitted', 'Your Found report for \"Samsung s25\" is pending approval.', 'report_submitted', 'pending', 'found', 0, 33, 'App\\Models\\Item', NULL, '2025-11-22 05:37:04', '2025-11-22 05:37:04'),
(38, 1, 'Report Submitted', 'Your Lost report for \"Samsung s25\" is pending approval.', 'report_submitted', 'pending', 'lost', 0, 34, 'App\\Models\\Item', NULL, '2025-11-22 05:43:41', '2025-11-22 05:43:41'),
(39, 1, 'Potential Match Found', 'A potential match for your lost item \"Samsung s25\" has been found. Please check and verify if it’s yours.', 'match_found', 'matched', 'lost', 1, 31, 'App\\Models\\Item', '2025-11-22 05:43:57', '2025-11-22 05:43:41', '2025-11-22 05:43:57'),
(40, 1, 'Potential Match Found', 'A potential match for your lost item \"Samsung s25\" has been found. Please check and verify if it’s yours.', 'match_found', 'matched', 'lost', 1, 33, 'App\\Models\\Item', '2025-11-22 05:44:00', '2025-11-22 05:43:41', '2025-11-22 05:44:00'),
(41, 1, 'Potential Match Found', 'A found item might match your lost report for \"mi 14t\". Please review and confirm if it’s yours.', 'match_found', 'matched', 'lost', 0, 36, 'App\\Models\\Item', NULL, '2025-11-22 17:29:37', '2025-11-22 17:29:37'),
(42, 2, 'Report Approved', 'You approved the report for \"ulet\".', 'report_approved', 'approved', 'report', 0, 16, 'App\\Models\\Item', NULL, '2025-11-22 18:00:12', '2025-11-22 18:00:12'),
(43, 2, 'Report Deleted', 'You deleted the report for \"ttyytyt\".', 'report_deleted', 'deleted', 'report', 0, 15, 'App\\Models\\Item', NULL, '2025-11-22 18:03:44', '2025-11-22 18:03:44'),
(44, 2, 'Claim Rejected', 'You rejected the claim for \"sdfsdf\".', 'claim_rejected', 'rejected', 'claim', 0, 3, 'App\\Models\\Claim', NULL, '2025-11-22 18:10:52', '2025-11-22 18:10:52'),
(45, 2, 'Claim Rejected', 'You rejected the claim for \"sdfsdf\".', 'claim_rejected', 'rejected', 'claim', 0, 3, 'App\\Models\\Claim', NULL, '2025-11-22 18:36:16', '2025-11-22 18:36:16'),
(46, 2, 'Claim Rejected', 'You rejected the claim for \"dfdf\".', 'claim_rejected', 'rejected', 'claim', 0, 1, 'App\\Models\\Claim', NULL, '2025-11-22 18:36:35', '2025-11-22 18:36:35'),
(47, 2, 'Claim Rejected', 'You rejected and deleted the claim for \"xcxc\".', 'claim_rejected', 'rejected', 'claim', 0, 2, 'App\\Models\\Claim', NULL, '2025-11-22 18:39:40', '2025-11-22 18:39:40'),
(48, 2, 'Claim Rejected', 'You rejected and deleted the claim for \"sdfsdf\".', 'claim_rejected', 'rejected', 'claim', 0, 3, 'App\\Models\\Claim', NULL, '2025-11-22 18:40:18', '2025-11-22 18:40:18'),
(49, 2, 'Claim Rejected', 'You rejected and deleted the claim for \"dfdf\".', 'claim_rejected', 'rejected', 'claim', 0, 1, 'App\\Models\\Claim', NULL, '2025-11-22 18:40:37', '2025-11-22 18:40:37'),
(50, 1, 'Claim Submitted', 'Your claim for \"sdsad\" is pending review.', 'claim_submitted', 'pending', 'claim', 0, 7, 'App\\Models\\Claim', NULL, '2025-11-22 18:53:36', '2025-11-22 18:53:36'),
(51, 2, 'Claim Rejected', 'You rejected and deleted the claim for \"sdsad\".', 'claim_rejected', 'rejected', 'claim', 0, 7, 'App\\Models\\Claim', NULL, '2025-11-22 18:54:35', '2025-11-22 18:54:35'),
(52, 1, 'Claim Submitted', 'Your claim for \"sdfert\" is pending review.', 'claim_submitted', 'pending', 'claim', 0, 8, 'App\\Models\\Claim', NULL, '2025-11-22 18:59:01', '2025-11-22 18:59:01'),
(53, 2, 'Claim Rejected', 'You rejected and deleted the claim for \"sdfert\".', 'claim_rejected', 'rejected', 'claim', 0, 8, 'App\\Models\\Claim', NULL, '2025-11-22 18:59:25', '2025-11-22 18:59:25'),
(54, 1, 'Claim Submitted', 'Your claim for \"gdfxcgdg\" is pending review.', 'claim_submitted', 'pending', 'claim', 0, 9, 'App\\Models\\Claim', NULL, '2025-11-22 19:04:41', '2025-11-22 19:04:41'),
(55, 1, 'Claim Submitted', 'Your claim for \"dasdsadsad\" is pending review.', 'claim_submitted', 'pending', 'claim', 0, 11, 'App\\Models\\Claim', NULL, '2025-11-22 19:07:21', '2025-11-22 19:07:21'),
(56, 1, 'Claim Submitted', 'Your claim for \"dsfwerwerwer\" is pending review.', 'claim_submitted', 'pending', 'claim', 0, 12, 'App\\Models\\Claim', NULL, '2025-11-22 19:10:42', '2025-11-22 19:10:42'),
(57, 2, 'Claim Rejected', 'You rejected and deleted the claim for \"gdfxcgdg\".', 'claim_rejected', 'rejected', 'claim', 0, 9, 'App\\Models\\Claim', NULL, '2025-11-22 19:11:03', '2025-11-22 19:11:03'),
(58, 2, 'Report Approved', 'You approved the report for \"Samsung tab s11 ultra\".', 'report_approved', 'approved', 'report', 0, 37, 'App\\Models\\Item', NULL, '2025-11-22 20:49:47', '2025-11-22 20:49:47'),
(59, 2, 'Claim Rejected', 'You rejected and deleted the claim for \"dasdsadsad\".', 'claim_rejected', 'rejected', 'claim', 0, 11, 'App\\Models\\Claim', NULL, '2025-11-22 20:50:02', '2025-11-22 20:50:02'),
(60, 2, 'Report Approved', 'You approved the report for \"mi 14t\".', 'report_approved', 'approved', 'report', 0, 35, 'App\\Models\\Item', NULL, '2025-11-22 21:39:32', '2025-11-22 21:39:32'),
(61, 2, 'Report Approved', 'You approved the report for \"Iphone 17\".', 'report_approved', 'approved', 'report', 0, 30, 'App\\Models\\Item', NULL, '2025-11-23 01:16:30', '2025-11-23 01:16:30'),
(62, 2, 'Item Claimed', 'You marked the claim for \"dsfwerwerwer\" as claimed and removed the item and claim.', 'claim_claimed', 'claimed', 'claim', 0, 12, 'App\\Models\\Claim', NULL, '2025-11-23 01:21:17', '2025-11-23 01:21:17'),
(63, 2, 'Item Claimed', 'You marked the claim for \"dasdsadsad\" as claimed and removed the item and claim.', 'claim_claimed', '', '', 0, 10, 'App\\Models\\Claim', NULL, '2025-11-23 01:36:27', '2025-11-23 01:36:27'),
(64, 1, 'Claim Submitted', 'Your claim for \"Tab s11 ultra\" is pending review.', 'claim_submitted', 'pending', 'claim', 0, 13, 'App\\Models\\Claim', NULL, '2025-11-23 01:42:53', '2025-11-23 01:42:53'),
(65, 2, 'Item Claimed', 'You marked the claim for \"Tab s11 ultra\" as claimed and removed the item and claim.', 'claim_claimed', '', '', 0, 13, 'App\\Models\\Claim', NULL, '2025-11-23 01:43:32', '2025-11-23 01:43:32'),
(66, 1, 'Claim Submitted', 'Your claim for \"sdfsfd\" is pending review.', 'claim_submitted', 'pending', 'claim', 0, 14, 'App\\Models\\Claim', NULL, '2025-11-23 01:55:40', '2025-11-23 01:55:40'),
(67, 2, 'Item Claimed', 'You marked the claim for \"sdfsfd\" as claimed and removed the item and claim.', 'claim_claimed', 'claimed', 'claim', 0, 14, 'App\\Models\\Claim', NULL, '2025-11-23 02:39:55', '2025-11-23 02:39:55'),
(68, 2, 'Report Deleted', 'You deleted the report for \"Samsung s25\".', 'report_deleted', 'deleted', 'report', 0, 34, 'App\\Models\\Item', NULL, '2025-11-26 10:46:47', '2025-11-26 10:46:47'),
(69, 2, 'Report Deleted', 'You deleted the report for \"Samsung s25\".', 'report_deleted', 'deleted', 'report', 0, 33, 'App\\Models\\Item', NULL, '2025-11-26 10:46:53', '2025-11-26 10:46:53'),
(70, 2, 'Report Deleted', 'You deleted the report for \"Samsung s25\".', 'report_deleted', 'deleted', 'report', 0, 32, 'App\\Models\\Item', NULL, '2025-11-26 10:46:58', '2025-11-26 10:46:58'),
(71, 2, 'Report Deleted', 'You deleted the report for \"22332\".', 'report_deleted', 'deleted', 'report', 0, 20, 'App\\Models\\Item', NULL, '2025-11-26 10:47:01', '2025-11-26 10:47:01'),
(72, 2, 'Report Deleted', 'You deleted the report for \"YAYAYYAYA\".', 'report_deleted', 'deleted', 'report', 0, 17, 'App\\Models\\Item', NULL, '2025-11-26 10:47:04', '2025-11-26 10:47:04'),
(73, 2, 'Report Deleted', 'You deleted the report for \"ulet\".', 'report_deleted', 'deleted', 'report', 0, 16, 'App\\Models\\Item', NULL, '2025-11-26 10:47:07', '2025-11-26 10:47:07'),
(74, 2, 'Report Deleted', 'You deleted the report for \"hjhjh\".', 'report_deleted', 'deleted', 'report', 0, 14, 'App\\Models\\Item', NULL, '2025-11-26 10:47:09', '2025-11-26 10:47:09'),
(75, 2, 'Report Deleted', 'You deleted the report for \"4534\".', 'report_deleted', 'deleted', 'report', 0, 13, 'App\\Models\\Item', NULL, '2025-11-26 10:47:12', '2025-11-26 10:47:12'),
(76, 2, 'Report Deleted', 'You deleted the report for \"4534\".', 'report_deleted', 'deleted', 'report', 0, 11, 'App\\Models\\Item', NULL, '2025-11-26 10:47:15', '2025-11-26 10:47:15'),
(77, 2, 'Report Deleted', 'You deleted the report for \"4534\".', 'report_deleted', 'deleted', 'report', 0, 12, 'App\\Models\\Item', NULL, '2025-11-26 10:47:17', '2025-11-26 10:47:17'),
(78, 2, 'Report Deleted', 'You deleted the report for \"4534\".', 'report_deleted', 'deleted', 'report', 0, 10, 'App\\Models\\Item', NULL, '2025-11-26 10:47:23', '2025-11-26 10:47:23'),
(79, 2, 'Report Deleted', 'You deleted the report for \"4534\".', 'report_deleted', 'deleted', 'report', 0, 9, 'App\\Models\\Item', NULL, '2025-11-26 10:47:25', '2025-11-26 10:47:25'),
(80, 2, 'Report Deleted', 'You deleted the report for \"asasas\".', 'report_deleted', 'deleted', 'report', 0, 8, 'App\\Models\\Item', NULL, '2025-11-26 10:47:28', '2025-11-26 10:47:28'),
(81, 2, 'Report Deleted', 'You deleted the report for \"retre\".', 'report_deleted', 'deleted', 'report', 0, 7, 'App\\Models\\Item', NULL, '2025-11-26 10:47:30', '2025-11-26 10:47:30'),
(82, 2, 'Report Deleted', 'You deleted the report for \"sws\".', 'report_deleted', 'deleted', 'report', 0, 6, 'App\\Models\\Item', NULL, '2025-11-26 10:47:33', '2025-11-26 10:47:33'),
(83, 2, 'Report Approved', 'You approved the report for \"Samsung s25\".', 'report_approved', 'approved', 'report', 0, 31, 'App\\Models\\Item', NULL, '2025-11-26 10:47:46', '2025-11-26 10:47:46'),
(84, 2, 'Report Approved', 'You approved the report for \"Iphone 17\".', 'report_approved', 'approved', 'report', 0, 29, 'App\\Models\\Item', NULL, '2025-11-26 10:47:49', '2025-11-26 10:47:49'),
(85, 2, 'Report Approved', 'You approved the report for \"Iphone 15 pro\".', 'report_approved', 'approved', 'report', 0, 4, 'App\\Models\\Item', NULL, '2025-11-26 10:47:52', '2025-11-26 10:47:52'),
(86, 2, 'Report Approved', 'You approved the report for \"Iphone 17 pro\".', 'report_approved', 'approved', 'report', 0, 3, 'App\\Models\\Item', NULL, '2025-11-26 10:47:55', '2025-11-26 10:47:55'),
(87, 2, 'Report Approved', 'You approved the report for \"iPad mini 7th gen\".', 'report_approved', 'approved', 'report', 0, 2, 'App\\Models\\Item', NULL, '2025-11-26 10:47:57', '2025-11-26 10:47:57'),
(88, 2, 'Report Approved', 'You approved the report for \"Samsung S22\".', 'report_approved', 'approved', 'report', 0, 1, 'App\\Models\\Item', NULL, '2025-11-26 10:48:02', '2025-11-26 10:48:02'),
(89, 1, 'Claim Submitted', 'Your claim for \"S25\" is pending review.', 'claim_submitted', 'pending', 'claim', 0, 15, 'App\\Models\\Claim', NULL, '2025-11-26 10:54:12', '2025-11-26 10:54:12'),
(90, 1, 'Claim Submitted', 'Your claim for \"iphone 17\" is pending review.', 'claim_submitted', 'pending', 'claim', 0, 16, 'App\\Models\\Claim', NULL, '2025-11-26 10:55:39', '2025-11-26 10:55:39');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `claims`
--

CREATE TABLE `claims` (
  `claim_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `contact_details` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `unique_identifier` varchar(255) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `add_location` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `claims`
--

INSERT INTO `claims` (`claim_id`, `user_id`, `item_id`, `item_name`, `full_name`, `contact_details`, `description`, `unique_identifier`, `photo_path`, `location`, `add_location`, `status`, `approved_at`, `ip_address`, `created_at`, `updated_at`) VALUES
(15, 1, 31, 'S25', 'Juan Dela Cruz', '09190101010', 'Gray', '23443234', NULL, 'Architecture', 'Stair', 'pending', NULL, '127.0.0.1', '2025-11-26 10:54:12', '2025-11-26 10:54:12'),
(16, 1, 29, 'iphone 17', 'Dloria', '09123456789', 'Orange', '12313242', NULL, 'UNP Admin', '1st floor', 'pending', NULL, '127.0.0.1', '2025-11-26 10:55:39', '2025-11-26 10:55:39');

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
-- Table structure for table `histories`
--

CREATE TABLE `histories` (
  `history_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action_type` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `performed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `report_type` enum('lost','found') NOT NULL DEFAULT 'lost',
  `item_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) NOT NULL,
  `date_reported` date DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `add_location` varchar(255) DEFAULT NULL,
  `admin_approved` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('active','approved','rejected','archived') DEFAULT 'active',
  `prio_flag` enum('High','Normal') NOT NULL DEFAULT 'Normal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `user_id`, `report_type`, `item_name`, `description`, `category`, `date_reported`, `photo`, `location`, `add_location`, `admin_approved`, `status`, `prio_flag`, `created_at`, `updated_at`) VALUES
(1, 1, 'lost', 'Samsung S22', 'White', 'Electronics & Gadgets', '2025-09-19', NULL, 'communication_and_information_technology', 'Lobby', 0, 'approved', 'Normal', '2025-11-01 04:15:10', '2025-11-26 10:48:02'),
(2, 1, 'lost', 'iPad mini 7th gen', 'black', 'Electronics & Gadgets', '2025-10-30', NULL, 'canteen', 'Table 1', 0, 'approved', 'Normal', '2025-11-01 04:29:34', '2025-11-26 10:47:57'),
(3, 1, 'lost', 'Iphone 17 pro', 'Gray', 'Electronics & Gadgets', '2025-09-11', NULL, 'back_gate', 'Near Guard House', 0, 'approved', 'Normal', '2025-11-01 21:15:43', '2025-11-26 10:47:55'),
(4, 1, 'lost', 'Iphone 15 pro', 'White', 'Electronics & Gadgets', '2025-10-04', NULL, 'unp_pavillion', 'Pav West', 0, 'approved', 'Normal', '2025-11-01 21:26:29', '2025-11-26 10:47:52'),
(29, 1, 'lost', 'Iphone 17', 'Gray', 'Electronics & Gadgets', '2025-10-15', NULL, 'law', 'Graduate Library', 0, 'approved', 'Normal', '2025-11-22 04:32:35', '2025-11-26 10:47:49'),
(31, 1, 'found', 'Samsung s25', 'Gray', 'Electronics & Gadgets', '2025-11-01', NULL, 'engineering', 'Park', 0, 'approved', 'Normal', '2025-11-22 05:35:16', '2025-11-26 10:47:46'),
(38, 1, 'lost', 'Artic Hunter', 'Gray', 'Bags & Accessories', '2025-10-18', NULL, 'communication_and_information_technology', 'Pavilion', 0, 'active', 'Normal', '2025-11-26 10:56:15', '2025-11-26 10:56:15');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_16_123746_create_items_table', 1),
(5, '2025_10_16_123747_create_histories_table', 1),
(6, '2025_10_16_123921_create_claims_table', 1),
(7, '2025_10_16_123930_create_notifications_table', 1),
(8, '2025_10_25_125320_modify_claims_table', 1),
(9, '2025_10_25_134929_add_location_fields_to_claims_table', 1),
(10, '2025_10_25_135238_add_item_name_and_location_to_claims_table', 1),
(11, '2025_11_01_113002_create_alerts_table', 1),
(12, '2025_11_02_110241_add_status_and_label_to_alerts_table', 2),
(13, '2025_11_21_121058_alter_status_enum_in_items_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `related_id` bigint(20) UNSIGNED DEFAULT NULL,
  `related_type` varchar(255) DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `related_id`, `related_type`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Report Approved', 'You approved the report for \"sws\".', 'report_approved', 0, 6, 'App\\Models\\Item', NULL, '2025-11-21 19:29:44', '2025-11-21 19:29:44'),
(2, 2, 'Report Deleted', 'You deleted the report for \"wewe\".', 'report_deleted', 0, 5, 'App\\Models\\Item', NULL, '2025-11-21 19:31:44', '2025-11-21 19:31:44'),
(3, 2, 'Claim Approved', 'You approved the claim for \"xcxc\".', 'claim_approved', 0, 2, 'App\\Models\\Claim', NULL, '2025-11-21 19:31:58', '2025-11-21 19:31:58'),
(4, 2, 'Claim Approved', 'You approved the claim for \"sdfsdf\".', 'claim_approved', 0, 3, 'App\\Models\\Claim', NULL, '2025-11-21 19:32:08', '2025-11-21 19:32:08'),
(5, 2, 'New Report Submitted', 'A new Lost report for \"Iphone 17\" has been submitted.', 'report_submitted', 0, 29, 'App\\Models\\Item', NULL, '2025-11-22 04:32:35', '2025-11-22 04:32:35'),
(6, 2, 'New Report Submitted', 'A new Found report for \"Iphone 17\" has been submitted.', 'report_submitted', 0, 30, 'App\\Models\\Item', NULL, '2025-11-22 04:33:11', '2025-11-22 04:33:11'),
(7, 2, 'New Report Submitted', 'A new Found report for \"Samsung s25\" has been submitted.', 'report_submitted', 0, 31, 'App\\Models\\Item', NULL, '2025-11-22 05:35:16', '2025-11-22 05:35:16'),
(8, 2, 'New Report Submitted', 'A new Lost report for \"Samsung s25\" has been submitted.', 'report_submitted', 0, 32, 'App\\Models\\Item', NULL, '2025-11-22 05:36:20', '2025-11-22 05:36:20'),
(9, 2, 'New Report Submitted', 'A new Found report for \"Samsung s25\" has been submitted.', 'report_submitted', 0, 33, 'App\\Models\\Item', NULL, '2025-11-22 05:37:04', '2025-11-22 05:37:04'),
(10, 2, 'New Report Submitted', 'A new Lost report for \"Samsung s25\" has been submitted.', 'report_submitted', 0, 34, 'App\\Models\\Item', NULL, '2025-11-22 05:43:41', '2025-11-22 05:43:41'),
(11, 1, 'Report Submitted', 'Your Lost report for \"mi 14t\" is pending approval.', 'report_submitted', 1, 35, 'App\\Models\\Item', '2025-11-22 17:34:12', '2025-11-22 17:29:12', '2025-11-22 17:34:12'),
(12, 2, 'New Report Submitted', 'A new Lost report for \"mi 14t\" has been submitted.', 'report_submitted', 0, 35, 'App\\Models\\Item', NULL, '2025-11-22 17:29:12', '2025-11-22 17:29:12'),
(13, 1, 'Report Submitted', 'Your Found report for \"mi 14t\" is pending approval.', 'report_submitted', 1, 36, 'App\\Models\\Item', '2025-11-22 17:34:12', '2025-11-22 17:29:37', '2025-11-22 17:34:12'),
(14, 2, 'New Report Submitted', 'A new Found report for \"mi 14t\" has been submitted.', 'report_submitted', 0, 36, 'App\\Models\\Item', NULL, '2025-11-22 17:29:37', '2025-11-22 17:29:37'),
(15, 1, 'Report Approved', 'Your report for \"mi 14t\" has been approved.', 'report_approved', 0, 36, 'App\\Models\\Item', NULL, '2025-11-22 17:40:10', '2025-11-22 17:40:10'),
(16, 2, 'Report Approved', 'You approved the report for \"mi 14t\".', 'report_approved', 0, 36, 'App\\Models\\Item', NULL, '2025-11-22 17:40:10', '2025-11-22 17:40:10'),
(17, 1, 'Report Approved', 'Your report for \"ulet\" has been approved.', 'report_approved', 0, 16, 'App\\Models\\Item', NULL, '2025-11-22 18:00:12', '2025-11-22 18:00:12'),
(18, 1, 'Report Deleted', 'Your report for \"ttyytyt\" has been deleted.', 'report_deleted', 0, 15, 'App\\Models\\Item', NULL, '2025-11-22 18:03:44', '2025-11-22 18:03:44'),
(19, 1, 'Report Submitted', 'Your Lost report for \"Samsung tab s11 ultra\" is pending approval.', 'report_submitted', 0, 37, 'App\\Models\\Item', NULL, '2025-11-22 18:09:39', '2025-11-22 18:09:39'),
(20, 2, 'New Report Submitted', 'A new Lost report for \"Samsung tab s11 ultra\" has been submitted.', 'report_submitted', 0, 37, 'App\\Models\\Item', NULL, '2025-11-22 18:09:39', '2025-11-22 18:09:39'),
(21, 1, 'Claim Rejected', 'Your claim for \"sdfsdf\" has been rejected.', 'claim_rejected', 1, 3, 'App\\Models\\Claim', '2025-11-22 18:13:30', '2025-11-22 18:10:52', '2025-11-22 18:13:30'),
(22, 1, 'Claim Rejected', 'Your claim for \"sdfsdf\" has been rejected.', 'claim_rejected', 0, 3, 'App\\Models\\Claim', NULL, '2025-11-22 18:36:16', '2025-11-22 18:36:16'),
(23, 1, 'Claim Rejected', 'Your claim for \"dfdf\" has been rejected.', 'claim_rejected', 0, 1, 'App\\Models\\Claim', NULL, '2025-11-22 18:36:35', '2025-11-22 18:36:35'),
(24, 1, 'Claim Rejected', 'Your claim for \"xcxc\" has been rejected and removed.', 'claim_rejected', 0, 2, 'App\\Models\\Claim', NULL, '2025-11-22 18:39:40', '2025-11-22 18:39:40'),
(25, 1, 'Claim Rejected', 'Your claim for \"sdfsdf\" has been rejected and removed.', 'claim_rejected', 0, 3, 'App\\Models\\Claim', NULL, '2025-11-22 18:40:18', '2025-11-22 18:40:18'),
(26, 1, 'Claim Rejected', 'Your claim for \"dfdf\" has been rejected and removed.', 'claim_rejected', 0, 1, 'App\\Models\\Claim', NULL, '2025-11-22 18:40:37', '2025-11-22 18:40:37'),
(27, 1, 'Claim Rejected', 'Your claim for \"sdsad\" has been rejected and removed.', 'claim_rejected', 0, 7, 'App\\Models\\Claim', NULL, '2025-11-22 18:54:35', '2025-11-22 18:54:35'),
(28, 1, 'Claim Rejected', 'Your claim for \"sdfert\" has been rejected and removed.', 'claim_rejected', 0, 8, 'App\\Models\\Claim', NULL, '2025-11-22 18:59:25', '2025-11-22 18:59:25'),
(29, 1, 'Claim Submitted', 'Your claim for \"dsfwerwerwer\" has been submitted successfully.', 'claim_submitted', 0, 12, 'App\\Models\\Claim', NULL, '2025-11-22 19:10:42', '2025-11-22 19:10:42'),
(30, 1, 'Claim Rejected', 'Your claim for \"gdfxcgdg\" has been rejected and removed.', 'claim_rejected', 0, 9, 'App\\Models\\Claim', NULL, '2025-11-22 19:11:03', '2025-11-22 19:11:03'),
(31, 1, 'Report Approved', 'Your report for \"Samsung tab s11 ultra\" has been approved.', 'report_approved', 0, 37, 'App\\Models\\Item', NULL, '2025-11-22 20:49:47', '2025-11-22 20:49:47'),
(32, 1, 'Claim Rejected', 'Your claim for \"dasdsadsad\" has been rejected and removed.', 'claim_rejected', 0, 11, 'App\\Models\\Claim', NULL, '2025-11-22 20:50:02', '2025-11-22 20:50:02'),
(33, 1, 'Report Approved', 'Your report for \"mi 14t\" has been approved.', 'report_approved', 0, 35, 'App\\Models\\Item', NULL, '2025-11-22 21:39:32', '2025-11-22 21:39:32'),
(34, 1, 'Report Approved', 'Your report for \"Iphone 17\" has been approved.', 'report_approved', 0, 30, 'App\\Models\\Item', NULL, '2025-11-23 01:16:30', '2025-11-23 01:16:30'),
(35, 1, 'Item Claimed', 'Your claim for \"dsfwerwerwer\" has been processed and the item has been claimed.', 'claim_claimed', 1, 12, 'App\\Models\\Claim', '2025-11-23 01:39:01', '2025-11-23 01:21:17', '2025-11-23 01:39:01'),
(36, 1, 'Item Claimed', 'Your claim for \"dasdsadsad\" has been processed and the item has been claimed.', 'claim_claimed', 1, 10, 'App\\Models\\Claim', '2025-11-23 01:39:05', '2025-11-23 01:36:27', '2025-11-23 01:39:05'),
(37, 1, 'Claim Submitted', 'Your claim for \"Tab s11 ultra\" has been submitted successfully.', 'claim_submitted', 0, 13, 'App\\Models\\Claim', NULL, '2025-11-23 01:42:53', '2025-11-23 01:42:53'),
(38, 1, 'Item Claimed', 'Your claim for \"Tab s11 ultra\" has been processed and the item has been claimed.', 'claim_claimed', 0, 13, 'App\\Models\\Claim', NULL, '2025-11-23 01:43:32', '2025-11-23 01:43:32'),
(39, 1, 'Claim Submitted', 'Your claim for \"sdfsfd\" has been submitted successfully.', 'claim_submitted', 0, 14, 'App\\Models\\Claim', NULL, '2025-11-23 01:55:40', '2025-11-23 01:55:40'),
(40, 1, 'Item Claimed', 'Your claim for \"sdfsfd\" has been processed and the item has been claimed.', 'claim_claimed', 0, 14, 'App\\Models\\Claim', NULL, '2025-11-23 02:39:55', '2025-11-23 02:39:55'),
(41, 1, 'Report Deleted', 'Your report for \"Samsung s25\" has been deleted.', 'report_deleted', 0, 34, 'App\\Models\\Item', NULL, '2025-11-26 10:46:47', '2025-11-26 10:46:47'),
(42, 1, 'Report Deleted', 'Your report for \"Samsung s25\" has been deleted.', 'report_deleted', 0, 33, 'App\\Models\\Item', NULL, '2025-11-26 10:46:53', '2025-11-26 10:46:53'),
(43, 1, 'Report Deleted', 'Your report for \"Samsung s25\" has been deleted.', 'report_deleted', 0, 32, 'App\\Models\\Item', NULL, '2025-11-26 10:46:58', '2025-11-26 10:46:58'),
(44, 1, 'Report Deleted', 'Your report for \"22332\" has been deleted.', 'report_deleted', 0, 20, 'App\\Models\\Item', NULL, '2025-11-26 10:47:01', '2025-11-26 10:47:01'),
(45, 1, 'Report Deleted', 'Your report for \"YAYAYYAYA\" has been deleted.', 'report_deleted', 0, 17, 'App\\Models\\Item', NULL, '2025-11-26 10:47:04', '2025-11-26 10:47:04'),
(46, 1, 'Report Deleted', 'Your report for \"ulet\" has been deleted.', 'report_deleted', 0, 16, 'App\\Models\\Item', NULL, '2025-11-26 10:47:07', '2025-11-26 10:47:07'),
(47, 1, 'Report Deleted', 'Your report for \"hjhjh\" has been deleted.', 'report_deleted', 0, 14, 'App\\Models\\Item', NULL, '2025-11-26 10:47:09', '2025-11-26 10:47:09'),
(48, 1, 'Report Deleted', 'Your report for \"4534\" has been deleted.', 'report_deleted', 0, 13, 'App\\Models\\Item', NULL, '2025-11-26 10:47:12', '2025-11-26 10:47:12'),
(49, 1, 'Report Deleted', 'Your report for \"4534\" has been deleted.', 'report_deleted', 0, 11, 'App\\Models\\Item', NULL, '2025-11-26 10:47:15', '2025-11-26 10:47:15'),
(50, 1, 'Report Deleted', 'Your report for \"4534\" has been deleted.', 'report_deleted', 0, 12, 'App\\Models\\Item', NULL, '2025-11-26 10:47:17', '2025-11-26 10:47:17'),
(51, 1, 'Report Deleted', 'Your report for \"4534\" has been deleted.', 'report_deleted', 0, 10, 'App\\Models\\Item', NULL, '2025-11-26 10:47:23', '2025-11-26 10:47:23'),
(52, 1, 'Report Deleted', 'Your report for \"4534\" has been deleted.', 'report_deleted', 0, 9, 'App\\Models\\Item', NULL, '2025-11-26 10:47:25', '2025-11-26 10:47:25'),
(53, 1, 'Report Deleted', 'Your report for \"asasas\" has been deleted.', 'report_deleted', 0, 8, 'App\\Models\\Item', NULL, '2025-11-26 10:47:28', '2025-11-26 10:47:28'),
(54, 1, 'Report Deleted', 'Your report for \"retre\" has been deleted.', 'report_deleted', 0, 7, 'App\\Models\\Item', NULL, '2025-11-26 10:47:30', '2025-11-26 10:47:30'),
(55, 1, 'Report Deleted', 'Your report for \"sws\" has been deleted.', 'report_deleted', 0, 6, 'App\\Models\\Item', NULL, '2025-11-26 10:47:33', '2025-11-26 10:47:33'),
(56, 1, 'Report Approved', 'Your report for \"Samsung s25\" has been approved.', 'report_approved', 0, 31, 'App\\Models\\Item', NULL, '2025-11-26 10:47:46', '2025-11-26 10:47:46'),
(57, 1, 'Report Approved', 'Your report for \"Iphone 17\" has been approved.', 'report_approved', 0, 29, 'App\\Models\\Item', NULL, '2025-11-26 10:47:49', '2025-11-26 10:47:49'),
(58, 1, 'Report Approved', 'Your report for \"Iphone 15 pro\" has been approved.', 'report_approved', 0, 4, 'App\\Models\\Item', NULL, '2025-11-26 10:47:52', '2025-11-26 10:47:52'),
(59, 1, 'Report Approved', 'Your report for \"Iphone 17 pro\" has been approved.', 'report_approved', 0, 3, 'App\\Models\\Item', NULL, '2025-11-26 10:47:55', '2025-11-26 10:47:55'),
(60, 1, 'Report Approved', 'Your report for \"iPad mini 7th gen\" has been approved.', 'report_approved', 0, 2, 'App\\Models\\Item', NULL, '2025-11-26 10:47:57', '2025-11-26 10:47:57'),
(61, 1, 'Report Approved', 'Your report for \"Samsung S22\" has been approved.', 'report_approved', 0, 1, 'App\\Models\\Item', NULL, '2025-11-26 10:48:02', '2025-11-26 10:48:02'),
(62, 1, 'Claim Submitted', 'Your claim for \"S25\" has been submitted successfully.', 'claim_submitted', 0, 15, 'App\\Models\\Claim', NULL, '2025-11-26 10:54:12', '2025-11-26 10:54:12'),
(63, 1, 'Claim Submitted', 'Your claim for \"iphone 17\" has been submitted successfully.', 'claim_submitted', 0, 16, 'App\\Models\\Claim', NULL, '2025-11-26 10:55:39', '2025-11-26 10:55:39'),
(64, 1, 'Report Submitted', 'Your Lost report for \"Artic Hunter\" is pending approval.', 'report_submitted', 0, 38, 'App\\Models\\Item', NULL, '2025-11-26 10:56:15', '2025-11-26 10:56:15'),
(65, 2, 'New Report Submitted', 'A new Lost report for \"Artic Hunter\" has been submitted.', 'report_submitted', 0, 38, 'App\\Models\\Item', NULL, '2025-11-26 10:56:15', '2025-11-26 10:56:15');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(150) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('k1ndkzhVKLkQhsyOlpUj2VKTIe149YbYYESz6HeB', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSVRaV1lZRWRtMWlnRlpRdjJUNjJPd3doV1VHQVNtTlBhRE5uMTlJSiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjM4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvY2xhaW1zLzE1L3N0YXR1cyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1764183408),
('knf5dmhokoBTtDOYCa9bnzmHoVfA5al7wn9YMT6x', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaXUyaVJlRHhpdDU2T1JKc2dqQktVVVI1ZXMwc0dCMGNFWFhCWmpvUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1764215536),
('pLzIKAKGrp73Ed1BSnhHjpoO1nL684Ool6HSmob0', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVzFYRmdCQ3F4Z0dYaGJrMm9paDhBYmRVZTVYcUphenQxV3k5WHJwTyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaWduLWluIjt9fQ==', 1764317900),
('Q0mQx90ihs72lNIgU9VeOJCeetYlNQLcwLa9BBk6', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid2VnTHoza09DOFVlZklZOWlDMjkyNG11aFhBNkM0NkljSjNjNEg5QiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1764195671);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `last_login_ip` varchar(45) DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `email_verified_at`, `password`, `role`, `last_login_ip`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Jomarie Tijada', 'jomsalvio@gmail.com', NULL, '$2y$12$am0I1nVcs6CZg3FuiJlSc.o2O4olgXim1TGM94W6wggvFLRHZ.XeK', 'user', '127.0.0.1', '2025-11-28 00:17:20', NULL, '2025-11-01 04:14:41', '2025-11-28 00:17:20'),
(2, 'Admin', 'admin@gmail.com', NULL, '$2y$12$N1GLRaBXQC9NNKCBDr.QZOtWYUTa44.idbva/wyGnuR54HIwBxbSa', 'admin', '127.0.0.1', '2025-11-26 10:56:48', NULL, '2025-11-08 05:12:02', '2025-11-26 10:56:48'),
(3, 'Test', 'test@gmail.com', NULL, '$2y$12$rh9AaO.RgiJhlp3bvBcZaepUJHh2rm6P019c2xpTR6eQvxPhZ7E6O', 'user', NULL, NULL, NULL, '2025-11-28 00:18:08', '2025-11-28 00:18:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alerts_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `claims`
--
ALTER TABLE `claims`
  ADD PRIMARY KEY (`claim_id`),
  ADD KEY `claims_user_id_foreign` (`user_id`),
  ADD KEY `claims_item_id_foreign` (`item_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `histories_user_id_foreign` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `items_user_id_foreign` (`user_id`),
  ADD KEY `items_item_name_index` (`item_name`),
  ADD KEY `items_category_index` (`category`),
  ADD KEY `items_prio_flag_index` (`prio_flag`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_foreign` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_index` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `claims`
--
ALTER TABLE `claims`
  MODIFY `claim_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histories`
--
ALTER TABLE `histories`
  MODIFY `history_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `alerts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `claims`
--
ALTER TABLE `claims`
  ADD CONSTRAINT `claims_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `claims_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `histories`
--
ALTER TABLE `histories`
  ADD CONSTRAINT `histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
