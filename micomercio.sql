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
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idCliente`, `nombre`, `apellido`, `telefono`, `correo`, `activo`) VALUES
(1, 'Joana', NULL, '095311256', NULL, 1),
(2, 'Nicol1', NULL, '093840491', NULL, 1),
(3, 'Gabriela1', 'Garay', '096135310', NULL, 1),
(4, 'Maria', 'Yeyson', '095668268', '', 1),
(5, 'luis', '', '095639253', '', 1),
(6, 'Mathias', '', '094521581', '', 1),
(7, 'Vivi', 'Juarez', '093913868', '', 1),
(8, 'Joana', '', '095311256', NULL, 1),
(9, 'nicol', '', '093840491', NULL, 1),
(10, 'Gabriela', 'garay', '096135310', NULL, 1),
(11, 'maria', 'yeyson', '095668268', NULL, 1),
(12, 'Luis', '', '095639253', NULL, 1),
(13, 'mathias', '', '094521581', NULL, 1),
(14, 'vivi', 'juarez', '093913868', NULL, 1),
(15, 'melina', '', '92119707', NULL, 1),
(16, 'Silvia 3', '', '97300143', NULL, 1),
(17, 'vale', '', '94320905', NULL, 1),
(18, 'carmencita', 'palacios', '098171505', NULL, 1),
(19, 'Rossana', 'guidobono', '092240085', NULL, 1),
(20, 'lorena', '', '096922565', NULL, 1),
(21, 'valeeria', 'clienta', '097005286', NULL, 1),
(22, 'tathiana', '', '094786758', NULL, 1),
(23, 'eduarno y vane', '', '099230799', NULL, 1),
(24, 'Beatriz', '', '093878605', NULL, 1),
(25, 'mercadito', 'charys', '095410547', NULL, 1),
(26, 'Andrea', 'p-Alcira', '092365958', NULL, 1),
(27, 'Javier', 'almacen', '095186472', NULL, 1),
(28, 'Angela', 'pirezz', '095796348', NULL, 1),
(29, 'isamel', 'Vicente', '093926374', NULL, 1),
(30, 'krishna', '', '092864853', NULL, 1),
(31, 'Andrea', 'arzaguet', '091470840', NULL, 1),
(32, 'Jessy', '', '094108722', NULL, 1),
(33, 'freddy', '', '095635821', NULL, 1),
(34, 'Rossana', '', '095498184', NULL, 1),
(35, 'siamii', 'alonso', '095852707', NULL, 1),
(36, 'Jorge', 'ramirez', '091099028', NULL, 1),
(37, 'miriam', 'almacen', '097298685', NULL, 1),
(38, 'eli', '', '095031633', NULL, 1),
(39, 'jonathan', '', '097951792', NULL, 1),
(40, 'caren', 'larrosa', '095086129', NULL, 1),
(41, 'carola', '', '099676861', NULL, 1),
(42, 'cristina', 'silva', '097518258', NULL, 1),
(43, 'maria', 'juan', '097757210', NULL, 1),
(44, 'zarza', '', '097553692', NULL, 1),
(45, 'julio', 'alvez', '095001040', NULL, 1),
(46, 'carol', '', '094801329', NULL, 1),
(47, 'estefani', 'vecina', '097977866', NULL, 1),
(48, 'andrea', '', '095923396', NULL, 1),
(49, 'fabian', 'lopez', '095186113', NULL, 1),
(50, 'isabel', 'ramirez', '091248954', NULL, 1),
(51, 'noble', 'oronio', '096216404', NULL, 1),
(52, 'alcira', '', '096976252', NULL, 1),
(53, 'mariloy', '', '091266042', NULL, 1),
(54, 'miguel angel', '', '096224733', NULL, 1),
(55, 'nancy', '', '096609963', NULL, 1),
(56, 'cecilia', '', '092615710', NULL, 1),
(57, 'jorge', 'martinez', '099112972', NULL, 1),
(58, 'ramon', '', '093762767', NULL, 1),
(59, 'nicolas', '', '097873644', NULL, 1),
(60, 'Elizabet', '', '095536222', NULL, 1),
(61, 'Vicente', '', '095371812', NULL, 1),
(62, 'facu', '', '094382055', NULL, 1),
(63, 'pablo', '', '095557420', NULL, 1),
(64, 'mika', '', '099015025', NULL, 1),
(65, 'leo', '', '097226485', NULL, 1),
(66, 'sole', '', '097153045', NULL, 1),
(67, 'Tatiana', 'bazar', '093730952', NULL, 1),
(68, 'Valeria', 'embarazada', '097056133', NULL, 1),
(69, 'nati', '', '094722474', NULL, 1),
(70, 'erika', 'grosso', '092303927', NULL, 1),
(71, 'ana', 'alonso', '096581973', NULL, 1),
(72, 'vilma', '', '097575068', NULL, 1),
(73, 'camila', '', '097641044', NULL, 1),
(74, 'lucia', '', '096238523', NULL, 1),
(75, 'gloria', '', '094898576', NULL, 1),
(76, 'antonela', '', '092893978', NULL, 1),
(77, 'belen', 'flor', '095923944', NULL, 1),
(78, 'caro', '', '097356040', NULL, 1),
(79, 'Silvia', 'sastre', '091805238', NULL, 1),
(80, 'gloria 2', '', '097789677', NULL, 1),
(81, 'silvana', '', '092796602', NULL, 1),
(82, 'Elizabeth', 'castro', '093774955', NULL, 1),
(83, 'katerin', '', '094174917', NULL, 1),
(84, 'claudia', 'Vidal', '094031317', NULL, 1),
(85, 'genesis y marcelo', '', '096555401', NULL, 1),
(86, 'rosa', 'alonso', '094031479', NULL, 1),
(87, 'noe', '', '091750604', NULL, 1),
(88, 'silvana', 'escobar', '094067915', NULL, 1),
(89, 'leonardo', '', '099572796', NULL, 1),
(90, 'Juancho', '', '094677191', NULL, 1),
(91, 'maja', 'eventos', '095682885', NULL, 1),
(92, 'Paty y dani', '', '097307378', NULL, 1),
(93, 'Laura', '', '097938203', NULL, 1),
(94, 'agus', '', '093772800', NULL, 1),
(95, 'veronica', 'etchechury', '096385941', NULL, 1),
(96, 'patricia', '', '093497824', NULL, 1),
(97, 'iris', 'alvaro', '092158074', NULL, 1),
(98, 'iris', 'amiga', '098912607', NULL, 1),
(99, 'Andreina', '', '095317557', NULL, 1),
(100, 'Alicia', 'silva', '094494129', NULL, 1),
(101, 'lusmila', '', '097575025', NULL, 1),
(102, 'Karen', '', '097737209', NULL, 1),
(103, 'Silvia 2', '', '098421330', NULL, 1),
(104, 'daiana', '', '099684013', NULL, 1),
(105, 'lauti', 'romero', '094119583', NULL, 1),
(106, 'gissel', '', '092259519', NULL, 1),
(107, 'ataquefinal2', '', '091474415', NULL, 1),
(108, 'agustin', 'oxley', '093451616', NULL, 1),
(109, 'juan', 'vecino', '095328276', NULL, 1),
(110, 'Javier', '', '094030013', NULL, 1),
(111, 'bloquero', '', '099248656', NULL, 1),
(112, 'raul', 'sastre', '096114579', NULL, 1),
(113, 'tania', '', '096379059', NULL, 1),
(114, 'maria Esther', 'ribeiro', '097550610', NULL, 1),
(115, 'Fernanda', 'silva', '096145864', NULL, 1),
(116, 'Luis', 'frigorifico', '094889753', NULL, 1),
(117, 'nadia', 'noble', '099049994', NULL, 1),
(118, 'Sharon', 'gerez', '094068821', NULL, 1),
(119, 'Carlos', '', '094382569', NULL, 1),
(120, 'lu', 'prima de erika', '095826947', NULL, 1),
(121, 'braian', '', '095451433', NULL, 1),
(122, 'maria', 'escobar y pando', '097700972', NULL, 1),
(123, 'lucia', '', '092366230', NULL, 1),
(124, 'valentina', '', '092607734', NULL, 1),
(125, 'gustavo', '', '096367932', NULL, 1),
(126, 'yeyson', 'rodriguez', '094754586', NULL, 1),
(127, 'soledad', '', '092103752', NULL, 1),
(128, 'juan', 'Carlos', '092221395', NULL, 1),
(129, 'Richard', 'acosta', '091885749', NULL, 1),
(130, 'maria', 'barrera', '093402927', NULL, 1),
(131, 'ailen', 'martinez', '096164246', NULL, 1),
(132, 'caro', '', '092854804', NULL, 1),
(133, 'Cliente', 'Genérico', '099999999', '', 1);

-- --------------------------------------------------------

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
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`, `nombre`) VALUES
(0, 'warriol@gmail.com', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 'Wilson Denis');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedores`
--

CREATE TABLE `vendedores` (
  `idVendedor` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vendedores`
--

INSERT INTO `vendedores` (`idVendedor`, `nombre`, `telefono`) VALUES
(1, 'Delba Arriola', '098701910'),
(2, 'Fátima Weigert', '097921701'),
(3, 'Cesar Weigert', '091785364'),
(4, 'Wilson Arriola', '092373973');

-- --------------------------------------------------------

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
