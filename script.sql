-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Czas generowania: 17 Lut 2021, 19:23
-- Wersja serwera: 10.3.16-MariaDB
-- Wersja PHP: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `id15524123_porownywarka_gier`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `games`
--

CREATE TABLE `games` (
  `ID` int(11) NOT NULL,
  `Name` varchar(75) NOT NULL,
  `Producent` varchar(60) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `game_categories`
--

CREATE TABLE `game_categories` (
  `ID_game` int(11) NOT NULL,
  `ID_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `game_shops`
--

CREATE TABLE `game_shops` (
  `ID_game` int(11) NOT NULL,
  `ID_shop` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `shops`
--

CREATE TABLE `shops` (
  `ID` int(11) NOT NULL,
  `ID_shop` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Link` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `shop_names`
--

CREATE TABLE `shop_names` (
  `ID` int(11) NOT NULL,
  `NameOfShop` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `game_categories`
--
ALTER TABLE `game_categories`
  ADD KEY `ID_game` (`ID_game`),
  ADD KEY `ID_category` (`ID_category`);

--
-- Indeksy dla tabeli `game_shops`
--
ALTER TABLE `game_shops`
  ADD KEY `ID_game` (`ID_game`),
  ADD KEY `ID_shop` (`ID_shop`);

--
-- Indeksy dla tabeli `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_shop` (`ID_shop`);

--
-- Indeksy dla tabeli `shop_names`
--
ALTER TABLE `shop_names`
  ADD PRIMARY KEY (`ID`);

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `game_categories`
--
ALTER TABLE `game_categories`
  ADD CONSTRAINT `game_categories_ibfk_1` FOREIGN KEY (`ID_game`) REFERENCES `games` (`ID`),
  ADD CONSTRAINT `game_categories_ibfk_2` FOREIGN KEY (`ID_category`) REFERENCES `categories` (`ID`);

--
-- Ograniczenia dla tabeli `game_shops`
--
ALTER TABLE `game_shops`
  ADD CONSTRAINT `game_shops_ibfk_1` FOREIGN KEY (`ID_game`) REFERENCES `games` (`ID`),
  ADD CONSTRAINT `game_shops_ibfk_2` FOREIGN KEY (`ID_shop`) REFERENCES `shops` (`ID`);

--
-- Ograniczenia dla tabeli `shops`
--
ALTER TABLE `shops`
  ADD CONSTRAINT `shops_ibfk_1` FOREIGN KEY (`ID_shop`) REFERENCES `shop_names` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
