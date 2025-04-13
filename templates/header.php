<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/auth.php';
$auth = new Auth();
$currentUser = $auth->getCurrentUser();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>Cielo Tico</title>
    <link rel="icon" type="image/png" href="<?php echo SITE_URL; ?>/assets/img/logo.png" />
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="<?php echo SITE_URL; ?>/js/script.js" defer></script>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo-container">
                <a href="<?php echo SITE_URL; ?>/">
                    <img src="<?php echo SITE_URL; ?>/assets/img/logo.png" alt="Cielo Tico Logo" class="logo">
                    <h1>Cielo Tico</h1>
                </a>
            </div>
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <nav>
                <ul class="nav-menu">
                    <li><a href="<?php echo SITE_URL; ?>/">Inicio</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/acerca.php">Acerca de</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/servicios.php">Servicios</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/ubicacion.php">Ubicación</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/contacto.php">Contacto</a></li>
                </ul>
                <div class="auth-buttons">
                    <?php if ($currentUser): ?>
                        <span class="user-name">Hola, <?php echo htmlspecialchars($currentUser['nombre']); ?></span>
                        <?php if ($currentUser['rol'] === 'admin'): ?>
                            <a href="<?php echo SITE_URL; ?>/admin/" class="btn-login">Panel Admin</a>
                        <?php endif; ?>
                        <a href="<?php echo SITE_URL; ?>/perfil.php" class="btn-login">Mi Perfil</a>
                        <a href="<?php echo SITE_URL; ?>/logout.php" class="btn-register">Cerrar Sesión</a>
                    <?php else: ?>
                        <a href="<?php echo SITE_URL; ?>/login.php" class="btn-login">Iniciar Sesión</a>
                        <a href="<?php echo SITE_URL; ?>/registro.php" class="btn-register">Registrarse</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>
    <main> 