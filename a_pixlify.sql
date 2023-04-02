-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Erstellungszeit: 22. Dez 2022 um 20:14
-- Server-Version: 5.7.34
-- PHP-Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `a_pixlify`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `articles`
--

CREATE TABLE `articles` (
  `ID` int(11) NOT NULL,
  `category` varchar(64) NOT NULL,
  `image` text NOT NULL,
  `title` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `articles`
--

INSERT INTO `articles` (`ID`, `category`, `image`, `title`, `description`, `date`, `userID`) VALUES
(16, 'photo', 'upload_1671720892.jpg', 'Sports', 'I\'m well experienced with shooting several types of sport events. If it\'s an Ironman with several spots to cover or your local football match - I\'m your guy to call. ', '2022-12-12 13:15:00', 684),
(17, 'photo', 'upload_1671720900.jpg', 'Events', 'If its a business style gathering for your company or a private hosted event, I\'d love to take photos for you. So far I\'ve shot many finance events and I would love to make your event unforgettable.', '2022-12-12 13:34:47', 684),
(19, 'photo', 'upload_1671721060.jpg', 'Weddings', 'Getting married? Let me help you to make your best day of your life unforgetable! I love shooting weddings and capture raw emotions as real as possible. ', '2022-12-12 13:36:33', 684),
(41, 'video', 'upload_1671721119.jpg', 'Weddings', 'Getting married? Let me help you to make your best day of your life unforgetable! I love filming weddings and create a video to remember forever! ', '2022-12-22 14:58:39', 684),
(42, 'video', 'upload_1671721480.jpg', 'Cameraoperator', 'Do you need a cameraoperator for your event? I have experience with live events, tv productions and behind the scenes clips. Tell me about your event and let\'s produce something nice! ', '2022-12-22 15:04:40', 685),
(43, 'video', 'upload_1671721680.jpg', 'No time to learn how to cut a video?', 'You have filmed your project by yourself and have no time to learn to cut? Allow me to help you and make the best out of your clips!  ', '2022-12-22 15:08:00', 685),
(44, 'web', 'upload_1671721959.jpg', 'Concept', 'Need a new Concept / Redesign for your website? Allow me to pitch you a mockup that really describes your work.', '2022-12-22 15:12:39', 685),
(45, 'web', 'upload_1671722046.jpg', 'Custom Site', 'Need a new website from A-Z? From a completely custom CMS to a cheaper solution with Wordpress or other Content Management Systems, I\'m here to help. ', '2022-12-22 15:14:06', 684),
(46, 'web', 'upload_1671722131.jpg', 'Website getting old and unresponsive? ', 'Let me have a look at it, and we can discuss together what can be improved for a thight budget or let\'s figure out something completly new together.', '2022-12-22 15:15:31', 684);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `customer`
--

CREATE TABLE `customer` (
  `ID` int(11) NOT NULL,
  `projecttitle` varchar(255) NOT NULL,
  `userID` int(11) NOT NULL,
  `zip` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `customer`
--

INSERT INTO `customer` (`ID`, `projecttitle`, `userID`, `zip`, `date`) VALUES
(14, 'Swisscom Jahresfest 2022', 687, 'upload_1671554544.zip', '2022-12-20 16:42:24'),
(15, 'Swisscom Lunch Break', 687, 'upload_1671554703.zip', '2022-12-19 16:45:03'),
(16, 'Testfile', 686, 'upload_1671554731.zip', '2022-12-20 16:45:31');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `usertype` tinyint(9) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`ID`, `usertype`, `username`, `email`, `password`) VALUES
(684, 1, 'Admin', 'admin@email.com', '$2y$10$LmviRJK6TkIMxhPDyZzinObwrfogG6gkJ8pGYplXjrMCZ6Myl1ob6'),
(685, 2, 'Teammember', 'teammember@email.com', '$2y$10$TE50jnZVirnmASjTMGgN7eh3jcwVwhOYpc5Px3POpnAIg1mb182Hy'),
(686, 3, 'Customer', 'customer@email.com', '$2y$10$VBlQcAXJcZXZrktQ.EHwXeNZP3L//YivYHvW3H3BWaZ2FeomMcXhu'),
(687, 3, 'Swisscom', 'swisscom@mail.com', '$2y$10$UZlOvWk//zZooC2G06iiVe4hwSNU3iLXiljyH5XKDcwZZ12urfMDm');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `articles`
--
ALTER TABLE `articles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT für Tabelle `customer`
--
ALTER TABLE `customer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=691;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
