-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 18 mars 2025 à 23:09
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ppe_orderbyyou`
--

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(7, 9, 27, 8, '2025-02-27 15:38:36'),
(8, 9, 28, 1, '2025-02-27 15:39:17'),
(9, 9, 25, 1, '2025-02-27 15:39:19'),
(19, 10, 25, 1, '2025-02-27 22:29:30'),
(20, 10, 12, 1, '2025-02-27 22:29:33'),
(21, 10, 17, 1, '2025-02-27 22:29:35'),
(22, 10, 20, 1, '2025-02-27 22:29:37'),
(23, 10, 32, 1, '2025-02-27 22:29:39'),
(24, 10, 35, 1, '2025-02-27 22:29:41'),
(48, 6, 13, 1, '2025-03-15 01:41:11'),
(55, 13, 12, 1, '2025-03-19 00:08:47');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('En attente','Payé','Expédié','Annulé') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'En attente',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_orders_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `created_at`) VALUES
(7, 8, 1329.00, 'Expédié', '2025-03-11 14:06:57'),
(8, 8, 3790.00, 'Payé', '2025-03-11 15:01:30'),
(9, 8, 3501.99, 'En attente', '2025-03-11 15:28:40'),
(11, 6, 2597.98, 'En attente', '2025-03-14 17:48:29'),
(12, 21, 2024.99, 'En attente', '2025-03-15 16:12:29'),
(13, 13, 1329.00, 'En attente', '2025-03-16 12:30:59');

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_items_order` (`order_id`),
  KEY `fk_order_items_product` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 7, 12, 1, 1329.00),
(2, 8, 12, 1, 1329.00),
(3, 8, 13, 1, 950.00),
(4, 8, 14, 1, 824.00),
(5, 8, 15, 1, 687.00),
(6, 9, 12, 1, 1329.00),
(7, 9, 13, 1, 950.00),
(8, 9, 27, 1, 1222.99),
(10, 11, 36, 1, 525.00),
(11, 11, 28, 1, 849.99),
(12, 11, 27, 1, 1222.99),
(13, 12, 15, 1, 687.00),
(14, 12, 19, 1, 438.00),
(15, 12, 22, 1, 899.99),
(16, 13, 12, 1, 1329.00);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL,
  `brand` enum('APPLE','SAMSUNG','XIAOMI','HUAWEI') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `category_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `brand`, `category_id`, `created_at`, `image_path`) VALUES
(12, 'iPhone 15 Pro Max', 'Le modèle phare d\'Apple avec un design en titane, un puissant processeur A17 Pro, et un système photo avancé avec zoom optique 5x.', 1329.00, 100, 'APPLE', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhone15ProMax.jpg'),
(13, 'iPhone 15 Pro', 'Un concentré de puissance et de légèreté avec un écran Super Retina XDR et des performances exceptionnelles grâce à l\'A17 Pro.', 950.00, 100, 'APPLE', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhone15Pro.jpg'),
(14, 'iPhone 15', 'Un choix élégant avec un écran lumineux, des performances fiables, et une connectivité USB-C pour plus de polyvalence.', 824.00, 100, 'APPLE', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhone15.jpg'),
(15, 'iPhone 14 Pro Max', 'Puissance et design premium, avec un écran ProMotion, une caméra 48 MP, et une autonomie exceptionnelle.', 687.00, 100, 'APPLE', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhone14ProMax.jpg'),
(16, 'iPhone 14 Pro', 'Les fonctionnalités avancées d\'Apple avec Dynamic Island, des caméras professionnelles, et une fluidité hors pair.', 603.00, 100, 'APPLE', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhone14Pro.jpg'),
(17, 'iPhone 14', 'Simplicité et efficacité, avec des performances rapides et un design intemporel.', 453.00, 100, 'APPLE', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhone14.jpg'),
(18, 'iPhone 13 Pro Max', 'Une option haut de gamme avec une triple caméra impressionnante et une autonomie prolongée.', 528.00, 100, 'APPLE', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhone13ProMax.jpg'),
(19, 'iPhone 13 Pro', 'Compact, puissant et élégant, parfait pour ceux qui veulent un flagship sans compromis sur la taille.', 438.00, 100, 'APPLE', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhone13Pro.jpg'),
(20, 'iPhone 13', 'Puissance et design, avec un écran ProMotion, une caméra 48 MP, et une autonomie exceptionnelle.', 379.00, 100, 'APPLE', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhone13.jpg'),
(21, 'iPhone SE (2022)', 'Un design classique avec la puissance de la puce A15 Bionic pour un prix plus abordable.', 603.00, 100, 'APPLE', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhoneSE2022.jpg'),
(22, 'Samsung Galaxy S23 Ultra', 'Le summum de Samsung avec un stylet intégré, une caméra 200 MP, et un écran Dynamic AMOLED 6,8 pouces.', 899.99, 100, 'SAMSUNG', 1, '2025-01-31 19:12:37', '/assets/img/productsImg/SamsungGalaxyS23ultra.jpg'),
(25, 'Samsung Galaxy S23+', 'Un téléphone haut de gamme avec une autonomie améliorée et des performances robustes grâce au Snapdragon 8 Gen 2.\r\n', 799.99, 100, 'SAMSUNG', 1, '2025-01-31 19:12:45', '/assets/img/productsImg/SamsungGalaxyS23+.jpg'),
(26, 'Samsung Galaxy S23', 'Compact, puissant et élégant, parfait pour ceux qui veulent un flagship sans compromis sur la taille.', 605.99, 100, 'SAMSUNG', 1, '2025-01-31 19:17:26', '/assets/img/productsImg/SamsungGalaxyS23.jpg'),
(27, 'Samsung Galaxy Z Fold5', 'Un smartphone pliable conçu pour la productivité avec un écran principal de 7,6 pouces.', 1222.99, 100, 'SAMSUNG', 1, '2025-01-31 19:17:26', '/assets/img/productsImg/Galaxy-Z-Fold5'),
(28, 'Samsung Galaxy Z Flip5', 'Style et innovation dans un format pliable compact avec un écran externe plus grand.', 849.99, 100, 'SAMSUNG', 1, '2025-01-31 19:22:59', '/assets/img/productsImg/Galaxy-Z-Flip5'),
(29, 'Samsung Galaxy A54', 'Milieu de gamme avec un écran AMOLED éclatant, une excellente autonomie, et un prix abordable.', 309.99, 100, 'SAMSUNG', 1, '2025-01-31 19:22:59', '/assets/img/productsImg/SamsungGalaxyA54'),
(30, 'Samsung Galaxy A34', 'Performance et design moderne pour un smartphone 5G économique.', 209.00, 100, 'SAMSUNG', 1, '2025-01-31 19:28:22', '/assets/img/productsImg/SamsungGalaxyA34.jpg'),
(31, 'Samsung Galaxy A14', 'Un téléphone abordable avec une batterie massive de 6000 mAh pour une autonomie impressionnante.', 118.00, 100, 'SAMSUNG', 1, '2025-01-31 19:28:22', '/assets/img/productsImg/SamsungGalaxyA14.jpg'),
(32, 'Samsung Galaxy Note20 Ultra', 'Un téléphone premium avec un stylet S Pen et un écran de 6,9 pouces.', 849.00, 100, 'SAMSUNG', 1, '2025-01-31 19:49:24', '/assets/img/productsImg/SamsungGalaxyNote20Ultra.jpg'),
(33, 'Samsung Galaxy S21 FE', 'Une version plus accessible de la série S21 avec des fonctionnalités premium.', 414.99, 100, 'SAMSUNG', 1, '2025-01-31 19:49:24', '/assets/img/productsImg/SamsungGalaxyS21FE.jpg'),
(34, 'Samsung Galaxy S22 Ultra NOIR', 'Le Samsung Galaxy S22 Ultra est un smartphone d’exception.\r\nAvec l’ADN du Galaxy S en son cœur, il embarque toute l’expérience d’un Galaxy Note avec un cadre en aluminium poli, une conception symétrique et un bloc photo intégré à la face arrière.', 869.00, 100, 'SAMSUNG', 1, '2025-01-31 19:52:47', '/assets/img/productsImg/SamsungGalaxyS22Ultra.jpg'),
(35, 'Samsung Galaxy S22+', 'Retrouvez tout l’ADN Galaxy S au cœur du design d’exception des Galaxy S22 et Galaxy S22+.\r\nLes bords ultra fins se fondent dans un cadre poli symétrique et viennent harmonieusement entourer l’écran, tandis que l’arrière abrite un système photo à trois optiques.', 679.99, 100, 'SAMSUNG', 1, '2025-01-31 19:52:47', '/assets/img/productsImg/SamsungGalaxyS22+jpg'),
(36, 'Samsung Galaxy S22', 'Les bords ultra fins se fondent dans un cadre poli symétrique et viennent harmonieusement entourer l’écran, tandis que l’arrière abrite un système photo à trois optiques.\r\nUne véritable œuvre d’art technologique, dans le creux de votre main.', 525.00, 100, 'SAMSUNG', 1, '2025-01-31 19:53:56', '/assets/img/productsImg/SamsungGalaxyS22.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `role` enum('CLIENT','ADMINISTRATEUR','FOURNISSEUR') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'CLIENT',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `phone`, `role`, `created_at`) VALUES
(4, 'Test', 'Te', 'st', 'Test@gmail.com', '$2y$10$jT.Jkko18tYsrFaQa6Sse.jMbW7Ex21oXn16boBgmeb0YabU9hg3C', '', 'CLIENT', '2025-02-21 02:41:20'),
(5, 'Kilo', 'Kiki', 'Lolo', 'kilo@gmail.com', '$2y$10$4nhqfmZUZBFiLxelQQIcKurBWcW33cSY/Lv1eK0CUHc1v2B9ReVIq', '', 'CLIENT', '2025-02-21 11:47:56'),
(6, 'aa', 'a', 'a', 'aa@gmail.com', '$2y$10$Q67k5A2kXtJaS.ZZ/H25Kuw3qmHNB8Ym1DHIGEJ5OdDe01vCGVfq2', '', 'CLIENT', '2025-02-21 17:14:05'),
(7, 'Lolavlch', 'Lola', 'Viladrich', 'lolaviladrich2006@icloud.com', '$2y$10$3e6YKzaCc4CjhGtINxdb3OzVXR60WLfGSeMuso80G6Maxpw8tScAS', '07 67 31 21 37', 'CLIENT', '2025-02-23 11:53:56'),
(8, 'bb', 'b', 'b', 'bb@gmail.com', '$2y$10$rLEtC6plTkmpsk8f7NWMc.v47RfrGwYk6heOJY15NdOHxh/YzNdq.', '', 'CLIENT', '2025-02-23 11:55:57'),
(9, 'cc', 'c', 'c', 'cc@gmail.com', '$2y$10$QQLqItJPx/TJCB4SFzgvhenmN/ZDG.qpiiZHxg0QNTEWUQ/YW4aF.', NULL, 'CLIENT', '2025-02-27 14:52:38'),
(10, 'Vexyuu', 'Killian', 'Fievet', 'killianfievet@gmail.com', '$2y$10$MgeEjLHBACrgN/uMU7yTiuMrtxPCYhYhtnrrY5VHaYEvsty7sditG', '06 69 97 90 59', 'ADMINISTRATEUR', '2025-02-27 22:28:13'),
(11, 'ee', 'e', 'e', 'ee@gmail.com', '$2y$10$mvHlcLyd43C2YzrHxzD73ehjv2okqqHQhDKWgG5ihUYFXVj9SJwOu', '', 'CLIENT', '2025-02-27 23:03:18'),
(13, 'admin', 'ladmin', 'istrateur', 'admin@gmail.com', '$2y$10$84mp3aJiJ0mtCn/EqyP4quIlJDTCoMocw5yWZmiscKrQynG/fM/Oa', '', 'ADMINISTRATEUR', '2025-03-15 00:59:46'),
(14, 'qq', 'q', 'q', 'qq@gmail.com', '$2y$10$Tz4SpXlNoj6VmWXOi2sMx.MF6AJbnizy0UwGIKjnATBzRHyZ8B/sS', '', 'CLIENT', '2025-03-15 01:00:49'),
(15, 'rr', 'r', 'r', 'rr@gmail.com', '$2y$10$bznwU.FcZr3EiTswnkviA.yiG4lExML6gLejXT/GkWm5O9yFFjiHK', '04 05 03 02 11', 'CLIENT', '2025-03-15 01:50:34'),
(16, 'blablabla', 'blebleble', 'blublublu', 'blableblu@gmail.com', '$2y$10$XKdSKYfQQSeJOFOFiIDWNuvlx4NrLFGYqyCV4qCmwqwElWZ0zbBBS', '09 76 52 88 93', 'CLIENT', '2025-03-15 12:36:55'),
(17, 'ShadowByte', 'Thomas', 'Lemoine', 'shadow@cybermail.com', '$2y$10$ec6J7IDCaw8nQSlfk2ndZuwFg/.dDPCJwdxKzLSnO1dnQOf4LINsO', '06 12 34 56 78', 'CLIENT', '2025-03-15 17:01:00'),
(18, 'LunaCode', 'Camille', 'Dufresne', 'luna@techverse.net', '$2y$10$c106ymw3Tizey96G1ckI.evrmurUgMGhpZhVqlPhb8AOs/MkTSEdS', '07 98 76 54 32', 'CLIENT', '2025-03-15 17:01:20'),
(19, 'PhantomX', 'Alexandre', 'Marchand', 'phantom@darknet.org', '$2y$10$aa4GyTW3BsaRk8NpbS8X..VUhsSfWUp8KBj8sdABND4dJR1FrbFgC', '06 45 67 89 01', 'CLIENT', '2025-03-15 17:01:41'),
(20, 'BlazeFire', 'Mélanie', 'Dupont', 'blaze@infernomail.com', '$2y$10$zIAOUy.rNXmz5umKHv38peLXxiMFbOMiaS.zgOhSXBU1uCW8mc8ES', '07 22 33 44 55', 'CLIENT', '2025-03-15 17:01:59'),
(21, 'CyberWolf', 'Lucas', 'Morel', 'wolf@neonmatrix.io', '$2y$10$q/he1LJPXF./mzKtH4NVHOEmdPJouGvoRmTK0xzJHkgu/S7e63Ubi', '06 88 99 00 11', 'CLIENT', '2025-03-15 17:02:20'),
(22, 'MarieD92', 'Marie', 'Dupont', 'marie.dupont92@gmail.com', '$2y$10$GLI7Ue9HbsHRLZffxjnvxO0WVrzlshLIBeusWNkGDB11CxDFQStUK', '06 24 58 79 32', 'CLIENT', '2025-03-15 17:20:47'),
(23, 'Kevin75', 'Kévin', 'Lemoine', 'kevin.lemoine75@hotmail.fr', '$2y$10$HrlIHtM.4/gzZWsrKMf4GOaFu0Cp9YhlXQtdIDkJSnFgvG2UhTGYe', '07 52 41 36 89', 'CLIENT', '2025-03-15 17:21:04'),
(24, 'Julie_R', 'Julie', 'Richard', 'julie.richard@mail.fr', '$2y$10$wlXgb9TOJG1Q6kCGV9borePA6P34a8Ior2NhwGfuU5LX7ivIJ.JBO', '06 11 82 73 54', 'CLIENT', '2025-03-15 17:21:26'),
(25, 'Benoit_G', 'Benoît', 'Gauthier', 'benoit.gauthier@outlook.com', '$2y$10$g2wcWc3sj2Fvza/T3HY8TuBqzL.q3fcQpajqp92kUhLX/4Aqt963O', '06 97 55 44 21', 'CLIENT', '2025-03-15 17:21:42'),
(26, 'Sophie_Creil', 'Sophie', 'Martinez', 'sophie.martinez@free.fr', '$2y$10$0qFOQM.XCfNR18/h5pQqveKPpzqB2GlVy2cccxNbmDygxfmQihQXK', '07 26 49 85 37', 'CLIENT', '2025-03-15 17:22:00'),
(27, 'AntoineT91', 'Antoine', 'Thomas', 'antoine.thomas91@laposte.net', '$2y$10$pnioESUVnYcvG3A/XI62L.CIwUh7KU3vuPwwkJGRnAdmUHraRizki', '06 39 77 65 20', 'CLIENT', '2025-03-15 17:22:18'),
(28, 'Emma.P', 'Emma', 'Petit', 'emma.petit@gmail.com', '$2y$10$v72bKFhGHNMoRsdRAdI9WuRLnnLYxSOiJo/eMrXDe2FLbQp5lJb2m', '07 15 68 24 90', 'CLIENT', '2025-03-15 17:22:38'),
(29, 'JeanMi78', 'Jean-Michel', 'Rousseau', 'jm.rousseau78@yahoo.fr', '$2y$10$Ll53iiBrSkRNvDAXKjPfWuP8RLFccLt5C7QbIR4TAEtIdsRJi.uLC', '06 78 12 34 56', 'CLIENT', '2025-03-15 17:22:55');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
