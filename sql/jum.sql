CREATE DATABASE gestion_impresoras;

USE gestion_impresoras;

CREATE TABLE impresoras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modelo VARCHAR(100),
    nombre VARCHAR(100),
    contador_negro INT DEFAULT 0,
    contador_color INT DEFAULT 0,
    total_impresiones INT GENERATED ALWAYS AS (contador_negro + contador_color) STORED,
    fecha_instalacion DATE,
    lugar VARCHAR(100),
    sector VARCHAR(100),
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    estado ENUM('operativa', 'mantenimiento', 'fuera de servicio') DEFAULT 'operativa',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE historial_impresoras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_impresora INT,
    contador_negro INT,
    contador_color INT,
    total_impresiones INT,
    estado VARCHAR(50),
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_impresora) REFERENCES impresoras(id) ON DELETE CASCADE
);
SELECT * FROM modelos;

USE gestion_impresoras;

-- Crear la tabla de números de serie
CREATE TABLE series (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_serie VARCHAR(100) UNIQUE NOT NULL,
    id_impresora INT,
    FOREIGN KEY (id_impresora) REFERENCES impresoras(id) ON DELETE CASCADE
);

-- Crear la tabla de modelos
CREATE TABLE modelos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_modelo VARCHAR(100) UNIQUE NOT NULL
);

-- Crear la tabla de nombres
CREATE TABLE nombres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_impresora VARCHAR(100) UNIQUE NOT NULL
);

-- Modificar la tabla impresoras para referenciar modelos y nombres
ALTER TABLE impresoras
    ADD COLUMN modelo_id INT,
    ADD COLUMN nombre_id INT,
    ADD FOREIGN KEY (modelo_id) REFERENCES modelos(id) ON DELETE SET NULL,
    ADD FOREIGN KEY (nombre_id) REFERENCES nombres(id) ON DELETE SET NULL;
    

-- Insertar algunos modelos
INSERT INTO modelos (nombre_modelo) VALUES ('Modelo A'), ('Modelo B'), ('Modelo C');

-- Insertar algunos nombres
INSERT INTO nombres (nombre_impresora) VALUES ('Impresora 1'), ('Impresora 2'), ('Impresora 3');

ALTER TABLE impresoras
DROP COLUMN modelo,
DROP COLUMN nombre;

TRUNCATE TABLE modelos;


CREATE TABLE marcas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_marca VARCHAR(100) UNIQUE NOT NULL
);

ALTER TABLE modelos
ADD COLUMN marca_id INT,
ADD FOREIGN KEY (marca_id) REFERENCES marcas(id) ON DELETE SET NULL;

INSERT INTO marcas (nombre_marca) VALUES ('Epson'), ('HP');

-- Relaciona los modelos con sus marcas
INSERT INTO modelos (nombre_modelo, marca_id) VALUES ('L120', 1), ('L220', 1), ('Deskjet 2130', 2);

ALTER TABLE modelos
ADD COLUMN tipo_impresion ENUM('Blanco y Negro', 'Blanco y Negro y Colorido') NOT NULL DEFAULT 'Blanco y Negro';

CREATE TABLE imagenes_reportes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    impresora_id INT NOT NULL,
    ruta_imagen VARCHAR(255) NOT NULL,
    fecha_carga TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (impresora_id) REFERENCES impresoras(id) ON DELETE CASCADE
);
DESCRIBE impresoras;

ALTER TABLE impresoras
ADD COLUMN marca_id INT NOT NULL;
ALTER TABLE impresoras
DROP COLUMN modelo_id;


CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'usuario') DEFAULT 'usuario',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO usuarios (nombre_usuario, contrasena, rol) VALUES
('admin', MD5('admin123'), 'admin'),
('usuario', MD5('usuario123'), 'usuario');

SELECT 
    impresoras.id,
    modelos.nombre_modelo AS modelo,
    nombres.nombre_impresora AS nombre,
    marcas.nombre_marca AS marca,
    series.numero_serie AS numero_serie,
    impresoras.contador_negro,
    impresoras.contador_color,
    impresoras.total_impresiones,
    impresoras.fecha_instalacion,
    impresoras.lugar,
    impresoras.sector,
    impresoras.fecha_actualizacion,
    impresoras.estado,
    impresoras.fecha_registro
FROM impresoras
LEFT JOIN modelos ON impresoras.modelo_id = modelos.id
LEFT JOIN nombres ON impresoras.nombre_id = nombres.id
LEFT JOIN marcas ON impresoras.marca_id = marcas.id
LEFT JOIN series ON series.id_impresora = impresoras.id;



