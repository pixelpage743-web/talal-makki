-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2025 at 04:05 PM
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
-- Database: `portfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password_hash`) VALUES
(1, 'admin', '$2y$10$Tb1Ll2nH16qCqN7hQY60RuXeT7Gfn7lAImsykECSToX7H6A7ByV9O');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `message`) VALUES
(2, 'abc', 'abc@gmail.com', 'e'),
(3, 'Rayan', 'rayan@gmail.com', 'hi'),
(4, 'Rayan', 'rayan@gmail.com', 'hi'),
(5, 'Rayan', 'rayan@gmail.com', 'hi'),
(6, 'Rayan', 'rayan@gmail.com', 'hi'),
(7, 'Rayan', 'rayan@gmail.com', 'hi'),
(8, 'Rayan', 'rayan@gmail.com', 'hi'),
(9, 'Rayan', 'rayan@gmail.com', 'hi'),
(10, 'Rayan', 'rayan@gmail.com', 'hi'),
(11, 'Rayan', 'rayan@gmail.com', 'hi'),
(12, 'Rayan', 'rayan@gmail.com', 'hi'),
(13, 'Rayan', 'rayan@gmail.com', 'hi'),
(14, 'Rayan', 'rayan@gmail.com', 'hi'),
(15, 'Rayan', 'rayan@gmail.com', 'hi'),
(16, 'Rayan', 'rayan@gmail.com', 'hi'),
(17, 'Rayan', 'rayan@gmail.com', 'hi'),
(18, 'Rayan', 'rayan@gmail.com', 'hi'),
(19, 'Rayan', 'rayan@gmail.com', 'hi'),
(20, 'Rayan', 'rayan@gmail.com', 'hi');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `image`, `link`) VALUES
(6, 'E-COMMERCE', '1756821597_ecomerse.png', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fcolorlib.com%2Fwp%2Fcat%2Fecommerce%2F&psig=AOvVaw1NYad7-ZKsiVt8XPHpXsR-&ust=1756906149961000&source=images&cd=vfe&opi=89978449&ved=0CBUQjRxqFwoTCPidv5WYuo8DFQAAAAAdAAAAABAE'),
(7, 'E-COMMERCE', '1756821635_Kit.png', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fcolorlib.com%2Fwp%2Fcat%2Fecommerce%2F&psig=AOvVaw1NYad7-ZKsiVt8XPHpXsR-&ust=1756906149961000&source=images&cd=vfe&opi=89978449&ved=0CBUQjRxqFwoTCPidv5WYuo8DFQAAAAAdAAAAABAE'),
(8, 'TRAVEL WEBSITE', '1756821716_TRAVEL.png', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fcolorlib.com%2Fwp%2Fcat%2Fecommerce%2F&psig=AOvVaw1NYad7-ZKsiVt8XPHpXsR-&ust=1756906149961000&source=images&cd=vfe&opi=89978449&ved=0CBUQjRxqFwoTCPidv5WYuo8DFQAAAAAdAAAAABAE');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `name`, `level`) VALUES
(1, 'HTML', '90%'),
(2, 'CSS', '85%'),
(3, 'JavaScript', '75%'),
(5, 'UI/UX DESIGNS', '90%'),
(6, 'SEO', '75%'),
(7, 'MARKETING', '95%'),
(8, 'PHP', '80%'),
(9, 'web', '90%');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
