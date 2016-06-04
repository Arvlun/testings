-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 20 maj 2016 kl 16:07
-- Serverversion: 5.6.17
-- PHP-version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `hipp`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `lagraskit`
--

CREATE TABLE IF NOT EXISTS `lagraskit` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `namn` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ingred` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `pris` int(11) NOT NULL,
  `fampris` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=armscii8 AUTO_INCREMENT=5 ;

--
-- Dumpning av Data i tabell `lagraskit`
--

INSERT INTO `lagraskit` (`ID`, `namn`, `ingred`, `pris`, `fampris`) VALUES
(1, 'Groda', 'fdsf', 23, 233),
(2, 'tretre', 'tretre', 345, 3443),
(3, 'tretre', 'tret', 343, 343),
(4, 'rewrewrr', 'rewrewrw', 432432, 432432);

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(64) COLLATE utf8_unicode_ci NOT NULL,
  `salt` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `email`) VALUES
(1, 'ewqewqewq', 'bfb76310a44f0069247174c20fc59dd3fe6f4e12ba9f45a3fc5e884eacecd8b7', '3d4d46a65f66461f', 'testing@testmail.com'),
(2, 'grodan', '8dfe54f6336c758eeb58692b1a3f9e7022a055377845967acffa82ec0bae499a', '3c40cded6f237669', 'grodan@grodan.com'),
(3, 'Gregert', '457715cbf3eabb13a54c1a17e432ad72244d910aaa36b6c8008c7d0f57ce39e8', '24b123f2e3c39df', 'gregert@gmail.com'),
(4, 'fylletratt', '768ba462595900372f2f2472be5be208ab4483ddd1f9e36e996fff6b7abd8fbe', '38bedfe75689b97c', 'fylletratt@tratthatt.com'),
(5, 'sohrab', '6de945a102e02cf83d33bf5be9cbc0c93038711b3b8db944e292687fec1ecba2', 'efd324341466046', 'sohrab@sohrabsmail.com'),
(6, 'g', '5eca265a4c9e0635d428b4521bc94acba83c6db317733463057537f7389372e9', '4f2b2a7a7e1c0b8a', 'ggdfsgdfs@gmail.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
