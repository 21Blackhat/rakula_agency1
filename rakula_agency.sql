-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2026 at 08:44 AM
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
(1, 'main_org', 'about_main_org_1771162734_download (19).jpg', '2026-02-15 13:38:54'),
(2, 'office', 'about_office_1771162791_download (20).jpg', '2026-02-15 13:39:51'),
(3, 'fleet', 'about_fleet_1771250928_WhatsApp Image 2026-02-16 at 13.46.11 (7).jpeg', '2026-02-16 14:08:48'),
(4, 'location', 'about_location_1771163065_Baton Rouge - Coca-Cola UNITED.jpg', '2026-02-15 13:44:25');

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
(10, 'banners/hero_1771257111_215.jpg', 'image', '2026-02-16 15:51:51');

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
(9, '1771235352_mt kenya logo.webp', '2026-02-16 09:49:12');

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
(2, 'gallery/act_1771252047_698.jpeg', 'image', 'Distribution', '2026-02-16 14:27:27');

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
  `show_on_home` int(1) DEFAULT 0,
  `stock_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variations`
--

INSERT INTO `product_variations` (`id`, `brand_name`, `category_name`, `flavor_name`, `description`, `size_label`, `sort_value`, `price`, `image_path`, `image_path_2`, `show_on_home`, `stock_count`) VALUES
(1, 'Club Soda', NULL, 'pineapple', NULL, '1ltr', 0, 360.00, '1771224995_3646.jpg', NULL, 0, 0),
(3, 'Club Soda', NULL, 'Black Current', NULL, '500ml', 0, 480.00, '1771226737_3366.jpg', NULL, 1, 0),
(5, 'Club Soda', NULL, 'Black Current', 'Hey happy customer have you tested this amazing drink', '1ltr', 1, 480.00, '1771227648_6907.jpg', NULL, 0, 0),
(6, 'Highland Drinks', NULL, 'pineapple', '', '0.35ml', 0.35, 0.00, '1771242393_5152.jpg', NULL, 1, 0),
(8, 'Cordials', NULL, 'pineapple', 'A refreshing drink', '3ltr', 3, 0.00, '1771246098_1_bg1.jpg', '1771246098_2_bg1.jpg', 0, 0),
(9, 'Lato', NULL, 'fino', 'Best milk in the market now', '0.35ml', 0.35, 0.00, '1771250402_1_chocolate.jpg', '1771250402_2_chocolate.jpg', 0, 0);

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
(1, 555, '2026-02-17 07:04:11');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `brand_logos`
--
ALTER TABLE `brand_logos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `brand_products`
--
ALTER TABLE `brand_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_activities`
--
ALTER TABLE `gallery_activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
