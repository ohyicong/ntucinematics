-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2018 at 06:27 AM
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
  `MOVIE_NAME` text NOT NULL,
  `MOVIE_TYPE` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `current_movies`
--

INSERT INTO `current_movies` (`MOVIE_ID`, `MOVIE_NAME`, `MOVIE_TYPE`) VALUES
('001', 'CRAZY RICH ASIANS', 'ROMANCE'),
('002', 'THE FIRST PURGE', 'THRILLER'),
('003', 'DOWN A DARK HALL', 'HORROR'),
('004', 'A STAR IS BORN', 'ROMANCE'),
('005', 'VENOM', 'THRILLER'),
('006', 'THE NUN', 'HORROR');

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
('001', 'CRAZY RICH ASIANS', '001', 'JURONG', '001', '001', '19:00', '001001001001'),
('001', 'CRAZY RICH ASIANS', '001', 'JURONG', '002', '001', '19:00', '001001002001'),
('001', 'CRAZY RICH ASIANS', '001', 'JURONG', '003', '001', '19:00', '001001003001'),
('001', 'CRAZY RICH ASIANS', '001', 'JURONG', '004', '001', '19:00', '001001004001'),
('001', 'CRAZY RICH ASIANS', '001', 'JURONG', '005', '001', '19:00', '001001005001'),
('001', 'CRAZY RICH ASIANS', '001', 'JURONG', '006', '001', '19:00', '001001006001'),
('001', 'CRAZY RICH ASIANS', '001', 'JURONG', '007', '001', '19:00', '001001007001'),
('002', 'THE FIRST PURGE', '002', 'YISHUN', '001', '001', '13:15', '002002001001'),
('002', 'THE FIRST PURGE', '002', 'YISHUN', '002', '001', '13:15', '002002002001'),
('002', 'THE FIRST PURGE', '002', 'YISHUN', '003', '001', '13:15', '002002003001'),
('002', 'THE FIRST PURGE', '002', 'YISHUN', '004', '001', '13:15', '002002004001'),
('002', 'THE FIRST PURGE', '002', 'YISHUN', '005', '001', '13:15', '002002005001'),
('002', 'THE FIRST PURGE', '002', 'YISHUN', '006', '001', '13:15', '002002006001'),
('002', 'THE FIRST PURGE', '002', 'YISHUN', '007', '001', '13:15', '002002007001');

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

--
-- Dumping data for table `purchase_history`
--

INSERT INTO `purchase_history` (`purchaseID`, `userID`, `movieID`, `quantity`, `purchaseDate`, `movieDate`, `seatNumber`, `cinemaID`, `uniqueID`) VALUES
(1, '0aa73acded4fe0b62e573718e5f57d0a88bca0b8', '001', 4, '2018-10-29 20:23:00', '2018-10-30 05:30:00', '  0 , 1 , 2 , 3  ', '00001', '001001001002'),
(2, '0aa73acded4fe0b62e573718e5f57d0a88bca0b8', '001', 5, '2018-10-29 20:24:00', '2018-10-30 05:30:00', '  4 , 5 , 6 , 7 , 8  ', '00001', '001001001002'),
(3, '0aa73acded4fe0b62e573718e5f57d0a88bca0b8', '001', 4, '2018-10-29 20:38:00', '2018-10-30 05:30:00', '  18 , 27 , 28 , 29  ', '00001', '001001001002'),
(4, '0aa73acded4fe0b62e573718e5f57d0a88bca0b8', '001', 3, '2018-10-29 21:49:00', '2018-11-01 05:00:00', '  0 , 1 , 2  ', '001', '001001003001'),
(5, '0aa73acded4fe0b62e573718e5f57d0a88bca0b8', '001', 2, '2018-10-29 22:04:00', '2018-11-02 05:00:00', '  3 , 4  ', '001', '001001003001'),
(6, '0aa73acded4fe0b62e573718e5f57d0a88bca0b8', '001', 0, '2018-10-30 21:53:00', '2018-10-31 05:00:00', '  ', '001', '001001001001'),
(7, '0aa73acded4fe0b62e573718e5f57d0a88bca0b8', '002', 3, '2018-10-30 21:53:00', '2018-10-31 05:15:00', '  0 , 1 , 12  ', '002', '002002003001'),
(8, '0aa73acded4fe0b62e573718e5f57d0a88bca0b8', '002', 1, '2018-10-30 22:12:00', '2018-10-31 05:15:00', '  2  ', '002', '002002003001'),
(9, '0aa73acded4fe0b62e573718e5f57d0a88bca0b8', '001', 4, '2018-10-30 22:12:00', '2018-10-31 11:00:00', '  12 , 13 , 5 , 14  ', '001', '001001003001');

-- --------------------------------------------------------

--
-- Table structure for table `unique_seats`
--

CREATE TABLE `unique_seats` (
  `UNIQUE_ID` text NOT NULL,
  `SEAT_NO` text NOT NULL,
  `DATETIME` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unique_seats`
--

INSERT INTO `unique_seats` (`UNIQUE_ID`, `SEAT_NO`, `DATETIME`) VALUES
('001001001002', '0', '2018-10-30 13:30:00'),
('001001001002', '1', '2018-10-30 13:30:00'),
('001001001002', '2', '2018-10-30 13:30:00'),
('001001001002', '3', '2018-10-30 13:30:00'),
('001001001002', '4', '2018-10-30 13:30:00'),
('001001001002', '5', '2018-10-30 13:30:00'),
('001001001002', '6', '2018-10-30 13:30:00'),
('001001001002', '7', '2018-10-30 13:30:00'),
('001001001002', '8', '2018-10-30 13:30:00'),
('001001001002', '18', '2018-10-30 13:30:00'),
('001001001002', '27', '2018-10-30 13:30:00'),
('001001001002', '28', '2018-10-30 13:30:00'),
('001001001002', '29', '2018-10-30 13:30:00'),
('001001003001', '0', '2018-11-01 13:00:00'),
('001001003001', '1', '2018-11-01 13:00:00'),
('001001003001', '2', '2018-11-01 13:00:00'),
('001001003001', '3', '2018-11-02 13:00:00'),
('001001003001', '4', '2018-11-02 13:00:00'),
('002002003001', '0', '2018-10-31 13:15:00'),
('002002003001', '1', '2018-10-31 13:15:00'),
('002002003001', '12', '2018-10-31 13:15:00'),
('002002003001', '2', '2018-10-31 13:15:00'),
('001001003001', '12', '2018-10-31 19:00:00'),
('001001003001', '13', '2018-10-31 19:00:00'),
('001001003001', '5', '2018-10-31 19:00:00'),
('001001003001', '14', '2018-10-31 19:00:00');

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
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`userid`, `name`, `password`, `email`, `cardno`, `address`, `ccv`, `registerdate`, `cardtype`, `postalcode`) VALUES
('0aa73acded4fe0b62e573718e5f57d0a88bca0b8', 'yicong', '123123', 'ohyicong123@hotmail.com', '1234512345123451', 'Ang mo kio ave 10', '123', '2018-10-30 15:23:01', 'Mastercard', '123456');

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
  MODIFY `purchaseID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
