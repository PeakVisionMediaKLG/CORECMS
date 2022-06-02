-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 07. Mrz 2022 um 18:03
-- Server-Version: 10.4.22-MariaDB
-- PHP-Version: 8.1.1

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
-- Tabellenstruktur für Tabelle `app_assets`
--

CREATE TABLE `app_assets` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `src_file` text NOT NULL,
  `src_db` text NOT NULL,
  `eval` tinyint(4) NOT NULL,
  `is_active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `app_assets`
--

INSERT INTO `app_assets` (`id`, `name`, `src_file`, `src_db`, `eval`, `is_active`) VALUES
(1, 'Bootstrap 5.1 CSS', '', '<!-- Bootstrap CSS -->\r\n    <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3\" crossorigin=\"anonymous\">', 0, 1),
(2, 'Bootstrap 5.1 JS', '', '<!-- Option 1: Bootstrap Bundle with Popper -->    <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js\" integrity=\"sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p\" crossorigin=\"anonymous\"></script>', 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `app_headless_content`
--

CREATE TABLE `app_headless_content` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `language` varchar(255) NOT NULL,
  `content_type` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `position` int(11) NOT NULL,
  `is_static_template` tinyint(4) NOT NULL,
  `is_static_copy_of` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `changed_by` varchar(255) NOT NULL,
  `changed_date` varchar(255) NOT NULL,
  `deleted_by` varchar(255) NOT NULL,
  `deleted_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `app_headless_content_archive`
--

CREATE TABLE `app_headless_content_archive` (
  `id` int(11) NOT NULL,
  `original_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `language` varchar(255) NOT NULL,
  `content_type` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `is_static_template` tinyint(4) NOT NULL,
  `is_static_copy_of` int(11) NOT NULL,
  `changed_by` varchar(255) NOT NULL,
  `changed_date` varchar(255) NOT NULL,
  `deleted_by` varchar(255) NOT NULL,
  `deleted_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `app_languages`
--

CREATE TABLE `app_languages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code_2digit` varchar(2) NOT NULL,
  `code_5digit` varchar(5) NOT NULL,
  `short_caption` varchar(255) NOT NULL,
  `long_caption` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `app_languages`
--

INSERT INTO `app_languages` (`id`, `name`, `code_2digit`, `code_5digit`, `short_caption`, `long_caption`, `is_active`) VALUES
(1, 'english', 'en', 'en_US', 'EN', 'English', 1),
(2, 'deutsch', 'de', 'de_DE', 'DE', 'Deutsch', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `app_pages`
--

CREATE TABLE `app_pages` (
  `id` int(11) NOT NULL,
  `shared_id` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `link_text` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `show_in_navigation` tinyint(4) NOT NULL,
  `auth_access_only` tinyint(4) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `edited_by` varchar(255) DEFAULT NULL,
  `edited_date` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `deleted_date` varchar(255) DEFAULT NULL,
  `access_counter` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `app_pages`
--

INSERT INTO `app_pages` (`id`, `shared_id`, `language`, `url`, `link_text`, `title`, `show_in_navigation`, `auth_access_only`, `is_active`, `created_by`, `created_date`, `edited_by`, `edited_date`, `deleted_by`, `deleted_date`, `access_counter`) VALUES
(1, '1', 'en', 'home_en', 'home', 'home', 1, 0, 1, 'Admin', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `app_pages_templates`
--

CREATE TABLE `app_pages_templates` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `page_type` varchar(255) NOT NULL,
  `group_member` varchar(255) NOT NULL,
  `link_text` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  `edited_date` varchar(255) NOT NULL,
  `deleted_by` varchar(255) NOT NULL,
  `deleted_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `app_page_objects`
--

CREATE TABLE `app_page_objects` (
  `id` int(11) NOT NULL,
  `parent` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `object_type` varchar(255) NOT NULL,
  `object_order` int(11) NOT NULL,
  `excluded_languages` text NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  `edited_date` varchar(255) NOT NULL,
  `deleted_by` varchar(255) NOT NULL,
  `deleted_date` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `app_page_objects`
--

INSERT INTO `app_page_objects` (`id`, `parent`, `name`, `object_type`, `object_order`, `excluded_languages`, `created_by`, `created_date`, `edited_by`, `edited_date`, `deleted_by`, `deleted_date`, `is_active`) VALUES
(1, '', 'home', 'page', 0, '', 'Admin', '', '', '', '0', '', 1),
(2, '1', 'subhome', 'page', 0, '[\"de\"]', 'Admin', '', '', '', '0', '', 1),
(3, '', 'top', 'page', 0, '', 'Admin', '', '', '', '0', '', 1),
(4, '2', 'subsubhome', 'page', 0, '', '', '', '', '', '0', '', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `app_page_objects_deleted`
--

CREATE TABLE `app_page_objects_deleted` (
  `id` int(11) NOT NULL,
  `parent` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `object_type` varchar(255) NOT NULL,
  `object_order` int(11) NOT NULL,
  `excluded_languages` text NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  `edited_date` varchar(255) NOT NULL,
  `deleted_by` varchar(255) NOT NULL,
  `deleted_date` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `core_languages`
--

CREATE TABLE `core_languages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code_2digit` varchar(2) NOT NULL,
  `code_5digit` varchar(5) NOT NULL,
  `short_caption` varchar(255) NOT NULL,
  `long_caption` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `core_languages`
--

INSERT INTO `core_languages` (`id`, `name`, `code_2digit`, `code_5digit`, `short_caption`, `long_caption`) VALUES
(1, 'deutsch', 'de', 'de_DE', 'DE', 'Deutsch');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `core_users`
--

CREATE TABLE `core_users` (
  `id` int(11) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `allowed_workspaces` text NOT NULL,
  `disallowed_workspaces` text NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `is_admin` tinyint(4) NOT NULL,
  `preferred_language` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_created` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `core_users`
--

INSERT INTO `core_users` (`id`, `identifier`, `username`, `password`, `allowed_workspaces`, `disallowed_workspaces`, `is_active`, `is_admin`, `preferred_language`, `first_name`, `last_name`, `gender`, `email`, `date_created`) VALUES
(1, '2297aa9f09d86e9af9e1da9467620a7f', 'Admin', '$2y$10$ZeEzss9Ty4lwSRudmJmx6OtbAC7sYmauZ7uim0IX2dOtyHULC5HTa', '', '', 1, 1, 'en', 'John', 'Doe', 'male', '', ''),
(2, '33414ed1f8fc7d5aef61146977d2d2fb', 'Editor', '$2y$10$LRGDaTaggxMaFtqs4CypZet18rn.9KWpqfZFqRcEyMBb2B6GYZlVi', '', '', 1, 0, 'en', 'Jane', 'Doe', 'female', '', '1644917046');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `app_assets`
--
ALTER TABLE `app_assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `app_headless_content`
--
ALTER TABLE `app_headless_content`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `app_headless_content_archive`
--
ALTER TABLE `app_headless_content_archive`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `original_id` (`original_id`);

--
-- Indizes für die Tabelle `app_languages`
--
ALTER TABLE `app_languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `app_pages`
--
ALTER TABLE `app_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`);

--
-- Indizes für die Tabelle `app_pages_templates`
--
ALTER TABLE `app_pages_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`name`);

--
-- Indizes für die Tabelle `app_page_objects`
--
ALTER TABLE `app_page_objects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `internal_name` (`name`);

--
-- Indizes für die Tabelle `app_page_objects_deleted`
--
ALTER TABLE `app_page_objects_deleted`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `internal_name` (`name`);

--
-- Indizes für die Tabelle `core_languages`
--
ALTER TABLE `core_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `core_users`
--
ALTER TABLE `core_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `identifier` (`identifier`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `app_assets`
--
ALTER TABLE `app_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `app_headless_content`
--
ALTER TABLE `app_headless_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `app_headless_content_archive`
--
ALTER TABLE `app_headless_content_archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `app_languages`
--
ALTER TABLE `app_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `app_pages`
--
ALTER TABLE `app_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `app_pages_templates`
--
ALTER TABLE `app_pages_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `app_page_objects`
--
ALTER TABLE `app_page_objects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `app_page_objects_deleted`
--
ALTER TABLE `app_page_objects_deleted`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `core_languages`
--
ALTER TABLE `core_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `core_users`
--
ALTER TABLE `core_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
