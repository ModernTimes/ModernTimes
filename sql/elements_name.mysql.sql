-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 07. Aug 2012 um 19:29
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
-- Daten für Tabelle `mt_name`
--

INSERT INTO `mt_name` (`id`, `type`, `name`) VALUES
(53, 'boy', 'Scott'),
(54, 'boy', 'Jack'),
(55, 'boy', 'James'),
(56, 'boy', 'Thomas'),
(57, 'boy', 'Daniel'),
(58, 'boy', 'Joshua'),
(59, 'boy', 'Matthew'),
(60, 'boy', 'Samuel'),
(61, 'boy', 'Joseph'),
(62, 'boy', 'Ryan'),
(63, 'boy', 'Jordan'),
(64, 'boy', 'Luke'),
(65, 'boy', 'Harry'),
(66, 'boy', 'Benjamin'),
(67, 'boy', 'Connor'),
(68, 'boy', 'George'),
(69, 'boy', 'Alexander'),
(70, 'boy', 'William'),
(71, 'boy', 'Callum'),
(72, 'boy', 'Liam'),
(73, 'boy', 'Adam'),
(74, 'boy', 'Jake'),
(75, 'boy', 'Lewis'),
(76, 'boy', 'Oliver'),
(77, 'boy', 'Michael'),
(78, 'boy', 'Christopher'),
(79, 'boy', 'Nathan'),
(80, 'boy', 'Bradley'),
(81, 'boy', 'Kieran'),
(82, 'boy', 'Ben'),
(83, 'boy', 'Jacob'),
(84, 'boy', 'Mohammed'),
(85, 'boy', 'Jamie'),
(86, 'boy', 'Aaron'),
(87, 'boy', 'Robert'),
(88, 'boy', 'Charlie'),
(89, 'boy', 'Cameron'),
(90, 'boy', 'Brandon'),
(91, 'boy', 'Andrew'),
(92, 'boy', 'Kyle'),
(93, 'boy', 'David'),
(94, 'boy', 'Reece'),
(95, 'boy', 'Charles'),
(96, 'boy', 'Edward'),
(97, 'boy', 'Alex'),
(98, 'boy', 'Jonathan'),
(99, 'boy', 'Ashley'),
(100, 'boy', 'Sam'),
(101, 'boy', 'Joe'),
(102, 'boy', 'John'),
(103, 'boy', 'Dominic'),
(104, 'girl', 'Chloe'),
(105, 'girl', 'Emily'),
(106, 'girl', 'Sophie'),
(107, 'girl', 'Jessica'),
(108, 'girl', 'Megan'),
(109, 'girl', 'Hannah'),
(110, 'girl', 'Charlotte'),
(111, 'girl', 'Lauren'),
(112, 'girl', 'Rebecca'),
(113, 'girl', 'Georgia'),
(114, 'girl', 'Amy'),
(115, 'girl', 'Lucy'),
(116, 'girl', 'Emma'),
(117, 'girl', 'Bethany'),
(118, 'girl', 'Katie'),
(119, 'girl', 'Shannon'),
(120, 'girl', 'Laura'),
(121, 'girl', 'Courtney'),
(122, 'girl', 'Olivia'),
(123, 'girl', 'Eleanor'),
(124, 'girl', 'Molly'),
(125, 'girl', 'Sarah'),
(126, 'girl', 'Holly'),
(127, 'girl', 'Abigail'),
(128, 'girl', 'Jade'),
(129, 'girl', 'Alice'),
(130, 'girl', 'Ellie'),
(131, 'girl', 'Rachel'),
(132, 'girl', 'Danielle'),
(133, 'girl', 'Elizabeth'),
(134, 'girl', 'Zoe'),
(135, 'girl', 'Paige'),
(136, 'girl', 'Georgina'),
(137, 'girl', 'Victoria'),
(138, 'girl', 'Chelsea'),
(139, 'girl', 'Leah'),
(140, 'girl', 'Nicole'),
(141, 'girl', 'Samantha'),
(142, 'girl', 'Natasha'),
(143, 'girl', 'Amber'),
(144, 'girl', 'Anna'),
(145, 'girl', 'Grace'),
(146, 'girl', 'Alexandra'),
(147, 'girl', 'Ella'),
(148, 'girl', 'Louise'),
(149, 'girl', 'Caitlin'),
(150, 'girl', 'Melissa'),
(151, 'girl', 'Jasmine'),
(152, 'girl', 'Amelia'),
(153, 'girl', 'Kayleigh'),
(254, 'surname', 'Smith'),
(255, 'surname', 'Brown'),
(256, 'surname', 'Taylor'),
(257, 'surname', 'Johnson'),
(258, 'surname', 'Walker'),
(259, 'surname', 'Wright'),
(260, 'surname', 'Robinson'),
(261, 'surname', 'Thompson'),
(262, 'surname', 'White'),
(263, 'surname', 'Green'),
(264, 'surname', 'Hall'),
(265, 'surname', 'Wood'),
(266, 'surname', 'Harris'),
(267, 'surname', 'Martin'),
(268, 'surname', 'Jackson'),
(269, 'surname', 'Clarke'),
(270, 'surname', 'Clark'),
(271, 'surname', 'Turner'),
(272, 'surname', 'Hill'),
(273, 'surname', 'Cooper'),
(274, 'surname', 'Ward'),
(275, 'surname', 'Moore'),
(276, 'surname', 'King'),
(277, 'surname', 'Watson'),
(278, 'surname', 'Baker'),
(279, 'surname', 'Harrison'),
(280, 'surname', 'Young'),
(281, 'surname', 'Allen'),
(282, 'surname', 'Mitchell'),
(283, 'surname', 'Anderson'),
(284, 'surname', 'Lee'),
(285, 'surname', 'Bell'),
(286, 'surname', 'Parker'),
(287, 'surname', 'Davis'),
(288, 'surname', 'Bennett'),
(289, 'surname', 'Miller'),
(290, 'surname', 'Cook'),
(291, 'surname', 'Shaw'),
(292, 'surname', 'Richardson'),
(293, 'surname', 'Carter'),
(294, 'surname', 'Collins'),
(295, 'surname', 'Marshall'),
(296, 'surname', 'Bailey'),
(297, 'surname', 'Gray'),
(298, 'surname', 'Cox'),
(299, 'surname', 'Adams'),
(300, 'surname', 'Wilkinson'),
(301, 'surname', 'Foster'),
(302, 'surname', 'Chapman'),
(303, 'surname', 'Mason'),
(304, 'surname', 'Russell'),
(305, 'surname', 'Webb'),
(306, 'surname', 'Rogers'),
(307, 'surname', 'Hunt'),
(308, 'surname', 'Mills'),
(309, 'surname', 'Holmes'),
(310, 'surname', 'Palmer'),
(311, 'surname', 'Matthews'),
(312, 'surname', 'Fisher'),
(313, 'surname', 'Barnes'),
(314, 'surname', 'Knight'),
(315, 'surname', 'Harvey'),
(316, 'surname', 'Barker'),
(317, 'surname', 'Butler'),
(318, 'surname', 'Jenkins'),
(319, 'surname', 'Stevens'),
(320, 'surname', 'Pearson'),
(321, 'surname', 'Dixon'),
(322, 'surname', 'Fletcher'),
(323, 'surname', 'Hunter'),
(324, 'surname', 'Howard'),
(325, 'surname', 'Andrews'),
(326, 'surname', 'Reynolds'),
(327, 'surname', 'Elliott'),
(328, 'surname', 'Fox'),
(329, 'surname', 'Ford'),
(330, 'surname', 'Saunders'),
(331, 'surname', 'Payne'),
(332, 'surname', 'West'),
(333, 'surname', 'Day'),
(334, 'surname', 'Pearce'),
(335, 'surname', 'Brooks'),
(336, 'surname', 'Dawson'),
(337, 'surname', 'Walsh'),
(338, 'surname', 'Lawrence'),
(339, 'surname', 'Cole'),
(340, 'surname', 'Atkinson'),
(341, 'surname', 'Ball'),
(342, 'surname', 'Spencer'),
(343, 'surname', 'Armstrong'),
(344, 'surname', 'Burton'),
(345, 'surname', 'Booth'),
(346, 'surname', 'Rose'),
(347, 'surname', 'Webster'),
(348, 'surname', 'Williamson'),
(349, 'surname', 'Watts'),
(350, 'surname', 'Hart'),
(351, 'surname', 'Burns'),
(352, 'surname', 'Wells');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
