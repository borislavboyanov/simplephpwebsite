-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:81
-- Generation Time: 11 юли 2019 в 00:54
-- Версия на сървъра: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diplomnarabota`
--

-- --------------------------------------------------------

--
-- Структура на таблица `cart_item`
--

CREATE TABLE `cart_item` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `cart_item`
--

INSERT INTO `cart_item` (`cart_item_id`, `cart_id`, `product_id`, `quantity`, `price`) VALUES
(1, 4, 4, 1, 43),
(2, 4, 6, 2, 53),
(4, 9, 3, 3, 12);

-- --------------------------------------------------------

--
-- Структура на таблица `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Стъклария'),
(2, 'Вещества');

-- --------------------------------------------------------

--
-- Структура на таблица `credit_card`
--

CREATE TABLE `credit_card` (
  `credit_card_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `card_num` int(11) NOT NULL,
  `security_num` int(11) NOT NULL,
  `date_expiring` date NOT NULL,
  `card_default` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `credit_card`
--

INSERT INTO `credit_card` (`credit_card_id`, `user_id`, `card_num`, `security_num`, `date_expiring`, `card_default`) VALUES
(1, 1, 44444444, 123, '2019-02-12', 1),
(2, 2, 55555555, 456, '2018-11-21', 1);

-- --------------------------------------------------------

--
-- Структура на таблица `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `o_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `total` int(11) NOT NULL,
  `addr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `o_date`, `total`, `addr_id`) VALUES
(1, 1, '2018-09-10 03:59:47', 98, 1),
(2, 1, '2018-09-10 04:46:28', 139, 1),
(3, 1, '2018-09-10 07:55:30', 93, 1);

-- --------------------------------------------------------

--
-- Структура на таблица `order_item`
--

CREATE TABLE `order_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `order_item`
--

INSERT INTO `order_item` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 3, 1, 12),
(2, 1, 4, 2, 86),
(3, 2, 4, 2, 86),
(4, 2, 6, 1, 53),
(5, 3, 5, 3, 49.5),
(6, 3, 4, 1, 43);

-- --------------------------------------------------------

--
-- Структура на таблица `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `p_picture` varchar(255) NOT NULL,
  `p_quantity` int(11) NOT NULL,
  `p_price` float NOT NULL,
  `isdangerous` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `product_desc`, `p_picture`, `p_quantity`, `p_price`, `isdangerous`) VALUES
(3, 1, 'Лакмусова хартия', 'Синя лакмусова хартия.', 'images/products/lakmusova.jpeg', 50, 12, 0),
(4, 2, 'Амониев нитрат', '', 'images/products/ammonium-nitrate.jpg', 1000, 43, 1),
(5, 1, 'Спиртна лампа', '', 'images/products/spirtna-lampa.jpg', 20, 16.5, 0),
(6, 2, 'Калций', '', 'images/products/calcium.jpg', 100, 53, 0);

-- --------------------------------------------------------

--
-- Структура на таблица `shop_cart`
--

CREATE TABLE `shop_cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `shop_cart`
--

INSERT INTO `shop_cart` (`cart_id`, `user_id`) VALUES
(4, 1),
(5, 2),
(7, 4),
(8, 5),
(9, 9);

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `isprivate` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`user_id`, `first`, `last`, `username`, `password`, `email`, `isadmin`, `isprivate`, `date_created`) VALUES
(1, 'Borislav', 'Boyanov', 'borko', '$2y$10$KjkBxIS/A0Gh7Y5eQBv6bu3aAr1e.VHzyNZd3RN7XcMpezeTxAgTG', 'borko2@gmail.com', 1, 1, '2018-09-10 05:31:53'),
(2, 'Ivan', 'Petrov', 'ivan', '$2y$10$yLraXVTKxjujjrCsyJkdpOjJ49PvFDzrjs9upuVUZmrwBhox/w3Oe', 'ivan@gmail.com', 0, 0, '2018-09-08 19:44:25'),
(4, 'Georgi', 'Georgiev', 'georgi', '$2y$10$JXgo9IER8rVA/gr/RWk8lumWrh45MuUgGXjOdyP8d.5494Vq0EOiW', 'georgi@gmail.com', 1, 0, '2018-09-12 03:41:12'),
(5, 'Petyr', 'Petrov', 'petyr', '$2y$10$WA.A43b.N2RuUau8/RhUfe9ET8aX/rtckmXArBUYEtoBHfutT1yIy', 'petyr@gmail.com', 0, 0, '2018-09-10 06:20:51'),
(7, 'Kiril', 'Kirilov', 'kiril', '$2y$10$WZBnOFRfU6zsmnQ5vn8Z9euJuuWWI7fZ2Re22iecArVSicaXuB27e', 'kiril@gmail.com', 0, 0, '2018-09-12 07:52:33'),
(8, 'Kaloyan', 'Kaloyanov', 'kaloyan', '$2y$10$Tolrn.6sQ4pIC.ywtO7Ra.0Ybs5E6Dpm7/PYHxD.OL.UEkycmRmQy', 'kaloyan@gmail.com', 0, 0, '2018-09-12 07:53:07'),
(9, 'Mariya', 'Ivanova', 'mariya', '$2y$10$I8/n1TKeuvIfdCJDn9tOdegXEndYVMR8AqDkB5594/4TF/yQZLsbG', 'mariya@gmail.com', 0, 0, '2018-09-12 10:14:40');

-- --------------------------------------------------------

--
-- Структура на таблица `user_addrs`
--

CREATE TABLE `user_addrs` (
  `addr_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `postcode` varchar(255) NOT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `user_addrs`
--

INSERT INTO `user_addrs` (`addr_id`, `user_id`, `address`, `postcode`, `city`) VALUES
(1, 1, '\0Владислав Варненчик', '9027', 'Варна');

-- --------------------------------------------------------

--
-- Структура на таблица `user_addrs_copy`
--

CREATE TABLE `user_addrs_copy` (
  `addr_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `postcode` varchar(255) NOT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `user_addrs_copy`
--

INSERT INTO `user_addrs_copy` (`addr_id`, `user_id`, `address`, `postcode`, `city`) VALUES
(1, 1, 'Владислав Варненчик', '9027', 'Варна');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `card_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `credit_card`
--
ALTER TABLE `credit_card`
  ADD PRIMARY KEY (`credit_card_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `addr_id` (`addr_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD UNIQUE KEY `order_item_id` (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `shop_cart`
--
ALTER TABLE `shop_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_addrs`
--
ALTER TABLE `user_addrs`
  ADD PRIMARY KEY (`addr_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_addrs_copy`
--
ALTER TABLE `user_addrs_copy`
  ADD PRIMARY KEY (`addr_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `credit_card`
--
ALTER TABLE `credit_card`
  MODIFY `credit_card_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `shop_cart`
--
ALTER TABLE `shop_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_addrs`
--
ALTER TABLE `user_addrs`
  MODIFY `addr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_addrs_copy`
--
ALTER TABLE `user_addrs_copy`
  MODIFY `addr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения за дъмпнати таблици
--

--
-- Ограничения за таблица `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `shop_cart` (`cart_id`),
  ADD CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Ограничения за таблица `credit_card`
--
ALTER TABLE `credit_card`
  ADD CONSTRAINT `credit_card_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ограничения за таблица `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`addr_id`) REFERENCES `user_addrs` (`addr_id`);

--
-- Ограничения за таблица `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Ограничения за таблица `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Ограничения за таблица `shop_cart`
--
ALTER TABLE `shop_cart`
  ADD CONSTRAINT `shop_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ограничения за таблица `user_addrs`
--
ALTER TABLE `user_addrs`
  ADD CONSTRAINT `user_addrs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
