-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-02-2025 a las 00:58:48
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
-- Base de datos: `kiosco`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajadiaria`
--

CREATE TABLE `cajadiaria` (
  `id` int(11) NOT NULL,
  `inicioSesion` datetime NOT NULL,
  `egresoSesion` datetime NOT NULL,
  `empleado` varchar(200) NOT NULL,
  `totalCosto` double NOT NULL,
  `totalVenta` double NOT NULL,
  `limpio` double NOT NULL,
  `cantProductos` int(11) NOT NULL,
  `cantClientes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cajadiaria`
--

INSERT INTO `cajadiaria` (`id`, `inicioSesion`, `egresoSesion`, `empleado`, `totalCosto`, `totalVenta`, `limpio`, `cantProductos`, `cantClientes`) VALUES
(1, '2025-02-24 20:55:37', '2025-02-24 20:55:59', 'empleado1', 580, 4000, 3420, 4, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialcompras`
--

CREATE TABLE `historialcompras` (
  `cantProductos` int(11) NOT NULL,
  `nroCliente` int(11) NOT NULL,
  `metodoDePago` varchar(200) NOT NULL,
  `totalCosto` double NOT NULL,
  `totalVenta` double NOT NULL,
  `limpio` double NOT NULL,
  `fecha` varchar(3000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historialcompras`
--

INSERT INTO `historialcompras` (`cantProductos`, `nroCliente`, `metodoDePago`, `totalCosto`, `totalVenta`, `limpio`, `fecha`) VALUES
(4, 1, 'efectivo', 580, 4000, 3420, '2025-24-02 20:55:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialsesiones`
--

CREATE TABLE `historialsesiones` (
  `nombre` varchar(150) NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historialsesiones`
--

INSERT INTO `historialsesiones` (`nombre`, `fecha`, `estado`) VALUES
('empleado1', '2025-02-24 20:54:25', 'ingreso'),
('empleado1', '2025-02-24 20:55:23', 'egreso'),
('empleado1', '2025-02-24 20:55:37', 'ingreso'),
('empleado1', '2025-02-24 20:55:59', 'egreso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `cantidadPorCompra` int(11) NOT NULL DEFAULT 1,
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
(1, 1, 96, 'gaseosa', 130, 1000, 870, 0),
(6, 1, 61, 'don satur', 90, 1000, 910, 0),
(11, 1, 60, 'pepas', 200, 1000, 800, 0),
(12, 1, 93, 'don satur', 160, 1000, 40, 0),
(13, 1, 61, 'mantecol 100gr', 300, 1000, 700, 0),
(14, 1, 126, 'gatorade', 400, 1000, 600, 0),
(15, 1, 54, 'don satur dulce', 600, 1000, 400, 0),
(16, 1, 119, 'don satur salada', 200, 12000, 0, 0),
(17, 1, 300, 'chupetin', 150, 200, 50, 0),
(18, 1, 50, 'agua', 100, 150, 50, 0),
(19, 1, 498, 'chicle', 200, 300, 100, 0),
(20, 1, 30, 'push pop', 210, 350, 140, 0),
(21, 1, 99, 'chupetin bola loca', 120, 200, 80, 0);

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
-- Indices de la tabla `cajadiaria`
--
ALTER TABLE `cajadiaria`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT de la tabla `cajadiaria`
--
ALTER TABLE `cajadiaria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
