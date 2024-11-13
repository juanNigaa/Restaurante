-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-11-2024 a las 14:20:21
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
-- Base de datos: `restaurante`
--
CREATE DATABASE IF NOT EXISTS `restaurante` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `restaurante`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `Numero_mesa` int(11) NOT NULL,
  `Estado` set('Libre','Ocupada','','') NOT NULL,
  `Numero_comensales` int(11) NOT NULL,
  `ID_usuario` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`Numero_mesa`, `Estado`, `Numero_comensales`, `ID_usuario`) VALUES
(1, 'Libre', 0, 2),
(2, 'Ocupada', 12, 4),
(3, 'Ocupada', 5, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `ID_Pedido` int(100) NOT NULL,
  `ID_comida` int(100) NOT NULL,
  `Comida` varchar(50) NOT NULL,
  `Precio` int(100) NOT NULL,
  `Cantidad` int(100) NOT NULL,
  `Imagen` varchar(255) NOT NULL,
  `ID_usuario` int(100) NOT NULL,
  `Numeromesa` int(11) NOT NULL,
  `Notas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ID_comida` int(100) NOT NULL,
  `Comida` varchar(280) NOT NULL,
  `Cantidad` int(100) NOT NULL,
  `Precio` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID_comida`, `Comida`, `Cantidad`, `Precio`) VALUES
(1, 'Pollo', 100, 10),
(2, 'Arepa Con todo', 100, 15),
(3, 'Arroz con pollo Colombiano', 50, 25),
(4, 'Chuleta valluna', 10, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `ID_rol` int(100) NOT NULL,
  `Rol` set('Encargado','Camarero','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`ID_rol`, `Rol`) VALUES
(1, 'Encargado'),
(2, 'Camarero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID_usuario` int(100) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Usuario` varchar(20) NOT NULL,
  `Contrasena` varchar(12) NOT NULL,
  `ID_rol` int(100) NOT NULL,
  `Foto_DNI` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID_usuario`, `Nombre`, `Usuario`, `Contrasena`, `ID_rol`, `Foto_DNI`) VALUES
(1, 'Juan andres', 'JuanM', 'narutosxd@', 1, 'Imagenes/NIE_encargado.jpg'),
(2, 'Daniel matias', 'Dani23', 'DAW23', 2, 'Imagenes/Dni1.png'),
(3, 'Diego armando', 'Eldiego', 'DAW1234', 2, 'Imagenes/Dni2.png'),
(4, 'Benito camelas', 'BenitoxD', '12345', 2, 'Imagenes/DNI_camarero.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`Numero_mesa`),
  ADD KEY `ID_usuario` (`ID_usuario`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`ID_Pedido`),
  ADD KEY `ID_usuario` (`ID_usuario`),
  ADD KEY `Numeromesa` (`Numeromesa`),
  ADD KEY `ID_comida` (`ID_comida`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID_comida`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`ID_rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID_usuario`),
  ADD KEY `ID_rol` (`ID_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `Numero_mesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `ID_Pedido` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID_comida` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `ID_rol` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_usuario` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD CONSTRAINT `mesas_ibfk_1` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`Numeromesa`) REFERENCES `mesas` (`Numero_mesa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedidos_ibfk_3` FOREIGN KEY (`ID_comida`) REFERENCES `productos` (`ID_comida`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`ID_rol`) REFERENCES `roles` (`ID_rol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
