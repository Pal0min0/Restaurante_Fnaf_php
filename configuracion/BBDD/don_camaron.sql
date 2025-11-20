-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-11-2025 a las 18:17:59
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
-- Base de datos: `don_camaron`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `Usuarioid_usuario` int(5) NOT NULL,
  `Menuid_menu` int(5) NOT NULL,
  `cantidad` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`Usuarioid_usuario`, `Menuid_menu`, `cantidad`) VALUES
(3, 11, 1),
(3, 14, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(5) NOT NULL,
  `nombre` varchar(40) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `precio` int(20) DEFAULT NULL,
  `Tipo_Menuid_tipo_menu` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id_menu`, `nombre`, `descripcion`, `imagen`, `precio`, `Tipo_Menuid_tipo_menu`) VALUES
(4, 'Ceviche mixto', 'Ceviche fresco con variedad de mariscos.', 'ceviche_mixto.avif', 18000, 1),
(5, 'Ceviche de la casa', 'Receta especial de la casa con limón y especias.', 'Ceviche.jpg', 16000, 1),
(6, 'Ceviche de camarón', 'Ceviche preparado con camarones frescos.', 'ceviche_camarones.jpg', 15000, 1),
(7, 'Parrillada de mariscos', 'Combinación surtida de mariscos frescos a la parrilla.', 'parri_mariscox.jpg', 52000, 2),
(8, 'Arroz a la marinera', 'Arroz con mezcla de mariscos frescos.', 'arroz_marinera.jpeg', 28000, 2),
(9, 'Salmón teriyaki', 'Salmón en salsa teriyaki artesanal.', 'salmon_ty.jpg', 45000, 2),
(10, 'Anillos de calamar', 'Calamar empanizado y crocante.', 'anillos_cama.avif', 19000, 2),
(11, 'Pesca del día', 'Filete fresco según disponibilidad diaria.', 'pesca_dia.jpg', 39000, 2),
(12, 'Filete con camarones gratinados', 'Filete acompañado de camarones gratinados.', 'file_cama.jpg', 43000, 2),
(13, 'Frutos rojos', 'Bebida refrescante de frutos rojos.', 'frutos_rojos.jpg', 8000, 3),
(14, 'Piña con hierbabuena', 'Jugo de piña con toque de hierbabuena.', 'piña.jpg', 8000, 3),
(15, 'Mandarina', 'Jugo fresco de mandarina.', 'mandarina.jpg', 8000, 3),
(16, 'Limonada de coco', 'Limonada cremosa con coco.', 'limo_coco.jpg', 10000, 3),
(17, 'Limonada natural', 'Limonada tradicional refrescante.', 'limonada.jpg', 6000, 3),
(18, 'Limonada cerezada', 'Limonada con cereza y un toque dulce.', 'limo_cere.webp', 7000, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `id_mesa` int(11) NOT NULL,
  `numero_mesa` int(11) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `estado` varchar(20) DEFAULT 'disponible',
  `sucursal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`id_mesa`, `numero_mesa`, `capacidad`, `estado`, `sucursal_id`) VALUES
(2, 3, 4, 'ocupada', 1),
(3, 14, 4, 'ocupada', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(5) NOT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `direccion` varchar(40) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `Usuarioid_usuario` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `codigo`, `fecha`, `direccion`, `estado`, `Usuarioid_usuario`) VALUES
(2, 'N561GMY3', '2025-11-17', 'calle 56', 'Entregado', 2),
(3, 'S3WXZ9QC', '2025-11-17', 'calle 45', 'Entregado', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `id_reserva` int(5) NOT NULL,
  `codigo_reserva` varchar(10) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `Usuarioid_usuario` int(5) NOT NULL,
  `Sucursalid_sucursal` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`id_reserva`, `codigo_reserva`, `fecha`, `hora`, `Usuarioid_usuario`, `Sucursalid_sucursal`) VALUES
(2, 'N810LJTX', '2025-11-20', '12:10:00', 2, 1),
(3, 'YFSZQZ0Y', '2025-11-29', '15:15:00', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva_mesa`
--

CREATE TABLE `reserva_mesa` (
  `id_reserva` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reserva_mesa`
--

INSERT INTO `reserva_mesa` (`id_reserva`, `id_mesa`) VALUES
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

CREATE TABLE `sucursal` (
  `id_sucursal` int(5) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sucursal`
--

INSERT INTO `sucursal` (`id_sucursal`, `nombre`, `direccion`, `imagen`) VALUES
(1, 'Don Camaron - Bogotá', 'Cra. 7 #158 - 03', 'restaurante_1.jpg'),
(2, 'Don Camaron - Medellín', 'Calle 50 #10-30', 'restaurante_2.jpg'),
(3, 'Don Camaron - Cali', 'Av. 6N # 34-22', 'restaurante_3.jpg'),
(4, 'Don Camaron - Barranquilla', 'Cl. 84 # 50-15', 'restaurante_4.jpg'),
(5, 'Don Camaron - Cartagena', 'Cl. 38 # 8-55', 'restaurante_5.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_menu`
--

CREATE TABLE `tipo_menu` (
  `id_tipo_menu` int(5) NOT NULL,
  `tipo_menu` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_menu`
--

INSERT INTO `tipo_menu` (`id_tipo_menu`, `tipo_menu`) VALUES
(1, 'Entradas'),
(2, 'Platos Fuertes'),
(3, 'Bebidas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(5) NOT NULL,
  `rol` varchar(20) DEFAULT NULL,
  `nombres` varchar(40) DEFAULT NULL,
  `documento` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `Correo` varchar(40) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `rol`, `nombres`, `documento`, `telefono`, `Correo`, `contrasena`) VALUES
(1, 'Administrador', 'Admin', NULL, '1000000', 'admin@admin.com', '$2y$10$o3NKKvA23QU03mgGxvLW5.ponAIx5k1Kbh7ZhB3M4jjEjNpNj09Xe'),
(2, 'Cliente', 'Juan Pablo Pérez Zamudio ', '24204439', '34253253', 'jpablo23@gmail.com', '$2y$10$9sClPvb.tzF6KDRgSs7BguT3MRdj3Aw.hfXl8/gPvUTsKOG4FObX2'),
(3, 'Cliente', 'Marta Rojas Gonzales', '2324334', '34353535', 'marta1234@gmail.com', '$2y$10$r6pb29oEatRGcY6jsxnlW.FEzXPK/XE7bBHTgDBi5CSil5JE4cMkO');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`Usuarioid_usuario`,`Menuid_menu`),
  ADD KEY `Menuid_menu` (`Menuid_menu`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `Tipo_Menuid_tipo_menu` (`Tipo_Menuid_tipo_menu`);

--
-- Indices de la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`id_mesa`),
  ADD UNIQUE KEY `sucursal_id` (`sucursal_id`,`numero_mesa`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `Usuarioid_usuario` (`Usuarioid_usuario`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `Usuarioid_usuario` (`Usuarioid_usuario`),
  ADD KEY `Sucursalid_sucursal` (`Sucursalid_sucursal`);

--
-- Indices de la tabla `reserva_mesa`
--
ALTER TABLE `reserva_mesa`
  ADD PRIMARY KEY (`id_reserva`,`id_mesa`),
  ADD KEY `id_mesa` (`id_mesa`);

--
-- Indices de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  ADD PRIMARY KEY (`id_sucursal`);

--
-- Indices de la tabla `tipo_menu`
--
ALTER TABLE `tipo_menu`
  ADD PRIMARY KEY (`id_tipo_menu`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `mesa`
--
ALTER TABLE `mesa`
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id_reserva` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  MODIFY `id_sucursal` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_menu`
--
ALTER TABLE `tipo_menu`
  MODIFY `id_tipo_menu` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`Usuarioid_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`Menuid_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE;

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`Tipo_Menuid_tipo_menu`) REFERENCES `tipo_menu` (`id_tipo_menu`) ON DELETE CASCADE;

--
-- Filtros para la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD CONSTRAINT `mesa_ibfk_1` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursal` (`id_sucursal`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`Usuarioid_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`Usuarioid_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`Sucursalid_sucursal`) REFERENCES `sucursal` (`id_sucursal`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reserva_mesa`
--
ALTER TABLE `reserva_mesa`
  ADD CONSTRAINT `reserva_mesa_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reserva` (`id_reserva`) ON DELETE CASCADE,
  ADD CONSTRAINT `reserva_mesa_ibfk_2` FOREIGN KEY (`id_mesa`) REFERENCES `mesa` (`id_mesa`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
