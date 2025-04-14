<?php
require_once 'config/config.php';
require_once 'includes/database.php';

echo "=== Prueba de Variables de Entorno ===\n";
echo "Nombre del sitio: " . SITE_NAME . "\n";
echo "URL del sitio: " . SITE_URL . "\n";
echo "Host DB: " . DB_HOST . "\n";
echo "Nombre DB: " . DB_NAME . "\n";
echo "Zona horaria: " . date_default_timezone_get() . "\n\n";

echo "=== Prueba de Conexión a Base de Datos ===\n";
try {
    $db = Database::getInstance();
    $connection = $db->getConnection();
    
    // Probar crear una tabla de prueba
    $sql = "CREATE TABLE IF NOT EXISTS test_table (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $db->query($sql);
    echo "✓ Conexión exitosa a la base de datos\n";
    echo "✓ Tabla de prueba creada correctamente\n";
    
    // Probar insertar un registro
    $sql = "INSERT INTO test_table (nombre) VALUES ('Prueba')";
    $db->query($sql);
    echo "✓ Registro insertado correctamente\n";
    
    // Probar consultar datos
    $sql = "SELECT * FROM test_table";
    $resultados = $db->select($sql);
    echo "✓ Consulta exitosa: " . count($resultados) . " registros encontrados\n";
    
    // Limpiar la tabla de prueba
    $sql = "DROP TABLE test_table";
    $db->query($sql);
    echo "✓ Tabla de prueba eliminada correctamente\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 