-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 06. Aug 2012 um 13:25
-- Server Version: 5.5.16
-- PHP-Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `mt`
--

--
-- Daten für Tabelle `mt_quest`
--

INSERT INTO `mt_quest` (`id`, `name`, `specialClass`, `rejectable`, `desc`) VALUES
(1, 'Waking up', 'TutorialQuest', 0, 'Your head is throbbing and the world is spinning around you. It''s time to wake up and get your shit together.'),
(2, 'Beelzebub watches', 'Gluttony1Quest', 0, ''),
(3, 'Mammon watches', 'Greed1Quest', 0, ''),
(4, 'Lucifer calls', 'Pride1Quest', 0, ''),
(5, 'Asmodeus calls', 'Lust1Quest', 0, ''),
(6, 'Leviathan calls', 'Envy1Quest', 0, ''),
(7, 'Satan calls', 'Wrath1Quest', 0, ''),
(8, 'Belphegor calls', 'Sloth1Quest', 0, ''),
(9, 'My first PowerPoint presentation', 'Consultant1Quest', 0, 'After three whole weeks of training, you are finally ready to tell some of the biggest companies in the world how to do their job. So go out there and make your first PowerPoint presentation!');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
