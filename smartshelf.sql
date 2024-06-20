-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2024 at 06:13 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smartshelf`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessibility`
--

CREATE TABLE `accessibility` (
  `userID` int(11) NOT NULL,
  `shelfID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `accessibility`
--

INSERT INTO `accessibility` (`userID`, `shelfID`) VALUES
(15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productID` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `initialQuantity` int(11) NOT NULL,
  `currentQuantity` int(11) NOT NULL,
  `buyDate` date NOT NULL,
  `expiringDate` date DEFAULT NULL,
  `imgProduct` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `shelfID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productID`, `name`, `category`, `initialQuantity`, `currentQuantity`, `buyDate`, `expiringDate`, `imgProduct`, `price`, `shelfID`) VALUES
(6, 'Watermelon', 'Fruit', 20, 27, '2024-06-03', '2024-06-12', '665ddf62614d39.94818460.jpg', '20.00', 1),
(9, 'Fridge', 'Fruit', 3, 0, '2024-06-03', '2024-06-04', '665de9761fd5c9.13524244.jpg', '20.00', 1),
(10, 'Fridge', 'Fruit', 3, 2, '2024-06-03', '2024-06-04', '665de97840cc28.51391870.jpg', '20.00', 1),
(12, 'asd', 'asd', 60, 302, '2024-06-03', '2024-06-06', '665e14e29b2898.32372678.png', '2.00', 1),
(18, 'asdaa', 'sda', 25, 25, '2024-06-25', '2026-06-25', '666d97422616d8.32612727.png', '3.00', 2),
(19, 'Pearsssslmmmm', 'Fruit', 25, 18, '2024-12-06', '2025-12-06', NULL, '20.00', 1),
(20, 'pasta', 'mainCourse', 20, 20, '2024-06-16', '2024-06-20', '666336f6cb70a2.66840977.png', '20.00', 1),
(21, 'Pearsssslmmmm', 'Fruit', 5, 5, '2024-06-16', '2024-06-17', '6663286c732516.83893235.jpg', '2.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_templates`
--

CREATE TABLE `product_templates` (
  `templateID` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `imgProduct` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `product_templates`
--

INSERT INTO `product_templates` (`templateID`, `name`, `category`, `imgProduct`) VALUES
(7, 'Pearsssslmmmm', 'Fruit', '6663286c732516.83893235.jpg'),
(8, 'pasta', 'mainCourse', '666336f6cb70a2.66840977.png'),
(9, 'Test Product', 'Test Category', '66741110745340.73562226.png'),
(10, 'Test Product', 'Test Category', '6674116d6ca9a4.76762007.png'),
(11, 'Test Product', 'Test Category', '667411f8366e71.19696762.png'),
(12, 'Test Product', 'Test Category', '6674126a3e6983.34321272.png'),
(13, 'Test Product', 'Test Category', '6674128f8775d5.77474751.png'),
(14, 'Test Product', 'Test Category', '667412dfb93309.91262573.png'),
(15, 'Test Product', 'Test Category', '667413318d7769.62247276.png'),
(16, 'Test Product', 'Test Category', '66741345675fc4.19206183.png'),
(17, 'Test Product', 'Test Category', '6674138973d065.18155720.png'),
(18, 'Test Product', 'Test Category', '667413ac1426a7.22226908.png'),
(19, 'Test Product', 'Test Category', '6674199671bb49.68760539.png'),
(20, 'Test Product', 'Test Category', '66741d882765e3.28032238.png'),
(21, 'Test Product', 'Test Category', '66741dcbdef650.60386503.png'),
(22, 'Test Product', 'Test Category', '66741de63eb1f7.78200747.png'),
(23, 'Test Product', 'Test Category', '66741e79db1868.92699384.png'),
(24, 'Test Product', 'Test Category', '66741ef78012b8.35636034.png'),
(25, 'Test Product', 'Test Category', '6674203f890216.15711094.png'),
(26, 'Test Product', 'Test Category', '6674205fbc4696.85678797.png'),
(27, 'Test Product', 'Test Category', '66742081f32a94.18654790.png');

-- --------------------------------------------------------

--
-- Table structure for table `shelves`
--

CREATE TABLE `shelves` (
  `shelfID` int(11) NOT NULL,
  `shelfOwner` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `imgShelf` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `shelves`
--

INSERT INTO `shelves` (`shelfID`, `shelfOwner`, `name`, `imgShelf`) VALUES
(1, 14, 'fridge', '665db6567396a5.97559034.png'),
(2, 14, 'Garage', '666d9061b08733.31461637.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `imgProfile` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `firstname`, `lastname`, `email`, `password`, `imgProfile`, `isAdmin`) VALUES
(1, 'Ricar', 'asf', 'riccardo@asd.com', '$2y$10$6sBDWIejjZQeP0jmQ6JWAuo9F/pkyvKd4YAPpxLcyBQpXUTEvBSqi', 'https://www.google.com/', 0),
(2, 'r', 'r', 'riccardo@asds.com', '$2y$10$gwvEuQug8e777LT5J3l1i.e0dtfobt3P/ZMzGM/LJ6XiI45P.n8zG', NULL, 0),
(3, 'Ric', 'sdf', 'ric@ric.com', '$2y$10$GM/wNDm4qK.0QOFZ0eKhyeyTwlT5Nfwolq9xn/9piQr16Oczeim3i', NULL, 0),
(4, 'Riccardo', 'Glenn', 'ric@glenn.com', '$2y$10$zy8Hof.9RoX2GeeWYsC1Z.k/5Geek/YBrjMG0g0bp74Ydr7Bp1vXq', NULL, 0),
(6, 'dshfk', 'dgfd', 'ric@glennd.com', '$2y$10$b9UYtJhMpe8Gc40HqIgaROGplc29iHdPhTutO2t9O5.uXPlRPSz.q', NULL, 0),
(14, 'ric', 'ric', 'ric@riccc.com', '$2y$10$UU12RuY4.OAyQnIUZnbvQeAnc1CrZacj08DYZ2FkK.2csz7nLzn.m', '666339286a1d78.63864321.png', 1),
(15, 'Peppe', 'Bick', 'peppe-bick@ex.com', '$2y$10$WIRM3Q17UWkzdUvpmnSQ5OZ2CkM9wptF4ne7rVIXKRnKsI4hF4xya', NULL, 0),
(38, 'John', 'Doe', 'john.doe@example.com', '$2y$10$voR0LMkiigyEqJl3dnzekOrhZkP1TmFIxHx6rX/CVqeqJC5u6Te.S', '6671ae027aa431.66890328.jpg', 0),
(80, 'testuser', 'testuser', 'test@user.com', '$2y$10$2byNiz96D1VhzOfeBCtpbu1jOAv.lqx8EU1vZQUisICqBM/XM/lQG', NULL, 0),
(82, 'user1', 'user1', 'test1@example.com', '$2y$10$/6ZhJhWGCD6peywaDMAJ3e/PxQjZlEDBCKqMNudn9kRRUQR2X2Rk6', NULL, 0),
(83, 'user2', 'user2', 'test2@example.com', '$2y$10$.akfY73l85Q1o/WZReVNHeH4hjkBf8C9vaf9ZaSUY3egt2MtuRJYO', NULL, 0),
(87, 'test3', 'test3', 'test3@example.com', '$2y$10$bd.T71awyRX1sBAKRxiJledi19o2lfA.JKBfG.osfiuo4S4.BQwyi', NULL, 0),
(89, 'asd', 'asd', 'asd@asd.mo', '$2y$10$9UI/zC4XxqRZTJeb6ICG6OT.SJKtyFJgP7nXThhYJT84MLDrPMDay', NULL, 0),
(93, 'asdsd', 'asdas', 'asdf@asda.nm', '$2y$10$b5u/GfJ6DhBuwlt5aZncWeejpb3O8fm410r4.CDjNfLRiQ1I2dakG', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessibility`
--
ALTER TABLE `accessibility`
  ADD PRIMARY KEY (`userID`,`shelfID`),
  ADD KEY `shelfID` (`shelfID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productID`),
  ADD KEY `shelfID` (`shelfID`);

--
-- Indexes for table `product_templates`
--
ALTER TABLE `product_templates`
  ADD PRIMARY KEY (`templateID`);

--
-- Indexes for table `shelves`
--
ALTER TABLE `shelves`
  ADD PRIMARY KEY (`shelfID`),
  ADD KEY `shelfOwner` (`shelfOwner`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `product_templates`
--
ALTER TABLE `product_templates`
  MODIFY `templateID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `shelves`
--
ALTER TABLE `shelves`
  MODIFY `shelfID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accessibility`
--
ALTER TABLE `accessibility`
  ADD CONSTRAINT `accessibility_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `accessibility_ibfk_2` FOREIGN KEY (`shelfID`) REFERENCES `shelves` (`shelfID`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`shelfID`) REFERENCES `shelves` (`shelfID`);

--
-- Constraints for table `shelves`
--
ALTER TABLE `shelves`
  ADD CONSTRAINT `shelves_ibfk_1` FOREIGN KEY (`shelfOwner`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
