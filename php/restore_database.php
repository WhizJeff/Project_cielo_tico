<?php
require_once __DIR__ . '/config/database.php';

function findMysqlPath() {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        // En Windows, buscar en las ubicaciones comunes de XAMPP
        $possiblePaths = [
            'C:\\xampp\\mysql\\bin\\mysql.exe',
            'D:\\xampp\\mysql\\bin\\mysql.exe',
            'E:\\xampp\\mysql\\bin\\mysql.exe',
            'F:\\xampp\\mysql\\bin\\mysql.exe'
        ];
        
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }
    }
    return 'mysql'; // Si no se encuentra, usar el comando por defecto
}

function restoreDatabase() {
    global $conn;
    
    try {
        // Buscar el archivo de backup más reciente
        $backupDir = __DIR__ . '/../sql/backups';
        $backupFiles = glob($backupDir . '/*.sql');
        
        if (empty($backupFiles)) {
            die("No se encontraron archivos de backup en: " . $backupDir . "\n");
        }
        
        // Ordenar por fecha de modificación (más reciente primero)
        usort($backupFiles, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });
        
        $latestBackup = $backupFiles[0];
        echo "Restaurando desde: " . basename($latestBackup) . "\n";
        
        // Encontrar la ruta de mysql
        $mysqlPath = findMysqlPath();
        
        // Comando para restaurar la base de datos
        $command = sprintf(
            '"%s" -u%s -p%s %s < "%s"',
            $mysqlPath,
            DB_USER,
            DB_PASS,
            DB_NAME,
            $latestBackup
        );
        
        // Ejecutar el comando
        exec($command, $output, $returnVar);
        
        if ($returnVar === 0) {
            echo "Base de datos restaurada correctamente.\n";
        } else {
            echo "Error al restaurar la base de datos. Código de error: " . $returnVar . "\n";
            if (!empty($output)) {
                echo "Detalles del error:\n";
                print_r($output);
            }
        }
        
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

// Ejecutar la restauración
restoreDatabase();
?> 