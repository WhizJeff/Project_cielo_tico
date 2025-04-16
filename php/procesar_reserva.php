<?php
session_start();
require_once '../config/database.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'Debes iniciar sesión para hacer una reserva.';
    header('Location: /cielotico/html/login.php');
    exit;
}

// Verificar si se recibieron los datos necesarios
if (!isset($_POST['tour_id'], $_POST['fecha_tour'], $_POST['cantidad_personas'])) {
    $_SESSION['error'] = 'Faltan datos necesarios para la reserva.';
    header('Location: /cielotico/html/tours.php');
    exit;
}

// Validar los datos
$tour_id = filter_var($_POST['tour_id'], FILTER_VALIDATE_INT);
$fecha_reserva = filter_var($_POST['fecha_tour'], FILTER_SANITIZE_STRING);
$numero_personas = filter_var($_POST['cantidad_personas'], FILTER_VALIDATE_INT);

// Validaciones adicionales
if (!$tour_id || !$numero_personas || $numero_personas < 1 || $numero_personas > 10) {
    $_SESSION['error'] = 'Datos de reserva inválidos.';
    header('Location: /cielotico/html/tours.php');
    exit;
}

// Validar que la fecha de la reserva sea futura
$fecha_actual = new DateTime();
$fecha_reserva_obj = new DateTime($fecha_reserva);
if ($fecha_reserva_obj <= $fecha_actual) {
    $_SESSION['error'] = 'La fecha de la reserva debe ser futura.';
    header('Location: /cielotico/html/tours.php');
    exit;
}

try {
    // Verificar que el tour existe y está activo
    $stmt = $conn->prepare("SELECT precio FROM tours WHERE id = ? AND activo = 1");
    $stmt->execute([$tour_id]);
    $tour = $stmt->fetch();
    
    if (!$tour) {
        throw new Exception('El tour seleccionado no está disponible.');
    }
    
    // Calcular el precio total
    $precio_total = $tour['precio'] * $numero_personas;
    
    // Iniciar transacción
    $conn->beginTransaction();
    
    // Insertar la reserva
    $stmt = $conn->prepare("
        INSERT INTO reservaciones (
            usuario_id, tour_id, fecha_reserva, 
            numero_personas, precio_total, estado
        ) VALUES (
            ?, ?, ?, ?, ?, 'pendiente'
        )
    ");
    
    $stmt->execute([
        $_SESSION['user_id'],
        $tour_id,
        $fecha_reserva,
        $numero_personas,
        $precio_total
    ]);
    
    // Confirmar transacción
    $conn->commit();
    
    $_SESSION['success'] = '¡Reserva realizada con éxito! Puedes ver los detalles en "Mis Reservas".';
    header('Location: /cielotico/html/mis_reservas.php');
    exit;
    
} catch (Exception $e) {
    // Revertir transacción en caso de error
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    
    error_log("Error al procesar reserva: " . $e->getMessage());
    $_SESSION['error'] = 'Error al procesar la reserva. Por favor, intenta nuevamente.';
    header('Location: /cielotico/html/tours.php');
    exit;
} 