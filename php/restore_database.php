<?php
require_once 'config/database.php';

// Configuración
$backupDir = __DIR__ . '/../sql/backups/';
echo "Buscando backups en: " . $backupDir . "\n";

// Obtener lista de backups
$backups = glob($backupDir . 'database_backup_*.sql');

if (empty($backups)) {
    die("Error: No se encontraron archivos de backup en: " . $backupDir . "\n");
}

// Ordenar por fecha (más reciente primero)
usort($backups, function($a, $b) {
    return filemtime($b) - filemtime($a);
});

// Usar el backup más reciente
$latestBackup = $backups[0];
echo "Usando el backup más reciente: " . basename($latestBackup) . "\n";
echo "Ruta completa del backup: " . $latestBackup . "\n";

// Verificar que el archivo existe
if (!file_exists($latestBackup)) {
    die("Error: El archivo de backup no existe: " . $latestBackup . "\n");
}

// Comando para restaurar
$passwordParam = !empty(DB_PASS) ? "-p" . DB_PASS : "";
$command = "D:\\xampp\\mysql\\bin\\mysql.exe -u " . DB_USER . " " . $passwordParam . " " . DB_NAME . " < " . $latestBackup;
echo "Ejecutando comando: " . $command . "\n";

// Ejecutar el comando
exec($command, $output, $returnVar);

if ($returnVar === 0) {
    echo "Base de datos restaurada exitosamente desde: " . $latestBackup . "\n";
} else {
    echo "Error al restaurar la base de datos. Código de error: " . $returnVar . "\n";
    echo "Salida del comando:\n";
    print_r($output);
}
?> 