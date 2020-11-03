-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2018 at 09:52 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lloyds_backend`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `view_all` tinyint(1) NOT NULL,
  `mode` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `view_all`, `mode`, `created_at`, `updated_at`) VALUES
(1, 'root', 1, 2, '2018-06-15 14:29:40', '2018-08-16 06:42:52');

-- --------------------------------------------------------

--
-- Table structure for table `role_routes`
--

CREATE TABLE `role_routes` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` smallint(5) UNSIGNED NOT NULL,
  `route` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `app_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_host` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_port` smallint(5) UNSIGNED DEFAULT NULL,
  `smtp_protocol` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_username` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_password` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `https` tinyint(1) NOT NULL,
  `timezone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UTC',
  `date_format` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_format` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_code` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_api_key` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_pass_len` tinyint(3) UNSIGNED NOT NULL,
  `jwt_secret_key` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jwt_expiration_time` int(10) UNSIGNED NOT NULL,
  `media_storage` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_visibility` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_upload_size` int(10) UNSIGNED NOT NULL,
  `thumb_width_landscape` smallint(5) UNSIGNED NOT NULL,
  `thumb_width_portrait` smallint(5) UNSIGNED NOT NULL,
  `image_filter` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_filter` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_active` tinyint(1) NOT NULL,
  `registration_role_id` smallint(5) UNSIGNED NOT NULL,
  `registration_api_role_id` smallint(5) UNSIGNED NOT NULL,
  `aws_access_key_id` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aws_secret_access_key` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aws_default_region` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aws_bucket_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aws_bucket_url` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `onesignal_rest_api_key` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `onesignal_user_auth_key` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `app_name`, `app_email`, `smtp_host`, `smtp_port`, `smtp_protocol`, `smtp_username`, `smtp_password`, `https`, `timezone`, `date_format`, `time_format`, `currency_code`, `google_api_key`, `min_pass_len`, `jwt_secret_key`, `jwt_expiration_time`, `media_storage`, `media_visibility`, `max_upload_size`, `thumb_width_landscape`, `thumb_width_portrait`, `image_filter`, `video_filter`, `registration_active`, `registration_role_id`, `registration_api_role_id`, `aws_access_key_id`, `aws_secret_access_key`, `aws_default_region`, `aws_bucket_name`, `aws_bucket_url`, `onesignal_rest_api_key`, `onesignal_user_auth_key`, `created_at`, `updated_at`) VALUES
(1, 'Lloyds Backend', 'info@lloyds-design.com', NULL, 587, 'tls', NULL, NULL, 0, 'Europe/Zagreb', 'd/m/Y', 'H:i', 'USD', NULL, 6, 'AIzaSyAEY983bUGJ5N-9GTOoXyRmMPetFDjfpzc', 525600, 'public', 'public', 10485760, 828, 414, 'jpg\r\njpeg\r\npng', 'mp4', 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-06-15 14:30:42', '2018-10-11 08:56:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `role_id` smallint(5) UNSIGNED NOT NULL,
  `timezone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UTC',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `active`, `role_id`, `timezone`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'ricardo', 'ricardo@lloyds.design', '$2y$10$KUSTcHqsjvdgpr2.mGfs6eFQVl0MHSTfnw5I7BCvOr2rBzZakkPgi', 1, 1, 'UTC', 'CCfT64E1qmu1uL3cYJFe4jRJkSgNXlPDbwwAFpHXa6wGhOS2smx5NGuQ7XeK', '2018-06-15 14:42:13', '2018-06-15 14:42:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_routes`
--
ALTER TABLE `role_routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role_routes`
--
ALTER TABLE `role_routes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
