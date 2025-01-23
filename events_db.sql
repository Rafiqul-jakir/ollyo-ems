-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2025 at 09:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `events_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendees`
--

CREATE TABLE `attendees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `registered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendees`
--

INSERT INTO `attendees` (`id`, `name`, `phone`, `event_id`, `user_id`, `registered_at`) VALUES
(6, 'Rafiqul Jakir', '01879074212', 29, 1, '2025-01-23 03:49:04'),
(7, 'Jon Doe', '018795285', 25, 1, '2025-01-23 04:19:10'),
(8, 'Jon miss', '018795285', 25, 1, '2025-01-23 04:19:23');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `max_capacity` int(11) NOT NULL,
  `event_date` datetime NOT NULL,
  `time` time NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `max_capacity`, `event_date`, `time`, `created_by`, `created_at`) VALUES
(25, 'Web3 Workshop', 'An introductory workshop on Web3 technologies.', 2, '2025-02-01 00:00:00', '10:00:00', 1, '2025-01-23 03:26:04'),
(26, 'PHP Masterclass', 'A hands-on PHP programming masterclass.', 30, '2025-02-03 00:00:00', '14:00:00', 1, '2025-01-23 03:26:04'),
(27, 'IoT Innovations', 'Exploring the latest IoT trends and innovations.', 40, '2025-02-05 00:00:00', '09:30:00', 1, '2025-01-23 03:26:04'),
(28, 'AI in Healthcare', 'How AI is transforming the healthcare industry.', 100, '2025-02-10 00:00:00', '11:00:00', 1, '2025-01-23 03:26:04'),
(29, 'Cloud Computing Basics', 'Understanding the fundamentals of cloud computing.', 60, '2025-02-12 00:00:00', '13:30:00', 1, '2025-01-23 03:26:04'),
(30, 'German Language Basics', 'Learn basic German phrases and grammar.', 25, '2025-02-15 00:00:00', '15:00:00', 1, '2025-01-23 03:26:04'),
(31, 'Blockchain for Beginners', 'An overview of blockchain and its applications.', 45, '2025-02-20 00:00:00', '10:30:00', 1, '2025-01-23 03:26:04'),
(32, 'Cybersecurity Essentials', 'Protecting yourself in the digital age.', 70, '2025-02-22 00:00:00', '16:00:00', 1, '2025-01-23 03:26:04'),
(33, 'Machine Learning 101', 'Introduction to machine learning concepts.', 35, '2025-02-25 00:00:00', '09:00:00', 1, '2025-01-23 03:26:04'),
(34, 'Open Source Contributions', 'How to contribute to open-source projects.', 50, '2025-02-28 00:00:00', '14:00:00', 1, '2025-01-23 03:26:04'),
(35, 'Mobile App Development', 'Workshop on building mobile apps using Flutter.', 60, '2025-03-01 00:00:00', '10:00:00', 1, '2025-01-23 06:46:19'),
(36, 'Big Data Analytics', 'Understanding and applying big data analytics.', 80, '2025-03-03 00:00:00', '13:30:00', 1, '2025-01-23 06:46:19'),
(37, 'Cloud Security', 'Best practices for securing cloud environments.', 50, '2025-03-05 00:00:00', '11:00:00', 1, '2025-01-23 06:46:19'),
(38, 'PHP Frameworks', 'Exploring popular PHP frameworks like Laravel and Symfony.', 40, '2025-03-08 00:00:00', '14:00:00', 1, '2025-01-23 06:46:19'),
(39, 'Digital Marketing Strategies', 'Effective strategies for digital marketing success.', 70, '2025-03-10 00:00:00', '09:30:00', 1, '2025-01-23 06:46:19'),
(40, 'Data Science with Python', 'Learning data science fundamentals using Python.', 90, '2025-03-12 00:00:00', '16:00:00', 1, '2025-01-23 06:46:19'),
(41, 'Agile Project Management', 'Managing projects effectively using Agile methodology.', 55, '2025-03-15 00:00:00', '10:30:00', 1, '2025-01-23 06:46:19'),
(42, 'JavaScript for Beginners', 'Introductory session on JavaScript programming.', 40, '2025-03-17 00:00:00', '13:00:00', 1, '2025-01-23 06:46:19'),
(43, 'Game Development with Unity', 'Creating interactive games with Unity game engine.', 30, '2025-03-20 00:00:00', '14:30:00', 1, '2025-01-23 06:46:19'),
(44, 'Smart Home Automation', 'Learn how to automate your home using IoT devices.', 60, '2025-03-22 00:00:00', '09:00:00', 1, '2025-01-23 06:46:19'),
(45, 'Virtual Reality Trends', 'Exploring the latest trends in virtual reality technology.', 50, '2025-03-25 00:00:00', '11:00:00', 1, '2025-01-23 06:48:11'),
(46, 'Introduction to SQL', 'Learn the basics of SQL database management and querying.', 45, '2025-03-28 00:00:00', '14:00:00', 1, '2025-01-23 06:48:11'),
(47, 'Ethical Hacking Workshop', 'Hands-on workshop on ethical hacking and penetration testing.', 40, '2025-03-30 00:00:00', '10:30:00', 1, '2025-01-23 06:48:11'),
(48, 'DevOps Practices', 'Implementing DevOps principles for efficient software development.', 60, '2025-04-02 00:00:00', '13:00:00', 1, '2025-01-23 06:48:11'),
(49, 'Introduction to APIs', 'How to work with APIs in modern web development.', 70, '2025-04-05 00:00:00', '15:00:00', 1, '2025-01-23 06:48:11'),
(50, 'Quantum Computing Fundamentals', 'An introduction to the principles of quantum computing.', 30, '2025-04-07 00:00:00', '10:00:00', 1, '2025-01-23 06:48:11'),
(51, 'UX/UI Design Basics', 'A workshop on user experience and interface design principles.', 50, '2025-04-10 00:00:00', '11:30:00', 1, '2025-01-23 06:48:11'),
(52, 'Blockchain Development', 'Hands-on session on building decentralized applications on blockchain.', 40, '2025-04-12 00:00:00', '14:30:00', 1, '2025-01-23 06:48:11'),
(53, 'Python for Data Analysis', 'Learn how to use Python for data analysis and visualization.', 90, '2025-04-15 00:00:00', '09:00:00', 1, '2025-01-23 06:48:11'),
(54, 'Introduction to Kubernetes', 'Learn the basics of Kubernetes for container orchestration.', 80, '2025-04-17 00:00:00', '13:30:00', 1, '2025-01-23 06:48:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Rafiqul Jakir', 'abc@gmail.com', '$2y$10$.JdCn6fUYjh7GWfjN4pLQeEXCrbgUsoES92QDb.RvMlW68jVJF2Z6', 'user', '2025-01-21 15:39:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendees`
--
ALTER TABLE `attendees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendees`
--
ALTER TABLE `attendees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendees`
--
ALTER TABLE `attendees`
  ADD CONSTRAINT `attendees_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendees_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
