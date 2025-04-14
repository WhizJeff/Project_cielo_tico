<?php
require_once __DIR__ . '/config/database.php';

function importUsers() {
    global $conn;
    
    try {
        // Buscar el archivo de backup más reciente
        $backupDir = __DIR__ . '/../sql/';
        $files = glob($backupDir . 'users_backup_*.sql');
        
        if (empty($files)) {
            echo "No se encontraron archivos de backup de usuarios.\n";
            return;
        }
        
        // Ordenar por fecha de modificación (más reciente primero)
        usort($files, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });
        
        $latestBackup = $files[0];
        echo "Importando usuarios desde: " . $latestBackup . "\n";
        
        // Importar el archivo SQL
        $command = sprintf(
            'mysql -u%s -p%s %s < %s',
            DB_USER,
            DB_PASS,
            DB_NAME,
            $latestBackup
        );
        exec($command);
        
        echo "Usuarios importados correctamente.\n";
        
    } catch (PDOException $e) {
        echo "Error al importar usuarios: " . $e->getMessage() . "\n";
    }
}

// Ejecutar la importación
importUsers();
?> 