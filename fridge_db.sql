-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 24, 2017 at 12:15 PM
-- Server version: 5.7.18-0ubuntu0.16.04.1
-- PHP Version: 7.0.18-1+deb.sury.org~xenial+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fridge_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `fridge_refills`
--

CREATE TABLE `fridge_refills` (
  `fridge_refill_id` int(11) NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `english_description` varchar(255) NOT NULL,
  `french_description` longtext CHARACTER SET utf8,
  `arabic_description` longtext CHARACTER SET utf8 COLLATE utf8_romanian_ci,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fridge_refills`
--

INSERT INTO `fridge_refills` (`fridge_refill_id`, `item_id`, `image`, `english_description`, `french_description`, `arabic_description`, `created_at`, `updated_at`) VALUES
(1, 1, 'http://communityfridge.org/assets/uploads/refills/58d0fb5d93483.png', 'I have filled this fridge with fruit, vegetable, juices, grocery, fresh mill, ice, drink, dry fruits, butter, cheese, rusks, bread and curd JAZAKALLAH', '', '', '2017-03-21 05:07:25', '2017-03-21 10:07:25'),
(2, 1, 'http://communityfridge.org/assets/uploads/refills/58d11464b89e1.jpg', 'Bshsuabjqkas\nD\nD\nD\n\nD', '', '', '2017-03-21 06:54:12', '2017-03-21 11:54:12'),
(3, 9, 'http://communityfridge.org/assets/uploads/refills/59058805ea2bd.jpg', 'Just added fresh fruit', '', '', '2017-04-30 01:45:25', '2017-04-30 06:45:25'),
(4, 9, 'http://communityfridge.org/assets/uploads/refills/5908445fbdcf6.jpg', 'Added cans or coke', '', '', '2017-05-02 03:33:35', '2017-05-02 08:33:35'),
(5, 4, 'http://communityfridge.org/assets/uploads/refills/59087a2bb3319.jpg', 'Testing and', '', '', '2017-05-02 07:23:07', '2017-05-02 12:23:07'),
(6, 1, 'http://communityfridge.org/assets/uploads/refills/5909d9417cd9e.jpg', 'Milkfhhg', '', '', '2017-05-03 08:21:05', '2017-05-03 13:21:05'),
(7, 4, 'http://communityfridge.org/assets/uploads/refills/590afe1de3b1b.png', 'I have filled this fridge with fruit, vegetable, juices, grocery, fresh mill, ice, drink, dry fruits, butter, cheese, rusks, bread and curd JAZAKALLAH', '', '', '2017-05-04 05:10:37', '2017-05-04 10:10:37'),
(8, 1, 'http://communityfridge.org/assets/uploads/refills/590b134b4cb7d.jpg', 'I have filled this fridge with fruit, vegetable, juices, grocery, fresh mill, ice, drink, dry fruits, butter, cheese, rusks, bread and curd JAZAKALLAH', '', '', '2017-05-04 06:40:59', '2017-05-04 11:40:59'),
(9, 2, 'http://communityfridge.org/assets/uploads/refills/590c129f0df5c.jpg', 'I have filled this fridge with fruit, vegetable, juices, grocery, fresh mill, ice, drink, dry fruits, butter, cheese, rusks, bread and curd JAZAKALLAH', '', '', '2017-05-05 00:50:23', '2017-05-05 05:50:23');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) UNSIGNED NOT NULL,
  `condition` varchar(20) NOT NULL,
  `services` varchar(255) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `access_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_romanian_ci NOT NULL,
  `preferred_filling_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_romanian_ci NOT NULL,
  `country` varchar(100) NOT NULL,
  `area` varchar(255) NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_romanian_ci NOT NULL,
  `status` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `condition`, `services`, `latitude`, `longitude`, `access_time`, `preferred_filling_time`, `country`, `area`, `address`, `status`, `is_active`, `user_id`, `manager_id`, `created_at`, `updated_at`) VALUES
(1, 'Active', 'Cooler, Fridge', 31.4881, 74.3788, '4', '7', 'Pakistan', 'Islamabad', 'Street 9, Lahore', 'Full', 0, 57, 1, '2017-03-21 05:02:05', '2017-05-22 07:18:02'),
(5, 'Active', 'Fridge,Shelf,Cooler', 31.4904, 74.3794, '12:00 AM', '11:30 AM', 'Pakistan', 'Lahore', 'office', 'Deleted', 1, 50, 3, '2017-04-20 06:55:50', '2017-05-11 12:29:01'),
(6, 'Active', 'Fridge,Cooler,Shelf', 31.4909, 74.3788, '11:00 AM12:00 PM12:34 AM11:35 AM', '01:00 PM', 'Pakistan', 'Lahore', 'Main Boulevard', 'Needs Refilled', 1, 50, 1, '2017-04-21 02:29:06', '2017-05-12 05:52:14'),
(7, 'Active', 'Fridge', 11.214, 26.5709, '01:30 AM', '12:00 AM', 'Sudan', 'Darfur Wilayat', 'Africa Test Location', 'Full', 0, 50, NULL, '2017-04-21 02:30:59', '2017-05-02 12:26:41'),
(8, 'Active', 'Fridge', 24.2353, 55.7178, '13:00-21:00', '11;00- 12:30', 'United Arab Emirates', 'Al Ain', 'Address', 'Needs Refilled', 0, 59, NULL, '2017-04-22 11:48:16', '2017-04-22 16:49:05'),
(9, 'Active', 'Fridge,Cooler,Shelf', 25.3111, 55.4897, '2:30 pm - 7:00 pm', 'beat to fill in the mornings', 'Unnamed Road - Sharjah - United Arab Emirates', 'Sharjah', 'aus. behind the physical plant building', 'Needs Refilled', 1, 23, NULL, '2017-04-30 01:44:35', '2017-05-11 08:31:53'),
(10, 'Active', 'Fridge,Shelf', 31.4921, 74.3815, 'uuy\n', 'gtr', 'Pakistan', 'Lahore', 'Test', 'Full', 1, 56, NULL, '2017-05-03 10:00:31', '2017-05-11 08:29:34');

-- --------------------------------------------------------

--
-- Table structure for table `item_images`
--

CREATE TABLE `item_images` (
  `image_id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `item_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_images`
--

INSERT INTO `item_images` (`image_id`, `image`, `item_id`) VALUES
(1, 'http://communityfridge.org/assets/uploads/58d0fa1d493d1.jpg', 1),
(2, 'http://communityfridge.org/assets/uploads/58d0fa1d4aaac.png', 1),
(4, 'http://communityfridge.org/assets/uploads/58d11049e08be.jpg', 2),
(5, 'http://communityfridge.org/assets/uploads/58d11b72ed692.jpg', 3),
(6, 'http://communityfridge.org/assets/uploads/58d120b76da5e.jpg', 4),
(8, 'http://communityfridge.org/assets/uploads/58f8a1ffae714.jpg', 5),
(13, 'http://communityfridge.org/assets/uploads/58fb8981cb47c.jpg', 8),
(17, 'http://communityfridge.org/assets/uploads/5908770b9791a.jpg', 9),
(18, 'http://communityfridge.org/assets/uploads/59087b017e9b1.jpg', 7),
(19, 'http://communityfridge.org/assets/uploads/5909f08f9fa32.jpg', 10);

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

CREATE TABLE `managers` (
  `manager_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`manager_id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Hafiz Muhammad Abuzar', 'hafizmabuzar@synergistics.pk', '4321', '2017-05-12 01:57:28', '2017-05-12 05:57:28'),
(3, 'Talha Bukhari', 'talha@syg.pk', '112233', '2017-05-11 02:21:02', '2017-05-11 06:21:02');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `token_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(255) NOT NULL,
  `player_id` varchar(255) DEFAULT NULL,
  `device_id` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`token_id`, `token`, `player_id`, `device_id`, `user_email`, `created_date`, `updated_date`) VALUES
(1, 'b014b51bd4f0485c70e6851c69ede527792405ef5686420b4f23bc643f4a4f39', 'a5d0e259-60b0-4665-b933-9839c0f4c91e', NULL, '', '2016-10-03 01:10:05', '2016-10-03 06:42:27'),
(2, 'APA91bET9GqgjTirn-Yxxeel-opC10-mN39MSV8QkaJIPwLC3oe6j_I1EQHWqR8WneFk8-iWp7uNI_16W90BM-o0uX2k7oIr54yRzPqYtHh-yt1WWqlmAzZwkHuyTORSEN1wZg6QBxcb', NULL, 'a25c989135338f83', 'talha.bukhari@synergistics.pk', '2016-10-03 01:22:04', '2016-10-13 10:20:56'),
(3, 'APA91bF6uzSaQIR1jbcELsevq7aluxN22F3phWRA0FV6pGb3lCLXWCjbdgRFFi8qn1wfSIdOe3fGnVQ8E9YaDiQe4si3WX24QzQ6O5U6zWdaPZJqnbMzw_k6iixBzJo8EC4lHMTzcOWi', NULL, 'cfac9f55bd7dd7ac', 'talha@syg.pk', '2016-10-03 01:43:41', '2016-10-19 05:29:06'),
(4, 'ccd847ec350cb23adfa3002ff5c5358b1225aaad68a9fa0af0d7573211f03517', 'f5a90f91-d1fc-4a68-a6f2-29e111db3836', NULL, 'yasir@synergistics.pk', '2016-10-03 01:46:09', '2016-10-07 09:51:56'),
(5, 'APA91bH_PqZlAIHDBeZbrdPdQENcRtWMULtzbcxBy-jGEgqsi5o4KtW8mzk3nK-0MQRxRNzXbV2pGcqcmuSExudiVBRmlnchboB7ZjisJxIHqepPNB7zSzjmscgBSiopOI1uVZXLgWzT', NULL, '19a0c2c422eb8f6d', 'hamza790@gmail.com', '2016-10-03 02:26:51', '2016-10-19 06:59:57'),
(6, '7dd9688efce3d5b31f1eeedeb01417cf185715f848465e111d3d2206324af1ad', '1e14e83d-a133-4975-b3f0-25d073f9fc62', NULL, '', '2016-10-03 04:53:30', '2016-10-03 10:01:37'),
(7, 'APA91bEc9o1pPUGX5mmoQQe2BM7IOeAMQPI1sSePfDTbUxo9FLUfCdguRqUBfQwRqVB3LrYx0sbh7nZ2B2Aom1PPrjSYw_1XkvWvdhd-W2v02GTLyYMB6WUeICsEanvnxdMQ4qMeHL_T', NULL, '6446cab1efe7ca47', NULL, '2016-10-03 05:08:26', '2016-10-04 06:16:05'),
(8, '58a1c9d32812fc7533c0bfc3742bd4ce922bb264c75357ae30b177fe3a58976a', '2f8865ba-8f14-4b63-9d8c-46aba71dde18', NULL, NULL, '2016-10-04 07:31:00', '2016-10-04 12:31:00'),
(9, 'ec081f4490112640d007abc821fd15f8b28d3e85ce58007762d5b6c7fe88b859', 'ff6f20d9-a4eb-4b51-b39f-cf5286ccd595', NULL, 'yasir@synergistics.pk', '2016-10-07 05:00:17', '2016-10-07 10:00:54'),
(10, 'APA91bFh3TdJdCod2RAotsOGclE56FEBQV9cR96i2MJRbyV1dzZ1MHMcao5NtwEWDiQUguLOyzl7eHjrZ10uKxJZxXrAwd1bgk-vEUjBBRuIJF3eLgwTQCoM-1sx_HB3S05HN5T5jkfN', NULL, '938226e7a84211f3', '', '2016-10-13 05:32:34', '2016-10-13 10:38:43'),
(11, 'APA91bFwmtEOmeaXg_QwAfGgeme5uOLt27bYqZmxMA-0SHEl69cR7zVCih_z2-iVuskCIrzL5PM0Ql8CMltWSG71iAZUzJdVQGvNQISuZ-ksPIK54byAEgKf3UTvf8ELRaTEGG0oJZ5L', NULL, '3d99fb4bee0714e8', 'talha.bukhari@yahoo.com', '2017-03-20 06:43:23', '2017-05-05 05:40:40'),
(12, '0a4c2ad2a5d3b77f1096f90d88e19c083139282f1dcfde0ed151a2b67fdf455c', 'f74ef43e-fe69-451d-adec-551308190ee3', NULL, 'yasir@synergistics.pk', '2017-03-20 07:17:50', '2017-03-21 07:34:13'),
(13, '39cfb7b48e75ec7dbaf7a318df94351e66e7bcfaee8862af42c30cd8c9990549', '61ae8e61-ce61-48ab-9b54-319783219f0d', NULL, 'fahadnaeem@synergistics.pk', '2017-03-21 02:55:48', '2017-03-21 11:34:26'),
(14, '2adc352b68087144347d0cdce0db1ecf4116540d6795a745d791191ef45e8de7', '2e107ca5-b5c6-422a-a038-59d3dc918dd3', NULL, 'horizonapp786@gmail.com', '2017-03-21 07:22:08', '2017-03-21 12:23:12'),
(15, '4564e8504c997dd5af575d831175e94d293220fe952e6dc76ce6107311cb64f0', '61c6cc40-8c04-4a33-954b-30148a9a4189', NULL, '', '2017-03-21 07:35:09', '2017-04-24 07:06:12'),
(16, '36e21e1c83ee4b11cf257c3ee0e8a950e444669ee4ef818d0f86e1ca8d7da3ee', '3621c012-0af5-49a9-a1b7-c2c0b7f7d83d', NULL, NULL, '2017-03-21 13:45:54', '2017-03-21 18:45:54'),
(17, 'APA91bHBPtq4sDV47IRXt0Z3SanAarRfV5fLQlqKg7A6uIia1X_uYHt1bTfbPwThyq1_Ug82_ig1qi2Ygarx4ZqahfYy-_jflWM-4TX-8pG_lDBfznmh0cKVagOvNZB-pj8nwXKsdolv', NULL, '92458065028c844f', NULL, '2017-04-16 03:08:45', '2017-04-16 08:08:45'),
(18, '4303c4422f96404fddd6ffab799a788618150cdeba2a987e0867c4f20e4b9244', 'c9a599f8-68d2-4bc5-8fab-5002b97e7b81', NULL, NULL, '2017-04-20 02:43:48', '2017-04-20 07:43:48'),
(19, '08da8f6a011ae3fd94d534e60a51a828cb0c7e19189079a1fd058ab6d3c2a0b1', 'b56ca6db-2e5a-4850-993b-56e78ef0de21', NULL, '', '2017-04-20 05:39:04', '2017-04-23 18:37:43'),
(20, '30fb6a2f6fac3cabff79d58e20f98657f22d752b43747b84470fe5ccd4e0adfe', 'da2f58f9-fc25-4b80-a63f-30528bf2290f', NULL, '', '2017-04-20 17:14:49', '2017-04-22 16:49:14'),
(21, '3381a2b7c7e35586a9f1651bf08e754b1051df04930816f185e48d792d011c29', 'd4c5e380-01cd-44c1-93a3-4c3fd53936c1', NULL, 'hamza790@hotmail.com', '2017-04-23 13:39:00', '2017-05-02 10:11:22'),
(22, 'ca770c028677bd9bf46baac0a59b4ec235809b85936639d157e9864e7b029480', '74a92cbe-e1b1-4a82-ac60-f7ef89e6da05', NULL, 'akhawaja@aus.edu', '2017-04-30 01:40:46', '2017-04-30 06:43:17'),
(23, 'db1de1dc2249f461b4ad5ac6bb1fbca8365b1707e126c8b566e3b9caee0f0d3d', 'b067e9e0-08a6-4119-8ae0-4caad501b6c8', NULL, 'fahadnaeem@synergistics.pk', '2017-04-30 01:48:36', '2017-04-30 06:53:23'),
(24, '73c0b33ce02d7b325913b407c94327802bcebc5495fc10c07dc3e6cca5decba0', '5c0ce60a-43aa-442a-8013-d67819c6433e', NULL, 'horizonapp786@gmail.com', '2017-05-03 03:27:02', '2017-05-03 11:37:20'),
(25, 'ee6a297b12b382c14820d9ae6e81b40143ce085f8069e1d25cd104e5ef9f274b', '8f6cb0a3-ef71-462c-815f-1b824165714b', NULL, NULL, '2017-05-04 02:29:59', '2017-05-04 07:29:59'),
(26, 'b4836496293c7b247a4f0985cc4750d89ada9b7b92d969182451acdd3d895659', '9f242f2e-e761-46f6-ada5-bfec9db930fc', NULL, NULL, '2017-05-04 04:04:23', '2017-05-04 09:04:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mobile` varchar(20) CHARACTER SET utf8 NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `account_type` varchar(20) CHARACTER SET utf8 NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `mobile`, `remember_token`, `account_type`, `status`, `created_at`, `updated_at`) VALUES
(3, 'yasir', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'yasir@syg.pk', '1234', 'f98ce0284c602bc5d546177d566e81d855', 'normal', 1, '2016-08-19 02:56:25', '2016-10-03 10:46:05'),
(4, 'Usman Ahmed', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'u4usman.zain@yahoo.com', '90606006', '254e1cb2e126c064f4b0d6b856c0e10e', 'normal', 0, '2016-09-08 03:42:21', '2016-10-03 10:46:05'),
(6, 'Usman Ahmed', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'u4usman.ahm@yahoo.com', '096006', 'edddeb8ec020dae8fabbd9477abfa100', 'normal', 0, '2016-09-08 03:58:37', '2016-10-03 10:46:05'),
(7, 'Usman Ahmed', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'u4usd@yahoo.com', '99', '823f3044a4a823e84396b4c1297f15c0', 'normal', 0, '2016-09-08 04:04:38', '2016-10-03 10:46:05'),
(10, 'u4usman', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'u4usman.zain@gmail.com', '088663', '165952cb3a77366a75b48bb8a239436d', 'normal', 1, '2016-09-19 03:31:35', '2016-10-03 10:46:05'),
(11, 'Talha Bukhari', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'talha.bukhari@synergistics.pk', '00923336515953', '45661214f681f48ae4716ead454bfcad', 'normal', 1, '2016-09-30 01:12:54', '2016-10-04 06:41:46'),
(20, 'Talha Bukhari', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'talha@syg.pk', '00923336515953', 'f68ccf45ad34898870fc766cc1ae1985', 'normal', 1, '2016-09-30 01:20:46', '2016-10-03 10:46:05'),
(22, 'Usman Ahmed', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'hafizmabuzar@synergistics.pk', '7540449', '9f63acf20cbafe2d8fd023673c19e4cd', 'normal', 1, '2016-09-30 05:14:37', '2016-10-19 06:01:16'),
(23, 'akhawaja', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'akhawaja@aus.edu', '0505521466', '397f60173811e8e6236d1c34b2ff3612', 'normal', 0, '2016-09-30 13:42:45', '2016-10-03 10:46:05'),
(25, 'yasir2', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'yasir@synergistics.pk', '03434712950', 'ca8ff787f57d96356578796b0a8e1181', 'normal', 1, '2016-10-02 23:56:18', '2016-10-03 10:46:05'),
(26, 'Bukhari', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'engr.talhaumair@gmail.com', '03336515983', '1604a9490672f795bfbeea17f1d3d69c', 'normal', 1, '2016-10-03 05:43:21', '2016-10-03 10:46:05'),
(28, 'Muhammad Yasir', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'l060219@lhr.nu.edu.pk', '0', '9bf4a66cf46068caa7564f5ae59938e2', 'facebook', 0, '2016-10-03 06:08:03', '2016-10-03 11:08:03'),
(30, 'Usman Ahmed', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'u4usman.ahmad@yahoo.com', '', '4739bd5d882e1e40a84571825c58da82', 'facebook', 1, '2016-10-03 06:11:33', '2016-10-03 11:38:15'),
(32, 'test', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'u4uaman.ahmad@yahoo.com', '222', '4f5d0c479e3b491c082fbccbe5a833f8', 'normal', 0, '2016-10-03 06:25:05', '2016-10-03 11:25:05'),
(33, 'Hussam Jaberr', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'sayartiae@gmail.com', '', '6a24ef2199680617cd6168ec13931776', 'facebook', 0, '2016-10-03 07:56:30', '2016-10-03 12:56:30'),
(35, 'akhawaja', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'akhawaja@aus.edu', '0505521466', '397f60173811e8e6236d1c34b2ff3612', 'facebook', 0, '2016-10-05 17:01:46', '2016-10-05 22:01:46'),
(36, 'Ali Khawaja', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'ak@synergistics.ae', '0', '5101f6dd21820b4dce78a22c4e338700', 'facebook', 0, '2016-10-05 17:02:48', '2016-10-05 22:02:48'),
(37, 'Talha Bukhari', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'syedtalha1984@yahoo.com', '', 'f11586bac73b5a3f0c109eef4d687083', 'facebook', 0, '2016-10-13 05:33:36', '2016-10-13 10:33:36'),
(50, 'hamza', '35139ef894b28b73bea022755166a23933c7d9cb', 'hamza790@hotmail.com', '03454545', 'ce7342669a0bdcc4791e843c7c22dc32', 'normal', 1, '2016-10-14 06:59:21', '2016-10-14 12:03:03'),
(51, 'Sara', '8cb2237d0679ca88db6464eac60da96345513964', 'g00053242@aus.edu', '0501374919', '029399ab598e34792068ddc73935aeda', 'normal', 0, '2016-10-14 12:26:18', '2016-10-14 17:26:18'),
(52, 'sara96', '8cb2237d0679ca88db6464eac60da96345513964', 'pk@synergistics.ae', '0501374919', 'aba0e6e5786da1ec875faddb04b4c2a4', 'normal', 0, '2016-10-14 13:09:12', '2016-10-14 18:09:12'),
(53, 'haha', '8cb2237d0679ca88db6464eac60da96345513964', 'Hamza_babri@hotmail.co.uk', '0501374919', 'c8819200ca5a1d850b193b3398fd49b7', 'normal', 1, '2016-10-14 13:14:19', '2016-10-14 18:15:15'),
(54, 'hamzababri', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'hamza790@gmail.com', '0345473487', '245dc39168202a5c4a7ceb405dbebbdc', 'normal', 1, '2016-10-17 02:08:31', '2016-10-17 07:09:05'),
(55, 'Hamza Asad Babri', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'hamza790@hotmail.com', '0', '552dfa47cdf87c12c29782f0fa9c32e2', 'facebook', 0, '2016-10-18 07:07:08', '2016-10-18 12:07:08'),
(56, 'Asad Abbas', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'horizonapp786@gmail.com', '0', '27c60750408bb3048a7e49566793f9e5', 'facebook', 0, '2017-03-21 02:07:02', '2017-03-21 07:07:02'),
(57, 'Talha', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'talha.bukhari@yahoo.com', '00923336515953', '0a50412e36dea43a93b4ceb05fca44fb', 'normal', 1, '2017-03-21 04:26:41', '2017-05-04 11:25:25'),
(58, 'Fahad', '8cb2237d0679ca88db6464eac60da96345513964', 'fahadnaeem@synergistics.pk', '32214578542', '8dff46393f2aa8c178370f6d7b699fac', 'normal', 1, '2017-03-21 06:30:29', '2017-04-30 06:53:04'),
(59, 'sara1996', 'dea04453c249149b5fc772d9528fe61afaf7441c', 'sarazagbar@hotmail.com', '05013714919', '345467619cdac0147a16eccec0267d24', 'normal', 1, '2017-04-22 11:43:41', '2017-04-22 16:46:22');

-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE `user_activities` (
  `activity_id` int(10) UNSIGNED NOT NULL,
  `item_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fridge_refills`
--
ALTER TABLE `fridge_refills`
  ADD PRIMARY KEY (`fridge_refill_id`),
  ADD KEY `refill_item` (`item_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`);

--
-- Indexes for table `item_images`
--
ALTER TABLE `item_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `fk_item_images_1_idx` (`item_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`manager_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`token_id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD PRIMARY KEY (`activity_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fridge_refills`
--
ALTER TABLE `fridge_refills`
  MODIFY `fridge_refill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `item_images`
--
ALTER TABLE `item_images`
  MODIFY `image_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `managers`
--
ALTER TABLE `managers`
  MODIFY `manager_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `token_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `user_activities`
--
ALTER TABLE `user_activities`
  MODIFY `activity_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
