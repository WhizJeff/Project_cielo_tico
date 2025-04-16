<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'Debes iniciar sesión para hacer una reserva.';
    header('Location: login.php');
    exit;
}

// Verificar si se proporcionó un ID de tour
if (!isset($_GET['tour_id'])) {
    $_SESSION['error'] = 'Tour no especificado.';
    header('Location: tours.php');
    exit;
}

$tour_id = intval($_GET['tour_id']);

require_once '../config/database.php';

// Obtener información del tour y tipos de bus disponibles
try {
    // Obtener información del tour
    $stmt = $conn->prepare("SELECT * FROM tours WHERE id = ? AND activo = 1");
    $stmt->execute([$tour_id]);
    $tour = $stmt->fetch();

    if (!$tour) {
        $_SESSION['error'] = 'Tour no encontrado o no disponible.';
        header('Location: tours.php');
        exit;
    }

    // Obtener tipos de bus disponibles
    $stmt = $conn->query("SELECT * FROM tipos_bus ORDER BY id");
    $tipos_bus = $stmt->fetchAll();

} catch (PDOException $e) {
    error_log("Error al obtener datos: " . $e->getMessage());
    $_SESSION['error'] = 'Error al cargar la información del tour.';
    header('Location: tours.php');
    exit;
}

// Calcular fecha mínima (mañana) y máxima (6 meses desde hoy)
$min_date = date('Y-m-d', strtotime('+1 day'));
$max_date = date('Y-m-d', strtotime('+6 months'));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Tour - <?php echo htmlspecialchars($tour['nombre']); ?></title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .reservation-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .tour-info {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #e0e0e0;
            align-items: start;
        }
        .tour-image {
            width: 400px;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .tour-details h1 {
            margin: 0 0 1rem;
            color: #2c3e50;
            font-size: 2.5rem;
        }
        .tour-details p {
            color: #34495e;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        .duration-badge {
            display: inline-flex;
            align-items: center;
            background: #e3f2fd;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            color: #1976d2;
            font-weight: 500;
        }
        .duration-badge i {
            margin-right: 0.5rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2c3e50;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .form-group input[type="date"],
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        .form-group input[type="date"]:focus,
        .form-group select:focus {
            border-color: #3498db;
            outline: none;
        }
        .bus-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin: 1.5rem 0;
        }
        .bus-option {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .bus-option:hover {
            border-color: #3498db;
            transform: translateY(-2px);
        }
        .bus-option.selected {
            border-color: #3498db;
            background-color: #f8f9ff;
        }
        .bus-option h3 {
            color: #2c3e50;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .bus-features {
            margin: 1rem 0;
            padding: 0;
            list-style: none;
        }
        .bus-features li {
            margin-bottom: 0.5rem;
            color: #34495e;
            display: flex;
            align-items: center;
        }
        .bus-features li i {
            margin-right: 0.5rem;
            color: #3498db;
        }
        .bus-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin: 1rem 0;
        }
        .bus-price {
            font-size: 1.5rem;
            color: #2c3e50;
            font-weight: bold;
            margin-top: 1rem;
            text-align: right;
        }
        .bus-price .currency {
            color: #3498db;
            font-size: 1rem;
        }
        .btn-reservar {
            width: 100%;
            padding: 1rem;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 2rem;
        }
        .btn-reservar:hover {
            background-color: #2980b9;
        }
        .total-price {
            background: #f8f9ff;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: right;
            font-size: 1.5rem;
            color: #2c3e50;
            margin: 2rem 0;
            border: 2px solid #e0e0e0;
        }
        .total-price .amount {
            color: #3498db;
            font-weight: bold;
        }
        .upgrade-message {
            margin: 2rem 0;
            padding: 1.5rem;
            background-color: #e3f2fd;
            border-radius: 8px;
            text-align: center;
        }
        .upgrade-message h3 {
            color: #1565c0;
            margin: 0 0 0.5rem;
            font-size: 1.3rem;
        }
        .upgrade-message p {
            margin: 0;
            color: #1976d2;
        }
        .bus-option {
            margin-bottom: 2rem;
        }
        #buses-premium .bus-option {
            border-color: #e3f2fd;
        }
        #buses-premium .bus-option:hover,
        #buses-premium .bus-option.selected {
            border-color: #1976d2;
            background-color: #e3f2fd;
        }
        .bus-turistico {
            max-width: 800px;
            margin: 0 auto 2rem;
        }
        .bus-options-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .upgrade-message {
            margin: 2rem 0;
            padding: 1.5rem;
            background-color: #e3f2fd;
            border-radius: 8px;
            text-align: center;
        }
        .upgrade-message h3 {
            color: #1565c0;
            margin: 0 0 0.5rem;
            font-size: 1.3rem;
        }
        .upgrade-message p {
            margin: 0;
            color: #1976d2;
        }
        .bus-option {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .bus-option:hover,
        .bus-option.selected {
            border-color: #1976d2;
            background-color: #e3f2fd;
        }
        .bus-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin: 1rem 0;
        }
        .bus-features {
            margin: 1rem 0;
            padding: 0;
            list-style: none;
            flex-grow: 1;
        }
        .bus-features li {
            margin-bottom: 0.5rem;
            color: #34495e;
            display: flex;
            align-items: center;
        }
        .bus-features li i {
            margin-right: 0.5rem;
            color: #1976d2;
        }
        .bus-price {
            margin-top: auto;
            text-align: right;
            font-weight: bold;
            font-size: 1.2rem;
        }
        @media (max-width: 1200px) {
            .bus-options-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            .bus-options-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <div class="reservation-container">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
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

        <div class="tour-info">
            <img src="<?php echo htmlspecialchars($tour['imagen_url']); ?>" alt="<?php echo htmlspecialchars($tour['nombre']); ?>" class="tour-image">
            <div class="tour-details">
                <h1><?php echo str_replace('Volc?n', 'Volcán', htmlspecialchars($tour['nombre'])); ?></h1>
                <p><?php echo htmlspecialchars($tour['descripcion']); ?></p>
                <div class="duration-badge">
                    <i class="far fa-clock"></i>
                    <span>Duración: <?php echo str_replace(['dia', 'd?a'], ['día', 'día'], htmlspecialchars($tour['duracion'])); ?></span>
                </div>
            </div>
        </div>

        <form action="../php/procesar_reserva.php" method="POST" class="reservation-form">
            <input type="hidden" name="tour_id" value="<?php echo $tour['id']; ?>">
            
            <div class="form-group">
                <label for="fecha_reserva">Fecha del Tour:</label>
                <input type="date" id="fecha_reserva" name="fecha_reserva" required 
                       min="<?php echo $min_date; ?>" 
                       max="<?php echo $max_date; ?>">
            </div>

            <div class="form-group">
                <label for="horario">Horario:</label>
                <select id="horario" name="horario" required>
                    <option value="08:00:00">8:00 AM</option>
                    <option value="14:00:00">2:00 PM</option>
                </select>
            </div>

            <div class="form-group">
                <label for="numero_personas">Número de Personas:</label>
                <select id="numero_personas" name="numero_personas" required onchange="actualizarPrecioTotal()">
                    <option value="">Seleccione la cantidad</option>
                    <?php
                    $max_capacidad = max(array_column($tipos_bus, 'capacidad_pasajeros'));
                    for($i = 1; $i <= $max_capacidad; $i++) {
                        echo "<option value=\"$i\">$i " . ($i === 1 ? "persona" : "personas") . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Seleccione su Bus:</label>
                <div class="bus-options-grid">
                    <?php 
                    // Ordenar los buses por precio
                    $buses_ordenados = $tipos_bus;
                    usort($buses_ordenados, function($a, $b) use ($tour) {
                        $precio_a = $tour['precio_' . strtolower(str_replace('í', 'i', $a['nombre']))];
                        $precio_b = $tour['precio_' . strtolower(str_replace('í', 'i', $b['nombre']))];
                        return $precio_a - $precio_b;
                    });

                    foreach ($buses_ordenados as $bus):
                    ?>
                        <div class="bus-option" onclick="seleccionarBus(<?php echo $bus['id']; ?>)">
                            <input type="radio" name="tipo_bus" value="<?php echo $bus['id']; ?>" 
                                   id="bus_<?php echo $bus['id']; ?>" style="display: none;" required>
                            <h3><?php echo htmlspecialchars($bus['nombre']); ?></h3>
                            <img src="../img/buses/bus<?php echo $bus['id']; ?>.jpg" 
                                 alt="<?php echo htmlspecialchars($bus['nombre']); ?>" class="bus-image">
                            <ul class="bus-features">
                                <?php 
                                $caracteristicas = explode(', ', str_replace(
                                    ['estandar', 'entretenimiento'], 
                                    ['estándar', 'entretenimiento'], 
                                    $bus['caracteristicas']
                                ));
                                foreach ($caracteristicas as $caracteristica): 
                                ?>
                                    <li><i class="fas fa-check"></i><?php echo htmlspecialchars($caracteristica); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <p>Capacidad: <?php echo $bus['capacidad_pasajeros']; ?> personas</p>
                            <div class="bus-price">
                                <span class="currency">$</span>
                                <?php 
                                    $precio_campo = 'precio_' . strtolower(str_replace('í', 'i', $bus['nombre']));
                                    echo intval($tour[$precio_campo]/1000); 
                                ?> por persona
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Total -->
            <div class="total-price">
                Total: <span class="amount" id="total-amount">$0</span>
            </div>

            <!-- Botón Reservar -->
            <button type="submit" class="btn-reservar">Reservar Ahora</button>
        </form>
    </div>

    <script>
    let preciosPorBus = {
        <?php foreach ($tipos_bus as $bus): ?>
        <?php 
            $precio_campo = 'precio_' . strtolower(str_replace('í', 'i', $bus['nombre']));
        ?>
        <?php echo $bus['id']; ?>: {
            precio: <?php echo intval($tour[$precio_campo]/1000); ?>,
            capacidad: <?php echo $bus['capacidad_pasajeros']; ?>,
            nombre: '<?php echo $bus['nombre']; ?>'
        },
        <?php endforeach; ?>
    };

    function seleccionarBus(busId) {
        // Remover la clase selected de todas las opciones
        document.querySelectorAll('.bus-option').forEach(option => {
            option.classList.remove('selected');
        });
        
        // Seleccionar el radio button
        const radioButton = document.getElementById('bus_' + busId);
        if (radioButton) {
            radioButton.checked = true;
            // Agregar la clase selected a la opción seleccionada
            radioButton.closest('.bus-option').classList.add('selected');
        }
        
        // Actualizar el precio total
        actualizarPrecioTotal();
    }

    function actualizarPrecioTotal() {
        const busSeleccionado = document.querySelector('input[name="tipo_bus"]:checked');
        const numeroPersonas = document.getElementById('numero_personas').value;
        
        if (busSeleccionado && numeroPersonas) {
            const busId = parseInt(busSeleccionado.value);
            const precio = preciosPorBus[busId].precio;
            const total = precio * parseInt(numeroPersonas);
            document.getElementById('total-amount').textContent = '$' + total;
        } else {
            document.getElementById('total-amount').textContent = '$0';
        }
    }

    // Agregar evento change al select de número de personas
    document.getElementById('numero_personas').addEventListener('change', actualizarPrecioTotal);
    </script>

    <?php include '../templates/footer.php'; ?>
</body>
</html> 