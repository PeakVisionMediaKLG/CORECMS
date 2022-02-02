-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 22. Jan 2021 um 17:44
-- Server-Version: 10.4.16-MariaDB
-- PHP-Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `core-cms`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `be_captions`
--

CREATE TABLE `be_captions` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_bin NOT NULL,
  `systemadmin_only` tinyint(4) NOT NULL,
  `EN` text COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Daten für Tabelle `be_captions`
--

INSERT INTO `be_captions` (`id`, `name`, `systemadmin_only`, `EN`) VALUES
(3, 'input_type_boolean', 0, 'Boolean'),
(4, 'input_type_text', 0, 'Text'),
(5, 'input_type_select', 0, 'Select');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `core_settings`
--

CREATE TABLE `core_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `caption` text COLLATE utf8mb4_bin NOT NULL,
  `value` text COLLATE utf8mb4_bin NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `essential` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Daten für Tabelle `core_settings`
--

INSERT INTO `core_settings` (`id`, `name`, `caption`, `value`, `type`, `essential`) VALUES
(1, 'coreJqueryDebug', 'Enable jQuery logging to the console.', '1', 'bool', 1),
(2, 'dbLogMessages', 'Write database actions to the log.', '0', 'bool', 1),
(3, 'dbPrintMessages', 'Print database errors / warnings to the html document.', '0', 'bool', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `be_users`
--

CREATE TABLE `be_users` (
  `id` int(11) NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `is_systemadmin` tinyint(4) NOT NULL DEFAULT 0,
  `is_admin` tinyint(4) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `user_role` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `preferred_language` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `avatar` text COLLATE utf8mb4_bin NOT NULL,
  `date_created` varchar(25) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Daten für Tabelle `be_users`
--

INSERT INTO `be_users` (`id`, `identifier`, `username`, `password`, `is_systemadmin`, `is_admin`, `is_active`, `user_role`, `preferred_language`, `first_name`, `last_name`, `gender`, `email`, `avatar`, `date_created`) VALUES
(1, '4cea4a7de1d94a89d58c7e0b37085d2a', 'System admin', 'e3afed0047b08059d0fada10f400c1e5', 1, 1, 1, '', 'EN', 'First Name', 'Last Name', 'gender_diverse', '', '', ''),
(2, '2297aa9f09d86e9af9e1da9467620a7f', 'Admin', 'e3afed0047b08059d0fada10f400c1e5', 0, 1, 1, '', 'EN', 'First Name', 'Last Name', 'gender_male', '', '', '1611147323'),
(3, '33414ed1f8fc7d5aef61146977d2d2fb', 'Editor', '344a7f427fb765610ef96eb7bce95257', 0, 0, 1, '', 'EN', 'First Name', 'Last Name', 'gender_female', '', '', '1611147350');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `be_values`
--

CREATE TABLE `be_values` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `caption` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `value` text COLLATE utf8mb4_bin NOT NULL,
  `essential` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Daten für Tabelle `be_values`
--

INSERT INTO `be_values` (`id`, `name`, `caption`, `value`, `essential`) VALUES
(1, 'gender_diverse', 'Diverse', 'diverse', 1),
(2, 'gender_female', 'Female', 'female', 1),
(3, 'gender_male', 'Male', 'male', 1),
(15, 'input_type_boolean', 'Boolean', 'boolean', 1),
(16, 'input_type_text', 'Text', 'text', 1),
(17, 'input_type_select', 'Select', 'select', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `be_valuesets`
--

CREATE TABLE `be_valuesets` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `caption` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `contained_values` text COLLATE utf8mb4_bin NOT NULL,
  `essential` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Daten für Tabelle `be_valuesets`
--

INSERT INTO `be_valuesets` (`id`, `name`, `caption`, `contained_values`, `essential`) VALUES
(1, 'genders', 'Genders', '[\"gender_diverse\",\"gender_female\",\"gender_male\"]', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `db_log`
--

CREATE TABLE `db_log` (
  `id` int(11) NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `query_type` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `affected_table` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `column_keys` text COLLATE utf8mb4_bin NOT NULL,
  `column_values` text COLLATE utf8mb4_bin NOT NULL,
  `condition_keys` text COLLATE utf8mb4_bin NOT NULL,
  `condition_values` text COLLATE utf8mb4_bin NOT NULL,
  `extended` text COLLATE utf8mb4_bin NOT NULL,
  `parameters` text COLLATE utf8mb4_bin NOT NULL,
  `type_string` text COLLATE utf8mb4_bin NOT NULL,
  `attempt_date` varchar(25) COLLATE utf8mb4_bin NOT NULL,
  `error_message` text COLLATE utf8mb4_bin NOT NULL,
  `query_success` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `be_captions`
--
ALTER TABLE `be_captions`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `core_settings`
--
ALTER TABLE `core_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `be_users`
--
ALTER TABLE `be_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userName` (`username`);

--
-- Indizes für die Tabelle `be_values`
--
ALTER TABLE `be_values`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `be_valuesets`
--
ALTER TABLE `be_valuesets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `db_log`
--
ALTER TABLE `db_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `be_captions`
--
ALTER TABLE `be_captions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `core_settings`
--
ALTER TABLE `core_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `be_users`
--
ALTER TABLE `be_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT für Tabelle `be_values`
--
ALTER TABLE `be_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT für Tabelle `be_valuesets`
--
ALTER TABLE `be_valuesets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT für Tabelle `db_log`
--
ALTER TABLE `db_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
