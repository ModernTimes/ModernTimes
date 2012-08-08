-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 07. Aug 2012 um 19:43
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
-- Daten für Tabelle `mt_monster`
--

INSERT INTO `mt_monster` (`id`, `title`, `specialClass`, `sex`, `contactID`, `contactProb`, `hpMax`, `attack`, `defense`, `xp`, `msgEncounter`) VALUES
(1, 'Junior advertising specialist', '', 'male', 1, 0.050, 2, 4, 4, NULL, ''),
(2, 'Receptionist', 'ReceptionistMonster', NULL, 1, 0.050, 1, 4, 4, NULL, ''),
(3, 'Middle management manager guy', '', 'male', 1, 0.050, 4, 5, 5, NULL, ''),
(4, 'Sales person coordinator', '', 'male', 1, 0.050, 2, 4, 4, NULL, ''),
(5, 'Jehovah''s Witness', '', NULL, NULL, 0.000, 7, 3, 0, 1.0, '%1$s rings at your door. You open. Stupid you.');

--
-- Daten für Tabelle `mt_monster_battleskills`
--

INSERT INTO `mt_monster_battleskills` (`id`, `monsterID`, `battleskillID`, `prob`) VALUES
(2, 1, 1, 0.340000),
(3, 1, 6, 0.660000),
(4, 5, 9, 1.000000);

--
-- Daten für Tabelle `mt_monster_items`
--

INSERT INTO `mt_monster_items` (`id`, `monsterID`, `itemID`, `prob`) VALUES
(1, 1, 7, 0.200000),
(2, 1, 12, 0.200000),
(3, 4, 13, 0.200000),
(4, 4, 9, 0.200000),
(5, 3, 10, 0.200000),
(6, 3, 14, 0.200000);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
