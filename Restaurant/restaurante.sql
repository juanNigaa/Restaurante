-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-11-2024 a las 17:47:48
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
-- Estructura de tabla para la tabla `lineas_pedido`
--

CREATE TABLE `lineas_pedido` (
  `ID_linea` int(100) NOT NULL,
  `ID_pedido` int(100) DEFAULT NULL,
  `ID_comida` int(100) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `nota` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `lineas_pedido`
--

INSERT INTO `lineas_pedido` (`ID_linea`, `ID_pedido`, `ID_comida`, `cantidad`, `precio`, `nota`) VALUES
(1, 31, 1, 1, 15.00, ''),
(2, 32, 3, 2, 8.00, ''),
(3, 32, 4, 3, 8.00, ''),
(4, 32, 5, 1, 6.00, ''),
(5, 33, 1, 2, 15.00, 'Con hielo'),
(6, 33, 3, 1, 8.00, 'Con salsa'),
(7, 33, 5, 1, 6.00, 'Extra canela'),
(8, 34, 1, 2, 15.00, 'Con hielo'),
(9, 34, 3, 1, 8.00, 'Con salsa'),
(10, 34, 4, 5, 8.00, 'Con aji'),
(11, 35, 1, 2, 15.00, 'Con hielo'),
(12, 36, 2, 1, 5.00, 'Con hielo'),
(13, 36, 3, 1, 8.00, 'Con ketchup'),
(14, 37, 1, 1, 15.00, 'hielo'),
(15, 37, 3, 2, 8.00, 'salsa'),
(16, 38, 1, 1, 15.00, 'con hielo'),
(17, 39, 3, 2, 8.00, 'Con salsa de tomate '),
(18, 39, 5, 1, 6.00, ''),
(19, 39, 1, 2, 15.00, 'Con hielo'),
(20, 40, 5, 1, 6.00, ''),
(21, 41, 7, 1, 3.50, 'Con hielo'),
(22, 41, 3, 1, 8.00, 'Con salsa'),
(23, 41, 4, 4, 8.00, 'Con aji'),
(24, 41, 8, 2, 6.50, 'Con lechera'),
(25, 42, 2, 1, 5.00, ''),
(26, 42, 3, 1, 8.00, 'salsa'),
(27, 42, 4, 1, 8.00, 'aji'),
(28, 42, 11, 2, 3.00, 'aji rojo'),
(29, 43, 7, 1, 3.50, 'con hielo'),
(30, 43, 3, 1, 8.00, 'salsa'),
(31, 43, 12, 2, 8.00, ''),
(32, 44, 5, 1, 6.00, 'con lechera'),
(33, 45, 12, 4, 8.00, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `Numero_mesa` int(11) NOT NULL,
  `Estado` set('Libre','Ocupada','Pagada','') NOT NULL,
  `Numero_comensales` int(11) NOT NULL,
  `ID_usuario` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`Numero_mesa`, `Estado`, `Numero_comensales`, `ID_usuario`) VALUES
(1, 'Ocupada', 0, 2),
(2, 'Ocupada', 2, 4),
(3, 'Ocupada', 0, 3),
(4, 'Ocupada', 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `ID_Pedido` int(100) NOT NULL,
  `ID_usuario` int(100) NOT NULL,
  `Numeromesa` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `fecha_hora` datetime NOT NULL DEFAULT current_timestamp(),
  `Estado` set('pendiente','pagado','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`ID_Pedido`, `ID_usuario`, `Numeromesa`, `Fecha`, `fecha_hora`, `Estado`) VALUES
(31, 2, 1, '2024-11-20', '2024-11-20 21:42:02', 'pagado'),
(32, 2, 1, '2024-11-20', '2024-11-20 21:57:24', 'pagado'),
(33, 2, 1, '2024-11-21', '2024-11-21 22:13:36', 'pagado'),
(34, 2, 1, '2024-11-21', '2024-11-21 22:41:09', ''),
(35, 2, 1, '2024-11-21', '2024-11-21 22:44:29', 'pagado'),
(36, 2, 1, '2024-11-22', '2024-11-22 10:51:49', 'pagado'),
(37, 2, 1, '2024-11-22', '2024-11-22 11:26:50', 'pagado'),
(38, 2, 1, '2024-11-22', '2024-11-22 11:28:51', 'pagado'),
(39, 2, 1, '2024-11-25', '2024-11-25 09:16:25', 'pagado'),
(40, 2, 1, '2024-11-25', '2024-11-25 09:21:09', 'pagado'),
(41, 2, 2, '2024-11-25', '2024-11-25 11:47:53', 'pendiente'),
(42, 2, 1, '2024-11-26', '2024-11-26 09:24:45', 'pagado'),
(43, 2, 3, '2024-11-26', '2024-11-26 10:15:27', 'pagado'),
(44, 2, 3, '2024-11-26', '2024-11-26 10:15:57', 'pagado'),
(45, 2, 3, '2024-11-26', '2024-11-26 10:16:48', 'pagado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ID_comida` int(11) NOT NULL,
  `comida` varchar(50) NOT NULL,
  `tipo` set('Bebida','Entrante','Plato Fuerte','Postre') NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID_comida`, `comida`, `tipo`, `precio`, `imagen`) VALUES
(1, 'Cocacola', 'Bebida', 15.00, 'Imagenes/Cocacola.jpg'),
(2, 'Redbull', 'Bebida', 5.00, 'Imagenes/Redbull.jpg'),
(3, 'ArrozConPollo', 'Plato Fuerte', 8.00, 'Imagenes/arrozcompollo.jpg'),
(4, 'Empanadas', 'Entrante', 8.00, 'Imagenes/Empanada.jpeg'),
(5, 'Arroz de leche', 'Postre', 6.00, 'Imagenes/Arroz de leche.jpg'),
(7, 'Jugo_Maracuya', 'Bebida', 3.50, 'Imagenes/Jugo_Maracuya.jpg'),
(8, 'postredeMilo', 'Postre', 6.50, 'Imagenes/PostredeMilo.jpg'),
(9, 'Envuelto', 'Postre', 5.00, 'Imagenes/Envuelto.png'),
(10, 'Papa rellena', 'Entrante', 4.50, 'Imagenes/Papa_rellena.jpg'),
(11, 'Pastel de yuca', 'Entrante', 3.00, 'Imagenes/Pastel_yuca.jpg'),
(12, 'arepa con todo', 'Plato Fuerte', 8.00, 'Imagenes/arepaContodo.png'),
(13, 'Lechona', 'Plato Fuerte', 12.00, 'Imagenes/lechona.jpg'),
(14, 'MielmeSabe', 'Postre', 12.00, 'Imagenes/Mielmesabe.jpg'),
(15, 'Salchipapa', 'Plato Fuerte', 18.00, 'Imagenes/salchipapa.jfif'),
(16, 'Tortilla', 'Entrante', 5.00, 'Imagenes/Tortilla.jpg'),
(17, 'Frijolada', 'Plato Fuerte', 12.00, 'Imagenes/frijolada.jpg'),
(18, 'Sancocho', 'Plato Fuerte', 6.00, 'Imagenes/sancocho.jpg'),
(19, 'Bandeja paisa', 'Plato Fuerte', 9.00, '1366_2000.jpg'),
(20, 'Chuleta ', 'Plato Fuerte', 11.00, 'Imagenes/chuleta.jpg'),
(21, 'Ajiaco', '', 5.00, 'Imagenes/Ajiaco.jpeg');

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
  `Foto_DNI` varchar(255) NOT NULL,
  `DNI` varchar(11) NOT NULL,
  `Estado` set('Activo','Suspendido','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID_usuario`, `Nombre`, `Usuario`, `Contrasena`, `ID_rol`, `Foto_DNI`, `DNI`, `Estado`) VALUES
(1, 'Juan andres', 'JuanM', 'narutosxd@', 1, 'Imagenes/NIE_encargado.jpg', 'z0185325x', 'Activo'),
(2, 'Daniel matias', 'Dani23', 'DAW23', 2, 'Imagenes/Dni1.png', '20136564R', 'Activo'),
(3, 'Diego armando', 'Eldiego', 'DAW1234', 2, 'Imagenes/Dni2.png', '123456789z', 'Activo'),
(4, 'Benito camelas', 'BenitoxD', '12345', 2, 'Imagenes/DNI_camarero.jpg', '54265642A', 'Activo'),
(5, 'Victor', 'Victorino', '1234567', 1, 'Imagenes/198780_1.jpg', 'A14255125', 'Activo'),
(6, 'Roony', 'ColemanRony', '123456', 2, 'Imagenes/67443f5be0dd1_USUARIo.png', '12356789A', 'Activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `lineas_pedido`
--
ALTER TABLE `lineas_pedido`
  ADD PRIMARY KEY (`ID_linea`),
  ADD KEY `ID_pedido` (`ID_pedido`),
  ADD KEY `fk_lineas_pedido_productos` (`ID_comida`);

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
  ADD KEY `Numeromesa` (`Numeromesa`);

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
-- AUTO_INCREMENT de la tabla `lineas_pedido`
--
ALTER TABLE `lineas_pedido`
  MODIFY `ID_linea` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `Numero_mesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `ID_Pedido` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID_comida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `ID_rol` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_usuario` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lineas_pedido`
--
ALTER TABLE `lineas_pedido`
  ADD CONSTRAINT `fk_lineas_pedido_productos` FOREIGN KEY (`ID_comida`) REFERENCES `productos` (`ID_comida`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lineas_pedido_ibfk_1` FOREIGN KEY (`ID_pedido`) REFERENCES `pedidos` (`ID_Pedido`);

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
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`Numeromesa`) REFERENCES `mesas` (`Numero_mesa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`ID_rol`) REFERENCES `roles` (`ID_rol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
