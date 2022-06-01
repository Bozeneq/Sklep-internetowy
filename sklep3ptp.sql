-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 01 Cze 2022, 21:12
-- Wersja serwera: 10.4.21-MariaDB
-- Wersja PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `sklep3ptp`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `categories`
--

CREATE TABLE `categories` (
  `category_id` int(30) NOT NULL,
  `category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `categories`
--

INSERT INTO `categories` (`category_id`, `category`) VALUES
(1, 'Książki'),
(2, 'Podręczniki'),
(3, 'Kampanie'),
(4, 'Akcesoria'),
(5, 'Kości'),
(6, 'Wierze'),
(7, 'Figurki'),
(8, 'Maty');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `orders`
--

CREATE TABLE `orders` (
  `order_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `adress` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `status`, `date`, `adress`) VALUES
(4, 5, 'przetwarzanie', '2022-06-01', 'abcd'),
(5, 4, 'przetwarzanie', '2022-06-01', 'dcba');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `order_prod`
--

CREATE TABLE `order_prod` (
  `id` int(30) NOT NULL,
  `order_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `ilosc` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `products`
--

CREATE TABLE `products` (
  `product_id` int(30) NOT NULL,
  `product` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `products`
--

INSERT INTO `products` (`product_id`, `product`, `description`, `price`) VALUES
(20, 'DnD: Podręcznik gracza', 'Podręcznik zawierający podstawowe zasady systemu DnD.', 199.95),
(22, 'DnD: Podrzęcznik mistrza gry', 'Podręcznik zawierający zaawansowane zasady systemu DnD.', 199.95),
(23, 'DnD: Księga potworów', 'Księga potworów do wykorzystania w systemie DnD.', 199.95),
(24, 'Journeys Through the Radiant Citadel', 'Zestaw 13 przygód w Radiant Citadel.', 219.95),
(25, 'DnD: Zstąpienie do Avernusa', 'Przygoda osadzona we Wrotach Baldura, prowadząca do pierwszego poziomu piekła.', 199.95),
(26, 'Kości (Czarne)', 'Zestaw czarnych kości do gier RPG.', 24.99),
(27, 'Kości (Niebieskie)', 'Zestaw niebieskich kości do gier RPG.', 24.99),
(28, 'Kości (Zielone)', 'Zestaw zielonych kości do gier RPG.', 24.99),
(29, 'Kości (Czerwone)', 'Zestaw czerwonych kości do gier RPG.', 24.99),
(30, 'UGears - Modularna wierza na kości', 'Modular Dice Tower składa się z czterech sześciennych „kubków” do mieszania kości, zaprojektowanych dla czterech graczy. Poręczne spersonalizowane rozwiązanie pozwoli zaoszczędzić miejsce na stole.', 159.95),
(31, 'Dice Tower - Medieval', 'Ta wyjątkowa wieża do kości jest arcydziełem naszych najlepszych architektów. Dzięki niej Wasze kości do gry już nigdy więcej nie spadną ze stołu, a oryginalny design zapewni niepowtarzalną atmosferę podczas rozgrywek!Zestaw pozwala na samodzielne złożenie wieży z pojedynczych elementów.', 93.95),
(32, 'Wierza do kości - Zew Cthulhu', 'Wyjątkowa wieża do kości, stworzona na potrzeby kampani Call of Cthulhu Outer Gods. Dzięki niej Wasze kości do gry już nigdy więcej nie spadną ze stołu, a oryginalny wzór COC zapewni niepowtarzalną atmosferę podczas sesji gamingowych w uniwersum Lovecrafta. Zestaw pozwala na samodzielne złożenie wieży z pojedynczych elementów.', 93.95),
(33, 'DnD - Barbarzyńca', 'Figurka barbarzyńcy.', 39.95),
(34, 'DnD - Czarodziej', 'Figurka czarodzieja.', 39.95),
(35, 'DnD - Łotr', 'Figurka łotra.', 39.95),
(36, 'DnD - Bard', 'Figurka barda.', 39.95),
(37, 'DnD - Wojownik', 'Figurka wojownika.', 39.95),
(38, 'DnD - Druid', 'Figurka druida.', 39.95),
(39, 'DnD - Zaklinacz', 'Figurka zaklinacza.', 39.95),
(40, 'DnD - Czarownik', 'Figurka czarownika.', 39.95),
(41, 'DnD - Łowca', 'Figurka łowcy.', 39.95),
(42, 'DnD - Czerowny smok', 'Figurka starszego czerwonego smoka.', 79.99),
(43, 'Mata 80x80cm', 'Suchościeralna mata 80x80cm w kratkę.', 120),
(44, 'Mata 60x60cm', 'Suchościeralna mata 60x60cm w kratkę.', 69.99),
(45, 'Mata modularna', 'Mata modularna, składająca się z 9 odczepianych elementów 20x20cm.', 95.55);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product_cat`
--

CREATE TABLE `product_cat` (
  `prod_cat_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `category_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `product_cat`
--

INSERT INTO `product_cat` (`prod_cat_id`, `product_id`, `category_id`) VALUES
(143, 33, 4),
(144, 33, 7),
(145, 34, 4),
(146, 34, 7),
(147, 35, 4),
(148, 35, 7),
(149, 36, 4),
(150, 36, 7),
(151, 37, 4),
(152, 37, 7),
(153, 38, 4),
(154, 38, 7),
(155, 39, 4),
(156, 39, 7),
(157, 40, 4),
(158, 40, 7),
(159, 41, 4),
(160, 41, 7),
(173, 23, 1),
(174, 23, 2),
(175, 20, 1),
(176, 20, 2),
(177, 22, 1),
(178, 22, 2),
(179, 25, 1),
(180, 25, 3),
(181, 26, 4),
(182, 26, 5),
(183, 27, 4),
(184, 27, 5),
(185, 28, 4),
(186, 28, 5),
(187, 29, 4),
(188, 29, 5),
(191, 42, 4),
(192, 42, 7),
(193, 43, 4),
(194, 43, 8),
(195, 44, 4),
(196, 44, 8),
(203, 32, 4),
(204, 32, 6),
(205, 24, 1),
(206, 24, 3),
(207, 30, 4),
(208, 30, 6),
(209, 31, 4),
(210, 31, 6),
(211, 45, 4),
(212, 45, 8);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(30) NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surename` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`user_id`, `login`, `password`, `admin`, `name`, `surename`) VALUES
(1, 'admin', 'admin', 1, 'Admin', 'Admin'),
(4, 'lisjan', 'lisjan', 0, 'Jan', 'Lis'),
(5, 'ryśmaciek', 'ryśmaciek', 0, 'Maciek', 'Ryś');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indeksy dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeksy dla tabeli `order_prod`
--
ALTER TABLE `order_prod`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeksy dla tabeli `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeksy dla tabeli `product_cat`
--
ALTER TABLE `product_cat`
  ADD PRIMARY KEY (`prod_cat_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT dla tabeli `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `order_prod`
--
ALTER TABLE `order_prod`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT dla tabeli `product_cat`
--
ALTER TABLE `product_cat`
  MODIFY `prod_cat_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ograniczenia dla tabeli `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ograniczenia dla tabeli `order_prod`
--
ALTER TABLE `order_prod`
  ADD CONSTRAINT `order_prod_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_prod_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Ograniczenia dla tabeli `product_cat`
--
ALTER TABLE `product_cat`
  ADD CONSTRAINT `product_cat_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `product_cat_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
