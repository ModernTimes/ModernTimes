-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 26. Jul 2012 um 18:19
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
-- Daten für Tabelle `mt_marker`
--

INSERT INTO `mt_marker` (`id`, `name`, `specialClass`, `requirementID`, `type`, `lat`, `lng`, `povHeading`, `povPitch`, `povZoom`, `actionID`, `actionName`, `actionTurn`, `actionParams`, `desc`) VALUES
(1, 'Undisclosed insurance company', '', NULL, 'mischief', 51.5136220, -0.0814830, 227.00, 28.00, 1, 'mischief', 'Do mischief here', 1, 'a:1:{s:6:"areaID";i:1;}', 'The usual MBBCG client: over 100,000 employees, 1.5 trillion dollars of assets and a 250-year-old history. Time to tell those losers how to do their job.'),
(2, 'Home, sweet home', '', NULL, 'home', 51.4888390, -0.1774390, 50.40, 0.57, 1, 'rest', 'Rest', 1, '', 'Your apartment. Well, either here or next door. You spend too many nights in hotel rooms to be sure. Besides, these houses all look the same!'),
(3, 'Pablo jr.', '', NULL, 'shop', 51.5016550, -0.1319290, -134.68, -6.76, 3, 'shop', 'Talk to him', 0, 'a:1:{s:6:"shopID";i:1;}', 'You see Pablo jr. sitting on his usual bench at St James''s park. You wonder what he might have in his little suitcase today.'),
(4, 'McBooz&Bain Consulting Group', '', NULL, 'quest', 51.5189120, -0.1560520, -140.00, 15.50, 1, 'visit', 'Go in', 0, '', 'Making up numbers since 1967.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
