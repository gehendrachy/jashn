-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 13, 2022 at 04:33 AM
-- Server version: 10.3.34-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopatjashn_beta`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `image`, `url`, `created_at`, `updated_at`) VALUES
(1, 'Banner Top - Single', '1646479909.jpg', 'https://www.facebook.com/jashnthepage', '2021-08-24 23:54:23', '2022-03-06 17:57:49'),
(2, 'Banner Second - Single', '1646479925.jpg', 'https://www.facebook.com/jashnthepage', '2021-08-24 23:55:23', '2022-03-06 17:58:10'),
(3, 'Banner Middle - Left (Third Row)', '1646479938.jpg', 'https://www.facebook.com/jashnthepage', '2021-08-24 23:55:52', '2022-03-06 17:58:17'),
(4, 'Banner Middle - Right (Third Row)', '1646479949.jpg', 'https://www.facebook.com/jashnthepage', '2021-08-24 23:56:10', '2022-03-06 17:58:24'),
(5, 'Banner Bottom - First', '1646479962.jpg', 'https://www.facebook.com/jashnthepage', '2021-08-24 23:56:41', '2022-03-06 17:58:30'),
(6, 'Banner Bottom - Second', '1646479972.jpg', 'https://www.facebook.com/jashnthepage', '2021-08-24 23:56:53', '2022-03-06 17:58:38'),
(7, 'Banner Bottom - Third', '1646479983.jpg', 'https://www.facebook.com/jashnthepage', '2021-08-24 23:56:41', '2022-03-06 17:58:46'),
(8, 'Banner Bottom - Fourth', '1646479996.jpg', 'https://www.facebook.com/jashnthepage', '2021-08-24 23:56:53', '2022-03-06 17:58:58');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display` tinyint(1) NOT NULL DEFAULT 0,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `short_content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long_content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display` tinyint(1) NOT NULL DEFAULT 0,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_item` int(11) NOT NULL,
  `child` tinyint(1) NOT NULL DEFAULT 0,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `slug`, `image`, `display`, `featured`, `content`, `order_item`, `child`, `parent_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(24, 'Women Fashion', 'women-fashion', NULL, 1, 0, NULL, 1, 1, 0, 'SHOPJASHN', NULL, '2022-03-05 17:46:55', '2022-03-06 17:19:30'),
(25, 'Sarees', 'sarees', NULL, 1, 0, NULL, 2, 1, 24, 'SHOPJASHN', NULL, '2022-03-05 17:47:06', '2022-03-06 17:19:30'),
(26, 'Chiffon Saree', 'chiffon-saree', NULL, 1, 0, NULL, 3, 1, 25, 'SHOPJASHN', NULL, '2022-03-05 17:47:15', '2022-03-06 17:19:30'),
(27, 'Printed Chiffon', 'printed-chiffon', NULL, 1, 0, NULL, 4, 0, 26, 'SHOPJASHN', NULL, '2022-03-05 17:47:23', '2022-03-06 17:19:30'),
(28, 'Partywear Chiffon', 'partywear-chiffon', NULL, 1, 0, NULL, 5, 0, 26, 'SHOPJASHN', NULL, '2022-03-05 17:47:32', '2022-03-06 17:19:30'),
(29, 'Cotton Saree', 'cotton-saree', NULL, 1, 0, NULL, 6, 1, 25, 'SHOPJASHN', NULL, '2022-03-05 17:47:43', '2022-03-06 17:19:30'),
(30, 'Cotton Handloom Saree', 'cotton-handloom-saree', NULL, 1, 0, NULL, 7, 0, 29, 'SHOPJASHN', NULL, '2022-03-05 17:47:50', '2022-03-06 17:19:30'),
(31, 'Cotton Printed Saree', 'cotton-printed-saree', NULL, 1, 0, NULL, 8, 0, 29, 'SHOPJASHN', NULL, '2022-03-05 17:47:58', '2022-03-06 17:19:30'),
(32, 'Supernet Saree', 'supernet-saree', NULL, 1, 0, NULL, 9, 0, 29, 'SHOPJASHN', NULL, '2022-03-05 17:48:12', '2022-03-06 17:19:30'),
(33, 'Georgette Saree', 'georgette-saree', NULL, 1, 0, NULL, 10, 1, 25, 'SHOPJASHN', NULL, '2022-03-05 17:48:20', '2022-03-06 17:19:30'),
(34, 'Printed Georgette Saree', 'printed-georgette-saree', NULL, 1, 0, NULL, 11, 0, 33, 'SHOPJASHN', 'SHOPJASHN', '2022-03-05 17:48:30', '2022-03-06 17:19:30'),
(35, 'Partywear Georgette Saree', 'partywear-georgette-saree', NULL, 1, 0, NULL, 12, 0, 33, 'SHOPJASHN', NULL, '2022-03-05 17:48:51', '2022-03-06 17:19:30'),
(36, 'Linen Saree', 'linen-saree', NULL, 1, 0, NULL, 13, 0, 25, 'SHOPJASHN', NULL, '2022-03-05 17:48:59', '2022-03-06 17:19:30'),
(37, 'Organza & Net Saree', 'organza-net-saree', NULL, 1, 0, NULL, 14, 1, 25, 'SHOPJASHN', NULL, '2022-03-05 17:49:08', '2022-03-06 17:19:30'),
(38, 'Digital Print Organza Saree', 'digital-print-organza-saree', NULL, 1, 0, NULL, 15, 0, 37, 'SHOPJASHN', NULL, '2022-03-05 17:49:16', '2022-03-06 17:19:30'),
(39, 'Organza Saree with work', 'organza-saree-with-work', NULL, 1, 0, NULL, 16, 0, 37, 'SHOPJASHN', NULL, '2022-03-05 17:49:25', '2022-03-06 17:19:30'),
(40, 'Net Saree', 'net-saree', NULL, 1, 0, NULL, 17, 0, 37, 'SHOPJASHN', NULL, '2022-03-05 17:49:34', '2022-03-06 17:19:30'),
(41, 'Silk Saree', 'silk-saree', NULL, 1, 0, NULL, 18, 1, 25, 'SHOPJASHN', NULL, '2022-03-05 17:49:43', '2022-03-06 17:19:30'),
(42, 'Banarasi Silk Saree', 'banarasi-silk-saree', NULL, 1, 0, NULL, 19, 0, 41, 'SHOPJASHN', NULL, '2022-03-05 17:49:52', '2022-03-06 17:19:30'),
(43, 'Cotton Silk Saree', 'cotton-silk-saree', NULL, 1, 0, NULL, 20, 0, 41, 'SHOPJASHN', NULL, '2022-03-05 17:50:03', '2022-03-06 17:19:30'),
(44, 'Doriya Silk Saree', 'doriya-silk-saree', NULL, 1, 0, NULL, 21, 0, 41, 'SHOPJASHN', NULL, '2022-03-05 17:50:30', '2022-03-06 17:19:30'),
(45, 'Pashmina Silk Saree', 'pashmina-silk-saree', NULL, 1, 0, NULL, 22, 0, 41, 'SHOPJASHN', NULL, '2022-03-05 17:50:38', '2022-03-06 17:19:30'),
(46, 'Raw Silk Saree', 'raw-silk-saree', NULL, 1, 0, NULL, 23, 0, 41, 'SHOPJASHN', NULL, '2022-03-05 17:50:48', '2022-03-06 17:19:30'),
(47, 'Weaving Silk Saree', 'weaving-silk-saree', NULL, 1, 0, NULL, 24, 0, 41, 'SHOPJASHN', NULL, '2022-03-05 17:50:56', '2022-03-06 17:19:30'),
(48, 'Fancy Silk Saree', 'fancy-silk-saree', NULL, 1, 0, NULL, 25, 0, 41, 'SHOPJASHN', NULL, '2022-03-05 17:51:05', '2022-03-06 17:19:30'),
(49, 'Kurtis & Tops', 'kurtis-tops', NULL, 1, 0, NULL, 26, 1, 24, 'SHOPJASHN', NULL, '2022-03-05 17:51:18', '2022-03-06 17:19:30'),
(50, 'Short Tops & Shirts', 'short-tops-shirts', NULL, 1, 0, NULL, 27, 1, 49, 'SHOPJASHN', NULL, '2022-03-05 17:51:27', '2022-03-06 17:19:30'),
(51, 'Rayon Tops', 'rayon-tops', NULL, 1, 0, NULL, 28, 0, 50, 'SHOPJASHN', NULL, '2022-03-05 17:51:44', '2022-03-06 17:19:30'),
(52, 'Cotton Tops', 'cotton-tops', NULL, 1, 0, NULL, 29, 0, 50, 'SHOPJASHN', NULL, '2022-03-05 17:51:53', '2022-03-06 17:19:30'),
(53, 'Crepe Tops', 'crepe-tops', NULL, 1, 0, NULL, 30, 0, 50, 'SHOPJASHN', NULL, '2022-03-05 17:52:02', '2022-03-06 17:19:30'),
(54, 'Gowns', 'gowns', NULL, 1, 0, NULL, 31, 1, 49, 'SHOPJASHN', NULL, '2022-03-05 17:52:29', '2022-03-06 17:19:30'),
(55, 'Casual Gowns', 'casual-gowns', NULL, 1, 0, NULL, 32, 0, 54, 'SHOPJASHN', NULL, '2022-03-05 17:52:38', '2022-03-06 17:19:30'),
(56, 'Partywear Gowns', 'partywear-gowns', NULL, 1, 0, NULL, 33, 0, 54, 'SHOPJASHN', NULL, '2022-03-05 17:52:46', '2022-03-06 17:19:30'),
(57, 'Indo-western', 'indo-western', NULL, 1, 0, NULL, 34, 0, 54, 'SHOPJASHN', NULL, '2022-03-05 17:52:55', '2022-03-06 17:19:30'),
(58, 'Kurtis & Tunics', 'kurtis-tunics', NULL, 1, 0, NULL, 35, 1, 49, 'SHOPJASHN', NULL, '2022-03-05 17:53:22', '2022-03-06 17:19:30'),
(59, 'Cotton Kurti', 'cotton-kurti', NULL, 1, 0, NULL, 39, 0, 49, 'SHOPJASHN', NULL, '2022-03-05 17:53:32', '2022-03-06 17:19:30'),
(60, 'Rayon Kurti', 'rayon-kurti', NULL, 1, 0, NULL, 36, 0, 58, 'SHOPJASHN', NULL, '2022-03-05 17:53:44', '2022-03-06 17:19:30'),
(61, 'Crepe Kurti', 'crepe-kurti', NULL, 1, 0, NULL, 37, 0, 58, 'SHOPJASHN', NULL, '2022-03-05 17:53:52', '2022-03-06 17:19:30'),
(62, 'Silk Kurti', 'silk-kurti', NULL, 1, 0, NULL, 38, 0, 58, 'SHOPJASHN', NULL, '2022-03-05 17:54:01', '2022-03-06 17:19:30'),
(63, 'Dresses', 'dresses', NULL, 1, 0, NULL, 40, 1, 49, 'SHOPJASHN', NULL, '2022-03-05 17:54:11', '2022-03-06 17:19:30'),
(64, 'Casual Dresses', 'casual-dresses', NULL, 1, 0, NULL, 41, 0, 63, 'SHOPJASHN', NULL, '2022-03-05 17:54:19', '2022-03-06 17:19:30'),
(65, 'Top & Bottom Sets', 'top-bottom-sets', NULL, 1, 0, NULL, 42, 1, 24, 'SHOPJASHN', NULL, '2022-03-05 17:55:03', '2022-03-06 17:19:30'),
(66, 'Indo-western Sets', 'indo-western-sets', NULL, 1, 0, NULL, 43, 0, 65, 'SHOPJASHN', NULL, '2022-03-05 17:55:17', '2022-03-06 17:19:30'),
(67, 'Kurtis with Bottoms', 'kurtis-with-bottoms', NULL, 1, 0, NULL, 44, 1, 65, 'SHOPJASHN', NULL, '2022-03-05 17:55:31', '2022-03-06 17:19:31'),
(68, 'Kurtis with Pants', 'kurtis-with-pants', NULL, 1, 0, NULL, 45, 0, 67, 'SHOPJASHN', NULL, '2022-03-05 17:55:40', '2022-03-06 17:19:31'),
(69, 'Kurtis with Palazzo', 'kurtis-with-palazzo', NULL, 1, 0, NULL, 46, 0, 67, 'SHOPJASHN', NULL, '2022-03-05 17:55:49', '2022-03-06 17:19:31'),
(70, 'Kurti with Skirts', 'kurti-with-skirts', NULL, 1, 0, NULL, 47, 0, 67, 'SHOPJASHN', NULL, '2022-03-05 17:55:59', '2022-03-06 17:19:31'),
(71, 'Dress Materials', 'dress-materials', NULL, 1, 0, NULL, 48, 1, 24, 'SHOPJASHN', NULL, '2022-03-05 17:56:14', '2022-03-06 17:19:31'),
(72, 'Cotton Suit Pcs', 'cotton-suit-pcs', NULL, 1, 0, NULL, 49, 0, 71, 'SHOPJASHN', NULL, '2022-03-05 17:56:23', '2022-03-06 17:19:31'),
(73, 'Silk Suit Pcs', 'silk-suit-pcs', NULL, 1, 0, NULL, 50, 0, 71, 'SHOPJASHN', NULL, '2022-03-05 17:56:33', '2022-03-06 17:19:31'),
(74, 'Pashmina Suit Pcs', 'pashmina-suit-pcs', NULL, 1, 0, NULL, 51, 0, 71, 'SHOPJASHN', NULL, '2022-03-05 17:56:41', '2022-03-06 17:19:31'),
(75, 'Bottoms', 'bottoms', NULL, 1, 0, NULL, 52, 1, 24, 'SHOPJASHN', NULL, '2022-03-05 17:57:13', '2022-03-06 17:19:31'),
(76, 'Pants & Palazzo', 'pants-palazzo', NULL, 1, 0, NULL, 53, 1, 75, 'SHOPJASHN', NULL, '2022-03-05 17:57:22', '2022-03-06 17:19:31'),
(77, 'Pants', 'pants', NULL, 1, 0, NULL, 54, 0, 76, 'SHOPJASHN', NULL, '2022-03-05 17:57:31', '2022-03-06 17:19:31'),
(78, 'Palazzo', 'palazzo', NULL, 1, 0, NULL, 55, 0, 76, 'SHOPJASHN', NULL, '2022-03-05 17:57:40', '2022-03-06 17:19:31'),
(79, 'Skirts', 'skirts', NULL, 1, 0, NULL, 56, 0, 75, 'SHOPJASHN', NULL, '2022-03-05 17:57:51', '2022-03-06 17:19:31'),
(80, 'Leggings', 'leggings', NULL, 1, 0, NULL, 57, 0, 75, 'SHOPJASHN', NULL, '2022-03-05 17:57:59', '2022-03-06 17:19:31'),
(81, 'Dupatta & Stoles', 'dupatta-stoles', NULL, 1, 0, NULL, 58, 1, 24, 'SHOPJASHN', NULL, '2022-03-05 17:58:10', '2022-03-06 17:19:31'),
(82, 'Dupatta', 'dupatta', NULL, 1, 0, NULL, 59, 0, 81, 'SHOPJASHN', NULL, '2022-03-05 17:59:03', '2022-03-06 17:19:31'),
(83, 'Stoles', 'stoles', NULL, 1, 0, NULL, 60, 0, 81, 'SHOPJASHN', NULL, '2022-03-05 17:59:15', '2022-03-06 17:19:31'),
(84, 'Women\'s Bags', 'womens-bags', NULL, 1, 0, NULL, 62, 1, 152, 'SHOPJASHN', 'SHOPJASHN', '2022-03-05 17:59:51', '2022-03-06 17:19:31'),
(85, 'Clutches', 'clutches', NULL, 1, 0, NULL, 63, 0, 84, 'SHOPJASHN', NULL, '2022-03-05 18:00:08', '2022-03-06 17:19:31'),
(86, 'Totes', 'totes', NULL, 1, 0, NULL, 64, 0, 84, 'SHOPJASHN', NULL, '2022-03-05 18:00:19', '2022-03-06 17:19:31'),
(87, 'Shoulder Bags', 'shoulder-bags', NULL, 1, 0, NULL, 65, 0, 84, 'SHOPJASHN', NULL, '2022-03-05 18:00:31', '2022-03-06 17:19:31'),
(88, 'Kids Bags', 'kids-bags', NULL, 1, 0, NULL, 125, 0, 140, 'SHOPJASHN', 'SHOPJASHN', '2022-03-05 18:00:42', '2022-03-06 17:19:31'),
(89, 'Kids Fashion', 'kids-fashion', NULL, 1, 0, NULL, 74, 1, 0, 'SHOPJASHN', NULL, '2022-03-05 18:01:02', '2022-03-06 17:19:31'),
(90, 'Boys', 'boys', NULL, 1, 0, NULL, 75, 1, 89, 'SHOPJASHN', NULL, '2022-03-05 18:02:30', '2022-03-06 17:19:31'),
(91, 'Boys Tshirts & Tops', 'boys-tshirts-tops', NULL, 1, 0, NULL, 76, 1, 90, 'SHOPJASHN', NULL, '2022-03-05 18:03:11', '2022-03-06 17:19:31'),
(92, 'Boys Polo Tshirts', 'boys-polo-tshirts', NULL, 1, 0, NULL, 77, 0, 91, 'SHOPJASHN', NULL, '2022-03-05 18:03:32', '2022-03-06 17:19:31'),
(93, 'Boys Round Neck Tshirts', 'boys-round-neck-tshirts', NULL, 1, 0, NULL, 78, 0, 91, 'SHOPJASHN', NULL, '2022-03-05 18:03:52', '2022-03-06 17:19:31'),
(94, 'Boys Front Button Tshirts', 'boys-front-button-tshirts', NULL, 1, 0, NULL, 79, 0, 91, 'SHOPJASHN', NULL, '2022-03-05 18:04:12', '2022-03-06 17:19:31'),
(95, 'Highneck', 'highneck', NULL, 1, 0, NULL, 80, 0, 91, 'SHOPJASHN', NULL, '2022-03-05 18:04:25', '2022-03-06 17:19:31'),
(96, 'Boys Hoodies', 'boys-hoodies', NULL, 1, 0, NULL, 81, 0, 91, 'SHOPJASHN', NULL, '2022-03-05 18:04:42', '2022-03-06 17:19:31'),
(97, 'Boys Sweatshirts', 'boys-sweatshirts', NULL, 1, 0, NULL, 82, 0, 91, 'SHOPJASHN', NULL, '2022-03-05 18:05:07', '2022-03-06 17:19:31'),
(98, 'Boys Bottoms', 'boys-bottoms', NULL, 1, 0, NULL, 83, 1, 90, 'SHOPJASHN', NULL, '2022-03-05 18:05:24', '2022-03-06 17:19:31'),
(99, 'Boys Half Pant', 'boys-half-pant', NULL, 1, 0, NULL, 84, 0, 98, 'SHOPJASHN', NULL, '2022-03-05 18:05:38', '2022-03-06 17:19:31'),
(100, 'Boys Joggers', 'boys-joggers', NULL, 1, 0, NULL, 85, 0, 98, 'SHOPJASHN', NULL, '2022-03-05 18:05:56', '2022-03-06 17:19:31'),
(101, 'Boys Jeans', 'boys-jeans', NULL, 1, 0, NULL, 86, 0, 98, 'SHOPJASHN', NULL, '2022-03-05 18:06:10', '2022-03-06 17:19:31'),
(102, 'Boys Ribbed Bottoms', 'boys-ribbed-bottoms', NULL, 1, 0, NULL, 87, 0, 98, 'SHOPJASHN', NULL, '2022-03-05 18:06:26', '2022-03-06 17:19:31'),
(103, 'Boys Sets', 'boys-sets', NULL, 1, 0, NULL, 88, 1, 90, 'SHOPJASHN', NULL, '2022-03-05 18:06:39', '2022-03-06 17:19:31'),
(105, 'Boys Top & Bottom Set', 'boys-top-bottom-set', NULL, 1, 0, NULL, 89, 0, 103, 'SHOPJASHN', NULL, '2022-03-05 18:07:03', '2022-03-06 17:19:31'),
(106, 'Boys Rompers & Oneis', 'boys-rompers-oneis', NULL, 1, 0, NULL, 90, 0, 90, 'SHOPJASHN', NULL, '2022-03-05 18:07:16', '2022-03-06 17:19:31'),
(107, 'Ethnic wear', 'ethnic-wear', NULL, 1, 0, NULL, 91, 0, 90, 'SHOPJASHN', NULL, '2022-03-05 18:07:50', '2022-03-06 17:19:31'),
(108, 'Boys Sweaters & Jackets', 'boys-sweaters-jackets', NULL, 1, 0, NULL, 92, 1, 90, 'SHOPJASHN', NULL, '2022-03-05 18:08:01', '2022-03-06 17:19:31'),
(109, 'Boys Sweaters', 'boys-sweaters', NULL, 1, 0, NULL, 93, 0, 108, 'SHOPJASHN', NULL, '2022-03-05 18:08:13', '2022-03-06 17:19:31'),
(110, 'Boys Jackets', 'boys-jackets', NULL, 1, 0, NULL, 94, 0, 108, 'SHOPJASHN', NULL, '2022-03-05 18:08:27', '2022-03-06 17:19:31'),
(111, 'Boys Nightwear', 'boys-nightwear', NULL, 1, 0, NULL, 95, 0, 90, 'SHOPJASHN', NULL, '2022-03-05 18:08:39', '2022-03-06 17:19:31'),
(112, 'Girls', 'girls', NULL, 1, 0, NULL, 96, 1, 89, 'SHOPJASHN', NULL, '2022-03-05 18:09:03', '2022-03-06 17:19:31'),
(113, 'Girls Tops & Frocks', 'girls-tops-frocks', NULL, 1, 0, NULL, 97, 1, 112, 'SHOPJASHN', NULL, '2022-03-05 18:09:18', '2022-03-06 17:19:31'),
(114, 'Girls Tops', 'girls-tops', NULL, 1, 0, NULL, 98, 0, 113, 'SHOPJASHN', NULL, '2022-03-05 18:09:30', '2022-03-06 17:19:31'),
(115, 'Frocks', 'frocks', NULL, 1, 0, NULL, 99, 0, 113, 'SHOPJASHN', NULL, '2022-03-05 18:09:46', '2022-03-06 17:19:31'),
(116, 'Girls Sweatshirt', 'girls-sweatshirt', NULL, 1, 0, NULL, 100, 0, 113, 'SHOPJASHN', NULL, '2022-03-05 18:10:00', '2022-03-06 17:19:31'),
(117, 'Girls Bottoms', 'girls-bottoms', NULL, 1, 0, NULL, 101, 1, 112, 'SHOPJASHN', NULL, '2022-03-05 18:10:37', '2022-03-06 17:19:31'),
(118, 'Girls Half Pant', 'girls-half-pant', NULL, 1, 0, NULL, 102, 0, 117, 'SHOPJASHN', NULL, '2022-03-05 18:10:50', '2022-03-06 17:19:31'),
(119, 'Leggings', 'leggings-1', NULL, 1, 0, NULL, 103, 0, 117, 'SHOPJASHN', NULL, '2022-03-05 18:11:12', '2022-03-06 17:19:31'),
(120, 'Girls Joggers', 'girls-joggers', NULL, 1, 0, NULL, 104, 0, 117, 'SHOPJASHN', NULL, '2022-03-05 18:11:25', '2022-03-06 17:19:31'),
(121, 'Girls Ribbed Bottoms', 'girls-ribbed-bottoms', NULL, 1, 0, NULL, 105, 0, 117, 'SHOPJASHN', NULL, '2022-03-05 18:11:41', '2022-03-06 17:19:31'),
(122, 'Girls Sets', 'girls-sets', NULL, 1, 0, NULL, 106, 1, 112, 'SHOPJASHN', NULL, '2022-03-05 18:11:55', '2022-03-06 17:19:31'),
(123, 'Frock Sets', 'frock-sets', NULL, 1, 0, NULL, 107, 0, 122, 'SHOPJASHN', NULL, '2022-03-05 18:12:28', '2022-03-06 17:19:31'),
(124, 'Jumpsuits', 'jumpsuits', NULL, 1, 0, NULL, 108, 0, 122, 'SHOPJASHN', NULL, '2022-03-05 18:12:38', '2022-03-06 17:19:31'),
(125, 'Girls Top & Bottom Sets', 'girls-top-bottom-sets', NULL, 1, 0, NULL, 109, 0, 122, 'SHOPJASHN', NULL, '2022-03-05 18:12:50', '2022-03-06 17:19:31'),
(126, 'Girls Rompers & Oneis', 'girls-rompers-oneis', NULL, 1, 0, NULL, 110, 0, 112, 'SHOPJASHN', NULL, '2022-03-05 18:13:04', '2022-03-06 17:19:31'),
(127, 'Girls Ethnic Wear', 'girls-ethnic-wear', NULL, 1, 0, NULL, 111, 0, 112, 'SHOPJASHN', NULL, '2022-03-05 18:14:19', '2022-03-06 17:19:31'),
(128, 'Girls Sweaters & Jackets', 'girls-sweaters-jackets', NULL, 1, 0, NULL, 112, 1, 112, 'SHOPJASHN', NULL, '2022-03-05 18:14:32', '2022-03-06 17:19:31'),
(129, 'Girls Sweaters', 'girls-sweaters', NULL, 1, 0, NULL, 113, 0, 128, 'SHOPJASHN', NULL, '2022-03-05 18:14:47', '2022-03-06 17:19:31'),
(130, 'Girls Jackets', 'girls-jackets', NULL, 1, 0, NULL, 114, 0, 128, 'SHOPJASHN', NULL, '2022-03-05 18:15:01', '2022-03-06 17:19:31'),
(131, 'Girls Nightwear', 'girls-nightwear', NULL, 1, 0, NULL, 115, 0, 112, 'SHOPJASHN', NULL, '2022-03-05 18:15:12', '2022-03-06 17:19:31'),
(132, 'Girls Innerwear', 'girls-innerwear', NULL, 1, 0, NULL, 116, 0, 112, 'SHOPJASHN', NULL, '2022-03-05 18:15:28', '2022-03-06 17:19:31'),
(133, 'New Born & Infants', 'new-born-infants', NULL, 1, 0, NULL, 117, 1, 89, 'SHOPJASHN', NULL, '2022-03-05 18:16:11', '2022-03-06 17:19:31'),
(134, 'Infants Tops', 'infants-tops', NULL, 1, 0, NULL, 118, 0, 133, 'SHOPJASHN', NULL, '2022-03-05 18:16:28', '2022-03-06 17:19:31'),
(135, 'Infant Sets', 'infant-sets', NULL, 1, 0, NULL, 119, 0, 133, 'SHOPJASHN', NULL, '2022-03-05 18:16:40', '2022-03-06 17:19:31'),
(136, 'Infant Bottoms', 'infant-bottoms', NULL, 1, 0, NULL, 120, 0, 133, 'SHOPJASHN', NULL, '2022-03-05 18:16:53', '2022-03-06 17:19:31'),
(137, 'Thermals', 'thermals', NULL, 1, 0, NULL, 121, 1, 89, 'SHOPJASHN', NULL, '2022-03-05 18:17:14', '2022-03-06 17:19:31'),
(138, 'Thermal Tops', 'thermal-tops', NULL, 1, 0, NULL, 122, 0, 137, 'SHOPJASHN', NULL, '2022-03-05 18:17:21', '2022-03-06 17:19:31'),
(139, 'Thermal Bottoms', 'thermal-bottoms', NULL, 1, 0, NULL, 123, 0, 137, 'SHOPJASHN', NULL, '2022-03-05 18:17:30', '2022-03-06 17:19:31'),
(140, 'Kids Accessories', 'kids-accessories', NULL, 1, 0, NULL, 124, 1, 89, 'SHOPJASHN', NULL, '2022-03-05 18:17:41', '2022-03-06 17:19:31'),
(141, 'Socks & Mittens', 'socks-mittens', NULL, 1, 0, NULL, 126, 0, 140, 'SHOPJASHN', NULL, '2022-03-05 18:17:51', '2022-03-06 17:19:31'),
(142, 'Caps', 'caps', NULL, 1, 0, NULL, 127, 0, 140, 'SHOPJASHN', NULL, '2022-03-05 18:17:59', '2022-03-06 17:19:31'),
(143, 'Swaddles & Wraps', 'swaddles-wraps', NULL, 1, 0, NULL, 128, 0, 140, 'SHOPJASHN', NULL, '2022-03-05 18:18:09', '2022-03-06 17:19:31'),
(144, 'Nappy Covers & Nappy', 'nappy-covers-nappy', NULL, 1, 0, NULL, 129, 0, 140, 'SHOPJASHN', NULL, '2022-03-05 18:18:23', '2022-03-06 17:19:31'),
(145, 'Home Décor', 'home-decor', NULL, 1, 0, NULL, 138, 1, 0, 'SHOPJASHN', NULL, '2022-03-05 18:18:32', '2022-03-06 17:19:31'),
(146, 'Bedsheet', 'bedsheet', NULL, 1, 0, NULL, 139, 0, 145, 'SHOPJASHN', NULL, '2022-03-05 18:18:43', '2022-03-06 17:19:31'),
(149, 'Cushion Cover Sets', 'cushion-cover-sets', NULL, 1, 0, NULL, 140, 0, 145, 'SHOPJASHN', NULL, '2022-03-05 18:20:06', '2022-03-06 17:19:31'),
(150, 'Duvets', 'duvets', NULL, 1, 0, NULL, 141, 0, 145, 'SHOPJASHN', NULL, '2022-03-05 18:20:44', '2022-03-06 17:19:31'),
(151, 'Blankets & Covers', 'blankets-covers', NULL, 1, 0, NULL, 142, 0, 145, 'SHOPJASHN', NULL, '2022-03-05 18:20:52', '2022-03-06 17:19:31'),
(152, 'Women Accessories', 'women-accessories', NULL, 1, 0, NULL, 61, 1, 24, 'SHOPJASHN', NULL, '2022-03-05 18:23:17', '2022-03-06 17:19:31'),
(153, 'Imitation Jewelry', 'imitation-jewelry', NULL, 1, 0, NULL, 66, 1, 152, 'SHOPJASHN', NULL, '2022-03-05 18:23:49', '2022-03-06 17:19:31'),
(154, 'Necklace Sets', 'necklace-sets', NULL, 1, 0, NULL, 67, 0, 153, 'SHOPJASHN', NULL, '2022-03-05 18:23:58', '2022-03-06 17:19:31'),
(155, 'Mangal sutra', 'mangal-sutra', NULL, 1, 0, NULL, 68, 0, 153, 'SHOPJASHN', NULL, '2022-03-05 18:24:08', '2022-03-06 17:19:31'),
(156, 'Tops & Earrings', 'tops-earrings', NULL, 1, 0, NULL, 69, 0, 153, 'SHOPJASHN', NULL, '2022-03-05 18:24:20', '2022-03-06 17:19:31'),
(157, 'Bangles & Bracelets', 'bangles-bracelets', NULL, 1, 0, NULL, 70, 0, 153, 'SHOPJASHN', NULL, '2022-03-05 18:25:12', '2022-03-06 17:19:31'),
(158, 'Waistband', 'waistband', NULL, 1, 0, NULL, 72, 0, 153, 'SHOPJASHN', NULL, '2022-03-05 18:25:20', '2022-03-06 17:19:31'),
(159, 'Pendent Sets', 'pendent-sets', NULL, 1, 0, NULL, 71, 0, 153, 'SHOPJASHN', NULL, '2022-03-05 18:25:30', '2022-03-06 17:19:31'),
(160, 'Ladies Watches', 'ladies-watches', NULL, 1, 0, NULL, 73, 0, 152, 'SHOPJASHN', NULL, '2022-03-05 18:25:42', '2022-03-06 17:19:31'),
(161, 'Toys', 'toys', NULL, 1, 0, NULL, 130, 1, 89, 'SHOPJASHN', NULL, '2022-03-05 18:26:18', '2022-03-06 17:19:31'),
(162, 'Educational & Learnings Toys', 'educational-learnings-toys', NULL, 1, 0, NULL, 131, 0, 161, 'SHOPJASHN', NULL, '2022-03-05 18:26:33', '2022-03-06 17:19:31'),
(163, 'Gyms & Playmats', 'gyms-playmats', NULL, 1, 0, NULL, 132, 0, 161, 'SHOPJASHN', NULL, '2022-03-05 18:26:41', '2022-03-06 17:19:31'),
(164, 'Blocks, Construction & Stacking', 'blocks-construction-stacking', NULL, 1, 0, NULL, 133, 0, 161, 'SHOPJASHN', NULL, '2022-03-05 18:26:51', '2022-03-06 17:19:31'),
(165, 'Puzzle Toys', 'puzzle-toys', NULL, 1, 0, NULL, 134, 0, 161, 'SHOPJASHN', NULL, '2022-03-05 18:26:59', '2022-03-06 17:19:31'),
(166, 'Board Games', 'board-games', NULL, 1, 0, NULL, 135, 0, 161, 'SHOPJASHN', NULL, '2022-03-05 18:27:08', '2022-03-06 17:19:31'),
(167, 'Rattles', 'rattles', NULL, 1, 0, NULL, 136, 0, 161, 'SHOPJASHN', NULL, '2022-03-05 18:27:16', '2022-03-06 17:19:31'),
(168, 'Action Figures & Dolls', 'action-figures-dolls', NULL, 1, 0, NULL, 137, 0, 161, 'SHOPJASHN', NULL, '2022-03-05 18:27:25', '2022-03-06 17:19:31');

-- --------------------------------------------------------

--
-- Table structure for table `category_coupons`
--

CREATE TABLE `category_coupons` (
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `discount_coupon_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category_offers`
--

CREATE TABLE `category_offers` (
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `offer_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pin_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `display` tinyint(1) DEFAULT 1,
  `cod` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `pin_code`, `district_id`, `display`, `cod`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(16, 'Dhankuta', '56800', 56, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:03:51', '2022-03-06 23:48:39'),
(17, 'Ilam', '57300', 57, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:09:20', '2022-03-06 23:48:40'),
(18, 'Birtamode', '57204', 58, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:09:37', '2022-03-06 23:48:41'),
(19, 'Kakarbhitta', '57208', 58, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:09:55', '2022-03-06 23:48:41'),
(20, 'Damak', '57217', 58, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:10:16', '2022-03-06 23:48:43'),
(21, 'Biratnagar', '56613', 59, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:10:37', '2022-03-06 23:48:48'),
(22, 'Dharan', '56700', 60, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:10:58', '2022-03-06 23:48:49'),
(23, 'Itahari', '56705', 60, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:11:12', '2022-03-06 23:48:49'),
(24, 'Inaruwa', '56710', 60, 1, 1, 'SHOPJASHN', 'SHOPJASHN', '2022-03-06 23:11:24', '2022-03-06 23:48:50'),
(25, 'Gaighat', '56300', 61, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:11:41', '2022-03-06 23:49:08'),
(26, 'Kalaiya', '44400', 62, 1, 0, 'SHOPJASHN', NULL, '2022-03-06 23:11:59', '2022-03-06 23:11:59'),
(27, 'Janakpur', '45600', 63, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:12:14', '2022-03-07 21:24:55'),
(28, 'Birgunj', '44300', 64, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:12:34', '2022-03-07 21:24:58'),
(29, 'Jitpursimara', '44300', 64, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:12:48', '2022-03-07 21:25:33'),
(30, 'Rajbiraj', '56400', 65, 1, 0, 'SHOPJASHN', NULL, '2022-03-06 23:13:06', '2022-03-06 23:13:06'),
(31, 'Lahan', '56500', 89, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:14:10', '2022-03-07 21:25:46'),
(32, 'Siraha', '56500', 65, 1, 0, 'SHOPJASHN', NULL, '2022-03-06 23:14:31', '2022-03-06 23:14:31'),
(33, 'Bhaktapur', '44800', 68, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:14:48', '2022-03-07 21:26:04'),
(34, 'Bharatpur', '44200', 69, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:15:12', '2022-03-07 21:26:05'),
(36, 'Chandragadhi', '57200', 58, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:20:53', '2022-03-07 21:26:59'),
(37, 'Budhabare', '57200', 58, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:21:17', '2022-03-07 21:27:00'),
(38, 'Dhulabari', '57207', 58, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:21:37', '2022-03-07 21:27:12'),
(39, 'Sanishchare', '57205', 58, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:21:53', '2022-03-07 21:27:13'),
(40, 'Belbari', '56600', 59, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:22:20', '2022-03-07 21:27:14'),
(41, 'Biratchowk', '56604', 59, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:22:35', '2022-03-07 21:27:25'),
(42, 'Jhorahat', '56615', 59, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:22:50', '2022-03-07 21:27:25'),
(43, 'Rangeli', '56602', 59, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:23:11', '2022-03-07 21:27:26'),
(44, 'Urlabari', '56604', 59, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:23:25', '2022-03-07 21:27:27'),
(45, 'Duhabi', '56707', 60, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:24:03', '2022-03-07 21:27:32'),
(46, 'Jhumka', '56709', 60, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:24:17', '2022-03-07 21:27:39'),
(47, 'Chhireshwarnath', '45600', 62, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:24:43', '2022-03-07 21:27:46'),
(48, 'Bardibas', '45701', 90, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:25:06', '2022-03-07 21:27:46'),
(49, 'Dhalkebar', '45700', 90, 1, 0, 'SHOPJASHN', NULL, '2022-03-06 23:25:26', '2022-03-06 23:25:26'),
(50, 'Kathmandu', '44600', 71, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:25:59', '2022-03-07 21:27:54'),
(51, 'Dhulikhel', '45210', 72, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:26:24', '2022-03-07 21:27:55'),
(52, 'Banepa', '45210', 72, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:26:41', '2022-03-07 21:27:57'),
(53, 'Panauti', '45209', 72, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:26:54', '2022-03-07 21:28:03'),
(54, 'Lalitpur', '44600', 73, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:27:18', '2022-03-07 21:28:04'),
(55, 'Hetauda', '44100', 74, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:27:35', '2022-03-07 21:28:06'),
(56, 'Baglung', '33300', 76, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:27:57', '2022-03-07 21:28:07'),
(57, 'Gorkha', '34000', 77, 1, 0, 'SHOPJASHN', NULL, '2022-03-06 23:28:12', '2022-03-06 23:28:12'),
(59, 'Pokhara', '33700', 78, 1, 0, 'SHOPJASHN', NULL, '2022-03-06 23:28:27', '2022-03-06 23:28:27'),
(60, 'Damauli', '33900', 79, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:28:53', '2022-03-07 21:28:33'),
(61, 'Dumre', '33914', 79, 1, 0, 'SHOPJASHN', NULL, '2022-03-06 23:29:16', '2022-03-06 23:29:16'),
(62, 'Beni', '33200', 91, 1, 0, 'SHOPJASHN', NULL, '2022-03-06 23:29:31', '2022-03-06 23:29:31'),
(63, 'Birendranagar', '21700', 80, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:29:54', '2022-03-07 21:28:43'),
(64, 'Salyan', '22200', 92, 1, 0, 'SHOPJASHN', NULL, '2022-03-06 23:30:08', '2022-03-06 23:30:08'),
(65, 'Nepalganj', '21900', 81, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:30:28', '2022-03-07 21:28:44'),
(66, 'Ghorahi', '22400', 82, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:30:48', '2022-03-07 21:28:49'),
(67, 'Tulsipur', '22412', 82, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:31:00', '2022-03-07 21:28:50'),
(68, 'Ramgram', '33000', 84, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:31:15', '2022-03-07 21:28:57'),
(69, 'Bardaghat', '33000', 84, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:31:31', '2022-03-07 21:29:03'),
(70, 'Kusma Parbat', '33400', 95, 1, 0, 'SHOPJASHN', NULL, '2022-03-06 23:32:28', '2022-03-06 23:32:28'),
(71, 'Gaidakot', '33003', 93, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:32:45', '2022-03-07 21:29:14'),
(72, 'Kawasoti', '33016', 93, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:33:04', '2022-03-07 21:29:14'),
(73, 'Tansen', '32500', 85, 1, 0, 'SHOPJASHN', NULL, '2022-03-06 23:33:22', '2022-03-06 23:33:22'),
(74, 'Butwal', '32907', 86, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:33:43', '2022-03-07 21:29:22'),
(75, 'Bhairwah', '32900', 86, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:34:04', '2022-03-07 21:29:23'),
(76, 'Siddharthanagar', '32907', 86, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:34:18', '2022-03-07 21:29:24'),
(77, 'Tilottama', '32907', 86, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:34:37', '2022-03-07 21:29:25'),
(78, 'Manigram', '32903', 86, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:34:56', '2022-03-07 21:29:27'),
(79, 'Sunwal', '33000', 86, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:35:12', '2022-03-07 21:29:33'),
(80, 'Gulariya', '21800', 94, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:35:34', '2022-03-07 21:29:42'),
(81, 'Kohalpur', '21904', 81, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:36:05', '2022-03-07 21:29:48'),
(82, 'Krishnanagar', '32800', 83, 1, 0, 'SHOPJASHN', NULL, '2022-03-06 23:36:22', '2022-03-06 23:36:22'),
(83, 'Chanauta', '32814', 83, 1, 0, 'SHOPJASHN', NULL, '2022-03-06 23:36:47', '2022-03-06 23:36:47'),
(84, 'Taulihawa', '32800', 83, 1, 0, 'SHOPJASHN', NULL, '2022-03-06 23:37:01', '2022-03-06 23:37:01'),
(85, 'Dhangadhi', '10900', 87, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:37:30', '2022-03-07 21:29:50'),
(86, 'Attariya', '10900', 87, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:37:45', '2022-03-07 21:29:59'),
(87, 'Bauniya', '10901', 87, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:38:04', '2022-03-07 21:30:02'),
(88, 'Lamki', '10904', 87, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:38:16', '2022-03-07 21:30:02'),
(89, 'Tikapur', '10901', 87, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:38:46', '2022-03-07 21:30:03'),
(90, 'Mahendarnagar', '10400', 88, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:39:01', '2022-03-07 21:30:04');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `title`, `code`, `display`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(10, 'Red', '#ff0000', 1, 'SHOPJASHN', NULL, '2022-03-05 18:34:07', '2022-03-05 18:34:07'),
(11, 'Pink', '#efbbcc', 1, 'SHOPJASHN', NULL, '2022-03-05 18:34:27', '2022-03-05 18:34:27'),
(13, 'Blue', '#1b1bdb', 1, 'SHOPJASHN', NULL, '2022-03-05 18:35:11', '2022-03-05 18:35:11'),
(14, 'Green', '#28db30', 1, 'SHOPJASHN', NULL, '2022-03-05 18:35:21', '2022-03-05 18:35:21'),
(15, 'Yellow', '#ffff00', 1, 'SHOPJASHN', NULL, '2022-03-05 18:35:31', '2022-03-05 18:35:31'),
(16, 'Brown', '#d18410', 1, 'SHOPJASHN', NULL, '2022-03-05 18:36:07', '2022-03-05 18:36:07'),
(17, 'White', '#ffffff', 1, 'SHOPJASHN', NULL, '2022-03-05 18:36:17', '2022-03-05 18:36:17'),
(18, 'Golden', '#ffd700', 1, 'SHOPJASHN', NULL, '2022-03-05 18:36:36', '2022-03-05 18:36:36'),
(19, 'Cream', '#fffdd0', 1, 'SHOPJASHN', NULL, '2022-03-05 18:36:58', '2022-03-05 18:36:58'),
(20, 'Beige', '#f5f5dc', 1, 'SHOPJASHN', NULL, '2022-03-05 18:37:22', '2022-03-05 18:37:22'),
(21, 'Maroon', '#800000', 1, 'SHOPJASHN', NULL, '2022-03-05 18:37:36', '2022-03-05 18:37:36'),
(22, 'Purple', '#bf40bf', 1, 'SHOPJASHN', NULL, '2022-03-05 18:38:04', '2022-03-05 18:38:04'),
(23, 'Silver', '#c0c0c0', 1, 'SHOPJASHN', NULL, '2022-03-05 18:38:24', '2022-03-05 18:38:24'),
(25, 'Wine', '#722f37', 1, 'SHOPJASHN', NULL, '2022-03-05 18:40:03', '2022-03-05 18:40:03'),
(26, 'Sea Green', '#93e9be', 1, 'SHOPJASHN', NULL, '2022-03-05 18:40:25', '2022-03-05 18:40:25'),
(27, 'Black', '#000000', 1, 'SHOPJASHN', NULL, '2022-03-05 18:40:40', '2022-03-05 18:40:40'),
(28, 'Orange', '#eb5317', 1, 'SHOPJASHN', NULL, '2022-03-05 18:40:52', '2022-03-05 18:40:52'),
(29, 'Peach', '#ffe5b4', 1, 'SHOPJASHN', NULL, '2022-03-05 18:41:25', '2022-03-05 18:41:25'),
(30, 'Grey', '#808080', 1, 'SHOPJASHN', NULL, '2022-03-05 18:41:41', '2022-03-05 18:41:41');

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display` tinyint(1) NOT NULL DEFAULT 1,
  `excerpt` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_item` int(11) NOT NULL,
  `child` tinyint(1) NOT NULL DEFAULT 0,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `title`, `slug`, `image`, `display`, `excerpt`, `content`, `order_item`, `child`, `parent_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'About Us', 'about-us', NULL, 1, NULL, '<p>Seeing the Demand for Imitation jewlery, a untapped market, in 2012. we started a facebook page, to fill the gap in the market, making us one of the first Imitation Jewelry brand of Nepal. The reponse received was amazing. With the increasing demand and needs of our customer we slowly widened our product line in to many related products like saree, kurti, bags, purses, watches and most recently kidswear products.</p>\r\n\r\n<p>Jashn, has also been innovative, seeing the lack of online paymnet when it started, we were again one of the first to introduce Cash on Delivery (first in Kathmandu, slowly adding more cities to our list). Today as technology has advanced, online payment can be made with much more ease. Staying with the time, we introduced many other more of payments like Wallets, Bank Transfer and Online Card Payment.</p>\r\n\r\n<p>Today, We try and meet the demand by providing good quality products at reasonal products with easy and fair return policy to our customers.&nbsp;</p>\r\n\r\n<p>We at Jashn aim to making shopping online easy, fun, trustworthy and the best possible experience for our customers. In addition, to make your online shopping experience your most memorable one we have competent employees who sit on customer service desk to answer to every small query of our customers that needs to be addressed.</p>\r\n\r\n<p>&nbsp;</p>', 1, 0, 0, 'KTM RUSH', 'SHOPJASHN', '2021-11-11 06:12:35', '2022-03-10 14:12:01');
INSERT INTO `contents` (`id`, `title`, `slug`, `image`, `display`, `excerpt`, `content`, `order_item`, `child`, `parent_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 'Terms & Conditions', 'terms-conditions', NULL, 1, NULL, '<p><strong>TERMS OF USE</strong></p>\r\n\r\n<p>Effective as of&nbsp; 3rd March 2022</p>\r\n\r\n<p>These Terms of Use (&quot;<strong>Terms</strong>&quot;) apply to the website located at www.shopatjashn.com, the Social Media Accounts, Google Business Account and any other websites or applications associated with <strong>SHOPATJASHN</strong> brands or products that direct the viewer or user to these Terms (collectively, the &quot;<strong>Site</strong>&quot;). In these Terms, the terms &ldquo;SHOPATJASHN,&rdquo;, &ldquo;JASHN&rdquo;, &ldquo;we,&rdquo; and &ldquo;us&rdquo; refers to GAJANAN ENTERPRISES.</p>\r\n\r\n<p>Your access to and use of the Sites is conditioned on your acceptance of and compliance with these Terms. These Terms apply to all visitors, users and others who access or use the Site (collectively, &quot;Users&quot;).&nbsp;<strong>By accessing or using the Site you agree to be bound by these Terms. If you disagree with any part of the Terms, then you should discontinue access or use of the Site.</strong></p>\r\n\r\n<p><strong>2.&nbsp;ACCESS AND USE</strong></p>\r\n\r\n<p>Subject to your compliance with the terms and conditions of these Terms, you may access and use our Site solely for your personal, non-commercial use. We reserve all rights not expressly granted by these Terms in and to our Site and our Intellectual Property (defined below). We may suspend or terminate your access to our Site at any time for any reason or no reason.</p>\r\n\r\n<p><strong>3.&nbsp;RESTRICTIONS</strong></p>\r\n\r\n<p>You will not, and you will not assist, permit or enable others to, do any of the following:</p>\r\n\r\n<ol>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.1</strong>&nbsp;&nbsp; use our Site for any purpose other than as expressly set forth in the &ldquo;Access and Use&rdquo; section above;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.2</strong>&nbsp;&nbsp; disassemble, reverse engineer, decode or decompile any part of our Site;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.3</strong>&nbsp;&nbsp; use any robot, spider, scraper, data mining tool, data gathering or extraction tool, or any other automated means, to access, collect, copy or record the Site;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.4</strong>&nbsp;&nbsp; copy, rent, lease, sell, transfer, assign, sublicense, modify, alter, or create derivative works of any part of our Site or any of our Intellectual Property;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.5</strong>&nbsp;&nbsp; remove any copyright notices or proprietary legends from our Site;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.6</strong>&nbsp;&nbsp; use our Site in a manner that impacts: (i) the stability of our servers; (ii) the operation or performance of our Site or any other User&rsquo;s use of our Site; or (iii) the behavior of other applications using our Site;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.7</strong>&nbsp;&nbsp; use our Site in any manner or for any purpose that violates any applicable law, regulation, legal requirement or obligation, contractual obligation, or any right of any person including, but not limited to, intellectual property rights, rights of privacy and/or rights of personality, or which otherwise may be harmful (in our sole discretion) to us, our providers, our suppliers or Users;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.8</strong>&nbsp;&nbsp; use our Site in competition with us, to develop competing products or services, or otherwise to our detriment or commercial disadvantage;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.9</strong>&nbsp;&nbsp; use our Site for benchmarking or competitive analysis of our Site;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.10</strong>&nbsp;attempt to interfere with, compromise the system integrity or security of, or decipher any transmissions to or from, the servers running our Site;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.11</strong>&nbsp;transmit viruses, worms, or other software agents through our Site;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.12</strong>&nbsp;impersonate another person or misrepresent your affiliation with a person or entity, hide or attempt to hide your identity, or otherwise use our Site for any invasive or fraudulent purpose;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.13</strong>&nbsp;share passwords or authentication credentials for our Site;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.14</strong>&nbsp;bypass the measures we may use to prevent or restrict access to our Site or enforce limitations on use of our Site or the content therein, including without limitation features that prevent or restrict use or copying of any content;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.15</strong>&nbsp;identify us or display any portion of our Site on any site or service that disparages us or our products or services, or infringes any of our intellectual property or other rights; or</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.16</strong>&nbsp;identify or refer to us or our Site in a manner that could reasonably imply an endorsement, relationship or affiliation with or sponsorship between you or a third party and us, other than your permitted use of our Site under these Terms, without our express written consent.</li>\r\n</ol>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>4.&nbsp;USER ACCOUNTS</strong></p>\r\n\r\n<p>Your account on our Site (your&nbsp;<strong>&quot;User Account&quot;</strong>) gives you access to the services and functionality that we may establish and maintain from time to time and in our sole discretion. We may maintain different types of User Accounts for different types of Users.</p>\r\n\r\n<ol>\r\n	<li><strong>4.1</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; You may never use another User&rsquo;s User Account without permission.</li>\r\n	<li><strong>4.2</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; When creating your User Account, you must provide accurate and complete profile information, and you must keep this information up to date.</li>\r\n	<li><strong>4.3</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; You are solely responsible for the activity that occurs on your User Account, and you must keep your User Account password secure. We encourage you to use &quot;strong&quot; passwords (passwords that use a combination of upper and lowercase letters, numbers and symbols) with your User Account.</li>\r\n	<li><strong>4.4</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; You must notify us immediately of any breach of security or unauthorized use of your User Account.</li>\r\n	<li><strong>4.5</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; We will not be liable for any losses caused by any unauthorized use of your User Account.</li>\r\n	<li><strong>4.6</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; By providing us with your email address you consent to our using the email address to send you service-related notices, including any notices required by law, in lieu of communication by postal mail. We may also use your email address to send you other promotional messages, such as changes to features of our Site and special offers.</li>\r\n</ol>\r\n\r\n<p>If you do not want to receive such email messages, you may opt out or change your preferences by contacting JASHN support at&nbsp;jashn@shopatjashn.com&nbsp;or by clicking the unsubscribe link within each promotional message. Opting out may prevent you from receiving email messages regarding updates, improvements, or offers; however, opting out will not prevent you from receiving service-related notices.</p>\r\n\r\n<p>You acknowledge that you do not own the User Account you use to access our Site. Notwithstanding anything in these Terms to the contrary, you agree that we have the absolute right to manage, regulate, control, modify and/or eliminate any data stored by us or on our behalf on our (including by our third party hosting providers&rsquo;) servers as we see fit in our sole discretion, in any general or specific case, and that we will have no liability to you based on our exercise of such right.</p>\r\n\r\n<p>All data on our servers are subject to deletion, alteration or transfer. NOTWITHSTANDING ANY VALUE ATTRIBUTED TO SUCH DATA BY YOU OR ANY THIRD PARTY, YOU UNDERSTAND AND AGREE THAT ANY DATA, USER ACCOUNT HISTORY AND USER ACCOUNT CONTENT RESIDING ON OUR SERVERS, MAY BE DELETED, ALTERED, MOVED OR TRANSFERRED AT ANY TIME FOR ANY REASON IN OUR DISCRETION, WITH OR WITHOUT NOTICE AND WITH NO LIABILITY OF ANY KIND. WE DO NOT PROVIDE OR GUARANTEE, AND EXPRESSLY DISCLAIMS, ANY VALUE, CASH OR OTHERWISE, ATTRIBUTED TO ANY DATA RESIDING ON OUR SERVERS.</p>\r\n\r\n<p>By connecting to our Sites with a third-party service, you give us permission to access and use your information from that service as permitted by that service, and to store your log-in credentials for that service.</p>\r\n\r\n<p><strong>5.&nbsp;USER DATA</strong></p>\r\n\r\n<p>As part of your use and interaction with the Site, we will collect data, metadata, and information, including personal information, that you provide to us or that is collected by us or via the Site, including without limitation as described in our Privacy Policy (<strong>&quot;User Data&quot;</strong>). For clarity, however, User Data does not include your User Content described below. You hereby grant to us, and represent and warrant that you have all rights necessary to grant to us, a perpetual, irrevocable, non-exclusive, sublicensable, transferable and royalty-free right and license to collect, use, reproduce, electronically distribute, transmit, have transmitted, perform, display, store, archive, and to modify and make derivative works of any and all User Data in order to provide and maintain our Site and for such uses as described in our Privacy Policy, and, solely in anonymous or aggregate form, to improve our products and Sites and for our other business purposes (and any and all such derived data is deemed part of our Intellectual Property). We take no responsibility and assume no liability for any of your User Data. You shall be solely responsible and indemnify us for your User Data.</p>\r\n\r\n<p>For the purposes of these Terms,&nbsp;<strong>&quot;Intellectual Property&quot;</strong>&nbsp;means all patent rights, copyright rights, mask work rights, moral rights, rights of publicity, trademark, trade dress and service mark rights, goodwill, trade secret rights and other intellectual property rights as may now exist or hereafter come into existence, and all applications therefore and registrations, renewals and extensions thereof, under the laws of any state, country, territory or other jurisdiction.</p>\r\n\r\n<p><strong>6.&nbsp;OUR PROPRIETARY RIGHTS</strong></p>\r\n\r\n<p>Except for your User Content, you understand and accept that our Site and all materials therein or transferred thereby, including, without limitation, all information, data, text, software, music, sound, photographs, graphics, logos, patents, trademarks, service marks, copyrights, audio, video, message or other material appearing on this Site, including User Content belonging to other Users (collectively, &ldquo;JASHN Content&rdquo;),and all Intellectual Property rights related thereto, are the exclusive property of JASHN and its licensors (including other Users who post User Content to our Site).You are expressly prohibited from using any JASHN Content without the express written consent of JASHN or its licensors. Except as otherwise stated in these Terms, none of the material may be reproduced, distributed, republished, downloaded, displayed, posted, transmitted, or copied in any form or by any means, without the prior written permission of JASHN, and/or the appropriate licensor. Permission is granted to display, copy, distribute, and download the materials on this Site solely for personal, non-commercial use provided that you make no modifications to the materials and that all copyright and other proprietary notices contained in the materials are retained. You may not, without JASHN&#39;s express written permission, &#39;mirror&#39; any material contained on this Site or any other server. Any permission granted under these Terms terminates automatically without further notice if you breach any of the above terms. Upon such termination, you agree to immediately destroy any downloaded and/or printed materials. Any unauthorized use of any material contained on this Site may violate domestic and/or international copyright laws, the laws of privacy and publicity, and communications regulations and statutes.</p>\r\n\r\n<p>ANY USE OF THE SERVICES NOT SPECIFICALLY PERMITTED UNDER THESE TERMS IS STRICTLY PROHIBITED.</p>\r\n\r\n<p><strong>7.&nbsp;INTERACTIONS WITH OTHER USERS</strong></p>\r\n\r\n<p>You are solely responsible for your interactions with other Users. We reserve the right, but have no obligation, to monitor interactions between you and other Users. WE SHALL HAVE NO LIABILITY FOR, AND EXPRESSLY DISCLAIM ALL LIABILITY ARISING FROM, YOUR INTERACTIONS WITH OTHER USERS, OR FOR ANY USER&rsquo;S ACTION OR INACTION.</p>\r\n\r\n<p><strong>8.&nbsp;SERVICE LOCATION; RESTRICTIONS</strong></p>\r\n\r\n<p>Our Site is controlled and operated from facilities of our Server partners. We make no representations that our Site is available for use in other locations. Those who access or use our Site (other than the authorized server partners) from other jurisdictions do so at their own volition and are entirely responsible for compliance with all applicable Nepal and local laws and regulations, including but not limited to export and import regulations.</p>\r\n\r\n<p>Our Authorised Server Partner is _____________________________________ (effective from _______________)</p>\r\n\r\n<p><strong>9.&nbsp;SUBMISSION OF CONTENT; COMMENTS, IMAGES, VIDEOS AND OTHER CONTENT</strong></p>\r\n\r\n<p>The Site allows Users to submit, post, display, provide, or otherwise disclose, or offer in connection with your use of this Site, content, including content from or via third parties or third-party services or other websites such as Facebook or Instagram that may interact with this Site, including comments, ideas, images, photographs, video clips, audio clips, graphics, tags, data, materials, information, and other submissions, including submissions with any hashtags such as #JASHNNEPAL or #SHOPATJASHN (collectively,&nbsp;<strong>&#39;User Content&#39;</strong>). User Content may include personal information. WE CLAIM NO OWNERSHIP RIGHTS OVER USER CONTENT.</p>\r\n\r\n<p>However, you specifically grant us a non-exclusive, transferable, sub-licensable, royalty-free, fully paid up, worldwide license (but not the obligation) to use any User Content (<strong>&ldquo;IP License&rdquo;</strong>). The IP License includes, for example and without limitations, the right and license to use, reproduce, modify, edit, adapt, publish, translate, create derivative works from, distribute, perform and display such material (in whole or part) worldwide and/or to incorporate it in other works in any form, media, or technology now known or later developed, in both digital and physical owned channels, and will not be limited in any way in its use or modifications to the submission, whether for commercial purposes or not, of the User Content. In certain circumstances JASHN may also share your contribution with trusted third parties. You are also granting us a non-exclusive, transferable, sub-licensable, royalty-free, fully paid up, worldwide license (but not the obligation) to use your name, likeness, personality, voice, or any other materials or information you provide to JASHN in connection with your content.</p>\r\n\r\n<p>You further grant, and you represent and warrant that you have all rights necessary to grant, JASHN an irrevocable, transferable, sublicensable (through multiple tiers), fully paid, royalty-free, and worldwide right and license to use, copy, store, modify, and display your User Content: (a) to maintain and provide the Site to you; (b) solely in de-identified form, to improve our products and services and for our other business purposes, such as data analysis, customer research, developing new products or features, and identifying usage trends (and we will own such de-identified data); and (c) to perform such other actions as authorized by you in connection with your use of the Site.</p>\r\n\r\n<p>You understand and agree that it is your obligation to make sure the User Content you submit to the Site must not violate any law or infringe any rights of any third party, including but not limited to any Intellectual Property rights and privacy rights, and you have obtained and are solely responsible for obtaining all consents as may be required by law to post any User Content relating to third parties. You also understand and agree that User Content you submit to the Site must not be and will not contain libelous or otherwise unlawful, abusive, obscene, or otherwise objectionable material in JASHN&rsquo;s sole discretion. For example, and without limitation, you may not post violent, nude, partially nude, discriminatory, unlawful, infringing, hateful, pornographic or sexually suggestive photos or other content via the Site or other websites such as Facebook or Instagram that may interact with this Site.</p>\r\n\r\n<p>JASHN is not and shall not be under any obligation (1) to maintain any User Content in confidence; (2) to pay you any compensation for any User Content; (3) to credit or acknowledge you for User Content; or (4) to respond to any User Content. We take no responsibility and assume no liability for any User Content that you or any other User or third-party posts, sends, or otherwise makes available over our Site. You shall be solely responsible for your User Content and the consequences of posting, publishing it, sharing it, or otherwise making it available on our Site, and you agree that we are only acting as a passive conduit for your online distribution and publication of your User Content. You understand and agree that you may be exposed to User Content that is inaccurate, objectionable, inappropriate for children, or otherwise unsuited to your purpose, and you agree that JASHN shall not be liable for any damages you allege to incur as a result of or relating to any User Content.</p>\r\n\r\n<p>If you do not want to grant JASHN the permission set out above on these terms, please do not submit User Content.</p>\r\n\r\n<p><strong>10.&nbsp; TELEPHONE COMMUNICATIONS AND AGREEMENT TO BE CONTACTED VIA AUTOMATIC DIALER</strong></p>\r\n\r\n<ol>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 10.1 Call Recording and Monitoring.</strong>&nbsp;You acknowledge that telephone calls made to, or received from or on behalf of, JASHN may be monitored and recorded and you agree to such monitoring and recording.</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 10.2 Providing Telephone Numbers and Other Contact Information.</strong>&nbsp;When you provide your contact information to JASHN You certify that any such contact information, including, but not limited to, your name, mailing address, email address, and residential, business or mobile telephone number, is true, accurate, and current. As such, you certify that you are the current subscriber or owner of any telephone number(s) that you provide. You understand that you are strictly prohibited from providing a telephone number that is not your own. If you have an account with us, and if we discover that any contact information provided by you when you set up the account is false or inaccurate, we may suspend or terminate your account at any time.</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 10.3 Change in Ownership of Telephone Number(s).</strong>&nbsp;If you opted-in to receive SMS text messages from us as set forth below, and the ownership of your telephone number(s), were to change, you agree to immediately notify us before the change goes into effect by replying with email Subject -STOP (YOUR NUMBER) via email to jashn@shopatjashn.com.</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 10.4 Your Consent to Receive Automated Calls/Texts from JASHN.</strong>&nbsp;You acknowledge that by voluntarily providing your telephone number to us in any manner (including, without limitation, by signing up to receive text messages when prompted to do so at one of our JASHN stores, on our website or mobile app or social media, or by providing your telephone number when you register for an account), you expressly agree to receive transactions and promotional text messages from JASHN including as they relate to promotions, product recommendations, your account, changes and updates, service outages, reminders, follow ups to any push notifications delivered through our mobile app, or any other information regarding any transaction with JASHN, and/or your relationship with JASHN. You acknowledge and agree that automated calls or text messages may be made to the telephone number provided even if your telephone number is registered on any Do Not Call list. You agree to continue to receive recurring automated calls and text messages from JASHN even if you cancel your JASHN User Account or terminate your relationship with us, until you opt-out as instructed below. You do not have to agree to receive automated promotional calls/texts as a condition of purchasing any goods or services.</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 10.5 Opt-Out Instructions.</strong>&nbsp;Your consent to receive automated calls and texts from us is completely voluntary. You may opt-out at any time. To opt-out please email us with Subject -STOP (YOUR NUMBER) via email to jashn@shopatjashn.com. If you decide to opt-out, you acknowledge and agree to accept one final text/email message from us confirming your opt out. It is your sole responsibility to notify us if you no longer want to receive automated calls or text messages.</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 10.6 Fees and Charges.</strong>&nbsp;There is no fee to receive automated telephone calls or text messages from JASHN. However, you may incur a charge for these calls or text messages from your telephone carrier, which is your sole responsibility. Check your telephone plan and contact your carrier for details. You represent and warrant that you are authorized to incur such charges and acknowledge and agree that JASHN shall not be responsible for such charges.</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 10.7 General. </strong>You are responsible for obtaining and maintaining all telephone devices and other equipment and software, and all internet service provider, mobile service, and other services needed to receive calls and text messages. Text messaging may only be available with select carriers with compatible handsets. Your obligations under this Section of the Terms will survive indefinitely regardless of whether you continue to have an account with JASHN or continue to visit our site or app, or you do not. If you have any questions or need any clarification about any of the information and rules provided in this Section, please send us an email to&nbsp;jashn@shopatjashn.com, or contact our Customer Service at +977 9814327018 (Via Phone Viber or</li>\r\n</ol>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>11.&nbsp;PRIVACY</strong></p>\r\n\r\n<p>We care about the privacy of our Users. You understand that by using our Service you consent to the collection, use and disclosure of your personal information and aggregate and/or anonymized data as set forth, and to have your personal information collected, used, transferred to and processed in Nepal.</p>\r\n\r\n<ol>\r\n	<li>11.1 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; We may collect various pieces of information if you seek to place an order for a product with us on the Site.</li>\r\n	<li>11.2 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; We collect, store and process your data for processing your purchase on the Site and any possible later claims, and to provide you with our services. We may collect personal information including, but not limited to, your title, name, gender, date of birth, email address, postal address, delivery address (if different), telephone number, mobile number, fax number, payment details, payment card details or bank account details.</li>\r\n	<li>11.3 &nbsp;&nbsp;&nbsp; We will use the information you provide to enable us to process your orders and to provide you with the services and information offered through our website and which you request. Further, we will use the information you provide to administer your account with us; verify and carry out financial transactions in relation to payments you make; audit the downloading of data from our website; improve the layout and/or content of the pages of our website and customize them for users; identify visitors on our website; carry out research on our users&#39; demographics; send you information we think you may find useful or which you have requested from us, including information about our products and services, provided you have indicated that you have not objected to being contacted for these purposes. Subject to obtaining your consent we may contact you by email with details of other products and services. If you prefer not to receive any marketing communications from us, you can opt out at any time.</li>\r\n	<li>11.4 &nbsp;&nbsp;&nbsp; We may pass your name and address on to a third party in order to make delivery of the product to you (for example to our courier or supplier). You must only submit to us the Site information which is accurate and not misleading and you must keep it up to date and inform us of changes.</li>\r\n	<li>11.5 &nbsp;&nbsp;&nbsp; We may pass your name and address on to a third party in order to make delivery of the product to you (for example to our courier or supplier). You must only submit to us the Site information which is accurate and not misleading and you must keep it up to date and inform us of changes.</li>\r\n	<li>11.6 &nbsp;&nbsp;&nbsp; We may use your personal information for opinion and market research anonymously and for statistical purpose only</li>\r\n	<li>11.7&nbsp;&nbsp;&nbsp;&nbsp; We may use your personal information to send you other information about us such as sale promotions, our newsletters, anything relating to other companies in our group or our business partners</li>\r\n	<li>11.8 &nbsp;&nbsp;&nbsp; We may exchange information with third parties for the purposes of fraud protection and credit risk reduction. We may transfer our databases containing your personal information if we sell our business or part of it. Other than as set out in this Privacy Policy, we shall NOT sell or disclose your personal data to third parties without obtaining your prior consent unless this is necessary for the purposes set out in this Privacy Policy or unless we are required to do so by law. The Site may contain advertising of third parties and links to other sites or frames of other sites. Please be aware that we are not responsible for the privacy practices or content of those third parties or other sites, nor for any third party to whom we transfer your data in accordance with our Privacy Policy.</li>\r\n	<li>11.9&nbsp;&nbsp;&nbsp;&nbsp; If you are concerned about your data you have the right to request access to the personal data which we may hold or process about you. You have the right to require us to correct any inaccuracies in your data free of charge. At any stage you also have the right to ask us to stop using your personal data for direct marketing purposes.</li>\r\n</ol>\r\n\r\n<p><strong>12.&nbsp;SECURITY</strong></p>\r\n\r\n<p>We care about the integrity and security of your personal information. However, we cannot guarantee that unauthorized third parties will never be able to defeat our commercially reasonable security measures or use your personal information for improper purposes. You acknowledge that you provide your personal information at your own risk.</p>\r\n\r\n<p><strong>13.&nbsp;JASHN&#39;S COMMUNICATIONS TO YOU</strong></p>\r\n\r\n<p>You agree that JASHN may send electronic mail to you for the purpose of advising you of changes or additions to this Site, about any of JASHN&#39;s products or services, or for such other purpose(s) as JASHN deems appropriate.</p>\r\n\r\n<p><strong>14.&nbsp;PROMOTIONS AND CONTESTS</strong></p>\r\n\r\n<p>Any contests or promotions described or posted on this Site shall be governed by the rules regulating such event. By participating in Site sweepstakes, contests, promotions, and/or requesting promotional information or product updates, you agree that JASHN may use your information for marketing and promotional purposes.</p>\r\n\r\n<p><strong>15.&nbsp;PRODUCT INFORMATION</strong></p>\r\n\r\n<p>Most JASHN products displayed at the Site are available in select JASHN stores while supplies last. In some cases, merchandise displayed for sale at the Site may not be available in JASHN stores. The prices displayed at the Site are quoted in Nepali Rupees (NPR) and are valid and effective only in Nepal.</p>\r\n\r\n<p><strong>16. ORDER &amp; REFUNDS</strong></p>\r\n\r\n<p><strong>For Order, Refunds &amp; Exchange Policy please follow our Order, Return &amp; Exchange or Refund Policy</strong></p>\r\n\r\n<p><strong>16.&nbsp;LINKS TO OTHER WEB SITES AND SERVICES</strong></p>\r\n\r\n<p>OUR SERVICE MAY CONTAIN LINKS TO THIRD-PARTY MATERIALS, SITES OR SERVICES THAT ARE NOT OWNED OR CONTROLLED BY JASHN AND CERTAIN FUNCTIONALITY OF OUR SERVICE MAY REQUIRE INTEGRATION WITH OR YOUR USE OF THIRD-PARTY SERVICES. IF YOU USE A THIRD-PARTY SERVICE, YOU ARE SUBJECT TO AND AGREE TO THE THIRD PARTY&rsquo;S TERMS OF SERVICE AND PRIVACY POLICY MADE AVAILABLE ON THEIR SERVICES. WE DO NOT ENDORSE OR ASSUME ANY RESPONSIBILITY FOR ANY SUCH THIRD-PARTY SITES, INFORMATION, MATERIALS, PRODUCTS, OR SERVICES. IF YOU ACCESS A THIRD-PARTY WEBSITE OR SERVICE FROM OUR SERVICE OR SHARE YOUR USER CONTENT ON OR THROUGH ANY THIRD-PARTY WEBSITE OR SERVICE, YOU DO SO AT YOUR OWN RISK, AND YOU UNDERSTAND THAT THIS AGREEMENT AND OUR PRIVACY POLICY DO NOT APPLY TO YOUR USE OF SUCH SERVICES OR SITES. YOU EXPRESSLY RELIEVE JASHN FROM ANY AND ALL LIABILITY ARISING FROM YOUR USE OF ANY THIRD-PARTY WEBSITE, SERVICE, OR CONTENT, INCLUDING WITHOUT LIMITATION USER CONTENT SUBMITTED BY OTHER USERS.</p>\r\n\r\n<p><strong>17.&nbsp;WARRANTIES; DISCLAIMER</strong></p>\r\n\r\n<p>JASHN does not provide warranty on any of the products displayed on our website. However, we do recommend to follow the product care instruction for best use of the same.</p>\r\n\r\n<p><strong>18.&nbsp;INACCURACY DISCLAIMER</strong></p>\r\n\r\n<p>From time to time there may be information on the Site that contains typographical errors, inaccuracies, or omissions that may relate to product descriptions or availability. We reserve the right to correct any errors, inaccuracies or omissions and to change or update information at any time without prior notice (including after you have submitted your order). Price and availability information contained on this site is subject to change without notice. JASHN shall not be bound by any errors or omissions in posting product information or prices with respect to any products or services offered on the Site. All materials and information presented by JASHN on the Site are intended to be used for informational purposes only.</p>\r\n\r\n<p>We have made every effort to display, as accurately as possible, the colors of our products that appear at the Site. However, as the actual colors you see will depend on your monitor, we cannot guarantee that your monitor&#39;s display of any color will be accurate.</p>\r\n\r\n<p>If you are not completely satisfied with your SHOPJASHN.com purchase, you may return it with your invoice by mail. Please see our&nbsp;<strong>Order, Return &amp; Exchange or Refund Policy</strong>&nbsp;for details.</p>\r\n\r\n<p><strong>19.&nbsp;LIMITATION OF LIABILITY</strong></p>\r\n\r\n<p>TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW, IN NO EVENT SHALL JASHN OR ITS , ITS AFFILIATES, AGENTS, DIRECTORS, EMPLOYEES, SUPPLIERS OR LICENSORS (A) BE LIABLE TO THE USER WITH RESPECT TO USE OF THE SITES, THE CONTENT OR THE MATERIALS CONTAINED IN OR ACCESSED THROUGH THE SITES (INCLUDING WITHOUT LIMITATION ANY DAMAGES CAUSED BY OR RESULTING FROM RELIANCE BY A USER ON ANY INFORMATION OBTAINED FROM JASHN), OR ANY DAMAGES THAT RESULT FROM MISTAKES, OMISSIONS, INTERRUPTIONS, DELETION OF FILES OR EMAIL, ERRORS, DEFECTS, VIRUSES, DELAYS IN OPERATION OR TRANSMISSION OR ANY FAILURE OF PERFORMANCE, WHETHER OR NOT RESULTING FROM ACTS OF GOD, COMMUNICATIONS FAILURES, THEFT, DESTRUCTION, FRAUD, OR UNAUTHORIZED ACCESS TO JASHN&#39;S RECORDS, PROGRAMS OR SERVICES; AND (B) BE LIABLE TO THE USER FOR ANY INDIRECT, SPECIAL, INCIDENTAL, CONSEQUENTIAL, PUNITIVE OR EXEMPLARY DAMAGES, INCLUDING, WITHOUT LIMITATION, DAMAGES FOR LOSS OF GOODWILL, LOST PROFITS, LOSS, THEFT OR CORRUPTION OF USER INFORMATION, OR THE INABILITY TO USE THE SITES OR ANY OF THEIR FEATURES. THE USER&rsquo;S SOLE REMEDY IS TO CEASE USE OF THE SITES; (C) PERSONAL INJURY OR PROPERTY DAMAGE, OF ANY NATURE WHATSOEVER, RESULTING FROM YOUR ACCESS TO OR USE OF OUR SITE; (D) ANY UNAUTHORIZED ACCESS TO OR USE OF OUR SECURE SERVERS AND/OR ANY AND ALL PERSONAL INFORMATION STORED THEREIN; AND/OR (E) USER CONTENT OR THE DEFAMATORY, OFFENSIVE, OR ILLEGAL CONDUCT OF ANY THIRD PARTY.</p>\r\n\r\n<p>IN NO EVENT SHALL JASHN, ITS AFFILIATES, AGENTS, DIRECTORS, EMPLOYEES, SUPPLIERS, OR LICENSORS BE LIABLE TO YOU FOR ANY CLAIMS, PROCEEDINGS, LIABILITIES, OBLIGATIONS, DAMAGES, LOSSES OR COSTS IN AN AMOUNT EXCEEDING THE AMOUNT YOU PAID TO JASHN HEREUNDER OR $100.00, WHICHEVER IS GREATER.</p>\r\n\r\n<p>THIS LIMITATION OF LIABILITY SECTION APPLIES WHETHER THE ALLEGED LIABILITY IS BASED ON CONTRACT, TORT, NEGLIGENCE, STRICT LIABILITY, OR ANY OTHER BASIS, EVEN IF JASHN HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.</p>\r\n\r\n<p><strong>20.&nbsp;INDEMNIFICATION</strong></p>\r\n\r\n<p>You (and also any third party for whom you operate an account or activity on the Site or any other third party platform such as social media that may interact with the Site) agree to defend (at JASHNs request), indemnify and hold JASHN and its subsidiaries, agents, licensors, managers, and other affiliated companies, and their employees, contractors, agents, officers and directors harmless from and against any and all claims, damages, costs and expenses, including reasonable attorneys&#39; fees and costs, arising out of or in any way connected with any of the following (including as a result of your direct activities on the Site or those conducted on your behalf): (i) your use of and access to our Site, including any data or content transmitted or received by you; (ii) your breach or alleged breach of these Terms of Use, including without limitation your breach of any of the representations and warranties above; (iii) your violation of any third-party right, including without limitation, any Intellectual Property rights or privacy rights; (iv) your violation of any applicable laws, rules, regulations, codes, statutes, ordinances or orders of any governmental and quasi-governmental authorities, including, without limitation, all regulatory, administrative and legislative authorities; (v) User Data and User Content or any content that is submitted via your User Account including without limitation misleading, false, or inaccurate information; (vi) your willful misconduct; or (vii) any other party&rsquo;s access and use of our Site with your unique username, password or other appropriate security code. You will cooperate as fully required by JASHN in the defense of any claim. JASHN reserves the right to assume the exclusive defense and control of any matter subject to indemnification by you, and you will not in any event settle any claim without the prior written consent of JASHN.</p>\r\n\r\n<p><strong>21.&nbsp;ARBITRATION AND CLASS ACTION/JURY TRIAL WAIVER</strong></p>\r\n\r\n<ol>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 22.1 Arbitration</strong>&nbsp;READ THIS SECTION CAREFULLY BECAUSE IT REQUIRES THE PARTIES TO ARBITRATE THEIR DISPUTES AND LIMITS THE MANNER IN WHICH YOU CAN SEEK RELIEF FROM JASHN For any dispute with JASHN, you agree to first contact us and attempt to resolve the dispute with us informally by sending a notice to:</li>\r\n	<li>GAJANAN ENRERPRISES, POKHARIYA, BIRATNAGAR-2, MORANG</li>\r\n	<li>You must include your name and residence address, the email address you use for your JASHN User Account (if any), and a clear statement of your claim. In the unlikely event that JASHN has not been able to resolve a dispute it has with you after sixty (60) days, we each agree to resolve any claim, dispute, or controversy</li>\r\n</ol>\r\n\r\n<p><strong>22.&nbsp;GOVERNING LAW &amp; VENUE</strong></p>\r\n\r\n<p>These Terms of Use shall be governed by and construed in accordance with the laws of Nepal, without giving effect to its conflict of law rules. In the event of any dispute hereunder, USER and JASHN hereby consent to the exclusive jurisdiction of the court that has jurisdiction over the location of the headquarters of the Company. The parties expressly disclaim the application of the United Nations Convention on Contracts for the International Sale of Goods.</p>\r\n\r\n<p><strong>23.&nbsp;CHANGE IN TERMS</strong></p>\r\n\r\n<p>We may from time to time change the terms that govern your use of our Site. We may change, move or delete portions of, or may add to, our Site from time to time. We reserve the right to determine the form and means of providing notifications to our Users, provided that you may opt out of certain notifications as required under applicable laws or as described in these Terms or our Privacy Policy. We are not responsible for any automatic filtering you or your network provider may apply to email notifications we send to the email address you provide us. Your continued use of our Site following any such change constitutes your agreement and affirmative acceptance to follow and be bound by the modified Terms. If you do not agree to, or cannot comply with, the Terms as modified, you must stop using the Site.</p>\r\n\r\n<p><strong>24.&nbsp;ENTIRE AGREEMENT/SEVERABILITY.</strong></p>\r\n\r\n<p>These Terms, together with any amendments and any additional agreements you may enter into with us in connection with our Site, shall constitute the entire agreement between you and us concerning our Site. None of our employees or representatives are authorized to make any modification or addition to these Terms. Any statements or comments made between you and any of our employees or representatives are expressly excluded from these Terms and will not apply to you or us or your use of our Site. If any provision of these Terms is deemed invalid by a court of competent jurisdiction, the invalidity of such provision shall not affect the validity of the remaining provisions of these Terms, which shall remain in full force and effect, except that in the event of unenforceability of the universal Class Action/Jury Trial Waiver, the entire arbitration agreement shall be unenforceable.</p>\r\n\r\n<p><strong>25.&nbsp;NO WAIVER</strong></p>\r\n\r\n<p>No waiver of any term of these Terms shall be deemed a further or continuing waiver of such term or any other term, and JASHN&rsquo;S failure to assert any right or provision under these Terms shall not constitute a waiver of such right or provision.</p>\r\n\r\n<p><strong>26.&nbsp;CONTACT US</strong></p>\r\n\r\n<p>You may reach us at:&nbsp;<a href=\"mailto:jashn@shopatjashn.com\">jashn@shopatjashn.com</a></p>\r\n\r\n<p>GAJANAN ENRERPRISES</p>\r\n\r\n<p>POKHARIYA</p>\r\n\r\n<p>Biratnagar-1 , Morang</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>TERMS OF USE</strong></p>\r\n\r\n<p>Effective as of _____________________</p>\r\n\r\n<p>These Terms of Use (&quot;<strong>Terms</strong>&quot;) apply to the website located at www.shopatjashn.com, the Social Media Accounts, Google Business Account and any other websites or applications associated with <strong>SHOPATJASHN</strong> brands or products that direct the viewer or user to these Terms (collectively, the &quot;<strong>Site</strong>&quot;). In these Terms, the terms &ldquo;SHOPATJASHN,&rdquo;, &ldquo;JASHN&rdquo;, &ldquo;we,&rdquo; and &ldquo;us&rdquo; refers to GAJANAN ENTERPRISES.</p>\r\n\r\n<p>Your access to and use of the Sites is conditioned on your acceptance of and compliance with these Terms. These Terms apply to all visitors, users and others who access or use the Site (collectively, &quot;Users&quot;).&nbsp;<strong>By accessing or using the Site you agree to be bound by these Terms. If you disagree with any part of the Terms, then you should discontinue access or use of the Site.</strong></p>\r\n\r\n<p><strong>2.&nbsp;ACCESS AND USE</strong></p>\r\n\r\n<p>Subject to your compliance with the terms and conditions of these Terms, you may access and use our Site solely for your personal, non-commercial use. We reserve all rights not expressly granted by these Terms in and to our Site and our Intellectual Property (defined below). We may suspend or terminate your access to our Site at any time for any reason or no reason.</p>\r\n\r\n<p><strong>3.&nbsp;RESTRICTIONS</strong></p>\r\n\r\n<p>You will not, and you will not assist, permit or enable others to, do any of the following:</p>\r\n\r\n<ol>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.1</strong>&nbsp;&nbsp; use our Site for any purpose other than as expressly set forth in the &ldquo;Access and Use&rdquo; section above;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.2</strong>&nbsp;&nbsp; disassemble, reverse engineer, decode or decompile any part of our Site;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.3</strong>&nbsp;&nbsp; use any robot, spider, scraper, data mining tool, data gathering or extraction tool, or any other automated means, to access, collect, copy or record the Site;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.4</strong>&nbsp;&nbsp; copy, rent, lease, sell, transfer, assign, sublicense, modify, alter, or create derivative works of any part of our Site or any of our Intellectual Property;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.5</strong>&nbsp;&nbsp; remove any copyright notices or proprietary legends from our Site;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.6</strong>&nbsp;&nbsp; use our Site in a manner that impacts: (i) the stability of our servers; (ii) the operation or performance of our Site or any other User&rsquo;s use of our Site; or (iii) the behavior of other applications using our Site;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.7</strong>&nbsp;&nbsp; use our Site in any manner or for any purpose that violates any applicable law, regulation, legal requirement or obligation, contractual obligation, or any right of any person including, but not limited to, intellectual property rights, rights of privacy and/or rights of personality, or which otherwise may be harmful (in our sole discretion) to us, our providers, our suppliers or Users;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.8</strong>&nbsp;&nbsp; use our Site in competition with us, to develop competing products or services, or otherwise to our detriment or commercial disadvantage;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.9</strong>&nbsp;&nbsp; use our Site for benchmarking or competitive analysis of our Site;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.10</strong>&nbsp;attempt to interfere with, compromise the system integrity or security of, or decipher any transmissions to or from, the servers running our Site;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.11</strong>&nbsp;transmit viruses, worms, or other software agents through our Site;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.12</strong>&nbsp;impersonate another person or misrepresent your affiliation with a person or entity, hide or attempt to hide your identity, or otherwise use our Site for any invasive or fraudulent purpose;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.13</strong>&nbsp;share passwords or authentication credentials for our Site;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.14</strong>&nbsp;bypass the measures we may use to prevent or restrict access to our Site or enforce limitations on use of our Site or the content therein, including without limitation features that prevent or restrict use or copying of any content;</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.15</strong>&nbsp;identify us or display any portion of our Site on any site or service that disparages us or our products or services, or infringes any of our intellectual property or other rights; or</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 3.16</strong>&nbsp;identify or refer to us or our Site in a manner that could reasonably imply an endorsement, relationship or affiliation with or sponsorship between you or a third party and us, other than your permitted use of our Site under these Terms, without our express written consent.</li>\r\n</ol>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>4.&nbsp;USER ACCOUNTS</strong></p>\r\n\r\n<p>Your account on our Site (your&nbsp;<strong>&quot;User Account&quot;</strong>) gives you access to the services and functionality that we may establish and maintain from time to time and in our sole discretion. We may maintain different types of User Accounts for different types of Users.</p>\r\n\r\n<ol>\r\n	<li><strong>4.1</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; You may never use another User&rsquo;s User Account without permission.</li>\r\n	<li><strong>4.2</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; When creating your User Account, you must provide accurate and complete profile information, and you must keep this information up to date.</li>\r\n	<li><strong>4.3</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; You are solely responsible for the activity that occurs on your User Account, and you must keep your User Account password secure. We encourage you to use &quot;strong&quot; passwords (passwords that use a combination of upper and lowercase letters, numbers and symbols) with your User Account.</li>\r\n	<li><strong>4.4</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; You must notify us immediately of any breach of security or unauthorized use of your User Account.</li>\r\n	<li><strong>4.5</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; We will not be liable for any losses caused by any unauthorized use of your User Account.</li>\r\n	<li><strong>4.6</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; By providing us with your email address you consent to our using the email address to send you service-related notices, including any notices required by law, in lieu of communication by postal mail. We may also use your email address to send you other promotional messages, such as changes to features of our Site and special offers.</li>\r\n</ol>\r\n\r\n<p>If you do not want to receive such email messages, you may opt out or change your preferences by contacting JASHN support at&nbsp;jashn@shopatjashn.com&nbsp;or by clicking the unsubscribe link within each promotional message. Opting out may prevent you from receiving email messages regarding updates, improvements, or offers; however, opting out will not prevent you from receiving service-related notices.</p>\r\n\r\n<p>You acknowledge that you do not own the User Account you use to access our Site. Notwithstanding anything in these Terms to the contrary, you agree that we have the absolute right to manage, regulate, control, modify and/or eliminate any data stored by us or on our behalf on our (including by our third party hosting providers&rsquo;) servers as we see fit in our sole discretion, in any general or specific case, and that we will have no liability to you based on our exercise of such right.</p>\r\n\r\n<p>All data on our servers are subject to deletion, alteration or transfer. NOTWITHSTANDING ANY VALUE ATTRIBUTED TO SUCH DATA BY YOU OR ANY THIRD PARTY, YOU UNDERSTAND AND AGREE THAT ANY DATA, USER ACCOUNT HISTORY AND USER ACCOUNT CONTENT RESIDING ON OUR SERVERS, MAY BE DELETED, ALTERED, MOVED OR TRANSFERRED AT ANY TIME FOR ANY REASON IN OUR DISCRETION, WITH OR WITHOUT NOTICE AND WITH NO LIABILITY OF ANY KIND. WE DO NOT PROVIDE OR GUARANTEE, AND EXPRESSLY DISCLAIMS, ANY VALUE, CASH OR OTHERWISE, ATTRIBUTED TO ANY DATA RESIDING ON OUR SERVERS.</p>\r\n\r\n<p>By connecting to our Sites with a third-party service, you give us permission to access and use your information from that service as permitted by that service, and to store your log-in credentials for that service.</p>\r\n\r\n<p><strong>5.&nbsp;USER DATA</strong></p>\r\n\r\n<p>As part of your use and interaction with the Site, we will collect data, metadata, and information, including personal information, that you provide to us or that is collected by us or via the Site, including without limitation as described in our Privacy Policy (<strong>&quot;User Data&quot;</strong>). For clarity, however, User Data does not include your User Content described below. You hereby grant to us, and represent and warrant that you have all rights necessary to grant to us, a perpetual, irrevocable, non-exclusive, sublicensable, transferable and royalty-free right and license to collect, use, reproduce, electronically distribute, transmit, have transmitted, perform, display, store, archive, and to modify and make derivative works of any and all User Data in order to provide and maintain our Site and for such uses as described in our Privacy Policy, and, solely in anonymous or aggregate form, to improve our products and Sites and for our other business purposes (and any and all such derived data is deemed part of our Intellectual Property). We take no responsibility and assume no liability for any of your User Data. You shall be solely responsible and indemnify us for your User Data.</p>\r\n\r\n<p>For the purposes of these Terms,&nbsp;<strong>&quot;Intellectual Property&quot;</strong>&nbsp;means all patent rights, copyright rights, mask work rights, moral rights, rights of publicity, trademark, trade dress and service mark rights, goodwill, trade secret rights and other intellectual property rights as may now exist or hereafter come into existence, and all applications therefore and registrations, renewals and extensions thereof, under the laws of any state, country, territory or other jurisdiction.</p>\r\n\r\n<p><strong>6.&nbsp;OUR PROPRIETARY RIGHTS</strong></p>\r\n\r\n<p>Except for your User Content, you understand and accept that our Site and all materials therein or transferred thereby, including, without limitation, all information, data, text, software, music, sound, photographs, graphics, logos, patents, trademarks, service marks, copyrights, audio, video, message or other material appearing on this Site, including User Content belonging to other Users (collectively, &ldquo;JASHN Content&rdquo;),and all Intellectual Property rights related thereto, are the exclusive property of JASHN and its licensors (including other Users who post User Content to our Site).You are expressly prohibited from using any JASHN Content without the express written consent of JASHN or its licensors. Except as otherwise stated in these Terms, none of the material may be reproduced, distributed, republished, downloaded, displayed, posted, transmitted, or copied in any form or by any means, without the prior written permission of JASHN, and/or the appropriate licensor. Permission is granted to display, copy, distribute, and download the materials on this Site solely for personal, non-commercial use provided that you make no modifications to the materials and that all copyright and other proprietary notices contained in the materials are retained. You may not, without JASHN&#39;s express written permission, &#39;mirror&#39; any material contained on this Site or any other server. Any permission granted under these Terms terminates automatically without further notice if you breach any of the above terms. Upon such termination, you agree to immediately destroy any downloaded and/or printed materials. Any unauthorized use of any material contained on this Site may violate domestic and/or international copyright laws, the laws of privacy and publicity, and communications regulations and statutes.</p>\r\n\r\n<p>ANY USE OF THE SERVICES NOT SPECIFICALLY PERMITTED UNDER THESE TERMS IS STRICTLY PROHIBITED.</p>\r\n\r\n<p><strong>7.&nbsp;INTERACTIONS WITH OTHER USERS</strong></p>\r\n\r\n<p>You are solely responsible for your interactions with other Users. We reserve the right, but have no obligation, to monitor interactions between you and other Users. WE SHALL HAVE NO LIABILITY FOR, AND EXPRESSLY DISCLAIM ALL LIABILITY ARISING FROM, YOUR INTERACTIONS WITH OTHER USERS, OR FOR ANY USER&rsquo;S ACTION OR INACTION.</p>\r\n\r\n<p><strong>8.&nbsp;SERVICE LOCATION; RESTRICTIONS</strong></p>\r\n\r\n<p>Our Site is controlled and operated from facilities of our Server partners. We make no representations that our Site is available for use in other locations. Those who access or use our Site (other than the authorized server partners) from other jurisdictions do so at their own volition and are entirely responsible for compliance with all applicable Nepal and local laws and regulations, including but not limited to export and import regulations.</p>\r\n\r\n<p>Our Authorised Server Partner is _____________________________________ (effective from _______________)</p>\r\n\r\n<p><strong>9.&nbsp;SUBMISSION OF CONTENT; COMMENTS, IMAGES, VIDEOS AND OTHER CONTENT</strong></p>\r\n\r\n<p>The Site allows Users to submit, post, display, provide, or otherwise disclose, or offer in connection with your use of this Site, content, including content from or via third parties or third-party services or other websites such as Facebook or Instagram that may interact with this Site, including comments, ideas, images, photographs, video clips, audio clips, graphics, tags, data, materials, information, and other submissions, including submissions with any hashtags such as #JASHNNEPAL or #SHOPATJASHN (collectively,&nbsp;<strong>&#39;User Content&#39;</strong>). User Content may include personal information. WE CLAIM NO OWNERSHIP RIGHTS OVER USER CONTENT.</p>\r\n\r\n<p>However, you specifically grant us a non-exclusive, transferable, sub-licensable, royalty-free, fully paid up, worldwide license (but not the obligation) to use any User Content (<strong>&ldquo;IP License&rdquo;</strong>). The IP License includes, for example and without limitations, the right and license to use, reproduce, modify, edit, adapt, publish, translate, create derivative works from, distribute, perform and display such material (in whole or part) worldwide and/or to incorporate it in other works in any form, media, or technology now known or later developed, in both digital and physical owned channels, and will not be limited in any way in its use or modifications to the submission, whether for commercial purposes or not, of the User Content. In certain circumstances JASHN may also share your contribution with trusted third parties. You are also granting us a non-exclusive, transferable, sub-licensable, royalty-free, fully paid up, worldwide license (but not the obligation) to use your name, likeness, personality, voice, or any other materials or information you provide to JASHN in connection with your content.</p>\r\n\r\n<p>You further grant, and you represent and warrant that you have all rights necessary to grant, JASHN an irrevocable, transferable, sublicensable (through multiple tiers), fully paid, royalty-free, and worldwide right and license to use, copy, store, modify, and display your User Content: (a) to maintain and provide the Site to you; (b) solely in de-identified form, to improve our products and services and for our other business purposes, such as data analysis, customer research, developing new products or features, and identifying usage trends (and we will own such de-identified data); and (c) to perform such other actions as authorized by you in connection with your use of the Site.</p>\r\n\r\n<p>You understand and agree that it is your obligation to make sure the User Content you submit to the Site must not violate any law or infringe any rights of any third party, including but not limited to any Intellectual Property rights and privacy rights, and you have obtained and are solely responsible for obtaining all consents as may be required by law to post any User Content relating to third parties. You also understand and agree that User Content you submit to the Site must not be and will not contain libelous or otherwise unlawful, abusive, obscene, or otherwise objectionable material in JASHN&rsquo;s sole discretion. For example, and without limitation, you may not post violent, nude, partially nude, discriminatory, unlawful, infringing, hateful, pornographic or sexually suggestive photos or other content via the Site or other websites such as Facebook or Instagram that may interact with this Site.</p>\r\n\r\n<p>JASHN is not and shall not be under any obligation (1) to maintain any User Content in confidence; (2) to pay you any compensation for any User Content; (3) to credit or acknowledge you for User Content; or (4) to respond to any User Content. We take no responsibility and assume no liability for any User Content that you or any other User or third-party posts, sends, or otherwise makes available over our Site. You shall be solely responsible for your User Content and the consequences of posting, publishing it, sharing it, or otherwise making it available on our Site, and you agree that we are only acting as a passive conduit for your online distribution and publication of your User Content. You understand and agree that you may be exposed to User Content that is inaccurate, objectionable, inappropriate for children, or otherwise unsuited to your purpose, and you agree that JASHN shall not be liable for any damages you allege to incur as a result of or relating to any User Content.</p>\r\n\r\n<p>If you do not want to grant JASHN the permission set out above on these terms, please do not submit User Content.</p>\r\n\r\n<p><strong>10.&nbsp; TELEPHONE COMMUNICATIONS AND AGREEMENT TO BE CONTACTED VIA AUTOMATIC DIALER</strong></p>\r\n\r\n<ol>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 10.1 Call Recording and Monitoring.</strong>&nbsp;You acknowledge that telephone calls made to, or received from or on behalf of, JASHN may be monitored and recorded and you agree to such monitoring and recording.</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 10.2 Providing Telephone Numbers and Other Contact Information.</strong>&nbsp;When you provide your contact information to JASHN You certify that any such contact information, including, but not limited to, your name, mailing address, email address, and residential, business or mobile telephone number, is true, accurate, and current. As such, you certify that you are the current subscriber or owner of any telephone number(s) that you provide. You understand that you are strictly prohibited from providing a telephone number that is not your own. If you have an account with us, and if we discover that any contact information provided by you when you set up the account is false or inaccurate, we may suspend or terminate your account at any time.</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 10.3 Change in Ownership of Telephone Number(s).</strong>&nbsp;If you opted-in to receive SMS text messages from us as set forth below, and the ownership of your telephone number(s), were to change, you agree to immediately notify us before the change goes into effect by replying with email Subject -STOP (YOUR NUMBER) via email to jashn@shopatjashn.com.</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 10.4 Your Consent to Receive Automated Calls/Texts from JASHN.</strong>&nbsp;You acknowledge that by voluntarily providing your telephone number to us in any manner (including, without limitation, by signing up to receive text messages when prompted to do so at one of our JASHN stores, on our website or mobile app or social media, or by providing your telephone number when you register for an account), you expressly agree to receive transactions and promotional text messages from JASHN including as they relate to promotions, product recommendations, your account, changes and updates, service outages, reminders, follow ups to any push notifications delivered through our mobile app, or any other information regarding any transaction with JASHN, and/or your relationship with JASHN. You acknowledge and agree that automated calls or text messages may be made to the telephone number provided even if your telephone number is registered on any Do Not Call list. You agree to continue to receive recurring automated calls and text messages from JASHN even if you cancel your JASHN User Account or terminate your relationship with us, until you opt-out as instructed below. You do not have to agree to receive automated promotional calls/texts as a condition of purchasing any goods or services.</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 10.5 Opt-Out Instructions.</strong>&nbsp;Your consent to receive automated calls and texts from us is completely voluntary. You may opt-out at any time. To opt-out please email us with Subject -STOP (YOUR NUMBER) via email to jashn@shopatjashn.com. If you decide to opt-out, you acknowledge and agree to accept one final text/email message from us confirming your opt out. It is your sole responsibility to notify us if you no longer want to receive automated calls or text messages.</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 10.6 Fees and Charges.</strong>&nbsp;There is no fee to receive automated telephone calls or text messages from JASHN. However, you may incur a charge for these calls or text messages from your telephone carrier, which is your sole responsibility. Check your telephone plan and contact your carrier for details. You represent and warrant that you are authorized to incur such charges and acknowledge and agree that JASHN shall not be responsible for such charges.</li>\r\n	<li><strong>&nbsp; &nbsp; &nbsp; 10.7 General. </strong>You are responsible for obtaining and maintaining all telephone devices and other equipment and software, and all internet service provider, mobile service, and other services needed to receive calls and text messages. Text messaging may only be available with select carriers with compatible handsets. Your obligations under this Section of the Terms will survive indefinitely regardless of whether you continue to have an account with JASHN or continue to visit our site or app, or you do not. If you have any questions or need any clarification about any of the information and rules provided in this Section, please send us an email to&nbsp;jashn@shopatjashn.com, or contact our Customer Service at +977 9814327018 (Via Phone Viber or</li>\r\n</ol>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>11.&nbsp;PRIVACY</strong></p>\r\n\r\n<p>We care about the privacy of our Users. You understand that by using our Service you consent to the collection, use and disclosure of your personal information and aggregate and/or anonymized data as set forth, and to have your personal information collected, used, transferred to and processed in Nepal.</p>\r\n\r\n<ol>\r\n	<li>11.1 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; We may collect various pieces of information if you seek to place an order for a product with us on the Site.</li>\r\n	<li>11.2 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; We collect, store and process your data for processing your purchase on the Site and any possible later claims, and to provide you with our services. We may collect personal information including, but not limited to, your title, name, gender, date of birth, email address, postal address, delivery address (if different), telephone number, mobile number, fax number, payment details, payment card details or bank account details.</li>\r\n	<li>11.3 &nbsp;&nbsp;&nbsp; We will use the information you provide to enable us to process your orders and to provide you with the services and information offered through our website and which you request. Further, we will use the information you provide to administer your account with us; verify and carry out financial transactions in relation to payments you make; audit the downloading of data from our website; improve the layout and/or content of the pages of our website and customize them for users; identify visitors on our website; carry out research on our users&#39; demographics; send you information we think you may find useful or which you have requested from us, including information about our products and services, provided you have indicated that you have not objected to being contacted for these purposes. Subject to obtaining your consent we may contact you by email with details of other products and services. If you prefer not to receive any marketing communications from us, you can opt out at any time.</li>\r\n	<li>11.4 &nbsp;&nbsp;&nbsp; We may pass your name and address on to a third party in order to make delivery of the product to you (for example to our courier or supplier). You must only submit to us the Site information which is accurate and not misleading and you must keep it up to date and inform us of changes.</li>\r\n	<li>11.5 &nbsp;&nbsp;&nbsp; We may pass your name and address on to a third party in order to make delivery of the product to you (for example to our courier or supplier). You must only submit to us the Site information which is accurate and not misleading and you must keep it up to date and inform us of changes.</li>\r\n	<li>11.6 &nbsp;&nbsp;&nbsp; We may use your personal information for opinion and market research anonymously and for statistical purpose only</li>\r\n	<li>11.7&nbsp;&nbsp;&nbsp;&nbsp; We may use your personal information to send you other information about us such as sale promotions, our newsletters, anything relating to other companies in our group or our business partners</li>\r\n	<li>11.8 &nbsp;&nbsp;&nbsp; We may exchange inf', 2, 0, 0, 'KTM RUSH', 'SHOPJASHN', '2021-11-11 06:14:19', '2022-03-05 17:00:15');
INSERT INTO `contents` (`id`, `title`, `slug`, `image`, `display`, `excerpt`, `content`, `order_item`, `child`, `parent_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 'Order, Return & Exchange Policy', 'order-return-exchange-policy', NULL, 1, NULL, '<p>Order Policy</p>\r\n\r\n<ol>\r\n	<li>All Orders need to be made via our website <a href=\"http://www.shopatjashn.com\">www.shopatjashn.com</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>\r\n	<li>All Orders shall be processed only after the same has been confirmed on call for new customers or will be treated as confirm orders if from verified number (customer)</li>\r\n	<li>The Order delivery date will be estimated as per once mentioned on the Final Order Slip. This can be seen once at Checkout Page, Order Detail on website (My Accounts &gt; My Order). Same shall also be send via email (If provided).</li>\r\n	<li>All Returns shall be process only from the website only, as per the return policy.</li>\r\n	<li>In case of prepayment, the order shall only be processed once the payment has been received by us. Payment confirmation shall be sent via SMS or email. For easy process please share the payment voucher (Screenshot or deposit slip) with us (social media account, Email, or website) with your order number. Any payments if not verified can result in the delay in order processing.</li>\r\n	<li>On confirming the order, Jashn understands that you have seen and read all details provided about the product (such as Color, Fabric, Size, Price, Real Image &amp; Delivery date).</li>\r\n	<li>On confirming the order, Jashn understands that you have seen and read our Terms &amp; Conditions of the website</li>\r\n	<li>Jashn has the right to cancel any order, if it looks or seems likes a spam or fake order. Any cancellation will be informed by SMS or Email. For details on the same, it can be viewed in MY Accounts &gt; Order section of the website.</li>\r\n</ol>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Return Policy</p>\r\n\r\n<p>A Customer has the right to return the order received on any of the below reasons</p>\r\n\r\n<ol>\r\n	<li>If product quality is not as mentioned on the product description (this clause does not include personal view or opinion, but general view of the product. This Clause does not apply if real image for the same has been shared on our website, social media accounts)</li>\r\n	<li>If size does not fit (In this case, the product will be exchanged once the order has been returned back to us within 7 working days)</li>\r\n	<li>If the product received is in damage condition.</li>\r\n	<li>If product received is different than mentioned when placing the order (This Clause does not apply if real image for the same has been shared on our website, social media accounts)</li>\r\n</ol>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>In case of any returns, it must be processed from the website (My accounts&gt; Orders and Return).</p>\r\n\r\n<ol>\r\n	<li>Steps for Return<br />\r\n	The Customer shall request for return from the order section from the website. You will need to visit My Accounts&gt; Orders&gt; Click on the order number and click on Return next to the product. Do note this must be done within 72 hours of receiving the order (From Date of Delivery). Incase if the order has not been updated as delivered, please wait for 1 days or call the customer care number for assistance. Or same can be done from Return Request Link here</li>\r\n	<li>The customer will be led to a second page, where they can see the order number, product name, product net price (Price after discounts).</li>\r\n	<li>Here they will need to chose the reason for return along with at least one image of the product received.</li>\r\n	<li>The customer care shall respond to within 2 working days.</li>\r\n	<li>For Update on your return, please refer with the return request number.</li>\r\n</ol>\r\n\r\n<p>Do note your request is subjected to being approved based on the reason provided and its validity. The status of the return request shall be sent to you via SMS or Email. For more details you can always see the same on My Accounts&gt;Orders section of the website.</p>\r\n\r\n<p>Jashn holds the final decision to approve the request or not. The customer does have the right to contest the same in the court of law.</p>\r\n\r\n<p>On Approvable of Returns the following steps needs to be followed.</p>\r\n\r\n<ol>\r\n	<li>You need to apply for returns claims within 72 hours of receiving the order, else it will be not be considered.</li>\r\n	<li>The Product must be sent back to us in its original packaging along with any tags, vouchers received and Invoice with the order. Jashn has the right to cancel the return request if the products have not been received in full.</li>\r\n	<li>The ordered product needs to be sent back to us at our office once the return has been approved within 7 working days.\r\n	<ol>\r\n		<li>Gajanan Enterprises<br />\r\n		Radhe Krishnamarg, Pokhariya<br />\r\n		Biratnagar &ndash; 1<br />\r\n		Morang (Nepal)</li>\r\n		<li>The charges for the return packet need to be reimbursed by Jashn (based on our courier rates) unless it falls under Return Reason 2 (Size does not fit)</li>\r\n	</ol>\r\n	</li>\r\n	<li>If the product has not been received back in its original condition with all original packing, tags, invoice and vouchers send along with the order. If worn, used or damaged) we shall not process the return.</li>\r\n</ol>\r\n\r\n<p>Payments Mode</p>\r\n\r\n<ol>\r\n	<li>Only the mode of payment mentioned on the website shall be considered as official mode of payment. Our team will not encourage you to make payment in any other format or accounts. We request you to strictly follow the modes of payment of our website to avoid any loss.</li>\r\n	<li>Cash on delivery (COD) option shall be subjected to Jashn Management decision. This option is limited to certain cities only. The upper limit for COD option is of Rs10000/-</li>\r\n	<li>In case of pre-payment (either by debit or credit card, wallets or Net Banking), you request you to send us the voucher along with the order number either via message on social media account, website chat or email for easy processing of the order</li>\r\n	<li>Any payments if not verified can result in the delay in order processing.</li>\r\n	<li>Do note if order has been returned to us stating failed delivery, and if we need to send the order again via courier or any other means the cost shall be borne by the customer.</li>\r\n	<li>Jashn is not responsible if the payments sent via the customer are to the wrong account details other than mentioned on our website.</li>\r\n</ol>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Refund Policy</p>\r\n\r\n<ol>\r\n	<li>All refunds shall be done once the ordered product has been returned back to Jashn. The order returned must comply with the return policy mentioned above.</li>\r\n	<li>Any refunds shall be sent to the customer bank account as provided by them after deducting any charges incurred on their behalf while they returned the product.</li>\r\n	<li>The Refund amount will be equal to the net values paid for the product (i.e., after deducting all the discount, offer and point value used)</li>\r\n	<li>The refund shall be processed within 3 working days on receiving the returned Product</li>\r\n	<li>Jashn shall send the Transaction voucher for the refund via email, or social media account.</li>\r\n	<li>We request you to confirm if the payment has been received or not within 24 hours, so that if any errors can be resolved. In case of any claims after 24 hours Jashn shall not be responsible.</li>\r\n	<li>The refunds are given on the below conditions on\r\n	<ol>\r\n		<li>The Product order has been delayed and is no longer needed. This clause becomes void if the customer not receiving the product after it&rsquo;s been made ready for shipment. (By &ldquo;DELAY&rdquo;, it means the order is not ready for shipment within the estimated date provided while placing the order. &ldquo;Ready for Shipment&rdquo; Means the ordered products have been packed, invoiced &amp; handed over to the courier company. A SMS/email is sent with the tracking details once the order is ready for shipment. Any refund claims must be made before this stage.)</li>\r\n		<li>The Product order falls under any of the Return policy Reason</li>\r\n		<li>The Size requested is no longer available. This does not include the term Size does not fit (In such a case product will be exchanged only).</li>\r\n		<li>If Jashn is not able to fulfil your order (within the said time frame). This clause becomes void if the customer not receiving the product after it&rsquo;s been made ready for shipment.</li>\r\n	</ol>\r\n	</li>\r\n</ol>\r\n\r\n<p>Failed Delivery Reason</p>\r\n\r\n<ol>\r\n	<li>Customer not available at the time of delivery. The courier office has returned us the packet cause the customer was not available at the time of delivery</li>\r\n	<li>The Phone of the customer is not available once the order is ready for courier</li>\r\n</ol>\r\n\r\n<p>Other Order Cancelled Reason</p>\r\n\r\n<ol>\r\n	<li>Product has gone out of stock</li>\r\n	<li>Time taken is more than stated</li>\r\n	<li>Product is different</li>\r\n	<li>Product is damaged</li>\r\n	<li>Size does not fit</li>\r\n	<li>Spam or Fake order</li>\r\n</ol>', 3, 0, 0, 'KTM RUSH', 'SHOPJASHN', '2021-11-11 06:15:00', '2022-03-05 17:01:28'),
(4, 'Payment Policy', 'payment-policy', NULL, 1, NULL, '<p>Payments Mode</p>\r\n\r\n<ol>\r\n	<li>Only the mode of payment mentioned on the website shall be considered as official mode of payment. Our team will not encourage you to make payment in any other format or accounts. We request you to strictly follow the modes of payment of our website to avoid any loss.</li>\r\n	<li>Cash on delivery (COD) option shall be subjected to Jashn Management decision. This option is limited to certain cities only. The upper limit for COD option is of Rs10000/-</li>\r\n	<li>In case of pre-payment (either by debit or credit card, wallets or Net Banking), you request you to send us the voucher along with the order number either via message on social media account, website chat or email for easy processing of the order</li>\r\n	<li>Any payments if not verified can result in the delay in order processing.</li>\r\n	<li>Do note if order has been returned to us stating failed delivery, and if we need to send the order again via courier or any other means the cost shall be borne by the customer.</li>\r\n	<li>Jashn is not responsible if the payments sent via the customer are to the wrong account details other than mentioned on our website.</li>\r\n</ol>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Refund Policy</p>\r\n\r\n<ol>\r\n	<li>All refunds shall be done once the ordered product has been returned back to Jashn. The order returned must comply with the return policy mentioned above.</li>\r\n	<li>Any refunds shall be sent to the customer bank account as provided by them after deducting any charges incurred on their behalf while they returned the product.</li>\r\n	<li>The Refund amount will be equal to the net values paid for the product (i.e., after deducting all the discount, offer and point value used)</li>\r\n	<li>The refund shall be processed within 3 working days on receiving the returned Product</li>\r\n	<li>Jashn shall send the Transaction voucher for the refund via email, or social media account.</li>\r\n	<li>We request you to confirm if the payment has been received or not within 24 hours, so that if any errors can be resolved. In case of any claims after 24 hours Jashn shall not be responsible.</li>\r\n	<li>The refunds are given on the below conditions on\r\n	<ol>\r\n		<li>The Product order has been delayed and is no longer needed. This clause becomes void if the customer not receiving the product after it&rsquo;s been made ready for shipment. (By &ldquo;DELAY&rdquo;, it means the order is not ready for shipment within the estimated date provided while placing the order. &ldquo;Ready for Shipment&rdquo; Means the ordered products have been packed, invoiced &amp; handed over to the courier company. A SMS/email is sent with the tracking details once the order is ready for shipment. Any refund claims must be made before this stage.)</li>\r\n		<li>The Product order falls under any of the Return policy Reason</li>\r\n		<li>The Size requested is no longer available. This does not include the term Size does not fit (In such a case product will be exchanged only).</li>\r\n		<li>If Jashn is not able to fulfil your order (within the said time frame). This clause becomes void if the customer not receiving the product after it&rsquo;s been made ready for shipment.</li>\r\n	</ol>\r\n	</li>\r\n</ol>', 4, 0, 0, 'KTM RUSH', 'SHOPJASHN', '2021-11-11 06:19:27', '2022-03-05 17:02:16'),
(5, 'FAQ', 'faq', NULL, 1, NULL, '<p><strong>1. How do we place an order?</strong></p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; Placing an order has been made very easy. All you need to do is</p>\r\n\r\n<ul>\r\n	<li>Chose the product you would like to order</li>\r\n	<li>Select the size &amp; Quantity</li>\r\n	<li>Click on &ldquo;Buy Now&rdquo; or to continue Shopping click on &ldquo;Move to Cart&rdquo;</li>\r\n	<li>Go to the cart and fill in your delivery details</li>\r\n	<li>Chose the payment terms &amp; confirm your transaction</li>\r\n	<li>You will receive an sms and email containing your order details once the order is confirmed. (Do check your spam or bulk mail for the email.)</li>\r\n</ul>\r\n\r\n<p>For assistance you can always call our customer care number +977 9814327018 (also available on Viber and Whats app. We also have a live chat feature on the website)</p>\r\n\r\n<hr />\r\n<p><strong>2. How do we make the payments?</strong></p>\r\n\r\n<p>You have 3&nbsp;modes to make the payment</p>\r\n\r\n<ul>\r\n	<li>Online Card Payment (Debit &amp; Credit Card) Both Nepal &amp; International Cards are accepted</li>\r\n	<li>Cash On Delivery &ndash; (You can pay at the time of delivery, We provide this service at few cities.)</li>\r\n	<li>Esewa (Details mentioned in the Payment option)</li>\r\n</ul>\r\n\r\n<p>Please note any charge incurred to make the payment will be borne by the customer.&nbsp;Delivery charges will be applicable unless otherwise mentioned.</p>\r\n\r\n<hr />\r\n<p><strong>3. What about Return &amp; Damage policy?</strong></p>\r\n\r\n<p>We do take returns of products on the following conditions</p>\r\n\r\n<ul>\r\n	<li>If product quality is not as mentioned on the product description (this clause does not include personal view or opinion, but general view of the product. This Clause does not apply if real image for the same has been shared on our website, social media accounts)</li>\r\n	<li>If size does not fit (In this case, the product will be exchanged once the order has been returned back to us within 7 working days)</li>\r\n	<li>If the product received is in damage condition.</li>\r\n	<li>If product received is different than mentioned when placing the order (This Clause does not apply if real image for the same has been shared on our website, social media accounts)</li>\r\n</ul>\r\n\r\n<hr />\r\n<p><strong>4. What if I have made the payment and the product is not delivered?</strong></p>\r\n\r\n<p>If the payment is made and the product is not delivered within the said time, you can email us at&nbsp;&nbsp;jashn@shopatjashn.com&nbsp;and intimate us for a refund. Your entire amount shall be returned without questions asked as long as it meets the refund policy. Please mention your name, contact number and your order number in the email for an easy refund. Or<br />\r\n&nbsp;</p>\r\n\r\n<hr />\r\n<p><strong>5. How long does my order take to be delivered?</strong></p>\r\n\r\n<p>The Time taken to deliver the product is mentioned in the product detail. If the product is in stock when you have placed the order, it usually takes 3-4 working days to deliver. Otherwise the dates are mentioned in the product detail itself. Please confirm the estimate delivery time mentioned in the cart.</p>\r\n\r\n<hr />\r\n<p><strong>6. How will I know if my order has been placed?</strong></p>\r\n\r\n<p>Once your order has been placed you shall receive an sms and email for confirmation containing the order number, the product details along all other important information. If you do not receive the sms and email within 24 hours of placing the order please call customer care to confirm the order at +977 9814327018. The Same number is available at Whats App &amp; Viber also</p>\r\n\r\n<hr />\r\n<p><strong>7. Is there any other information about the product that we need to know?</strong></p>\r\n\r\n<p>Most of the information regarding the product is&nbsp;mentioned in the product details.&nbsp;Sometimes the real image of the product may be different from the model photo, which is also shown in the product detail.<br />\r\nIf you still would like to clarify more information about the product you can call us between 10 am to 5.30&nbsp;pm or get in touch with us via social media like our Facebook page or Instagram page or through Viber or Whats App. We also have an Live Chat facility at the website.</p>\r\n\r\n<hr />\r\n<p><strong>8. Is there any hidden cost?</strong></p>\r\n\r\n<p>No there is no hidden cost or addition expense that you will need to pay. The entire amount payable shall be mentioned on the order confirmation email send to you. Neither the delivery person nor the company shall ask you to make any addition payments. But please do note if the address mentioned is different than the delivery location, additional charge may be added by the delivery team.</p>\r\n\r\n<hr />\r\n<p><strong>9. Is our Card details safe on www.shopatjashn.com ?</strong></p>\r\n\r\n<p>We do not store any information regarding your card on our servers. Neither our customer service team nor any email communication will ask you for any such details. We also advise you not to share your details with anyone to avoid any security issues.</p>\r\n\r\n<hr />\r\n<p><strong>10. Can we come and see the product and buy them?</strong></p>\r\n\r\n<p>Yes, you can call us (at 9814327018) and fix an appointment to visit our office . You are most welcome to visit us during our working ours to select the products and buy them from there, Otherwise we ship only confirmed orders.</p>\r\n\r\n<hr />\r\n<p>&nbsp;</p>', 4, 0, 0, 'KTM RUSH', 'SHOPJASHN', '2021-11-11 06:19:27', '2022-03-10 14:58:49');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display` tinyint(1) DEFAULT 1,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `country_code`, `display`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Nepal', '977', 1, 'SHOPJASHN', NULL, '2022-03-05 17:18:00', '2022-03-05 17:18:00');

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

CREATE TABLE `couriers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`id`, `created_at`, `updated_at`, `name`, `email`, `phone`, `address`, `display`, `created_by`, `updated_by`) VALUES
(5, '2022-03-05 17:22:08', '2022-03-05 17:22:08', 'Aramex Courier', 'surya@aramex.com', '9804381233', 'Opp Himalayan Takkies, Himalayan Road, Biratnagar', 1, 'SHOPJASHN', NULL),
(6, '2022-03-05 17:23:53', '2022-03-05 17:24:27', 'Daraz Kamyu Pvt Ltd', 'seller.np@care.daraz.com', '01-5970597', 'Global IME Bank Building, Tinpanee, Biratnagar', 1, 'SHOPJASHN', 'SHOPJASHN');

-- --------------------------------------------------------

--
-- Table structure for table `courier_rates`
--

CREATE TABLE `courier_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `half_kg` double(8,2) DEFAULT NULL,
  `one_kg` double(8,2) DEFAULT NULL,
  `one_half_kg` double(8,2) DEFAULT NULL,
  `two_kg` double(8,2) DEFAULT NULL,
  `two_half_kg` double(8,2) DEFAULT NULL,
  `three_kg` double(8,2) DEFAULT NULL,
  `three_half_kg` double(8,2) DEFAULT NULL,
  `four_kg` double(8,2) DEFAULT NULL,
  `four_half_kg` double(8,2) DEFAULT NULL,
  `five_kg` double(8,2) DEFAULT NULL,
  `per_500g` double(8,2) DEFAULT NULL,
  `display` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courier_rates`
--

INSERT INTO `courier_rates` (`id`, `country_id`, `state_id`, `district_id`, `half_kg`, `one_kg`, `one_half_kg`, `two_kg`, `two_half_kg`, `three_kg`, `three_half_kg`, `four_kg`, `four_half_kg`, `five_kg`, `per_500g`, `display`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(7, 1, 13, 56, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:42:20', '2022-03-06 23:42:20'),
(8, 1, 13, 57, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:42:20', '2022-03-06 23:42:20'),
(9, 1, 13, 58, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:42:20', '2022-03-06 23:42:20'),
(10, 1, 13, 59, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:42:20', '2022-03-06 23:42:20'),
(11, 1, 13, 60, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:42:20', '2022-03-06 23:42:20'),
(12, 1, 13, 61, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:42:20', '2022-03-06 23:42:20'),
(13, 1, 13, 66, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:42:20', '2022-03-06 23:42:20'),
(14, 1, 13, 67, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:42:20', '2022-03-06 23:42:20'),
(15, 1, 14, 62, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:44:00', '2022-03-06 23:44:00'),
(16, 1, 14, 63, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:44:00', '2022-03-06 23:44:00'),
(17, 1, 14, 64, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:44:00', '2022-03-06 23:44:00'),
(18, 1, 14, 65, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:44:00', '2022-03-06 23:44:00'),
(19, 1, 14, 89, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 6060.00, 1, NULL, NULL, '2022-03-06 23:44:00', '2022-03-06 23:44:00'),
(20, 1, 14, 90, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:44:00', '2022-03-06 23:44:00'),
(21, 1, 15, 68, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:44:59', '2022-03-06 23:44:59'),
(22, 1, 15, 69, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:44:59', '2022-03-06 23:44:59'),
(23, 1, 15, 70, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:44:59', '2022-03-06 23:44:59'),
(24, 1, 15, 71, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:44:59', '2022-03-06 23:44:59'),
(25, 1, 15, 72, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:44:59', '2022-03-06 23:44:59'),
(26, 1, 15, 73, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:44:59', '2022-03-06 23:44:59'),
(27, 1, 15, 74, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:44:59', '2022-03-06 23:44:59'),
(28, 1, 15, 75, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:44:59', '2022-03-06 23:44:59'),
(29, 1, 16, 76, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:45:35', '2022-03-06 23:45:35'),
(30, 1, 16, 77, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:45:35', '2022-03-06 23:45:35'),
(31, 1, 16, 78, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:45:35', '2022-03-06 23:45:35'),
(32, 1, 16, 79, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:45:35', '2022-03-06 23:45:35'),
(33, 1, 16, 91, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:45:35', '2022-03-06 23:45:35'),
(34, 1, 17, 81, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:47:07', '2022-03-06 23:47:07'),
(35, 1, 17, 82, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:47:08', '2022-03-06 23:47:08'),
(36, 1, 17, 83, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:47:08', '2022-03-06 23:47:08'),
(37, 1, 17, 84, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:47:08', '2022-03-06 23:47:08'),
(38, 1, 17, 85, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:47:08', '2022-03-06 23:47:08'),
(39, 1, 17, 86, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:47:08', '2022-03-06 23:47:08'),
(40, 1, 17, 93, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:47:08', '2022-03-06 23:47:08'),
(41, 1, 17, 94, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:47:08', '2022-03-06 23:47:08'),
(42, 1, 17, 95, 115.00, 175.00, 235.00, 295.00, 255.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:47:08', '2022-03-06 23:47:08'),
(43, 1, 18, 80, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:47:53', '2022-03-06 23:47:53'),
(44, 1, 18, 92, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:47:53', '2022-03-06 23:47:53'),
(45, 1, 19, 87, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:48:15', '2022-03-06 23:48:15'),
(46, 1, 19, 88, 115.00, 175.00, 235.00, 295.00, 355.00, 415.00, 475.00, 535.00, 595.00, 655.00, 60.00, 1, NULL, NULL, '2022-03-06 23:48:15', '2022-03-06 23:48:15');

-- --------------------------------------------------------

--
-- Table structure for table `customer_addresses`
--

CREATE TABLE `customer_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `pin_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_address_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street_address_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_billing_address` tinyint(1) NOT NULL DEFAULT 0,
  `is_shipping_address` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_addresses`
--

INSERT INTO `customer_addresses` (`id`, `user_id`, `name`, `pan`, `phone`, `phone2`, `email`, `country_id`, `state_id`, `district_id`, `city_id`, `pin_code`, `street_address_1`, `street_address_2`, `is_billing_address`, `is_shipping_address`, `created_at`, `updated_at`) VALUES
(1, 5, 'Gehendra Chaudhary', NULL, '9849507010', NULL, 'gehendra@ktmrush.com', 1, 7, 4, 1, '00977', 'Sundhara-5', NULL, 0, 0, '2021-09-21 06:10:01', '2021-10-06 02:18:49'),
(2, 5, 'Gehendra Chaudhary', NULL, '9849507010', NULL, 'gehendra@ktmrush.com', 1, 7, 4, 1, NULL, 'Sundhara-5', NULL, 0, 0, '2021-09-21 06:10:20', '2021-10-06 01:29:22'),
(3, 5, 'John Doe', '1234567890', '9801374870', '9849507010', 'johndoe@ktmrush.com', 1, 3, 1, 2, '00977', 'Langan Tole', 'Sundhara', 1, 1, '2021-09-21 06:15:59', '2022-02-25 05:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `c_o_d_s`
--

CREATE TABLE `c_o_d_s` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `display` tinyint(1) DEFAULT 1,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discount_coupons`
--

CREATE TABLE `discount_coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_type` tinyint(4) NOT NULL,
  `coupon_usage` tinyint(4) NOT NULL,
  `coupon_usage_count` tinyint(4) NOT NULL DEFAULT 1,
  `minimum_quantity` double(8,2) DEFAULT NULL,
  `minimum_spend` double(8,2) NOT NULL DEFAULT 0.00,
  `maximum_discount` double(8,2) DEFAULT NULL,
  `discount_percentage` double(8,2) DEFAULT NULL,
  `start_date` date NOT NULL,
  `expire_date` date NOT NULL,
  `start_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_on` tinyint(4) NOT NULL,
  `discount_items` longtext COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '[]',
  `display` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discount_coupons`
--

INSERT INTO `discount_coupons` (`id`, `name`, `code`, `discount_type`, `coupon_usage`, `coupon_usage_count`, `minimum_quantity`, `minimum_spend`, `maximum_discount`, `discount_percentage`, `start_date`, `expire_date`, `start_time`, `expire_time`, `discount_on`, `discount_items`, `display`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Jashn First Purchase', 'JASHN500', 1, 1, 1, NULL, 0.00, 500.00, 20.00, '2022-03-11', '2022-03-24', '00:00', '23:59', 3, '[]', 1, '2022-03-11 18:36:26', '2022-03-11 18:36:26', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `display` tinyint(1) DEFAULT 1,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `state_id`, `country_id`, `display`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(56, 'Dhankuta', 13, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:02:39', '2022-03-06 23:02:39'),
(57, 'Ilam', 13, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:02:47', '2022-03-06 23:02:47'),
(58, 'Jhapa', 13, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:02:54', '2022-03-06 23:02:54'),
(59, 'Morang', 13, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:03:03', '2022-03-06 23:03:03'),
(60, 'Sunsari', 13, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:03:11', '2022-03-06 23:03:11'),
(61, 'Udayapur', 13, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:03:27', '2022-03-06 23:03:27'),
(62, 'Bara', 14, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:04:16', '2022-03-06 23:04:16'),
(63, 'Dhanusha', 14, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:04:25', '2022-03-06 23:04:25'),
(64, 'Parsa', 14, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:04:34', '2022-03-06 23:04:34'),
(65, 'Saptari', 14, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:04:43', '2022-03-06 23:04:43'),
(66, 'Sarlahi', 13, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:04:51', '2022-03-06 23:04:51'),
(67, 'Siraha', 13, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:05:05', '2022-03-06 23:05:05'),
(68, 'Bhaktapur', 15, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:05:12', '2022-03-06 23:05:12'),
(69, 'Chitwan', 15, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:05:17', '2022-03-06 23:05:17'),
(70, 'Dolakha', 15, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:05:22', '2022-03-06 23:05:22'),
(71, 'Kathmandu', 15, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:05:28', '2022-03-06 23:05:28'),
(72, 'Kavrepalanchok', 15, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:05:34', '2022-03-06 23:05:34'),
(73, 'Lalitpur', 15, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:05:39', '2022-03-06 23:05:39'),
(74, 'Makwanpur', 15, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:05:56', '2022-03-06 23:05:56'),
(75, 'Sindhuli', 15, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:06:01', '2022-03-06 23:06:01'),
(76, 'Baglung', 16, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:06:15', '2022-03-06 23:06:15'),
(77, 'Gorkha', 16, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:06:25', '2022-03-06 23:06:25'),
(78, 'Kaski', 16, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:06:34', '2022-03-06 23:06:34'),
(79, 'Tanahun', 16, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:06:43', '2022-03-06 23:06:43'),
(80, 'Surkhet', 18, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:06:57', '2022-03-06 23:06:57'),
(81, 'Banke', 17, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:07:23', '2022-03-06 23:07:23'),
(82, 'Dang Deukhuri', 17, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:07:33', '2022-03-06 23:07:33'),
(83, 'Kapilvastu', 17, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:07:41', '2022-03-06 23:07:41'),
(84, 'NawalParasi', 17, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:07:50', '2022-03-06 23:07:50'),
(85, 'Palpa', 17, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:07:59', '2022-03-06 23:07:59'),
(86, 'Rupandehi', 17, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:08:06', '2022-03-06 23:08:06'),
(87, 'Kailali', 19, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:08:21', '2022-03-06 23:08:21'),
(88, 'Kanchanpur', 19, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:08:56', '2022-03-06 23:08:56'),
(89, 'Sarlahi', 14, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:13:43', '2022-03-06 23:13:43'),
(90, 'Mahottari', 14, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:17:25', '2022-03-06 23:17:25'),
(91, 'Myagdi ', 16, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:18:23', '2022-03-06 23:18:23'),
(92, 'Salyan', 18, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:18:41', '2022-03-06 23:18:41'),
(93, 'Nawalpur', 17, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:19:08', '2022-03-06 23:19:08'),
(94, 'Bardiya', 17, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:19:36', '2022-03-06 23:19:36'),
(95, 'Parasi', 17, 1, 1, 'SHOPJASHN', NULL, '2022-03-06 23:32:11', '2022-03-06 23:32:11');

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
(4, '2021_06_20_135603_create_permission_tables', 1),
(5, '2021_06_21_175242_create_categories_table', 2),
(6, '2021_06_23_171621_create_occassions_table', 3),
(7, '2021_06_23_171708_create_colors_table', 3),
(8, '2021_07_11_063038_create_site_settings_table', 4),
(16, '2021_07_11_104449_create_size_groups_table', 5),
(17, '2021_07_11_105032_create_sizes_table', 5),
(18, '2021_07_14_120827_create_size_guides_table', 5),
(21, '2021_07_30_090025_create_product_cares_table', 6),
(40, '2021_08_10_103924_create_products_table', 7),
(41, '2021_08_11_110051_create_product_variations_table', 7),
(42, '2021_08_23_070633_create_occassion_products_table', 7),
(57, '2021_08_20_071506_create_countries_table', 8),
(58, '2021_08_21_040753_create_states_table', 8),
(59, '2021_08_22_075927_create_districts_table', 8),
(60, '2021_08_22_080113_create_cities_table', 8),
(61, '2021_08_23_054619_create_couriers_table', 8),
(63, '2021_08_24_084214_create_c_o_d_s_table', 8),
(64, '2021_08_25_082437_create_sliders_table', 9),
(65, '2021_08_25_082755_create_banners_table', 9),
(66, '2021_08_27_063602_create_blogs_table', 9),
(67, '2021_09_20_102005_create_customer_addresses_table', 10),
(70, '2021_10_06_100703_create_orders_table', 11),
(71, '2021_10_06_101358_create_ordered_products_table', 11),
(86, '2021_10_07_105541_create_return_requests_table', 12),
(87, '2021_10_07_110538_create_return_request_products_table', 12),
(89, '2021_11_11_113059_create_contents_table', 13),
(91, '2021_11_14_080059_create_wishlists_table', 14),
(92, '2021_12_13_120018_create_product_reviews_table', 15),
(93, '2021_12_16_101704_create_on_routes_table', 16),
(97, '2021_12_19_113809_create_offers_table', 17),
(98, '2022_01_18_073108_create_product_colors_table', 18),
(99, '2022_01_18_075456_create_product_sizes_table', 18),
(100, '2021_08_23_065856_create_courier_rates_table', 19);

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
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 10),
(1, 'App\\Models\\User', 11),
(2, 'App\\Models\\User', 5);

-- --------------------------------------------------------

--
-- Table structure for table `occassions`
--

CREATE TABLE `occassions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `occassions`
--

INSERT INTO `occassions` (`id`, `title`, `slug`, `image`, `display`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(6, 'Casual Wear', 'casual-wear', NULL, 1, 'SHOPJASHN', NULL, '2022-03-05 18:29:31', '2022-03-05 18:29:31'),
(7, 'Party wear', 'party-wear', NULL, 1, 'SHOPJASHN', 'SHOPJASHN', '2022-03-05 18:29:42', '2022-03-06 17:20:19'),
(8, 'Formal', 'formal', NULL, 1, 'SHOPJASHN', NULL, '2022-03-05 18:29:48', '2022-03-05 18:29:48'),
(9, 'Business', 'business', NULL, 1, 'SHOPJASHN', NULL, '2022-03-05 18:29:55', '2022-03-05 18:29:55'),
(10, 'Evening Formals', 'evening-formals', NULL, 1, 'SHOPJASHN', NULL, '2022-03-05 18:30:02', '2022-03-05 18:30:02'),
(11, 'Beach Wear', 'beach-wear', NULL, 1, 'SHOPJASHN', NULL, '2022-03-05 18:30:08', '2022-03-05 18:30:08'),
(12, 'Suitable for All Occasions', 'suitable-for-all-occasions', NULL, 1, 'SHOPJASHN', NULL, '2022-03-05 18:30:14', '2022-03-05 18:30:14'),
(13, 'Travel', 'travel', NULL, 1, 'SHOPJASHN', NULL, '2022-03-05 18:30:20', '2022-03-05 18:30:20'),
(14, 'Special Occasion', 'special-occasion', NULL, 1, 'SHOPJASHN', NULL, '2022-03-05 18:30:26', '2022-03-05 18:30:26'),
(15, 'Sports', 'sports', NULL, 1, 'SHOPJASHN', NULL, '2022-03-05 18:30:31', '2022-03-05 18:30:31'),
(16, 'Bridal', 'bridal', NULL, 1, 'SHOPJASHN', NULL, '2022-03-05 18:30:37', '2022-03-05 18:30:37'),
(18, 'Semi Formal', 'semi-formal-1', NULL, 1, 'SHOPJASHN', NULL, '2022-03-05 18:30:45', '2022-03-05 18:30:45'),
(19, 'Festive Wear', 'festive-wear', NULL, 1, 'SHOPJASHN', NULL, '2022-03-05 18:30:50', '2022-03-05 18:30:50'),
(20, 'Office Wear', 'office-wear', NULL, 1, 'SHOPJASHN', NULL, '2022-03-05 18:30:56', '2022-03-05 18:30:56');

-- --------------------------------------------------------

--
-- Table structure for table `occassion_products`
--

CREATE TABLE `occassion_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `occassion_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `occassion_products`
--

INSERT INTO `occassion_products` (`id`, `occassion_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 6, 1, '2022-03-06 15:45:06', '2022-03-06 15:45:06'),
(2, 20, 1, '2022-03-06 15:45:06', '2022-03-06 15:45:06'),
(3, 6, 2, '2022-03-07 16:57:13', '2022-03-07 16:57:13'),
(4, 20, 2, '2022-03-07 16:57:13', '2022-03-07 16:57:13'),
(5, 7, 3, '2022-03-07 17:03:42', '2022-03-07 17:03:42'),
(6, 18, 3, '2022-03-07 17:03:42', '2022-03-07 17:03:42'),
(7, 20, 3, '2022-03-07 17:03:42', '2022-03-07 17:03:42'),
(8, 6, 4, '2022-03-07 17:08:15', '2022-03-07 17:08:15'),
(9, 11, 4, '2022-03-07 17:08:15', '2022-03-07 17:08:15'),
(10, 13, 4, '2022-03-07 17:08:15', '2022-03-07 17:08:15'),
(11, 6, 5, '2022-03-07 17:12:05', '2022-03-07 17:12:05'),
(12, 13, 5, '2022-03-07 17:12:05', '2022-03-07 17:12:05'),
(13, 6, 6, '2022-03-07 17:39:39', '2022-03-07 17:39:39'),
(14, 20, 6, '2022-03-07 17:39:39', '2022-03-07 17:39:39'),
(15, 8, 7, '2022-03-07 17:58:16', '2022-03-07 17:58:16'),
(16, 18, 7, '2022-03-07 17:58:16', '2022-03-07 17:58:16'),
(17, 20, 7, '2022-03-07 17:58:16', '2022-03-07 17:58:16'),
(18, 12, 8, '2022-03-07 18:03:29', '2022-03-07 18:03:29'),
(19, 6, 9, '2022-03-07 21:58:07', '2022-03-07 21:58:07'),
(20, 11, 9, '2022-03-07 21:58:07', '2022-03-07 21:58:07'),
(21, 13, 9, '2022-03-07 21:58:07', '2022-03-07 21:58:07'),
(22, 15, 9, '2022-03-07 21:58:07', '2022-03-07 21:58:07');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `offer_type` tinyint(4) NOT NULL,
  `minimum_quantity` double(8,2) DEFAULT NULL,
  `minimum_spend` double(8,2) DEFAULT NULL,
  `maximum_discount` double(8,2) DEFAULT NULL,
  `discount_percentage` double(8,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `start_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_on` tinyint(4) NOT NULL,
  `discount_items` longtext COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '[]',
  `display` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `name`, `offer_type`, `minimum_quantity`, `minimum_spend`, `maximum_discount`, `discount_percentage`, `start_date`, `expire_date`, `start_time`, `expire_time`, `discount_on`, `discount_items`, `display`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Dashain Offer', 1, 3.00, NULL, 1000.00, 20.00, '2022-03-14', '2022-03-21', '00:00', '23:59', 2, '[]', 1, NULL, NULL, '2022-03-11 18:40:32', '2022-03-11 18:40:32'),
(2, 'Free Shipping', 3, NULL, NULL, NULL, NULL, '2022-03-29', '2022-03-29', '', NULL, 4, '[]', 1, NULL, NULL, '2022-03-11 21:32:47', '2022-03-11 21:32:47');

-- --------------------------------------------------------

--
-- Table structure for table `on_routes`
--

CREATE TABLE `on_routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ordered_products`
--

CREATE TABLE `ordered_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_price` double(8,2) NOT NULL,
  `variation_id` bigint(20) UNSIGNED NOT NULL,
  `preorder_status` tinyint(1) NOT NULL DEFAULT 0,
  `color_id` bigint(20) UNSIGNED NOT NULL,
  `color_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size_id` bigint(20) UNSIGNED NOT NULL,
  `size_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `sub_total` double(8,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT 0,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_details` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_details` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_details` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `delivery_charge` double(8,2) NOT NULL DEFAULT 0.00,
  `total_price` double(8,2) NOT NULL,
  `payment_status` tinyint(4) NOT NULL DEFAULT 0,
  `payment_method` tinyint(4) NOT NULL DEFAULT 1,
  `delivery_method` tinyint(4) NOT NULL DEFAULT 0,
  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_date` datetime DEFAULT NULL,
  `order_json` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `additional_message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_no`, `customer_id`, `customer_name`, `customer_email`, `customer_phone`, `billing_details`, `shipping_details`, `coupon_details`, `status`, `delivery_charge`, `total_price`, `payment_status`, `payment_method`, `delivery_method`, `payment_id`, `paid_date`, `order_json`, `additional_message`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '20220001', 11, 'Rohit Dhanawat', 'drohit1984@gmail.com', '9852026391', '{\"billing_name\":\"Rohit Dhanawat\",\"billing_pan\":null,\"billing_phone\":\"9852026391\",\"billing_phone2\":null,\"billing_email\":\"drohit1984@gmail.com\",\"billing_country_id\":\"1\",\"billing_state_id\":\"13\",\"billing_district_id\":\"56\",\"billing_city_id\":\"16\",\"billing_pin_code\":\"56613\",\"billing_street_address_1\":\"Biratnagar\",\"billing_street_address_2\":null}', '{\"shipping_name\":\"Rohit Dhanawat\",\"shipping_pan\":null,\"shipping_phone\":\"9852026391\",\"shipping_phone2\":null,\"shipping_email\":\"drohit1984@gmail.com\",\"shipping_country_id\":\"1\",\"shipping_state_id\":\"13\",\"shipping_district_id\":\"56\",\"shipping_city_id\":\"16\",\"shipping_pin_code\":\"56613\",\"shipping_street_address_1\":\"Biratnagar\",\"shipping_street_address_2\":null}', '[]', 0, 115.00, 2915.00, 0, 1, 0, '20220001', NULL, '[{\"cart_id\":3,\"product_id\":1,\"product_title\":\"Smart Crepe Round Neck Kurti\",\"product_color_id\":1,\"color_name\":\"Blue\",\"color_code\":\"#1b1bdb\",\"product_size_id\":3,\"size_name\":\"XL\",\"ordered_qty\":\"1\",\"sub_total\":1400},{\"cart_id\":5,\"product_id\":1,\"product_title\":\"Smart Crepe Round Neck Kurti\",\"product_color_id\":1,\"color_name\":\"Blue\",\"color_code\":null,\"product_size_id\":5,\"size_name\":\"3XL\",\"ordered_qty\":1,\"sub_total\":1400}]', NULL, 'Customer', NULL, '2022-03-07 00:03:36', '2022-03-07 00:03:36'),
(2, '20220002', 0, 'Rohit', 'drohit1984@gmail.com', '9852026391', '{\"billing_name\":\"Rohit\",\"billing_pan\":null,\"billing_phone\":\"9852026391\",\"billing_phone2\":null,\"billing_email\":\"drohit1984@gmail.com\",\"billing_country_id\":\"1\",\"billing_state_id\":\"13\",\"billing_district_id\":\"57\",\"billing_city_id\":\"17\",\"billing_pin_code\":\"854328\",\"billing_street_address_1\":\"main road\",\"billing_street_address_2\":null}', '{\"shipping_name\":\"Rohit\",\"shipping_pan\":null,\"shipping_phone\":\"9852026391\",\"shipping_phone2\":null,\"shipping_email\":\"drohit1984@gmail.com\",\"shipping_country_id\":\"1\",\"shipping_state_id\":\"13\",\"shipping_district_id\":\"57\",\"shipping_city_id\":\"17\",\"shipping_pin_code\":\"854328\",\"shipping_street_address_1\":\"main road\",\"shipping_street_address_2\":null}', '[]', 0, 115.00, 3065.00, 0, 1, 0, '20220002', NULL, '[{\"cart_id\":11,\"product_id\":4,\"product_title\":\"Cool Summer Rayon Kaftans\",\"product_color_id\":7,\"color_name\":\"Blue\",\"color_code\":\"#1b1bdb\",\"product_size_id\":11,\"size_name\":\"Free Upto 5xl\",\"ordered_qty\":1,\"sub_total\":2950}]', NULL, 'Customer', NULL, '2022-03-07 17:22:22', '2022-03-07 17:22:22'),
(3, '20220003', 11, 'Nidhi', 'drohit1984@gmail.com', '98765432133', '{\"billing_name\":\"Nidhi\",\"billing_pan\":null,\"billing_phone\":\"98765432133\",\"billing_phone2\":null,\"billing_email\":\"drohit1984@gmail.com\",\"billing_country_id\":\"1\",\"billing_state_id\":\"13\",\"billing_district_id\":\"59\",\"billing_city_id\":\"21\",\"billing_pin_code\":\"56613\",\"billing_street_address_1\":\"main road\",\"billing_street_address_2\":null}', '{\"shipping_name\":\"Nidhi\",\"shipping_pan\":null,\"shipping_phone\":\"98765432133\",\"shipping_phone2\":null,\"shipping_email\":\"drohit1984@gmail.com\",\"shipping_country_id\":\"1\",\"shipping_state_id\":\"13\",\"shipping_district_id\":\"59\",\"shipping_city_id\":\"21\",\"shipping_pin_code\":\"56613\",\"shipping_street_address_1\":\"main road\",\"shipping_street_address_2\":null}', '[]', 0, 115.00, 1615.00, 0, 1, 0, '20220003', NULL, '[{\"cart_id\":16,\"product_id\":5,\"product_title\":\"Digital Print Crepe Kurti\",\"product_color_id\":9,\"color_name\":\"Blue\",\"color_code\":null,\"product_size_id\":16,\"size_name\":\"XXL\",\"ordered_qty\":1,\"sub_total\":1500}]', NULL, 'Customer', NULL, '2022-03-07 17:24:48', '2022-03-07 17:24:48'),
(4, '20220004', 11, 'Rohit', 'drohit1984@gmail.com', '9852026391', '{\"billing_name\":\"Rohit\",\"billing_pan\":null,\"billing_phone\":\"9852026391\",\"billing_phone2\":null,\"billing_email\":\"drohit1984@gmail.com\",\"billing_country_id\":\"1\",\"billing_state_id\":\"13\",\"billing_district_id\":\"59\",\"billing_city_id\":\"41\",\"billing_pin_code\":\"854328\",\"billing_street_address_1\":\"main road\",\"billing_street_address_2\":null}', '{\"shipping_name\":\"Rohit\",\"shipping_pan\":null,\"shipping_phone\":\"9852026391\",\"shipping_phone2\":null,\"shipping_email\":\"drohit1984@gmail.com\",\"shipping_country_id\":\"1\",\"shipping_state_id\":\"13\",\"shipping_district_id\":\"59\",\"shipping_city_id\":\"41\",\"shipping_pin_code\":\"854328\",\"shipping_street_address_1\":\"main road\",\"shipping_street_address_2\":null}', '[]', 0, 115.00, 1515.00, 0, 1, 0, '20220004', NULL, '[{\"cart_id\":6,\"product_id\":2,\"product_title\":\"Digital Print Silky Chiffon Saree\",\"product_color_id\":2,\"color_name\":\"Red\",\"color_code\":\"#ff0000\",\"product_size_id\":6,\"size_name\":\"5.5\\/0.80 MTRS\",\"ordered_qty\":1,\"sub_total\":1400}]', NULL, 'Customer', NULL, '2022-03-07 22:02:34', '2022-03-07 22:02:34'),
(5, '20220005', 11, 'Rohit', 'drohit1984@gmail.com', '9852026391', '{\"billing_name\":\"Rohit\",\"billing_pan\":null,\"billing_phone\":\"9852026391\",\"billing_phone2\":null,\"billing_email\":\"drohit1984@gmail.com\",\"billing_country_id\":\"1\",\"billing_state_id\":\"13\",\"billing_district_id\":\"58\",\"billing_city_id\":\"18\",\"billing_pin_code\":\"854328\",\"billing_street_address_1\":\"main road\",\"billing_street_address_2\":null}', '{\"shipping_name\":\"Rohit\",\"shipping_pan\":null,\"shipping_phone\":\"9852026391\",\"shipping_phone2\":null,\"shipping_email\":\"drohit1984@gmail.com\",\"shipping_country_id\":\"1\",\"shipping_state_id\":\"13\",\"shipping_district_id\":\"58\",\"shipping_city_id\":\"18\",\"shipping_pin_code\":\"854328\",\"shipping_street_address_1\":\"main road\",\"shipping_street_address_2\":null}', '[]', 0, 175.00, 2975.00, 0, 1, 0, '20220005', NULL, '[{\"cart_id\":6,\"product_id\":2,\"product_title\":\"Digital Print Silky Chiffon Saree\",\"product_color_id\":2,\"color_name\":\"Red\",\"color_code\":\"#ff0000\",\"product_size_id\":6,\"size_name\":\"5.5\\/0.80 MTRS\",\"ordered_qty\":1,\"sub_total\":1400},{\"cart_id\":8,\"product_id\":2,\"product_title\":\"Digital Print Silky Chiffon Saree\",\"product_color_id\":4,\"color_name\":\"Yellow\",\"color_code\":null,\"product_size_id\":8,\"size_name\":\"5.5\\/0.80 MTRS\",\"ordered_qty\":1,\"sub_total\":1400}]', NULL, 'Customer', NULL, '2022-03-07 23:02:09', '2022-03-07 23:02:09'),
(6, '20220006', 0, 'Rohit', 'drohit1984@gmail.com', '9852026391', '{\"billing_name\":\"Rohit\",\"billing_pan\":null,\"billing_phone\":\"9852026391\",\"billing_phone2\":null,\"billing_email\":\"drohit1984@gmail.com\",\"billing_country_id\":\"1\",\"billing_state_id\":\"13\",\"billing_district_id\":\"57\",\"billing_city_id\":\"17\",\"billing_pin_code\":\"854328\",\"billing_street_address_1\":\"main road\",\"billing_street_address_2\":null}', '{\"shipping_name\":\"Rohit\",\"shipping_pan\":null,\"shipping_phone\":\"9852026391\",\"shipping_phone2\":null,\"shipping_email\":\"drohit1984@gmail.com\",\"shipping_country_id\":\"1\",\"shipping_state_id\":\"13\",\"shipping_district_id\":\"57\",\"shipping_city_id\":\"17\",\"shipping_pin_code\":\"854328\",\"shipping_street_address_1\":\"main road\",\"shipping_street_address_2\":null}', '[]', 0, 115.00, 1515.00, 0, 1, 0, '20220006', NULL, '[{\"cart_id\":19,\"product_id\":6,\"product_title\":\"Digital Print Crepe Kurti\",\"product_color_id\":10,\"color_name\":\"Red\",\"color_code\":\"#ff0000\",\"product_size_id\":19,\"size_name\":\"S\",\"ordered_qty\":1,\"sub_total\":1400}]', NULL, 'Customer', NULL, '2022-03-10 12:41:26', '2022-03-10 12:41:26'),
(7, '20220007', 0, 'Rohit Dhanawat', 'drohit1984@gmail.com', '9852026391', '{\"billing_name\":\"Rohit Dhanawat\",\"billing_pan\":null,\"billing_phone\":\"9852026391\",\"billing_phone2\":null,\"billing_email\":\"drohit1984@gmail.com\",\"billing_country_id\":\"1\",\"billing_state_id\":\"13\",\"billing_district_id\":\"59\",\"billing_city_id\":\"21\",\"billing_pin_code\":\"56613\",\"billing_street_address_1\":\"Biratnagar\",\"billing_street_address_2\":null}', '{\"shipping_name\":\"Rohit Dhanawat\",\"shipping_pan\":null,\"shipping_phone\":\"9852026391\",\"shipping_phone2\":null,\"shipping_email\":\"drohit1984@gmail.com\",\"shipping_country_id\":\"1\",\"shipping_state_id\":\"13\",\"shipping_district_id\":\"59\",\"shipping_city_id\":\"21\",\"shipping_pin_code\":\"56613\",\"shipping_street_address_1\":\"Biratnagar\",\"shipping_street_address_2\":null}', '[]', 0, 175.00, 1275.00, 0, 1, 0, '20220007', NULL, '[{\"cart_id\":26,\"product_id\":8,\"product_title\":\"jaipuri Print bedsheet\",\"product_color_id\":14,\"color_name\":\"Blue\",\"color_code\":\"#1b1bdb\",\"product_size_id\":26,\"size_name\":\"Double Bed Size A\",\"ordered_qty\":\"1\",\"sub_total\":1100}]', NULL, 'Customer', NULL, '2022-03-11 10:59:19', '2022-03-11 10:59:19'),
(8, '20220008', 11, 'Rohit Dhanawat', 'drohit1984@gmail.com', '9852026391', '{\"billing_name\":\"Rohit Dhanawat\",\"billing_pan\":null,\"billing_phone\":\"9852026391\",\"billing_phone2\":null,\"billing_email\":\"drohit1984@gmail.com\",\"billing_country_id\":\"1\",\"billing_state_id\":\"13\",\"billing_district_id\":\"57\",\"billing_city_id\":\"17\",\"billing_pin_code\":\"56613\",\"billing_street_address_1\":\"Biratnagar\",\"billing_street_address_2\":null}', '{\"shipping_name\":\"Rohit Dhanawat\",\"shipping_pan\":null,\"shipping_phone\":\"9852026391\",\"shipping_phone2\":null,\"shipping_email\":\"drohit1984@gmail.com\",\"shipping_country_id\":\"1\",\"shipping_state_id\":\"13\",\"shipping_district_id\":\"57\",\"shipping_city_id\":\"17\",\"shipping_pin_code\":\"56613\",\"shipping_street_address_1\":\"Biratnagar\",\"shipping_street_address_2\":null}', '[]', 0, 115.00, 3065.00, 0, 1, 0, '20220008', NULL, '[{\"cart_id\":12,\"product_id\":4,\"product_title\":\"Cool Summer Rayon Kaftans\",\"product_color_id\":8,\"color_name\":\"Grey\",\"color_code\":\"#808080\",\"product_size_id\":12,\"size_name\":\"Free Upto 5xl\",\"ordered_qty\":1,\"sub_total\":2950}]', NULL, 'Customer', NULL, '2022-03-12 13:01:34', '2022-03-12 13:01:34');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'role-list', 'web', '2021-06-21 03:03:29', '2021-06-21 03:03:29'),
(2, 'role-create', 'web', '2021-06-21 03:03:29', '2021-06-21 03:03:29'),
(3, 'role-edit', 'web', '2021-06-21 03:03:29', '2021-06-21 03:03:29'),
(4, 'role-delete', 'web', '2021-06-21 03:03:29', '2021-06-21 03:03:29'),
(5, 'user-list', 'web', '2021-06-21 03:03:29', '2021-06-21 03:03:29'),
(6, 'user-create', 'web', '2021-06-21 03:03:30', '2021-06-21 03:03:30'),
(7, 'user-edit', 'web', '2021-06-21 03:03:30', '2021-06-21 03:03:30'),
(8, 'user-delete', 'web', '2021-06-21 03:03:30', '2021-06-21 03:03:30'),
(9, 'site-setting-list', 'web', '2021-06-21 03:03:30', '2021-06-21 03:03:30'),
(10, 'site-setting-edit', 'web', '2021-06-21 03:03:30', '2021-06-21 03:03:30'),
(11, 'slider-list', 'web', '2021-06-21 03:03:30', '2021-06-21 03:03:30'),
(12, 'slider-create', 'web', '2021-06-21 03:03:30', '2021-06-21 03:03:30'),
(13, 'slider-edit', 'web', '2021-06-21 03:03:30', '2021-06-21 03:03:30'),
(14, 'slider-delete', 'web', '2021-06-21 03:03:30', '2021-06-21 03:03:30'),
(15, 'category-list', 'web', '2021-06-22 04:41:52', '2021-06-22 04:41:52'),
(16, 'category-edit', 'web', '2021-06-22 04:43:37', '2021-06-22 04:43:37'),
(17, 'category-create', 'web', '2021-06-22 04:43:42', '2021-06-22 04:43:42'),
(18, 'category-delete', 'web', '2021-06-22 04:43:48', '2021-06-22 04:43:48');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT 1,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `stock_status` tinyint(1) NOT NULL DEFAULT 1,
  `price` double(8,2) DEFAULT NULL,
  `offer_price` double(8,2) DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `highlights` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size_guide_id` int(11) DEFAULT NULL,
  `size_group_id` int(11) NOT NULL,
  `warranty` tinyint(1) NOT NULL DEFAULT 0,
  `weight` double(8,2) NOT NULL DEFAULT 0.00,
  `product_cares` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '[]',
  `views` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `slug`, `category_id`, `display`, `featured`, `stock_status`, `price`, `offer_price`, `gender`, `highlights`, `description`, `image`, `video_link`, `size_guide_id`, `size_group_id`, `warranty`, `weight`, `product_cares`, `views`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Smart Crepe Round Neck Kurti', 'smart-crepe-round-neck-kurti', 61, 1, 0, 1, NULL, NULL, 'Female', '<ul>\r\n	<li>&nbsp;Smart Crepe Kurti</li>\r\n	<li>&nbsp;Round Neck</li>\r\n	<li>&nbsp;Digital Print</li>\r\n	<li>&nbsp;Kurti Only</li>\r\n	<li>&nbsp;Plus Size available</li>\r\n	<li>&nbsp;Length 42 Inch</li>\r\n</ul>', '<p>Luxurious Crepe Kurti This smart crepe kurti is made of a luxuriously soft fabric, making it a must-have for any woman. The flattering kurti features a round neckline and side slits for ease of movement. The material is also easy to care for, with a machine wash and tumble dry.</p>', '1646552706.jpeg', NULL, NULL, 4, 0, 0.20, '[\"5\"]', 0, 'SHOPJASHN', NULL, '2022-03-07 16:51:04', '2022-03-06 15:45:06', '2022-03-07 16:51:04'),
(2, 'Digital Print Silky Chiffon Saree', 'digital-print-silky-chiffon-saree', 48, 1, 0, 1, NULL, NULL, 'Female', '<ul>\r\n	<li>Soft Saree</li>\r\n	<li>Digital Print</li>\r\n	<li>Banglori Silk Blouse</li>\r\n</ul>\r\n\r\n<div id=\"malwarebytes-root\">\r\n<style type=\"text/css\">@font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.woff\') format(\'woff\');\r\n              font-weight: 700;\r\n              font-style: normal;\r\n              font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.woff\') format(\'woff\');\r\n                   font-weight: 300;\r\n                   font-style: italic;\r\n                   font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.woff\') format(\'woff\');\r\n              font-weight: 400;\r\n              font-style: normal;\r\n              font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.eot?#iefix\')\r\n                   format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.woff2\')\r\n                   format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.woff\')\r\n                   format(\'woff\');\r\n              font-weight: 700;\r\n              font-style: italic;\r\n              font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.woff\') format(\'woff\');\r\n              font-weight: 500;\r\n              font-style: normal;\r\n              font-stretch: normal;\r\n            }\r\n</style>\r\n</div>', '<ul>\r\n	<li>Soft Saree</li>\r\n	<li>Digital Print</li>\r\n	<li>Banglori Silk Blouse</li>\r\n</ul>', NULL, NULL, NULL, 12, 0, 0.45, '[\"5\"]', 0, 'SHOPJASHN', NULL, NULL, '2022-03-07 16:57:13', '2022-03-07 16:57:13'),
(3, 'Beautiful Soft Raw Silk Saree in Temple Design', 'beautiful-soft-raw-silk-saree-in-temple-design', 46, 1, 0, 1, NULL, NULL, 'Female', '<ul>\r\n	<li>Soft Raw Silk</li>\r\n	<li>Weaving</li>\r\n</ul>\r\n\r\n<div id=\"malwarebytes-root\">\r\n<style type=\"text/css\">@font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.woff\') format(\'woff\');\r\n              font-weight: 700;\r\n              font-style: normal;\r\n              font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.woff\') format(\'woff\');\r\n                   font-weight: 300;\r\n                   font-style: italic;\r\n                   font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.woff\') format(\'woff\');\r\n              font-weight: 400;\r\n              font-style: normal;\r\n              font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.eot?#iefix\')\r\n                   format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.woff2\')\r\n                   format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.woff\')\r\n                   format(\'woff\');\r\n              font-weight: 700;\r\n              font-style: italic;\r\n              font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.woff\') format(\'woff\');\r\n              font-weight: 500;\r\n              font-style: normal;\r\n              font-stretch: normal;\r\n            }\r\n</style>\r\n</div>', '<ul>\r\n	<li>Soft Raw Silk</li>\r\n	<li>Weaving</li>\r\n</ul>', NULL, NULL, 15, 12, 0, 0.65, '[\"6\"]', 0, 'SHOPJASHN', NULL, NULL, '2022-03-07 17:03:42', '2022-03-07 17:03:42'),
(4, 'Cool Summer Rayon Kaftans', 'cool-summer-rayon-kaftans', 64, 1, 0, 1, NULL, NULL, 'Female', '<p>-Summer dress</p>\r\n\r\n<p>free size</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<div id=\"malwarebytes-root\">\r\n<style type=\"text/css\">@font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.woff\') format(\'woff\');\r\n              font-weight: 700;\r\n              font-style: normal;\r\n              font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.woff\') format(\'woff\');\r\n                   font-weight: 300;\r\n                   font-style: italic;\r\n                   font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.woff\') format(\'woff\');\r\n              font-weight: 400;\r\n              font-style: normal;\r\n              font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.eot?#iefix\')\r\n                   format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.woff2\')\r\n                   format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.woff\')\r\n                   format(\'woff\');\r\n              font-weight: 700;\r\n              font-style: italic;\r\n              font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.woff\') format(\'woff\');\r\n              font-weight: 500;\r\n              font-style: normal;\r\n              font-stretch: normal;\r\n            }\r\n</style>\r\n</div>', '<p>-Summer dress</p>\r\n\r\n<p>free size</p>', NULL, 'https://youtu.be/l02XcKO_dGg', 14, 11, 0, 0.25, '[\"5\"]', 0, 'SHOPJASHN', NULL, NULL, '2022-03-07 17:08:15', '2022-03-07 17:08:15'),
(5, 'Digital Print Crepe Kurti', 'digital-print-crepe-kurti', 61, 1, 0, 1, NULL, NULL, 'Female', '<p>-plus size</p>\r\n\r\n<p>-digital</p>\r\n\r\n<div id=\"malwarebytes-root\">\r\n<style type=\"text/css\">@font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.woff\') format(\'woff\');\r\n              font-weight: 700;\r\n              font-style: normal;\r\n              font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.woff\') format(\'woff\');\r\n                   font-weight: 300;\r\n                   font-style: italic;\r\n                   font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.woff\') format(\'woff\');\r\n              font-weight: 400;\r\n              font-style: normal;\r\n              font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.eot?#iefix\')\r\n                   format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.woff2\')\r\n                   format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.woff\')\r\n                   format(\'woff\');\r\n              font-weight: 700;\r\n              font-style: italic;\r\n              font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.woff\') format(\'woff\');\r\n              font-weight: 500;\r\n              font-style: normal;\r\n              font-stretch: normal;\r\n            }\r\n</style>\r\n</div>', '<p>-plus size</p>\r\n\r\n<p>-digital</p>', NULL, NULL, 5, 4, 0, 0.25, '[\"5\"]', 0, 'SHOPJASHN', NULL, NULL, '2022-03-07 17:12:05', '2022-03-07 17:12:05'),
(6, 'Digital Print Crepe Kurti', 'digital-print-crepe-kurti-1', 61, 1, 0, 1, NULL, NULL, 'Female', '<p>-small size</p>\r\n\r\n<p>-digital print</p>\r\n\r\n<div id=\"malwarebytes-root\">\r\n<style type=\"text/css\">@font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.woff\') format(\'woff\');\r\n              font-weight: 700;\r\n              font-style: normal;\r\n              font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.woff\') format(\'woff\');\r\n                   font-weight: 300;\r\n                   font-style: italic;\r\n                   font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.woff\') format(\'woff\');\r\n              font-weight: 400;\r\n              font-style: normal;\r\n              font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.eot?#iefix\')\r\n                   format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.woff2\')\r\n                   format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.woff\')\r\n                   format(\'woff\');\r\n              font-weight: 700;\r\n              font-style: italic;\r\n              font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.woff\') format(\'woff\');\r\n              font-weight: 500;\r\n              font-style: normal;\r\n              font-stretch: normal;\r\n            }\r\n</style>\r\n</div>', '<p>-small size</p>\r\n\r\n<p>-digital print</p>\r\n\r\n<p>-details</p>', NULL, NULL, 5, 4, 0, 0.25, '[\"5\"]', 0, 'SHOPJASHN', NULL, NULL, '2022-03-07 17:39:39', '2022-03-07 17:39:39'),
(7, 'Plain Organza Saree', 'plain-organza-saree', 38, 1, 0, 1, NULL, NULL, 'Female', '<p>Organza saree</p>\r\n\r\n<p>small border</p>\r\n\r\n<p>zari work</p>\r\n\r\n<div id=\"malwarebytes-root\">\r\n<style type=\"text/css\">@font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bold-web.woff\') format(\'woff\');\r\n              font-weight: 700;\r\n              font-style: normal;\r\n              font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-lightitalic-web.woff\') format(\'woff\');\r\n                   font-weight: 300;\r\n                   font-style: italic;\r\n                   font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-regular-web.woff\') format(\'woff\');\r\n              font-weight: 400;\r\n              font-style: normal;\r\n              font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.eot?#iefix\')\r\n                   format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.woff2\')\r\n                   format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-bolditalic-web.woff\')\r\n                   format(\'woff\');\r\n              font-weight: 700;\r\n              font-style: italic;\r\n              font-stretch: normal;\r\n            }\r\n            @font-face {\r\n              font-family: \'graphik-web\';\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.eot\');\r\n              src: url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.eot?#iefix\') format(\'embedded-opentype\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.woff2\') format(\'woff2\'),\r\n                   url(\'chrome-extension://ihcjicgdanjaechkgeegckofjjedodee/vendor/graphik/web/graphik-medium-web.woff\') format(\'woff\');\r\n              font-weight: 500;\r\n              font-style: normal;\r\n              font-stretch: normal;\r\n            }\r\n</style>\r\n</div>', '<p>Organza saree</p>\r\n\r\n<p>small border</p>\r\n\r\n<p>zari work</p>\r\n\r\n<p>details</p>', NULL, NULL, 15, 12, 0, 0.50, '[\"5\"]', 0, 'SHOPJASHN', NULL, NULL, '2022-03-07 17:58:16', '2022-03-07 17:58:16'),
(8, 'jaipuri Print bedsheet', 'jaipuri-print-bedsheet', 146, 1, 0, 1, NULL, NULL, 'Unisexual', '<p>double bedsheet</p>\r\n\r\n<p>90x100</p>\r\n\r\n<p>2pillow cover</p>', '<p>double bedsheet</p>\r\n\r\n<p>90x100</p>\r\n\r\n<p>2pillow cover</p>\r\n\r\n<p>details</p>', NULL, NULL, 13, 9, 0, 0.75, '[\"5\"]', 0, 'SHOPJASHN', 'SHOPJASHN', NULL, '2022-03-07 18:03:29', '2022-03-07 18:03:50'),
(9, 'Ollypop Plain Cotton Round Neck T-shirt for Boys', 'ollypop-plain-cotton-round-neck-t-shirt-for-boys', 93, 1, 0, 1, NULL, NULL, 'Male', '<p>100% Pure cotton</p>\r\n\r\n<p>Comfortable for childs skin</p>\r\n\r\n<p>no toxic colors or dyes used<br />\r\n&nbsp;</p>', '<p>100% Pure cotton</p>\r\n\r\n<p>Comfortable for childs skin</p>\r\n\r\n<p>no toxic colors or dyes used</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>deyail</p>', NULL, NULL, 6, 7, 0, 0.10, '[\"5\"]', 0, 'SHOPJASHN', 'SHOPJASHN', NULL, '2022-03-07 21:58:07', '2022-03-07 21:59:52');

-- --------------------------------------------------------

--
-- Table structure for table `product_cares`
--

CREATE TABLE `product_cares` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display` tinyint(1) NOT NULL DEFAULT 1,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_cares`
--

INSERT INTO `product_cares` (`id`, `title`, `slug`, `image`, `display`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(5, 'Home wash', 'home-wash', '1646477129.jpg', 1, '-       This Product can be washed at home in gentle detergent.\r\n-       Wash different colors separately.\r\n-       Wash in cold water to avoid Color Bleeding.\r\n-       Do not Iron directly on Rubber Prints, Work, Embroidery and Zari\r\n-       We advise for Pre wash before wearing any of our garments.', 'SHOPJASHN', NULL, '2022-03-05 18:45:29', '2022-03-05 18:45:29'),
(6, 'Dry wash', 'dry-wash', '1646477150.jpg', 1, '-       This Product needs to be dry cleans only\r\n-       Gentle Shampoo wash is not considered Dry Clean\r\n-       We advise for Pre wash before wearing any of our garments.', 'SHOPJASHN', NULL, '2022-03-05 18:45:50', '2022-03-05 18:45:50'),
(7, 'Kids', 'kids', '1646477169.jpg', 1, '-       Pre wash before use.\r\n-       Wash gently either by hand or machine with gentle detergent.\r\n-       Wash different colors separately.\r\n-       Wash in cold water to avoid Color Bleeding.\r\n-       Do not Iron directly on Rubber Prints', 'SHOPJASHN', NULL, '2022-03-05 18:46:09', '2022-03-05 18:46:09'),
(8, 'Shoes', 'shoes', '1646477185.jpg', 1, '-      Store in Dry Place\r\n-      Before Storage please wipe of the dirt\r\n-      Keep away from Direct Sun Light\r\n\"-      HYDROGEN PEROXIDE AND BAKING SODA TO MAKE YOUR SHOES BRIGHT AGAIN:\r\nEveryone enjoys flaunting a new pair of shiny bright sneakers but what many don’t is that even your old shoes can be as bright as a new pair. Just use a toothbrush dipped in a paste of hydrogen peroxide and baking soda and slowly scrub the paste all over the shoe and see the magic paste work wonders. You’ll have a shiny pair of sneakers that you can flaunt as a new pair of sneakers.\"', 'SHOPJASHN', 'SHOPJASHN', '2022-03-05 18:46:25', '2022-03-05 18:47:55'),
(9, 'Bags', 'bags', '1646477208.jpg', 1, '-      Store in Dry Place\r\n-      Before Storage please wipe off the dirt\r\n-      Keep away from Direct Sun Light\r\n-     Timely Air Out the bags', 'SHOPJASHN', 'SHOPJASHN', '2022-03-05 18:46:48', '2022-03-05 18:48:19'),
(10, 'Imitation Jewelry', 'imitation-jewelry', '1646477327.jpg', 1, '-      Store in Dry Place\r\n-      Before Storage please wipe off extra water or sweat\r\n-      Keep away from Direct Sun Light\r\n-     Avoid Direct contact with water and Perfumes', 'SHOPJASHN', NULL, '2022-03-05 18:48:48', '2022-03-05 18:48:48');

-- --------------------------------------------------------

--
-- Table structure for table `product_colors`
--

CREATE TABLE `product_colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `color_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_colors`
--

INSERT INTO `product_colors` (`id`, `product_id`, `color_id`, `image`, `status`, `sku`, `created_at`, `updated_at`) VALUES
(2, 2, 10, '1646643433.jpeg', 1, NULL, '2022-03-07 16:57:14', '2022-03-07 16:57:14'),
(3, 2, 14, '1646643434.jpeg', 1, NULL, '2022-03-07 16:57:15', '2022-03-07 16:57:15'),
(4, 2, 15, '1646643435.jpeg', 1, NULL, '2022-03-07 16:57:15', '2022-03-07 16:57:15'),
(5, 3, 10, '1646643822.jpeg', 1, NULL, '2022-03-07 17:03:43', '2022-03-07 17:03:43'),
(6, 3, 27, '1646643823.jpeg', 1, NULL, '2022-03-07 17:03:44', '2022-03-07 17:03:44'),
(7, 4, 13, '1646644095.jpeg', 1, NULL, '2022-03-07 17:08:15', '2022-03-07 17:08:15'),
(8, 4, 30, '1646644095.jpeg', 1, NULL, '2022-03-07 17:08:16', '2022-03-07 17:08:16'),
(9, 5, 13, '1646644325.jpeg', 1, NULL, '2022-03-07 17:12:05', '2022-03-07 17:12:05'),
(10, 6, 10, '1646645979.jpeg', 1, NULL, '2022-03-07 17:39:40', '2022-03-07 17:39:40'),
(11, 6, 17, '1646645980.jpeg', 1, NULL, '2022-03-07 17:39:40', '2022-03-07 17:39:40'),
(12, 7, 10, '1646647096.jpeg', 1, NULL, '2022-03-07 17:58:17', '2022-03-07 17:58:17'),
(13, 7, 15, '1646647097.jpeg', 1, NULL, '2022-03-07 17:58:17', '2022-03-07 17:58:17'),
(14, 8, 13, '1646647473.jpeg', 1, NULL, '2022-03-07 18:03:29', '2022-03-07 18:04:33'),
(15, 8, 14, '1646647473.jpeg', 1, NULL, '2022-03-07 18:03:29', '2022-03-07 18:04:34'),
(16, 9, 14, '1646661592.jpg', 1, NULL, '2022-03-07 21:58:08', '2022-03-07 21:59:52'),
(17, 9, 15, '1647060869.jpeg', 1, NULL, '2022-03-07 21:58:08', '2022-03-12 12:54:30'),
(18, 9, 26, '1646661593.jpg', 1, NULL, '2022-03-07 21:58:08', '2022-03-07 21:59:53');

-- --------------------------------------------------------

--
-- Table structure for table `product_coupons`
--

CREATE TABLE `product_coupons` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `discount_coupon_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_offers`
--

CREATE TABLE `product_offers` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `offer_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_offers`
--

INSERT INTO `product_offers` (`product_id`, `offer_id`, `created_at`, `updated_at`) VALUES
(2, 1, '2022-03-11 18:40:32', '2022-03-11 18:40:32'),
(3, 1, '2022-03-11 18:40:32', '2022-03-11 18:40:32'),
(4, 1, '2022-03-11 18:40:32', '2022-03-11 18:40:32'),
(7, 1, '2022-03-11 18:40:32', '2022-03-11 18:40:32');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` double(8,2) NOT NULL DEFAULT 1.00,
  `anonymous` tinyint(1) NOT NULL DEFAULT 0,
  `display` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--

CREATE TABLE `product_sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_color_id` bigint(20) UNSIGNED NOT NULL,
  `size_id` bigint(20) UNSIGNED NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT 1,
  `quantity` int(11) NOT NULL,
  `price` double(8,2) NOT NULL,
  `offer_price` double(8,2) DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preorder` tinyint(1) NOT NULL DEFAULT 0,
  `preorder_stock_limit` int(11) DEFAULT NULL,
  `preorder_price` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `product_color_id`, `size_id`, `display`, `quantity`, `price`, `offer_price`, `sku`, `preorder`, `preorder_stock_limit`, `preorder_price`, `created_at`, `updated_at`) VALUES
(6, 2, 101, 1, 2, 1400.00, NULL, 'Bijuli 03', 1, 10, NULL, '2022-03-07 16:57:14', '2022-03-07 16:57:14'),
(7, 3, 101, 1, 1, 1400.00, NULL, 'Bijuli 04', 1, 10, NULL, '2022-03-07 16:57:15', '2022-03-07 16:57:15'),
(8, 4, 101, 1, 0, 1400.00, NULL, 'Bijuli  01', 1, 10, NULL, '2022-03-07 16:57:15', '2022-03-07 16:57:15'),
(9, 5, 101, 1, 5, 2350.00, NULL, 'SGVADS001', 0, NULL, NULL, '2022-03-07 17:03:43', '2022-03-07 17:03:43'),
(10, 6, 101, 1, 1, 2350.00, NULL, 'SGVADS002', 1, 3, NULL, '2022-03-07 17:03:44', '2022-03-07 17:03:44'),
(11, 7, 100, 1, 0, 2950.00, NULL, 'SGGVKSP001', 1, 10, NULL, '2022-03-07 17:08:15', '2022-03-07 17:08:15'),
(12, 8, 100, 1, 0, 2950.00, NULL, 'SGVKSP002', 1, 5, NULL, '2022-03-07 17:08:16', '2022-03-07 17:08:16'),
(13, 9, 20, 1, 1, 1400.00, NULL, 'SGVCRA001M', 1, 10, NULL, '2022-03-07 17:12:05', '2022-03-07 17:12:05'),
(14, 9, 21, 1, 0, 1400.00, NULL, 'SGVCRA001L', 1, 10, NULL, '2022-03-07 17:12:05', '2022-03-07 17:12:05'),
(15, 9, 22, 1, 0, 1400.00, NULL, 'SGVCRA001XL', 1, 10, NULL, '2022-03-07 17:12:05', '2022-03-07 17:12:05'),
(16, 9, 23, 1, 2, 1500.00, NULL, 'SGVCRA0012XL', 1, 10, NULL, '2022-03-07 17:12:05', '2022-03-07 17:12:05'),
(17, 9, 24, 1, 1, 1500.00, NULL, 'SGVCRA0013XL', 1, 10, NULL, '2022-03-07 17:12:05', '2022-03-07 17:12:05'),
(18, 10, 18, 1, 1, 1400.00, NULL, 'SGVCRA011XS', 0, NULL, NULL, '2022-03-07 17:39:40', '2022-03-07 17:39:40'),
(19, 10, 19, 1, 2, 1400.00, NULL, 'SGVCRA011A', 0, NULL, NULL, '2022-03-07 17:39:40', '2022-03-07 17:39:40'),
(20, 10, 20, 1, 3, 1400.00, NULL, 'SGVCRA011M', 0, NULL, NULL, '2022-03-07 17:39:40', '2022-03-07 17:39:40'),
(21, 10, 21, 1, 4, 1400.00, NULL, 'SGVCRA011L', 0, NULL, NULL, '2022-03-07 17:39:40', '2022-03-07 17:39:40'),
(22, 11, 18, 1, 1, 1400.00, NULL, 'SGVCRA113XS', 0, NULL, NULL, '2022-03-07 17:39:40', '2022-03-07 17:39:40'),
(23, 11, 19, 1, 0, 1400.00, NULL, 'SGVCRA113S', 1, 50, NULL, '2022-03-07 17:39:40', '2022-03-07 17:39:40'),
(24, 12, 101, 1, 0, 2100.00, 1900.00, 'SGVORT001', 1, 50, NULL, '2022-03-07 17:58:17', '2022-03-07 17:58:17'),
(25, 13, 101, 1, 0, 2100.00, 1900.00, 'SGVORT002', 1, 50, NULL, '2022-03-07 17:58:17', '2022-03-07 17:58:17'),
(26, 14, 88, 1, 10, 1100.00, NULL, 'rockstar01', 0, NULL, NULL, '2022-03-07 18:03:29', '2022-03-07 18:03:29'),
(27, 15, 88, 1, 10, 1100.00, NULL, 'rockstar02', 0, NULL, NULL, '2022-03-07 18:03:29', '2022-03-07 18:03:29'),
(28, 16, 61, 1, 1, 400.00, NULL, '1055GRNB', 0, NULL, NULL, '2022-03-07 21:58:08', '2022-03-07 21:58:08'),
(29, 16, 62, 1, 2, 400.00, NULL, '1055GR3-6', 0, NULL, NULL, '2022-03-07 21:58:08', '2022-03-07 21:58:08'),
(30, 16, 63, 1, 1, 450.00, NULL, '1055GR6-12', 0, NULL, NULL, '2022-03-07 21:58:08', '2022-03-07 21:58:08'),
(31, 16, 64, 1, 2, 450.00, NULL, '1055GR12-18', 0, NULL, NULL, '2022-03-07 21:58:08', '2022-03-07 21:58:08'),
(32, 16, 65, 1, 1, 450.00, NULL, '1055GR18-24', 0, NULL, NULL, '2022-03-07 21:58:08', '2022-03-07 21:58:08'),
(33, 16, 66, 1, 5, 500.00, NULL, '1055GR2-3', 0, NULL, NULL, '2022-03-07 21:58:08', '2022-03-07 21:58:08'),
(34, 16, 67, 1, 2, 500.00, NULL, '1055GR3-4', 0, NULL, NULL, '2022-03-07 21:58:08', '2022-03-07 21:58:08'),
(35, 16, 68, 1, 1, 550.00, NULL, '1055GR4-5', 0, NULL, NULL, '2022-03-07 21:58:08', '2022-03-07 21:58:08'),
(36, 16, 69, 1, 3, 550.00, NULL, '1055GR5-6', 0, NULL, NULL, '2022-03-07 21:58:08', '2022-03-07 21:58:08'),
(37, 17, 66, 1, 1, 500.00, NULL, '1055Ye2-3', 0, NULL, NULL, '2022-03-07 21:58:08', '2022-03-07 21:58:08'),
(38, 17, 67, 1, 2, 500.00, NULL, '1055Ye3-4', 0, NULL, NULL, '2022-03-07 21:58:08', '2022-03-07 21:58:08'),
(39, 17, 68, 1, 3, 550.00, NULL, '1055Ye4-5', 0, NULL, NULL, '2022-03-07 21:58:08', '2022-03-07 21:58:08'),
(40, 18, 61, 1, 1, 400.00, NULL, '1055SGNB', 0, NULL, NULL, '2022-03-07 21:58:08', '2022-03-07 21:58:08'),
(41, 18, 62, 1, 1, 400.00, NULL, '1055SG3-6', 0, NULL, NULL, '2022-03-07 21:58:08', '2022-03-07 21:58:08');

-- --------------------------------------------------------

--
-- Table structure for table `product_variations`
--

CREATE TABLE `product_variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `color_id` bigint(20) UNSIGNED NOT NULL,
  `size_id` bigint(20) UNSIGNED NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT 1,
  `quantity` int(11) NOT NULL,
  `price` double(8,2) DEFAULT NULL,
  `offer_price` double(8,2) DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preorder` tinyint(1) NOT NULL DEFAULT 0,
  `preorder_stock_limit` int(11) DEFAULT NULL,
  `preorder_price` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_requests`
--

CREATE TABLE `return_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `return_request_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_price` double(8,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `return_requests`
--

INSERT INTO `return_requests` (`id`, `order_id`, `return_request_no`, `customer_id`, `total_price`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 7, '20210001', 5, 3998.00, 0, NULL, '2021-10-28 04:30:41', '2021-10-28 04:30:41'),
(2, 9, '20210002', 5, 3998.00, 0, NULL, '2021-10-28 05:19:29', '2021-10-28 05:19:29');

-- --------------------------------------------------------

--
-- Table structure for table `return_request_products`
--

CREATE TABLE `return_request_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_request_id` bigint(20) UNSIGNED NOT NULL,
  `ordered_product_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `sub_total` double(8,2) NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `return_request_products`
--

INSERT INTO `return_request_products` (`id`, `return_request_id`, `ordered_product_id`, `product_id`, `quantity`, `sub_total`, `reason`, `image`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 38, 3, 1, 1999.00, '2', '1635416141_38.jpg', 0, NULL, '2021-10-28 04:30:41', '2021-10-28 05:28:24'),
(2, 1, 39, 3, 1, 1999.00, '1', '1635416141_39.jpg', 0, NULL, '2021-10-28 04:30:41', '2021-10-28 04:30:41'),
(3, 2, 49, 3, 1, 1999.00, '3', '1635419069_49.jpg', 0, NULL, '2021-10-28 05:19:29', '2021-10-28 05:19:29'),
(4, 2, 50, 3, 1, 1999.00, '2', '1635419069_50.jpg', 0, NULL, '2021-10-28 05:19:29', '2021-10-28 05:19:29');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2021-06-21 03:21:09', '2021-06-21 03:21:09'),
(2, 'customer', 'web', '2021-08-03 12:17:05', '2021-08-03 12:17:05');

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
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_viber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_whatsapp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebookurl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitterurl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagramurl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `googlemapurl` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtubeurl` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `how_to_order_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aboutus` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `email`, `title`, `phone`, `mobile`, `mobile_viber`, `mobile_whatsapp`, `address`, `logo`, `favicon`, `facebookurl`, `twitterurl`, `instagramurl`, `googlemapurl`, `youtubeurl`, `how_to_order_link`, `aboutus`, `og_title`, `og_description`, `og_image`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(1, 'jashn@shopatjashn.com', 'Jashn', '9814327018', '9802790090', '+977 9814327018', '+977 9814327018', 'GMI Premises, Radhe Krishna Marg, Biratnagar-1, Nepal', '1646063415.png', '1646063415.png', 'https://www.facebook.com/jashnthepaage', NULL, 'https://www.instagram.com/jashnthepage', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3571.4776178332822!2d87.29006249999999!3d26.4725625!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x20b77decf230b2cb!2s7MR9F7FR%2B22!5e0!3m2!1sen!2snp!4v1646814713569!5m2!1sen!2snp', NULL, NULL, NULL, 'Jashn Nepal', 'Welcome to Jashn', '1625994838.png', 'Jashn - Online Store in Nepal', 'Welcome to Jashn. You wish we deliver.', 'ecommerce, jashn, nepal', '2021-07-11 01:00:30', '2022-03-09 19:45:44');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `size_group_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `size_group_id`, `name`, `display`, `created_at`, `updated_at`) VALUES
(18, 4, 'XS', 1, '2022-03-05 18:50:15', '2022-03-05 18:50:15'),
(19, 4, 'S', 1, '2022-03-05 18:50:15', '2022-03-05 18:50:15'),
(20, 4, 'M', 1, '2022-03-05 18:50:15', '2022-03-05 18:50:15'),
(21, 4, 'L', 1, '2022-03-05 18:50:15', '2022-03-05 18:50:15'),
(22, 4, 'XL', 1, '2022-03-05 18:50:15', '2022-03-05 18:50:15'),
(23, 4, 'XXL', 1, '2022-03-05 18:50:15', '2022-03-05 18:50:15'),
(24, 4, '3XL', 1, '2022-03-05 18:50:15', '2022-03-05 18:50:15'),
(25, 4, '4XL', 1, '2022-03-05 18:50:15', '2022-03-05 18:50:15'),
(26, 4, '5XL', 1, '2022-03-05 18:50:15', '2022-03-05 18:50:15'),
(27, 4, '6XL', 1, '2022-03-05 18:50:15', '2022-03-05 18:50:15'),
(47, 6, 'NB', 1, '2022-03-05 18:56:28', '2022-03-05 18:56:28'),
(48, 6, '3-6M', 1, '2022-03-05 18:56:28', '2022-03-05 18:56:28'),
(49, 6, '6-12M', 1, '2022-03-05 18:56:28', '2022-03-05 18:56:28'),
(50, 6, '12-18M', 1, '2022-03-05 18:56:28', '2022-03-05 18:56:28'),
(51, 6, '18-24M', 1, '2022-03-05 18:56:28', '2022-03-05 18:56:28'),
(52, 6, '2-3Y', 1, '2022-03-05 18:56:28', '2022-03-05 18:56:28'),
(53, 6, '3-4Y', 1, '2022-03-05 18:56:28', '2022-03-05 18:56:28'),
(54, 6, '4-5Y', 1, '2022-03-05 18:56:28', '2022-03-05 18:56:28'),
(55, 6, '5-6Y', 1, '2022-03-05 18:56:28', '2022-03-05 18:56:28'),
(56, 6, '6-7Y', 1, '2022-03-05 18:56:28', '2022-03-05 18:56:28'),
(57, 6, '8-10Y', 1, '2022-03-05 18:56:28', '2022-03-05 18:56:28'),
(58, 6, '10-12Y', 1, '2022-03-05 18:56:28', '2022-03-05 18:56:28'),
(59, 6, '12-14Y', 1, '2022-03-05 18:56:28', '2022-03-05 18:56:28'),
(60, 6, '14-16Y', 1, '2022-03-05 18:56:28', '2022-03-05 18:56:28'),
(61, 7, 'NB', 1, '2022-03-05 18:59:23', '2022-03-05 18:59:23'),
(62, 7, '3-6M', 1, '2022-03-05 18:59:23', '2022-03-05 18:59:23'),
(63, 7, '6-12M', 1, '2022-03-05 18:59:23', '2022-03-05 18:59:23'),
(64, 7, '12-18M', 1, '2022-03-05 18:59:23', '2022-03-05 18:59:23'),
(65, 7, '18-24M', 1, '2022-03-05 18:59:23', '2022-03-05 18:59:23'),
(66, 7, '2-3Y', 1, '2022-03-05 18:59:23', '2022-03-05 18:59:23'),
(67, 7, '3-4Y', 1, '2022-03-05 18:59:23', '2022-03-05 18:59:23'),
(68, 7, '4-5Y', 1, '2022-03-05 18:59:23', '2022-03-05 18:59:23'),
(69, 7, '5-6Y', 1, '2022-03-05 18:59:23', '2022-03-05 18:59:23'),
(70, 7, '6-7Y', 1, '2022-03-05 18:59:23', '2022-03-05 18:59:23'),
(71, 7, '7-8Y', 1, '2022-03-05 18:59:23', '2022-03-05 18:59:23'),
(72, 7, '8-9Y', 1, '2022-03-05 18:59:23', '2022-03-05 18:59:23'),
(73, 7, '9-10Y', 1, '2022-03-05 18:59:23', '2022-03-05 18:59:23'),
(74, 7, '10-11Y', 1, '2022-03-05 18:59:23', '2022-03-05 18:59:23'),
(75, 7, '11-12Y', 1, '2022-03-05 18:59:23', '2022-03-05 18:59:23'),
(76, 7, '12-13Y', 1, '2022-03-05 18:59:23', '2022-03-05 18:59:23'),
(77, 7, '13-14Y', 1, '2022-03-05 18:59:23', '2022-03-05 18:59:23'),
(78, 7, '14-15Y', 1, '2022-03-05 18:59:23', '2022-03-05 18:59:23'),
(79, 7, '15-16Y', 1, '2022-03-05 18:59:23', '2022-03-05 18:59:23'),
(80, 8, '3-4Y', 1, '2022-03-07 16:17:45', '2022-03-07 16:17:45'),
(81, 8, '5-6Y', 1, '2022-03-07 16:17:45', '2022-03-07 16:17:45'),
(82, 8, '7-8Y', 1, '2022-03-07 16:17:45', '2022-03-07 16:17:45'),
(83, 8, '9-10Y', 1, '2022-03-07 16:17:45', '2022-03-07 16:17:45'),
(84, 8, '11-12Y', 1, '2022-03-07 16:17:45', '2022-03-07 16:17:45'),
(85, 8, '13-14Y', 1, '2022-03-07 16:17:46', '2022-03-07 16:17:46'),
(86, 8, '15-16Y', 1, '2022-03-07 16:17:46', '2022-03-07 16:17:46'),
(87, 9, 'Single Bed Size', 1, '2022-03-07 16:26:52', '2022-03-07 16:26:52'),
(88, 9, 'Double Bed Size A', 1, '2022-03-07 16:26:52', '2022-03-07 16:26:52'),
(89, 9, 'Double Bed Size B', 1, '2022-03-07 16:26:52', '2022-03-07 16:26:52'),
(90, 9, 'Queen Bed Size A', 1, '2022-03-07 16:26:52', '2022-03-07 16:26:52'),
(91, 9, 'Queen Bed Size B', 1, '2022-03-07 16:26:52', '2022-03-07 16:26:52'),
(92, 9, 'King Size', 1, '2022-03-07 16:26:52', '2022-03-07 16:26:52'),
(93, 9, 'Jumbo Size', 1, '2022-03-07 16:26:52', '2022-03-07 16:26:52'),
(94, 10, '2.2', 1, '2022-03-07 16:27:22', '2022-03-07 16:27:22'),
(95, 10, '2,4', 1, '2022-03-07 16:27:22', '2022-03-07 16:27:22'),
(96, 10, '2,6', 1, '2022-03-07 16:27:22', '2022-03-07 16:27:22'),
(97, 10, '2,8', 1, '2022-03-07 16:27:22', '2022-03-07 16:27:22'),
(98, 10, '2.10', 1, '2022-03-07 16:27:22', '2022-03-07 16:27:22'),
(99, 11, 'Free For All', 1, '2022-03-07 16:29:23', '2022-03-07 16:29:23'),
(100, 11, 'Free Upto 5xl', 1, '2022-03-07 16:29:23', '2022-03-07 16:29:23'),
(101, 12, '5.5/0.80 MTRS', 1, '2022-03-07 16:30:12', '2022-03-07 16:30:12'),
(102, 10, 'Adjustable', 1, '2022-03-07 21:38:29', '2022-03-07 21:38:29');

-- --------------------------------------------------------

--
-- Table structure for table `size_groups`
--

CREATE TABLE `size_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `size_groups`
--

INSERT INTO `size_groups` (`id`, `name`, `display`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, 'Medium To 6XL', 1, 'SHOPJASHN', 'SHOPJASHN', '2022-03-05 18:50:15', '2022-03-05 18:50:49'),
(6, 'Cucumber', 1, 'SHOPJASHN', NULL, '2022-03-05 18:56:28', '2022-03-05 18:56:28'),
(7, 'Ollypop (NB to 16yrs)', 1, 'SHOPJASHN', 'SHOPJASHN', '2022-03-05 18:59:23', '2022-03-07 16:18:00'),
(8, 'Luyk', 1, 'SHOPJASHN', NULL, '2022-03-07 16:17:45', '2022-03-07 16:17:45'),
(9, 'Bed Sheets', 1, 'SHOPJASHN', NULL, '2022-03-07 16:26:52', '2022-03-07 16:26:52'),
(10, 'Bangles', 1, 'SHOPJASHN', 'SHOPJASHN', '2022-03-07 16:27:22', '2022-03-07 21:38:29'),
(11, 'FREE', 1, 'SHOPJASHN', NULL, '2022-03-07 16:29:23', '2022-03-07 16:29:23'),
(12, 'Saree', 1, 'SHOPJASHN', NULL, '2022-03-07 16:30:12', '2022-03-07 16:30:12');

-- --------------------------------------------------------

--
-- Table structure for table `size_guides`
--

CREATE TABLE `size_guides` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size_group_id` bigint(20) UNSIGNED NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT 1,
  `units` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `sizes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `size_guides`
--

INSERT INTO `size_guides` (`id`, `name`, `size_group_id`, `display`, `units`, `sizes`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 'Women Bottom', 4, 1, '{\"1\":{\"name\":\"Waist Bottom\",\"value\":[\"25\",\"26\",\"27.5\",\"29\",\"30.5\",\"32\",\"33.5\",\"35\",\"36.5\",\"38\"]}}', '[{\"id\":\"18\",\"name\":\"XS\"},{\"id\":\"19\",\"name\":\"S\"},{\"id\":\"20\",\"name\":\"M\"},{\"id\":\"21\",\"name\":\"L\"},{\"id\":\"22\",\"name\":\"XL\"},{\"id\":\"23\",\"name\":\"XXL\"},{\"id\":\"24\",\"name\":\"3XL\"},{\"id\":\"25\",\"name\":\"4XL\"},{\"id\":\"26\",\"name\":\"5XL\"},{\"id\":\"27\",\"name\":\"6XL\"}]', 'SHOPJASHN', NULL, '2022-03-07 16:06:11', '2022-03-07 16:06:11'),
(4, 'Women Top & Bottom Set', 4, 1, '{\"1\":{\"name\":\"Bust\",\"value\":[\"34\",\"36\",\"38\",\"40\",\"42\",\"44\",\"46\",\"48\",\"50\",\"52\"]},\"2\":{\"name\":\"Waist Bottom\",\"value\":[\"25\",\"26\",\"27.5\",\"29\",\"30.5\",\"32\",\"33.5\",\"35\",\"36.5\",\"38\"]}}', '[{\"id\":\"18\",\"name\":\"XS\"},{\"id\":\"19\",\"name\":\"S\"},{\"id\":\"20\",\"name\":\"M\"},{\"id\":\"21\",\"name\":\"L\"},{\"id\":\"22\",\"name\":\"XL\"},{\"id\":\"23\",\"name\":\"XXL\"},{\"id\":\"24\",\"name\":\"3XL\"},{\"id\":\"25\",\"name\":\"4XL\"},{\"id\":\"26\",\"name\":\"5XL\"},{\"id\":\"27\",\"name\":\"6XL\"}]', 'SHOPJASHN', NULL, '2022-03-07 16:07:26', '2022-03-07 16:07:26'),
(5, 'Women Top', 4, 1, '{\"1\":{\"name\":\"Bust\",\"value\":[\"34\",\"36\",\"38\",\"40\",\"42\",\"44\",\"46\",\"48\",\"50\",\"52\"]}}', '[{\"id\":\"18\",\"name\":\"XS\"},{\"id\":\"19\",\"name\":\"S\"},{\"id\":\"20\",\"name\":\"M\"},{\"id\":\"21\",\"name\":\"L\"},{\"id\":\"22\",\"name\":\"XL\"},{\"id\":\"23\",\"name\":\"XXL\"},{\"id\":\"24\",\"name\":\"3XL\"},{\"id\":\"25\",\"name\":\"4XL\"},{\"id\":\"26\",\"name\":\"5XL\"},{\"id\":\"27\",\"name\":\"6XL\"}]', 'SHOPJASHN', NULL, '2022-03-07 16:07:54', '2022-03-07 16:07:54'),
(6, 'Kidswear Boys Ollypop', 7, 1, '{\"1\":{\"name\":\"Size Tag\",\"value\":[\"XS\",\"S\",\"M\",\"L or 16\",\"XL or 18\",\"XXL or 20\",\"XXXL or 22\",\"24\",\"26\",\"28\",\"30\",\"32\",\"34\",\"36\",\"*\",\"*\",\"*\",\"*\",\"*\"]},\"2\":{\"name\":\"EU\",\"value\":[\"New Born\",\"*\",\"80 cm\",\"80-86 cm\",\"86-92 cm\",\"92-98 cm\",\"98-104 cm\",\"104-110 cm\",\"110-116 cm\",\"116- 122 cm\",\"122-128 cm\",\"128-134 cm\",\"134- 140 cm\",\"140- 146 cm\",\"*\",\"*\",\"*\",\"*\",\"*\"]},\"3\":{\"name\":\"Tshirt Chest\",\"value\":[\"18\",\"20\",\"21\",\"22\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"31\",\"33\",\"35\",\"36\",\"*\",\"*\",\"*\",\"*\",\"*\"]},\"4\":{\"name\":\"Tshirt Length\",\"value\":[\"10\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"*\",\"*\",\"*\",\"*\",\"*\"]},\"5\":{\"name\":\"Bottom Waist\",\"value\":[\"13\",\"14\",\"15\",\"15\",\"16\",\"17\",\"19\",\"20\",\"21\",\"*\",\"*\",\"*\",\"*\",\"*\",\"*\",\"*\",\"*\",\"*\",\"*\"]}}', '[{\"id\":\"61\",\"name\":\"NB\"},{\"id\":\"62\",\"name\":\"3-6M\"},{\"id\":\"63\",\"name\":\"6-12M\"},{\"id\":\"64\",\"name\":\"12-18M\"},{\"id\":\"65\",\"name\":\"18-24M\"},{\"id\":\"66\",\"name\":\"2-3Y\"},{\"id\":\"67\",\"name\":\"3-4Y\"},{\"id\":\"68\",\"name\":\"4-5Y\"},{\"id\":\"69\",\"name\":\"5-6Y\"},{\"id\":\"70\",\"name\":\"6-7Y\"},{\"id\":\"71\",\"name\":\"7-8Y\"},{\"id\":\"72\",\"name\":\"8-9Y\"},{\"id\":\"73\",\"name\":\"9-10Y\"},{\"id\":\"74\",\"name\":\"10-11Y\"},{\"id\":\"75\",\"name\":\"11-12Y\"},{\"id\":\"76\",\"name\":\"12-13Y\"},{\"id\":\"77\",\"name\":\"13-14Y\"},{\"id\":\"78\",\"name\":\"14-15Y\"},{\"id\":\"79\",\"name\":\"15-16Y\"}]', 'SHOPJASHN', NULL, '2022-03-07 16:13:19', '2022-03-07 16:13:19'),
(7, 'Luyk Shorts, Skirt', 8, 1, '{\"1\":{\"name\":\"Waist\",\"value\":[\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"*\"]},\"2\":{\"name\":\"Inseam Length\",\"value\":[\"4\",\"4.5\",\"5\",\"5.5\",\"6\",\"6.5\",\"*\"]}}', '[{\"id\":\"80\",\"name\":\"3-4Y\"},{\"id\":\"81\",\"name\":\"5-6Y\"},{\"id\":\"82\",\"name\":\"7-8Y\"},{\"id\":\"83\",\"name\":\"9-10Y\"},{\"id\":\"84\",\"name\":\"11-12Y\"},{\"id\":\"85\",\"name\":\"13-14Y\"},{\"id\":\"86\",\"name\":\"15-16Y\"}]', 'SHOPJASHN', NULL, '2022-03-07 16:19:06', '2022-03-07 16:19:06'),
(8, 'Luyk Long Skirt', 8, 1, '{\"1\":{\"name\":\"Waist\",\"value\":[\"*\",\"*\",\"24\",\"25\",\"26\",\"27\",\"*\"]},\"2\":{\"name\":\"Inseam Length\",\"value\":[\"*\",\"*\",\"5\",\"5.5\",\"6\",\"6.5\",\"*\"]},\"3\":{\"name\":\"Skirt Length\",\"value\":[\"*\",\"*\",\"15.5\",\"16\",\"16.5\",\"17\",\"*\"]}}', '[{\"id\":\"80\",\"name\":\"3-4Y\"},{\"id\":\"81\",\"name\":\"5-6Y\"},{\"id\":\"82\",\"name\":\"7-8Y\"},{\"id\":\"83\",\"name\":\"9-10Y\"},{\"id\":\"84\",\"name\":\"11-12Y\"},{\"id\":\"85\",\"name\":\"13-14Y\"},{\"id\":\"86\",\"name\":\"15-16Y\"}]', 'SHOPJASHN', NULL, '2022-03-07 16:20:03', '2022-03-07 16:20:03'),
(9, 'Luyk Jumpsuit', 8, 1, '{\"1\":{\"name\":\"Waist\",\"value\":[\"*\",\"*\",\"25\",\"26\",\"27\",\"28\",\"29\"]},\"2\":{\"name\":\"Across Shoulder\",\"value\":[\"*\",\"*\",\"9\",\"9.5\",\"19\",\"10.5\",\"11\"]},\"3\":{\"name\":\"Chest\",\"value\":[\"*\",\"*\",\"25\",\"26\",\"27\",\"28\",\"29\"]},\"4\":{\"name\":\"Inseam Length\",\"value\":[\"*\",\"*\",\"20\",\"21.5\",\"24.5\",\"24.5\",\"26\"]}}', '[{\"id\":\"80\",\"name\":\"3-4Y\"},{\"id\":\"81\",\"name\":\"5-6Y\"},{\"id\":\"82\",\"name\":\"7-8Y\"},{\"id\":\"83\",\"name\":\"9-10Y\"},{\"id\":\"84\",\"name\":\"11-12Y\"},{\"id\":\"85\",\"name\":\"13-14Y\"},{\"id\":\"86\",\"name\":\"15-16Y\"}]', 'SHOPJASHN', NULL, '2022-03-07 16:22:02', '2022-03-07 16:22:02'),
(10, 'Luyk Trousers', 8, 1, '{\"1\":{\"name\":\"Waist\",\"value\":[\"*\",\"*\",\"24\",\"25\",\"26\",\"27\",\"28\"]},\"2\":{\"name\":\"Inseam Length\",\"value\":[\"*\",\"*\",\"22\",\"23.5\",\"25\",\"26\",\"28\"]}}', '[{\"id\":\"80\",\"name\":\"3-4Y\"},{\"id\":\"81\",\"name\":\"5-6Y\"},{\"id\":\"82\",\"name\":\"7-8Y\"},{\"id\":\"83\",\"name\":\"9-10Y\"},{\"id\":\"84\",\"name\":\"11-12Y\"},{\"id\":\"85\",\"name\":\"13-14Y\"},{\"id\":\"86\",\"name\":\"15-16Y\"}]', 'SHOPJASHN', NULL, '2022-03-07 16:22:47', '2022-03-07 16:22:47'),
(11, 'Luky Clothing Set', 8, 1, '{\"1\":{\"name\":\"Across Shoulder\",\"value\":[\"*\",\"9.5\",\"10\",\"10.5\",\"11\",\"11.5\",\"*\"]},\"2\":{\"name\":\"Chest\",\"value\":[\"*\",\"27\",\"29\",\"30\",\"30\",\"31\",\"*\"]},\"3\":{\"name\":\"Front Length\",\"value\":[\"*\",\"18\",\"19\",\"21\",\"22.5\",\"24\",\"*\"]},\"4\":{\"name\":\"InSeam Length\",\"value\":[\"*\",\"19.5\",\"21\",\"22.5\",\"24\",\"25.5\",\"*\"]},\"5\":{\"name\":\"Outseam Length\",\"value\":[\"*\",\"23\",\"24\",\"25\",\"26\",\"27\",\"*\"]},\"6\":{\"name\":\"Waist\",\"value\":[\"*\",\"23\",\"24\",\"25\",\"26\",\"27\",\"*\"]}}', '[{\"id\":\"80\",\"name\":\"3-4Y\"},{\"id\":\"81\",\"name\":\"5-6Y\"},{\"id\":\"82\",\"name\":\"7-8Y\"},{\"id\":\"83\",\"name\":\"9-10Y\"},{\"id\":\"84\",\"name\":\"11-12Y\"},{\"id\":\"85\",\"name\":\"13-14Y\"},{\"id\":\"86\",\"name\":\"15-16Y\"}]', 'SHOPJASHN', NULL, '2022-03-07 16:24:49', '2022-03-07 16:24:49'),
(12, 'Luyk Tops', 8, 1, '{\"1\":{\"name\":\"Chest\",\"value\":[\"*\",\"*\",\"28\",\"29\",\"30\",\"31\",\"32\"]},\"2\":{\"name\":\"Front Length\",\"value\":[\"*\",\"*\",\"19\",\"20\",\"21\",\"22\",\"23\"]}}', '[{\"id\":\"80\",\"name\":\"3-4Y\"},{\"id\":\"81\",\"name\":\"5-6Y\"},{\"id\":\"82\",\"name\":\"7-8Y\"},{\"id\":\"83\",\"name\":\"9-10Y\"},{\"id\":\"84\",\"name\":\"11-12Y\"},{\"id\":\"85\",\"name\":\"13-14Y\"},{\"id\":\"86\",\"name\":\"15-16Y\"}]', 'SHOPJASHN', NULL, '2022-03-07 16:25:40', '2022-03-07 16:25:40'),
(13, 'Bed Sheets', 9, 1, '{\"1\":{\"name\":\"Mattress (In Feet) (4Inch Mattress)\",\"value\":[\"3.5\\u2019 x 6\\u2019\",\"5.5\\u2019 x 6.5\\u2019\",\"5.5\\u2019 x 6.5\\u2019\",\"6\\u2019 x 6.5\\u2019\",\"6\\u2019 x 6.5\",\"6.5\\u2019 x 7\\u2019\",\"7\\u2019 x 7\\u2019\"]},\"2\":{\"name\":\"Bedsheet (In Inch)\",\"value\":[\"60\\u201d x 90\\u201d\",\"90\\u201d x 100\\u201d\",\"100\\u201d x 100\\u201d\",\"90\\u201d x 108\\u201d\",\"95\\u201d x 108\\u201d\",\"100\\u201d x 108\\u201d\",\"108\\u201d x 108\\u201d\"]}}', '[{\"id\":\"87\",\"name\":\"Single Bed Size\"},{\"id\":\"88\",\"name\":\"Double Bed Size A\"},{\"id\":\"89\",\"name\":\"Double Bed Size B\"},{\"id\":\"90\",\"name\":\"Queen Bed Size A\"},{\"id\":\"91\",\"name\":\"Queen Bed Size B\"},{\"id\":\"92\",\"name\":\"King Size\"},{\"id\":\"93\",\"name\":\"Jumbo Size\"}]', 'SHOPJASHN', NULL, '2022-03-07 16:28:43', '2022-03-07 16:28:43'),
(14, 'Free Size', 11, 1, '{\"1\":{\"name\":\"Upto\",\"value\":[\"All Sizes\",\"Upto 5XL\"]}}', '[{\"id\":\"99\",\"name\":\"Free For All\"},{\"id\":\"100\",\"name\":\"Free Upto 5xl\"}]', 'SHOPJASHN', NULL, '2022-03-07 16:30:46', '2022-03-07 16:30:46'),
(15, 'Saree Size', 12, 1, '{\"1\":{\"name\":\"Saree\",\"value\":[\"5.5 Meters\"]},\"2\":{\"name\":\"Blouse\",\"value\":[\"0.80 Meters\"]}}', '[{\"id\":\"101\",\"name\":\"5.5\\/0.80 MTRS\"}]', 'SHOPJASHN', NULL, '2022-03-07 16:31:13', '2022-03-07 16:31:13');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `image`, `url`, `display`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Slider 1', '1630236892.jpg', 'https://www.jashn.com/', 1, 'KTM RUSH', 'KTM RUSH', '2021-08-29 05:16:02', '2021-08-29 06:38:43'),
(2, 'Slider 2', '1630239822.jpg', 'https://www.jashn.com/', 1, 'KTM RUSH', 'KTM RUSH', '2021-08-29 05:16:18', '2021-08-29 05:49:52'),
(3, 'Slider 3', '1630236979.jpg', 'https://www.jashn.com/', 1, 'KTM RUSH', 'KTM RUSH', '2021-08-29 05:20:12', '2021-08-29 05:51:20');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display` tinyint(1) DEFAULT 1,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `country_id`, `display`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(13, 'Provision 1', '1', 1, 'SHOPJASHN', 'SHOPJASHN', '2022-03-05 17:09:29', '2022-03-05 17:16:46'),
(14, 'Madhesh Province', '1', 1, 'SHOPJASHN', 'SHOPJASHN', '2022-03-05 17:10:28', '2022-03-06 23:01:38'),
(15, 'Bagmati Province', '1', 1, 'SHOPJASHN', 'SHOPJASHN', '2022-03-05 17:10:37', '2022-03-06 23:01:50'),
(16, 'Gandaki Province', '1', 1, 'SHOPJASHN', 'SHOPJASHN', '2022-03-05 17:10:46', '2022-03-06 23:01:56'),
(17, 'Lumbini Province', '1', 1, 'SHOPJASHN', 'SHOPJASHN', '2022-03-05 17:10:56', '2022-03-06 23:02:03'),
(18, 'Karnali Province', '1', 1, 'SHOPJASHN', 'SHOPJASHN', '2022-03-05 17:11:06', '2022-03-06 23:02:15'),
(19, 'Sudurpashchim Province', '1', 1, 'SHOPJASHN', 'SHOPJASHN', '2022-03-05 17:11:15', '2022-03-06 23:02:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `country_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `state_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `district_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `city_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `get_updates_via_sms` tinyint(1) NOT NULL DEFAULT 1,
  `get_updates_via_email` tinyint(1) NOT NULL DEFAULT 1,
  `get_updates_on_chrome` tinyint(1) NOT NULL DEFAULT 1,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `country_id`, `country_name`, `state_id`, `state_name`, `district_id`, `district_name`, `city_id`, `city_name`, `address`, `get_updates_via_sms`, `get_updates_via_email`, `get_updates_on_chrome`, `password`, `email_verified_at`, `otp`, `remember_token`, `provider`, `provider_id`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'KTM RUSH', 'ktmrushservices@gmail.com', '9843XXXXXX', 1, NULL, 1, NULL, 1, NULL, 1, NULL, NULL, 1, 1, 1, '$2y$10$aBTCB.HU4MQmw5nBWTNw1OteqoCDP7OWt8GXRakYnyOGC3x4PQWVa', '2021-06-21 03:21:09', NULL, 'WP6Vo1dzgiyq1MFrm2emljWBotshXpVpUtfUHj1wgJ6dJVg2KPn4d8G39qRf', NULL, NULL, NULL, '2021-06-21 03:21:09', '2021-06-21 03:21:09', NULL, NULL),
(5, 'Gehendra Chaudhary', 'gehendra@ktmrush.com', '9849507010', 1, NULL, 7, NULL, 4, NULL, 1, NULL, 'Hasanpur', 1, 1, 1, '$2y$10$a8aoAQ.REkyNUhDQeDwNG.LGOh2Oy.n.TRiVCANaRrR2MhxT4EDmK', NULL, NULL, '73tnX9g3R9mXnGzDEXjnpmWIUCwIjCAZj9gbbRdoh2U8MWLxNUgLRYM3jEI1', NULL, NULL, NULL, '2021-09-17 04:51:33', '2021-09-20 03:17:16', NULL, NULL),
(9, 'Gehendra Chaudhary', 'rockstar.gehendra19@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, '', NULL, NULL, NULL, 'google', '100988690405186401598', NULL, '2021-12-22 06:42:43', '2021-12-22 06:42:43', NULL, NULL),
(10, 'QA', 'qa@ktmrush.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, '$2y$10$3BfICOdk68j9tNntrHehV.koDdaEbqdJ31Hl7Nl3PO0wVnMMErvq2', NULL, NULL, NULL, NULL, NULL, NULL, '2022-01-09 01:45:38', '2022-01-09 01:45:38', NULL, NULL),
(11, 'SHOPJASHN', 'shop@jashn.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, '$2y$10$GXaNI3GgISOQ8FinCEEKXegNHLtexl340/9DbVlFXFzc5.Ob6uHxe', NULL, NULL, 'xPsMjrl0eIzMHbJ8gNnfiNPoT42KJA2bwjFtUJzOvdDrNnXxpGJHTlriWMAk', NULL, NULL, NULL, '2022-03-04 20:03:40', '2022-03-04 20:03:40', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `customer_id`, `product_id`, `created_at`, `updated_at`) VALUES
(3, 5, 3, '2021-11-14 03:10:43', '2021-11-14 03:10:43'),
(4, 5, 2, '2021-11-14 03:11:09', '2021-11-14 03:11:09'),
(5, 5, 6, '2021-11-14 03:17:26', '2021-11-14 03:17:26'),
(6, 5, 12, '2022-02-24 06:49:37', '2022-02-24 06:49:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_slug_unique` (`slug`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_district_id_foreign` (`district_id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contents_slug_unique` (`slug`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courier_rates`
--
ALTER TABLE `courier_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courier_rates_country_id_foreign` (`country_id`),
  ADD KEY `courier_rates_state_id_foreign` (`state_id`),
  ADD KEY `courier_rates_district_id_foreign` (`district_id`);

--
-- Indexes for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `c_o_d_s`
--
ALTER TABLE `c_o_d_s`
  ADD PRIMARY KEY (`id`),
  ADD KEY `c_o_d_s_state_id_foreign` (`state_id`),
  ADD KEY `c_o_d_s_district_id_foreign` (`district_id`),
  ADD KEY `c_o_d_s_city_id_foreign` (`city_id`);

--
-- Indexes for table `discount_coupons`
--
ALTER TABLE `discount_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `districts_state_id_foreign` (`state_id`),
  ADD KEY `districts_country_id_foreign` (`country_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `occassions`
--
ALTER TABLE `occassions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `occassion_products`
--
ALTER TABLE `occassion_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `occassion_products_occassion_id_foreign` (`occassion_id`),
  ADD KEY `occassion_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `on_routes`
--
ALTER TABLE `on_routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ordered_products`
--
ALTER TABLE `ordered_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_no_unique` (`order_no`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_cares`
--
ALTER TABLE `product_cares`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_colors`
--
ALTER TABLE `product_colors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_colors_product_id_foreign` (`product_id`),
  ADD KEY `product_colors_color_id_foreign` (`color_id`);

--
-- Indexes for table `product_coupons`
--
ALTER TABLE `product_coupons`
  ADD KEY `product_coupons_product_id_foreign` (`product_id`),
  ADD KEY `product_coupons_discount_coupon_id_foreign` (`discount_coupon_id`);

--
-- Indexes for table `product_offers`
--
ALTER TABLE `product_offers`
  ADD KEY `product_offers_product_id_foreign` (`product_id`),
  ADD KEY `product_offers_offer_id_foreign` (`offer_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_reviews_customer_id_foreign` (`customer_id`),
  ADD KEY `product_reviews_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_sizes_product_color_id_foreign` (`product_color_id`),
  ADD KEY `product_sizes_size_id_foreign` (`size_id`);

--
-- Indexes for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variations_product_id_foreign` (`product_id`),
  ADD KEY `product_variations_color_id_foreign` (`color_id`),
  ADD KEY `product_variations_size_id_foreign` (`size_id`);

--
-- Indexes for table `return_requests`
--
ALTER TABLE `return_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `return_requests_order_id_foreign` (`order_id`);

--
-- Indexes for table `return_request_products`
--
ALTER TABLE `return_request_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `return_request_products_return_request_id_foreign` (`return_request_id`);

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
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sizes_size_group_id_foreign` (`size_group_id`);

--
-- Indexes for table `size_groups`
--
ALTER TABLE `size_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `size_guides`
--
ALTER TABLE `size_guides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `size_guides_size_group_id_foreign` (`size_group_id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_customer_id_foreign` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `couriers`
--
ALTER TABLE `couriers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `courier_rates`
--
ALTER TABLE `courier_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `c_o_d_s`
--
ALTER TABLE `c_o_d_s`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `discount_coupons`
--
ALTER TABLE `discount_coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `occassions`
--
ALTER TABLE `occassions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `occassion_products`
--
ALTER TABLE `occassion_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `on_routes`
--
ALTER TABLE `on_routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ordered_products`
--
ALTER TABLE `ordered_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_cares`
--
ALTER TABLE `product_cares`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_colors`
--
ALTER TABLE `product_colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `product_variations`
--
ALTER TABLE `product_variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `return_requests`
--
ALTER TABLE `return_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `return_request_products`
--
ALTER TABLE `return_request_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `size_groups`
--
ALTER TABLE `size_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `size_guides`
--
ALTER TABLE `size_guides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courier_rates`
--
ALTER TABLE `courier_rates`
  ADD CONSTRAINT `courier_rates_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `courier_rates_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `courier_rates_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD CONSTRAINT `customer_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `c_o_d_s`
--
ALTER TABLE `c_o_d_s`
  ADD CONSTRAINT `c_o_d_s_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `c_o_d_s_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `c_o_d_s_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `districts_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `occassion_products`
--
ALTER TABLE `occassion_products`
  ADD CONSTRAINT `occassion_products_occassion_id_foreign` FOREIGN KEY (`occassion_id`) REFERENCES `occassions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `occassion_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `product_colors`
--
ALTER TABLE `product_colors`
  ADD CONSTRAINT `product_colors_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_colors_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_coupons`
--
ALTER TABLE `product_coupons`
  ADD CONSTRAINT `product_coupons_discount_coupon_id_foreign` FOREIGN KEY (`discount_coupon_id`) REFERENCES `discount_coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_coupons_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_offers`
--
ALTER TABLE `product_offers`
  ADD CONSTRAINT `product_offers_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_offers_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `product_reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `product_sizes_product_color_id_foreign` FOREIGN KEY (`product_color_id`) REFERENCES `product_colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_sizes_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD CONSTRAINT `product_variations_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`),
  ADD CONSTRAINT `product_variations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_variations_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`);

--
-- Constraints for table `return_requests`
--
ALTER TABLE `return_requests`
  ADD CONSTRAINT `return_requests_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `return_request_products`
--
ALTER TABLE `return_request_products`
  ADD CONSTRAINT `return_request_products_return_request_id_foreign` FOREIGN KEY (`return_request_id`) REFERENCES `return_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sizes`
--
ALTER TABLE `sizes`
  ADD CONSTRAINT `sizes_size_group_id_foreign` FOREIGN KEY (`size_group_id`) REFERENCES `size_groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `size_guides`
--
ALTER TABLE `size_guides`
  ADD CONSTRAINT `size_guides_size_group_id_foreign` FOREIGN KEY (`size_group_id`) REFERENCES `size_groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
