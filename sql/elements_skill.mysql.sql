-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 20. Jul 2012 um 17:51
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
-- Daten für Tabelle `mt_skill`
--

INSERT INTO `mt_skill` (`id`, `name`, `skillType`, `actionType`, `battlePhase`, `subType`, `specialClass`, `charactermodifierID`, `costEnergy`, `dealsDamage`, `damageAttackFactor`, `damageFixedAmount`, `damageType`, `healing`, `createEffect`, `effectTurns`, `effectMsgIncreasedDuration`, `desc`, `msgResolved`) VALUES
(1, 'Procrastinate', 'combat', 'personal', 'offense', '', 'ProcrastinateSkill', NULL, 0, 0, 0.000, 0, 'normal', 0, NULL, 0, '', 'Do nothing. Not yet.', '%1$s does nothing. Not yet.'),
(2, 'Babble', 'combat', 'personal', 'offense', 'babbling', 'BabbleConsultantSpeakSkill', NULL, 0, 1, 0.000, 3, 'normal', 0, 1, 0, '', 'Trust me, it hurts.', ''),
(3, 'Throw pencils', 'combat', 'personal', 'offense', '', '', NULL, 0, 2, 0.000, 0, 'normal', 0, NULL, 0, '', 'The sharpened ones, obviously!', '%1$s throws a bunch of sharpened pencils around.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
