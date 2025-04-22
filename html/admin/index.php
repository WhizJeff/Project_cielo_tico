<?php
session_start();

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['user_id']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: /cielotico/html/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Cielo Tico</title>
    <link rel="icon" type="image/png" href="/cielotico/assets/img/logo.png" />
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
            margin-bottom: 1.5rem;
        }
        .admin-card a {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #FF7F50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            font-weight: 500;
        }
        .admin-card a:hover {
            background-color: #FF6B3D;
        }
        .admin-card i {
            font-size: 2rem;
            color: #FF7F50;
            margin-bottom: 1rem;
            display: block;
        }
        .welcome-message {
            font-size: 1.1rem;
            color: #666;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo-container">
                <a href="/cielotico/html/index.php">
                    <img src="/cielotico/assets/img/logo.png" alt="Cielo Tico Logo" class="logo">
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
                <p class="welcome-message">Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></p>
            </div>
            
            <div class="admin-grid">
                <div class="admin-card">
                    <i class="fas fa-users"></i>
                    <h3>Gestionar Usuarios</h3>
                    <p>Administrar usuarios registrados en el sistema</p>
                    <a href="usuarios.php">Gestionar</a>
                </div>
                
                <div class="admin-card">
                    <i class="fas fa-map-marked-alt"></i>
                    <h3>Gestionar Tours</h3>
                    <p>Administrar tours y servicios disponibles</p>
                    <a href="tours.php">Gestionar</a>
                </div>
                
                <div class="admin-card">
                    <i class="fas fa-calendar-check"></i>
                    <h3>Gestionar Reservas</h3>
                    <p>Ver y administrar las reservas de tours</p>
                    <a href="reservas.php">Gestionar</a>
                </div>
                
                <div class="admin-card">
                    <i class="fas fa-envelope"></i>
                    <h3>Mensajes de Contacto</h3>
                    <p>Ver mensajes recibidos del formulario de contacto</p>
                    <a href="mensajes.php">Ver Mensajes</a>
                </div>
            </div>
        </div>
    </main>

    <footer role="contentinfo">
        <div class="footer-content">
            <p>&copy; 2025 Cielo Tico - Panel de Administración</p>
        </div>
    </footer>
</body>
</html> 