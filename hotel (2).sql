-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2024 at 06:59 PM
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
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `days` int(11) NOT NULL,
  `number_of_rooms` int(11) NOT NULL,
  `bed_selection` varchar(255) NOT NULL,
  `smoke` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `bring_car` varchar(3) NOT NULL,
  `additional_requests` varchar(255) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `car_plates` varchar(255) DEFAULT NULL,
  `payment_status` varchar(20) NOT NULL,
  `booking_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `email`, `room_id`, `check_in_date`, `check_out_date`, `days`, `number_of_rooms`, `bed_selection`, `smoke`, `first_name`, `last_name`, `phone_number`, `bring_car`, `additional_requests`, `total_amount`, `created_at`, `car_plates`, `payment_status`, `booking_status`) VALUES
(1, 'lieweden03@gmail.com', 1, '2024-07-18', '2024-07-19', 1, 1, '2 Single Beds', 'Non-Smoking', 'Eden', 'Liew', '01128220633', 'Yes', '[{\"extra_bed\":\"Yes\",\"bed_quantity\":\"1\",\"add_breakfast\":\"No\",\"breakfast_quantity\":0}]', 310.00, '2024-07-17 22:45:09', 'JJX 4042', 'Success', 'Pending'),
(2, 'lieweden03@gmail.com', 1, '2024-07-08', '2024-07-09', 1, 1, '2 Single Beds', 'Non-Smoking', 'Eden', 'Liew', '01128220633', 'Yes', '[{\"extra_bed\":\"Yes\",\"bed_quantity\":\"1\",\"add_breakfast\":\"Yes\",\"breakfast_quantity\":\"1\"}]', 345.00, '2024-07-17 22:54:17', 'JUY 9155', 'Success', 'Pending'),
(3, 'liewdaphne07@gmail.com', 1, '2024-07-18', '2024-07-19', 1, 2, '1 Double Bed', 'Non-Smoking', 'Daphne', 'Liew', '0177820611', 'Yes', '[{\"extra_bed\":\"Yes\",\"bed_quantity\":\"1\",\"add_breakfast\":\"Yes\",\"breakfast_quantity\":\"1\"},{\"extra_bed\":\"Yes\",\"bed_quantity\":\"1\",\"add_breakfast\":\"Yes\",\"breakfast_quantity\":\"1\"}]', 690.00, '2024-07-19 16:33:08', 'JUY9155,JJX4042', 'Success', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_type` varchar(255) NOT NULL,
  `room_level` int(3) NOT NULL,
  `room_price` decimal(10,2) NOT NULL,
  `room_features` text DEFAULT NULL,
  `room_facilities` text DEFAULT NULL,
  `room_size` varchar(50) DEFAULT NULL,
  `room_availability` int(11) DEFAULT NULL,
  `room_description` text DEFAULT NULL,
  `room_images` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_type`, `room_level`, `room_price`, `room_features`, `room_facilities`, `room_size`, `room_availability`, `room_description`, `room_images`) VALUES
(1, 'Standard Room', 7, 300.00, '2 Single Beds, Smoking, Non-Smoking, 1 Double Bed', 'Hair Dryer, Private Bathroom, Toiletries, Towels, Telephone, Fan, Satellite/cable channels, Air Conditioning, Blackout curtains, Slippers, Mineral Water, Refrigerator, Desk, Window, Closet, Clothes Rack, Ironing Facilities, Safety Box', '19 m²/205 ft²', 8, 'Discover comfort and convenience in our Standard Room, ideal for both leisure and business travelers. This room features your choice of 1 double bed or 2 single beds, available in smoking and non-smoking options to suit your preference. Enjoy essential amenities and a welcoming ambiance, ensuring a relaxing stay whether you\'re here for a short visit or an extended stay.', 'standard1.webp,standard2.jpg,standard3.jpg,standard4.webp,standard5.jpg'),
(2, 'Deluxe Room', 6, 340.00, 'Smoking, Non-Smoking, 1 Queen Bed, 2 Single Bed', 'Hair Dryer, Private Bathroom, Toiletries, Towels, Telephone, Fan, Satellite/cable channels, Blackout curtains, Slippers, Refrigerator, Desk, Safety Box, Electric Kettle, Air conditioning, Free Mineral Water, Ironing facilities', '17 m²/183 ft²', 10, 'Experience the perfect blend of comfort and luxury in our Deluxe Room, designed to cater to both leisure and business travelers. This spacious room offers the choice of a queen bed or two single beds, along with smoking and non-smoking options to suit your preference. Enjoy modern amenities and a cozy atmosphere, making your stay both convenient and relaxing. Whether you are here for a short stay or an extended visit, our Deluxe Room provides the ideal setting for a memorable stay.', 'deluxe1.webp,deluxe2.jpg,deluxe3.jpg,deluxe4.jpg,deluxe5.webp'),
(3, 'Triple Room', 5, 500.00, '1 Queen Bed, 1 Single Bed, Smoking, Non-Smoking', 'Mobility accessibility, Hair dryer, Private bathroom, Toiletries, Towels, Satellite/cable channels, Telephone, Fan, Slippers, Air conditioning, Coffee/tea maker, Mineral Water, Refrigerator, Daily housekeeping, Desk, Window, Closet, Ironing facilities, Safety Box', '17 m²/183 ft²', 10, 'Experience comfort and convenience in our well-appointed Triple Room, designed to cater to the needs of small groups or families. This room offers a perfect blend of functionality and style, ensuring a pleasant and memorable stay.', 'triple1.jpg,triple2.jpg,triple3.webp,triple4.jpg'),
(4, 'Family Suite Room', 4, 1000.00, '3 Queen Beds, Outdoor View, Free Wi-Fi, Smoking, Non-Smoking', 'Hair Dryer, Private Bathroom, Toiletries, Towels, Telephone, Fan, Satellite/cable channels, Slippers, Wake-up service, Air conditioning, Mineral Water, Refrigerator, Desk, Window, Baby Cot (Upon Request), Safety Box, Safety/security feature', '29 m²/312 ft²', 5, 'Experience unparalleled luxury and comfort in our Family Suite Room, designed to cater to all your needs and provide an unforgettable stay. Perfect for families, this spacious suite offers a harmonious blend of modern amenities and elegant decor.', 'family-suite1.webp,family-suite2.webp,family-suite3.webp,family-suite4.webp,family-suite5.jpg,family-suite6.webp');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(6) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `staff_id`, `first_name`, `last_name`, `email`, `phone_number`, `password`, `role`) VALUES
(1, 'A00001', 'Eden', 'Liew', 'b2345dit@mdis.edu.my', '01128220633', 'Ly7288128', 'Admin'),
(2, 'S00002', 'Zhe Kai', 'Lau', 'b2342dit@mdis.edu.my', '0187781382', 'Zhekai1382', 'Staff'),
(3, 'S00003', 'Joanne', 'Liew', 'liewjoanne05@gmail.com', '0177820611', 'Joanne0511', 'Staff'),
(4, 'A00004', 'Daphne', 'Liew', 'liewdaphne07@gmail.com', '0127288128', 'Daphne0305', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `password`) VALUES
(2, 'Jack', 'Liew', 'jackliew4466@gmail.com', '01128220633', '$2y$10$cumxT3ZOe2F6LcN8WCRahe6PbJN4x3/NzYRlMZL1Ew6QeLUXBwuXm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_id` (`staff_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`) USING BTREE,
  ADD UNIQUE KEY `phone_number` (`phone_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `room_id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
