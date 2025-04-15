<?php
require_once 'config/database.php';

// Configuración
$backupDir = __DIR__ . '/../sql/backups/';
$backupFile = $backupDir . 'database_backup.sql';

// Crear directorio de backups si no existe
if (!file_exists($backupDir)) {
    mkdir($backupDir, 0777, true);
}

// Comando para hacer el dump
$command = "D:\\xampp\\mysql\\bin\\mysqldump.exe -u " . DB_USER . " -p" . DB_PASS . " " . DB_NAME . " > " . $backupFile;

// Ejecutar el comando
exec($command, $output, $returnVar);

if ($returnVar === 0) {
    echo "Backup creado exitosamente en: " . $backupFile . "\n";
} else {
    echo "Error al crear el backup. Código de error: " . $returnVar . "\n";
    print_r($output);
}
?> 