-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 15. Jul 2012 um 14:21
-- Server Version: 5.5.16
-- PHP-Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;
START TRANSACTION;
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
  `combatProb` decimal(7,6) NOT NULL DEFAULT '0.000000',
  `reqMainstat` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `mt_area`
--

INSERT INTO `mt_area` (`id`, `name`, `specialClass`, `combatProb`, `reqMainstat`) VALUES
(1, 'Insurance company', '', 1.000000, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_area_encounters`
--

CREATE TABLE IF NOT EXISTS `mt_area_encounters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `areaID` int(11) NOT NULL,
  `encounterID` int(11) NOT NULL,
  `prob` decimal(7,6) NOT NULL DEFAULT '0.000000',
  PRIMARY KEY (`id`),
  KEY `areaID` (`areaID`),
  KEY `encounterID` (`encounterID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- RELATIONEN DER TABELLE `mt_area_encounters`:
--   `encounterID`
--       `mt_encounter` -> `id`
--   `areaID`
--       `mt_area` -> `id`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_area_monsters`
--

CREATE TABLE IF NOT EXISTS `mt_area_monsters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `areaID` int(11) NOT NULL,
  `monsterID` int(11) NOT NULL,
  `prob` decimal(7,6) NOT NULL DEFAULT '0.000000',
  PRIMARY KEY (`id`),
  KEY `areaID` (`areaID`),
  KEY `monsterID` (`monsterID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- RELATIONEN DER TABELLE `mt_area_monsters`:
--   `areaID`
--       `mt_area` -> `id`
--   `monsterID`
--       `mt_monster` -> `id`
--

--
-- Daten für Tabelle `mt_area_monsters`
--

INSERT INTO `mt_area_monsters` (`id`, `areaID`, `monsterID`, `prob`) VALUES
(1, 1, 1, 1.000000);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Daten für Tabelle `mt_battle`
--

INSERT INTO `mt_battle` (`id`, `type`, `combatantAID`, `combatantBID`, `state`, `winnerType`, `winnerID`, `objectState`) VALUES

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

--
-- Daten für Tabelle `mt_battleeffect`
--

INSERT INTO `mt_battleeffect` (`id`, `name`, `specialClass`, `buff`, `singleton`, `increaseDuration`, `blocks`, `blockActionTypes`, `blockActionNormalSpecial`, `blockChance`, `blockTurns`, `blockNumberOfBlocks`, `desc`, `msgExpire`) VALUES
(1, 'Babble momentum', 'BabbleComboEffect', 1, 1, 0, 0, 'all', 'all', 0.000000, 0, 0, 'From the mouth of a professional, babbling gets more obnoxious the longer it goes on.', '%1 lost babble momentum.');

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

--
-- Daten für Tabelle `mt_character`
--

INSERT INTO `mt_character` (`id`, `userID`, `active`, `name`, `sex`, `class`, `ongoingBattleID`, `ongoingEncounterID`, `turns`, `badConscience`, `networkStrainedness`, `resolutenessSub`, `willpowerSub`, `cunningSub`, `hp`, `energy`, `cash`, `favours`, `kudos`) VALUES
(1, 1, 1, 'Dummy', 'male', 'consultant', NULL, NULL, 184, 0, 0, 1, 1, 4, 4, 4, 8, 8, 10);

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
  `dopFavours` smallint(6) NOT NULL DEFAULT '0',
  `dropFavoursPerc` smallint(6) NOT NULL DEFAULT '0',
  `dropKudos` smallint(6) NOT NULL DEFAULT '0',
  `dropKudosPerc` smallint(6) NOT NULL DEFAULT '0',
  `dropItemPerc` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `mt_charactermodifier`
--

INSERT INTO `mt_charactermodifier` (`id`, `hp`, `hpPerc`, `energy`, `energyPerc`, `resoluteness`, `resolutenessPerc`, `willpower`, `willpowerPerc`, `cunning`, `cunningPerc`, `dropCash`, `dropCashPerc`, `dopFavours`, `dropFavoursPerc`, `dropKudos`, `dropKudosPerc`, `dropItemPerc`) VALUES
(1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- RELATIONEN DER TABELLE `mt_character_effects`:
--   `effectID`
--       `mt_effect` -> `id`
--   `characterID`
--       `mt_character` -> `id`
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
--   `characterID`
--       `mt_character` -> `id`
--

--
-- Daten für Tabelle `mt_character_equipments`
--

INSERT INTO `mt_character_equipments` (`id`, `characterID`, `active`, `weapon`, `offhand`, `accessoryA`, `accessoryB`, `accessoryC`) VALUES
(1, 1, 0, NULL, NULL, NULL, NULL, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- RELATIONEN DER TABELLE `mt_character_items`:
--   `itemID`
--       `mt_item` -> `id`
--   `characterID`
--       `mt_character` -> `id`
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

--
-- Daten für Tabelle `mt_character_skills`
--

INSERT INTO `mt_character_skills` (`id`, `characterID`, `skillID`, `available`, `permed`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 2, 1, 1);

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

--
-- Daten für Tabelle `mt_character_skillsets`
--

INSERT INTO `mt_character_skillsets` (`id`, `characterID`, `active`, `pos1`, `pos2`, `pos3`, `pos4`, `pos5`, `pos6`, `pos7`, `pos8`, `pos9`, `pos10`) VALUES
(1, 1, 1, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `costsAction` tinyint(1) NOT NULL DEFAULT '1',
  `gainCash` smallint(6) NOT NULL DEFAULT '0',
  `gainFavours` smallint(6) NOT NULL DEFAULT '0',
  `gainKudos` smallint(6) NOT NULL DEFAULT '0',
  `gainXp` smallint(6) NOT NULL DEFAULT '0',
  `gainResoluteness` smallint(6) NOT NULL DEFAULT '0',
  `gainWilpower` smallint(6) NOT NULL DEFAULT '0',
  `gainCunning` smallint(6) NOT NULL DEFAULT '0',
  `effectID` int(11) DEFAULT NULL,
  `effectDuration` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mt_encounter_encounters`
--

CREATE TABLE IF NOT EXISTS `mt_encounter_encounters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fromEncounterID` int(11) NOT NULL,
  `toEncounterID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fromEncounterID` (`fromEncounterID`),
  KEY `toEncounterID` (`toEncounterID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- RELATIONEN DER TABELLE `mt_encounter_encounters`:
--   `toEncounterID`
--       `mt_area_encounters` -> `id`
--   `fromEncounterID`
--       `mt_area_encounters` -> `id`
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
  `type` enum('weapon','offhand','accessory') NOT NULL DEFAULT 'weapon',
  `usable` tinyint(1) NOT NULL DEFAULT '0',
  `tradable` tinyint(1) NOT NULL DEFAULT '1',
  `desc` text NOT NULL,
  `reqClass` enum('none','consultant','banker') NOT NULL DEFAULT 'none',
  `reqResoluteness` int(11) NOT NULL DEFAULT '0',
  `reqWilpower` int(11) NOT NULL DEFAULT '0',
  `reqCunning` int(11) NOT NULL DEFAULT '0',
  `autosellCash` int(11) NOT NULL DEFAULT '0',
  `autosellFavours` int(11) NOT NULL DEFAULT '0',
  `autosellKudos` int(11) NOT NULL DEFAULT '0',
  `useHp` int(11) NOT NULL DEFAULT '0',
  `useEnergy` int(11) NOT NULL DEFAULT '0',
  `useEffectID` int(11) DEFAULT NULL,
  `useEffectDuration` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `charactermodifierID` (`charactermodifierID`),
  KEY `useEffectID` (`useEffectID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- RELATIONEN DER TABELLE `mt_item`:
--   `charactermodifierID`
--       `mt_charactermodifier` -> `id`
--

--
-- Daten für Tabelle `mt_item`
--

INSERT INTO `mt_item` (`id`, `name`, `specialClass`, `charactermodifierID`, `type`, `usable`, `tradable`, `desc`, `reqClass`, `reqResoluteness`, `reqWilpower`, `reqCunning`, `autosellCash`, `autosellFavours`, `autosellKudos`, `useHp`, `useEnergy`, `useEffectID`, `useEffectDuration`) VALUES
(1, 'Pink socks', '', NULL, 'accessory', 0, 1, '', 'none', 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0);

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
  `xp` int(11) NOT NULL,
  `dropCash` int(11) NOT NULL,
  `dropFavours` int(11) NOT NULL,
  `dropKudos` int(11) NOT NULL,
  `msgEncounter` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `mt_monster`
--

INSERT INTO `mt_monster` (`id`, `name`, `specialClass`, `hpMax`, `attack`, `defense`, `xp`, `dropCash`, `dropFavours`, `dropKudos`, `msgEncounter`) VALUES
(1, 'Middle management marketing guy', '', 7, 1, 1, 1, 0, 0, 2, 'The five forces are strong with him.');

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

--
-- Daten für Tabelle `mt_monster_skills`
--

INSERT INTO `mt_monster_skills` (`id`, `monsterID`, `skillID`, `prob`) VALUES
(1, 1, 1, 0.500000),
(2, 1, 3, 0.500000);

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
--   `charactermodifierID`
--       `mt_charactermodifier` -> `id`
--

--
-- Daten für Tabelle `mt_skill`
--

INSERT INTO `mt_skill` (`id`, `name`, `skillType`, `actionType`, `battlePhase`, `subType`, `specialClass`, `charactermodifierID`, `costEnergy`, `dealsDamage`, `damageAttackFactor`, `damageFixedAmount`, `damageType`, `healing`, `createEffect`, `effectTurns`, `effectMsgIncreasedDuration`, `desc`, `msgResolved`) VALUES
(1, 'Procrastinate', 'combat', 'personal', 'offense', '', 'ProcrastinateSkill', NULL, 0, 0, 0.000, 0, 'normal', 0, NULL, 0, '', 'Do nothing. Not yet.', '%1$s does nothing. Not yet.'),
(2, 'Babble', 'combat', 'personal', 'offense', 'babbling', 'BabbleConsultantSpeakSkill', NULL, 0, 1, 0.000, 3, 'normal', 0, 1, 0, '', 'Trust me, it hurts.', ''),
(3, 'Throw pencils', 'combat', 'personal', 'offense', '', '', NULL, 0, 2, 0.000, 0, 'normal', 0, NULL, 0, '', 'The sharpened ones, obviously!', '%1$s throws a bunch of sharpened pencils around.');

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

--
-- Daten für Tabelle `mt_user`
--

INSERT INTO `mt_user` (`id`, `username`, `password`, `email`, `activkey`, `createtime`, `lastvisit`, `superuser`, `status`) VALUES
(1, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 'webmaster@example.com', '9a24eff8c15a6a141ece27eb6947da0f', 1261146094, 1342348568, 1, 1),
(2, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'demo@example.com', '099f825543f7850cc038b90aaff39fac', 1261146096, 0, 0, 1);

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

--
-- Daten für Tabelle `mt_user_profile`
--

INSERT INTO `mt_user_profile` (`user_id`, `lastname`, `firstname`, `birthday`) VALUES
(1, 'Admin', 'Administrator', '0000-00-00'),
(2, 'Demo', 'Demo', '0000-00-00');

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
-- Daten für Tabelle `mt_user_profilefield`
--

INSERT INTO `mt_user_profilefield` (`id`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`) VALUES
(1, 'lastname', 'Last Name', 'VARCHAR', 50, 3, 1, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 1, 3),
(2, 'firstname', 'First Name', 'VARCHAR', 50, 3, 1, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 0, 3),
(3, 'birthday', 'Birthday', 'DATE', 0, 0, 2, '', '', '', '', '0000-00-00', 'UWjuidate', '{"ui-theme":"redmond"}', 3, 2);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `mt_area_encounters`
--
ALTER TABLE `mt_area_encounters`
  ADD CONSTRAINT `mt_area_encounters_ibfk_2` FOREIGN KEY (`encounterID`) REFERENCES `mt_encounter` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_area_encounters_ibfk_1` FOREIGN KEY (`areaID`) REFERENCES `mt_area` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_area_monsters`
--
ALTER TABLE `mt_area_monsters`
  ADD CONSTRAINT `mt_area_monsters_ibfk_2` FOREIGN KEY (`areaID`) REFERENCES `mt_area` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_area_monsters_ibfk_1` FOREIGN KEY (`monsterID`) REFERENCES `mt_monster` (`id`) ON UPDATE CASCADE;

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
-- Constraints der Tabelle `mt_character_equipments`
--
ALTER TABLE `mt_character_equipments`
  ADD CONSTRAINT `mt_character_equipments_ibfk_1` FOREIGN KEY (`characterID`) REFERENCES `mt_character` (`id`) ON UPDATE CASCADE;

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
-- Constraints der Tabelle `mt_encounter_encounters`
--
ALTER TABLE `mt_encounter_encounters`
  ADD CONSTRAINT `mt_encounter_encounters_ibfk_2` FOREIGN KEY (`toEncounterID`) REFERENCES `mt_area_encounters` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mt_encounter_encounters_ibfk_1` FOREIGN KEY (`fromEncounterID`) REFERENCES `mt_area_encounters` (`id`) ON UPDATE CASCADE;

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
  ADD CONSTRAINT `mt_item_ibfk_1` FOREIGN KEY (`charactermodifierID`) REFERENCES `mt_charactermodifier` (`id`) ON UPDATE CASCADE;

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
-- Constraints der Tabelle `mt_skill`
--
ALTER TABLE `mt_skill`
  ADD CONSTRAINT `mt_skill_ibfk_1` FOREIGN KEY (`charactermodifierID`) REFERENCES `mt_charactermodifier` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `mt_user_profile`
--
ALTER TABLE `mt_user_profile`
  ADD CONSTRAINT `mt_user_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mt_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
