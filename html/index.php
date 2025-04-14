<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Cielo Tico</title>
    <link rel="icon" type="image/png" href="../img/logo.png">
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo-container">
                <a href="index.php">
                    <img src="../img/logo.png" alt="Cielo Tico Logo" class="logo">
                    <h1>Cielo Tico</h1>
                </a>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="acerca.html">Acerca de</a></li>
                    <li><a href="servicios.html">Servicios</a></li>
                    <li><a href="ubicacion.html">Ubicación</a></li>
                    <li><a href="contacto.html">Contacto</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li><span>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span></li>
                        <li><a href="../php/logout.php">Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li><a href="login.php" class="btn-login">Iniciar Sesión</a></li>
                        <li><a href="registro.html" class="btn-register">Registro</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <!-- Contenido de la página de inicio -->
    </main>

    <footer>
        <!-- Contenido del footer -->
    </footer>

    <script src="../js/script.js"></script>
</body>
</html> 