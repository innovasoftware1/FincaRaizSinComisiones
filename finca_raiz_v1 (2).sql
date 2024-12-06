-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3307
-- Tiempo de generación: 05-12-2024 a las 15:58:53
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
-- Base de datos: `finca_raiz_v1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE `ciudades` (
  `id` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `nombre_ciudad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciudades`
--

INSERT INTO `ciudades` (`id`, `id_departamento`, `nombre_ciudad`) VALUES
(1, 1, 'Bogotá'),
(2, 2, 'Medellín'),
(3, 2, 'Bello'),
(4, 2, 'Itagüí'),
(5, 3, 'Cali'),
(6, 3, 'Palmira'),
(7, 3, 'Buenaventura'),
(8, 4, 'Barranquilla'),
(9, 4, 'Soledad'),
(10, 4, 'Malambo'),
(11, 5, 'Soacha'),
(12, 5, 'Zipaquirá'),
(13, 5, 'Girardot'),
(14, 6, 'Bucaramanga'),
(15, 6, 'Floridablanca'),
(16, 6, 'Piedecuesta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL,
  `nombre_departamento` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id`, `nombre_departamento`) VALUES
(1, 'Bogotá D.C.'),
(2, 'Antioquia'),
(3, 'Valle del Cauca'),
(4, 'Atlántico'),
(5, 'Cundinamarca'),
(6, 'Santander');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

CREATE TABLE `fotos` (
  `id` int(11) NOT NULL,
  `id_propiedad` int(11) NOT NULL,
  `nombre_foto` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fotos`
--

INSERT INTO `fotos` (`id`, `id_propiedad`, `nombre_foto`) VALUES
(1, 1, 'db45d31698e6193e48f2f02dbf30f1387877a2a4.jpg'),
(2, 1, 'd32ca83f86e059252dd3c27962d70e381178e1c3.jpg'),
(3, 1, 'fe30f0648257fb73199e8a0a89a72493fe6f4c49.jpg'),
(4, 1, '2de0100c2c0a514a08f6f1e25c34f61619f10584.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propiedades`
--

CREATE TABLE `propiedades` (
  `id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL DEFAULT current_timestamp(),
  `titulo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `tipo` int(11) NOT NULL,
  `tipoUbicacion` varchar(200) NOT NULL,
  `estado` varchar(15) NOT NULL,
  `ubicacion` varchar(200) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `habitaciones` varchar(2) NOT NULL,
  `banios` varchar(2) NOT NULL,
  `pisos` varchar(1) NOT NULL,
  `garage` varchar(2) NOT NULL,
  `dimensiones` varchar(50) NOT NULL,
  `dimensiones_tipo` varchar(10) DEFAULT NULL,
  `area` float DEFAULT NULL,
  `altitud` float DEFAULT NULL,
  `distancia_pueblo` float DEFAULT NULL,
  `vias_acceso` text DEFAULT NULL,
  `clima` varchar(300) DEFAULT NULL,
  `precio` int(11) NOT NULL,
  `moneda` varchar(5) NOT NULL,
  `url_foto_principal` varchar(200) NOT NULL,
  `video_url` text DEFAULT NULL,
  `recorrido_360_url` varchar(300) DEFAULT NULL,
  `ubicacion_url` text NOT NULL,
  `documentos_transferencia` varchar(300) DEFAULT NULL,
  `permisos` text DEFAULT NULL,
  `uso_principal` varchar(100) DEFAULT NULL,
  `uso_compatibles` varchar(300) DEFAULT NULL,
  `uso_condicionales` varchar(300) DEFAULT NULL,
  `departamento` int(11) NOT NULL,
  `ciudad` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `agua_propia` varchar(300) DEFAULT NULL,
  `luz` varchar(300) DEFAULT NULL,
  `gas` varchar(300) DEFAULT NULL,
  `internet` varchar(300) DEFAULT NULL,
  `permuta` tinyint(1) NOT NULL,
  `caracteristicas_positivas` varchar(255) DEFAULT NULL,
  `distancia_desde_bogota` int(11) DEFAULT NULL,
  `fecha_de_venta` date DEFAULT NULL,
  `financiacion` tinyint(1) DEFAULT NULL,
  `salidas_bogota` varchar(255) DEFAULT NULL,
  `inventario` varchar(255) DEFAULT NULL,
  `construcciones_aledañas` varchar(255) DEFAULT NULL,
  `nombre_propietario` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `propiedades`
--

INSERT INTO `propiedades` (`id`, `fecha_alta`, `titulo`, `descripcion`, `tipo`, `tipoUbicacion`, `estado`, `ubicacion`, `direccion`, `habitaciones`, `banios`, `pisos`, `garage`, `dimensiones`, `dimensiones_tipo`, `area`, `altitud`, `distancia_pueblo`, `vias_acceso`, `clima`, `precio`, `moneda`, `url_foto_principal`, `video_url`, `recorrido_360_url`, `ubicacion_url`, `documentos_transferencia`, `permisos`, `uso_principal`, `uso_compatibles`, `uso_condicionales`, `departamento`, `ciudad`, `usuario_id`, `agua_propia`, `luz`, `gas`, `internet`, `permuta`, `caracteristicas_positivas`, `distancia_desde_bogota`, `fecha_de_venta`, `financiacion`, `salidas_bogota`, `inventario`, `construcciones_aledañas`, `nombre_propietario`) VALUES
(1, '2024-12-05 09:53:12', 'La nueva manzanda', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Provident, recusandae tenetur. Cupiditate illo accusantium quo, odio magnam, harum aspernatur officiis ducimus hic repellat amet et neque molestias earum itaque ipsum.\r\n', 1, 'Campestre', 'activo', 'las cruces', 'Vía Guaymaral, Km. 7.5', '4', '2', '2', '2', '2', 'm²', 2, 0, 222, '2', 'aaaaaaaaa', 20000000, 'COP', 'fotos/1/1.jpg', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/5V-WecdQe5g?si=WMJTQ-Go5TqXVz6D\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', 'https://webobook.com/public/66cf47e0deaff507cf1432b2,en?ap=false&amp', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15898.641763175523!2d-74.3460728675808!3d4.995947746013482!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e4085b18d640f2d%3A0x74ae9038db1681ac!2sHotel%20Villa%20Tatiana!5e0!3m2!1ses!2sco!4v1733410064776!5m2!1ses!2sco\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'aaaaaa', 'aaaaaaaa', 'aaaaaa', 'aaaaa', 'aaaaaaaaaaa', 2, 2, 1014274669, 'nacimiento propio', 'si', 'si', 'si', 1, 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Provident, recusandae tenetur. Cupiditate illo accusantium quo, odio magnam, harum aspernatur officiis ducimus hic repellat amet et neque molestias earum itaque ipsum.\r\n', 2222, NULL, 1, 'autopista_sur', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Provident, recusandae tenetur. Cupiditate illo accusantium quo, odio magnam, harum aspernatur officiis ducimus hic repellat amet et neque molestias earum itaque ipsum.', 'aaaaaaaaaaa', 'AAAA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre_rol`, `descripcion`) VALUES
(1, 'administrador', 'Rol con todos los permisos: administrar propiedades, usuarios, configuraciones, etc.'),
(2, 'moderador', 'Rol con permisos limitados: puede crear y editar propiedades, pero no gestionar usuarios o configuraciones.'),
(3, 'usuario', 'Rol para usuarios comunes, con acceso restringido a ver propiedades y realizar acciones limitadas.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subfotos`
--

CREATE TABLE `subfotos` (
  `id` int(11) NOT NULL,
  `id_subpropiedad` int(11) NOT NULL,
  `nombre_foto` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subpropiedades`
--

CREATE TABLE `subpropiedades` (
  `id` int(11) NOT NULL,
  `propiedad_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL DEFAULT current_timestamp(),
  `titulo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `dimensiones` varchar(50) NOT NULL,
  `area_tipo` varchar(10) DEFAULT NULL,
  `area` float DEFAULT NULL,
  `precio` int(11) NOT NULL,
  `moneda` varchar(5) NOT NULL,
  `url_foto_principal` varchar(200) NOT NULL,
  `video_url` text DEFAULT NULL,
  `recorrido_360_url` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE `tipos` (
  `id` int(11) NOT NULL,
  `nombre_tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos`
--

INSERT INTO `tipos` (`id`, `nombre_tipo`) VALUES
(1, 'Casa'),
(2, 'Casa Lote'),
(3, 'Casa Quinta'),
(4, 'Lotes'),
(5, 'Fincas'),
(6, 'Proyectos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `usuario`, `password`, `rol_id`, `fecha_creacion`) VALUES
(1014274668, 'Sergio Pinzon', 'sergio@gmail.com', 'sergpinz68', '101010', 2, '2024-11-14 10:34:55'),
(1014274669, 'Feldan D. Rodriguez', 'admininnova@example.com', 'Admin10.', '123456', 1, '2024-11-12 11:06:39');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ciudades_departamentos` (`id_departamento`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fotos_propiedades` (`id_propiedad`);

--
-- Indices de la tabla `propiedades`
--
ALTER TABLE `propiedades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_propiedades_tipos` (`tipo`),
  ADD KEY `fk_propiedades_ciudades` (`ciudad`),
  ADD KEY `fk_propiedades_usuarios` (`usuario_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subfotos`
--
ALTER TABLE `subfotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fotos_subpropiedades` (`id_subpropiedad`);

--
-- Indices de la tabla `subpropiedades`
--
ALTER TABLE `subpropiedades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_subpropiedades_propiedades` (`propiedad_id`);

--
-- Indices de la tabla `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `fk_usuarios_roles` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `fotos`
--
ALTER TABLE `fotos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `propiedades`
--
ALTER TABLE `propiedades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `subfotos`
--
ALTER TABLE `subfotos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `subpropiedades`
--
ALTER TABLE `subpropiedades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1014274670;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD CONSTRAINT `fk_ciudades_departamentos` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD CONSTRAINT `fk_fotos_propiedades` FOREIGN KEY (`id_propiedad`) REFERENCES `propiedades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `propiedades`
--
ALTER TABLE `propiedades`
  ADD CONSTRAINT `fk_propiedades_ciudades` FOREIGN KEY (`ciudad`) REFERENCES `ciudades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_propiedades_tipos` FOREIGN KEY (`tipo`) REFERENCES `tipos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_propiedades_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `subfotos`
--
ALTER TABLE `subfotos`
  ADD CONSTRAINT `fk_fotos_subpropiedades` FOREIGN KEY (`id_subpropiedad`) REFERENCES `subpropiedades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `subpropiedades`
--
ALTER TABLE `subpropiedades`
  ADD CONSTRAINT `fk_subpropiedades_propiedades` FOREIGN KEY (`propiedad_id`) REFERENCES `propiedades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
