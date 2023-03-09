-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 13-11-2022 a las 14:07:13
-- Versión del servidor: 5.7.36
-- Versión de PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pokinator`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arbol` donde se almacenará los datos de los pokemons y preguntas
--

DROP TABLE IF EXISTS `arbol`;
CREATE TABLE IF NOT EXISTS `arbol` (
  `nodo` int(11) NOT NULL,
  `texto` varchar(500) DEFAULT NULL,
  `pregunta` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`nodo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `arbol`
--

INSERT INTO `arbol` (`nodo`, `texto`, `pregunta`) VALUES
(2, 'Es de color blau?', 1),
(3, 'Es de tipus foc?', 1),
(1, 'Es de tipus planta?', 1),
(6, 'Camina a quatre potes?', 1),
(7, 'Es de tipus aigua?', 1),
(14, 'Es vermell?', 1),
(15, 'Es de tipus normal?', 1),
(30, 'Esta gras?', 1),
(31, 'Es de tipus electric?', 1),
(4, 'Oddish', 0),
(5, 'Camina a dues potes?', 1),
(10, 'Te cua?', 1),
(11, 'Te el coll llarg?', 1),
(22, 'Meganium', 0),
(23, 'Bulbasur', 0),
(20, 'Snivy', 0),
(21, 'Roselia', 0),
(62, 'Te un llamp per cua?', 1),
(250, 'Magnemite', 0),
(124, 'Pikachu', 0),
(125, 'Te imants com a braços?', 1),
(251, 'Vola?', 1),
(502, 'Emolga', 0),
(503, 'Es de color groc?', 1),
(1006, 'Ampharos', 0),
(1007, 'Voltorb', 0),
(12, 'Rapidash', 0),
(13, 'Te orelles?', 1),
(26, 'Pansear', 0),
(54, 'Cyndaquil', 0),
(55, 'Es segona evolució?', 1),
(27, 'Te foc a l`esquena?', 1),
(110, 'Combusken', 0),
(111, 'Charmander', 0),
(28, 'Te tentacles?', 1),
(29, 'És llegendari?', 1),
(56, 'Octillery', 0),
(57, 'Magikarp', 0),
(58, 'Kyogre', 0),
(59, 'Te aletes?', 1),
(118, 'Sharpedo', 0),
(119, 'Squirtle', 0),
(60, 'Es rosa?', 1),
(61, 'Es de color lila?', 1),
(120, 'Miltank', 0),
(121, 'Snorlax', 0),
(122, 'Ditto', 0),
(123, 'Te orelles?', 1),
(247, 'Porygon', 0),
(246, 'Eevee', 0),
(63, 'Es de tipus psiquic?', 1),
(126, 'Te forma humanoide?', 1),
(253, 'Cosmog', 0),
(252, 'Es de color groc?', 1),
(504, 'Abra', 0),
(505, 'Es llegendari?', 1),
(1010, 'Es de color lila?', 1),
(1011, 'Mr. Mime', 0),
(2020, 'Mewtwo', 0),
(2021, 'Deoxys', 0),
(127, 'Es de tipus roca?', 1),
(254, 'Vola?', 1),
(508, 'Aerodactyl', 0),
(509, 'Es de color verd?', 1),
(1018, 'Larvitar', 0),
(1019, 'Te forma de llop?', 1),
(2038, 'Lycanroc', 0),
(2039, 'Es rodó?', 1),
(4078, 'Golem', 0),
(4079, 'Onix', 0),
(255, 'Es de tipus acer?', 1),
(510, 'Es verd?', 1),
(1020, 'Bronzong', 0),
(1021, 'Te quatre potes?', 1),
(2042, 'Es segona evolució?', 1),
(2043, 'Es llegendari?', 1),
(4084, 'Lairon', 0),
(4085, 'Metagross', 0),
(4086, 'Jirachi', 0),
(4087, 'Meltan', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida` donde se almacenará los aciertos de la partida
--

DROP TABLE IF EXISTS `partida`;
CREATE TABLE IF NOT EXISTS `partida` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personaje` varchar(500) DEFAULT NULL,
  `acierto` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=127 DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
