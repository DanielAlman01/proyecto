-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-11-2024 a las 10:58:00
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
-- Base de datos: `proyecto_clasificados`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncio`
--

CREATE TABLE `anuncio` (
  `id_anuncio` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) DEFAULT 0.00,
  `ubicacion` varchar(255) NOT NULL,
  `fecha_publicacion` datetime NOT NULL DEFAULT current_timestamp(),
  `ultima_modificacion` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `usuario_modifico` int(11) DEFAULT NULL,
  `gusto` int(11) DEFAULT 0,
  `estado` enum('ACTIVO','ELIMINADO') DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anuncio`
--

INSERT INTO `anuncio` (`id_anuncio`, `id_usuario`, `id_categoria`, `titulo`, `descripcion`, `precio`, `ubicacion`, `fecha_publicacion`, `ultima_modificacion`, `usuario_modifico`, `gusto`, `estado`) VALUES
(18, 10, 6, 'Vendo Balon de Futbol soccer', 'Balo profesional, color blanco', 150.00, 'Las acacias', '2024-11-23 17:08:15', NULL, NULL, 0, 'ACTIVO'),
(19, 10, 8, 'Dibujos para niños de escuiela primaria', 'Tares para niños', 15.00, 'Don Biosco', '2024-11-23 17:22:18', '2024-11-23 20:50:12', NULL, 10, 'ACTIVO'),
(20, 10, 7, 'Alquiler de casa', 'El alquier se paga quincenalmente', 500.00, 'El dorado', '2024-11-23 20:53:05', NULL, NULL, 0, 'ACTIVO'),
(21, 10, 3, 'Vendo auto de segunda', 'Del 2015, 4x4 marca Mazda', 15000.00, 'San Carlos', '2024-11-23 20:59:14', '2024-11-23 22:14:41', 10, 0, 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_registra` int(11) NOT NULL,
  `ultima_modificacion` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `usuario_modifico` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`, `fecha_creacion`, `usuario_registra`, `ultima_modificacion`, `usuario_modifico`) VALUES
(2, 'Tecnología y Electrónica', '2024-11-04 18:27:50', 0, NULL, NULL),
(3, 'Vehículos', '2024-11-04 18:28:38', 0, NULL, NULL),
(4, 'Hogar y Muebles', '2024-11-04 18:28:55', 0, NULL, NULL),
(5, 'Moda y Belleza', '2024-11-04 18:29:12', 0, NULL, NULL),
(6, 'Deportes y Ocio', '2024-11-04 18:29:40', 0, NULL, NULL),
(7, 'Inmuebles', '2024-11-04 18:42:06', 0, NULL, NULL),
(8, 'Trabajo', '2024-11-06 18:10:33', 0, NULL, NULL),
(9, 'Servicios', '2024-11-06 18:13:52', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE `imagen` (
  `id_imagen` int(11) NOT NULL,
  `id_anuncio` int(11) NOT NULL,
  `ruta_imagen` varchar(255) NOT NULL,
  `nombre_imagen` varchar(100) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` enum('ACTIVO','ELIMINADO') NOT NULL DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagen`
--

INSERT INTO `imagen` (`id_imagen`, `id_anuncio`, `ruta_imagen`, `nombre_imagen`, `fecha_registro`, `estado`) VALUES
(11, 18, 'uploads/1732399695_balon_futbol_soccer.webp', '1732399695_balon_futbol_soccer.webp', '2024-11-23 17:08:15', 'ACTIVO'),
(12, 18, 'uploads/1732399695_balon_soccer2.webp', '1732399695_balon_soccer2.webp', '2024-11-23 17:08:15', 'ACTIVO'),
(13, 19, 'uploads/1732400538_MIXTO.jpg', '1732400538_MIXTO.jpg', '2024-11-23 17:22:18', 'ACTIVO'),
(14, 19, 'uploads/1732400538_TERRESTRE.jpg', '1732400538_TERRESTRE.jpg', '2024-11-23 17:22:18', 'ACTIVO'),
(15, 20, 'uploads/1732413185_casa.jpg', '1732413185_casa.jpg', '2024-11-23 20:53:05', 'ACTIVO'),
(16, 20, 'uploads/1732413185_casa2.jpg', '1732413185_casa2.jpg', '2024-11-23 20:53:05', 'ACTIVO'),
(17, 20, 'uploads/1732413185_casa3.jpg', '1732413185_casa3.jpg', '2024-11-23 20:53:05', 'ACTIVO'),
(18, 21, 'uploads/1732413554_mazad2.jpg', '1732413554_mazad2.jpg', '2024-11-23 20:59:14', 'ACTIVO'),
(19, 21, 'uploads/1732413554_mazda1.jpg', '1732413554_mazda1.jpg', '2024-11-23 20:59:14', 'ACTIVO'),
(20, 21, 'uploads/1732413554_mazda3.jpg', '1732413554_mazda3.jpg', '2024-11-23 20:59:14', 'ACTIVO'),
(21, 21, 'uploads/1732413554_mazda4.jpg', '1732413554_mazda4.jpg', '2024-11-23 20:59:14', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `id_mensaje` int(11) NOT NULL,
  `id_anuncio` int(11) NOT NULL,
  `id_emisor` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_mensaje` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_visitas`
--

CREATE TABLE `registro_visitas` (
  `id` int(11) NOT NULL,
  `id_usuario_registrado` int(11) DEFAULT NULL,
  `pagina_visitada` varchar(100) NOT NULL DEFAULT '0',
  `fecha_visita` datetime NOT NULL DEFAULT current_timestamp(),
  `ip_equipo` varchar(100) NOT NULL,
  `nombre_equipo` varchar(100) NOT NULL,
  `accion_realizada` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(25) NOT NULL,
  `apellido_usuario` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `tipo_usuario` enum('ADM','USUAL') NOT NULL DEFAULT 'USUAL',
  `estado_usuario` enum('ACTIVO','INACTIVO') NOT NULL DEFAULT 'ACTIVO',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `ultima_modificacion` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `usuario_modifico` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_usuario`, `apellido_usuario`, `email`, `clave`, `tipo_usuario`, `estado_usuario`, `fecha_creacion`, `ultima_modificacion`, `usuario_modifico`) VALUES
(10, 'Ghadafy', 'Neville', 'kadaneville@gmail.com', '$2y$10$nJyfK55cjRTDs8977nU3T.e2tz1z86HCdIBjGzK1kny.vzGWJOxGe', 'ADM', 'ACTIVO', '2024-11-03 23:32:11', '2024-11-24 03:43:55', 10),
(11, 'marysabel', 'cernchiaro', 'marytza13n@gmail.com', '$2y$10$im6aYvJslS1pWsdvEb6WdeUnrlO5g7o9JG4s6UQtJGiArzyhhdt5.', 'USUAL', 'ACTIVO', '2024-11-04 12:30:56', '2024-11-24 03:44:05', 10),
(12, 'Anthony', 'Martinez', 'anthony@gmail.com', '$2y$10$kslnDZMS6UiNK5sstOmZEuCxiNug56t3IqunQYn89kY9sWQBhqema', 'USUAL', 'ACTIVO', '2024-11-04 12:39:42', '2024-11-24 04:05:22', 10),
(13, 'prueba', 'prueba', 'pp@gmail.com', '$2y$10$.4FZq.peRPXVeB0JUwHoIODStY0caOrfQmnoIxpNzLvxwOjqaZ2eG', 'USUAL', 'ACTIVO', '2024-11-20 18:15:40', '2024-11-24 04:05:30', 10),
(14, 'Shaiel', 'Neville', 'sn@gmail.com', '$2y$10$oUHWu5qIph8RuvKr28o3Yue6lct0GxAXrYWS7yiQf/Z5Q8jOzxtt2', 'USUAL', 'INACTIVO', '2024-11-23 07:53:22', '2024-11-24 04:10:26', 10),
(15, 'Admin', 'Admin', 'aa@gmail.com', '$2y$10$HN2mhbc0piU3nOZLop6bsuz/dVE8GUg9XF4WV4kn/c2moo9/fdqKO', 'USUAL', 'ACTIVO', '2024-11-24 04:50:05', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anuncio`
--
ALTER TABLE `anuncio`
  ADD PRIMARY KEY (`id_anuncio`),
  ADD KEY `fk_anun_usu` (`id_usuario`),
  ADD KEY `fk_anun_cat` (`id_categoria`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `fk_img_anun` (`id_anuncio`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`id_mensaje`),
  ADD KEY `fk_msg_usu` (`id_emisor`),
  ADD KEY `fk_msg_anun` (`id_anuncio`);

--
-- Indices de la tabla `registro_visitas`
--
ALTER TABLE `registro_visitas`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anuncio`
--
ALTER TABLE `anuncio`
  MODIFY `id_anuncio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_visitas`
--
ALTER TABLE `registro_visitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anuncio`
--
ALTER TABLE `anuncio`
  ADD CONSTRAINT `fk_anun_cat` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_anun_usu` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD CONSTRAINT `fk_img_anun` FOREIGN KEY (`id_anuncio`) REFERENCES `anuncio` (`id_anuncio`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD CONSTRAINT `fk_msg_anun` FOREIGN KEY (`id_anuncio`) REFERENCES `anuncio` (`id_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_msg_usu` FOREIGN KEY (`id_emisor`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
