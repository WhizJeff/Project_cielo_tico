<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>Cielo Tico</title>
    <link rel="icon" type="image/png" href="/cielotico/assets/img/logo.png" />
    <link rel="stylesheet" href="/cielotico/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="/cielotico/js/script.js" defer></script>
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
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <nav>
                <ul class="nav-menu">
                    <li><a href="/cielotico/html/index.php">Inicio</a></li>
                    <li><a href="/cielotico/html/acerca.php">Acerca de</a></li>
                    <li><a href="/cielotico/html/servicios.php">Servicios</a></li>
                    <li><a href="/cielotico/html/ubicacion.php">Ubicación</a></li>
                    <li><a href="/cielotico/html/contacto.php">Contacto</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="user-menu">
                            <a href="#" class="user-toggle">
                                <i class="fas fa-user"></i>
                                <?php echo htmlspecialchars($_SESSION['nombre']); ?>
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <ul class="user-dropdown">
                                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                                    <li><a href="/cielotico/html/admin/"><i class="fas fa-cog"></i> Administrator</a></li>
                                <?php endif; ?>
                                <li><a href="/cielotico/html/perfil.php"><i class="fas fa-user-circle"></i> Mi Perfil</a></li>
                                <li><a href="/cielotico/html/mis_reservas.php"><i class="fas fa-calendar-check"></i> Mis Reservas</a></li>
                                <li><a href="/cielotico/php/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a href="/cielotico/html/login.php" class="btn-login">Iniciar Sesión</a></li>
                        <li><a href="/cielotico/html/registro.php" class="btn-register">Registro</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main> 