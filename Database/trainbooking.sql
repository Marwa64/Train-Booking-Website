-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2020 at 02:53 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trainbooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `booked_trip`
--

CREATE TABLE `booked_trip` (
  `user_ID` int(11) NOT NULL,
  `trip_ID` int(11) NOT NULL,
  `cost` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `train`
--

CREATE TABLE `train` (
  `train_ID` int(11) NOT NULL,
  `cartNum` int(11) NOT NULL,
  `seatNum` int(11) NOT NULL,
  `train_type` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `train`
--

INSERT INTO `train` (`train_ID`, `cartNum`, `seatNum`, `train_type`) VALUES
(3, 4, 100, 'Polar Express'),
(6, 6, 70, 'Duronto Express');

-- --------------------------------------------------------

--
-- Table structure for table `trip`
--

CREATE TABLE `trip` (
  `trip_ID` int(11) NOT NULL,
  `trip_from` varchar(30) NOT NULL,
  `trip_to` varchar(30) NOT NULL,
  `trip_seats` int(11) NOT NULL,
  `seatCost` float NOT NULL,
  `trip_date` date NOT NULL,
  `trip_time` varchar(10) NOT NULL,
  `train_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trip`
--

INSERT INTO `trip` (`trip_ID`, `trip_from`, `trip_to`, `trip_seats`, `seatCost`, `trip_date`, `trip_time`, `train_ID`) VALUES
(6, 'Cairo', 'Luxor', 400, 10, '2020-05-30', '13:00', 3),
(7, 'NewYork', 'Washington', 420, 25, '2020-06-21', '11:00', 6),
(8, 'Alexandria', 'Cairo', 420, 15, '2020-07-08', '17:15', 6),
(9, 'Cairo', 'Aswan', 400, 20, '2020-06-17', '19:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `user_ID` int(11) NOT NULL,
  `user_name` varchar(40) NOT NULL,
  `user_password` varchar(40) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL,
  `balance` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`user_ID`, `user_name`, `user_password`, `user_email`, `role`, `balance`) VALUES
(3, 'Admin', 'admin01', 'admin@gmail.com', 'Admin', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `train`
--
ALTER TABLE `train`
  ADD PRIMARY KEY (`train_ID`);

--
-- Indexes for table `trip`
--
ALTER TABLE `trip`
  ADD PRIMARY KEY (`trip_ID`),
  ADD KEY `train_ID` (`train_ID`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `train`
--
ALTER TABLE `train`
  MODIFY `train_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `trip`
--
ALTER TABLE `trip`
  MODIFY `trip_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `trip`
--
ALTER TABLE `trip`
  ADD CONSTRAINT `trip_ibfk_1` FOREIGN KEY (`train_ID`) REFERENCES `train` (`train_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
