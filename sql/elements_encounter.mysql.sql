-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 06. Aug 2012 um 15:22
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
-- Daten für Tabelle `mt_encounter`
--

INSERT INTO `mt_encounter` (`id`, `name`, `specialClass`, `onetime`, `msg`, `costsTurn`, `gainCash`, `gainXp`, `gainResoluteness`, `gainWillpower`, `gainCunning`, `effectID`, `effectDuration`, `questID`, `questSetState`) VALUES
(1, 'Beelzebub says hello', '', 1, 'Bla bla bla. Come visit me sometime!', 0, 0, 0, 0, 0, 0, NULL, 0, 2, 'completed'),
(2, 'Mommon says hello', '', 1, 'Bla bla bla. Come visit me sometime!', 0, 0, 0, 0, 0, 0, NULL, 0, 3, 'completed'),
(3, 'Lucifer calls', '', 1, 'Bla bla bla. Come visit me sometime!', 0, 0, 0, 0, 0, 0, NULL, 0, 4, 'completed'),
(4, 'Asmodeus calls', '', 1, 'Bla bla bla. Come visit me sometime!', 0, 0, 0, 0, 0, 0, NULL, 0, 5, 'completed'),
(5, 'Leviathan calls', '', 1, 'Bla bla bla. Come visit me sometime!', 0, 0, 0, 0, 0, 0, NULL, 0, 6, 'completed'),
(6, 'Saten calls', '', 1, 'Bla bla bla. Come visit me sometime!', 0, 0, 0, 0, 0, 0, NULL, 0, 7, 'completed'),
(7, 'Belphegor calls', '', 1, 'Bla bla bla. Come visit me sometime!', 0, 0, 0, 0, 0, 0, NULL, 0, 8, 'completed');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
