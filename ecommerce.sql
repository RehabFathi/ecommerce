-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2022 at 09:25 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `addersses`
--

CREATE TABLE `addersses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `street` varchar(100) NOT NULL,
  `building` varchar(100) NOT NULL,
  `floor` varchar(100) NOT NULL,
  `flat_number` varchar(100) NOT NULL,
  `notes` text NOT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT '0=> active 1=>not active ',
  `region_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `addersses`
--

INSERT INTO `addersses` (`id`, `street`, `building`, `floor`, `flat_number`, `notes`, `status`, `region_id`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 'go', '1', '2', '3', 'good', 1, 4, 1, '2021-11-26 23:04:23', '2021-11-26 23:04:23'),
(4, 'jh;', 'hvfu', 'mm', '7', '1', 1, 4, 119, '2021-11-26 23:04:23', '2021-11-26 23:04:23'),
(5, 'sdf', 'dsaf', 'dzfs', 'sdfsaf', 'asfd', 1, 4, 119, '2021-11-26 23:04:23', '2021-11-26 23:04:23'),
(23, ' nnnn', '1', '3', '3', 'sss', 1, 4, 119, '2022-03-07 21:21:14', '2022-03-07 21:21:14'),
(24, ' ggggg ', '1', '2', '2', '', 1, 5, 119, '2022-03-07 21:35:33', '2022-03-07 21:35:33'),
(25, 'jjj', '1', '1', '1', 'aaa', 1, 5, 119, '2022-03-07 21:37:18', '2022-03-07 21:37:18');

-- --------------------------------------------------------

--
-- Stand-in structure for view `addressdtails`
-- (See below for the actual view)
--
CREATE TABLE `addressdtails` (
`id` bigint(20) unsigned
,`street` varchar(100)
,`building` varchar(100)
,`floor` varchar(100)
,`flat_number` varchar(100)
,`notes` text
,`status` tinyint(1)
,`region_id` bigint(20) unsigned
,`user_id` bigint(20) unsigned
,`created_at` timestamp
,`updated_at` timestamp
,`region name_en` varchar(100)
,`city name_en` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(100) NOT NULL,
  `name_ar` varchar(100) NOT NULL,
  `image` varchar(50) NOT NULL DEFAULT 'default.png',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=> active 1 => not active',
  `ceated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name_en`, `name_ar`, `image`, `status`, `ceated_at`, `updated_at`) VALUES
(1, 'apple', 'iphone', 'default.png', 1, '2021-11-19 13:37:54', '2021-11-27 23:27:09'),
(2, 'lenovo', 'لينوفو', 'default.png', 1, '2021-11-19 13:37:54', '2021-11-27 23:27:16'),
(3, 'samsung', 'samsung', 'default.png', 1, '2021-11-19 13:39:55', '2021-11-27 23:27:26'),
(4, 'oppo', 'oppo', 'default.png', 1, '2021-11-19 13:39:55', '2021-11-27 23:27:37');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`user_id`, `product_id`, `quantity`) VALUES
(71, 46, 2),
(119, 45, 5),
(119, 47, 3);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(100) NOT NULL,
  `name_ar` varchar(100) NOT NULL,
  `image` varchar(50) NOT NULL DEFAULT 'default.png',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=> active 0=> not active',
  `ceated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name_en`, `name_ar`, `image`, `status`, `ceated_at`, `updated_at`) VALUES
(10, 'electronic ', 'كهرباء', 'default.png', 1, '2021-11-19 13:42:35', '2022-02-23 21:31:08'),
(11, 'foods', 'طعام', 'default.png', 1, '2021-11-19 13:42:35', '2021-11-24 15:51:22'),
(14, 'ckechen', 'مطبخ', 'default.png', 1, '2022-02-23 21:28:32', '2022-02-23 21:28:32');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(100) NOT NULL,
  `name_ar` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=>not active 1=> active',
  `lat` float UNSIGNED NOT NULL,
  `long` float UNSIGNED NOT NULL,
  `distance` decimal(20,10) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name_en`, `name_ar`, `status`, `lat`, `long`, `distance`, `updated_at`, `created_at`) VALUES
(1, 'cairo', 'القاهرة', 1, 23567, 4587, '5678.0000000000', '2021-11-26 22:57:47', '2021-11-26 22:57:47'),
(2, 'alex', 'الاسكندرية', 1, 7898900, 34678900, '245678.0000000000', '2022-02-25 15:56:47', '2022-02-25 13:39:50');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) NOT NULL,
  `discount` decimal(8,2) DEFAULT NULL,
  `discount_type` varchar(100) NOT NULL,
  `min_order_price` decimal(8,2) NOT NULL,
  `count_per_users` int(255) NOT NULL,
  `count_per_coupons` int(255) NOT NULL,
  `starte_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `end_time` timestamp NULL DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `coupons_users`
--

CREATE TABLE `coupons_users` (
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title_en` varchar(100) NOT NULL,
  `title_ar` varchar(100) NOT NULL,
  `des_en` text NOT NULL,
  `des_ar` text NOT NULL,
  `image` varchar(50) NOT NULL DEFAULT 'default.png',
  `discount` decimal(6,0) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `end_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `offers_products`
--

CREATE TABLE `offers_products` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `offer_id` bigint(20) UNSIGNED NOT NULL,
  `price_after_offer` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `total_price` decimal(8,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `deliver_data` varchar(1000) NOT NULL,
  `coupon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `address_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `total_price`, `status`, `deliver_data`, `coupon_id`, `address_id`, `created_at`, `updated_at`) VALUES
(7, '10000.00', 1, '1/12', NULL, 5, '2021-11-26 23:08:27', '2021-11-26 23:08:27'),
(10, '60000.00', 1, 'saf', NULL, 5, '2021-11-26 23:08:27', '2021-11-26 23:08:27'),
(20, '15000.00', 1, 'ds', NULL, 3, '2021-11-26 23:13:03', '2021-11-26 23:13:03'),
(21, '25000.00', 1, 'sd', NULL, 4, '2021-11-26 23:13:25', '2021-11-26 23:13:25');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('r.fathielhoty274@gmail.com', '$2y$10$HxjK7jMrEEkrm171GhVmc.vEVyRkf6f80RNubcAjowINfrw.C/q1m', '2021-12-03 02:30:03');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text NOT NULL,
  `last_used_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Stand-in structure for view `productdetails`
-- (See below for the actual view)
--
CREATE TABLE `productdetails` (
`id` bigint(20) unsigned
,`name_en` varchar(100)
,`name_ar` varchar(100)
,`desc_en` text
,`desc_ar` text
,`status` tinyint(1)
,`code` varchar(100)
,`price` decimal(7,2)
,`image` varchar(50)
,`quantity` smallint(3)
,`brand_id` bigint(20) unsigned
,`subcategory_id` bigint(20) unsigned
,`created_at` timestamp
,`updated_at` timestamp
,`subcategory_name_en` varchar(100)
,`category_name_en` varchar(100)
,`category_id` bigint(20) unsigned
,`brand_name_en` varchar(100)
,`count_review` bigint(21)
,`avg_review` decimal(4,0)
);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(100) NOT NULL,
  `name_ar` varchar(100) NOT NULL,
  `desc_en` text NOT NULL,
  `desc_ar` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=>not active 1 => active 2 =>waiting',
  `code` varchar(100) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `image` varchar(50) NOT NULL DEFAULT 'default.png',
  `quantity` smallint(3) NOT NULL DEFAULT 1,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subcategory_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name_en`, `name_ar`, `desc_en`, `desc_ar`, `status`, `code`, `price`, `image`, `quantity`, `brand_id`, `subcategory_id`, `created_at`, `updated_at`) VALUES
(40, 'labtop lenovo', 'لاب لينوفو', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. A sequi maxime dolore est sunt fugit modi!', 'الداخلية بصفته الرئيس الاعلي للإدارة العامة للمرور ويعلن بهيئة قضايا الدولة        ', 1, '12345', '8000.00', 'lenovo.jpeg', 20, 2, 11, '2021-11-25 01:04:32', '2021-11-25 01:04:32'),
(41, 'laptop mac', 'لابتوب ماك', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. A sequi maxime dolore est sunt fugit modi!', 'الداخلية بصفته الرئيس الاعلي للإدارة العامة للمرور ويعلن بهيئة قضايا الدولة        ', 1, '4678t', '20000.00', 'mac.jpeg', 2, 1, 11, '2021-11-25 01:04:32', '2022-03-10 06:57:12'),
(45, 'iphone12', 'ايفون 12', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. A sequi maxime dolore est sunt fugit modi!', 'الداخلية بصفته الرئيس الاعلي للإدارة العامة للمرور ويعلن بهيئة قضايا الدولة ', 1, 'hhhg67', '25000.00', 'iphone12.jpeg', 4, 1, 12, '2021-11-25 01:13:51', '2022-03-11 16:38:34'),
(46, 'dates', 'تمر ', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. A sequi maxime dolore est sunt fugit modi!', 'الداخلية بصفته الرئيس الاعلي للإدارة العامة للمرور ويعلن بهيئة قضايا الدولة        ', 1, 'ggg5687', '200.00', 'dates.jpeg', 1000, NULL, 14, '2021-11-25 01:17:34', '2021-11-25 01:17:34'),
(47, 'chipsy', 'شبسي', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. A sequi maxime dolore est sunt fugit modi!', 'الداخلية بصفته الرئيس الاعلي للإدارة العامة للمرور ويعلن بهيئة قضايا الدولة   ', 1, 'fff976', '10.00', 'chipsy.jpeg', 1000, NULL, 13, '2021-11-25 01:17:34', '2021-11-26 13:54:15'),
(48, 'samsung A50', 'سامسونج A50', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. A sequi maxime dolore est sunt fugit modi!', 'الداخلية بصفته الرئيس الاعلي للإدارة العامة للمرور ويعلن بهيئة قضايا الدولة   ', 1, 'gff886', '5000.00', 'samsungA50.jpeg', 6, 3, 12, '2021-11-25 01:21:10', '2021-11-25 01:21:10'),
(49, 'samsung A20', 'سامسونج A20', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. A sequi maxime dolore est sunt fugit modi!', 'الداخلية بصفته الرئيس الاعلي للإدارة العامة للمرور ويعلن بهيئة قضايا الدولة   ', 1, 'hgg87656', '4500.00', 'samsungA20.jpeg', 4, 3, 12, '2021-11-25 01:21:10', '2021-11-25 01:21:10'),
(58, 'tomatoes', 'طماطم', '', 'لداخلية بصفته الرئيس الاعلي للإدارة العامة للمرور ويعلن بهيئة قضايا الدولة ', 0, 'لvnkj7', '100.00', 'tomatoes.jpeg', 1000, NULL, 14, '2021-11-25 01:29:01', '2021-11-26 13:54:31'),
(59, 'chesse', 'جبن', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. A sequi maxime dolore est sunt fugit modi!', 'لداخلية بصفته الرئيس الاعلي للإدارة العامة للمرور ويعلن بهيئة قضايا الدولة ', 1, 'vghhjj7', '200.00', 'cheese.jpeg', 1, NULL, 13, '2021-11-25 01:29:01', '2021-11-25 13:37:01'),
(60, 'lab thinlpad', 'لابتوب thinlpad', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. A sequi maxime dolore est sunt fugit modi!', 'الداخلية بصفته الرئيس الاعلي للإدارة العامة للمرور ويعلن بهيئة قضايا الدولة   ', 1, '6655tr', '10000.00', 'thinkpad.jpeg', 1, NULL, 11, '2021-11-25 01:30:54', '2021-11-26 14:59:00'),
(63, 'laptop mac', 'لابتوب ماك', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. A sequi maxime dolore est sunt fugit modi!', 'الداخلية بصفته الرئيس الاعلي للإدارة العامة للمرور ويعلن بهيئة قضايا الدولة ', 1, '467833t', '20000.00', 'mac.jpg', 160, 1, 11, '2021-11-25 01:30:32', '2022-03-11 08:24:03'),
(64, 'oppo A51', 'oppo A51', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. A sequi maxime dolore est sunt fugit modi!', 'الداخلية بصفته الرئيس الاعلي للإدارة العامة للمرور ويعلن بهيئة قضايا الدولة ', 1, 'hht77', '5000.00', 'oppoA51.jpeg', 100, 4, 12, '2021-11-25 01:35:28', '2021-11-25 13:42:26'),
(73, 'ssss', 'xxx', 'sss', 'ssxx', 0, 'ddd', '1111.00', '1638314640.jpg', 333, 2, 11, '2021-11-30 23:24:01', '2021-12-03 09:16:36'),
(75, 'rrr', 'xxx', 'ssssdds', 'ssxx', 0, '1638314753', '1111.00', '1638314753.jpg', 333, 2, 11, '2021-11-30 23:25:54', '2021-11-30 23:25:54'),
(76, 'rrrdsdd', 'xxx', 'ssssdds', 'ssxx', 1, '1638314759', '1111.00', 't.jpg', 333, 2, 11, '2021-11-30 23:25:59', '2022-03-11 09:32:28'),
(77, 'rrrdsdd', 'xxxdde', 'ssssdds', 'ssxx', 2, '1638314765', '8888.00', '1638314765.jpg', 333, 2, 11, '2021-11-30 23:26:05', '2021-12-03 09:05:57'),
(79, 'sss', 'www', 'ss', 'ss', 1, '211201.labtops-1638389196', '9999.00', 'x.jpg', 22, 2, 12, '2021-12-01 20:06:36', '2022-03-11 09:28:16'),
(80, 'bbb', 'bb', 'xxx', 'ccc', 2, '211201.labtops-1638389265', '11.00', '1638389265.jpg', 11, 2, 11, '2021-12-01 20:07:45', '2021-12-01 20:44:46'),
(81, 'ltttt', 'hhh', 'hhhh', 'hhh', 0, '211201.labtops-1638389746', '20000.00', '1638389746.jpg', 99, 1, 12, '2021-12-01 20:15:46', '2022-03-08 16:00:54');

-- --------------------------------------------------------

--
-- Table structure for table `products_orders`
--

CREATE TABLE `products_orders` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `price_after_order` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products_orders`
--

INSERT INTO `products_orders` (`product_id`, `order_id`, `price_after_order`) VALUES
(40, 7, '15000.00'),
(40, 20, '15000.00'),
(41, 7, '999999.99'),
(41, 20, '50000.00'),
(41, 21, '9000.00'),
(46, 10, '2000.00'),
(46, 20, '30000.00'),
(47, 7, '15000.00'),
(59, 20, '68909.00'),
(60, 7, '6578.00'),
(60, 21, '5000.00'),
(63, 10, '768909.00');

-- --------------------------------------------------------

--
-- Table structure for table `product_spec`
--

CREATE TABLE `product_spec` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `spec_id` bigint(20) UNSIGNED NOT NULL,
  `spec_value` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_spec`
--

INSERT INTO `product_spec` (`product_id`, `spec_id`, `spec_value`) VALUES
(45, 1, '8 g.byte'),
(60, 2, '1000g.b'),
(60, 3, 'gray'),
(63, 2, '500 g.b'),
(64, 1, '6 g.byte');

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(100) NOT NULL,
  `name_ar` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=> not active 1=> active',
  `lat` float UNSIGNED NOT NULL,
  `long` float UNSIGNED NOT NULL,
  `distance` float UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `name_en`, `name_ar`, `status`, `lat`, `long`, `distance`, `city_id`, `created_at`, `updated_at`) VALUES
(4, 'hggf', 'سسس', 1, 23567, 4587, 5678, 1, '2021-11-26 22:59:42', '2021-11-26 22:59:42'),
(5, 'adas', 'سبيليث', 1, 1111, 224235, 2143340, 2, '2021-11-26 22:59:42', '2022-02-25 15:59:03'),
(6, 'nasr city', 'مدينة نصر ', 1, 4567900, 6778910, 567880000, 1, '2022-02-25 13:31:31', '2022-02-25 13:31:31');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment` varchar(1000) DEFAULT NULL,
  `value` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`product_id`, `user_id`, `comment`, `value`, `created_at`, `updated_at`) VALUES
(41, 70, '', 5, '2021-11-26 22:19:45', '2021-11-27 12:51:19'),
(41, 71, 'dba', 4, '2021-11-26 22:19:45', '2021-11-27 12:52:54'),
(41, 119, 'ggg', 0, '2021-11-26 22:19:45', '2022-03-10 17:36:45'),
(45, 7, '', 4, '2021-11-26 22:19:45', '2021-11-27 12:53:09'),
(45, 71, 'sss', 4, '2021-11-27 12:49:15', '2021-11-27 12:49:15'),
(60, 8, 'jjj', 5, '2021-10-26 22:19:45', '2022-03-10 13:29:00'),
(60, 38, 'gg', 3, '2021-11-25 22:19:45', '2022-02-10 13:29:12'),
(60, 66, '', 3, '2021-11-19 22:19:45', '2022-03-10 13:29:23'),
(60, 119, '', 3, '2022-03-11 06:35:58', '2022-03-11 06:35:58');

-- --------------------------------------------------------

--
-- Table structure for table `spec`
--

CREATE TABLE `spec` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `spec_en` varchar(1000) NOT NULL,
  `spec_ar` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `spec`
--

INSERT INTO `spec` (`id`, `spec_en`, `spec_ar`) VALUES
(1, 'storage', 'ذاكؤة داخلية'),
(2, 'ram', 'ذاكرة مؤقته'),
(3, 'color', 'اللون');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(100) NOT NULL,
  `name_ar` varchar(100) NOT NULL,
  `image` varchar(50) NOT NULL DEFAULT 'default.png',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=> not active 1=> active',
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `name_en`, `name_ar`, `image`, `status`, `category_id`, `created_at`, `updated_at`) VALUES
(11, 'labtops', 'لابتوب', 'default.png', 1, 10, '2021-11-24 23:40:02', '2021-11-24 23:40:02'),
(12, 'smart phone', 'هواتف زكية', 'default.png', 1, 10, '2021-11-24 23:40:02', '2021-11-24 23:40:02'),
(13, 'canned food', ' معلبات', 'default.png', 1, 11, '2021-11-24 23:42:37', '2021-11-24 23:42:37'),
(14, 'vegetables', 'خضروات', 'default.png', 1, 11, '2021-11-24 23:42:37', '2021-11-24 23:42:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `frist_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `code` int(5) DEFAULT NULL,
  `gender` enum('M','F') DEFAULT NULL,
  `image` varchar(50) DEFAULT 'default.png',
  `status` tinyint(1) DEFAULT 0 COMMENT '0=> NOT ACTIVE 1=> ACTIVE ',
  `remember_token` varchar(100) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `frist_name`, `last_name`, `email`, `password`, `phone`, `code`, `gender`, `image`, `status`, `remember_token`, `email_verified_at`, `created_at`, `updated_at`) VALUES
(1, 'mohamed', 'ahmed', 'mohmed@gmail.com', '123456', '0987655543', 1234, 'M', 'default.png', 1, NULL, '0000-00-00 00:00:00', '2021-11-19 00:59:29', '2021-11-23 22:57:37'),
(7, 'mohmed', 'ahmed', 'mohmedah@gmail.com', '543113', '345678', NULL, 'M', 'default.png', 0, NULL, NULL, '2021-11-19 19:05:47', '2021-11-19 19:05:47'),
(8, 'rehab', 'fathi', 'refab@gamil.com', '09877665', '0998877665', 12345, 'F', 'default.png', 1, NULL, NULL, '2021-11-19 19:05:47', '2021-11-19 19:05:47'),
(10, 'ahmed', 'mohammed', 'monaaa@gmail.com', 'be512884ee13c787a366803a846f0da208daf562', '09876555431', 335460, '', 'default.png', 0, NULL, NULL, '2021-11-22 18:08:09', '2021-11-22 18:08:09'),
(38, '', '', 'mohammed@gmaigfgtyl.com', 'edf4fb2c3332526ab1c7467016c26997ff15dc84', '09876555432', 832561, '', 'default.png', 0, NULL, NULL, '2021-11-23 15:43:17', '2021-11-23 15:43:17'),
(66, 'modamed', 'ffff', 'mona1@gmail.com', '72d3ca73179152ff8b163e6a44c2b15ec1936880', '111111', 452527, '', 'default.png', 0, NULL, NULL, '2021-11-23 17:09:34', '2022-02-07 20:35:04'),
(68, 'ahmed', 'ffff', 'mohamed22@gmail.com', 'cdbd24975bc4ebeab577da3d3be96832e91efc1a', '09876555430', 158585, '', 'default.png', 0, NULL, NULL, '2021-11-23 17:13:34', '2021-11-23 17:13:34'),
(70, '', '', 'ahmed223@gmail.com', '02afac31e04d396ee5b97f5597dc8557712c7a35', '432222', 751608, '', 'default.png', 0, NULL, NULL, '2021-11-23 17:15:24', '2021-11-23 17:15:24'),
(71, '', '', 'ahmed99@gmail.com', '9cc97e60f86a15b75e6e2d1e970f308939811260', '5555', 977748, '', 'default.png', 0, NULL, NULL, '2021-11-23 17:16:37', '2021-11-23 17:16:37'),
(82, '', '', 'mona2@gmail.com', 'a748dc102218026325911725a9d4775708a5a0a9', '01032517608', 134419, '', 'default.png', 1, NULL, '2021-11-24 10:07:18', '2021-11-23 20:31:29', '2021-11-23 23:07:18'),
(97, '', '', 'mohame55d@gmail.com', '61c53bc4e0498bb432bb339b1411f70ecd4512c2', '01025166760', 839588, '', 'default.png', 0, NULL, NULL, '2021-11-24 14:52:58', '2021-11-24 14:52:58'),
(100, 'mohamed', 'ahmed', 'mohmed22@gmail.com', 'Rehab@12345', '11111111111', 850395, 'M', 'default.png', 0, NULL, NULL, '2021-12-02 23:36:57', '2021-12-02 23:36:57'),
(105, 'Mona1', '', 'r.fathielhoty4@gmail.com', '73aea9b051059b6444652dae06e72508e43fae2d', '01025106081', 68880, 'M', 'default.png', 1, NULL, '2022-02-15 07:17:45', '2021-12-02 23:59:17', '2022-02-16 06:48:06'),
(106, 'ahmed', 'mohammed', 'Ahmedmo@gmail.com', '@Rehab1234', '09087650043', 95622, 'M', 'default.png', 1, NULL, '2022-02-08 20:57:23', '2022-02-06 22:54:35', '2022-02-15 07:14:28'),
(119, 'Rehab', 'Fathi', 'r.fathielhoty274@gmail.com', '73aea9b051059b6444652dae06e72508e43fae2d', '01025176081', 99512, 'F', 'default.png', 1, NULL, '2022-02-18 14:33:00', '2022-02-10 14:48:16', '2022-02-18 14:44:33');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`product_id`, `user_id`) VALUES
(48, 8),
(48, 10),
(48, 40),
(48, 71),
(60, 1),
(60, 7),
(63, 7),
(63, 8),
(63, 10);

-- --------------------------------------------------------

--
-- Structure for view `addressdtails`
--
DROP TABLE IF EXISTS `addressdtails`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `addressdtails`  AS   (select `addersses`.`id` AS `id`,`addersses`.`street` AS `street`,`addersses`.`building` AS `building`,`addersses`.`floor` AS `floor`,`addersses`.`flat_number` AS `flat_number`,`addersses`.`notes` AS `notes`,`addersses`.`status` AS `status`,`addersses`.`region_id` AS `region_id`,`addersses`.`user_id` AS `user_id`,`addersses`.`created_at` AS `created_at`,`addersses`.`updated_at` AS `updated_at`,`regions`.`name_en` AS `region name_en`,`cities`.`name_en` AS `city name_en` from (`cities` left join (`regions` left join `addersses` on(`regions`.`id` = `addersses`.`region_id`)) on(`cities`.`id` = `regions`.`city_id`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `productdetails`
--
DROP TABLE IF EXISTS `productdetails`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `productdetails`  AS SELECT `products`.`id` AS `id`, `products`.`name_en` AS `name_en`, `products`.`name_ar` AS `name_ar`, `products`.`desc_en` AS `desc_en`, `products`.`desc_ar` AS `desc_ar`, `products`.`status` AS `status`, `products`.`code` AS `code`, `products`.`price` AS `price`, `products`.`image` AS `image`, `products`.`quantity` AS `quantity`, `products`.`brand_id` AS `brand_id`, `products`.`subcategory_id` AS `subcategory_id`, `products`.`created_at` AS `created_at`, `products`.`updated_at` AS `updated_at`, `subcategories`.`name_en` AS `subcategory_name_en`, `categories`.`name_en` AS `category_name_en`, `categories`.`id` AS `category_id`, `brands`.`name_en` AS `brand_name_en`, count(`reviews`.`product_id`) AS `count_review`, round(if(avg(`reviews`.`value`) is null,0,avg(`reviews`.`value`)),0) AS `avg_review` FROM (((`categories` left join (`subcategories` left join `products` on(`subcategories`.`id` = `products`.`subcategory_id`)) on(`categories`.`id` = `subcategories`.`category_id`)) left join `brands` on(`brands`.`id` = `products`.`brand_id`)) left join `reviews` on(`reviews`.`product_id` = `products`.`id`)) GROUP BY `products`.`id` ORDER BY `products`.`price` ASC, `products`.`name_en` ASC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addersses`
--
ALTER TABLE `addersses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addersses_users_fk` (`user_id`),
  ADD KEY `addersses_regions_fk` (`region_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`user_id`,`product_id`),
  ADD KEY `carts_products_fk` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `coupons_users`
--
ALTER TABLE `coupons_users`
  ADD PRIMARY KEY (`user_id`,`coupon_id`),
  ADD KEY `jj` (`coupon_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers_products`
--
ALTER TABLE `offers_products`
  ADD PRIMARY KEY (`product_id`,`offer_id`),
  ADD KEY `offer_offer_product_fk` (`offer_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupons_orders_fk` (`coupon_id`),
  ADD KEY `addresses_orders_fk` (`address_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tokenable_type` (`tokenable_type`),
  ADD UNIQUE KEY `tokenable_id` (`tokenable_id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `subcategories_product_fk` (`subcategory_id`),
  ADD KEY `brand_product_fk` (`brand_id`);

--
-- Indexes for table `products_orders`
--
ALTER TABLE `products_orders`
  ADD PRIMARY KEY (`product_id`,`order_id`),
  ADD KEY `order_orderProduct_fk` (`order_id`);

--
-- Indexes for table `product_spec`
--
ALTER TABLE `product_spec`
  ADD PRIMARY KEY (`product_id`,`spec_id`),
  ADD KEY `spec_id` (`spec_id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `regions_cities_fk` (`city_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`product_id`,`user_id`),
  ADD KEY `reviews_users_fk` (`user_id`);

--
-- Indexes for table `spec`
--
ALTER TABLE `spec`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_subcategories_fk` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`product_id`,`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addersses`
--
ALTER TABLE `addersses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `spec`
--
ALTER TABLE `spec`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addersses`
--
ALTER TABLE `addersses`
  ADD CONSTRAINT `addersses_regions_fk` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `addersses_users_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_products_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_users_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `coupons_users`
--
ALTER TABLE `coupons_users`
  ADD CONSTRAINT `coupons_coupons_users_fk` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`),
  ADD CONSTRAINT `coupons_users_users_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `offers_products`
--
ALTER TABLE `offers_products`
  ADD CONSTRAINT `offer_offer_product_fk` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_product_offer_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `addresses_orders_fk` FOREIGN KEY (`address_id`) REFERENCES `addersses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `coupons_orders_fk` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `brand_product_fk` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subcategories_product_fk` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products_orders`
--
ALTER TABLE `products_orders`
  ADD CONSTRAINT `product_order_order_fk` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_product_order_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_spec`
--
ALTER TABLE `product_spec`
  ADD CONSTRAINT `product_spec_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_spec_ibfk_2` FOREIGN KEY (`spec_id`) REFERENCES `spec` (`id`),
  ADD CONSTRAINT `spec_product_spec_fk` FOREIGN KEY (`spec_id`) REFERENCES `spec` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `regions`
--
ALTER TABLE `regions`
  ADD CONSTRAINT `regions_cities_fk` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_products_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_users_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `categories_subcategories_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlist_products_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
