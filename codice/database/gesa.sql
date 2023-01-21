-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 21, 2023 alle 16:11
-- Versione del server: 10.4.27-MariaDB
-- Versione PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gesa`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `associazione`
--

CREATE TABLE `associazione` (
  `ID` int(3) NOT NULL,
  `nome` varchar(25) NOT NULL,
  `password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `associazione`
--

INSERT INTO `associazione` (`ID`, `nome`, `password`) VALUES
(1, 'UNIBG', 'unibg'),
(2, 'UNIMI', 'unimi'),
(3, 'CSC', 'CSC'),
(4, 'MASTERCHEF', 'masterchef'),
(5, 'NUOTO', 'nuoto');

-- --------------------------------------------------------

--
-- Struttura della tabella `eventi`
--

CREATE TABLE `eventi` (
  `id` int(3) NOT NULL,
  `descr` varchar(25) NOT NULL,
  `private` int(1) NOT NULL,
  `stanza` int(4) NOT NULL,
  `organizz` varchar(10) NOT NULL,
  `data` bigint(12) NOT NULL,
  `durata` int(2) NOT NULL,
  `iscritti` int(4) NOT NULL,
  `associazione` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `infostanza`
--

CREATE TABLE `infostanza` (
  `infr` int(3) NOT NULL,
  `stanza` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `infostanza`
--

INSERT INTO `infostanza` (`infr`, `stanza`) VALUES
(1, 1),
(2, 1),
(2, 2),
(2, 3),
(3, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `infrastrutture`
--

CREATE TABLE `infrastrutture` (
  `id` int(3) NOT NULL,
  `descr` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `infrastrutture`
--

INSERT INTO `infrastrutture` (`id`, `descr`) VALUES
(1, 'BAGNO'),
(2, 'CUCINA'),
(3, 'PROIETTORE');

-- --------------------------------------------------------

--
-- Struttura della tabella `pubblico`
--

CREATE TABLE `pubblico` (
  `evento` int(5) NOT NULL,
  `utente` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `soci`
--

CREATE TABLE `soci` (
  `associazione` varchar(25) NOT NULL,
  `utente` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `stanza`
--

CREATE TABLE `stanza` (
  `id` int(3) NOT NULL,
  `area` int(4) NOT NULL,
  `capienza` int(4) NOT NULL,
  `tipologia` int(3) NOT NULL,
  `posizione` int(1) NOT NULL,
  `puliziah` int(2) NOT NULL,
  `costoh` double NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `stanza`
--

INSERT INTO `stanza` (`id`, `area`, `capienza`, `tipologia`, `posizione`, `puliziah`, `costoh`, `status`) VALUES
(1, 50, 10, 2, 0, 5, 20, 0),
(2, 60, 20, 1, 0, 7, 25, 0),
(3, 15, 8, 3, 0, 1, 5, 0),
(4, 100, 40, 2, 1, 10, 15, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `tipologia`
--

CREATE TABLE `tipologia` (
  `id` int(3) NOT NULL,
  `descr` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tipologia`
--

INSERT INTO `tipologia` (`id`, `descr`) VALUES
(1, 'PALESTRA'),
(2, 'FESTA'),
(3, 'RIUNIONE');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `username` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL,
  `mail` varchar(25) NOT NULL,
  `admin` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`username`, `password`, `mail`, `admin`) VALUES
('admin', 'admin', 'admin@gesa.it', 1),
('ALE', 'psw', 'test@test.it', 0),
('GIONNY', 'psw', 'test2@test.it', 0),
('LUCA', 'psw', 'test3@test.it', 0),
('PAOLA', 'psw', 'test4@test.it', 0),
('ANDREA', 'psw', 'test4@test.it', 0),
('FRANCESCA', 'psw', 'test6@test.it', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
