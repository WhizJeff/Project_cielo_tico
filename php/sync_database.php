<?php
require_once __DIR__ . '/config/database.php';

function syncDatabase() {
    global $conn;
    
    try { 
        // Leer el archivo de migraciones
        $sql = file_get_contents(__DIR__ . '/../sql/migrations.sql');
        
        // Ejecutar las migraciones
        $conn->exec($sql);
        
        echo "Base de datos sincronizada correctamente.\n";
        
        // Exportar la base de datos actual (backup completo)
        $backupFile = __DIR__ . '/../sql/backup.sql';
        $command = sprintf(
            'mysqldump -u%s -p%s %s > %s',
            DB_USER,
            DB_PASS,
            DB_NAME,
            $backupFile
        );
        exec($command);
        
        echo "Backup creado en: " . $backupFile . "\n";
        
        // Exportar solo los datos de usuarios y credenciales
        $usersBackupFile = __DIR__ . '/../sql/users_backup.sql';
        $command = sprintf(
            'mysqldump -u%s -p%s %s usuarios credenciales > %s',
            DB_USER,
            DB_PASS,
            DB_NAME,
            $usersBackupFile
        );
        exec($command);
        
        echo "Backup de usuarios creado en: " . $usersBackupFile . "\n";
        
    } catch (PDOException $e) {
        echo "Error al sincronizar la base de datos: " . $e->getMessage() . "\n";
    }
}

// Ejecutar la sincronización
syncDatabase();
?> 