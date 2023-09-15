-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2023 at 12:28 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatify`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts_table`
--

CREATE TABLE `contacts_table` (
  `contact_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `accepter_id` int(11) NOT NULL,
  `sender_image` varchar(100) NOT NULL,
  `accepter_image` varchar(100) NOT NULL,
  `sender_name` varchar(100) NOT NULL,
  `accepter_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contacts_table`
--

INSERT INTO `contacts_table` (`contact_id`, `sender_id`, `accepter_id`, `sender_image`, `accepter_image`, `sender_name`, `accepter_name`) VALUES
(70, 24, 25, 'images/1672005605.jpg', 'images/1012468150.jpg', 'dania', 'ali123'),
(71, 23, 25, 'images/987791095.jpg', 'images/1012468150.jpg', 'maarij123', 'ali123'),
(72, 27, 26, 'images/1143723036.png', 'images/32169900.png', 'maarij', 'saim');

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `request_id` int(11) NOT NULL,
  `send_by` varchar(150) NOT NULL,
  `send_to` varchar(150) NOT NULL,
  `request_status` varchar(50) NOT NULL,
  `unfriended_by` varchar(50) NOT NULL,
  `request_time` varchar(40) NOT NULL,
  `send_date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`request_id`, `send_by`, `send_to`, `request_status`, `unfriended_by`, `request_time`, `send_date`) VALUES
(62, 'dania', 'maarij123', 'declined', 'dania', 'false', '2023-08-06'),
(63, 'ali123', 'maarij123', 'declined', 'ali', 'false', '2023-08-06'),
(64, 'ali123', 'dania', 'unfriended', 'ali', 'false', '2023-08-06'),
(65, 'ali123', 'dania', 'unfriended', 'ali', 'false', '2023-08-06'),
(66, 'dania', 'maarij123', 'unfriended', 'maarij', 'false', '2023-08-06'),
(67, 'dania', 'ali123', 'accepted', 'null', 'true', '2023-08-06'),
(68, 'maarij123', 'ali123', 'accepted', 'null', 'true', '2023-08-06'),
(69, 'maarij123', '', 'pending', 'null', 'true', '2023-08-20'),
(70, 'maarij123', '', 'pending', 'null', 'true', '2023-08-20'),
(71, 'maarij123', 'saim', 'declined', 'null', 'false', '2023-08-20'),
(72, 'maarij123', 'dania', 'declined', 'null', 'false', '2023-08-20'),
(73, 'maarij', 'saim', 'accepted', 'null', 'true', '2023-08-24'),
(74, 'haris', 'dania', 'declined', 'null', 'false', '2023-08-27'),
(75, 'haris', 'dania', 'declined', 'null', 'false', '2023-08-27');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `sender_username` varchar(50) NOT NULL,
  `receiver_username` varchar(50) NOT NULL,
  `message_text` varchar(200) NOT NULL,
  `dtetime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `sender_username`, `receiver_username`, `message_text`, `dtetime`) VALUES
(27, 'ali123', 'dania', 'hello dania', '2023-08-06 23:55:03'),
(28, 'dania', 'ali123', 'hello ali', '2023-08-07 00:18:01'),
(29, 'ali123', 'dania', 'kia haal hain', '2023-08-07 00:19:36'),
(30, 'dania', 'ali123', 'main thk tu suna\n', '2023-08-07 00:25:35'),
(31, 'maarij123', 'ali123', 'hi', '2023-08-07 00:36:22'),
(32, 'ali123', 'maarij123', 'kia haal hain', '2023-08-07 00:38:02'),
(33, 'maarij123', 'ali123', 'thk tu suna', '2023-08-07 00:52:17'),
(34, 'ali123', 'maarij123', 'main bhi thk jani', '2023-08-07 00:56:08'),
(35, 'ali123', 'dania', 'bs yr coding chal rahi hai', '2023-08-07 00:56:26'),
(36, 'dania', 'ali123', 'acha mera bhi yahi scene hai', '2023-08-13 11:55:29'),
(37, 'ali123', 'dania', 'same to same', '2023-08-13 11:55:52'),
(42, 'ali123', 'dania', 'images/1388307676.jpg', '2023-08-13 16:26:42'),
(44, 'dania', 'ali123', 'images/1232842792.pdf', '2023-08-13 16:33:33'),
(45, 'ali123', 'dania', 'thank you dania', '2023-08-13 16:43:28'),
(54, 'ali123', 'dania', 'bata', '2023-08-13 17:19:01'),
(55, 'dania', 'ali123', 'images/1287066156.jpg', '2023-08-20 20:28:01'),
(56, 'dania', 'ali123', 'images/1861766552.jpg', '2023-08-20 20:28:14'),
(57, 'dania', 'ali123', '', '2023-08-20 20:28:17'),
(58, 'dania', 'ali123', '', '2023-08-20 20:28:19'),
(59, 'dania', 'ali123', 'images/2105353484.jpg', '2023-08-20 20:30:07'),
(60, 'dania', 'ali123', 'hi', '2023-08-20 20:30:30'),
(61, 'dania', 'ali123', 'hi', '2023-08-21 14:56:42'),
(62, 'saim', 'maarij', 'hello', '2023-08-25 00:06:57'),
(63, 'saim', 'maarij', 'hello', '2023-08-25 00:07:31'),
(64, 'maarij', 'saim', 'hi', '2023-08-25 00:08:12'),
(65, 'dania', 'ali123', 'hi', '2023-08-28 02:19:39'),
(66, 'dania', 'ali123', 'hi', '2023-08-28 02:19:42'),
(67, 'dania', 'ali123', 'hi', '2023-08-28 02:19:43'),
(68, 'dania', 'ali123', '.', '2023-08-28 02:19:51');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `friend_request_id` int(11) NOT NULL,
  `notification_msg` varchar(100) NOT NULL,
  `notification_time` varchar(40) NOT NULL,
  `notification_date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `sender_id`, `friend_request_id`, `notification_msg`, `notification_time`, `notification_date`) VALUES
(6, 24, 23, 62, 'declined', 'false', '2023-08-06'),
(7, 25, 23, 63, 'declined', 'false', '2023-08-06'),
(8, 25, 24, 64, 'unfriended', 'false', '2023-08-06'),
(9, 25, 24, 65, 'unfriended', 'false', '2023-08-06'),
(10, 24, 23, 66, 'unfriended', 'false', '2023-08-06'),
(11, 24, 25, 67, 'accepted', 'true', '2023-08-06'),
(12, 23, 25, 68, 'accepted', 'true', '2023-08-06'),
(13, 23, 0, 69, 'pending', 'true', '2023-08-20'),
(14, 23, 0, 70, 'pending', 'true', '2023-08-20'),
(15, 23, 26, 71, 'declined', 'false', '2023-08-20'),
(16, 23, 24, 72, 'declined', 'false', '2023-08-20'),
(17, 27, 26, 73, 'accepted', 'true', '2023-08-24'),
(18, 31, 24, 74, 'declined', 'false', '2023-08-27'),
(19, 31, 24, 75, 'declined', 'false', '2023-08-27');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_location` varchar(130) NOT NULL,
  `user_image` varchar(200) NOT NULL,
  `user_register_date` varchar(200) NOT NULL,
  `account_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`user_id`, `user_name`, `user_email`, `user_password`, `user_location`, `user_image`, `user_register_date`, `account_status`) VALUES
(23, 'maarij123', 'ma@gmail.com', '$2y$10$nPa0bq2of/7xsJj3izHRpOz1regcU5PoeDd.nl/9Li93xm1OuSKay', 'Karachi , Pakistan', 'images/987791095.jpg', '2023-08-06', 'deleted'),
(24, 'dania', 'dania@gmail.com', '$2y$10$dAenzAas71xFhhwkGI2GKeh.M/Y62VkgJK8XIoaGxvh1ew5bx71Uq', 'Karachi , Pakistan', 'images/1672005605.jpg', '2023-08-06', 'active'),
(25, 'ali123', 'ali@gmail.com', '$2y$10$mQ2v2qWk47OwPJeFzlt2mO1PxBj3AB3BhENlCZ5VdfwNQpbUk.FMe', 'Karachi , Pakistan', 'images/1012468150.jpg', '2023-08-06', 'active'),
(26, 'saim', 's@gmail.com', '$2y$10$Oo.prhXjs92cEv5dbiflZOd6KRDJveGNX7jZ/7SpRfrBkHVIBsRa.', 'Karachi , Pakistan', 'images/32169900.png', '2023-08-11', 'active'),
(27, 'maarij', 'ma@gmail.com', '$2y$10$kUjWDrQn0azjC/0eVlZ7m.9FITRy2kQSlLcHiwFDOGoW8WygAHSMG', 'Karachi , Pakistan', 'images/1143723036.png', '2023-08-21', 'active'),
(30, 'abdullah', 'abdullah@gmail.com', '$2y$10$doMXr9oYwHta518Zr.2TY.Yjxpd8oKAd5qswG91MeVp0.HxbaV1pG', 'Karachi , Pakistan', 'images/246537056.png', '2023-08-25', 'active'),
(31, 'haris', 'haris@gmail.com', '$2y$10$3GwyFRdaVO4jswS0cZWPHOo7pafJTHGnaQ5R.ZoDpkmqEHIj003tG', 'Karachi , Pakistan', 'images/302105315.jpg', '2023-08-27', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts_table`
--
ALTER TABLE `contacts_table`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `user_request_id` (`sender_id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`sender_id`),
  ADD KEY `request_status` (`friend_request_id`),
  ADD KEY `login_id` (`user_id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts_table`
--
ALTER TABLE `contacts_table`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `signup`
--
ALTER TABLE `signup`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `login_id` FOREIGN KEY (`user_id`) REFERENCES `signup` (`user_id`),
  ADD CONSTRAINT `request_status` FOREIGN KEY (`friend_request_id`) REFERENCES `friend_requests` (`request_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
