-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-09-2022 a las 13:18:48
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `carddatabase`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cards`
--

CREATE TABLE `cards` (
  `id_cardBD` int(11) NOT NULL,
  `id_card` varchar(255) NOT NULL,
  `card_name` varchar(255) DEFAULT NULL,
  `user_id` int(5) NOT NULL,
  `qty` int(5) NOT NULL,
  `card_info` varchar(255) NOT NULL,
  `color_identity` varchar(50) NOT NULL DEFAULT '{}',
  `updateDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cards`
--

INSERT INTO `cards` (`id_cardBD`, `id_card`, `card_name`, `user_id`, `qty`, `card_info`, `color_identity`, `updateDate`) VALUES
(1, '0f279560-7e9f-4a6d-9fd6-6c8c6bd94a1b', 'Wear // Tear', 0, 2, '', ' R,W,', '2022-04-22 00:00:00'),
(3, '12fadf25-0995-440d-a3e6-7964ed86cff6', 'Liquify', 0, 1, '', ' U,', '2022-04-14 00:00:00'),
(4, '212f9fbc-ebb9-474a-b3c4-cbde8e69af77', 'Bloodstained Mire', 0, 2, '', '', '2022-04-14 00:00:00'),
(5, '27740ea5-79c8-420f-bc49-6d5eac58dac5', 'Lightning Bolt', 0, 3, 'Foil', 'R,', '2022-04-14 00:00:00'),
(6, '634dd3bd-d29b-4481-990b-f320e60c4f91', 'Lifetap', 0, 2, '', ',U', '2022-06-14 00:00:00'),
(7, '6fb94c1b-8002-4d79-add0-c4dfef9019ee', 'Lightning Bolt', 29, 1, '', ' R,', '2022-04-25 00:00:00'),
(8, 'ac8cd7a1-3f79-405b-8930-2206f32c2035', 'Boros Charm', 0, 2, '', 'R,W,', '2022-08-09 00:00:00'),
(9, 'ae5f9fb1-5a55-4db3-98a1-2628e3598c18', 'Lightning Bolt', 0, 3, '', ' R,', '2022-04-25 00:00:00'),
(10, 'd95e8b57-e355-42c8-9db1-98c4f53387d0', 'Thoughtseize', 0, 3, '', 'B,', '2022-08-04 00:00:00'),
(12, 'ff204024-20a5-4bb9-82b6-f6b4337efd60', 'Lightning Bolt', 0, 4, 'Mamayemosa', 'R,', '2022-04-14 00:00:00'),
(13, 'ae5f9fb1-5a55-4db3-98a1-2628e3598c18', 'Lightning Bolt', 29, 2, '', ' R,', '2022-04-25 00:00:00'),
(14, 'b3a69a1c-c80f-4413-a6fd-ae54cabbce28', 'Black Lotus', 0, 2, '', '', '2022-08-09 00:00:00'),
(15, '8da3eeb2-c3bb-44dc-bbfe-a8178b86d3e1', 'Searing Blood', 0, 2, 'Foil', 'R,', '2022-08-09 00:00:00'),
(16, '4fc5577f-7eb6-4f7e-b5c1-91f9c498cc91', 'Arclight Phoenix', 0, 5, '', 'R,', '2022-08-09 10:29:12'),
(22, 'b0faa7f2-b547-42c4-a810-839da50dadfe', 'Black Lotus', 0, 1, '', '', '2022-08-16 11:47:24'),
(24, '6fb94c1b-8002-4d79-add0-c4dfef9019ee', 'Lightning Bolt', 0, 4, 'Album 2', 'R,', '2022-08-23 20:55:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `decks`
--

CREATE TABLE `decks` (
  `id_deck` int(25) NOT NULL,
  `user_id` int(5) UNSIGNED NOT NULL,
  `name` varchar(25) NOT NULL,
  `format` varchar(15) NOT NULL,
  `colors` varchar(255) NOT NULL,
  `deck_img` varchar(255) NOT NULL,
  `cards` longtext NOT NULL DEFAULT '{}',
  `sideboard` longtext DEFAULT '{}',
  `totalPrice` float NOT NULL,
  `updatedDate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `private` tinyint(1) NOT NULL DEFAULT 0,
  `priceTix` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `decks`
--

INSERT INTO `decks` (`id_deck`, `user_id`, `name`, `format`, `colors`, `deck_img`, `cards`, `sideboard`, `totalPrice`, `updatedDate`, `private`, `priceTix`) VALUES
(32, 0, 'Selesnya Aggro', 'Standard', '', 'https://c1.scryfall.com/file/scryfall-cards/art_crop/front/2/4/24e58478-c6a8-4f86-854a-a489c99bd777.jpg?1631046407', '{\"Usher of the Fallen\":\"4\",\"Hopeful Initiate\":\"4\",\"Thalia, Guardian of Thraben\":\"3\",\"Intrepid Adversary\":\"3\",\"Luminarch Aspirant\":\"4\",\"Eiganjo, Seat of the Empire\":\"2\",\"Adeline, Resplendent Cathar\":\"2\",\"The Wandering Emperor\":\"3\",\"Legion Angel\":\"4\",\"Reidane, God of the Worthy\":\"2\",\"Cave of the Frost Dragon\":\"3\",\"Crawling Barrens\":\"3\",\"Valorous Stance\":\"3\",\"Elite Spellbinder\":\"4\",\"Portable Hole\":\"4\",\"Skyclave Apparition\":\"4\",\"\":\"1\",\"Guardian of Faith\":\"3\",\"Brutal Cathar\":\"3\",\"March of Otherworldly Light\":\"1\"}', '{}', 88.71, '2022-03-28 00:00:00', 1, 0),
(41, 0, 'jfgjgfjf', 'Standard', '[\"B\"]', 'https://c1.scryfall.com/file/scryfall-cards/art_crop/front/6/e/6e9d8fe4-fd9b-4923-92bf-7dd6b8fa02e7.jpg?1598304715', '{\"Fatal Push\":\"4\"}', '[]', 6.72, '2022-03-29 00:00:00', 0, 4.16),
(47, 41, 'asdsada', 'Standard', '[\"G\",\"W\"]', 'https://c1.scryfall.com/file/scryfall-cards/art_crop/front/c/3/c375a022-5b57-496d-a802-e4ea8376e9e4.jpg?1654568932', '{\"Eiganjo, Seat of the Empire\":\"1\",\"Boseiju, Who Endures\":\"1\",\"Branchloft Pathway\":\"4\",\"Tangled Florahedron\":\"2\",\"Plains\":\"6\",\"Forest\":\"3\",\"Lair of the Hydra\":\"1\",\"Overgrown Farmland\":\"4\",\"Emeria\'s Call\":\"3\",\"Cave of the Frost Dragon\":\"1\",\"Starnheim Unleashed\":\"3\",\"Luminarch Aspirant\":\"4\",\"Prosperous Innkeeper\":\"4\",\"Welcoming Vampire\":\"4\",\"Wedding Announcement\":\"4\",\"Skyclave Apparition\":\"4\",\"Legion Angel\":\"1\",\"Yasharn, Implacable Earth\":\"2\",\"Esika\'s Chariot\":\"4\",\"The Wandering Emperor\":\"4\"}', '{\"Legion Angel\":\"3\",\"Circle of Confinement\":\"4\",\"Valorous Stance\":\"4\",\"Guardian of Faith\":\"3\",\"Yasharn, Implacable Earth\":\"1\"}', 321.77, '2022-08-11 13:17:58', 0, 393.08),
(54, 0, 'PRUEBA REDIREC', 'Historic', '[\"B\",\"R\"]', 'https://c1.scryfall.com/file/scryfall-cards/art_crop/front/6/e/6e9d8fe4-fd9b-4923-92bf-7dd6b8fa02e7.jpg?1598304715', '{\"Fatal Push\":\"4\"}', '{\"Lightning Bolt\":\"4\"}', 11.52, '2022-08-10 12:57:33', 1, 7),
(57, 0, 'PRUEBA COLORS', 'Pioneer', '[\"G\"]', 'https://c1.scryfall.com/file/scryfall-cards/art_crop/front/a/3/a390a7df-b8da-41aa-93e5-2c0db938a27e.jpg?1637630879', '{\"Avacyn\'s Pilgrim\":\"1\"}', '[]', 0.18, '2022-08-11 13:14:29', 1, 0),
(58, 0, 'asdsada', 'Standard', '[\"G\",\"W\"]', 'https://c1.scryfall.com/file/scryfall-cards/art_crop/front/c/3/c375a022-5b57-496d-a802-e4ea8376e9e4.jpg?1654568932', '{\"Eiganjo, Seat of the Empire\":\"1\",\"Boseiju, Who Endures\":\"1\",\"Branchloft Pathway\":\"4\",\"Tangled Florahedron\":\"2\",\"Plains\":\"6\",\"Forest\":\"3\",\"Lair of the Hydra\":\"1\",\"Overgrown Farmland\":\"4\",\"Emeria\'s Call\":\"3\",\"Cave of the Frost Dragon\":\"1\",\"Starnheim Unleashed\":\"3\",\"Luminarch Aspirant\":\"4\",\"Prosperous Innkeeper\":\"4\",\"Welcoming Vampire\":\"4\",\"Wedding Announcement\":\"4\",\"Skyclave Apparition\":\"4\",\"Legion Angel\":\"1\",\"Yasharn, Implacable Earth\":\"2\",\"Esika\'s Chariot\":\"4\",\"The Wandering Emperor\":\"4\"}', '{\"Legion Angel\":\"3\",\"Circle of Confinement\":\"4\",\"Valorous Stance\":\"4\",\"Guardian of Faith\":\"3\",\"Yasharn, Implacable Earth\":\"1\"}', 321.77, '2022-08-11 13:25:12', 0, 393.08),
(60, 0, 'Yorion BG', 'Modern', '[\"G\",\"U\",\"W\",\"R\"]', 'https://c1.scryfall.com/file/scryfall-cards/art_crop/front/1/a/1a05b2f6-a6b3-4e30-904b-0dc85d124ef8.jpg?1631587722', '{\"Abundant Growth\":\"4\",\"Boseiju, Who Endures\":\"1\",\"Breeding Pool\":\"1\",\"Counterspell\":\"4\",\"Eladamri\'s Call\":\"1\",\"Endurance\":\"2\",\"Ephemerate\":\"2\",\"Eternal Witness\":\"2\",\"Expressive Iteration\":\"4\",\"Flooded Strand\":\"4\",\"Fury\":\"1\",\"Hallowed Fountain\":\"1\",\"Ice-Fang Coatl\":\"4\",\"Ketria Triome\":\"1\",\"Lightning Bolt\":\"3\",\"March of Otherworldly Light\":\"2\",\"Misty Rainforest\":\"4\",\"Omnath, Locus of Creation\":\"4\",\"Otawara, Soaring City\":\"1\",\"Prismatic Ending\":\"4\",\"Raugrin Triome\":\"1\",\"Sacred Foundry\":\"1\",\"Snow-Covered Forest\":\"2\",\"Snow-Covered Island\":\"1\",\"Snow-Covered Plains\":\"1\",\"Sokenzan, Crucible of Defiance\":\"1\",\"Solitude\":\"4\",\"Steam Vents\":\"1\",\"Stomping Ground\":\"1\",\"Teferi, Time Raveler\":\"4\",\"Temple Garden\":\"1\",\"Windswept Heath\":\"4\",\"Wooded Foothills\":\"3\",\"Wrenn and Six\":\"4\",\"Dress Down\":\"1\"}', '{\"Chalice of the Void\":\"3\",\"Emrakul, the Promised End\":\"1\",\"Endurance\":\"2\",\"Flusterstorm\":\"2\",\"Force of Vigor\":\"2\",\"Supreme Verdict\":\"2\",\"Veil of Summer\":\"1\",\"Yorion, Sky Nomad\":\"1\",\"Dress Down\":\"1\"}', 1738.98, '2022-08-12 11:32:26', 0, 1412.51);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `games`
--

CREATE TABLE `games` (
  `game_id` int(11) NOT NULL,
  `game_num` int(5) DEFAULT NULL,
  `game_info` varchar(50) DEFAULT NULL,
  `game_result` varchar(50) DEFAULT NULL,
  `round_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `games`
--

INSERT INTO `games` (`game_id`, `game_num`, `game_info`, `game_result`, `round_id`) VALUES
(4, 1, 'Good Pairing, 4 Deflecting Palm', 'win', 6),
(5, 1, '4 Kor in and 4 eidolon out.', 'win', 7),
(6, 1, '4 Kor in and 4 eidolon out.', 'lose', 7),
(7, 1, 'Mamayemaso', 'win', 8),
(8, 2, 'Good Pairing, 4 Deflecting Palm', 'win', 8),
(9, 1, 'Bad pairing rhinos omg', 'win', 9),
(10, 2, 'Mamayemaso', 'win', 9),
(35, 1, 'asdsadsada', 'win', 0),
(36, 1, 'asfafasf', 'win', 0),
(39, 1, 'Mami', 'win', 13),
(40, 2, 'asdadsad', 'win', 0),
(41, 2, 'asdsadasdasdasd', 'win', 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id_notification` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `trigger_user_id` int(11) NOT NULL,
  `id_publication` int(11) NOT NULL,
  `notification_type` varchar(50) DEFAULT NULL,
  `already_read` tinyint(1) NOT NULL DEFAULT 0,
  `notification_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `notifications`
--

INSERT INTO `notifications` (`id_notification`, `user_id`, `trigger_user_id`, `id_publication`, `notification_type`, `already_read`, `notification_date`) VALUES
(20, 0, 0, 70, 'notification_like', 0, '2022-08-04 10:38:32'),
(21, 0, 0, 70, 'notification_like', 0, '2022-08-04 10:39:49'),
(22, 0, 40, 0, 'notification_followed', 0, '2022-08-04 10:41:00'),
(23, 0, 40, 70, 'notification_like', 0, '2022-08-04 10:41:13'),
(24, 0, 40, 70, 'notification_like', 0, '2022-08-04 10:43:57'),
(25, 0, 0, 83, 'notification_like', 0, '2022-08-31 11:53:43'),
(26, 40, 0, 10, 'notification_like', 0, '2022-09-01 10:25:37'),
(27, 40, 0, 10, 'notification_commented', 0, '2022-09-01 10:26:11'),
(28, 40, 0, 10, 'notification_like', 0, '2022-09-01 10:33:46'),
(29, 40, 0, 10, 'notification_like', 0, '2022-09-01 10:54:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publications`
--

CREATE TABLE `publications` (
  `id_publication` int(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  `publication_message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publication_img` varchar(255) NOT NULL,
  `publication_deck` int(255) NOT NULL,
  `publication_card` int(255) NOT NULL,
  `publication_date` datetime NOT NULL DEFAULT sysdate(),
  `publication_likes` text NOT NULL DEFAULT '{}'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `publications`
--

INSERT INTO `publications` (`id_publication`, `id_user`, `publication_message`, `publication_img`, `publication_deck`, `publication_card`, `publication_date`, `publication_likes`) VALUES
(10, 40, 'Prueba', 'none', 58, 0, '2022-07-18 11:43:38', '{\"1\":43,\"2\":\"42\",\"3\":\"0\"}'),
(23, 0, 'Ayuda', 'a84885ca-bd01-4216-b888-7aed95fcc6d6.png', 0, 0, '2022-07-19 08:58:55', '{}'),
(25, 0, 'asdad', 'none', 0, 0, '2022-07-19 09:10:53', '{}'),
(26, 0, 'asd', '73282ce5-06f7-46e4-8b9f-4cf75ef0a9f5.png', 0, 0, '2022-07-19 09:24:42', '{}'),
(28, 0, 'asd', 'none', 0, 0, '2022-07-19 09:46:04', '{}'),
(29, 0, 'asd', 'fd05b837-afd6-4df9-8f5c-5cbeed7e37c4.jpeg', 0, 0, '2022-07-25 09:08:03', '{}'),
(58, 0, 'asd', 'none', 0, 0, '2022-07-27 09:38:39', '{}'),
(59, 0, 'sadsad', 'none', 0, 0, '2022-07-27 09:39:13', '{}'),
(60, 0, 'asd', '0e2a4d16-c25b-4125-89df-6de8634d3223.jpeg', 0, 0, '2022-07-27 10:04:20', '[]'),
(61, 43, 'asd', 'none', 0, 0, '2022-07-27 10:04:25', '{\"1\":\"0\"}'),
(83, 0, 'Prueba Deck🍎', 'none', 58, 0, '2022-08-16 21:01:13', '{\"1\":43,\"2\":\"0\"}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publications_comments`
--

CREATE TABLE `publications_comments` (
  `id_comment` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `comment_message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_date` datetime NOT NULL DEFAULT current_timestamp(),
  `id_publication` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `publications_comments`
--

INSERT INTO `publications_comments` (`id_comment`, `id_user`, `comment_message`, `comment_date`, `id_publication`) VALUES
(33, 42, 'hol', '2022-08-07 10:05:33', 61),
(34, 42, 'asdsadas', '2022-08-07 10:11:47', 61),
(40, 0, 'asdsa', '2022-08-08 10:28:02', 60),
(41, 0, 'Prueba', '2022-08-08 10:28:07', 60),
(42, 0, '😊😊', '2022-08-08 10:30:25', 60),
(43, 0, 'Prueba', '2022-08-31 11:53:00', 83),
(44, 0, '😘Buen deck!', '2022-09-01 10:26:10', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reports`
--

CREATE TABLE `reports` (
  `id_report` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `reported_user_id` int(11) NOT NULL,
  `report_type` varchar(255) NOT NULL,
  `reported_publication` int(11) NOT NULL,
  `reported_deck` int(11) NOT NULL,
  `resolved` tinyint(1) NOT NULL DEFAULT 0,
  `report_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `reports`
--

INSERT INTO `reports` (`id_report`, `id_user`, `reported_user_id`, `report_type`, `reported_publication`, `reported_deck`, `resolved`, `report_date`) VALUES
(1, 1, 1, 'report_publication', 70, 0, 1, '2022-08-05 10:50:39'),
(2, 0, 40, 'report_user', 0, 0, 1, '2022-08-05 11:33:36'),
(4, 0, 0, 'report_publication', 78, 0, 1, '2022-08-05 11:43:52'),
(5, 0, 0, 'report_publication', 77, 0, 1, '2022-08-05 11:46:14'),
(6, 0, 1, 'report_user', 0, 0, 1, '2022-08-05 12:30:42'),
(7, 0, 1, 'report_user', 0, 0, 1, '2022-08-05 12:34:06'),
(9, 0, 41, 'report_user', 0, 0, 1, '2022-08-05 12:46:49'),
(10, 0, 41, 'report_user', 0, 0, 1, '2022-08-05 12:47:51'),
(11, 0, 0, 'report_publication', 61, 0, 0, '2022-08-07 09:52:04'),
(12, 0, 0, 'report_publication', 60, 0, 1, '2022-08-07 09:52:54'),
(13, 0, 0, 'report_publication', 56, 0, 0, '2022-08-07 09:53:40'),
(14, 0, 0, 'report_publication', 60, 0, 0, '2022-08-08 10:31:11'),
(15, 0, 0, 'report_deck', 0, 0, 0, '2022-08-29 13:29:05'),
(16, 0, 0, 'report_deck', 0, 57, 0, '2022-08-29 14:05:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rounds`
--

CREATE TABLE `rounds` (
  `round_id` int(11) NOT NULL,
  `games_status` varchar(50) NOT NULL DEFAULT '0',
  `opponent_deck` varchar(50) NOT NULL DEFAULT '0',
  `tournament_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rounds`
--

INSERT INTO `rounds` (`round_id`, `games_status`, `opponent_deck`, `tournament_id`) VALUES
(6, 'win', 'Tron', 9),
(7, 'win', 'Burn', 9),
(8, '2-0-0', 'Mamayemaso', 11),
(9, '2-0-0', 'Chalbelcher', 11),
(13, '2-0-0', 'Mami', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournaments`
--

CREATE TABLE `tournaments` (
  `id_tournament` int(11) UNSIGNED NOT NULL,
  `id_user` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `description` varchar(255) NOT NULL,
  `ubication` varchar(255) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  `tournament_price` float NOT NULL,
  `start_date` datetime NOT NULL DEFAULT current_timestamp(),
  `format` varchar(50) NOT NULL DEFAULT '----',
  `prices` text NOT NULL DEFAULT '{}',
  `players` text NOT NULL DEFAULT '{}',
  `max_players` int(11) NOT NULL,
  `updatedDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tournaments`
--

INSERT INTO `tournaments` (`id_tournament`, `id_user`, `name`, `description`, `ubication`, `image`, `tournament_price`, `start_date`, `format`, `prices`, `players`, `max_players`, `updatedDate`) VALUES
(13, 0, 'Prueba Tournament', '', 'Factoria del Joc', '0b098c0d-cd8b-4977-9fd9-2b437e78c3b2.jpeg', 5, '2022-08-18 11:30:54', 'Historic', '\'{}\'', '{}', 15, '2022-08-18 12:24:00'),
(14, 0, 'Prueba Tournament', '', 'Factoria del Joc', 'caaa3574-fad9-400c-85d8-10027480fea6.jpeg', 5, '2022-08-20 11:32:00', 'Pioneer', '{}', '{}', 15, '2022-08-18 12:24:00'),
(15, 0, 'OPEN FRIDAY NIGHT', '', 'Factoria del Joc', '', 15, '2022-08-19 14:35:00', 'Pioneer', '{}', '{}', 5, '2022-08-18 12:24:00'),
(16, 0, 'Prueba Tournament', '', 'Factoria del Joc', '', 5, '2022-08-20 11:41:00', 'Modern', '{}', '{}', 15, '2022-08-18 12:24:00'),
(17, 0, 'Prueba Edit', '', 'Icarus Jocs', '8129d12a-1f5d-4064-bb29-1b8f1ea5c7f0.jpeg', 35, '2022-08-21 11:43:00', 'Alcehmy', '{}', '{}', 6, '2022-08-18 12:24:00'),
(18, 0, 'Prueba Tournament', '', 'Factoria del Joc', 'b3a2467b-e10c-47ab-b763-e40f0202885e.jpeg', 5, '2022-08-20 11:22:00', 'Pioneer', '{}', '{}', 5, '2022-08-19 11:18:36'),
(19, 0, 'asdsadsa', '', 'asd', '0330af68-3d64-486d-a899-caf2fa4c55ee.jpeg', 5, '2022-08-21 11:25:00', 'Pioneer', '{}', '{}', 25, '2022-08-19 11:30:15'),
(20, 0, 'asd', '', 'Factoria del Joc', '', 5, '2022-08-14 13:17:00', 'Standard', '{}', '{}', 5, '2022-08-19 13:18:43'),
(21, 0, 'asd', '', 'asd', '', 5, '2022-08-21 13:18:00', 'Pioneer', '{\"1\":{\"1\":{\"id\":\"b9203f23-8c7a-47e1-b359-5a326722d1c0\",\"type\":\"card\",\"name\":\"Black Lotus (PRM)\",\"qty\":\"1\"},\"2\":{\"id\":\"\",\"type\":\"text\",\"name\":\"Caja de Sobres Modern Horizons\",\"qty\":\"1\"}},\"2\":{\"1\":{\"id\":\"27740ea5-79c8-420f-bc49-6d5eac58dac5\",\"type\":\"card\",\"name\":\"Lightning Bolt (SLD)\",\"qty\":\"2\",\"foil\":\"on\"},\"2\":{\"id\":\"8d96bc2b-2e31-4654-b192-c3f023d9fde6\",\"type\":\"card\",\"name\":\"Akroan Jailer (ORI)\",\"qty\":\"1\",\"foil\":\"on\"}}}', '{}', 5, '2022-08-19 13:18:56'),
(22, 0, 'Clasificatorio Sofia', 'Just an another tournament for Sofia 2022.', 'Doctor Ocio', '', 30, '2022-08-27 10:00:00', 'Modern', '{\"1\":{\"1\":{\"id\":\"b9203f23-8c7a-47e1-b359-5a326722d1c0\",\"type\":\"card\",\"name\":\"Black Lotus (PRM)\",\"qty\":\"1\"},\"2\":{\"id\":\"\",\"type\":\"text\",\"name\":\"Caja de Sobres Modern Horizons\",\"qty\":\"1\"}},\"2\":{\"1\":{\"id\":\"27740ea5-79c8-420f-bc49-6d5eac58dac5\",\"type\":\"card\",\"name\":\"Lightning Bolt (SLD)\",\"qty\":\"2\",\"foil\":\"on\"},\"2\":{\"id\":\"8d96bc2b-2e31-4654-b192-c3f023d9fde6\",\"type\":\"card\",\"name\":\"Akroan Jailer (ORI)\",\"qty\":\"1\",\"foil\":\"on\"}},\"3\":{\"1\":{\"id\":\"2b8285b7-bd88-4a6c-bd2e-9798a1c661f8\",\"type\":\"card\",\"name\":\"Mox Jet (OVNT)\",\"qty\":\"2\"}}}', '[\"1\",\"0\"]', 180, '2022-08-22 12:05:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `biography` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Your biography',
  `website` varchar(255) NOT NULL,
  `shop` int(1) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `admin` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `settings` varchar(255) NOT NULL DEFAULT '{}',
  `fechaCaptura` date NOT NULL DEFAULT current_timestamp(),
  `verified` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `verify_code` varchar(36) NOT NULL,
  `google_id` varchar(50) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT 'cards/assets/img/default_profile.png',
  `profile_cover` varchar(255) NOT NULL,
  `followers` text NOT NULL DEFAULT '{}',
  `followed` text NOT NULL DEFAULT '{}',
  `cardmarket_link` varchar(255) NOT NULL,
  `blocked_users` text NOT NULL DEFAULT '{}',
  `twitter` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `discord` varchar(255) NOT NULL,
  `ubication` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `username`, `biography`, `website`, `shop`, `name`, `email`, `password`, `admin`, `settings`, `fechaCaptura`, `verified`, `verify_code`, `google_id`, `profile_image`, `profile_cover`, `followers`, `followed`, `cardmarket_link`, `blocked_users`, `twitter`, `instagram`, `discord`, `ubication`) VALUES
(0, 'alexmadrigal', '😒Your biographysadasdsadas', 'https://www.google.es', 1, 'Alex Madrigal', 'alex25005.lleida@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 1, '{\"darkMode\": true}', '2022-04-13', 0, '1', NULL, 'cards/uploads/747ad776-b36c-4e0c-b0a0-3474ffd9fdcf.png', 'cards/uploads/ad2505c7-2adf-4fce-a841-a2c94f91f25a.png', '{}', '{\"1\":\"41\",\"2\":\"40\",\"3\":\"78\"}', 'https://cardmarket.com', '{\"1\":\"1\",\"2\":\"42\"}', 'alex25005', 'alexxmadrigal_', 'SrAlex#6969', 'Corregidor Escofet, 81. Lleida, España'),
(40, 'alex25005pro', 'Your biography', '', 0, 'Seasoned Pyromancer', 'alex.madrigal.alriols25005@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 0, '{}', '2022-07-27', 0, 'a9a7e428-fcc1-4f08-8b0a-f65276a3cff1', NULL, 'cards/assets/img/default_profile.png', '', '{}', '{\"1\":\"0\"}', '', '{}', '', '', '', ''),
(41, 'alex', 'Your biography', '', 0, 'AlexMad', 'alex@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 0, '{}', '2022-07-29', 0, 'cc109922-32f4-4478-9e4e-452ff623552b', NULL, 'cards/assets/img/default_profile.png', '', '{}', '{\"1\":\"0\"}', '', '{}', '', '', '', ''),
(42, 'chawiart', 'Your biography', '', 0, 'Chawi', 'chawi@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 0, '{}', '2022-07-29', 0, '45fecfcb-b095-41ca-9df2-c7b835a87d9d', NULL, 'cards/assets/img/default_profile.png', '', '{}', '[]', '', '{}', '', '', '', ''),
(43, 'mamapinga', 'Your biography', '', 0, 'Mamapinga', 'mamapinga@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 0, '{}', '2022-07-29', 0, '6382577e-edf6-42b5-b72e-916edf254680', NULL, 'cards/assets/img/default_profile.png', '', '{}', '{}', '', '{}', '', '', '', ''),
(48, 'Alex25005', 'Your biography', '', 0, 'Alex Madrigal', 'alex25005yt.lleida@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 0, '{}', '2022-08-17', 0, '63057111-ef72-49ec-9552-eb81e6ea1428', NULL, 'cards/assets/img/default_profile.png', '', '{}', '{}', '', '{}', '', '', '', ''),
(58, 'alexxmadrigal_', 'Your biography', '', 0, 'Pendelhaven', 'alex.madrigal.lleida@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 0, '{}', '2022-08-17', 0, 'ee86d2b2-9685-4581-90db-408c514ca5ab', NULL, 'cards/assets/img/default_profile.png', '', '{}', '{}', '', '{}', '', '', '', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id_cardBD`) USING BTREE,
  ADD KEY `user` (`user_id`);

--
-- Indices de la tabla `decks`
--
ALTER TABLE `decks`
  ADD PRIMARY KEY (`id_deck`);

--
-- Indices de la tabla `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`game_id`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id_notification`);

--
-- Indices de la tabla `publications`
--
ALTER TABLE `publications`
  ADD PRIMARY KEY (`id_publication`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `publications_comments`
--
ALTER TABLE `publications_comments`
  ADD PRIMARY KEY (`id_comment`);

--
-- Indices de la tabla `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id_report`);

--
-- Indices de la tabla `rounds`
--
ALTER TABLE `rounds`
  ADD PRIMARY KEY (`round_id`);

--
-- Indices de la tabla `tournaments`
--
ALTER TABLE `tournaments`
  ADD PRIMARY KEY (`id_tournament`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `verifiy_code` (`verify_code`) USING BTREE,
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cards`
--
ALTER TABLE `cards`
  MODIFY `id_cardBD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `decks`
--
ALTER TABLE `decks`
  MODIFY `id_deck` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `games`
--
ALTER TABLE `games`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id_notification` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `publications`
--
ALTER TABLE `publications`
  MODIFY `id_publication` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de la tabla `publications_comments`
--
ALTER TABLE `publications_comments`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `reports`
--
ALTER TABLE `reports`
  MODIFY `id_report` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `rounds`
--
ALTER TABLE `rounds`
  MODIFY `round_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tournaments`
--
ALTER TABLE `tournaments`
  MODIFY `id_tournament` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
