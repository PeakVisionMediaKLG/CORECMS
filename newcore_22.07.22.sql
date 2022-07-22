-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 22. Jul 2022 um 17:44
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
  `unique_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `src_file` text NOT NULL,
  `src_db` text NOT NULL,
  `use_in_dev` tinyint(1) NOT NULL,
  `use_in_prod` tinyint(1) NOT NULL,
  `eval` tinyint(4) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `app_assets`
--

INSERT INTO `app_assets` (`id`, `unique_id`, `name`, `src_file`, `src_db`, `use_in_dev`, `use_in_prod`, `eval`, `is_active`, `created_by`, `created_date`) VALUES
(1, 'asset_eb2b029ea923bee01d38589815ada57c', 'Bootstrap JS 5.2 ', '', '<!-- JavaScript Bundle with Popper  --><script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js\" integrity=\"sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2\" crossorigin=\"anonymous\"></script>', 0, 0, 0, 1, 'Admin', '1653989635'),
(3, 'asset_7c6b54d3020e4c757756eb921f69a76d', 'Bootstrap CSS 5.2', '', '<!-- CSS only --><link href=', 0, 0, 0, 1, 'Admin', '1653989497');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `app_assets_archive`
--

CREATE TABLE `app_assets_archive` (
  `archive_id` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `src_file` text NOT NULL,
  `src_db` text NOT NULL,
  `use_in_dev` tinyint(1) NOT NULL,
  `use_in_prod` tinyint(1) NOT NULL,
  `eval` tinyint(4) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  `edited_date` varchar(255) NOT NULL,
  `edited_action` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `app_assets_archive`
--

INSERT INTO `app_assets_archive` (`archive_id`, `unique_id`, `name`, `src_file`, `src_db`, `use_in_dev`, `use_in_prod`, `eval`, `is_active`, `created_by`, `created_date`, `edited_by`, `edited_date`, `edited_action`) VALUES
(5, 'asset_eb2b029ea923bee01d38589815ada57c', 'Bootstrap JS 5.2', '', '<!-- JavaScript Bundle with Popper --><script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js\" integrity=\"sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2\" crossorigin=\"anonymous\"></script>', 0, 0, 0, 1, 'Admin', '1653989635', 'Admin', '1657542275', 'update'),
(6, 'asset_7c6b54d3020e4c757756eb921f69a76d', 'Bootstrap CSS 5.2 ', '', '<!-- CSS only --><link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor\" crossorigin=\"anonymous\">', 0, 0, 0, 1, 'Admin', '1653989497', 'Admin', '1658140329', 'update'),
(7, 'asset_7c6b54d3020e4c757756eb921f69a76d', 'Bootstrap CSS 5.2', '', '<!-- CSS only --><link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor\" crossorigin=\"anonymous\">', 1, 1, 0, 1, 'Admin', '1653989497', 'Admin', '1658140341', 'update'),
(8, 'asset_85fc89c78d0af2110cd622b87720d593', 'test', '', 'test', 1, 1, 1, 1, 'Admin', '1658142914', 'Admin', '1658142944', 'update'),
(9, 'asset_85fc89c78d0af2110cd622b87720d593', 'test', '', 'test', 1, 0, 0, 1, 'Admin', '1658142914', 'Admin', '1658142958', 'update'),
(10, 'asset_85fc89c78d0af2110cd622b87720d593', 'test', '', 'test', 1, 1, 1, 1, 'Admin', '1658142914', 'Admin', '1658142992', 'delete'),
(11, 'asset_85fc89c78d0af2110cd622b87720d593', 'test', '', 'test', 1, 1, 1, 1, 'Admin', '1658142914', 'Admin', '1658143259', 'delete'),
(12, 'asset_7c6b54d3020e4c757756eb921f69a76d', 'Bootstrap CSS 5.2', '', '<!-- CSS only --><link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor\" crossorigin=\"anonymous\">', 0, 0, 0, 1, 'Admin', '1653989497', 'Admin', '1658430798', 'delete');

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
-- Tabellenstruktur für Tabelle `app_languages`
--

CREATE TABLE `app_languages` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
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
-- Daten für Tabelle `app_languages`
--

INSERT INTO `app_languages` (`id`, `unique_id`, `name`, `code_2digit`, `code_5digit`, `short_caption`, `long_caption`, `is_active`, `created_by`, `created_date`) VALUES
(1, 'language_9b9ef3204cf0abba6a3d09532b2a58fd', 'English', 'en', 'en_US', 'EN', 'English', 1, 'Admin', '1654787617'),
(6, 'language_83abc2997f7022568ac4903f855206f8', 'Deutsch', 'de', 'de_DE', 'DE', 'Deutsch', 1, 'Admin', '1654787755');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `app_languages_archive`
--

CREATE TABLE `app_languages_archive` (
  `archive_id` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
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
  `edited_action` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `app_languages_archive`
--

INSERT INTO `app_languages_archive` (`archive_id`, `unique_id`, `name`, `code_2digit`, `code_5digit`, `short_caption`, `long_caption`, `is_active`, `created_by`, `created_date`, `edited_by`, `edited_date`, `edited_action`) VALUES
(11, 'language_840c63142388aad50e76b1f576888a7e', 'ertgaw', 'rt', 'teret', 'strester', 'srtstretsr', 0, 'Admin', '1655300969', 'Admin', '1655300987', 'delete'),
(12, 'language_83abc2997f7022568ac4903f855206f8', 'Deutsch', 'de', 'de_DE', 'DE', 'Deutsch', 1, 'Admin', '1654787755', 'Admin', '1656488770', 'update'),
(13, 'language_83abc2997f7022568ac4903f855206f8', 'Deutsch1', 'de', 'de_DE', 'DE', 'Deutsch', 1, 'Admin', '1654787755', 'Admin', '1656488785', 'update'),
(14, 'language_83abc2997f7022568ac4903f855206f8', 'Deutsch', 'de', 'de_DE', 'DE', 'Deutsch', 1, 'Admin', '1654787755', 'Admin', '1656504432', 'update'),
(15, 'language_83abc2997f7022568ac4903f855206f8', 'Deutsch', 'de', 'de_DE', 'DE', 'Deutsch', 0, 'Admin', '1654787755', 'Admin', '1656504438', 'update'),
(16, 'language_83abc2997f7022568ac4903f855206f8', 'Deutsch', 'de', 'de_DE', 'DE', 'Deutsch', 1, 'Admin', '1654787755', 'Admin', '1656680104', 'update'),
(17, 'language_9b9ef3204cf0abba6a3d09532b2a58fd', 'English', 'en', 'en_US', 'EN', 'English', 1, 'Admin', '1654787617', 'Admin', '1657542129', 'update'),
(18, 'language_9b9ef3204cf0abba6a3d09532b2a58fd', 'English', 'en', 'en_Us', 'EN', 'English', 1, 'Admin', '1654787617', 'Admin', '1657542221', 'update'),
(19, 'language_fc1926badd3ab08c60b0c21e58c62047', 'Italiano', 'it', 'it_IT', 'IT', 'Italiano', 1, 'Admin', '1657546771', 'Admin', '1657546816', 'update'),
(21, 'language_83abc2997f7022568ac4903f855206f8', 'Deutsch', 'de', 'de_DE', 'DE', 'Deutsch', 1, 'Admin', '1654787755', 'Admin', '1658430820', 'delete'),
(22, 'language_83abc2997f7022568ac4903f855206f8', 'Deutsch', 'de', 'de_DE', 'DE', 'Deutsch', 1, 'Admin', '1654787755', 'Admin', '1658430979', 'update'),
(23, 'language_83abc2997f7022568ac4903f855206f8', 'Deutschdfhlj', 'de', 'de_DE', 'DE', 'Deutsch', 1, 'Admin', '1654787755', 'Admin', '1658430995', 'update');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `app_pages`
--

CREATE TABLE `app_pages` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `shared_id` varchar(255) NOT NULL,
  `uses_template` varchar(255) NOT NULL,
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
  `created_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `app_pages`
--

INSERT INTO `app_pages` (`id`, `unique_id`, `shared_id`, `uses_template`, `language`, `url`, `link_text`, `title`, `show_in_navigation`, `auth_access_only`, `access_counter`, `timed_from`, `timed_until`, `is_active`, `created_by`, `created_date`) VALUES
(4, 'page_c2ac38e5893d85db1a5d07980c4f56ee', '11d19bbeec19d2ba4ee556f818f19ac0', '', 'de', 'sfa', 'afsd', 'afs', 1, 0, 0, '', '', 1, 'Admin', '1657535125');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `app_pages_archive`
--

CREATE TABLE `app_pages_archive` (
  `archive_id` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `shared_id` varchar(255) NOT NULL,
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
  `edited_by` varchar(255) NOT NULL,
  `edited_date` varchar(255) NOT NULL,
  `edited_action` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `app_pages_archive`
--

INSERT INTO `app_pages_archive` (`archive_id`, `unique_id`, `shared_id`, `language`, `url`, `link_text`, `title`, `show_in_navigation`, `auth_access_only`, `access_counter`, `timed_from`, `timed_until`, `is_active`, `created_by`, `created_date`, `edited_by`, `edited_date`, `edited_action`) VALUES
(5, '', '', '', '', '', '', 0, 0, 0, '', '', 0, '', '', 'Admin', '1657542236', 'update'),
(6, 'page_c2ac38e5893d85db1a5d07980c4f56ee', '11d19bbeec19d2ba4ee556f818f19ac0', 'de', 'sfa', 'afsd', 'afs', 0, 0, 0, '', '', 1, 'Admin', '1657535125', 'Admin', '1657542451', 'update'),
(7, 'page_c2ac38e5893d85db1a5d07980c4f56ee', '11d19bbeec19d2ba4ee556f818f19ac0', 'de', 'sfa', 'afsd', 'afs', 1, 0, 0, '', '', 1, 'Admin', '1657535125', 'Admin', '1657542463', 'update'),
(8, 'page_c2ac38e5893d85db1a5d07980c4f56ee', '11d19bbeec19d2ba4ee556f818f19ac0', 'de', 'sfa', 'afsd', 'afs', 0, 0, 0, '', '', 1, 'Admin', '1657535125', 'Admin', '1657547333', 'update'),
(9, 'page_c2ac38e5893d85db1a5d07980c4f56ee', '11d19bbeec19d2ba4ee556f818f19ac0', 'de', 'sfa', 'afsd', 'afs', 1, 0, 0, '', '', 1, 'Admin', '1657535125', 'Admin', '1657547349', 'update'),
(10, 'page_c2ac38e5893d85db1a5d07980c4f56ee', '11d19bbeec19d2ba4ee556f818f19ac0', 'de', 'sfa', 'afsdddd', 'afs', 1, 0, 0, '', '', 1, 'Admin', '1657535125', 'Admin', '1657547359', 'update'),
(11, 'page_7b142cf1b293e8d7c2cb1a949ce6da18', '11d19bbeec19d2ba4ee556f818f19ac0', 'en', 'dhgd', 'gfdfg', 'dfgdgf', 1, 0, 0, '', '', 1, 'Admin', '1657542473', 'Admin', '1657552414', 'delete'),
(12, 'page_7b142cf1b293e8d7c2cb1a949ce6da18', '11d19bbeec19d2ba4ee556f818f19ac0', 'en', 'dhgd', 'gfdfg', 'dfgdgf', 1, 0, 0, '', '', 1, 'Admin', '1657542473', 'Admin', '1657552461', 'delete');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `app_page_objects`
--

CREATE TABLE `app_page_objects` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent` varchar(255) NOT NULL,
  `object_type` varchar(255) NOT NULL,
  `excluded_languages` text NOT NULL,
  `timed_from` varchar(255) NOT NULL,
  `timed_until` varchar(255) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `app_page_objects`
--

INSERT INTO `app_page_objects` (`id`, `unique_id`, `name`, `parent`, `object_type`, `excluded_languages`, `timed_from`, `timed_until`, `is_active`, `created_by`, `created_date`) VALUES
(0, '11d19bbeec19d2ba4ee556f818f19ac0', 'test1', '', 'page', '', '', '', 1, 'Admin', '1647005905'),
(1, 'f94cb1ae17316984927376e7a3c063ab', 'test2', '', 'page', '', '', '', 0, 'Admin', '1647006087'),
(2, '13a096aca73fde935efd22b938e4868f', 'test3', '11d19bbeec19d2ba4ee556f818f19ac0', 'page', '', '', '', 0, 'Admin', '1647005932'),
(4, '106c0f8fefca0691e829f2758c6ed061', 'dsfasfdggg', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656407891'),
(7, 'po_06f34aa21a2bc6d3071082f73e45d0bf', 'dfsasdasd', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656408238'),
(9, 'po_f0f1cbe88cbab76c203c75286a2a607b', 'afcav', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656504276'),
(10, 'page_object_71a0cb52dc276e7fabe2fccc03019fb0', 'böa', '11d19bbeec19d2ba4ee556f818f19ac0', 'page', '', '', '', 0, 'Admin', '1657550527');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `app_page_objects_archive`
--

CREATE TABLE `app_page_objects_archive` (
  `archive_id` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
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
  `edited_date` varchar(255) NOT NULL,
  `edited_action` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `app_page_objects_archive`
--

INSERT INTO `app_page_objects_archive` (`archive_id`, `unique_id`, `name`, `parent`, `object_type`, `excluded_languages`, `timed_from`, `timed_until`, `is_active`, `created_by`, `created_date`, `edited_by`, `edited_date`, `edited_action`) VALUES
(6, '', '', '', '', '', '', '', 0, '', '', 'Admin', '1656408087', 'update'),
(7, '', '', '', '', '', '', '', 0, '', '', 'Admin', '1656408274', 'update'),
(8, '', '', '', '', '', '', '', 0, '', '', 'Admin', '1656488594', 'update'),
(9, '', '', '', '', '', '', '', 0, '', '', 'Admin', '1656488719', 'update'),
(10, '', '', '', '', '', '', '', 0, '', '', 'Admin', '1656489095', 'update'),
(11, '', '', '', '', '', '', '', 0, '', '', 'Admin', '1656489188', 'update'),
(12, 'po_06f34aa21a2bc6d3071082f73e45d0bf', 'dfsasdas', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656408238', 'Admin', '1656498125', 'update'),
(13, 'po_06f34aa21a2bc6d3071082f73e45d0bf', 'dfsasdasd', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656408238', 'Admin', '1656592716', 'update'),
(14, 'po_06f34aa21a2bc6d3071082f73e45d0bf', 'dfsasdasde', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656408238', 'Admin', '1656603891', 'update'),
(15, 'po_06f34aa21a2bc6d3071082f73e45d0bf', 'dfsasdasdeuuu', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656408238', 'Admin', '1656673154', 'update'),
(16, 'po_06f34aa21a2bc6d3071082f73e45d0bf', 'dfsasdasdeuuu6', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656408238', 'Admin', '1656673602', 'update'),
(17, 'po_06f34aa21a2bc6d3071082f73e45d0bf', 'dfsasdasdeuu', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656408238', 'Admin', '1656674144', 'update'),
(18, 'po_06f34aa21a2bc6d3071082f73e45d0bf', 'dfsasdasdeuu7', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656408238', 'Admin', '1656674373', 'update'),
(19, 'po_06f34aa21a2bc6d3071082f73e45d0bf', 'dfsasdasdeuu', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656408238', 'Admin', '1656674410', 'update'),
(20, 'po_06f34aa21a2bc6d3071082f73e45d0bf', 'dfsasdas', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656408238', 'Admin', '1656674803', 'update'),
(21, 'po_06f34aa21a2bc6d3071082f73e45d0bf', 'dfsasdas', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656408238', 'Admin', '1656674903', 'update'),
(22, 'po_06f34aa21a2bc6d3071082f73e45d0bf', 'dfs', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656408238', 'Admin', '1656674924', 'update'),
(23, 'po_06f34aa21a2bc6d3071082f73e45d0bf', 'dfs', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656408238', 'Admin', '1656675480', 'update'),
(24, 'po_06f34aa21a2bc6d3071082f73e45d0bf', 'dfs', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656408238', 'Admin', '1656675700', 'update'),
(25, 'po_06f34aa21a2bc6d3071082f73e45d0bf', 'dfsasdasdeuu', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656408238', 'Admin', '1656675781', 'update'),
(26, 'po_06f34aa21a2bc6d3071082f73e45d0bf', 'dfsasdasdeuu', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656408238', 'Admin', '1656675857', 'update'),
(27, 'po_06f34aa21a2bc6d3071082f73e45d0bf', 'dfsasdasd', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656408238', 'Admin', '1656675869', 'update'),
(28, 'po_06f34aa21a2bc6d3071082f73e45d0bf', 'd', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656408238', 'Admin', '1656675875', 'update'),
(29, 'po_06f34aa21a2bc6d3071082f73e45d0bf', 'dfsasdasd', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656408238', 'Admin', '1656676155', 'delete'),
(30, '106c0f8fefca0691e829f2758c6ed061', 'dsfasfd', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656407891', 'Admin', '1657280804', 'update'),
(31, '', '', '', '', '', '', '', 0, '', '', 'Admin', '1657286674', 'update'),
(32, '106c0f8fefca0691e829f2758c6ed061', 'dsfasfdggg', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656407891', 'Admin', '1657288596', 'delete'),
(33, '106c0f8fefca0691e829f2758c6ed061', 'dsfasfdggg', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 0, 'Admin', '1656407891', 'Admin', '1657291951', 'update'),
(34, '106c0f8fefca0691e829f2758c6ed061', 'dsfasfdggg', '13a096aca73fde935efd22b938e4868f', 'page', '', '', '', 1, 'Admin', '1656407891', 'Admin', '1657291960', 'update'),
(35, '11d19bbeec19d2ba4ee556f818f19ac0', 'test1', '', 'page', '', '', '', 0, 'Admin', '1647005905', 'Admin', '1657547396', 'update');

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
  `unique_id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `allowed_extensions` text NOT NULL,
  `disallowed_extensions` text NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `is_admin` tinyint(4) NOT NULL,
  `preferred_language` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `core_users`
--

INSERT INTO `core_users` (`id`, `unique_id`, `username`, `password`, `allowed_extensions`, `disallowed_extensions`, `is_active`, `is_admin`, `preferred_language`, `first_name`, `last_name`, `gender`, `email`, `created_by`, `created_date`) VALUES
(1, '2297aa9f09d86e9af9e1da9467620a7f', 'Admin', '$2y$10$ZeEzss9Ty4lwSRudmJmx6OtbAC7sYmauZ7uim0IX2dOtyHULC5HTa', '', '', 1, 1, 'en', 'John', 'Doe', 'male', '', '', ''),
(2, '33414ed1f8fc7d5aef61146977d2d2fb', 'Editor', '$2y$10$mLUjWS94vJd94Ace48kLweG2NPo5m40iGdLuPKEn8Nj6rRj0b2OjW', '', '', 0, 0, 'en', 'Jane', 'Doe', 'female', '', '', '1644917046');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `core_users_archive`
--

CREATE TABLE `core_users_archive` (
  `archive_id` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `allowed_extensions` text NOT NULL,
  `disallowed_extensions` text NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `is_admin` tinyint(4) NOT NULL,
  `preferred_language` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  `edited_date` varchar(255) NOT NULL,
  `edited_action` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `templates_content`
--

CREATE TABLE `templates_content` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `origin` varchar(255) NOT NULL,
  `parent` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `timed_from` varchar(255) NOT NULL,
  `timed_until` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `templates_pages`
--

CREATE TABLE `templates_pages` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `timed_from` varchar(255) NOT NULL,
  `timed_until` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `templates_pages`
--

INSERT INTO `templates_pages` (`id`, `unique_id`, `name`, `timed_from`, `timed_until`, `created_by`, `created_date`) VALUES
(3, 'page_template_81c84e065926061f5363303d9ff39eeb', 'Default', '', '', 'Admin', '1658431028');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `templates_pages_archive`
--

CREATE TABLE `templates_pages_archive` (
  `archive_id` int(11) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `timed_from` varchar(255) NOT NULL,
  `timed_until` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `edited_by` varchar(255) NOT NULL,
  `edited_date` varchar(255) NOT NULL,
  `edited_action` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `templates_pages_archive`
--

INSERT INTO `templates_pages_archive` (`archive_id`, `unique_id`, `name`, `timed_from`, `timed_until`, `created_by`, `created_date`, `edited_by`, `edited_date`, `edited_action`) VALUES
(1, 'page_object_26a6eefd0a271d761197b594fe8a8d52', 'Default', '', '', 'Admin', '1658392347', 'Admin', '1658409225', 'delete'),
(2, 'page_template_ff0c0c18f05858061ab41f4052faf988', 'Default', '', '', 'Admin', '1658431028', 'Admin', '1658488015', 'update'),
(3, 'page_template_2f66cd24c11019c7232bff1eb11892a8', 'Default2', '', '', 'Admin', '1658431028', 'Admin', '1658488026', 'update');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `app_assets`
--
ALTER TABLE `app_assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`unique_id`);

--
-- Indizes für die Tabelle `app_assets_archive`
--
ALTER TABLE `app_assets_archive`
  ADD PRIMARY KEY (`archive_id`);

--
-- Indizes für die Tabelle `app_headless_content`
--
ALTER TABLE `app_headless_content`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `app_languages`
--
ALTER TABLE `app_languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `unique_id` (`unique_id`);

--
-- Indizes für die Tabelle `app_languages_archive`
--
ALTER TABLE `app_languages_archive`
  ADD PRIMARY KEY (`archive_id`);

--
-- Indizes für die Tabelle `app_pages`
--
ALTER TABLE `app_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`),
  ADD UNIQUE KEY `unique_identifier` (`unique_id`);

--
-- Indizes für die Tabelle `app_pages_archive`
--
ALTER TABLE `app_pages_archive`
  ADD PRIMARY KEY (`archive_id`);

--
-- Indizes für die Tabelle `app_page_objects`
--
ALTER TABLE `app_page_objects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shared_identifier` (`unique_id`),
  ADD UNIQUE KEY `unique_identifier` (`unique_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `app_page_objects_archive`
--
ALTER TABLE `app_page_objects_archive`
  ADD PRIMARY KEY (`archive_id`);

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
  ADD UNIQUE KEY `unique_id` (`unique_id`);

--
-- Indizes für die Tabelle `core_users_archive`
--
ALTER TABLE `core_users_archive`
  ADD PRIMARY KEY (`archive_id`);

--
-- Indizes für die Tabelle `templates_content`
--
ALTER TABLE `templates_content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`unique_id`);

--
-- Indizes für die Tabelle `templates_pages`
--
ALTER TABLE `templates_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_identifier` (`unique_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `templates_pages_archive`
--
ALTER TABLE `templates_pages_archive`
  ADD PRIMARY KEY (`archive_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `app_assets`
--
ALTER TABLE `app_assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `app_assets_archive`
--
ALTER TABLE `app_assets_archive`
  MODIFY `archive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT für Tabelle `app_headless_content`
--
ALTER TABLE `app_headless_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `app_languages`
--
ALTER TABLE `app_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `app_languages_archive`
--
ALTER TABLE `app_languages_archive`
  MODIFY `archive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT für Tabelle `app_pages`
--
ALTER TABLE `app_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `app_pages_archive`
--
ALTER TABLE `app_pages_archive`
  MODIFY `archive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT für Tabelle `app_page_objects`
--
ALTER TABLE `app_page_objects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `app_page_objects_archive`
--
ALTER TABLE `app_page_objects_archive`
  MODIFY `archive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

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

--
-- AUTO_INCREMENT für Tabelle `core_users_archive`
--
ALTER TABLE `core_users_archive`
  MODIFY `archive_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `templates_content`
--
ALTER TABLE `templates_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `templates_pages`
--
ALTER TABLE `templates_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `templates_pages_archive`
--
ALTER TABLE `templates_pages_archive`
  MODIFY `archive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
