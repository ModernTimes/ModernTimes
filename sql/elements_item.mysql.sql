-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 02. Aug 2012 um 17:02
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

INSERT INTO `mt_item` (`id`, `name`, `specialClass`, `charactermodifierID`, `requirementID`, `type`, `usable`, `tradable`, `autosellable`, `desc`, `autosellCash`, `autosellFavours`, `autosellKudos`, `useHp`, `useEnergy`, `useEffectID`, `useEffectDuration`, `useMsg`) VALUES
(1, 'Trolley', '', 1, 1, 'offhand', 0, 1, 1, 'Contains most of your household.', 1, 0, 0, 0, 0, NULL, 0, ''),
(2, 'Bog-standard shirt', '', 2, NULL, 'accessory', 0, 1, 1, 'You have five of these, but they are all exactly the same, so for the purpose of this game, they just count as 1.', 1, 0, 0, 0, 0, NULL, 0, ''),
(3, 'Smartphone', '', 3, NULL, 'accessory', 0, 0, 1, 'To make sure that your boss can reach you at 2.30 am.', 1, 0, 0, 0, 0, NULL, 0, ''),
(5, 'Weed', '', NULL, NULL, 'usable', 1, 1, 1, 'God''s gift to the world. Brings peace when used wisely. <span style=''font-size:0.7em''>(urbandictionary.com)</span>', 3, 0, 0, 0, 5, 2, 5, ''),
(6, 'Heroin', '', NULL, NULL, 'usable', 1, 1, 1, '', 0, 0, 0, 0, 0, NULL, 0, ''),
(7, 'Harvey ball', '', NULL, NULL, 'misc', 0, 0, 1, 'These cute little ideograms just have to be in every presentation.', 0, 0, 0, 0, 0, NULL, 0, ''),
(8, 'Gantt chart', '', NULL, NULL, 'misc', 0, 0, 1, 'In honor of Henry Gantt, idol of project scheduling.', 0, 0, 0, 0, 0, NULL, 0, ''),
(9, 'Radar chart', '', NULL, NULL, 'misc', 0, 0, 1, 'One of the most beautiful charts available to mankind.', 0, 0, 0, 0, 0, NULL, 0, ''),
(10, 'BCG matrix', '', NULL, NULL, 'misc', 0, 0, 1, 'Where''s the cash cow? Where''s the cash cow?', 0, 0, 0, 0, 0, NULL, 0, ''),
(12, 'Catchy marketing phrase', '', NULL, NULL, 'misc', 0, 0, 1, '"A pleasant experience at your fingertips below wholesale prices!"', 0, 0, 0, 0, 0, NULL, 0, ''),
(13, 'Wisdom of a sales person', '', NULL, NULL, 'misc', 0, 0, 1, '"Ask yourself: What have I done today to generate business for tomorrow?"', 0, 0, 0, 0, 0, NULL, 0, ''),
(14, 'Management insight', '', NULL, NULL, 'misc', 0, 0, 1, '"Management is efficiency in climbing the ladder of success; leadership determines whether the ladder is leaning against the right wall." - Stephen R. Covey.\r\nNeedless to say that you feel inspired.', 0, 0, 0, 0, 0, NULL, 0, ''),
(15, 'Marketing slide', '', NULL, NULL, 'misc', 0, 0, 1, 'Some buzz words and a chart is all it takes.', 0, 0, 0, 0, 0, NULL, 0, ''),
(16, 'Sales slide', '', NULL, NULL, 'misc', 0, 0, 1, 'A quote and a chart, what more could you possibly want?', 0, 0, 0, 0, 0, NULL, 0, ''),
(17, 'Strategy slide', '', NULL, NULL, 'misc', 0, 0, 1, 'A strategy that fits onto a slide ... but whatever.', 0, 0, 0, 0, 0, NULL, 0, ''),
(18, 'Nearly finished novice deck', '', NULL, NULL, 'misc', 0, 0, 1, 'It has some nice looking slides, but something''s still missing.', 0, 0, 0, 0, 0, NULL, 0, ''),
(19, 'Novice deck', '', NULL, 1, 'weapon', 0, 0, 1, 'A simple yet effective deck of slides that can support spontaneous babbling about pretty much any topic.', 0, 5, 0, 0, 0, NULL, 0, '');

--
-- Daten für Tabelle `mt_recipe`
--

INSERT INTO `mt_recipe` (`id`, `item1ID`, `item2ID`, `itemResultID`, `costCash`, `costFavours`, `costKudos`, `costsTurn`) VALUES
(1, 9, 13, 16, 0, 0, 0, 0),
(2, 7, 12, 15, 0, 0, 0, 0),
(3, 10, 14, 17, 0, 0, 0, 0),
(4, 15, 16, 18, 0, 0, 0, 0),
(5, 15, 17, 18, 0, 0, 0, 0),
(6, 16, 17, 18, 0, 0, 0, 0),
(7, 15, 18, 19, 0, 0, 0, 0),
(8, 16, 18, 19, 0, 0, 0, 0),
(9, 17, 18, 19, 0, 0, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
