-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 30, 2021 alle 13:15
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
  `img_src` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `hour` char(5) NOT NULL,
  `ticket_price` float NOT NULL,
  `artists` varchar(50) NOT NULL,
  `tot_tickets` int(11) NOT NULL,
  `discounted` int(1) NOT NULL,
  `place_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `events`
--

INSERT INTO `events` (`id`, `title`, `id_type`, `id_genre`, `img_src`, `date`, `hour`, `ticket_price`, `artists`, `tot_tickets`, `discounted`, `place_id`) VALUES
(1, 'Album AC/DC', 3, 1, 'ACDC_logo.jpg', '2021-06-03', '19:00', 1.54448, 'AC/DC', 999999995, 0, 1),
(9, 'Einsturzende Neubaut', 3, 2, 'einsturzende.jpg', '2022-06-16', '15:30', 50, 'Einsturzende Neubauten', 50, 0, 3),
(13, 'Alicia Keys', 4, 2, 'Alicia-Keys-Mediolanum-Forum-Assago-Milano-28-giugno-2022-738x415.jpg', '2021-06-26', '18:00', 44.6, 'Alicia Keys', 300, 0, 1),
(14, 'Dangerous woman', 4, 2, 'Sweetener_Artwork.jpg', '2021-07-16', '21:30', 75, 'Ariana Grande', 5000, 0, 1);

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
-- Struttura della tabella `places`
--

CREATE TABLE `places` (
  `id` int(11) NOT NULL,
  `place` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `nation` varchar(255) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `places`
--

INSERT INTO `places` (`id`, `place`, `city`, `nation`, `lat`, `lng`) VALUES
(1, 'Museo del cinema', 'Turin', 'Italy', 45.116177, 7.742615),
(2, 'The Barri Gòtic', 'Barcellona', 'Spain', 41.385331792, 2.168665992),
(3, 'Tour eiffel', 'Paris', 'France', 48.858093, 2.294694),
(4, 'Piazza Galimberti', 'Cuneo', 'Italy', 44.38892, 7.54787),
(5, 'Budokan', 'Tokyo', 'Japan', 35.097964, 134.326478),
(6, 'Galleria d\'arte moderna', 'Milano', 'Italy', 41.917046, 12.47998);

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
('bassi', 14, 1),
('nico', 1, 0);

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
('bassi', 1),
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
(223, 'ticket_yuri_1_0', 1, 'yuri', '2021-05-28'),
(224, 'ticket_yuri_1_1', 1, 'yuri', '2021-05-28'),
(225, 'ticket_yuri_1_2', 1, 'yuri', '2021-05-28'),
(226, 'ticket_yuri_1_3', 1, 'yuri', '2021-05-28');

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
('bassi', '6e6bc4e49dd477ebc98ef4046c067b5f', 'bacobas.f@gmail.com', 'Francesco', 'Bassignana', '3349628407', 1, 988522),
('cesca', '6e6bc4e49dd477ebc98ef4046c067b5f', 'francy.luki16@gmail.com', 'Francesca', 'Luchino', NULL, 1, 10000000),
('luca', '6e6bc4e49dd477ebc98ef4046c067b5f', 'isnf.sdf@sdf.sdf', 'luca', 'cognomeLuca', NULL, 0, 88888),
('nico', '6e6bc4e49dd477ebc98ef4046c067b5f', 'bacobas.nik@gmail.com', 'niccolò', 'bassignana', NULL, 1, 991),
('paolo', '6e6bc4e49dd477ebc98ef4046c067b5f', 'asd.as@asd.s', 'paolo', 'shekawat', '1928283838', 0, 66666),
('prova', '6e6bc4e49dd477ebc98ef4046c067b5f', 'prova.prova@s.s', 'nomeProva', 'cognProva', '321929382', 0, 23432),
('yuri', '6e6bc4e49dd477ebc98ef4046c067b5f', 'asd.asda@as.as', 'yuri', 'armando', '2376217232', 1, 10000000);

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
  ADD KEY `author` (`artists`),
  ADD KEY `place_id` (`place_id`);

--
-- Indici per le tabelle `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lat_lng` (`lat`,`lng`);

--
-- Indici per le tabelle `prefer_events`
--
ALTER TABLE `prefer_events`
  ADD PRIMARY KEY (`username`,`id_e`,`caso`),
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
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT per la tabella `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `places`
--
ALTER TABLE `places`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

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
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`id_type`) REFERENCES `types` (`id`),
  ADD CONSTRAINT `events_ibfk_3` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`);

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
