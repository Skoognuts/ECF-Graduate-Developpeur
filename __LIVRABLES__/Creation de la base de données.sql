-- Création de la base de données
CREATE DATABASE IF NOT EXISTS `ecf_graduate_developpeur_web`;

-- Création de la table User
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Création de la table Administrator
CREATE TABLE IF NOT EXISTS `administrator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id_id` int(11) NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_58DF06519D86650F` (`user_id_id`),
  CONSTRAINT `FK_58DF06519D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Création de la table Partner
CREATE TABLE IF NOT EXISTS `partner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id_id` int(11) NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_312B3E169D86650F` (`user_id_id`),
  CONSTRAINT `FK_312B3E169D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Création de la table Structure
CREATE TABLE IF NOT EXISTS `structure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id_id` int(11) NOT NULL,
  `partner_id_id` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6F0137EA9D86650F` (`user_id_id`),
  KEY `IDX_6F0137EA6C783232` (`partner_id_id`),
  CONSTRAINT `FK_6F0137EA6C783232` FOREIGN KEY (`partner_id_id`) REFERENCES `partner` (`id`),
  CONSTRAINT `FK_6F0137EA9D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Création de la table Grant
CREATE TABLE IF NOT EXISTS `grant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Création de la table UserGrants
CREATE TABLE IF NOT EXISTS `user_grants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id_id` int(11) NOT NULL,
  `grant_id_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1FFDCEB9D86650F` (`user_id_id`),
  KEY `IDX_1FFDCEB323467CC` (`grant_id_id`),
  CONSTRAINT `FK_1FFDCEB323467CC` FOREIGN KEY (`grant_id_id`) REFERENCES `grant` (`id`),
  CONSTRAINT `FK_1FFDCEB9D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Hydratation de la table User
INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
	(1, 'jbombeur@sporty.fr', '["ROLE_ADMIN"]', '$2y$13$7lP1vWKKJkoxSdvZxFYI9enyq9gGYPZS.mRm3Ed/GR09zgPn/G5wq'),
	(2, 'lzatack@sporty.fr', '["ROLE_ADMIN"]', '$2y$13$NxRjg8ABds80nerXEhSHIuiObqyZPU0Us32sCYYtNEU9ZefaudpkG'),
	(3, 'nouillorc@sporty.fr', '["ROLE_PARTNER"]', '$2y$13$ReHv1HUv4gUy0S.7XTwr3.y3.HITGEoOUruNkOCg2.D7stZCxUBTy'),
	(4, 'losse-en-gelaisse@sporty.fr', '["ROLE_PARTNER"]', '$2y$13$jymURSMsJLu0BaHJvzHyn.g1saAPGcHhEBBD7SrNytq2jIwvdC8p2'),
	(5, 'yste-en-boule@sporty.fr', '["ROLE_PARTNER"]', '$2y$10$MPno.Kjty7QubRyrBN9jiOeugWEfingOS.OaGoYYKTWscOzb0Df5a'),
	(6, 'st-gapour@sporty.fr', '["ROLE_PARTNER"]', '$2y$13$CNqYBaZrLuqKxtbDt3kOW./5psv/E0dNilcTXJ7/126oUadwBXHMi'),
	(7, 'quancoune@sporty.fr', '["ROLE_PARTNER"]', '$2y$10$1tGix52ZJ8ud/uAndkT2AOjgGnvri4F0F13h.XcplfBSAF92t5IzG'),
	(8, 'hhogan@sporty.fr', '["ROLE_STRUCTURE"]', '$2y$13$jHoTC8wKiVwaZY4292voJ.ERFZnhuzvxBpOGbc5QjfGJXWyH6mzCC'),
	(9, 'jcena@sporty.fr', '["ROLE_STRUCTURE"]', '$2y$13$tYhNKDUx.F2m76HWF5RGROJ7P2AKpLDDyYH69fRS8BwLepqB89HGq'),
	(10, 'rorton@sporty.fr', '["ROLE_STRUCTURE"]', '$2y$10$dYhkKqAh3dj4T0/gQFdwqu3PTB2mp1puuMf9d2TDHrn/ZiV5LLqMe'),
	(11, 'djohnson@sporty.fr', '["ROLE_STRUCTURE"]', '$2y$10$Lw.19XwpUMwpgPhliH2duOpOO8s1nFUWTEjRKHpN4XqQuW0VmBGby'),
	(12, 'rsavage@sporty.fr', '["ROLE_STRUCTURE"]', '$2y$10$MU65p0EvZSJNgmMtyLkqsuxUHCeJ/tcablrrxouI8IDxLuDlgaBK2'),
	(13, 'rreigns@sporty.fr', '["ROLE_STRUCTURE"]', '$2y$10$SBxhVPQ9faW94KAlwI2zEeCOqoOcElvIUFtVWizm9ZZ0robyHhEUO'),
	(14, 'rmysterio@sporty.fr', '["ROLE_STRUCTURE"]', '$2y$10$9NiZs1/zymfnZpN/./3r7ueoKZv/ToZLV8PtyLSHUi0DMCOmxq9Ae'),
	(15, 'dbautista@sporty.fr', '["ROLE_STRUCTURE"]', '$2y$10$e5HAgTPI7B3VPGS6qkXtCu.uYss5DI/S.VRjjgZR/WnUibV648VxK'),
	(16, 'joinesse-bourg@sporty.fr', '["ROLE_PARTNER"]', '$2y$13$gEhudsIgdTAWx0Ob1lqnw.qCu.QkEhJWL3CDfbU.hl1mCqqN5BOqS'),
	(18, 'blesnar@sporty.fr', '["ROLE_STRUCTURE"]', '$2y$13$rOKab2igpMW7kAjQJXX3bOADEWUUYiiXjFmnBrvy1yZVdcF0MxULO');

-- Hydratation de la table Administrator
INSERT INTO `administrator` (`id`, `user_id_id`, `first_name`, `last_name`) VALUES
	(1, 1, 'Jean', 'BOMBEUR'),
	(2, 2, 'Louis', 'ZATACK');

-- Hydratation de la table Partner
INSERT INTO `partner` (`id`, `user_id_id`, `city`, `is_active`) VALUES
	(1, 3, 'NOUILLORC', 1),
	(2, 4, 'LOSSE-EN-GELAISSE', 1),
	(3, 5, 'YSTE-EN-BOULE', 1),
	(4, 6, 'SAINT-GAPOUR', 0),
	(5, 7, 'QUANCOUNE', 0),
	(6, 16, 'JOINESSE-BOURG', 1);

-- Hydratation de la table Structure
INSERT INTO `structure` (`id`, `user_id_id`, `partner_id_id`, `address`, `phone`, `is_active`) VALUES
	(1, 8, 1, '45 Avenue Braudouay', '555-1978', 1),
	(2, 9, 2, '12 Rue du Parc Griphitte', '555-1254', 1),
	(3, 10, 2, '223 Boulevard Auliwoud', '555-4329', 0),
	(4, 11, 3, '25 Impasse de Galata', '555-4931', 1),
	(5, 12, 4, '640 Avenue Sentosa', '555-9877', 0),
	(6, 13, 4, '1 Rue du Padangue', '555-1212', 0),
	(7, 14, 5, '17 Impasse des Requins Marteau', '555-9632', 0),
	(8, 18, 6, '12 Rue Jean Coqueteau', '555-1930', 1);

-- Hydratation de la table Grant
INSERT INTO `grant` (`id`, `name`) VALUES
	(1, 'Gérer le planning d''équipe'),
	(2, 'Gérer son mailing'),
	(3, 'Promotion de la salle'),
	(4, 'Vendre des boissons'),
	(5, 'Vendre des articles de sport');

-- Hydratation de la table UserGrants
INSERT INTO `user_grants` (`id`, `user_id_id`, `grant_id_id`, `is_active`) VALUES
	(1, 3, 1, 1),
	(2, 3, 2, 1),
	(3, 3, 3, 0),
	(4, 3, 4, 1),
	(5, 3, 5, 0),
	(6, 4, 1, 1),
	(7, 4, 2, 1),
	(8, 4, 3, 0),
	(9, 4, 4, 1),
	(10, 4, 5, 1),
	(11, 5, 1, 0),
	(12, 5, 2, 0),
	(13, 5, 3, 1),
	(14, 5, 4, 1),
	(15, 5, 5, 1),
	(16, 6, 1, 0),
	(17, 6, 2, 1),
	(18, 6, 3, 1),
	(19, 6, 4, 0),
	(20, 6, 5, 1),
	(21, 7, 1, 1),
	(22, 7, 2, 1),
	(23, 7, 3, 1),
	(24, 7, 4, 0),
	(25, 7, 5, 1),
	(26, 8, 1, 1),
	(27, 8, 2, 1),
	(28, 8, 3, 0),
	(29, 8, 4, 1),
	(30, 8, 5, 1),
	(31, 9, 1, 1),
	(32, 9, 2, 1),
	(33, 9, 3, 0),
	(34, 9, 4, 1),
	(35, 9, 5, 1),
	(36, 10, 1, 1),
	(37, 10, 2, 1),
	(38, 10, 3, 1),
	(39, 10, 4, 1),
	(40, 10, 5, 1),
	(41, 11, 1, 0),
	(42, 11, 2, 0),
	(43, 11, 3, 1),
	(44, 11, 4, 1),
	(45, 11, 5, 1),
	(46, 12, 1, 0),
	(47, 12, 2, 1),
	(48, 12, 3, 1),
	(49, 12, 4, 0),
	(50, 12, 5, 1),
	(51, 13, 1, 0),
	(52, 13, 2, 1),
	(53, 13, 3, 1),
	(54, 13, 4, 1),
	(55, 13, 5, 1),
	(56, 14, 1, 1),
	(57, 14, 2, 1),
	(58, 14, 3, 1),
	(59, 14, 4, 0),
	(60, 14, 5, 1),
	(61, 16, 1, 1),
	(62, 16, 2, 1),
	(63, 16, 3, 0),
	(64, 16, 4, 1),
	(65, 16, 5, 0),
	(66, 18, 1, 1),
	(67, 18, 2, 1),
	(68, 18, 3, 0),
	(69, 18, 4, 1),
	(70, 18, 5, 0);