-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 28, 2021 at 07:35 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `don'hum_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `association`
--

DROP TABLE IF EXISTS `association`;
CREATE TABLE IF NOT EXISTS `association` (
  `idAsso` int(11) NOT NULL AUTO_INCREMENT,
  `emailAsso` varchar(255) NOT NULL,
  `mdpAsso` varchar(255) NOT NULL,
  `numTelAsso` varchar(10) NOT NULL,
  `descAsso` longtext NOT NULL,
  `nomAsso` varchar(200) NOT NULL,
  `RNA` varchar(10) NOT NULL,
  PRIMARY KEY (`idAsso`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `association`
--

INSERT INTO `association` (`idAsso`, `emailAsso`, `mdpAsso`, `numTelAsso`, `descAsso`, `nomAsso`, `RNA`) VALUES
(16, 'test@gmail.com', '25f9e794323b453885f5181f1b624d0b', '0102030405', 'prévenir et alléger en toutes circonstances les souffrances humaines. Protéger la vie et la santé ainsi qu\'à faire respecter la personnes humaine!', 'CROIX ROUGE FRANCAISE', 'W751004076'),
(17, 'asso@gmail.com', '882baf28143fb700b388a87ef561a6e5', '0102030405', 'l\'orientation, la rééducation et la formation professionnelle des personnes en situation de handicap, leur insertion ou réinsertion dans la vie économique et sociale afin de concourir à leur intégration dans la société ; informer l\'opinion sur ces sujets et d\'intervenir auprès des pouvoirs publics afin d\'obtenir les moyens de réaliser les objectifs définis à l\'alinéa précédent ; réunir les personnes en situation de handicap et leurs aidants en vue d\'engager les actions nécessaires à la mise en uvre des mesures législatives et règlementaires en faveurs des personnes en situation de handicap ; d\'informer les personnels d\'encadrement, de leur apporter la formation nécessaire ; la création et la gestion d\'établissements et de services ; et généralement toutes opérations financières, mobilières ou immobilières pouvant se rattacher directement ou indirectement à son objet social et à tous objets similaires ou connexes, ou susceptibles d\'en faciliter l\'application et le développement, le tout tant pour elle-même que pour le compte de tiers', 'ETAPE AUVERGNE', 'W431000434'),
(18, 'testAsso2@gmail.com', 'e40f01afbb1b9ae3dd6747ced5bca532', '0645786958', 'promouvoir le développement social et culturel sur la commune de Décines-Charpieu; concevoir et mettre en oeuvre un projet de développement social et culturel qui repose sur la participation des habitants des quartiers; s\'inscrire dans une dynamique globale de l\'action sociale en cohérence avec d\'autres partenaires; s\'engager dans une démarche démocratique et susciter des pratiques citoyennes et laïques', 'CENTRE SOCIAL DE LA BERTHAUDIERE', 'W691054577');

-- --------------------------------------------------------

--
-- Table structure for table `besoin`
--

DROP TABLE IF EXISTS `besoin`;
CREATE TABLE IF NOT EXISTS `besoin` (
  `idBesoin` int(11) NOT NULL AUTO_INCREMENT,
  `idAsso` int(11) NOT NULL,
  `articleName` varchar(255) NOT NULL,
  `articleQuantite` int(11) NOT NULL,
  PRIMARY KEY (`idBesoin`),
  KEY `idAsso` (`idAsso`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `besoin`
--

INSERT INTO `besoin` (`idBesoin`, `idAsso`, `articleName`, `articleQuantite`) VALUES
(1, 16, 'nuage', 2),
(2, 16, 'Petit nuage', 1),
(3, 17, 'arbres', 10),
(4, 17, 'Foscarini', 1);

-- --------------------------------------------------------

--
-- Table structure for table `particulier`
--

DROP TABLE IF EXISTS `particulier`;
CREATE TABLE IF NOT EXISTS `particulier` (
  `idPar` int(11) NOT NULL AUTO_INCREMENT,
  `emailPar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numTelPar` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `mdpPar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descPar` longtext COLLATE utf8_unicode_ci NOT NULL,
  `nomPar` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `prenomPar` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `cptDmd` int(11) NOT NULL,
  PRIMARY KEY (`idPar`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table host the Particulier data';

--
-- Dumping data for table `particulier`
--

INSERT INTO `particulier` (`idPar`, `emailPar`, `numTelPar`, `mdpPar`, `descPar`, `nomPar`, `prenomPar`, `cptDmd`) VALUES
(1, 'particulier@gmail.com', '0665020155', 'a43a2a73dedfe7951368ffabf1b86e57', 'Emporté par son élan que l\'artiste et la création d\'êtres tout-puissants. Vote distinct du budget des recettes et le budget extraordinaire. ', 'Dupond', 'Lisa', 30),
(2, 'part@gmail.com', '0665020155', '882baf28143fb700b388a87ef561a6e5', 'Dormez donc ainsi près de mourir, me dis-je ; demain matin j\'irai le rejoindre jeudi. Supposons que je ne fusse qu\'un commis et un garçon de service donnait un coup de chargé. ', 'TRAVES', 'Julien', 30),
(3, 'jean@gmail.com', '0601020315', '13f4d97cf5eec780f0affbee9817295b', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 'Dujardin', 'Jean', 30),
(4, 'marie.anne@gmail.com', '0665020155', 'acb2162ed88c911d8eb6bb1c8970abfd', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. ', 'Marie', 'Anne', 30),
(5, 'rajao@gmail.com', '0607080901', '881f81133d3efe4359460c03c1aa2cd2', 'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur', 'RAJAO', 'Martin', 30);

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `productID` int(11) NOT NULL AUTO_INCREMENT,
  `idPar` int(11) NOT NULL,
  `productImage` varchar(255) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productDesc` tinytext NOT NULL,
  `productKeywords` varchar(255) NOT NULL,
  `productValidite` int(11) NOT NULL DEFAULT '0',
  `productOwnerType` varchar(255) DEFAULT NULL,
  `productNewOwnerID` int(11) DEFAULT NULL,
  `productBesoinID` int(11) DEFAULT NULL,
  PRIMARY KEY (`productID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`productID`, `idPar`, `productImage`, `productName`, `productDesc`, `productKeywords`, `productValidite`, `productOwnerType`, `productNewOwnerID`, `productBesoinID`) VALUES
(1, 1, 'upload_60d9926e2d7e460d9926e2d7e5.jpg', 'Nuage', 'Allons à son atelier, et qui sentait que le plaisir que nous t\'avons rencontré nulle part, orphelin partout.', 'nuage,blanc', 2, 'association', 16, 0),
(2, 1, 'upload_60d9942333e1e60d9942333e20.jpg', 'petit nuage', 'Marié à l\'une de ces distinctions bizarres dans les diverses contrées, de plus effrayant...', 'nuage,petit,blanc', 2, 'association', 16, 2),
(3, 1, 'upload_60d995442ea5f60d995442ea61.png', 'truc_rejet', 'Mets-toi en sang, les conséquences terribles d\'un semblable chaos. Alliance offensive et défensive avec son insinuant visiteur', 'truc,rejet', 3, 'particulier', 5, 0),
(6, 1, 'upload_60d995b953bc660d995b953bc8.jpg', 'nuage', 'Les conséquences terribles d\'un semblable chaos. Alliance offensive et défensive avec son insinuant visiteur', 'nouveau,nuage,ok', 2, 'association', 16, 1),
(7, 1, 'upload_60d9982a2a84960d9982a2a854.jpg', 'fleurs', 'Beaucoup de fleurs jaunes', 'fleurs,fleur,jaune', 0, NULL, NULL, NULL),
(8, 1, 'upload_60d99859a399c60d99859a399e.jpg', 'arbres', 'Des arbres, beaucoup d\'arbres', 'arbres, arbre', 0, NULL, NULL, NULL),
(9, 2, 'upload_60d998918ba3f60d998918ba41.jpeg', 'Galaxy', 'Des étoiles', 'étoiles,stars', 0, NULL, NULL, NULL),
(10, 1, 'upload_60d998b05844160d998b058447.png', 'Foscarini', 'C\'est pas grave', 'grave,foscarini', 0, NULL, NULL, NULL),
(11, 2, 'upload_60d9996e6b9cf60d9996e6b9d0.jpg', 'Bibliothèque', 'Une grande biblio blanche', 'biblio', 0, NULL, NULL, NULL),
(12, 5, 'upload_60da0c408343160da0c4083433.jpg', 'Sosuke', 'Cute Sosuke', 'Sosuke,cute,tiny', 0, NULL, NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `besoin`
--
ALTER TABLE `besoin`
  ADD CONSTRAINT `idAsso` FOREIGN KEY (`idAsso`) REFERENCES `association` (`idAsso`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
