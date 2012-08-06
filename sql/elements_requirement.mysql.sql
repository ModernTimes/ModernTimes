-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 06. Aug 2012 um 13:35
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
-- Daten für Tabelle `mt_requirement`
--

INSERT INTO `mt_requirement` (`id`, `questID`, `questState`, `class`, `sex`, `level`, `mainstat`, `resoluteness`, `willpower`, `cunning`) VALUES
(1, NULL, 'completed', 'consultant', 'none', 0, 0, 0, 0, 0),
(2, NULL, 'completed', 'resoluteness', 'none', 0, 0, 0, 0, 0),
(3, NULL, 'completed', 'willpower', 'none', 0, 0, 0, 0, 0),
(4, NULL, 'completed', 'cunning', 'none', 0, 0, 0, 0, 0),
(5, NULL, 'completed', 'banker', 'none', 0, 0, 0, 0, 0),
(6, NULL, 'completed', 'none', 'male', 0, 0, 0, 0, 0),
(7, NULL, 'completed', 'none', 'female', 0, 0, 0, 0, 0),
(8, 2, 'completed', 'none', 'none', 0, 0, 0, 0, 0),
(9, 9, 'started', 'none', 'none', 0, 0, 0, 0, 0),
(10, 1, 'completed', 'consultant', 'none', 0, 0, 0, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
