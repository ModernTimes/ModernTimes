-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 01. Aug 2012 um 18:50
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
-- Daten für Tabelle `mt_area`
--

INSERT INTO `mt_area` (`id`, `name`, `specialClass`, `requirementID`, `combatProb`) VALUES
(1, 'Undisclosed insurance company', '', 9, 1.000000);

--
-- Daten für Tabelle `mt_area_monsters`
--

INSERT INTO `mt_area_monsters` (`id`, `areaID`, `monsterID`, `requirementID`, `prob`) VALUES
(1, 1, 1, NULL, 0.200000),
(2, 1, 2, NULL, 1.000000),
(3, 1, 4, NULL, 1.000000),
(4, 1, 3, NULL, 1.000000);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
