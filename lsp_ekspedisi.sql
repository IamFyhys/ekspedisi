-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2026 at 02:28 AM
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
-- Database: `lsp_ekspedisi`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `city`, `address`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'Hub Jakarta', 'Jakarta', 'Jl. Gatot Subroto No. 10', '021-987654', '2026-05-01 16:47:22', '2026-05-02 01:55:37'),
(2, 'Hub Surabaya', 'Surabaya', 'Jl. Pahlawan No. 1', '031-123456', '2026-05-01 16:47:22', '2026-05-02 01:55:37'),
(3, 'Cabang Bandung', 'Bandung', 'Jl. Asia Afrika No. 5', '022-1112223', '2026-05-01 16:47:22', '2026-05-01 16:47:22'),
(4, 'jakarta', 'jakarta', 'Jl.H. Kain\r\nKecamatan cibinong bogor', '0895386956728', '2026-05-02 03:44:15', '2026-05-02 03:44:15');

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
-- Table structure for table `cash_drawers`
--

CREATE TABLE `cash_drawers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `starting_balance` decimal(18,2) NOT NULL,
  `current_balance` decimal(18,2) NOT NULL,
  `closing_balance` decimal(18,2) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'open',
  `closed_at` timestamp NULL DEFAULT NULL,
  `closed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_drawers`
--

INSERT INTO `cash_drawers` (`id`, `branch_id`, `date`, `starting_balance`, `current_balance`, `closing_balance`, `status`, `closed_at`, `closed_by`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-05-01', 1000000.00, 1045000.00, NULL, 'open', NULL, NULL, '2026-05-01 16:47:24', '2026-05-01 16:47:24'),
(2, 1, '2026-05-02', 1000000.00, 1000000.00, 1000000.00, 'closed', '2026-05-01 17:19:23', 3, '2026-05-01 17:08:15', '2026-05-01 17:19:23'),
(3, 1, '2026-05-03', 10000.00, 325000.00, 645000.00, 'closed', '2026-05-02 23:50:24', 17, '2026-05-02 23:29:53', '2026-05-02 23:50:24'),
(4, 1, '2026-05-05', 10000.00, 10000.00, NULL, 'open', NULL, NULL, '2026-05-04 21:11:20', '2026-05-04 21:11:20'),
(5, 1, '2026-05-06', 0.00, 0.00, NULL, 'open', NULL, NULL, '2026-05-05 20:39:13', '2026-05-05 20:39:13');

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
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `province`, `created_at`, `updated_at`) VALUES
(1, 'Jakarta', 'DKI Jakarta', '2026-05-01 16:47:22', '2026-05-01 16:47:22'),
(2, 'Surabaya', 'Jawa Timur', '2026-05-01 16:47:22', '2026-05-01 16:47:22'),
(3, 'Bandung', 'Jawa Barat', '2026-05-01 16:47:22', '2026-05-01 16:47:22'),
(4, 'KABUPATEN TAPANULI TENGAH', 'SUMATERA UTARA', '2026-05-05 21:14:19', '2026-05-05 21:14:19'),
(5, 'KOTA JAKARTA SELATAN', 'DKI JAKARTA', '2026-05-05 21:14:23', '2026-05-05 21:14:23'),
(6, 'KABUPATEN MUARA ENIM', 'SUMATERA SELATAN', '2026-05-05 21:15:03', '2026-05-05 21:15:03'),
(7, 'KABUPATEN ACEH TENGGARA', 'ACEH', '2026-05-05 21:15:04', '2026-05-05 21:15:04'),
(8, 'KABUPATEN MANDAILING NATAL', 'SUMATERA UTARA', '2026-05-05 21:19:57', '2026-05-05 21:19:57'),
(9, 'KABUPATEN KULON PROGO', 'DI YOGYAKARTA', '2026-05-05 21:20:02', '2026-05-05 21:20:02'),
(10, 'KABUPATEN LOMBOK BARAT', 'NUSA TENGGARA BARAT', '2026-05-05 21:20:41', '2026-05-05 21:20:41'),
(11, 'KABUPATEN KLUNGKUNG', 'BALI', '2026-05-05 21:20:43', '2026-05-05 21:20:43'),
(12, 'KABUPATEN BEKASI', 'JAWA BARAT', '2026-05-05 22:44:56', '2026-05-05 22:44:56'),
(13, 'KABUPATEN MANGGARAI TIMUR', 'NUSA TENGGARA TIMUR', '2026-05-05 22:44:57', '2026-05-05 22:44:57'),
(14, 'KABUPATEN BULELENG', 'BALI', '2026-05-05 22:46:46', '2026-05-05 22:46:46'),
(15, 'KOTA CILEGON', 'BANTEN', '2026-05-05 22:46:47', '2026-05-05 22:46:47');

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
(4, '2024_01_01_000001_create_branches_table', 1),
(5, '2024_01_01_000002_create_locations_table', 1),
(6, '2024_01_01_000003_create_subdistricts_table', 1),
(7, '2024_01_01_000004_create_rates_table', 1),
(8, '2024_01_01_000005_create_shipments_table', 1),
(9, '2024_01_01_000006_create_shipment_trackings_table', 1),
(10, '2024_01_01_000007_create_payments_table', 1),
(11, '2024_01_01_000008_create_vehicles_table', 1),
(12, '2026_04_29_024938_add_avatar_to_users_table', 1),
(13, '2026_04_29_040008_add_payment_status_to_shipments_table', 1),
(14, '2026_04_29_041354_add_payment_status_to_shipments', 1),
(15, '2026_04_29_041408_create_cash_drawers_table', 1),
(16, '2026_04_29_041421_create_shifts_table', 1),
(17, '2026_04_29_061652_add_delivery_details_to_shipments_table', 1),
(18, '2026_04_29_063751_add_advanced_role_system_to_users_table', 1),
(19, '2026_04_29_064055_cleanup_users_table_columns', 1),
(20, '2026_04_29_065752_update_users_table_for_rbac', 1),
(21, '2026_04_29_070719_update_user_roles_enum', 1),
(22, '2026_04_29_072224_add_staff_registration_columns_to_users_table', 1),
(23, '2026_04_30_014802_create_notifications_table', 1),
(24, '2026_04_30_032106_add_approval_to_shifts_table', 1),
(25, '2026_04_30_231317_update_user_roles_add_courier_types', 1),
(26, '2026_04_30_231339_create_trips_table', 1),
(27, '2026_04_30_231415_add_transit_and_delivery_columns_to_shipments_table', 1),
(28, '2026_04_30_231949_add_logistics_columns_v2_to_shipments_table', 1),
(29, '2026_05_01_004336_add_cod_columns_to_shipments_table', 1),
(30, '2026_05_01_004337_add_cashier_columns_to_payments_table', 1),
(31, '2026_05_01_020004_increase_money_column_sizes', 1),
(32, '2026_05_02_084434_add_trip_id_to_shipments_table', 2),
(33, '2026_05_02_084500_add_trip_id_to_shipments_table', 2),
(34, '2026_05_02_091740_add_coordinates_to_shipments_table', 3),
(35, '2026_05_03_010736_add_assigned_at_to_shipments_table', 4),
(36, '2026_05_03_011418_add_scheduled_date_to_shipments_table', 5),
(37, '2026_05_03_020041_add_staff_fields_to_users_table', 6),
(38, '2026_05_04_012928_create_pickup_requests_table', 7),
(39, '2026_05_04_013108_add_pickup_courier_role_to_users_table', 7),
(40, '2026_05_05_034433_add_dimensions_to_shipments_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('10067573-378b-45f7-88d8-48a40cce17ea', 'App\\Notifications\\StaffApplicationNotification', 'App\\Models\\User', 2, '{\"applicant_id\":17,\"applicant_name\":\"Yahya\",\"position\":\"cashier\",\"message\":\"Lamaran staff baru dari Yahya\"}', NULL, '2026-05-02 22:36:51', '2026-05-02 22:36:51'),
('1ab2f88a-60dd-4890-b207-eb70323c35a7', 'App\\Notifications\\StaffApplicationNotification', 'App\\Models\\User', 1, '{\"applicant_id\":13,\"applicant_name\":\"Transit Jakarta\",\"position\":\"courier_transit\",\"message\":\"Lamaran staff baru dari Transit Jakarta\"}', NULL, '2026-05-02 04:38:10', '2026-05-02 04:38:10'),
('1c565af4-1322-4247-9ddd-4666c8781af2', 'App\\Notifications\\StaffApplicationNotification', 'App\\Models\\User', 1, '{\"applicant_id\":18,\"applicant_name\":\"andi\",\"position\":\"courier_transit\",\"message\":\"Lamaran staff baru dari andi\"}', NULL, '2026-05-05 20:36:13', '2026-05-05 20:36:13'),
('1e822f71-2c74-45c7-80f0-ec534f846fc3', 'App\\Notifications\\StaffApplicationNotification', 'App\\Models\\User', 2, '{\"applicant_id\":16,\"applicant_name\":\"John Doe\",\"position\":\"cashier\",\"message\":\"Lamaran staff baru dari John Doe\"}', NULL, '2026-05-02 21:35:49', '2026-05-02 21:35:49'),
('330c305b-674d-435a-9f9f-d203fa63bc8c', 'App\\Notifications\\PackageReturnedNotification', 'App\\Models\\User', 2, '{\"title\":\"Paket Dikembalikan ke Gudang\",\"message\":\"Paket EXP-20260502-HFJUNC milik udin dikembalikan ke gudang oleh kurir Delivery Utama\",\"url\":\"\\/manager\\/gudang\",\"type\":\"warning\"}', NULL, '2026-05-03 01:00:02', '2026-05-03 01:00:02'),
('3a8dd2f4-68e7-4edc-90c6-a229835e49a5', 'App\\Notifications\\StaffApplicationNotification', 'App\\Models\\User', 1, '{\"applicant_id\":13,\"applicant_name\":\"Transit Jakarta\",\"position\":\"courier_transit\",\"message\":\"Lamaran staff baru dari Transit Jakarta\"}', NULL, '2026-05-02 04:38:10', '2026-05-02 04:38:10'),
('55e0d92f-c3b0-4207-90db-4e83696f1793', 'App\\Notifications\\PackageReturnedNotification', 'App\\Models\\User', 2, '{\"title\":\"Paket Dikembalikan ke Gudang\",\"message\":\"Paket EXP-20260502-K9GJCS milik udin dikembalikan ke gudang oleh kurir Delivery Utama\",\"url\":\"\\/manager\\/gudang\",\"type\":\"warning\"}', NULL, '2026-05-02 23:19:31', '2026-05-02 23:19:31'),
('691828df-eb91-40ad-b2e0-55529945b65a', 'App\\Notifications\\StaffApplicationNotification', 'App\\Models\\User', 1, '{\"applicant_id\":17,\"applicant_name\":\"Yahya\",\"position\":\"cashier\",\"message\":\"Lamaran staff baru dari Yahya\"}', NULL, '2026-05-02 22:46:07', '2026-05-02 22:46:07'),
('b01e322f-3c43-4f6a-9989-74c74a8bb0ea', 'App\\Notifications\\StaffApplicationNotification', 'App\\Models\\User', 1, '{\"applicant_id\":13,\"applicant_name\":\"Transit Jakarta\",\"position\":\"courier_transit\",\"message\":\"Lamaran staff baru dari Transit Jakarta\"}', NULL, '2026-05-02 04:38:09', '2026-05-02 04:38:09'),
('dc68c271-f116-4f0d-8571-ebc2e15409d9', 'App\\Notifications\\StaffApplicationNotification', 'App\\Models\\User', 2, '{\"applicant_id\":15,\"applicant_name\":\"bambang wijaya\",\"position\":\"cashier\",\"message\":\"Lamaran staff baru dari bambang wijaya\"}', NULL, '2026-05-02 18:32:30', '2026-05-02 18:32:30'),
('f3fed067-1fcf-42a5-9060-c77e9ce2964c', 'App\\Notifications\\StaffApplicationNotification', 'App\\Models\\User', 2, '{\"applicant_id\":18,\"applicant_name\":\"andi\",\"position\":\"courier_transit\",\"message\":\"Lamaran staff baru dari andi\"}', NULL, '2026-05-05 20:34:15', '2026-05-05 20:34:15');

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
  `shipment_id` bigint(20) UNSIGNED NOT NULL,
  `external_id` varchar(255) DEFAULT NULL,
  `amount` decimal(18,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) NOT NULL,
  `snap_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `received_by` bigint(20) UNSIGNED DEFAULT NULL,
  `courier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `shipment_id`, `external_id`, `amount`, `status`, `payment_method`, `snap_token`, `created_at`, `updated_at`, `received_by`, `courier_id`, `paid_at`) VALUES
(1, 4, NULL, 150000.00, 'pending', 'midtrans', NULL, '2026-05-01 17:09:28', '2026-05-01 17:09:28', NULL, NULL, NULL),
(2, 5, NULL, 150000.00, 'pending', 'midtrans', NULL, '2026-05-01 17:09:32', '2026-05-01 17:09:32', NULL, NULL, NULL),
(3, 6, NULL, 150000.00, 'pending', 'midtrans', NULL, '2026-05-01 17:10:35', '2026-05-01 17:10:35', NULL, NULL, NULL),
(4, 7, NULL, 150000.00, 'pending', 'midtrans', NULL, '2026-05-01 17:10:46', '2026-05-01 17:10:46', NULL, NULL, NULL),
(5, 8, NULL, 150000.00, 'pending', 'midtrans', NULL, '2026-05-01 17:11:22', '2026-05-01 17:11:22', NULL, NULL, NULL),
(6, 9, NULL, 150000.00, 'pending', 'midtrans', NULL, '2026-05-01 17:14:04', '2026-05-01 17:14:04', NULL, NULL, NULL),
(7, 9, NULL, 150000.00, 'success', 'midtrans', NULL, '2026-05-01 17:16:21', '2026-05-01 17:16:21', NULL, NULL, NULL),
(8, 8, NULL, 150000.00, 'success', 'midtrans', NULL, '2026-05-01 17:16:24', '2026-05-01 17:16:24', NULL, NULL, NULL),
(9, 7, NULL, 150000.00, 'success', 'midtrans', NULL, '2026-05-01 17:16:27', '2026-05-01 17:16:27', NULL, NULL, NULL),
(10, 6, NULL, 150000.00, 'success', 'midtrans', NULL, '2026-05-01 17:16:30', '2026-05-01 17:16:30', NULL, NULL, NULL),
(11, 10, NULL, 150000.00, 'pending', 'midtrans', NULL, '2026-05-01 17:17:06', '2026-05-01 17:17:06', NULL, NULL, NULL),
(12, 10, NULL, 150000.00, 'success', 'midtrans', NULL, '2026-05-01 17:17:40', '2026-05-01 17:17:40', NULL, NULL, NULL),
(13, 11, NULL, 80000.00, 'pending', 'cod', NULL, '2026-05-01 17:18:31', '2026-05-01 17:18:31', NULL, NULL, NULL),
(14, 11, NULL, 80000.00, 'success', 'cod', NULL, '2026-05-01 17:18:42', '2026-05-01 17:18:42', NULL, NULL, NULL),
(15, 19, NULL, 180000.00, 'pending', 'midtrans', NULL, '2026-05-02 04:05:14', '2026-05-02 04:05:14', NULL, NULL, NULL),
(16, 19, NULL, 180000.00, 'success', 'midtrans', NULL, '2026-05-02 04:05:51', '2026-05-02 04:05:51', NULL, NULL, NULL),
(17, 18, NULL, 70000.00, 'success', 'cod', NULL, '2026-05-02 04:24:50', '2026-05-02 04:24:50', NULL, NULL, NULL),
(18, 13, NULL, 60000.00, 'success', 'cod', NULL, '2026-05-02 04:25:11', '2026-05-02 04:25:11', NULL, NULL, NULL),
(19, 20, NULL, 135000.00, 'pending', 'midtrans', NULL, '2026-05-02 23:31:38', '2026-05-02 23:31:38', NULL, NULL, NULL),
(20, 20, NULL, 135000.00, 'success', 'midtrans', NULL, '2026-05-02 23:32:14', '2026-05-02 23:32:14', NULL, NULL, NULL),
(21, 21, NULL, 90000.00, 'success', 'transfer', NULL, '2026-05-02 23:43:02', '2026-05-02 23:43:02', NULL, NULL, NULL),
(22, 22, NULL, 105000.00, 'success', 'cod', NULL, '2026-05-02 23:47:47', '2026-05-02 23:47:53', NULL, NULL, NULL),
(23, 23, NULL, 315000.00, 'success', 'cash', NULL, '2026-05-02 23:48:40', '2026-05-02 23:48:40', NULL, NULL, NULL),
(24, 24, NULL, 315000.00, 'success', 'midtrans', NULL, '2026-05-04 20:29:47', '2026-05-04 20:30:22', NULL, NULL, NULL),
(25, 25, NULL, 20000.00, 'success', 'midtrans', NULL, '2026-05-04 20:30:39', '2026-05-04 20:30:56', NULL, NULL, NULL),
(26, 26, NULL, 120000.00, 'success', 'transfer', NULL, '2026-05-05 01:41:30', '2026-05-05 01:41:30', NULL, NULL, NULL),
(27, 27, NULL, 40000.00, 'pending', 'midtrans', NULL, '2026-05-05 03:00:09', '2026-05-05 03:00:09', NULL, NULL, NULL),
(28, 28, NULL, 315000.00, 'success', 'midtrans', NULL, '2026-05-05 10:35:25', '2026-05-05 10:42:32', NULL, NULL, NULL),
(29, 29, NULL, 315000.00, 'success', 'midtrans', NULL, '2026-05-05 10:41:39', '2026-05-05 10:42:29', NULL, NULL, NULL),
(30, 30, NULL, 1800000.00, 'success', 'midtrans', NULL, '2026-05-05 21:22:32', '2026-05-05 21:25:41', NULL, NULL, NULL),
(31, 31, NULL, 1638000.00, 'success', 'midtrans', NULL, '2026-05-05 22:47:05', '2026-05-05 22:47:34', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pickup_requests`
--

CREATE TABLE `pickup_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pickup_code` varchar(255) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `sender_phone` varchar(255) NOT NULL,
  `sender_address` text NOT NULL,
  `sender_city` varchar(255) NOT NULL,
  `sender_lat` decimal(10,8) DEFAULT NULL,
  `sender_lng` decimal(11,8) DEFAULT NULL,
  `estimated_weight` decimal(8,2) NOT NULL,
  `goods_type` varchar(255) NOT NULL,
  `goods_description` text DEFAULT NULL,
  `receiver_name` varchar(255) NOT NULL,
  `receiver_phone` varchar(255) NOT NULL,
  `receiver_address` text NOT NULL,
  `receiver_city` varchar(255) NOT NULL,
  `pickup_date` date NOT NULL,
  `pickup_time` enum('08:00-10:00','10:00-12:00','13:00-15:00','15:00-17:00') NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `courier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `assigned_by` bigint(20) UNSIGNED DEFAULT NULL,
  `processed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','assigned_pickup','on_the_way','picked_up','arrived_at_branch','processed','cancelled') NOT NULL DEFAULT 'pending',
  `actual_weight` decimal(8,2) DEFAULT NULL,
  `pickup_photo` varchar(255) DEFAULT NULL,
  `pickup_note` text DEFAULT NULL,
  `picked_up_at` timestamp NULL DEFAULT NULL,
  `arrived_at` timestamp NULL DEFAULT NULL,
  `cancel_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pickup_requests`
--

INSERT INTO `pickup_requests` (`id`, `pickup_code`, `sender_name`, `sender_phone`, `sender_address`, `sender_city`, `sender_lat`, `sender_lng`, `estimated_weight`, `goods_type`, `goods_description`, `receiver_name`, `receiver_phone`, `receiver_address`, `receiver_city`, `pickup_date`, `pickup_time`, `branch_id`, `customer_id`, `courier_id`, `assigned_by`, `processed_by`, `status`, `actual_weight`, `pickup_photo`, `pickup_note`, `picked_up_at`, `arrived_at`, `cancel_reason`, `created_at`, `updated_at`) VALUES
(1, 'PKP-20260504-M80K', 'Ahmad fauzi', '0895386956728', 'Jl.H. Kain\r\nKecamatan cibinong bogor', 'KABUPATEN BOGOR', NULL, NULL, 1.00, 'Pakaian', 'hihihiihi', 'Samsudin', '0895386956728', 'Jl.H. Kain\r\nKecamatan cibinong bogor', 'KABUPATEN BOGOR', '2026-05-08', '10:00-12:00', 1, NULL, 5, 5, 3, 'processed', 2.00, 'pickup-photos/dCkWguaPHhUzBEPxOhYEFJ34C5vaO1EfbHl0TQPk.jpg', 'butuh buble warp', '2026-05-04 20:03:00', '2026-05-04 20:25:24', NULL, '2026-05-03 21:03:49', '2026-05-04 20:30:39'),
(2, 'PKP-20260504-98XD', 'Ahmad fauzi', '0895386956728', 'Jl.H. Kain\r\nKecamatan cibinong bogor', 'KABUPATEN BOGOR', NULL, NULL, 2.00, 'Elektronik', 'Isinya bom', 'Samsudin', '0895386956245', 'Jl.H. Kain\r\nKecamatan cibinong bogor', 'KABUPATEN BOGOR', '2026-05-08', '08:00-10:00', 2, NULL, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-03 21:20:11', '2026-05-03 21:20:11'),
(3, 'PKP-20260505-ROBC', 'Rudy', '0881012683367', '437H+4H9, Belian, Batam Kota, Batam City, Riau Islands, Indonesia', 'surabaya', NULL, NULL, 4.80, 'Elektronik', 'hati-hati barang gampang rusak', 'dita', '0895386956728', '437H+4H9, Belian, Batam Kota, Batam City, Riau Islands, Indonesia', 'jakarta', '2026-07-08', '08:00-10:00', 1, NULL, 5, 2, 3, 'processed', 4.80, 'pickup-photos/af2exH3YofL4GMpYCS8ZjIoqcBS4hdpMW1maASBS.jpg', 'Awas mbg', '2026-05-05 02:58:21', '2026-05-05 02:58:36', NULL, '2026-05-05 02:52:05', '2026-05-05 03:00:09');

-- --------------------------------------------------------

--
-- Table structure for table `rates`
--

CREATE TABLE `rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `origin_location_id` bigint(20) UNSIGNED NOT NULL,
  `destination_location_id` bigint(20) UNSIGNED NOT NULL,
  `price_per_kg` decimal(18,2) NOT NULL,
  `estimated_days` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rates`
--

INSERT INTO `rates` (`id`, `origin_location_id`, `destination_location_id`, `price_per_kg`, `estimated_days`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 15000.00, 3, '2026-05-01 16:47:22', '2026-05-01 16:47:22'),
(2, 1, 3, 8000.00, 1, '2026-05-01 16:47:22', '2026-05-01 16:47:22'),
(3, 2, 1, 15000.00, 3, '2026-05-01 16:47:22', '2026-05-01 16:47:22'),
(4, 3, 1, 20000.00, 3, '2026-05-02 03:50:35', '2026-05-02 03:50:35'),
(5, 4, 5, 10000.00, 2, '2026-05-05 20:42:01', '2026-05-05 21:14:28');

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
('PnRigILs3aJIb9NpRkahpX9HriKt6hUS5SAxzJ9A', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU1RNOGhiT1JGeGFDWmJTZ3Q1YTFVaTdZbzVLazRIM2pVdGN2bE5yQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90cmFja2luZz9yZXNpPUVYUC0yMDI2MDUwMi1RS1pOQkIiO3M6NToicm91dGUiO3M6ODoidHJhY2tpbmciO319', 1778022356),
('zSQlDSsKc4o6h5Y4zONMfagOeP4guwEGuyp0mboZ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRFN2MnFTSldoSHEzVHhmUTdLWFE2SzRuU2hqVkFYUW5VVWkzY1hFWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaGlwbWVudHMiO3M6NToicm91dGUiO3M6MTU6InNoaXBtZW50cy5pbmRleCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1778021578);

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `end_time` timestamp NULL DEFAULT NULL,
  `total_transactions` int(11) NOT NULL DEFAULT 0,
  `total_revenue` decimal(12,2) NOT NULL DEFAULT 0.00,
  `physical_cash` decimal(12,2) DEFAULT NULL,
  `difference` decimal(12,2) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`id`, `user_id`, `branch_id`, `start_time`, `end_time`, `total_transactions`, `total_revenue`, `physical_cash`, `difference`, `status`, `approved_by`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2026-05-04 23:14:23', '2026-05-01 17:19:23', 14, 830000.00, NULL, NULL, 'completed', 2, '2026-05-04 23:14:23', '2026-05-01 16:47:24', '2026-05-04 23:14:23'),
(2, 3, 1, '2026-05-01 17:08:15', NULL, 0, 0.00, NULL, NULL, 'active', NULL, NULL, '2026-05-01 17:08:15', '2026-05-01 17:08:15'),
(3, 17, 1, '2026-05-03 06:50:24', '2026-05-02 23:50:24', 5, 645000.00, NULL, NULL, 'completed', NULL, NULL, '2026-05-02 23:29:53', '2026-05-02 23:50:24'),
(4, 3, 1, '2026-05-04 21:11:20', NULL, 0, 0.00, NULL, NULL, 'active', NULL, NULL, '2026-05-04 21:11:20', '2026-05-04 21:11:20'),
(5, 3, 1, '2026-05-05 20:39:13', NULL, 0, 0.00, NULL, NULL, 'active', NULL, NULL, '2026-05-05 20:39:13', '2026-05-05 20:39:13');

-- --------------------------------------------------------

--
-- Table structure for table `shipments`
--

CREATE TABLE `shipments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tracking_number` varchar(255) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `sender_phone` varchar(255) NOT NULL,
  `origin_location_id` bigint(20) UNSIGNED NOT NULL,
  `origin_subdistrict_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_name` varchar(255) NOT NULL,
  `receiver_phone` varchar(255) NOT NULL,
  `receiver_address` text NOT NULL,
  `destination_location_id` bigint(20) UNSIGNED NOT NULL,
  `destination_subdistrict_id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL,
  `length` int(11) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `volumetric_weight` decimal(8,2) DEFAULT NULL,
  `total_price` decimal(18,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'unpaid',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `scheduled_date` date DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `cashier_id` bigint(20) UNSIGNED NOT NULL,
  `courier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `assigned_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `received_by` varchar(255) DEFAULT NULL,
  `receiver_relation` varchar(255) DEFAULT NULL,
  `delivery_note` text DEFAULT NULL,
  `proof_photo` varchar(255) DEFAULT NULL,
  `digital_signature` text DEFAULT NULL,
  `departed_at` timestamp NULL DEFAULT NULL,
  `arrived_at` timestamp NULL DEFAULT NULL,
  `failed_reason` varchar(255) DEFAULT NULL,
  `failed_note` text DEFAULT NULL,
  `failed_photo` varchar(255) DEFAULT NULL,
  `failed_at` timestamp NULL DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `cod_received_at` timestamp NULL DEFAULT NULL,
  `cod_received_by` bigint(20) UNSIGNED DEFAULT NULL,
  `cod_courier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cod_method` varchar(255) DEFAULT NULL,
  `cod_note` text DEFAULT NULL,
  `trip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dest_lat` decimal(10,8) DEFAULT NULL,
  `dest_lng` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipments`
--

INSERT INTO `shipments` (`id`, `tracking_number`, `sender_name`, `sender_phone`, `origin_location_id`, `origin_subdistrict_id`, `receiver_name`, `receiver_phone`, `receiver_address`, `destination_location_id`, `destination_subdistrict_id`, `item_name`, `weight`, `length`, `width`, `height`, `volumetric_weight`, `total_price`, `payment_method`, `payment_status`, `status`, `scheduled_date`, `branch_id`, `cashier_id`, `courier_id`, `assigned_at`, `created_at`, `updated_at`, `delivered_at`, `received_by`, `receiver_relation`, `delivery_note`, `proof_photo`, `digital_signature`, `departed_at`, `arrived_at`, `failed_reason`, `failed_note`, `failed_photo`, `failed_at`, `paid_at`, `cod_received_at`, `cod_received_by`, `cod_courier_id`, `cod_method`, `cod_note`, `trip_id`, `dest_lat`, `dest_lng`) VALUES
(1, 'EXP-JKT-001', 'Budi Jakarta', '0811111111', 1, 1, 'Ani Surabaya', '0822222222', 'Jl. Tunjungan No. 5', 2, 3, 'Buku Pelajaran', 2000, NULL, NULL, NULL, NULL, 30000.00, 'cash', 'paid', 'delivered', NULL, 1, 3, 5, NULL, '2026-05-01 16:47:24', '2026-05-02 05:02:13', '2026-05-02 05:02:13', NULL, 'Diri Sendiri', 'Paket sudah di terima', 'delivery-proofs/oK15H1tnUYtfeL6OgTQWBmQiFpMPjzRWgcmhri6s.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'EXP-JKT-002', 'Dedi Jakarta', '0811111112', 1, 1, 'Rina Surabaya', '0822222223', 'Jl. Surabaya No. 10', 2, 3, 'Pakaian Elektronik', 1000, NULL, NULL, NULL, NULL, 15000.00, 'cash', 'paid', 'in_transit', NULL, 1, 3, NULL, NULL, '2026-05-01 16:47:24', '2026-05-01 16:47:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'EXP-JKT-003', 'Eko Jakarta', '0811111113', 1, 1, 'Siti Surabaya', '0822222224', 'Jl. Surabaya Indah No. 1', 2, 3, 'Sepatu Olahraga', 1000, NULL, NULL, NULL, NULL, 15000.00, 'cash', 'paid', 'arrived', NULL, 2, 3, NULL, NULL, '2026-05-01 16:47:24', '2026-05-01 16:47:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'EXP-20260502-YUJJAP', 'andi saturno', '0895386956728', 1, 2, 'udin', '08921332443', 'Jl.H. Kain\nKecamatan cibinong bogor', 2, 3, 'Sepatu brand', 10, NULL, NULL, NULL, NULL, 150000.00, 'midtrans', 'pending', 'pending', NULL, 1, 3, NULL, NULL, '2026-05-01 17:09:28', '2026-05-01 17:09:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'EXP-20260502-CPE8RU', 'andi saturno', '0895386956728', 1, 2, 'udin', '08921332443', 'Jl.H. Kain\nKecamatan cibinong bogor', 2, 3, 'Sepatu brand', 10, NULL, NULL, NULL, NULL, 150000.00, 'midtrans', 'pending', 'pending', NULL, 1, 3, NULL, NULL, '2026-05-01 17:09:32', '2026-05-01 17:09:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'EXP-20260502-J5ECTX', 'andi saturno', '0895386956728', 1, 2, 'udin', '08921332443', 'Jl.H. Kain\nKecamatan cibinong bogor', 2, 3, 'Sepatu brand', 10, NULL, NULL, NULL, NULL, 150000.00, 'midtrans', 'paid', 'delivered', '2026-05-04', 1, 3, 5, NULL, '2026-05-01 17:10:35', '2026-05-04 12:08:54', '2026-05-04 12:08:54', 'udin', 'Diri Sendiri', 'paket di terima', 'delivery-proofs/YzvdIDb2oATONnCY0OLAjiMJlVLvXi9S6x4z8AVm.jpg', 'data:image/png;base64,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', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'EXP-20260502-K9GJCS', 'andi saturno', '0895386956728', 1, 2, 'udin', '08921332443', 'Jl.H. Kain\nKecamatan cibinong bogor', 2, 3, 'Sepatu brand', 10, NULL, NULL, NULL, NULL, 150000.00, 'midtrans', 'paid', 'returned_to_warehouse', NULL, 1, 3, 5, '2026-05-02 22:56:43', '2026-05-01 17:10:46', '2026-05-02 23:19:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alamat Tidak Ditemukan', 'huhuhu', 'failed-delivery/2BzDLxZ5xX7GNokHTwumtn0Q2eySewQJJwXu1oda.jpg', '2026-05-02 23:19:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'EXP-20260502-HFJUNC', 'andi', '0895386956728', 1, 1, 'udin', '0895386956797', 'Jl.H. Kain\nKecamatan cibinong bogor', 2, 3, 'Sepatu brand', 10, NULL, NULL, NULL, NULL, 150000.00, 'midtrans', 'paid', 'returned_to_warehouse', NULL, 1, 3, 5, '2026-05-02 22:56:45', '2026-05-01 17:11:22', '2026-05-03 01:00:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alamat Tidak Ditemukan', 'dada', 'failed-delivery/EqEoNHxDXxzFKgGmxADWwc83rhwTXrsd5nVofauo.jpg', '2026-05-03 00:52:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'EXP-20260502-O5EOVN', 'andi', '0895386956728', 1, 1, 'udin', '0895386956245', 'Jl.H. Kain\nKecamatan cibinong bogor', 2, 3, 'Sepatu brand', 10, NULL, NULL, NULL, NULL, 150000.00, 'midtrans', 'paid', 'failed_delivery', NULL, 1, 3, 5, '2026-05-02 22:56:49', '2026-05-01 17:14:04', '2026-05-05 00:18:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Penerima Menolak', 'ntah kenapa bokek kali', 'failed-delivery/Bhk3quMrTcN0feqRZkUAKqcwSRDJpH7HxKi0jRs4.jpg', '2026-05-05 00:18:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'EXP-20260502-K4LOJG', 'agung', '0895386956728', 1, 1, 'sudin', '089538695665', 'Jl.H. Kain\nKecamatan cibinong bogor', 2, 3, 'Sepatu brand', 10, NULL, NULL, NULL, NULL, 150000.00, 'midtrans', 'paid', 'arrived_at_hub', NULL, 1, 3, 13, NULL, '2026-05-01 17:17:06', '2026-05-04 22:42:52', NULL, '13', NULL, NULL, NULL, NULL, '2026-05-04 22:42:33', '2026-05-04 22:42:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL),
(11, 'EXP-20260502-YHMDJ2', 'abang', '0895386956728', 1, 1, 'adik', '08953869567321', 'Jl.H. Kain\nKecamatan cibinong bogor', 3, 4, 'Sepatu brand', 10, NULL, NULL, NULL, NULL, 80000.00, 'cod', 'paid', 'in_transit', NULL, 1, 3, 4, NULL, '2026-05-01 17:18:31', '2026-05-01 17:45:07', NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-01 17:45:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'EXP-2026-READY01', 'Pengirim Satu', '08111111111', 2, 5, 'Penerima Satu', '08222222221', 'Jl. Sudirman No. 1, Jakarta', 1, 1, 'Paket Elektronik', 2, NULL, NULL, NULL, NULL, 45000.00, 'cash', 'paid', 'in_transit', NULL, 2, 3, 4, NULL, '2026-05-02 01:55:38', '2026-05-03 00:06:37', NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-03 00:06:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL),
(13, 'EXP-2026-READY02', 'Pengirim Dua', '08111111112', 2, 5, 'Penerima Dua', '08222222222', 'Jl. Thamrin No. 5, Jakarta', 1, 1, 'Paket Elektronik', 3, NULL, NULL, NULL, NULL, 60000.00, 'cod', 'paid', 'arrived_at_hub', NULL, 2, 3, 4, NULL, '2026-05-02 01:55:38', '2026-05-03 17:55:12', NULL, '4', NULL, NULL, NULL, NULL, '2026-05-03 17:54:54', '2026-05-03 17:55:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL),
(14, 'EXP-2026-TRANS01', 'Pengirim Empat', '08111111114', 2, 5, 'Penerima Empat', '08222222224', 'Jl. Kemang Raya No. 3, Jakarta Selatan', 1, 1, 'Paket Elektronik', 2, NULL, NULL, NULL, NULL, 45000.00, 'cash', 'paid', 'arrived_at_hub', NULL, 2, 3, 4, NULL, '2026-05-02 01:55:38', '2026-05-03 00:11:39', NULL, '4', NULL, NULL, NULL, NULL, '2026-05-01 22:19:46', '2026-05-03 00:11:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, -6.27380000, 106.82060000),
(15, 'EXP-2026-ARRIV01', 'Pengirim Enam', '08111111116', 2, 5, 'Penerima Enam', '08222222226', 'Jl. Fatmawati No. 12, Jakarta', 1, 1, 'Paket Elektronik', 2, NULL, NULL, NULL, NULL, 45000.00, 'cash', 'paid', 'delivered', NULL, 1, 3, 5, NULL, '2026-05-02 01:55:38', '2026-05-02 02:52:29', '2026-05-02 02:52:29', NULL, 'Diri Sendiri', 'Sudah di terima', 'delivery-proofs/3FSQtapmcH9F6IDbmmEpRLVddOXbx8Nsw6CgY7Xu.jpg', NULL, NULL, '2026-05-02 00:55:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'EXP-2026-ASGN01', 'Pengirim Delapan', '08111111118', 2, 5, 'Penerima Delapan', '08222222228', 'Jl. Menteng No. 10, Jakarta', 1, 1, 'Paket Elektronik', 1, NULL, NULL, NULL, NULL, 35000.00, 'cash', 'paid', 'assigned', '2026-05-04', 1, 3, 5, NULL, '2026-05-02 01:55:38', '2026-05-02 22:59:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Alamat Tidak Ditemukan', 'dimana sih salah alamat kali ya', 'failed-delivery/imuUJeOcaiktmND5CNTNCWCCDFZDnhxkRRdyFerE.jpg', '2026-05-02 18:29:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'EXP-2026-DONE01', 'Pengirim Sepuluh', '08111111120', 2, 5, 'Penerima Sepuluh', '08222222230', 'Jl. Kuningan No. 5, Jakarta', 1, 1, 'Paket Elektronik', 3, NULL, NULL, NULL, NULL, 55000.00, 'cash', 'paid', 'delivered', NULL, 1, 3, 5, NULL, '2026-05-02 01:55:38', '2026-05-02 01:55:38', '2026-05-02 00:55:38', 'Penerima Sepuluh', 'Diri Sendiri', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'EXP-2026-TRANS02', 'Pengirim Lima', '08111111115', 2, 5, 'Penerima Lima', '08222222225', 'Jl. Blok M Plaza, Jakarta Selatan', 1, 1, 'Paket Elektronik', 4, NULL, NULL, NULL, NULL, 70000.00, 'cod', 'paid', 'arrived_at_hub', NULL, 2, 3, 4, NULL, '2026-05-02 02:01:15', '2026-05-03 00:11:39', NULL, '4', NULL, NULL, NULL, NULL, '2026-05-01 22:19:46', '2026-05-03 00:11:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, -6.24440000, 106.80200000),
(19, 'EXP-20260502-QKZNBB', 'samsudin', '08921332443', 3, 4, 'agus', '08921332443', 'Jl.H. Kain\nKecamatan cibinong bogor', 1, 2, 'Sepatu brand', 9, NULL, NULL, NULL, NULL, 180000.00, 'midtrans', 'paid', 'delivered', NULL, 1, 3, 5, '2026-05-03 00:51:45', '2026-05-02 04:05:14', '2026-05-04 12:16:16', '2026-05-04 12:16:16', 'agus', 'Keluarga', 'sudah', 'delivery-proofs/uf0ORpVKpVogeWGQ9uDXr701Dxz9TOSUJcW6G44d.jpg', 'data:image/png;base64,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', '2026-05-02 04:43:15', '2026-05-02 04:52:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL);
INSERT INTO `shipments` (`id`, `tracking_number`, `sender_name`, `sender_phone`, `origin_location_id`, `origin_subdistrict_id`, `receiver_name`, `receiver_phone`, `receiver_address`, `destination_location_id`, `destination_subdistrict_id`, `item_name`, `weight`, `length`, `width`, `height`, `volumetric_weight`, `total_price`, `payment_method`, `payment_status`, `status`, `scheduled_date`, `branch_id`, `cashier_id`, `courier_id`, `assigned_at`, `created_at`, `updated_at`, `delivered_at`, `received_by`, `receiver_relation`, `delivery_note`, `proof_photo`, `digital_signature`, `departed_at`, `arrived_at`, `failed_reason`, `failed_note`, `failed_photo`, `failed_at`, `paid_at`, `cod_received_at`, `cod_received_by`, `cod_courier_id`, `cod_method`, `cod_note`, `trip_id`, `dest_lat`, `dest_lng`) VALUES
(20, 'EXP-20260503-CLGV3Q', 'asep', '08921332443', 1, 1, 'boring', '08921332443', 'Jl.H. Kain\nKecamatan cibinong bogor', 2, 5, 'Sepatu brand', 9, NULL, NULL, NULL, NULL, 135000.00, 'midtrans', 'paid', 'delivered', NULL, 1, 17, 5, '2026-05-04 22:45:00', '2026-05-02 23:31:38', '2026-05-04 22:46:10', '2026-05-04 22:46:10', 'boring', 'Diri Sendiri', 'sudah di terima', 'delivery-proofs/Gc2qfknDWBVmIBd1DP1OuOYu2x48iV4W4XuPYeiY.jpg', 'data:image/png;base64,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', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'EXP-20260503-DNACPR', 'sasa', '0895386956728', 1, 2, 'asas', '089538695632', 'Jl.H. Kain\nKecamatan cibinong bogor', 2, 3, 'baju', 6, NULL, NULL, NULL, NULL, 90000.00, 'transfer', 'paid', 'ready_to_ship', NULL, 1, 17, NULL, NULL, '2026-05-02 23:43:02', '2026-05-02 23:43:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'EXP-20260503-AQVEJJ', 'wawa', '0895386956728', 1, 2, 'awaw', '089538695632', 'Jl.H. Kain\nKecamatan cibinong bogor', 2, 3, 'baju', 7, NULL, NULL, NULL, NULL, 105000.00, 'cod', 'paid', 'ready_to_ship', NULL, 1, 17, NULL, NULL, '2026-05-02 23:47:47', '2026-05-02 23:47:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'EXP-20260503-OGLGEY', 'dada', '0895386956728', 2, 5, 'adad', '089538695632', 'Jl.H. Kain\nKecamatan cibinong bogor', 1, 1, 'baju', 21, NULL, NULL, NULL, NULL, 315000.00, 'cash', 'paid', 'ready_to_ship', NULL, 1, 17, NULL, NULL, '2026-05-02 23:48:40', '2026-05-02 23:48:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'EXP-20260505-X1FRFA', 'sass', '0895386956728', 2, 5, 'sssa', '089538695632', 'Jl.H. Kain\nKecamatan cibinong bogor', 1, 1, 'baju', 21, NULL, NULL, NULL, NULL, 315000.00, 'midtrans', 'paid', 'ready_to_ship', NULL, 1, 3, NULL, NULL, '2026-05-04 20:29:47', '2026-05-04 20:30:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'EXP-20260505-JJYQTH', 'Ahmad fauzi', '0895386956728', 1, 1, 'Samsudin', '0895386956728', 'Jl.H. Kain\r\nKecamatan cibinong bogor', 1, 1, 'Pakaian', 2, NULL, NULL, NULL, NULL, 20000.00, 'midtrans', 'paid', 'ready_to_ship', NULL, 1, 3, NULL, NULL, '2026-05-04 20:30:39', '2026-05-04 20:30:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'EXP-20260505-QWH93N', 'udin', '089979797979', 3, 4, 'adit', '080443434545', 'hohohohohoho', 1, 2, 'baju', 2, NULL, NULL, NULL, NULL, 120000.00, 'transfer', 'paid', 'ready_to_ship', NULL, 1, 3, NULL, NULL, '2026-05-05 01:41:30', '2026-05-05 01:41:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'EXP-20260505-G6GWBJ', 'Rudy', '0881012683367', 1, 1, 'dita', '0895386956728', '437H+4H9, Belian, Batam Kota, Batam City, Riau Islands, Indonesia', 3, 1, 'Elektronik', 5, NULL, NULL, NULL, NULL, 40000.00, 'midtrans', 'unpaid', 'ready_to_ship', NULL, 1, 3, NULL, NULL, '2026-05-05 03:00:09', '2026-05-05 03:00:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'EXP-20260505-NCAID6', 'Ahmad fauzi', '0895386956728', 2, 5, 'dikap', '089538695632', 'Jl.H. Kain\nKecamatan cibinong bogor', 1, 1, 'baju', 21, NULL, NULL, NULL, NULL, 315000.00, 'midtrans', 'paid', 'ready_to_ship', NULL, 1, 3, NULL, NULL, '2026-05-05 10:35:25', '2026-05-05 10:42:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'EXP-20260505-ZH7VBF', 'sasss', '0895386956728', 2, 5, 'sssa', '089538695632', 'Jl.H. Kain\nKecamatan cibinong bogor', 1, 1, 'baju', 21, NULL, NULL, NULL, NULL, 315000.00, 'midtrans', 'paid', 'ready_to_ship', NULL, 1, 3, NULL, NULL, '2026-05-05 10:41:39', '2026-05-05 10:42:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'EXP-20260506-IR02BU', 'frach', '08767675656', 10, 12, 'amarica', '08213433434', 'jalanananna', 11, 13, 'elektronik', 100, NULL, NULL, NULL, NULL, 1800000.00, 'midtrans', 'paid', 'ready_to_ship', NULL, 1, 3, NULL, NULL, '2026-05-05 21:22:32', '2026-05-05 21:25:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'EXP-20260506-DITHRY', 'sasasasa', '09876543', 14, 16, 'sasasasa', '09876543', 'asasasasasass', 15, 17, 'baju', 91, NULL, NULL, NULL, NULL, 1638000.00, 'midtrans', 'paid', 'ready_to_ship', NULL, 1, 3, NULL, NULL, '2026-05-05 22:47:04', '2026-05-05 22:47:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipment_trackings`
--

CREATE TABLE `shipment_trackings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipment_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipment_trackings`
--

INSERT INTO `shipment_trackings` (`id`, `shipment_id`, `status`, `location`, `description`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', NULL, '2026-05-01 16:47:24', '2026-05-01 16:47:24'),
(2, 1, 'pending', 'Cabang Jakarta Pusat', 'Paket telah diterima di Cabang Jakarta.', 3, '2026-05-01 16:47:24', '2026-05-01 16:47:24'),
(3, 2, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', NULL, '2026-05-01 16:47:24', '2026-05-01 16:47:24'),
(4, 2, 'pending', 'Jakarta', 'Paket diterima.', NULL, '2026-05-01 16:47:24', '2026-05-01 16:47:24'),
(5, 2, 'in_transit', 'Dalam Perjalanan JKT-SBY', 'Paket sedang dibawa oleh Kurir Transit.', 4, '2026-05-01 16:47:24', '2026-05-01 16:47:24'),
(6, 3, 'pending', 'Surabaya', 'Paket telah diterima di cabang pengirim.', NULL, '2026-05-01 16:47:24', '2026-05-01 16:47:24'),
(7, 3, 'pending', 'Jakarta', 'Paket diterima.', NULL, '2026-05-01 16:47:24', '2026-05-01 16:47:24'),
(8, 3, 'in_transit', 'Transit', 'Dalam perjalanan.', NULL, '2026-05-01 16:47:24', '2026-05-01 16:47:24'),
(9, 3, 'arrived', 'Cabang Surabaya', 'Paket telah sampai di Cabang Surabaya.', NULL, '2026-05-01 16:47:24', '2026-05-01 16:47:24'),
(10, 4, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 3, '2026-05-01 17:09:28', '2026-05-01 17:09:28'),
(11, 5, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 3, '2026-05-01 17:09:32', '2026-05-01 17:09:32'),
(12, 6, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 3, '2026-05-01 17:10:35', '2026-05-01 17:10:35'),
(13, 7, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 3, '2026-05-01 17:10:46', '2026-05-01 17:10:46'),
(14, 8, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 3, '2026-05-01 17:11:22', '2026-05-01 17:11:22'),
(15, 9, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 3, '2026-05-01 17:14:04', '2026-05-01 17:14:04'),
(16, 10, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 3, '2026-05-01 17:17:06', '2026-05-01 17:17:06'),
(17, 11, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 3, '2026-05-01 17:18:31', '2026-05-01 17:18:31'),
(18, 12, 'pending', 'Surabaya', 'Paket telah diterima di cabang pengirim.', NULL, '2026-05-02 01:55:38', '2026-05-02 01:55:38'),
(19, 13, 'pending', 'Surabaya', 'Paket telah diterima di cabang pengirim.', NULL, '2026-05-02 01:55:38', '2026-05-02 01:55:38'),
(20, 14, 'pending', 'Surabaya', 'Paket telah diterima di cabang pengirim.', NULL, '2026-05-02 01:55:38', '2026-05-02 01:55:38'),
(21, 15, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', NULL, '2026-05-02 01:55:38', '2026-05-02 01:55:38'),
(22, 16, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', NULL, '2026-05-02 01:55:38', '2026-05-02 01:55:38'),
(23, 17, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', NULL, '2026-05-02 01:55:38', '2026-05-02 01:55:38'),
(24, 18, 'pending', 'Surabaya', 'Paket telah diterima di cabang pengirim.', NULL, '2026-05-02 02:01:15', '2026-05-02 02:01:15'),
(25, 15, 'assigned', 'Jakarta', 'Status pengiriman diperbarui.', 2, '2026-05-02 02:09:13', '2026-05-02 02:09:13'),
(26, 14, 'in_transit', 'Transit', 'Paket sedang dalam perjalanan.', NULL, '2026-05-02 02:19:46', '2026-05-02 02:19:46'),
(27, 18, 'in_transit', 'Transit', 'Paket sedang dalam perjalanan.', NULL, '2026-05-02 02:19:46', '2026-05-02 02:19:46'),
(28, 15, 'delivered', 'Jakarta', 'Paket telah berhasil diterima.', 5, '2026-05-02 02:52:29', '2026-05-02 02:52:29'),
(29, 19, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 3, '2026-05-02 04:05:14', '2026-05-02 04:05:14'),
(30, 1, 'assigned', 'Jakarta', 'Status pengiriman diperbarui.', 2, '2026-05-02 05:00:51', '2026-05-02 05:00:51'),
(31, 6, 'assigned', 'Jakarta', 'Status pengiriman diperbarui.', 2, '2026-05-02 05:00:55', '2026-05-02 05:00:55'),
(32, 1, 'delivered', 'Jakarta', 'Paket telah berhasil diterima.', 5, '2026-05-02 05:02:13', '2026-05-02 05:02:13'),
(33, 6, 'failed_delivery', 'Jakarta', 'Status pengiriman diperbarui.', 5, '2026-05-02 05:02:48', '2026-05-02 05:02:48'),
(34, 6, 'returned_to_warehouse', 'Jakarta', 'Status pengiriman diperbarui.', 5, '2026-05-02 05:02:48', '2026-05-02 05:02:48'),
(35, 16, 'failed_delivery', 'Jakarta', 'Status pengiriman diperbarui.', 5, '2026-05-02 06:55:34', '2026-05-02 06:55:34'),
(36, 16, 'returned_to_warehouse', 'Jakarta', 'Status pengiriman diperbarui.', 5, '2026-05-02 06:55:34', '2026-05-02 06:55:34'),
(37, 6, 'assigned', 'Jakarta', 'Status pengiriman diperbarui.', 5, '2026-05-02 18:22:36', '2026-05-02 18:22:36'),
(38, 16, 'assigned', 'Jakarta', 'Status pengiriman diperbarui.', 5, '2026-05-02 18:24:30', '2026-05-02 18:24:30'),
(39, 16, 'failed_delivery', 'Jakarta', 'Status pengiriman diperbarui.', 5, '2026-05-02 18:29:32', '2026-05-02 18:29:32'),
(40, 7, 'assigned', 'Jakarta', 'Status pengiriman diperbarui.', 2, '2026-05-02 22:56:43', '2026-05-02 22:56:43'),
(41, 8, 'assigned', 'Jakarta', 'Status pengiriman diperbarui.', 2, '2026-05-02 22:56:45', '2026-05-02 22:56:45'),
(42, 9, 'assigned', 'Jakarta', 'Status pengiriman diperbarui.', 2, '2026-05-02 22:56:49', '2026-05-02 22:56:49'),
(43, 16, 'assigned', 'Jakarta', 'Status pengiriman diperbarui.', 5, '2026-05-02 22:59:08', '2026-05-02 22:59:08'),
(44, 7, 'failed_delivery', 'Jakarta', 'Gagal dalam pengiriman paket.', 5, '2026-05-02 23:19:19', '2026-05-02 23:19:19'),
(45, 7, 'returned_to_warehouse', 'Jakarta', 'Paket dikembalikan ke gudang.', 5, '2026-05-02 23:19:31', '2026-05-02 23:19:31'),
(46, 20, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 17, '2026-05-02 23:31:38', '2026-05-02 23:31:38'),
(47, 20, 'ready_to_ship', 'Jakarta', 'Status pengiriman diperbarui.', 17, '2026-05-02 23:32:14', '2026-05-02 23:32:14'),
(48, 21, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 17, '2026-05-02 23:43:02', '2026-05-02 23:43:02'),
(49, 22, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 17, '2026-05-02 23:47:47', '2026-05-02 23:47:47'),
(50, 23, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 17, '2026-05-02 23:48:40', '2026-05-02 23:48:40'),
(51, 19, 'assigned', 'Transit', 'Kurir ditugaskan untuk mengantar paket.', 1, '2026-05-03 00:51:45', '2026-05-03 00:51:45'),
(52, 8, 'failed_delivery', 'Jakarta', 'Gagal dalam pengiriman paket.', 5, '2026-05-03 00:52:27', '2026-05-03 00:52:27'),
(53, 8, 'returned_to_warehouse', 'Jakarta', 'Paket dikembalikan ke gudang.', 5, '2026-05-03 01:00:02', '2026-05-03 01:00:02'),
(54, 6, 'delivered', 'Jakarta', 'Paket telah berhasil diterima.', 5, '2026-05-04 12:08:54', '2026-05-04 12:08:54'),
(55, 19, 'delivered', 'Jakarta', 'Paket telah berhasil diterima.', 5, '2026-05-04 12:16:16', '2026-05-04 12:16:16'),
(56, 24, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 3, '2026-05-04 20:29:47', '2026-05-04 20:29:47'),
(57, 24, 'ready_to_ship', 'Jakarta', 'Status pengiriman diperbarui.', 3, '2026-05-04 20:30:22', '2026-05-04 20:30:22'),
(58, 25, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 3, '2026-05-04 20:30:39', '2026-05-04 20:30:39'),
(59, 20, 'assigned', 'Transit', 'Kurir ditugaskan untuk mengantar paket.', 1, '2026-05-04 22:45:00', '2026-05-04 22:45:00'),
(60, 20, 'delivered', 'Jakarta', 'Paket telah berhasil diterima.', 5, '2026-05-04 22:46:10', '2026-05-04 22:46:10'),
(61, 9, 'failed_delivery', 'Jakarta', 'Gagal dalam pengiriman paket.', 5, '2026-05-05 00:18:33', '2026-05-05 00:18:33'),
(62, 26, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 3, '2026-05-05 01:41:30', '2026-05-05 01:41:30'),
(63, 27, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 3, '2026-05-05 03:00:09', '2026-05-05 03:00:09'),
(64, 28, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 3, '2026-05-05 10:35:25', '2026-05-05 10:35:25'),
(65, 29, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 3, '2026-05-05 10:41:39', '2026-05-05 10:41:39'),
(66, 29, 'ready_to_ship', 'Jakarta', 'Status pengiriman diperbarui.', 3, '2026-05-05 10:42:29', '2026-05-05 10:42:29'),
(67, 28, 'ready_to_ship', 'Jakarta', 'Status pengiriman diperbarui.', 3, '2026-05-05 10:42:32', '2026-05-05 10:42:32'),
(68, 30, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 3, '2026-05-05 21:22:32', '2026-05-05 21:22:32'),
(69, 30, 'ready_to_ship', 'Jakarta', 'Status pengiriman diperbarui.', 3, '2026-05-05 21:25:41', '2026-05-05 21:25:41'),
(70, 31, 'pending', 'Jakarta', 'Paket telah diterima di cabang pengirim.', 3, '2026-05-05 22:47:05', '2026-05-05 22:47:05'),
(71, 31, 'ready_to_ship', 'Jakarta', 'Paket siap diberangkatkan ke kota tujuan.', 3, '2026-05-05 22:47:34', '2026-05-05 22:47:34');

-- --------------------------------------------------------

--
-- Table structure for table `subdistricts`
--

CREATE TABLE `subdistricts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subdistricts`
--

INSERT INTO `subdistricts` (`id`, `location_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Gambir', '2026-05-01 16:47:22', '2026-05-01 16:47:22'),
(2, 1, 'Menteng', '2026-05-01 16:47:22', '2026-05-01 16:47:22'),
(3, 2, 'Tegalsari', '2026-05-01 16:47:22', '2026-05-01 16:47:22'),
(4, 3, 'Sumur Bandung', '2026-05-01 16:47:22', '2026-05-01 16:47:22'),
(5, 2, 'Wonokromo', '2026-05-02 01:55:37', '2026-05-02 01:55:37'),
(6, 4, '-', '2026-05-05 21:14:19', '2026-05-05 21:14:19'),
(7, 5, '-', '2026-05-05 21:14:23', '2026-05-05 21:14:23'),
(8, 6, 'GUNUNG MEGANG', '2026-05-05 21:15:03', '2026-05-05 21:15:03'),
(9, 7, 'BABUSSALAM', '2026-05-05 21:15:05', '2026-05-05 21:15:05'),
(10, 8, '-', '2026-05-05 21:19:57', '2026-05-05 21:19:57'),
(11, 9, '-', '2026-05-05 21:20:02', '2026-05-05 21:20:02'),
(12, 10, 'GUNUNG SARI', '2026-05-05 21:20:41', '2026-05-05 21:20:41'),
(13, 11, 'KLUNGKUNG', '2026-05-05 21:20:43', '2026-05-05 21:20:43'),
(14, 12, 'TAMBUN SELATAN', '2026-05-05 22:44:56', '2026-05-05 22:44:56'),
(15, 13, 'ELAR SELATAN', '2026-05-05 22:44:57', '2026-05-05 22:44:57'),
(16, 14, 'BUSUNGBIU', '2026-05-05 22:46:46', '2026-05-05 22:46:46'),
(17, 15, 'CILEGON', '2026-05-05 22:46:48', '2026-05-05 22:46:48');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `courier_id` bigint(20) UNSIGNED NOT NULL,
  `origin_branch_id` varchar(255) NOT NULL,
  `destination_branch_id` varchar(255) NOT NULL,
  `total_packages` int(11) NOT NULL DEFAULT 0,
  `total_received` int(11) NOT NULL DEFAULT 0,
  `departed_at` timestamp NULL DEFAULT NULL,
  `arrived_at` timestamp NULL DEFAULT NULL,
  `status` enum('on_the_way','completed','cancelled') NOT NULL DEFAULT 'on_the_way',
  `missing_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `courier_id`, `origin_branch_id`, `destination_branch_id`, `total_packages`, `total_received`, `departed_at`, `arrived_at`, `status`, `missing_note`, `created_at`, `updated_at`) VALUES
(1, 4, '2', '1', 2, 2, '2026-05-01 22:01:15', '2026-05-02 02:05:36', 'completed', NULL, '2026-05-01 17:45:07', '2026-05-02 02:05:36'),
(2, 4, '2', '1', 2, 2, '2026-05-01 22:19:46', '2026-05-03 00:11:39', 'completed', NULL, '2026-05-02 02:19:46', '2026-05-03 00:11:39'),
(3, 13, '1', '4', 1, 1, '2026-05-02 04:43:15', '2026-05-02 04:52:58', 'completed', NULL, '2026-05-02 04:43:15', '2026-05-02 04:52:58'),
(4, 4, '2', '4', 1, 2, '2026-05-03 00:06:37', '2026-05-03 00:07:27', 'completed', NULL, '2026-05-03 00:06:37', '2026-05-03 00:07:27'),
(5, 4, '2', '1', 1, 1, '2026-05-03 17:54:54', '2026-05-03 17:55:12', 'completed', NULL, '2026-05-03 17:54:54', '2026-05-03 17:55:12'),
(6, 13, '1', '2', 1, 1, '2026-05-04 22:42:33', '2026-05-04 22:42:52', 'completed', NULL, '2026-05-04 22:42:33', '2026-05-04 22:42:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','manager','cashier','courier','courier_transit','courier_delivery','courier_pickup','staff','customer') DEFAULT 'customer',
  `sim_type` varchar(255) DEFAULT NULL,
  `sim_photo` varchar(255) DEFAULT NULL,
  `vehicle_type` varchar(255) DEFAULT NULL,
  `vehicle_plate` varchar(255) DEFAULT NULL,
  `courier_type` varchar(255) DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','review','active','rejected') DEFAULT 'pending',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `province_id` varchar(255) DEFAULT NULL,
  `province_name` varchar(255) DEFAULT NULL,
  `regency_id` varchar(255) DEFAULT NULL,
  `regency_name` varchar(255) DEFAULT NULL,
  `district_id` varchar(255) DEFAULT NULL,
  `district_name` varchar(255) DEFAULT NULL,
  `address_detail` text DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `ktp_photo` varchar(255) DEFAULT NULL,
  `selfie_photo` varchar(255) DEFAULT NULL,
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `rejected_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `manager_note` text DEFAULT NULL,
  `rejected_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `role`, `sim_type`, `sim_photo`, `vehicle_type`, `vehicle_plate`, `courier_type`, `branch_id`, `status`, `remember_token`, `created_at`, `updated_at`, `phone`, `birth_date`, `address`, `province_id`, `province_name`, `regency_id`, `regency_name`, `district_id`, `district_name`, `address_detail`, `experience`, `ktp_photo`, `selfie_photo`, `reviewed_by`, `approved_by`, `rejected_by`, `reviewed_at`, `approved_at`, `manager_note`, `rejected_reason`) VALUES
(1, 'Admin Pusat', 'admin@expedisi.com', 'avatars/8o59UaQHi9Au2qUGaUMoyCsLiLBCXGvaL6KR3TYx.jpg', NULL, '$2y$12$NguXUnAkGv9szhep3RYtN.VQE.7haVXabXdsSl9kcUXSqrcewZXYC', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-05-01 16:47:23', '2026-05-05 02:32:35', 'admin@expedisi.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Manager Jakarta', 'manager@expedisi.com', NULL, NULL, '$2y$12$UNpgjReixqeqQ8zomHhR6e6wlKFiZ0e2goi8DLowJT29phk40NG3a', 'manager', NULL, NULL, NULL, NULL, NULL, 1, 'active', NULL, '2026-05-01 16:47:23', '2026-05-01 16:47:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Kasir Jakarta', 'cashier@expedisi.com', NULL, NULL, '$2y$12$HMc/sp.R.jTNuxJBiRJkHuQSThGa1OIlNvjtRgwJE.LRxyHMFiVl6', 'cashier', NULL, NULL, NULL, NULL, NULL, 1, 'active', NULL, '2026-05-01 16:47:23', '2026-05-01 16:47:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Transit Utama', 'transit@expedisi.com', NULL, NULL, '$2y$12$y4wrRmle9LGp4EbS8PEByuKuf1V.BANKMmmnN4G2C1K7gI5eyNk5K', 'courier_transit', NULL, NULL, NULL, NULL, NULL, 2, 'active', NULL, '2026-05-01 16:47:23', '2026-05-02 02:19:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Delivery Utama', 'delivery@expedisi.com', NULL, NULL, '$2y$12$JxpzaKPUuFoYy1K8N0sZK.xOXINVOP8bxtQHyxZdddvSAMFP3bAQ2', 'courier_delivery', NULL, NULL, NULL, NULL, NULL, 1, 'active', NULL, '2026-05-01 16:47:24', '2026-05-02 02:19:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Budi Customer', 'customer@expedisi.com', NULL, NULL, '$2y$12$qRupvZPCBXGchtj44wZqfO.QBImStqrltaCDCbBuIraAqcuE7/xLe', 'customer', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-05-01 16:47:24', '2026-05-01 16:47:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Pelamar Baru', 'pelamar@gmail.com', NULL, NULL, '$2y$12$KacYe3mGVPnYjlIugIB1hOizywQHe8JyI0VN.4wPLIEBwwEx2OkHO', 'courier_delivery', NULL, NULL, NULL, NULL, NULL, 1, 'pending', NULL, '2026-05-01 16:47:24', '2026-05-01 16:47:24', '08123456780', NULL, 'Jl. Pelamar No. 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pernah kerja di JNE 2 tahun', 'staff-documents/ktp/dummy.jpg', 'staff-documents/selfie/dummy.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Pelamar Direview', 'review@gmail.com', NULL, NULL, '$2y$12$3JOK5rt2VVbRCuzuf67lV.76rNVc2gtgLSJi31ja64rno7PZjnpvy', 'cashier', NULL, NULL, NULL, NULL, NULL, 1, 'review', NULL, '2026-05-01 16:47:24', '2026-05-01 16:47:24', '08123456781', NULL, 'Jl. Review No. 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, '2026-05-01 16:47:24', NULL, NULL, NULL),
(9, 'Transit Dodi', 'transit2@expedisi.com', NULL, NULL, '$2y$12$SSYParkRHewv1T5k522dzeSjtpL5v7a/4qj7hT/MaesAqOHTH.1jK', 'courier_transit', NULL, NULL, NULL, NULL, NULL, 2, 'active', NULL, '2026-05-02 01:55:37', '2026-05-02 01:55:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Transit Eko', 'transit3@expedisi.com', NULL, NULL, '$2y$12$VDHbvDL.jlYG1vpAS9BlJu49tDsuUe38MdEMIAdf47x4j.Cy7Ed9G', 'courier_transit', NULL, NULL, NULL, NULL, NULL, 2, 'active', NULL, '2026-05-02 01:55:37', '2026-05-02 01:55:37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'Delivery Fajar', 'delivery2@expedisi.com', NULL, NULL, '$2y$12$CxRLx1lQIqxSVjhEEtaR0uBY0h0FrZO5sjhI1coKtxGOWEfvVqXIq', 'courier_delivery', NULL, NULL, NULL, NULL, NULL, 1, 'active', NULL, '2026-05-02 01:55:38', '2026-05-02 01:55:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'Delivery Gilang', 'delivery3@expedisi.com', NULL, NULL, '$2y$12$rcUk40NIWgMzJedUJo7PbORSnO3tvx0qGeKyCZvK2QhF6eFIyZEyy', 'courier_delivery', NULL, NULL, NULL, NULL, NULL, 1, 'active', NULL, '2026-05-02 01:55:38', '2026-05-02 01:55:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'Transit Jakarta', 'transit.jkt@expedisi.com', NULL, NULL, '$2y$12$JK.x/FVUd0pj1UqS/LAbRexrSIuIHVLavZYXgO.Ge.HjF8ub6sLoO', 'courier_transit', NULL, NULL, NULL, NULL, NULL, 1, 'active', NULL, '2026-05-02 04:35:08', '2026-05-02 04:38:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, NULL, '2026-05-02 04:38:10', '2026-05-02 04:38:41', 'boleh lah cabang jakarta', NULL),
(14, 'adrian', 'adrian@gmail.com', NULL, NULL, '$2y$12$XqTj4RJmPTSC1JQlHMzSVez534Me2gnAOf66dHI/0f.vWyTFgLKLe', 'cashier', NULL, NULL, NULL, NULL, NULL, 2, 'pending', NULL, '2026-05-02 06:34:11', '2026-05-02 06:34:11', '089538694325', '2026-05-02', 'Jl.H. Kain\r\nKecamatan cibinong bogor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'staff-documents/ktp/XBQWU658OvRV9v0qFvf0WklfUtih5HfU6e8eSvsK.jpg', 'staff-documents/selfie/L2uWqUQzAyQukCTSGtXouAQNYTbVHrszobSMtbSJ.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'bambang wijaya', 'bambang@gmail.com', NULL, NULL, '$2y$12$6szInEVT7a8XqVlisFjfi.tBiy4QIIvvedyTDv0VJTAnX2CC4n6Pi', 'cashier', NULL, NULL, NULL, NULL, NULL, 1, 'pending', NULL, '2026-05-02 18:32:21', '2026-05-02 18:32:21', '089538694325', '2008-04-14', 'Jl.H. Kain\r\nKecamatan cibinong bogor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sudah pernah berurusan keuangan di bank central jaya', 'staff-documents/ktp/pMPMByIQ7uIEtQ4810HE4D0ptrWeSqSSCGMh6B0H.jpg', 'staff-documents/selfie/qEdM31pDOgApXnxiLTp6Ym7pfN1WCbpZkXLzfj0N.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'John Doe', 'john.doe@example.com', NULL, NULL, '$2y$12$fkDGxhfzDuY6/0Nspc7jzOLC/aC7BTT.qE2z8nF6.jdtpbJZOnF5e', 'cashier', NULL, NULL, NULL, '', NULL, 1, 'rejected', NULL, '2026-05-02 21:35:43', '2026-05-02 22:31:52', '081234567890', '2000-01-01', NULL, '11', 'ACEH', '1101', 'KABUPATEN SIMEULUE', '1101010', 'TEUPAH SELATAN', 'Jl. Kebon Jeruk No. 123', '1 tahun pengalaman sebagai kasir di toko retail.', 'staff/ktp/PZZvxSNMX16eOuD5yuLKtkTcVHSAAZSFFJjc9qQm.jpg', 'staff/staffie/XPIP8L51npTLWeGeOUU0KodkC5iel8ORhyYPgLJl.jpg', NULL, NULL, 2, NULL, NULL, NULL, 'malas'),
(17, 'Yahya', 'redmiyahya15@gmail.com', NULL, NULL, '$2y$12$ryoISY/wk4YpS2NqbJXmM.Npk.158SdrFyNwnAYQdem.Q4czGxP7e', 'cashier', NULL, NULL, NULL, '', NULL, 1, 'active', NULL, '2026-05-02 22:36:46', '2026-05-02 22:48:34', '0895386956728', '2007-11-17', NULL, '32', 'JAWA BARAT', '3201', 'KABUPATEN BOGOR', '3201210', 'CIBINONG', 'Jl.H. Kain  Kecamatan cibinong bogor', 'ayo kita main', 'staff/ktp/qoo3Vk0F9fuJAe97j9HgN1TwGtGMWzephJHQD1Wm.jpg', 'staff/staffie/V82a3kcMwipqLkXeokMLXNlao34cpQSkRclLu1F9.jpg', 2, 1, NULL, '2026-05-02 22:46:07', '2026-05-02 22:48:34', 'boleh lah rekomen banget cik', NULL),
(18, 'andi', 'anditransit@gmail.com', NULL, NULL, '$2y$12$RQQfLrbFutPb/eRTWsx98uClWfB0dhfUTaqD.NpGGtnB0ng5Ev9fS', 'courier_transit', 'A', 'staff/sim/hY6XdCbEdMBos9U7pq4GmnOLExHFln0b1Dhl3WjF.jpg', 'Motor', 'B 12334 BC', NULL, 1, 'active', NULL, '2026-05-05 20:34:05', '2026-05-05 20:37:12', '0895386956728', '2000-08-16', NULL, '35', 'JAWA TIMUR', '3513', 'KABUPATEN PROBOLINGGO', '3513140', 'BESUK', 'Jl.H. Kain\r\nKecamatan cibinong bogor', 'Pernah nyawit', 'staff/ktp/8qlAdNAmEovf1mUoLgm6uK4mYvdYWNcO5ZufSzGD.jpg', 'staff/staffie/NEJl1I9IBD9Qbdx2tBDw1kltnuUiWAakx2uyjgCa.jpg', 2, 1, NULL, '2026-05-05 20:36:13', '2026-05-05 20:37:12', 'boleh lah mbg itu', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_type` varchar(255) NOT NULL,
  `license_plate` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `cash_drawers`
--
ALTER TABLE `cash_drawers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_drawers_branch_id_foreign` (`branch_id`),
  ADD KEY `cash_drawers_closed_by_foreign` (`closed_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `locations`
--
ALTER TABLE `locations`
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
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

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
  ADD KEY `payments_shipment_id_foreign` (`shipment_id`),
  ADD KEY `payments_received_by_foreign` (`received_by`),
  ADD KEY `payments_courier_id_foreign` (`courier_id`);

--
-- Indexes for table `pickup_requests`
--
ALTER TABLE `pickup_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pickup_requests_pickup_code_unique` (`pickup_code`),
  ADD KEY `pickup_requests_branch_id_foreign` (`branch_id`),
  ADD KEY `pickup_requests_customer_id_foreign` (`customer_id`),
  ADD KEY `pickup_requests_courier_id_foreign` (`courier_id`),
  ADD KEY `pickup_requests_assigned_by_foreign` (`assigned_by`),
  ADD KEY `pickup_requests_processed_by_foreign` (`processed_by`);

--
-- Indexes for table `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rates_origin_location_id_foreign` (`origin_location_id`),
  ADD KEY `rates_destination_location_id_foreign` (`destination_location_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shifts_user_id_foreign` (`user_id`),
  ADD KEY `shifts_branch_id_foreign` (`branch_id`),
  ADD KEY `shifts_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `shipments`
--
ALTER TABLE `shipments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shipments_tracking_number_unique` (`tracking_number`),
  ADD KEY `shipments_origin_location_id_foreign` (`origin_location_id`),
  ADD KEY `shipments_origin_subdistrict_id_foreign` (`origin_subdistrict_id`),
  ADD KEY `shipments_destination_location_id_foreign` (`destination_location_id`),
  ADD KEY `shipments_destination_subdistrict_id_foreign` (`destination_subdistrict_id`),
  ADD KEY `shipments_branch_id_foreign` (`branch_id`),
  ADD KEY `shipments_cashier_id_foreign` (`cashier_id`),
  ADD KEY `shipments_courier_id_foreign` (`courier_id`),
  ADD KEY `shipments_cod_received_by_foreign` (`cod_received_by`),
  ADD KEY `shipments_cod_courier_id_foreign` (`cod_courier_id`),
  ADD KEY `shipments_trip_id_foreign` (`trip_id`);

--
-- Indexes for table `shipment_trackings`
--
ALTER TABLE `shipment_trackings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipment_trackings_shipment_id_foreign` (`shipment_id`),
  ADD KEY `shipment_trackings_user_id_foreign` (`user_id`);

--
-- Indexes for table `subdistricts`
--
ALTER TABLE `subdistricts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subdistricts_location_id_foreign` (`location_id`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trips_courier_id_foreign` (`courier_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicles_license_plate_unique` (`license_plate`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cash_drawers`
--
ALTER TABLE `cash_drawers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `pickup_requests`
--
ALTER TABLE `pickup_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rates`
--
ALTER TABLE `rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shipments`
--
ALTER TABLE `shipments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `shipment_trackings`
--
ALTER TABLE `shipment_trackings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `subdistricts`
--
ALTER TABLE `subdistricts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cash_drawers`
--
ALTER TABLE `cash_drawers`
  ADD CONSTRAINT `cash_drawers_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `cash_drawers_closed_by_foreign` FOREIGN KEY (`closed_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_courier_id_foreign` FOREIGN KEY (`courier_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payments_received_by_foreign` FOREIGN KEY (`received_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payments_shipment_id_foreign` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pickup_requests`
--
ALTER TABLE `pickup_requests`
  ADD CONSTRAINT `pickup_requests_assigned_by_foreign` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pickup_requests_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `pickup_requests_courier_id_foreign` FOREIGN KEY (`courier_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pickup_requests_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pickup_requests_processed_by_foreign` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `rates`
--
ALTER TABLE `rates`
  ADD CONSTRAINT `rates_destination_location_id_foreign` FOREIGN KEY (`destination_location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rates_origin_location_id_foreign` FOREIGN KEY (`origin_location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shifts`
--
ALTER TABLE `shifts`
  ADD CONSTRAINT `shifts_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `shifts_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `shifts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `shipments`
--
ALTER TABLE `shipments`
  ADD CONSTRAINT `shipments_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `shipments_cashier_id_foreign` FOREIGN KEY (`cashier_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `shipments_cod_courier_id_foreign` FOREIGN KEY (`cod_courier_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `shipments_cod_received_by_foreign` FOREIGN KEY (`cod_received_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `shipments_courier_id_foreign` FOREIGN KEY (`courier_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `shipments_destination_location_id_foreign` FOREIGN KEY (`destination_location_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `shipments_destination_subdistrict_id_foreign` FOREIGN KEY (`destination_subdistrict_id`) REFERENCES `subdistricts` (`id`),
  ADD CONSTRAINT `shipments_origin_location_id_foreign` FOREIGN KEY (`origin_location_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `shipments_origin_subdistrict_id_foreign` FOREIGN KEY (`origin_subdistrict_id`) REFERENCES `subdistricts` (`id`),
  ADD CONSTRAINT `shipments_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `shipment_trackings`
--
ALTER TABLE `shipment_trackings`
  ADD CONSTRAINT `shipment_trackings_shipment_id_foreign` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shipment_trackings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `subdistricts`
--
ALTER TABLE `subdistricts`
  ADD CONSTRAINT `subdistricts_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `trips_courier_id_foreign` FOREIGN KEY (`courier_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
