-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2018 at 10:45 PM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rka`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_photos`
--

CREATE TABLE IF NOT EXISTS `access_photos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `request_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `address_books`
--

CREATE TABLE IF NOT EXISTS `address_books` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` longtext NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email_address` varchar(100) DEFAULT NULL,
  `primary_address` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `athlete_types`
--

CREATE TABLE IF NOT EXISTS `athlete_types` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `block_users`
--

CREATE TABLE IF NOT EXISTS `block_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `block_profile` int(11) NOT NULL,
  `description` int(11) DEFAULT NULL,
  `request_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `approval_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL,
  `country_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `favorite_users`
--

CREATE TABLE IF NOT EXISTS `favorite_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `favorite_profile` int(11) NOT NULL,
  `visible` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment_accounts`
--

CREATE TABLE IF NOT EXISTS `payment_accounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_email` varchar(255) NOT NULL,
  `account_api` varchar(255) DEFAULT NULL,
  `account_password` varchar(255) DEFAULT NULL,
  `account_signature` varchar(255) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `billing_address` longtext,
  `country` int(11) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `zip` int(11) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `card_no` varchar(50) DEFAULT NULL,
  `card_brand` varchar(50) DEFAULT NULL,
  `expiry_month` varchar(20) DEFAULT NULL,
  `expiry_year` varchar(20) DEFAULT NULL,
  `cvv_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `report_users`
--

CREATE TABLE IF NOT EXISTS `report_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` longtext,
  `report_profile` int(11) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `approval_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `search_details`
--

CREATE TABLE IF NOT EXISTS `search_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `search_name` varchar(255) NOT NULL,
  `search_criteria` varchar(255) NOT NULL,
  `selected_option` varchar(100) DEFAULT NULL,
  `no_of_items` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `trainer_types`
--

CREATE TABLE IF NOT EXISTS `trainer_types` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `trainer_visibilities`
--

CREATE TABLE IF NOT EXISTS `trainer_visibilities` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trainer_profile` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_credentials`
--

CREATE TABLE IF NOT EXISTS `user_credentials` (
  `id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `social_id` varchar(255) DEFAULT NULL,
  `social_source` varchar(100) DEFAULT NULL,
  `secret_question` varchar(255) DEFAULT NULL,
  `secret_answer` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `reset_status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_credentials`
--

INSERT INTO `user_credentials` (`id`, `profile_id`, `user_id`, `username`, `password`, `social_id`, `social_source`, `secret_question`, `secret_answer`, `status`, `reset_status`) VALUES
(1, 1, 1, 'admin', 'e6e061838856bf47e1de730719fb2609', NULL, NULL, NULL, NULL, 1, 0),
(2, 2, 2, 'debdas', 'be16e981f3bd283a0401aff140d2340a', NULL, NULL, NULL, NULL, 1, 0),
(3, 3, 3, 'ram', '3db66ceb605c1bcb779c63e180c4f2d0', NULL, NULL, NULL, NULL, 1, 0),
(4, 4, 4, 'steve', '50af985e0b3f269fad93db694a4775d8', NULL, NULL, NULL, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE IF NOT EXISTS `user_details` (
  `id` int(11) NOT NULL,
  `athlete_type` int(11) DEFAULT NULL,
  `trainer_type` int(11) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `profile_name` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `profile_heading` varchar(255) DEFAULT NULL,
  `about_me` longtext,
  `looking_tags` longtext,
  `look_up` varchar(255) DEFAULT NULL,
  `premium​_user` int(1) NOT NULL DEFAULT '0',
  `online_status` int(1) NOT NULL DEFAULT '0',
  `last_active` datetime DEFAULT NULL,
  `video_link` longtext
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `athlete_type`, `trainer_type`, `first_name`, `last_name`, `profile_name`, `date_of_birth`, `gender`, `profile_heading`, `about_me`, `looking_tags`, `look_up`, `premium​_user`, `online_status`, `last_active`, `video_link`) VALUES
(1, NULL, NULL, 'Admin', 'Admin', NULL, '1990-01-09', 'Male', '', NULL, NULL, NULL, 0, 0, NULL, NULL),
(2, 1, NULL, 'Debdas', 'Bakshi', 'Deb''s Profile', '1987-02-02', 'Male', 'This is Debdas Bakshi''s Profile', 'This is Debdas Bakshi''s Profile', 'Racing Partners', 'Test String', 0, 0, NULL, 'https://www.youtube.com'),
(3, 2, NULL, 'Ram', 'Roy', 'Test Profile', '1997-02-04', 'Male', 'This is a test profile', 'This is a test profile', 'Aspiring Athletes', 'Test String', 0, 0, NULL, NULL),
(4, 3, NULL, 'Steve', 'Brown', 'Recovery Specialist Account', '1985-04-07', 'Male', 'Recovery Specialist Account Profile', 'This is a test profile', 'Repair / recovery specialists', 'Test String', 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_fields`
--

CREATE TABLE IF NOT EXISTS `user_fields` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `looking_for` varchar(255) NOT NULL,
  `training_philosophy` varchar(255) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `certifications` varchar(255) DEFAULT NULL,
  `body_type` varchar(100) NOT NULL,
  `height` varchar(20) NOT NULL,
  `fitness_level` varchar(50) NOT NULL,
  `fitness_goals` varchar(255) NOT NULL,
  `scheduled_races` varchar(100) DEFAULT NULL,
  `avg_swim_time` varchar(50) DEFAULT NULL,
  `avg_bike_speed` varchar(50) DEFAULT NULL,
  `avg_run_time` varchar(50) DEFAULT NULL,
  `athletic_achievements` varchar(255) DEFAULT NULL,
  `gym_memberships` varchar(100) DEFAULT NULL,
  `outdoor_locations` varchar(255) DEFAULT NULL,
  `personal_trainers` longtext,
  `medical_issues` varchar(255) DEFAULT NULL,
  `relationship` varchar(100) DEFAULT NULL,
  `children` varchar(100) DEFAULT NULL,
  `language` varchar(100) DEFAULT NULL,
  `ethnicity` varchar(100) NOT NULL,
  `workout_info_location` varchar(255) DEFAULT NULL,
  `rate_expectations` varchar(100) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `rate_description` varchar(255) DEFAULT NULL,
  `fitness_budget` varchar(255) DEFAULT NULL,
  `allowance_expectations` varchar(255) DEFAULT NULL,
  `smokes` varchar(50) DEFAULT NULL,
  `drinks` varchar(50) DEFAULT NULL,
  `education` varchar(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `income` decimal(10,2) DEFAULT NULL,
  `net_worth` decimal(10,2) DEFAULT NULL,
  `lifestyle` varchar(255) DEFAULT NULL,
  `triathlon_club` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_fields`
--

INSERT INTO `user_fields` (`id`, `user_id`, `looking_for`, `training_philosophy`, `experience`, `certifications`, `body_type`, `height`, `fitness_level`, `fitness_goals`, `scheduled_races`, `avg_swim_time`, `avg_bike_speed`, `avg_run_time`, `athletic_achievements`, `gym_memberships`, `outdoor_locations`, `personal_trainers`, `medical_issues`, `relationship`, `children`, `language`, `ethnicity`, `workout_info_location`, `rate_expectations`, `rate`, `rate_description`, `fitness_budget`, `allowance_expectations`, `smokes`, `drinks`, `education`, `occupation`, `income`, `net_worth`, `lifestyle`, `triathlon_club`) VALUES
(1, 2, 'Runner|Marathoner|Bicyclist', NULL, NULL, NULL, 'Athletic', '5''11"', '4 = Less Than Average Fit with Occasional Activity', 'ELITE CHAMPION', '', '8 min/mile', 'I don''t know', 'I don''t know', '', '', '', '', '', 'Single', '0', 'Espanol', 'Latin/Hispanic', NULL, NULL, NULL, NULL, 'Minimal (Up to $500 monthly)', 'Practical (Up to $1000 monthly)', 'Light Smoker', 'Social Drinker', 'Bachelors Degree', 'Self Service', NULL, NULL, NULL, ''),
(2, 3, 'Runner|Triathlete|Tough Mudder competitor', NULL, NULL, NULL, 'N/A', 'N/A', 'N/A', 'N/A', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 'Fixed Rates', '12.00', 'Fixed Rate', NULL, NULL, NULL, NULL, 'N/A', 'N/A', NULL, NULL, NULL, NULL),
(3, 4, 'Runner|Triathlete|Tough Mudder competitor', NULL, NULL, NULL, 'Slim', '5''10"', '4 = Less Than Average Fit with Occasional Activity', 'N/A', NULL, '21', '15', '17', NULL, NULL, NULL, NULL, 'None', NULL, NULL, NULL, 'Asian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, 'North Club');

-- --------------------------------------------------------

--
-- Table structure for table `user_locations`
--

CREATE TABLE IF NOT EXISTS `user_locations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `latitude` varchar(100) DEFAULT NULL,
  `longitude` varchar(100) DEFAULT NULL,
  `is_primary` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_locations`
--

INSERT INTO `user_locations` (`id`, `user_id`, `location`, `latitude`, `longitude`, `is_primary`) VALUES
(1, 2, 'British Columbia, Canada', '53.7266683', '-127.6476205', 1),
(2, 2, 'San Francisco, CA, USA', '37.7749295', '-122.4194155', 0),
(3, 2, 'Pariser Platz, Berlin, Germany', '52.5158907', '13.3789525', 0),
(4, 3, 'British Columbia, Canada', '53.7266683', '-127.6476205', 0),
(5, 3, 'San Francisco, CA, USA', '37.7749295', '-122.4194155', 0),
(6, 3, 'Pariser Platz, Berlin, Germany', '52.5158907', '13.3789525', 1),
(7, 4, 'British Columbia, Canada', '53.7266683', '-127.6476205', 1),
(8, 3, 'San Francisco, CA, USA', '37.7749295', '-122.4194155', 1),
(9, 3, 'Pariser Platz, Berlin, Germany', '52.5158907', '13.3789525', 0),
(11, 4, 'Kolkata, West Bengal', '53.7266683', '-127.6476205', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_messages`
--

CREATE TABLE IF NOT EXISTS `user_messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `description` longtext,
  `execute_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_offers`
--

CREATE TABLE IF NOT EXISTS `user_offers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `offer_type` varchar(255) NOT NULL,
  `offer_code` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `expiry_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_payments`
--

CREATE TABLE IF NOT EXISTS `user_payments` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `order_no` varchar(100) NOT NULL,
  `payment_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `completion_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` decimal(10,2) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `transaction_type` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_photos`
--

CREATE TABLE IF NOT EXISTS `user_photos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `profile_image` longtext NOT NULL,
  `thumbnail_image` longtext,
  `is_public` int(1) NOT NULL DEFAULT '0',
  `is_primary` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_photos`
--

INSERT INTO `user_photos` (`id`, `user_id`, `profile_image`, `thumbnail_image`, `is_public`, `is_primary`) VALUES
(1, 2, '5022_1531150357_athletes-celebrating.jpg', NULL, 1, 0),
(2, 2, '8769_1531150357_athletes-celebrating2.jpg', NULL, 1, 0),
(3, 2, '9734_1531150357_stock-photo-gym-fitness-sport-fit-couple-working-out-battle-rope-exercise-banner-panorama-woman-and-man-cross-708317974.jpg', NULL, 0, 0),
(4, 2, '2943_1531150357_stock-photo-motivated-couple-of-runners-celebrating-their-new-record-sportive-people-training-outdoors-1089514580.jpg', NULL, 0, 0),
(5, 3, '3124_1531150412_stock-photo-gym-fitness-sport-fit-couple-working-out-battle-rope-exercise-banner-panorama-woman-and-man-cross-708317974.jpg', NULL, 1, 0),
(6, 3, '3643_1531150412_stock-photo-motivated-couple-of-runners-celebrating-their-new-record-sportive-people-training-outdoors-1089514580.jpg', NULL, 1, 0),
(7, 3, '7598_1531150412_athletes-celebrating.jpg', NULL, 0, 0),
(8, 3, '4381_1531150412_athletes-celebrating2.jpg', NULL, 0, 0),
(9, 4, '4935_1531150479_athletes-celebrating.jpg', NULL, 1, 0),
(10, 4, '1514_1531150479_athletes-celebrating2.jpg', NULL, 1, 0),
(11, 4, '5255_1531150480_stock-photo-portrait-of-young-runners-enjoying-workout-on-the-sea-front-path-along-the-shoreline-running-club-364241294.jpg', NULL, 0, 0),
(12, 4, '2543_1531150480_stock-photo-sporty-couple-doing-plank-exercise-in-gym-578059885.jpg', NULL, 0, 0),
(13, 2, '5632_1531153784_lady-jumping.jpg', NULL, 1, 0),
(14, 2, '1990_1531153784_stock-photo-portrait-of-young-runners-enjoying-workout-on-the-sea-front-path-along-the-shoreline-running-club-364241294.jpg', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(11) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `description` longtext
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `profile`, `description`) VALUES
(1, 'Admin', 'Admin Profile'),
(2, 'Athlete/Training Partner', 'A person who is seeking personal training,inspiration, support and help from training partners / Anyone who can inspire an Athlete, and may or may not expect an allowance'),
(3, 'Personal Trainer', 'Specialized personal trainer seeks client to train and travels directly to the client within his or her vicinity'),
(4, 'Recovery Specialist', 'Repair / Recovery Specialist');

-- --------------------------------------------------------

--
-- Table structure for table `user_rates`
--

CREATE TABLE IF NOT EXISTS `user_rates` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `max_rate` decimal(10,2) DEFAULT NULL,
  `min_rate` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_requests`
--

CREATE TABLE IF NOT EXISTS `user_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `viewed_users`
--

CREATE TABLE IF NOT EXISTS `viewed_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `viewed_profile` int(11) NOT NULL,
  `visible` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `visibility_details`
--

CREATE TABLE IF NOT EXISTS `visibility_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `visit_profiles`
--

CREATE TABLE IF NOT EXISTS `visit_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `visited_user` int(11) NOT NULL,
  `visit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_photos`
--
ALTER TABLE `access_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `address_books`
--
ALTER TABLE `address_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country` (`country`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `athlete_types`
--
ALTER TABLE `athlete_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `block_users`
--
ALTER TABLE `block_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `block_profile` (`block_profile`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorite_users`
--
ALTER TABLE `favorite_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `favorite_profile` (`favorite_profile`);

--
-- Indexes for table `payment_accounts`
--
ALTER TABLE `payment_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `country` (`country`);

--
-- Indexes for table `report_users`
--
ALTER TABLE `report_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `report_profile` (`report_profile`);

--
-- Indexes for table `search_details`
--
ALTER TABLE `search_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `trainer_types`
--
ALTER TABLE `trainer_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainer_visibilities`
--
ALTER TABLE `trainer_visibilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `trainer_profile` (`trainer_profile`);

--
-- Indexes for table `user_credentials`
--
ALTER TABLE `user_credentials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profile_id` (`profile_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_fields`
--
ALTER TABLE `user_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_locations`
--
ALTER TABLE `user_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_messages`
--
ALTER TABLE `user_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `user_offers`
--
ALTER TABLE `user_offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `partner_id` (`partner_id`);

--
-- Indexes for table `user_payments`
--
ALTER TABLE `user_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `user_photos`
--
ALTER TABLE `user_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_rates`
--
ALTER TABLE `user_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_requests`
--
ALTER TABLE `user_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `viewed_users`
--
ALTER TABLE `viewed_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `viewed_profile` (`viewed_profile`);

--
-- Indexes for table `visibility_details`
--
ALTER TABLE `visibility_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `visit_profiles`
--
ALTER TABLE `visit_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `visited_user` (`visited_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_photos`
--
ALTER TABLE `access_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `address_books`
--
ALTER TABLE `address_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `athlete_types`
--
ALTER TABLE `athlete_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `block_users`
--
ALTER TABLE `block_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `favorite_users`
--
ALTER TABLE `favorite_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `payment_accounts`
--
ALTER TABLE `payment_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `report_users`
--
ALTER TABLE `report_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `search_details`
--
ALTER TABLE `search_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trainer_types`
--
ALTER TABLE `trainer_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trainer_visibilities`
--
ALTER TABLE `trainer_visibilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_credentials`
--
ALTER TABLE `user_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_fields`
--
ALTER TABLE `user_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_locations`
--
ALTER TABLE `user_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `user_messages`
--
ALTER TABLE `user_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_offers`
--
ALTER TABLE `user_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_payments`
--
ALTER TABLE `user_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_photos`
--
ALTER TABLE `user_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_rates`
--
ALTER TABLE `user_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_requests`
--
ALTER TABLE `user_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `viewed_users`
--
ALTER TABLE `viewed_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `visibility_details`
--
ALTER TABLE `visibility_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `visit_profiles`
--
ALTER TABLE `visit_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `access_photos`
--
ALTER TABLE `access_photos`
  ADD CONSTRAINT `access_photos_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `access_photos_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `address_books`
--
ALTER TABLE `address_books`
  ADD CONSTRAINT `address_books_ibfk_1` FOREIGN KEY (`country`) REFERENCES `countries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `address_books_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `block_users`
--
ALTER TABLE `block_users`
  ADD CONSTRAINT `block_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `block_users_ibfk_2` FOREIGN KEY (`block_profile`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `favorite_users`
--
ALTER TABLE `favorite_users`
  ADD CONSTRAINT `favorite_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `favorite_users_ibfk_2` FOREIGN KEY (`favorite_profile`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `payment_accounts`
--
ALTER TABLE `payment_accounts`
  ADD CONSTRAINT `payment_accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `payment_accounts_ibfk_2` FOREIGN KEY (`country`) REFERENCES `countries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `report_users`
--
ALTER TABLE `report_users`
  ADD CONSTRAINT `report_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `report_users_ibfk_2` FOREIGN KEY (`report_profile`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `search_details`
--
ALTER TABLE `search_details`
  ADD CONSTRAINT `search_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `trainer_visibilities`
--
ALTER TABLE `trainer_visibilities`
  ADD CONSTRAINT `trainer_visibilities_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `trainer_visibilities_ibfk_2` FOREIGN KEY (`trainer_profile`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_credentials`
--
ALTER TABLE `user_credentials`
  ADD CONSTRAINT `user_credentials_ibfk_1` FOREIGN KEY (`profile_id`) REFERENCES `user_profiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_credentials_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_fields`
--
ALTER TABLE `user_fields`
  ADD CONSTRAINT `user_fields_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_locations`
--
ALTER TABLE `user_locations`
  ADD CONSTRAINT `user_locations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_messages`
--
ALTER TABLE `user_messages`
  ADD CONSTRAINT `user_messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_offers`
--
ALTER TABLE `user_offers`
  ADD CONSTRAINT `user_offers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_offers_ibfk_2` FOREIGN KEY (`partner_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_payments`
--
ALTER TABLE `user_payments`
  ADD CONSTRAINT `user_payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_payments_ibfk_2` FOREIGN KEY (`trainer_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_payments_ibfk_3` FOREIGN KEY (`request_id`) REFERENCES `user_requests` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_photos`
--
ALTER TABLE `user_photos`
  ADD CONSTRAINT `user_photos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_rates`
--
ALTER TABLE `user_rates`
  ADD CONSTRAINT `user_rates_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_requests`
--
ALTER TABLE `user_requests`
  ADD CONSTRAINT `user_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_requests_ibfk_2` FOREIGN KEY (`trainer_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `viewed_users`
--
ALTER TABLE `viewed_users`
  ADD CONSTRAINT `viewed_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `viewed_users_ibfk_2` FOREIGN KEY (`viewed_profile`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `visibility_details`
--
ALTER TABLE `visibility_details`
  ADD CONSTRAINT `visibility_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `visit_profiles`
--
ALTER TABLE `visit_profiles`
  ADD CONSTRAINT `visit_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `visit_profiles_ibfk_2` FOREIGN KEY (`visited_user`) REFERENCES `user_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
