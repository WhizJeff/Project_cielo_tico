<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contacta con Cielo Tico - Reserva tu viaje o solicita información">
    <meta name="author" content="Cielo Tico">
    <title>Contacto - Cielo Tico</title>
    <link rel="icon" type="image/png" href="../img/logo.png" />
    <link rel="stylesheet" href="/cielotico/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="../js/script.js" defer></script>
    <style>
        .user-menu {
            position: relative;
            display: inline-block;
        }
        .user-toggle {
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
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .user-toggle:hover {
            color: #FF7F50;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }
        .user-dropdown {
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
            list-style: none;
            padding: 0;
        }
        .user-menu.active .user-dropdown {
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
        .user-dropdown a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
            font-family: 'Montserrat', sans-serif;
        }
        .user-dropdown a:hover {
            background-color: #FF6B3D;
        }
        .user-dropdown li:first-child a {
            border-radius: 4px 4px 0 0;
        }
        .user-dropdown li:last-child a {
            border-radius: 0 0 4px 4px;
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
            <button class="menu-toggle" aria-label="Menú">
                <i class="fas fa-bars"></i>
            </button>
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
        <section id="contacto">
            <div class="contacto-container">
                <div class="contacto-info">
                    <h3>Información de Contacto</h3>
                    <div class="contacto-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>San José, Costa Rica<br>Avenida Central, Calle 5</p>
                    </div>
                    <div class="contacto-item">
                        <i class="fas fa-phone"></i>
                        <p>+506 2222-2222<br>+506 8888-8888</p>
                    </div>
                    <div class="contacto-item">
                        <i class="fas fa-envelope"></i>
                        <p>info@cielotico.com<br>reservas@cielotico.com</p>
                    </div>
                    <div class="redes-sociales">
                        <h3>Síguenos en Redes</h3>
                        <div class="social-icons">
                            <a href="https://instagram.com/cieloticotours" aria-label="Síguenos en Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="https://facebook.com/cieloticocr" aria-label="Síguenos en Facebook"><i class="fab fa-facebook"></i></a>
                            <a href="https://tiktok.com/@vivecielotico" aria-label="Síguenos en TikTok"><i class="fab fa-tiktok"></i></a>
                            <a href="https://youtube.com/CieloTicoAventuras" aria-label="Síguenos en YouTube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="formulario-contacto">
                    <h3>Envíanos un Mensaje</h3>
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-error">
                            <?php 
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?php 
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                            ?>
                        </div>
                    <?php endif; ?>
                    <form action="/cielotico/php/procesar_contacto.php" method="POST">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="tel" id="telefono" name="telefono">
                        </div>
                        <div class="form-group">
                            <label for="mensaje">Mensaje</label>
                            <textarea id="mensaje" name="mensaje" rows="5" required maxlength="150"></textarea>
                            <small>Máximo 150 caracteres</small>
                        </div>
                        <button type="submit" class="btn-primary">Enviar Mensaje</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer role="contentinfo">
        <div class="footer-content" style="text-align: center;">
            <h3 style="font-size: 2rem; margin-bottom: 1.5rem; color: white; font-weight: normal; font-family: 'Ubuntu', sans-serif;">Enlaces útiles:</h3>
            <div style="display: flex; justify-content: center; align-items: center; gap: 3rem; margin: 1rem auto;">
                <a href="preguntas-frecuentes.php" aria-label="Preguntas Frecuentes" style="font-size: 2rem; color: white;"><i class="fas fa-question-circle"></i></a>
                <a href="terminos-condiciones.php" aria-label="Términos y Condiciones" style="font-size: 2rem; color: white;"><i class="fas fa-file-contract"></i></a>
                <a href="politica-privacidad.php" aria-label="Política de Privacidad" style="font-size: 2rem; color: white;"><i class="fas fa-shield-alt"></i></a>
            </div>
            <p style="font-size: 0.875rem; color: white; margin-top: 1.5rem; font-family: 'Ubuntu', sans-serif;">&copy; 2025 Cielo Tico. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="../js/main.js"></script>
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