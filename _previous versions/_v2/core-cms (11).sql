-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2021 at 06:20 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `core-cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `core_captions`
--

CREATE TABLE `core_captions` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_bin NOT NULL,
  `systemadmin_only` tinyint(4) NOT NULL,
  `caption_en` text COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `core_captions`
--

INSERT INTO `core_captions` (`id`, `name`, `systemadmin_only`, `caption_en`) VALUES
(3, 'input_type_boolean', 0, 'Boolean'),
(4, 'input_type_text', 0, 'Text'),
(5, 'input_type_select', 0, 'Select');

-- --------------------------------------------------------

--
-- Table structure for table `core_dblog`
--

CREATE TABLE `core_dblog` (
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

-- --------------------------------------------------------

--
-- Table structure for table `core_includes`
--

CREATE TABLE `core_includes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `code_local` text COLLATE utf8mb4_bin NOT NULL,
  `code_cdn` text COLLATE utf8mb4_bin NOT NULL,
  `use_cdn` tinyint(4) NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `essential` tinyint(4) NOT NULL,
  `caption_en` varchar(255) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `core_settings`
--

CREATE TABLE `core_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `caption_en` text COLLATE utf8mb4_bin NOT NULL,
  `valueset` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `value` text COLLATE utf8mb4_bin NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `essential` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `core_settings`
--

INSERT INTO `core_settings` (`id`, `name`, `caption_en`, `valueset`, `value`, `type`, `essential`) VALUES
(1, 'jQueryDebugConsole', 'Enable jQuery logging to the console.', '', '1', 'bool', 1),
(2, 'jQueryDebugPrint', 'Print jQuery Ajax output to the document.', '', '1', 'bool', 1),
(3, 'dbLogMessages', 'Write database actions to the log.', '', '0', 'bool', 1),
(4, 'dbPrintMessages', 'Print database errors / warnings to the html document.', '', '0', 'bool', 1),
(5, 'dbAutoDumpOnLogin', 'Backup database on each back-end user login.', '', '0', 'input_type_boolean', 1);

-- --------------------------------------------------------

--
-- Table structure for table `core_users`
--

CREATE TABLE `core_users` (
  `id` int(11) NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `is_systemadmin` tinyint(4) NOT NULL DEFAULT 0,
  `is_admin` tinyint(4) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `preferred_language` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `avatar` text COLLATE utf8mb4_bin NOT NULL,
  `date_created` varchar(25) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `core_users`
--

INSERT INTO `core_users` (`id`, `identifier`, `username`, `password`, `is_systemadmin`, `is_admin`, `is_active`, `preferred_language`, `first_name`, `last_name`, `gender`, `email`, `avatar`, `date_created`) VALUES
(1, '4cea4a7de1d94a89d58c7e0b37085d2a', 'System admin', '$2y$10$0GRAubD3tGeMWXOy4U7lIOQDb0LeQsdqmLJqkOHcpjdOU3us6QS9S', 1, 1, 1, 'en', 'First Name', 'Last Name', 'gender_diverse', '', '', ''),
(2, '2297aa9f09d86e9af9e1da9467620a7f', 'Admin', '$2y$10$14ZY9CeqeAzMj7aVKwWfS.uxw56x213fR7ZExljx33T2mzEmT38bu', 0, 1, 1, 'en', 'First Name', 'Last Name', 'gender_male', '', '', '1611147323'),
(3, '33414ed1f8fc7d5aef61146977d2d2fb', 'Editor', '$2y$10$l1T59nvXLO7tQysmJ0dlWenyaInM.TA./iQm7A1wFLdCTd9mOU9i2', 0, 0, 1, 'en', 'First Name', 'Last Name', 'gender_female', '', '', '1611147350');

-- --------------------------------------------------------

--
-- Table structure for table `core_values`
--

CREATE TABLE `core_values` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `caption_en` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `value` text COLLATE utf8mb4_bin NOT NULL,
  `essential` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `core_values`
--

INSERT INTO `core_values` (`id`, `name`, `caption_en`, `value`, `essential`) VALUES
(1, 'gender_diverse', 'Diverse', 'diverse', 1),
(2, 'gender_female', 'Female', 'female', 1),
(3, 'gender_male', 'Male', 'male', 1),
(15, 'input_type_boolean', 'Boolean', 'boolean', 1),
(18, 'input_type_text', 'Text', 'text', 0),
(19, 'input_type_select', 'Select', 'select', 0),
(20, 'input_type_colorpicker', 'Color', 'color', 0),
(23, 'include_position_head_start', 'head (start)', 'head_start', 1),
(24, 'include_position_body_start', 'body (start)', 'body_start', 1),
(25, 'include_position_body_end', 'body (end)', 'body_end', 0),
(26, 'include_position_head_end', 'head (end)', 'head_end', 0);

-- --------------------------------------------------------

--
-- Table structure for table `core_valuesets`
--

CREATE TABLE `core_valuesets` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `caption_en` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `contained_values` text COLLATE utf8mb4_bin NOT NULL,
  `essential` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `core_valuesets`
--

INSERT INTO `core_valuesets` (`id`, `name`, `caption_en`, `contained_values`, `essential`) VALUES
(1, 'genders', 'Genders', '[\"gender_diverse\",\"gender_female\",\"gender_male\"]', 1),
(2, 'input_types', 'Input types', '[\"input_type_boolean\",\"input_type_select\",\"input_type_text\"]', 1),
(3, 'include_positions', 'Include position', '[\"include_position_body_start\",\"include_position_body_end\",\"include_position_head_end\",\"include_position_head_start\"]', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `core_captions`
--
ALTER TABLE `core_captions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_dblog`
--
ALTER TABLE `core_dblog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_includes`
--
ALTER TABLE `core_includes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_settings`
--
ALTER TABLE `core_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_users`
--
ALTER TABLE `core_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userName` (`username`);

--
-- Indexes for table `core_values`
--
ALTER TABLE `core_values`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `core_valuesets`
--
ALTER TABLE `core_valuesets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `core_captions`
--
ALTER TABLE `core_captions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `core_dblog`
--
ALTER TABLE `core_dblog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `core_includes`
--
ALTER TABLE `core_includes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `core_settings`
--
ALTER TABLE `core_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `core_users`
--
ALTER TABLE `core_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `core_values`
--
ALTER TABLE `core_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `core_valuesets`
--
ALTER TABLE `core_valuesets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
