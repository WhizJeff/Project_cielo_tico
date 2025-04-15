<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página no encontrada - Cielo Tico">
    <meta name="author" content="Cielo Tico">
    <title>Página no encontrada - Cielo Tico</title>
    <link rel="icon" type="image/png" href="../img/logo.png" />
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="logo-container">
            <a href="index.php">
                <img src="../img/logo.png" alt="Cielo Tico Logo" class="logo">
                <h1>Cielo Tico</h1>
            </a>
        </div>
        <nav>
            <ul class="nav-menu">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="acerca.php">Acerca de</a></li>
                <li><a href="servicios.php">Servicios</a></li>
                <li><a href="ubicacion.php">Ubicación</a></li>
                <li><a href="contacto.php">Contacto</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="user-menu">
                        <button class="user-menu-btn">
                            <i class="fas fa-user"></i>
                            <i class="fas fa-bars"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><span><?php echo $_SESSION['nombre']; ?></span></li>
                            <li><a href="perfil.php">Mi Perfil</a></li>
                            <li><a href="../php/logout.php">Cerrar Sesión</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><a href="login.php">Iniciar Sesión</a></li>
                    <li><a href="registro.php">Registro</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <button class="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
    </header>

    <main>
        <section id="error-404" class="section">
            <div class="error-container">
                <h2>404</h2>
                <h3>¡Oops! Página no encontrada</h3>
                <p>Lo sentimos, la página que estás buscando no existe o ha sido movida.</p>
                <div class="error-actions">
                    <a href="index.php" class="btn-primary">
                        <i class="fas fa-home"></i> Volver al Inicio
                    </a>
                    <a href="contacto.php" class="btn-secondary">
                        <i class="fas fa-envelope"></i> Contáctanos
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="redes-sociales">
                <h3>Síguenos en redes sociales:</h3>
                <ul>
                    <li><a href="https://instagram.com/cieloticotours" aria-label="Síguenos en Instagram"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="https://facebook.com/cieloticocr" aria-label="Síguenos en Facebook"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="https://tiktok.com/@vivecielotico" aria-label="Síguenos en TikTok"><i class="fab fa-tiktok"></i></a></li>
                    <li><a href="https://youtube.com/CieloTicoAventuras" aria-label="Síguenos en YouTube"><i class="fab fa-youtube"></i></a></li>
                </ul>
                <p>&copy; 2025 Cielo Tico. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="../js/main.js"></script>
</body>
</html> 