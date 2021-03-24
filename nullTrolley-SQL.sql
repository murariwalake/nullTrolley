-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 22, 2018 at 12:54 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nullTrolley`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `permissions` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `join_date`, `last_login`, `permissions`) VALUES
(1, 'Murari Walake', 'murariwalake@gmail.com', '$2y$10$yq2Xv49k1QvheU0N0OpM2uRXizAyQ1HnRZpqsVbdy/qo1ulOlmBEy', '2018-04-22 15:45:50', '2018-08-22 23:33:37', 'admin,edit');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand`) VALUES
(1, 'Allen solly'),
(3, 'Lee Cooper'),
(4, 'Pape Jeans '),
(6, 'Spykar'),
(7, 'Levi\'s'),
(8, 'Puma'),
(9, 'U.S Polo'),
(10, 'Ramraj'),
(11, 'Fastrack'),
(13, 'London Bee'),
(14, 'Bon point'),
(15, 'Jani And Jack'),
(16, 'Lilly'),
(23, 'Sparx'),
(24, 'Manyavar');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `size` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `u_id`, `p_id`, `quantity`, `size`, `added_date`) VALUES
(59, 7, 5, 1, 'L', '2018-04-30 16:55:52'),
(71, 8, 5, 1, 'L', '2018-05-10 15:18:27'),
(73, 5, 5, 1, 'L', '2018-05-11 16:48:30'),
(74, 1, 5, 1, 'XL', '2018-05-19 15:11:36'),
(75, 1, 37, 1, 'S', '2018-08-03 18:13:41');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent`) VALUES
(1, 'Men', 0),
(2, 'Women', 0),
(3, 'Boys', 0),
(4, 'Girls', 0),
(5, 'Pants', 1),
(6, 'Shirts', 1),
(7, 'Shoes', 1),
(8, 'Watches', 1),
(9, 'Tops', 2),
(11, 'Shoes', 2),
(12, 'Watches', 2),
(13, 'Shirts', 3),
(14, 'Pants', 3),
(15, 'Hats', 3),
(17, 'Tops', 4),
(18, 'Legins', 4),
(20, 'Shoes', 4),
(27, 'Bags', 2),
(35, 'Shirts', 2),
(36, 'Shoes', 3),
(39, 'Gifts', 0),
(40, 'marriage', 39),
(41, 'Kids', 0),
(42, 'Clothes', 41),
(43, 'Bags', 41),
(44, 'Shorts', 41),
(45, 'Stationeries', 4);

-- --------------------------------------------------------

--
-- Table structure for table `pimage`
--

CREATE TABLE `pimage` (
  `pid` int(11) NOT NULL,
  `image` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pimage`
--

INSERT INTO `pimage` (`pid`, `image`) VALUES
(5, 'images/products/men/shoes/pumasports1-2.jpg'),
(5, 'images/products/men/shoes/pumasports1-3.jpg'),
(3, 'images/products/men/pants/leecooper1.png'),
(2, 'images/products/men/pants/allensolly1.png'),
(26, 'images/products/kids/clothes/01520d0d420568b385fdd62fdc52c447.png'),
(27, 'images/products/kids/clothes/19f92c335c55f19d424f2c59efc236d4.png'),
(28, 'images/products/kids/bags/f9b18bc44db9934231b0174734a1fbb4.jpg'),
(29, 'images/products/kids/clothes/f21e22fbe13afb25887bb9d0806ca944.jpg'),
(30, 'images/products/kids/shorts/86dff920df05afabf22e6aa3f3748ad1.jpg'),
(31, 'images/products/kids/clothes/5469238ac71b4dd6c4e573897225cc61.jpg'),
(31, 'images/products/kids/clothes/dca03195c38c211e915d2cb410735674.jpg'),
(32, 'images/products/boys/hats/31abe570a3f55b324192ef492bf84795.jpg'),
(32, 'images/products/boys/hats/7910007e89adcc30b82c2e22d36f8ad3.png'),
(32, 'images/products/boys/hats/e333291b65a7a4750de2e73f449080b4.jpg'),
(33, 'images/products/kids/clothes/950ce2fbbd58539d3a6483aa1789ac1a.jpg'),
(33, 'images/products/kids/clothes/c2056b6f5372493d8537db6c1bf2b8db.jpg'),
(34, 'images/products/boys/pants/6d28492d546945aa31f4ec38e75b90cd.png'),
(35, 'images/products/girls/stationeries/6a3f54e96f3ef41a51d89eff48a1f7be.jpg'),
(35, 'images/products/girls/stationeries/97f89b4be9f729a06d575cbd92fb399d.jpg'),
(36, 'images/products/girls/stationeries/4ac1d47ca9c6bb3d7cb0a65cbda4c6e5.jpg'),
(36, 'images/products/girls/stationeries/eb8807d451918b2e6f08a25865f0dee7.jpg'),
(37, 'images/products/kids/clothes/d5cc9b97826d4ba935fb064397046909.jpg'),
(37, 'images/products/kids/clothes/503b7376276b16fa833029e7723b92ca.jpg'),
(38, 'images/products/boys/hats/b5c4d17e428348431822da2482302e26.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `plocation`
--

CREATE TABLE `plocation` (
  `pid` int(11) NOT NULL,
  `zip` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `porder`
--

CREATE TABLE `porder` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `odate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `porder`
--

INSERT INTO `porder` (`id`, `uid`, `pid`, `size`, `quantity`, `odate`, `payment`, `status`, `amount`) VALUES
(25, 7, 5, 'L', 1, '2018-04-30 16:25:43', 'POD(pay on delivery)', 'Delivered', 0),
(26, 7, 3, 'L', 1, '2018-04-30 16:29:06', 'POD(pay on delivery)', 'Delivered', 700),
(27, 1, 3, 'L', 2, '2018-05-01 07:42:27', 'POD(pay on delivery)', 'Returned', 1400),
(28, 1, 26, 'XS', 1, '2018-05-01 07:42:52', 'POD(pay on delivery)', 'Delivered', 500),
(29, 1, 5, 'L', 2, '2018-05-01 07:43:14', 'POD(pay on delivery)', 'Product canceled', 3600),
(30, 1, 27, 'M', 2, '2018-05-01 07:43:35', 'POD(pay on delivery)', 'Delivered', 1000),
(31, 1, 5, 'L', 2, '2018-05-01 10:30:59', 'POD(pay on delivery)', 'Product canceled', 3600),
(32, 1, 5, 'M', 2, '2018-05-01 10:32:30', 'POD(pay on delivery)', 'Returned', 3600),
(33, 1, 26, 'XS', 1, '2018-05-01 19:18:58', 'POD(pay on delivery)', 'Delivered', 500),
(34, 1, 5, 'M', 1, '2018-05-06 04:47:10', 'POD(pay on delivery)', 'Product canceled', 1800),
(35, 1, 3, 'L', 1, '2018-05-08 06:24:48', 'POD(pay on delivery)', 'Delivered', 700),
(36, 8, 5, 'L', 1, '2018-05-10 15:32:22', 'POD(pay on delivery)', 'Delivered', 1800),
(37, 8, 5, 'L', 1, '2018-05-10 15:33:12', 'POD(pay on delivery)', 'Delivered', 1800),
(38, 8, 5, 'L', 1, '2018-05-10 15:33:16', 'POD(pay on delivery)', 'Product canceled', 1800),
(39, 8, 5, 'L', 1, '2018-05-10 15:34:16', 'POD(pay on delivery)', 'Product canceled', 1800),
(40, 8, 5, 'L', 1, '2018-05-10 15:34:46', 'POD(pay on delivery)', 'Product canceled', 1800),
(41, 8, 27, 'M', 2, '2018-05-10 15:36:35', 'POD(pay on delivery)', 'Delivered', 1000),
(42, 1, 26, 'XS', 1, '2018-05-11 16:16:10', 'POD(pay on delivery)', 'Returned', 500),
(43, 5, 26, 'XS', 1, '2018-05-11 16:36:22', 'POD(pay on delivery)', 'Returned', 500),
(44, 1, 27, 'M', 0, '2018-05-22 09:39:48', 'POD(pay on delivery)', 'Delivered', 0),
(45, 10, 27, 'M', 1, '2018-05-22 10:07:51', 'POD(pay on delivery)', 'Delivered', 500),
(46, 10, 27, 'M', 1, '2018-05-22 10:08:59', 'POD(pay on delivery)', 'Returned', 500),
(47, 1, 5, 'L', 1, '2018-05-22 10:46:34', 'POD(pay on delivery)', 'Returned', 1800),
(48, 11, 29, 'S', 1, '2018-05-26 13:45:03', 'POD(pay on delivery)', 'Order placed', 300),
(49, 11, 26, 'XS', 1, '2018-05-26 13:46:57', 'POD(pay on delivery)', 'Order placed', 500),
(50, 11, 2, 'L', 1, '2018-05-26 13:58:11', 'POD(pay on delivery)', 'Order placed', 800),
(51, 1, 27, 'M', 1, '2018-05-26 14:09:28', 'POD(pay on delivery)', 'Product canceled', 500),
(52, 1, 5, 'M', 1, '2018-06-13 05:24:09', 'POD(pay on delivery)', 'Delivered', 1800),
(53, 1, 5, 'L', 1, '2018-07-21 16:09:22', 'POD(pay on delivery)', 'Delivered', 1800),
(54, 1, 27, 'M', 1, '2018-08-03 17:56:06', 'POD(pay on delivery)', 'Delivered', 500),
(55, 1, 37, 'S', 1, '2018-08-03 18:14:15', 'POD(pay on delivery)', 'Returned', 200),
(56, 1, 31, 'S', 1, '2018-08-22 21:32:20', 'POD(pay on delivery)', 'Delivered', 500);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `list_price` decimal(10,0) NOT NULL,
  `brand` int(11) NOT NULL,
  `categories` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `featured` tinyint(4) NOT NULL DEFAULT '0',
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `list_price`, `brand`, `categories`, `description`, `featured`, `deleted`) VALUES
(2, 'Allen solly pant', '800', '1100', 1, 5, 'Men pant in its best price. Flexible and smooth.  ', 1, 0),
(3, 'Lee cooper pant', '700', '950', 3, 5, 'Men pant in its best price. Flexible and smooth. Quality color. ', 1, 0),
(5, 'Puma sports shoes', '1800', '2200', 8, 36, 'puma sports shoe', 1, 0),
(26, 'Kids Lilly Sweater', '500', '650', 16, 42, 'The best and smooth sweater for kids.', 1, 0),
(27, 'Kids Pant', '500', '550', 16, 42, 'The nice pant for kids', 1, 0),
(28, 'Kids kindel bag', '400', '455', 16, 43, 'A nice kids bag', 1, 0),
(29, 'Baby rabhit dress', '300', '350', 14, 42, 'A nice baby winter wear.', 1, 0),
(30, 'Kids cotton Shorts', '400', '420', 16, 44, 'A smooth kids summer wear', 1, 0),
(31, 'Cloth with bag', '500', '400', 4, 42, 'Kids cloth with school bag.', 1, 0),
(32, 'demo', '200', '220', 11, 15, 'hey its just demo', 1, 1),
(33, 'demo', '200', '220', 11, 42, 'hey its demo', 1, 1),
(34, 'demo', '200', '220', 1, 14, 'hey its just added', 1, 1),
(35, 'Bangles', '200', '230', 16, 45, 'The best girls bangles', 0, 1),
(36, 'Bangles', '200', '230', 16, 45, 'Nice girls bangles', 0, 1),
(37, 'Bangles', '200', '230', 16, 42, 'Nice golden bangles', 1, 0),
(38, 'Demo', '300', '320', 1, 15, 'Joker', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `psize`
--

CREATE TABLE `psize` (
  `pid` int(11) NOT NULL,
  `size` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `psize`
--

INSERT INTO `psize` (`pid`, `size`, `quantity`) VALUES
(2, 'L', 4),
(2, 'M', 0),
(2, 'S', 9),
(2, 'XL', 0),
(3, 'L', 4),
(3, 'M', 16),
(3, 'S', 10),
(3, 'XL', 20),
(5, 'L', 17),
(5, 'M', 17),
(5, 'XL', 6),
(26, 'XS', 7),
(27, 'M', 7),
(27, 'M', 7),
(27, 'M', 7),
(28, 'S', 0),
(28, 'M', 0),
(28, 'L', 0),
(29, 'S', 16),
(29, 'M', 24),
(29, 'XL', 13),
(29, 'L', 19),
(30, '15', 20),
(30, '18', 18),
(30, '20', 15),
(30, 'XL', 13),
(31, 'S', 5),
(31, 'M', 10),
(31, 'L', 13),
(31, 'XL', 12),
(32, 'S', 8),
(32, 'L', 9),
(33, 'S', 8),
(33, 'L', 9),
(34, 'S', 10),
(34, 'M', 2),
(35, 'S', 11),
(35, 'M', 20),
(35, 'L', 18),
(36, 'S', 11),
(36, 'M', 20),
(36, 'L', 18),
(37, 'S', 12),
(37, 'M', 20),
(37, 'L', 18),
(38, 'S', 10),
(38, 'M', 10);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `zip` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `mobile`, `address`, `zip`) VALUES
(1, 'Murari Walake', 'murariwalake@gmail.com', '$2y$10$.gmRj4ii8XA1kgX43wgZ6.glJgDIP3ohAFWIRZY2LIkeyZkgSKwiG', '8105616117', '#42 UVCE boys hostel Bengaluru', '560001'),
(5, 'Maibu sab', 'maibu.uvce@gmail.com', '$2y$10$k63B/HSwjN2P.2WaLRilROfdz9w5t1GVzV7IQO7gDl10Lhhx4sa.K', '9916939341', '#42 uvce boys hostel', '560001'),
(6, 'Revanasidda pujari', '2020revanasidda@gmail.com', '$2y$10$4LPznulo2WBHjH4BJ2vSAOjAwP/2xsQFoDLjcoNyAVMOfgtYyKtam', '7676616280', '#42 uvce Boys hostel, K.R circle bengaluru 560001 ', '560001'),
(7, 'Vijay Patil', 'vijapatil211198@gmail.com', '$2y$10$UFYfRd9OewXrLsCAYnMPTurJPu/YGwBh8T6ENrhhyai/TomqUTMZW', '9591600378', '#42 UVCE boys hostel k r circle Bengaluru', '560001'),
(8, 'Mantesh Kumbar', 'kumbarmantesh25@gmail.com', '$2y$10$wMu3qOeWhJHr0fizq65BJeGoR11FH0rBaH5Iwe1cOKSqEDma.w/T2', '7353571971', '#42 uvce boys hostel behind city civil court k. r. circle bangalore 560001\r\nbangalore 560001', '560001'),
(9, 'Krishnakant jagadale', 'krish@gmail.com', '$2y$10$AsNknVPm2KH.hGqo3dmULeInQpqKHW.5S84EEacpE43NZMGdWkLUW', '1234567891', '#42 uvce boys hostel', '560001'),
(10, 'Nuthan chandra', 'nuthanchandra@gmail.com', '$2y$10$hB7H490dyXG.KsohOvGl8.TuSKJWLappbrPTLgf77SuNUCMcrctHy', '9066670290', 'Hoskote', '560001'),
(11, 'Tejaswini D R', 'tejaswinidr@gamil.com', '$2y$10$0tqbHETm7fDjP/utrXbar.N2JjwOO2RSL.OfbbhCIN5jv2WHokE4.', '9066841486', '#20 bangaluru university girls hostel, SBI circle bangaluru. ', '560006');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pimage`
--
ALTER TABLE `pimage`
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `plocation`
--
ALTER TABLE `plocation`
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `porder`
--
ALTER TABLE `porder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand` (`brand`),
  ADD KEY `categories` (`categories`);

--
-- Indexes for table `psize`
--
ALTER TABLE `psize`
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `porder`
--
ALTER TABLE `porder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`p_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pimage`
--
ALTER TABLE `pimage`
  ADD CONSTRAINT `pimage_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `plocation`
--
ALTER TABLE `plocation`
  ADD CONSTRAINT `plocation_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `porder`
--
ALTER TABLE `porder`
  ADD CONSTRAINT `porder_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `porder_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brand`) REFERENCES `brand` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`categories`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `psize`
--
ALTER TABLE `psize`
  ADD CONSTRAINT `psize_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
