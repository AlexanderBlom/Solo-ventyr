-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 11 okt 2018 kl 10:22
-- Serverversion: 10.1.29-MariaDB
-- PHP-version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `soloäventyr`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `story`
--

CREATE TABLE `story` (
  `id` int(10) UNSIGNED NOT NULL,
  `text` text COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumpning av Data i tabell `story`
--

INSERT INTO `story` (`id`, `text`) VALUES
(1, 'Violetta ligger sjuk i sin säng.\r\nHennes far har kallat dig för att hjälpa henne. \r\n\r\nVill du undersöka Violetta eller gå därifrån?'),
(3, 'Du går med på att undersöka Violetta. <br>För att kunna stjäla hennes organ så måste du lura Giorgio ut ur rummet.\r\n\r\nVad gör du?'),
(4, 'Du lämnar Violettas sovrum och lämnar henne för att dö. Giorgio svär att han kommer döda dig och du lever resten av ditt liv i flykt.'),
(5, 'Du hjälper Violetta och hon överlever. Du lever resten av ditt liv besviken över att du inte lyckades stjäla hennes njurar'),
(6, 'Giorgio går med på att hämta din väska. Han lämnar Violettas sovrum och du är nu ensam. <br>För att kunna stjäla Violettas njurar måste du söva ner henne. Vill du söva ner Violetta eller hjälpa henne?'),
(7, 'Du ber Violetta lukta på din trasa doppad i kloroform. Hon somnar snabbt och när du skär upp henne så får du ett smörgåsbord av organ. <br>Giorgio borde vara tillbaka vilken sekund som helst så du har bara tid att ta ett organ. Vilket väljer du?');

-- --------------------------------------------------------

--
-- Tabellstruktur `storylinks`
--

CREATE TABLE `storylinks` (
  `id` int(10) UNSIGNED NOT NULL,
  `storyid` int(10) UNSIGNED NOT NULL,
  `target` int(10) UNSIGNED NOT NULL,
  `text` varchar(128) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumpning av Data i tabell `storylinks`
--

INSERT INTO `storylinks` (`id`, `storyid`, `target`, `text`) VALUES
(1, 1, 3, 'Undersök Violetta'),
(2, 1, 4, 'Gå därifrån'),
(3, 3, 5, 'Hjälp Violetta'),
(4, 3, 7, 'Be Giorgio att hämta ett glas vatten'),
(5, 3, 6, 'Be Giorgio att hämta din väska med doktor redskap'),
(6, 4, 1, 'Börja om'),
(7, 6, 5, 'Hjälp Violetta'),
(8, 6, 7, 'Söv ner Violetta'),
(9, 7, 8, 'Lungorna'),
(10, 7, 9, 'Njurarna'),
(11, 7, 10, 'Tarmarna');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `story`
--
ALTER TABLE `story`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `storylinks`
--
ALTER TABLE `storylinks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `storyid` (`storyid`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `story`
--
ALTER TABLE `story`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT för tabell `storylinks`
--
ALTER TABLE `storylinks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
