-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 01 fév. 2018 à 09:09
-- Version du serveur :  10.1.28-MariaDB
-- Version de PHP :  7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `billing_campost`
--

-- --------------------------------------------------------

--
-- Structure de la table `bill_file`
--

CREATE TABLE `bill_file` (
  `id` int(11) NOT NULL,
  `bill_number` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `period` varchar(32) NOT NULL,
  `file_path` varchar(32) NOT NULL,
  `zone` varchar(50) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `customerID` int(11) NOT NULL,
  `deleted` varchar(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `uin` varchar(50) NOT NULL,
  `business_register` varchar(100) NOT NULL,
  `bank` varchar(100) DEFAULT NULL,
  `account_number` varchar(100) DEFAULT NULL,
  `town` varchar(50) NOT NULL,
  `adress` varchar(100) DEFAULT NULL,
  `postal_box` varchar(50) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `deleted` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `customer`
--

INSERT INTO `customer` (`id`, `name`, `uin`, `business_register`, `bank`, `account_number`, `town`, `adress`, `postal_box`, `phone_number`, `deleted`) VALUES
(1, 'hjto', '12589', '33698', 'ecoobank', '', 'bafssam', '', '2654', '694861095', 1),
(2, 'garine', '1236321', '5876652', '', '123652145', 'ydé', '', '5874', '587', 1),
(3, 'hjkl', '12589', '33698', 'ecoobank', '', 'bafssam', '', '2654', '6985478', 0),
(4, 'dfdfdf', '1254dfd1258874', 'dfdfd698', 'ecobank', '123698', 'tyui', 'ghghghggh', '1254', '12368', 0);

-- --------------------------------------------------------

--
-- Structure de la table `state_file`
--

CREATE TABLE `state_file` (
  `id` int(50) NOT NULL,
  `date` date NOT NULL,
  `period` int(11) NOT NULL,
  `file_path` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `customerID` int(11) NOT NULL,
  `deleted` int(5) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bill_file`
--
ALTER TABLE `bill_file`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customerID` (`customerID`) USING BTREE;

--
-- Index pour la table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `state_file`
--
ALTER TABLE `state_file`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bill_file`
--
ALTER TABLE `bill_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `state_file`
--
ALTER TABLE `state_file`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `bill_file`
--
ALTER TABLE `bill_file`
  ADD CONSTRAINT `bill_file_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
