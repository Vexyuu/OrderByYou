-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 28 fév. 2025 à 11:22
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

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
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(16, 6, 28, 1, '2025-02-27 19:13:10'),
(9, 9, 25, 1, '2025-02-27 15:39:19'),
(8, 9, 28, 1, '2025-02-27 15:39:17'),
(7, 9, 27, 6, '2025-02-27 15:38:36'),
(18, 6, 36, 1, '2025-02-27 22:07:24'),
(19, 10, 25, 1, '2025-02-27 22:29:30'),
(20, 10, 12, 1, '2025-02-27 22:29:33'),
(21, 10, 17, 1, '2025-02-27 22:29:35'),
(22, 10, 20, 1, '2025-02-27 22:29:37'),
(23, 10, 32, 1, '2025-02-27 22:29:39'),
(24, 10, 35, 1, '2025-02-27 22:29:41');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(1, 'Electronics', '2024-11-22 18:14:13'),
(2, 'Books', '2024-11-22 18:14:13'),
(3, 'Clothing', '2024-11-22 18:14:13');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','canceled') DEFAULT 'pending',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `brand` varchar(50) NOT NULL,
  `category_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `brand`, `category_id`, `created_at`, `image_path`) VALUES
(27, 'Samsung Galaxy Z Fold5', 'Un smartphone pliable conçu pour la productivité avec un écran principal de 7,6 pouces.', '1222.99', 100, 'Samsung', 1, '2025-01-31 19:17:26', '/assets/img/productsImg/Galaxy-Z-Fold5'),
(28, 'Samsung Galaxy Z Flip5', 'Style et innovation dans un format pliable compact avec un écran externe plus grand.', '849.99', 100, 'Samsung', 1, '2025-01-31 19:22:59', '/assets/img/productsImg/Galaxy-Z-Flip5'),
(25, 'Samsung Galaxy S23+', 'Un téléphone haut de gamme avec une autonomie améliorée et des performances robustes grâce au Snapdragon 8 Gen 2.\r\n', '799.99', 100, 'Samsung', 1, '2025-01-31 19:12:45', '/assets/img/productsImg/SamsungGalaxyS23+.jpg'),
(26, 'Samsung Galaxy S23', 'Compact, puissant et élégant, parfait pour ceux qui veulent un flagship sans compromis sur la taille.', '605.99', 100, 'Samsung', 1, '2025-01-31 19:17:26', '/assets/img/productsImg/SamsungGalaxyS23.jpg'),
(22, 'Samsung Galaxy S23 Ultra', 'Le summum de Samsung avec un stylet intégré, une caméra 200 MP, et un écran Dynamic AMOLED 6,8 pouces.', '899.99', 100, 'Samsung', 1, '2025-01-31 19:12:37', '/assets/img/productsImg/SamsungGalaxyS23ultra.jpg'),
(12, 'iPhone 15 Pro Max', 'Le modèle phare d\'Apple avec un design en titane, un puissant processeur A17 Pro, et un système photo avancé avec zoom optique 5x.', '1329.00', 100, 'Apple', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhone15ProMax.jpg'),
(13, 'iPhone 15 Pro', 'Un concentré de puissance et de légèreté avec un écran Super Retina XDR et des performances exceptionnelles grâce à l\'A17 Pro.', '950.00', 100, 'Apple', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhone15Pro.jpg'),
(14, 'iPhone 15', 'Un choix élégant avec un écran lumineux, des performances fiables, et une connectivité USB-C pour plus de polyvalence.', '824.00', 100, 'Apple', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhone15.jpg'),
(15, 'iPhone 14 Pro Max', 'Puissance et design premium, avec un écran ProMotion, une caméra 48 MP, et une autonomie exceptionnelle.', '687.00', 100, 'Apple', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhone14ProMax.jpg'),
(16, 'iPhone 14 Pro', 'Les fonctionnalités avancées d\'Apple avec Dynamic Island, des caméras professionnelles, et une fluidité hors pair.', '603.00', 100, 'Apple', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhone14Pro.jpg'),
(17, 'iPhone 14', 'Simplicité et efficacité, avec des performances rapides et un design intemporel.', '453.00', 100, 'Apple', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhone14.jpg'),
(18, 'iPhone 13 Pro Max', 'Une option haut de gamme avec une triple caméra impressionnante et une autonomie prolongée.', '528.00', 100, 'Apple', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhone13ProMax.jpg'),
(19, 'iPhone 13 Pro', 'Compact, puissant et élégant, parfait pour ceux qui veulent un flagship sans compromis sur la taille.', '438.00', 100, 'Apple', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhone13Pro.jpg'),
(20, 'iPhone 13', 'Puissance et design, avec un écran ProMotion, une caméra 48 MP, et une autonomie exceptionnelle.', '379.00', 100, 'Apple', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhone13.jpg'),
(21, 'iPhone SE (2022)', 'Un design classique avec la puissance de la puce A15 Bionic pour un prix plus abordable.', '603.00', 100, 'Apple', 1, '2025-01-14 22:31:09', '/assets/img/productsImg/iPhoneSE2022.jpg'),
(29, 'Samsung Galaxy A54', 'Milieu de gamme avec un écran AMOLED éclatant, une excellente autonomie, et un prix abordable.', '309.99', 100, 'Samsung', 1, '2025-01-31 19:22:59', '/assets/img/productsImg/SamsungGalaxyA54'),
(30, 'Samsung Galaxy A34', 'Performance et design moderne pour un smartphone 5G économique.', '209.00', 100, 'Samsung', 1, '2025-01-31 19:28:22', '/assets/img/productsImg/SamsungGalaxyA34.jpg'),
(31, 'Samsung Galaxy A14', 'Un téléphone abordable avec une batterie massive de 6000 mAh pour une autonomie impressionnante.', '118.00', 100, 'Samsung', 1, '2025-01-31 19:28:22', '/assets/img/productsImg/SamsungGalaxyA14.jpg'),
(32, 'Samsung Galaxy Note20 Ultra', 'Un téléphone premium avec un stylet S Pen et un écran de 6,9 pouces.', '849.00', 100, 'Samsung', 1, '2025-01-31 19:49:24', '/assets/img/productsImg/SamsungGalaxyNote20Ultra.jpg'),
(33, 'Samsung Galaxy S21 FE', 'Une version plus accessible de la série S21 avec des fonctionnalités premium.', '414.99', 100, 'Samsung', 1, '2025-01-31 19:49:24', '/assets/img/productsImg/SamsungGalaxyS21FE.jpg'),
(34, 'Samsung Galaxy S22 Ultra NOIR', 'Le Samsung Galaxy S22 Ultra est un smartphone d’exception.\r\nAvec l’ADN du Galaxy S en son cœur, il embarque toute l’expérience d’un Galaxy Note avec un cadre en aluminium poli, une conception symétrique et un bloc photo intégré à la face arrière.', '869.00', 100, 'Samsung', 1, '2025-01-31 19:52:47', '/assets/img/productsImg/SamsungGalaxyS22Ultra.jpg'),
(35, 'Samsung Galaxy S22+', 'Retrouvez tout l’ADN Galaxy S au cœur du design d’exception des Galaxy S22 et Galaxy S22+.\r\nLes bords ultra fins se fondent dans un cadre poli symétrique et viennent harmonieusement entourer l’écran, tandis que l’arrière abrite un système photo à trois optiques.', '679.99', 100, 'Samsung', 1, '2025-01-31 19:52:47', '/assets/img/productsImg/SamsungGalaxyS22+jpg'),
(36, 'Samsung Galaxy S22', 'Les bords ultra fins se fondent dans un cadre poli symétrique et viennent harmonieusement entourer l’écran, tandis que l’arrière abrite un système photo à trois optiques.\r\nUne véritable œuvre d’art technologique, dans le creux de votre main.', '525.00', 100, 'Samsung', 1, '2025-01-31 19:53:56', '/assets/img/productsImg/SamsungGalaxyS22.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `rating` tinyint DEFAULT NULL,
  `comment` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `phone`, `created_at`) VALUES
(7, 'Lola', 'lolaviladrich2006@icloud.com', '$2y$10$3e6YKzaCc4CjhGtINxdb3OzVXR60WLfGSeMuso80G6Maxpw8tScAS', '0767312137', '2025-02-23 11:53:56'),
(8, 'bb', 'bb@gmail.com', '$2y$10$rLEtC6plTkmpsk8f7NWMc.v47RfrGwYk6heOJY15NdOHxh/YzNdq.', '', '2025-02-23 11:55:57'),
(3, 'Admin', 'Admin123@gmail.com', 'Admin123', NULL, '2025-02-21 02:23:47'),
(4, 'Test', 'Test@gmail.com', '$2y$10$jT.Jkko18tYsrFaQa6Sse.jMbW7Ex21oXn16boBgmeb0YabU9hg3C', '', '2025-02-21 02:41:20'),
(5, 'Kilo', 'kilo@gmail.com', '$2y$10$4nhqfmZUZBFiLxelQQIcKurBWcW33cSY/Lv1eK0CUHc1v2B9ReVIq', '', '2025-02-21 11:47:56'),
(6, 'aa', 'aa@gmail.com', '$2y$10$Q67k5A2kXtJaS.ZZ/H25Kuw3qmHNB8Ym1DHIGEJ5OdDe01vCGVfq2', '', '2025-02-21 17:14:05'),
(9, 'cc', 'cc@gmail.com', '$2y$10$QQLqItJPx/TJCB4SFzgvhenmN/ZDG.qpiiZHxg0QNTEWUQ/YW4aF.', NULL, '2025-02-27 14:52:38'),
(10, 'Fievet Killian', 'killianfievet@gmail.com', '$2y$10$MgeEjLHBACrgN/uMU7yTiuMrtxPCYhYhtnrrY5VHaYEvsty7sditG', '06 69 97 90 59', '2025-02-27 22:28:13'),
(11, 'ee', 'ee@gmail.com', '$2y$10$mvHlcLyd43C2YzrHxzD73ehjv2okqqHQhDKWgG5ihUYFXVj9SJwOu', '', '2025-02-27 23:03:18');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
