-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 06 oct. 2021 à 11:46
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `symfony_ecommerce`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

CREATE TABLE `adresse` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pays` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `adresse`
--

INSERT INTO `adresse` (`id`, `user_id`, `name`, `firstname`, `company`, `adresse`, `cp`, `ville`, `pays`, `telephone`, `lastname`) VALUES
(1, 1, 'eeee', 'eeeee', 'eeee', 'fsfsfsf', '48545', 'sfsfs', 'AF', '999595985', 'fsfsfs');

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `infos` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `name`, `infos`, `price`, `created_at`, `image_name`, `updated_at`) VALUES
(4, 'Horloge', 'Une belle horloge', 14.99, '2021-10-06 10:29:45', 'ales-krivec-zmzhcvivgbg-unsplash-615d5e7981d94102831320.jpg', '2021-10-06 10:46:45'),
(5, 'Console ATARI', 'Une console pour revenir aux base', 54.99, '2021-10-06 10:31:22', '26atari1-videosixteenbyninejumbo1600-615d5eda34260426509933.jpg', '2021-10-06 10:46:45'),
(6, 'Appareil photo ALEXANDER', 'Appareil photo de la ALEXANDER', 36.45, '2021-10-06 10:33:53', 'alexander-andrews-solew77napo-unsplash-615d5f71868db196681007.jpg', '2021-10-06 10:46:45'),
(7, 'Machine à écrire ARASH', 'Une machine à écrire de la marque arash', 109.99, '2021-10-06 10:36:15', 'arash-asghari-znssdsmy9ho-unsplash-615d5fff50a98787859776.jpg', '2021-10-06 10:46:45'),
(8, 'Poster caleb gregor', 'Un poster de l\'artiste Caleb Gregor', 9.99, '2021-10-06 10:37:32', 'caleb-george-ivxfoilgyha-unsplash-615d604c19ffe861987008.jpg', '2021-10-06 10:46:45'),
(9, 'Collection de livre de chris-lawton', '5 livres de chris-lawton', 25.99, '2021-10-06 10:38:49', 'chris-lawton-zvkx6ixuhwq-unsplash-615d609919955517071957.jpg', '2021-10-06 10:46:45'),
(10, 'Collection de livre de Clem onoji', '7 livres de clem', 33.9, '2021-10-06 10:40:05', 'clem-onojeghuo-1-1ypksil8e-unsplash-615d60e532078979244204.jpg', '2021-10-06 10:46:45'),
(11, 'Illustration d\'oiseaux', 'De la marque playmotion', 5.65, '2021-10-06 10:41:10', 'boston-public-library-svgzln7y-sw-unsplash-615d612674285998523804.jpg', '2021-10-06 10:46:45'),
(12, 'Tableau : La tabatière', 'Artiste : clem onojeghuo', 549.99, '2021-10-06 10:43:48', 'clem-onojeghuo-yoblhvtdkug-unsplash-615d61c43546a037568634.jpg', '2021-10-06 10:46:45'),
(13, 'Tableau : Le rose de minuit', 'Artiste : cyrus crossan', 4999.99, '2021-10-06 10:44:41', 'cyrus-crossan-vkgj6ylpcsg-unsplash-615d61f9249bd439227673.jpg', '2021-10-06 10:46:45'),
(14, 'Lot de 2 pot de glycérine', 'Lot de 2 pot de glycérine', 12.99, '2021-10-06 10:45:49', 'daria-nepriakhina-zcdkupah4wc-unsplash-615d623de713e860810680.jpg', '2021-10-06 10:46:45'),
(15, 'Tableau europeana', 'europeana', 5, '2021-10-06 10:47:49', 'europeana-smwpyqhvruy-unsplash-615d62b514e6a465541950.jpg', '2021-10-06 10:47:49'),
(16, 'Machine à écrire klauer', 'De la marque klauer', 79.5, '2021-10-06 10:48:37', 'florian-klauer-mk7d-4ucfmg-unsplash-1-615d62e57ee91478066244.jpg', '2021-10-06 10:48:37'),
(17, 'Lots de 2 cassette vierge', 'cassette vierge', 5.78, '2021-10-06 10:49:47', 'hello-i-m-nik-6nqbkx5ui9i-unsplash-615d632b861da856288090.jpg', '2021-10-06 10:49:47'),
(18, 'Cassete vierge INAMI', 'lot de 1', 2.2, '2021-10-06 10:50:41', 'imani-bahati-ut67ifuod2o-unsplash-615d63618c1c4919263489.jpg', '2021-10-06 10:50:41'),
(19, 'Appareil photo Autostar', 'De la marque autostar', 19.99, '2021-10-06 10:51:46', 'jakob-owens-esbfahabh7y-unsplash-615d63a2ad9ab425104633.jpg', '2021-10-06 10:51:46'),
(20, 'Décoration vielle appareil', 'Œuvre D\'albert Jonathan', 35, '2021-10-06 10:53:10', 'jonathan-talbert-1naxtprvyo4-unsplash-615d63f611a6e402551774.jpg', '2021-10-06 10:53:10'),
(21, 'Reveil rose joshua', 'Reveil rose de la marque joshua', 12.99, '2021-10-06 10:54:10', 'joshua-coleman-jmt6brgbuxu-unsplash-615d6432bd79a760991034.jpg', '2021-10-06 10:54:10'),
(22, 'Telephone fixe', 'Telephone fixe', 34.99, '2021-10-06 10:57:48', 'louis-hansel-ogdrj7q8eaw-unsplash-615d650ca2b72215803991.jpg', '2021-10-06 10:57:48'),
(23, 'Velo rouge Markus', 'Velo rouge', 36, '2021-10-06 10:58:17', 'markus-spiske-oxiv6mxmfpa-unsplash-615d65291283e914038529.jpg', '2021-10-06 10:58:17'),
(24, 'Telephone jaune fixe', 'tel jeune', 24.99, '2021-10-06 10:58:48', 'mike-meyers-haaxbjihds-unsplash-615d65483e020932959324.jpg', '2021-10-06 10:58:48'),
(25, 'Lecteur mp3 mike', 'lecteur orange', 15, '2021-10-06 10:59:29', 'mike-meyers-v8xavfyo41q-unsplash-615d6571724ef412244442.jpg', '2021-10-06 10:59:29'),
(26, 'Musique namroud', 'MUSIQUE', 4.99, '2021-10-06 11:00:05', 'namroud-gorguis-fzwivbri0xk-unsplash-1-615d6595d0754160174916.jpg', '2021-10-06 11:00:05'),
(27, 'Lot de vêtement OLEG', '5 vêtement', 26, '2021-10-06 11:00:43', 'oleg-magni-bij7yvmsjew-unsplash-615d65bbd00f4487085036.jpg', '2021-10-06 11:00:43'),
(28, 'Lot de livre paige cody', 'paige cody', 36, '2021-10-06 11:01:53', 'paige-cody-esaigzemqu-unsplash-615d6601c7717017900849.jpg', '2021-10-06 11:01:53'),
(29, 'Console nintendo', 'Nintendo', 129.99, '2021-10-06 11:02:31', 'ravi-palwe-eorjxplsnfs-unsplash-615d6627c444e937285826.jpg', '2021-10-06 11:02:31'),
(30, 'Lot de 10 pogs aléatoires', 'Lot de pogs aléatoires', 5, '2021-10-06 11:14:56', 'phil-shaw-xx5jm-kqy0o-unsplash-615d6910c9958516889935.jpg', '2021-10-06 11:14:56'),
(31, 'Film casablanca', 'Film casablanca', 3, '2021-10-06 11:29:58', 'casablanca-615d6c9601e95236588627.jpg', '2021-10-06 11:29:58'),
(32, 'L\'exorcist', 'L\'exorcist', 3, '2021-10-06 11:30:36', 'exorcist-615d6cbc1de2b311644691.jpg', '2021-10-06 11:30:36'),
(33, 'Godzilla', 'Godzilla', 3, '2021-10-06 11:30:54', 'godzilla-615d6ccec6468219236700.jpg', '2021-10-06 11:30:54'),
(34, 'Titanic', 'Titanic', 3, '2021-10-06 11:31:09', 'titanic-615d6cdddf730094245905.jpg', '2021-10-06 11:31:09'),
(35, 'Streetfighter', 'Streetfighter retro', 8.99, '2021-10-06 11:31:59', 'street-fighter-ii-turbo-e50972-615d6d0fe8649386813492.jpg', '2021-10-06 11:31:59'),
(36, 'Super Mario Nintendo', 'Super Mario Nintendo  pour super Nintendo', 8.99, '2021-10-06 11:32:42', 'super-mario-kart-snes-e56666-615d6d3ad5916223180258.jpg', '2021-10-06 11:32:42'),
(37, 'Donkey kong', 'dk kong', 4, '2021-10-06 11:33:17', 'dk-kong-3d-e61889-615d6d5d3ee25035017565.jpg', '2021-10-06 11:33:17'),
(38, 'Nintendo DS', 'Nintendo DS', 29.99, '2021-10-06 11:34:05', 'sq-nintendodslite-support-image380w-615d6d8d9a64b737046979.jpg', '2021-10-06 11:34:05'),
(39, 'Tintin en Amérique', 'Tintin en Amérique', 4.99, '2021-10-06 11:34:32', 'tintin1-615d6da8b677d001103652.jpg', '2021-10-06 11:34:32'),
(40, 'Quicke et Flupke', 'Quicke et Flupke', 4.99, '2021-10-06 11:35:09', 'qef-615d6dcdd9150532800820.jpg', '2021-10-06 11:35:09'),
(41, 'Mystic', 'Mystic', 2, '2021-10-06 11:35:30', 'mystic-615d6de20ee8b120522894.jpg', '2021-10-06 11:35:30'),
(42, 'Albator', 'Albator', 5, '2021-10-06 11:35:52', 'albator-615d6df8e0e79924225981.jpg', '2021-10-06 11:35:52'),
(43, 'Goldorak BD', 'Goldorak BD', 5, '2021-10-06 11:36:16', 'goldorak-615d6e1068163774255357.jpg', '2021-10-06 11:36:16'),
(44, 'Tourne Disque', 'Tourne Disque HOWNER', 47.5, '2021-10-06 11:36:53', 'tournedisque-615d6e352c12e077910417.jpg', '2021-10-06 11:36:53');

-- --------------------------------------------------------

--
-- Structure de la table `article_category`
--

CREATE TABLE `article_category` (
  `article_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article_category`
--

INSERT INTO `article_category` (`article_id`, `category_id`) VALUES
(4, 1),
(4, 2),
(5, 4),
(5, 5),
(6, 5),
(7, 2),
(8, 2),
(11, 2),
(12, 2),
(13, 2),
(15, 2),
(16, 2),
(17, 5),
(18, 5),
(19, 5),
(20, 1),
(20, 2),
(21, 1),
(21, 2),
(21, 5),
(22, 1),
(23, 1),
(24, 1),
(24, 2),
(25, 5),
(25, 8),
(26, 8),
(27, 7),
(28, 6),
(29, 4),
(29, 5),
(30, 3),
(31, 10),
(32, 10),
(33, 6),
(34, 10),
(35, 9),
(36, 9),
(37, 9),
(38, 4),
(38, 5),
(39, 6),
(40, 6),
(41, 6),
(42, 6),
(43, 6),
(44, 1),
(44, 2),
(44, 8);

-- --------------------------------------------------------

--
-- Structure de la table `carrier`
--

CREATE TABLE `carrier` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `carrier`
--

INSERT INTO `carrier` (`id`, `name`, `description`, `price`) VALUES
(1, 'La poste', 'La poste', 5);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Mobilier'),
(2, 'Décoration '),
(3, 'Jouet'),
(4, 'Console'),
(5, 'Electronique '),
(6, 'Livre'),
(7, 'Vêtement '),
(8, 'Musique'),
(9, 'Jeux Video'),
(10, 'Film');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `article_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `moderate` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20211006081654', '2021-10-06 10:17:06', 512);

-- --------------------------------------------------------

--
-- Structure de la table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` double NOT NULL,
  `id_stripe` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carrier_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carrier_price` double DEFAULT NULL,
  `delivery` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `purchase`
--

INSERT INTO `purchase` (`id`, `user_id`, `created_at`, `status`, `total`, `id_stripe`, `reference`, `carrier_name`, `carrier_price`, `delivery`) VALUES
(1, 1, '2021-10-06 10:19:07', 'panier', 0, 'cs_test_b11FIydApjb3Jb9O6k2EleTtHajvmXM0xRBSqhrvJXB1kmPpLjkF2EkE1k', '06102021-615d62760aa52', 'La poste', 5, 'eeeee fsfsfs<br/>999595985<br/>fsfsfsf<br/>48545 sfsfs<br/>AF');

-- --------------------------------------------------------

--
-- Structure de la table `purchase_have_product`
--

CREATE TABLE `purchase_have_product` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `purchase_have_product`
--

INSERT INTO `purchase_have_product` (`id`, `article_id`, `purchase_id`, `quantity`) VALUES
(1, 9, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` datetime NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `nom`, `prenom`, `genre`, `date_naissance`, `email`) VALUES
(1, 'admin', '[\"ROLE_ADMIN\"]', '$2y$13$lwkfETZFPa5gmZpQ9/HjKulOPnaGCeJ3K2mbZmaParMb/zzE5fv..', 'amdin', 'admin', 'Homme', '1901-01-01 00:00:00', 'admin@admin.com');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `adresse`
--
ALTER TABLE `adresse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C35F0816A76ED395` (`user_id`);

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `article_category`
--
ALTER TABLE `article_category`
  ADD PRIMARY KEY (`article_id`,`category_id`),
  ADD KEY `IDX_53A4EDAA7294869C` (`article_id`),
  ADD KEY `IDX_53A4EDAA12469DE2` (`category_id`);

--
-- Index pour la table `carrier`
--
ALTER TABLE `carrier`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5F9E962A7294869C` (`article_id`),
  ADD KEY `IDX_5F9E962AA76ED395` (`user_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6117D13BA76ED395` (`user_id`);

--
-- Index pour la table `purchase_have_product`
--
ALTER TABLE `purchase_have_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2F48694C7294869C` (`article_id`),
  ADD KEY `IDX_2F48694C558FBEB9` (`purchase_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `adresse`
--
ALTER TABLE `adresse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `carrier`
--
ALTER TABLE `carrier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `purchase_have_product`
--
ALTER TABLE `purchase_have_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `adresse`
--
ALTER TABLE `adresse`
  ADD CONSTRAINT `FK_C35F0816A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `article_category`
--
ALTER TABLE `article_category`
  ADD CONSTRAINT `FK_53A4EDAA12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_53A4EDAA7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_5F9E962A7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  ADD CONSTRAINT `FK_5F9E962AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `FK_6117D13BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `purchase_have_product`
--
ALTER TABLE `purchase_have_product`
  ADD CONSTRAINT `FK_2F48694C558FBEB9` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`id`),
  ADD CONSTRAINT `FK_2F48694C7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
