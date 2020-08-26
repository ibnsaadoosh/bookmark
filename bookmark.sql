-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 26, 2020 at 07:11 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookmark`
--

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE `folders` (
  `id` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL COMMENT 'If parent = 0 so no parent to it',
  `title` varchar(30) NOT NULL,
  `comment_section` text DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `folders`
--

INSERT INTO `folders` (`id`, `parent`, `title`, `comment_section`, `date`, `user_id`) VALUES
(23, NULL, 'Folder1', 'New folder', '2020-08-19 15:25:06', 9),
(24, NULL, 'Another folder', 'Bla bla bla', '2020-08-20 17:07:59', 9),
(30, NULL, 'Test folder', 'bla bla', '2020-08-26 15:59:21', 4),
(31, NULL, 'Test folder2', 'bla bla', '2020-08-26 16:00:22', 4),
(36, NULL, 'Lets test', 'Bla bla', '2020-08-26 16:04:51', 4),
(39, NULL, 'Custom folder', 'bla bla', '2020-08-26 16:10:18', 9);

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `id` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL COMMENT 'Parent of site (folder)',
  `link` varchar(255) NOT NULL,
  `title` varchar(30) NOT NULL,
  `comment_section` text DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`id`, `parent`, `link`, `title`, `comment_section`, `date`, `user_id`) VALUES
(5, NULL, 'www.google.com', 'Google', NULL, '2020-08-11 14:49:12', 3),
(8, NULL, 'https://www.google.com/', 'Link1', 'New link', '2020-08-19 15:40:47', 9),
(9, NULL, 'https://www.google.com/', 'Another link', 'Bla bla bla hhh', '2020-08-20 17:07:40', 9),
(10, 23, 'https://www.google.com/', 'Test link', '&#34;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi.', '2020-08-20 17:12:11', 9),
(11, 23, 'https://www.google.com/', 'New link 2', '&#34;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi', '2020-08-20 17:12:38', 9),
(12, 23, 'https://www.google.com/', 'Test test', 'bal bal', '2020-08-24 15:35:29', 9),
(13, NULL, 'https://www.google.com/', 'Custom link', 'bla bla', '2020-08-26 16:11:11', 9);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(30) DEFAULT NULL,
  `lastName` varchar(30) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT 'default.png' COMMENT 'Avatar of the user',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `username`, `password`, `email`, `image`, `date`, `ip`) VALUES
(3, 'Abdulaziz', 'Sayed', 'Saadoush', '123456', 'zero@gmail.com', 'default_avatar.jpg', '2020-07-25 12:44:40', NULL),
(4, 'newFirstName', 'Saad', 'newUsername', '123456', 'saadoush@gmail.com', 'default_avatar.jpg', '2020-07-26 13:38:04', NULL),
(5, 'testt', 'testt', 'zozozoss555zoz', 'testttttttttt5555', 'test@saad.com', 'default_avatar.jpg', '2020-07-26 15:06:49', NULL),
(7, 'asdfadfasdfa', 'asdfadfasdfsdf', 'Khaled550', '$2y$10$UNmfIS0XDG5UITU4tyuf2..xBu/Oh.tFV0xC1X63mFLM5ERJy1zE.', 'test@gmail.com', 'default_avatar.jpg', '2020-07-26 15:31:46', NULL),
(8, NULL, NULL, 'AbdoBallo', '$2y$10$cHMmSLnovT2uSjHdZFzDWuz2FnBbftCPtJEcexAhtSOX667fyBCqq', 'ballo@gmail.com', NULL, '2020-08-09 16:21:11', '::1'),
(9, 'Abdulaziz', 'Sayed', 'XAlienBeardX', '$2y$10$rKRxvogOyQGqgaGf3nqxPuTTLw16R8A4U8LApzLeKQSeWKEsv0cTW', 'zeroalzamalkawy515@gmail.com', '5580697722_IMG_9783.JPG', '2020-08-09 20:05:22', '::1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_id_folders` (`user_id`),
  ADD KEY `fk_parent_folder2` (`parent`);

--
-- Indexes for table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_id` (`user_id`),
  ADD KEY `fk_parent_folder` (`parent`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `folders`
--
ALTER TABLE `folders`
  ADD CONSTRAINT `fk_parent_folder2` FOREIGN KEY (`parent`) REFERENCES `folders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_id_folders` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sites`
--
ALTER TABLE `sites`
  ADD CONSTRAINT `fk_parent_folder` FOREIGN KEY (`parent`) REFERENCES `folders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
