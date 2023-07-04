-- phpMyAdmin SQL Dump
-- version 4.9.10
-- https://www.phpmyadmin.net/
--
-- Host: db5007562347.hosting-data.io
-- Generation Time: May 17, 2022 at 01:18 PM
-- Server version: 5.7.38-log
-- PHP Version: 7.0.33-0+deb9u12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbs6237366`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(500) NOT NULL,
  `picture` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `picture`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN AA', 'admin@admin.com', 'e10adc3949ba59abbe56e057f20f883e', '1651914025_user1-128x128.jpg', 1, '2021-04-03 11:43:42', '2022-05-07 09:00:26');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `building_no` varchar(255) NOT NULL,
  `order_no` varchar(255) NOT NULL,
  `invoice_id` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` double(10,2) NOT NULL,
  `total_paid` double(10,2) NOT NULL,
  `transfer_amount` double(10,2) NOT NULL,
  `net_amount` double(10,2) NOT NULL,
  `invoice_url` text,
  `status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `vendor_id` int(255) DEFAULT NULL,
  `invoice_id` int(11) NOT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `amount` double(10,2) DEFAULT NULL,
  `transfer_amount` double(10,2) NOT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` text NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `copyright` varchar(500) NOT NULL,
  `stripe_mode` enum('development','live') NOT NULL DEFAULT 'development',
  `stripe_publish_key` varchar(500) DEFAULT NULL,
  `stripe_secret_key` varchar(500) DEFAULT NULL,
  `stripe_webhook_key` varchar(500) DEFAULT NULL,
  `plaid_environment` enum('production','development','sandbox') NOT NULL DEFAULT 'development',
  `plaid_client_id` varchar(500) DEFAULT NULL,
  `plaid_client_secret` varchar(500) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `email`, `description`, `keywords`, `copyright`, `stripe_mode`, `stripe_publish_key`, `stripe_secret_key`, `stripe_webhook_key`, `plaid_environment`, `plaid_client_id`, `plaid_client_secret`, `updated_at`) VALUES
(1, 'VRM', 'admin@newgents.com', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\n', 'lorem,ipsum,dolor\r\n', 'copyright 2022 @newgents.com', 'live', 'pk_live_51Kk5v6DD8ZpzDT6QAANcEd6ZS29RasJz9oQHMx4CzXHheBavEqN0T1WXTIS4aBoG3NP98aUNL7RUrg1VMYnr8fuc00k7282w37', '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', 'whsec_iwBj84tARJTj9sh8mL3Zbmqd6lVVA0XS', 'sandbox', '', '', '2022-05-17 09:15:33');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(500) NOT NULL,
  `picture` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `reference_account_id` varchar(500) DEFAULT NULL,
  `reference_account_status` tinyint(1) NOT NULL DEFAULT '0',
  `percentage` float(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `email`, `password`, `picture`, `status`, `reference_account_id`, `reference_account_status`, `percentage`, `created_at`, `updated_at`) VALUES
(1, 'Johnny Guerrero', 'jguerrero3079@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1652721611_super.jpg', 1, NULL, 0, 80.00, '2022-05-16 17:20:11', '2022-05-16 17:20:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
