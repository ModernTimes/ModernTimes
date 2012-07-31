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
-- Daten für Tabelle `mt_skill`
--

INSERT INTO `mt_skill` (`id`, `name`, `skillType`, `specialClass`, `charactermodifierID`, `costEnergy`, `healing`, `createEffectID`, `effectTurns`, `effectMsgIncreasedDuration`, `desc`, `msgResolved`) VALUES
(1, 'Pull an all-nighter', 'active', '', NULL, 1, 0, 8, 5, '', 'You pull an all-nighter in the office. You''ll be super prepared for whatever might be coming at you.', 'You just pulled an all-nighter in the office. Don''t worry: work-life balance is overratd anyway.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
