-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 02. Jul 2021 um 17:01
-- Server-Version: 10.4.18-MariaDB
-- PHP-Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `newcore`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `core_settings`
--

CREATE TABLE `core_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `valueset` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `essential` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `core_settings`
--

INSERT INTO `core_settings` (`id`, `name`, `caption`, `valueset`, `value`, `type`, `essential`) VALUES
(6, 'dbPrintMessages', 'Print database errors / warnings to the html document.', '', '0', 'boolean', 1),
(7, 'dbAutoDumpOnLogin', 'Backup database on each back-end user login.', '', '0', 'boolean', 1),
(8, 'dbLogMessages', 'Write database actions to the log.', '', '0', 'boolean', 1),
(9, 'jQueryDebugConsole', 'Enable jQuery logging to the console.', '', '1', 'boolean', 1),
(10, 'jQueryDebugPrint', 'Print jQuery Ajax output to the document.', '', '0', 'boolean', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `core_users`
--

CREATE TABLE `core_users` (
  `id` int(11) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `is_admin` tinyint(4) NOT NULL,
  `preferred_language` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_created` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `core_users`
--

INSERT INTO `core_users` (`id`, `identifier`, `username`, `password`, `user_role`, `is_active`, `is_admin`, `preferred_language`, `first_name`, `last_name`, `email`, `date_created`) VALUES
(2, '4cea4a7de1d94a89d58c7e0b37085d2a', 'System admin', '$2y$10$0GRAubD3tGeMWXOy4U7lIOQDb0LeQsdqmLJqkOHcpjdOU3us6QS9S', 'admin', 1, 1, 'en', 'John', 'Doe', '', '');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `core_settings`
--
ALTER TABLE `core_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `core_users`
--
ALTER TABLE `core_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `core_settings`
--
ALTER TABLE `core_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `core_users`
--
ALTER TABLE `core_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
