<?php
// Configuración de la base de datos local
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Usuario por defecto de MySQL en local
define('DB_PASS', ''); // Contraseña por defecto en local (vacía)
define('DB_NAME', 'cielotico_db');

// Función para conectar a la base de datos
function conectarDB() {
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    
    $conexion->set_charset("utf8");
    return $conexion;
}
?> 