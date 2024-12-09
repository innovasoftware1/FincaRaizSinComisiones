
DROP DATABASE IF EXISTS finca_raiz_v1;
CREATE DATABASE finca_raiz_v1;
USE finca_raiz_v1;

-- Tabla roles
CREATE TABLE `roles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre_rol` VARCHAR(50) NOT NULL,
  `descripcion` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla usuarios
CREATE TABLE `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `usuario` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `rol_id` INT(11) NOT NULL,
  `fecha_creacion` DATETIME NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_usuarios_roles` (`rol_id`),
  CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla tipos
CREATE TABLE `tipos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre_tipo` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla departamentos
CREATE TABLE `departamentos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre_departamento` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla ciudades
CREATE TABLE `ciudades` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_departamento` INT(11) NOT NULL,
  `nombre_ciudad` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ciudades_departamentos` (`id_departamento`),
  CONSTRAINT `fk_ciudades_departamentos` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla propiedades
CREATE TABLE `propiedades` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha_alta` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `titulo` VARCHAR(100) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `tipo` INT(11) NOT NULL,
  `tipoUbicacion` VARCHAR(200) NOT NULL,
  `estado` VARCHAR(15) NOT NULL,
  `ubicacion` VARCHAR(200) NOT NULL,
  `direccion` VARCHAR(200) NOT NULL,
  `habitaciones` VARCHAR(2) NOT NULL,
  `banios` VARCHAR(2) NOT NULL,
  `pisos` VARCHAR(1) NOT NULL,
  `garage` VARCHAR(2) NOT NULL,
  `dimensiones` VARCHAR(50) NOT NULL,
  `dimensiones_tipo` VARCHAR(10) DEFAULT NULL,
  `area` FLOAT DEFAULT NULL,
  `altitud` FLOAT DEFAULT NULL,
  `distancia_pueblo` FLOAT DEFAULT NULL,
  `vias_acceso` TEXT DEFAULT NULL,
  `clima` VARCHAR(300) DEFAULT NULL,
  `precio` INT(11) NOT NULL,
  `moneda` VARCHAR(5) NOT NULL,
  `url_foto_principal` VARCHAR(200) NOT NULL,
  `video_url` TEXT DEFAULT NULL,
  `recorrido_360_url` VARCHAR(300) DEFAULT NULL,
  `ubicacion_url` TEXT NOT NULL,
  `documentos_transferencia` VARCHAR(300) DEFAULT NULL,
  `permisos` TEXT DEFAULT NULL,
  `uso_principal` VARCHAR(100) DEFAULT NULL,
  `uso_compatibles` VARCHAR(300) DEFAULT NULL,
  `uso_condicionales` VARCHAR(300) DEFAULT NULL,
  `departamento` INT(11) NOT NULL,
  `ciudad` INT(11) NOT NULL,
  `usuario_id` INT(11) DEFAULT NULL,
  `agua_propia` VARCHAR(300) DEFAULT NULL,
  `luz` VARCHAR(300) DEFAULT NULL,
  `gas` VARCHAR(300) DEFAULT NULL,
  `internet` VARCHAR(300) DEFAULT NULL,
  `permuta` TINYINT(1) NOT NULL,
  `caracteristicas_positivas` VARCHAR(255) DEFAULT NULL,
  `distancia_desde_bogota` INT DEFAULT NULL,
  `fecha_de_venta` DATE DEFAULT NULL,
  `financiacion` BOOLEAN DEFAULT NULL,
  `salidas_bogota` VARCHAR(255) DEFAULT NULL,
  `inventario` VARCHAR(255) DEFAULT NULL,
  `construcciones_aledañas` VARCHAR(255) DEFAULT NULL,
  `nombre_propietario` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_propiedades_tipos` (`tipo`),
  KEY `fk_propiedades_ciudades` (`ciudad`),
  KEY `fk_propiedades_usuarios` (`usuario_id`),
  CONSTRAINT `fk_propiedades_tipos` FOREIGN KEY (`tipo`) REFERENCES `tipos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_propiedades_ciudades` FOREIGN KEY (`ciudad`) REFERENCES `ciudades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_propiedades_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Tabla configuracion
CREATE TABLE `configuracion` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre_configuracion` VARCHAR(100) NOT NULL,
  `valor` TEXT DEFAULT NULL,
  `propiedad_id` INT(11) DEFAULT NULL, 
  PRIMARY KEY (`id`),
  KEY `fk_configuracion_propiedades` (`propiedad_id`),
  CONSTRAINT `fk_configuracion_propiedades` FOREIGN KEY (`propiedad_id`) REFERENCES `propiedades` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla subpropiedades
CREATE TABLE `subpropiedades` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `propiedad_id` INT(11) NOT NULL, 
  `fecha_alta` DATETIME NOT NULL DEFAULT current_timestamp(),
  `titulo` VARCHAR(100) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `dimensiones` VARCHAR(50) NOT NULL,
  `area_tipo` VARCHAR(10) DEFAULT NULL,
  `area` FLOAT DEFAULT NULL,
  `precio` INT(11) NOT NULL,
  `moneda` VARCHAR(5) NOT NULL,
  `url_foto_principal` VARCHAR(200) NOT NULL,
  `video_url` TEXT DEFAULT NULL,
  `recorrido_360_url` VARCHAR(300) DEFAULT NULL, 
  `estado` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_subpropiedades_propiedades` (`propiedad_id`),
  CONSTRAINT `fk_subpropiedades_propiedades` FOREIGN KEY (`propiedad_id`) REFERENCES `propiedades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla fotos
CREATE TABLE `fotos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_propiedad` INT(11) NOT NULL, 
  `nombre_foto` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_fotos_propiedades` (`id_propiedad`),  -- No es necesario un `id_subpropiedad` aquí
  CONSTRAINT `fk_fotos_propiedades` FOREIGN KEY (`id_propiedad`) REFERENCES `propiedades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Tabla subfotos
CREATE TABLE `subfotos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_subpropiedad` INT(11) NOT NULL, 
  `nombre_foto` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_fotos_subpropiedades` (`id_subpropiedad`),
  CONSTRAINT `fk_fotos_subpropiedades` FOREIGN KEY (`id_subpropiedad`) REFERENCES `subpropiedades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




INSERT INTO `roles` (`id`, `nombre_rol`, `descripcion`) VALUES
(1, 'administrador', 'Rol con todos los permisos: administrar propiedades, usuarios, configuraciones, etc.'),
(2, 'moderador', 'Rol con permisos limitados: puede crear y editar propiedades, pero no gestionar usuarios o configuraciones.'),
(3, 'usuario', 'Rol para usuarios comunes, con acceso restringido a ver propiedades y realizar acciones limitadas.');


INSERT INTO `tipos` (`id`, `nombre_tipo`) VALUES
(1, 'Casa'),
(2, 'Casa Lote'),
(3, 'Casa Quinta'),
(4, 'Lotes'),
(5, 'Fincas'),
(6, 'Proyectos');



INSERT INTO `departamentos` (`id`, `nombre_departamento`) VALUES
(1, 'Bogotá D.C.'),
(2, 'Antioquia'),
(3, 'Valle del Cauca'),
(4, 'Atlántico'),
(5, 'Cundinamarca'),
(6, 'Santander');

-- Insertar en ciudades (suponiendo que el departamento de Tolima tiene el id 1)
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

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `usuario`, `password`, `rol_id`, `fecha_creacion`) VALUES
(1014274668, 'Sergio Pinzon', 'sergio@gmail.com', 'sergpinz68', '101010', 2, '2024-11-14 10:34:55'),
(1014274669, 'Feldan D. Rodriguez', 'admininnova@example.com', 'Admin10.', '123456', 1, '2024-11-12 11:06:39');



INSERT INTO `usuarios` (`id`, `nombre`, `email`, `usuario`, `password`, `rol_id`, `fecha_creacion`) VALUES
(1027524040, 'sergio alejandro saavedra rojas', 'saavedrarojass41@gmail.com', 'checho', '$2y$10$WM6zFp8jy1tYTbwfeb92S.q17envIvJJASgYPdMBHzGkkpYDdKYJa', 1, '2024-12-05 12:24:44');

