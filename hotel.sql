-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2024 at 01:01 PM
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
  `booking_status` varchar(20) NOT NULL,
  `cancel_reason` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `email`, `room_id`, `check_in_date`, `check_out_date`, `days`, `number_of_rooms`, `bed_selection`, `smoke`, `first_name`, `last_name`, `phone_number`, `bring_car`, `additional_requests`, `total_amount`, `created_at`, `car_plates`, `payment_status`, `booking_status`, `cancel_reason`) VALUES
(1, 'zhekai@gmail.com', 1, '2024-08-07', '2024-08-09', 2, 1, '1 Double Bed', 'Smoking', 'Zhe Kai', 'Lau', '0123456789', 'Yes', '[{\"extra_bed\":\"Yes\",\"bed_quantity\":\"1\",\"add_breakfast\":\"Yes\",\"breakfast_quantity\":\"1\"}]', 645.00, '2024-07-30 10:33:13', 'JUY1234', 'Success', 'Cancelled', ''),
(2, 'zhekai@gmail.com', 1, '2024-07-31', '2024-08-02', 2, 1, '1 Double Bed', 'Non-Smoking', 'Zhe Kai', 'Lau', '0123456789', 'Yes', '[{\"extra_bed\":\"Yes\",\"bed_quantity\":\"1\",\"add_breakfast\":\"Yes\",\"breakfast_quantity\":\"1\"}]', 645.00, '2024-07-31 05:06:42', 'ABC 1234', 'Success', 'Cancelled', 'test'),
(3, 'zhekai@gmail.com', 2, '2024-08-08', '2024-08-09', 1, 1, '1 Queen Bed', 'Non-Smoking', 'Zhe Kai', 'Lau', '0123456789', 'Yes', '[{\"extra_bed\":\"Yes\",\"bed_quantity\":\"1\",\"add_breakfast\":\"Yes\",\"breakfast_quantity\":\"1\"}]', 385.00, '2024-07-31 05:13:27', 'JSQ 9155', 'Success', 'Success', ''),
(4, 'zhekai@gmail.com', 3, '2024-08-05', '2024-08-08', 3, 2, '1 Queen Bed', 'Non-Smoking', 'Zhe Kai', 'Lau', '0123456789', 'Yes', '[{\"extra_bed\":\"Yes\",\"bed_quantity\":\"1\",\"add_breakfast\":\"Yes\",\"breakfast_quantity\":\"1\"},{\"extra_bed\":\"Yes\",\"bed_quantity\":\"1\",\"add_breakfast\":\"No\",\"breakfast_quantity\":0}]', 3055.00, '2024-07-31 05:15:42', 'ABC 1234', 'Success', 'Cancelled', 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoice_id` varchar(10) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `generate_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_id`, `booking_id`, `amount`, `payment_status`, `generate_time`, `email`) VALUES
(1, 'INV00001', 1, 645.00, 'Success', '2024-07-30 10:33:28', 'zhekai@gmail.com'),
(2, 'INV00002', 2, 645.00, 'Success', '2024-07-31 05:07:05', 'zhekai@gmail.com'),
(3, 'INV00003', 3, 385.00, 'Success', '2024-07-31 05:14:12', 'zhekai@gmail.com'),
(4, 'INV00004', 4, 3055.00, 'Success', '2024-07-31 05:15:58', 'zhekai@gmail.com');

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
(1, 'Standard Room', 7, 300.00, '2 Single Beds, Smoking, Non-Smoking, 1 Double Bed', 'Hair Dryer, Private Bathroom, Toiletries, Towels, Telephone, Fan, Satellite/cable channels, Air Conditioning, Blackout curtains, Slippers, Mineral Water, Refrigerator, Desk, Window, Closet, Clothes Rack, Ironing Facilities, Safety Box', '19 m²/205 ft²', 9, 'Discover comfort and convenience in our Standard Room, ideal for both leisure and business travelers. This room features your choice of 1 double bed or 2 single beds, available in smoking and non-smoking options to suit your preference. Enjoy essential amenities and a welcoming ambiance, ensuring a relaxing stay whether you\'re here for a short visit or an extended stay.', 'standard1.webp,standard2.jpg,standard3.jpg,standard4.webp,standard5.jpg'),
(2, 'Deluxe Room', 6, 340.00, 'Smoking, Non-Smoking, 1 Queen Bed, 2 Single Bed', 'Hair Dryer, Private Bathroom, Toiletries, Towels, Telephone, Fan, Satellite/cable channels, Blackout curtains, Slippers, Refrigerator, Desk, Safety Box, Electric Kettle, Air conditioning, Free Mineral Water, Ironing facilities', '17 m²/183 ft²', 9, 'Experience the perfect blend of comfort and luxury in our Deluxe Room, designed to cater to both leisure and business travelers. This spacious room offers the choice of a queen bed or two single beds, along with smoking and non-smoking options to suit your preference. Enjoy modern amenities and a cozy atmosphere, making your stay both convenient and relaxing. Whether you are here for a short stay or an extended visit, our Deluxe Room provides the ideal setting for a memorable stay.', 'deluxe1.webp,deluxe2.jpg,deluxe3.jpg,deluxe4.jpg,deluxe5.webp'),
(3, 'Triple Room', 5, 500.00, 'Smoking, Non-Smoking, 1 Queen Bed, 1 Single Bed', 'Toiletries, Towels, Telephone, Fan, Satellite/cable channels, Slippers, Mineral Water, Refrigerator, Desk, Window, Closet, Safety Box, Air conditioning, Ironing facilities, Mobility accessibility, Hair dryer, Private bathroom, Coffee/tea maker, Daily housekeeping', '17 m²/183 ft²', 10, 'Experience comfort and convenience in our well-appointed Triple Room, designed to cater to the needs of small groups or families. This room offers a perfect blend of functionality and style, ensuring a pleasant and memorable stay.', 'triple1.jpg,triple2.jpg,triple3.webp,triple4.jpg'),
(4, 'Family Suite Room', 4, 1000.00, 'Smoking, Non-Smoking, 3 Queen Beds, Outdoor View, Free Wi-Fi', 'Hair Dryer, Private Bathroom, Toiletries, Towels, Telephone, Fan, Satellite/cable channels, Slippers, Mineral Water, Refrigerator, Desk, Window, Safety Box, Air conditioning, Wake-up service, Baby Cot (Upon Request), Safety/security feature', '29 m²/312 ft²', 5, 'Experience unparalleled luxury and comfort in our Family Suite Room, designed to cater to all your needs and provide an unforgettable stay. Perfect for families, this spacious suite offers a harmonious blend of modern amenities and elegant decor.', 'family-suite1.webp,family-suite2.webp,family-suite3.webp,family-suite4.webp,family-suite5.jpg,family-suite6.webp');

-- --------------------------------------------------------

--
-- Table structure for table `room_assignments`
--

CREATE TABLE `room_assignments` (
  `assignment_id` int(6) NOT NULL,
  `room_id` int(11) NOT NULL,
  `room_type` varchar(255) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_level` int(11) NOT NULL,
  `room_number` varchar(10) NOT NULL,
  `assign_status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_assignments`
--

INSERT INTO `room_assignments` (`assignment_id`, `room_id`, `room_type`, `booking_id`, `room_level`, `room_number`, `assign_status`) VALUES
(1, 1, 'Standard Room', 1, 7, '7001', 'Assign'),
(2, 1, 'Standard Room', 2, 7, '7002', 'Cancelled'),
(3, 1, 'Standard Room', 0, 7, '7003', 'Not Assign'),
(4, 1, 'Standard Room', 0, 7, '7004', 'Not Assign'),
(5, 1, 'Standard Room', 0, 7, '7005', 'Not Assign'),
(6, 1, 'Standard Room', 0, 7, '7006', 'Not Assign'),
(7, 1, 'Standard Room', 0, 7, '7007', 'Not Assign'),
(8, 1, 'Standard Room', 0, 7, '7008', 'Not Assign'),
(9, 1, 'Standard Room', 0, 7, '7009', 'Not Assign'),
(10, 1, 'Standard Room', 0, 7, '7010', 'Not Assign'),
(11, 2, 'Deluxe Room', 3, 6, '6001', 'Assign'),
(12, 2, 'Deluxe Room', 0, 6, '6002', 'Not Assign'),
(13, 2, 'Deluxe Room', 0, 6, '6003', 'Not Assign'),
(14, 2, 'Deluxe Room', 0, 6, '6004', 'Not Assign'),
(15, 2, 'Deluxe Room', 0, 6, '6005', 'Not Assign'),
(16, 2, 'Deluxe Room', 0, 6, '6006', 'Not Assign'),
(17, 2, 'Deluxe Room', 0, 6, '6007', 'Not Assign'),
(18, 2, 'Deluxe Room', 0, 6, '6008', 'Not Assign'),
(19, 2, 'Deluxe Room', 0, 6, '6009', 'Not Assign'),
(20, 2, 'Deluxe Room', 0, 6, '6010', 'Not Assign'),
(21, 3, 'Triple Room', 4, 5, '5001', 'Cancelled'),
(22, 3, 'Triple Room', 4, 5, '5002', 'Cancelled'),
(23, 3, 'Triple Room', 0, 5, '5003', 'Not Assign'),
(24, 3, 'Triple Room', 0, 5, '5004', 'Not Assign'),
(25, 3, 'Triple Room', 0, 5, '5005', 'Not Assign'),
(26, 3, 'Triple Room', 0, 5, '5006', 'Not Assign'),
(27, 3, 'Triple Room', 0, 5, '5007', 'Not Assign'),
(28, 3, 'Triple Room', 0, 5, '5008', 'Not Assign'),
(29, 3, 'Triple Room', 0, 5, '5009', 'Not Assign'),
(30, 3, 'Triple Room', 0, 5, '5010', 'Not Assign'),
(31, 4, 'Family Suite Room', 0, 4, '4001', 'Not Assign'),
(32, 4, 'Family Suite Room', 0, 4, '4002', 'Not Assign'),
(33, 4, 'Family Suite Room', 0, 4, '4003', 'Not Assign'),
(34, 4, 'Family Suite Room', 0, 4, '4004', 'Not Assign'),
(35, 4, 'Family Suite Room', 0, 4, '4005', 'Not Assign');

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
  `phone_number` varchar(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `staff_id`, `first_name`, `last_name`, `email`, `phone_number`, `password`, `role`) VALUES
(1, 'A00001', 'Eden', 'Liew', 'eden@lshotel.com', '01128220633', 'Ly7288128', 'Admin');

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
(1, 'Zhe Kai', 'Lau', 'zhekai@gmail.com', '0123456789', '$2y$10$H1CzsQuEeYYN73olPA1h4eyP/39.oFKOl6aagA7MH1in5ZlCDsuP.');

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
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_id` (`invoice_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `room_assignments`
--
ALTER TABLE `room_assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `Room ID` (`room_id`);

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
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `room_assignments`
--
ALTER TABLE `room_assignments`
  MODIFY `assignment_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

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

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);

--
-- Constraints for table `room_assignments`
--
ALTER TABLE `room_assignments`
  ADD CONSTRAINT `Room ID` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
