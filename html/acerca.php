<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Conoce la historia y valores de Cielo Tico - Tu mejor opción para viajar por Costa Rica">
    <meta name="author" content="Cielo Tico">
    <title>Acerca de - Cielo Tico</title>
    <link rel="icon" type="image/png" href="../img/logo.png" />
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        .user-menu {
            position: relative;
            display: inline-block;
        }
        .user-menu-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #FF7F50;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1000;
            border-radius: 4px;
            top: 100%;
            margin-top: 5px;
        }
        .user-menu-button {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .user-menu-button:hover {
            color: #FF7F50;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }
        .user-menu.active .user-menu-content {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .user-menu-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
            font-family: 'Montserrat', sans-serif;
        }
        .user-menu-content a:hover {
            background-color: #FF6B3D;
        }
        .user-info {
            padding: 12px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            color: white;
            font-family: 'Montserrat', sans-serif;
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: rgba(0, 0, 0, 0.1);
        }
        .user-info i {
            margin-right: 8px;
        }
    </style>
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
                    <li><a href="acerca.php">Acerca de</a></li>
                    <li><a href="servicios.php">Servicios</a></li>
                    <li><a href="ubicacion.php">Ubicación</a></li>
                    <li><a href="contacto.php">Contacto</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
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
                        <li><a href="login.php" class="btn-login">Iniciar Sesión</a></li>
                        <li><a href="registro.php" class="btn-register">Registro</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="about-section">
            <div class="container">
                <h2>Nuestra Historia</h2>
                <div class="history-content">
                    <div class="imagen-historia">
                        <img src="../img/about/historia.jpg" alt="Historia de Cielo Tico - Nuestro primer bus" loading="lazy">
                    </div>
                    <div class="texto-historia">
                        <h3>Historia de Cielo Tico - Nuestro primer bus</h3>
                        <p>Desde 2010, Cielo Tico ha sido sinónimo de excelencia en el transporte turístico en Costa Rica. Nacimos con la visión de ofrecer una experiencia de viaje única, combinando comodidad, seguridad y el espíritu aventurero que caracteriza a nuestro país.</p>
                        <p>Lo que comenzó como una pequeña empresa familiar ha crecido hasta convertirse en una de las compañías más confiables del sector turístico costarricense, sirviendo a miles de visitantes nacionales e internacionales.</p>
                    </div>
                </div>

                <div class="mission-vision">
                    <div class="mission">
                        <h3>Nuestra Misión</h3>
                        <p>Proporcionar un servicio de transporte turístico de alta calidad, seguro y confortable, que permita a nuestros clientes disfrutar de la belleza natural de Costa Rica mientras viajan.</p>
                        <img src="../img/about/mision.jpg" alt="Misión - Servicio de calidad" loading="lazy">
                    </div>

                    <div class="vision">
                        <h3>Nuestra Visión</h3>
                        <p>Ser la empresa líder en transporte turístico en Costa Rica, reconocida por nuestra excelencia en el servicio, compromiso con la sostenibilidad y la satisfacción de nuestros clientes.</p>
                        <img src="../img/about/vision.jpg" alt="Visión - Liderazgo en transporte turístico" loading="lazy">
                    </div>
                </div>

                <div class="values">
                    <h3>Nuestros Valores</h3>
                    <div class="values-grid">
                        <div class="value-card">
                            <i class="fas fa-shield-alt"></i>
                            <h4>Seguridad</h4>
                            <p>La seguridad de nuestros pasajeros es nuestra prioridad número uno.</p>
                        </div>
                        <div class="value-card">
                            <i class="fas fa-heart"></i>
                            <h4>Compromiso</h4>
                            <p>Nos dedicamos a brindar el mejor servicio a nuestros clientes.</p>
                        </div>
                        <div class="value-card">
                            <i class="fas fa-leaf"></i>
                            <h4>Sostenibilidad</h4>
                            <p>Nos comprometemos con el medio ambiente y el turismo responsable.</p>
                        </div>
                        <div class="value-card">
                            <i class="fas fa-handshake"></i>
                            <h4>Confianza</h4>
                            <p>Construimos relaciones duraderas basadas en la confianza mutua.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer role="contentinfo">
        <div class="footer-content">
            <div class="redes-sociales">
                <h3>Síguenos en redes sociales:</h3>
                <ul>
                    <li><a href="https://instagram.com/cieloticotours" aria-label="Síguenos en Instagram"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="https://facebook.com/cieloticocr" aria-label="Síguenos en Facebook"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="https://tiktok.com/@vivecielotico" aria-label="Síguenos en TikTok"><i class="fab fa-tiktok"></i></a></li>
                    <li><a href="https://youtube.com/CieloTicoAventuras" aria-label="Síguenos en YouTube"><i class="fab fa-youtube"></i></a></li>
                </ul>
            </div>
            <p>&copy; 2025 Cielo Tico. Todos los derechos reservados.</p>
        </div>
    </footer>
    <script src="../js/script.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const userToggle = document.querySelector('.user-toggle');
        const userMenu = document.querySelector('.user-menu');

        if (userToggle && userMenu) {
            userToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                userMenu.classList.toggle('active');
            });

            // Cerrar el menú cuando se hace clic fuera de él
            document.addEventListener('click', function(e) {
                if (!userMenu.contains(e.target)) {
                    userMenu.classList.remove('active');
                }
            });

            // Cerrar el menú con la tecla ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && userMenu.classList.contains('active')) {
                    userMenu.classList.remove('active');
                }
            });
        }
    });
    </script>
</body>
</html> 