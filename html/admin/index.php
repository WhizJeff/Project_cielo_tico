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
            padding: 2.5rem;
            background: white;
            border-radius: 12px;
            text-align: center;
            border: 3px solid #40E0D0;
            box-shadow: 0 4px 15px rgba(64, 224, 208, 0.15);
        }
        .admin-header h1 {
            color: #000000;
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.5rem;
        }
        .admin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .admin-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            text-align: center;
        }
        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        .admin-card h3 {
            color: #333;
            margin: 1rem 0;
            font-size: 1.5rem;
            font-weight: 600;
        }
        .admin-card p {
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        .admin-card a {
            display: inline-block;
            padding: 0.75rem 2rem;
            background-color: #40E0D0;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s ease;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }
        .admin-card a:hover {
            background-color: #20B2AA;
            transform: scale(1.05);
        }
        .admin-card i {
            font-size: 2.5rem;
            color: #40E0D0;
            margin-bottom: 1rem;
            display: block;
            transition: all 0.3s ease;
        }
        .admin-card:hover i {
            transform: scale(1.1);
        }
        .welcome-message {
            font-size: 1.2rem;
            color: #666;
            margin-top: 0.5rem;
            font-weight: 300;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo-container" style="display: flex; align-items: center;">
                <img src="/cielotico/~assets/logo/logo_ctt.png" alt="Cielo Tico Logo" style="width: 60px; height: 60px; margin-right: 15px;">
                <span style="color: white; font-size: 32px; font-weight: bold;">Cielo Tico</span>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Panel de Control</a></li>
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