-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2024 at 10:02 PM
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
  `payment_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_type` varchar(255) NOT NULL,
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

INSERT INTO `rooms` (`room_id`, `room_type`, `room_price`, `room_features`, `room_facilities`, `room_size`, `room_availability`, `room_description`, `room_images`) VALUES
(1, 'Standard Room', 300.00, '1 Double Bed, 2 Single Beds, Smoking, Non-Smoking', 'Hair Dryer, Private Bathroom, Toiletries, Towels, Telephone, Fan, Satellite/cable channels, Air Conditioning, Blackout curtains, Slippers, Mineral Water, Refrigerator, Desk, Window, Closet, Clothes Rack, Ironing Facilities, Safety Box', '19 m²/205 ft²', 10, 'Discover comfort and convenience in our Standard Room, ideal for both leisure and business travelers. This room features your choice of 1 double bed or 2 single beds, available in smoking and non-smoking options to suit your preference. Enjoy essential amenities and a welcoming ambiance, ensuring a relaxing stay whether you\'re here for a short visit or an extended stay.', 'standard1.webp,standard2.jpg,standard3.jpg,standard4.webp,standard5.jpg'),
(2, 'Deluxe Room', 340.00, '1 Queen Bed, 2 Single Bed, Smoking, Non-Smoking', 'Electric Kettle, Hair Dryer, Private Bathroom, Toiletries, Towels, Satellite/cable channels, Telephone, Air conditioning, Blackout curtains, Fan, Slippers, Free Mineral Water, Refrigerator, Desk, Ironing facilities, Safety Box', '17 m²/183 ft²', 10, 'Experience the perfect blend of comfort and luxury in our Deluxe Room, designed to cater to both leisure and business travelers. This spacious room offers the choice of a queen bed or two single beds, along with smoking and non-smoking options to suit your preference. Enjoy modern amenities and a cozy atmosphere, making your stay both convenient and relaxing. Whether you are here for a short stay or an extended visit, our Deluxe Room provides the ideal setting for a memorable stay.', 'deluxe1.webp,deluxe2.jpg,deluxe3.jpg,deluxe4.jpg,deluxe5.webp'),
(3, 'Triple Room', 500.00, '1 Queen Bed, 1 Single Bed, Smoking, Non-Smoking', 'Mobility accessibility, Hair dryer, Private bathroom, Toiletries, Towels, Satellite/cable channels, Telephone, Fan, Slippers, Air conditioning, Coffee/tea maker, Mineral Water, Refrigerator, Daily housekeeping, Desk, Window, Closet, Ironing facilities, Safety Box', '17 m²/183 ft²', 10, 'Experience comfort and convenience in our well-appointed Triple Room, designed to cater to the needs of small groups or families. This room offers a perfect blend of functionality and style, ensuring a pleasant and memorable stay.', 'triple1.jpg,triple2.jpg,triple3.webp,triple4.jpg'),
(4, 'Family Suite Room', 1000.00, '3 Queen Beds, Outdoor View, Free Wi-Fi, Smoking, Non-Smoking', 'Hair Dryer, Private Bathroom, Toiletries, Towels, Telephone, Fan, Satellite/cable channels, Slippers, Wake-up service, Air conditioning, Mineral Water, Refrigerator, Desk, Window, Baby Cot (Upon Request), Safety Box, Safety/security feature', '29 m²/312 ft²', 5, 'Experience unparalleled luxury and comfort in our Family Suite Room, designed to cater to all your needs and provide an unforgettable stay. Perfect for families, this spacious suite offers a harmonious blend of modern amenities and elegant decor.', 'family-suite1.webp,family-suite2.webp,family-suite3.webp,family-suite4.webp,family-suite5.jpg,family-suite6.webp');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `staff_id`, `first_name`, `last_name`, `email`, `phone_number`, `password`) VALUES
(1, 'S000001', 'Eden', 'Liew', 'b2345dit@mdis.edu.my', '01128220633', 'Ly7288128');

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
(1, 'Eden', 'Liew', 'lieweden03@gmail.com', '01128220633', '$2y$10$dORQJ0DuHrlUZroHsE/BLOBgKttmRnvn5vaTC0YF9B7kXq0kBaDfm');

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
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
