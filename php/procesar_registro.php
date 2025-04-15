<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log del inicio del script
error_log("Iniciando procesar_registro.php");

// Verificar que el archivo de configuración existe
if (!file_exists(__DIR__ . '/../config/database.php')) {
    error_log("Error: No se encuentra el archivo de configuración de la base de datos");
    $_SESSION['error'] = 'Error de configuración del servidor';
    header('Location: ../html/registro.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';

if (!isset($conn)) {
    error_log("Error crítico: No hay conexión a la base de datos disponible");
    $_SESSION['error'] = 'Error de conexión a la base de datos';
    header('Location: ../html/registro.php');
    exit;
}

// Log del método de la petición
error_log("Método de la petición: " . $_SERVER['REQUEST_METHOD']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    error_log("Error: Método no permitido - " . $_SERVER['REQUEST_METHOD']);
    $_SESSION['error'] = 'Método no permitido';
    header('Location: ../html/registro.php');
    exit;
}

try {
    // Obtener datos del formulario POST
    $nombre = trim($_POST['nombre'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $password = $_POST['password'] ?? '';
    
    error_log("Datos recibidos - Nombre: $nombre, Username: $username, Email: $email, Teléfono: $telefono");

    // Validar datos
    if (empty($nombre) || empty($username) || empty($email) || empty($telefono) || empty($password)) {
        $campos_vacios = [];
        if (empty($nombre)) $campos_vacios[] = 'nombre';
        if (empty($username)) $campos_vacios[] = 'username';
        if (empty($email)) $campos_vacios[] = 'email';
        if (empty($telefono)) $campos_vacios[] = 'telefono';
        if (empty($password)) $campos_vacios[] = 'password';
        
        error_log("Campos vacíos detectados: " . implode(', ', $campos_vacios));
        throw new Exception('Los siguientes campos son requeridos: ' . implode(', ', $campos_vacios));
    }

    // Validar email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        error_log("Email inválido: $email");
        throw new Exception('Email inválido');
    }

    // Validar nombre de usuario
    if (!preg_match('/^[a-zA-Z0-9_-]{3,20}$/', $username)) {
        error_log("Nombre de usuario inválido: $username");
        throw new Exception('El nombre de usuario solo puede contener letras, números, guiones y debe tener entre 3 y 20 caracteres');
    }

    error_log("Intentando verificar duplicados en la base de datos...");
    
    // Validar que el email y username no existan
    $stmt = $conn->prepare("SELECT id, email, username FROM usuarios WHERE email = ? OR username = ?");
    $stmt->execute([$email, $username]);
    $existente = $stmt->fetch();
    
    if ($existente) {
        if ($existente['email'] === $email) {
            error_log("Email duplicado encontrado: $email");
            throw new Exception('El email ya está registrado');
        }
        if ($existente['username'] === $username) {
            error_log("Nombre de usuario duplicado encontrado: $username");
            throw new Exception('El nombre de usuario ya está registrado');
        }
    }

    error_log("No se encontraron duplicados, procediendo con el registro");

    // Hash de la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar usuario
    $stmt = $conn->prepare("
        INSERT INTO usuarios (nombre, username, email, telefono, password, fecha_registro, rol) 
        VALUES (?, ?, ?, ?, ?, NOW(), 'usuario')
    ");

    error_log("Ejecutando inserción en la base de datos...");
    
    $result = $stmt->execute([
        $nombre,
        $username,
        $email,
        $telefono,
        $password_hash
    ]);

    if (!$result) {
        $error = $stmt->errorInfo();
        error_log("Error en la inserción: " . print_r($error, true));
        throw new Exception('Error al insertar en la base de datos: ' . $error[2]);
    }

    $nuevo_id = $conn->lastInsertId();
    error_log("Usuario registrado exitosamente con ID: $nuevo_id");
    
    $_SESSION['success'] = '¡Registro exitoso! Ya puedes iniciar sesión.';
    header('Location: ../html/login.php');
    exit;

} catch (Exception $e) {
    error_log("Error en registro: " . $e->getMessage());
    $_SESSION['error'] = $e->getMessage();
    header('Location: ../html/registro.php');
    exit;
} catch (PDOException $e) {
    error_log("Error de PDO: " . $e->getMessage());
    $_SESSION['error'] = 'Error en la base de datos. Por favor, intenta nuevamente.';
    header('Location: ../html/registro.php');
    exit;
} 