-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-11-2024 a las 19:03:24
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion_impresoras`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_impresoras`
--

CREATE TABLE `historial_impresoras` (
  `id` int(11) NOT NULL,
  `id_impresora` int(11) DEFAULT NULL,
  `contador_negro` int(11) DEFAULT NULL,
  `contador_color` int(11) DEFAULT NULL,
  `total_impresiones` int(11) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_impresoras`
--

INSERT INTO `historial_impresoras` (`id`, `id_impresora`, `contador_negro`, `contador_color`, `total_impresiones`, `estado`, `fecha_actualizacion`) VALUES
(1, 3, 400, 200, 600, 'operativa', '2024-11-13 23:11:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_reportes`
--

CREATE TABLE `imagenes_reportes` (
  `id` int(11) NOT NULL,
  `impresora_id` int(11) NOT NULL,
  `ruta_imagen` varchar(255) NOT NULL,
  `fecha_carga` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impresoras`
--

CREATE TABLE `impresoras` (
  `id` int(11) NOT NULL,
  `contador_negro` int(11) DEFAULT 0,
  `contador_color` int(11) DEFAULT 0,
  `total_impresiones` int(11) GENERATED ALWAYS AS (`contador_negro` + `contador_color`) STORED,
  `fecha_instalacion` date DEFAULT NULL,
  `lugar` varchar(100) DEFAULT NULL,
  `sector` varchar(100) DEFAULT NULL,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` enum('operativa','mantenimiento','fuera de servicio') DEFAULT 'operativa',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `modelo_id` int(11) DEFAULT NULL,
  `nombre_id` int(11) DEFAULT NULL,
  `marca_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `impresoras`
--

INSERT INTO `impresoras` (`id`, `contador_negro`, `contador_color`, `fecha_instalacion`, `lugar`, `sector`, `fecha_actualizacion`, `estado`, `fecha_registro`, `modelo_id`, `nombre_id`, `marca_id`) VALUES
(3, 400, 200, '2024-11-13', 'test', 'test', '2024-11-13 23:11:41', 'operativa', '2024-11-13 19:08:04', 1, 1, 0),
(4, 500, 500, '2024-11-13', 'test', 'test', '2024-11-13 20:32:59', 'operativa', '2024-11-13 20:32:59', 2, 1, 0),
(5, 144, 4444, '0000-00-00', 'test', 'test', '2024-11-14 17:49:39', 'operativa', '2024-11-14 17:49:39', 5, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `nombre_marca` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombre_marca`) VALUES
(1, 'Epson'),
(2, 'HP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos`
--

CREATE TABLE `modelos` (
  `id` int(11) NOT NULL,
  `nombre_modelo` varchar(100) NOT NULL,
  `marca_id` int(11) DEFAULT NULL,
  `tipo_impresion` enum('Blanco y Negro','Blanco y Negro y Colorido') NOT NULL DEFAULT 'Blanco y Negro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modelos`
--

INSERT INTO `modelos` (`id`, `nombre_modelo`, `marca_id`, `tipo_impresion`) VALUES
(1, 'Modelo A', NULL, 'Blanco y Negro'),
(2, 'Modelo B', NULL, 'Blanco y Negro'),
(3, 'Modelo C', NULL, 'Blanco y Negro'),
(4, 'L120', 1, 'Blanco y Negro'),
(5, 'L220', 1, 'Blanco y Negro'),
(6, 'Deskjet 2130', 2, 'Blanco y Negro'),
(13, 'im400', 1, 'Blanco y Negro y Colorido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nombres`
--

CREATE TABLE `nombres` (
  `id` int(11) NOT NULL,
  `nombre_impresora` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nombres`
--

INSERT INTO `nombres` (`id`, `nombre_impresora`) VALUES
(1, 'Impresora 1'),
(2, 'Impresora 2'),
(3, 'Impresora 3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `series`
--

CREATE TABLE `series` (
  `id` int(11) NOT NULL,
  `numero_serie` varchar(100) NOT NULL,
  `id_impresora` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `historial_impresoras`
--
ALTER TABLE `historial_impresoras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_impresora` (`id_impresora`);

--
-- Indices de la tabla `imagenes_reportes`
--
ALTER TABLE `imagenes_reportes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `impresora_id` (`impresora_id`);

--
-- Indices de la tabla `impresoras`
--
ALTER TABLE `impresoras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modelo_id` (`modelo_id`),
  ADD KEY `nombre_id` (`nombre_id`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_marca` (`nombre_marca`);

--
-- Indices de la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_modelo` (`nombre_modelo`),
  ADD KEY `marca_id` (`marca_id`);

--
-- Indices de la tabla `nombres`
--
ALTER TABLE `nombres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_impresora` (`nombre_impresora`);

--
-- Indices de la tabla `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_serie` (`numero_serie`),
  ADD KEY `id_impresora` (`id_impresora`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `historial_impresoras`
--
ALTER TABLE `historial_impresoras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `imagenes_reportes`
--
ALTER TABLE `imagenes_reportes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `impresoras`
--
ALTER TABLE `impresoras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `modelos`
--
ALTER TABLE `modelos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `nombres`
--
ALTER TABLE `nombres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `series`
--
ALTER TABLE `series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial_impresoras`
--
ALTER TABLE `historial_impresoras`
  ADD CONSTRAINT `historial_impresoras_ibfk_1` FOREIGN KEY (`id_impresora`) REFERENCES `impresoras` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `imagenes_reportes`
--
ALTER TABLE `imagenes_reportes`
  ADD CONSTRAINT `imagenes_reportes_ibfk_1` FOREIGN KEY (`impresora_id`) REFERENCES `impresoras` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `impresoras`
--
ALTER TABLE `impresoras`
  ADD CONSTRAINT `impresoras_ibfk_1` FOREIGN KEY (`modelo_id`) REFERENCES `modelos` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `impresoras_ibfk_2` FOREIGN KEY (`nombre_id`) REFERENCES `nombres` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD CONSTRAINT `modelos_ibfk_1` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `series`
--
ALTER TABLE `series`
  ADD CONSTRAINT `series_ibfk_1` FOREIGN KEY (`id_impresora`) REFERENCES `impresoras` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
