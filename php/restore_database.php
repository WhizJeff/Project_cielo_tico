<?php
require_once 'config/database.php';

// Configuración
$backupDir = __DIR__ . '/../sql/backups/';
$backupFile = $backupDir . 'database_backup.sql';

// Verificar que el archivo de backup existe
if (!file_exists($backupFile)) {
    die("Error: No se encontró el archivo de backup en: " . $backupFile . "\n");
}

// Comando para restaurar
$command = "D:\\xampp\\mysql\\bin\\mysql.exe -u " . DB_USER . " -p" . DB_PASS . " " . DB_NAME . " < " . $backupFile;

// Ejecutar el comando
exec($command, $output, $returnVar);

if ($returnVar === 0) {
    echo "Base de datos restaurada exitosamente desde: " . $backupFile . "\n";
} else {
    echo "Error al restaurar la base de datos. Código de error: " . $returnVar . "\n";
    print_r($output);
}
?> 