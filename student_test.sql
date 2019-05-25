-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 25 2019 г., 19:04
-- Версия сервера: 5.7.20
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `student_test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `request`
--

CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `test` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'тест в сериализованном виде',
  `test_id` int(11) NOT NULL COMMENT 'id изменяемого теста, если равно 0, то это новый тест',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `test` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'тест в сериализованном виде',
  `description` text COLLATE utf8mb4_unicode_ci,
  `time` datetime NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Добавивший пользователь',
  `admin_id` int(11) NOT NULL COMMENT 'Одобривший заявку админ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `test`
--

INSERT INTO `test` (`id`, `test`, `description`, `time`, `user_id`, `admin_id`) VALUES
(1, 'a:8:{i:0;a:3:{s:8:\"question\";s:44:\"А еще один вопрос, он же 6\";s:4:\"true\";a:3:{i:0;s:63:\"А это ответ на 6 вопрос 1 правильный\";i:1;s:60:\"Еще ответ на 6 вопрос 3 правильный\";i:2;s:53:\"Ответ на 6 вопрос 2 правильный\";}s:5:\"false\";a:0:{}}i:1;a:3:{s:8:\"question\";s:25:\"Вопрос номер 1\";s:4:\"true\";a:1:{i:0;s:53:\"Ответ 1 на вопрос 1 правильный\";}s:5:\"false\";a:3:{i:0;s:57:\"Ответ 2 на вопрос 1 неправильный\";i:1;s:62:\"еще ответ на вопрос 1 неправильный\";i:2;s:66:\"ответ 3 на вопрос 1 тоже неправильный\";}}i:2;a:3:{s:8:\"question\";s:45:\"Вопрос номер 8, последний\";s:4:\"true\";a:2:{i:0;s:53:\"Ответ на 8 вопрос 1 правильный\";i:1;s:53:\"Ответ на 8 вопрос 2 правильный\";}s:5:\"false\";a:1:{i:0;s:64:\"Еще ответ на 8 вопрос 2 неправильный\";}}i:3;a:3:{s:8:\"question\";s:43:\"Давай еще вопрос, он же 3\";s:4:\"true\";a:2:{i:0;s:60:\"Еще ответ на 3 вопрос 2 правильный\";i:1;s:53:\"Ответ на 3 вопрос 1 правильный\";}s:5:\"false\";a:1:{i:0;s:57:\"Ответ на 3 вопрос 2 неправильный\";}}i:4;a:3:{s:8:\"question\";s:30:\"Еще один вопрос 4\";s:4:\"true\";a:2:{i:0;s:60:\"Еще ответ на 4 вопрос 3 правильный\";i:1;s:53:\"Ответ на 4 вопрос 1 правильный\";}s:5:\"false\";a:1:{i:0;s:57:\"Ответ на 4 вопрос 2 неправильный\";}}i:5;a:3:{s:8:\"question\";s:41:\"Еще один вопрос, он же 2\";s:4:\"true\";a:2:{i:0;s:58:\"Еще ответ на вопрос 2 правильный\";i:1;s:53:\"Ответ на 2 вопрос 1 правильный\";}s:5:\"false\";a:1:{i:0;s:57:\"Ответ на 2 вопрос 2 неправильный\";}}i:6;a:3:{s:8:\"question\";s:58:\"И еще один вопрос, вопрос номер 7\";s:4:\"true\";a:2:{i:0;s:58:\"Еще ответ на вопрос 7 правильный\";i:1;s:53:\"Ответ на 7 вопрос 1 правильный\";}s:5:\"false\";a:1:{i:0;s:32:\"Ответ на 7 вопрос 2\";}}i:7;a:3:{s:8:\"question\";s:79:\"Я - вопрос на который надо дать ответ, он же 5\";s:4:\"true\";a:2:{i:0;s:64:\"На 5 вопрос ответ номер 3 правильный\";i:1;s:85:\"Ответ номер 1 правильный на вопрос 5 правильный\";}s:5:\"false\";a:2:{i:0;s:68:\"Ответ на 5 вопрос номер 2 неправильный\";i:1;s:62:\"еще ответ на вопрос 5 неправильный\";}}}', 'dasdadas', '2019-05-25 06:22:43', 6, 1),
(2, 'a:8:{i:0;a:3:{s:8:\"question\";s:44:\"А еще один вопрос, он же 6\";s:4:\"true\";a:3:{i:0;s:63:\"А это ответ на 6 вопрос 1 правильный\";i:1;s:60:\"Еще ответ на 6 вопрос 3 правильный\";i:2;s:53:\"Ответ на 6 вопрос 2 правильный\";}s:5:\"false\";a:0:{}}i:1;a:3:{s:8:\"question\";s:25:\"Вопрос номер 1\";s:4:\"true\";a:1:{i:0;s:53:\"Ответ 1 на вопрос 1 правильный\";}s:5:\"false\";a:3:{i:0;s:57:\"Ответ 2 на вопрос 1 неправильный\";i:1;s:62:\"еще ответ на вопрос 1 неправильный\";i:2;s:66:\"ответ 3 на вопрос 1 тоже неправильный\";}}i:2;a:3:{s:8:\"question\";s:45:\"Вопрос номер 8, последний\";s:4:\"true\";a:2:{i:0;s:53:\"Ответ на 8 вопрос 1 правильный\";i:1;s:53:\"Ответ на 8 вопрос 2 правильный\";}s:5:\"false\";a:1:{i:0;s:64:\"Еще ответ на 8 вопрос 2 неправильный\";}}i:3;a:3:{s:8:\"question\";s:43:\"Давай еще вопрос, он же 3\";s:4:\"true\";a:2:{i:0;s:60:\"Еще ответ на 3 вопрос 2 правильный\";i:1;s:53:\"Ответ на 3 вопрос 1 правильный\";}s:5:\"false\";a:1:{i:0;s:57:\"Ответ на 3 вопрос 2 неправильный\";}}i:4;a:3:{s:8:\"question\";s:30:\"Еще один вопрос 4\";s:4:\"true\";a:2:{i:0;s:60:\"Еще ответ на 4 вопрос 3 правильный\";i:1;s:53:\"Ответ на 4 вопрос 1 правильный\";}s:5:\"false\";a:1:{i:0;s:57:\"Ответ на 4 вопрос 2 неправильный\";}}i:5;a:3:{s:8:\"question\";s:41:\"Еще один вопрос, он же 2\";s:4:\"true\";a:2:{i:0;s:58:\"Еще ответ на вопрос 2 правильный\";i:1;s:53:\"Ответ на 2 вопрос 1 правильный\";}s:5:\"false\";a:1:{i:0;s:57:\"Ответ на 2 вопрос 2 неправильный\";}}i:6;a:3:{s:8:\"question\";s:58:\"И еще один вопрос, вопрос номер 7\";s:4:\"true\";a:2:{i:0;s:58:\"Еще ответ на вопрос 7 правильный\";i:1;s:53:\"Ответ на 7 вопрос 1 правильный\";}s:5:\"false\";a:1:{i:0;s:32:\"Ответ на 7 вопрос 2\";}}i:7;a:3:{s:8:\"question\";s:79:\"Я - вопрос на который надо дать ответ, он же 5\";s:4:\"true\";a:2:{i:0;s:64:\"На 5 вопрос ответ номер 3 правильный\";i:1;s:85:\"Ответ номер 1 правильный на вопрос 5 правильный\";}s:5:\"false\";a:2:{i:0;s:68:\"Ответ на 5 вопрос номер 2 неправильный\";i:1;s:62:\"еще ответ на вопрос 5 неправильный\";}}}', 'jgbcfydasdasvm,;fmiow4eqnfwFWQAFW', '2019-05-25 07:03:24', 6, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `test_hash`
--

CREATE TABLE `test_hash` (
  `id` int(11) NOT NULL,
  `hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `test_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `test_hash`
--

INSERT INTO `test_hash` (`id`, `hash`, `test_id`) VALUES
(1, '09436842d528d8f8a7c8989984dc89ce40302f45', 1),
(2, '09436842d528d8f8a7c8989984dc89ce40302f45', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `user_group`) VALUES
(1, 'admin', '$2y$10$EwtJoYjJcxfRZDUhz3UzrOamnJdBxTK8wXacxSuCUI8Md7uKmIYga', 1),
(6, 'Selecao12', '$2y$10$KdqbhWx.N3TkdR7A5P1rzueG6IYH87UNtnhA99A51JJ9AlZjHfe56', 2),
(7, 'WitalikN', '$2y$10$wG44Wrs8nu0pFuNnvRReOuwv9FBJDuoZZOawAIHvRQbJjtDOyhj16', 1),
(8, 'student', '$2y$10$/JAg64gufbMGRh/1g0BOIOEhHJQeTAJ7k2hw6gvt4PVCznTqCJADW', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `user_group`
--

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_time` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_group`
--

INSERT INTO `user_group` (`id`, `name`, `access_time`) VALUES
(1, 'admin', NULL),
(2, 'examiner', NULL),
(3, 'entrant', 1558731600);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Индексы таблицы `test_hash`
--
ALTER TABLE `test_hash`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `user_group` (`user_group`);

--
-- Индексы таблицы `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `test_hash`
--
ALTER TABLE `test_hash`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `test_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `test_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `test_hash`
--
ALTER TABLE `test_hash`
  ADD CONSTRAINT `test_hash_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`);

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_group`) REFERENCES `user_group` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
