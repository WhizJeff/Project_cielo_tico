-- Actualizar la estructura de la tabla tours
ALTER TABLE `tours`
ADD COLUMN `max_personas` int(11) DEFAULT NULL AFTER `duracion`,
ADD COLUMN `imagen_url` varchar(255) DEFAULT NULL AFTER `max_personas`,
ADD COLUMN `activo` tinyint(1) DEFAULT 1 AFTER `estado`,
ADD COLUMN `precio_turistico` decimal(10,2) NOT NULL AFTER `precio`,
ADD COLUMN `precio_ejecutivo` decimal(10,2) NOT NULL AFTER `precio_turistico`,
ADD COLUMN `precio_lujo` decimal(10,2) NOT NULL AFTER `precio_ejecutivo`;

-- Actualizar los tours existentes con los nuevos precios
UPDATE `tours` SET
`precio_turistico` = CASE 
    WHEN duracion LIKE '%1 día%' THEN 40 * 550 -- $40 USD aproximadamente
    WHEN duracion LIKE '%2 días%' THEN 80 * 550
    WHEN duracion LIKE '%3 días%' THEN 120 * 550
    ELSE precio END,
`precio_ejecutivo` = CASE 
    WHEN duracion LIKE '%1 día%' THEN 60 * 550 -- $60 USD aproximadamente
    WHEN duracion LIKE '%2 días%' THEN 120 * 550
    WHEN duracion LIKE '%3 días%' THEN 180 * 550
    ELSE precio * 1.5 END,
`precio_lujo` = CASE 
    WHEN duracion LIKE '%1 día%' THEN 80 * 550 -- $80 USD aproximadamente
    WHEN duracion LIKE '%2 días%' THEN 160 * 550
    WHEN duracion LIKE '%3 días%' THEN 240 * 550
    ELSE precio * 2 END;

-- Insertar los tours si no existen
INSERT IGNORE INTO `tours` 
(`nombre`, `descripcion`, `duracion`, `max_personas`, `imagen_url`, `precio_turistico`, `precio_ejecutivo`, `precio_lujo`, `activo`) 
VALUES
('Volcán Arenal', 'El majestuoso coloso de Costa Rica, rodeado de aguas termales y bosque tropical.', '1 día', 40, '../img/slider1.jpg', 22000, 33000, 44000, 1),
('Guanacaste', 'Playas doradas, puestas de sol espectaculares y cultura guanacasteca.', '2 días', 35, '../img/slider2.jpg', 44000, 66000, 88000, 1),
('Cerro Chirripó', 'El punto más alto de Costa Rica, donde las nubes tocan la tierra.', '2 días', 30, '../img/slider3.jpg', 44000, 66000, 88000, 1),
('Manuel Antonio', 'Donde el bosque se encuentra con el mar, hogar de una increíble biodiversidad.', '1 día', 40, '../img/slider5.jpg', 22000, 33000, 44000, 1),
('Monteverde', 'Bosque nuboso místico con una biodiversidad única en el mundo.', '2 días', 35, '../img/slider6.jpg', 44000, 66000, 88000, 1),
('Puerto Viejo', 'Paraíso caribeño con rica cultura afrocaribeña y playas paradisíacas.', '3 días', 30, '../img/slider4.jpg', 66000, 99000, 132000, 1),
('Río Celeste', 'Descubre el mágico río de aguas turquesas en el Parque Nacional Volcán Tenorio.', '1 día', 40, '../img/tours/rio-celeste.jpg', 22000, 33000, 44000, 1),
('Cahuita', 'Explora los arrecifes de coral y la exuberante selva tropical del Caribe.', '2 días', 35, '../img/tours/cahuita.jpg', 44000, 66000, 88000, 1),
('San José', 'Recorre la capital y descubre su rica historia, cultura y arquitectura.', '1 día', 40, '../img/tours/san-jose.jpg', 22000, 33000, 44000, 1); 