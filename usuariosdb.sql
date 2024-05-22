-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-05-2024 a las 23:20:42
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `usuariosdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `creador` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id`, `nombre`, `fecha`, `creador`) VALUES
(1, 'Cumpleaños', '2024-05-31', 'juan'),
(2, 'Intercambio de ragalos POST/navidad', '2024-05-21', 'javier');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invitaciones_eventos`
--

CREATE TABLE `invitaciones_eventos` (
  `id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL,
  `email_invitado` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `invitaciones_eventos`
--

INSERT INTO `invitaciones_eventos` (`id`, `evento_id`, `email_invitado`) VALUES
(1, 0, 'javiercohuoayil@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listas_regalos`
--

CREATE TABLE `listas_regalos` (
  `id` int(11) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `regalos` text NOT NULL,
  `evento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `listas_regalos`
--

INSERT INTO `listas_regalos` (`id`, `usuario`, `regalos`, `evento_id`) VALUES
(2, 'Javier', 'Chocolates\r\nVideojuegos\r\nRopa\r\nMausePad', 1),
(3, 'carlos', 'Pantalones\r\nCamisas\r\nDinero\r\nVajilla\r\nTeclado\r\nMausePad', 1),
(4, 'juan', 'Adornos\r\nAudifonos\r\nEspejo \r\nPintura', 1),
(5, 'javier', 'coca', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_pairs`
--

CREATE TABLE `user_pairs` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `paired_user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user_pairs`
--

INSERT INTO `user_pairs` (`id`, `username`, `paired_user`) VALUES
(1, 'juan', 'Javier'),
(2, 'javier', 'Carlos'),
(3, 'carlos', 'juan');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `name`, `email`, `password`) VALUES
(1, 'Javier', 'cohuo_javier2001@hotmail.com', '$2y$10$kr6o//f1KUsiUGDxd07K1eqidOIRVmMyNVE5bzXENjMWcQahnNZpC'),
(2, 'Carlos', 'javiercohuoayil@gmail.com', '$2y$10$w5Jx4/.RYXA.dFec7xMfS..2Lax2LeN47DcHtZUFSor7a6ZtcId56'),
(3, 'juan', 'al066180@uacam.mx', '$2y$10$WEETAOoJIxpmscSKmey55.lPmqHpwxfjsHaTd6cl8cDvQMuvoeD4O'),
(4, 'mercedes', 'al067544@uacam.mx', '$2y$10$1W2rGNckE86QqUEQEcDfIeaKRiYS8fl5mXIfBXQAR5k9p5Kyji6Sm');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `invitaciones_eventos`
--
ALTER TABLE `invitaciones_eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evento_id` (`evento_id`);

--
-- Indices de la tabla `listas_regalos`
--
ALTER TABLE `listas_regalos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_pairs`
--
ALTER TABLE `user_pairs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `invitaciones_eventos`
--
ALTER TABLE `invitaciones_eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `listas_regalos`
--
ALTER TABLE `listas_regalos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `user_pairs`
--
ALTER TABLE `user_pairs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `invitaciones_eventos`
--
ALTER TABLE `invitaciones_eventos`
  ADD CONSTRAINT `invitaciones_eventos_ibfk_1` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
