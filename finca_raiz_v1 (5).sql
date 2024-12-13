
DROP DATABASE IF EXISTS finca_raiz_v1;
CREATE DATABASE finca_raiz_v1;
USE finca_raiz_v1;

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
  `habitaciones` int(2) NOT NULL,
  `banios` int(2) NOT NULL,
  `pisos` int(2) NOT NULL,
  `garage` int(2) NOT NULL,
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
  `nombre_propietario` varchar(255) DEFAULT NULL,
  `valor_fijo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `recorrido_360_url` varchar(300) DEFAULT NULL,
  `estado` varchar(15) NOT NULL
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
(1, 'Casa prueba'),
(2, 'Casa Lote'),
(3, 'Casa Quinta'),
(4, 'Lotes'),
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
(824571254, 'fledman jefe', 'fledman@gmail.es', 'Administrador', '$2y$10$cphHavpQ4dBV4lGfhd6TWOPwbarqr3yh1r2CrluCBKIiuEzOudvDm', 1, '2024-12-05 15:45:35');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `fotos`
--
ALTER TABLE `fotos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `propiedades`
--
ALTER TABLE `propiedades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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

