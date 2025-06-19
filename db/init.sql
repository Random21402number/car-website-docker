-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2025 at 12:12 PM
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
-- Database: `carwebsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `maker` varchar(50) NOT NULL,
  `model` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `mileage` int(11) DEFAULT NULL,
  `user_id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `maker`, `model`, `year`, `price`, `image_path`, `mileage`, `user_id`) VALUES
(1, 'Toyota', 'Camryyyyy', 2023, 25000.00, 'https://www.clickheretesting.com/GreenvilleToyota/research/2023/camry/images/mlp-img-perf.webp', 123, 1),
(3, 'Ford', 'Mustang', 2023, 35000.00, 'https://www.ford.co.uk/content/dam/guxeu/rhd/central/cars/S650-Mustang/my25/column_cards/ford-mustang-eu-bronze_pack_overview_card-3x2-1000x667.jpg', 123, NULL),
(4, 'honda', 'Camry', 2011, 123123.00, '', 1231, NULL),
(5, 'honda', 'Camry', 2011, 123123.00, NULL, 1231, NULL),
(6, 'honda', 'Camry', 2011, 123123.00, NULL, 1231, NULL),
(7, 'honda', 'Camry', 2011, 123123.00, NULL, 1231, NULL),
(8, 'honda', '1234', 2025, 1234.00, NULL, 1234, NULL),
(9, 'honda', '1234', 2025, 1234.00, NULL, 1234, NULL),
(10, 'honda', '1234', 2025, 1234.00, NULL, 1234, NULL),
(11, 'honda', 'Camry', 2014, 123456.00, NULL, 2134, NULL),
(12, 'toyota', 'Camry', 2012, 123321.00, NULL, 12341234, 5),
(13, 'toyota', 'Camry', 2021, 19799.00, NULL, 100, 6);

-- --------------------------------------------------------

--
-- Table structure for table `car_features`
--

CREATE TABLE `car_features` (
  `car_id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car_features`
--

INSERT INTO `car_features` (`car_id`, `feature_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 7),
(1, 8),
(1, 9),
(3, 1),
(3, 2),
(3, 5),
(3, 6),
(4, 1),
(4, 2),
(4, 4),
(4, 5),
(4, 6),
(5, 1),
(5, 2),
(5, 4),
(5, 5),
(5, 6),
(6, 1),
(6, 2),
(6, 4),
(6, 5),
(6, 6),
(7, 1),
(7, 2),
(7, 4),
(7, 5),
(7, 6),
(8, 1),
(8, 4),
(8, 6),
(9, 1),
(9, 4),
(9, 6),
(10, 1),
(10, 4),
(10, 6),
(11, 2),
(11, 4),
(11, 5),
(12, 1),
(12, 2),
(12, 4),
(12, 5),
(12, 9),
(13, 2),
(13, 3),
(13, 4),
(13, 5),
(13, 6),
(13, 7),
(13, 8),
(13, 9);

-- --------------------------------------------------------

--
-- Table structure for table `email_settings`
--

CREATE TABLE `email_settings` (
  `setting_id` int(11) NOT NULL,
  `setting_name` varchar(50) NOT NULL,
  `setting_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_settings`
--

INSERT INTO `email_settings` (`setting_id`, `setting_name`, `setting_value`) VALUES
(1, 'from_email', 'noreply@carmarket.com'),
(2, 'from_name', 'CarMarket'),
(3, 'reply_to', 'support@carmarket.com'),
(4, 'email_subject_template', 'New inquiry about your {year} {maker} {model}');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `feature_id` int(11) NOT NULL,
  `feature_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`feature_id`, `feature_name`) VALUES
(6, 'Alloy Wheels'),
(3, 'Backup Camera'),
(2, 'Bluetooth'),
(7, 'Climate Control'),
(9, 'Cruise Control'),
(8, 'Heated Seats'),
(5, 'Leather Seats'),
(4, 'Navigation System'),
(1, 'Sunroof');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `inquiry_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`inquiry_id`, `car_id`, `name`, `email`, `phone`, `message`, `created_at`, `is_read`) VALUES
(18, 11, 'Endurable Moon', 'EndurableMoon@gmail.com', '0898590351', 'Hi, Im interested in the 2014 honda Camry. Please contact me with more information.', '2025-04-10 19:59:41', 0),
(19, 12, 'Endurable Moon', 'EndurableMoon@gmail.com', '0898590351', 'Hi, Im interested in the 2012 toyota Camry. Please contact me with more information.', '2025-04-10 20:06:25', 0),
(20, 13, 'Endurable Moon', 'EndurableMoon@gmail.com', '0898590351', 'Hi, Im interested in the 2021 toyota Camry. Please contact me with more information.', '2025-04-10 20:23:51', 1),
(21, 1, 'EndurableMoon', 'EndurableMoon@gmail.com', '0898590351', 'Hi, Im interested in the 2023 Toyota Camryyyyy. Please contact me with more information.', '2025-04-12 17:32:04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Name`, `Password`, `Email`, `Phone`) VALUES
(1, '1234123412341234', '$2y$10$c8MDl.b38zCKW3ziicw7teET1BuOzdUeI.ch./7xB9d9khMRSE2L6', '21402@uktc-bg.com', '0898590351'),
(2, '12341234', '$2y$10$lttonAzh3tFym3SMj2AgheL3Pk0Oc/HO4o/J6Y/l8K0r/3GeJ10.S', 'disposable1234567@abv.bg', '0'),
(3, 'EndurableMoon1234', '$2y$10$CnLTAmZM.t7yJtdy5rdBO.En3tGPGEI9gEMpjpnawWAh4CY5vgnau', 'AndreyPetrov12345@abv.bg', '0'),
(5, '12341234123412345', '$2y$10$YKFo6U/XuGjg7LU7oloSH.586kDNUrpwoUH6m7ZxQ8FiEtEL6xRVO', 'EndurableMoon@gmail.com', ''),
(6, 'MrMimi', '$2y$10$3KAwVlanctxNnHCyVAt2Ie8fiI65qGQIe9AFdTfE9aOEw4RDF2Moe', 'AndreyPetrov1213@abv.bg', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`),
  ADD KEY `fk_cars_users` (`user_id`);

--
-- Indexes for table `car_features`
--
ALTER TABLE `car_features`
  ADD PRIMARY KEY (`car_id`,`feature_id`),
  ADD KEY `feature_id` (`feature_id`);

--
-- Indexes for table `email_settings`
--
ALTER TABLE `email_settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD UNIQUE KEY `setting_name` (`setting_name`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`feature_id`),
  ADD UNIQUE KEY `feature_name` (`feature_name`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`inquiry_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `email_settings`
--
ALTER TABLE `email_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `feature_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `inquiry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `fk_cars_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE SET NULL;

--
-- Constraints for table `car_features`
--
ALTER TABLE `car_features`
  ADD CONSTRAINT `car_features_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `car_features_ibfk_2` FOREIGN KEY (`feature_id`) REFERENCES `features` (`feature_id`) ON DELETE CASCADE;

--
-- Constraints for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD CONSTRAINT `inquiries_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
