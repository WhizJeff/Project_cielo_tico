<?php
session_start();
require_once '../config/database.php';

// Verificar si la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Obtener y sanitizar los datos del formulario
        $nombre = trim(htmlspecialchars($_POST['nombre'] ?? ''));
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $telefono = trim(htmlspecialchars($_POST['telefono'] ?? ''));
        $mensaje = trim(htmlspecialchars($_POST['mensaje'] ?? ''));

        // Validar que el mensaje no exceda los 150 caracteres
        if (strlen($mensaje) > 150) {
            $mensaje = substr($mensaje, 0, 150);
        }

        // Validar que los campos requeridos no estén vacíos
        if (empty($nombre) || empty($email) || empty($mensaje)) {
            throw new Exception('Por favor complete todos los campos requeridos');
        }

        // Validar el formato del correo electrónico
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('El formato del correo electrónico no es válido');
        }

        // Preparar la consulta SQL usando PDO
        $stmt = $conn->prepare("
            INSERT INTO contactos (
                nombre, 
                email, 
                telefono, 
                mensaje,
                estado
            ) VALUES (?, ?, ?, ?, 'nuevo')
        ");

        // Ejecutar la consulta
        $stmt->execute([
            $nombre,
            $email,
            $telefono,
            $mensaje
        ]);

        $_SESSION['success'] = 'Mensaje enviado correctamente. Nos pondremos en contacto contigo pronto.';
        header('Location: /cielotico/html/contacto.php');
        exit;

    } catch (Exception $e) {
        error_log("Error en procesamiento de contacto: " . $e->getMessage());
        $_SESSION['error'] = 'Error al enviar el mensaje. Por favor, intenta nuevamente.';
        header('Location: /cielotico/html/contacto.php');
        exit;
    }
} else {
    header('Location: /cielotico/html/contacto.php');
    exit;
}
?> 