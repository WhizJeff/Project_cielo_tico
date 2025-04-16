-- Actualizar la tabla reservaciones para incluir horario y bus asignado
ALTER TABLE reservaciones
ADD COLUMN horario TIME AFTER fecha_reserva,
ADD COLUMN bus_id INT AFTER estado,
ADD FOREIGN KEY (bus_id) REFERENCES buses(id); 