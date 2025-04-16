<?php
session_start();
require_once '../config/database.php';

// Obtener todos los tours disponibles
try {
    $stmt = $conn->query("SELECT * FROM tours WHERE activo = 1 ORDER BY nombre");
    $tours = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Error al obtener tours: " . $e->getMessage());
    $_SESSION['error'] = 'Error al cargar los tours disponibles.';
    $tours = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tours Disponibles - Cielo Tico</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
        .tours-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        .tour-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .tour-card:hover {
            transform: translateY(-5px);
        }
        .tour-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .tour-content {
            padding: 1.5rem;
        }
        .tour-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #333;
        }
        .tour-description {
            color: #666;
            margin-bottom: 1rem;
        }
        .tour-price {
            font-size: 1.25rem;
            color: #28a745;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .reservation-form {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #666;
        }
        .form-group input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn-reservar {
            width: 100%;
            padding: 0.75rem;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-reservar:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <div class="tours-container">
        <?php if (empty($tours)): ?>
            <div class="alert alert-info">
                No hay tours disponibles en este momento.
            </div>
        <?php else: ?>
            <?php foreach ($tours as $tour): ?>
                <div class="tour-card">
                    <img src="<?php echo htmlspecialchars($tour['imagen_url']); ?>" alt="<?php echo htmlspecialchars($tour['nombre']); ?>" class="tour-image">
                    <div class="tour-content">
                        <h2 class="tour-title"><?php echo htmlspecialchars($tour['nombre']); ?></h2>
                        <p class="tour-description"><?php echo htmlspecialchars($tour['descripcion']); ?></p>
                        <p class="tour-price">₡<?php echo number_format($tour['precio'], 2); ?> por persona</p>
                        
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form action="/cielotico/php/procesar_reserva.php" method="POST" class="reservation-form">
                                <input type="hidden" name="tour_id" value="<?php echo $tour['id']; ?>">
                                <div class="form-group">
                                    <label for="fecha_tour_<?php echo $tour['id']; ?>">Fecha del Tour:</label>
                                    <input type="date" id="fecha_tour_<?php echo $tour['id']; ?>" name="fecha_tour" required 
                                           min="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="cantidad_personas_<?php echo $tour['id']; ?>">Cantidad de Personas:</label>
                                    <input type="number" id="cantidad_personas_<?php echo $tour['id']; ?>" name="cantidad_personas" 
                                           required min="1" max="10" value="1">
                                </div>
                                <button type="submit" class="btn-reservar">Reservar Ahora</button>
                            </form>
                        <?php else: ?>
                            <p class="alert alert-warning">
                                <a href="login.php">Inicia sesión</a> para hacer una reserva.
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php include '../templates/footer.php'; ?>
</body>
</html> 