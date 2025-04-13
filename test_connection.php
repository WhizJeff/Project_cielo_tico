<?php
require_once 'includes/database.php';

try {
    $db = Database::getInstance();
    echo "¡Conexión exitosa a la base de datos!";
    
    // Probar una consulta simple
    $result = $db->select("SELECT * FROM usuarios LIMIT 1");
    echo "\nNúmero de usuarios encontrados: " . count($result);
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?> 