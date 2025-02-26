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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.agreement : ~0 rows (environ)

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.comment : ~0 rows (environ)

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
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.critic : ~3 rows (environ)
INSERT INTO `critic` (`id`, `media`, `summary`, `critic_score`, `length_min`, `date_post`, `origin_date_post`, `piece_id`, `influencer_id`) VALUES
	(16, 'https://www.youtube.com/embed/93o3a6MWgxA?si=pdujXUWJCD-0ejbl', '"I particularly enjoyed this first \ncontact with Dune: Awakening"', 3.5, 19, '2025-02-19 21:09:58', '2025-01-30 00:00:00', 1, 2),
	(17, 'https://www.youtube.com/embed/QJjEP0Nnsa0?si=x5IeomulzXxysW_N', '"I let myself be carried away by the atmosphere and the general intention."', 3, 15, '2025-02-20 14:29:52', '2025-01-30 00:00:00', 1, 12),
	(30, 'https://www.youtube.com/embed/EoeytqKY1-k?si=fLCB3qU0qhzV9ipk', '"Wow, that\'s a dense film!"', 3.5, 11, '2025-02-20 18:39:55', '2025-02-10 00:00:00', 19, 17);

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
  `is_poster` tinyint(1) DEFAULT NULL,
  `piece_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C53D045FC40FCFA8` (`piece_id`),
  CONSTRAINT `FK_C53D045FC40FCFA8` FOREIGN KEY (`piece_id`) REFERENCES `piece` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.image : ~0 rows (environ)

-- Listage de la structure de table sfcritix. influencer
CREATE TABLE IF NOT EXISTS `influencer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nick_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `real_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.influencer : ~3 rows (environ)
INSERT INTO `influencer` (`id`, `nick_name`, `real_name`, `photo`, `bio`) VALUES
	(2, 'ExServ', 'Benoît Reinier', 'influ-ExServ-67b769a27f05d.webp', 'Since 2010, ExServ has been providing \'From Software\' video game guides, tests and news analysis. A former video game journalist, he now works as an independant since 2016 and divides his time between his YouTube channel, the podcast \'Fin du Game\' and writing books for \'Third Editions\'.'),
	(12, 'Carole Quintaine', 'Carole Quintaine', 'influ-Carole-Quintaine-67b769c9dbc25.jpg', 'Carole is a superhero who wears a cape and a bat mask. And she\'s also on YouTube to talk about video games.'),
	(17, 'Clapman', NULL, 'influ-Clapman-67b769e3a92ac.jpg', 'Guillaume, Film/TV Series and Video Games video-maker on Youtube.');

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

-- Listage des données de la table sfcritix.influencer_user : ~0 rows (environ)

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.opinion : ~0 rows (environ)

-- Listage de la structure de table sfcritix. piece
CREATE TABLE IF NOT EXISTS `piece` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `about` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `maker` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `release_date` datetime NOT NULL,
  `category_id` int NOT NULL,
  `is_upcoming` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_44CA0B2312469DE2` (`category_id`),
  CONSTRAINT `FK_44CA0B2312469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.piece : ~2 rows (environ)
INSERT INTO `piece` (`id`, `title`, `about`, `maker`, `release_date`, `category_id`, `is_upcoming`) VALUES
	(1, 'Dune: Awakening', 'Dune: Awakening is a massively multiplayer online game where players must survive in the desert of Arrakis. It takes place in an open world.', 'Funcom', '2025-01-01 00:00:00', 1, 1),
	(19, 'The Brutalist', 'Escaping post-war Europe, visionary architect László Toth arrives in America to rebuild his life, his work, and his marriage to his wife Erzsébet after being forced apart during wartime by shifting borders and regimes. On his own in a strange new country, László settles in Pennsylvania, where an industrialist recognizes his talent for building.', 'Brady Corbet', '2025-02-12 00:00:00', 2, NULL);

-- Listage de la structure de table sfcritix. social
CREATE TABLE IF NOT EXISTS `social` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `influencer_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7161E1874AF97FA6` (`influencer_id`),
  CONSTRAINT `FK_7161E1874AF97FA6` FOREIGN KEY (`influencer_id`) REFERENCES `influencer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.social : ~0 rows (environ)

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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.user : ~0 rows (environ)
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `nick_name`, `profile_picture`, `status`, `bio`, `account_date`, `is_verified`) VALUES
	(16, 'test@exemple.com', '[]', '$2y$13$3JP6RlXMQmt5AxpcVxfHlesXj0Fq30ev.cd2rO/jDUBbBatZEaI0G', 'Xylo', NULL, NULL, NULL, '2025-02-26 08:50:05', 0),
	(22, 'test2@exemple.com', '[]', '$2y$13$E./O8UnL966b82Gt5qVPz.yjxLDPjJSw88YDhUwBJDWsFD4Dq7h2W', 'Xylo2', NULL, NULL, NULL, '2025-02-26 09:56:42', 0),
	(23, 'test3@exemple.com', '[]', '$2y$13$MafLiGCuJ6WFSKfgEACf..xe8utnWuGAC.gh0ZKvovHP6Oc./kp/2', 'Xylo3', NULL, NULL, NULL, '2025-02-26 09:57:29', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfcritix.video : ~0 rows (environ)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
