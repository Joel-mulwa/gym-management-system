-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2024 at 08:16 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thegymdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'joel123');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `schedule` varchar(255) NOT NULL,
  `plan_id` varchar(255) NOT NULL,
  `package_id` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `schedule`, `plan_id`, `package_id`, `status`, `customer_id`) VALUES
(54, 'morning', '1', '10', 'paid', 34),
(55, 'evening', '3', '12', 'approved', 35),
(56, 'morning', '6', '20', 'paid', 36),
(57, 'morning', '1', '1', 'paid', 36),
(58, 'morning', '1', '1', 'paid', 36),
(59, 'morning', '1', '1', 'paid', 36),
(60, 'morning', '1', '1', 'paid', 36),
(61, 'morning', '1', '1', 'paid', 37),
(62, 'morning', '1', '15', 'paid', 37),
(63, 'morning', '1', '1', 'pending', 37);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `fullname`, `username`, `password`, `contact`, `gender`, `status`, `email`) VALUES
(1, 'julia makinya mumbi', 'julia', '$2y$10$mbHFx70q23xAh6WihYEKgu3LttrubZE5f5QjVxHopp/nss8ZovHuO', '0797673392', 'Male', 1, 'makinyajulia@gmail.com'),
(35, 'carol', 'caro', '$2y$10$iG1r158WxdwuOO8lYpXF2udKC5nXCqm0xXmVYHLz6uZhAc4FXNWL2', '0797673392', 'Female', 1, 'makinyajulia@gmail.com'),
(36, 'tabby', 'tjay', '$2y$10$fF1REoj9e81p6hXUTX8XQOSIjpi8WejjHqpFx217K.96BAUroj.bW', '0741416717', 'Female', 1, 'tabbyccherop@gmail.com'),
(37, 'mr mwenda gichuru ', 'mwenda', '$2y$10$k5psUr8Kggg6WJuwmmb6SOScQkPfd8FPJhJ3n5Uji7vRhcfXuqloe', '0797673392', 'Male', 1, 'makinyajulia@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `package_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`package_id`, `name`, `description`, `amount`) VALUES
(1, 'simple package', 'one day weight cut package', '1000.00'),
(10, 'simple package', 'one day Basic Membership', '950.00'),
(12, 'starter package', 'one week Fitness Starter Package', '1500.00'),
(14, 'Family Fitness Package', 'Three month Family Fitness Package', '10500.00'),
(15, 'Premium Membership', 'one week Premium Membership', '3500.00'),
(16, 'Couples Fitness Package', 'Three month Couples Fitness Package', '12000.00'),
(17, 'semi -complex package', 'Six month Couples Fitness Package', '18000.00'),
(18, 'Premium  package', 'Six month premium package', '19500.00'),
(19, 'complex package', 'one year complex package', '35000.00'),
(20, 'Discounted package', 'One year Discounted package', '33500.00');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` varchar(255) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `booking_id`, `amount`, `status`, `transaction_id`, `payment_date`, `customer_id`) VALUES
('payment_65fab44acbaec', 59, '1000.00', 'paid', 'transaction_65fab44acbaf3', '2024-03-20 11:02:50', 36),
('payment_65fc333dd0289', 60, '1000.00', 'paid', 'transaction_65fc333dd0294', '2024-03-21 14:16:45', 36),
('payment_65fc376d79447', 61, '1000.00', 'paid', 'transaction_65fc376d79452', '2024-03-21 14:34:37', 37),
('payment_65fc37c80f27b', 62, '3500.00', 'paid', 'transaction_65fc37c80f285', '2024-03-21 14:36:08', 37);

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `plan_id` int(11) NOT NULL,
  `plan_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`plan_id`, `plan_type`) VALUES
(1, 'one day'),
(2, 'one week'),
(3, 'one month'),
(4, 'three months'),
(5, 'six months'),
(6, 'one year');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `duration` int(11) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
