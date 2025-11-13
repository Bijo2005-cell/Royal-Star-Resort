-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2025 at 02:57 PM
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
-- Database: `royal_star_resort`
--

-- --------------------------------------------------------

--
-- Table structure for table `accommodations`
--

CREATE TABLE `accommodations` (
  `acc_id` int(11) NOT NULL,
  `acc_type` enum('room','villa') NOT NULL,
  `number` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('available','occupied','maintenance') NOT NULL DEFAULT 'available',
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accommodations`
--

INSERT INTO `accommodations` (`acc_id`, `acc_type`, `number`, `price`, `status`, `image`, `description`) VALUES
(1, 'room', 'Premium Club Suite', 7200.00, 'available', '../photos/rm5.jpeg', 'Spacious club suite with stunning valley views, modern decor, and a balcony.'),
(2, 'room', 'Presidental Suite', 6900.00, 'occupied', '../photos/rm7.jpeg', 'The most luxurious and prestigious accommodation offered in a hotel.'),
(3, 'room', 'Jacuzzi 180-Degree Suite', 8700.00, 'available', '../photos/rm8.jpeg', 'A high-end hotel suite designed for guests seeking luxury and breathtaking views.'),
(4, 'room', 'Deluxe Room', 4999.00, 'available', '../photos/rm3.jpg', 'Experience comfort in our spacious deluxe rooms with stunning views.'),
(5, 'room', 'Honeymoon Suite', 6700.00, 'maintenance', '../photos/rm6.jpeg', 'An intimate and elegant retreat that offers a perfect blend of comfort and privacy.'),
(6, 'room', 'Premium Room', 6000.00, 'available', '../photos/rm1.jpg', 'Relax in a plush king bed with premium linens and take in scenic views.'),
(7, 'room', 'Superior Room', 3500.00, 'occupied', '../photos/rm2.jpg', 'Elevate your stay in our stylish Superior Room, thoughtfully designed for comfort.'),
(8, 'room', 'Family Innerconnected Club Suite', 7200.00, 'available', '../photos/rm4.jpg', 'Premium accommodations with extra space and exclusive amenities for families.'),
(9, 'villa', 'Garden Villa', 17200.00, 'available', '../photos/villa1.jpeg', 'Private villa surrounded by lush tropical gardens with a plunge pool.'),
(10, 'villa', 'Dam front Villa', 14000.00, 'occupied', '../photos/villa2.jpeg', 'Direct dam access with stunning ocean views from every room.'),
(11, 'villa', 'Royal Suite Villa', 21000.00, 'available', '../photos/villa3.jpeg', 'Our most luxurious accommodation with private butler service and infinity pool.');

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action_title` varchar(100) NOT NULL,
  `action_description` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`log_id`, `user_id`, `action_title`, `action_description`, `timestamp`) VALUES
(1, 11, 'Guest Check-In', 'Bijo K Binoy checked into Room 301', '2025-10-24 08:07:07'),
(2, 16, 'Task Completed', 'Room 205 cleaning inspection finished', '2025-10-24 08:07:07'),
(3, 2, 'Leave Approved', 'Approved sick leave for Anand Krishnan', '2025-10-24 08:07:07'),
(4, 11, 'Guest Check-Out', 'Vasu checked out from Room 108', '2025-10-24 08:07:07'),
(5, 2, 'Task Completed', 'Task ID 2 marked as Completed', '2025-10-24 11:16:39'),
(6, 1, 'New Task Assigned', 'Task \'Assign Room 102 clean\' assigned to user ID 2', '2025-10-24 11:23:33');

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

CREATE TABLE `awards` (
  `award_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `title` varchar(100) NOT NULL,
  `year_received` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `awards`
--

INSERT INTO `awards` (`award_id`, `image_path`, `title`, `year_received`, `description`) VALUES
(1, '../photos/award3.png', 'Excellence In Hospitality', '2025', 'The art of consistently exceeding guest expectations to create unforgettable experiences.'),
(2, '../photos/award1.png', 'Best Luxury Resort', '2024', 'An exclusive sanctuary offering unparalleled comfort, bespoke services, and an unforgettable escape.'),
(3, '../photos/award4.png', 'Award Of Excellence', '2023', 'A prestigious honor recognizing individuals or organizations for achieving the highest standards of performance and quality in their field.'),
(4, '../photos/award8.jpg', 'Award Of Excellence', '2022', 'A prestigious honor recognizing individuals or organizations for achieving the highest standards of performance and quality in their field.'),
(5, '../photos/award2.png', 'Top Rating', '2020', 'Top 1% of hotels worldwide based on consistently outstanding traveler reviews.'),
(6, '../photos/award6.png', 'State Tourism Award', '2017-2018', 'A prestigious government award honoring the highest level of excellence and contribution to a state\'s travel and hospitality industry.'),
(7, '../photos/award5.png', 'Top Rating', '2014', 'Top 1% of hotels worldwide based on consistently outstanding traveler reviews.'),
(8, '../photos/award7.jpg', 'State Tourism Award', '2013-2014', 'A prestigious government award honoring the highest level of excellence and contribution to a state\'s travel and hospitality industry.');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `post_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_alt` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `post_date` date DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `read_more_link` varchar(255) DEFAULT '#'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`post_id`, `image_path`, `image_alt`, `title`, `post_date`, `summary`, `read_more_link`) VALUES
(1, '../photos/bg1.jpg', 'Royal Star Resort History', 'The History of Royal Star Residency', '2023-06-15', 'Nestled in the misty hills of Idukki, Royal Star Residency stands as a proud testimony to history, nature, and heritage. Once a quaint British-era bungalow that served as a haven for engineers and officials during the construction of the iconic Ponmudi Dam, this vintage structure has now been thoughtfully restored into a premium hilltop retreat—Royal Star Residency.', '#'),
(2, '../photos/blog1.png', 'Family Stay', 'Make Every Stay Special at Royal Star Residency', '2023-05-28', 'Nestled in a serene and accessible location, Royal Star Residency offers the perfect blend of warmth, elegance, and modern comfort. Designed with families in mind, our hotel features spacious rooms, thoughtful amenities, and a welcoming atmosphere that makes every guest feel at home.', '#'),
(3, '../photos/blog2.png', 'Top Resort', 'Your Perfect Escape among the Top Ten Resorts in Munnar', '2023-04-10', 'Tucked away in the lush hills of Munnar, Royal Star Residency invites you to experience the ultimate blend of nature, comfort, and hospitality. Recognized among the top ten resorts in the region, our property offers an ideal retreat for couples, families, and travelers seeking peace, beauty, and premium service.', '#'),
(4, '../photos/blog3.jpg', 'Spa Experience', 'Rejuvenate at Our Award-Winning Spa', '2023-03-22', 'Discover the art of relaxation at our world-class spa facility. Our expert therapists combine ancient techniques with modern therapies to create personalized treatments that will leave you feeling refreshed and revitalized. Learn about our signature treatments and wellness packages.', '#'),
(5, '../photos/blog4.jpg', 'Culinary Experience', 'A Culinary Journey at Royal Star', '2023-02-15', 'Our executive chef takes you behind the scenes of our award-winning restaurants. Discover the secrets of our farm-to-table philosophy, meet our local suppliers, and learn about the inspiration behind our seasonal menus that celebrate the region\'s rich culinary heritage.', '#'),
(6, '../photos/wedding.png', 'Wedding Venue', 'Dream Weddings at Royal Star Resort', '2023-01-05', 'From intimate ceremonies to grand celebrations, our resort provides the perfect backdrop for your special day. Meet our wedding planners and learn how we create unforgettable experiences tailored to each couple\'s unique vision and style.', '#');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `guest_name` varchar(255) DEFAULT NULL,
  `guest_email` varchar(255) DEFAULT NULL,
  `guest_phone` varchar(20) DEFAULT NULL,
  `guest_nationality` varchar(50) DEFAULT NULL,
  `identity_document` varchar(255) DEFAULT NULL,
  `special_requests` text DEFAULT NULL,
  `total_rate` decimal(10,2) NOT NULL,
  `refund_amount` decimal(10,2) DEFAULT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Confirmed','Cancelled') NOT NULL DEFAULT 'Confirmed',
  `source` varchar(50) NOT NULL DEFAULT 'Direct Website'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `guest_name`, `guest_email`, `guest_phone`, `guest_nationality`, `identity_document`, `special_requests`, `total_rate`, `refund_amount`, `booking_date`, `status`, `source`) VALUES
(20, 1, NULL, NULL, NULL, NULL, NULL, NULL, 7200.00, NULL, '2025-10-09 16:58:55', 'Confirmed', 'Booking.com (OTA)'),
(21, 1, NULL, NULL, NULL, NULL, NULL, NULL, 30700.00, NULL, '2025-10-09 17:09:17', 'Confirmed', 'Direct Website'),
(22, 1, NULL, NULL, NULL, NULL, NULL, NULL, 22700.00, NULL, '2025-10-13 10:28:08', 'Confirmed', 'Travel Agents'),
(25, 1, NULL, NULL, NULL, NULL, NULL, NULL, 26200.00, NULL, '2025-10-13 10:35:17', 'Confirmed', 'Booking.com (OTA)'),
(27, 1, 'Bijo K Binoy', 'bijokbinoy2005@gmail.com', '09400258163', 'India', 'uploads/documents/doc_68eea3aa514244.03529073.png', '', 16000.00, NULL, '2025-10-14 19:25:30', 'Confirmed', 'Walk-in'),
(28, 1, 'Bijo K Binoy', 'bijokbinoy2005@gmail.com', '09400258163', 'India', 'uploads/documents/doc_68fa52333f5476.92621210.jpg', '', 22000.00, NULL, '2025-10-23 16:05:07', 'Confirmed', 'Direct Website'),
(29, 1, 'vasu', 'vasudev@gmail.com', '09400258163', 'India', 'uploads/documents/doc_68fa5297c103b5.80037354.jpg', '', 39400.00, NULL, '2025-10-23 16:06:47', 'Confirmed', 'Travel Agents'),
(30, 1, 'vasu', 'vasudev@gmail.com', '09400258163', 'India', 'uploads/documents/doc_68fa5319ddae14.90732084.jpg', '', 30700.00, NULL, '2025-10-23 16:08:57', 'Confirmed', 'Direct Website'),
(31, 1, 'vasu', 'vasudev@gmail.com', '09400258163', 'India', 'uploads/documents/doc_68fa539e8a2245.37955825.jpg', '', 150000.00, NULL, '2025-10-23 16:11:10', 'Confirmed', 'Direct Website'),
(32, 1, 'vasu', 'vasudev@gmail.com', '09400258163', 'Other', 'uploads/documents/doc_68fa5d1a154dc0.54543746.jpg', '', 24700.00, NULL, '2025-10-23 16:51:38', 'Confirmed', 'Direct Website'),
(33, 1, 'vasu', 'vasudev@gmail.com', '09400258163', 'Other', 'uploads/documents/doc_68fa60d18e32a8.09417256.jpg', '', 22700.00, NULL, '2025-10-23 17:07:29', 'Confirmed', 'Direct Website'),
(34, 1, 'vasu', 'vasudev@gmail.com', '123454321', 'India', 'uploads/documents/doc_68fa61488ef9f2.84949631.jpg', '', 29800.00, 20860.00, '2025-10-23 17:09:28', 'Cancelled', 'Direct Website'),
(35, 3, 'vasu', 'vasudev@gmail.com', '123454321', 'India', 'uploads/documents/doc_68fa71bb4cae75.41559782.jpg', '', 150000.00, 105000.00, '2025-10-23 18:19:39', 'Cancelled', 'Direct Website');

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `bd_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `acc_id` int(11) DEFAULT NULL,
  `program_id` int(11) DEFAULT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`bd_id`, `booking_id`, `acc_id`, `program_id`, `check_in`, `check_out`) VALUES
(96, 20, 8, NULL, '2025-10-11', '2025-10-12'),
(97, 21, 3, 3, '2025-10-16', '2025-10-17'),
(98, 22, 5, 1, '2025-10-14', '2025-10-15'),
(99, 25, 1, 2, '2025-10-13', '2025-10-14'),
(100, 27, NULL, 1, '2025-10-15', '2025-10-16'),
(101, 28, NULL, 3, '2025-10-23', '2025-10-24'),
(102, 29, 3, 3, '2025-10-24', '2025-10-26'),
(103, 30, 3, 3, '2025-10-25', '2025-10-26'),
(105, 32, 3, 1, '2025-10-23', '2025-10-24'),
(106, 33, 5, 1, '2025-10-23', '2025-10-24'),
(107, 34, 2, 1, '2025-10-31', '2025-11-02'),
(108, 35, NULL, 6, '2025-10-24', '2025-10-25');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `image_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_alt` varchar(255) DEFAULT NULL,
  `category` enum('rooms','dining','spa','pool','events') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`image_id`, `image_path`, `image_alt`, `category`) VALUES
(1, '../photos/rm1.jpg', 'Luxury Suite', 'rooms'),
(2, '../photos/rm2.jpg', 'Deluxe Room', 'rooms'),
(3, '../photos/rm3.jpg', 'Presidential Suite', 'rooms'),
(4, '../photos/rm7.jpeg', 'Luxury Suite', 'rooms'),
(5, '../photos/rm4.jpg', 'Deluxe Room', 'rooms'),
(6, '../photos/rm5.jpeg', 'Presidential Suite', 'rooms'),
(7, '../photos/dining1.jpg', 'Fine Dining Restaurant', 'dining'),
(8, '../photos/dining2.jpg', 'Beachfront Bar', 'dining'),
(9, '../photos/dining3.jpg', 'Gourmet Cuisine', 'dining'),
(10, '../photos/dining4.jpg', 'Fine Dining Restaurant', 'dining'),
(11, '../photos/dining5.jpg', 'Beachfront Bar', 'dining'),
(12, '../photos/dining6.jpg', 'Gourmet Cuisine', 'dining'),
(13, '../photos/limited2.jpg', 'Spa Treatment Room', 'spa'),
(14, '../photos/packagewellness.jpg', 'Massage Therapy', 'spa'),
(15, '../photos/blog.jpg', 'Infinity Pool', 'pool'),
(16, '../photos/blog1.png', 'Private Beach', 'pool'),
(17, '../photos/packagefamily.jpg', 'Poolside Cabana', 'pool'),
(18, '../photos/banquent.jpg', 'Wedding Ceremony', 'events');

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `leave_type` varchar(50) NOT NULL DEFAULT 'Other',
  `start_date` date NOT NULL DEFAULT '1970-01-01',
  `end_date` date NOT NULL DEFAULT '1970-01-01',
  `reason` text NOT NULL,
  `contact_info` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `user_id`, `leave_type`, `start_date`, `end_date`, `reason`, `contact_info`, `status`) VALUES
(6, 11, 'Other', '1970-01-01', '1970-01-01', 'Personal work at home.', NULL, 'Pending'),
(7, 12, 'Other', '1970-01-01', '1970-01-01', 'Doctor\'s appointment for a family member.', NULL, 'Approved'),
(8, 16, 'Other', '1970-01-01', '1970-01-01', 'Attending a family function out of town.', NULL, 'Rejected'),
(9, 11, 'Other', '1970-01-01', '1970-01-01', 'Going for a two-day vacation.', NULL, 'Pending'),
(10, 12, 'Other', '1970-01-01', '1970-01-01', 'Feeling unwell, need sick leave.', NULL, 'Approved'),
(11, 2, 'Vacation', '2025-11-20', '2025-11-25', 'Family trip.', 'Available via phone.', 'Approved'),
(12, 11, 'Sick', '2025-10-15', '2025-10-15', 'Feeling unwell, doctor\'s appointment.', 'Not available.', 'Approved'),
(13, 2, 'Personal', '2025-12-01', '2025-12-02', 'Attending a personal event.', 'Emergency contact only.', 'Rejected'),
(14, 2, 'Sick', '2025-10-01', '2025-10-02', 'high fever', '9400258160', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `booking_id`, `user_id`, `amount`, `payment_date`) VALUES
(5, 20, 1, 7200.00, '2025-10-09'),
(9, 34, 1, 29800.00, '2025-10-23'),
(10, 34, 1, 29800.00, '2025-10-23'),
(11, 35, 3, 150000.00, '2025-10-23');

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `program_id` int(11) NOT NULL,
  `type` enum('package','offer','event','function') NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(50) DEFAULT NULL,
  `valid_from` date DEFAULT NULL,
  `valid_to` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`program_id`, `type`, `title`, `description`, `price`, `valid_from`, `valid_to`, `image`) VALUES
(1, 'package', 'Honeymoon Package', 'A romantic getaway for two featuring spa treatments, private candle-lit dinners, and premium ocean-view accommodations.', '16000', NULL, NULL, '../photos/packagehoney.jpg'),
(2, 'package', 'Family Package', 'Fun for the whole family! Includes access to the kids\' club, family-friendly activities, and spacious connecting rooms.', '19000', NULL, NULL, '../photos/blog1.png'),
(3, 'package', 'Wellness Retreat', 'Rejuvenate your mind and body with daily yoga sessions, healthy gourmet meals, and holistic spa therapies.', '22000', NULL, NULL, '../photos/packagewellness.jpg'),
(4, 'event', 'Food Festival', 'Explore a world of flavors with live cooking stations, international cuisines, and special menus crafted by our expert chefs.', '300', '2025-12-15', '2025-12-17', '../photos/dining1.jpg'),
(5, 'event', 'Cultural Shows', 'Experience the rich heritage of Kerala with captivating performances of traditional dance and music.', '300', NULL, NULL, '../photos/event.jpg'),
(6, 'function', 'Wedding Reception', 'Celebrate your special day with our all-inclusive package, featuring a grand banquet hall, custom catering, and elegant decorations.', '150000', NULL, NULL, '../photos/wedding.png'),
(7, 'function', 'Birthday Parties', 'Host an unforgettable birthday bash with themed decorations, fun activities, and a delicious custom cake.', '25000', NULL, NULL, '../photos/function.jpg'),
(8, 'offer', 'Summer Escape Special', 'Beat the heat with our special summer offer. Enjoy cool savings on all rooms plus complimentary chilled beverages.', '30% OFF', '2025-09-14', '2025-10-31', '../photos/limited1.jpg'),
(9, 'offer', 'Weekend Getaway', 'Make the most of your weekend with this short and sweet escape, perfect for a quick recharge.', '25% OFF', NULL, NULL, '../photos/limited2.jpg'),
(10, 'offer', 'Extended Stay Deal', 'Stay longer and save more. Our extended stay package offers great value with home-like comfort and amenities.', '40% OFF', NULL, NULL, '../photos/limited3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `salary_records`
--

CREATE TABLE `salary_records` (
  `salary_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `hire_date` date NOT NULL,
  `payment_date` date NOT NULL,
  `basic_salary` decimal(10,2) NOT NULL,
  `allowances` decimal(10,2) DEFAULT 0.00,
  `deductions` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salary_records`
--

INSERT INTO `salary_records` (`salary_id`, `user_id`, `job_title`, `hire_date`, `payment_date`, `basic_salary`, `allowances`, `deductions`) VALUES
(1, 1, 'Proprietor', '2023-01-15', '2025-09-28', 75000.00, 0.00, 0.00),
(2, 2, 'General Manager', '2023-03-20', '2025-09-28', 55000.00, 0.00, 0.00),
(3, 11, 'Receptionist', '2024-05-10', '2025-08-30', 32000.00, 0.00, 0.00),
(4, 12, 'Housekeeping', '2023-11-01', '2025-08-30', 35000.00, 0.00, 0.00),
(5, 16, 'Receptionist', '2025-10-01', '2025-07-29', 30000.00, 0.00, 0.00),
(7, 2, 'General Manager', '0000-00-00', '2025-10-01', 55000.00, 8250.00, 6600.00),
(8, 17, 'Receptionist', '2025-10-06', '0000-00-00', 30000.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `priority` enum('Low','Medium','High') NOT NULL DEFAULT 'Medium',
  `status` enum('Pending','In Progress','Completed') NOT NULL DEFAULT 'Pending',
  `assigned_to_user_id` int(11) DEFAULT NULL,
  `assigned_by_user_id` int(11) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `title`, `description`, `priority`, `status`, `assigned_to_user_id`, `assigned_by_user_id`, `due_date`, `created_at`) VALUES
(1, 'Prepare VIP Welcome Package', 'Ensure all items are included for Room 301 (Champagne, fruits, chocolates)', 'High', 'Pending', 2, 1, '2025-10-24 15:00:00', '2025-10-24 08:06:16'),
(2, 'Check-In Coordination', 'Assist with group check-in at 2 PM (12 rooms, Wellington Corp.)', 'Medium', 'Completed', 2, 1, '2025-10-24 14:00:00', '2025-10-24 08:06:16'),
(3, 'Update Guest Records', 'Enter details for new arrivals and update preferences', 'Low', 'Pending', 2, 1, '2025-10-24 17:00:00', '2025-10-24 08:06:16'),
(4, 'Assign Room 102 clean', '', 'Medium', 'Pending', 2, 1, '2025-10-24 17:53:00', '2025-10-24 11:23:33');

-- --------------------------------------------------------

--
-- Table structure for table `upcoming`
--

CREATE TABLE `upcoming` (
  `project_id` int(11) NOT NULL,
  `status` enum('planning','in-progress','opening-soon') NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_alt` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `est_completion` varchar(50) DEFAULT NULL,
  `modal_target` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `upcoming`
--

INSERT INTO `upcoming` (`project_id`, `status`, `image_path`, `image_alt`, `title`, `description`, `est_completion`, `modal_target`) VALUES
(1, 'opening-soon', '../photos/upcoming3.jpg', 'Overwater Villas', 'Overwater Villas Expansion', 'Introducing 12 new ultra-luxurious villas suspended over serene waters, each with a private infinity plunge pool.', 'Q4 2025', '#projectModal1'),
(2, 'in-progress', '../photos/upcoming5.jpg', 'Wellness Retreat', 'Luxury Wellness Retreat Upgrade', 'A complete revitalization of our spa, introducing holistic therapies, and hydrotherapy circuits.', 'Q1 2026', '#projectModal2'),
(3, 'planning', '../photos/upcoming4.jpg', 'Rooftop Restaurant', 'Rooftop Fine Dining Experience', 'A new sky-high culinary destination offering 360-degree views, a curated menu by a celebrity chef, and a starlit ambiance.', 'Q3 2026', '#projectModal3'),
(4, 'in-progress', '../photos/upcoming2.jpg', 'Water Park', 'New Water Adventure Park', 'Thrills for the whole family with state-of-the-art slides, a lazy river, and a dedicated kids\' splash zone.', 'Q2 2026', '#projectModal4'),
(5, 'opening-soon', '../photos/upcoming1.jpg', 'Smart Room', 'Smart Room Automation', 'Integrating cutting-edge tech in all rooms for voice-controlled lighting, climate, and in-room entertainment.', 'Q4 2025', '#projectModal5');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `role` enum('guest','staff','admin') NOT NULL DEFAULT 'guest'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `department`, `password`, `mobile_number`, `role`) VALUES
(1, 'bijokbinoy2005@gmail.com', 'bijo', NULL, '$2y$10$6YtOwCvK8rWzLxqhWzF0ROstccdVa77ldDSora.jOzxS662Y0.eIW', NULL, 'admin'),
(2, 'noyal@gmail.com', 'noyal', 'Management', '$2y$10$mNM/CTcDtH55/KH3tgF.zubeYl46B2ge.CCjlzXhdFRQneHz4UBHe', NULL, 'staff'),
(3, 'vasudev@gmail.com', 'vasudev', NULL, '$2y$10$Fav94aNAKC2pvaFRlbXDfe7kFT0FWe4LUvcmUZt/.lDhwmi9RyMCe', NULL, 'guest'),
(4, 'neha.eldhose@example.com', 'Neha Eldhose', NULL, '$2y$10$N5Dqokps.FQ5V2i.KX5VT.DhHXV.f2NaEkXfQ3sTpbvaEAXIwodie', '+91 98765 43213', 'guest'),
(5, 'paul.kurian@example.com', 'Paul Kurian', NULL, '$2y$10$Wk3qGXfG2BNdlyQKtfnTxOqtfHHYYYuk24dP/tr63fURwQRWHfiHG', '+91 98765 43214', 'guest'),
(6, 'devika.binu@example.com', 'Devika Binu', NULL, 'password123', '+91 98765 43217', 'guest'),
(7, 'sreelakshmi.tv@example.com', 'Sreelakshmi T V', NULL, 'password123', '+91 98765 43216', 'guest'),
(8, 'tom.jose@example.com', 'Tom Jose', NULL, 'password123', '+91 98765 43215', 'guest'),
(9, 'albin.mathai@example.com', 'Albin Mathai', NULL, 'password123', '+91 98765 43218', 'guest'),
(10, 'jithin.reji@example.com', 'Jithin Reji', NULL, 'password123', '+91 98765 43219', 'guest'),
(11, 'anand.k@royalstar.com', 'Anand Krishnan', 'Management', 'staffpass123', '+91 99887 76655', 'staff'),
(12, 'priya.m@royalstar.com', 'Priya Menon', 'Housekeeping', 'staffpass123', '+91 99887 76654', 'staff'),
(16, 'aswin@gmail.com', 'aswin', 'Front Office', '$2y$10$MwjBmlor8kpxzbQIAqVX8Omj9OoD1y67HE.0VacWWD76g9/JWNyX2', '9876543210', 'staff'),
(17, 'johnmon@gmail.com', 'johnmon vk', NULL, '$2y$10$mKzi589kmmGn.QDSrGL87e4zSQcSK3aUdbZwUSU6uIBp6WGZ9DXh2', '9074935562', 'staff'),
(18, 'devan@gmail.com', 'devan', NULL, '$2y$10$/MOyjiSvRB7nDChsR/15pu6UVPCKd29Q368qEvRH3dqg75N8t5OlW', '9400258167', 'guest'),
(20, 'adithyan@gmail.com', 'adithyan', NULL, '$2y$10$wF3G5mPyht3onjKia0GMhuAL/Kwi5B5FdlAWPWB7zUOxQMjJo4Ije', '9846829388', 'guest'),
(21, 'alan@gmail.com', 'alan', NULL, '$2y$10$jElTsmEurTasBsq7gRejEe9FwkKNgXUtAAk9kPUlUqerU2oVZIs/6', '9074527127', 'guest');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accommodations`
--
ALTER TABLE `accommodations`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`award_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`bd_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `acc_id` (`acc_id`),
  ADD KEY `program_id` (`program_id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`program_id`);

--
-- Indexes for table `salary_records`
--
ALTER TABLE `salary_records`
  ADD PRIMARY KEY (`salary_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `assigned_to_user_id` (`assigned_to_user_id`),
  ADD KEY `assigned_by_user_id` (`assigned_by_user_id`);

--
-- Indexes for table `upcoming`
--
ALTER TABLE `upcoming`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accommodations`
--
ALTER TABLE `accommodations`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `awards`
--
ALTER TABLE `awards`
  MODIFY `award_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `bd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `program_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `salary_records`
--
ALTER TABLE `salary_records`
  MODIFY `salary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `upcoming`
--
ALTER TABLE `upcoming`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_details_ibfk_3` FOREIGN KEY (`program_id`) REFERENCES `programs` (`program_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_booking_accommodation` FOREIGN KEY (`acc_id`) REFERENCES `accommodations` (`acc_id`);

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE;

--
-- Constraints for table `salary_records`
--
ALTER TABLE `salary_records`
  ADD CONSTRAINT `salary_records_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`assigned_to_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`assigned_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
