-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS cielotico_db;
USE cielotico_db;

-- Crear la tabla de contactos
CREATE TABLE IF NOT EXISTS contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(100) NOT NULL,
    correo_electronico VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    asunto ENUM('reserva', 'informacion', 'queja', 'otro') NOT NULL,
    mensaje VARCHAR(150) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('pendiente', 'respondido', 'archivado') DEFAULT 'pendiente',
    INDEX idx_correo (correo_electronico),
    INDEX idx_asunto (asunto)
);

-- Crear índice para búsquedas por correo electrónico
CREATE INDEX idx_correo ON contactos(correo_electronico);

-- Crear índice para búsquedas por asunto
CREATE INDEX idx_asunto ON contactos(asunto); 