-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 06, 2024 alle 17:53
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
-- Struttura della tabella `paesi`
--

CREATE TABLE `paesi` (
  `Id` int(11) NOT NULL,
  `Nome_paese` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `paesi`
--

INSERT INTO `paesi` (`Id`, `Nome_paese`) VALUES
(1, 'Italy'),
(2, 'France'),
(3, 'Spain'),
(4, 'Germany'),
(5, 'Belgium'),
(6, 'Portugal');

-- --------------------------------------------------------

--
-- Struttura della tabella `paesi_nei_viaggi`
--

CREATE TABLE `paesi_nei_viaggi` (
  `viaggio_id` int(11) NOT NULL,
  `paese_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `paesi_nei_viaggi`
--

INSERT INTO `paesi_nei_viaggi` (`viaggio_id`, `paese_id`) VALUES
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
-- Struttura della tabella `viaggi`
--

CREATE TABLE `viaggi` (
  `Id` int(11) NOT NULL,
  `Nome_Viaggio` varchar(50) NOT NULL,
  `Posti_disponibili` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `viaggi`
--

INSERT INTO `viaggi` (`Id`, `Nome_Viaggio`, `Posti_disponibili`) VALUES
(1, 'Alicante', 20),
(2, 'Naples', 5),
(3, 'Costa Azzurra', 10),
(4, 'Tour Europeo', 5),
(5, 'Pirenei', 10);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `paesi`
--
ALTER TABLE `paesi`
  ADD PRIMARY KEY (`Id`);

--
-- Indici per le tabelle `paesi_nei_viaggi`
--
ALTER TABLE `paesi_nei_viaggi`
  ADD PRIMARY KEY (`viaggio_id`,`paese_id`),
  ADD KEY `paese_id` (`paese_id`);

--
-- Indici per le tabelle `viaggi`
--
ALTER TABLE `viaggi`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `paesi`
--
ALTER TABLE `paesi`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `viaggi`
--
ALTER TABLE `viaggi`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `paesi_nei_viaggi`
--
ALTER TABLE `paesi_nei_viaggi`
  ADD CONSTRAINT `paesi_nei_viaggi_ibfk_1` FOREIGN KEY (`paese_id`) REFERENCES `paesi` (`Id`),
  ADD CONSTRAINT `paesi_nei_viaggi_ibfk_2` FOREIGN KEY (`viaggio_id`) REFERENCES `viaggi` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
