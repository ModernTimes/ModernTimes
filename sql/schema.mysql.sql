-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 28. Jul 2012 um 19:02
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

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_area`
--

CREATE TABLE IF NOT EXISTS `mt_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `specialClass` varchar(50) NOT NULL,
  `requirementID` int(11) DEFAULT NULL,
  `combatProb` decimal(7,6) NOT NULL DEFAULT '0.000000',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `requirementID` (`requirementID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- RELATIONEN DER TABELLE `mt_area`:
--   `requirementID`
--       `mt_requirement` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_area_encounters`
--

CREATE TABLE IF NOT EXISTS `mt_area_encounters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `areaID` int(11) NOT NULL,
  `encounterID` int(11) NOT NULL,
  `requirementID` int(11) DEFAULT NULL,
  `prob` decimal(7,6) NOT NULL DEFAULT '0.000000',
  PRIMARY KEY (`id`),
  KEY `areaID` (`areaID`),
  KEY `encounterID` (`encounterID`),
  KEY `requirementID` (`requirementID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- RELATIONEN DER TABELLE `mt_area_encounters`:
--   `requirementID`
--       `mt_requirement` -> `id`
--   `areaID`
--       `mt_area` -> `id`
--   `encounterID`
--       `mt_encounter` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_area_monsters`
--

CREATE TABLE IF NOT EXISTS `mt_area_monsters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `areaID` int(11) NOT NULL,
  `monsterID` int(11) NOT NULL,
  `requirementID` int(11) DEFAULT NULL,
  `prob` decimal(7,6) NOT NULL DEFAULT '0.000000',
  PRIMARY KEY (`id`),
  KEY `areaID` (`areaID`),
  KEY `monsterID` (`monsterID`),
  KEY `requirementID` (`requirementID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- RELATIONEN DER TABELLE `mt_area_monsters`:
--   `requirementID`
--       `mt_requirement` -> `id`
--   `monsterID`
--       `mt_monster` -> `id`
--   `areaID`
--       `mt_area` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_battle`
--

CREATE TABLE IF NOT EXISTS `mt_battle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('monster','pvp') NOT NULL DEFAULT 'monster',
  `combatantAID` int(11) NOT NULL,
  `combatantBID` int(11) NOT NULL,
  `state` enum('ongoing','resolved') NOT NULL DEFAULT 'ongoing',
  `winnerType` enum('undecided','player','monster','draw') NOT NULL DEFAULT 'undecided',
  `winnerID` int(11) NOT NULL,
  `objectState` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `combatantAID` (`combatantAID`),
  KEY `combatantBID` (`combatantBID`),
  KEY `state` (`state`),
  KEY `winnerID` (`winnerID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_battleeffect`
--

CREATE TABLE IF NOT EXISTS `mt_battleeffect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `specialClass` varchar(50) NOT NULL,
  `buff` tinyint(4) NOT NULL DEFAULT '1',
  `singleton` tinyint(4) NOT NULL DEFAULT '0',
  `increaseDuration` tinyint(4) NOT NULL DEFAULT '1',
  `blocks` smallint(6) NOT NULL DEFAULT '0',
  `blockActionTypes` enum('all') NOT NULL DEFAULT 'all',
  `blockActionNormalSpecial` enum('all','normal','special') NOT NULL DEFAULT 'all',
  `blockChance` decimal(7,6) NOT NULL DEFAULT '0.000000',
  `blockTurns` smallint(6) NOT NULL DEFAULT '0',
  `blockNumberOfBlocks` smallint(6) NOT NULL DEFAULT '0',
  `desc` text NOT NULL,
  `msgExpire` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_character`
--

CREATE TABLE IF NOT EXISTS `mt_character` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(100) NOT NULL,
  `sex` enum('male','female') NOT NULL DEFAULT 'male',
  `class` enum('consultant','banker') NOT NULL DEFAULT 'consultant',
  `ongoingBattleID` int(11) DEFAULT NULL,
  `ongoingEncounterID` int(11) DEFAULT NULL,
  `turns` smallint(6) NOT NULL DEFAULT '0',
  `badConscience` smallint(6) NOT NULL DEFAULT '0',
  `networkStrainedness` smallint(6) NOT NULL DEFAULT '0',
  `resolutenessSub` int(11) NOT NULL DEFAULT '1',
  `willpowerSub` int(11) NOT NULL DEFAULT '1',
  `cunningSub` int(11) NOT NULL DEFAULT '1',
  `hp` int(11) NOT NULL DEFAULT '0',
  `energy` int(11) NOT NULL DEFAULT '0',
  `cash` int(11) NOT NULL DEFAULT '0',
  `favours` int(11) NOT NULL DEFAULT '0',
  `kudos` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- RELATIONEN DER TABELLE `mt_character`:
--   `userID`
--       `mt_user` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_charactermodifier`
--

CREATE TABLE IF NOT EXISTS `mt_charactermodifier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hp` smallint(6) NOT NULL DEFAULT '0',
  `hpPerc` smallint(6) NOT NULL DEFAULT '0',
  `energy` smallint(6) NOT NULL DEFAULT '0',
  `energyPerc` smallint(6) NOT NULL DEFAULT '0',
  `resoluteness` smallint(6) NOT NULL DEFAULT '0',
  `resolutenessPerc` smallint(6) NOT NULL DEFAULT '0',
  `willpower` smallint(6) NOT NULL DEFAULT '0',
  `willpowerPerc` smallint(6) NOT NULL DEFAULT '0',
  `cunning` smallint(6) NOT NULL DEFAULT '0',
  `cunningPerc` smallint(6) NOT NULL DEFAULT '0',
  `dropCash` smallint(6) NOT NULL DEFAULT '0',
  `dropCashPerc` smallint(6) NOT NULL DEFAULT '0',
  `dropFavours` smallint(6) NOT NULL DEFAULT '0',
  `dropFavoursPerc` smallint(6) NOT NULL DEFAULT '0',
  `dropKudos` smallint(6) NOT NULL DEFAULT '0',
  `dropKudosPerc` smallint(6) NOT NULL DEFAULT '0',
  `dropItemPerc` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_character_effects`
--

CREATE TABLE IF NOT EXISTS `mt_character_effects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `characterID` int(11) NOT NULL,
  `effectID` int(11) NOT NULL,
  `turns` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `characterID` (`characterID`),
  KEY `effectID` (`effectID`),
  KEY `turns` (`turns`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- RELATIONEN DER TABELLE `mt_character_effects`:
--   `effectID`
--       `mt_effect` -> `id`
--   `characterID`
--       `mt_character` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_character_encounters`
--

CREATE TABLE IF NOT EXISTS `mt_character_encounters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `characterID` int(11) NOT NULL,
  `encounterID` int(11) NOT NULL,
  `delay` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `characterID` (`characterID`),
  KEY `encounterID` (`encounterID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- RELATIONEN DER TABELLE `mt_character_encounters`:
--   `characterID`
--       `mt_character` -> `id`
--   `encounterID`
--       `mt_encounter` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_character_equipments`
--

CREATE TABLE IF NOT EXISTS `mt_character_equipments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `characterID` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `weapon` int(11) DEFAULT NULL,
  `offhand` int(11) DEFAULT NULL,
  `accessoryA` int(11) DEFAULT NULL,
  `accessoryB` int(11) DEFAULT NULL,
  `accessoryC` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `characterID` (`characterID`),
  KEY `active` (`active`),
  KEY `weapon` (`weapon`),
  KEY `offhand` (`offhand`),
  KEY `accessoryA` (`accessoryA`),
  KEY `accessoryB` (`accessoryB`),
  KEY `accessoryC` (`accessoryC`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- RELATIONEN DER TABELLE `mt_character_equipments`:
--   `accessoryC`
--       `mt_item` -> `id`
--   `characterID`
--       `mt_character` -> `id`
--   `weapon`
--       `mt_item` -> `id`
--   `offhand`
--       `mt_item` -> `id`
--   `accessoryA`
--       `mt_item` -> `id`
--   `accessoryB`
--       `mt_item` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_character_familiars`
--

CREATE TABLE IF NOT EXISTS `mt_character_familiars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `characterID` int(11) NOT NULL,
  `familiarID` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `xp` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `characterID` (`characterID`),
  KEY `familiarID` (`familiarID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- RELATIONEN DER TABELLE `mt_character_familiars`:
--   `characterID`
--       `mt_character` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_character_items`
--

CREATE TABLE IF NOT EXISTS `mt_character_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `characterID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `n` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `characterID` (`characterID`),
  KEY `itemID` (`itemID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- RELATIONEN DER TABELLE `mt_character_items`:
--   `itemID`
--       `mt_item` -> `id`
--   `characterID`
--       `mt_character` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_character_quests`
--

CREATE TABLE IF NOT EXISTS `mt_character_quests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `characterID` int(11) NOT NULL,
  `questID` int(11) NOT NULL,
  `state` enum('unavailable','available','ongoing','completed','rejected','failed') NOT NULL DEFAULT 'unavailable',
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `characterID` (`characterID`),
  KEY `questID` (`questID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- RELATIONEN DER TABELLE `mt_character_quests`:
--   `characterID`
--       `mt_character` -> `id`
--   `questID`
--       `mt_quest` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_character_skills`
--

CREATE TABLE IF NOT EXISTS `mt_character_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `characterID` int(11) NOT NULL,
  `skillID` int(11) NOT NULL,
  `available` tinyint(1) NOT NULL,
  `permed` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `characterID` (`characterID`),
  KEY `skillID` (`skillID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- RELATIONEN DER TABELLE `mt_character_skills`:
--   `skillID`
--       `mt_skill` -> `id`
--   `characterID`
--       `mt_character` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_character_skillsets`
--

CREATE TABLE IF NOT EXISTS `mt_character_skillsets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `characterID` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `pos1` int(11) DEFAULT NULL,
  `pos2` int(11) DEFAULT NULL,
  `pos3` int(11) DEFAULT NULL,
  `pos4` int(11) DEFAULT NULL,
  `pos5` int(11) DEFAULT NULL,
  `pos6` int(11) DEFAULT NULL,
  `pos7` int(11) DEFAULT NULL,
  `pos8` int(11) DEFAULT NULL,
  `pos9` int(11) DEFAULT NULL,
  `pos10` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `characterID` (`characterID`),
  KEY `pos1` (`pos1`),
  KEY `pos2` (`pos2`),
  KEY `pos3` (`pos3`),
  KEY `pos4` (`pos4`),
  KEY `pos5` (`pos5`),
  KEY `pos6` (`pos6`),
  KEY `pos7` (`pos7`),
  KEY `pos8` (`pos8`),
  KEY `pos9` (`pos9`),
  KEY `pos10` (`pos10`),
  KEY `active` (`active`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- RELATIONEN DER TABELLE `mt_character_skillsets`:
--   `pos10`
--       `mt_skill` -> `id`
--   `characterID`
--       `mt_character` -> `id`
--   `pos9`
--       `mt_skill` -> `id`
--   `pos1`
--       `mt_skill` -> `id`
--   `pos2`
--       `mt_skill` -> `id`
--   `pos3`
--       `mt_skill` -> `id`
--   `pos4`
--       `mt_skill` -> `id`
--   `pos5`
--       `mt_skill` -> `id`
--   `pos6`
--       `mt_skill` -> `id`
--   `pos7`
--       `mt_skill` -> `id`
--   `pos8`
--       `mt_skill` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_effect`
--

CREATE TABLE IF NOT EXISTS `mt_effect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `specialClass` varchar(50) NOT NULL,
  `charactermodifierID` int(11) DEFAULT NULL,
  `desc` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `charactermodifierID` (`charactermodifierID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- RELATIONEN DER TABELLE `mt_effect`:
--   `charactermodifierID`
--       `mt_charactermodifier` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_encounter`
--

CREATE TABLE IF NOT EXISTS `mt_encounter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `specialClass` varchar(50) NOT NULL,
  `onetime` tinyint(1) NOT NULL DEFAULT '0',
  `msg` text NOT NULL,
  `costsTurn` tinyint(1) NOT NULL DEFAULT '1',
  `gainCash` smallint(6) NOT NULL DEFAULT '0',
  `gainFavours` smallint(6) NOT NULL DEFAULT '0',
  `gainKudos` smallint(6) NOT NULL DEFAULT '0',
  `gainXp` smallint(6) NOT NULL DEFAULT '0',
  `gainResoluteness` smallint(6) NOT NULL DEFAULT '0',
  `gainWillpower` smallint(6) NOT NULL DEFAULT '0',
  `gainCunning` smallint(6) NOT NULL DEFAULT '0',
  `effectID` int(11) DEFAULT NULL,
  `effectDuration` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `effectID` (`effectID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- RELATIONEN DER TABELLE `mt_encounter`:
--   `effectID`
--       `mt_effect` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_encounter_encounters`
--

CREATE TABLE IF NOT EXISTS `mt_encounter_encounters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `encounterID` int(11) NOT NULL,
  `toEncounterID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `toEncounterID` (`toEncounterID`),
  KEY `encounterID` (`encounterID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- RELATIONEN DER TABELLE `mt_encounter_encounters`:
--   `toEncounterID`
--       `mt_encounter` -> `id`
--   `encounterID`
--       `mt_encounter` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_encounter_items`
--

CREATE TABLE IF NOT EXISTS `mt_encounter_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `encounterID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `prob` decimal(7,6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `encounterID` (`encounterID`),
  KEY `itemID` (`itemID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- RELATIONEN DER TABELLE `mt_encounter_items`:
--   `itemID`
--       `mt_item` -> `id`
--   `encounterID`
--       `mt_encounter` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_item`
--

CREATE TABLE IF NOT EXISTS `mt_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `specialClass` varchar(50) NOT NULL,
  `charactermodifierID` int(11) DEFAULT NULL,
  `requirementID` int(11) DEFAULT NULL,
  `type` enum('usable','combat','weapon','offhand','accessory','quest','misc') NOT NULL DEFAULT 'usable',
  `usable` tinyint(1) NOT NULL DEFAULT '0',
  `tradable` tinyint(1) NOT NULL DEFAULT '1',
  `desc` text NOT NULL,
  `autosellCash` int(11) NOT NULL DEFAULT '0',
  `autosellFavours` int(11) NOT NULL DEFAULT '0',
  `autosellKudos` int(11) NOT NULL DEFAULT '0',
  `useHp` int(11) NOT NULL DEFAULT '0',
  `useEnergy` int(11) NOT NULL DEFAULT '0',
  `useEffectID` int(11) DEFAULT NULL,
  `useEffectDuration` int(11) NOT NULL DEFAULT '0',
  `useMsg` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `charactermodifierID` (`charactermodifierID`),
  KEY `useEffectID` (`useEffectID`),
  KEY `requirementID` (`requirementID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- RELATIONEN DER TABELLE `mt_item`:
--   `requirementID`
--       `mt_requirement` -> `id`
--   `charactermodifierID`
--       `mt_charactermodifier` -> `id`
--   `useEffectID`
--       `mt_effect` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_marker`
--

CREATE TABLE IF NOT EXISTS `mt_marker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `specialClass` varchar(100) NOT NULL,
  `requirementID` int(11) DEFAULT NULL,
  `type` enum('mischief','home','shop','quest') NOT NULL DEFAULT 'mischief',
  `lat` decimal(9,7) NOT NULL,
  `lng` decimal(9,7) NOT NULL,
  `povHeading` decimal(5,2) NOT NULL,
  `povPitch` decimal(4,2) NOT NULL,
  `povZoom` smallint(6) NOT NULL DEFAULT '1',
  `actionID` varchar(25) NOT NULL,
  `actionName` varchar(50) NOT NULL,
  `actionTurn` tinyint(1) NOT NULL DEFAULT '0',
  `actionParams` tinytext NOT NULL,
  `desc` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `requirementID` (`requirementID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- RELATIONEN DER TABELLE `mt_marker`:
--   `requirementID`
--       `mt_requirement` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_monster`
--

CREATE TABLE IF NOT EXISTS `mt_monster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `specialClass` varchar(50) NOT NULL,
  `hpMax` int(11) NOT NULL,
  `attack` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `xp` int(11) DEFAULT NULL,
  `dropCash` int(11) NOT NULL,
  `dropFavours` int(11) NOT NULL,
  `dropKudos` int(11) NOT NULL,
  `msgEncounter` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_monster_items`
--

CREATE TABLE IF NOT EXISTS `mt_monster_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `monsterID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `prob` decimal(7,6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `monsterID` (`monsterID`),
  KEY `itemID` (`itemID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- RELATIONEN DER TABELLE `mt_monster_items`:
--   `monsterID`
--       `mt_monster` -> `id`
--   `itemID`
--       `mt_item` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_monster_skills`
--

CREATE TABLE IF NOT EXISTS `mt_monster_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `monsterID` int(11) NOT NULL,
  `skillID` int(11) NOT NULL,
  `prob` decimal(7,6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `monsterID` (`monsterID`),
  KEY `skillID` (`skillID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- RELATIONEN DER TABELLE `mt_monster_skills`:
--   `skillID`
--       `mt_skill` -> `id`
--   `monsterID`
--       `mt_monster` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_quest`
--

CREATE TABLE IF NOT EXISTS `mt_quest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `specialClass` varchar(50) NOT NULL,
  `desc` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_recipe`
--

CREATE TABLE IF NOT EXISTS `mt_recipe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item1ID` int(11) NOT NULL,
  `item2ID` int(11) NOT NULL,
  `itemResultID` int(11) NOT NULL,
  `costCash` smallint(6) NOT NULL DEFAULT '0',
  `costFavours` smallint(6) NOT NULL DEFAULT '0',
  `costKudos` smallint(6) NOT NULL DEFAULT '0',
  `costsTurn` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `item1ID` (`item1ID`),
  KEY `item2ID` (`item2ID`),
  KEY `itemResultID` (`itemResultID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- RELATIONEN DER TABELLE `mt_recipe`:
--   `itemResultID`
--       `mt_item` -> `id`
--   `item1ID`
--       `mt_item` -> `id`
--   `item2ID`
--       `mt_item` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_requirement`
--

CREATE TABLE IF NOT EXISTS `mt_requirement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `questID` int(11) DEFAULT NULL,
  `questState` enum('unavailable','available','ongoing','completed','failed','rejected','started') NOT NULL DEFAULT 'completed',
  `class` enum('none','resoluteness','willpower','cunning','consultant','banker') NOT NULL DEFAULT 'none',
  `sex` enum('none','male','female') NOT NULL DEFAULT 'none',
  `level` smallint(4) unsigned NOT NULL DEFAULT '0',
  `mainstat` smallint(5) unsigned NOT NULL DEFAULT '0',
  `resoluteness` smallint(5) unsigned NOT NULL DEFAULT '0',
  `willpower` smallint(5) unsigned NOT NULL DEFAULT '0',
  `cunning` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `questID` (`questID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- RELATIONEN DER TABELLE `mt_requirement`:
--   `questID`
--       `mt_quest` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_shop`
--

CREATE TABLE IF NOT EXISTS `mt_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `specialClass` varchar(50) NOT NULL,
  `requirementID` int(11) DEFAULT NULL,
  `desc` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `requirementID` (`requirementID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- RELATIONEN DER TABELLE `mt_shop`:
--   `requirementID`
--       `mt_requirement` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_shop_items`
--

CREATE TABLE IF NOT EXISTS `mt_shop_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `requirementID` int(11) DEFAULT NULL,
  `cash` smallint(6) NOT NULL DEFAULT '0',
  `favours` smallint(6) NOT NULL DEFAULT '0',
  `kudos` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `shopID` (`shopID`),
  KEY `itemID` (`itemID`),
  KEY `requirementID` (`requirementID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- RELATIONEN DER TABELLE `mt_shop_items`:
--   `shopID`
--       `mt_shop` -> `id`
--   `itemID`
--       `mt_item` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_skill`
--

CREATE TABLE IF NOT EXISTS `mt_skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `skillType` enum('combat','non-combat','passive') NOT NULL DEFAULT 'combat',
  `actionType` enum('personal','special','familiar') NOT NULL DEFAULT 'personal',
  `battlePhase` enum('offense','block','defense') NOT NULL DEFAULT 'offense',
  `subType` varchar(20) NOT NULL,
  `specialClass` varchar(50) NOT NULL,
  `charactermodifierID` int(11) DEFAULT NULL,
  `costEnergy` smallint(6) NOT NULL DEFAULT '0',
  `dealsDamage` tinyint(1) NOT NULL DEFAULT '0',
  `damageAttackFactor` decimal(5,3) NOT NULL DEFAULT '0.000',
  `damageFixedAmount` smallint(6) NOT NULL DEFAULT '0',
  `damageType` enum('normal','envy','gluttony','greed','lust','pride','sloth','wrath') NOT NULL DEFAULT 'normal',
  `healing` smallint(6) NOT NULL DEFAULT '0',
  `createEffect` int(11) DEFAULT NULL,
  `effectTurns` int(11) NOT NULL DEFAULT '0',
  `effectMsgIncreasedDuration` tinytext NOT NULL,
  `desc` text NOT NULL,
  `msgResolved` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `charactermodifierID` (`charactermodifierID`),
  KEY `createEffect` (`createEffect`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- RELATIONEN DER TABELLE `mt_skill`:
--   `createEffect`
--       `mt_battleeffect` -> `id`
--   `charactermodifierID`
--       `mt_charactermodifier` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_user`
--

CREATE TABLE IF NOT EXISTS `mt_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `createtime` int(10) NOT NULL DEFAULT '0',
  `lastvisit` int(10) NOT NULL DEFAULT '0',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_user_profile`
--

CREATE TABLE IF NOT EXISTS `mt_user_profile` (
  `user_id` int(11) NOT NULL,
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `birthday` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONEN DER TABELLE `mt_user_profile`:
--   `user_id`
--       `mt_user` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_user_profilefield`
--

CREATE TABLE IF NOT EXISTS `mt_user_profilefield` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_size` int(3) NOT NULL DEFAULT '0',
  `field_size_min` int(3) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` varchar(5000) NOT NULL DEFAULT '',
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` varchar(5000) NOT NULL DEFAULT '',
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`,`widget`,`visible`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=4 ;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `mt_area`
--
ALTER TABLE `mt_area`
  ADD CONSTRAINT `mt_area_ibfk_1` FOREIGN KEY (`requirementID`) REFERENCES `mt_requirement` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_area_encounters`
--
ALTER TABLE `mt_area_encounters`
  ADD CONSTRAINT `mt_area_encounters_ibfk_3` FOREIGN KEY (`requirementID`) REFERENCES `mt_requirement` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_area_encounters_ibfk_1` FOREIGN KEY (`areaID`) REFERENCES `mt_area` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_area_encounters_ibfk_2` FOREIGN KEY (`encounterID`) REFERENCES `mt_encounter` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_area_monsters`
--
ALTER TABLE `mt_area_monsters`
  ADD CONSTRAINT `mt_area_monsters_ibfk_3` FOREIGN KEY (`requirementID`) REFERENCES `mt_requirement` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_area_monsters_ibfk_1` FOREIGN KEY (`monsterID`) REFERENCES `mt_monster` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_area_monsters_ibfk_2` FOREIGN KEY (`areaID`) REFERENCES `mt_area` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_character`
--
ALTER TABLE `mt_character`
  ADD CONSTRAINT `mt_character_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `mt_user` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_character_effects`
--
ALTER TABLE `mt_character_effects`
  ADD CONSTRAINT `mt_character_effects_ibfk_2` FOREIGN KEY (`effectID`) REFERENCES `mt_effect` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_effects_ibfk_1` FOREIGN KEY (`characterID`) REFERENCES `mt_character` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_character_encounters`
--
ALTER TABLE `mt_character_encounters`
  ADD CONSTRAINT `mt_character_encounters_ibfk_2` FOREIGN KEY (`characterID`) REFERENCES `mt_character` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_encounters_ibfk_1` FOREIGN KEY (`encounterID`) REFERENCES `mt_encounter` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_character_equipments`
--
ALTER TABLE `mt_character_equipments`
  ADD CONSTRAINT `mt_character_equipments_ibfk_6` FOREIGN KEY (`accessoryC`) REFERENCES `mt_item` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_equipments_ibfk_1` FOREIGN KEY (`characterID`) REFERENCES `mt_character` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_equipments_ibfk_2` FOREIGN KEY (`weapon`) REFERENCES `mt_item` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_equipments_ibfk_3` FOREIGN KEY (`offhand`) REFERENCES `mt_item` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_equipments_ibfk_4` FOREIGN KEY (`accessoryA`) REFERENCES `mt_item` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_equipments_ibfk_5` FOREIGN KEY (`accessoryB`) REFERENCES `mt_item` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_character_familiars`
--
ALTER TABLE `mt_character_familiars`
  ADD CONSTRAINT `mt_character_familiars_ibfk_1` FOREIGN KEY (`characterID`) REFERENCES `mt_character` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_character_items`
--
ALTER TABLE `mt_character_items`
  ADD CONSTRAINT `mt_character_items_ibfk_2` FOREIGN KEY (`itemID`) REFERENCES `mt_item` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_items_ibfk_1` FOREIGN KEY (`characterID`) REFERENCES `mt_character` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_character_quests`
--
ALTER TABLE `mt_character_quests`
  ADD CONSTRAINT `mt_character_quests_ibfk_1` FOREIGN KEY (`characterID`) REFERENCES `mt_character` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_quests_ibfk_2` FOREIGN KEY (`questID`) REFERENCES `mt_quest` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_character_skills`
--
ALTER TABLE `mt_character_skills`
  ADD CONSTRAINT `mt_character_skills_ibfk_2` FOREIGN KEY (`skillID`) REFERENCES `mt_skill` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_skills_ibfk_1` FOREIGN KEY (`characterID`) REFERENCES `mt_character` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_character_skillsets`
--
ALTER TABLE `mt_character_skillsets`
  ADD CONSTRAINT `mt_character_skillsets_ibfk_11` FOREIGN KEY (`pos10`) REFERENCES `mt_skill` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_skillsets_ibfk_1` FOREIGN KEY (`characterID`) REFERENCES `mt_character` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_skillsets_ibfk_10` FOREIGN KEY (`pos9`) REFERENCES `mt_skill` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_skillsets_ibfk_2` FOREIGN KEY (`pos1`) REFERENCES `mt_skill` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_skillsets_ibfk_3` FOREIGN KEY (`pos2`) REFERENCES `mt_skill` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_skillsets_ibfk_4` FOREIGN KEY (`pos3`) REFERENCES `mt_skill` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_skillsets_ibfk_5` FOREIGN KEY (`pos4`) REFERENCES `mt_skill` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_skillsets_ibfk_6` FOREIGN KEY (`pos5`) REFERENCES `mt_skill` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_skillsets_ibfk_7` FOREIGN KEY (`pos6`) REFERENCES `mt_skill` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_skillsets_ibfk_8` FOREIGN KEY (`pos7`) REFERENCES `mt_skill` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_character_skillsets_ibfk_9` FOREIGN KEY (`pos8`) REFERENCES `mt_skill` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_effect`
--
ALTER TABLE `mt_effect`
  ADD CONSTRAINT `mt_effect_ibfk_1` FOREIGN KEY (`charactermodifierID`) REFERENCES `mt_charactermodifier` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_encounter`
--
ALTER TABLE `mt_encounter`
  ADD CONSTRAINT `mt_encounter_ibfk_1` FOREIGN KEY (`effectID`) REFERENCES `mt_effect` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_encounter_encounters`
--
ALTER TABLE `mt_encounter_encounters`
  ADD CONSTRAINT `mt_encounter_encounters_ibfk_2` FOREIGN KEY (`toEncounterID`) REFERENCES `mt_encounter` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_encounter_encounters_ibfk_1` FOREIGN KEY (`encounterID`) REFERENCES `mt_encounter` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_encounter_items`
--
ALTER TABLE `mt_encounter_items`
  ADD CONSTRAINT `mt_encounter_items_ibfk_2` FOREIGN KEY (`itemID`) REFERENCES `mt_item` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_encounter_items_ibfk_1` FOREIGN KEY (`encounterID`) REFERENCES `mt_encounter` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_item`
--
ALTER TABLE `mt_item`
  ADD CONSTRAINT `mt_item_ibfk_3` FOREIGN KEY (`requirementID`) REFERENCES `mt_requirement` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_item_ibfk_1` FOREIGN KEY (`charactermodifierID`) REFERENCES `mt_charactermodifier` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_item_ibfk_2` FOREIGN KEY (`useEffectID`) REFERENCES `mt_effect` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_marker`
--
ALTER TABLE `mt_marker`
  ADD CONSTRAINT `mt_marker_ibfk_1` FOREIGN KEY (`requirementID`) REFERENCES `mt_requirement` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_monster_items`
--
ALTER TABLE `mt_monster_items`
  ADD CONSTRAINT `mt_monster_items_ibfk_2` FOREIGN KEY (`monsterID`) REFERENCES `mt_monster` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_monster_items_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `mt_item` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_monster_skills`
--
ALTER TABLE `mt_monster_skills`
  ADD CONSTRAINT `mt_monster_skills_ibfk_2` FOREIGN KEY (`skillID`) REFERENCES `mt_skill` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_monster_skills_ibfk_1` FOREIGN KEY (`monsterID`) REFERENCES `mt_monster` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_recipe`
--
ALTER TABLE `mt_recipe`
  ADD CONSTRAINT `mt_recipe_ibfk_3` FOREIGN KEY (`itemResultID`) REFERENCES `mt_item` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_recipe_ibfk_1` FOREIGN KEY (`item1ID`) REFERENCES `mt_item` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_recipe_ibfk_2` FOREIGN KEY (`item2ID`) REFERENCES `mt_item` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_requirement`
--
ALTER TABLE `mt_requirement`
  ADD CONSTRAINT `mt_requirement_ibfk_1` FOREIGN KEY (`questID`) REFERENCES `mt_quest` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_shop`
--
ALTER TABLE `mt_shop`
  ADD CONSTRAINT `mt_shop_ibfk_1` FOREIGN KEY (`requirementID`) REFERENCES `mt_requirement` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_shop_items`
--
ALTER TABLE `mt_shop_items`
  ADD CONSTRAINT `mt_shop_items_ibfk_1` FOREIGN KEY (`shopID`) REFERENCES `mt_shop` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_shop_items_ibfk_2` FOREIGN KEY (`itemID`) REFERENCES `mt_item` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_skill`
--
ALTER TABLE `mt_skill`
  ADD CONSTRAINT `mt_skill_ibfk_2` FOREIGN KEY (`createEffect`) REFERENCES `mt_battleeffect` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_skill_ibfk_1` FOREIGN KEY (`charactermodifierID`) REFERENCES `mt_charactermodifier` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_user_profile`
--
ALTER TABLE `mt_user_profile`
  ADD CONSTRAINT `mt_user_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mt_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
