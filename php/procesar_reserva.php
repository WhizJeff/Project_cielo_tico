<?php
session_start();
require_once '../config/database.php';
require_once 'classes/Mailer.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'Debes iniciar sesión para hacer una reserva.';
    header('Location: /cielotico/html/login.php');
    exit;
}

// Verificar si se recibieron los datos necesarios
if (!isset($_POST['tour_id'], $_POST['fecha_reserva'], $_POST['horario'], $_POST['numero_personas'], $_POST['tipo_bus'])) {
    $_SESSION['error'] = 'Faltan datos necesarios para la reserva.';
    header('Location: /cielotico/html/tours.php');
    exit;
}

try {
    error_log("Iniciando procesamiento de reserva");
    error_log("POST data: " . print_r($_POST, true));

    // Validar y sanitizar los datos
    $tour_id = filter_var($_POST['tour_id'], FILTER_VALIDATE_INT);
    $fecha_reserva = filter_var($_POST['fecha_reserva'], FILTER_SANITIZE_STRING);
    $horario = filter_var($_POST['horario'], FILTER_SANITIZE_STRING);
    $numero_personas = filter_var($_POST['numero_personas'], FILTER_VALIDATE_INT);
    $tipo_bus = filter_var($_POST['tipo_bus'], FILTER_VALIDATE_INT);

    error_log("Datos validados: tour_id=$tour_id, fecha=$fecha_reserva, horario=$horario, personas=$numero_personas, tipo_bus=$tipo_bus");

    // Validaciones adicionales
    if (!$tour_id || !$numero_personas || !$tipo_bus || $numero_personas < 1) {
        error_log("Falló validación básica: tour_id=" . ($tour_id ? 'true' : 'false') . 
                 ", numero_personas=" . ($numero_personas ? 'true' : 'false') . 
                 ", tipo_bus=" . ($tipo_bus ? 'true' : 'false'));
        throw new Exception('Por favor, complete todos los campos requeridos.');
    }

    // Validar que la fecha sea futura
    $fecha_actual = new DateTime();
    $fecha_reserva_obj = new DateTime($fecha_reserva);
    if ($fecha_reserva_obj <= $fecha_actual) {
        error_log("Fecha inválida: fecha_reserva=$fecha_reserva, fecha_actual=" . $fecha_actual->format('Y-m-d'));
        throw new Exception('La fecha de la reserva debe ser futura.');
    }

    // Validar el horario (ahora acepta el formato con segundos)
    $horarios_validos = ['08:00:00', '14:00:00'];
    if (!in_array($horario, $horarios_validos)) {
        error_log("Horario inválido: $horario");
        throw new Exception('Por favor, seleccione un horario válido.');
    }

    // Iniciar transacción
    $conn->beginTransaction();
    error_log("Transacción iniciada");

    // Verificar que el tour existe y está activo
    $stmt = $conn->prepare("
        SELECT t.*, tb.capacidad_pasajeros, tb.nombre as nombre_bus
        FROM tours t
        JOIN tipos_bus tb ON tb.id = ?
        WHERE t.id = ? AND t.activo = 1
        LIMIT 1
    ");
    $stmt->execute([$tipo_bus, $tour_id]);
    $tour = $stmt->fetch(PDO::FETCH_ASSOC);
    error_log("Datos del tour: " . print_r($tour, true));

    if (!$tour) {
        error_log("Tour no encontrado o inactivo");
        throw new Exception('El tour o tipo de bus seleccionado no está disponible.');
    }

    // Verificar disponibilidad para la fecha y horario seleccionados
    $stmt = $conn->prepare("
        SELECT COUNT(*) as reservas_existentes, COALESCE(SUM(numero_personas), 0) as total_personas
        FROM reservaciones 
        WHERE tour_id = ? AND fecha_reserva = ? AND horario = ? AND estado != 'cancelada'
    ");
    $stmt->execute([$tour_id, $fecha_reserva, $horario]);
    $disponibilidad = $stmt->fetch(PDO::FETCH_ASSOC);
    error_log("Disponibilidad: " . print_r($disponibilidad, true));

    // Verificar si hay espacio disponible
    if ($disponibilidad['total_personas'] + $numero_personas > $tour['capacidad_pasajeros']) {
        error_log("No hay espacio suficiente: capacidad=" . $tour['capacidad_pasajeros'] . 
                 ", ocupado=" . $disponibilidad['total_personas'] . 
                 ", solicitado=" . $numero_personas);
        throw new Exception('No hay suficiente espacio disponible para esta fecha y horario.');
    }

    // Obtener el precio según el tipo de bus
    $precio_campo = 'precio_' . strtolower(str_replace('í', 'i', $tour['nombre_bus']));
    error_log("Campo de precio a buscar: $precio_campo");
    $precio_por_persona = $tour[$precio_campo];
    
    if (!$precio_por_persona) {
        error_log("Error al obtener precio. Campos disponibles: " . print_r(array_keys($tour), true));
        throw new Exception('Error al calcular el precio. Por favor, intente nuevamente.');
    }

    $precio_total = ($precio_por_persona / 1000) * $numero_personas; // Dividir por 1000 para convertir a dólares
    error_log("Precio calculado: precio_por_persona=$precio_por_persona, total=$precio_total");

    // Insertar la reserva
    $stmt = $conn->prepare("
        INSERT INTO reservaciones (
            usuario_id, tour_id, fecha_reserva, horario,
            numero_personas, precio_total, estado, tipo_bus_id
        ) VALUES (?, ?, ?, ?, ?, ?, 'pendiente', ?)
    ");

    $valores = [
        $_SESSION['user_id'],
        $tour_id,
        $fecha_reserva,
        $horario,
        $numero_personas,
        $precio_total,
        $tipo_bus
    ];
    error_log("Intentando insertar reserva con valores: " . print_r($valores, true));

    $stmt->execute($valores);
    $reserva_id = $conn->lastInsertId();

    // Obtener datos del usuario
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Preparar datos para la notificación
    $reserva = [
        'id' => $reserva_id,
        'fecha_reserva' => $fecha_reserva,
        'horario' => $horario,
        'numero_personas' => $numero_personas,
        'precio_total' => $precio_total
    ];

    // Enviar notificaciones por correo
    $mailer = new Mailer();
    $mailer->notificarNuevaReserva($reserva, $tour, $usuario);

    // Confirmar transacción
    $conn->commit();
    error_log("Transacción confirmada");

    $_SESSION['success'] = '¡Reserva realizada con éxito! Te hemos enviado un correo con los detalles.';
    header('Location: /cielotico/html/mis_reservas.php');
    exit;

} catch (Exception $e) {
    // Revertir transacción en caso de error
    if ($conn->inTransaction()) {
        $conn->rollBack();
        error_log("Transacción revertida");
    }

    error_log("Error al procesar reserva: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    $_SESSION['error'] = $e->getMessage();
    header('Location: /cielotico/html/reservar_tour.php?tour_id=' . $tour_id);
    exit;
} 