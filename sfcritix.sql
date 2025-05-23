-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour sfcritix
CREATE DATABASE IF NOT EXISTS `sfcritix` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sfcritix`;

-- Listage de la structure de table sfcritix. agreement
CREATE TABLE IF NOT EXISTS `agreement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `is_ok` tinyint(1) DEFAULT NULL,
  `critic_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2E655A24C7BE2830` (`critic_id`),
  KEY `IDX_2E655A24A76ED395` (`user_id`),
  CONSTRAINT `FK_2E655A24A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_2E655A24C7BE2830` FOREIGN KEY (`critic_id`) REFERENCES `critic` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.agreement : ~5 rows (environ)
INSERT INTO `agreement` (`id`, `is_ok`, `critic_id`, `user_id`) VALUES
	(154, 0, 17, 36),
	(155, 0, 44, 36),
	(159, 0, 49, 36),
	(161, 1, 45, 35),
	(162, 0, 44, 35),
	(163, 0, 51, 36),
	(164, 0, 45, 36);

-- Listage de la structure de table sfcritix. category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.category : ~6 rows (environ)
INSERT INTO `category` (`id`, `name`) VALUES
	(1, 'Games'),
	(2, 'Movies'),
	(3, 'TV Shows'),
	(4, 'Music'),
	(5, 'Books'),
	(6, 'Mangas/Comics');

-- Listage de la structure de table sfcritix. comment
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `text` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_post` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_vip` tinyint(1) DEFAULT NULL,
  `critic_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526CC7BE2830` (`critic_id`),
  KEY `IDX_9474526CA76ED395` (`user_id`),
  CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_9474526CC7BE2830` FOREIGN KEY (`critic_id`) REFERENCES `critic` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.comment : ~9 rows (environ)
INSERT INTO `comment` (`id`, `text`, `date_post`, `is_vip`, `critic_id`, `user_id`) VALUES
	(31, 'Hello', '2025-04-16 11:07:27', NULL, 45, 36),
	(32, 'Ça va ?', '2025-04-16 11:07:41', 0, 45, 36),
	(33, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2025-04-16 11:08:20', 1, 45, 36),
	(35, 'Test', '2025-04-16 18:28:57', 0, 45, 35),
	(46, 'OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO', '2025-04-22 15:07:05', NULL, 44, 36),
	(48, 'Eh ben moi, j\'ai pas du tout aimé !!!!!', '2025-04-23 20:16:02', 1, 49, 36),
	(49, 'Eh toc !', '2025-04-23 20:16:21', NULL, 49, 36),
	(50, 'OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO', '2025-04-24 08:33:07', 0, 45, 36),
	(51, 'Test', '2025-04-24 21:01:49', NULL, 45, 35);

-- Listage de la structure de table sfcritix. critic
CREATE TABLE IF NOT EXISTS `critic` (
  `id` int NOT NULL AUTO_INCREMENT,
  `media` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `critic_score` double NOT NULL DEFAULT '0',
  `length_min` int NOT NULL DEFAULT '0',
  `date_post` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `origin_date_post` datetime NOT NULL,
  `piece_id` int NOT NULL,
  `influencer_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C9E2F7F1C40FCFA8` (`piece_id`),
  KEY `IDX_C9E2F7F14AF97FA6` (`influencer_id`),
  CONSTRAINT `FK_C9E2F7F14AF97FA6` FOREIGN KEY (`influencer_id`) REFERENCES `influencer` (`id`),
  CONSTRAINT `FK_C9E2F7F1C40FCFA8` FOREIGN KEY (`piece_id`) REFERENCES `piece` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.critic : ~24 rows (environ)
INSERT INTO `critic` (`id`, `media`, `summary`, `critic_score`, `length_min`, `date_post`, `origin_date_post`, `piece_id`, `influencer_id`) VALUES
	(16, '93o3a6MWgxA', '"I particularly enjoyed this first \r\ncontact with Dune: Awakening."', 4, 19, '2025-02-19 21:09:58', '2025-01-30 00:00:00', 1, 2),
	(17, 'QJjEP0Nnsa0', '"I let myself be carried away by the atmosphere and the general intention."', 3, 15, '2025-02-20 14:29:52', '2025-01-30 00:00:00', 1, 12),
	(30, 'EoeytqKY1-k', '"Wow, that\'s a dense film!"', 3, 11, '2025-02-20 18:39:55', '2025-02-10 00:00:00', 19, 17),
	(39, 'gHQE7tULx6c', '"I loved this project, and i thought it was a great experience."', 4, 27, '2025-03-02 12:54:47', '2022-05-17 00:00:00', 62, 41),
	(40, '-wZeUJDkAO0', '"I enjoyed the Pinocchio theme more than i expected. I love this game."', 4, 48, '2025-04-02 10:25:20', '2023-12-04 00:00:00', 63, 42),
	(41, '8yjGImX96ZM', '"I really enjoyed the game, it\'s my Game of the Year for sure."', 4, 9, '2025-04-02 11:22:53', '2023-12-10 00:00:00', 63, 43),
	(42, 'klX7i7YL8-I', '"Despite all its faults, the game is still a huge hit."', 3, 17, '2025-04-02 12:11:27', '2023-10-01 00:00:00', 63, 44),
	(43, 'EvRZDXYMpSc', '"As imperfect as it may be, the game has a real beating heart."', 3, 10, '2025-04-02 12:27:35', '2023-09-30 00:00:00', 63, 45),
	(44, 'NFKAupy3SgQ', '"I really enjoyed the game, but at times, it made me feel like i did not."', 3, 19, '2025-04-02 14:20:52', '2025-02-24 00:00:00', 64, 46),
	(45, 'KtcFzvhvPo4', '"The foundations of the game are solid, and it will gradually emerge from the ground."', 3, 30, '2025-04-02 14:25:57', '2025-02-28 00:00:00', 64, 2),
	(46, 'NkN25Qpls6Q', '"It\'s better for certain films to be imaginary than material."', 2, 12, '2025-04-02 18:39:22', '2018-05-25 00:00:00', 65, 47),
	(47, 'ebKicNLR8fQ', '"I think we\'ve missed out on an exceptional film."', 2, 13, '2025-04-02 19:09:10', '2025-02-16 00:00:00', 19, 48),
	(48, 'IztXNqasmQ0', '"I loved The Brutalist, I think it\'s a great film."', 4, 27, '2025-04-02 19:30:21', '2025-02-09 00:00:00', 19, 49),
	(49, 'jEAGyROITQI', '"To sum it up : we needed this."', 4, 10, '2025-04-02 20:30:28', '2025-03-08 00:00:00', 66, 50),
	(50, 'CzhjiQW6H4E', '"A story that many people will find hard to like."', 2, 9, '2025-04-02 20:40:31', '2025-03-04 00:00:00', 66, 17),
	(51, 'rKIDIg-VaUA', '"An interesting work in every aspect, even if the director is capable of much better."', 3, 17, '2025-04-02 21:05:47', '2025-03-06 00:00:00', 66, 51),
	(53, 'RRTvIdB8Qkg', '"This album flawed me : this is one of the greatest this year, no doubt."', 4, 11, '2025-04-03 20:31:24', '2016-09-13 00:00:00', 69, 53),
	(54, '4OPV_np5Zks', '"This album is the perfect combination of what Kendrick has made so far."', 4, 18, '2025-04-03 20:47:59', '2022-05-18 00:00:00', 62, 54),
	(55, 'V9345rBzdWQ', '"I can\'t imagine a piece that fulfill its mission quite like this."', 5, 13, '2025-04-03 21:20:35', '2016-09-15 00:00:00', 69, 56),
	(56, 'Vz2YokGxlT4', '"I was really impressed with this record : it is beautifully sad."', 4, 9, '2025-04-03 21:26:04', '2016-09-19 00:00:00', 69, 41),
	(57, '0F9p_d7Pfxg', '"It is pretty mediocre, but there are a few good songs."', 3, 9, '2025-04-03 21:55:37', '2017-08-29 00:00:00', 70, 57),
	(58, 'QMNvNt5HKng', '"A very good story, you can feel the author\'s experience behind the lines."', 4, 16, '2025-04-06 11:39:51', '2021-09-29 00:00:00', 71, 58),
	(59, 'LZMIYP-Iu4g', '"It\'s a great book. The book contains some very important messages."', 4, 7, '2025-04-06 12:21:47', '2016-06-22 00:00:00', 72, 59),
	(60, 'DQlmjGioECM', '"I enjoyed every page of this novel."', 5, 10, '2025-04-06 12:56:07', '2018-10-21 00:00:00', 73, 60);

-- Listage de la structure de table sfcritix. critic_user
CREATE TABLE IF NOT EXISTS `critic_user` (
  `critic_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`critic_id`,`user_id`),
  KEY `IDX_E0D9968C7BE2830` (`critic_id`),
  KEY `IDX_E0D9968A76ED395` (`user_id`),
  CONSTRAINT `FK_E0D9968A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_E0D9968C7BE2830` FOREIGN KEY (`critic_id`) REFERENCES `critic` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.critic_user : ~0 rows (environ)

-- Listage de la structure de table sfcritix. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table sfcritix.doctrine_migration_versions : ~0 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20250218150339', '2025-02-18 16:03:49', 274);

-- Listage de la structure de table sfcritix. image
CREATE TABLE IF NOT EXISTS `image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `piece_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C53D045FC40FCFA8` (`piece_id`),
  CONSTRAINT `FK_C53D045FC40FCFA8` FOREIGN KEY (`piece_id`) REFERENCES `piece` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.image : ~0 rows (environ)

-- Listage de la structure de table sfcritix. influencer
CREATE TABLE IF NOT EXISTS `influencer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nick_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `real_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.influencer : ~21 rows (environ)
INSERT INTO `influencer` (`id`, `nick_name`, `real_name`, `photo`, `bio`) VALUES
	(2, 'ExServ', 'Benoît Reinier', 'influ-ExServ-67b769a27f05d.webp', 'Since 2010, ExServ has been providing \'From Software\' video game guides, tests and news analysis. A former video game journalist, he now works as an independant since 2016 and divides his time between his YouTube channel, the podcast \'Fin du Game\' and writing books for \'Third Editions\'.'),
	(12, 'Carole Quintaine', 'Carole Quintaine', 'influ-Carole-Quintaine-67b769c9dbc25.jpg', 'Carole is a superhero who wears a cape and a bat mask. And she\'s also on YouTube to talk about video games.'),
	(17, 'Clapman', NULL, 'influ-Clapman-67b769e3a92ac.jpg', 'Guillaume, Film/TV Series and Video Games video-maker on Youtube.'),
	(41, 'theneedledrop', 'Anthony Fantano', 'influ-Anthony-Fantano-67ed9caf1cdc2.jpg', '"The Internet\'s busiest music nerd."'),
	(42, 'Joseph Anderson', NULL, NULL, 'In-depth video game reviews and critiques, with a sharp focus on gameplay and narrative where applicable.'),
	(43, 'IamYunie', NULL, 'influ-iAmYunie-67eda517dd8d9.jpg', 'Lead UX/UI Designer | Content Creator | Passionate about video games.'),
	(44, 'Loudic', NULL, 'influ-Loudic-67ed0ab2d4200.png', '"Touch the withered arm and travel to the Realm of Shadow, i will not be far behind."'),
	(45, 'Playmoo', NULL, NULL, '"Helping hands on Souls-Like and reviews!"'),
	(46, 'ACG  / Angry Centaur Gaming', 'Jeremy Penter', NULL, '"I buy every game I review."'),
	(47, 'Le Fossoyeur de Films', 'François Theurel', 'influ-LeFossoyeurDeFilms-67eeaf96981bf.jpg', '"Le Fossoyeur" likes to explore the mysteries of cinema and enjoy a good cup of coffee along the way.'),
	(48, 'Merej', NULL, 'influ-Merej-67eeafb278fa9.jpg', '"The film-loving neighbour."'),
	(49, 'Regelegorila', NULL, 'influ-Regelegorila-67eda8115faf6.jpg', 'Youtuber with a passion for cinema and TV series.'),
	(50, 'Karsten Runquist', NULL, 'influ-KarstenRunquist-67eda6de0a79e.jpg', '"Talking about the movies • Los Angeles"'),
	(51, 'Captain Popcorn', NULL, 'influ-CaptainPopCorn-67eda41575c9d.jpg', 'Captain Popcorn is a channel of reviews, theories, analyses and opinions on films and series.'),
	(53, 'deep cuts', 'Oliver Kemp', 'influ-OliverKemp-67eed26a48f84.jpg', 'A channel dedicated to music, for lovers of music! Discussions on genres, guides to band discographies and commenting on the  ever-changing landscape of modern music.'),
	(54, 'Volksgeist', 'Philip D’amico', 'influ-Volksgeist-67eed68633209.jpg', '"I’m Philip and this is volksgeist. I’m here to share my love of music and talk about all the ways music can change the world."'),
	(56, 'Spectrum Pulse', 'Mark Grondin', 'influ-SpectrumPulse-67eede4998478.webp', '"Where we talk about music, movies, art, and culture."'),
	(57, 'Lie Likes Music', 'Christian Haug Lie', 'influ-LieLikesMusic-67eee67c69618.jpg', '"Fretboard flyer mentor - Oslo, Norway"'),
	(58, 'Canal Franzo', NULL, 'influ-CanalFranzo-67f24aee2f790.jpg', 'My name is Franzo, and I\'m a writer published by self-publishing houses.'),
	(59, 'Margaud Liseuse', 'Margaud Quartenoud', 'influ-MargaudQuartenoud-67f254936b13a.jpg', 'Margaud talks mainly about books, and everything that revolves around this universe. There\'s something for everyone. She chats in the comments and it\'s always a nice, relaxing moment.'),
	(60, 'PeruseProject', NULL, 'influ-PeruseProject-67f25c510203f.jpg', '"I am Regan I like to talk about books."');

-- Listage de la structure de table sfcritix. influencer_user
CREATE TABLE IF NOT EXISTS `influencer_user` (
  `influencer_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`influencer_id`,`user_id`),
  KEY `IDX_DC19FDE44AF97FA6` (`influencer_id`),
  KEY `IDX_DC19FDE4A76ED395` (`user_id`),
  CONSTRAINT `FK_DC19FDE44AF97FA6` FOREIGN KEY (`influencer_id`) REFERENCES `influencer` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_DC19FDE4A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.influencer_user : ~1 rows (environ)
INSERT INTO `influencer_user` (`influencer_id`, `user_id`) VALUES
	(12, 36),
	(51, 36);

-- Listage de la structure de table sfcritix. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table sfcritix. opinion
CREATE TABLE IF NOT EXISTS `opinion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_score` double DEFAULT NULL,
  `piece_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AB02B027C40FCFA8` (`piece_id`),
  KEY `IDX_AB02B027A76ED395` (`user_id`),
  CONSTRAINT `FK_AB02B027A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_AB02B027C40FCFA8` FOREIGN KEY (`piece_id`) REFERENCES `piece` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.opinion : ~4 rows (environ)
INSERT INTO `opinion` (`id`, `user_score`, `piece_id`, `user_id`) VALUES
	(79, 3, 64, 35),
	(83, 4, 70, 36),
	(91, 2, 66, 36),
	(92, 4, 64, 36);

-- Listage de la structure de table sfcritix. piece
CREATE TABLE IF NOT EXISTS `piece` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `about` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `maker` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `release_date` datetime NOT NULL,
  `category_id` int NOT NULL,
  `is_upcoming` tinyint(1) DEFAULT NULL,
  `poster` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_44CA0B2312469DE2` (`category_id`),
  CONSTRAINT `FK_44CA0B2312469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.piece : ~12 rows (environ)
INSERT INTO `piece` (`id`, `title`, `about`, `maker`, `release_date`, `category_id`, `is_upcoming`, `poster`) VALUES
	(1, 'Dune: Awakening', 'Dune: Awakening is a massively multiplayer online game where players must survive in the desert of Arrakis. It takes place in an open world.', 'Funcom', '2025-01-01 00:00:00', 1, 1, 'games-DuneA-poster-67c0af2463993.png'),
	(19, 'The Brutalist', 'Escaping post-war Europe, visionary architect László Toth arrives in America to rebuild his life, his work, and his marriage to his wife Erzsébet after being forced apart during wartime by shifting borders and regimes. On his own in a strange new country, László settles in Pennsylvania, where an industrialist recognizes his talent for building.', 'Brady Corbet', '2025-02-12 00:00:00', 2, 0, 'movies-TheBrutalist-67edabfff0677.jpg'),
	(62, 'Mr. Morale & The Big Steppers', 'Mr. Morale & the Big Steppers is a concept album that analyzes and reflects on his life experiences during his therapy journey. Its lyrics touch on a variety of personal themes, including childhood and generational trauma, infidelity, and celebrity worship.', 'Kendrick Lamar', '2022-05-13 00:00:00', 4, 0, 'music-Mr-Morale-and-TheBigSteppers-poster-67c1da00466e2.jpg'),
	(63, 'Lies of P', 'Lies of P is a thrilling soulslike that takes the story of Pinocchio, turns it on its head, and sets it against the darkly elegant backdrop of the Belle Epoque era.', 'Neowiz', '2023-09-18 00:00:00', 1, 0, 'games-LiesOfP-poster-67ed99c1ef49d.avif'),
	(64, 'Monster Hunter Wilds', 'As with other Monster Hunter games, Wilds has the player control a hunter that is part of a guild assigned to explore the Forbidden Lands, a nearly uninhabitable area with multiple biomes and dangerous storms. During their exploration, the hunters are assigned quests to fight large monsters that threaten their group, either by killing or capturing them.', 'Capcom', '2025-02-28 00:00:00', 1, 0, 'games-MHWilds-poster-67ed9b46a88b9.jpg'),
	(65, 'The Man Who Killed Don Quixote', 'Toby Grummett, a director, is in rural Spain, struggling with the production of a commercial featuring Don Quixote. After an unsuccessful day of shooting, Toby\'s superior, the Boss, introduces him to a Romani street merchant who sells him an old DVD of The Man Who Killed Don Quixote, a film he wrote and directed ten years earlier as a student.', 'Terry Gilliam', '2018-05-19 00:00:00', 2, 0, 'movies-TheManWhoKilledDonQuixote-poster-67eda28b9f4b0.jpg'),
	(66, 'Mickey 17', 'In the year 2054, Mickey Barnes and his friend Timo join a spaceship crew heading to colonize the ice-planet Niflheim, in order to escape a murderous loan shark.', 'Bong Joon Ho', '2025-02-13 00:00:00', 2, 0, 'movies-Mickey17-poster-67eda19756f56.jpg'),
	(69, 'Skeleton Tree', 'Skeleton Tree is the sixteenth studio album by Australian rock band Nick Cave and the Bad Seeds. Skeleton Tree\'s minimal production and "less polished" sound incorporates elements of electronica and ambient music and, like Push the Sky Away, features extensive use of synthesizers, drum machines and loops.', 'Nick Cave & the Bad Seeds', '2016-09-09 00:00:00', 4, 0, 'music-Skeleton-Tree-67eecc6d559ea.jpg'),
	(70, 'Villains', 'Villains is the seventh studio album by American rock band Queens of the Stone Age. The album was announced with a teaser trailer taking the form of a comedy skit featuring the band performing a polygraph test with Liam Lynch.', 'Queens of the Stone Age', '2017-08-25 00:00:00', 4, 0, 'music-Villains-67eee4c95e5b4.jpg'),
	(71, 'Les impatientes', 'Three women, three stories, three linked destinies. This polyphonic novel traces the fate of young Ramla, who is torn from her love to be married to Safira\'s husband, while Hindou, her sister, is forced to marry her cousin.', 'Djaïli Amadou Amal', '2020-09-04 00:00:00', 5, 0, 'books-LesImpatientes-67f249862398f.jpg'),
	(72, 'Le coeur des louves', 'Célia and her mother, a successful writer with a writer\'s block, return to live in their grandmother\'s house, dead for years, in the heart of a village lost in the mountains. Their return is resented by some, as if it revives old buried stories.', 'Stéphane Servant', '2013-08-17 00:00:00', 5, 0, 'books-LeCoeurDesLouves-67f2520937230.jpg'),
	(73, 'Warbreaker', 'Warbreaker tells the story of two Idrian princesses, Vivenna and Siri. Vivenna was contracted through a treaty written before she was born to marry the God King of rival nation Hallandren. However, King Dedelin sends his other daughter Siri to meet the treaty instead.', 'Brandon Sanderson', '2016-06-09 00:00:00', 5, 0, 'books-Warbreaker-67f2571169c75.jpg');

-- Listage de la structure de table sfcritix. reset_password_request
CREATE TABLE IF NOT EXISTS `reset_password_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `selector` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`),
  CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.reset_password_request : ~0 rows (environ)

-- Listage de la structure de table sfcritix. social
CREATE TABLE IF NOT EXISTS `social` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `influencer_id` int NOT NULL,
  `channel_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `live_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7161E1874AF97FA6` (`influencer_id`),
  CONSTRAINT `FK_7161E1874AF97FA6` FOREIGN KEY (`influencer_id`) REFERENCES `influencer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.social : ~43 rows (environ)
INSERT INTO `social` (`id`, `name`, `sub_number`, `link`, `influencer_id`, `channel_id`, `live_id`) VALUES
	(4, 'YouTube', '200k', 'https://www.youtube.com/@ExServ85', 2, 'UC2FAM-zL-PhH0OkIT95aWJQ', NULL),
	(5, 'Bluesky', '9.4k', 'https://bsky.app/profile/exserv.bsky.social', 2, NULL, NULL),
	(6, 'YouTube', '229k', 'https://www.youtube.com/@CaroleQuintaine', 12, 'UC6yhX3lGeSSRlHycI3rfDqQ', NULL),
	(7, 'Instagram', '57k', 'https://www.instagram.com/carolequintaine/', 12, NULL, NULL),
	(8, 'Twitch', '42k', 'https://www.twitch.tv/quintainecarole', 12, NULL, 'quintainecarole'),
	(9, 'YouTube', '105k', 'https://www.youtube.com/@CLAPMAN', 17, 'UCz0yrDEjbd68clSkcWbYXwA', NULL),
	(10, 'Instagram', '12k', 'https://www.instagram.com/clapman_yt/', 17, NULL, NULL),
	(12, 'YouTube', '2.98M', 'https://www.youtube.com/@theneedledrop', 41, 'UCt7fwAhXDy3oNFTAzF2o8Pw', NULL),
	(13, 'Instagram', '1.1M', 'https://www.instagram.com/afantano/', 41, NULL, NULL),
	(14, 'Twitch', '430k', 'https://www.twitch.tv/theneedledrop/', 41, NULL, 'theneedledrop'),
	(15, 'YouTube', '754k', 'https://www.youtube.com/@JosephAndersonChannel', 42, 'UCyhnYIvIKK_--PiJXCMKxQQ', NULL),
	(16, 'Twitch', '130.1k', 'https://www.twitch.tv/andersonjph', 42, NULL, 'andersonjph'),
	(17, 'YouTube', '18k', 'https://www.youtube.com/@IamYunie', 43, 'UC3jdvI5ltyDmgiCaqHVqIZg', NULL),
	(18, 'YouTube', '49.2k', 'https://www.youtube.com/@Loudic', 44, 'UCHl2H4ZU36ElTCf3hV4YnJg', NULL),
	(19, 'Twitch', '3k', 'https://www.twitch.tv/loudicTV', 44, NULL, 'loudicTV'),
	(21, 'YouTube', '66,6k', 'https://www.youtube.com/@Playmoo', 45, 'UCymjJG9eSFYtnLe1QE4mORw', NULL),
	(22, 'YouTube', '1.21M', 'https://www.youtube.com/@ACGreviews', 46, 'UCK9_x1DImhU-eolIay5rb2Q', NULL),
	(23, 'YouTube', '800k', 'https://www.youtube.com/@deadwattsofficiel', 47, 'UCwbV8cTR4yBgFdfa_BXV2OA', NULL),
	(24, 'Facebook', '87k', 'https://www.facebook.com/LeFossoyeurDeFilms', 47, NULL, NULL),
	(25, 'YouTube', '38k', 'https://www.youtube.com/@merej6401', 48, 'UCIuXzWHPFizzsGs2IS3Sf8g', NULL),
	(26, 'YouTube', '241k', 'https://www.youtube.com/@Regelegorila', 49, 'UCouHAi3jWpC8lAqsoeM_zOA', NULL),
	(27, 'Twitch', '11.6k', 'https://www.twitch.tv/regelegorila', 49, NULL, 'regelegorila'),
	(28, 'Bluesky', '1.7k', 'https://bsky.app/profile/regelegorila.bsky.social', 49, NULL, NULL),
	(29, 'Instagram', '39.2k', 'https://www.instagram.com/regelegorila/', 49, NULL, NULL),
	(30, 'YouTube', '724k', 'https://www.youtube.com/@KarstenRunquist', 50, 'UCS85PXHRkizrbGHBCe4tV3g', NULL),
	(31, 'Instagram', '29k', 'https://www.instagram.com/karstenrunquist', 50, NULL, NULL),
	(32, 'YouTube', '518k', 'https://www.youtube.com/@CaptainPopcorn', 51, 'UCZeyUZmGAyRLDfM2ir3q-OQ', NULL),
	(33, 'Instagram', '13.5k', 'https://www.instagram.com/le_captain_popcorn/', 51, NULL, NULL),
	(34, 'Facebook', '12k', 'https://www.facebook.com/CaptainSylvain/', 51, NULL, NULL),
	(38, 'YouTube', '192k', 'https://www.youtube.com/@deepcuts', 53, 'UCRYhCg0DHloE9gn-PAiAYNg', NULL),
	(39, 'Instagram', '6220', 'https://www.instagram.com/oliverjkemp/', 53, NULL, NULL),
	(40, 'YouTube', '499k', 'https://www.youtube.com/@Volksgeist', 54, 'UCikpumVCosztN-ZUthleRug', NULL),
	(41, 'Instagram', '6300', 'https://www.instagram.com/volks.geist/', 54, NULL, NULL),
	(43, 'YouTube', '46.6k', 'https://www.youtube.com/@SpectrumPulse', 56, NULL, NULL),
	(44, 'Instagram', '2270', 'https://www.instagram.com/spectrumpulse', 56, NULL, NULL),
	(45, 'YouTube', '323k', 'https://www.youtube.com/@LieLikesMusic', 57, 'UCgIlmfJhLLBwTYvL4r-2hhg', NULL),
	(46, 'Instagram', '2230', 'https://www.instagram.com/christianhlie/', 57, NULL, NULL),
	(47, 'YouTube', '2.4k', 'https://www.youtube.com/@canalfranzo', 58, 'UCvCOAuSXP_9VoTUmJkASgpg', NULL),
	(48, 'Instagram', '2670', 'https://www.instagram.com/canal_franzo', 58, NULL, NULL),
	(49, 'YouTube', '74.6k', 'https://www.youtube.com/@MargaudLiseuse', 59, 'UCP2X3cVGXP0r56gOGhiRDlA', NULL),
	(50, 'Instagram', '34.1k', 'https://www.instagram.com/margaudliseuse/', 59, NULL, NULL),
	(51, 'YouTube', '385k', 'https://www.youtube.com/@PeruseProject', 60, 'UCy6Qlkv2hif7KPtmMmNUGUw', NULL),
	(52, 'Instagram', '220k', 'https://www.instagram.com/peruseproject', 60, NULL, NULL);

-- Listage de la structure de table sfcritix. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nick_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `account_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  UNIQUE KEY `UNIQ_8D93D649A045A5E9` (`nick_name`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.user : ~3 rows (environ)
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `nick_name`, `profile_picture`, `status`, `bio`, `account_date`, `is_verified`) VALUES
	(35, 'our@exemple.com', '[]', '$2y$13$Xt4Q1F4qrjamc1NT8P7DYeMJSkd06a.CS5kRT7aFNJ/agrCpXlOk6', 'Our', 'Onizuka-grimace-67ce0177cce60.webp', 'Les "Infiltrés" ont tout copié sur "Infernal Affairs"', '"Si tu veux m\'parler envoie moi un...FAX !!"', '2025-03-09 21:54:50', 0),
	(36, 'sparkster@exemple.com', '["ROLE_MODO"]', '$2y$13$JLkesG6lVl2qcDnSjJ0FPOVkIcMWzGDvlmDa2XdCoRgNj4oXSpRZi', 'Sparkster', 'Sparkster-67d090a1a590d.jpg', 'isOk', 'Renard à Jet-Pack.\r\nTous les matins je vois Joe Hallenbeck dans le miroir.', '2025-03-11 20:33:05', 0),
	(41, 'xylo@exemple.com', '["ROLE_ADMIN"]', '$2y$13$qkJGstRg.qngODX1qTT1wuK2EEiHqKtCwylh0ZtwE7imLaRy32Dry', 'Xylo', NULL, NULL, NULL, '2025-04-10 19:50:30', 0);

-- Listage de la structure de table sfcritix. user_piece
CREATE TABLE IF NOT EXISTS `user_piece` (
  `user_id` int NOT NULL,
  `piece_id` int NOT NULL,
  PRIMARY KEY (`user_id`,`piece_id`),
  KEY `IDX_A608F07BA76ED395` (`user_id`),
  KEY `IDX_A608F07BC40FCFA8` (`piece_id`),
  CONSTRAINT `FK_A608F07BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_A608F07BC40FCFA8` FOREIGN KEY (`piece_id`) REFERENCES `piece` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.user_piece : ~2 rows (environ)
INSERT INTO `user_piece` (`user_id`, `piece_id`) VALUES
	(36, 64);

-- Listage de la structure de table sfcritix. video
CREATE TABLE IF NOT EXISTS `video` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_trailer` tinyint(1) DEFAULT NULL,
  `piece_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7CC7DA2CC40FCFA8` (`piece_id`),
  CONSTRAINT `FK_7CC7DA2CC40FCFA8` FOREIGN KEY (`piece_id`) REFERENCES `piece` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.video : ~7 rows (environ)
INSERT INTO `video` (`id`, `title`, `link`, `is_trailer`, `piece_id`) VALUES
	(6, 'Dune: Awakening - Official Arrakis Trailer', 'r8lxVDqoHLQ?', 1, 1),
	(7, 'The Brutalist | Official Trailer HD | A24', 'GdRXPAHIEW4', 1, 19),
	(11, 'Lies of P - Official Launch Trailer', 'kXZoKdr-xeo', 1, 63),
	(12, 'Monster Hunter Wilds - Launch Trailer', 'a_wNFT4j6qI', 1, 64),
	(13, 'THE MAN WHO KILLED DON QUIXOTE Official Trailer', 'yiiRZJUTT2k', 1, 65),
	(14, 'Mickey 17 | Official Trailer', 'osYpGSz_0i4', 1, 66),
	(16, 'Skeleton Tree (Official Audio)', 'O7tfTBtpR0E', 1, 69);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
