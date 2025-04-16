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
if (!isset($_POST['tour_id'], $_POST['fecha_reserva'], $_POST['horario'], $_POST['numero_personas'])) {
    $_SESSION['error'] = 'Faltan datos necesarios para la reserva.';
    header('Location: /cielotico/html/tours.php');
    exit;
}

try {
    // Validar y sanitizar los datos
    $tour_id = filter_var($_POST['tour_id'], FILTER_VALIDATE_INT);
    $fecha_reserva = filter_var($_POST['fecha_reserva'], FILTER_SANITIZE_STRING);
    $horario = filter_var($_POST['horario'], FILTER_SANITIZE_STRING);
    $numero_personas = filter_var($_POST['numero_personas'], FILTER_VALIDATE_INT);

    // Validaciones adicionales
    if (!$tour_id || !$numero_personas || $numero_personas < 1 || $numero_personas > 10) {
        throw new Exception('Datos de reserva inválidos.');
    }

    // Validar que la fecha sea futura
    $fecha_actual = new DateTime();
    $fecha_reserva_obj = new DateTime($fecha_reserva);
    if ($fecha_reserva_obj <= $fecha_actual) {
        throw new Exception('La fecha de la reserva debe ser futura.');
    }

    // Validar el horario
    $horarios_validos = ['08:00', '14:00'];
    if (!in_array($horario, $horarios_validos)) {
        throw new Exception('Horario no válido.');
    }

    // Iniciar transacción
    $conn->beginTransaction();

    // Verificar que el tour existe y está activo
    $stmt = $conn->prepare("
        SELECT t.*, b.id as bus_id, b.codigo as bus_codigo
        FROM tours t
        LEFT JOIN buses b ON b.tipo_bus_id = t.tipo_bus_id AND b.estado = 'activo'
        WHERE t.id = ? AND t.activo = 1
        LIMIT 1
    ");
    $stmt->execute([$tour_id]);
    $tour = $stmt->fetch();

    if (!$tour) {
        throw new Exception('El tour seleccionado no está disponible.');
    }

    // Verificar disponibilidad para la fecha y horario seleccionados
    $stmt = $conn->prepare("
        SELECT COUNT(*) as reservas_existentes, SUM(numero_personas) as total_personas
        FROM reservaciones 
        WHERE tour_id = ? AND fecha_reserva = ? AND horario = ? AND estado != 'cancelada'
    ");
    $stmt->execute([$tour_id, $fecha_reserva, $horario]);
    $disponibilidad = $stmt->fetch();

    // Verificar si hay espacio disponible
    if ($disponibilidad['total_personas'] + $numero_personas > $tour['capacidad_maxima']) {
        throw new Exception('No hay suficiente espacio disponible para esta fecha y horario.');
    }

    // Calcular el precio total
    $precio_total = $tour['precio'] * $numero_personas;

    // Insertar la reserva
    $stmt = $conn->prepare("
        INSERT INTO reservaciones (
            usuario_id, tour_id, fecha_reserva, horario,
            numero_personas, precio_total, estado, bus_id
        ) VALUES (?, ?, ?, ?, ?, ?, 'pendiente', ?)
    ");

    $stmt->execute([
        $_SESSION['user_id'],
        $tour_id,
        $fecha_reserva,
        $horario,
        $numero_personas,
        $precio_total,
        $tour['bus_id']
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
    $_SESSION['error'] = $e->getMessage();
    header('Location: /cielotico/html/reservar_tour.php?tour_id=' . $tour_id);
    exit;
} 