-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2022 at 03:36 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mdb_lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `mdblms_mcq`
--

CREATE TABLE `mdblms_mcq` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option_1` text NOT NULL,
  `option_2` text NOT NULL,
  `option_3` text NOT NULL,
  `option_4` text NOT NULL,
  `correct_answer` int(11) NOT NULL,
  `reason` text NOT NULL,
  `tags` text DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `datetime` datetime DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mdblms_trueorfalse`
--

CREATE TABLE `mdblms_trueorfalse` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `correct_answer` int(11) NOT NULL,
  `reason` text NOT NULL,
  `tags` text DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `datetime` datetime DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mdb_topic_content`
--

CREATE TABLE `mdb_topic_content` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `added_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mdb_topic_docs`
--

CREATE TABLE `mdb_topic_docs` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `doc` longblob DEFAULT NULL,
  `doc_type` varchar(80) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `added_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mdb_topic_videos`
--

CREATE TABLE `mdb_topic_videos` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `video_link` text NOT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `added_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mdblms_mcq`
--
ALTER TABLE `mdblms_mcq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdblms_trueorfalse`
--
ALTER TABLE `mdblms_trueorfalse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdb_topic_content`
--
ALTER TABLE `mdb_topic_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdb_topic_docs`
--
ALTER TABLE `mdb_topic_docs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdb_topic_videos`
--
ALTER TABLE `mdb_topic_videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mdblms_mcq`
--
ALTER TABLE `mdblms_mcq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdblms_trueorfalse`
--
ALTER TABLE `mdblms_trueorfalse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdb_topic_content`
--
ALTER TABLE `mdb_topic_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdb_topic_docs`
--
ALTER TABLE `mdb_topic_docs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdb_topic_videos`
--
ALTER TABLE `mdb_topic_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
