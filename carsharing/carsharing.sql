-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Янв 23 2026 г., 12:34
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
-- База данных: `carsharing`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `year` year(4) NOT NULL,
  `license_plate` varchar(20) NOT NULL,
  `category_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `color` varchar(50) DEFAULT NULL,
  `fuel_type` varchar(50) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `mileage` int(11) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`id`, `brand`, `model`, `year`, `license_plate`, `category_id`, `status_id`, `color`, `fuel_type`, `latitude`, `longitude`, `mileage`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Hyundai', 'Solaris', '2020', 'E101AA77', 1, 1, 'Белый', 'Бензин', 55.75580000, 37.61730000, 42000, 'hyundai-solaris-2020-white', '2026-01-22 20:27:20', '2026-01-23 18:14:02'),
(2, 'Kia', 'Rio', '2021', 'E102AB77', 1, 1, 'Серый', 'Бензин', 55.75400000, 37.62000000, 36000, 'kia-rio-2021-red', '2026-01-22 20:27:20', '2026-01-23 18:14:04'),
(3, 'Volkswagen', 'Polo', '2019', 'E103AC77', 1, 2, 'Синий', 'Бензин', 55.75320000, 37.61550000, 51000, 'vw-polo-2019-blue', '2026-01-22 20:27:20', '2026-01-23 18:14:04'),
(4, 'Skoda', 'Rapid', '2020', 'E104AD77', 1, 1, 'Черный', 'Бензин', 55.75610000, 37.61880000, 39000, 'skoda-rapid-2020-blue', '2026-01-22 20:27:20', '2026-01-23 18:14:04'),
(5, 'Renault', 'Logan', '2018', 'E105AE77', 1, 3, 'Белый', 'Бензин', 55.75200000, 37.61200000, 68000, 'renault-logan-2018-blue', '2026-01-22 20:27:20', '2026-01-23 18:14:04'),
(6, 'Lada', 'Vesta', '2021', 'E106AF77', 1, 1, 'Красный', 'Бензин', 55.75820000, 37.62120000, 29000, 'lada-vesta-2021-gray', '2026-01-22 20:27:20', '2026-01-23 18:14:04'),
(7, 'Toyota', 'Camry', '2022', 'C201BA77', 2, 1, 'Черный', 'Бензин', 55.75120000, 37.61840000, 18000, 'toyota-camry-2022-gray', '2026-01-22 20:27:20', '2026-01-23 18:14:04'),
(8, 'Mazda', '6', '2021', 'C202BB77', 2, 1, 'Белый', 'Бензин', 55.74990000, 37.61690000, 22000, 'mazda-6-2021-blue', '2026-01-22 20:27:20', '2026-01-23 18:14:04'),
(9, 'Volkswagen', 'Passat', '2020', 'C203BC77', 2, 2, 'Серый', 'Бензин', 55.74850000, 37.61430000, 33000, 'vw-passat-2020-silver', '2026-01-22 20:27:20', '2026-01-23 18:14:04'),
(10, 'Skoda', 'Octavia', '2022', 'C204BD77', 2, 1, 'Синий', 'Бензин', 55.74730000, 37.61910000, 17000, 'skoda-octavia-2022-white', '2026-01-22 20:27:20', '2026-01-23 18:14:04'),
(11, 'Kia', 'K5', '2021', 'C205BE77', 2, 1, 'Белый', 'Бензин', 55.75010000, 37.62180000, 26000, 'kia-k5-2021-gray', '2026-01-22 20:27:20', '2026-01-23 18:14:04'),
(12, 'Hyundai', 'Sonata', '2020', 'C206BF77', 2, 3, 'Черный', 'Бензин', 55.74690000, 37.61370000, 41000, 'hyundai-sonata-2020-blue', '2026-01-22 20:27:20', '2026-01-23 18:14:04'),
(13, 'BMW', '5 Series', '2022', 'P301CA77', 3, 1, 'Черный', 'Бензин', 55.74480000, 37.61050000, 14000, 'bmw-5-series-2022-white', '2026-01-22 20:27:20', '2026-01-23 18:14:04'),
(14, 'Mercedes-Benz', 'E-Class', '2022', 'P302CB77', 3, 1, 'Белый', 'Бензин', 55.74310000, 37.61290000, 12000, 'mercedes-e-class-2022-silver', '2026-01-22 20:27:20', '2026-01-23 18:14:04'),
(15, 'Audi', 'A6', '2021', 'P303CC77', 3, 2, 'Серый', 'Бензин', 55.74200000, 37.61500000, 19000, 'audi-a6-2021-black', '2026-01-22 20:27:20', '2026-01-23 18:14:04'),
(16, 'BMW', 'X5', '2023', 'P304CD77', 3, 1, 'Черный', 'Бензин', 55.74090000, 37.61760000, 8000, 'bmw-x5-2023-white', '2026-01-22 20:27:20', '2026-01-23 18:14:04'),
(17, 'Mercedes-Benz', 'GLE', '2023', 'P305CE77', 3, 1, 'Синий', 'Бензин', 55.73980000, 37.62020000, 6000, 'mercedes-gle-2023-white', '2026-01-22 20:27:20', '2026-01-23 18:14:04'),
(18, 'Audi', 'Q7', '2022', 'P306CF77', 3, 3, 'Белый', 'Бензин', 55.73870000, 37.62280000, 15000, 'audi-q7-2022-white', '2026-01-22 20:27:20', '2026-01-23 18:14:04'),
(19, 'Tesla', 'Model 3', '2023', 'P307CG77', 3, 1, 'Красный', 'Электро', 55.73750000, 37.62540000, 5000, 'tesla-model-3-2023-black', '2026-01-22 20:27:20', '2026-01-23 18:14:04'),
(20, 'Tesla', 'Model Y', '2023', 'P308CH77', 3, 1, 'Белый', 'Электро', 55.73630000, 37.62800000, 4000, 'tesla-model-y-2023-white', '2026-01-22 20:27:20', '2026-01-23 18:14:04');

-- --------------------------------------------------------

--
-- Структура таблицы `car_categories`
--

CREATE TABLE `car_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `price_per_minute` decimal(6,2) NOT NULL,
  `price_per_min` decimal(10,2) NOT NULL DEFAULT 10.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `car_categories`
--

INSERT INTO `car_categories` (`id`, `name`, `description`, `price_per_minute`, `price_per_min`) VALUES
(1, 'Эконом', 'Автомобили эконом-класса', 8.50, 8.00),
(2, 'Комфорт', 'Автомобили повышенного комфорта', 12.00, 12.00),
(3, 'Премиум', 'Автомобили премиум-класса', 20.00, 20.00);

-- --------------------------------------------------------

--
-- Структура таблицы `car_statuses`
--

CREATE TABLE `car_statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `car_statuses`
--

INSERT INTO `car_statuses` (`id`, `name`, `description`) VALUES
(1, 'Свободен', 'Автомобиль доступен для аренды'),
(2, 'В аренде', 'Автомобиль используется'),
(3, 'На обслуживании', 'Автомобиль временно недоступен');

-- --------------------------------------------------------

--
-- Структура таблицы `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `rental_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(50) DEFAULT 'card',
  `status` enum('pending','completed','failed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `payments`
--

INSERT INTO `payments` (`id`, `rental_id`, `amount`, `payment_date`, `payment_method`, `status`) VALUES
(1, 4, 8.00, '2026-01-22 18:32:28', 'card', 'completed'),
(2, 5, 20.00, '2026-01-22 19:26:56', 'card', 'completed');

-- --------------------------------------------------------

--
-- Структура таблицы `rentals`
--

CREATE TABLE `rentals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `price_per_minute` decimal(6,2) NOT NULL,
  `total_price` decimal(8,2) DEFAULT NULL,
  `start_latitude` decimal(10,8) DEFAULT NULL,
  `start_longitude` decimal(11,8) DEFAULT NULL,
  `end_latitude` decimal(10,8) DEFAULT NULL,
  `end_longitude` decimal(11,8) DEFAULT NULL,
  `status` varchar(30) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `rentals`
--

INSERT INTO `rentals` (`id`, `user_id`, `car_id`, `start_time`, `end_time`, `duration_minutes`, `price_per_minute`, `total_price`, `start_latitude`, `start_longitude`, `end_latitude`, `end_longitude`, `status`, `created_at`) VALUES
(4, 3, 2, '2026-01-23 01:25:33', '2026-01-23 01:28:13', 1, 8.00, 8.00, NULL, NULL, NULL, NULL, 'completed', '2026-01-23 01:25:33'),
(5, 3, 13, '2026-01-23 02:22:27', '2026-01-23 02:26:27', 1, 20.00, 20.00, NULL, NULL, NULL, NULL, 'completed', '2026-01-23 02:22:27');

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `car_id`, `rating`, `comment`, `created_at`) VALUES
(1, 3, 2, 5, 'Все замечательно', '2026-01-22 18:41:17');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `password_hash`, `role_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Иван', 'Иванов', 'ivan@test.ru', '+79990001122', 'TEST_HASH', 2, 1, '2026-01-22 20:13:26', '2026-01-22 20:13:26'),
(3, 'Алдар', 'Эмедеев', 'aldaremedeev@gmail.com', '+7 (951) 638-71-55', '$2y$10$1mFqaOTbrTYUjpj6.16aqO/2EHw4UOiElNnJDTrkSYrCflU1qHwfq', 2, 1, '2026-01-23 00:51:53', '2026-01-23 00:51:53'),
(4, 'Андрей', 'Кравченко', 'aldar.emedeev@bk.ru', '+7 (799) 610 92 71', '$2y$10$YAtcx3u.9oTYLgsmEuqpO.SXEMRwR46fqviMExr3AQ0PJH5rjmR2q', 2, 1, '2026-01-23 02:28:23', '2026-01-23 02:28:23');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `license_plate` (`license_plate`),
  ADD KEY `fk_cars_category` (`category_id`),
  ADD KEY `fk_cars_status` (`status_id`);

--
-- Индексы таблицы `car_categories`
--
ALTER TABLE `car_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `car_statuses`
--
ALTER TABLE `car_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rental_id` (`rental_id`);

--
-- Индексы таблицы `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rentals_user` (`user_id`),
  ADD KEY `fk_rentals_car` (`car_id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `fk_users_role` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `car_categories`
--
ALTER TABLE `car_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `car_statuses`
--
ALTER TABLE `car_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `fk_cars_category` FOREIGN KEY (`category_id`) REFERENCES `car_categories` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cars_status` FOREIGN KEY (`status_id`) REFERENCES `car_statuses` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`rental_id`) REFERENCES `rentals` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `fk_rentals_car` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rentals_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
