-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 19, 2020 at 10:06 AM
-- Server version: 5.7.23
-- PHP Version: 5.6.38

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
-- Table structure for table `access`
--

DROP TABLE IF EXISTS `access`;
CREATE TABLE IF NOT EXISTS `access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `company` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `access`
--

INSERT INTO `access` (`id`, `user_id`, `company`) VALUES
(1, 1, '1,2,3,4,5,6,7,8,9,10,11,12,18,19,21,22,23,9,25,26,27,28,29,30'),
(2, 2, '1,2,3,4,5,6,7,8,9,10,11,12,18,19,21,22,23,9,25,26,27,28,29,30'),
(3, 3, '10,11,12,2,3,4,6,5,7,8,18,19,1'),
(4, 4, '10,11,12,22,23,25,26,27,28,29,30,21,9'),
(5, 5, '1,2,3,4,5,6'),
(6, 6, '7,8,9'),
(7, 7, '21,22,23,9'),
(8, 8, '25,26,27,28'),
(9, 9, '29,30'),
(10, 10, '18,19');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

DROP TABLE IF EXISTS `bank`;
CREATE TABLE IF NOT EXISTS `bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id`, `name`, `status`) VALUES
(1, 'Eastwest Bank', 1),
(2, 'Chinabank', 1),
(3, 'BPI', 1),
(4, 'BDO', 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `check_details`
--

INSERT INTO `check_details` (`id`, `po_id`, `cv_no`, `bank`, `check_no`, `check_date`) VALUES
(1, 1, '441225', 2, '451323', '2020-03-11 00:00:00'),
(2, 2, '33121', 1, '1212', '2020-03-11 00:00:00'),
(6, 3, '112312', 4, '451122', '2020-03-18 00:00:00'),
(7, 4, '665122', 2, '12344', '2020-03-19 00:00:00'),
(8, 5, '1212', 1, '3312', '2020-03-18 00:00:00');

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
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company`, `status`) VALUES
(1, 'MJ Land Trade', 1),
(2, 'Aeon Prime', 1),
(3, 'Polaris', 1),
(4, 'Excel', 1),
(5, 'Toyo, Batangas', 1),
(6, 'Atria', 1),
(7, 'Velsons', 1),
(8, 'Carcar', 1),
(9, 'Serenis South', 1),
(10, 'Ong Tiak', 1),
(11, 'Link', 1),
(12, 'Ohmori', 1),
(13, 'Median 1 & 2', 1),
(14, 'Cagayan', 1),
(15, 'Induco', 1),
(16, 'Inno Prime', 1),
(17, 'Serenis Plains', 1),
(18, 'Innoland', 1),
(19, 'TGU', 1),
(20, 'Calres', 1),
(21, 'Calcen', 1),
(22, 'Abiathar (Montage)', 1),
(23, 'Serenis North', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

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
  `si_num` varchar(20) NOT NULL,
  `company` int(11) NOT NULL,
  `project` int(11) NOT NULL,
  `department` int(11) DEFAULT NULL,
  `supplier` int(11) NOT NULL,
  `bill_no` varchar(20) NOT NULL,
  `bill_date` datetime NOT NULL,
  `terms` varchar(11) DEFAULT NULL,
  `amount` varchar(20) NOT NULL,
  `due_date` datetime DEFAULT NULL,
  `days_due` varchar(15) DEFAULT NULL,
  `date_submit` varchar(11) NOT NULL,
  `reports` varchar(250) DEFAULT NULL,
  `or_num` varchar(20) DEFAULT NULL,
  `submitted_by` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `po_details`
--

INSERT INTO `po_details` (`id`, `po_num`, `si_num`, `company`, `project`, `department`, `supplier`, `bill_no`, `bill_date`, `terms`, `amount`, `due_date`, `days_due`, `date_submit`, `reports`, `or_num`, `submitted_by`, `status`) VALUES
(1, '4235', '', 2, 17, 12, 20, '445674', '2020-03-10 00:00:00', '30', '32,000.00', '2020-04-09 00:00:00', '29 day/s', '2020-03-10', '', '12331-2020', 1, 9),
(2, '125654', '5441122', 2, 18, 16, 1, '1231222', '2020-03-10 00:00:00', '30 days', '10,000.00', '2020-04-09 00:00:00', '28 day/s', '2020-03-10', '', '45112', 2, 11),
(3, '112453', '451244', 2, 2, 4, 4, '474574', '2020-03-07 00:00:00', '30', '50,000.00', '2020-04-06 00:00:00', 'undefined', '2020-03-16', '', NULL, 1, 9),
(4, '777941', '455745', 2, 5, 14, 3, '11746441', '2020-03-16 00:00:00', '30', '154,111.00', '2020-04-15 00:00:00', 'undefined', '2020-03-16', '', NULL, 1, 9),
(5, '44512', '455664', 2, 8, 16, 21, '121433445', '2020-03-16 00:00:00', '20', '10,000.00', '2020-04-05 00:00:00', 'undefined', '2020-03-16', '', '121223', 1, 11),
(6, '11234', '13341', 14, 17, 2, 3, '3131', '2020-03-18 00:00:00', '30', '45,661.00', '2020-04-17 00:00:00', NULL, '2020-03-18', '', NULL, 1, 1),
(7, '44321', '31212', 2, 6, 6, 17, '885664', '2020-03-18 00:00:00', '20', '41,225.00', '2020-04-07 00:00:00', NULL, '2020-03-18', '', NULL, 1, 1),
(8, '33112', '121344', 2, 25, 2, 23, '1213213', '2020-03-18 00:00:00', '30 days', '1,211.00', '2020-04-17 00:00:00', NULL, '2020-03-18', '', NULL, 1, 1),
(9, '99412', '1541', 2, 17, 16, 18, '78994', '2020-03-18 00:00:00', '20', '120,000.00', '2020-04-07 00:00:00', NULL, '2020-03-18', '', NULL, 1, 1),
(10, '44231', '144564', 2, 2, 3, 37, '55641', '2020-03-18 00:00:00', '30', '10,023.00', '2020-04-17 00:00:00', NULL, '2020-03-18', '', NULL, 1, 1),
(11, '1212', '4561', 2, 2, 15, 4, '123132', '2020-03-18 00:00:00', '30', '10,000.00', '2020-04-17 00:00:00', NULL, '2020-03-18', '', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `po_other_details`
--

DROP TABLE IF EXISTS `po_other_details`;
CREATE TABLE IF NOT EXISTS `po_other_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` int(11) NOT NULL,
  `date_returned_req` datetime DEFAULT NULL,
  `remarks` varchar(300) DEFAULT NULL,
  `2nd_date_received` datetime DEFAULT NULL,
  `date_received_fo` datetime DEFAULT NULL,
  `received_by_fo` int(11) DEFAULT NULL,
  `date_received_bo` datetime DEFAULT NULL,
  `received_by_bo` int(11) DEFAULT NULL,
  `date_to_ea` datetime DEFAULT NULL,
  `date_from_ea` datetime DEFAULT NULL,
  `date_on_hold` datetime DEFAULT NULL,
  `date_for_release` datetime DEFAULT NULL,
  `date_release` datetime DEFAULT NULL,
  `released_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `po_other_details`
--

INSERT INTO `po_other_details` (`id`, `po_id`, `date_returned_req`, `remarks`, `2nd_date_received`, `date_received_fo`, `received_by_fo`, `date_received_bo`, `received_by_bo`, `date_to_ea`, `date_from_ea`, `date_on_hold`, `date_for_release`, `date_release`, `released_by`) VALUES
(1, 1, '2020-03-10 00:00:00', 'lack of requirements', NULL, '2020-03-11 00:00:00', 4, '2020-03-11 00:00:00', 5, '2020-03-12 00:00:00', '2020-03-13 00:00:00', '2020-03-13 00:00:00', '2020-03-18 00:00:00', '2020-03-14 00:00:00', NULL),
(2, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 2, '2020-03-11 00:00:00', 'Check the details again', NULL, '2020-03-11 00:00:00', 4, '2020-03-11 00:00:00', 5, '2020-03-12 00:00:00', NULL, '2020-03-13 00:00:00', '2020-03-18 00:00:00', '2020-03-19 00:00:00', 5),
(6, 3, NULL, NULL, NULL, '2020-03-17 00:00:00', 4, '2020-03-18 00:00:00', 5, '2020-03-18 00:00:00', '2020-03-18 00:00:00', '2020-03-18 00:00:00', '2020-03-18 00:00:00', NULL, NULL),
(7, 4, NULL, NULL, NULL, '2020-03-17 00:00:00', 4, '2020-03-18 00:00:00', 5, '2020-03-18 00:00:00', '2020-03-18 00:00:00', '2020-03-18 00:00:00', NULL, NULL, NULL),
(8, 5, NULL, NULL, NULL, '2020-03-17 00:00:00', 4, '2020-03-18 00:00:00', 5, '2020-03-18 00:00:00', '2020-03-18 00:00:00', NULL, '2020-03-18 00:00:00', '2020-03-19 00:00:00', 4),
(9, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `project`, `status`) VALUES
(1, 'Fluor Corp Center (Orion)', 1),
(2, 'Harmonis Carcar', 1),
(3, 'Montage Phase 1B', 1),
(4, 'Montage Fit-Out', 1),
(5, 'Median 2 Showroom', 1),
(6, 'Serenis North', 1),
(7, 'Serenis Plains', 1),
(8, 'Serenis South', 1),
(9, 'The Median', 1),
(10, 'The Median 2', 1),
(11, 'Two Montage', 1),
(12, 'Fit-Out - Savvy Sherpa', 1),
(13, 'Fit-Out - Fluor 5/f', 1),
(14, 'Fit-Out - Fluor 12/f', 1),
(15, 'Fit-Out - Hikay SM', 1),
(16, 'Fit-Out - Calyx Penthouse', 1),
(17, 'Fit-Out - The Median Showroom', 1),
(18, 'Fit-Out - Ma. Luisa', 1),
(19, 'Fit-Out - Calyx Plug-n-Play', 1),
(20, 'Fit-Out - TGU Plug-n-Play', 1),
(21, 'Fit-Out - Link Plug-n-Play', 1),
(22, 'Fit-Out - CalCen 1201W', 1),
(23, 'Fit-Out - CalCen 1901W', 1),
(24, 'Fit-Out - CalCen 2101W', 1),
(25, 'Fit-Out - CalCen 2301W', 1),
(26, 'Fit-Out - CalCen 2401W', 1),
(27, 'Fit-Out - CalRes 09D', 1),
(28, 'Fit-Out - CalRes 18LM', 1),
(29, 'Fit-Out - CalRes 22FG', 1),
(30, 'Fit-Out - CalRes 26A', 1),
(31, 'Plug-n-Play - Aeon 6f', 1),
(32, 'Plug-n-Play - Aeon 10f', 1);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `status`) VALUES
(1, 'Pending'),
(2, 'Returned'),
(3, 'In Process'),
(4, 'Process by BO'),
(5, 'For Signature'),
(6, 'Sent to EA'),
(7, 'Ready to Claim from EA'),
(8, 'Returned from EA'),
(9, 'On Hold'),
(10, 'For Releasing'),
(11, 'Released');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(50) NOT NULL,
  `terms` varchar(20) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=576 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `supplier_name`, `terms`, `status`) VALUES
(1, '2Go', '30 days', 1),
(2, '2Jess Elect.Sales & Services', '30 days', 1),
(3, '3S Electronic Services', '', 1),
(4, '3B Merchandising', '', 1),
(5, '4JC Medical Imports', '', 1),
(6, 'A & M Carpet ', '', 1),
(7, 'A. Salonga ', '', 1),
(8, 'A.L. Saberon', '', 1),
(9, 'Abdel Construction', '', 1),
(10, 'Abenson Ventures Inc. ', 'COD', 1),
(11, 'Accent Micro (AMTI)', '', 1),
(12, 'Access Frontier', '', 1),
(13, 'Ace Hardware Phils. Inc.', 'COD', 1),
(14, 'Adams Travel', '', 1),
(15, 'Adlawan Construction', '', 1),
(16, 'Aedobe Corp.', '30 days', 1),
(17, 'AIMHEC', '', 1),
(18, 'Aison Surplus ', '', 1),
(19, 'Akari Lighting and Technology Corp.', '', 1),
(20, 'Alaska Refrigeration', '30 days', 1),
(21, 'Aljhune Tinsmith', '', 1),
(22, 'Alkane Chemicals', '', 1),
(23, 'All Batteries ', '30 days', 1),
(24, 'Alliance Hardware Inc.', '30 days', 1),
(25, 'Almich Marketing ', '', 1),
(26, 'Alpha Office Equipment Center', '30 days', 1),
(27, 'AL Saberon / LBS', '', 1),
(28, 'Amici Water Systems Sales & Services', '30 days', 1),
(29, 'Amon Marketing', '', 1),
(30, 'Anako Phil. Corp. ', '30 days', 1),
(31, 'AP Cargo Logistics Network Corp.', '', 1),
(32, 'APG Engineering ', '', 1),
(33, 'Apo - Cemex ', '30 days', 1),
(34, 'Apo Cement Corp. ', '30 days', 1),
(35, 'Apple\'s Ink Trading', '30 days', 1),
(36, 'Architechnologies, Inc.', '', 1),
(37, 'Asia Glass ', '', 1),
(38, 'Asia Industries Material Handling Equip\'t Corp.', '', 1),
(39, 'Asia Pacific Computers ', '', 1),
(40, 'Asia Pacific Safety & Indt\'l Supply Inc.', '', 1),
(41, 'Asian Alloy Gen. Sales Inc. ', '', 1),
(42, 'Asian Home Appliance Center Company', '', 1),
(43, 'Asian Wirings Systems ', '30 days', 1),
(44, 'Asia\'s Best Industrial Sales Corporation', '30 days', 1),
(45, 'Asiatic Carpet Shoppe & Services', '', 1),
(46, 'Atlas Bolt & Supply ', '', 1),
(47, 'Atlas Metal Industries ', '', 1),
(48, 'Automation Security Inc. (ASI)', '', 1),
(49, 'Avantrac Heavy Machinery Inc.', '', 1),
(50, 'AVD Marketing', '', 1),
(51, 'AVK Phils.', '', 1),
(52, 'AWS Distribution Phils. Corp.', '30 days', 1),
(53, 'B. Benedicto And Sons ', '30 days', 1),
(54, 'Banilad Cebu Trade Center', '', 1),
(55, 'Belle Cebu Fuel Express', '30 days', 1),
(56, 'Belmont Industrial Supply', '30 days', 1),
(57, 'Belmont Hardware Cebu', '30 days', 1),
(58, 'Belmont Hardware Mandaue', '30 days', 1),
(59, 'Benter N Cutter ', '', 1),
(60, 'BEPL Mktg. & Services ', '', 1),
(61, 'Berovan Mrtg. Inc.', '30 days', 1),
(62, 'Beyond Global Multisales Corp.', '', 1),
(63, 'BG Filmaco', '', 1),
(64, 'BF Alabang Trading ', '', 1),
(65, 'Blackstone Techno Power', '', 1),
(66, 'Blackhawk USA', '', 1),
(67, 'Biometrix Systems & Trading Corp.', '', 1),
(68, 'Bordeos Heavy Equipment ', '', 1),
(69, 'Bravski Trading ', '30 days', 1),
(70, 'Bright Lamps and Style ', '', 1),
(71, 'Brixton Construction & Ind. Supply Inc.', '', 1),
(72, 'Bryon Industrial Sales & Services', '30 days', 1),
(73, 'Bticino Philippines, Inc. ', '', 1),
(74, 'Budget Builders', ' 30 days', 1),
(75, 'Bussbar Corp.', '', 1),
(76, 'Cabahug Ornamental and Flower Shop', '30 days', 1),
(77, 'Card Company of Cebu, Inc.', '30 days', 1),
(78, 'Capitol Steel Corp. ', '', 1),
(79, 'Cathay Hardware', '', 1),
(80, 'Cathay Pacific Steel Corp. ', '', 1),
(81, 'CBX ', '', 1),
(82, 'CBX Corporation ', '', 1),
(83, 'Cebu Ad Consultants', '30 days', 1),
(84, 'Cebu Atlantic Hardware', '30 days', 1),
(85, 'Cebu Belmont Hardware', '30 days', 1),
(86, 'Cebu Bionic Builder Supply Inc.', '30 days', 1),
(87, 'Cebu Bolt  & Screw Sales', '30 days', 1),
(88, 'Cebu Bolt Center Corp.', '30 days', 1),
(89, 'Cebu Business Material Trading', '', 1),
(90, 'Cebu Cable International', '30 days', 1),
(91, 'Cebu Champion Hardware & Electrical', '30 days', 1),
(92, 'Cebu Comm Electronics Center', '', 1),
(93, 'Cebu Digital Domain Marketing', '30 days', 1),
(94, 'Cebu Digitools/NL3K Corp.', '30 days', 1),
(95, 'Cebu Eco-Thermal Horizon Inc.', '30 days', 1),
(96, 'Cebu Educational Supply', '', 1),
(97, 'Cebu Electrical ', '', 1),
(98, 'Cebu Ever Global Marketing', '30 days', 1),
(99, 'Cebu Evergreen Enterprises', '30 days', 1),
(100, 'Cebu Evergreen Industries Inc.', '30 days', 1),
(101, 'Cebu Furnitech Marketing Inc.', '', 1),
(102, 'Cebu GL Safety Product', '', 1),
(103, 'Cebu Home (AS FORTUNA)', '30 days', 1),
(104, 'Cebu Home Builders Centre', '30 days', 1),
(105, 'Cebu Ink Toner Well Sales & Services', '', 1),
(106, 'Cebu Iron Foundry Corp.', '30 days', 1),
(107, 'Cebu Lucky Machinery', '90 days', 1),
(108, 'Cebu NL3K Corp.', '30 days', 1),
(109, 'Cebu Oversea Hardware', '60 days', 1),
(110, 'Cebu Power  Alliance', '', 1),
(111, 'Cebu Powertrade', '', 1),
(112, 'Cebu Progress Commercial', '', 1),
(113, 'Cebu Protrade Industrial Corp.', '30 days', 1),
(114, 'Cebu Royal Traders', '30 days', 1),
(115, 'Cebu Sherilin Trading Corp.', '', 1),
(116, 'Cebu Titan Surplus', '', 1),
(117, 'Cebu Top Ten Sales', '30 days', 1),
(118, 'Cebu Tristar Corp.', '30 days', 1),
(119, 'Cebu Vazcom', '', 1),
(120, 'Cebuano Hardware', '30 days', 1),
(121, 'Cemex', '', 1),
(122, 'Cemex Service Center', '', 1),
(123, 'CENIT Wholesaler', '', 1),
(124, 'Central Lumber Corp.', '90 days', 1),
(125, 'Central Philippines Marketing Corp. ', '30 days', 1),
(126, 'Centron Energy Savings Technology Corp.', '', 1),
(127, 'Century Spring', '', 1),
(128, 'Chain Glass Ent. Inc.', '', 1),
(129, 'Charmaine Olivares Const. Supply', '', 1),
(130, 'Chem Search', '', 1),
(131, 'Cigin Cons & Dev. Corp.', '', 1),
(132, 'Citi Appliance ', '', 1),
(133, 'Classic Colors Enterprises', '', 1),
(134, 'Classic Touch Ventures', '', 1),
(135, 'CLFG Inc.', '', 1),
(136, 'Cleaning Solutions ', '30 days', 1),
(137, 'CM Tradepacific', '', 1),
(138, 'Co Ban Kiat Hardware Inc. ', '30 days', 1),
(139, 'Colt Express Trade & Sales Inc.', '', 1),
(140, 'Comer Industrial Develoment Inc.', '', 1),
(141, 'Comfac Corp.', '', 1),
(142, 'Conprotec Construction & Supply', '', 1),
(143, 'Copylandia (Ayala branch)', '', 1),
(144, 'Coquilla Surplus ', '', 1),
(145, 'Corrchem Inc.', '30 days', 1),
(146, 'Corrtech Inc.', '', 1),
(147, 'Cosine Industries ', '', 1),
(148, 'Cosmetech', '', 1),
(149, 'Crest Forwarder Inc.', '', 1),
(150, 'Crest Sun Industrial Products Inc. ', '', 1),
(151, 'Crown Central ', '30 days', 1),
(152, 'Cuandro Ocho Inc.', '', 1),
(153, 'Cut & Break Diamond Products Inc. (HUSQVARNA)', '', 1),
(154, 'D.B International Sales & Services', '', 1),
(155, 'D Five Stainless Works', '', 1),
(156, 'Davies (CEBU)', '', 1),
(157, 'Dell88 Power Systems Corp.', '', 1),
(158, 'Delos Santos Housing Supply', '', 1),
(159, 'Denovo Express Endeavors Corp.', '', 1),
(160, 'Di-Catalyst Int\'l Corp.', '', 1),
(161, 'Diamond Interior Ind. Corp.', '', 1),
(162, 'Digital Domain', '', 1),
(163, 'DN Distribution Center Inc.', '', 1),
(164, 'Double M Electrical', '', 1),
(165, 'Dwightsteel', '', 1),
(166, 'Ebarra Pumps Phils. Inc.', '', 1),
(167, 'EC Ventic Enterprises Corporation', '30 days', 1),
(168, 'Easy Gas Convenience Store', '', 1),
(169, 'Eastern Wire Manufacturing', '', 1),
(170, 'Eastman Industrial Supply, Inc.', '', 1),
(171, 'EBG', '', 1),
(172, 'Echo Appliance Center', '', 1),
(173, 'Echo Electrical Supply', '', 1),
(174, 'Ecogreenhab', '', 1),
(175, 'Econtech', '', 1),
(176, 'Econtech (Manila)', '', 1),
(177, 'Edcon Glass & Aluminum Inc.', '30 days', 1),
(178, 'Edison Enterprises', '', 1),
(179, 'EDMI Phils.', '30 days', 1),
(180, 'Electrochem', '', 1),
(181, 'Elite Construction Supply', '', 1),
(182, 'Embryo Trading Corp.', '', 1),
(183, 'Emcor Appliance', '', 1),
(184, 'EMCOR Incorporated', '', 1),
(185, 'Emman Tinshop', '', 1),
(186, 'Emwood Trading', '', 1),
(187, 'Enlon Philippines Corp. ', '', 1),
(188, 'ENN Ind\'t  Sales & Services', '', 1),
(189, 'Environair Asia, Inc', '', 1),
(190, 'ENYE LTD. Corp.', '', 1),
(192, 'Escano Lines', '', 1),
(193, 'ETS (Equipment Technical Services)', '', 1),
(194, 'Eustaquio Enterprise ', '', 1),
(195, 'Ever Global Mktg.', '30 days', 1),
(196, 'Ever HRI Sales', '', 1),
(197, 'Exa Sales International', '', 1),
(198, 'Fast Autoworld ', '', 1),
(199, 'FBL Blocks', '30 days', 1),
(200, 'Federal North Hardware', '', 1),
(201, 'Filipino Metals Corp.', '', 1),
(202, 'Filmon Finishing Studio', '', 1),
(203, 'Filmon Hardware', '30 days', 1),
(204, 'Fine Impression', '', 1),
(205, 'Fins & Frost Enterprises', '', 1),
(206, 'First HI-Ace', '', 1),
(207, 'First Tank', '', 1),
(208, 'Fischer Fixing System', '', 1),
(209, 'Floreem Signs Depot', '', 1),
(210, 'Formaply Industries Inc.', '', 1),
(211, 'Fortress Electrical Supply', '', 1),
(212, 'Fortsteel', '', 1),
(213, 'Fotoline Express Supply', '', 1),
(214, 'Freysinnet Filipinas', '', 1),
(215, 'Gadiell Painting Works Inc.', '', 1),
(216, 'Gaisano Capital', '', 1),
(217, 'Garden Gear & Lanscape ', '', 1),
(218, 'Generous Eng\'g Works', '', 1),
(219, 'Gere Enterprises', '', 1),
(220, 'Geo Transport & Cons Inc.', '', 1),
(221, 'Gerome Phils.', '', 1),
(222, 'Gift of God Engraving', '', 1),
(223, 'Global Building Materials Mktg. Corp.', '', 1),
(224, 'Global Dimension', '', 1),
(225, 'Global Interiors', '', 1),
(226, 'Global Magic Wand', '', 1),
(227, 'Globe Home Interiors', '', 1),
(228, 'Globe Home Trading', '', 1),
(230, 'Go Em Lay Sons Company', '', 1),
(231, 'Golden Home Trading', '', 1),
(232, 'Golden Matsui Enterprises', '', 1),
(233, 'Golden Steel Construction Supply', '', 1),
(234, 'Gothong Cargo', '', 1),
(235, 'Gotesco Mktg.', '', 1),
(236, 'GP Hose & Airconditioning Supply Corp.', '', 1),
(237, 'Granite Industrial Corp. (first tank)', '', 1),
(238, 'Green Archer', '', 1),
(239, 'Green Leaf Entreprises', '', 1),
(240, 'Greenlee CP Elect. Corp.', '', 1),
(241, 'Grundos Pumps (Phils)', '', 1),
(242, 'Gud Moto Trading', '', 1),
(243, 'Gyro Steel', '', 1),
(244, 'H & E Industries Inc. /Ongkingking', '', 1),
(245, 'Hafele Phils.', '', 1),
(246, 'Halsangz Plating Cebu Corp.', '', 1),
(247, 'Hamil Enterprises', '', 1),
(248, 'Hammerluck ', '', 1),
(249, 'HAP Metal Fabricators', '', 1),
(250, 'Hardware Hauz', '', 1),
(251, 'Hawk Trading', '30 days', 1),
(252, 'Heinar Traders Corporation ', '30 days', 1),
(253, 'Hello Marketing', '30 days', 1),
(254, 'Hesreal Development Corp.', '30 days', 1),
(255, 'High Precision Power Electro ', '30 days', 1),
(256, 'Hilti Phils. Inc', '30 days', 1),
(257, 'Hitachi', '', 1),
(258, 'Hitech Hardware & Electrical Supply Inc.', '30 days', 1),
(259, 'Hitech Supplies & Packaging', '30 days', 1),
(260, 'Hive', '', 1),
(261, 'HLRD Marketing', '', 1),
(262, 'HMLT / MLT Marketing', '30 days', 1),
(263, 'Hotong Hardware', '', 1),
(264, 'HTU Distributors Inc.', '', 1),
(265, 'HQT Science & Technology, Inc.', '', 1),
(266, 'Hydrotek Inc.', '', 1),
(267, 'I Jet Trans Forwarder', '', 1),
(268, 'I Solutions International Inc.', '', 1),
(269, 'Istore SM ', '', 1),
(270, 'IBM Hollowblocks ', '', 1),
(271, 'IBM Machine Blocks Concrete Product, Inc.', '', 1),
(272, 'IEEI/ International Elevator', '', 1),
(273, 'Igros Marketing', '', 1),
(274, 'Ikkinari Enterprises', '', 1),
(275, 'Inca Phils. Inc.', '', 1),
(276, 'Infonet Solutions', '', 1),
(277, 'Integrated Computer System', '', 1),
(278, 'Integrated Security & Automation Inc.', '', 1),
(279, 'International Masagana Corporation', '', 1),
(280, 'Interphil Marketing', '', 1),
(281, 'I-trade', '', 1),
(282, 'JB Music (SM)', '', 1),
(283, 'J.Ceramics & Garden Accents', '', 1),
(284, 'Jades Cargo Forwarder', '', 1),
(285, 'Jaho Hardware', '', 1),
(286, 'Jaman Products Inc.', '', 1),
(287, 'Jaydee Trading', '', 1),
(288, 'JB Rock Garden', '', 1),
(289, 'Jea Steel  Industries Inc.', '', 1),
(290, 'Jet Water Systems', '', 1),
(291, 'JF Truck Parts & Center ', '', 1),
(292, 'JFA Car Aircons Services', '', 1),
(293, 'JGH Business Solutions ', '', 1),
(294, 'JIB Industrial & Autoparts', '', 1),
(295, 'Jim\'s Enterprises ', '', 1),
(296, 'JJED Phils.', '', 1),
(297, 'JKA Marketing', '', 1),
(298, 'JMD International Corp. ', '', 1),
(299, 'JMS Enterprises', '', 1),
(300, 'Jowood Industries Inc.', '', 1),
(301, 'JRA ', '', 1),
(302, 'JRJ Solutions Enterprises ', '', 1),
(303, 'JRS Express- GORORDO', '', 1),
(304, 'Jumbolon Phils. Inc.', '', 1),
(305, 'Juasing Hardware Inc.', '', 1),
(306, 'JVF Commercial', '', 1),
(307, 'JVS Audio System ', '', 1),
(308, 'JY All Boards', '', 1),
(309, 'JYU Enterprises ', '', 1),
(310, 'Kapper Phils.', '', 1),
(311, 'K & T Home Planners and Gen. Contractor', '', 1),
(312, 'Katipunan Lumber', '', 1),
(313, 'Ker & Company', '', 1),
(314, 'Keylinks (P.P.E)', '', 1),
(315, 'Kima Glass Supply', '30 days', 1),
(316, 'King Global Trading ', '30 days', 1),
(317, 'Kingscraft Fine Furniture Inc.', '', 1),
(318, 'Kitchen Gallery (TW & Co. Inc.)', '', 1),
(319, 'Konsult Water', '', 1),
(320, 'Kruger M & E Industries Corp.', '', 1),
(321, 'Krystel Marketing', '', 1),
(322, 'Kudu3 Enterprises (TENAX)', '', 1),
(323, 'Kumwell Exothermic Welding', '', 1),
(324, 'Kyolite Cebu Inc.', '', 1),
(325, 'Kulas', '', 1),
(326, 'KUS Architectural Components, Inc.', '', 1),
(328, 'Lantro Vision', '', 1),
(329, 'Leciann Ventures Inc. Shell', '', 1),
(330, 'Lenwoon Air Systems Engineering', '', 1),
(331, 'Lik-lik Barilan', '', 1),
(332, 'Litecrete Corp.', '', 1),
(333, 'Living \'n Style', '', 1),
(334, 'L\'rih Enterprises Corp.', '', 1),
(335, 'Lixil Philippines Ltd. Co', '30 days', 1),
(336, 'LJ Industrial', '', 1),
(337, 'Maay Pool Supply and Equipment Center', '', 1),
(338, 'Machealth Depot Mktg.', '', 1),
(339, 'Mackent Enterprises', '', 1),
(340, 'Magellan Veneer', '', 1),
(341, 'Makati Foundry', '', 1),
(342, 'Mandaue Compressed Gases (Lapu Branch)', '', 1),
(343, 'Mandaue Compressed Gases (Mingla)', '', 1),
(344, 'Mandaue Compressed Gases Corp.-Canduman Branch', '', 1),
(345, 'Mandaue Foam Ind. Inc.', '', 1),
(346, 'Mandaue Foam Furniture Center', '', 1),
(347, 'Mandaue Fortune ', '', 1),
(348, 'Mandaue Printshop Corporation', '', 1),
(349, 'Manila Emperial - Manila ', '', 1),
(350, 'Manny Janero', '', 1),
(351, 'Mapecon Phils. Inc.', '', 1),
(352, 'Mariwasa (Manila)', '', 1),
(353, 'Mariwasa Siam Ceramics Inc.', '', 1),
(354, 'Matimco (wood)', '', 1),
(355, 'Mc Construction', '', 1),
(356, 'MC Construction (DORMA)', '', 1),
(357, 'Mcken Sales International Corp', '', 1),
(358, 'MCWD (Main)', '', 1),
(359, 'MCWD (Talamban)', '', 1),
(360, 'Medallaaj Architects Consultancy Services', '', 1),
(361, 'Medical Center Trading Corp. ', '', 1),
(362, 'Megasign Corporation ', '', 1),
(363, 'Mel Go ', '', 1),
(364, 'Merit Gas Network Corp./ Seaoil', '', 1),
(365, 'Merit Stainless Steel Inc.', '', 1),
(366, 'Mertro Sports - Lahug', '', 1),
(367, 'Metro Asia Corporation', '', 1),
(368, 'Metro Gaisano Colon', '', 1),
(369, 'Metro Retail Stores Group, Inc.', '', 1),
(370, 'Metrotech Steel Industries, Inc.', '', 1),
(371, 'MGMM Forwarder ', '', 1),
(372, 'MHECO', '', 1),
(373, 'MILOC', '', 1),
(374, 'Mit-Air Incorporated', '', 1),
(375, 'MJ Auto ID Corp.', '', 1),
(376, 'MMF Safety Glass Inc. ', '', 1),
(377, 'Mobelhaus Kitchen & Closet', '', 1),
(378, 'Modern Tech. Corp.', '', 1),
(379, 'Moduletech Rack Center ', '', 1),
(380, 'Monark Cat Equipment ', '', 1),
(381, 'MPC Trading', '', 1),
(382, 'MR. E. Enterprises', '', 1),
(383, 'MR Metal Industries Corp.', '', 1),
(384, 'MRC Mercantile', '', 1),
(385, 'MS Trucking', '', 1),
(386, 'Multimax Industries Corporation', '', 1),
(387, 'Murillo\'s Export International, Inc.', '', 1),
(388, 'Mustard Seed ', '', 1),
(389, 'My Lifestyle Studio', '', 1),
(390, 'Nature Works Landscaping', '', 1),
(391, 'NCH Phils. Inc.', '', 1),
(392, 'Need Ink Sales & Services', '', 1),
(393, 'Neltex (Manila)', '', 1),
(394, 'Newbridge Elec\'l Ent.', '', 1),
(395, 'New Datche Phils.', '', 1),
(396, 'New Datche Phils.- Mandaue branch', '', 1),
(397, 'New Interlock Sales & Services', '', 1),
(398, 'New Seaman Trade Center ', '', 1),
(399, 'New Yutek Hardware', '', 1),
(400, 'NG Khai Development Corp.', '', 1),
(401, 'Night Bright Asia Pacific ', '', 1),
(402, 'North and South Builders Supply', '', 1),
(403, 'One Elcar Mercantile Corporation', '', 1),
(404, 'Oliver Industrial Products', '', 1),
(405, 'Ollywood Trading ', '', 1),
(406, 'Optimum Eqpt Mngt & Exchange', '', 1),
(407, 'Orion Maxis', '', 1),
(408, 'Othman Phil. ', '', 1),
(409, 'Ottilie Mktg.', '', 1),
(410, 'Pacific Orient Winds Corp. (POWCO)', '', 1),
(411, 'Pacific Paint (Boysen) Philippines, Inc.', '30 days', 1),
(412, 'Paradigm Diversified Resources Inc.', '', 1),
(413, 'Pasajero Motors', '', 1),
(414, 'Paul Go', '', 1),
(415, 'Peoples Educational Supply', '', 1),
(416, 'Perfect Star Computer ', '', 1),
(417, 'Perri Carpets', '', 1),
(418, 'Petronne', '', 1),
(419, 'Phelps Dodge Phils.', '60 days', 1),
(420, 'Phil Span Carrier Corp.', '', 1),
(421, 'Phil Valve Manufacturing Co.', '', 1),
(422, 'Phil. Laminate ', '', 1),
(423, 'Phil. Laminates Inc.', '', 1),
(424, 'PhilBytes', '', 1),
(425, 'Philcopy Corp.', '', 1),
(426, 'Philips ', '', 1),
(427, 'Philips Electronics ', '', 1),
(428, 'Philmetal', '', 1),
(429, 'Phoenix Bldg. Systems Corp. ', '', 1),
(430, 'Pipe Master Corp.', '', 1),
(431, 'Power Systems Inc.', '', 1),
(432, 'Powersteel Hardware', '', 1),
(433, 'Premiere Interior Center ', '', 1),
(434, 'Premiere Laminates', '', 1),
(435, 'Prime Power Energic System Inc.', '', 1),
(436, 'Primex Trade Sales Inc.', '', 1),
(437, 'Primeworx Building Solutions', '', 1),
(438, 'Prince Surplus', '', 1),
(439, 'Princewarehouse Club', '', 1),
(440, 'Prisma Electrical Control Corp.', '30 days', 1),
(441, 'Puyat Steel', '', 1),
(442, 'QPS Computer Solutions ', '', 1),
(443, 'Quality Savers', '', 1),
(444, 'Queen\'s Pharmacy', '', 1),
(445, 'R.E.N. Arc Machine Shop', '', 1),
(446, 'Ramil Alfante ', '', 1),
(447, 'RAPID Forming Corp.', '', 1),
(448, 'RCP Manufacturing Co. Inc', '', 1),
(449, 'RCR Marketing & Services Phils.', '', 1),
(450, 'RCT Signs & Services', '', 1),
(451, 'RDT Industrial Sales Inc.', '', 1),
(452, 'REGAN Industrial Sales', '60 days', 1),
(453, 'Reja Construction', '30 days', 1),
(454, 'RENTOKIL', '', 1),
(455, 'Republic Corrugated Cartoons & Alcohol Inc.', '', 1),
(456, 'Reva Commercial Expo.', '', 1),
(457, 'Reyal Meis Ent.', '', 1),
(458, 'REY MIAYO (trading)', '', 1),
(459, 'Richwood Electrical & Industrial Corp.', '', 1),
(460, 'Ritebuild/ Sika', '', 1),
(461, 'RK Eustaquio Enterprises ', '', 1),
(462, 'RKF Industrial', '', 1),
(463, 'RMC (Rece Group) ', '', 1),
(464, 'RMD Kwikform Philippines Inc.', '', 1),
(465, 'RNW Pacific Pipes', '', 1),
(466, 'Romeo V. Austria Trading (RVA)', '', 1),
(467, 'Rockmaster Development Corp.', '30 days', 1),
(468, 'RPV Electro', '', 1),
(469, 'RVM Roofing & Construction', '', 1),
(470, 'Sanitary Care Products Asia Inc.', '', 1),
(471, 'S.A Styropor', '', 1),
(472, 'Salazar Topcon Surveying Instruments', '', 1),
(473, 'San-Vic Traders', '', 1),
(474, 'Sarkchemicals Manufacturing Phils.', '', 1),
(475, 'Scanwolf Phil.', '30 days', 1),
(476, 'SCG Smartboard ', '', 1),
(477, 'Sea Road Trading', '', 1),
(478, 'Sealbond Chemical Industries Inc. ', '', 1),
(479, '', '', 0),
(480, 'Security & Systems Monitoring Inc. (SSMI)', '', 1),
(481, 'Seaman Trade Center', '', 1),
(482, 'Sheridan Marketing Inc.', '', 1),
(483, 'Shekinah Tech.', '', 1),
(484, 'Shurebright Elec. Supply', '', 1),
(485, 'Siccion Marketing Inc.', '', 1),
(486, 'Siccion Marketing Inc.- Cebu', '', 1),
(487, 'Sigma Foundry', '', 1),
(488, 'Signal Trading Corporation', '', 1),
(489, 'SIKA Phil. Inc. (Right Build)', '', 1),
(490, 'Sistem Cusina', '', 1),
(491, 'Soundroom Corp.', '', 1),
(492, 'Soonest Global', '', 1),
(493, 'South East Gate Phils.', '', 1),
(494, 'Southern Star Aluminum', '', 1),
(495, 'Spanasia ', '', 1),
(496, 'Sparkton Construction Supplies', '', 1),
(497, 'Specialized Bolt Center', '30 days', 1),
(498, 'Spectrum', '', 1),
(499, 'Speedy Tires Inc.', '', 1),
(500, 'Sportfit Inc. ', '', 1),
(501, 'Spurway ', '', 1),
(502, 'Squares & Linears', '', 1),
(503, 'SSI Metal Corp. ', '', 1),
(504, 'St. Raymund Trading', '', 1),
(505, 'Steelasia Manufacturing Corporation-Cebu', '30 days', 1),
(506, 'Steelasia Manufacturing Corporation-Manila', '', 1),
(507, 'Stitches & Wear Industries', '30 days', 1),
(508, 'Sulpicio Lines Inc.', '', 1),
(509, 'Summit Global Bidg Prdct Inc. ', '', 1),
(510, 'Summit Granite', '', 1),
(511, 'Summit Pacific Phil. Inc. (surelock)', '', 1),
(512, 'Sun Gold ', '', 1),
(513, 'Suncare Trading ', '', 1),
(514, 'Sycwin Coating & Wires Inc.', '', 1),
(515, 'Tades Cargo Services, Inc. ', '', 1),
(516, 'Tavaris Int\'l Inc.', '', 1),
(517, 'Techniquep ', '', 1),
(518, 'Techno Trade Resources', '', 1),
(519, 'TFE Sales Marketing Corp.', '', 1),
(520, 'The First Family Appliance Circle Corp.', '', 1),
(521, 'The Fourth Dimension Inc.', '', 1),
(522, 'The Hive ', '', 1),
(523, 'The LINDE Group', '', 1),
(524, 'Thinking Tools', '', 1),
(525, 'TIC International Inc. ', '', 1),
(526, 'Timex (Joy Pallones)', '', 1),
(527, 'Tinguan Trading Corp.', '', 1),
(528, 'Tokyo Hardware', '', 1),
(529, 'Toner Pro Trading ', '', 1),
(530, 'Tool Aide (Bosch Service Center)', '', 1),
(531, 'Topphand Ent.', '', 1),
(532, 'Trends and Technologies Inc.', '', 1),
(533, 'Tri-Jaguar', '', 1),
(534, 'Tristar Paints', '', 1),
(535, 'TRIMCOR (Triumph Machinery Corp.)', '', 1),
(536, 'Trinity Dynamics Inc.', '', 1),
(537, 'Tro Works Engineering Supply & Services', '', 1),
(538, 'Twin Bee Print Ads Corp.', '', 1),
(539, 'Tyval Industrial Supply', '', 1),
(540, 'U-Bix', '', 1),
(541, 'Ultra Petronne ', '', 1),
(542, 'UHM Son\'s Group', '', 1),
(543, 'Unichem Industrial Sales Inc.', '', 1),
(544, 'Unifield Enterprises Inc.', '45 days', 1),
(545, 'Unotel Electronics Inc.', '', 1),
(546, 'United Bearing Industrial Corp.', '', 1),
(547, 'Value Builders', '', 1),
(548, 'Veggie Mart (Oil)', '', 1),
(549, 'Vescorp International Trading ', '', 1),
(550, 'VGME Trading Corp.', '', 1),
(551, 'Vic Enterprises', '', 1),
(552, 'Vic Enterprises/Cement', '', 1),
(553, 'Visayan Educational Supplies', '', 1),
(554, 'Vincent Bathroom Clinic Repair', '', 1),
(555, 'Wacker Machines Supplies Corporation', '', 1),
(556, 'Washington Electrical & Industrial Supply', '', 1),
(557, 'Weld Industrial Sales', '30 days', 1),
(558, 'West Coast Security Solutions ', '', 1),
(559, 'White Gold Club', '', 1),
(560, 'Wheelmasters Corp.', '30 days', 1),
(561, 'Wired Systems Corp.', '30 days', 1),
(562, 'Wilcon Builders Depot Inc. (Mandaue)', '30 days', 1),
(563, 'Wilcon Builders Depot Inc. (Talisay)', '', 1),
(564, 'Williams Commercial', '', 1),
(565, 'Winner Motors & Industrial Sales', '', 1),
(566, 'World Home Depot ', '', 1),
(567, 'Worldwide Home Depot', '', 1),
(568, 'Worlwide Interiors', '', 1),
(569, 'Xcomp Computer Sales & Services', '', 1),
(570, 'Xenon Commercial', '', 1),
(571, 'Y2 Chem Industrial Sales', '', 1),
(572, 'Yale Hardware Corp.', '30 days', 1),
(573, 'Yandiesel Marketing ', '', 1),
(574, 'Yes Marketing', '30 days', 1),
(575, 'PRD Prime Concert & Design', '30 days', 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `username`, `password`, `logcount`, `access`, `status`) VALUES
(1, 'Elmar', 'Malazarte', 'elmar.malazarte@innogroup.com.ph', 'elmar.malazarte', 'e10adc3949ba59abbe56e057f20f883e', 0, 4, 1),
(2, 'May Flor', 'Zafra', 'may.zafra@innogroup.com.ph', 'may.zafra', 'e10adc3949ba59abbe56e057f20f883e', 0, 1, 1),
(3, 'Faye Ann', 'Tejamo', 'faye.tejamo@innogroup.com.ph', 'faye.tejamo', 'e10adc3949ba59abbe56e057f20f883e', 0, 2, 1),
(4, 'Brigette', 'Trangia', 'brigette.trangia@innogroup.com.ph', 'brigette.trangia', 'e10adc3949ba59abbe56e057f20f883e', 0, 2, 1),
(5, 'Alberr', 'Soreno', 'alberr.soreno@innogroup.com.ph', 'alberr.soreno', 'e10adc3949ba59abbe56e057f20f883e', 0, 3, 1),
(6, 'John Karl', 'Morga', 'john.morga@innogroup.com.ph', 'john.morga', 'e10adc3949ba59abbe56e057f20f883e', 0, 3, 1),
(7, 'Chris Marie', 'Pepito', 'chrismarie.pepito@innogroup.com.ph', 'chris.pepito', 'e10adc3949ba59abbe56e057f20f883e', 0, 3, 1),
(8, 'Lady Jane', 'Saladaga', 'lady.saladaga@innogroup.com.ph', 'lady.saladaga', 'e10adc3949ba59abbe56e057f20f883e', 0, 3, 1),
(9, 'George', 'Mansueto', 'george.mansueto@innogroup.com.ph', 'george.mansueto', 'e10adc3949ba59abbe56e057f20f883e', 0, 3, 1),
(10, 'Madel', 'Senoran', 'madel.senoran@innogroup.com.ph', 'madel.senoran', 'e10adc3949ba59abbe56e057f20f883e', 0, 3, 1),
(11, 'Katrina', 'Butil', 'katrina.butil@innogroup.com.ph', 'katrina.butil', 'e10adc3949ba59abbe56e057f20f883e', 0, 2, 0),
(12, 'Carmela', 'Inocian', 'carmela.inocian@innogroup.com.ph', 'carmela.inocian', 'e10adc3949ba59abbe56e057f20f883e', 0, 4, 1),
(13, 'Elisa', 'Quezon', 'elisa.quezon@innogroup.com.ph', 'elisa.quezon', 'e10adc3949ba59abbe56e057f20f883e', 0, 4, 1),
(14, 'Louise', 'Tan', 'louise.tan@innogroup.com.ph', 'louise.tan', 'e10adc3949ba59abbe56e057f20f883e', 0, 5, 1),
(15, 'Charisse', 'Ibon', 'charisse.ibon@innogroup.com.ph', 'charisse.ibon', 'e10adc3949ba59abbe56e057f20f883e', 0, 5, 1),
(16, 'Anabelle', 'Ranolo', 'anabelle.ranolo@innogroup.com.ph', 'anabelle.ranolo', 'e10adc3949ba59abbe56e057f20f883e', 0, 6, 1),
(17, 'Mark', 'Yu', 'mark.yu@innogroup.com.ph', 'mark.yu', 'e10adc3949ba59abbe56e057f20f883e', 0, 7, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
