<?php
session_start();
require_once '../config/database.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'Debes iniciar sesión para cancelar reservas.';
    header('Location: login.php');
    exit;
}

// Verificar si se proporcionó un ID de reserva
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = 'ID de reserva no válido.';
    header('Location: mis_reservas.php');
    exit;
}

try {
    // Verificar que la reserva pertenece al usuario y está pendiente
    $stmt = $conn->prepare("
        SELECT * FROM reservas 
        WHERE id = ? AND usuario_id = ? AND estado = 'pendiente'
    ");
    $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
    $reserva = $stmt->fetch();

    if (!$reserva) {
        $_SESSION['error'] = 'No se encontró la reserva o no tienes permiso para cancelarla.';
        header('Location: mis_reservas.php');
        exit;
    }

    // Cancelar la reserva
    $stmt = $conn->prepare("
        UPDATE reservas 
        SET estado = 'cancelada' 
        WHERE id = ? AND usuario_id = ?
    ");
    $stmt->execute([$_GET['id'], $_SESSION['user_id']]);

    $_SESSION['success'] = 'La reserva ha sido cancelada exitosamente.';

} catch (PDOException $e) {
    error_log("Error al cancelar reserva: " . $e->getMessage());
    $_SESSION['error'] = 'Error al cancelar la reserva. Por favor, intenta nuevamente.';
}

header('Location: mis_reservas.php');
exit; 