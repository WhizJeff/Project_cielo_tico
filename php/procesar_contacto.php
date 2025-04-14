<?php
require_once 'config/database.php';

// Verificar si la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y validar los datos del formulario
    $nombre_completo = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $correo_electronico = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
    $asunto = filter_input(INPUT_POST, 'asunto', FILTER_SANITIZE_STRING);
    $mensaje = filter_input(INPUT_POST, 'mensaje', FILTER_SANITIZE_STRING);

    // Validar que el mensaje no exceda los 150 caracteres
    if (strlen($mensaje) > 150) {
        $mensaje = substr($mensaje, 0, 150);
    }

    // Validar que los campos requeridos no estén vacíos
    if (empty($nombre_completo) || empty($correo_electronico) || empty($asunto) || empty($mensaje)) {
        echo json_encode(['success' => false, 'message' => 'Por favor complete todos los campos requeridos']);
        exit;
    }

    // Conectar a la base de datos
    $conexion = conectarDB();

    // Preparar la consulta SQL
    $stmt = $conexion->prepare("INSERT INTO contactos (nombre_completo, correo_electronico, telefono, asunto, mensaje) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nombre_completo, $correo_electronico, $telefono, $asunto, $mensaje);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Mensaje enviado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al enviar el mensaje']);
    }

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?> 