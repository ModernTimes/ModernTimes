-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 20. Jul 2012 um 17:43
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
-- Daten für Tabelle `mt_character`
--

INSERT INTO `mt_character` (`id`, `userID`, `active`, `name`, `sex`, `class`, `ongoingBattleID`, `ongoingEncounterID`, `turns`, `badConscience`, `networkStrainedness`, `resolutenessSub`, `willpowerSub`, `cunningSub`, `hp`, `energy`, `cash`, `favours`, `kudos`) VALUES
(1, 1, 1, 'Dummy', 'male', 'consultant', NULL, NULL, 173, 0, 0, 53, 53, 103, 4, 4, 12, 8, 32);

--
-- Daten für Tabelle `mt_character_equipments`
--

INSERT INTO `mt_character_equipments` (`id`, `characterID`, `active`, `weapon`, `offhand`, `accessoryA`, `accessoryB`, `accessoryC`) VALUES
(1, 1, 1, 3, NULL, 4, 1, 1);

--
-- Daten für Tabelle `mt_character_items`
--

INSERT INTO `mt_character_items` (`id`, `characterID`, `itemID`, `n`) VALUES
(7, 1, 3, 1),
(9, 1, 4, 3),
(11, 1, 2, 1);

--
-- Daten für Tabelle `mt_character_skills`
--

INSERT INTO `mt_character_skills` (`id`, `characterID`, `skillID`, `available`, `permed`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 2, 1, 1);

--
-- Daten für Tabelle `mt_character_skillsets`
--

INSERT INTO `mt_character_skillsets` (`id`, `characterID`, `active`, `pos1`, `pos2`, `pos3`, `pos4`, `pos5`, `pos6`, `pos7`, `pos8`, `pos9`, `pos10`) VALUES
(1, 1, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Daten für Tabelle `mt_user`
--

INSERT INTO `mt_user` (`id`, `username`, `password`, `email`, `activkey`, `createtime`, `lastvisit`, `superuser`, `status`) VALUES
(1, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 'webmaster@example.com', '9a24eff8c15a6a141ece27eb6947da0f', 1261146094, 1342793781, 1, 1),
(2, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'demo@example.com', '099f825543f7850cc038b90aaff39fac', 1261146096, 0, 0, 1);

--
-- Daten für Tabelle `mt_user_profile`
--

INSERT INTO `mt_user_profile` (`user_id`, `lastname`, `firstname`, `birthday`) VALUES
(1, 'Admin', 'Administrator', '0000-00-00'),
(2, 'Demo', 'Demo', '0000-00-00');

--
-- Daten für Tabelle `mt_user_profilefield`
--

INSERT INTO `mt_user_profilefield` (`id`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`) VALUES
(1, 'lastname', 'Last Name', 'VARCHAR', 50, 3, 1, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 1, 3),
(2, 'firstname', 'First Name', 'VARCHAR', 50, 3, 1, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 0, 3),
(3, 'birthday', 'Birthday', 'DATE', 0, 0, 2, '', '', '', '', '0000-00-00', 'UWjuidate', '{"ui-theme":"redmond"}', 3, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
