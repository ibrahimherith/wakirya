-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2024 at 11:24 AM
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
-- Database: `wakirya_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL,
  `is_ban` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=not_ban,1=ban',
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `phone`, `role`, `is_ban`, `created_at`) VALUES
(5, 'wakirya', 'admin@example.com', '$2y$10$eAF30FEqkFWw1WUsHZSOfubYw0m7y.Vhi6qMmFMAtqzT58498G5gW', '0712000555', 'admin', 0, '2024-09-02'),
(6, 'ibrah', 'ibrah@gmail.com', '$2y$10$9zbd8FHa0qicGdwmZTN54OBjVMYlMw4uuOnOy2enz.QxpyKeKiUjy', '0652700800', 'user', 0, '2024-09-02');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0 COMMENT '0=visible,1=hidden',
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `status`, `created_at`) VALUES
(59, 'mteja', NULL, '', 0, '2024-09-29'),
(60, 'ibrah mteja', NULL, '', 0, '2024-09-29'),
(61, 'mteja mpya', NULL, '', 0, '2024-09-29'),
(62, 'curtis', NULL, '', 0, '2024-09-29'),
(63, 'zuma', NULL, '', 0, '2024-09-29');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `tracking_no` varchar(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `total_amount` varchar(100) NOT NULL,
  `paid_amount` varchar(100) NOT NULL,
  `due_amount` varchar(100) NOT NULL,
  `surplus_amount` varchar(100) NOT NULL,
  `order_date` date NOT NULL,
  `order_status` varchar(100) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `payment_mode` varchar(100) DEFAULT NULL,
  `order_placed_by_id` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `customer_id`, `tracking_no`, `invoice_no`, `total_amount`, `paid_amount`, `due_amount`, `surplus_amount`, `order_date`, `order_status`, `comment`, `payment_mode`, `order_placed_by_id`, `created_at`) VALUES
(12, 58, '65037', 'INV-301017', '175000', '110000', '65000', '0', '2024-09-29', 'Anadaiwa', 'Atamalizia', NULL, 5, '2024-09-29'),
(13, 59, '44388', 'INV-661907', '22500', '10000', '12500', '0', '2024-09-29', 'Anadaiwa', '', NULL, 5, '2024-09-29');

-- --------------------------------------------------------

--
-- Table structure for table `loan_items`
--

CREATE TABLE `loan_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` varchar(100) NOT NULL,
  `quantity` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan_items`
--

INSERT INTO `loan_items` (`id`, `order_id`, `product_id`, `price`, `quantity`) VALUES
(12, 12, 10, '17500', '10'),
(13, 13, 9, '22500', '1');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `tracking_no` varchar(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `total_amount` varchar(100) NOT NULL,
  `paid_amount` varchar(100) DEFAULT NULL,
  `due_amount` varchar(100) DEFAULT NULL,
  `surplus_amount` varchar(100) NOT NULL,
  `order_date` date NOT NULL,
  `order_status` varchar(100) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(100) DEFAULT NULL COMMENT 'cash, online',
  `order_placed_by_id` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `tracking_no`, `invoice_no`, `total_amount`, `paid_amount`, `due_amount`, `surplus_amount`, `order_date`, `order_status`, `comment`, `payment_mode`, `order_placed_by_id`, `created_at`) VALUES
(80, 56, '54152', 'INV-451767', '225000', '22500', '202500', '0', '2024-09-21', 'Punguzo', '', NULL, 5, '2024-09-21'),
(81, 57, '64049', 'INV-598630', '205000', '205000', '0', '0', '2024-09-29', 'Amelipa', '', NULL, 6, '2024-09-29'),
(82, 58, '65729', 'INV-171402', '182000', '182000', '0', '0', '2024-09-29', 'Amelipa', '', NULL, 6, '2024-09-29'),
(83, 60, '28869', 'INV-171508', '229000', '229000', '0', '0', '2024-09-29', 'Amelipa', '', NULL, 5, '2024-09-29'),
(84, 59, '33926', 'INV-843443', '17500', '17500', '0', '0', '2024-09-29', 'Amelipa', '', NULL, 5, '2024-09-29'),
(85, 59, '57808', 'INV-323139', '22500', '22500', '0', '0', '2024-09-29', 'Amelipa', '', NULL, 5, '2024-09-29'),
(86, 60, '63534', 'INV-398748', '4000', '4000', '0', '0', '2024-09-29', 'Amelipa', '', NULL, 5, '2024-09-29'),
(87, 60, '74780', 'INV-902537', '19500', '19500', '0', '0', '2024-09-29', 'Amelipa', '', NULL, 5, '2024-09-29'),
(88, 60, '91294', 'INV-680717', '4000', '4000', '0', '0', '2024-09-29', 'Amelipa', '', NULL, 5, '2024-09-29'),
(89, 61, '61432', 'INV-802582', '22500', '22500', '0', '0', '2024-09-29', 'Amelipa', '', NULL, 5, '2024-09-29'),
(90, 61, '62303', 'INV-425457', '17500', '17500', '0', '0', '2024-09-29', 'Amelipa', '', NULL, 5, '2024-09-29'),
(91, 61, '11407', 'INV-374897', '3000', '3000', '0', '0', '2024-09-29', 'Amelipa', '', NULL, 5, '2024-09-29'),
(92, 59, '70251', 'INV-667352', '4000', '4000', '0', '0', '2024-09-29', 'Amelipa', '', NULL, 5, '2024-09-29'),
(93, 60, '83059', 'INV-829637', '19500', '19500', '0', '0', '2024-09-29', 'Amelipa', '', NULL, 5, '2024-09-29'),
(94, 63, '42171', 'INV-122234', '45000', '40000', '5000', '0', '2024-09-29', 'Pending', 'kapunguza', NULL, 5, '2024-09-29'),
(95, 63, '11713', 'INV-407509', '17500', '10500', '7000', '0', '2024-09-29', 'Anadaiwa', '', NULL, 5, '2024-09-29'),
(96, 63, '62979', 'INV-381018', '4000', '4000', '0', '0', '2024-09-29', 'Amelipa', 'amechukua mzigo', NULL, 5, '2024-09-29'),
(97, 60, '85556', 'INV-657139', '3000', '2000', '1000', '0', '2024-09-29', 'Punguzo', 'amepunguziwa', NULL, 5, '2024-09-29');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` varchar(100) NOT NULL,
  `quantity` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `price`, `quantity`) VALUES
(1, 1, 1, '15000', '1'),
(2, 1, 4, '12599', '1'),
(3, 1, 5, '350', '1'),
(4, 1, 7, '20', '2'),
(5, 2, 1, '15000', '1'),
(6, 2, 4, '12599', '1'),
(7, 3, 1, '15000', '1'),
(8, 3, 2, '84000', '1'),
(9, 4, 5, '350', '1'),
(10, 5, 2, '84000', '1'),
(11, 6, 1, '', '10'),
(12, 7, 1, '', '10'),
(13, 8, 1, '', '8'),
(14, 8, 2, '', '4'),
(15, 9, 1, '', '10'),
(16, 9, 2, '', '3'),
(17, 10, 2, '', '1'),
(18, 11, 4, '', '10'),
(19, 12, 4, '', '3'),
(20, 13, 1, '16500', '2'),
(21, 14, 1, '16500', '10'),
(22, 15, 5, '3500', '5'),
(23, 15, 4, '32000', '100'),
(24, 16, 1, '16500', '2'),
(25, 16, 2, '22500', '1'),
(26, 16, 5, '3500', '10'),
(27, 17, 5, '3500', '5'),
(28, 17, 1, '16500', '2'),
(29, 18, 1, '16500', '1'),
(30, 19, 4, '32000', '10'),
(31, 19, 2, '22500', '1'),
(32, 19, 6, '4500', '10'),
(33, 20, 1, '16500', '2'),
(34, 21, 6, '4500', '1'),
(35, 22, 1, '16500', '1'),
(36, 23, 6, '4500', '10'),
(37, 24, 1, '16500', '1'),
(38, 24, 4, '32000', '4'),
(39, 25, 1, '16500', '1'),
(40, 25, 6, '4500', '10'),
(41, 26, 1, '16500', '1'),
(42, 27, 6, '4500', '2'),
(43, 28, 6, '4500', '10'),
(44, 28, 5, '3500', '5'),
(45, 29, 6, '4500', '1'),
(46, 30, 1, '16500', '1'),
(47, 30, 7, '1200', '10'),
(48, 31, 7, '1200', '1'),
(49, 32, 1, '16500', '1'),
(50, 32, 6, '4500', '1'),
(51, 33, 6, '4500', '3'),
(52, 34, 6, '4500', '1'),
(53, 34, 5, '3500', '1'),
(54, 35, 6, '4500', '1'),
(55, 35, 1, '15000', '1'),
(56, 36, 1, '15000', '10'),
(57, 37, 7, '1200', '10'),
(58, 37, 4, '32000', '2'),
(59, 38, 2, '22500', '10'),
(60, 38, 4, '32000', '3'),
(61, 39, 2, '22500', '1'),
(62, 40, 1, '15000', '1'),
(63, 40, 7, '1200', '10'),
(64, 41, 1, '15000', '1'),
(65, 42, 7, '1200', '1'),
(66, 42, 5, '3500', '1'),
(67, 43, 1, '15000', '1'),
(68, 43, 7, '1200', '1'),
(69, 44, 1, '15000', '2'),
(70, 45, 7, '1200', '1'),
(71, 46, 2, '22500', '1'),
(72, 46, 7, '1200', '1'),
(73, 47, 1, '15000', '1'),
(74, 48, 7, '1200', '1'),
(75, 49, 5, '3500', '1'),
(76, 50, 2, '22500', '3'),
(77, 51, 4, '32000', '1'),
(78, 52, 2, '22500', '2'),
(79, 53, 2, '22500', '2'),
(80, 54, 1, '15000', '1'),
(81, 55, 1, '15000', '1'),
(82, 56, 1, '15000', '1'),
(83, 57, 1, '15000', '1'),
(84, 58, 1, '15000', '1'),
(85, 59, 1, '15000', '1'),
(86, 60, 1, '15000', '1'),
(87, 61, 1, '15000', '1'),
(88, 62, 2, '22500', '1'),
(89, 63, 1, '15000', '1'),
(90, 64, 1, '15000', '1'),
(91, 64, 4, '32000', '1'),
(92, 65, 1, '15000', '1'),
(93, 66, 4, '32000', '1'),
(94, 66, 2, '22500', '1'),
(95, 67, 4, '32000', '1'),
(96, 68, 4, '32000', '1'),
(97, 69, 2, '22500', '1'),
(98, 70, 2, '22500', '1'),
(99, 71, 1, '15000', '1'),
(100, 72, 2, '22500', '1'),
(101, 73, 1, '15000', '1'),
(102, 74, 1, '15000', '1'),
(103, 75, 1, '15000', '1'),
(104, 76, 7, '1200', '1'),
(105, 77, 8, '15000', '1'),
(106, 78, 1, '15000', '1'),
(107, 79, 1, '15000', '1'),
(108, 80, 9, '22500', '10'),
(109, 81, 10, '17500', '10'),
(110, 81, 11, '3000', '10'),
(111, 82, 13, '19500', '1'),
(112, 82, 12, '4000', '5'),
(113, 82, 11, '3000', '5'),
(114, 82, 10, '17500', '6'),
(115, 82, 9, '22500', '1'),
(116, 83, 12, '4000', '1'),
(117, 83, 13, '19500', '10'),
(118, 83, 11, '3000', '10'),
(119, 84, 10, '17500', '1'),
(120, 85, 9, '22500', '1'),
(121, 86, 12, '4000', '1'),
(122, 87, 13, '19500', '1'),
(123, 88, 12, '4000', '1'),
(124, 89, 9, '22500', '1'),
(125, 90, 10, '17500', '1'),
(126, 91, 11, '3000', '1'),
(127, 92, 12, '4000', '1'),
(128, 93, 13, '19500', '1'),
(129, 94, 9, '22500', '2'),
(130, 95, 10, '17500', '1'),
(131, 96, 12, '4000', '1'),
(132, 97, 11, '3000', '1');

-- --------------------------------------------------------

--
-- Table structure for table `preorders`
--

CREATE TABLE `preorders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `tracking_no` varchar(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `total_amount` varchar(100) NOT NULL,
  `paid_amount` varchar(100) NOT NULL,
  `due_amount` varchar(100) NOT NULL,
  `surplus_amount` varchar(100) NOT NULL,
  `order_date` date NOT NULL,
  `order_status` varchar(100) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(100) DEFAULT NULL,
  `order_placed_by_id` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `preorders`
--

INSERT INTO `preorders` (`id`, `customer_id`, `tracking_no`, `invoice_no`, `total_amount`, `paid_amount`, `due_amount`, `surplus_amount`, `order_date`, `order_status`, `comment`, `payment_mode`, `order_placed_by_id`, `created_at`) VALUES
(8, 62, '39907', 'INV-926598', '175000', '100000', '75000', '0', '2024-09-29', 'Anadaiwa', 'Anachukua mzigo jumapili', NULL, 5, '2024-09-29');

-- --------------------------------------------------------

--
-- Table structure for table `preorder_items`
--

CREATE TABLE `preorder_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` varchar(100) NOT NULL,
  `quantity` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `preorder_items`
--

INSERT INTO `preorder_items` (`id`, `order_id`, `product_id`, `price`, `quantity`) VALUES
(8, 8, 10, '17500', '10');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `batch` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `measure` varchar(255) DEFAULT NULL,
  `buy_price` int(11) NOT NULL,
  `sell_price` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT 0 COMMENT '0 = visible, 1 = hidden',
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `batch`, `quantity`, `measure`, `buy_price`, `sell_price`, `status`, `created_at`) VALUES
(9, 'Pespi', 'AC100', 54, 'creti', 15000, 22500, 0, '2024-09-21'),
(10, 'cement', 'BD677G', 161, 'mifuko', 15000, 17500, 0, '2024-09-29'),
(11, 'mbao', 'PBN1012', 73, '2x2', 2000, 3000, 0, '2024-09-29'),
(12, 'Misumali', 'BD677G', 60, 'kilo', 3600, 4000, 0, '2024-09-29'),
(13, 'Rangi', '100RG', 187, 'kopo', 15000, 19500, 0, '2024-09-29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_items`
--
ALTER TABLE `loan_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `preorders`
--
ALTER TABLE `preorders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `preorder_items`
--
ALTER TABLE `preorder_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `loan_items`
--
ALTER TABLE `loan_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `preorders`
--
ALTER TABLE `preorders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `preorder_items`
--
ALTER TABLE `preorder_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
