-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 30. Jul 2012 um 18:57
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

INSERT INTO `mt_monster` (`id`, `name`, `specialClass`, `hpMax`, `attack`, `defense`, `xp`, `dropCash`, `dropFavours`, `dropKudos`, `msgEncounter`) VALUES
(1, 'Advertising specialist', '', 7, 3, 1, NULL, 0, 1, 1, '');

--
-- Daten für Tabelle `mt_monster_battleskills`
--

INSERT INTO `mt_monster_battleskills` (`id`, `monsterID`, `battleskillID`, `prob`) VALUES
(2, 1, 3, 0.500000);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
