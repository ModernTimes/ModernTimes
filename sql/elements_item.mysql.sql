-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 20. Jul 2012 um 17:49
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

INSERT INTO `mt_item` (`id`, `name`, `specialClass`, `charactermodifierID`, `type`, `usable`, `tradable`, `desc`, `reqClass`, `reqResoluteness`, `reqWilpower`, `reqCunning`, `autosellCash`, `autosellFavours`, `autosellKudos`, `useHp`, `useEnergy`, `useEffectID`, `useEffectDuration`) VALUES
(1, 'Pink socks', '', 1, 'accessory', 0, 1, '', 'none', 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0),
(2, 'pickaxe', '', NULL, 'weapon', 0, 1, 'desc: pickaxe', 'none', 0, 0, 0, 2, 0, 0, 0, 0, NULL, 0),
(3, 'Prickaxe', '', 2, 'weapon', 0, 1, 'for pricks only', 'none', 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0),
(4, 'black socks', '', NULL, 'accessory', 0, 1, 'Uhhhh, dark!', 'none', 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
