-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-10-2021 a las 12:57:31
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 7.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `apirest`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `id_user` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `description` longtext COLLATE utf8_bin DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `ubication` varchar(45) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `activities`
--

INSERT INTO `activities` (`id`, `id_user`, `name`, `description`, `date`, `ubication`) VALUES
(1, 1, 'Senderismo y Trekking', ' Caminata por senderos de montañas para disfrutar en familia y en contacto directo con la naturaleza.', '2021-10-10 17:00:00', 'Cerro Carrizalito. Valle Grande. San Rafael, '),
(2, 1, 'Restaurant, Turismo Aventura', 'Servicio de Turismo Aventura en el Cañón del Atuel. San Rafael, Mendoza. Argentina.', '2021-10-15 12:00:00', 'Ruta 173, Km 27,5, Valle Grande, 5600 San Raf'),
(3, 1, 'Biero (@bierodraftbeer)', 'La mejor cervecería de San Rafael ', '2021-10-06 23:00:00', 'Hipolito Yrigoyen 2065, 5600 San Rafael, Prov');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activities_categories`
--

CREATE TABLE `activities_categories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `activities_categories`
--

INSERT INTO `activities_categories` (`id`, `category_id`, `activity_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 2, 3),
(5, 3, 3),
(6, 4, 1),
(7, 4, 2),
(8, 4, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activities_users`
--

CREATE TABLE `activities_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `invite` tinyint(4) DEFAULT 0,
  `pending` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `activities_users`
--

INSERT INTO `activities_users` (`id`, `user_id`, `activity_id`, `invite`, `pending`) VALUES
(1, 2, 3, 0, 1),
(2, 2, 1, 0, 0),
(3, 2, 2, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Outdoors'),
(2, 'Restaurant'),
(3, 'Drinks'),
(4, 'Turismo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(45) COLLATE utf8_bin NOT NULL,
  `name` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `lastname` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `role` varchar(45) COLLATE utf8_bin NOT NULL DEFAULT 'user',
  `password` mediumtext COLLATE utf8_bin NOT NULL,
  `token` mediumtext COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `lastname`, `role`, `password`, `token`) VALUES
(1, 'organizer@gmail.com', 'organizer', 'organizer', 'organizer', '$2y$10$M/PT3CrkZzShZAHJ5xNSmu5jEUqrMh5r5fbxHumUBZe9SuPyiT0Nu', NULL),
(2, 'user@gmail.com', 'user', 'user', 'user', '$2y$10$TW/A9wHR0ARDGvX7R7cLqORsUuZBqkCt5KXlKmaEINlvGv4eIiS2W', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `activities_categories`
--
ALTER TABLE `activities_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indices de la tabla `activities_users`
--
ALTER TABLE `activities_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `activities_categories`
--
ALTER TABLE `activities_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `activities_users`
--
ALTER TABLE `activities_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `activities_categories`
--
ALTER TABLE `activities_categories`
  ADD CONSTRAINT `activities_categories_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activities_categories_ibfk_4` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `activities_users`
--
ALTER TABLE `activities_users`
  ADD CONSTRAINT `activities_users_ibfk_3` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activities_users_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
