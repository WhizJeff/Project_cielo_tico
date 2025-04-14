-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS cielotico_db;
USE cielotico_db;

-- Crear la tabla usuarios si no existe
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    fecha_registro DATETIME NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    UNIQUE KEY unique_email (email)
);

-- Crear la tabla de credenciales si no existe
CREATE TABLE IF NOT EXISTS credenciales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'usuario') NOT NULL DEFAULT 'usuario',
    ultimo_acceso DATETIME,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE
);

-- Insertar credenciales de administrador (si no existen)
INSERT INTO credenciales (usuario, password, rol) 
VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin')
ON DUPLICATE KEY UPDATE id=id;

-- Insertar datos de prueba (opcional)
INSERT INTO usuarios (nombre, email, telefono, password, fecha_registro) 
VALUES 
('Usuario Prueba', 'test@example.com', '+506 2222-2222', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW())
ON DUPLICATE KEY UPDATE id=id; 