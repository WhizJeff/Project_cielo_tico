<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contacta con Cielo Tico - Estamos aquí para ayudarte">
    <meta name="author" content="Cielo Tico">
    <title>Contacto - Cielo Tico</title>
    <link rel="icon" type="image/png" href="../img/logo.png" />
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="../js/script.js" defer></script>
    <style>
        .contact-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 2rem;
            margin-top: 1rem;
        }

        .info-section {
            background: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .info-section:hover {
            border-color: var(--color-primary);
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .info-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        .info-title i {
            font-size: 1.5rem;
            color: var(--color-primary);
        }

        .info-title h2 {
            font-size: 1.25rem;
            color: #333333;
            margin: 0;
            font-weight: 500;
        }

        .info-content {
            color: #666666;
        }

        .info-content p {
            margin: 0.5rem 0;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .social-links {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #666666;
            text-decoration: none;
            padding: 0.5rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background-color: var(--color-primary);
            color: white;
        }

        .social-link i {
            font-size: 1.2rem;
        }

        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group label {
            color: #333333;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea {
            padding: 0.75rem;
            border: 2px solid #e0e0e0;
            border-radius: 4px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: var(--color-primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 127, 80, 0.1);
        }

        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }

        .btn-enviar {
            background: var(--color-primary);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            align-self: flex-start;
        }

        .btn-enviar:hover {
            background: #FF6B3D;
            transform: translateY(-2px);
        }

        @media (max-width: 992px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .social-links {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .contact-container {
                padding: 1rem;
            }
            
            .info-section {
                padding: 1.5rem;
            }

            .social-links {
                grid-template-columns: 1fr;
            }

            .btn-enviar {
                width: 100%;
            }
        }

        .user-menu {
            position: relative;
            display: inline-block;
        }
        .user-toggle {
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Montserrat', sans-serif;
            font-size: 16px;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }
        .user-toggle:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }
        .user-toggle i {
            font-size: 18px;
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
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="acerca.php">Acerca de</a></li>
                    <li><a href="servicios.php">Servicios</a></li>
                    <li><a href="ubicacion.php">Ubicación</a></li>
                    <li><a href="contacto.php">Contacto</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="user-menu">
                            <button type="button" class="user-toggle">
                                <i class="fas fa-user"></i>
                                <?php echo $_SESSION['nombre']; ?>
                                <i class="fas fa-chevron-down"></i>
                            </button>
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

    <div class="contact-container">
        <div class="info-grid">
            <div class="info-section">
                <div class="info-title">
                    <i class="fas fa-address-book"></i>
                    <h2>Información de Contacto</h2>
                </div>
                <div class="info-content">
                    <p><i class="fas fa-map-marker-alt"></i> Centro Comercial Plaza del Sol, Local #15</p>
                    <p><i class="fas fa-phone"></i> +506 2222-2222</p>
                    <p><i class="fas fa-mobile-alt"></i> +506 8888-8888</p>
                    <p><i class="fas fa-envelope"></i> info@cielotico.com</p>

                    <div class="info-title" style="margin-top: 2rem;">
                        <i class="fas fa-share-alt"></i>
                        <h2>Síguenos en Redes</h2>
                    </div>
                    <div class="social-links">
                        <a href="https://instagram.com/cieloticotours" class="social-link">
                            <i class="fab fa-instagram"></i>
                            <span>Instagram</span>
                        </a>
                        <a href="https://facebook.com/cieloticocr" class="social-link">
                            <i class="fab fa-facebook"></i>
                            <span>Facebook</span>
                        </a>
                        <a href="https://tiktok.com/@vivecielotico" class="social-link">
                            <i class="fab fa-tiktok"></i>
                            <span>TikTok</span>
                        </a>
                        <a href="https://youtube.com/CieloTicoAventuras" class="social-link">
                            <i class="fab fa-youtube"></i>
                            <span>YouTube</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="info-section">
                <div class="info-title">
                    <i class="fas fa-paper-plane"></i>
                    <h2>Envíanos un Mensaje</h2>
                </div>
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
                
                <form action="/cielotico/php/procesar_contacto.php" method="POST" class="contact-form">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" required placeholder="Tu nombre completo">
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" required placeholder="tu@email.com">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel" id="telefono" name="telefono" placeholder="Tu número de teléfono">
                    </div>
                    <div class="form-group">
                        <label for="mensaje">Mensaje</label>
                        <textarea id="mensaje" name="mensaje" required placeholder="¿En qué podemos ayudarte?"></textarea>
                    </div>
                    <button type="submit" class="btn-enviar">
                        <i class="fas fa-paper-plane"></i> Enviar Mensaje
                    </button>
                </form>
            </div>
        </div>
    </div>

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
</body>
</html> 