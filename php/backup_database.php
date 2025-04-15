<?php
require_once 'config/database.php';

// Configuración
$backupDir = __DIR__ . '/../sql/backups/';
$maxBackups = 3;

// Crear directorio de backups si no existe
if (!file_exists($backupDir)) {
    mkdir($backupDir, 0777, true);
}

// Generar nombre de archivo con timestamp
$timestamp = date('Y-m-d_H-i-s');
$backupFile = $backupDir . 'database_backup_' . $timestamp . '.sql';

// Comando para hacer el dump
$command = "D:\\xampp\\mysql\\bin\\mysqldump.exe -u " . DB_USER . " -p" . DB_PASS . " " . DB_NAME . " > " . $backupFile;

// Ejecutar el comando
exec($command, $output, $returnVar);

if ($returnVar === 0) {
    echo "Backup creado exitosamente en: " . $backupFile . "\n";
    
    // Obtener lista de backups
    $backups = glob($backupDir . 'database_backup_*.sql');
    
    // Ordenar por fecha (más reciente primero)
    usort($backups, function($a, $b) {
        return filemtime($b) - filemtime($a);
    });
    
    // Eliminar backups antiguos si excedemos el límite
    if (count($backups) > $maxBackups) {
        for ($i = $maxBackups; $i < count($backups); $i++) {
            unlink($backups[$i]);
            echo "Eliminado backup antiguo: " . $backups[$i] . "\n";
        }
    }
} else {
    echo "Error al crear el backup. Código de error: " . $returnVar . "\n";
    print_r($output);
}
?> 