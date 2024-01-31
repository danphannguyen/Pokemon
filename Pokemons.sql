-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mer. 31 jan. 2024 à 02:49
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `poo_pkm`
--

-- --------------------------------------------------------

--
-- Structure de la table `Pokemons`
--

CREATE TABLE `Pokemons` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `atk` int(11) NOT NULL,
  `pv` int(11) NOT NULL,
  `maxPv` int(11) NOT NULL,
  `lvl` int(11) NOT NULL,
  `typePkm` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Pokemons`
--

INSERT INTO `Pokemons` (`id`, `name`, `atk`, `pv`, `maxPv`, `lvl`, `typePkm`) VALUES
(1, 'pawniard', 10, 100, 100, 9, 'other'),
(9, 'snivy', 10, 100, 100, 10, 'Grass'),
(10, 'pignite', 20, 150, 150, 16, 'Fire'),
(11, 'oshawott', 10, 100, 100, 6, 'Water'),
(12, 'hydreigon', 30, 200, 200, 35, 'other'),
(13, 'whimsicott', 15, 120, 120, 14, 'Grass'),
(14, 'lillipup', 10, 80, 80, 5, 'other'),
(15, 'panpour', 15, 100, 100, 9, 'Water'),
(16, 'seismitoad', 20, 240, 240, 37, 'Water'),
(17, 'sawk', 20, 90, 90, 24, 'other'),
(18, 'zorua', 15, 90, 90, 9, 'other'),
(19, 'trubbish', 10, 40, 40, 6, 'other'),
(20, 'druddigon', 40, 120, 120, 30, 'other'),
(21, 'bisharp', 50, 90, 90, 43, 'other'),
(22, 'zekrom', 60, 300, 300, 58, 'other'),
(23, 'kyuremblack', 300, 900, 900, 63, 'other');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Pokemons`
--
ALTER TABLE `Pokemons`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Pokemons`
--
ALTER TABLE `Pokemons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
