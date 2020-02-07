-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 07, 2020 at 09:19 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ap_dashboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

DROP TABLE IF EXISTS `bank`;
CREATE TABLE IF NOT EXISTS `bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `check_details`
--

DROP TABLE IF EXISTS `check_details`;
CREATE TABLE IF NOT EXISTS `check_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` int(11) NOT NULL,
  `cv_no` varchar(50) NOT NULL,
  `bank` int(11) NOT NULL,
  `check_no` varchar(50) NOT NULL,
  `check_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company`, `status`) VALUES
(1, 'AeonPrime', 1),
(2, 'Polaris', 1);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department` varchar(200) NOT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department`, `status`) VALUES
(1, 'Accounting', 1),
(2, 'Ancillary', 1),
(3, 'Audit', 1),
(4, 'Business Process', 1),
(5, 'Executive Office', 1),
(6, 'Engineering', 1),
(7, 'HR', 1),
(8, 'IT', 1),
(9, 'KENZO', 1),
(10, 'Leasing', 1),
(11, 'Logistic', 1),
(12, 'Marketing', 1),
(13, 'Operations-Contruction', 1),
(14, 'PMO-Cebu', 1),
(15, 'PMO-Manila', 1),
(16, 'PMC', 1),
(17, 'Purchasing', 1),
(18, 'Retail Business', 1);

-- --------------------------------------------------------

--
-- Table structure for table `po_details`
--

DROP TABLE IF EXISTS `po_details`;
CREATE TABLE IF NOT EXISTS `po_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_num` varchar(20) NOT NULL,
  `company` int(11) NOT NULL,
  `project` int(11) NOT NULL,
  `department` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `bill_no` varchar(20) NOT NULL,
  `bill_date` datetime NOT NULL,
  `terms` int(11) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `days_due` int(11) DEFAULT NULL,
  `date_submit` varchar(11) NOT NULL,
  `submitted_by` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `po_details`
--

INSERT INTO `po_details` (`id`, `po_num`, `company`, `project`, `department`, `supplier`, `bill_no`, `bill_date`, `terms`, `due_date`, `days_due`, `date_submit`, `submitted_by`, `status`) VALUES
(1, '154366', 1, 0, 0, 1, '4512265', '2020-01-31 00:00:00', NULL, NULL, NULL, '2020-01-31', 0, 1),
(2, '20-2231-141', 2, 0, 0, 6, '19-200013', '2020-02-03 00:00:00', NULL, NULL, NULL, '2020-02-03', 0, 1),
(3, '4512333', 1, 0, 0, 5, '854467-2021', '2020-02-04 00:00:00', NULL, NULL, NULL, '2020-02-04', 0, 1),
(4, '121133', 1, 0, 0, 1, '5564122', '2020-02-05 00:00:00', NULL, NULL, NULL, '2020-02-05', 0, 1),
(5, '1123-42', 2, 0, 0, 3, '554602-20', '2020-02-05 00:00:00', NULL, NULL, NULL, '2020-02-05', 0, 1),
(6, '1212-112', 2, 0, 0, 6, '121311-1111', '2020-02-05 00:00:00', NULL, NULL, NULL, '2020-02-05', 0, 1),
(7, '11122', 2, 0, 0, 3, '121334', '2020-02-26 00:00:00', 20, '7070-01-01 00:00:00', 20, '2020-02-06', 0, 1),
(8, '1211', 2, 0, 0, 1, '2212134345', '2020-02-06 00:00:00', 30, '2020-03-11 00:00:00', 30, '2020-02-06', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `po_other_details`
--

DROP TABLE IF EXISTS `po_other_details`;
CREATE TABLE IF NOT EXISTS `po_other_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` int(11) NOT NULL,
  `date_returned_req` datetime NOT NULL,
  `2nd_date_received` datetime NOT NULL,
  `date_received_fo` datetime NOT NULL,
  `date_received_bo` datetime NOT NULL,
  `date_to_ea` datetime NOT NULL,
  `date_from_ea` datetime NOT NULL,
  `date_release` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `status`) VALUES
(1, 'Pending'),
(2, 'On Process'),
(3, 'For BO Processing'),
(4, 'For Signature'),
(5, 'For Releasing'),
(6, 'Released'),
(7, 'Returned');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `supplier_name`, `status`) VALUES
(1, 'Atlantic Hardware', 1),
(2, 'Ace Hardware Incorporated', 1),
(3, 'Vic Enterprises Inc.', 1),
(4, 'Graphic Star', 1),
(5, 'Cannon Philippines', 1),
(6, 'Perfect Star', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `logcount` int(11) NOT NULL,
  `access` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `username`, `password`, `logcount`, `access`, `status`) VALUES
(1, 'Elmar', 'Malazarte', 'elmar.malazarte@innogroup.com.ph', 'elmar.malazarte', 'e10adc3949ba59abbe56e057f20f883e', 0, 1, 1),
(2, 'Jan Jomar', 'Lim', 'elmar.malazarte@innogroup.com.ph', 'janjomar.lim', 'e10adc3949ba59abbe56e057f20f883e', 0, 2, 1),
(3, 'Jade', 'Romo', 'jerome.romo@innogroup.com.ph', 'jade.romo', '4297f44b13955235245b2497399d7a93', 0, 2, 1),
(4, 'John Carlo', 'Espinosa', 'johncarlo.espinosa@innogroup.com.ph', 'johncarlo.espinosa', 'e10adc3949ba59abbe56e057f20f883e', 0, 3, 1),
(5, 'Jeffrey', 'Monilla', 'jeffrey.monilla@innogroup.com.ph', 'jeffrey.monilla', 'e10adc3949ba59abbe56e057f20f883e', 0, 3, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
