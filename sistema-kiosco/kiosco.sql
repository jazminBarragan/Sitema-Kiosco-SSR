-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-01-2025 a las 00:59:51
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
-- Base de datos: `kiosco`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialcompras`
--

CREATE TABLE `historialcompras` (
  `cantProductos` int(11) NOT NULL,
  `nroCliente` int(11) NOT NULL,
  `metodoDePago` varchar(200) NOT NULL,
  `total` double NOT NULL,
  `fecha` varchar(3000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historialcompras`
--

INSERT INTO `historialcompras` (`cantProductos`, `nroCliente`, `metodoDePago`, `total`, `fecha`) VALUES
(10, 1, 'efectivo', 566, ''),
(10, 1, 'efectivo', 566, ''),
(10, 1, 'efectivo', 566, '06-01-2025 23:51:41'),
(10, 1, 'efectivo', 566, '06-01-2025 23:52:48'),
(10, 1, 'efectivo', 566, '06-01-2025 23:59:18'),
(3, 1, 'efectivo', 466, '07-01-2025 00:00:03'),
(1, 1, 'efectivo', 0, '07-01-2025 00:20:50'),
(1, 1, 'transferencia', 466, '07-01-2025 23:05:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialsesiones`
--

CREATE TABLE `historialsesiones` (
  `nombre` varchar(300) NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historialsesiones`
--

INSERT INTO `historialsesiones` (`nombre`, `fecha`, `estado`) VALUES
('admin', '2024-12-27 20:59:05', 'ingreso'),
('admin', '2024-12-27 20:59:37', 'egreso'),
('empleado1', '2024-12-27 21:00:01', 'ingreso'),
('empleado1', '2024-12-27 21:00:08', 'egreso'),
('admin', '2024-12-27 21:00:26', 'ingreso'),
('admin', '2024-12-28 14:40:52', 'ingreso'),
('admin', '2024-12-29 14:42:45', 'ingreso'),
('admin', '2024-12-29 15:03:14', 'ingreso'),
('admin', '2024-12-29 18:02:23', 'ingreso'),
('admin', '2024-12-29 18:18:24', 'egreso'),
('admin', '2024-12-29 18:18:39', 'ingreso'),
('admin', '2024-12-29 18:25:03', 'ingreso'),
('admin', '2025-01-06 12:51:19', 'ingreso'),
('admin', '2025-01-06 13:12:21', 'ingreso'),
('admin', '2025-01-06 22:09:40', 'ingreso'),
('admin', '2025-01-07 22:16:17', 'ingreso'),
('admin', '2025-01-07 23:03:13', 'egreso'),
('admin', '2025-01-07 23:03:42', 'ingreso'),
('admin', '2025-01-17 12:50:03', 'ingreso'),
('admin', '2025-01-17 14:00:30', 'ingreso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `cantidadPorCompra` int(11) NOT NULL,
  `cantidadEnStock` int(11) NOT NULL,
  `nombre` varchar(300) NOT NULL,
  `costo` double NOT NULL,
  `venta` double NOT NULL,
  `limpio` double NOT NULL,
  `seleccion` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `cantidadPorCompra`, `cantidadEnStock`, `nombre`, `costo`, `venta`, `limpio`, `seleccion`) VALUES
(1, 3, 0, 'don satur', 455, 466, 0, 1),
(2, 0, 0, 'FFF', 0, 0, 0, 0),
(3, 0, 0, 'HHHHHHHHHH', 0, 0, 0, 0),
(4, 0, 0, 'UUUUU', 0, 100, 0, 1),
(5, 0, 0, 'UUUUUUUUUUU', 0, 0, 0, 0),
(6, 0, 0, 'TYJUYT', 0, 0, 0, 0),
(7, 0, 0, 'YJ', 0, 0, 0, 0),
(8, 0, 0, 'JYTJ', 0, 0, 0, 0),
(9, 0, 0, 'JTYR', 0, 0, 0, 0),
(10, 0, 0, 'JRTRY', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `contraseña` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `contraseña`) VALUES
(1, 'empleado1', '$2b$12$ppDnWH3DBb9yTXe.5/nIM.K6qNh0.xvaspaEPldmiVOthATRFuGH2'),
(2, 'empleado2', '$2b$12$441TloxLk0G8tpyawiR91.OSZY9gb.1ODGqAiqd/XUnbl2sI4oAX.'),
(3, 'admin', '$2b$12$.22VecE4LFJ60xD6cmcJJ.X0NEOB0jelE2VSFh8/w3XUaklFmRLVa');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
