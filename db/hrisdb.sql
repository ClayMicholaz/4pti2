-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2026 at 02:08 AM
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
-- Database: `hrisdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jabatan`
--

CREATE TABLE `tbl_jabatan` (
  `id` int(11) NOT NULL,
  `namajab` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_jabatan`
--

INSERT INTO `tbl_jabatan` (`id`, `namajab`) VALUES
(1, 'IT Manager'),
(4, 'tes'),
(5, 'tes d'),
(7, 'tes tes'),
(8, 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pegawai`
--

CREATE TABLE `tbl_pegawai` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT NULL,
  `idjabatan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pegawai`
--

INSERT INTO `tbl_pegawai` (`id`, `nama`, `email`, `username`, `password`, `role`, `idjabatan`) VALUES
(7, 'Blessy', 'blessy@gmail.com', 'blessy', '$2y$10$9u00MX.0m6b/YNty8ak.W.FUp5ROf8JQg8PrvxxPdmMERRaEtpQSu', 'admin', 1),
(8, 'Vanda', 'vanda@gmail.com', 'vanda', '$2y$10$NVJOYPB47OSu.AtJZ6rtuuk8PyI/5E0RKAf3j/U6EAaDySM9X0/5K', 'user', 1);

--
-- Triggers `tbl_pegawai`
--
DELIMITER $$
CREATE TRIGGER `trg_delete_user` AFTER DELETE ON `tbl_pegawai` FOR EACH ROW DELETE FROM tbl_users 
WHERE username = OLD.username
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_insert_user` AFTER INSERT ON `tbl_pegawai` FOR EACH ROW INSERT INTO tbl_users (username, password, role)
    VALUES (
        NEW.username,
        NEW.password,
        New.role
    )
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_update_user` AFTER UPDATE ON `tbl_pegawai` FOR EACH ROW UPDATE tbl_users
SET 
    username = NEW.username,
    password = NEW.password,
    role = NEW.role
WHERE username = OLD.username
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`username`, `password`, `role`) VALUES
('blessy', '$2y$10$9u00MX.0m6b/YNty8ak.W.FUp5ROf8JQg8PrvxxPdmMERRaEtpQSu', 'admin'),
('vanda', '$2y$10$NVJOYPB47OSu.AtJZ6rtuuk8PyI/5E0RKAf3j/U6EAaDySM9X0/5K', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pegawai`
--
ALTER TABLE `tbl_pegawai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idjabatan` (`idjabatan`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_pegawai`
--
ALTER TABLE `tbl_pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_pegawai`
--
ALTER TABLE `tbl_pegawai`
  ADD CONSTRAINT `tbl_pegawai_ibfk_1` FOREIGN KEY (`idjabatan`) REFERENCES `tbl_jabatan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
