-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2026 at 01:59 PM
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
-- Database: `rakula_agency`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_content`
--

CREATE TABLE `about_content` (
  `id` int(11) NOT NULL,
  `section_key` varchar(50) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_content`
--

INSERT INTO `about_content` (`id`, `section_key`, `image_path`, `updated_at`) VALUES
(1, 'main_org', 'about_main_org_1771342466_WhatsApp Image 2026-02-17 at 16.04.02.jpeg', '2026-02-17 15:34:26'),
(2, 'office', 'about_office_1771342414_WhatsApp Image 2026-02-17 at 15.58.22 (22).jpeg', '2026-02-17 15:33:34'),
(3, 'fleet', 'about_fleet_1771250928_WhatsApp Image 2026-02-16 at 13.46.11 (7).jpeg', '2026-02-16 14:08:48'),
(4, 'location', 'about_location_1771342569_WhatsApp Image 2026-02-17 at 18.37.07.jpeg', '2026-02-17 15:36:09');

-- --------------------------------------------------------

--
-- Table structure for table `banner_assets`
--

CREATE TABLE `banner_assets` (
  `id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banner_assets`
--

INSERT INTO `banner_assets` (`id`, `file_path`, `file_type`, `created_at`) VALUES
(2, 'banners/hero_1771239066_516.jpeg', 'image', '2026-02-16 10:51:06'),
(4, 'banners/hero_1771239094_165.jpeg', 'image', '2026-02-16 10:51:34'),
(7, 'banners/hero_1771255110_353.jpg', 'image', '2026-02-16 15:18:30'),
(9, 'banners/hero_1771257011_676.jpg', 'image', '2026-02-16 15:50:11'),
(10, 'banners/hero_1771257111_215.jpg', 'image', '2026-02-16 15:51:51'),
(11, 'banners/hero_1771370022_886.png', 'image', '2026-02-17 23:13:42');

-- --------------------------------------------------------

--
-- Table structure for table `brand_logos`
--

CREATE TABLE `brand_logos` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand_logos`
--

INSERT INTO `brand_logos` (`id`, `image_path`, `created_at`) VALUES
(7, '1771234660_highland logo.jpg', '2026-02-16 09:37:40'),
(8, '1771234995_kevian logo.jpg', '2026-02-16 09:43:15'),
(9, '1771235352_mt kenya logo.webp', '2026-02-16 09:49:12'),
(10, '1771368688_logo11.png', '2026-02-17 22:51:28');

-- --------------------------------------------------------

--
-- Table structure for table `brand_products`
--

CREATE TABLE `brand_products` (
  `id` int(11) NOT NULL,
  `category_brand` varchar(255) DEFAULT NULL,
  `flavor_name` varchar(255) DEFAULT NULL,
  `size_label` varchar(50) DEFAULT NULL,
  `primary_image` varchar(255) DEFAULT NULL,
  `secondary_image` varchar(255) DEFAULT NULL,
  `flavor_description` text DEFAULT NULL,
  `on_home` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_activities`
--

CREATE TABLE `gallery_activities` (
  `id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` enum('image','video') NOT NULL,
  `label` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_activities`
--

INSERT INTO `gallery_activities` (`id`, `file_path`, `file_type`, `label`, `created_at`) VALUES
(1, 'gallery/act_1771252013_986.jpeg', 'image', 'Logistics', '2026-02-16 14:26:53'),
(2, 'gallery/act_1771252047_698.jpeg', 'image', 'Distribution', '2026-02-16 14:27:27'),
(4, 'gallery/act_1771336123_781.jpeg', 'image', 'Warehouse', '2026-02-17 13:48:43'),
(5, 'gallery/act_1771336161_661.jpeg', 'image', 'Warehouse', '2026-02-17 13:49:21'),
(11, 'gallery/act_1771338574_696.jpeg', 'image', 'Distribution', '2026-02-17 14:29:34'),
(12, 'gallery/act_1771338972_884.jpeg', 'image', 'Logistics Team', '2026-02-17 14:36:12'),
(13, 'gallery/act_1771339045_383.jpeg', 'image', 'Packaging', '2026-02-17 14:37:25'),
(14, 'gallery/staff_1771339865.jpeg', 'image', 'Distribution Team', '2026-02-17 14:51:05');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `phone`, `location`, `total_amount`, `payment_method`, `status`, `created_at`) VALUES
(1, 1, 'Javers Tindi', '0740553475', 'Location Fee: 100', 400.00, 'mpesa', 'Delivered', '2026-02-15 10:47:29'),
(2, 1, 'Javers Tindi', '0740553475', 'Location Fee: 100', 250.00, 'mpesa', 'Delivered', '2026-02-15 11:02:38'),
(3, 0, 'Javers Tindi', '0740553475', 'Location Fee: 100', 400.00, 'cod', 'Delivered', '2026-02-15 14:25:18'),
(4, 0, 'Javers Tindi', '0740553475', 'Location Fee: 100', 100.00, 'cod', 'Delivered', '2026-02-15 14:25:31'),
(5, 1, 'Javers Tindi', '0740553475', 'Location Fee: 0', 710.00, 'cod', 'Delivered', '2026-02-15 19:19:34');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` enum('Milk','Water','Drink') NOT NULL,
  `stock_status` enum('In Stock','Out of Stock') DEFAULT 'In Stock'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `description`, `category`, `stock_status`) VALUES
(1, 'Highland water', 150.00, '500ml.jpg', NULL, 'Water', 'In Stock'),
(3, 'Mt Kenya milk', 560.00, 'bg.jpg', NULL, 'Milk', 'In Stock');

-- --------------------------------------------------------

--
-- Table structure for table `product_variations`
--

CREATE TABLE `product_variations` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(100) DEFAULT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `flavor_name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `size_label` varchar(20) DEFAULT NULL,
  `sort_value` float DEFAULT 0,
  `price` decimal(10,2) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image_path_2` varchar(255) DEFAULT NULL,
  `image_path_cover` varchar(255) DEFAULT NULL,
  `show_on_home` int(1) DEFAULT 0,
  `stock_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variations`
--

INSERT INTO `product_variations` (`id`, `brand_name`, `category_name`, `flavor_name`, `description`, `size_label`, `sort_value`, `price`, `image_path`, `image_path_2`, `image_path_cover`, `show_on_home`, `stock_count`) VALUES
(1, 'Club Soda', NULL, 'pineapple', NULL, '1ltr', 0, 360.00, '1771224995_3646.jpg', NULL, NULL, 0, 0),
(3, 'Club Soda', NULL, 'Black Current', NULL, '500ml', 0, 480.00, '1771226737_3366.jpg', NULL, NULL, 1, 0),
(5, 'Club Soda', NULL, 'Black Current', 'Hey happy customer have you tested this amazing drink', '1ltr', 1, 480.00, '1771227648_6907.jpg', NULL, NULL, 0, 0),
(6, 'Highland Drinks', NULL, 'pineapple', '', '0.35ml', 0.35, 0.00, '1771242393_5152.jpg', NULL, NULL, 1, 0),
(8, 'Cordials', NULL, 'pineapple', 'A refreshing drink', '3ltr', 3, 0.00, '1771246098_1_bg1.jpg', '1771246098_2_bg1.jpg', NULL, 0, 0),
(9, 'Lato', NULL, 'fino', 'Best milk in the market now', '0.35ml', 0.35, 0.00, '1771250402_1_chocolate.jpg', '1771250402_2_chocolate.jpg', NULL, 0, 0),
(10, 'Club Soda', NULL, 'pineapple', 'we bring the best for you!!!!', NULL, 0, 0.00, '1771334197_1_WhatsApp Image 2026-02-17 at 16.03.20 (13).jpeg', '1771334197_2_WhatsApp Image 2026-02-17 at 15.58.22 (4).jpeg', 'cover_1771334197_WhatsApp Image 2026-02-17 at 15.58.22 (20).jpeg', 1, 0),
(12, 'Kevian', NULL, 'Afia', 'Afia drink', NULL, 0, 0.00, '1771340066_1_WhatsApp Image 2026-02-17 at 16.03.19 (1).jpeg', '1771340066_2_WhatsApp Image 2026-02-17 at 16.03.19 (1).jpeg', 'cover_1771340066_WhatsApp Image 2026-02-17 at 16.03.19 (1).jpeg', 0, 0),
(14, 'Kevian', NULL, 'afia', 'hello', NULL, 0, 0.00, '1771340697_1_WhatsApp Image 2026-02-17 at 15.58.22 (1).jpeg', '1771340697_2_WhatsApp Image 2026-02-17 at 15.58.22 (3).jpeg', 'cover_1771340697_WhatsApp Image 2026-02-17 at 15.58.19.jpeg', 0, 0),
(15, 'Kevian', NULL, 'afia', 'hello', NULL, 0, 0.00, '1771340948_1_WhatsApp Image 2026-02-17 at 15.58.19.jpeg', '1771340948_2_WhatsApp Image 2026-02-17 at 15.58.19.jpeg', 'cover_1771340948_WhatsApp Image 2026-02-17 at 15.58.19.jpeg', 0, 0),
(16, 'Lato', NULL, 'fino', 'cool', NULL, 0, 0.00, '1771341227_1_WhatsApp Image 2026-02-17 at 16.03.20 (14).jpeg', '1771341227_2_WhatsApp Image 2026-02-17 at 16.03.20 (15).jpeg', 'cover_1771341227_WhatsApp Image 2026-02-17 at 15.58.22 (16).jpeg', 0, 0),
(17, 'Mt Kenya', NULL, 'dairy joy', 'wow', NULL, 0, 0.00, '1771341463_1_WhatsApp Image 2026-02-17 at 15.58.22 (9).jpeg', '1771341463_2_WhatsApp Image 2026-02-17 at 15.58.22 (13).jpeg', 'cover_1771341463_WhatsApp Image 2026-02-17 at 15.58.22 (3).jpeg', 0, 0),
(18, 'Azam', NULL, 'azam', 'yes its sweet!!', NULL, 0, 0.00, '1771341724_1_WhatsApp Image 2026-02-17 at 15.58.22 (9).jpeg', '1771341724_2_WhatsApp Image 2026-02-17 at 15.58.22 (12).jpeg', 'cover_1771341724_WhatsApp Image 2026-02-17 at 15.58.22 (14).jpeg', 0, 0),
(19, 'Coastal Bottlers', NULL, 'cola', 'taste good', NULL, 0, 0.00, '1771342016_1_WhatsApp Image 2026-02-17 at 15.58.22 (6).jpeg', '1771342016_2_WhatsApp Image 2026-02-17 at 15.58.22 (14).jpeg', 'cover_1771342016_WhatsApp Video 2026-02-17 at 16.03.20 (1).mp4', 0, 0),
(20, 'Coastal Bottlers', NULL, 'predator', 'wow', NULL, 0, 0.00, '1771342115_1_WhatsApp Image 2026-02-17 at 15.58.22 (6).jpeg', '1771342115_2_WhatsApp Image 2026-02-17 at 15.58.22 (2).jpeg', 'cover_1771342115_WhatsApp Image 2026-02-17 at 15.58.22 (12).jpeg', 0, 0),
(21, 'Bounty Limited', NULL, 'lemonade', 'hey', NULL, 0, 0.00, '1771416519_1_lemonade.png', '1771416519_2_lemonade.png', 'cover_1771416519_lemonade.png', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `site_content`
--

CREATE TABLE `site_content` (
  `content_key` varchar(50) NOT NULL,
  `content_value` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_content`
--

INSERT INTO `site_content` (`content_key`, `content_value`, `updated_at`) VALUES
('about_text', 'Rakula Agency is a premier provider of highland water and premium milk.', '2026-02-15 11:15:15'),
('explore_title', 'Our Refreshing Selection', '2026-02-15 11:15:15');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(50) DEFAULT NULL,
  `setting_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`) VALUES
(1, 'staff_logistics', 'about_fleet_default.jpg'),
(2, 'staff_admin', 'about_office_default.jpg'),
(3, 'staff_distribution', 'gallery/staff_1771339865.jpeg'),
(4, 'staff_bounty', 'about_bounty_default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `site_stats`
--

CREATE TABLE `site_stats` (
  `id` int(11) NOT NULL,
  `page_views` int(11) DEFAULT 0,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_stats`
--

INSERT INTO `site_stats` (`id`, `page_views`, `last_updated`) VALUES
(1, 946, '2026-02-18 12:14:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `reset_token` varchar(6) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `reset_token`, `token_expiry`) VALUES
(1, 'javers', 'javerstindi851@gmail.com', 'javers75', 'user', NULL, NULL),
(2, 'Rakula Admin', 'admin@rakula.com', 'admin123', 'admin', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_content`
--
ALTER TABLE `about_content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section_key` (`section_key`);

--
-- Indexes for table `banner_assets`
--
ALTER TABLE `banner_assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand_logos`
--
ALTER TABLE `brand_logos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand_products`
--
ALTER TABLE `brand_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_activities`
--
ALTER TABLE `gallery_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_content`
--
ALTER TABLE `site_content`
  ADD PRIMARY KEY (`content_key`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `site_stats`
--
ALTER TABLE `site_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_content`
--
ALTER TABLE `about_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `banner_assets`
--
ALTER TABLE `banner_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `brand_logos`
--
ALTER TABLE `brand_logos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `brand_products`
--
ALTER TABLE `brand_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_activities`
--
ALTER TABLE `gallery_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_variations`
--
ALTER TABLE `product_variations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
