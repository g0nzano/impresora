-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2024 a las 22:15:32
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
-- Base de datos: `control_impresoras`
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impresoras`
--

CREATE TABLE `impresoras` (
  `id` int(11) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contador_negro` int(11) DEFAULT 0,
  `contador_color` int(11) DEFAULT 0,
  `total_impresiones` int(11) GENERATED ALWAYS AS (`contador_negro` + `contador_color`) STORED,
  `fecha_instalacion` date DEFAULT NULL,
  `lugar` varchar(100) DEFAULT NULL,
  `sector` varchar(100) DEFAULT NULL,
  `fecha_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('operativa','mantenimiento','fuera de servicio') DEFAULT 'operativa',
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `impresoras`
--

INSERT INTO `impresoras` (`id`, `modelo`, `nombre`, `contador_negro`, `contador_color`, `fecha_instalacion`, `lugar`, `sector`, `fecha_cadastro`, `estado`, `fecha_actualizacion`) VALUES
(1, 'test', 'testar', 1, 1, '2024-11-10', 'test', 'test', '2024-11-11 02:19:02', 'operativa', '2024-11-11 02:33:11');

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
-- Indices de la tabla `impresoras`
--
ALTER TABLE `impresoras`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `historial_impresoras`
--
ALTER TABLE `historial_impresoras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `impresoras`
--
ALTER TABLE `impresoras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial_impresoras`
--
ALTER TABLE `historial_impresoras`
  ADD CONSTRAINT `historial_impresoras_ibfk_1` FOREIGN KEY (`id_impresora`) REFERENCES `impresoras` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
