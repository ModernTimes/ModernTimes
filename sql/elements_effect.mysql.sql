-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 31. Jul 2012 um 18:24
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
-- Daten für Tabelle `mt_effect`
--

INSERT INTO `mt_effect` (`id`, `name`, `specialClass`, `charactermodifierID`, `desc`) VALUES
(1, 'Good For Nothing', '', 5, 'You feel shit.'),
(2, 'High', '', 4, 'Your preferred state of mind. At least while you''re high.'),
(3, 'Sated', '', 6, ''),
(4, 'Drunk', '', NULL, ''),
(5, 'Stoned', '', NULL, ''),
(6, 'Hammered', '', NULL, ''),
(7, 'Surfeited', '', NULL, ''),
(8, 'Super prepared', '', 7, 'You are super prepared for whatever might be coming at you.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
