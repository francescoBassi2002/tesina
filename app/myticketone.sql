-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 23, 2021 alle 17:40
-- Versione del server: 10.4.18-MariaDB
-- Versione PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myticketone`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `events`
--

CREATE TABLE `events` (
  `id` int(4) NOT NULL,
  `title` varchar(20) NOT NULL,
  `id_type` int(1) NOT NULL COMMENT '->tabella dei tipi',
  `id_genre` int(1) NOT NULL COMMENT '->tabella dei generi',
  `img_src` varchar(25) NOT NULL,
  `location` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `hour` char(5) NOT NULL,
  `ticket_price` float NOT NULL,
  `artists` varchar(50) NOT NULL,
  `tot_tickets` int(11) NOT NULL,
  `discounted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `events`
--

INSERT INTO `events` (`id`, `title`, `id_type`, `id_genre`, `img_src`, `location`, `date`, `hour`, `ticket_price`, `artists`, `tot_tickets`, `discounted`) VALUES
(1, 'Album AC/DC', 3, 1, 'ACDC_logo.jpg', 'Rome', '2021-06-03', '19:00', 1.54448, 'AC/DC', 999999995, 0),
(2, 'Gratest', 4, 3, 'neffex.jpg', 'New York', '2021-05-20', '14:30', 30, 'NEFFEX', 5, 0),
(6, 'Metallica album', 3, 1, 'metallica.jpg', 'cuneo', '2021-05-20', '13:45', 62.1, 'Metallica', 30, 0),
(9, 'Einsturzende Neubaut', 3, 2, 'einsturzende.jpg', 'Turin', '2022-06-16', '15:30', 50, 'Einsturzende Neubauten', 50, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `genres`
--

CREATE TABLE `genres` (
  `id` int(1) NOT NULL,
  `genre` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `genres`
--

INSERT INTO `genres` (`id`, `genre`) VALUES
(1, 'rock'),
(2, 'pop'),
(3, 'classic');

-- --------------------------------------------------------

--
-- Struttura della tabella `prefer_events`
--

CREATE TABLE `prefer_events` (
  `username` varchar(10) NOT NULL,
  `id_e` int(4) NOT NULL,
  `caso` int(1) NOT NULL COMMENT 'se è lista desideri o no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `prefer_events`
--

INSERT INTO `prefer_events` (`username`, `id_e`, `caso`) VALUES
('bassi', 2, 1),
('bassi', 6, 0),
('bassi', 9, 1),
('nico', 1, 0),
('nico', 2, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `prefer_genres`
--

CREATE TABLE `prefer_genres` (
  `username` varchar(10) NOT NULL,
  `id_genre` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `prefer_genres`
--

INSERT INTO `prefer_genres` (`username`, `id_genre`) VALUES
('bassi', 2),
('bassi', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `pdf_src` varchar(30) NOT NULL,
  `id_e` int(11) NOT NULL,
  `user` varchar(15) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `tickets`
--

INSERT INTO `tickets` (`id`, `pdf_src`, `id_e`, `user`, `date`) VALUES
(9, 'ticket_admin_1_0', 1, 'admin', '2021-05-11'),
(10, 'ticket_admin_1_1', 1, 'admin', '2021-05-11'),
(11, 'ticket_admin_2_0', 2, 'admin', '2021-05-11'),
(12, 'ticket_admin_2_1', 2, 'admin', '2021-05-11'),
(13, 'ticket_admin_2_2', 2, 'admin', '2021-05-11'),
(14, 'ticket_admin_2_3', 2, 'admin', '2021-05-11'),
(15, 'ticket_admin_2_4', 2, 'admin', '2021-05-11'),
(16, 'ticket_admin_2_5', 2, 'admin', '2021-05-11'),
(17, 'ticket_admin_6_0', 6, 'admin', '2021-05-11'),
(18, 'ticket_admin_6_1', 6, 'admin', '2021-05-11'),
(19, 'ticket_admin_6_2', 6, 'admin', '2021-05-11'),
(20, 'ticket_admin_6_3', 6, 'admin', '2021-05-11'),
(78, 'ticket_admin_2_6', 2, 'admin', '2021-05-13'),
(79, 'ticket_admin_2_7', 2, 'admin', '2021-05-13'),
(80, 'ticket_admin_2_8', 2, 'admin', '2021-05-13'),
(81, 'ticket_admin_2_9', 2, 'admin', '2021-05-13'),
(82, 'ticket_admin_2_10', 2, 'admin', '2021-05-13'),
(83, 'ticket_admin_2_11', 2, 'admin', '2021-05-13'),
(84, 'ticket_admin_2_12', 2, 'admin', '2021-05-13'),
(85, 'ticket_admin_2_13', 2, 'admin', '2021-05-13'),
(86, 'ticket_admin_2_14', 2, 'admin', '2021-05-13'),
(87, 'ticket_admin_2_15', 2, 'admin', '2021-05-13'),
(88, 'ticket_admin_2_16', 2, 'admin', '2021-05-13'),
(89, 'ticket_admin_2_17', 2, 'admin', '2021-05-13'),
(90, 'ticket_admin_2_18', 2, 'admin', '2021-05-13'),
(157, 'ticket_nico_1_0', 1, 'nico', '2021-05-16'),
(158, 'ticket_nico_1_1', 1, 'nico', '2021-05-16'),
(159, 'ticket_nico_1_2', 1, 'nico', '2021-05-16'),
(164, 'ticket_bassi_9_0', 9, 'bassi', '2021-05-20'),
(165, 'ticket_bassi_9_1', 9, 'bassi', '2021-05-20'),
(166, 'ticket_bassi_9_2', 9, 'bassi', '2021-05-20');

-- --------------------------------------------------------

--
-- Struttura della tabella `types`
--

CREATE TABLE `types` (
  `id` int(1) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `types`
--

INSERT INTO `types` (`id`, `type`) VALUES
(1, 'concert'),
(2, 'strumental'),
(3, 'band'),
(4, 'single'),
(5, 'solist');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `username` varchar(10) NOT NULL,
  `psw` char(32) NOT NULL,
  `email` varchar(25) NOT NULL,
  `name` varchar(15) NOT NULL,
  `surname` varchar(15) NOT NULL,
  `tel` char(10) DEFAULT NULL,
  `admin` int(1) NOT NULL,
  `aviable_balance` float UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`username`, `psw`, `email`, `name`, `surname`, `tel`, `admin`, `aviable_balance`) VALUES
('admin', '6e6bc4e49dd477ebc98ef4046c067b5f', 'admin@gmail.com', 'admin_name', 'admin_surname', NULL, 1, 8805),
('bassi', '6e6bc4e49dd477ebc98ef4046c067b5f', 'bacobas.f@gmail.com', 'Francesco', 'Bassignana', '3349628407', 1, 990226),
('luca', '6e6bc4e49dd477ebc98ef4046c067b5f', 'isnf.sdf@sdf.sdf', 'luca', 'cognomeLuca', NULL, 0, 88888),
('nico', '6e6bc4e49dd477ebc98ef4046c067b5f', 'bacobas.nik@gmail.com', 'niccolò', 'bassignana', NULL, 1, 991);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_genre` (`id_genre`),
  ADD KEY `id_type` (`id_type`),
  ADD KEY `author` (`artists`);

--
-- Indici per le tabelle `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `prefer_events`
--
ALTER TABLE `prefer_events`
  ADD PRIMARY KEY (`username`,`id_e`),
  ADD KEY `id_e` (`id_e`);

--
-- Indici per le tabelle `prefer_genres`
--
ALTER TABLE `prefer_genres`
  ADD PRIMARY KEY (`username`,`id_genre`),
  ADD KEY `id_genre` (`id_genre`);

--
-- Indici per le tabelle `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `id_e` (`id_e`);

--
-- Indici per le tabelle `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `events`
--
ALTER TABLE `events`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT per la tabella `types`
--
ALTER TABLE `types`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`id_genre`) REFERENCES `genres` (`id`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`id_type`) REFERENCES `types` (`id`);

--
-- Limiti per la tabella `prefer_events`
--
ALTER TABLE `prefer_events`
  ADD CONSTRAINT `prefer_events_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `prefer_events_ibfk_3` FOREIGN KEY (`id_e`) REFERENCES `events` (`id`);

--
-- Limiti per la tabella `prefer_genres`
--
ALTER TABLE `prefer_genres`
  ADD CONSTRAINT `prefer_genres_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `prefer_genres_ibfk_2` FOREIGN KEY (`id_genre`) REFERENCES `genres` (`id`);

--
-- Limiti per la tabella `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`user`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `tickets_ibfk_4` FOREIGN KEY (`id_e`) REFERENCES `events` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
