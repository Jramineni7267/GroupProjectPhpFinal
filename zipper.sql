-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2022 at 12:16 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zipper`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `model` varchar(150) NOT NULL,
  `id_admin` int(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `display` varchar(150) NOT NULL,
  `hardware` varchar(255) NOT NULL,
  `camera` varchar(255) NOT NULL,
  `battery` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `images` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `model`, `id_admin`, `title`, `price`, `display`, `hardware`, `camera`, `battery`, `qty`, `images`, `created_at`) VALUES
(15, 'Canon', 0, 'Canon EOS 5D', 600, '22.3 MP', '3.2 inch', 'Mirrorless', '55-250 mm', 5, 'canon1.png', '2022-08-07 02:01:06'),
(17, 'Nikon', 0, 'Nikon Z5', 450, '24 MP', '3.69 inch', 'Mirrored', '24-50 mm', 4, 'nikon2.jpg', '2022-08-07 02:09:50'),
(19, 'Panasonic ', 0, 'Panosonic Lumix', 3500, '18.2 MP', '3.2 inch', 'Mirrorless', '12-50 MM', 2, 'Panosonic111.jpg', '2022-08-18 20:59:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `license_date` varchar(255) DEFAULT NULL,
  `active_status` varchar(255) NOT NULL,
  `status` smallint(1) NOT NULL DEFAULT 0,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `online` smallint(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `email`, `password`, `create_date`, `license_date`, `active_status`, `status`, `role`, `online`) VALUES
(40, 'Jeshwanth', 'Ramineni', 'kalyanjeshwanth@gmail.com', '$2y$10$MwqgK/szYsLGUy/m4VRsh.WP8ywdW8zR46gJ4.A1SG9PFaVnrhbWS', '2022-08-05 20:15:55', '2023-08-05', '597857', 0, 'admin', 0),
(41, 'Jesh', 'Rami', 'Jramineni7267@conestogac.on.ca', '$2y$10$QiRJU/tAMDsHw4koUdQyUumJGYCgJeBOk1zEY2b3jITwYrlDnPuDS', '2022-08-05 20:21:27', '2023-08-05', '644355', 0, 'user', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
