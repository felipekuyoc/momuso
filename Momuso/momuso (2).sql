-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-12-2024 a las 04:53:13
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
-- Base de datos: `momuso`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administraciondecontenidos`
--

CREATE TABLE `administraciondecontenidos` (
  `ID_Contenido` int(11) NOT NULL,
  `Tipo_Contenido` varchar(100) DEFAULT NULL,
  `Detalles_Contenido` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administraciondecontenidos`
--

INSERT INTO `administraciondecontenidos` (`ID_Contenido`, `Tipo_Contenido`, `Detalles_Contenido`) VALUES
(1, 'Banner', 'Descuento de Verano: ¡Aprovecha hasta un 20% en todos los productos!'),
(2, 'Página Estática', 'Acerca de Nosotros: Información sobre nuestra misión y visión.'),
(3, 'Política de Privacidad', 'Detalles sobre cómo manejamos tus datos personales.'),
(4, 'Banner', 'Black Friday: Descuentos de hasta el 50% en productos seleccionados.'),
(5, 'Página Estática', 'Términos y Condiciones: Normas de uso del sitio web.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritodecompras`
--

CREATE TABLE `carritodecompras` (
  `ID_Carrito` int(11) NOT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `ID_Producto` int(11) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `Fecha_Compra` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carritodecompras`
--

INSERT INTO `carritodecompras` (`ID_Carrito`, `ID_Usuario`, `ID_Producto`, `Cantidad`, `Fecha_Compra`) VALUES
(16, 1, 1, 6, '2024-12-01 13:34:14'),
(17, 2, 2, 1, '2024-12-01 13:34:14'),
(18, 3, 3, 3, '2024-12-01 13:34:14'),
(19, 4, 4, 1, '2024-12-01 13:34:14'),
(20, 5, 5, 4, '2024-12-01 13:34:14'),
(21, 1, 3, 3, '2024-12-01 13:34:14'),
(22, 5, 3, 15, '2024-12-01 13:44:35'),
(23, 5, 4, 9, '2024-12-01 16:42:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `ID_Categoria` int(11) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`ID_Categoria`, `Nombre`) VALUES
(1, 'Moda'),
(2, 'Accesorios'),
(3, 'Juguetes'),
(4, 'Salud y Belleza'),
(5, 'Electrónica'),
(6, 'Ropa de Mujer'),
(7, 'Ropa'),
(9, 'Peluches'),
(11, 'Disfraz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio`
--

CREATE TABLE `envio` (
  `ID_Envio` int(11) NOT NULL,
  `ID_Pedido` int(11) DEFAULT NULL,
  `Direccion_Envio` varchar(255) DEFAULT NULL,
  `Empresa_Mensajeria` varchar(100) DEFAULT NULL,
  `Numero_Seguimiento` varchar(50) DEFAULT NULL,
  `Fecha_Envio` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `envio`
--

INSERT INTO `envio` (`ID_Envio`, `ID_Pedido`, `Direccion_Envio`, `Empresa_Mensajeria`, `Numero_Seguimiento`, `Fecha_Envio`) VALUES
(1, 1, 'Av. Principal 123, Ciudad A', 'DHL', 'ZX123456789', '2024-10-01'),
(2, 2, 'Calle Falsa 456, Ciudad B', 'FedEx', 'AB987654321', '2024-10-02'),
(3, 3, 'Calle Real 789, Ciudad C', 'UPS', 'UV123456789', '2024-10-03'),
(4, 4, 'Avenida Nueva 321, Ciudad D', 'DHL', 'XY987654321', '2024-10-04'),
(5, 5, 'Plaza Central 654, Ciudad E', 'Estafeta', 'PQ456789012', '2024-10-05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metododepago`
--

CREATE TABLE `metododepago` (
  `ID_Pago` int(11) NOT NULL,
  `ID_Pedido` int(11) DEFAULT NULL,
  `Metodo_Pago` varchar(50) DEFAULT NULL,
  `Detalles_Pago` text DEFAULT NULL,
  `Estado_Pago` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metododepago`
--

INSERT INTO `metododepago` (`ID_Pago`, `ID_Pedido`, `Metodo_Pago`, `Detalles_Pago`, `Estado_Pago`) VALUES
(1, 1, 'Tarjeta de Crédito', 'Pago realizado con VISA', 'Completado'),
(2, 2, 'PayPal', 'Pago completado vía PayPal', 'Completado'),
(3, 3, 'Tarjeta de Débito', 'Pago con MasterCard', 'Pendiente'),
(4, 4, 'Transferencia Bancaria', 'Pago en proceso por transferencia', 'Pendiente'),
(5, 5, 'Efectivo', 'Pago en efectivo al momento de entrega', 'Completado'),
(6, 6, 'Tarjeta de Crédito', 'Pago en proceso', 'Pendiente'),
(7, 7, 'Tarjeta de Crédito', 'Pago en proceso', 'Pendiente'),
(8, 8, 'Tarjeta de Crédito', 'Pago en proceso', 'Pendiente'),
(9, 9, 'Tarjeta de Crédito', 'Pago en proceso', 'Pendiente'),
(10, 10, 'Tarjeta de Crédito', 'Pago en proceso', 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertasydescuentos`
--

CREATE TABLE `ofertasydescuentos` (
  `ID_Oferta` int(11) NOT NULL,
  `Nombre_Oferta` varchar(100) DEFAULT NULL,
  `Porcentaje_Descuento` float DEFAULT NULL,
  `Fecha_Inicio` date DEFAULT NULL,
  `Fecha_Finalizacion` date DEFAULT NULL,
  `ID_Producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ofertasydescuentos`
--

INSERT INTO `ofertasydescuentos` (`ID_Oferta`, `Nombre_Oferta`, `Porcentaje_Descuento`, `Fecha_Inicio`, `Fecha_Finalizacion`, `ID_Producto`) VALUES
(6, 'Descuento Verano', 15, '2024-06-01', '2024-06-30', 1),
(7, 'Promoción Invierno', 20, '2024-12-01', '2024-12-31', 2),
(8, 'Descuento Black Friday', 50, '2024-11-29', '2024-11-30', 3),
(9, 'Descuento Cyber Monday', 40, '2024-12-01', '2024-12-02', 4),
(10, 'Rebajas de Navidad', 20, '2024-12-20', '2024-12-31', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `ID_Pedido` int(11) NOT NULL,
  `Fecha_Compra` date DEFAULT NULL,
  `Estado_Pedido` varchar(50) DEFAULT NULL,
  `ID_Usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`ID_Pedido`, `Fecha_Compra`, `Estado_Pedido`, `ID_Usuario`) VALUES
(1, '2024-10-01', 'Completado', 1),
(2, '2024-10-02', 'Pendiente', 2),
(3, '2024-10-03', 'Completado', 3),
(4, '2024-10-04', 'En Proceso', 4),
(5, '2024-10-05', 'Cancelado', 5),
(6, '2024-11-26', 'Pendiente', 1),
(7, '2024-11-26', 'Pendiente', 1),
(8, '2024-11-26', 'Pendiente', 1),
(9, '2024-11-26', 'Pendiente', 1),
(10, '2024-11-26', 'Pendiente', 1),
(11, '2024-11-27', 'Pendiente', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `ID_Producto` int(11) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `Descripcion` text DEFAULT NULL,
  `Precio` decimal(10,2) DEFAULT NULL,
  `Cantidad_En_Inventario` int(11) DEFAULT NULL,
  `Imagenes` varchar(255) DEFAULT NULL,
  `ID_Categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`ID_Producto`, `Nombre`, `Descripcion`, `Precio`, `Cantidad_En_Inventario`, `Imagenes`, `ID_Categoria`) VALUES
(1, 'Camisa de Moda', 'Camisa casual de hombre', 25.99, 94, 'camisa.jpg', 1),
(2, 'Reloj Deportivo', 'Reloj resistente al agua', 50.00, 48, 'reloj.jpg', 2),
(3, 'Muñeca de Juguete', 'Muñeca articulada para niñas', 20.00, 199, 'muneca.jpg', 3),
(4, 'Crema Facial', 'Crema hidratante para la piel', 15.75, 145, 'crema.jpg', 4),
(5, 'Bolsa de Mano', 'Bolsa de cuero para dama', 30.00, 75, 'bolsa.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseñasycomentarios`
--

CREATE TABLE `reseñasycomentarios` (
  `ID_Reseña` int(11) NOT NULL,
  `ID_Producto` int(11) DEFAULT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `Puntuacion` int(11) DEFAULT NULL CHECK (`Puntuacion` between 1 and 5),
  `Comentario` text DEFAULT NULL,
  `Fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reseñasycomentarios`
--

INSERT INTO `reseñasycomentarios` (`ID_Reseña`, `ID_Producto`, `ID_Usuario`, `Puntuacion`, `Comentario`, `Fecha`) VALUES
(46, 1, 1, 5, 'El producto es de excelente calidad, superó mis expectativas.', '2024-11-20 16:17:44'),
(47, 2, 3, 4, 'Buena relación calidad-precio, pero la entrega fue un poco lenta.', '2024-11-20 16:17:44'),
(48, 3, 3, 3, 'El producto es funcional, aunque esperaba más características.', '2024-11-20 16:17:44'),
(49, 4, 4, 5, 'Muy contento con la compra, lo recomiendo a todos.', '2024-11-20 16:17:44'),
(50, 5, 5, 2, 'La calidad no es tan buena como esperaba por el precio.', '2024-11-20 16:17:44'),
(52, 4, 1, 5, 'Excelente, recomendada al 100', '2024-11-20 16:50:47'),
(67, 1, 5, 5, 'Exelente', '2024-12-02 00:02:24'),
(72, 1, NULL, 5, 'My buena', '2024-12-02 00:34:58'),
(73, 1, NULL, 5, 'ecelente', '2024-12-02 00:35:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ropamujer`
--

CREATE TABLE `ropamujer` (
  `ID_Ropa` int(11) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `Descripcion` text DEFAULT NULL,
  `Precio` decimal(10,2) DEFAULT NULL,
  `Cantidad_En_Inventario` int(11) DEFAULT NULL,
  `Imagenes` varchar(255) DEFAULT NULL,
  `Tamanio` varchar(50) DEFAULT NULL,
  `Color` varchar(50) DEFAULT NULL,
  `ID_Categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ropamujer`
--

INSERT INTO `ropamujer` (`ID_Ropa`, `Nombre`, `Descripcion`, `Precio`, `Cantidad_En_Inventario`, `Imagenes`, `Tamanio`, `Color`, `ID_Categoria`) VALUES
(1, 'Blusa de Seda', 'Blusa de seda, perfecta para ocasiones formales.', 35.99, 50, 'blusa_seda.jpg', 'M', 'Blanco', 6),
(2, 'Falda de Cuero', 'Falda de cuero sintético para look casual.', 45.50, 30, 'falda_cuero.jpg', 'L', 'Negra', 6),
(3, 'Vestido de Verano', 'Vestido ligero y cómodo para el verano.', 29.99, 100, 'vestido_verano.jpg', 'S', 'Rosa', 6),
(4, 'Chaqueta de Lana', 'Chaqueta de lana cálida para el invierno.', 55.00, 25, 'chaqueta_lana.jpg', 'M', 'Azul', 6),
(5, 'Pantalón de Jeans', 'Pantalón de mezclilla ajustado y cómodo.', 39.99, 75, 'pantalon_jeans.jpg', 'L', 'Azul', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID_Usuario` int(11) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `Correo_Electronico` varchar(100) DEFAULT NULL,
  `Contrasena` varchar(255) DEFAULT NULL,
  `Rol` enum('Administrador','Cliente') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_Usuario`, `Nombre`, `Correo_Electronico`, `Contrasena`, `Rol`) VALUES
(1, 'Juan Perez', 'juan.perez@gmail.com', 'ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f', 'Cliente'),
(2, 'Maria Gomez', 'maria.gomez@hotmail.com', '2768b29fde9e02f48891ec8f8fe55745361f4fd08e57d8a29a4e4a5cc961b988', 'Administrador'),
(3, 'Pedro Ruiz', 'pedro.ruiz@yahoo.com', 'a644e2d3738178417cf86e75d3ebbf92c61501c52f683ecd971af7d9f00103d4', 'Cliente'),
(4, 'Ana Lopez', 'ana.lopez@outlook.com', 'f963022d70c6f1210756ef64afede637d9da72e524557efafa7581725141791a', 'Cliente'),
(5, 'Carlos Sanchez', 'carlos.sanchez@gmail.com', '90771e416dda7ee1017c14c2ad3be7dc5903f27f9ec8f569128c81d796c8d675', 'Cliente'),
(7, 'Katherine ', 'kathe@gmail.com', '3cee150a3925a46c0dd1ae91587850f7160ff290e16289cf57b7722f21cd9752', 'Cliente'),
(8, 'Carlos', 'carlos@gmail.com', '$2y$10$HAsqz4zHaAnZhAdXjbGVd.7QcFzccoOPdZBs1vix1x.2L8D8p51ba', 'Administrador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administraciondecontenidos`
--
ALTER TABLE `administraciondecontenidos`
  ADD PRIMARY KEY (`ID_Contenido`);

--
-- Indices de la tabla `carritodecompras`
--
ALTER TABLE `carritodecompras`
  ADD PRIMARY KEY (`ID_Carrito`),
  ADD KEY `ID_Usuario` (`ID_Usuario`),
  ADD KEY `ID_Producto` (`ID_Producto`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID_Categoria`);

--
-- Indices de la tabla `envio`
--
ALTER TABLE `envio`
  ADD PRIMARY KEY (`ID_Envio`),
  ADD KEY `ID_Pedido` (`ID_Pedido`);

--
-- Indices de la tabla `metododepago`
--
ALTER TABLE `metododepago`
  ADD PRIMARY KEY (`ID_Pago`),
  ADD KEY `ID_Pedido` (`ID_Pedido`);

--
-- Indices de la tabla `ofertasydescuentos`
--
ALTER TABLE `ofertasydescuentos`
  ADD PRIMARY KEY (`ID_Oferta`),
  ADD KEY `ID_Producto` (`ID_Producto`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`ID_Pedido`),
  ADD KEY `ID_Usuario` (`ID_Usuario`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`ID_Producto`),
  ADD KEY `ID_Categoria` (`ID_Categoria`);

--
-- Indices de la tabla `reseñasycomentarios`
--
ALTER TABLE `reseñasycomentarios`
  ADD PRIMARY KEY (`ID_Reseña`),
  ADD KEY `ID_Producto` (`ID_Producto`),
  ADD KEY `ID_Usuario` (`ID_Usuario`);

--
-- Indices de la tabla `ropamujer`
--
ALTER TABLE `ropamujer`
  ADD PRIMARY KEY (`ID_Ropa`),
  ADD KEY `ID_Categoria` (`ID_Categoria`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_Usuario`),
  ADD UNIQUE KEY `Correo_Electronico` (`Correo_Electronico`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administraciondecontenidos`
--
ALTER TABLE `administraciondecontenidos`
  MODIFY `ID_Contenido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `carritodecompras`
--
ALTER TABLE `carritodecompras`
  MODIFY `ID_Carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `ID_Categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `envio`
--
ALTER TABLE `envio`
  MODIFY `ID_Envio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `metododepago`
--
ALTER TABLE `metododepago`
  MODIFY `ID_Pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ofertasydescuentos`
--
ALTER TABLE `ofertasydescuentos`
  MODIFY `ID_Oferta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `ID_Pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `ID_Producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `reseñasycomentarios`
--
ALTER TABLE `reseñasycomentarios`
  MODIFY `ID_Reseña` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de la tabla `ropamujer`
--
ALTER TABLE `ropamujer`
  MODIFY `ID_Ropa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carritodecompras`
--
ALTER TABLE `carritodecompras`
  ADD CONSTRAINT `carritodecompras_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`),
  ADD CONSTRAINT `carritodecompras_ibfk_2` FOREIGN KEY (`ID_Producto`) REFERENCES `producto` (`ID_Producto`);

--
-- Filtros para la tabla `envio`
--
ALTER TABLE `envio`
  ADD CONSTRAINT `envio_ibfk_1` FOREIGN KEY (`ID_Pedido`) REFERENCES `pedido` (`ID_Pedido`);

--
-- Filtros para la tabla `metododepago`
--
ALTER TABLE `metododepago`
  ADD CONSTRAINT `metododepago_ibfk_1` FOREIGN KEY (`ID_Pedido`) REFERENCES `pedido` (`ID_Pedido`);

--
-- Filtros para la tabla `ofertasydescuentos`
--
ALTER TABLE `ofertasydescuentos`
  ADD CONSTRAINT `ofertasydescuentos_ibfk_1` FOREIGN KEY (`ID_Producto`) REFERENCES `producto` (`ID_Producto`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`ID_Categoria`) REFERENCES `categoria` (`ID_Categoria`);

--
-- Filtros para la tabla `reseñasycomentarios`
--
ALTER TABLE `reseñasycomentarios`
  ADD CONSTRAINT `reseñasycomentarios_ibfk_1` FOREIGN KEY (`ID_Producto`) REFERENCES `producto` (`ID_Producto`),
  ADD CONSTRAINT `reseñasycomentarios_ibfk_2` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`);

--
-- Filtros para la tabla `ropamujer`
--
ALTER TABLE `ropamujer`
  ADD CONSTRAINT `ropamujer_ibfk_1` FOREIGN KEY (`ID_Categoria`) REFERENCES `categoria` (`ID_Categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
