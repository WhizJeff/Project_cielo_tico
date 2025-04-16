<?php
require_once 'config/database.php';

// Configuración
$backupDir = __DIR__ . '/../sql/backups/';
$maxBackups = 3;

// Función para encontrar mysqldump.exe
function findMysqldump() {
    // Lista de unidades comunes donde podría estar instalado XAMPP
    $drives = ['C:', 'D:', 'E:', 'F:'];
    $possiblePaths = [
        '\\xampp\\mysql\\bin\\mysqldump.exe',
        '\\wamp\\bin\\mysql\\mysql8.0.31\\bin\\mysqldump.exe',
        '\\wamp64\\bin\\mysql\\mysql8.0.31\\bin\\mysqldump.exe'
    ];

    foreach ($drives as $drive) {
        foreach ($possiblePaths as $path) {
            $fullPath = $drive . $path;
            if (file_exists($fullPath)) {
                return $fullPath;
            }
        }
    }

    return false;
}

// Crear directorio de backups si no existe
if (!file_exists($backupDir)) {
    mkdir($backupDir, 0777, true);
}

// Generar nombre de archivo con timestamp
$timestamp = date('Y-m-d_H-i-s');
$backupFile = $backupDir . 'database_backup_' . $timestamp . '.sql';

// Encontrar mysqldump
$mysqldump = findMysqldump();

if (!$mysqldump) {
    die("Error: No se puede encontrar mysqldump.exe en ninguna ubicación conocida.\n" .
        "Por favor, especifica manualmente la ruta de mysqldump.exe en el archivo de configuración.");
}

// Comando para hacer el dump (usando comillas dobles para la ruta del archivo de salida)
$command = "\"{$mysqldump}\" -h " . DB_HOST . " -u " . DB_USER . " " . 
          (DB_PASS ? "-p" . DB_PASS : "") . " " . 
          DB_NAME . " > \"{$backupFile}\" 2>&1";

// Mostrar información de depuración
echo "Intentando crear backup...\n";
echo "Usando mysqldump desde: " . $mysqldump . "\n";

// Ejecutar el comando
exec($command, $output, $returnVar);

if ($returnVar === 0) {
    echo "¡Backup creado exitosamente!\n";
    echo "Ubicación: " . $backupFile . "\n";
    
    // Obtener lista de backups
    $backups = glob($backupDir . 'database_backup_*.sql');
    
    // Ordenar por fecha (más reciente primero)
    usort($backups, function($a, $b) {
        return filemtime($b) - filemtime($a);
    });
    
    // Eliminar backups antiguos si excedemos el límite
    if (count($backups) > $maxBackups) {
        echo "\nEliminando backups antiguos...\n";
        for ($i = $maxBackups; $i < count($backups); $i++) {
            unlink($backups[$i]);
            echo "- Eliminado: " . basename($backups[$i]) . "\n";
        }
    }
    
    echo "\nProceso completado correctamente.";
} else {
    echo "Error al crear el backup.\n";
    echo "Código de error: " . $returnVar . "\n";
    echo "Detalles del error:\n";
    if (!empty($output)) {
        foreach ($output as $line) {
            echo "- " . $line . "\n";
        }
    }
    echo "\nComando ejecutado: " . $command . "\n";
    
    echo "\nSugerencias de solución:\n";
    echo "1. Verifica que MySQL esté corriendo\n";
    echo "2. Comprueba las credenciales de la base de datos\n";
    echo "3. Asegúrate de tener permisos de escritura en la carpeta de backups\n";
    echo "4. Si el problema persiste, intenta ejecutar el comando manualmente en la terminal\n";
}
?> 