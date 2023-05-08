-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3906
-- Generation Time: May 07, 2023 at 10:22 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_cafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Coffee'),
(2, 'Hot drinks'),
(3, 'Cold drinks'),
(4, 'Smoothies');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `status` enum('processing','done') NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `notes` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `room_id`, `status`, `total_price`, `notes`, `created_at`) VALUES
(8, 1, 1, 'processing', '35.00', 'asdasd', '2023-05-05 00:12:38'),
(12, 1, 2, 'processing', '27.00', 'aaaaaaasdd', '2023-05-05 00:38:12'),
(14, 1, 2, 'processing', '27.00', 'dddddddddddd', '2023-05-06 13:49:15'),
(17, 1, 2, 'processing', '27.00', 'dddddddddddd', '2023-05-06 13:52:09'),
(19, 1, 2, 'processing', '27.00', 'dddddddddddd', '2023-05-06 13:54:20'),
(22, 1, 2, 'processing', '27.00', 'dddddddddddd', '2023-05-06 13:56:44'),
(23, 1, 2, 'processing', '27.00', 'dddddddddddd', '2023-05-06 13:56:51'),
(25, 1, 2, 'processing', '27.00', 'dddddddddddd', '2023-05-06 14:03:13'),
(29, 1, 2, 'processing', '27.00', 'dddddddddddd', '2023-05-06 14:14:27'),
(30, 1, 2, 'processing', '27.00', 'dddddddddddd', '2023-05-06 14:14:29'),
(31, 1, 2, 'processing', '27.00', 'dddddddddddd', '2023-05-06 14:16:57'),
(34, 1, 2, 'processing', '27.00', 'dddddddddddd', '2023-05-06 14:27:47'),
(39, 2, 1, 'processing', '35.00', 'cvbcvbc', '2023-05-06 14:39:40');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`) VALUES
(8, 1, 1),
(8, 5, 1),
(12, 1, 1),
(12, 4, 1),
(14, 1, 1),
(14, 4, 1),
(17, 1, 1),
(17, 4, 1),
(19, 1, 1),
(19, 4, 1),
(22, 1, 1),
(22, 4, 1),
(23, 1, 1),
(23, 4, 1),
(25, 1, 1),
(25, 4, 1),
(29, 1, 1),
(29, 4, 1),
(30, 1, 1),
(30, 4, 1),
(31, 1, 1),
(31, 4, 1),
(34, 1, 1),
(34, 4, 1),
(39, 1, 1),
(39, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `product` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `category_id`, `image`) VALUES
(1, 'Latte', '15.00', 1, 'latte.png'),
(2, 'Cappuccino', '18.00', 1, 'cappuccino.png'),
(3, 'Espresso', '10.00', 1, 'espresso.png'),
(4, 'Americano', '12.00', 1, 'americano.png'),
(5, 'Hot Chocolate', '20.00', 2, 'hot-chocolate.jpg'),
(6, 'Iced Tea', '8.00', 3, 'iced-tea.jpg'),
(7, 'Fruit Smoothie', '25.00', 4, 'fruit-smoothie.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`) VALUES
(1, 'room1'),
(2, 'Room 2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `ext_attr` text DEFAULT NULL,
  `total_amount_price` decimal(10,2) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `image`, `room_id`, `ext_attr`, `total_amount_price`, `is_admin`, `created_at`) VALUES
(1, 'admin', '$2y$10$MjtpwIfUDcr8FeD1ubc.7u2.WhYx7pKwCyHxdjYBrtua1WNut33zu', 'admin@gmail.com', 'image/image', 2, 'some data', '0.00', 1, '2023-05-02 09:27:43'),
(2, 'johndoe', '$2y$10$TepYDCVw.akFSYxL6OjqeewgSnn5FX5o7IOKrjPSRTNyc0D.bfpK.', 'johndoe@example.com', 'user1.jpg', 1, NULL, '0.00', 0, '2022-05-03 10:00:00'),
(3, 'janedoe', '5ecr3t', 'janedoe@example.com', 'user2.jpg', 2, NULL, '0.00', 0, '2022-05-03 10:00:00'),
(4, 'admin', '9#p@ss', 'admin@example.com', 'admin.jpg', NULL, NULL, '0.00', 1, '2022-05-03 10:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
