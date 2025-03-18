-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-03-2025 a las 16:41:00
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
-- Base de datos: `micomercio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `idCliente` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) NOT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estructura de tabla para la tabla `detallepedidos`
--

CREATE TABLE `detallepedidos` (
  `idDetallePedido` int(11) NOT NULL,
  `idPedido` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleventas`
--

CREATE TABLE `detalleventas` (
  `idDetalleVenta` int(11) NOT NULL,
  `idVenta` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalleventas`
--

INSERT INTO `detalleventas` (`idDetalleVenta`, `idVenta`, `idProducto`, `cantidad`, `subtotal`) VALUES
(1, 1, 36, 20.00, 120.00),
(2, 1, 34, 24.00, 144.00),
(3, 1, 2, 1.00, 80.00),
(4, 2, 33, 1.00, 300.00),
(5, 2, 2, 1.00, 100.00),
(6, 3, 33, 1.00, 300.00),
(7, 3, 2, 1.00, 100.00),
(8, 4, 37, 1.00, 150.00),
(9, 4, 13, 8.00, 560.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idVendedor` int(11) NOT NULL,
  `fechaRealizado` date NOT NULL,
  `fechaEntrega` date DEFAULT NULL,
  `tipoPedido` enum('contado','credito') NOT NULL,
  `comentario` varchar(70) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `tipo` enum('por kilo','por unidad','por mitad','oferta','paquete','100','grande','chico','mediano','28cm') NOT NULL,
  `precioEsp` decimal(10,2) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `nombre`, `imagen`, `precio`, `tipo`, `precioEsp`, `activo`) VALUES
(1, 'Pan Negro', '67c626b446d1c.jpg', 120.00, 'por kilo', 120.00, 1),
(2, 'Pan Catalán', '67c627ea22ddf.jpg', 100.00, 'por kilo', 80.00, 1),
(3, 'Pan Marcelles', '67c6280d55da0.jpg', 120.00, 'por kilo', 90.00, 1),
(4, 'Pan Porteño', '67c73761b5237.jpg', 100.00, 'por kilo', 80.00, 1),
(5, 'Pan de Manteca', '67c735d58e54b.jpg', 60.00, 'oferta', 50.00, 1),
(6, 'Pan Flauta', '67c735c0343ed.jpg', 55.00, 'oferta', 45.00, 1),
(7, 'Pan de Viena', '67c6297782772.jpg', 6.00, 'por unidad', 6.00, 1),
(8, 'Pan Catalán Maja', '67c62ab0a07f1.jpg', 8.00, 'por unidad', 8.00, 1),
(9, 'Pan de Maíz', '67c62ae9ac9fa.jpg', 30.00, 'por unidad', 30.00, 1),
(10, 'Pan Flautín', '67c62b09549d6.jpg', 35.00, 'por unidad', 35.00, 1),
(11, 'Galletas de Campaña', '67c735e79a4c5.jpg', 100.00, 'por kilo', 80.00, 1),
(12, 'Galletas Malteadas', '67c62cd7703e1.jpg', 45.00, 'paquete', 45.00, 1),
(13, 'Pizzeta', '67c736f0c66a5.jpg', 70.00, 'por unidad', 50.00, 1),
(14, 'Pizza', '67c62d21d8eac.jpg', 300.00, 'por unidad', 300.00, 1),
(15, 'Tortugas 1', '67c62dac1e1c8.jpg', 6.00, 'por unidad', 6.00, 1),
(16, 'Tortugas 2', '67c62dbebda3c.jpg', 8.00, 'por unidad', 8.00, 1),
(17, 'Tortugas 3', '67c62dd1e7853.jpg', 10.00, 'por unidad', 10.00, 1),
(18, 'Tortugas 4', '67c62de642522.jpg', 20.00, 'por unidad', 20.00, 1),
(19, 'Pebete Con Relleno', '67c62e11c4f7e.jpg', 650.00, '100', 650.00, 1),
(20, 'Pebete Sin Relleno', '67c62e2f386e2.jpg', 440.00, '100', 440.00, 1),
(21, 'Media Luna', '67c73707ad3a1.jpg', 850.00, '100', 850.00, 1),
(22, 'Empanaditas', '67c73719ecfbe.jpg', 850.00, '100', 850.00, 1),
(23, 'Pascualina', '67c62e6fc06c4.jpg', 950.00, 'por unidad', 950.00, 1),
(24, 'Torta de Fiambre', '67c62eff55a6d.jpg', 850.00, 'por unidad', 850.00, 1),
(25, 'Torta de Fiambre', '67c62f163c0e8.jpg', 500.00, 'por mitad', 500.00, 1),
(26, 'Torta de Atún', '67c62f32c2d78.jpg', 930.00, 'por unidad', 930.00, 1),
(27, 'Torta de Atún', '67c62f4447a76.jpg', 550.00, 'por mitad', 550.00, 1),
(28, 'Pasta Flora', '67c62f853ccf0.jpg', 1250.00, 'grande', 1250.00, 1),
(29, 'Pasta Flora', '67c62fa4688da.jpg', 170.00, '28cm', 170.00, 1),
(30, 'Rosca', '67c62fbf246c9.jpg', 70.00, 'por unidad', 50.00, 1),
(31, 'Rosca de Coco', '67c62fe309d84.jpg', 80.00, 'por unidad', 50.00, 1),
(32, 'Cara Sucia', '67c630a86a8e5.jpg', 55.00, 'paquete', 55.00, 1),
(33, 'Bizcochos', '67c738b61e6ec.jpg', 300.00, 'por kilo', 300.00, 1),
(34, 'Bizcochos', '67c738cac098e.jpg', 8.00, 'por unidad', 6.00, 1),
(35, 'Ojitos', '67c73732425b4.jpg', 300.00, 'por kilo', 300.00, 1),
(36, 'Ojitos', '67c7373b6de08.jpg', 8.00, 'por unidad', 6.00, 1),
(37, 'Ojitos', '67c739e3105ff.jpg', 150.00, 'por mitad', 150.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre de usuario para iniciar sesion.',
  `password` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estructura de tabla para la tabla `vendedores`
--

CREATE TABLE `vendedores` (
  `idVendedor` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `idVenta` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idVendedor` int(11) NOT NULL,
  `fechaVenta` date NOT NULL,
  `fechaEntrega` date DEFAULT NULL,
  `tipoVenta` enum('contado','credito') NOT NULL,
  `comentario` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`idVenta`, `idCliente`, `idVendedor`, `fechaVenta`, `fechaEntrega`, `tipoVenta`, `comentario`) VALUES
(1, 48, 1, '2025-03-04', '2025-03-04', 'contado', ''),
(2, 133, 1, '2025-03-04', '2025-03-04', 'contado', 'Charo'),
(3, 133, 1, '2025-03-04', '2025-03-04', 'contado', ''),
(4, 61, 1, '2025-03-04', '2025-03-04', 'contado', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `detallepedidos`
--
ALTER TABLE `detallepedidos`
  ADD PRIMARY KEY (`idDetallePedido`),
  ADD KEY `idPedido` (`idPedido`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `detalleventas`
--
ALTER TABLE `detalleventas`
  ADD PRIMARY KEY (`idDetalleVenta`),
  ADD KEY `idVenta` (`idVenta`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idVendedor` (`idVendedor`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`);

--
-- Indices de la tabla `vendedores`
--
ALTER TABLE `vendedores`
  ADD PRIMARY KEY (`idVendedor`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`idVenta`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idVendedor` (`idVendedor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT de la tabla `detallepedidos`
--
ALTER TABLE `detallepedidos`
  MODIFY `idDetallePedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalleventas`
--
ALTER TABLE `detalleventas`
  MODIFY `idDetalleVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `vendedores`
--
ALTER TABLE `vendedores`
  MODIFY `idVendedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `idVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallepedidos`
--
ALTER TABLE `detallepedidos`
  ADD CONSTRAINT `detallepedidos_ibfk_1` FOREIGN KEY (`idPedido`) REFERENCES `pedidos` (`idPedido`),
  ADD CONSTRAINT `detallepedidos_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`);

--
-- Filtros para la tabla `detalleventas`
--
ALTER TABLE `detalleventas`
  ADD CONSTRAINT `detalleventas_ibfk_1` FOREIGN KEY (`idVenta`) REFERENCES `ventas` (`idVenta`),
  ADD CONSTRAINT `detalleventas_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`idVendedor`) REFERENCES `vendedores` (`idVendedor`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`),
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`idVendedor`) REFERENCES `vendedores` (`idVendedor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
