-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 19 2024 г., 15:33
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `podzamkom`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `order_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `quest_link` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `review_id` int UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `players` int NOT NULL,
  `age` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `actors` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `promocode` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `quest_link`, `review_id`, `date`, `time`, `players`, `age`, `actors`, `promocode`) VALUES
(9, 6, 'virus', NULL, '2024-04-14', '18:00:00', 3, 'teens', 'ac', ''),
(10, 6, 'virus', NULL, '2024-04-14', '16:00:00', 3, 'teens', 'ac', '321321'),
(11, 6, 'virus', NULL, '2024-04-14', '10:00:00', 5, 'adult', 'as', '5566567'),
(12, 6, 'deal', NULL, '2024-04-14', '12:00:00', 8, 'mixed', 'wa', '#huesos'),
(13, 7, 'virus', NULL, '2024-04-17', '18:00:00', 6, 'adult', 'wa', ''),
(14, 7, 'virus', NULL, '2024-04-17', '20:00:00', 6, 'adult', 'wa', ''),
(15, 7, 'virus', NULL, '2024-04-17', '16:00:00', 6, 'adult', 'wa', ''),
(16, 7, 'virus', NULL, '2024-04-17', '10:00:00', 6, 'adult', 'wa', ''),
(17, 7, 'virus', NULL, '2024-04-17', '12:00:00', 6, 'adult', 'wa', ''),
(18, 7, 'virus', NULL, '2024-04-17', '14:00:00', 6, 'adult', 'wa', ''),
(19, 7, 'virus', NULL, '2024-04-17', '22:00:00', 6, 'adult', 'wa', ''),
(20, 7, 'escape', NULL, '2024-04-18', '18:00:00', 3, 'adult', 'as', ''),
(21, 7, 'escape', NULL, '2024-04-16', '12:00:00', 3, 'mixed', 'ac', ''),
(22, 7, 'escape', NULL, '2024-04-16', '16:00:00', 3, 'teens', 'as', '');

-- --------------------------------------------------------

--
-- Структура таблицы `quests`
--

CREATE TABLE `quests` (
  `quest_id` int UNSIGNED NOT NULL,
  `quest_link` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `quest_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `quest_legend` text COLLATE utf8mb4_general_ci,
  `quest_price` varchar(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quest_genre` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quest_preview` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quest_rating` decimal(2,2) DEFAULT '0.00',
  `quest_min` tinyint(1) NOT NULL,
  `quest_max` tinyint(1) NOT NULL,
  `quest_additional` tinyint(1) DEFAULT NULL,
  `first_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'http://test.podzamkom24.ru/img/quest_img/photo_404.png',
  `second_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'http://test.podzamkom24.ru/img/quest_img/photo_404.png',
  `third_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'http://test.podzamkom24.ru/img/quest_img/photo_404.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `quests`
--

INSERT INTO `quests` (`quest_id`, `quest_link`, `quest_name`, `quest_legend`, `quest_price`, `quest_genre`, `quest_preview`, `quest_rating`, `quest_min`, `quest_max`, `quest_additional`, `first_photo`, `second_photo`, `third_photo`) VALUES
(1, 'virus', 'вирус', 'Этот объект давным-давно перестали отмечать на картах, а в военных отчетах его указывали, как крайне опасный. Основной задачей этой лаборатории было исследование нового оружия массового поражения путем выведения вируса, который морально и физически влияет на человека. Вас вызвали, как военных биологов, чтобы вы вместе смогли завершить разработку этих вирусов, но услышав разговоры персонала, вы понимаете, что прибыли сюда с совершенно иной целью...', '4500', 'хоррор', 'http://test.podzamkom24.ru/img/quests_preview/virus_prev.png', '0.00', 3, 8, 7, 'http://test.podzamkom24.ru/img/quest_img/virus_1.png', 'http://test.podzamkom24.ru/img/quest_img/virus_2.png', 'http://test.podzamkom24.ru/img/quest_img/photo_404.png'),
(2, 'escape', 'побег', 'Вас ошибочно обвинили в самом ужасном преступлении и поместили в камеры смертников. Ровно через 1,5 часа вас посадят на электрический стул! По чистой случайности Вы попадаете в камеру, из которой одному заключенному удалось сбежать без следов. Вдруг коридоры тюрьмы опустели, у вас появилвся шанс выбраться из заточения и спасти свою жизнь! Удастся ли вам использовать свой последний шанс - зависит только от вас.', '4000', 'триллер', 'http://test.podzamkom24.ru/img/quests_preview/escape_prev.png', '0.00', 3, 8, 7, 'http://test.podzamkom24.ru/img/quest_img/escape.png', 'http://test.podzamkom24.ru/img/quest_img/photo_404.png', 'http://test.podzamkom24.ru/img/quest_img/photo_404.png'),
(3, 'deal', 'сделка', 'Слухи о пропащих постояльцах этого старого отеля очень быстро расползлись по нашему маленькому городку. И все же ваша команда отчаянных искателей приключений осмеливается заселиться в странный НОМЕР. Вы столкнетесь с настоящим злом! Каждый ваш шаг оставит отпечаток в истории этого старого отеля.', '4500', 'мистика', 'http://test.podzamkom24.ru/img/quests_preview/deal_prev.png', '0.00', 3, 15, 10, 'http://test.podzamkom24.ru/img/quest_img/deal.png', 'http://test.podzamkom24.ru/img/quest_img/photo_404.png', 'http://test.podzamkom24.ru/img/quest_img/photo_404.png'),
(4, 'coma', 'кома', 'Вы - компания друзей, отправившаяся в автомобильное путешествие по рельефам горного хребта. На одном из поворотов водитель увидел посреди дороги силуэт ребёнка и резко выкрутил руль. По трагическому стечению обстоятельств, на этом участке дороги отсутствовали заградительные отбойники и автомобиль кубарем покатился по склону. К моменту жёсткой остановки все пассажиры находились уже В КОМЕ... Нужно бороться за свою жизнь... а уж выпустит ли вас Кома - этого никто не знает...', '4500', 'перформанс', 'http://test.podzamkom24.ru/img/quests_preview/certificate_prev.png', '0.00', 2, 5, NULL, 'http://test.podzamkom24.ru/img/quest_img/photo_404.png', 'http://test.podzamkom24.ru/img/quest_img/photo_404.png', 'http://test.podzamkom24.ru/img/quest_img/photo_404.png');

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `quest_link` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rating` float NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `publicated` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`review_id`, `user_id`, `quest_link`, `rating`, `comment`, `publicated`) VALUES
(1, 1, 'virus', 4, 'gfhdkbhkjg hksjghjkdfhj hgjkfdkhj gjkfdh kjhgjkfdhjk gfdjkdh kjhfgddjkh jkhfgdjk fjkdgh kjdfghjkg hfdkj hgjkfdh gkjhfdjkl ghjkfdh jkgfhkj hkjgf', '2024-04-10 13:59:39'),
(2, 4, 'virus', 5, 'квест крутой!', '2024-04-10 14:01:15'),
(3, 2, 'virus', 2, 'gfjdhh gfdjh hjgfjhkd hkjgfdhjk hjkgfdhjk', '2024-04-10 14:42:21'),
(4, 1, 'virus', 1, '321321321321', '2024-04-10 17:16:12'),
(5, 3, 'escape', 4, '321321321', '2024-04-10 17:42:53');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `role_id` int UNSIGNED NOT NULL,
  `role` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`role_id`, `role`) VALUES
(1, 'Пользователь'),
(2, 'Актёр'),
(3, 'Администратор'),
(4, 'Руководитель');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int UNSIGNED NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pass` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `number` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role_id` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `email`, `pass`, `token`, `name`, `number`, `role_id`) VALUES
(1, 's1ngleez@yandex.ru', '$2y$10$lBJXLwEksCKB4gwudy6gD.LvgIkQYmnb7U7Sfz1GlJ/Lc9pILMzWW', '8716199e539f7df1e72c5bfdbbf04031', 'Александр', '79333368212', 4),
(2, 's1ngle1ez@yandex.ru', '$2y$10$e2VoPv7rJpDQWrkVosg5E.ptr/Zwf/ApNcuC3dFYORQ6ClnLJaYW6', '9b6d3904df50547f44ca11fa564e6993', 'axixe', NULL, 1),
(3, 's1n321gleez@yandex.ru', '$2y$10$H3HH4mEN0UsyY.MXLPfYNehL75N8e1rzfo2IaOcckzVAAbreaIrAq', 'abea59f955e6865d59eb4a6cc678cb3f', 'alex', NULL, 1),
(4, 'egorpidor31@gmail.com', '$2y$10$yNNZUT7gpewwh4ODkttaCepk3yNf0Wve/1ytgGrsFVXjMIub5C43i', 'c6ea1c8bb53646bd6ee2599baf284ae6', 'Егор', NULL, 1),
(5, 'pidoras@yandex.ru', '$2y$10$nKtwe5IKZGvJFkMOqyD.Eud1.2hDGwwJqboKOAcr3ldWaTkTzpgou', '68fbc97674a0cc3568c8f6d3c185b43b', 'Аким', NULL, 1),
(6, 'gfdhhgfdhjk@mail.ru', '$2y$10$iavCeKfuz7cIsmpYJgJF6eiTg4BxcQp2GU9lYt9nkNy8SlqBuJ3mW', 'e9676025c694692f947cd5990eba4c5f', 'fkdjsjkfdsk', NULL, 1),
(7, 'black@yandex.ru', '$2y$10$toSww1hjKeAHQr/jtNV6FOxhokgIkZxRKNo5SGtRBU.VeIXWrLHa.', 'f5a6205eac5b7919fb1b256ac3fd5c43', 'светлана', '321321321', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `quest_id` (`quest_link`,`user_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `review_id` (`review_id`),
  ADD KEY `quest_link` (`quest_link`);

--
-- Индексы таблицы `quests`
--
ALTER TABLE `quests`
  ADD PRIMARY KEY (`quest_id`),
  ADD KEY `quest_link` (`quest_link`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `reviews_ibfk_1` (`user_id`),
  ADD KEY `review_quest` (`quest_link`),
  ADD KEY `quest_link` (`quest_link`),
  ADD KEY `review_id` (`review_id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `phone` (`email`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `role_id_2` (`role_id`),
  ADD KEY `role_id_3` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `quests`
--
ALTER TABLE `quests`
  MODIFY `quest_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`review_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`quest_link`) REFERENCES `quests` (`quest_link`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`quest_link`) REFERENCES `quests` (`quest_link`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
