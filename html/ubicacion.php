<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ubicación y contacto de Cielo Tico - Encuéntranos en San José, Costa Rica">
    <meta name="author" content="Cielo Tico">
    <title>Ubicación - Cielo Tico</title>
    <link rel="icon" type="image/png" href="../img/logo.png" />
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="../js/script.js" defer></script>
    <style>
        .location-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
        }

        .map-container {
            width: 100%;
            height: 400px;
            margin-bottom: 3rem;
            border-radius: 15px;
            overflow: hidden;
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .info-section {
            background: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border: 1px solid transparent;
            transition: all 0.3s ease;
            cursor: pointer;
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

        .info-content a {
            color: #666666;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0.5rem 0;
            font-size: 0.95rem;
            transition: color 0.3s ease;
            position: relative;
            padding-left: 12px;
        }

        .info-content a::before {
            content: "•";
            position: absolute;
            left: 0;
            color: var(--color-primary);
            transition: color 0.3s ease;
        }

        .info-content a:hover, 
        .transport-list li:hover {
            color: inherit;
        }

        .info-content a:hover::before,
        .transport-list li:hover::before {
            color: var(--color-primary);
        }

        .info-content a i {
            color: #FF7F50;
            width: 16px;
            font-size: 1rem;
        }

        .transport-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .transport-list li {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.8rem;
            color: #666666;
            font-size: 0.95rem;
            position: relative;
            padding-left: 12px;
            transition: color 0.3s ease;
        }

        .transport-list li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: var(--color-primary);
            transition: color 0.3s ease;
        }

        .transport-list li i {
            color: #FF7F50;
            width: 16px;
            font-size: 1rem;
        }

        @media (max-width: 992px) {
            .info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .info-section {
                padding: 1.5rem;
            }
        }

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
            outline: none;
        }
        .user-toggle:hover, .user-toggle:focus {
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
                                <?php echo htmlspecialchars($_SESSION['nombre']); ?>
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

    <div class="location-container">
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.8457157262584!2d-84.09099772414567!3d9.936499674057693!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa0e342c50d15c5%3A0xe6746a6a9f11b882!2sCentro%20Comercial%20Plaza%20del%20Sol!5e0!3m2!1ses!2scr!4v1709351264099!5m2!1ses!2scr" 
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div class="info-grid">
            <div class="info-section">
                <div class="info-title">
                    <i class="fas fa-map-marker-alt"></i>
                    <h2>Dirección</h2>
                </div>
                <div class="info-content">
                    <p>Centro Comercial Plaza del Sol</p>
                    <p>Local #15, Segundo Piso</p>
                    <p>Curridabat, San José</p>
                    <p>Costa Rica</p>
                </div>
            </div>

            <div class="info-section">
                <div class="info-title">
                    <i class="fas fa-clock"></i>
                    <h2>Horarios</h2>
                </div>
                <div class="info-content">
                    <p><strong>Horario de Atención:</strong></p>
                    <p>Todos los días: 6:00 AM - 6:00 PM</p>
                    <p><strong>Salidas de Tours:</strong></p>
                    <p>Todos los días: 8:00 AM y 2:00 PM</p>
                    <p><small>(según disponibilidad)</small></p>
                </div>
            </div>

            <div class="info-section">
                <div class="info-title">
                    <i class="fas fa-phone-alt"></i>
                    <h2>Contacto</h2>
                </div>
                <div class="info-content">
                    <a href="tel:+50622222222">
                        +506 2222-2222
                    </a>
                    <a href="tel:+50688888888">
                        +506 8888-8888
                    </a>
                    <a href="mailto:info@cielotico.com">
                        info@cielotico.com
                    </a>
                    <a href="mailto:reservas@cielotico.com">
                        reservas@cielotico.com
                    </a>
                </div>
            </div>

            <div class="info-section">
                <div class="info-title">
                    <i class="fas fa-bus"></i>
                    <h2>Transporte Público</h2>
                </div>
                <div class="info-content">
                    <ul class="transport-list">
                        <li>
                            Buses de Curridabat - San José cada 15 minutos
                        </li>
                        <li>
                            A 50 metros de la parada principal de Curridabat
                        </li>
                        <li>
                            Servicio de taxis disponible 24/7
                        </li>
                        <li>
                            Parqueo gratuito disponible
                        </li>
                    </ul>
                </div>
            </div>

            <div class="info-section">
                <div class="info-title">
                    <i class="fas fa-info-circle"></i>
                    <h2>Información Adicional</h2>
                </div>
                <div class="info-content">
                    <p>Contamos con sala de espera climatizada y café gratuito para nuestros clientes.</p>
                    <p>WiFi gratuito disponible en nuestras instalaciones.</p>
                    <p>Personal bilingüe para atender todas sus consultas.</p>
                </div>
            </div>

            <div class="info-section">
                <div class="info-title">
                    <i class="fas fa-map"></i>
                    <h2>Puntos de Referencia</h2>
                </div>
                <div class="info-content">
                    <ul class="transport-list">
                        <li>
                            Frente al Banco Nacional
                        </li>
                        <li>
                            Dentro del Centro Comercial Plaza del Sol
                        </li>
                        <li>
                            A 100 metros de la Municipalidad
                        </li>
                        <li>
                            Cerca del Centro Médico de Curridabat
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php include '../templates/footer.php'; ?>

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