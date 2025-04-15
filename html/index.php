<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Cielo Tico - Vive el cielo en la tierra. Tu mejor opción para excursiones y tours en Costa Rica." />
    <meta name="keywords" content="Cielo Tico, tours Costa Rica, excursiones, ecoturismo, aventura, naturaleza" />
    <meta name="author" content="Cielo Tico" />
    <title>Cielo Tico | Vive el cielo en la tierra</title>
    <link rel="icon" type="image/png" href="../img/logo.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos.css" />
    <link rel="preload" href="img/slider1.jpg" as="image" />
    <link rel="preload" href="img/slider2.jpg" as="image" />
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
        .welcome-text {
            margin-left: 8px;
            color: white;
        }
        .fa-bars {
            font-size: 1.2rem;
        }
        @media (max-width: 768px) {
            .welcome-text {
                display: none;
            }
            .user-menu-content {
                width: 100%;
                position: relative;
            }
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
                    <li><a href="acerca.html">Acerca de</a></li>
                    <li><a href="servicios.html">Servicios</a></li>
                    <li><a href="ubicacion.html">Ubicación</a></li>
                    <li><a href="contacto.html">Contacto</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="user-menu">
                            <button class="user-menu-button" aria-label="Menú de usuario">
                                <i class="fas fa-user"></i>
                                <i class="fas fa-bars"></i>
                            </button>
                            <div class="user-menu-content">
                                <div class="user-info">
                                    <i class="fas fa-user-circle"></i>
                                    <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                                </div>
                                <a href="perfil.php"><i class="fas fa-user"></i> Mi Perfil</a>
                                <a href="mis-reservas.php"><i class="fas fa-calendar-alt"></i> Mis Reservas</a>
                                <a href="../php/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li><a href="login.php" class="btn-login">Iniciar Sesión</a></li>
                        <li><a href="registro.html" class="btn-register">Registro</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section id="slider">
            <div class="slide-container">
                <div class="slide">
                    <img src="../img/slider1.jpg" alt="Volcán Arenal en La Fortuna">
                    <h2>Volcán Arenal</h2>
                    <p>El majestuoso coloso de Costa Rica, rodeado de aguas termales y bosque tropical</p>
                </div>
                <div class="slide">
                    <img src="../img/slider2.jpg" alt="Playas de Guanacaste">
                    <h2>Guanacaste</h2>
                    <p>Playas doradas, puestas de sol espectaculares y cultura guanacasteca</p>
                </div>
                <div class="slide">
                    <img src="../img/slider3.jpg" alt="Cerro Chirripó">
                    <h2>Cerro Chirripó</h2>
                    <p>El punto más alto de Costa Rica, donde las nubes tocan la tierra</p>
                </div>
                <div class="slide">
                    <img src="../img/slider4.jpg" alt="Puerto Viejo de Talamanca">
                    <h2>Puerto Viejo</h2>
                    <p>Paraíso caribeño con rica cultura afrocaribeña y playas paradisíacas</p>
                </div>
                <div class="slide">
                    <img src="../img/slider5.jpg" alt="Parque Nacional Manuel Antonio">
                    <h2>Manuel Antonio</h2>
                    <p>Donde el bosque se encuentra con el mar, hogar de una increíble biodiversidad</p>
                </div>
                <div class="slide">
                    <img src="../img/slider6.jpg" alt="Bosque Nuboso de Monteverde">
                    <h2>Monteverde</h2>
                    <p>Bosque nuboso místico con una biodiversidad única en el mundo</p>
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
            </div>
            <p>&copy; 2025 Cielo Tico. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="../js/script.js"></script>
</body>
</html> 