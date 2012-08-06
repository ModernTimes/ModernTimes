-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 06. Aug 2012 um 13:26
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

INSERT INTO `mt_battleskill` (`id`, `name`, `actionType`, `battlePhase`, `subType`, `specialClass`, `costEnergy`, `successRate`, `dealsDamage`, `damageAttackFactorStat`, `damageAttackFactor`, `damageAttackFactorCap`, `damageBonusCap`, `damageFixedAmount`, `damageFixedAmountVariation`, `damageType`, `healing`, `createBattleeffectID`, `battleeffectTurns`, `effectMsgIncreasedDuration`, `desc`, `msgResolved`) VALUES
(1, 'Procrastinate', 'personal', 'defense', '', 'ProcrastinateSkill', 0, 1.000, 0, '', 0.000, NULL, NULL, 0, 0, 'normal', 0, NULL, 0, '', 'Do nothing. Not yet.', '%1$s does nothing. Not yet.'),
(2, 'Babble', 'personal', 'offense', 'babbling', 'BabbleConsultantSpeakSkill', 0, 1.000, 1, 'resoluteness', 0.000, NULL, NULL, 3, 0, 'normal', 0, 1, 0, '', 'Trust me, it hurts.<BR />Creates Babble momentum, which hurts even more.', ''),
(3, 'Throw pencils', 'personal', 'offense', '', '', 0, 1.000, 1, 'resoluteness', 0.000, NULL, NULL, 0, 0, 'normal', 0, NULL, 0, '', 'The sharpened ones, obviously!', '%1$s throws a bunch of sharpened pencils around.'),
(5, 'Refer to McBooz&BainCG', 'personal', 'block', 'babbling', '', 2, 0.500, 0, NULL, 0.000, NULL, NULL, NULL, 0, NULL, 0, 2, 3, '', 'The name of your employer awes your opponent. They''ll think twice before they attack you.', '%1$s casually refers to his employer, McBooz&Bain Consulting Group.'),
(6, 'Create needs', 'personal', 'offense', '', '', 0, 1.000, 1, NULL, 0.000, NULL, NULL, 1, 0, 'greed', 0, NULL, NULL, '', 'You don''t need it. But you want it. And so you DO need it, in a way.', '%1$s finds a leaflet with details about a new household insurance. It''s 20 percent cheaper if you also get a new car insurance. If you buy both, you also get a gilded key chain on top!'),
(7, 'Flirty smile', 'personal', 'offense', '', '', 0, 1.000, 1, NULL, 0.000, NULL, NULL, 1, 0, 'lust', 0, NULL, NULL, '', '', '%1$s smiles prettily.'),
(8, 'Bitchy smile', 'personal', 'offense', '', '', 0, 1.000, 1, NULL, 0.000, NULL, NULL, 1, 0, 'envy', 0, NULL, NULL, '', '', '%1$s smiles bitchily to show off her pretty features.'),
(9, 'Offer a copy of the Watchtower', 'personal', 'offense', '', '', 0, 1.000, 1, NULL, NULL, NULL, NULL, 0, 0, NULL, 0, NULL, NULL, '', 'The Watchtower is "the most widely read magazine in the world", with an average print run of over 42,000,000 copies per month.<BR /><span style=''font-size:0.8em''>(Meares, Joel, 2010, "The Most Widely Read Magazine in the World", The New York Review of Magazines (Columbia University Graduate School of Journalism))</span>', 'RESISTANCE IS FUTILE');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
