-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 20. Jul 2012 um 17:46
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

INSERT INTO `mt_battleeffect` (`id`, `name`, `specialClass`, `buff`, `singleton`, `increaseDuration`, `blocks`, `blockActionTypes`, `blockActionNormalSpecial`, `blockChance`, `blockTurns`, `blockNumberOfBlocks`, `desc`, `msgExpire`) VALUES
(1, 'Babble momentum', 'BabbleComboEffect', 1, 1, 0, 0, 'all', 'all', 0.000000, 0, 0, 'Babbling gets more obnoxious the longer it goes on.', '%1 lost babble momentum.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
