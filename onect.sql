-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Авг 13 2025 г., 15:15
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `onect`
--

-- --------------------------------------------------------

--
-- Структура таблицы `activation`
--

CREATE TABLE `activation` (
  `id` int(32) NOT NULL,
  `actkey` text NOT NULL,
  `user_id` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `banlist`
--

CREATE TABLE `banlist` (
  `id` int(16) NOT NULL,
  `user_id` int(16) NOT NULL COMMENT 'ID пользователя',
  `reason` text DEFAULT NULL COMMENT 'Причина бана'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `chats`
--

CREATE TABLE `chats` (
  `id` int(32) NOT NULL,
  `type` int(1) NOT NULL DEFAULT 0,
  `keyring` text DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `parametrs` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(16) NOT NULL,
  `post_id` int(16) NOT NULL,
  `user_id` int(16) NOT NULL,
  `text` varchar(512) NOT NULL,
  `date` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int(32) NOT NULL,
  `name` varchar(50) NOT NULL,
  `verify` int(1) DEFAULT 0,
  `description` varchar(200) DEFAULT NULL,
  `owner_id` int(32) NOT NULL,
  `admins` text DEFAULT NULL,
  `anonim` int(1) NOT NULL DEFAULT 0,
  `type` int(1) NOT NULL DEFAULT 0,
  `sub` int(11) NOT NULL DEFAULT 0,
  `img50` varchar(255) DEFAULT NULL,
  `img100` varchar(255) DEFAULT NULL,
  `img200` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `im`
--

CREATE TABLE `im` (
  `id` int(16) NOT NULL,
  `chat_id` int(16) NOT NULL DEFAULT 0,
  `from_id` int(16) NOT NULL,
  `date` int(32) NOT NULL,
  `text` text NOT NULL,
  `file` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `likes`
--

CREATE TABLE `likes` (
  `id` int(16) NOT NULL,
  `post_id` int(16) NOT NULL,
  `user_id` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `music`
--

CREATE TABLE `music` (
  `id` int(16) NOT NULL,
  `filename` varchar(50) NOT NULL,
  `user_id` int(16) NOT NULL,
  `name` varchar(100) NOT NULL,
  `author` varchar(50) NOT NULL,
  `date` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `post`
--

CREATE TABLE `post` (
  `id` int(16) NOT NULL,
  `id_user` int(16) NOT NULL,
  `id_who` int(16) NOT NULL,
  `post` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `img` varchar(256) DEFAULT NULL,
  `pin` int(1) NOT NULL DEFAULT 0,
  `date` int(64) NOT NULL,
  `verify` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sub`
--

CREATE TABLE `sub` (
  `id` int(64) NOT NULL,
  `type` int(2) NOT NULL,
  `user_id` int(16) NOT NULL,
  `item_id` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(16) NOT NULL,
  `email` varchar(128) NOT NULL,
  `name` varchar(50) NOT NULL,
  `pass` text NOT NULL,
  `ip` varchar(16) NOT NULL,
  `descr` varchar(256) DEFAULT NULL,
  `ban` int(1) NOT NULL DEFAULT 0,
  `yespost` varchar(3) NOT NULL DEFAULT '0',
  `priv` int(1) NOT NULL DEFAULT 0,
  `img50` varchar(255) DEFAULT NULL,
  `img100` varchar(255) DEFAULT NULL,
  `img200` varchar(255) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `token` varchar(64) DEFAULT NULL,
  `secret` varchar(256) DEFAULT NULL,
  `auth` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `activation`
--
ALTER TABLE `activation`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `banlist`
--
ALTER TABLE `banlist`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `im`
--
ALTER TABLE `im`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `music`
--
ALTER TABLE `music`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sub`
--
ALTER TABLE `sub`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `activation`
--
ALTER TABLE `activation`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `banlist`
--
ALTER TABLE `banlist`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `im`
--
ALTER TABLE `im`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `music`
--
ALTER TABLE `music`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `post`
--
ALTER TABLE `post`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `sub`
--
ALTER TABLE `sub`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
