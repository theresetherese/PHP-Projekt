-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Värd: 193.17.218.137
-- Skapad: 24 oktober 2011 kl 23:23
-- Serverversion: 5.1.41
-- PHP-version: 5.3.2-1ubuntu4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `110711-whattoeat`
--

-- --------------------------------------------------------

--
-- Struktur för tabell `User`
--

DROP TABLE IF EXISTS `User`;
CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `password` char(128) NOT NULL,
  `email` varchar(80) NOT NULL,
  `cookie` char(128) NOT NULL,
  `ip` varchar(39) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Data i tabell `User`
--

INSERT INTO `User` (`id`, `username`, `password`, `email`, `cookie`, `ip`) VALUES
(1, 'Email', '2907305e0eaf0b64a86e6c0eae383c042dd05f23ff8d18843f0b618a4180ff4103373bde72e6e36daa8f8247dbe74abde746925dbd41851f3fe0a4ebee137cfc', 'therese.x@gmail.com', '', ''),
(2, 'Test', '18d57470291a09c574a3f33fe5904cc7c4b4b232ca1117475b2ba66333933df8c5f1b6ee11782e1401ae591d5e01903070d1e3a1ac43e3d5e86c1a48f647e5a0', 'therese.x@gmail.com', '', '');
