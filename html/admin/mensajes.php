<?php
session_start();

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['user_id']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: /cielotico/html/login.php');
    exit();
}

// Incluir la conexión a la base de datos
require_once '../../php/config/database.php';
require_once '../../php/classes/Mailer.php';

// Procesar acciones
if (isset($_POST['action']) && isset($_POST['mensaje_id'])) {
    $mensaje_id = filter_var($_POST['mensaje_id'], FILTER_VALIDATE_INT);
    
    if ($mensaje_id) {
        try {
            switch ($_POST['action']) {
                case 'marcar_leido':
                    $stmt = $conn->prepare("UPDATE contactos SET estado = 'leido' WHERE id = ?");
                    $stmt->execute([$mensaje_id]);
                    $_SESSION['success'] = 'Mensaje marcado como leído';
                    break;
                case 'marcar_respondido':
                    $stmt = $conn->prepare("UPDATE contactos SET estado = 'respondido' WHERE id = ?");
                    $stmt->execute([$mensaje_id]);
                    $_SESSION['success'] = 'Mensaje marcado como respondido';
                    break;
                case 'responder':
                    $respuesta = trim($_POST['respuesta']);
                    if (empty($respuesta)) {
                        throw new Exception('La respuesta no puede estar vacía');
                    }

                    // Obtener detalles del mensaje
                    $stmt = $conn->prepare("SELECT * FROM contactos WHERE id = ?");
                    $stmt->execute([$mensaje_id]);
                    $mensaje = $stmt->fetch();

                    if (!$mensaje) {
                        throw new Exception('Mensaje no encontrado');
                    }

                    // Enviar correo
                    $mailer = new Mailer();
                    $enviado = $mailer->enviarRespuestaContacto(
                        $mensaje['email'],
                        $mensaje['nombre'],
                        'Re: Mensaje de contacto - Cielo Tico',
                        $mensaje['mensaje'],
                        $respuesta
                    );

                    if ($enviado) {
                        // Actualizar estado del mensaje
                        $stmt = $conn->prepare("UPDATE contactos SET estado = 'respondido' WHERE id = ?");
                        $stmt->execute([$mensaje_id]);
                        $_SESSION['success'] = 'Respuesta enviada correctamente';
                    } else {
                        throw new Exception('Error al enviar la respuesta por correo');
                    }
                    break;
            }
        } catch(Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Obtener filtro de estado
$estado_filtro = isset($_GET['estado']) ? $_GET['estado'] : 'todos';

// Construir consulta SQL base
$sql = "SELECT * FROM contactos";
$params = [];

if ($estado_filtro !== 'todos') {
    $sql .= " WHERE estado = ?";
    $params[] = $estado_filtro;
}

$sql .= " ORDER BY fecha_creacion DESC";

// Obtener mensajes
try {
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $error = "Error al obtener los mensajes: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes de Contacto - Cielo Tico</title>
    <link rel="icon" type="image/png" href="/cielotico/img/logo.png" />
    <link rel="stylesheet" href="/cielotico/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        .admin-container {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1rem;
            background-color: #f5f5f5;
            border-radius: 8px;
        }
        .filtros {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .filtro-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            background-color: #f0f0f0;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .filtro-btn.activo {
            background-color: #FF7F50;
            color: white;
        }
        .mensajes-grid {
            display: grid;
            gap: 1.5rem;
        }
        .mensaje-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .mensaje-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }
        .mensaje-info h3 {
            margin: 0;
            color: #333;
        }
        .mensaje-meta {
            color: #666;
            font-size: 0.9rem;
            margin: 0.5rem 0;
        }
        .mensaje-estado {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .estado-nuevo {
            background-color: #ff7f50;
            color: white;
        }
        .estado-leido {
            background-color: #4CAF50;
            color: white;
        }
        .estado-respondido {
            background-color: #2196F3;
            color: white;
        }
        .mensaje-contenido {
            margin: 1rem 0;
            color: #444;
            line-height: 1.6;
        }
        .mensaje-acciones {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        .btn-accion {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }
        .btn-leido {
            background-color: #4CAF50;
            color: white;
        }
        .btn-respondido {
            background-color: #2196F3;
            color: white;
        }
        .btn-accion:hover {
            opacity: 0.9;
        }
        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo-container">
                <a href="/cielotico/html/index.php">
                    <img src="/cielotico/img/logo.png" alt="Cielo Tico Logo" class="logo">
                    <h1>Cielo Tico</h1>
                </a>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Panel Admin</a></li>
                    <li><a href="/cielotico/html/index.php">Volver al Sitio</a></li>
                    <li><a href="/cielotico/php/logout.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="admin-container">
            <div class="admin-header">
                <h1>Mensajes de Contacto</h1>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>

            <div class="filtros">
                <a href="?estado=todos" class="filtro-btn <?php echo $estado_filtro === 'todos' ? 'activo' : ''; ?>">
                    Todos
                </a>
                <a href="?estado=nuevo" class="filtro-btn <?php echo $estado_filtro === 'nuevo' ? 'activo' : ''; ?>">
                    Nuevos
                </a>
                <a href="?estado=leido" class="filtro-btn <?php echo $estado_filtro === 'leido' ? 'activo' : ''; ?>">
                    Leídos
                </a>
                <a href="?estado=respondido" class="filtro-btn <?php echo $estado_filtro === 'respondido' ? 'activo' : ''; ?>">
                    Respondidos
                </a>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php else: ?>
                <div class="mensajes-grid">
                    <?php foreach ($mensajes as $mensaje): ?>
                        <div class="mensaje-card">
                            <div class="mensaje-header">
                                <div class="mensaje-info">
                                    <h3><?php echo htmlspecialchars($mensaje['nombre']); ?></h3>
                                    <p class="mensaje-meta">
                                        <i class="fas fa-envelope"></i> <?php echo htmlspecialchars($mensaje['email']); ?>
                                        <?php if (!empty($mensaje['telefono'])): ?>
                                            <br>
                                            <i class="fas fa-phone"></i> <?php echo htmlspecialchars($mensaje['telefono']); ?>
                                        <?php endif; ?>
                                        <br>
                                        <i class="fas fa-clock"></i> <?php echo date('d/m/Y H:i', strtotime($mensaje['fecha_creacion'])); ?>
                                    </p>
                                </div>
                                <span class="mensaje-estado estado-<?php echo $mensaje['estado']; ?>">
                                    <?php echo ucfirst($mensaje['estado']); ?>
                                </span>
                            </div>
                            
                            <div class="mensaje-contenido">
                                <?php echo nl2br(htmlspecialchars($mensaje['mensaje'])); ?>
                            </div>

                            <div class="mensaje-acciones">
                                <?php if ($mensaje['estado'] === 'nuevo'): ?>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="mensaje_id" value="<?php echo $mensaje['id']; ?>">
                                        <input type="hidden" name="action" value="marcar_leido">
                                        <button type="submit" class="btn-accion btn-leido">
                                            <i class="fas fa-check"></i> Marcar como Leído
                                        </button>
                                    </form>
                                <?php endif; ?>
                                
                                <?php if ($mensaje['estado'] !== 'respondido'): ?>
                                    <button type="button" class="btn-accion btn-respondido" 
                                            onclick="mostrarFormularioRespuesta('<?php echo $mensaje['id']; ?>')">
                                        <i class="fas fa-reply"></i> Responder
                                    </button>
                                <?php endif; ?>
                            </div>

                            <!-- Formulario de respuesta (oculto por defecto) -->
                            <div id="form-respuesta-<?php echo $mensaje['id']; ?>" class="form-respuesta" style="display: none; margin-top: 1rem;">
                                <form method="POST">
                                    <input type="hidden" name="mensaje_id" value="<?php echo $mensaje['id']; ?>">
                                    <input type="hidden" name="action" value="responder">
                                    <textarea name="respuesta" class="respuesta-textarea" 
                                              placeholder="Escribe tu respuesta aquí..." 
                                              style="width: 100%; min-height: 100px; padding: 0.5rem; margin-bottom: 0.5rem;"></textarea>
                                    <button type="submit" class="btn-accion btn-respondido">
                                        <i class="fas fa-paper-plane"></i> Enviar Respuesta
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php if (empty($mensajes)): ?>
                        <p>No hay mensajes para mostrar.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script>
    function mostrarFormularioRespuesta(mensajeId) {
        const form = document.getElementById('form-respuesta-' + mensajeId);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
    </script>

    <footer role="contentinfo">
        <div class="footer-content">
            <p>&copy; 2025 Cielo Tico - Panel de Administración</p>
        </div>
    </footer>
</body>
</html> 