-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2026 at 07:04 PM
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
-- Database: `cinema_management1`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `showtime_id` bigint(20) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_seats`
--

CREATE TABLE `booking_seats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `seat_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cinemas`
--

CREATE TABLE `cinemas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cinemas`
--

INSERT INTO `cinemas` (`id`, `name`, `location`) VALUES
(1, 'CineMax Downtown', '123 Main St, City Center'),
(2, 'CineMax Mall', '456 Shopping Plaza, Mall Level 3'),
(3, 'CineMax Luxury', '789 Premium Ave, Uptown');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Action'),
(2, 'Adventure'),
(3, 'Comedy'),
(4, 'Drama'),
(5, 'Fantasy'),
(6, 'Horror'),
(7, 'Romance'),
(8, 'Sci-Fi'),
(9, 'Thriller'),
(10, 'Animation');

-- --------------------------------------------------------

--
-- Table structure for table `halls`
--

CREATE TABLE `halls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cinema_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `halls`
--

INSERT INTO `halls` (`id`, `cinema_id`, `name`, `capacity`) VALUES
(1, 1, 'Hall 1', 100),
(2, 1, 'Hall 2', 100),
(3, 1, 'Hall 3', 100),
(4, 2, 'Hall 1', 100),
(5, 2, 'Hall 2', 100),
(6, 2, 'Hall 3', 100),
(7, 3, 'Hall 1', 100),
(8, 3, 'Hall 2', 100),
(9, 3, 'Hall 3', 100);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(65, '2026_03_18_091910_create_roles_table', 1),
(66, '2026_03_18_091929_create_users_table', 1),
(67, '2026_03_18_091939_create_genres_table', 1),
(68, '2026_03_18_091946_create_movies_table', 1),
(69, '2026_03_18_091952_create_cinemas_table', 1),
(70, '2026_03_18_092001_create_halls_table', 1),
(71, '2026_03_18_092009_create_seats_table', 1),
(72, '2026_03_18_092017_create_showtimes_table', 1),
(73, '2026_03_18_092024_create_bookings_table', 1),
(74, '2026_03_18_092031_create_bookings_seats_table', 1),
(75, '2026_03_18_092039_create_payments_table', 1),
(76, '2026_03_18_092046_create_tickets_table', 1),
(77, '2026_03_18_092053_create_reviews_table', 1),
(78, '2026_04_08_100024_create_sessions_table', 1),
(79, '2026_04_15_134500_add_updated_at_to_users_and_reviews_table', 1),
(80, '2026_04_15_135740_add_poster_to_movies_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `duration` int(11) NOT NULL,
  `release_date` date NOT NULL,
  `poster` varchar(255) DEFAULT NULL,
  `genre_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `description`, `duration`, `release_date`, `poster`, `genre_id`) VALUES
(1, 'Harry Potter and the Philosopher\'s Stone', 'An orphaned boy enrolls in a school of wizardry, where he learns the truth about himself, his family and the terrible evil that haunts the magical world.', 152, '2001-11-16', 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=400', 5),
(2, 'The Dark Knight', 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.', 152, '2008-07-18', 'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=400', 1),
(3, 'Inception', 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.', 148, '2010-07-16', 'https://upload.wikimedia.org/wikipedia/en/2/2e/Inception_%282010%29_theatrical_poster.jpg', 8),
(4, 'The Shawshank Redemption', 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.', 142, '1994-09-23', 'https://images.pexels.com/photos/7974/pexels-photo.jpg?auto=compress&cs=tinysrgb&w=400', 4),
(5, 'Pulp Fiction', 'The lives of two mob hitmen, a boxer, a gangster and his wife intertwine in four tales of violence and redemption.', 154, '1994-10-14', 'https://images.pexels.com/photos/1170412/pexels-photo-1170412.jpeg?auto=compress&cs=tinysrgb&w=400', 9),
(6, 'The Lord of the Rings: The Fellowship of the Ring', 'A meek Hobbit from the Shire and eight companions set out on a journey to destroy the powerful One Ring and save Middle-earth from the Dark Lord Sauron.', 178, '2001-12-19', 'https://images.pexels.com/photos/3945683/pexels-photo-3945683.jpeg?auto=compress&cs=tinysrgb&w=400', 5),
(7, 'Forrest Gump', 'The presidencies of Kennedy and Johnson, the Vietnam War, the Watergate scandal and other historical events unfold from the perspective of an Alabama man with an IQ of 75.', 142, '1994-07-06', 'https://images.pexels.com/photos/36101/preview-483.jpg?auto=compress&cs=tinysrgb&w=400', 4),
(8, 'The Matrix', 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.', 136, '1999-03-31', 'https://images.unsplash.com/photo-1505686994434-e3cc5abf1330?w=400', 8),
(9, 'Titanic', 'A seventeen-year-old aristocrat falls in love with a kind but poor artist aboard the luxurious, ill-fated R.M.S. Titanic.', 195, '1997-12-19', 'https://images.pexels.com/photos/208698/pexels-photo-208698.jpeg?auto=compress&cs=tinysrgb&w=400', 7),
(10, 'The Avengers', 'Earth\'s mightiest heroes must come together and learn to fight as a team if they are going to stop the mischievous Loki and his alien army from enslaving humanity.', 143, '2012-05-04', 'https://images.unsplash.com/photo-1489599849228-ed2edf1e5c88?w=400', 1),
(11, 'Toy Story', 'A cowboy doll is profoundly threatened and jealous when a new spaceman figure supplants him as top toy in a boy\'s room.', 81, '1995-11-22', 'https://images.unsplash.com/photo-1494306895848-b75deaf00564?w=400', 10),
(12, 'The Conjuring', 'Paranormal investigators Ed and Lorraine Warren work to help a family terrorized by a dark presence in their farmhouse.', 112, '2013-07-19', 'https://images.pexels.com/photos/1170412/pexels-photo-1170412.jpeg?auto=compress&cs=tinysrgb&w=400', 6);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `movie_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hall_id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(10) NOT NULL,
  `row_number` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`id`, `hall_id`, `number`, `row_number`) VALUES
(1, 1, '1', 'A'),
(2, 1, '2', 'A'),
(3, 1, '3', 'A'),
(4, 1, '4', 'A'),
(5, 1, '5', 'A'),
(6, 1, '6', 'A'),
(7, 1, '7', 'A'),
(8, 1, '8', 'A'),
(9, 1, '9', 'A'),
(10, 1, '10', 'A'),
(11, 1, '1', 'B'),
(12, 1, '2', 'B'),
(13, 1, '3', 'B'),
(14, 1, '4', 'B'),
(15, 1, '5', 'B'),
(16, 1, '6', 'B'),
(17, 1, '7', 'B'),
(18, 1, '8', 'B'),
(19, 1, '9', 'B'),
(20, 1, '10', 'B'),
(21, 1, '1', 'C'),
(22, 1, '2', 'C'),
(23, 1, '3', 'C'),
(24, 1, '4', 'C'),
(25, 1, '5', 'C'),
(26, 1, '6', 'C'),
(27, 1, '7', 'C'),
(28, 1, '8', 'C'),
(29, 1, '9', 'C'),
(30, 1, '10', 'C'),
(31, 1, '1', 'D'),
(32, 1, '2', 'D'),
(33, 1, '3', 'D'),
(34, 1, '4', 'D'),
(35, 1, '5', 'D'),
(36, 1, '6', 'D'),
(37, 1, '7', 'D'),
(38, 1, '8', 'D'),
(39, 1, '9', 'D'),
(40, 1, '10', 'D'),
(41, 1, '1', 'E'),
(42, 1, '2', 'E'),
(43, 1, '3', 'E'),
(44, 1, '4', 'E'),
(45, 1, '5', 'E'),
(46, 1, '6', 'E'),
(47, 1, '7', 'E'),
(48, 1, '8', 'E'),
(49, 1, '9', 'E'),
(50, 1, '10', 'E'),
(51, 1, '1', 'F'),
(52, 1, '2', 'F'),
(53, 1, '3', 'F'),
(54, 1, '4', 'F'),
(55, 1, '5', 'F'),
(56, 1, '6', 'F'),
(57, 1, '7', 'F'),
(58, 1, '8', 'F'),
(59, 1, '9', 'F'),
(60, 1, '10', 'F'),
(61, 1, '1', 'G'),
(62, 1, '2', 'G'),
(63, 1, '3', 'G'),
(64, 1, '4', 'G'),
(65, 1, '5', 'G'),
(66, 1, '6', 'G'),
(67, 1, '7', 'G'),
(68, 1, '8', 'G'),
(69, 1, '9', 'G'),
(70, 1, '10', 'G'),
(71, 1, '1', 'H'),
(72, 1, '2', 'H'),
(73, 1, '3', 'H'),
(74, 1, '4', 'H'),
(75, 1, '5', 'H'),
(76, 1, '6', 'H'),
(77, 1, '7', 'H'),
(78, 1, '8', 'H'),
(79, 1, '9', 'H'),
(80, 1, '10', 'H'),
(81, 1, '1', 'I'),
(82, 1, '2', 'I'),
(83, 1, '3', 'I'),
(84, 1, '4', 'I'),
(85, 1, '5', 'I'),
(86, 1, '6', 'I'),
(87, 1, '7', 'I'),
(88, 1, '8', 'I'),
(89, 1, '9', 'I'),
(90, 1, '10', 'I'),
(91, 1, '1', 'J'),
(92, 1, '2', 'J'),
(93, 1, '3', 'J'),
(94, 1, '4', 'J'),
(95, 1, '5', 'J'),
(96, 1, '6', 'J'),
(97, 1, '7', 'J'),
(98, 1, '8', 'J'),
(99, 1, '9', 'J'),
(100, 1, '10', 'J'),
(101, 2, '1', 'A'),
(102, 2, '2', 'A'),
(103, 2, '3', 'A'),
(104, 2, '4', 'A'),
(105, 2, '5', 'A'),
(106, 2, '6', 'A'),
(107, 2, '7', 'A'),
(108, 2, '8', 'A'),
(109, 2, '9', 'A'),
(110, 2, '10', 'A'),
(111, 2, '1', 'B'),
(112, 2, '2', 'B'),
(113, 2, '3', 'B'),
(114, 2, '4', 'B'),
(115, 2, '5', 'B'),
(116, 2, '6', 'B'),
(117, 2, '7', 'B'),
(118, 2, '8', 'B'),
(119, 2, '9', 'B'),
(120, 2, '10', 'B'),
(121, 2, '1', 'C'),
(122, 2, '2', 'C'),
(123, 2, '3', 'C'),
(124, 2, '4', 'C'),
(125, 2, '5', 'C'),
(126, 2, '6', 'C'),
(127, 2, '7', 'C'),
(128, 2, '8', 'C'),
(129, 2, '9', 'C'),
(130, 2, '10', 'C'),
(131, 2, '1', 'D'),
(132, 2, '2', 'D'),
(133, 2, '3', 'D'),
(134, 2, '4', 'D'),
(135, 2, '5', 'D'),
(136, 2, '6', 'D'),
(137, 2, '7', 'D'),
(138, 2, '8', 'D'),
(139, 2, '9', 'D'),
(140, 2, '10', 'D'),
(141, 2, '1', 'E'),
(142, 2, '2', 'E'),
(143, 2, '3', 'E'),
(144, 2, '4', 'E'),
(145, 2, '5', 'E'),
(146, 2, '6', 'E'),
(147, 2, '7', 'E'),
(148, 2, '8', 'E'),
(149, 2, '9', 'E'),
(150, 2, '10', 'E'),
(151, 2, '1', 'F'),
(152, 2, '2', 'F'),
(153, 2, '3', 'F'),
(154, 2, '4', 'F'),
(155, 2, '5', 'F'),
(156, 2, '6', 'F'),
(157, 2, '7', 'F'),
(158, 2, '8', 'F'),
(159, 2, '9', 'F'),
(160, 2, '10', 'F'),
(161, 2, '1', 'G'),
(162, 2, '2', 'G'),
(163, 2, '3', 'G'),
(164, 2, '4', 'G'),
(165, 2, '5', 'G'),
(166, 2, '6', 'G'),
(167, 2, '7', 'G'),
(168, 2, '8', 'G'),
(169, 2, '9', 'G'),
(170, 2, '10', 'G'),
(171, 2, '1', 'H'),
(172, 2, '2', 'H'),
(173, 2, '3', 'H'),
(174, 2, '4', 'H'),
(175, 2, '5', 'H'),
(176, 2, '6', 'H'),
(177, 2, '7', 'H'),
(178, 2, '8', 'H'),
(179, 2, '9', 'H'),
(180, 2, '10', 'H'),
(181, 2, '1', 'I'),
(182, 2, '2', 'I'),
(183, 2, '3', 'I'),
(184, 2, '4', 'I'),
(185, 2, '5', 'I'),
(186, 2, '6', 'I'),
(187, 2, '7', 'I'),
(188, 2, '8', 'I'),
(189, 2, '9', 'I'),
(190, 2, '10', 'I'),
(191, 2, '1', 'J'),
(192, 2, '2', 'J'),
(193, 2, '3', 'J'),
(194, 2, '4', 'J'),
(195, 2, '5', 'J'),
(196, 2, '6', 'J'),
(197, 2, '7', 'J'),
(198, 2, '8', 'J'),
(199, 2, '9', 'J'),
(200, 2, '10', 'J'),
(201, 3, '1', 'A'),
(202, 3, '2', 'A'),
(203, 3, '3', 'A'),
(204, 3, '4', 'A'),
(205, 3, '5', 'A'),
(206, 3, '6', 'A'),
(207, 3, '7', 'A'),
(208, 3, '8', 'A'),
(209, 3, '9', 'A'),
(210, 3, '10', 'A'),
(211, 3, '1', 'B'),
(212, 3, '2', 'B'),
(213, 3, '3', 'B'),
(214, 3, '4', 'B'),
(215, 3, '5', 'B'),
(216, 3, '6', 'B'),
(217, 3, '7', 'B'),
(218, 3, '8', 'B'),
(219, 3, '9', 'B'),
(220, 3, '10', 'B'),
(221, 3, '1', 'C'),
(222, 3, '2', 'C'),
(223, 3, '3', 'C'),
(224, 3, '4', 'C'),
(225, 3, '5', 'C'),
(226, 3, '6', 'C'),
(227, 3, '7', 'C'),
(228, 3, '8', 'C'),
(229, 3, '9', 'C'),
(230, 3, '10', 'C'),
(231, 3, '1', 'D'),
(232, 3, '2', 'D'),
(233, 3, '3', 'D'),
(234, 3, '4', 'D'),
(235, 3, '5', 'D'),
(236, 3, '6', 'D'),
(237, 3, '7', 'D'),
(238, 3, '8', 'D'),
(239, 3, '9', 'D'),
(240, 3, '10', 'D'),
(241, 3, '1', 'E'),
(242, 3, '2', 'E'),
(243, 3, '3', 'E'),
(244, 3, '4', 'E'),
(245, 3, '5', 'E'),
(246, 3, '6', 'E'),
(247, 3, '7', 'E'),
(248, 3, '8', 'E'),
(249, 3, '9', 'E'),
(250, 3, '10', 'E'),
(251, 3, '1', 'F'),
(252, 3, '2', 'F'),
(253, 3, '3', 'F'),
(254, 3, '4', 'F'),
(255, 3, '5', 'F'),
(256, 3, '6', 'F'),
(257, 3, '7', 'F'),
(258, 3, '8', 'F'),
(259, 3, '9', 'F'),
(260, 3, '10', 'F'),
(261, 3, '1', 'G'),
(262, 3, '2', 'G'),
(263, 3, '3', 'G'),
(264, 3, '4', 'G'),
(265, 3, '5', 'G'),
(266, 3, '6', 'G'),
(267, 3, '7', 'G'),
(268, 3, '8', 'G'),
(269, 3, '9', 'G'),
(270, 3, '10', 'G'),
(271, 3, '1', 'H'),
(272, 3, '2', 'H'),
(273, 3, '3', 'H'),
(274, 3, '4', 'H'),
(275, 3, '5', 'H'),
(276, 3, '6', 'H'),
(277, 3, '7', 'H'),
(278, 3, '8', 'H'),
(279, 3, '9', 'H'),
(280, 3, '10', 'H'),
(281, 3, '1', 'I'),
(282, 3, '2', 'I'),
(283, 3, '3', 'I'),
(284, 3, '4', 'I'),
(285, 3, '5', 'I'),
(286, 3, '6', 'I'),
(287, 3, '7', 'I'),
(288, 3, '8', 'I'),
(289, 3, '9', 'I'),
(290, 3, '10', 'I'),
(291, 3, '1', 'J'),
(292, 3, '2', 'J'),
(293, 3, '3', 'J'),
(294, 3, '4', 'J'),
(295, 3, '5', 'J'),
(296, 3, '6', 'J'),
(297, 3, '7', 'J'),
(298, 3, '8', 'J'),
(299, 3, '9', 'J'),
(300, 3, '10', 'J'),
(301, 4, '1', 'A'),
(302, 4, '2', 'A'),
(303, 4, '3', 'A'),
(304, 4, '4', 'A'),
(305, 4, '5', 'A'),
(306, 4, '6', 'A'),
(307, 4, '7', 'A'),
(308, 4, '8', 'A'),
(309, 4, '9', 'A'),
(310, 4, '10', 'A'),
(311, 4, '1', 'B'),
(312, 4, '2', 'B'),
(313, 4, '3', 'B'),
(314, 4, '4', 'B'),
(315, 4, '5', 'B'),
(316, 4, '6', 'B'),
(317, 4, '7', 'B'),
(318, 4, '8', 'B'),
(319, 4, '9', 'B'),
(320, 4, '10', 'B'),
(321, 4, '1', 'C'),
(322, 4, '2', 'C'),
(323, 4, '3', 'C'),
(324, 4, '4', 'C'),
(325, 4, '5', 'C'),
(326, 4, '6', 'C'),
(327, 4, '7', 'C'),
(328, 4, '8', 'C'),
(329, 4, '9', 'C'),
(330, 4, '10', 'C'),
(331, 4, '1', 'D'),
(332, 4, '2', 'D'),
(333, 4, '3', 'D'),
(334, 4, '4', 'D'),
(335, 4, '5', 'D'),
(336, 4, '6', 'D'),
(337, 4, '7', 'D'),
(338, 4, '8', 'D'),
(339, 4, '9', 'D'),
(340, 4, '10', 'D'),
(341, 4, '1', 'E'),
(342, 4, '2', 'E'),
(343, 4, '3', 'E'),
(344, 4, '4', 'E'),
(345, 4, '5', 'E'),
(346, 4, '6', 'E'),
(347, 4, '7', 'E'),
(348, 4, '8', 'E'),
(349, 4, '9', 'E'),
(350, 4, '10', 'E'),
(351, 4, '1', 'F'),
(352, 4, '2', 'F'),
(353, 4, '3', 'F'),
(354, 4, '4', 'F'),
(355, 4, '5', 'F'),
(356, 4, '6', 'F'),
(357, 4, '7', 'F'),
(358, 4, '8', 'F'),
(359, 4, '9', 'F'),
(360, 4, '10', 'F'),
(361, 4, '1', 'G'),
(362, 4, '2', 'G'),
(363, 4, '3', 'G'),
(364, 4, '4', 'G'),
(365, 4, '5', 'G'),
(366, 4, '6', 'G'),
(367, 4, '7', 'G'),
(368, 4, '8', 'G'),
(369, 4, '9', 'G'),
(370, 4, '10', 'G'),
(371, 4, '1', 'H'),
(372, 4, '2', 'H'),
(373, 4, '3', 'H'),
(374, 4, '4', 'H'),
(375, 4, '5', 'H'),
(376, 4, '6', 'H'),
(377, 4, '7', 'H'),
(378, 4, '8', 'H'),
(379, 4, '9', 'H'),
(380, 4, '10', 'H'),
(381, 4, '1', 'I'),
(382, 4, '2', 'I'),
(383, 4, '3', 'I'),
(384, 4, '4', 'I'),
(385, 4, '5', 'I'),
(386, 4, '6', 'I'),
(387, 4, '7', 'I'),
(388, 4, '8', 'I'),
(389, 4, '9', 'I'),
(390, 4, '10', 'I'),
(391, 4, '1', 'J'),
(392, 4, '2', 'J'),
(393, 4, '3', 'J'),
(394, 4, '4', 'J'),
(395, 4, '5', 'J'),
(396, 4, '6', 'J'),
(397, 4, '7', 'J'),
(398, 4, '8', 'J'),
(399, 4, '9', 'J'),
(400, 4, '10', 'J'),
(401, 5, '1', 'A'),
(402, 5, '2', 'A'),
(403, 5, '3', 'A'),
(404, 5, '4', 'A'),
(405, 5, '5', 'A'),
(406, 5, '6', 'A'),
(407, 5, '7', 'A'),
(408, 5, '8', 'A'),
(409, 5, '9', 'A'),
(410, 5, '10', 'A'),
(411, 5, '1', 'B'),
(412, 5, '2', 'B'),
(413, 5, '3', 'B'),
(414, 5, '4', 'B'),
(415, 5, '5', 'B'),
(416, 5, '6', 'B'),
(417, 5, '7', 'B'),
(418, 5, '8', 'B'),
(419, 5, '9', 'B'),
(420, 5, '10', 'B'),
(421, 5, '1', 'C'),
(422, 5, '2', 'C'),
(423, 5, '3', 'C'),
(424, 5, '4', 'C'),
(425, 5, '5', 'C'),
(426, 5, '6', 'C'),
(427, 5, '7', 'C'),
(428, 5, '8', 'C'),
(429, 5, '9', 'C'),
(430, 5, '10', 'C'),
(431, 5, '1', 'D'),
(432, 5, '2', 'D'),
(433, 5, '3', 'D'),
(434, 5, '4', 'D'),
(435, 5, '5', 'D'),
(436, 5, '6', 'D'),
(437, 5, '7', 'D'),
(438, 5, '8', 'D'),
(439, 5, '9', 'D'),
(440, 5, '10', 'D'),
(441, 5, '1', 'E'),
(442, 5, '2', 'E'),
(443, 5, '3', 'E'),
(444, 5, '4', 'E'),
(445, 5, '5', 'E'),
(446, 5, '6', 'E'),
(447, 5, '7', 'E'),
(448, 5, '8', 'E'),
(449, 5, '9', 'E'),
(450, 5, '10', 'E'),
(451, 5, '1', 'F'),
(452, 5, '2', 'F'),
(453, 5, '3', 'F'),
(454, 5, '4', 'F'),
(455, 5, '5', 'F'),
(456, 5, '6', 'F'),
(457, 5, '7', 'F'),
(458, 5, '8', 'F'),
(459, 5, '9', 'F'),
(460, 5, '10', 'F'),
(461, 5, '1', 'G'),
(462, 5, '2', 'G'),
(463, 5, '3', 'G'),
(464, 5, '4', 'G'),
(465, 5, '5', 'G'),
(466, 5, '6', 'G'),
(467, 5, '7', 'G'),
(468, 5, '8', 'G'),
(469, 5, '9', 'G'),
(470, 5, '10', 'G'),
(471, 5, '1', 'H'),
(472, 5, '2', 'H'),
(473, 5, '3', 'H'),
(474, 5, '4', 'H'),
(475, 5, '5', 'H'),
(476, 5, '6', 'H'),
(477, 5, '7', 'H'),
(478, 5, '8', 'H'),
(479, 5, '9', 'H'),
(480, 5, '10', 'H'),
(481, 5, '1', 'I'),
(482, 5, '2', 'I'),
(483, 5, '3', 'I'),
(484, 5, '4', 'I'),
(485, 5, '5', 'I'),
(486, 5, '6', 'I'),
(487, 5, '7', 'I'),
(488, 5, '8', 'I'),
(489, 5, '9', 'I'),
(490, 5, '10', 'I'),
(491, 5, '1', 'J'),
(492, 5, '2', 'J'),
(493, 5, '3', 'J'),
(494, 5, '4', 'J'),
(495, 5, '5', 'J'),
(496, 5, '6', 'J'),
(497, 5, '7', 'J'),
(498, 5, '8', 'J'),
(499, 5, '9', 'J'),
(500, 5, '10', 'J'),
(501, 6, '1', 'A'),
(502, 6, '2', 'A'),
(503, 6, '3', 'A'),
(504, 6, '4', 'A'),
(505, 6, '5', 'A'),
(506, 6, '6', 'A'),
(507, 6, '7', 'A'),
(508, 6, '8', 'A'),
(509, 6, '9', 'A'),
(510, 6, '10', 'A'),
(511, 6, '1', 'B'),
(512, 6, '2', 'B'),
(513, 6, '3', 'B'),
(514, 6, '4', 'B'),
(515, 6, '5', 'B'),
(516, 6, '6', 'B'),
(517, 6, '7', 'B'),
(518, 6, '8', 'B'),
(519, 6, '9', 'B'),
(520, 6, '10', 'B'),
(521, 6, '1', 'C'),
(522, 6, '2', 'C'),
(523, 6, '3', 'C'),
(524, 6, '4', 'C'),
(525, 6, '5', 'C'),
(526, 6, '6', 'C'),
(527, 6, '7', 'C'),
(528, 6, '8', 'C'),
(529, 6, '9', 'C'),
(530, 6, '10', 'C'),
(531, 6, '1', 'D'),
(532, 6, '2', 'D'),
(533, 6, '3', 'D'),
(534, 6, '4', 'D'),
(535, 6, '5', 'D'),
(536, 6, '6', 'D'),
(537, 6, '7', 'D'),
(538, 6, '8', 'D'),
(539, 6, '9', 'D'),
(540, 6, '10', 'D'),
(541, 6, '1', 'E'),
(542, 6, '2', 'E'),
(543, 6, '3', 'E'),
(544, 6, '4', 'E'),
(545, 6, '5', 'E'),
(546, 6, '6', 'E'),
(547, 6, '7', 'E'),
(548, 6, '8', 'E'),
(549, 6, '9', 'E'),
(550, 6, '10', 'E'),
(551, 6, '1', 'F'),
(552, 6, '2', 'F'),
(553, 6, '3', 'F'),
(554, 6, '4', 'F'),
(555, 6, '5', 'F'),
(556, 6, '6', 'F'),
(557, 6, '7', 'F'),
(558, 6, '8', 'F'),
(559, 6, '9', 'F'),
(560, 6, '10', 'F'),
(561, 6, '1', 'G'),
(562, 6, '2', 'G'),
(563, 6, '3', 'G'),
(564, 6, '4', 'G'),
(565, 6, '5', 'G'),
(566, 6, '6', 'G'),
(567, 6, '7', 'G'),
(568, 6, '8', 'G'),
(569, 6, '9', 'G'),
(570, 6, '10', 'G'),
(571, 6, '1', 'H'),
(572, 6, '2', 'H'),
(573, 6, '3', 'H'),
(574, 6, '4', 'H'),
(575, 6, '5', 'H'),
(576, 6, '6', 'H'),
(577, 6, '7', 'H'),
(578, 6, '8', 'H'),
(579, 6, '9', 'H'),
(580, 6, '10', 'H'),
(581, 6, '1', 'I'),
(582, 6, '2', 'I'),
(583, 6, '3', 'I'),
(584, 6, '4', 'I'),
(585, 6, '5', 'I'),
(586, 6, '6', 'I'),
(587, 6, '7', 'I'),
(588, 6, '8', 'I'),
(589, 6, '9', 'I'),
(590, 6, '10', 'I'),
(591, 6, '1', 'J'),
(592, 6, '2', 'J'),
(593, 6, '3', 'J'),
(594, 6, '4', 'J'),
(595, 6, '5', 'J'),
(596, 6, '6', 'J'),
(597, 6, '7', 'J'),
(598, 6, '8', 'J'),
(599, 6, '9', 'J'),
(600, 6, '10', 'J'),
(601, 7, '1', 'A'),
(602, 7, '2', 'A'),
(603, 7, '3', 'A'),
(604, 7, '4', 'A'),
(605, 7, '5', 'A'),
(606, 7, '6', 'A'),
(607, 7, '7', 'A'),
(608, 7, '8', 'A'),
(609, 7, '9', 'A'),
(610, 7, '10', 'A'),
(611, 7, '1', 'B'),
(612, 7, '2', 'B'),
(613, 7, '3', 'B'),
(614, 7, '4', 'B'),
(615, 7, '5', 'B'),
(616, 7, '6', 'B'),
(617, 7, '7', 'B'),
(618, 7, '8', 'B'),
(619, 7, '9', 'B'),
(620, 7, '10', 'B'),
(621, 7, '1', 'C'),
(622, 7, '2', 'C'),
(623, 7, '3', 'C'),
(624, 7, '4', 'C'),
(625, 7, '5', 'C'),
(626, 7, '6', 'C'),
(627, 7, '7', 'C'),
(628, 7, '8', 'C'),
(629, 7, '9', 'C'),
(630, 7, '10', 'C'),
(631, 7, '1', 'D'),
(632, 7, '2', 'D'),
(633, 7, '3', 'D'),
(634, 7, '4', 'D'),
(635, 7, '5', 'D'),
(636, 7, '6', 'D'),
(637, 7, '7', 'D'),
(638, 7, '8', 'D'),
(639, 7, '9', 'D'),
(640, 7, '10', 'D'),
(641, 7, '1', 'E'),
(642, 7, '2', 'E'),
(643, 7, '3', 'E'),
(644, 7, '4', 'E'),
(645, 7, '5', 'E'),
(646, 7, '6', 'E'),
(647, 7, '7', 'E'),
(648, 7, '8', 'E'),
(649, 7, '9', 'E'),
(650, 7, '10', 'E'),
(651, 7, '1', 'F'),
(652, 7, '2', 'F'),
(653, 7, '3', 'F'),
(654, 7, '4', 'F'),
(655, 7, '5', 'F'),
(656, 7, '6', 'F'),
(657, 7, '7', 'F'),
(658, 7, '8', 'F'),
(659, 7, '9', 'F'),
(660, 7, '10', 'F'),
(661, 7, '1', 'G'),
(662, 7, '2', 'G'),
(663, 7, '3', 'G'),
(664, 7, '4', 'G'),
(665, 7, '5', 'G'),
(666, 7, '6', 'G'),
(667, 7, '7', 'G'),
(668, 7, '8', 'G'),
(669, 7, '9', 'G'),
(670, 7, '10', 'G'),
(671, 7, '1', 'H'),
(672, 7, '2', 'H'),
(673, 7, '3', 'H'),
(674, 7, '4', 'H'),
(675, 7, '5', 'H'),
(676, 7, '6', 'H'),
(677, 7, '7', 'H'),
(678, 7, '8', 'H'),
(679, 7, '9', 'H'),
(680, 7, '10', 'H'),
(681, 7, '1', 'I'),
(682, 7, '2', 'I'),
(683, 7, '3', 'I'),
(684, 7, '4', 'I'),
(685, 7, '5', 'I'),
(686, 7, '6', 'I'),
(687, 7, '7', 'I'),
(688, 7, '8', 'I'),
(689, 7, '9', 'I'),
(690, 7, '10', 'I'),
(691, 7, '1', 'J'),
(692, 7, '2', 'J'),
(693, 7, '3', 'J'),
(694, 7, '4', 'J'),
(695, 7, '5', 'J'),
(696, 7, '6', 'J'),
(697, 7, '7', 'J'),
(698, 7, '8', 'J'),
(699, 7, '9', 'J'),
(700, 7, '10', 'J'),
(701, 8, '1', 'A'),
(702, 8, '2', 'A'),
(703, 8, '3', 'A'),
(704, 8, '4', 'A'),
(705, 8, '5', 'A'),
(706, 8, '6', 'A'),
(707, 8, '7', 'A'),
(708, 8, '8', 'A'),
(709, 8, '9', 'A'),
(710, 8, '10', 'A'),
(711, 8, '1', 'B'),
(712, 8, '2', 'B'),
(713, 8, '3', 'B'),
(714, 8, '4', 'B'),
(715, 8, '5', 'B'),
(716, 8, '6', 'B'),
(717, 8, '7', 'B'),
(718, 8, '8', 'B'),
(719, 8, '9', 'B'),
(720, 8, '10', 'B'),
(721, 8, '1', 'C'),
(722, 8, '2', 'C'),
(723, 8, '3', 'C'),
(724, 8, '4', 'C'),
(725, 8, '5', 'C'),
(726, 8, '6', 'C'),
(727, 8, '7', 'C'),
(728, 8, '8', 'C'),
(729, 8, '9', 'C'),
(730, 8, '10', 'C'),
(731, 8, '1', 'D'),
(732, 8, '2', 'D'),
(733, 8, '3', 'D'),
(734, 8, '4', 'D'),
(735, 8, '5', 'D'),
(736, 8, '6', 'D'),
(737, 8, '7', 'D'),
(738, 8, '8', 'D'),
(739, 8, '9', 'D'),
(740, 8, '10', 'D'),
(741, 8, '1', 'E'),
(742, 8, '2', 'E'),
(743, 8, '3', 'E'),
(744, 8, '4', 'E'),
(745, 8, '5', 'E'),
(746, 8, '6', 'E'),
(747, 8, '7', 'E'),
(748, 8, '8', 'E'),
(749, 8, '9', 'E'),
(750, 8, '10', 'E'),
(751, 8, '1', 'F'),
(752, 8, '2', 'F'),
(753, 8, '3', 'F'),
(754, 8, '4', 'F'),
(755, 8, '5', 'F'),
(756, 8, '6', 'F'),
(757, 8, '7', 'F'),
(758, 8, '8', 'F'),
(759, 8, '9', 'F'),
(760, 8, '10', 'F'),
(761, 8, '1', 'G'),
(762, 8, '2', 'G'),
(763, 8, '3', 'G'),
(764, 8, '4', 'G'),
(765, 8, '5', 'G'),
(766, 8, '6', 'G'),
(767, 8, '7', 'G'),
(768, 8, '8', 'G'),
(769, 8, '9', 'G'),
(770, 8, '10', 'G'),
(771, 8, '1', 'H'),
(772, 8, '2', 'H'),
(773, 8, '3', 'H'),
(774, 8, '4', 'H'),
(775, 8, '5', 'H'),
(776, 8, '6', 'H'),
(777, 8, '7', 'H'),
(778, 8, '8', 'H'),
(779, 8, '9', 'H'),
(780, 8, '10', 'H'),
(781, 8, '1', 'I'),
(782, 8, '2', 'I'),
(783, 8, '3', 'I'),
(784, 8, '4', 'I'),
(785, 8, '5', 'I'),
(786, 8, '6', 'I'),
(787, 8, '7', 'I'),
(788, 8, '8', 'I'),
(789, 8, '9', 'I'),
(790, 8, '10', 'I'),
(791, 8, '1', 'J'),
(792, 8, '2', 'J'),
(793, 8, '3', 'J'),
(794, 8, '4', 'J'),
(795, 8, '5', 'J'),
(796, 8, '6', 'J'),
(797, 8, '7', 'J'),
(798, 8, '8', 'J'),
(799, 8, '9', 'J'),
(800, 8, '10', 'J'),
(801, 9, '1', 'A'),
(802, 9, '2', 'A'),
(803, 9, '3', 'A'),
(804, 9, '4', 'A'),
(805, 9, '5', 'A'),
(806, 9, '6', 'A'),
(807, 9, '7', 'A'),
(808, 9, '8', 'A'),
(809, 9, '9', 'A'),
(810, 9, '10', 'A'),
(811, 9, '1', 'B'),
(812, 9, '2', 'B'),
(813, 9, '3', 'B'),
(814, 9, '4', 'B'),
(815, 9, '5', 'B'),
(816, 9, '6', 'B'),
(817, 9, '7', 'B'),
(818, 9, '8', 'B'),
(819, 9, '9', 'B'),
(820, 9, '10', 'B'),
(821, 9, '1', 'C'),
(822, 9, '2', 'C'),
(823, 9, '3', 'C'),
(824, 9, '4', 'C'),
(825, 9, '5', 'C'),
(826, 9, '6', 'C'),
(827, 9, '7', 'C'),
(828, 9, '8', 'C'),
(829, 9, '9', 'C'),
(830, 9, '10', 'C'),
(831, 9, '1', 'D'),
(832, 9, '2', 'D'),
(833, 9, '3', 'D'),
(834, 9, '4', 'D'),
(835, 9, '5', 'D'),
(836, 9, '6', 'D'),
(837, 9, '7', 'D'),
(838, 9, '8', 'D'),
(839, 9, '9', 'D'),
(840, 9, '10', 'D'),
(841, 9, '1', 'E'),
(842, 9, '2', 'E'),
(843, 9, '3', 'E'),
(844, 9, '4', 'E'),
(845, 9, '5', 'E'),
(846, 9, '6', 'E'),
(847, 9, '7', 'E'),
(848, 9, '8', 'E'),
(849, 9, '9', 'E'),
(850, 9, '10', 'E'),
(851, 9, '1', 'F'),
(852, 9, '2', 'F'),
(853, 9, '3', 'F'),
(854, 9, '4', 'F'),
(855, 9, '5', 'F'),
(856, 9, '6', 'F'),
(857, 9, '7', 'F'),
(858, 9, '8', 'F'),
(859, 9, '9', 'F'),
(860, 9, '10', 'F'),
(861, 9, '1', 'G'),
(862, 9, '2', 'G'),
(863, 9, '3', 'G'),
(864, 9, '4', 'G'),
(865, 9, '5', 'G'),
(866, 9, '6', 'G'),
(867, 9, '7', 'G'),
(868, 9, '8', 'G'),
(869, 9, '9', 'G'),
(870, 9, '10', 'G'),
(871, 9, '1', 'H'),
(872, 9, '2', 'H'),
(873, 9, '3', 'H'),
(874, 9, '4', 'H'),
(875, 9, '5', 'H'),
(876, 9, '6', 'H'),
(877, 9, '7', 'H'),
(878, 9, '8', 'H'),
(879, 9, '9', 'H'),
(880, 9, '10', 'H'),
(881, 9, '1', 'I'),
(882, 9, '2', 'I'),
(883, 9, '3', 'I'),
(884, 9, '4', 'I'),
(885, 9, '5', 'I'),
(886, 9, '6', 'I'),
(887, 9, '7', 'I'),
(888, 9, '8', 'I'),
(889, 9, '9', 'I'),
(890, 9, '10', 'I'),
(891, 9, '1', 'J'),
(892, 9, '2', 'J'),
(893, 9, '3', 'J'),
(894, 9, '4', 'J'),
(895, 9, '5', 'J'),
(896, 9, '6', 'J'),
(897, 9, '7', 'J'),
(898, 9, '8', 'J'),
(899, 9, '9', 'J'),
(900, 9, '10', 'J');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('rbUEvByxIqUZium5wANV8c3nibHfO3yXrHXHnNA8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 OPR/129.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMGoxRmtvOVpocFh4SkNlckZLcjhHemlUUG9XbFgwakdadldnMGJsMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tb3ZpZXMvOCI7czo1OiJyb3V0ZSI7czoxMToibW92aWVzLnNob3ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1776272503);

-- --------------------------------------------------------

--
-- Table structure for table `showtimes`
--

CREATE TABLE `showtimes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `movie_id` bigint(20) UNSIGNED NOT NULL,
  `hall_id` bigint(20) UNSIGNED NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `showtimes`
--

INSERT INTO `showtimes` (`id`, `movie_id`, `hall_id`, `start_time`, `end_time`, `price`) VALUES
(1, 1, 2, '2026-04-17 19:00:24', '2026-04-17 21:32:24', 356.00),
(2, 1, 5, '2026-04-22 21:00:24', '2026-04-22 23:32:24', 383.00),
(3, 2, 5, '2026-04-15 20:00:24', '2026-04-15 22:32:24', 414.00),
(4, 2, 8, '2026-04-20 20:00:24', '2026-04-20 22:32:24', 394.00),
(5, 3, 3, '2026-04-20 21:00:24', '2026-04-20 23:28:24', 435.00),
(6, 3, 4, '2026-04-18 15:00:24', '2026-04-18 17:28:24', 416.00),
(7, 4, 8, '2026-04-18 18:00:24', '2026-04-18 20:22:24', 330.00),
(8, 4, 9, '2026-04-21 16:00:24', '2026-04-21 18:22:24', 314.00),
(9, 5, 2, '2026-04-18 20:00:24', '2026-04-18 22:34:24', 299.00),
(10, 5, 7, '2026-04-17 21:00:24', '2026-04-17 23:34:24', 298.00),
(11, 6, 4, '2026-04-17 10:00:24', '2026-04-17 12:58:24', 388.00),
(12, 6, 9, '2026-04-15 20:00:24', '2026-04-15 22:58:24', 412.00),
(13, 7, 1, '2026-04-18 17:00:24', '2026-04-18 19:22:24', 316.00),
(14, 7, 6, '2026-04-17 15:00:24', '2026-04-17 17:22:24', 276.00),
(15, 8, 1, '2026-04-18 10:00:24', '2026-04-18 12:16:24', 356.00),
(16, 8, 2, '2026-04-20 16:00:24', '2026-04-20 18:16:24', 393.00),
(17, 9, 4, '2026-04-15 17:00:24', '2026-04-15 20:15:24', 274.00),
(18, 9, 7, '2026-04-18 14:00:24', '2026-04-18 17:15:24', 313.00),
(19, 10, 5, '2026-04-20 16:00:24', '2026-04-20 18:23:24', 398.00),
(20, 10, 7, '2026-04-20 18:00:24', '2026-04-20 20:23:24', 381.00),
(21, 11, 2, '2026-04-18 22:00:24', '2026-04-18 23:21:24', 362.00),
(22, 11, 6, '2026-04-22 14:00:24', '2026-04-22 15:21:24', 362.00),
(23, 12, 3, '2026-04-19 14:00:24', '2026-04-19 15:52:24', 325.00),
(24, 12, 5, '2026-04-21 15:00:24', '2026-04-21 16:52:24', 291.00);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `seat_id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) NOT NULL,
  `issued_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@cinemax.com', '$2y$12$B9VOgPcU3nx4VGaAjssCE.KYybs12U5qB.ZsHrSf3l56GQFC8/cBO', 1, '2026-04-15 08:44:22', '2026-04-15 08:44:22'),
(2, 'Test Customer', 'customer@cinemax.com', '$2y$12$c5PKUM3GWbGNdNCHGGNTXeREw1IbeTQY5G2KDRG1eHIimLCIEKdtO', 2, '2026-04-15 08:44:22', '2026-04-15 08:44:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_showtime_id_foreign` (`showtime_id`);

--
-- Indexes for table `booking_seats`
--
ALTER TABLE `booking_seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_seats_booking_id_foreign` (`booking_id`),
  ADD KEY `booking_seats_seat_id_foreign` (`seat_id`);

--
-- Indexes for table `cinemas`
--
ALTER TABLE `cinemas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `halls_cinema_id_foreign` (`cinema_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movies_genre_id_foreign` (`genre_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_booking_id_unique` (`booking_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_movie_id_foreign` (`movie_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seats_hall_id_foreign` (`hall_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `showtimes`
--
ALTER TABLE `showtimes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `showtimes_movie_id_foreign` (`movie_id`),
  ADD KEY `showtimes_hall_id_foreign` (`hall_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets_code_unique` (`code`),
  ADD KEY `tickets_booking_id_foreign` (`booking_id`),
  ADD KEY `tickets_seat_id_foreign` (`seat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_seats`
--
ALTER TABLE `booking_seats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cinemas`
--
ALTER TABLE `cinemas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `halls`
--
ALTER TABLE `halls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=901;

--
-- AUTO_INCREMENT for table `showtimes`
--
ALTER TABLE `showtimes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_showtime_id_foreign` FOREIGN KEY (`showtime_id`) REFERENCES `showtimes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `booking_seats`
--
ALTER TABLE `booking_seats`
  ADD CONSTRAINT `booking_seats_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_seats_seat_id_foreign` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `halls`
--
ALTER TABLE `halls`
  ADD CONSTRAINT `halls_cinema_id_foreign` FOREIGN KEY (`cinema_id`) REFERENCES `cinemas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_genre_id_foreign` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_hall_id_foreign` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `showtimes`
--
ALTER TABLE `showtimes`
  ADD CONSTRAINT `showtimes_hall_id_foreign` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `showtimes_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_seat_id_foreign` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
