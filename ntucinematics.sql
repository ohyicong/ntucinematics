-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2018 at 05:17 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ntucinematics`
--

-- --------------------------------------------------------

--
-- Table structure for table `cinema`
--

CREATE TABLE `cinema` (
  `cinemaID` varchar(100) NOT NULL,
  `cinemaName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cinema`
--

INSERT INTO `cinema` (`cinemaID`, `cinemaName`) VALUES
('001', 'JURONG'),
('002', 'YISHUN'),
('003', 'HABOURFRONT');

-- --------------------------------------------------------

--
-- Table structure for table `current_movies`
--

CREATE TABLE `current_movies` (
  `MOVIE_ID` text NOT NULL,
  `MOVIE_NAME` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `current_movies`
--

INSERT INTO `current_movies` (`MOVIE_ID`, `MOVIE_NAME`) VALUES
('001', 'CRAZY RICH ASIANS'),
('002', 'THE FIRST PURGE'),
('003', 'DOWN A DARK HALL'),
('004', 'A STAR IS BORN'),
('005', 'VENOM'),
('006', 'THE NUN');

-- --------------------------------------------------------

--
-- Table structure for table `loc_address`
--

CREATE TABLE `loc_address` (
  `MOVIE_ID` text NOT NULL,
  `MOVIE_NAME` text NOT NULL,
  `CINEMA_ID` text NOT NULL,
  `CINEMA` text NOT NULL,
  `DAY` text NOT NULL,
  `TIME` text NOT NULL,
  `TIMESTAMP` text NOT NULL,
  `UNIQUE_ID` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loc_address`
--

INSERT INTO `loc_address` (`MOVIE_ID`, `MOVIE_NAME`, `CINEMA_ID`, `CINEMA`, `DAY`, `TIME`, `TIMESTAMP`, `UNIQUE_ID`) VALUES
('001', 'CRAZY RICH ASIANS', '001', 'JURONG', '001', '001', '14:00', '001001001001'),
('001', 'CRAZY RICH ASIANS', '001', 'JURONG', '002', '001', '14:00', '001001002001'),
('001', 'CRAZY RICH ASIANS', '001', 'JURONG', '003', '001', '14:00', '001001003001'),
('001', 'CRAZY RICH ASIANS', '001', 'JURONG', '004', '001', '14:00', '001001004001'),
('001', 'CRAZY RICH ASIANS', '001', 'JURONG', '005', '001', '14:00', '001001005001'),
('001', 'CRAZY RICH ASIANS', '001', 'JURONG', '006', '001', '14:00', '001001006001'),
('001', 'CRAZY RICH ASIANS', '001', 'JURONG', '007', '001', '14:00', '001001007001');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_history`
--

CREATE TABLE `purchase_history` (
  `purchaseID` int(100) NOT NULL,
  `userID` varchar(200) NOT NULL,
  `movieID` varchar(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `purchaseDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `movieDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `seatNumber` varchar(100) NOT NULL,
  `cinemaID` varchar(100) NOT NULL,
  `uniqueID` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `unique_seats`
--

CREATE TABLE `unique_seats` (
  `UNIQUE_ID` text NOT NULL,
  `SEAT_NO` text NOT NULL,
  `DATETIME` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `userid` text NOT NULL,
  `name` text NOT NULL,
  `password` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `cardno` text NOT NULL,
  `address` text NOT NULL,
  `ccv` text NOT NULL,
  `registerdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cardtype` varchar(10) DEFAULT NULL,
  `postalcode` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD PRIMARY KEY (`purchaseID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `purchaseID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
