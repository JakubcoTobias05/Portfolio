-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 26. bře 2025, 01:46
-- Verze serveru: 10.4.32-MariaDB
-- Verze PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `iot_database`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `sensor_data`
--

CREATE TABLE `sensor_data` (
  `id` int(11) NOT NULL,
  `teplota` float DEFAULT NULL,
  `vlhkost` float DEFAULT NULL,
  `koncentrace_co2` int(11) DEFAULT NULL,
  `rosny_bod` float DEFAULT NULL,
  `teplota_venkovni` float DEFAULT NULL,
  `cas_mereni` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `sensor_data`
--

INSERT INTO `sensor_data` (`id`, `teplota`, `vlhkost`, `koncentrace_co2`, `rosny_bod`, `teplota_venkovni`, `cas_mereni`) VALUES
(6, 21.5, 42.6, 1102, 8.2, 3.6, '2025-03-25 10:00:00'),
(7, 22, 43, 1110, 8.5, 4, '2025-03-25 11:00:00'),
(8, 22.5, 44, 1120, 8.8, 4.5, '2025-03-25 12:00:00'),
(9, 23, 45, 1130, 9, 5, '2025-03-25 13:00:00'),
(10, 23.5, 46, 1140, 9.2, 5.5, '2025-03-25 14:00:00'),
(11, 24, 47, 1150, 9.5, 6, '2025-03-25 15:00:00'),
(12, 24.5, 48, 1160, 9.8, 6.5, '2025-03-25 16:00:00'),
(13, 25, 49, 1170, 10, 7, '2025-03-25 17:00:00'),
(14, 25.5, 50, 1180, 10.2, 7.5, '2025-03-25 18:00:00'),
(15, 26, 51, 1190, 10.5, 8, '2025-03-25 19:00:00'),
(16, 21.4, 42.3, 1043, 8, 5.7, '2025-03-26 01:32:00'),
(17, 21.4, 42.3, 1047, 8, 5.6, '2025-03-26 01:36:00'),
(18, 21.3, 42.3, 1048, 8, 5.6, '2025-03-26 01:39:00'),
(19, 21.3, 42.3, 1043, 8, 5.4, '2025-03-26 01:42:00'),
(20, 21.4, 42.2, 1038, 8, 5.3, '2025-03-26 01:45:00'),
(21, 21.4, 42.2, 1038, 8, 5.3, '2025-03-26 01:45:00');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `sensor_data`
--
ALTER TABLE `sensor_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `sensor_data`
--
ALTER TABLE `sensor_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
