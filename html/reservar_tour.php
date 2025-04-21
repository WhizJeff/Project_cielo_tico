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
    <title>Reservar Tour - <?php echo htmlspecialchars($tour['nombre'], ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .reservation-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: var(--shadow-md);
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
            box-shadow: var(--shadow-md);
            transition: transform 0.3s ease;
        }
        .tour-image:hover {
            transform: scale(1.02);
        }
        .tour-details h1 {
            color: var(--color-text);
            margin: 0 0 1rem;
            font-size: 2.5rem;
            font-family: var(--font-heading);
        }
        .tour-details p {
            color: var(--color-text);
            margin-bottom: 1rem;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        .duration-badge {
            display: inline-flex;
            align-items: center;
            background: var(--color-secondary);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            color: var(--color-light);
            font-weight: 500;
        }
        .duration-badge i {
            margin-right: 0.5rem;
        }
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--color-text);
            font-weight: 500;
            font-size: 1.1rem;
            font-family: var(--font-body);
        }
        /* Contenedor para el campo de fecha */
        .form-group .date-input-container {
            position: relative;
            width: 100%;
        }
        /* Estilos base para el input de fecha */
        .form-group input[type="date"] {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #87CEFA;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: white;
            color: var(--color-text);
            cursor: pointer;
            font-family: var(--font-body);
            position: relative;
        }
        .form-group input[type="date"]::-webkit-calendar-picker-indicator {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 0;
            cursor: pointer;
        }
        .form-group input[type="date"]:hover {
            border-color: var(--color-primary);
            background-color: rgba(135, 206, 250, 0.1);
        }
        .form-group input[type="date"]:focus {
            border-color: var(--color-secondary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(64, 224, 208, 0.2);
        }
        .form-group select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #87CEFA;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: white;
            color: var(--color-text);
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%2340E0D0' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1.2em;
            padding-right: 2.5rem;
            font-family: var(--font-body);
        }
        .form-group select:hover {
            border-color: var(--color-primary);
            background-color: rgba(135, 206, 250, 0.1);
        }
        .form-group select:focus {
            border-color: var(--color-secondary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(64, 224, 208, 0.2);
        }
        .form-group select option:first-child {
            color: #666;
            font-style: italic;
        }
        .form-group select option {
            color: var(--color-text);
            padding: 0.5rem;
        }
        .form-group.special-select select {
            background-color: white;
            color: var(--color-text);
            border: 2px solid #87CEFA;
        }
        .form-group.special-select select:valid:not([value=""]) {
            border-color: var(--color-secondary);
        }
        .form-group.special-select select:hover {
            border-color: var(--color-secondary);
        }
        .form-group.special-select select:focus {
            border-color: var(--color-secondary);
            box-shadow: 0 0 0 3px rgba(64, 224, 208, 0.2);
        }
        .form-group.special-select select option {
            background-color: white;
            color: var(--color-text);
            font-family: var(--font-body);
        }
        .form-group.special-select label {
            color: var(--color-text);
        }
        .bus-options-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin: 1.5rem 0;
        }
        .bus-option {
            border: 2px solid var(--color-secondary);
            border-radius: 12px;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .bus-option:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }
        .bus-option.selected {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }
        .bus-option h3 {
            color: var(--color-text);
            font-size: 1.5rem;
            margin-bottom: 1rem;
            font-family: var(--font-heading);
        }
        .bus-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin: 1rem 0;
            transition: transform 0.3s ease;
        }
        .bus-option:hover .bus-image {
            transform: scale(1.05);
        }
        .bus-features {
            margin: 1rem 0;
            padding: 0;
            list-style: none;
            flex-grow: 1;
        }
        .bus-features li {
            margin-bottom: 0.5rem;
            color: inherit;
            display: flex;
            align-items: center;
            font-size: 1rem;
        }
        .bus-features li i {
            margin-right: 0.5rem;
            color: var(--color-primary);
        }
        .bus-option.selected .bus-features li i {
            color: var(--color-light);
        }
        .bus-price {
            margin-top: auto;
            text-align: right;
            font-weight: bold;
            font-size: 1.2rem;
            color: inherit;
        }
        .total-price {
            background: linear-gradient(135deg, #87CEFA, #40E0D0);
            padding: 1.5rem;
            border-radius: 8px;
            text-align: right;
            font-size: 1.5rem;
            color: var(--color-light);
            margin: 2rem 0;
            box-shadow: var(--shadow-md);
            font-family: var(--font-heading);
        }
        .total-price .amount {
            font-weight: bold;
            font-size: 1.8rem;
        }
        .btn-reservar {
            width: 100%;
            padding: 1rem;
            background: var(--color-coral);
            color: var(--color-light);
            border: none;
            border-radius: 8px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: var(--shadow-md);
            font-family: var(--font-body);
        }
        .btn-reservar:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            background: var(--color-coral);
            filter: brightness(1.1);
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            overflow-y: auto;
        }
        .modal-content {
            background: white;
            width: 98%;
            max-width: 1400px;
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            padding: 2rem;
            position: relative;
            margin: 0.5rem auto;
            animation: fadeIn 0.3s ease;
            height: auto;
            max-height: 98vh;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .modal-content h2 {
            color: var(--color-primary);
            margin-bottom: 1.5rem;
            text-align: center;
            font-size: 2rem;
            font-family: var(--font-heading);
            position: relative;
            padding-bottom: 0.8rem;
        }
        .modal-content h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: var(--gradient-primary);
            border-radius: 2px;
        }
        .terminos-contenido {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            padding: 0 1rem;
        }
        .seccion-terminos {
            background: var(--background-color);
            padding: 1.5rem;
            border-radius: 12px;
        }
        .seccion-terminos h3 {
            color: var(--color-primary);
            margin-bottom: 1.2rem;
            font-size: 1.4rem;
            font-family: var(--font-heading);
            border-bottom: 2px solid var(--color-secondary);
            padding-bottom: 0.5rem;
        }
        .seccion-terminos ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }
        .seccion-terminos li {
            display: flex;
            align-items: center;
            color: var(--color-text);
            background: white;
            padding: 0.8rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        .seccion-terminos li:hover {
            transform: translateX(5px);
            background: var(--color-secondary);
            color: white;
        }
        .seccion-terminos li i {
            margin-right: 0.8rem;
            color: var(--color-primary);
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }
        .seccion-terminos li:hover i {
            color: white;
        }
        .terminos-acciones {
            background-color: var(--background-color);
            padding: 1.2rem;
            border-radius: 8px;
            margin-top: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            cursor: pointer;
            user-select: none;
            color: var(--color-text);
            font-weight: 500;
            padding: 0.8rem;
            border-radius: 6px;
            transition: background-color 0.3s ease;
            font-size: 1.1rem;
        }
        .checkbox-container:hover {
            background-color: var(--color-secondary);
            color: white;
        }
        .botones {
            display: flex;
            gap: 1rem;
        }
        .btn-cancelar,
        .btn-confirmar {
            padding: 0.8rem 2rem;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            min-width: 150px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-cancelar {
            border: 2px solid var(--color-secondary);
            background: transparent;
            color: var(--color-text);
        }
        .btn-confirmar {
            border: none;
            background: var(--gradient-primary);
            color: white;
        }
        .btn-confirmar:disabled {
            background: #ccc;
            cursor: not-allowed;
            opacity: 0.7;
        }
        .btn-cancelar:hover {
            background: var(--color-secondary);
            color: white;
            transform: translateY(-2px);
        }
        .btn-confirmar:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        @media (max-width: 1200px) {
            .seccion-terminos ul {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            .modal-content {
                padding: 1rem;
                width: 95%;
            }
            .seccion-terminos {
                padding: 1rem;
            }
            .seccion-terminos ul {
                grid-template-columns: 1fr;
            }
            .terminos-acciones {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            .botones {
                width: 100%;
                flex-direction: column;
            }
            .btn-cancelar,
            .btn-confirmar {
                width: 100%;
            }
        }
        .date-wrapper {
            position: relative;
            width: 100%;
            cursor: pointer;
        }
        
        .date-wrapper input[type="date"] {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #87CEFA;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: white;
            color: var(--color-text);
            cursor: pointer;
            font-family: var(--font-body);
        }

        .date-wrapper:hover input[type="date"] {
            border-color: var(--color-primary);
            background-color: rgba(135, 206, 250, 0.1);
        }

        .date-wrapper input[type="date"]:focus {
            border-color: var(--color-secondary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(64, 224, 208, 0.2);
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
            <img src="<?php echo htmlspecialchars($tour['imagen_url']); ?>" alt="<?php echo htmlspecialchars($tour['nombre'], ENT_QUOTES, 'UTF-8'); ?>" class="tour-image">
            <div class="tour-details">
                <h1><?php echo htmlspecialchars($tour['nombre'], ENT_QUOTES, 'UTF-8'); ?></h1>
                <p><?php echo htmlspecialchars($tour['descripcion'], ENT_QUOTES, 'UTF-8'); ?></p>
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
                <div class="date-wrapper" onclick="document.getElementById('fecha_reserva').showPicker()">
                    <input type="date" id="fecha_reserva" name="fecha_reserva" required 
                           min="<?php echo $min_date; ?>" 
                           max="<?php echo $max_date; ?>">
                </div>
            </div>

            <div class="form-group special-select">
                <label for="horario">Horario:</label>
                <select id="horario" name="horario" required>
                    <option value="">Seleccionar horario</option>
                    <option value="08:00:00">8:00 AM</option>
                    <option value="14:00:00">2:00 PM</option>
                </select>
            </div>

            <div class="form-group special-select">
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
            <button type="button" class="btn-reservar" onclick="mostrarTerminos()">Reservar Ahora</button>

            <!-- Modal de Términos y Condiciones -->
            <div id="modal-terminos" class="modal">
                <div class="modal-content">
                    <h2>Términos y Condiciones de Reserva</h2>
                    
                    <div class="terminos-contenido">
                        <h3>Información de Pago</h3>
                        <ul>
                            <li><i class="fas fa-money-bill"></i> El pago se realiza únicamente en efectivo.</li>
                            <li><i class="fas fa-clock"></i> El pago debe realizarse completo antes de iniciar el viaje.</li>
                            <li><i class="fas fa-bus"></i> El punto de encuentro será confirmado por correo electrónico.</li>
                        </ul>

                        <h3>Políticas de Reserva</h3>
                        <ul>
                            <li><i class="fas fa-calendar-alt"></i> La reserva debe ser cancelada con al menos 24 horas de anticipación para recibir un reembolso.</li>
                            <li><i class="fas fa-users"></i> Los menores de edad deben ir acompañados por un adulto responsable.</li>
                            <li><i class="fas fa-clock"></i> Se requiere llegar 15 minutos antes de la hora programada.</li>
                        </ul>

                        <h3>Durante el Tour</h3>
                        <ul>
                            <li><i class="fas fa-suitcase"></i> Se permite una maleta mediana por persona.</li>
                            <li><i class="fas fa-camera"></i> Está permitido tomar fotografías durante el recorrido.</li>
                            <li><i class="fas fa-ban"></i> No se permite el consumo de alcohol o sustancias prohibidas.</li>
                        </ul>

                        <h3>Responsabilidades</h3>
                        <ul>
                            <li><i class="fas fa-shield-alt"></i> La empresa no se hace responsable por objetos perdidos o daños personales.</li>
                            <li><i class="fas fa-exclamation-triangle"></i> Los pasajeros deben seguir las instrucciones del guía en todo momento.</li>
                            <li><i class="fas fa-heart"></i> Nos reservamos el derecho de modificar el itinerario por condiciones climáticas o seguridad.</li>
                        </ul>
                    </div>

                    <div class="terminos-acciones">
                        <label class="checkbox-container">
                            <input type="checkbox" id="aceptar-terminos" required>
                            <span class="checkmark"></span>
                            He leído y acepto los términos y condiciones
                        </label>
                        <div class="botones">
                            <button type="button" class="btn-cancelar" onclick="cerrarTerminos()">Cancelar</button>
                            <button type="button" class="btn-confirmar" onclick="confirmarReserva()" disabled>Confirmar Reserva</button>
                        </div>
                    </div>
                </div>
            </div>
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

    function mostrarTerminos() {
        // Verificar si se ha seleccionado un bus y número de personas
        const busSeleccionado = document.querySelector('input[name="tipo_bus"]:checked');
        const numeroPersonas = document.getElementById('numero_personas').value;

        if (!busSeleccionado || !numeroPersonas) {
            alert('Por favor, seleccione un bus y el número de personas antes de continuar.');
            return;
        }

        document.getElementById('modal-terminos').style.display = 'block';
        document.body.style.overflow = 'hidden'; // Prevenir scroll en el fondo
    }

    function cerrarTerminos() {
        document.getElementById('modal-terminos').style.display = 'none';
        document.body.style.overflow = 'auto';
        document.getElementById('aceptar-terminos').checked = false;
    }

    function confirmarReserva() {
        if (document.getElementById('aceptar-terminos').checked) {
            // Verificar que todos los campos necesarios estén completos
            const fecha = document.getElementById('fecha_reserva').value;
            const horario = document.getElementById('horario').value;
            const numeroPersonas = document.getElementById('numero_personas').value;
            const tipoBus = document.querySelector('input[name="tipo_bus"]:checked');

            if (!fecha || !horario || !numeroPersonas || !tipoBus) {
                alert('Por favor, complete todos los campos antes de continuar.');
                return;
            }

            document.querySelector('form').submit();
        }
    }

    // Habilitar/deshabilitar botón de confirmar según checkbox
    document.getElementById('aceptar-terminos').addEventListener('change', function() {
        document.querySelector('.btn-confirmar').disabled = !this.checked;
    });

    // Cerrar modal si se hace clic fuera del contenido
    window.onclick = function(event) {
        const modal = document.getElementById('modal-terminos');
        if (event.target == modal) {
            cerrarTerminos();
        }
    }
    </script>

    <?php include '../templates/footer.php'; ?>
</body>
</html> 