<?php
session_start();
require_once '../config/database.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'Debes iniciar sesión para ver tus reservas.';
    header('Location: /cielotico/html/login.php');
    exit;
}

// Obtener las reservas del usuario
try {
    $stmt = $conn->prepare("
        SELECT r.*, t.nombre as nombre_tour, t.precio 
        FROM reservas r 
        JOIN tours t ON r.tour_id = t.id 
        WHERE r.usuario_id = ? 
        ORDER BY r.fecha_reserva DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $reservas = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Error al obtener reservas: " . $e->getMessage());
    $_SESSION['error'] = 'Error al cargar las reservas.';
    $reservas = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas - Cielo Tico</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
        .reservas-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .reservas-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .reservas-table th, .reservas-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .reservas-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .estado-pendiente {
            color: #ffa500;
            font-weight: bold;
        }
        .estado-confirmada {
            color: #28a745;
            font-weight: bold;
        }
        .estado-cancelada {
            color: #dc3545;
            font-weight: bold;
        }
        .no-reservas {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <div class="reservas-container">
        <h1>Mis Reservas</h1>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (empty($reservas)): ?>
            <div class="no-reservas">
                <h2>No tienes reservas activas</h2>
                <p>¡Explora nuestros tours y haz tu primera reserva!</p>
                <a href="tours.php" class="btn-primary">Ver Tours Disponibles</a>
            </div>
        <?php else: ?>
            <table class="reservas-table">
                <thead>
                    <tr>
                        <th>Tour</th>
                        <th>Fecha de Reserva</th>
                        <th>Fecha del Tour</th>
                        <th>Cantidad de Personas</th>
                        <th>Precio Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reserva['nombre_tour']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($reserva['fecha_reserva'])); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($reserva['fecha_tour'])); ?></td>
                            <td><?php echo $reserva['cantidad_personas']; ?></td>
                            <td>₡<?php echo number_format($reserva['precio'] * $reserva['cantidad_personas'], 2); ?></td>
                            <td>
                                <span class="estado-<?php echo strtolower($reserva['estado']); ?>">
                                    <?php echo ucfirst($reserva['estado']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($reserva['estado'] === 'pendiente'): ?>
                                    <a href="cancelar_reserva.php?id=<?php echo $reserva['id']; ?>" 
                                       class="btn-danger"
                                       onclick="return confirm('¿Estás seguro de que deseas cancelar esta reserva?')">
                                        Cancelar
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <?php include '../templates/footer.php'; ?>
</body>
</html> 