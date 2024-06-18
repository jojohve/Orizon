-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 18, 2024 alle 15:09
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `orizon`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `countries`
--

CREATE TABLE `countries` (
  `Id` int(11) NOT NULL,
  `country_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `countries`
--

INSERT INTO `countries` (`Id`, `country_name`) VALUES
(1, 'Italy'),
(2, 'France'),
(3, 'Spain'),
(4, 'Germany'),
(5, 'Belgium'),
(6, 'Portugal');

-- --------------------------------------------------------

--
-- Struttura della tabella `country_trip`
--

CREATE TABLE `country_trip` (
  `trip_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `country_trip`
--

INSERT INTO `country_trip` (`trip_id`, `country_id`) VALUES
(1, 3),
(2, 1),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(4, 6),
(5, 2),
(5, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `trips`
--

CREATE TABLE `trips` (
  `Id` int(11) NOT NULL,
  `trip_name` varchar(50) NOT NULL,
  `availability` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `trips`
--

INSERT INTO `trips` (`Id`, `trip_name`, `availability`) VALUES
(1, 'Alicante', 20),
(2, 'Naples', 5),
(3, 'Costa Azzurra', 10),
(4, 'Tour Europeo', 5),
(5, 'Pirenei', 10);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`Id`);

--
-- Indici per le tabelle `country_trip`
--
ALTER TABLE `country_trip`
  ADD PRIMARY KEY (`trip_id`,`country_id`),
  ADD KEY `paese_id` (`country_id`);

--
-- Indici per le tabelle `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `countries`
--
ALTER TABLE `countries`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `trips`
--
ALTER TABLE `trips`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `country_trip`
--
ALTER TABLE `country_trip`
  ADD CONSTRAINT `country_trip_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`Id`),
  ADD CONSTRAINT `country_trip_ibfk_2` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
