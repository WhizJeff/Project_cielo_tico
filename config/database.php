<?php
// Configuración de la base de datos local
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Usuario por defecto de MySQL en local
define('DB_PASS', ''); // Contraseña por defecto en local (vacía)
define('DB_NAME', 'cielotico_db');

try {
    $conn = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USER,
        DB_PASS
    );
    
    // Configurar el modo de error de PDO para lanzar excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Configurar el modo de obtención por defecto
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    error_log("Error de conexión: " . $e->getMessage());
    die("Error de conexión a la base de datos");
}
?> 