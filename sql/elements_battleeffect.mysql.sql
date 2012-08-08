-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 08. Aug 2012 um 19:37
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
-- Daten für Tabelle `mt_battleeffect`
--

INSERT INTO `mt_battleeffect` (`id`, `name`, `specialClass`, `buff`, `singleton`, `increaseDuration`, `blocks`, `blockActionTypes`, `blockActionNormalSpecial`, `blockChance`, `blockTurns`, `blockNumberOfBlocks`, `msgBlock`, `desc`, `msgExpire`) VALUES
(1, 'Babble momentum', 'BabbleComboEffect', 1, 1, 0, 0, 'all', 'all', 0.000000, 0, 0, '', 'Babbling gets more obnoxious the longer it goes on.', '%1$s loses %3$s babble momentum'),
(2, 'Unassailable employee', '', 1, 1, 1, 1, 'all', 'all', 0.600000, 3, 0, '%1$s thinks twice before attacking an employee of McBooz&Bain Consulting Group.', 'Employees of McBooz&Bain Consulting Group are pretty much unassailable.', '%1$s is no longer protected by McBooz&Bain Consulting Group.'),
(3, 'Trapped in a meeting', '', 0, 1, 1, 1, 'all', 'all', 0.750000, -1, 2, '%1$s is trapped in a meeting.', 'Can trap up to 30 people for a loooong time.', '%1$s manages to flee from the meeting.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
