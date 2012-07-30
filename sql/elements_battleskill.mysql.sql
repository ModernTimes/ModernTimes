-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 30. Jul 2012 um 18:55
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
-- Daten für Tabelle `mt_battleskill`
--

INSERT INTO `mt_battleskill` (`id`, `name`, `actionType`, `battlePhase`, `subType`, `specialClass`, `costEnergy`, `dealsDamage`, `damageAttackFactor`, `damageFixedAmount`, `damageType`, `healing`, `createBattleeffectID`, `battleeffectTurns`, `effectMsgIncreasedDuration`, `desc`, `msgResolved`) VALUES
(1, 'Procrastinate', 'personal', 'offense', '', 'ProcrastinateSkill', 0, 0, 0.000, 0, 'normal', 0, NULL, 0, '', 'Do nothing. Not yet.', '%1$s does nothing. Not yet.'),
(2, 'Babble', 'personal', 'offense', 'babbling', 'BabbleConsultantSpeakSkill', 0, 1, 0.750, 0, 'normal', 0, 1, 0, '', 'Trust me, it hurts.', ''),
(3, 'Throw pencils', 'personal', 'offense', '', '', 0, 1, 1.000, 0, 'normal', 0, NULL, 0, '', 'The sharpened ones, obviously!', '%1$s throws a bunch of sharpened pencils around.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
