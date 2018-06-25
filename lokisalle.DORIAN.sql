-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 25 juin 2018 à 15:30
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `lokisalle`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `id_avis` int(3) NOT NULL AUTO_INCREMENT,
  `id_membre` int(3) NOT NULL,
  `id_salle` int(3) NOT NULL,
  `note` int(2) NOT NULL,
  `commentaire` text,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_avis`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id_avis`, `id_membre`, `id_salle`, `note`, `commentaire`, `date_enregistrement`) VALUES
(1, 1, 1, 4, 'bla bla', '2018-06-14 00:00:00'),
(2, 1, 2, 2, 're bla bla bla', '2018-06-13 00:00:00'),
(3, 1, 3, 3, 'blob blob', '2018-06-23 00:00:00'),
(4, 1, 4, 4, 'fghfdnghnfgy', '2018-06-13 15:20:41'),
(5, 1, 5, 1, 'hdfvcdhf', '2018-06-25 11:00:00'),
(6, 1, 6, 2, 'qseb ezrbvdfvq rqtzb dfg', '2018-06-25 11:00:00'),
(7, 1, 7, 4, 'dsfbv qdsfvqsdcfqez dqsfvqdf', '2018-06-25 11:00:00'),
(8, 1, 8, 2, 'dsfsdfq vvqvret', '2018-06-25 11:00:00'),
(9, 1, 9, 1, 'qsdfv qdgfvdvf', '2018-06-25 11:00:00'),
(10, 1, 10, 5, 'Vive les Putes OUaiiiis !!', '2018-06-25 11:00:00'),
(11, 1, 11, 5, 'Y\'a aussi robin', '2018-06-25 11:00:00'),
(12, 1, 12, 5, 'Maintenant j\'ai beaucoup beaucoup plus de dents', '2018-06-25 11:00:00'),
(13, 2, 1, 2, 'bla bla', '2018-06-14 00:00:00'),
(14, 2, 2, 4, 're bla bla', '2018-06-13 00:00:00'),
(15, 2, 3, 5, 'blob blob', '2018-06-23 00:00:00'),
(16, 2, 4, 1, 'fghfdnghnfgy', '2018-06-13 15:20:41'),
(17, 2, 5, 2, 'hdfvcdhf', '2018-06-25 11:00:00'),
(18, 2, 6, 3, 'qseb ezrbvdfvq rqtzb dfg', '2018-06-25 11:00:00'),
(19, 2, 7, 1, 'dsfbv qdsfvqsdcfqez dqsfvqdf', '2018-06-25 11:00:00'),
(20, 2, 8, 2, 'dsfsdfq vvqvret', '2018-06-25 11:00:00'),
(21, 2, 9, 2, 'qsdfv qdgfvdvf', '2018-06-25 11:00:00'),
(22, 2, 10, 5, 'Vive les Putes OUaiiiis !!', '2018-06-25 11:00:00'),
(23, 2, 11, 5, 'Y\'a aussi robin', '2018-06-25 11:00:00'),
(24, 2, 12, 5, 'Maintenant j\'ai beaucoup beaucoup plus de dents', '2018-06-25 11:00:00'),
(25, 3, 1, 1, 'bla bla', '2018-06-14 00:00:00'),
(26, 3, 2, 1, 're bla bla', '2018-06-13 00:00:00'),
(27, 3, 3, 4, 'blob blob', '2018-06-23 00:00:00'),
(28, 3, 4, 2, 'fghfdnghnfgy', '2018-06-13 15:20:41'),
(29, 3, 5, 3, 'hdfvcdhf', '2018-06-25 11:00:00'),
(30, 3, 6, 5, 'qseb ezrbvdfvq rqtzb dfg', '2018-06-25 11:00:00'),
(31, 3, 7, 3, 'dsfbv qdsfvqsdcfqez dqsfvqdf', '2018-06-25 11:00:00'),
(32, 3, 8, 1, 'dsfsdfq vvqvret', '2018-06-25 11:00:00'),
(33, 3, 9, 3, 'qsdfv qdgfvdvf', '2018-06-25 11:00:00'),
(34, 3, 10, 5, 'Vive les Putes OUaiiiis !!', '2018-06-25 11:00:00'),
(35, 3, 11, 5, 'Y\'a aussi robin', '2018-06-25 11:00:00'),
(36, 3, 12, 5, 'Maintenant j\'ai beaucoup beaucoup plus de dents', '2018-06-25 11:00:00'),
(37, 4, 1, 5, 'bla bla', '2018-06-14 00:00:00'),
(38, 4, 2, 0, 're bla bla', '2018-06-13 00:00:00'),
(39, 4, 3, 0, 'blob blob', '2018-06-23 00:00:00'),
(40, 4, 4, 4, 'fghfdnghnfgy', '2018-06-13 15:20:41'),
(41, 4, 5, 5, 'hdfvcdhf', '2018-06-25 11:00:00'),
(42, 4, 6, 1, 'qseb ezrbvdfvq rqtzb dfg', '2018-06-25 11:00:00'),
(43, 4, 7, 2, 'dsfbv qdsfvqsdcfqez dqsfvqdf', '2018-06-25 11:00:00'),
(44, 4, 8, 4, 'dsfsdfq vvqvret', '2018-06-25 11:00:00'),
(45, 4, 9, 1, 'qsdfv qdgfvdvf', '2018-06-25 11:00:00'),
(46, 4, 10, 5, 'Vive les Putes OUaiiiis !!', '2018-06-25 11:00:00'),
(47, 4, 11, 5, 'Y\'a aussi robin', '2018-06-25 11:00:00'),
(48, 4, 12, 5, 'Maintenant j\'ai beaucoup beaucoup plus de dents', '2018-06-25 11:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int(3) NOT NULL AUTO_INCREMENT,
  `id_membre` int(3) NOT NULL,
  `id_produit` int(3) NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  PRIMARY KEY (`id_commande`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `id_membre`, `id_produit`, `date_enregistrement`) VALUES
(4, 0, 1, '2018-06-13 11:36:52');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id_membre` int(3) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(60) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `civilite` enum('M','F') NOT NULL,
  `statut` int(1) NOT NULL,
  `date_inscription` datetime NOT NULL,
  PRIMARY KEY (`id_membre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `statut`, `date_inscription`) VALUES
(1, 'admin', '$2y$10$g63czkAXhlTYD8wkK7vvKO0gSNdb1xjHjD531/PxNhPGYlG0e4jcy', 'Thoyer', 'Marie', 'marie.thoyer@gmail.com', 'F', 1, '2018-06-07 14:37:58'),
(2, 'zizi', '$2y$10$xfpY813ZXchG/E1G807KweMqLegr4tabqrUBrvNx8Ym9oJO9Yl26u', 'zizi', 'zizi', 'zizi@zizi.com', 'F', 0, '2018-06-11 10:48:13'),
(3, 'prout', '$2y$10$3rLV.EVUMVQwzrNXS5tcGuUw56PSMgq4EF3.tuo83Tmg08aEV.r8a', 'prout', 'prout', 'prout@prout.com', 'M', 0, '2018-06-11 10:48:30'),
(4, 'caca', '$2y$10$.iS.9BPpj0lCq29useZvI.8q6WNnMuYx/.zXMLlx7FA74mon/lBL2', 'caca', 'caca', 'caca@caca.com', 'M', 1, '2018-06-11 10:48:45');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id_produit` int(3) NOT NULL AUTO_INCREMENT,
  `id_salle` int(3) NOT NULL,
  `date_arrivee` datetime NOT NULL,
  `date_depart` datetime DEFAULT NULL,
  `prix` int(5) NOT NULL,
  `etat` enum('libre','reservation') NOT NULL,
  PRIMARY KEY (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `id_salle`, `date_arrivee`, `date_depart`, `prix`, `etat`) VALUES
(1, 1, '2018-07-02 09:00:00', '2018-07-06 19:00:00', 2300, 'reservation'),
(2, 2, '2018-07-02 09:00:00', '2018-07-06 19:00:00', 350, 'libre'),
(3, 3, '2018-07-02 09:00:00', '2018-07-06 19:00:00', 780, 'reservation'),
(4, 4, '2018-07-02 09:00:00', '2018-07-06 19:00:00', 1750, 'reservation'),
(5, 5, '2018-07-02 09:00:00', '2018-07-06 19:00:00', 220, 'libre'),
(6, 6, '2018-07-02 09:00:00', '2018-07-06 19:00:00', 380, 'libre'),
(7, 7, '2018-07-02 09:00:00', '2018-07-06 19:00:00', 1730, 'libre'),
(8, 8, '2018-07-02 09:00:00', '2018-07-06 19:00:00', 650, 'libre'),
(9, 9, '2018-07-02 09:00:00', '2018-07-06 19:00:00', 590, 'libre'),
(10, 10, '2018-07-02 09:00:00', '2018-07-06 19:00:00', 50, 'reservation'),
(11, 11, '2018-07-02 09:00:00', '2018-07-06 19:00:00', 1, 'libre'),
(12, 12, '2018-07-02 09:00:00', '2018-07-06 19:00:00', 1, 'libre'),
(13, 1, '2018-07-09 09:00:00', '2018-07-13 19:00:00', 2300, 'libre'),
(14, 2, '2018-07-09 09:00:00', '2018-07-13 19:00:00', 350, 'libre'),
(15, 3, '2018-07-09 09:00:00', '2018-07-13 19:00:00', 780, 'libre'),
(16, 4, '2018-07-09 09:00:00', '2018-07-13 19:00:00', 1750, 'libre'),
(17, 5, '2018-07-09 09:00:00', '2018-07-13 19:00:00', 220, 'libre'),
(18, 6, '2018-07-09 09:00:00', '2018-07-13 19:00:00', 380, 'libre'),
(19, 7, '2018-07-09 09:00:00', '2018-07-13 19:00:00', 1730, 'libre'),
(20, 8, '2018-07-09 09:00:00', '2018-07-13 19:00:00', 650, 'libre'),
(21, 9, '2018-07-09 09:00:00', '2018-07-13 19:00:00', 590, 'libre'),
(22, 10, '2018-07-09 09:00:00', '2018-07-13 19:00:00', 50, 'libre'),
(23, 11, '2018-07-09 09:00:00', '2018-07-13 19:00:00', 1, 'libre'),
(24, 12, '2018-07-09 09:00:00', '2018-07-13 19:00:00', 1, 'libre');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

DROP TABLE IF EXISTS `salle`;
CREATE TABLE IF NOT EXISTS `salle` (
  `id_salle` int(3) NOT NULL AUTO_INCREMENT,
  `titre` varchar(200) NOT NULL,
  `description` text,
  `photo` varchar(200) DEFAULT NULL,
  `pays` varchar(20) DEFAULT NULL,
  `ville` varchar(20) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `cp` int(5) NOT NULL,
  `capacite` int(3) NOT NULL,
  `categorie` enum('reunion','bureau','formation') NOT NULL,
  PRIMARY KEY (`id_salle`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`id_salle`, `titre`, `description`, `photo`, `pays`, `ville`, `adresse`, `cp`, `capacite`, `categorie`) VALUES
(1, 'Titre.Salle.1', 'Description.Salle.1', 'http://localhost/lokisalle/photo/Titre.Salle.1_salle1.jpg', 'france', 'paris', 'Adresse.Salle.1', 75000, 40, 'formation'),
(2, 'Titre.Salle.2', 'Description.Salle.2', 'http://localhost/lokisalle/photo/Titre.Salle.2_salle2.jpg', 'france', 'paris', 'Adresse.Salle.2', 75000, 4, 'bureau'),
(3, 'Titre.Salle.3', 'Description.Salle.3', 'http://localhost/lokisalle/photo/Titre.Salle.3_salle3.jpg', 'france', 'paris', 'Adresse.Salle.3', 75000, 12, 'reunion'),
(4, 'Titre.Salle.4', 'Description.Salle.4', 'http://localhost/lokisalle/photo/Titre.Salle.5_salle5.jpg', 'france', 'lyon', 'Adresse.Salle.4', 69000, 72, 'formation'),
(5, 'Titre.Salle.5', 'Description.Salle.5', 'http://localhost/lokisalle/photo/Titre.Salle.5_salle5.jpg', 'france', 'lyon', 'Adresse.Salle.5', 69000, 3, 'bureau'),
(6, 'Titre.Salle.6', 'Description.salle.6', 'http://localhost/lokisalle/photo/Titre.Salle.6_salle6.jpg', 'france', 'lyon', 'Adresse.Salle.6', 69000, 22, 'reunion'),
(7, 'Titre.Salle.7', 'Description.Salle.7', 'http://localhost/lokisalle/photo/Titre.Salle.7_salle7.jpg', 'france', 'marseille', 'Adresse.Salle.7', 13000, 28, 'formation'),
(8, 'Titre.Salle.8', 'description.Salle.8', 'http://localhost/lokisalle/photo/Titre.Salle.8_salle8.jpg', 'france', 'marseillle', 'Adresse.Salle.8', 13000, 5, 'bureau'),
(9, 'Titre.Salle.9', 'Description.salle.9', 'http://localhost/lokisalle/photo/Titre.Salle.9_salle9.jpg', 'france', 'marseille', 'Adresse.Salle.9', 13000, 2, 'reunion'),
(10, 'Maison.Close', 'Description.Maison.Close', 'http://localhost/lokisalle/photo/Maison.Close_SkullGirls.png', 'france', 'paris', 'Adresse Maison Close', 75000, 90, 'formation'),
(11, 'BatCave', 'Description.BatCave', 'http://localhost/lokisalle/photo/BatCave_batman.jpg', 'france', 'lyon', 'manoir Wayne', 69000, 2, 'bureau'),
(12, 'Dentiste.Psychotique', 'Description.Dentiste', 'http://localhost/lokisalle/photo/Dentiste.Psychotique_dentiste.jpg', 'france', 'marseille', 'Ruelle sombre', 13000, 2, 'reunion');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
