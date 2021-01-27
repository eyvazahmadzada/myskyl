-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 08, 2020 at 08:43 PM
-- Server version: 5.7.29-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weather`
--

-- --------------------------------------------------------

--
-- Table structure for table `qualitative_data_1`
--

CREATE TABLE `qualitative_data_1` (
  `weather_condition_id` int(11) NOT NULL,
  `weather_condition` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qualitative_data_1`
--

INSERT INTO `qualitative_data_1` (`weather_condition_id`, `weather_condition`) VALUES
(1, 'cold'),
(2, 'mild'),
(3, 'warm'),
(4, 'sunny'),
(5, 'chilly'),
(6, 'hot'),
(7, 'freezing');

-- --------------------------------------------------------

--
-- Table structure for table `qualitative_data_2`
--

CREATE TABLE `qualitative_data_2` (
  `humidity_id` int(11) NOT NULL,
  `humidity` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qualitative_data_2`
--

INSERT INTO `qualitative_data_2` (`humidity_id`, `humidity`) VALUES
(1, 'wet'),
(2, 'humid'),
(3, 'dry'),
(4, 'rainy'),
(5, 'soggy'),
(6, 'dank'),
(7, 'muggy');

-- --------------------------------------------------------

--
-- Table structure for table `qualitative_data_3`
--

CREATE TABLE `qualitative_data_3` (
  `wind_id` int(11) NOT NULL,
  `wind` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qualitative_data_3`
--

INSERT INTO `qualitative_data_3` (`wind_id`, `wind`) VALUES
(1, 'windy'),
(2, 'breezy'),
(3, 'blustery'),
(4, 'gusty'),
(5, 'blowy'),
(6, 'airy'),
(7, 'boisterous');

-- --------------------------------------------------------

--
-- Table structure for table `qualitative_data_4`
--

CREATE TABLE `qualitative_data_4` (
  `visibility_id` int(11) NOT NULL,
  `visibility` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qualitative_data_4`
--

INSERT INTO `qualitative_data_4` (`visibility_id`, `visibility`) VALUES
(1, 'clear'),
(2, 'conspicuous'),
(3, 'invisible'),
(4, 'detectable'),
(5, 'discernible'),
(6, 'fair'),
(7, 'clarion');

-- --------------------------------------------------------

--
-- Table structure for table `qualitative_data_5`
--

CREATE TABLE `qualitative_data_5` (
  `fog_id` int(11) NOT NULL,
  `fog` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qualitative_data_5`
--

INSERT INTO `qualitative_data_5` (`fog_id`, `fog`) VALUES
(1, 'hazy'),
(2, 'misty'),
(3, 'smoggy'),
(4, 'fuzzy'),
(5, 'murky'),
(6, 'soupy'),
(7, 'vague');

-- --------------------------------------------------------

--
-- Table structure for table `quantitative_data`
--

CREATE TABLE `quantitative_data` (
  `record_id` int(11) NOT NULL,
  `temprature_celsius` float NOT NULL,
  `humidity_percent` float NOT NULL,
  `air_pressure` float NOT NULL,
  `precipitation_percent` int(11) NOT NULL,
  `visibility` float NOT NULL,
  `cloud_cover_percent` int(11) NOT NULL,
  `record_date` date NOT NULL,
  `record_time` time NOT NULL,
  `wind_speed` int(11) NOT NULL,
  `fog_id` int(11) NOT NULL,
  `wind_id` int(11) NOT NULL,
  `visibility_id` int(11) NOT NULL,
  `humidity_id` int(11) NOT NULL,
  `weather_condition_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quantitative_data`
--

INSERT INTO `quantitative_data` (`record_id`, `temprature_celsius`, `humidity_percent`, `air_pressure`, `precipitation_percent`, `visibility`, `cloud_cover_percent`, `record_date`, `record_time`, `wind_speed`, `fog_id`, `wind_id`, `visibility_id`, `humidity_id`, `weather_condition_id`) VALUES
(1, 12, 59, 1011, 0, 16, 2, '2020-05-01', '16:00:00', 74, 1, 1, 1, 1, 1),
(2, 11, 15, 1015, 25, 15, 5, '2020-05-02', '16:00:00', 30, 2, 2, 2, 2, 2),
(3, 15, 10, 1017, 12, 15, 25, '2020-05-03', '16:00:00', 12, 3, 3, 3, 3, 3),
(4, 15, 12, 1018.2, 36, 8, 17, '2020-05-04', '16:00:00', 30, 4, 4, 4, 4, 4),
(5, 15.5, 32, 1019, 0, 7, 12, '2020-05-05', '16:00:00', 13, 5, 5, 5, 5, 5),
(6, 19, 14, 1020, 34, 6, 12, '2020-05-06', '16:00:00', 45, 6, 6, 6, 6, 6),
(7, 21, 25, 1015, 23, 13, 24, '2020-05-07', '16:00:00', 35, 7, 7, 7, 7, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `qualitative_data_1`
--
ALTER TABLE `qualitative_data_1`
  ADD PRIMARY KEY (`weather_condition_id`);

--
-- Indexes for table `qualitative_data_2`
--
ALTER TABLE `qualitative_data_2`
  ADD PRIMARY KEY (`humidity_id`);

--
-- Indexes for table `qualitative_data_3`
--
ALTER TABLE `qualitative_data_3`
  ADD PRIMARY KEY (`wind_id`);

--
-- Indexes for table `qualitative_data_4`
--
ALTER TABLE `qualitative_data_4`
  ADD PRIMARY KEY (`visibility_id`);

--
-- Indexes for table `qualitative_data_5`
--
ALTER TABLE `qualitative_data_5`
  ADD PRIMARY KEY (`fog_id`);

--
-- Indexes for table `quantitative_data`
--
ALTER TABLE `quantitative_data`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `fog_id` (`fog_id`),
  ADD KEY `wind_id` (`wind_id`),
  ADD KEY `visibility_id` (`visibility_id`),
  ADD KEY `humidity_id` (`humidity_id`),
  ADD KEY `weather_condition_id` (`weather_condition_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `qualitative_data_1`
--
ALTER TABLE `qualitative_data_1`
  MODIFY `weather_condition_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `qualitative_data_2`
--
ALTER TABLE `qualitative_data_2`
  MODIFY `humidity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `qualitative_data_3`
--
ALTER TABLE `qualitative_data_3`
  MODIFY `wind_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `qualitative_data_4`
--
ALTER TABLE `qualitative_data_4`
  MODIFY `visibility_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `qualitative_data_5`
--
ALTER TABLE `qualitative_data_5`
  MODIFY `fog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `quantitative_data`
--
ALTER TABLE `quantitative_data`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `quantitative_data`
--
ALTER TABLE `quantitative_data`
  ADD CONSTRAINT `quantitative_data_ibfk_1` FOREIGN KEY (`fog_id`) REFERENCES `qualitative_data_5` (`fog_id`) ON UPDATE RESTRICT ON DELETE RESTRICT,
  ADD CONSTRAINT `quantitative_data_ibfk_2` FOREIGN KEY (`wind_id`) REFERENCES `qualitative_data_3` (`wind_id`) ON UPDATE RESTRICT ON DELETE RESTRICT,
  ADD CONSTRAINT `quantitative_data_ibfk_3` FOREIGN KEY (`visibility_id`) REFERENCES `qualitative_data_4` (`visibility_id`) ON UPDATE RESTRICT ON DELETE RESTRICT,
  ADD CONSTRAINT `quantitative_data_ibfk_4` FOREIGN KEY (`humidity_id`) REFERENCES `qualitative_data_2` (`humidity_id`) ON UPDATE RESTRICT ON DELETE RESTRICT,
  ADD CONSTRAINT `quantitative_data_ibfk_5` FOREIGN KEY (`weather_condition_id`) REFERENCES `qualitative_data_1` (`weather_condition_id`) ON UPDATE RESTRICT ON DELETE RESTRICT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
