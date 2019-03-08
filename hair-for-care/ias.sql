-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2018 at 07:10 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ias`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `first_name`, `last_name`, `email`, `password`) VALUES
('A001', 'pansilu', 'nilaweera', 'pansilu@gmail.com', '6c7ca345f63f835cb353ff15bd6c5e052ec08e7a');

-- --------------------------------------------------------

--
-- Table structure for table `cashier`
--

CREATE TABLE `cashier` (
  `cashier_id` varchar(15) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cashier`
--

INSERT INTO `cashier` (`cashier_id`, `first_name`, `last_name`, `address`, `phone`, `email`, `password`) VALUES
('C001', 'mario', 'perera', '255 colombo 7', 777511456, 'mario@gmail.com', '58a8e242317395aae15c1255041c129c0a1e1b41');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `subject_id` varchar(10) NOT NULL,
  `student_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

CREATE TABLE `lecturers` (
  `lecturer_id` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` int(10) NOT NULL,
  `nic` varchar(10) NOT NULL,
  `email` text NOT NULL,
  `address` varchar(50) NOT NULL,
  `password` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`lecturer_id`, `first_name`, `last_name`, `phone`, `nic`, `email`, `address`, `password`) VALUES
('L001', 'Nipuna', 'Nagoda', 771234567, '753456789V', 'nago@gmail.com', '25/A flower rd,Kurunegala', 'ef37c66ef301a6c22b850af02685e6ca19ab6168');

-- --------------------------------------------------------

--
-- Table structure for table `lecturer_attendance`
--

CREATE TABLE `lecturer_attendance` (
  `attendance_id` int(100) NOT NULL,
  `lecturer_id` int(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lecture_hall`
--

CREATE TABLE `lecture_hall` (
  `hall_no` varchar(10) NOT NULL,
  `floor` text NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lecture_schedule`
--

CREATE TABLE `lecture_schedule` (
  `lecturer_id` varchar(50) NOT NULL,
  `hall_no` varchar(10) NOT NULL,
  `subject_id` varchar(50) NOT NULL,
  `time` text NOT NULL,
  `day` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `monthly_fee`
--

CREATE TABLE `monthly_fee` (
  `payment_id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `subject_id` varchar(50) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `monthly_fee`
--

INSERT INTO `monthly_fee` (`payment_id`, `student_id`, `subject_id`, `amount`, `timestamp`) VALUES
(4, '18E01', 'BFR', '1500', '2018-09-27 06:00:43'),
(5, '18E02', 'BFR', '1500', '2018-09-27 06:01:43'),
(13, '18E02', 'FA', '2500', '2018-09-27 10:11:15'),
(14, '18E01', 'Canada', '5', '2018-09-28 06:24:57');

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `slip_no` varchar(50) NOT NULL,
  `lecturer_id` varchar(10) NOT NULL,
  `amount` decimal(10,4) NOT NULL,
  `month` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `dob` date NOT NULL,
  `nic` varchar(20) NOT NULL,
  `phone` int(11) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `address`, `dob`, `nic`, `phone`, `email`, `password`) VALUES
('18E01', 'Samantha', 'Wijesekara', '251 1/2, Maha Mawatha, Colombo-5 ', '1998-06-19', '983456789V', 771234567, 'sama@gmail.com', '2439e0457579ab4fd962cbd80b9206aca794cc38'),
('18E02', 'Mihiri', 'Prarthna', '255/A Pasihena rd,Gampaha', '1996-09-17', '965872592V', 714856252, 'mihiri@gmail.com', 'c241e7b7811ffbe3faba5b193717a46f9643eab1'),
('12E45', 'Gaja', 'Man', 'dfbgfd', '1996-05-21', '123456788V', 778103123, 'abc@abc.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');

-- --------------------------------------------------------

--
-- Table structure for table `student_attendance`
--

CREATE TABLE `student_attendance` (
  `attendance_id` int(10) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_attendance`
--

INSERT INTO `student_attendance` (`attendance_id`, `student_id`, `timestamp`) VALUES
(1, 'l102', '2018-09-26 03:33:51'),
(2, '18E02', '2018-09-26 05:19:27'),
(3, '18E02', '2018-10-30 09:26:04'),
(4, '18E02', '2018-10-30 09:26:22');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` varchar(10) NOT NULL,
  `subject_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`) VALUES
('FA', 'Financial Accounting'),
('MGT', 'Management');

-- --------------------------------------------------------

--
-- Table structure for table `tutes`
--

CREATE TABLE `tutes` (
  `tute_no` int(30) NOT NULL,
  `tute_name` varchar(50) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tute_issue`
--

CREATE TABLE `tute_issue` (
  `tute_no` int(30) NOT NULL,
  `student_id` int(50) NOT NULL,
  `has_received` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tute_issuer`
--

CREATE TABLE `tute_issuer` (
  `tute_issuer_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tute_issuer`
--

INSERT INTO `tute_issuer` (`tute_issuer_id`, `first_name`, `last_name`, `email`, `password`) VALUES
('T001', 'nadeesha', 'pathiraja', 'nadeesha@gmail.com', '925a8db8803982a237226ac1062420e6d14fb2f8');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cashier`
--
ALTER TABLE `cashier`
  ADD PRIMARY KEY (`cashier_id`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`subject_id`,`student_id`);

--
-- Indexes for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD PRIMARY KEY (`lecturer_id`);

--
-- Indexes for table `lecturer_attendance`
--
ALTER TABLE `lecturer_attendance`
  ADD PRIMARY KEY (`attendance_id`,`lecturer_id`);

--
-- Indexes for table `lecture_hall`
--
ALTER TABLE `lecture_hall`
  ADD PRIMARY KEY (`hall_no`);

--
-- Indexes for table `lecture_schedule`
--
ALTER TABLE `lecture_schedule`
  ADD PRIMARY KEY (`lecturer_id`,`hall_no`,`subject_id`);

--
-- Indexes for table `monthly_fee`
--
ALTER TABLE `monthly_fee`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`slip_no`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD PRIMARY KEY (`attendance_id`,`student_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `tutes`
--
ALTER TABLE `tutes`
  ADD PRIMARY KEY (`tute_no`);

--
-- Indexes for table `tute_issue`
--
ALTER TABLE `tute_issue`
  ADD PRIMARY KEY (`tute_no`,`student_id`);

--
-- Indexes for table `tute_issuer`
--
ALTER TABLE `tute_issuer`
  ADD PRIMARY KEY (`tute_issuer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `monthly_fee`
--
ALTER TABLE `monthly_fee`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `student_attendance`
--
ALTER TABLE `student_attendance`
  MODIFY `attendance_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
