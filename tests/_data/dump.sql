-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 25, 2016 at 09:40 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 7.0.3-9+deb.sury.org~trusty+3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testcms`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `article` varchar(10000) NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `article`, `created`) VALUES
(1, 'neils blog post', 'If you want to show the full text without a page reload you will have to use javascript/jquery. For that to work the full text has to be in the generated HTML.\n\nI did this by using 2 divs, one with the shortened text and one with the full text which is hidden by default. When \'read more\' is clicked I toggle both divs and change the link label to something like \'see less\'.\n\nYou could also put the not-shortened text as well as the ellipsis in an element like so:', '2016-02-17'),
(2, 'Some Worthy title', 'In this post I present the development model that I’ve introduced for some of my projects (both at work and private) about a year ago, and which has turned out to be very successful. I’ve been meaning to write about it for a while now, but I’ve never really found the time to do so thoroughly, until now. I won’t talk about any of the projects’ details, merely about the branching strategy and release management.', '2016-02-24');

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` int(10) NOT NULL,
  `name` text NOT NULL,
  `path` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `path`) VALUES
(1, 'default', '/css/defaulttheme.css'),
(2, 'blue', '/css/blue.css');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
