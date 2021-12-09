-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-11-2021 a las 18:03:30
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
-- Base de datos: `db_docbrown`
--
CREATE DATABASE IF NOT EXISTS `db_docbrown` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_docbrown`;

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
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_historial`
--

INSERT INTO `tbl_historial` (`id_historial`, `id_mesa`, `dia_historial`, `inicio_historial`, `fin_historial`, `nombre`) VALUES
(9, 1, '2021-11-05', '16:08:22', '16:08:24', 'Xavi'),
(10, 3, '2021-11-05', '17:10:02', '17:10:08', 'Xavi'),
(11, 2, '2021-11-05', '17:10:05', '17:10:09', 'Xavi'),
(12, 2, '2021-11-05', '17:45:57', '17:46:03', 'Diego'),
(13, 3, '2021-11-05', '17:46:05', '17:46:25', 'Diego'),
(15, 1, '2021-11-05', '19:17:56', '19:17:58', 'Xavi'),
(16, 3, '2021-11-05', '19:32:48', '19:33:07', 'Xavi'),
(17, 104, '2021-11-05', '19:40:42', '19:40:53', 'Xavi'),
(18, 2, '2021-11-08', '15:15:54', '15:16:14', 'Xavi'),
(19, 104, '2021-11-08', '15:50:21', '15:50:59', 'Xavi'),
(20, 1, '2021-11-09', '16:41:11', '16:41:37', 'Xavi'),
(21, 9, '2021-11-09', '17:06:41', '17:09:14', 'Xavi'),
(22, 105, '2021-11-09', '17:09:17', '17:09:20', 'Xavi'),
(25, 1, '2021-11-09', '17:41:16', '17:41:24', 'Xavi'),
(26, 1, '2021-11-09', '17:43:57', '17:43:58', 'Xavi'),
(27, 2, '2021-11-09', '17:53:20', '17:53:21', 'Xavi'),
(28, 105, '2021-11-09', '17:55:56', '17:55:59', 'Xavi');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_incidencia`
--

CREATE TABLE `tbl_incidencia` (
  `id_incidencia` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `id_localizacion` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
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

INSERT INTO `tbl_incidencia` (`id_incidencia`, `id_mesa`, `id_localizacion`, `nombre`, `descripcion_incidencia`, `fecha_inicio_incidencia`, `fecha_fin_incidencia`, `hora_inicio_incidencia`, `hora_final_incidencia`, `resuelto`) VALUES
(2, 1, 1, 'Danny', 'Mesa rota\r\nSilla rota', '2021-11-08', '2021-11-08', '19:58:31', '19:58:46', 'Danny'),
(3, 2, 2, 'Xavi', 'Se ha roto 2 sillas', '2021-11-09', '2021-11-09', '17:10:03', '17:36:39', 'Danny');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_localizacion`
--

CREATE TABLE `tbl_localizacion` (
  `id_localizacion` int(11) NOT NULL,
  `nombre_localizacion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_localizacion`
--

INSERT INTO `tbl_localizacion` (`id_localizacion`, `nombre_localizacion`) VALUES
(1, 'Terraza'),
(2, 'Comedor'),
(3, 'Sala Privada');

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
(102, 4, 12, 'si', 3),
(103, 4, 16, 'si', 3),
(104, 5, 18, 'si', 3),
(105, 5, 20, 'si', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuario`
--

CREATE TABLE `tbl_usuario` (
  `nombre` varchar(45) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contraseña` varchar(100) NOT NULL,
  `tipo` enum('camarero','mantenimiento') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_usuario`
--

INSERT INTO `tbl_usuario` (`nombre`, `email`, `contraseña`, `tipo`) VALUES
('Agnes', 'agnesplans@docbrown.com', '81dc9bdb52d04dc20036dbd8313ed055', 'mantenimiento'),
('Danny', 'dannylarrea@docbrown.com', '81dc9bdb52d04dc20036dbd8313ed055', 'mantenimiento'),
('Diego', 'diegosoledispa@docbrown.com', '81dc9bdb52d04dc20036dbd8313ed055', 'camarero'),
('Ignasi', 'ignasiromero@docbrown.com', '81dc9bdb52d04dc20036dbd8313ed055', 'mantenimiento'),
('Sergio', 'sergiojimenez@docbrown.com', '81dc9bdb52d04dc20036dbd8313ed055', 'mantenimiento'),
('Xavi', 'xaviergomez@docbrown.com', '81dc9bdb52d04dc20036dbd8313ed055', 'camarero');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_historial`
--
ALTER TABLE `tbl_historial`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `fk_historial_mesa_idx` (`id_mesa`),
  ADD KEY `fk_historial_usuario_idx` (`nombre`);

--
-- Indices de la tabla `tbl_incidencia`
--
ALTER TABLE `tbl_incidencia`
  ADD PRIMARY KEY (`id_incidencia`),
  ADD KEY `fk_incidencia_localizacion_idx` (`id_localizacion`),
  ADD KEY `fk_incidencia_mesa_idx` (`id_mesa`),
  ADD KEY `fk_incidencia_usuario_idx` (`nombre`),
  ADD KEY `fk_resuelto_idx` (`resuelto`);

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
  ADD PRIMARY KEY (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_historial`
--
ALTER TABLE `tbl_historial`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `tbl_incidencia`
--
ALTER TABLE `tbl_incidencia`
  MODIFY `id_incidencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  ADD CONSTRAINT `fk_historial_usuario` FOREIGN KEY (`nombre`) REFERENCES `tbl_usuario` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_incidencia`
--
ALTER TABLE `tbl_incidencia`
  ADD CONSTRAINT `fk_incidencia_localizacion` FOREIGN KEY (`id_localizacion`) REFERENCES `tbl_localizacion` (`id_localizacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_incidencia_mesa` FOREIGN KEY (`id_mesa`) REFERENCES `tbl_mesa` (`id_mesa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_incidencia_usuario` FOREIGN KEY (`nombre`) REFERENCES `tbl_usuario` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_resuelto` FOREIGN KEY (`resuelto`) REFERENCES `tbl_usuario` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_mesa`
--
ALTER TABLE `tbl_mesa`
  ADD CONSTRAINT `fk_mesa_localizacion` FOREIGN KEY (`id_localizacion`) REFERENCES `tbl_localizacion` (`id_localizacion`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
