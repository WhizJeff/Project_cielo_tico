<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>Cielo Tico</title>
    <link rel="icon" type="image/png" href="assets/img/logo.png" />
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="js/script.js" defer></script>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo-container">
                <a href="index.html">
                    <img src="assets/img/logo.png" alt="Cielo Tico Logo" class="logo">
                    <h1>Cielo Tico</h1>
                </a>
            </div>
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="acerca.html">Acerca de</a></li>
                    <li><a href="servicios.html">Servicios</a></li>
                    <li><a href="ubicacion.html">Ubicación</a></li>
                    <li><a href="contacto.html">Contacto</a></li>
                    <li><a href="login.php" class="btn-login">Iniciar Sesión</a></li>
                    <li><a href="registro.html" class="btn-register">Registro</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main> 