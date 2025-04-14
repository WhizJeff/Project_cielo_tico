<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'cielotico');
define('DB_USER', 'root');
define('DB_PASS', '');

// Zona horaria
date_default_timezone_set('America/Costa_Rica');

// Configuración de caracteres
ini_set('default_charset', 'UTF-8');

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