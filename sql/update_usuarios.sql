-- Agregar campo de nombre de usuario a la tabla usuarios
ALTER TABLE usuarios
ADD COLUMN username VARCHAR(50) UNIQUE
AFTER nombre;

-- Actualizar registros existentes con un nombre de usuario basado en el email
UPDATE usuarios
SET username = SUBSTRING_INDEX(email, '@', 1)
WHERE username IS NULL; 