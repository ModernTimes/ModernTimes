-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 06. Aug 2012 um 15:23
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
-- Daten für Tabelle `mt_shop`
--

INSERT INTO `mt_shop` (`id`, `name`, `specialClass`, `requirementID`, `desc`) VALUES
(1, 'Pablo jr.', '', NULL, 'Pablo opens his little suitcase. Here''s what he''s got in stock for you today:');

--
-- Daten für Tabelle `mt_shop_items`
--

INSERT INTO `mt_shop_items` (`id`, `shopID`, `itemID`, `requirementID`, `cash`) VALUES
(1, 1, 5, NULL, 10);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
