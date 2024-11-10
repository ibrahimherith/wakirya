-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2024 at 05:44 AM
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
(5, 'Administrator', 'admin@example.com', '$2y$10$eAF30FEqkFWw1WUsHZSOfubYw0m7y.Vhi6qMmFMAtqzT58498G5gW', '0712000555', 'admin', 0, '2024-09-02'),
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
(1, 'curtis', NULL, '0652999888', 0, '2024-11-09'),
(2, 'zuma', NULL, '0652000000', 0, '2024-11-09'),
(3, 'ibrah mteja', NULL, '', 0, '2024-11-09'),
(4, 'mteja', NULL, '0652000000', 0, '2024-11-10'),
(5, 'tariq', NULL, '', 0, '2024-11-10'),
(6, 'mteja mpya', NULL, '', 0, '2024-11-10'),
(7, 'mteja mpya', NULL, '', 0, '2024-11-10');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `tracking_no` varchar(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `total_amount` varchar(100) NOT NULL,
  `paid_amount` varchar(100) NOT NULL,
  `due_amount` varchar(100) NOT NULL,
  `surplus_amount` varchar(100) NOT NULL,
  `loan_payment` int(100) NOT NULL,
  `salary_payment` int(100) NOT NULL,
  `other_payment` int(100) NOT NULL,
  `amount1` int(255) NOT NULL,
  `amount2` int(255) NOT NULL,
  `amount3` int(100) NOT NULL,
  `order_date` date NOT NULL,
  `order_status` varchar(100) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `payment_mode` varchar(100) DEFAULT NULL,
  `order_placed_by_id` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `tracking_no` varchar(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `total_amount` varchar(100) NOT NULL,
  `paid_amount` varchar(100) DEFAULT NULL,
  `due_amount` varchar(100) DEFAULT NULL,
  `surplus_amount` varchar(100) NOT NULL,
  `loan_payment` varchar(100) NOT NULL,
  `salary_payment` int(100) NOT NULL,
  `other_payment` int(100) NOT NULL,
  `order_date` date NOT NULL,
  `order_status` varchar(100) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(100) DEFAULT NULL COMMENT 'cash, online',
  `order_placed_by_id` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `preorders`
--

CREATE TABLE `preorders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `tracking_no` varchar(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `total_amount` int(100) NOT NULL,
  `paid_amount` int(100) NOT NULL,
  `due_amount` int(100) NOT NULL,
  `surplus_amount` int(100) NOT NULL,
  `loan_payment` int(100) NOT NULL,
  `salary_payment` int(100) NOT NULL,
  `other_payment` int(100) NOT NULL,
  `amount1` int(100) NOT NULL,
  `amount2` int(100) NOT NULL,
  `amount3` int(100) NOT NULL,
  `order_date` date NOT NULL,
  `order_status` varchar(100) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(100) DEFAULT NULL,
  `order_placed_by_id` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `expense_1` varchar(255) NOT NULL,
  `percent_1` int(100) NOT NULL,
  `expense_2` varchar(255) NOT NULL,
  `percent_2` int(100) NOT NULL,
  `expense_3` varchar(255) NOT NULL,
  `percent_3` int(100) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `batch`, `quantity`, `measure`, `buy_price`, `sell_price`, `expense_1`, `percent_1`, `expense_2`, `percent_2`, `expense_3`, `percent_3`, `created_at`) VALUES
(1, 'cement', 'BN-7490', 49, 'mifuko', 15000, 20000, 'mkopo', 10, '', 0, '', 0, '2024-11-08'),
(2, 'Mbao', 'BN-4955', 97, '3 x 3', 3500, 4000, '', 0, '', 0, '', 0, '2024-11-10');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_items`
--
ALTER TABLE `loan_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `preorders`
--
ALTER TABLE `preorders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `preorder_items`
--
ALTER TABLE `preorder_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
