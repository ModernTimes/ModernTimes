-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 25. Jul 2012 um 18:46
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
-- Daten für Tabelle `mt_item`
--

INSERT INTO `mt_item` (`id`, `name`, `specialClass`, `charactermodifierID`, `type`, `usable`, `tradable`, `desc`, `reqClass`, `reqResoluteness`, `reqWilpower`, `reqCunning`, `autosellCash`, `autosellFavours`, `autosellKudos`, `useHp`, `useEnergy`, `useEffectID`, `useEffectDuration`, `useMsg`) VALUES
(1, 'Trolley', '', 1, 'offhand', 0, 1, 'Contains most of your household.', 'consultant', 0, 0, 0, 1, 0, 0, 0, 0, NULL, 0, ''),
(2, 'Bog-standard suit', '', 2, 'accessory', 0, 1, 'You have five of these, but they are all exactly the same, so for the purpose of this game, they just count as 1.', 'consultant', 0, 0, 0, 1, 0, 0, 0, 0, NULL, 0, ''),
(3, 'Smartphone', '', 3, 'accessory', 0, 0, 'To make sure that your boss can reach you at 2.30 am.', 'none', 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, ''),
(5, 'Weed', '', NULL, 'usable', 1, 1, '', 'none', 0, 0, 0, 3, 0, 0, 0, 5, 2, 5, ''),
(6, 'Heroin', '', NULL, 'usable', 1, 1, '', 'none', 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
