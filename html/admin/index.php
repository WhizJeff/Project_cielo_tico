<?php
session_start();

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['user_id']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: /cielotico/html/login.php');
    exit();
}

// Incluir la conexión a la base de datos
require_once '../../php/config/database.php';

// Obtener la lista de usuarios
try {
    $stmt = $conn->prepare("SELECT id, nombre, email, rol, fecha_registro FROM usuarios ORDER BY fecha_registro DESC");
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $error = "Error al obtener los usuarios: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Cielo Tico</title>
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
            margin-bottom: 2rem;
            padding: 1rem;
            background-color: #f5f5f5;
            border-radius: 8px;
        }
        .admin-header h1 {
            color: #333;
            margin: 0;
        }
        .admin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .admin-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .admin-card:hover {
            transform: translateY(-5px);
        }
        .admin-card h3 {
            color: #333;
            margin-top: 0;
        }
        .admin-card p {
            color: #666;
        }
        .admin-card a {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background-color: #FF7F50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .admin-card a:hover {
            background-color: #FF6B3D;
        }
        .users-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .users-table th,
        .users-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .users-table th {
            background-color: #f5f5f5;
            font-weight: 600;
            color: #333;
        }
        .users-table tr:last-child td {
            border-bottom: none;
        }
        .users-table tr:hover {
            background-color: #f9f9f9;
        }
        .user-actions {
            display: flex;
            gap: 0.5rem;
        }
        .btn-edit,
        .btn-delete {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            font-size: 0.875rem;
        }
        .btn-edit {
            background-color: #4CAF50;
        }
        .btn-delete {
            background-color: #f44336;
        }
        .btn-edit:hover {
            background-color: #45a049;
        }
        .btn-delete:hover {
            background-color: #da190b;
        }
        .section-title {
            margin: 2rem 0 1rem;
            color: #333;
            font-size: 1.5rem;
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
                    <li><a href="/cielotico/html/index.php">Volver al Sitio</a></li>
                    <li><a href="/cielotico/php/logout.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="admin-container">
            <div class="admin-header">
                <h1>Panel de Administración</h1>
                <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></p>
            </div>
            
            <div class="admin-grid">
                <div class="admin-card">
                    <h3>Gestionar Usuarios</h3>
                    <p>Administrar usuarios registrados en el sistema</p>
                    <a href="usuarios.php">Gestionar</a>
                </div>
                
                <div class="admin-card">
                    <h3>Gestionar Tours</h3>
                    <p>Administrar tours y servicios disponibles</p>
                    <a href="tours.php">Gestionar</a>
                </div>
                
                <div class="admin-card">
                    <h3>Gestionar Reservas</h3>
                    <p>Ver y administrar las reservas de tours</p>
                    <a href="reservas.php">Gestionar</a>
                </div>
                
                <div class="admin-card">
                    <h3>Mensajes de Contacto</h3>
                    <p>Ver mensajes recibidos del formulario de contacto</p>
                    <a href="mensajes.php">Ver Mensajes</a>
                </div>
            </div>

            <h2 class="section-title">Usuarios Registrados</h2>
            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php else: ?>
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Fecha de Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['fecha_registro']); ?></td>
                                <td class="user-actions">
                                    <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>" class="btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="eliminar_usuario.php?id=<?php echo $usuario['id']; ?>" class="btn-delete" 
                                       onclick="return confirm('¿Está seguro de que desea eliminar este usuario?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>

    <footer role="contentinfo">
        <div class="footer-content">
            <p>&copy; 2025 Cielo Tico - Panel de Administración</p>
        </div>
    </footer>
</body>
</html> 