-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2025 at 08:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12
CREATE DATABASE IF NOT EXISTS nohunger;
USE nohunger;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nohunger`
--

-- --------------------------------------------------------

--
-- Table structure for table `applydonation`
--

CREATE TABLE `applydonation` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phonenumber` varchar(15) NOT NULL,
  `residential` varchar(255) NOT NULL,
  `reason_to_apply` text NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asignup`
--

CREATE TABLE `signup` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE donations (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    donation_type ENUM('monthly', 'one-time') NOT NULL, 
    amount DECIMAL(10, 2) NOT NULL, 
    currency VARCHAR(3) NOT NULL, 
    name VARCHAR(255) NOT NULL, 
    email VARCHAR(255) NOT NULL, 
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `donation_type`, `amount`, `currency`, `name`, `email`) VALUES
(1, 'monthly', 100.00, 'MYR', 'CAWLE', 'abdullahi.ali@student.aiu.edu.my');

-- --------------------------------------------------------

--
-- Table structure for table `joinrequests`
--

CREATE TABLE `joinrequests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization` varchar(255) NOT NULL, -- Organization column added
  `country` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `position` enum('donor', 'helper', 'volunteer', 'ambassador') NOT NULL,
  PRIMARY KEY (`id`) -- Set id as the primary key
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderfreefood`
--
CREATE TABLE meal_donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    branch VARCHAR(255) NOT NULL,
    meal_item VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    sub_total DECIMAL(10, 2) NOT NULL,
    payment_method VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE `orderfreefood` (
  `id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `delivery_fee` decimal(10,2) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applydonation`
--
ALTER TABLE `applydonation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asignup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `joinrequests`
--
ALTER TABLE `joinrequests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderfreefood`
--
ALTER TABLE `orderfreefood`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applydonation`
--
ALTER TABLE `applydonation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `meal_donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table `asignup`
--
ALTER TABLE `signup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `joinrequests`
--
ALTER TABLE `joinrequests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderfreefood`
--
ALTER TABLE `orderfreefood`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
