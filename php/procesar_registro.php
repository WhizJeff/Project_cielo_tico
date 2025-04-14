<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log del inicio del script
error_log("Iniciando procesar_registro.php");

// Verificar que el archivo de configuración existe
if (!file_exists(__DIR__ . '/config/database.php')) {
    error_log("Error: No se encuentra el archivo de configuración de la base de datos");
    die(json_encode(['success' => false, 'message' => 'Error de configuración del servidor']));
}

require_once __DIR__ . '/config/database.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Log del método de la petición
error_log("Método de la petición: " . $_SERVER['REQUEST_METHOD']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    error_log("Error: Método no permitido - " . $_SERVER['REQUEST_METHOD']);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

try {
    $raw_data = file_get_contents('php://input');
    error_log("Datos recibidos: " . $raw_data);
    
    $data = json_decode($raw_data, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Error al decodificar JSON: ' . json_last_error_msg());
    }
    
    error_log("Datos decodificados: " . print_r($data, true));

    // Validar datos
    if (empty($data['nombre']) || empty($data['email']) || empty($data['telefono']) || empty($data['password'])) {
        throw new Exception('Todos los campos son requeridos');
    }

    // Validar email
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Email inválido');
    }

    error_log("Intentando conectar a la base de datos...");
    
    // Validar que el email no exista
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$data['email']]);
    if ($stmt->rowCount() > 0) {
        throw new Exception('El email ya está registrado');
    }

    error_log("Email no duplicado, procediendo con el registro");

    // Hash de la contraseña
    $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);

    // Insertar usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, telefono, password, fecha_registro) VALUES (?, ?, ?, ?, NOW())");
    $result = $stmt->execute([
        $data['nombre'],
        $data['email'],
        $data['telefono'],
        $password_hash
    ]);

    if (!$result) {
        error_log("Error en la inserción: " . print_r($stmt->errorInfo(), true));
        throw new Exception('Error al insertar en la base de datos');
    }

    error_log("Usuario registrado exitosamente");

    echo json_encode([
        'success' => true,
        'message' => '¡Registro exitoso! Ya puedes iniciar sesión.'
    ]);

} catch (Exception $e) {
    error_log("Error en registro: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 