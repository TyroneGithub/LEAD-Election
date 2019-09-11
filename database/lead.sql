-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2019 at 03:18 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lead`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidate`
--

CREATE TABLE `candidate` (
  `candidate_id` int(200) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `position` int(200) NOT NULL,
  `party_list` int(200) NOT NULL,
  `vote` int(200) NOT NULL,
  `image` varchar(1024) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `candidate`
--



-- --------------------------------------------------------

--
-- Table structure for table `party_list`
--

CREATE TABLE `party_list` (
  `party_id` int(200) NOT NULL,
  `party_name` varchar(500) NOT NULL,
  `party_code` varchar(500) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `party_list`
--

INSERT INTO `party_list` (`party_id`, `party_name`, `party_code`, `active`) VALUES
(1, 'Franciscan Party', 'FP', 1),
(2, 'Marian Party', 'MP', 1);

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `position_id` int(200) NOT NULL,
  `pos_name` varchar(1024) NOT NULL,
  `pos_code` varchar(500) NOT NULL,
  `level` enum('7','8','9','10','11','12') NOT NULL,
  `winner` int(10) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`position_id`, `pos_name`, `pos_code`, `level`, `winner`, `active`) VALUES
(1, 'President', 'pres', '12', 1, 1),
(2, 'Vice President SHS', 'VPSHS', '12', 1, 1),
(3, 'Vice President JHS', 'VPJHS', '10', 1, 1),
(4, 'Record Officer (Gr. 11)', 'RcrdOff11', '11', 1, 1),
(5, 'Record Officer (Gr. 10)', 'RcrdOff10', '10', 1, 1),
(6, 'Finance Officer (Gr. 11)', 'Finance11', '11', 1, 1),
(7, 'Finance Officer (Gr. 9)', 'Finance9', '9', 1, 1),
(8, 'Bookkeeping Officer (Gr.9)', 'Bookkeeping9', '9', 1, 1),
(9, 'Bookkeeping Officer (Gr.8)', 'Bookkeeping8', '8', 1, 1),
(10, 'Human Relation and Communication Officer (Gr.8)', 'HR8', '8', 1, 1),
(11, 'Human Relation and Communication Officer (Gr.7)', 'HR7', '7', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `response`
--

CREATE TABLE `response` (
  `response_id` int(200) NOT NULL,
  `voter_id` varchar(1024) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `sched_id` int(200) NOT NULL,
  `drafting` int(1) NOT NULL,
  `election` int(1) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`sched_id`, `drafting`, `election`, `start_date`, `end_date`) VALUES
(1, 1, 0, '2019-07-14', '2019-07-14');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(200) NOT NULL,
  `level` enum('7','8','9','10','11','12') NOT NULL,
  `section_name` varchar(500) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `level`, `section_name`, `active`) VALUES
(1, '7', 'Joy', 1),
(2, '7', 'Hope', 0),
(3, '7', 'Faith', 1),
(4, '8', 'Humility', 1),
(5, '8', 'Fidelity', 1),
(6, '8', 'Minority', 1),
(7, '9', 'Obedience', 1),
(8, '9', 'Reverence', 1),
(9, '9', 'Perseverance', 1),
(10, '10', 'Justice', 1),
(11, '10', 'Counsel', 1),
(12, '10', 'Fortitude', 1),
(13, '11', 'Peace', 1),
(14, '11', 'Patience', 1),
(15, '11', 'Truth', 1),
(16, '12', 'Wisdom', 1),
(17, '12', 'Piety', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `section` int(200) NOT NULL,
  `role` varchar(500) NOT NULL,
  `password` varchar(1024) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `name`, `section`, `role`, `password`, `active`) VALUES
(1, '0500091', 'STA. MARIA, Tyrone Justin Ramos', 16, 'student', '$2y$10$WrS4FNMOpotmW6Bp/1fUEODOJHc37dY0N0MADMQwEsG/QWWGNZOii', 0),
(2, 'admin', 'admin', 0, 'admin', '$2y$10$EvOVK5hDPa2n5rrmhMVOCu3ik5a32K4DrM6VjxeBGAc.a1IM16k46', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidate`
--
ALTER TABLE `candidate`
  ADD PRIMARY KEY (`candidate_id`);

--
-- Indexes for table `party_list`
--
ALTER TABLE `party_list`
  ADD PRIMARY KEY (`party_id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `response`
--
ALTER TABLE `response`
  ADD PRIMARY KEY (`response_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`sched_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidate`
--
ALTER TABLE `candidate`
  MODIFY `candidate_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `party_list`
--
ALTER TABLE `party_list`
  MODIFY `party_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `position_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
  MODIFY `response_id` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `sched_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
