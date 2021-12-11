-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-12-2021 a las 16:40:12
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `2122_gomezgallegoxavier`
--
CREATE DATABASE IF NOT EXISTS `2122_gomezgallegoxavier` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `2122_gomezgallegoxavier`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_historial`
--

CREATE TABLE `tbl_historial` (
  `id_historial` int(11) NOT NULL,
  `id_mesa` int(11) DEFAULT NULL,
  `dia_historial` date DEFAULT NULL,
  `inicio_historial` time DEFAULT NULL,
  `fin_historial` time DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_historial`
--

INSERT INTO `tbl_historial` (`id_historial`, `id_mesa`, `dia_historial`, `inicio_historial`, `fin_historial`, `email`) VALUES
(9, 1, '2021-11-05', '16:08:22', '16:08:24', 'xaviergomez@docbrown.com'),
(10, 3, '2021-11-05', '17:10:02', '17:10:08', 'xaviergomez@docbrown.com'),
(12, 2, '2021-11-05', '17:45:57', '17:46:03', 'xaviergomez@docbrown.com'),
(13, 3, '2021-11-05', '17:46:05', '17:46:25', 'xaviergomez@docbrown.com'),
(15, 1, '2021-11-05', '19:17:56', '19:17:58', 'xaviergomez@docbrown.com'),
(16, 3, '2021-11-05', '19:32:48', '19:33:07', 'xaviergomez@docbrown.com'),
(18, 2, '2021-11-08', '15:15:54', '15:16:14', 'xaviergomez@docbrown.com'),
(20, 1, '2021-11-09', '16:41:11', '16:41:37', 'xaviergomez@docbrown.com'),
(21, 9, '2021-11-09', '17:06:41', '17:09:14', 'xaviergomez@docbrown.com'),
(25, 1, '2021-11-09', '17:41:16', '17:41:24', 'xaviergomez@docbrown.com'),
(26, 1, '2021-11-09', '17:43:57', '17:43:58', 'xaviergomez@docbrown.com'),
(27, 2, '2021-11-09', '17:53:20', '17:53:21', 'xaviergomez@docbrown.com'),
(29, 13, '2021-11-09', '19:49:47', '19:50:43', 'xaviergomez@docbrown.com'),
(30, 1, '2021-11-09', '20:07:55', '20:08:02', 'xaviergomez@docbrown.com'),
(31, 5, '2021-11-09', '20:08:04', '20:08:07', 'xaviergomez@docbrown.com'),
(32, 1, '2021-11-10', '15:16:06', '15:16:18', 'xaviergomez@docbrown.com'),
(33, 13, '2021-11-10', '18:54:05', '18:55:24', 'xaviergomez@docbrown.com'),
(34, 13, '2021-11-10', '18:59:01', '18:59:31', 'xaviergomez@docbrown.com'),
(35, 1, '2021-12-11', '13:12:21', '13:12:27', 'xaviergomez@docbrown.com'),
(36, 1, '2021-12-11', '16:10:42', '16:10:44', 'xaviergomez@docbrown.com'),
(37, 1, '2021-12-11', '16:21:49', '16:21:50', 'xaviergomez@docbrown.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_historialonline`
--

CREATE TABLE `tbl_historialonline` (
  `id_historialonline` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `id_mesa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_incidencia`
--

CREATE TABLE `tbl_incidencia` (
  `id_incidencia` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `id_localizacion` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `descripcion_incidencia` text DEFAULT NULL,
  `fecha_inicio_incidencia` date DEFAULT NULL,
  `fecha_fin_incidencia` date DEFAULT NULL,
  `hora_inicio_incidencia` time DEFAULT NULL,
  `hora_final_incidencia` time DEFAULT NULL,
  `resuelto` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_incidencia`
--

INSERT INTO `tbl_incidencia` (`id_incidencia`, `id_mesa`, `id_localizacion`, `email`, `descripcion_incidencia`, `fecha_inicio_incidencia`, `fecha_fin_incidencia`, `hora_inicio_incidencia`, `hora_final_incidencia`, `resuelto`) VALUES
(2, 1, 1, 'dannylarrea@docbrown.com', 'Mesa rota\r\nSilla rota', '2021-11-08', '2021-11-08', '19:58:31', '19:58:46', 'Danny'),
(3, 2, 2, 'xaviergomez@docbrown.com', 'Se ha roto 2 sillas', '2021-11-09', '2021-11-09', '17:10:03', '17:36:39', 'Danny'),
(4, 1, 1, 'xaviergomez@docbrown.com', 'silla rota', '2021-11-09', '2021-11-09', '19:53:34', '19:54:15', 'Danny'),
(5, 4, 1, 'xaviergomez@docbrown.com', 'Mesa rota', '2021-11-10', '2021-11-10', '15:15:29', '15:17:38', 'Danny'),
(6, 1, 1, 'sergiojimenez@docbrown.com', 'Mesa rota', '2021-11-10', '2021-11-10', '19:01:38', '19:02:07', 'Sergio'),
(9, 1, 1, 'xaviergomez@docbrown.com', '432343425', '2021-12-11', '2021-12-11', '16:12:18', '16:12:39', 'Danny');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_localizacion`
--

CREATE TABLE `tbl_localizacion` (
  `id_localizacion` int(11) NOT NULL,
  `nombre_localizacion` varchar(45) NOT NULL,
  `img` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_localizacion`
--

INSERT INTO `tbl_localizacion` (`id_localizacion`, `nombre_localizacion`, `img`) VALUES
(1, 'Terraza', '../img/terraza.jpg'),
(2, 'Comedor', '../img/comedor.jpg'),
(3, 'Karaoke', '../img/karaoke.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mesa`
--

CREATE TABLE `tbl_mesa` (
  `id_mesa` int(11) NOT NULL,
  `mesa` int(11) DEFAULT NULL,
  `silla` int(11) DEFAULT NULL,
  `disponibilidad` enum('si','no','mantenimiento') DEFAULT NULL,
  `id_localizacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_mesa`
--

INSERT INTO `tbl_mesa` (`id_mesa`, `mesa`, `silla`, `disponibilidad`, `id_localizacion`) VALUES
(1, 1, 2, 'si', 1),
(2, 3, 8, 'si', 2),
(3, 1, 2, 'si', 3),
(4, 1, 4, 'si', 1),
(5, 2, 4, 'si', 1),
(6, 2, 6, 'si', 1),
(7, 3, 8, 'si', 1),
(8, 3, 10, 'si', 1),
(9, 4, 12, 'si', 1),
(10, 4, 16, 'si', 1),
(11, 5, 18, 'si', 1),
(12, 5, 20, 'si', 1),
(13, 1, 2, 'si', 2),
(14, 2, 4, 'si', 2),
(15, 2, 6, 'si', 2),
(16, 3, 10, 'si', 2),
(17, 4, 12, 'si', 2),
(18, 2, 4, 'si', 3),
(19, 2, 6, 'si', 3),
(20, 2, 6, 'si', 3),
(21, 3, 8, 'si', 3),
(101, 3, 10, 'si', 3),
(102, 4, 12, 'si', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuario`
--

CREATE TABLE `tbl_usuario` (
  `email` varchar(50) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `contraseña` varchar(250) NOT NULL,
  `tipo` enum('camarero','mantenimiento','administrador') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_usuario`
--

INSERT INTO `tbl_usuario` (`email`, `nombre`, `apellido`, `contraseña`, `tipo`) VALUES
('agnesplans@docbrown.com', 'Agnes', 'Plans', '81dc9bdb52d04dc20036dbd8313ed055', 'mantenimiento'),
('arnaubalart@docbrown.com', 'Arnau', 'Balart', '81dc9bdb52d04dc20036dbd8313ed055', 'administrador'),
('dannylarrea@docbrown.com', 'Danny', 'Larrea', '81dc9bdb52d04dc20036dbd8313ed055', 'mantenimiento'),
('davidortega@docbrown.com', 'David', 'Ortega', '81dc9bdb52d04dc20036dbd8313ed055', 'camarero'),
('diegosoledispa@docbrown.com', 'Diego', 'Soledispa', 'md5(1234)', 'mantenimiento'),
('ignasiromero@docbrown.com', 'Ignasi', 'Romero', '81dc9bdb52d04dc20036dbd8313ed055', 'mantenimiento'),
('marcdiaz@docbrown.com', 'Marc', 'Diaz', '81dc9bdb52d04dc20036dbd8313ed055', 'administrador'),
('miguelgras@docbrown.com', 'Miguel', 'Gras', '81dc9bdb52d04dc20036dbd8313ed055', 'camarero'),
('polgarcia@docbrown.com', 'Pol', 'Garcia', '81dc9bdb52d04dc20036dbd8313ed055', 'administrador'),
('sergiojimenez@docbrown.com', 'Sergio', 'Jimenez', '81dc9bdb52d04dc20036dbd8313ed055', 'mantenimiento'),
('test@test.com', 'test', 'test', '81dc9bdb52d04dc20036dbd8313ed055', 'administrador'),
('xaviergomez@docbrown.com', 'Xavi', 'Gomez', '81dc9bdb52d04dc20036dbd8313ed055', 'camarero');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_historial`
--
ALTER TABLE `tbl_historial`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `fk_historial_mesa_idx` (`id_mesa`),
  ADD KEY `fk_historial_usuario_idx` (`email`);

--
-- Indices de la tabla `tbl_historialonline`
--
ALTER TABLE `tbl_historialonline`
  ADD PRIMARY KEY (`id_historialonline`),
  ADD KEY `fk_reservaonline_mesa_idx` (`id_mesa`);

--
-- Indices de la tabla `tbl_incidencia`
--
ALTER TABLE `tbl_incidencia`
  ADD PRIMARY KEY (`id_incidencia`),
  ADD KEY `fk_incidencia_localizacion_idx` (`id_localizacion`),
  ADD KEY `fk_incidencia_mesa_idx` (`id_mesa`),
  ADD KEY `fk_incidencia_usuario_idx` (`email`);

--
-- Indices de la tabla `tbl_localizacion`
--
ALTER TABLE `tbl_localizacion`
  ADD PRIMARY KEY (`id_localizacion`);

--
-- Indices de la tabla `tbl_mesa`
--
ALTER TABLE `tbl_mesa`
  ADD PRIMARY KEY (`id_mesa`),
  ADD KEY `fk_mesa_localizacion_idx` (`id_localizacion`);

--
-- Indices de la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_historial`
--
ALTER TABLE `tbl_historial`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `tbl_historialonline`
--
ALTER TABLE `tbl_historialonline`
  MODIFY `id_historialonline` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_incidencia`
--
ALTER TABLE `tbl_incidencia`
  MODIFY `id_incidencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tbl_localizacion`
--
ALTER TABLE `tbl_localizacion`
  MODIFY `id_localizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_mesa`
--
ALTER TABLE `tbl_mesa`
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_historial`
--
ALTER TABLE `tbl_historial`
  ADD CONSTRAINT `fk_historial_mesa` FOREIGN KEY (`id_mesa`) REFERENCES `tbl_mesa` (`id_mesa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_historial_usuario` FOREIGN KEY (`email`) REFERENCES `tbl_usuario` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_historialonline`
--
ALTER TABLE `tbl_historialonline`
  ADD CONSTRAINT `fk_reservaonline_mesa` FOREIGN KEY (`id_mesa`) REFERENCES `tbl_mesa` (`id_mesa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_incidencia`
--
ALTER TABLE `tbl_incidencia`
  ADD CONSTRAINT `fk_incidencia_localizacion` FOREIGN KEY (`id_localizacion`) REFERENCES `tbl_localizacion` (`id_localizacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_incidencia_mesa` FOREIGN KEY (`id_mesa`) REFERENCES `tbl_mesa` (`id_mesa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_incidencia_usuario` FOREIGN KEY (`email`) REFERENCES `tbl_usuario` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_mesa`
--
ALTER TABLE `tbl_mesa`
  ADD CONSTRAINT `fk_mesa_localizacion` FOREIGN KEY (`id_localizacion`) REFERENCES `tbl_localizacion` (`id_localizacion`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
