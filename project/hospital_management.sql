-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2024 at 08:24 PM
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
-- Database: `hospital_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `doctor_email` varchar(255) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` enum('due','done') DEFAULT 'due',
  `doctor_name` varchar(255) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointments_patients`
--

CREATE TABLE `appointments_patients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `address` text NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `patient_status` enum('New','Old') NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `doctor_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments_patients`
--

INSERT INTO `appointments_patients` (`id`, `name`, `phone_number`, `age`, `gender`, `address`, `appointment_date`, `appointment_time`, `patient_status`, `department_name`, `doctor_name`, `email`) VALUES
(10, 'Md.Mostak Ahmed', '01307141820', 25, 'Male', 'west shawrapara,mirpur,dhaka', '2024-11-18', '14:11:00', 'Old', 'Child and Adolescent Development Clinic', 'Dr. Farzana Ahmed', 'md@gmail.com'),
(11, 'Md.Mostak Ahmed', '01307141820', 25, 'Male', 'west shawrapara,mirpur,dhaka', '2024-11-19', '18:18:00', 'New', 'Psychosexual Disorder Clinic', 'Dr. Tanvir Alam', 'md@gmail.com'),
(12, 'Md.Mostak Ahmed', '01307141820', 25, 'Male', 'west shawrapara,mirpur,dhaka', '2024-12-31', '17:20:00', 'New', 'Child and Adolescent Development Clinic', 'Dr. Saiful Islam', 'md@gmail.com'),
(13, 'Md.Mostak Ahmed', '01307141820', 25, 'Male', 'west shawrapara,mirpur,dhaka', '2024-11-18', '11:20:00', 'New', 'Child and Adolescent Development Clinic', 'Dr. Nasim Hossain', 'md@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `availability_slots`
--

CREATE TABLE `availability_slots` (
  `slot_id` int(11) NOT NULL,
  `doctor_email` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` enum('available','booked','cancelled') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_edu`
--

CREATE TABLE `doctor_edu` (
  `edu_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `school` varchar(100) DEFAULT NULL,
  `college` varchar(100) DEFAULT NULL,
  `medical_college` varchar(100) DEFAULT NULL,
  `other_degrees` text DEFAULT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `specialties` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_edu`
--

INSERT INTO `doctor_edu` (`edu_id`, `user_id`, `profile_picture`, `school`, `college`, `medical_college`, `other_degrees`, `father_name`, `mother_name`, `address`, `specialties`) VALUES
(1, 18, '673a2ac27bffd.jpg', 'Sher-e- bangla nagar govt girls  high school', 'Shaheed Bir Uttam Lt. Anwar Girls College', 'Green Life medical college', 'MBBS', 'sdasdasds', 'jesmin', 'west shawrapara,mirpur,dhaka', 'sink');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `birthday` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `role` enum('admin','doctor','patient') DEFAULT 'patient',
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone_number`, `email`, `password`, `birthday`, `gender`, `role`, `profile_picture`) VALUES
(10, 'Md.Mostak', 'Ahmed', '01405697800', 'md@gmail.com', '$2y$10$OqwM7m6OGu8mDBg8zQRbkeQv3JIw5hscsLxmniipKyoFghqk2LoQ2', '2024-11-13', 'Male', 'patient', NULL),
(18, 'Md.Mostak', 'Ahmed', '01405697800', 'mda@gmail.com', '$2y$10$8RfhyH7.YNQZHAcSqXLRGOdzJH6xdpKBaWzn3CwOwxXmEC2u/vrKq', '2024-11-15', 'Male', 'doctor', NULL),
(19, 'sabiha', 'jui', '01758697892', 'jka@gmail.com', '$2y$10$RKXbckiTsw0U0cm8LHXajuEbJeSmkslf.i5sP/tt55NyWvqhYprHG', '2002-08-12', 'Female', 'doctor', NULL),
(20, 'mahabub', 'Ahmed', '01405697800', 'mahabubkowsar21@gmail.com', '$2y$10$BvNBepZ/kq3yV0Akj7wjtegzn3Pca4KI6KcdLYvH6V.BYlq7B61a2', '2024-11-17', 'Male', 'doctor', NULL),
(21, 'adsa', 'asdads', '01405697800', 'mdw@gmail.com', '$2y$10$PPizUpIggEoZdpoN9TAJ6.ezjxvjulSgq/8aX2WzYXnAqhmlUBbxa', '2024-11-17', 'Female', 'doctor', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `doctor_email` (`doctor_email`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `appointments_patients`
--
ALTER TABLE `appointments_patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `availability_slots`
--
ALTER TABLE `availability_slots`
  ADD PRIMARY KEY (`slot_id`),
  ADD KEY `doctor_email` (`doctor_email`);

--
-- Indexes for table `doctor_edu`
--
ALTER TABLE `doctor_edu`
  ADD PRIMARY KEY (`edu_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `email` (`email`);

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
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointments_patients`
--
ALTER TABLE `appointments_patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `availability_slots`
--
ALTER TABLE `availability_slots`
  MODIFY `slot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `doctor_edu`
--
ALTER TABLE `doctor_edu`
  MODIFY `edu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`doctor_email`) REFERENCES `users` (`email`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`);

--
-- Constraints for table `availability_slots`
--
ALTER TABLE `availability_slots`
  ADD CONSTRAINT `availability_slots_ibfk_1` FOREIGN KEY (`doctor_email`) REFERENCES `users` (`email`);

--
-- Constraints for table `doctor_edu`
--
ALTER TABLE `doctor_edu`
  ADD CONSTRAINT `doctor_edu_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
