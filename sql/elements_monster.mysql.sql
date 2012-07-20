-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 20. Jul 2012 um 17:50
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
(1, 'Middle management marketing guy', '', 7, 2, 1, NULL, 0, 0, 2, 'The five forces are strong with him.');

--
-- Daten für Tabelle `mt_monster_skills`
--

INSERT INTO `mt_monster_skills` (`id`, `monsterID`, `skillID`, `prob`) VALUES
(1, 1, 1, 0.500000),
(2, 1, 3, 0.500000);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
