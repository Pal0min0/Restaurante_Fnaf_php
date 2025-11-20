-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2025 a las 05:01:03
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
(4, 'Fazbear Popcorn', 'Crispetas mitad caramelo mitad chocolate, servidas en un envase retro. Dulces y crujientes, perfectas para una noche de shows animatrónicos.', '1763607948_Fazbear Popcorn.jpg', 18000, 1),
(5, 'Freddy Tokens Pretzels', 'Pretzels circulares como fichas de arcade. Salados, crujientes y con vibe de sala recreativa ochentera.', '1763608000_Freddy Tokens Pretzels.jpg', 16000, 1),
(6, '8-bit Freddy Bites', 'Mini cuadritos de cereal cubiertos de chocolate con estética 8-bit. Dulces, nostálgicos y perfectos para acompañar una sesión de arcade.', '1763608041_8-bit Freddy Bites.jpg', 15000, 1),
(7, 'Freddy’s FazBurger', 'Una hamburguesa doble jugosa con queso derretido y pan brioche tostado. Su decoración y colores evocan el estilo de un animatrónico clásico de pizzería, cálido y con un toque retro.', '1763608087_Freddy’s FazBurger.jpg', 52000, 2),
(8, 'Bonnie’s Purple Crunch', 'Nuggets de pollo extra crujientes con un empanizado morado brillante. Su tono vibrante recuerda al ambiente misterioso del backstage lleno de luces púrpura.', '1763608119_Bonnie’s Purple Crunch.jpg', 28000, 2),
(9, 'Chica’s Party Pizza', 'Mini pizzas de fiesta cubiertas con pepperoni en forma de estrella. Tienen un estilo caótico, divertido y explosivo, como un cumpleaños eterno en una pizzería encantada.', '1763608144_Chica’s Party Pizza.jpg', 45000, 2),
(10, 'Foxy’s Pirate Bites', 'Dedos de pescado empanizados con toque pirata, con especias intensas y una presentación inspirada en un corsario animatrónico listo para una aventura marina.', '1763608180_Foxy’s Pirate Bites.jpg', 19000, 2),
(11, 'Nightguard Hotdog', 'Un hotdog con cebolla caramelizada oscura y salsa ahumada, perfecto para un vigilante nocturno que intenta sobrevivir el turno. Sabor fuerte, ambiente sombrío.', '1763608210_Nightguard Hotdog.jpg', 39000, 2),
(12, 'Springtrap Melt Sandwich', 'Sándwich de queso derretido con bordes tostados y estética deteriorada, representando un diseño viejo, quemado y corroído. Sabor reconfortante con un look inquietante.', '1763608254_Springtrap Melt Sandwich.jpg', 43000, 2),
(13, 'Fazbear Fuel', 'Una bebida energética azul eléctrica, servida en un vaso metálico con iluminación retro. Refrescante, vibrante y diseñada para recargar tus niveles de energía.', '1763608308_Fazbear Fuel.jpg', 8000, 3),
(14, 'Fizzy Faz Soda', 'Soda súper burbujeante con colores vivos y un sabor dulce y festivo. Su estética arcade la hace sentir salida directamente de una máquina recreativa.', '1763608362_Fizzy Faz Soda.jpg', 8000, 3),
(15, 'Bonnie Berry Punch', 'Un ponche morado intenso de frutos rojos, con un estilo teatral y sombrío. Ideal para quienes aman los sabores frutales con un toque dramático.', '1763608391_Bonnie Berry Punch.jpg', 8000, 3),
(16, 'Chica Lemon Glow', 'Limonada amarilla neón, dulce, fresca y explosiva. Se siente como una fiesta dentro de un vaso, llena de energía y brillo.', '1763608415_Chica Lemon Glow.jpg', 10000, 3),
(17, 'Foxy’s Pirate Rum', 'Bebida ámbar con sabor especiado al jengibre, servida con un estilo pirata clásico. Dulce, ligera y perfecta para navegar… o patrullar un restaurante embrujado.', '1763608444_Foxy’s Pirate Rum.jpg', 6000, 3),
(18, 'Ruin Reactor Mocktail', 'Coctel verde y bronce con un ligero efecto de humo. Se siente como una mezcla peligrosa, brillante y experimental salida de algún sótano secreto del lugar.', '1763608472_Ruin Reactor Mocktail.jpg', 7000, 3);

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
(1, 'Fazbear’s Fright - Bogotá', 'Cra. 102 #69-34', '1763608508_restaurante_1.jpg'),
(2, 'Mega Pizzaplex - Medellín', 'Cra. 43A #9-30', '1763608536_restaurante_2.jpg'),
(3, 'Freddy\'s Fazbear Pizza - Cali', ' Av. Colombia #2-72', '1763608566_restaurante_3.jpg'),
(4, 'Circus Baby\'s Pizza World - Ba', 'Vía 40 con calle 79', '1763608590_restaurante_4.jpg'),
(5, 'Fazbear’s Family Diner - Carta', 'Cra. 2 # 41-71', '1763608603_restaurante_5.jpg');

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
