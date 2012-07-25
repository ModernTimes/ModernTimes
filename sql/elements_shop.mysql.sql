-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 25. Jul 2012 um 18:47
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

INSERT INTO `mt_shop` (`id`, `name`, `specialClass`, `desc`) VALUES
(1, 'Pablo jr.', '', 'Pablo opens his little suitcase. Here''s what he''s got in stock for you today:');

--
-- Daten für Tabelle `mt_shop_items`
--

INSERT INTO `mt_shop_items` (`id`, `shopID`, `itemID`, `cash`, `favours`, `kudos`) VALUES
(1, 1, 5, 10, 0, 1),
(2, 1, 6, 25, 0, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
