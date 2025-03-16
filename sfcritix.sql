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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.agreement : ~1 rows (environ)
INSERT INTO `agreement` (`id`, `is_ok`, `critic_id`, `user_id`) VALUES
	(35, 1, 17, 36);

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
	(3, 'TV Series'),
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.comment : ~3 rows (environ)
INSERT INTO `comment` (`id`, `text`, `date_post`, `is_vip`, `critic_id`, `user_id`) VALUES
	(1, 'Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test', '2025-03-09 19:02:18', NULL, 16, 16),
	(2, 'Je ne suis pas du tout d\'accord avec toi ExServ...', '2025-03-10 20:31:02', 0, 16, 35),
	(3, 'Bande de caves...', '2025-03-10 20:39:02', 1, 16, 34);

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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.critic : ~4 rows (environ)
INSERT INTO `critic` (`id`, `media`, `summary`, `critic_score`, `length_min`, `date_post`, `origin_date_post`, `piece_id`, `influencer_id`) VALUES
	(16, 'https://www.youtube.com/embed/93o3a6MWgxA?si=pdujXUWJCD-0ejbl', '"I particularly enjoyed this first \r\ncontact with Dune: Awakening"', 4, 19, '2025-02-19 21:09:58', '2025-01-30 00:00:00', 1, 2),
	(17, 'https://www.youtube.com/embed/QJjEP0Nnsa0?si=x5IeomulzXxysW_N', '"I let myself be carried away by the atmosphere and the general intention."', 3, 15, '2025-02-20 14:29:52', '2025-01-30 00:00:00', 1, 12),
	(30, 'https://www.youtube.com/embed/EoeytqKY1-k?si=fLCB3qU0qhzV9ipk', '"Wow, that\'s a dense film!"', 3, 11, '2025-02-20 18:39:55', '2025-02-10 00:00:00', 19, 17),
	(39, 'https://www.youtube.com/embed/gHQE7tULx6c?si=9IoukxOyNtJ77JZF', '"I loved this project, and i thought it was a great experience"', 4, 27, '2025-03-02 12:54:47', '2022-05-17 00:00:00', 62, 41);

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

-- Listage des données de la table sfcritix.doctrine_migration_versions : ~1 rows (environ)
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
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.influencer : ~4 rows (environ)
INSERT INTO `influencer` (`id`, `nick_name`, `real_name`, `photo`, `bio`) VALUES
	(2, 'ExServ', 'Benoît Reinier', 'influ-ExServ-67b769a27f05d.webp', 'Since 2010, ExServ has been providing \'From Software\' video game guides, tests and news analysis. A former video game journalist, he now works as an independant since 2016 and divides his time between his YouTube channel, the podcast \'Fin du Game\' and writing books for \'Third Editions\'.'),
	(12, 'Carole Quintaine', 'Carole Quintaine', 'influ-Carole-Quintaine-67b769c9dbc25.jpg', 'Carole is a superhero who wears a cape and a bat mask. And she\'s also on YouTube to talk about video games.'),
	(17, 'Clapman', NULL, 'influ-Clapman-67b769e3a92ac.jpg', 'Guillaume, Film/TV Series and Video Games video-maker on Youtube.'),
	(41, 'theneedledrop', 'Anthony Fantano', 'influ-Anthony-Fantano-67c441ed2fcf8.png', 'The Internet\'s busiest music nerd.');

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

-- Listage des données de la table sfcritix.influencer_user : ~6 rows (environ)
INSERT INTO `influencer_user` (`influencer_id`, `user_id`) VALUES
	(2, 16),
	(2, 34),
	(2, 35),
	(12, 16),
	(12, 34),
	(12, 36);

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
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.opinion : ~4 rows (environ)
INSERT INTO `opinion` (`id`, `user_score`, `piece_id`, `user_id`) VALUES
	(47, 4, 19, 16),
	(48, 3, 19, 35),
	(51, 5, 1, 34),
	(53, 4, 1, 36);

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
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.piece : ~3 rows (environ)
INSERT INTO `piece` (`id`, `title`, `about`, `maker`, `release_date`, `category_id`, `is_upcoming`, `poster`) VALUES
	(1, 'Dune: Awakening', 'Dune: Awakening is a massively multiplayer online game where players must survive in the desert of Arrakis. It takes place in an open world.', 'Funcom', '2025-01-01 00:00:00', 1, 1, 'games-DuneA-poster-67c0af2463993.png'),
	(19, 'The Brutalist', 'Escaping post-war Europe, visionary architect László Toth arrives in America to rebuild his life, his work, and his marriage to his wife Erzsébet after being forced apart during wartime by shifting borders and regimes. On his own in a strange new country, László settles in Pennsylvania, where an industrialist recognizes his talent for building.', 'Brady Corbet', '2025-02-12 00:00:00', 2, 0, 'movies-TheBrutalist-poster-67c1b34cc833b.jpg'),
	(62, 'Mr. Morale & The Big Steppers', 'Mr. Morale & the Big Steppers is a concept album that analyzes and reflects on his life experiences during his therapy journey. Its lyrics touch on a variety of personal themes, including childhood and generational trauma, infidelity, and celebrity worship.', 'Kendrick Lamar', '2022-05-13 00:00:00', 4, 0, 'music-Mr-Morale-and-TheBigSteppers-poster-67c1da00466e2.jpg');

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.social : ~11 rows (environ)
INSERT INTO `social` (`id`, `name`, `sub_number`, `link`, `influencer_id`, `channel_id`, `live_id`) VALUES
	(4, 'YouTube', '200k', 'https://www.youtube.com/@ExServ85', 2, 'UC2FAM-zL-PhH0OkIT95aWJQ', NULL),
	(5, 'Bluesky', '9.4k', 'https://bsky.app/profile/exserv.bsky.social', 2, NULL, NULL),
	(6, 'YouTube', '229k', 'https://www.youtube.com/@CaroleQuintaine', 12, 'UC6yhX3lGeSSRlHycI3rfDqQ', NULL),
	(7, 'Instagram', '57k', 'https://www.instagram.com/carolequintaine/', 12, NULL, NULL),
	(8, 'Twitch', '42k', 'https://www.twitch.tv/quintainecarole', 12, NULL, 'quintainecarole'),
	(9, 'YouTube', '105k', 'https://www.youtube.com/@CLAPMAN', 17, 'UCz0yrDEjbd68clSkcWbYXwA', NULL),
	(10, 'Instagram', '12k', 'https://www.instagram.com/clapman_yt/', 17, NULL, NULL),
	(11, 'Twitch', '2k', 'https://www.twitch.tv/clapman_yt', 17, NULL, 'clapman_yt'),
	(12, 'YouTube', '2.98M', 'https://www.youtube.com/@theneedledrop', 41, 'UCt7fwAhXDy3oNFTAzF2o8Pw', NULL),
	(13, 'Instagram', '1.1M', 'https://www.instagram.com/afantano/', 41, NULL, NULL),
	(14, 'Twitch', '430k', 'https://www.twitch.tv/theneedledrop/', 41, NULL, 'theneedledrop');

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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.user : ~4 rows (environ)
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `nick_name`, `profile_picture`, `status`, `bio`, `account_date`, `is_verified`) VALUES
	(16, 'test@exemple.com', '[]', '$2y$13$3JP6RlXMQmt5AxpcVxfHlesXj0Fq30ev.cd2rO/jDUBbBatZEaI0G', 'Test', '', 'Test2', 'Test3', '2025-02-26 08:50:05', 0),
	(34, 'titi@exemple.com', '[]', '$2y$13$gfEN2hZtNCH3N7NxxHsktebrha3JhyW/3V7AAJsrU55KWctPxw14W', 'Toto', 'Sosie-67c085e9c7ef4.png', 'Barbecue + Partie de football', 'Sosie officiel de Robert de Niro dans Heat', '2025-02-27 14:15:15', 0),
	(35, 'our@exemple.com', '[]', '$2y$13$Xt4Q1F4qrjamc1NT8P7DYeMJSkd06a.CS5kRT7aFNJ/agrCpXlOk6', 'Our', 'Onizuka-grimace-67ce0177cce60.webp', 'Les "Infiltrés" ont tout copié sur "Infernal Affairs"', '"Si tu veux m\'parler envoie moi un...FAX !!"', '2025-03-09 21:54:50', 0),
	(36, 'sparkster@exemple.com', '["ROLE_MODO"]', '$2y$13$JLkesG6lVl2qcDnSjJ0FPOVkIcMWzGDvlmDa2XdCoRgNj4oXSpRZi', 'Sparkster', 'Sparkster-67d090a1a590d.jpg', 'Parti manger', 'Survivant', '2025-03-11 20:33:05', 0);

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

-- Listage des données de la table sfcritix.user_piece : ~5 rows (environ)
INSERT INTO `user_piece` (`user_id`, `piece_id`) VALUES
	(16, 1),
	(16, 19),
	(34, 1),
	(34, 19),
	(35, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.video : ~2 rows (environ)
INSERT INTO `video` (`id`, `title`, `link`, `is_trailer`, `piece_id`) VALUES
	(6, 'Dune: Awakening - Official Arrakis Trailer', 'https://www.youtube.com/embed/r8lxVDqoHLQ?si=uXlAQDGgLB8umpGr', 1, 1),
	(7, 'The Brutalist | Official Trailer HD | A24', 'https://www.youtube.com/embed/GdRXPAHIEW4?si=IZotUvlcBCqftzTd', 1, 19);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
