
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
  `fecha_alta` DATETIME NOT NULL DEFAULT current_timestamp(),
  `titulo` VARCHAR(100) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `tipo` INT(11) NOT NULL,
  `estado` VARCHAR(15) NOT NULL,
  `ubicacion` VARCHAR(200) NOT NULL,
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
  `agua` TINYINT(1) DEFAULT NULL,
  `luz` TINYINT(1) DEFAULT NULL,
  `gas` TINYINT(1) DEFAULT NULL,
  `internet` TINYINT(1) DEFAULT NULL,
  `permuta` TINYINT(1) NOT NULL,
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
  `dimensiones_tipo` VARCHAR(10) DEFAULT NULL,
  `area` FLOAT DEFAULT NULL,
  `precio` INT(11) NOT NULL,
  `moneda` VARCHAR(5) NOT NULL,
  `url_foto_principal` VARCHAR(200) NOT NULL,
  `video_url` TEXT DEFAULT NULL,
  `recorrido_360_url` VARCHAR(300) DEFAULT NULL,
  `documentos_transferencia` VARCHAR(300) DEFAULT NULL,
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




INSERSIONES 

INSERT INTO `tipos` (`nombre_tipo`)
VALUES ('Lote');

-- Insertar en departamentos
INSERT INTO `departamentos` (`nombre_departamento`)
VALUES ('Tolima');

-- Insertar en ciudades (suponiendo que el departamento de Tolima tiene el id 1)
INSERT INTO `ciudades` (`id_departamento`, `nombre_ciudad`)
VALUES (1, 'Melgar');



INSERT INTO `propiedades` (
  `titulo`, `descripcion`, `tipo`, `estado`, `ubicacion`, `habitaciones`, `banios`, `pisos`, 
  `garage`, `dimensiones`, `dimensiones_tipo`, `area`, `altitud`, `distancia_pueblo`, `vias_acceso`, 
  `clima`, `precio`, `moneda`, `url_foto_principal`, `video_url`, `recorrido_360_url`, 
  `ubicacion_url`, `documentos_transferencia`, `permisos`, `uso_principal`, `uso_compatibles`, 
  `uso_condicionales`, `departamento`, `ciudad`, `usuario_id`, `agua`, `luz`, `gas`, `internet`, `permuta`
) 
VALUES (
  'LOTE CAMPESTRE', 
  'Excelente Lote con gran ubicación dentro del Condominio Campestre El Palmar - Melgar, para casa de descanso.', 
  1, -- Tipo de propiedad, asumiendo que "1" es el ID del tipo correspondiente (ajustar según tu base de datos)
  'Disponible', -- Estado de la propiedad (Disponible, Vendido, etc.)
  'El Salero - Melgar (Condominio Campestre El Palmar)', -- Ubicación
  '0', -- Habitaciones
  '0', -- Baños
  '1', -- Pisos
  '0', -- Garage
  '12.5 x 25 Mts', -- Dimensiones
  'M2', -- Tipo de dimensiones (m², mts, etc.)
  312.5, -- Área en m²
  323, -- Altitud en metros sobre el nivel del mar
  83, -- Distancia desde el peaje Chusacá - Bogotá en Km
  'Carretera pavimentada y destapada 3 Minutos', -- Vías de acceso
  'Entre 28C° - 32C°', -- Clima
  90000000, -- Precio en la moneda local
  'COP', -- Moneda (Colombianos Pesos)
  'url_foto_principal.jpg', -- URL de la foto principal
  'video_url_here', -- URL del video
  'recorrido_360_url_here', -- URL del recorrido 360
  'ubicacion_url_here', -- URL de ubicación en maps
  'Escritura pública por el 100 % del predio', -- Documentos de transferencia
  'Ninguno', -- Permisos
  'Construcciones hasta 3 pisos', -- Uso principal
  'Actividades industriales, recreativas y/o de vivienda', -- Usos compatibles
  'Infraestructura vial', -- Usos condicionados
  1, -- Departamento ID (suponiendo que "1" es el ID de Tolima)
  1, -- Ciudad ID (suponiendo que "1" es el ID de Melgar)
  1, -- Usuario ID (suponiendo que el ID del usuario sea "1")
  0, -- Agua
  0, -- Luz
  0, -- Gas
  0, -- Internet
  0 -- Permuta
);
