-- Crear tabla para los tipos de bus
CREATE TABLE IF NOT EXISTS tipos_bus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    descripcion TEXT,
    capacidad_pasajeros INT NOT NULL,
    caracteristicas TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla para los buses
CREATE TABLE IF NOT EXISTS buses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(10) NOT NULL UNIQUE,
    tipo_bus_id INT NOT NULL,
    placa VARCHAR(20) NOT NULL UNIQUE,
    estado ENUM('activo', 'mantenimiento', 'inactivo') DEFAULT 'activo',
    ano_fabricacion YEAR,
    ultima_revision DATE,
    proxima_revision DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tipo_bus_id) REFERENCES tipos_bus(id)
);

-- Insertar tipos de bus
INSERT INTO tipos_bus (nombre, descripcion, capacidad_pasajeros, caracteristicas) VALUES
('Lujo', 'Bus de lujo con máximo confort y amenidades', 30, 'Asientos reclinables de cuero, WiFi, TV, Baño, Aire acondicionado, Sistema de entretenimiento'),
('Ejecutivo', 'Bus ejecutivo con comodidades estándar plus', 35, 'Asientos reclinables, Aire acondicionado, Baño, Sistema de audio'),
('Turístico', 'Bus turístico estándar', 40, 'Asientos estándar, Aire acondicionado, Sistema de audio básico');

-- Insertar buses
-- Buses de Lujo
INSERT INTO buses (codigo, tipo_bus_id, placa, ano_fabricacion) VALUES
('LUXBUS-001', 1, 'LUX-001', 2023),
('LUXBUS-002', 1, 'LUX-002', 2023),
('LUXBUS-003', 1, 'LUX-003', 2023);

-- Buses Ejecutivos
INSERT INTO buses (codigo, tipo_bus_id, placa, ano_fabricacion) VALUES
('EXEBUS-001', 2, 'EXE-001', 2022),
('EXEBUS-002', 2, 'EXE-002', 2022),
('EXEBUS-003', 2, 'EXE-003', 2022);

-- Buses Turísticos
INSERT INTO buses (codigo, tipo_bus_id, placa, ano_fabricacion) VALUES
('TURBUS-001', 3, 'TUR-001', 2021),
('TURBUS-002', 3, 'TUR-002', 2021),
('TURBUS-003', 3, 'TUR-003', 2021); 