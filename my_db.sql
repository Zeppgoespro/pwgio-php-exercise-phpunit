-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: database
-- Время создания: Сен 13 2023 г., 11:19
-- Версия сервера: 8.0.34
-- Версия PHP: 8.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `my_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `invoices`
--

CREATE TABLE `invoices` (
  `id` int UNSIGNED NOT NULL,
  `amount` decimal(10,4) DEFAULT NULL,
  `user_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `invoices`
--

INSERT INTO `invoices` (`id`, `amount`, `user_id`) VALUES
(1, 25.0000, 1),
(2, 115.9500, 1),
(3, 10500.0000, 1),
(4, 25.0000, 9),
(5, 33.0000, 11),
(6, 133.0000, 28),
(7, 99.0000, 45),
(8, 88.0000, 47),
(9, 10.0000, 50),
(10, 15.0000, 51),
(11, 8.0000, 52),
(12, 9.0000, 53),
(13, 18.0000, 54),
(14, 180.0000, 55),
(15, 1800.0000, 74),
(16, 88.0000, 75),
(17, 888.0000, 78);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `full_name`, `is_active`, `created_at`) VALUES
(1, 'john@doe.com', 'John Doe', 1, '2023-05-08 17:47:30'),
(3, 'buba@bookex.com', 'Buba Smith', 1, '2023-05-08 19:39:58'),
(4, 'yoda@sw.com', 'Yoda the Master', 1, '2023-05-08 19:39:58'),
(5, 'vader@sw.com', 'Darth Vader', 0, '2023-05-08 19:39:58'),
(6, 'skywalker@sw.com', 'Anakin Skywalker', 1, '2023-05-08 19:39:58'),
(7, 'bongo@bookex.com', 'Bingo Bongo', 1, '2023-05-10 21:05:00'),
(8, 'jungo@bookex.com', 'Bob Jungo', 0, '2023-05-10 22:05:00'),
(9, 'jango@bkex.com', 'Bob Jango', 1, '2023-05-11 20:38:11'),
(11, 'frodo@bkex.com', 'Frodo Baggins', 1, '2023-05-11 20:55:40'),
(28, 'bilbo@bkex.com', 'Bilbo Baggins', 1, '2023-05-14 11:03:48'),
(45, 'sam@bkex.com', 'Sam Gardener', 1, '2023-05-15 19:26:29'),
(47, 'pippin@bkex.com', 'Pip Took', 1, '2023-05-15 19:33:52'),
(50, 'tob@bkex.com', 'Tob Took', 1, '2023-05-15 19:38:30'),
(51, 'gnom@bkex.com', 'Gnom Blob', 1, '2023-05-15 19:52:23'),
(52, 'elf@bkex.com', 'Elf Hlob', 1, '2023-05-15 19:56:01'),
(53, 'mim@bkex.com', 'Mim Flob', 1, '2023-05-15 19:58:42'),
(54, 'hren@bkex.com', 'Hren Glob', 1, '2023-05-15 20:02:48'),
(55, 'frank@bkex.com', 'Frank Glob', 1, '2023-05-15 20:05:09'),
(74, 'shrek@bkex.com', 'Shrek Snob', 1, '2023-05-16 08:54:41'),
(75, 'zinzo@bkex.com', 'Zinzo Shvarkis', 1, '2023-05-16 08:56:49'),
(78, 'sponge@bkex.com', 'Sponge Bob', 1, '2023-05-26 19:58:02');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `is_active` (`is_active`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
