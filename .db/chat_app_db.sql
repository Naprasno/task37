-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 29 2022 г., 11:31
-- Версия сервера: 8.0.24
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `chat_app_db`
--
CREATE DATABASE IF NOT EXISTS `chat_app_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `chat_app_db`;

-- --------------------------------------------------------

--
-- Структура таблицы `chats`
--

CREATE TABLE `chats` (
  `chat_id` int NOT NULL,
  `from_id` int NOT NULL,
  `to_id` int NOT NULL,
  `message` text NOT NULL,
  `opened` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `chats`
--

INSERT INTO `chats` (`chat_id`, `from_id`, `to_id`, `message`, `opened`, `created_at`) VALUES
(1, 2, 1, '123', 1, '2022-05-29 10:45:52'),
(2, 1, 2, 'qwertyuiop', 1, '2022-05-29 10:48:32'),
(3, 1, 3, '123', 0, '2022-05-29 11:08:25'),
(4, 4, 3, 'www', 0, '2022-05-29 11:28:58'),
(5, 4, 3, 'w', 0, '2022-05-29 11:29:04');

-- --------------------------------------------------------

--
-- Структура таблицы `conversations`
--

CREATE TABLE `conversations` (
  `conversation_id` int NOT NULL,
  `user_1` int NOT NULL,
  `user_2` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `conversations`
--

INSERT INTO `conversations` (`conversation_id`, `user_1`, `user_2`) VALUES
(1, 2, 1),
(2, 1, 3),
(3, 4, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `p_p` varchar(255) DEFAULT 'user-default.png',
  `last_seen` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hidden` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `name`, `username`, `password`, `p_p`, `last_seen`, `hidden`) VALUES
(1, 'тест1', 'code.94@mail.ru', '$2y$10$p/cmJOTly8xnGhXNQmIDpeCxW4QIA.3rWOAHekivUf5SK.l5wYlfW', 'code.94@mail.ru.png', '2022-05-29 11:31:43', 0),
(2, 'ник', 'asdf@qwer.ty', '$2y$10$XLsbjXmJBd2sFtEK3uHmOOQi1xddBPrZN9qyvIXloS2veuZEgNP6G', 'user-default.png', '2022-05-29 11:07:03', 0),
(3, 'Skillfactory', 'qqq@qqq.q', '$2y$10$g6aDxP7GWjM.94M8mod6Iu0xTUvKTxsDZnzOtBlgov.y/Myavi17C', 'qqq@qqq.q.png', '2022-05-29 11:08:05', 1),
(4, 'www', 'www@www', '$2y$10$7kLEuYjOfbNeaCJoagye1OfeSwjhwdYn5q/uEHKog7NGUbLUIFm2.', 'www@www.png', '2022-05-29 11:31:47', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`);

--
-- Индексы таблицы `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`conversation_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `conversations`
--
ALTER TABLE `conversations`
  MODIFY `conversation_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
