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
    <link rel="preload" href="../img/slider1.jpg" as="image" />
    <link rel="preload" href="../img/slider2.jpg" as="image" />
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
        <section id="slider">
            <div class="slide-container">
                <div class="slide">
                    <img src="../img/slider1.jpg" alt="Volcán Arenal en La Fortuna">
                    <div class="slide-content">
                        <h2>Volcán Arenal</h2>
                        <p>El majestuoso coloso de Costa Rica, rodeado de aguas termales y bosque tropical</p>
                    </div>
                </div>
                <div class="slide">
                    <img src="../img/slider2.jpg" alt="Playas de Guanacaste">
                    <div class="slide-content">
                        <h2>Guanacaste</h2>
                        <p>Playas doradas, puestas de sol espectaculares y cultura guanacasteca</p>
                    </div>
                </div>
                <div class="slide">
                    <img src="../img/slider3.jpg" alt="Cerro Chirripó">
                    <div class="slide-content">
                        <h2>Cerro Chirripó</h2>
                        <p>El punto más alto de Costa Rica, donde las nubes tocan la tierra</p>
                    </div>
                </div>
                <div class="slide">
                    <img src="../img/slider4.jpg" alt="Puerto Viejo de Talamanca">
                    <div class="slide-content">
                        <h2>Puerto Viejo</h2>
                        <p>Paraíso caribeño con rica cultura afrocaribeña y playas paradisíacas</p>
                    </div>
                </div>
                <div class="slide">
                    <img src="../img/slider5.jpg" alt="Parque Nacional Manuel Antonio">
                    <div class="slide-content">
                        <h2>Manuel Antonio</h2>
                        <p>Donde el bosque se encuentra con el mar, hogar de una increíble biodiversidad</p>
                    </div>
                </div>
                <div class="slide">
                    <img src="../img/slider6.jpg" alt="Bosque Nuboso de Monteverde">
                    <div class="slide-content">
                        <h2>Monteverde</h2>
                        <p>Bosque nuboso místico con una biodiversidad única en el mundo</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="destacados" aria-label="Experiencias Destacadas">
            <h2>Experiencias Destacadas</h2>
            <div class="experiencias-grid">
                <div class="experiencia">
                    <i class="fas fa-mountain"></i>
                    <h3>Aventuras en la Montaña</h3>
                    <p>Explora los senderos más hermosos de Costa Rica</p>
                </div>
                <div class="experiencia">
                    <i class="fas fa-water"></i>
                    <h3>Playas Paradisíacas</h3>
                    <p>Disfruta de las mejores playas del país</p>
                </div>
                <div class="experiencia">
                    <i class="fas fa-tree"></i>
                    <h3>Ecoturismo</h3>
                    <p>Conecta con la naturaleza en su estado más puro</p>
                </div>
            </div>
        </section>

        <section id="testimonios" aria-label="Testimonios de clientes">
            <h2>Reseñas</h2>
            <div class="testimonios-grid">
                <blockquote>
                    <p>"Una experiencia inolvidable. Cielo Tico nos permitió descubrir la verdadera esencia de Costa Rica."</p>
                    <footer>
                        <span class="nombre">María Solís</span>
                        <span class="usuario">@mariasol</span>
                    </footer>
                </blockquote>
                <blockquote>
                    <p>"El servicio fue excepcional. Cada detalle estaba pensado para nuestra comodidad."</p>
                    <footer>
                        <span class="nombre">Juan Pérez</span>
                        <span class="usuario">@juanperez</span>
                    </footer>
                </blockquote>
                <blockquote>
                    <p>"La mejor manera de explorar Costa Rica. ¡Volveremos pronto!"</p>
                    <footer>
                        <span class="nombre">Ana Rodríguez</span>
                        <span class="usuario">@anarod</span>
                    </footer>
                </blockquote>
            </div>
        </section>

        <section id="buses" aria-label="Nuestra flota de buses">
            <h2>Nuestra Flota de Buses</h2>
            <div class="buses-grid">
                <div class="bus-card">
                    <img src="../img/buses/bus1.jpg" alt="Bus de lujo Cielo Tico" loading="lazy">
                    <div class="bus-info">
                        <h3>Bus de Lujo</h3>
                        <p>Nuestro bus de lujo ofrece la máxima comodidad para tus viajes, con asientos reclinables y entretenimiento a bordo.</p>
                        <ul class="bus-features">
                            <li><i class="fas fa-check"></i> Asientos reclinables</li>
                            <li><i class="fas fa-check"></i> Aire acondicionado</li>
                            <li><i class="fas fa-check"></i> WiFi a bordo</li>
                            <li><i class="fas fa-check"></i> Pantallas de entretenimiento</li>
                        </ul>
                    </div>
                </div>
                <div class="bus-card">
                    <img src="../img/buses/bus2.jpg" alt="Bus ejecutivo Cielo Tico" loading="lazy">
                    <div class="bus-info">
                        <h3>Bus Ejecutivo</h3>
                        <p>Ideal para grupos medianos, combina confort y eficiencia para tus excursiones.</p>
                        <ul class="bus-features">
                            <li><i class="fas fa-check"></i> Espacios amplios</li>
                            <li><i class="fas fa-check"></i> Aire acondicionado</li>
                            <li><i class="fas fa-check"></i> Almacenamiento extra</li>
                            <li><i class="fas fa-check"></i> Asientos ergonómicos</li>
                        </ul>
                    </div>
                </div>
                <div class="bus-card">
                    <img src="../img/buses/bus3.jpg" alt="Bus turístico Cielo Tico" loading="lazy">
                    <div class="bus-info">
                        <h3>Bus Turístico</h3>
                        <p>Diseñado para la aventura, con ventanas panorámicas para disfrutar de los paisajes.</p>
                        <ul class="bus-features">
                            <li><i class="fas fa-check"></i> Ventanas panorámicas</li>
                            <li><i class="fas fa-check"></i> Aire acondicionado</li>
                            <li><i class="fas fa-check"></i> Sistema de audio</li>
                            <li><i class="fas fa-check"></i> Espacios para equipaje</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="cta" aria-label="Llamada a la acción">
            <div class="cta-content">
                <h2>¿Listo para tu próxima aventura?</h2>
                <p>Descubre los rincones más hermosos de Costa Rica con nosotros</p>
                <a href="servicios.html" class="btn-primary">Explora nuestros tours</a>
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