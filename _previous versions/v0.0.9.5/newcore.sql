-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2022 at 10:41 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newcore`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_assets`
--

CREATE TABLE `app_assets` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `src_file` text NOT NULL,
  `src_db` text NOT NULL,
  `eval` tinyint(4) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `app_assets`
--

INSERT INTO `app_assets` (`id`, `unique_id`, `name`, `src_file`, `src_db`, `eval`, `is_active`, `created_by`, `created_date`) VALUES
(1, '', 'Bootstrap 5.1 CSS', '', '<!-- Bootstrap CSS -->\r\n    <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3\" crossorigin=\"anonymous\">', 0, 1, '', ''),
(2, 'bla', 'Bootstrap 5.1 JS', '', '<!-- Option 1: Bootstrap Bundle with Popper -->    <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js\" integrity=\"sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p\" crossorigin=\"anonymous\"></script>', 0, 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `app_assets_archive`
--

CREATE TABLE `app_assets_archive` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `src_file` text NOT NULL,
  `src_db` text NOT NULL,
  `eval` tinyint(4) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  `edited_date` varchar(255) NOT NULL,
  `edited_action` varchar(255) NOT NULL,
  `archive_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `app_assets_archive`
--

INSERT INTO `app_assets_archive` (`id`, `unique_id`, `name`, `src_file`, `src_db`, `eval`, `is_active`, `created_by`, `created_date`, `edited_by`, `edited_date`, `edited_action`, `archive_id`) VALUES
(2, 'bla', 'Bootstrap 5.1 JS', '', '<!-- Option 1: Bootstrap Bundle with Popper -->    <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js\" integrity=\"sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p\" crossorigin=\"anonymous\"></script>', 0, 1, '', '', 'Admin', '1653410742', 'update', 1);

-- --------------------------------------------------------

--
-- Table structure for table `app_headless_content`
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
-- Table structure for table `app_headless_content_archive`
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
-- Table structure for table `app_languages`
--

CREATE TABLE `app_languages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code_2digit` varchar(2) NOT NULL,
  `code_5digit` varchar(5) NOT NULL,
  `short_caption` varchar(255) NOT NULL,
  `long_caption` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `app_languages`
--

INSERT INTO `app_languages` (`id`, `name`, `code_2digit`, `code_5digit`, `short_caption`, `long_caption`, `is_active`, `created_by`, `created_date`) VALUES
(1, 'english', 'en', 'en_US', 'EN', 'English', 1, '', ''),
(2, 'deutsch', 'de', 'de_DE', 'DE', 'Deutsch', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `app_languages_archive`
--

CREATE TABLE `app_languages_archive` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code_2digit` varchar(2) NOT NULL,
  `code_5digit` varchar(5) NOT NULL,
  `short_caption` varchar(255) NOT NULL,
  `long_caption` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  `edited_date` varchar(255) NOT NULL,
  `edited_action` varchar(255) NOT NULL,
  `archive_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `app_pages`
--

CREATE TABLE `app_pages` (
  `id` int(11) NOT NULL,
  `unique_identifier` varchar(255) NOT NULL,
  `shared_identifier` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `link_text` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `show_in_navigation` tinyint(4) NOT NULL,
  `auth_access_only` tinyint(4) NOT NULL,
  `access_counter` int(11) DEFAULT 0,
  `timed_from` varchar(255) NOT NULL,
  `timed_until` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `edited_by` varchar(255) DEFAULT NULL,
  `edited_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `app_pages`
--

INSERT INTO `app_pages` (`id`, `unique_identifier`, `shared_identifier`, `language`, `url`, `link_text`, `title`, `show_in_navigation`, `auth_access_only`, `access_counter`, `timed_from`, `timed_until`, `is_active`, `created_by`, `created_date`, `edited_by`, `edited_date`) VALUES
(1, '', '8f61ff8a08d1be541d2a787f527a320c', 'de', 'subsub_de', 'Sub Sub DE', 'Sub Sub DE', 1, 0, 0, '', '', 1, 'Admin', '1647006390', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `app_pages_archive`
--

CREATE TABLE `app_pages_archive` (
  `id` int(11) NOT NULL,
  `original_identifier` varchar(255) NOT NULL,
  `shared_identifier` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `link_text` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `show_in_navigation` tinyint(4) NOT NULL,
  `auth_access_only` tinyint(4) NOT NULL,
  `access_counter` int(11) DEFAULT 0,
  `timed_from` varchar(255) NOT NULL,
  `timed_until` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  `edited_date` varchar(255) NOT NULL,
  `deleted_by` varchar(255) NOT NULL,
  `deleted_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `app_page_objects`
--

CREATE TABLE `app_page_objects` (
  `id` int(11) NOT NULL,
  `unique_identifier` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent` varchar(255) NOT NULL,
  `object_type` varchar(255) NOT NULL,
  `excluded_languages` text NOT NULL,
  `timed_from` varchar(255) NOT NULL,
  `timed_until` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  `edited_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `app_page_objects`
--

INSERT INTO `app_page_objects` (`id`, `unique_identifier`, `name`, `parent`, `object_type`, `excluded_languages`, `timed_from`, `timed_until`, `is_active`, `created_by`, `created_date`, `edited_by`, `edited_date`) VALUES
(0, '11d19bbeec19d2ba4ee556f818f19ac0', 'test1', '', 'page', '', '', '', 0, 'Admin', '1647005905', '', ''),
(1, 'f94cb1ae17316984927376e7a3c063ab', 'test2', '', 'page', '', '', '', 0, 'Admin', '1647006087', '', ''),
(2, '8f61ff8a08d1be541d2a787f527a320c', 'test4', '11d19bbeec19d2ba4ee556f818f19ac0', 'page', '', '', '', 1, 'Admin', '1647006070', 'Admin', '1653299905'),
(3, '13a096aca73fde935efd22b938e4868f', 'test3', '11d19bbeec19d2ba4ee556f818f19ac0', 'page', '', '', '', 0, 'Admin', '1647005932', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `app_page_objects_archive`
--

CREATE TABLE `app_page_objects_archive` (
  `id` int(11) NOT NULL,
  `original_identifier` varchar(255) NOT NULL,
  `parent` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `object_type` varchar(255) NOT NULL,
  `excluded_languages` text NOT NULL,
  `timed_from` varchar(255) NOT NULL,
  `timed_until` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  `edited_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `core_languages`
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
-- Dumping data for table `core_languages`
--

INSERT INTO `core_languages` (`id`, `name`, `code_2digit`, `code_5digit`, `short_caption`, `long_caption`) VALUES
(1, 'deutsch', 'de', 'de_DE', 'DE', 'Deutsch');

-- --------------------------------------------------------

--
-- Table structure for table `core_users`
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
-- Dumping data for table `core_users`
--

INSERT INTO `core_users` (`id`, `identifier`, `username`, `password`, `allowed_workspaces`, `disallowed_workspaces`, `is_active`, `is_admin`, `preferred_language`, `first_name`, `last_name`, `gender`, `email`, `date_created`) VALUES
(1, '2297aa9f09d86e9af9e1da9467620a7f', 'Admin', '$2y$10$ZeEzss9Ty4lwSRudmJmx6OtbAC7sYmauZ7uim0IX2dOtyHULC5HTa', '', '', 1, 1, 'en', 'John', 'Doe', 'male', '', ''),
(2, '33414ed1f8fc7d5aef61146977d2d2fb', 'Editor', '$2y$10$LRGDaTaggxMaFtqs4CypZet18rn.9KWpqfZFqRcEyMBb2B6GYZlVi', '', '', 1, 0, 'en', 'Jane', 'Doe', 'female', '', '1644917046');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_assets`
--
ALTER TABLE `app_assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `unique_id` (`unique_id`);

--
-- Indexes for table `app_assets_archive`
--
ALTER TABLE `app_assets_archive`
  ADD PRIMARY KEY (`archive_id`);

--
-- Indexes for table `app_headless_content`
--
ALTER TABLE `app_headless_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_headless_content_archive`
--
ALTER TABLE `app_headless_content_archive`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `original_id` (`original_id`);

--
-- Indexes for table `app_languages`
--
ALTER TABLE `app_languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `code_2digit` (`code_2digit`);

--
-- Indexes for table `app_languages_archive`
--
ALTER TABLE `app_languages_archive`
  ADD PRIMARY KEY (`archive_id`);

--
-- Indexes for table `app_pages`
--
ALTER TABLE `app_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`),
  ADD UNIQUE KEY `unique_identifier` (`unique_identifier`);

--
-- Indexes for table `app_pages_archive`
--
ALTER TABLE `app_pages_archive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_page_objects`
--
ALTER TABLE `app_page_objects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shared_identifier` (`unique_identifier`),
  ADD UNIQUE KEY `unique_identifier` (`unique_identifier`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `app_page_objects_archive`
--
ALTER TABLE `app_page_objects_archive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_languages`
--
ALTER TABLE `core_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_users`
--
ALTER TABLE `core_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `identifier` (`identifier`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_assets`
--
ALTER TABLE `app_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `app_assets_archive`
--
ALTER TABLE `app_assets_archive`
  MODIFY `archive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_headless_content`
--
ALTER TABLE `app_headless_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_headless_content_archive`
--
ALTER TABLE `app_headless_content_archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_languages`
--
ALTER TABLE `app_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `app_languages_archive`
--
ALTER TABLE `app_languages_archive`
  MODIFY `archive_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_pages`
--
ALTER TABLE `app_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_pages_archive`
--
ALTER TABLE `app_pages_archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `app_page_objects`
--
ALTER TABLE `app_page_objects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `app_page_objects_archive`
--
ALTER TABLE `app_page_objects_archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `core_languages`
--
ALTER TABLE `core_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `core_users`
--
ALTER TABLE `core_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
