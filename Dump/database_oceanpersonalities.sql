-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 10, 2021 at 06:18 PM
-- Server version: 5.6.51-cll-lve
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_oceanpersonalities`
--

-- --------------------------------------------------------

--
-- Table structure for table `questions_general`
--

CREATE TABLE `questions_general` (
  `questionID` mediumint(9) NOT NULL,
  `questionCorrelate` int(11) NOT NULL,
  `questionTrait` tinyint(4) NOT NULL,
  `questionPositive` tinyint(1) NOT NULL,
  `questionPrompt` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions_general`
--

INSERT INTO `questions_general` (`questionID`, `questionCorrelate`, `questionTrait`, `questionPositive`, `questionPrompt`) VALUES
(1, -1, 1, 1, 'You\'d be excited to go on a first date at a place you\'d never heard of'),
(2, -1, 1, 0, 'You find it pointless to analyze symbolism in movies or artwork'),
(3, -1, 2, 1, 'You always follow through with your goals'),
(4, -1, 2, 0, 'You often forget to put things back in their proper places'),
(5, 6, 3, 1, 'You feel energized by the end of a long social gathering'),
(6, 5, 3, 0, 'You feel drained by the end of an eventful party'),
(7, -1, 3, 0, 'You gravitate around a few familiar people at social events'),
(8, -1, 4, 1, 'You would never step on others to get ahead'),
(9, -1, 4, 0, 'You often share your achievements with others'),
(10, -1, 5, 1, 'People seem all good or all bad based on your last interaction with them'),
(11, -1, 5, 0, 'You are not often hurt by others\' actions'),
(12, -1, 3, 1, 'You enjoy attention in foreign social situations'),
(13, 14, 3, 1, 'You don\'t feel drained by the end of an exciting social gathering'),
(14, 13, 3, 0, 'You feel exhausted by the end of an eventful party'),
(15, -1, 2, 1, 'You tend to take on a persistently busy workload'),
(16, -1, 2, 0, 'You often let your things get unorganized'),
(17, -1, 4, 1, 'Acquaintances consider you easy to get along with'),
(18, -1, 4, 0, 'You often end up in conflicts with others'),
(19, -1, 4, 0, 'If someone had a problem with you, you would confront them about it'),
(20, 21, 5, 1, 'You feel more insecure than secure about your competence'),
(21, 20, 5, 0, 'You have very high self-confidence'),
(22, 23, 1, 1, 'You don\'t mind being around people with vastly different beliefs from your own'),
(23, 22, 1, 0, 'You strongly prefer to be around people who share the same beliefs as you'),
(24, 23, 1, 1, 'You don\'t mind being around people with contrary beliefs from your own'),
(25, -1, 1, 1, 'You\'d be excited to go on a first date at a strange restaurant'),
(26, 23, 1, 0, 'You don\'t mind being around people with contrary beliefs from your own'),
(27, 28, 1, 0, 'You prefer to be around people who share the same beliefs as you'),
(28, 27, 1, 1, 'You don\'t mind being around people with contrary beliefs from your own'),
(29, -1, 2, 1, 'You take on a persistently busy workload'),
(30, 31, 3, 0, 'You feel tired by the end of an eventful party'),
(31, 30, 3, 1, 'You feel alert by the end of an exciting social gathering'),
(32, -1, 4, 1, 'You would not step on others to get ahead'),
(33, -1, 4, 0, 'If someone had a problem with you, you would address it'),
(34, 35, 5, 0, 'You have high self-confidence'),
(35, 34, 5, 1, 'You feel more insecure than secure about your competence'),
(36, 37, 5, 0, 'You have high self-confidence'),
(37, 36, 5, 1, 'You feel more insecure than secure about your ability to do well'),
(38, -1, 2, 1, 'When you put your mind to it, you are very productive'),
(39, 40, 3, 1, 'You seek to get involved when there\'s a lot happening at a time'),
(40, 39, 3, 0, 'You tend to close off when there\'s a lot going on at once'),
(41, 27, 1, 1, 'You avoid being around people with contrary beliefs from your own'),
(42, -1, 4, 0, 'If someone has a problem with you, you immediately address it'),
(43, -1, 4, 1, 'You would not step on others to help your career'),
(44, 36, 5, 1, 'You feel more insecure than secure about how others perceive you');

-- --------------------------------------------------------

--
-- Table structure for table `surveys_answers`
--

CREATE TABLE `surveys_answers` (
  `surveyAnswerID` mediumint(9) NOT NULL,
  `surveyAnswerData` text NOT NULL,
  `surveyAnswerType` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surveys_answers`
--

INSERT INTO `surveys_answers` (`surveyAnswerID`, `surveyAnswerData`, `surveyAnswerType`) VALUES
(1, 'date', 'N'),
(2, 'written', 'N'),
(3, 'likert', 'N'),
(4, 'multiple_choice', 'race'),
(5, 'multiple_choice', 'birth_sex'),
(6, 'multiple_choice', 'gender_identity');

-- --------------------------------------------------------

--
-- Table structure for table `surveys_choices`
--

CREATE TABLE `surveys_choices` (
  `surveyChoiceID` mediumint(9) NOT NULL,
  `surveyAnswerID` mediumint(9) NOT NULL,
  `surveyChoiceOrder` tinyint(4) NOT NULL,
  `surveyChoiceText` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surveys_choices`
--

INSERT INTO `surveys_choices` (`surveyChoiceID`, `surveyAnswerID`, `surveyChoiceOrder`, `surveyChoiceText`) VALUES
(1, 4, 1, 'Asian'),
(2, 4, 2, 'Black'),
(3, 4, 3, 'Indigenous'),
(4, 4, 4, 'White'),
(5, 4, 4, 'Biracial or Multiracial'),
(6, 5, 1, 'Male'),
(7, 5, 2, 'Female'),
(8, 5, 3, 'Intersex'),
(9, 6, 1, 'Cisgender Male'),
(10, 6, 2, 'Cisgender Female'),
(11, 6, 3, 'Transgender Male'),
(12, 6, 4, 'Transgender Female'),
(13, 6, 5, 'Non-Binary'),
(14, 6, 6, 'Questioning');

-- --------------------------------------------------------

--
-- Table structure for table `surveys_general`
--

CREATE TABLE `surveys_general` (
  `surveyID` mediumint(9) NOT NULL,
  `surveyName` tinytext NOT NULL,
  `surveyHidden` tinyint(1) NOT NULL,
  `surveyOrder` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surveys_general`
--

INSERT INTO `surveys_general` (`surveyID`, `surveyName`, `surveyHidden`, `surveyOrder`) VALUES
(1, 'demographics_general', 1, 2),
(3, 'sample_one', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `surveys_questionanswers`
--

CREATE TABLE `surveys_questionanswers` (
  `localID` mediumint(9) NOT NULL,
  `surveyQuestionID` mediumint(9) NOT NULL,
  `surveyAnswerID` mediumint(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surveys_questionanswers`
--

INSERT INTO `surveys_questionanswers` (`localID`, `surveyQuestionID`, `surveyAnswerID`) VALUES
(1, 1, 1),
(2, 2, 4),
(3, 3, 5),
(4, 4, 3),
(5, 5, 2),
(6, 6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `surveys_questions`
--

CREATE TABLE `surveys_questions` (
  `surveyQuestionID` mediumint(9) NOT NULL,
  `surveyID` mediumint(9) NOT NULL,
  `surveyQuestionOrder` tinyint(4) NOT NULL,
  `surveyQuestionPrompt` text NOT NULL,
  `surveyQuestionTarget` text NOT NULL,
  `surveyQuestionIdentifier` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surveys_questions`
--

INSERT INTO `surveys_questions` (`surveyQuestionID`, `surveyID`, `surveyQuestionOrder`, `surveyQuestionPrompt`, `surveyQuestionTarget`, `surveyQuestionIdentifier`) VALUES
(1, 3, 1, 'When were you born?', 'self', 'born'),
(2, 3, 2, 'What race do you identify as?', 'self', 'N'),
(3, 3, 3, 'What sex were you assiged at birth?', 'self', 'N'),
(4, 3, 5, 'How well do you feel your type represents your personality?', 'self', 'testAccuracy'),
(5, 3, 6, 'Do you have any feedback or suggestions?', 'self', 'N'),
(6, 3, 4, 'Which gender identity do you most closely identify with?', 'self', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `surveys_responses`
--

CREATE TABLE `surveys_responses` (
  `localID` bigint(20) NOT NULL,
  `surveyTakenID` mediumint(9) NOT NULL,
  `surveyQuestionID` mediumint(9) NOT NULL,
  `surveyAnswerID` mediumint(9) NOT NULL,
  `surveyResponse` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surveys_responses`
--

INSERT INTO `surveys_responses` (`localID`, `surveyTakenID`, `surveyQuestionID`, `surveyAnswerID`, `surveyResponse`) VALUES
(1, 1, 1, 1, '2001-12-03'),
(2, 1, 2, 4, '4'),
(3, 1, 3, 5, '6'),
(4, 1, 4, 3, '17'),
(5, 1, 5, 2, 'I am Gabriel Quinn Tucker.  beep bop'),
(6, 1, 6, 6, '9'),
(7, 2, 1, 1, '1970-06-10'),
(8, 2, 2, 4, '4'),
(9, 2, 3, 5, '6'),
(10, 2, 4, 3, '17'),
(11, 2, 5, 2, 'This is awesome and accurate...love it!'),
(12, 2, 6, 6, '9');

-- --------------------------------------------------------

--
-- Table structure for table `surveys_taken`
--

CREATE TABLE `surveys_taken` (
  `surveyTakenID` bigint(20) NOT NULL,
  `userID` bigint(20) NOT NULL,
  `surveyID` mediumint(9) NOT NULL,
  `surveyTakenTime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surveys_taken`
--

INSERT INTO `surveys_taken` (`surveyTakenID`, `userID`, `surveyID`, `surveyTakenTime`) VALUES
(1, 1, 3, '2021-03-19 20:57:03'),
(2, 15, 3, '2021-03-24 21:57:19');

-- --------------------------------------------------------

--
-- Table structure for table `tests_responses`
--

CREATE TABLE `tests_responses` (
  `localID` bigint(20) NOT NULL,
  `testTakenID` bigint(20) NOT NULL,
  `questionID` mediumint(9) NOT NULL,
  `questionResponse` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tests_responses`
--

INSERT INTO `tests_responses` (`localID`, `testTakenID`, `questionID`, `questionResponse`) VALUES
(1, 1, 2, 18),
(2, 1, 1, 16),
(3, 1, 4, 16),
(4, 1, 3, 18),
(5, 1, 7, 5),
(6, 1, 6, 1),
(7, 1, 5, 1),
(8, 1, 12, 7),
(9, 1, 9, 15),
(10, 1, 8, 12),
(11, 1, 11, 18),
(12, 1, 10, 17),
(36, 2, 10, 16),
(35, 2, 11, 18),
(34, 2, 8, 13),
(33, 2, 9, 14),
(32, 2, 12, 6),
(31, 2, 5, 0),
(30, 2, 6, 2),
(29, 2, 7, 6),
(28, 2, 3, 18),
(27, 2, 4, 17),
(26, 2, 1, 15),
(25, 2, 2, 18),
(168, 10, 10, 10),
(167, 10, 11, 6),
(166, 10, 8, 7),
(165, 10, 9, 5),
(164, 10, 12, 12),
(163, 10, 5, 7),
(162, 10, 6, 7),
(161, 10, 7, 5),
(160, 10, 3, 13),
(159, 10, 4, 5),
(158, 10, 1, 7),
(157, 10, 2, 15),
(120, 6, 10, 15),
(119, 6, 11, 17),
(118, 6, 8, 16),
(117, 6, 9, 8),
(116, 6, 12, 12),
(115, 6, 5, 1),
(114, 6, 6, 0),
(113, 6, 7, 3),
(112, 6, 3, 18),
(111, 6, 4, 17),
(110, 6, 1, 17),
(109, 6, 2, 17),
(156, 9, 10, 5),
(155, 9, 11, 12),
(154, 9, 8, 10),
(153, 9, 9, 7),
(152, 9, 12, 11),
(151, 9, 5, 13),
(150, 9, 6, 14),
(149, 9, 7, 11),
(148, 9, 3, 13),
(147, 9, 4, 18),
(146, 9, 1, 13),
(145, 9, 2, 17),
(312, 16, 8, 5),
(311, 16, 17, 13),
(310, 16, 18, 15),
(309, 16, 19, 4),
(308, 16, 12, 3),
(307, 16, 13, 18),
(306, 16, 7, 2),
(305, 16, 14, 0),
(304, 16, 3, 11),
(303, 16, 15, 13),
(302, 16, 4, 16),
(301, 16, 16, 15),
(300, 16, 25, 11),
(299, 16, 2, 15),
(298, 16, 23, 8),
(297, 16, 26, 2),
(296, 15, 10, 10),
(295, 15, 20, 2),
(294, 15, 11, 10),
(293, 15, 21, 2),
(292, 15, 8, 8),
(291, 15, 17, 12),
(290, 15, 18, 11),
(289, 15, 19, 6),
(288, 15, 12, 8),
(287, 15, 13, 0),
(286, 15, 7, 5),
(285, 15, 14, 0),
(284, 15, 3, 10),
(283, 15, 15, 14),
(282, 15, 4, 4),
(281, 15, 16, 8),
(280, 15, 25, 10),
(279, 15, 2, 0),
(278, 15, 23, 2),
(277, 15, 26, 10),
(276, 14, 10, 2),
(275, 14, 11, 11),
(274, 14, 8, 16),
(273, 14, 9, 13),
(272, 14, 12, 11),
(271, 14, 5, 13),
(270, 14, 6, 11),
(269, 14, 7, 17),
(268, 14, 3, 13),
(267, 14, 4, 17),
(266, 14, 1, 18),
(265, 14, 2, 6),
(264, 13, 10, 14),
(263, 13, 11, 18),
(262, 13, 8, 10),
(261, 13, 9, 0),
(260, 13, 12, 18),
(259, 13, 5, 15),
(258, 13, 6, 11),
(257, 13, 7, 4),
(256, 13, 3, 7),
(255, 13, 4, 14),
(254, 13, 1, 10),
(253, 13, 2, 18),
(252, 12, 10, 6),
(251, 12, 11, 11),
(250, 12, 8, 7),
(249, 12, 9, 11),
(248, 12, 12, 12),
(247, 12, 5, 6),
(246, 12, 6, 3),
(245, 12, 7, 15),
(244, 12, 3, 2),
(243, 12, 4, 3),
(242, 12, 1, 16),
(241, 12, 2, 6),
(313, 16, 21, 7),
(314, 16, 11, 14),
(315, 16, 20, 1),
(316, 16, 10, 12),
(317, 17, 2, 18),
(318, 17, 27, 18),
(319, 17, 25, 17),
(320, 17, 28, 18),
(321, 17, 16, 16),
(322, 17, 4, 17),
(323, 17, 3, 15),
(324, 17, 29, 18),
(325, 17, 7, 0),
(326, 17, 30, 0),
(327, 17, 12, 10),
(328, 17, 31, 4),
(329, 17, 18, 15),
(330, 17, 33, 3),
(331, 17, 17, 12),
(332, 17, 32, 13),
(333, 17, 11, 17),
(334, 17, 34, 8),
(335, 17, 10, 16),
(336, 17, 35, 15),
(337, 18, 2, 13),
(338, 18, 27, 6),
(339, 18, 25, 15),
(340, 18, 28, 8),
(341, 18, 16, 15),
(342, 18, 4, 16),
(343, 18, 3, 10),
(344, 18, 29, 14),
(345, 18, 7, 6),
(346, 18, 30, 5),
(347, 18, 12, 6),
(348, 18, 31, 5),
(349, 18, 18, 12),
(350, 18, 33, 10),
(351, 18, 17, 17),
(352, 18, 32, 17),
(353, 18, 11, 7),
(354, 18, 34, 8),
(355, 18, 10, 5),
(356, 18, 35, 7),
(357, 19, 2, 16),
(358, 19, 27, 13),
(359, 19, 25, 14),
(360, 19, 28, 15),
(361, 19, 16, 6),
(362, 19, 4, 7),
(363, 19, 3, 6),
(364, 19, 38, 10),
(365, 19, 7, 7),
(366, 19, 40, 12),
(367, 19, 12, 5),
(368, 19, 39, 13),
(369, 19, 18, 12),
(370, 19, 33, 2),
(371, 19, 17, 0),
(372, 19, 32, 14),
(373, 19, 11, 4),
(374, 19, 36, 5),
(375, 19, 10, 10),
(376, 19, 37, 6),
(377, 20, 2, 13),
(378, 20, 27, 12),
(379, 20, 25, 4),
(380, 20, 28, 12),
(381, 20, 16, 1),
(382, 20, 4, 5),
(383, 20, 3, 10),
(384, 20, 38, 13),
(385, 20, 7, 2),
(386, 20, 40, 2),
(387, 20, 12, 18),
(388, 20, 39, 8),
(389, 20, 18, 11),
(390, 20, 33, 2),
(391, 20, 17, 18),
(392, 20, 32, 18),
(393, 20, 11, 4),
(394, 20, 36, 5),
(395, 20, 10, 6),
(396, 20, 37, 13),
(397, 21, 2, 3),
(398, 21, 27, 7),
(399, 21, 25, 16),
(400, 21, 28, 14),
(401, 21, 16, 14),
(402, 21, 4, 15),
(403, 21, 3, 14),
(404, 21, 38, 14),
(405, 21, 7, 7),
(406, 21, 40, 14),
(407, 21, 12, 14),
(408, 21, 39, 15),
(409, 21, 18, 6),
(410, 21, 33, 4),
(411, 21, 17, 12),
(412, 21, 32, 4),
(413, 21, 11, 17),
(414, 21, 36, 3),
(415, 21, 10, 3),
(416, 21, 37, 3),
(417, 22, 2, 12),
(418, 22, 27, 4),
(419, 22, 25, 13),
(420, 22, 28, 14),
(421, 22, 16, 15),
(422, 22, 4, 12),
(423, 22, 3, 10),
(424, 22, 38, 11),
(425, 22, 7, 13),
(426, 22, 40, 10),
(427, 22, 12, 10),
(428, 22, 39, 15),
(429, 22, 18, 17),
(430, 22, 33, 8),
(431, 22, 17, 18),
(432, 22, 32, 18),
(433, 22, 11, 8),
(434, 22, 36, 6),
(435, 22, 10, 6),
(436, 22, 37, 8);

-- --------------------------------------------------------

--
-- Table structure for table `tests_taken`
--

CREATE TABLE `tests_taken` (
  `testTakenID` bigint(20) NOT NULL,
  `userID` bigint(20) NOT NULL,
  `versionID` mediumint(9) NOT NULL,
  `OTI` tinytext NOT NULL,
  `testTime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tests_taken`
--

INSERT INTO `tests_taken` (`testTakenID`, `userID`, `versionID`, `OTI`, `testTime`) VALUES
(1, 1, 2, '33133', '2021-01-01 17:42:34'),
(2, 1, 2, '33133', '2021-01-01 19:39:31'),
(6, 1, 2, '33133', '2021-02-04 20:07:43'),
(9, 6, 2, '33222', '2021-02-11 17:39:41'),
(10, 7, 2, '22212', '2021-02-15 00:31:20'),
(12, 11, 2, '21222', '2021-03-19 22:24:15'),
(13, 13, 2, '32213', '2021-03-21 00:49:39'),
(14, 15, 2, '23332', '2021-03-24 21:47:40'),
(15, 16, 8, '12122', '2021-03-30 23:03:59'),
(16, 17, 8, '23122', '2021-03-30 23:30:52'),
(17, 1, 9, '33123', '2021-03-31 01:51:55'),
(18, 19, 9, '23132', '2021-04-27 15:32:15'),
(19, 24, 11, '32222', '2021-06-15 18:51:48'),
(20, 30, 11, '22232', '2021-08-22 09:23:19'),
(21, 31, 11, '23222', '2021-09-16 22:04:25'),
(22, 32, 11, '22232', '2021-10-10 00:45:28');

-- --------------------------------------------------------

--
-- Table structure for table `traits_domains`
--

CREATE TABLE `traits_domains` (
  `domainID` smallint(6) NOT NULL,
  `domainName` tinytext NOT NULL,
  `domainOrder` smallint(6) NOT NULL,
  `domainColor` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `traits_domains`
--

INSERT INTO `traits_domains` (`domainID`, `domainName`, `domainOrder`, `domainColor`) VALUES
(1, 'General', 0, '1590A3'),
(2, 'Interpersonal', 1, '1590A3'),
(3, 'Virtues', 2, '1590A3'),
(4, 'Aspirational', 3, '1590A3'),
(5, 'Professional', 4, '1590A3'),
(6, 'Ideological', 5, '1590A3'),
(7, 'Idiosyncrasies', 6, '1590A3'),
(8, 'Pathological', 7, '1590A3'),
(9, 'Betterment', 8, '1590A3'),
(10, '', -1, '1590A3');

-- --------------------------------------------------------

--
-- Table structure for table `traits_general`
--

CREATE TABLE `traits_general` (
  `traitID` bigint(20) NOT NULL,
  `OTI` tinytext NOT NULL,
  `domainID` smallint(6) NOT NULL,
  `traitParagraph` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `traits_general`
--

INSERT INTO `traits_general` (`traitID`, `OTI`, `domainID`, `traitParagraph`) VALUES
(48, '30330', 3, '!PLURAL are extremely free-spirited people.  They will often be seen contributing to organizations or causes that serve the greater good and enjoying every second that they do so.  !POSSESSIVE core values include actively engaging in the world around them, spending their time living in the moment, and helping others.'),
(49, '31113', 8, 'A !SINGULAR contains every single trait expression that is considered to be one of David Funderâ€™s â€œBad Fiveâ€ personality traits in extremes.  This is dangerous, and !PLURAL are extremely likely to have mental disorders associated with these pathological traits.'),
(50, '01101', 8, 'A !SINGULAR is likely to be bitter toward society, and Peterson claims that many !POSSESSIVE have not been properly socialized which may lead to detachment, disinhibition, and low emotional affect.'),
(47, '01003', 8, '!PLURAL are likely to encounter problems with performance.  When encountering obstacles, a !SINGULAR will often suffer from stress or lack of motivation which can be too much for them to handle.  This can lead to avoiding their responsibilities to a severe extent and engaging in harmful behaviors to cope.  !PLURAL are often highly erratic in their behaviors.'),
(44, '00301', 7, 'Many extraverts get restless when they\'re alone for too long.  For a !SINGULAR, however, they aren\'t as easily affected by periods of solitude.  Rather, being drawn to action is more of a preference than a necessity for their well-being.'),
(45, '00303', 7, 'There\'s a stereotype about extraverts that they get restless when they\'re alone for an extended period of time.  For !PLURAL, this is especially true, and itâ€™s important for their well being that they spend time with others when they need it.'),
(46, '00031', 5, 'While many types that are highly agreeable may not be the best candidates for management positions due to their avoidance of confrontation, !PLURAL are strong in this regard.  Given a !POSSESSIVE confidence, they are likely to stand up for their beliefs with a firm yet warm voice.  They create friendly yet accountable work environments, and few can match their ability to solve conflict between others.'),
(40, '31000', 8, 'Often, it is difficult for !PLURAL to reach their goals.  This can feel confining for them due to the endless possibility they find in the world paired with a dismal inhibition from reaching it.'),
(38, '00002', 1, 'A !SINGULAR is emotionally affected by others but are generally capable of controlling their emotional responses to these challenges.  Their emotions may boil up inside, but this rarely would result in an angry outburst or in bitter remarks.  Instead, !PLURAL move on from what bothers them not immediately, but after a reasonable amount of time.<br/><br/>!PLURAL more than others may surprise themselves at how they react to certain situations.  For instance, a given negative situation may not harm them as much as they expect, while a positive situation may evoke a profoundly negative emotional response.  Like their highly stable and unstable counterparts, !PLURAL are less predictable in how they emotionally react to a negative stimulus.'),
(37, '00001', 1, '!PLURAL are emotionally stable.  They are able to keep cool in a wide context of situations that may be difficult for others to handle, and this can be beneficial to their performance.  !PLURAL are likely to be less affected by negative interpersonal occurrences in their lives, and they generally can more easily move on from negative encounters with others as well as from lost relationships.  !PLURAL tend to have high self-esteem, and are admirably competent in the face of danger.<br/><br/>However, a !SINGULAR may be overconfident in the face of stressful situations which can lead to risky behaviors in spite of potential consequences.  It may also be difficult for !PLURAL to empathize or relative with others who are not similarly emotionally stable due to a !POSSESSIVE less severe reactions to negative stimuli.  Sad movies or stories are also unlikely to move a !SINGULAR to the same degree as others.'),
(32, '00200', 1, '!PLURAL are naturally ambiverted, and as such, they appreciate a balance between smaller groups of friends and meeting new people.  They are versatile compared to their introverted and extroverted counterparts, and whether the situation is a party or a long period of individual work, this type more easily adapts to its demands without feeling as out of place.  This can make it easier for !PLURAL to fit in with vastly different social groups.<br/><br/>A !SINGULAR is a wildcard and is especially likely to appear highly extroverted in some situations and highly introverted in others.  That considered, it can be difficult for many to make accurate initial judgements about this type based on first impressions.'),
(31, '00100', 1, '!PLURAL are naturally introverted, and as such, they tend to prefer closer, smaller groups of friends over more eventful scenes.  This type may prefer to work independently, and often considers conversations more in retrospect than in the moment.  Further, !PLURAL tend to enjoy their own company and engage in more solitary activities.<br/><br/>It is common for !PLURAL to think for longer before speaking than their extraverted counterparts.  As a result, they may come off as unnerving or noncontributory in conversations.  People may tend to see this type as reserved, but around close and trusted friends, they may be hard to identify as introverts since others can bring out the outgoing side of a !SINGULAR.'),
(29, '02000', 1, '!PLURAL are capable of devoting themselves to tasks, but when they donâ€™t care about said task, it can be difficult for a !SINGULAR to focus.  It can also be difficult for !PLURAL to sustain focus for extended durations so breaks for this type throughout work may be helpful.<br/><br/>A !SINGULAR is in the pail between being responsible and perpetually driven, and irresponsible and perpetually content.  Fortunately, Conscientiousness is considered to be more circumstantial and flexible than other types, so it is possible for a !SINGULAR to become more conscientious over time.'),
(27, '30000', 1, '!PLURAL are generally open to new ideas.  People of this type dislike conforming to the norm and look for ways to express their individuality and creativity.  This can be detrimental when it comes to a !POSSESSIVE performance in formulaic tasks as these tasks may make !PLURAL feel suffocated.  It is important for a !SINGULAR to feel a sense of freedom in approaching a task if it is going to hold their focus, and they enjoy making abstract connections between subjective ideas.<br/><br/>It\'s likely for a !SINGULAR to enjoy devoting time to at least one art form, and they appreciate finding the deeper meaning in things whether it be in music, movies, artwork, or in abstract fields which allow for subjective understandings such as psychology, history, philosophy, or literature.'),
(41, '03001', 3, 'Given how !PLURAL are impressively productive and capable of keeping their emotions in check, they can have almost robotic efficiency when it comes to completing tasks.'),
(42, '00101', 7, 'Many introverts get overwhelmed when they\'re surrounded by others for too long.  For a !SINGULAR, however, they aren\'t as easily drained by being around others.  Rather, quietness is more of a preference than a necessity for their well-being.'),
(43, '00103', 7, 'There\'s a stereotype about introverts that they get overwhelmed when they\'re surrounded by others for an extended period of time.  For !PLURAL, this is especially true, and itâ€™s important for their well being that they get solitary time to recharge when they need it.'),
(39, '00003', 1, '!PLURAL are easily affected by their surroundings.  They may be emotionally volatile (regardless of whether they express it) and experience excessive unpleasant emotions in comparison to the rest of the population.  !PLURAL are not emotionally stable, and when under great stress they may avoid the situation or engage in distractions to cope.  Excessive worry, feelings of loneliness, and self-critical thoughts are common for a !SINGULAR, and sadly, this type is highly likely to hold grudges and to fall victim to mental disorders and low self-esteem.<br/><br/>However, !PLURAL often value their connections with close ones more strongly than someone who is not similarly neurotic.  They may care more strongly about others\' well-being, and emotion is often a source of inspiration for !PLURAL whether creative or in alleviating issues that they personally experienced.  Interestingly, in older populations, high Neuroticism correlates with strong mental health as those whose mental health deteriorates are likely to have weaker emotional affect.'),
(36, '00030', 1, 'Trusting and sympathetic, !PLURAL always consider the impact of their actions on others.  This trait tends to correlate with high emotional intelligence, and !PLURAL are modest and often have moral values they hold to their core.  This type is often likable and people may hold strong positive opinions of them due to their friendliness and caringness.  They are non-confrontational and will often go out of their way to help others, but while this can be a positive quality, it may become harmful when exhibited at extremes.<br/><br/>For instance, !PLURAL may allow others to step on them more than their less agreeable counterparts, and they are likely to avoid conflict when it could result in damaging their interpersonal relationships.  They may be indirect and often word their ways around, or even avoid, a difficult truth.'),
(56, '00010', 8, 'While !PLURAL are modestly disagreeable, this does not necessarily mean that this trait is certain to be pathological.  However, like all traits, it is in great extremes, and is one of David Funderâ€™s â€œBad Fiveâ€ traits (ostensibly antagonism).  A !SINGULAR has crossed the line between being unagreeable and being antagonistic when they exhibit repeated manipulative, hostile, or sadistic behaviors.  Sadly, those who cross this line are prone to diagnoses with Narcissistic Personality Disorder and Antisocial Personality Disorder.  It is difficult, but not impossible, for !PLURAL exhibiting antagonistic behaviors to recover, but the person must desire to do so which for those high in antagonism, is uncommon.  Those who do not exhibit these behaviors, however, are merely assertive, and it is important to distinguish antagonism from mere disagreeableness.'),
(35, '00020', 1, '!PLURAL are a balance between antagonism and letting others step on them.  They will usually self-prioritize when it comes to deciding between themselves and those they donâ€™t know, but for close ones, they are likely to make sacrifices.<br/><br/>!PLURAL are generally not afraid to speak up for what they believe, but when it comes to making others uncomfortable, they may be more likely to withhold.  Who to prioritize in their moral compass is in a chasm, so in making difficult decisions, it can often be difficult for them to decide whether to prioritize themselves or others.  As a result, a !SINGULAR may struggle with decisiveness.'),
(33, '00300', 1, '!PLURAL are naturally extraverted, and as such, they enjoy spending lots of time with a variety of different people.  They need a lot going on in the moment to feel satisfied, and !PLURAL often are underwhelmed by activities that do not involve other people.  Theyâ€™re generally willing to share personal information if prompted, and a !SINGULAR is often highly expressive.<br/><br/>However, !PLURAL can come off as overly domineering if they\'re not careful since they can have so much to say.  They rarely get lost in their thoughts, and a !SINGULAR would likely emphasize living in the moment and not concerning themself with things outside of the present.'),
(34, '00010', 1, 'Blunt and straightforward, !PLURAL see telling the facts as they are to be a virtue.  They rarely accommodate othersâ€™ demands when doing so would interfere with their objectives, so consequently, they may be perceived as cold.  However, a !SINGULAR is especially well-suited for making tough decisions regarding people and is strong in taking objective views on situations, in spite of others who disagree.<br/><br/>Because they are self-prioritizing, !PLURAL are not often considered â€œemotionally intelligentâ€.  They may also be arrogant or selfish.  !SINGULAR may get further in life and be more effective as a result of this; many would not view this as acceptable, but for a !SINGULAR, this is not all bad.'),
(30, '03000', 1, '!PLURAL are highly motivated and consistently follow through with their goals.  Since they are cautious, they are also generally reliable in work environments, and a !SINGULAR is likely to be trusted fulfilling more essential duties.  They are also highly organized and are often highly articulate, and their goals play a large role in their self-identity.<br/><br/>However, !PLURAL are likely to be perfectionistic and upset if a person or obstacle obstructs them from achieving their goals.  A !SINGULAR may be inflexible, and although their personality predisposes them to success, they often will feel less satisfied with what they have, and if they fail to reach a goal, may tend to be harshly self-critical.'),
(28, '01000', 1, '!PLURAL act on a whim without considering long-term consequences, and this spontaneity can make them especially fun to be around.  This type may also tend to be carefree.  When they partake in work that is not unenjoyable, a !SINGULAR will often feel content with their professional life and will not feel a strong desire to keep reaching for more.<br/><br/>However, !PLURAL are often impulsive, irresponsible, and disorganized as a result of this and may struggle to do what\'s necessary for achieving their goals.  Fortunately, Conscientiousness is considered to be more circumstantial and flexible than other types, so it is possible for a !SINGULAR to become more conscientious over time.'),
(25, '10000', 1, '!PLURAL find tradition to offer a sense of comfort and stability.  It gives them an unshifting foundation for their understanding of the world, and for a !SINGULAR, diverging ideas are threatening and donâ€™t deserve their attention.  These traditional beliefs are often paramount in a !POSSESSIVE self-understanding, so itâ€™s understandable why they prefer sticking to whatâ€™s already been established.<br/><br/>The downside to this is that when change could be beneficial, too often a !SINGULAR is unwilling to consider adapting to this.  !PLURAL also tend to be less open to seriously considering opposing viewpoints, and their firm understanding of what constitutes the world may lead to them not exploring abstract ideas and their creativity may suffer consequently.'),
(26, '20000', 1, '!PLURAL are a balance between Openness and abiding by established traditions.  This type is especially versatile in work environments.  While creative, !PLURAL are comfortably able to suppress their beliefs and desire for self-expression when this would be beneficial.  Thus, this type is well-suited for leadership positions as theyâ€™re able to find an equilibrium between ambition and realism, leading to the pursuit of realistic yet ambitious goals.<br/><br/>A !SINGULAR is likely to be similarly talented at most things they apply themself to, whether abstract or concrete.  This makes !PLURAL well-rounded which can result in a diverse skillset for achieving seemingly contradictory tasks.'),
(51, '00032', 5, 'Given that !PLURAL are both selfless and emotionally balanced, a !SINGULAR is the ideal counselor.  They are able to notice and manage their emotions effectively, thus resulting in them often offering practical advice for emotional management that they themselves have likely accrued through experience.'),
(52, '00100', 8, 'While there is nothing wrong with introversion, extreme manifestation of introversion (ostensibly detachment) is considered to be one of David Funderâ€™s â€œBad Fiveâ€ personality traits.  So long as a !SINGULAR still engages in interpersonal relationships, experiences pleasure, and is not unreasonably suspicious of othersâ€™ intentions, this is nothing to worry about; for a !SINGULAR who partially or fully meets any of these criteria, however, this person likely encountered developmental challenges, trauma, or repeated betrayal or rejection which influenced their emotional affect.  Sadly, !PLURAL who are high in detachment are prone to Major Depressive Disorder, Avoidant Personality Disorder, Generalized Anxiety Disorder, and a plethora of other mental illnesses.  Of course, however, this does not apply to all !PLURAL.'),
(53, '00003', 8, '!PLURAL are highly neurotic, and extreme Neuroticism (ostensibly emotional lability) is considered to be one of David Funderâ€™s â€œBad Fiveâ€ personality traits.  !PLURAL are to some degree emotionally labile and may experience separation anxiety, anxiety, extreme mood swings, depressivity, bitterness or hostility, erroneous belief that others are ill-meaning, unwillingness to change negative behaviors, and interpersonal trust issues.  Understandably, high Neuroticism is the greatest predisposition to mental disorders, including Major Depressive Disorder, Generalized Anxiety Disorder, Bipolar Disorder, Borderline Personality Disorder, Schizophrenia, and all other disorders positively correlating with emotional lability or psychotic tendencies.  Of course, not all !PLURAL fully exhibit all of these issues, but they are disproportionately common among !PLURAL and it is essential that those with many of the pathological traits above are addressed with a licensed mental professional, as all too often, these symptoms may significantly worsen the longer they are not addressed.'),
(54, '30000', 8, 'A modest amount of Openness is alright.  But in extremes, a !SINGULAR can fail to dismiss absurd ideas and may manifest abnormal levels of eccentricity.  This degree of Openness, ostensibly psychoticism, is one of David Funderâ€™s â€œBad Fiveâ€ traits.  These people may believe strange things such as the earth being flat and may engage in behaviors that society would consider to be taboo.  !PLURAL who are high in psychoticism may be predisposed to Schizotypal Personality Disorder, although of course, this does not apply to all !PLURAL.'),
(55, '03003', 8, 'When manifested in !PLURAL, extreme Conscientiousness paired with high neuroticism is dangerous.  If a !SINGULAR has overactive systems of disgust and are driven to a pathological extent, they may be predisposed to Obsessive-Compulsive Personality Disorder and Obsessive-Compulsive Disorder.  Although this does not apply to all !PLURAL, it is something to look out for if the !SINGULAR feels disproportionately and perpetually uneased by what to others, would be relatively insignificant stimuli.'),
(57, '00201', 3, 'Ambiverts are versatile.  And !PLURAL, being emotionally stable, are especially versatile.  The fact that !PLURAL are able to blend with a wider variety of social situations and are able to sustain their emotions in difficult contexts makes them perfect candidates for entrustment in difficult and unpredictable situations.'),
(58, '00203', 7, '!PLURAL are emotionally affected by diverse social situations.  Their desire to be alone or to be with friends often oscillates, and as a result, they often feel out of place, especially when theyâ€™re around people they donâ€™t like.  It is important that !PLURAL have consistent access to both solitude and social events, as if they donâ€™t, this may affect their emotional stability.'),
(59, '30200', 2, '!PLURAL are among the most versatile personalities.  Their high openness paired with ambiversion makes them especially likely to end up being accepted into many different kinds of social groups due to a strong compatibility with a wide variety of other personality types.  But not only are they likely to be socially accepted by a wide range of audiences; a !POSSESSIVE genuine interest in diverse activities makes them more engaged and involved with these different audiences, which allows them to have a better time in a surprising variety of contexts.  Others tend to notice this, in turn further improving their likeability.'),
(60, '22222', 7, 'A !SINGULAR is the only personality type to have all mid-level traits.'),
(61, '20222', 5, '!PLURAL are grounded in reality.  Interested in competing ideas, but practical. They spend time alone to study, but not to a degree that obstructs their capacity to share and test their ideas.  Emotionally aware, but not to a degree that leads to favoritism.  And neurotic, but only insofar as it allows them to more closely tie themselves to ideas about which theyâ€™re passionate.  As a result, a !SINGULAR would make a fantastic historian, sociologist, or anthropologist.'),
(62, '30220', 2, '!PLURAL are drawn to a variety of different types of people.  They play a passive yet receptive role when it comes to getting to know them, but this by no means detracts from the quality of their relationships.  It may take longer than most for their relationships to develop as a result of this, but !PLURAL prefer to take it slow and to watch and see where things naturally take them.'),
(63, '00202', 8, '!PLURAL vary in how they respond to various social situations, so as a result, theyâ€™re harder to classify.  They keep to themselves around those they donâ€™t like and may be upset when theyâ€™re forced to interact with such people.  However, if they wish to, they can generally control their emotions in such situations, but after a long day, they can often slip in terms of hiding their upsetedness.');

-- --------------------------------------------------------

--
-- Table structure for table `traits_ocean`
--

CREATE TABLE `traits_ocean` (
  `localID` tinyint(4) NOT NULL,
  `oceanColor` tinytext NOT NULL,
  `oceanParagraph` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `traits_ocean`
--

INSERT INTO `traits_ocean` (`localID`, `oceanColor`, `oceanParagraph`) VALUES
(1, '4000FF', '!TRAIT, the first trait in the OCEAN acronym, is the most controversial.  Formally, it refers to â€œOpenness of Experienceâ€, but we simplify it to just â€œOpennessâ€ so it is more colloquial.  Some view this trait as reflecting a personâ€™s â€œapproach to intellectual mattersâ€ or even level of intelligence, whereas others deem it more as a measure of their engagement with the humanities such as â€œliterature, art, and musicâ€.  More broadly, it entails open-mindedness, aesthetics, ideas, values, creativity, intellect, and perceptiveness (Funder 203, 210).'),
(2, 'FF5500', '!TRAIT, the second trait in the OCEAN acronym, roughly refers to how high-functioning one is in society, relationships, and reaching goals.  It has been suggested not to correlate with intelligence, but to be a fantastic predictor of whether one will engage in harmful or self-damaging behaviors.  More broadly, it entails competence, order, dutifulness, ambition, self-discipline, deliberation, industriousness, and orderliness (Funder 203, 208-209).'),
(3, 'FFE600', '!TRAIT, the third trait in the OCEAN acronym, measures how strongly you react to sensory stimuli.  Introverts overreact to high levels of external activity and therefore close themselves off, whereas extraverts underreact to high levels of external activity and therefore seek to become more involved.  More broadly, it entails warmth, gregariousness, assertiveness, activity, excitement seeking, and enthusiasm (Funder 202, 203).'),
(4, '34EBA4', '!TRAIT, the fourth trait in the OCEAN acronym, measures a variety of interesting factors.  Those high in Agreeableness are likely to be â€œliberal and egalitarianâ€, whereas those low are likely to be â€œconservative and traditionalâ€.  It also tends to correlate with a lower likelihood to cheat on your partner, swifter recovery time from diseases, and greater satisfaction gained from interpersonal relationships.  More broadly, it entails trust, straightforwardness, altruism, compliance, cooperativeness, modesty, compassion, conflict avoidance, and politeness (Funder 203, 209-210).'),
(5, 'FF0061', '!TRAIT, the final trait in the OCEAN acronym, is the bleakest of the traits.  People high in Neuroticism â€œdeal ineffectively with problemsâ€ and â€œreact more negatively to stressful eventsâ€.  Those who are generally satisfied with their lives are not neurotic, and the trait also correlates with â€œtaking things too seriously, being unable to handle criticismâ€, and even a predisposition to being afflicted by mental disorders.  More broadly, it entails anxiety, hostility, depression, self-consciousness, impulsiveness, vulnerability to stress, volatility, and emotional withdrawal (Funder 203, 205-206).');

-- --------------------------------------------------------

--
-- Table structure for table `types_general`
--

CREATE TABLE `types_general` (
  `localID` bigint(20) NOT NULL,
  `OTI` tinytext NOT NULL,
  `typeName` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `types_general`
--

INSERT INTO `types_general` (`localID`, `OTI`, `typeName`) VALUES
(1, '11111', 'Placeholder'),
(2, '11112', 'Placeholder'),
(3, '11113', 'Locket'),
(4, '11121', 'Placeholder'),
(5, '11122', 'Placeholder'),
(6, '11123', 'Placeholder'),
(7, '11131', 'Placeholder'),
(8, '11132', 'Placeholder'),
(9, '11133', 'Placeholder'),
(10, '11211', 'Placeholder'),
(11, '11212', 'Cynic'),
(12, '11213', 'Placeholder'),
(13, '11221', 'Placeholder'),
(14, '11222', 'Placeholder'),
(15, '11223', 'Placeholder'),
(16, '11231', 'Placeholder'),
(17, '11232', 'Placeholder'),
(18, '11233', 'Placeholder'),
(19, '11311', 'Placeholder'),
(20, '11312', 'Placeholder'),
(21, '11313', 'Placeholder'),
(22, '11321', 'Placeholder'),
(23, '11322', 'Placeholder'),
(24, '11323', 'Placeholder'),
(25, '11331', 'Placeholder'),
(26, '11332', 'Placeholder'),
(27, '11333', 'Placeholder'),
(28, '12111', 'Placeholder'),
(29, '12112', 'Placeholder'),
(30, '12113', 'Placeholder'),
(31, '12121', 'Placeholder'),
(32, '12122', 'Placeholder'),
(33, '12123', 'Placeholder'),
(34, '12131', 'Placeholder'),
(35, '12132', 'Placeholder'),
(36, '12133', 'Placeholder'),
(37, '12211', 'Traditionalist'),
(38, '12212', 'Placeholder'),
(39, '12213', 'Placeholder'),
(40, '12221', 'Placeholder'),
(41, '12222', 'Placeholder'),
(42, '12223', 'Placeholder'),
(43, '12231', 'Placeholder'),
(44, '12232', 'Placeholder'),
(45, '12233', 'Placeholder'),
(46, '12311', 'Officer'),
(47, '12312', 'Placeholder'),
(48, '12313', 'Placeholder'),
(49, '12321', 'Placeholder'),
(50, '12322', 'Placeholder'),
(51, '12323', 'Placeholder'),
(52, '12331', 'Placeholder'),
(53, '12332', 'Placeholder'),
(54, '12333', 'Placeholder'),
(55, '13111', 'Placeholder'),
(56, '13112', 'Placeholder'),
(57, '13113', 'Placeholder'),
(58, '13121', 'Placeholder'),
(59, '13122', 'Placeholder'),
(60, '13123', 'Placeholder'),
(61, '13131', 'Placeholder'),
(62, '13132', 'Placeholder'),
(63, '13133', 'Placeholder'),
(64, '13211', 'Placeholder'),
(65, '13212', 'Judge'),
(66, '13213', 'Placeholder'),
(67, '13221', 'Placeholder'),
(68, '13222', 'Placeholder'),
(69, '13223', 'Placeholder'),
(70, '13231', 'Placeholder'),
(71, '13232', 'Placeholder'),
(72, '13233', 'Placeholder'),
(73, '13311', 'Executive'),
(74, '13312', 'Placeholder'),
(75, '13313', 'Placeholder'),
(76, '13321', 'Placeholder'),
(77, '13322', 'Placeholder'),
(78, '13323', 'Placeholder'),
(79, '13331', 'Placeholder'),
(80, '13332', 'Placeholder'),
(81, '13333', 'Placeholder'),
(82, '21111', 'Placeholder'),
(83, '21112', 'Placeholder'),
(84, '21113', 'Placeholder'),
(85, '21121', 'Placeholder'),
(86, '21122', 'Placeholder'),
(87, '21123', 'Placeholder'),
(88, '21131', 'Placeholder'),
(89, '21132', 'Placeholder'),
(90, '21133', 'Placeholder'),
(91, '21211', 'Placeholder'),
(92, '21212', 'Placeholder'),
(93, '21213', 'Placeholder'),
(94, '21221', 'Placeholder'),
(95, '21222', 'Historian'),
(96, '21223', 'Prophet'),
(97, '21231', 'Placeholder'),
(98, '21232', 'Placeholder'),
(99, '21233', 'Placeholder'),
(100, '21311', 'Placeholder'),
(101, '21312', 'Placeholder'),
(102, '21313', 'Placeholder'),
(103, '21321', 'Placeholder'),
(104, '21322', 'Placeholder'),
(105, '21323', 'Placeholder'),
(106, '21331', 'Placeholder'),
(107, '21332', 'Placeholder'),
(108, '21333', 'Placeholder'),
(109, '22111', 'Placeholder'),
(110, '22112', 'Placeholder'),
(111, '22113', 'Placeholder'),
(112, '22121', 'Placeholder'),
(113, '22122', 'Placeholder'),
(114, '22123', 'Placeholder'),
(115, '22131', 'Placeholder'),
(116, '22132', 'Placeholder'),
(117, '22133', 'Placeholder'),
(118, '22211', 'Placeholder'),
(119, '22212', 'Placeholder'),
(120, '22213', 'Placeholder'),
(121, '22221', 'Placeholder'),
(122, '22222', 'Sociologist'),
(123, '22223', 'Placeholder'),
(124, '22231', 'Placeholder'),
(125, '22232', 'Placeholder'),
(126, '22233', 'Placeholder'),
(127, '22311', 'Placeholder'),
(128, '22312', 'Placeholder'),
(129, '22313', 'Placeholder'),
(130, '22321', 'Placeholder'),
(131, '22322', 'Placeholder'),
(132, '22323', 'Placeholder'),
(133, '22331', 'Placeholder'),
(134, '22332', 'Placeholder'),
(135, '22333', 'Placeholder'),
(136, '23111', 'Placeholder'),
(137, '23112', 'Placeholder'),
(138, '23113', 'Placeholder'),
(139, '23121', 'Placeholder'),
(140, '23122', 'Placeholder'),
(141, '23123', 'Placeholder'),
(142, '23131', 'Placeholder'),
(143, '23132', 'Aficionado'),
(144, '23133', 'Placeholder'),
(145, '23211', 'Placeholder'),
(146, '23212', 'Placeholder'),
(147, '23213', 'Placeholder'),
(148, '23221', 'Placeholder'),
(149, '23222', 'Anthropologist'),
(150, '23223', 'Consigliere'),
(151, '23231', 'Placeholder'),
(152, '23232', 'Placeholder'),
(153, '23233', 'Placeholder'),
(154, '23311', 'Industrialist'),
(155, '23312', 'Placeholder'),
(156, '23313', 'Placeholder'),
(157, '23321', 'Placeholder'),
(158, '23322', 'Attorney'),
(159, '23323', 'Placeholder'),
(160, '23331', 'Placeholder'),
(161, '23332', 'Placeholder'),
(162, '23333', 'Placeholder'),
(163, '31111', 'Placeholder'),
(164, '31112', 'Placeholder'),
(165, '31113', 'Wildcard'),
(166, '31121', 'Placeholder'),
(167, '31122', 'Placeholder'),
(168, '31123', 'Placeholder'),
(169, '31131', 'Placeholder'),
(170, '31132', 'Placeholder'),
(171, '31133', 'Poet'),
(172, '31211', 'Placeholder'),
(173, '31212', 'Placeholder'),
(174, '31213', 'Placeholder'),
(175, '31221', 'Placeholder'),
(176, '31222', 'Placeholder'),
(177, '31223', 'Placeholder'),
(178, '31231', 'Placeholder'),
(179, '31232', 'Placeholder'),
(180, '31233', 'Placeholder'),
(181, '31311', 'Placeholder'),
(182, '31312', 'Placeholder'),
(183, '31313', 'Placeholder'),
(184, '31321', 'Placeholder'),
(185, '31322', 'Placeholder'),
(186, '31323', 'Performer'),
(187, '31331', 'Placeholder'),
(188, '31332', 'Placeholder'),
(189, '31333', 'Placeholder'),
(190, '32111', 'Placeholder'),
(191, '32112', 'Placeholder'),
(192, '32113', 'Placeholder'),
(193, '32121', 'Placeholder'),
(194, '32122', 'Placeholder'),
(195, '32123', 'Placeholder'),
(196, '32131', 'Placeholder'),
(197, '32132', 'Placeholder'),
(198, '32133', 'Esoteric'),
(199, '32211', 'Placeholder'),
(200, '32212', 'Placeholder'),
(201, '32213', 'Placeholder'),
(202, '32221', 'Connoisseur'),
(203, '32222', 'Mediator'),
(204, '32223', 'Placeholder'),
(205, '32231', 'Placeholder'),
(206, '32232', 'Counselor'),
(207, '32233', 'Placeholder'),
(208, '32311', 'Placeholder'),
(209, '32312', 'Placeholder'),
(210, '32313', 'Placeholder'),
(211, '32321', 'Placeholder'),
(212, '32322', 'Placeholder'),
(213, '32323', 'Placeholder'),
(214, '32331', 'Placeholder'),
(215, '32332', 'Placeholder'),
(216, '32333', 'Placeholder'),
(217, '33111', 'Placeholder'),
(218, '33112', 'Placeholder'),
(219, '33113', 'Placeholder'),
(220, '33121', 'Placeholder'),
(221, '33122', 'Placeholder'),
(222, '33123', 'Placeholder'),
(223, '33131', 'Placeholder'),
(224, '33132', 'Placeholder'),
(225, '33133', 'Visionary'),
(226, '33211', 'Placeholder'),
(227, '33212', 'Placeholder'),
(228, '33213', 'Placeholder'),
(229, '33221', 'Placeholder'),
(230, '33222', 'Placeholder'),
(231, '33223', 'Placeholder'),
(232, '33231', 'Placeholder'),
(233, '33232', 'Placeholder'),
(234, '33233', 'Neoteric'),
(235, '33311', 'Opportunist'),
(236, '33312', 'Placeholder'),
(237, '33313', 'Placeholder'),
(238, '33321', 'Placeholder'),
(239, '33322', 'Campaigner'),
(240, '33323', 'Placeholder'),
(241, '33331', 'Placeholder'),
(242, '33332', 'Placeholder'),
(243, '33333', 'Placeholder');

-- --------------------------------------------------------

--
-- Table structure for table `users_general`
--

CREATE TABLE `users_general` (
  `userID` bigint(20) NOT NULL,
  `userUsername` tinytext NOT NULL,
  `userFirstName` tinytext NOT NULL,
  `userEmail` tinytext NOT NULL,
  `userPassword` longtext NOT NULL,
  `OTI` tinytext NOT NULL,
  `userAdmin` tinyint(1) NOT NULL,
  `userAccountTime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_general`
--

INSERT INTO `users_general` (`userID`, `userUsername`, `userFirstName`, `userEmail`, `userPassword`, `OTI`, `userAdmin`, `userAccountTime`) VALUES
(1, 'gabetucker22', 'Gabe', 'gabeqtucker@gmail.com', '$2y$10$IwKOMwD8bq/ofT9qPRPpT.weCcKUTKCsgwBePBzV76wEuTg.aQRPa', '33123', 1, '2021-03-19 21:28:15'),
(2, 'Cathrine22', 'Clair', 'bart.meesterburrie@advantech.nl', '$2y$10$jahtxpiktstHfH4vppfDUOBWu683VQ29/a2.9K1wQglJMz1Fd0pvG', '00000', 0, '2021-03-19 21:28:15'),
(3, 'Jessedah', 'Jessedah', 'i.o.ox.ver.tris@gmail.com', '$2y$10$2IhIXFVhQ/8UjdhPjAk40uDokC6wz2k1gVcEl9W.ERLdn4G0.EX5K', '00000', 0, '2021-03-19 21:28:15'),
(4, 'ALMShapiroPeterson', 'Arushi', 'arushi.badola01@gmail.com', '$2y$10$aP8UcYFIFRG6tuVcdmqlB.3UHWUAkotbrsozhiCIKWE75j5/O.dKS', '00000', 1, '2021-03-19 21:28:15'),
(5, 'Lester78', 'Bertrand', 'magalilecomte@hotmail.com', '$2y$10$WUiVAcrVZ.BvRTqzfru0WufjTAsMu4b83.osXzpgYdxtE1ztCCAsm', '00000', 0, '2021-03-19 21:28:15'),
(9, 'Lessie82', 'Corrine', 'shawnwillis3138@gmail.com', '$2y$10$T4kcw1qR9NEYnQBhQgjig.hNf8oZiuzmWMFCbgbNPEZrEFlNK6BJ6', '00000', 0, '2021-03-19 21:28:15'),
(6, 'declananders6', 'Declan', 'declananders6@gmail.com', '$2y$10$DG2hmsfjd1g5JmCW1OOIhurVMu9i6HE3UgoqjFWK.KMNroSz9dyQa', '33222', 0, '2021-03-19 21:28:15'),
(7, 'VincentHaney', 'Vincent', 'haney.237@osu.edu', '$2y$10$E8FLYSvtIqJ/vMBrtQyDeeFWnOxqR4fFzFach5NtrTDJ7o.JMfX4K', '22212', 0, '2021-03-19 21:28:15'),
(8, 'Sydney28', 'Elias', 'Donny.Armstrong26@yahoo.com', '$2y$10$59FBb1Rh8uuAigwd9cokA.zuGLKR7560qtWjWTrGkcaLA8aCBnZzu', '00000', 0, '2021-03-19 21:28:15'),
(10, 'Jonathan35', 'Naomie', 'honger.courtney@gmail.com', '$2y$10$q1MeX1CYKnRFGoPOfH5F0ecqHs1TjakFoBLJxtV0/1QvsOHXyWuZu', '00000', 0, '2021-03-19 21:28:15'),
(11, 'Ian1', 'Ian', 'IanLivingston2001@gmail.com', '$2y$10$2zcD/JnQupPNVGo8X68aTe7OMp5b/VZ6MfAp1hDX/J3pJzLAGpEKa', '21222', 0, '2021-03-19 21:28:15'),
(12, 'Harmony20', 'Gabriel', 'mkf019@yahoo.com', '$2y$10$Qap2nM17NgHFJbb.ifJ87uVtOTk1kFJM2qsr9k0uUb9dy76e5LtXO', '00000', 0, '2021-03-20 15:18:57'),
(13, 'ConnorT', 'Connor', 'Connor.telford01@gmail.com', '$2y$10$465drrJY1G/6w/DS.9Uwm.bpC/slonPm9HqwjGLMCfktbnKAeN1zi', '32213', 0, '2021-03-21 00:46:27'),
(14, 'bpi', 'b', 'benoitadamski@gmail.com', '$2y$10$pUabPsyv3.lnnm6uwVTCge2gYpixN.OaiTmo9LQX5eE97MwKEM/QO', '00000', 0, '2021-03-24 17:33:58'),
(15, 'Tucker', 'Wendell', 'wtucker@dataresolutions.com', '$2y$10$XNaG78XDEwjiiAxlXHgRiuHyKdfgmSQJIQZ4mTV.rNqg/3H4.mvbG', '23332', 0, '2021-03-24 21:39:41'),
(16, '1Coal', 'Cole', '133coal@gmail.com', '$2y$10$Eczb/64hdzsa4TBjNlgIsuGsUv3u4Y0Zf8OU1.3mkAVDtEqRC/5b.', '12222', 0, '2021-03-30 21:12:27'),
(17, 'betterian', 'ian', 'ian@the-tuckers.com', '$2y$10$0a6XO1vMEa.prJRA/HhDcugmuIBikKh5DNRpO9e7j2uIQ8TNtPQsy', '22122', 0, '2021-03-30 23:26:45'),
(18, 'Augusthob', 'Augusthob', 'berta_vishnyakova.1984@mail.com', '$2y$10$E/wfa8ahZv3triWdDlozHuE8MoaPGw8NNIRj3OPk5lR0dJR0vYRgW', '00000', 0, '2021-04-20 21:40:06'),
(19, 'vicky', 'vicky', 'vickypeucker@gmx.net', '$2y$10$lLz4d2jxwhgIleRO7Rx3DexBQtrjZTgnNn57PmRqd2NfvoeTaRH2W', '23132', 0, '2021-04-27 15:26:47'),
(20, 'Lydiacolvin', 'Lydia', 'lydiacolvin02@gmail.com', '$2y$10$xLmSoTqP2ZiJEBdwl.zY7.g0oI11MmjX/6w9OmGGF4ZyXzspUoMQC', '00000', 0, '2021-05-01 14:21:11'),
(21, 'raihuang', 'Rainbow', 'rainbowh333@gmail.com', '$2y$10$ZIng62a.JozB5k4o2jB/DuOm/CSuy/ANomEJ80lmMtVtIOEkr.HaS', '00000', 0, '2021-05-01 14:21:35'),
(22, 'Harrypsymn', 'Harrypsymn', 'yana.kryulova@torontomail.com', '$2y$10$tcF92eQlvXlTZwQ/2XfSAuIchrbnWnVQbt6Pr50iT2wY3VcZ9UhxK', '00000', 0, '2021-05-10 15:09:33'),
(23, 'Perry77', 'Jannie', 'verlandaalfred@gmail.com', '$2y$10$GVSWoKAd9cc7.8HQ3NLwReE.qWYWxnmZgjhl5VBv2aeQybKoH3IMq', '00000', 0, '2021-06-04 07:18:22'),
(24, 'Avinashk02', 'Avinash', 'avikosaraju@gmail.com', '$2y$10$tfyap8rgj77F0Jo6VKHIEu.92B9nXyG0olceDNvapd2kC85hOY1AK', '32222', 0, '2021-06-15 18:48:45'),
(26, 'asf23sd23sd', 'NAME CENSORED', 'salavat.esengaliev@yandex.com', '$2y$10$6OXsfUv7ySEi/bavja3eruKB84merPB5pO/6fmibu3lQRurfItoCy', '00000', 0, '2021-06-26 11:08:00'),
(30, 'ludyd', 'ludy', 'ludydianaw@gmail.com', '$2y$10$IDDvTelirxEuFlD7JoyLfu9zwxrKJ2Ob8WZ2Lo.6VVvrzwv2HKvhq', '22232', 0, '2021-08-22 09:19:23'),
(31, 'tacos20065', 'vasilios', 'vasillioskonstantacos@gmail.com', '$2y$10$kMPQEr/l1OFl9Xu2YnP7PeKqxdiBiafBU/6A3W.o5xNF6zxAqYhYu', '23222', 0, '2021-09-16 22:02:24'),
(28, 'asf2345678d', 'NAME CENSORED', 'brofest77@gmail.com', '$2y$10$R1aetV7..ZMEbffppxanNOk8svp4oZ69gIH5UYvAArCtzg6CZHp1m', '00000', 0, '2021-06-26 11:08:21'),
(29, 'asf2345681d', 'NAME CENSORED', 'kilmarupsu@biyac.com', '$2y$10$nR4LTWe8QHXWLdyh/rwAoeEQbUOIl5sQh9IZQo5wpU8o47r2wO64e', '00000', 0, '2021-06-26 11:08:21'),
(32, 'Vydula', 'Vybhav', 'vybhav.vydula@gmail.com', '$2y$10$MjQN0uAsmaClhbQq8SJutethKslvqLxD5aPFN0s/lRCHm7/4ELPU2', '22232', 0, '2021-10-10 00:36:50');

-- --------------------------------------------------------

--
-- Table structure for table `versions_general`
--

CREATE TABLE `versions_general` (
  `versionID` mediumint(9) NOT NULL,
  `versionNumber` double NOT NULL,
  `versionMaxValue` smallint(6) NOT NULL,
  `versionTime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `versions_general`
--

INSERT INTO `versions_general` (`versionID`, `versionNumber`, `versionMaxValue`, `versionTime`) VALUES
(1, 0.1, 18, '2020-12-23 19:25:21'),
(2, 0.11, 18, '2020-12-24 00:48:17'),
(3, 0.12, 18, '2021-03-30 21:23:47'),
(6, 0.2, 18, '2021-03-30 22:36:45'),
(8, 0.21, 18, '2021-03-30 22:59:28'),
(9, 0.22, 18, '2021-03-31 01:45:30'),
(10, 0.23, 18, '2021-05-02 22:21:20'),
(11, 0.24, 18, '2021-05-02 22:34:37'),
(14, 0.27, 18, '2021-10-10 01:45:41');

-- --------------------------------------------------------

--
-- Table structure for table `versions_questions`
--

CREATE TABLE `versions_questions` (
  `localID` bigint(20) NOT NULL,
  `versionID` mediumint(9) NOT NULL,
  `questionID` mediumint(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `versions_questions`
--

INSERT INTO `versions_questions` (`localID`, `versionID`, `questionID`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 2, 2),
(13, 2, 1),
(14, 2, 4),
(15, 2, 3),
(16, 2, 7),
(17, 2, 6),
(18, 2, 5),
(19, 2, 9),
(20, 2, 8),
(21, 2, 11),
(22, 2, 10),
(23, 2, 12),
(24, 3, 2),
(25, 3, 1),
(26, 3, 4),
(27, 3, 3),
(28, 3, 7),
(29, 3, 12),
(30, 3, 9),
(31, 3, 8),
(32, 3, 11),
(33, 3, 10),
(34, 3, 13),
(35, 3, 14),
(68, 6, 10),
(67, 6, 11),
(66, 6, 8),
(65, 6, 13),
(64, 6, 12),
(63, 6, 14),
(62, 6, 7),
(61, 6, 3),
(60, 6, 4),
(59, 6, 1),
(58, 6, 2),
(69, 6, 15),
(70, 6, 16),
(71, 6, 17),
(72, 6, 18),
(73, 6, 19),
(74, 6, 20),
(75, 6, 21),
(76, 6, 22),
(77, 6, 23),
(117, 8, 26),
(116, 8, 25),
(115, 8, 20),
(114, 8, 10),
(113, 8, 21),
(112, 8, 11),
(111, 8, 17),
(110, 8, 8),
(109, 8, 19),
(108, 8, 18),
(107, 8, 13),
(106, 8, 12),
(105, 8, 14),
(104, 8, 7),
(103, 8, 15),
(102, 8, 3),
(101, 8, 16),
(100, 8, 4),
(99, 8, 23),
(98, 8, 2),
(118, 9, 2),
(119, 9, 25),
(120, 9, 16),
(121, 9, 4),
(122, 9, 3),
(123, 9, 7),
(124, 9, 12),
(125, 9, 18),
(126, 9, 17),
(127, 9, 11),
(128, 9, 10),
(129, 9, 27),
(130, 9, 28),
(131, 9, 29),
(132, 9, 30),
(133, 9, 31),
(134, 9, 32),
(135, 9, 33),
(136, 9, 34),
(137, 9, 35),
(138, 10, 2),
(139, 10, 27),
(140, 10, 25),
(141, 10, 28),
(142, 10, 16),
(143, 10, 4),
(144, 10, 3),
(145, 10, 29),
(146, 10, 7),
(147, 10, 30),
(148, 10, 12),
(149, 10, 31),
(150, 10, 18),
(151, 10, 33),
(152, 10, 17),
(153, 10, 32),
(154, 10, 11),
(155, 10, 36),
(156, 10, 10),
(157, 10, 37),
(158, 11, 2),
(159, 11, 27),
(160, 11, 25),
(161, 11, 28),
(162, 11, 16),
(163, 11, 4),
(164, 11, 3),
(165, 11, 7),
(166, 11, 12),
(167, 11, 18),
(168, 11, 33),
(169, 11, 17),
(170, 11, 32),
(171, 11, 11),
(172, 11, 36),
(173, 11, 10),
(174, 11, 37),
(175, 11, 38),
(176, 11, 39),
(177, 11, 40),
(237, 14, 44),
(236, 14, 10),
(235, 14, 36),
(234, 14, 11),
(233, 14, 43),
(232, 14, 17),
(231, 14, 42),
(230, 14, 18),
(229, 14, 39),
(228, 14, 12),
(227, 14, 40),
(226, 14, 7),
(225, 14, 38),
(224, 14, 3),
(223, 14, 4),
(222, 14, 16),
(221, 14, 41),
(220, 14, 25),
(219, 14, 27),
(218, 14, 2);

-- --------------------------------------------------------

--
-- Table structure for table `votes_traits`
--

CREATE TABLE `votes_traits` (
  `localID` bigint(20) NOT NULL,
  `userID` bigint(20) NOT NULL,
  `traitID` bigint(20) NOT NULL,
  `voteIsUpvote` tinyint(1) NOT NULL,
  `voteIsCurrent` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `votes_traits`
--

INSERT INTO `votes_traits` (`localID`, `userID`, `traitID`, `voteIsUpvote`, `voteIsCurrent`) VALUES
(2, 31, 26, 1, 1),
(3, 31, 30, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questions_general`
--
ALTER TABLE `questions_general`
  ADD PRIMARY KEY (`questionID`);

--
-- Indexes for table `surveys_answers`
--
ALTER TABLE `surveys_answers`
  ADD PRIMARY KEY (`surveyAnswerID`);

--
-- Indexes for table `surveys_choices`
--
ALTER TABLE `surveys_choices`
  ADD PRIMARY KEY (`surveyChoiceID`);

--
-- Indexes for table `surveys_general`
--
ALTER TABLE `surveys_general`
  ADD PRIMARY KEY (`surveyID`);

--
-- Indexes for table `surveys_questionanswers`
--
ALTER TABLE `surveys_questionanswers`
  ADD PRIMARY KEY (`localID`);

--
-- Indexes for table `surveys_questions`
--
ALTER TABLE `surveys_questions`
  ADD PRIMARY KEY (`surveyQuestionID`);

--
-- Indexes for table `surveys_responses`
--
ALTER TABLE `surveys_responses`
  ADD PRIMARY KEY (`localID`);

--
-- Indexes for table `surveys_taken`
--
ALTER TABLE `surveys_taken`
  ADD PRIMARY KEY (`surveyTakenID`);

--
-- Indexes for table `tests_responses`
--
ALTER TABLE `tests_responses`
  ADD PRIMARY KEY (`localID`);

--
-- Indexes for table `tests_taken`
--
ALTER TABLE `tests_taken`
  ADD PRIMARY KEY (`testTakenID`);

--
-- Indexes for table `traits_domains`
--
ALTER TABLE `traits_domains`
  ADD PRIMARY KEY (`domainID`);

--
-- Indexes for table `traits_general`
--
ALTER TABLE `traits_general`
  ADD PRIMARY KEY (`traitID`);

--
-- Indexes for table `traits_ocean`
--
ALTER TABLE `traits_ocean`
  ADD PRIMARY KEY (`localID`);

--
-- Indexes for table `types_general`
--
ALTER TABLE `types_general`
  ADD PRIMARY KEY (`localID`);

--
-- Indexes for table `users_general`
--
ALTER TABLE `users_general`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `versions_general`
--
ALTER TABLE `versions_general`
  ADD PRIMARY KEY (`versionID`);

--
-- Indexes for table `versions_questions`
--
ALTER TABLE `versions_questions`
  ADD PRIMARY KEY (`localID`);

--
-- Indexes for table `votes_traits`
--
ALTER TABLE `votes_traits`
  ADD PRIMARY KEY (`localID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions_general`
--
ALTER TABLE `questions_general`
  MODIFY `questionID` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `surveys_answers`
--
ALTER TABLE `surveys_answers`
  MODIFY `surveyAnswerID` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `surveys_choices`
--
ALTER TABLE `surveys_choices`
  MODIFY `surveyChoiceID` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `surveys_general`
--
ALTER TABLE `surveys_general`
  MODIFY `surveyID` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `surveys_questionanswers`
--
ALTER TABLE `surveys_questionanswers`
  MODIFY `localID` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `surveys_questions`
--
ALTER TABLE `surveys_questions`
  MODIFY `surveyQuestionID` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `surveys_responses`
--
ALTER TABLE `surveys_responses`
  MODIFY `localID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `surveys_taken`
--
ALTER TABLE `surveys_taken`
  MODIFY `surveyTakenID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tests_responses`
--
ALTER TABLE `tests_responses`
  MODIFY `localID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=437;

--
-- AUTO_INCREMENT for table `tests_taken`
--
ALTER TABLE `tests_taken`
  MODIFY `testTakenID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `traits_domains`
--
ALTER TABLE `traits_domains`
  MODIFY `domainID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `traits_general`
--
ALTER TABLE `traits_general`
  MODIFY `traitID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `traits_ocean`
--
ALTER TABLE `traits_ocean`
  MODIFY `localID` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `types_general`
--
ALTER TABLE `types_general`
  MODIFY `localID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT for table `users_general`
--
ALTER TABLE `users_general`
  MODIFY `userID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `versions_general`
--
ALTER TABLE `versions_general`
  MODIFY `versionID` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `versions_questions`
--
ALTER TABLE `versions_questions`
  MODIFY `localID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;

--
-- AUTO_INCREMENT for table `votes_traits`
--
ALTER TABLE `votes_traits`
  MODIFY `localID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
