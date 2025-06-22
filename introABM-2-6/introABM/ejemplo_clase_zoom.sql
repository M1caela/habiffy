-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 04, 2025 at 10:45 PM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ejemplo_clase_zoom`
--

-- --------------------------------------------------------

--
-- Table structure for table `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `apellido` text NOT NULL,
  `fec_nac` date NOT NULL,
  `provincia_rel` int(11) DEFAULT NULL,
  `localidad_rel` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `estudiantes`
--

INSERT INTO `estudiantes` (`id`, `nombre`, `apellido`, `fec_nac`, `provincia_rel`, `localidad_rel`, `estado`) VALUES
(1, 'David', 'Bedoian', '2025-03-14', NULL, NULL, NULL),
(3, 'Patricia', 'Sosa', '2006-08-15', NULL, NULL, NULL),
(4, 'Liliana', 'Sosa', '2003-10-14', NULL, NULL, NULL),
(5, 'Martina', 'Paz', '2001-02-17', NULL, NULL, NULL),
(6, 'Sofia', 'Sosa', '1970-02-11', NULL, NULL, NULL),
(8, 'Stan', 'Luburic', '1992-06-14', NULL, NULL, NULL),
(9, 'Marianela', 'Lopez', '2005-05-11', NULL, NULL, NULL),
(10, 'Peter', 'Pan', '2018-05-01', NULL, NULL, NULL),
(11, 'Luciano', 'Fernandez', '2001-05-11', NULL, NULL, NULL),
(12, 'David', 'Bedoian', '2025-06-04', NULL, NULL, NULL),
(13, 'Sofia', 'Gomez', '1995-05-14', 1, 1, NULL),
(14, 'Tony', 'Stark', '1971-09-16', 2, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `localidades`
--

CREATE TABLE `localidades` (
  `id_localidad` int(11) NOT NULL,
  `nombre_localidad` text NOT NULL,
  `id_provincia_padre_rel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `localidades`
--

INSERT INTO `localidades` (`id_localidad`, `nombre_localidad`, `id_provincia_padre_rel`) VALUES
(1, 'La Plata', 1),
(2, 'Berazategui', 1),
(3, 'Ushuaia', 2),
(4, 'Río Grande', 2);

-- --------------------------------------------------------

--
-- Table structure for table `provincias`
--

CREATE TABLE `provincias` (
  `id_provincia` int(11) NOT NULL,
  `nombre_provincia` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `provincias`
--

INSERT INTO `provincias` (`id_provincia`, `nombre_provincia`) VALUES
(1, 'Buenos Aires'),
(2, 'Tierra del Fuego');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `localidades`
--
ALTER TABLE `localidades`
  ADD PRIMARY KEY (`id_localidad`);

--
-- Indexes for table `provincias`
--
ALTER TABLE `provincias`
  ADD PRIMARY KEY (`id_provincia`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `localidades`
--
ALTER TABLE `localidades`
  MODIFY `id_localidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `provincias`
--
ALTER TABLE `provincias`
  MODIFY `id_provincia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
