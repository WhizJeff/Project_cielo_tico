<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Servicios de transporte turístico de Cielo Tico - Tours y excursiones por Costa Rica" />
    <meta name="keywords" content="Cielo Tico, tours Costa Rica, excursiones, ecoturismo, aventura, naturaleza, playas, montañas" />
    <meta name="author" content="Cielo Tico" />
    <title>Servicios - Cielo Tico</title>
    <link rel="icon" type="image/png" href="../img/logo.png" />
    <link rel="stylesheet" href="../css/estilos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
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
        <section id="tours" class="about-section">
            <div class="container">
                <h2>Nuestros Tours</h2>
                <div class="tours-grid">
                    <!-- Tour Volcán Arenal -->
                    <div class="tour-card">
                        <img src="../img/slider1.jpg" alt="Volcán Arenal" class="tour-image" onclick="openImagePopup(this.src, 'Volcán Arenal', 'El majestuoso coloso de Costa Rica, rodeado de aguas termales y bosque tropical.')">
                        <div class="tour-info">
                            <h3>Volcán Arenal</h3>
                            <p>El majestuoso coloso de Costa Rica, rodeado de aguas termales y bosque tropical.</p>
                            <ul class="tour-details">
                                <li><i class="far fa-clock"></i> Duración: 1 día</li>
                                <li><i class="fas fa-users"></i> Máximo: 20 personas</li>
                                <li><i class="fas fa-utensils"></i> Incluye almuerzo</li>
                            </ul>
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <a href="reservar_tour.php?tour_id=1" class="btn-primary">Reservar Tour</a>
                            <?php else: ?>
                                <a href="login.php" class="btn-primary">Iniciar sesión para reservar</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tour Guanacaste -->
                    <div class="tour-card">
                        <img src="../img/slider2.jpg" alt="Playas de Guanacaste" class="tour-image" onclick="openImagePopup(this.src, 'Playas de Guanacaste', 'Playas doradas, puestas de sol espectaculares y cultura guanacasteca.')">
                        <div class="tour-info">
                            <h3>Guanacaste</h3>
                            <p>Playas doradas, puestas de sol espectaculares y cultura guanacasteca.</p>
                            <ul class="tour-details">
                                <li><i class="far fa-clock"></i> Duración: 2 días</li>
                                <li><i class="fas fa-users"></i> Máximo: 15 personas</li>
                                <li><i class="fas fa-utensils"></i> Incluye todas las comidas</li>
                            </ul>
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <a href="reservar_tour.php?tour_id=2" class="btn-primary">Reservar Tour</a>
                            <?php else: ?>
                                <a href="login.php" class="btn-primary">Iniciar sesión para reservar</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tour Cerro Chirripó -->
                    <div class="tour-card">
                        <img src="../img/slider3.jpg" alt="Cerro Chirripó" class="tour-image" onclick="openImagePopup(this.src, 'Cerro Chirripó', 'El punto más alto de Costa Rica, donde las nubes tocan la tierra.')">
                        <div class="tour-info">
                            <h3>Cerro Chirripó</h3>
                            <p>El punto más alto de Costa Rica, donde las nubes tocan la tierra.</p>
                            <ul class="tour-details">
                                <li><i class="far fa-clock"></i> Duración: 2 días</li>
                                <li><i class="fas fa-users"></i> Máximo: 12 personas</li>
                                <li><i class="fas fa-utensils"></i> Incluye todas las comidas</li>
                            </ul>
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <a href="reservar_tour.php?tour_id=3" class="btn-primary">Reservar Tour</a>
                            <?php else: ?>
                                <a href="login.php" class="btn-primary">Iniciar sesión para reservar</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tour Manuel Antonio -->
                    <div class="tour-card">
                        <img src="../img/slider5.jpg" alt="Parque Nacional Manuel Antonio" class="tour-image" onclick="openImagePopup(this.src, 'Manuel Antonio', 'Donde el bosque se encuentra con el mar, hogar de una increíble biodiversidad.')">
                        <div class="tour-info">
                            <h3>Manuel Antonio</h3>
                            <p>Donde el bosque se encuentra con el mar, hogar de una increíble biodiversidad.</p>
                            <ul class="tour-details">
                                <li><i class="far fa-clock"></i> Duración: 1 día</li>
                                <li><i class="fas fa-users"></i> Máximo: 15 personas</li>
                                <li><i class="fas fa-utensils"></i> Incluye almuerzo</li>
                            </ul>
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <a href="reservar_tour.php?tour_id=4" class="btn-primary">Reservar Tour</a>
                            <?php else: ?>
                                <a href="login.php" class="btn-primary">Iniciar sesión para reservar</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tour Monteverde -->
                    <div class="tour-card">
                        <img src="../img/slider6.jpg" alt="Bosque Nuboso de Monteverde" class="tour-image" onclick="openImagePopup(this.src, 'Monteverde', 'Bosque nuboso místico con una biodiversidad única en el mundo.')">
                        <div class="tour-info">
                            <h3>Monteverde</h3>
                            <p>Bosque nuboso místico con una biodiversidad única en el mundo.</p>
                            <ul class="tour-details">
                                <li><i class="far fa-clock"></i> Duración: 2 días</li>
                                <li><i class="fas fa-users"></i> Máximo: 15 personas</li>
                                <li><i class="fas fa-utensils"></i> Incluye todas las comidas</li>
                            </ul>
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <a href="reservar_tour.php?tour_id=5" class="btn-primary">Reservar Tour</a>
                            <?php else: ?>
                                <a href="login.php" class="btn-primary">Iniciar sesión para reservar</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tour Puerto Viejo -->
                    <div class="tour-card">
                        <img src="../img/slider4.jpg" alt="Puerto Viejo de Talamanca" class="tour-image" onclick="openImagePopup(this.src, 'Puerto Viejo', 'Paraíso caribeño con rica cultura afrocaribeña y playas paradisíacas.')">
                        <div class="tour-info">
                            <h3>Puerto Viejo</h3>
                            <p>Paraíso caribeño con rica cultura afrocaribeña y playas paradisíacas.</p>
                            <ul class="tour-details">
                                <li><i class="far fa-clock"></i> Duración: 3 días</li>
                                <li><i class="fas fa-users"></i> Máximo: 12 personas</li>
                                <li><i class="fas fa-utensils"></i> Incluye todas las comidas</li>
                            </ul>
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <a href="reservar_tour.php?tour_id=6" class="btn-primary">Reservar Tour</a>
                            <?php else: ?>
                                <a href="login.php" class="btn-primary">Iniciar sesión para reservar</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tour Río Celeste -->
                    <div class="tour-card">
                        <img src="../img/tours/rio-celeste.jpg" alt="Río Celeste" class="tour-image" onclick="openImagePopup(this.src, 'Río Celeste', 'Descubre el mágico río de aguas turquesas en el Parque Nacional Volcán Tenorio.')">
                        <div class="tour-info">
                            <h3>Río Celeste</h3>
                            <p>Descubre el mágico río de aguas turquesas en el Parque Nacional Volcán Tenorio.</p>
                            <ul class="tour-details">
                                <li><i class="far fa-clock"></i> Duración: 1 día</li>
                                <li><i class="fas fa-users"></i> Máximo: 15 personas</li>
                                <li><i class="fas fa-utensils"></i> Incluye almuerzo</li>
                            </ul>
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <a href="reservar_tour.php?tour_id=7" class="btn-primary">Reservar Tour</a>
                            <?php else: ?>
                                <a href="login.php" class="btn-primary">Iniciar sesión para reservar</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tour Cahuita -->
                    <div class="tour-card">
                        <img src="../img/tours/cahuita.jpg" alt="Parque Nacional Cahuita" class="tour-image" onclick="openImagePopup(this.src, 'Cahuita', 'Explora los arrecifes de coral y la exuberante selva tropical del Caribe.')">
                        <div class="tour-info">
                            <h3>Cahuita</h3>
                            <p>Explora los arrecifes de coral y la exuberante selva tropical del Caribe.</p>
                            <ul class="tour-details">
                                <li><i class="far fa-clock"></i> Duración: 2 días</li>
                                <li><i class="fas fa-users"></i> Máximo: 10 personas</li>
                                <li><i class="fas fa-utensils"></i> Incluye todas las comidas</li>
                            </ul>
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <a href="reservar_tour.php?tour_id=8" class="btn-primary">Reservar Tour</a>
                            <?php else: ?>
                                <a href="login.php" class="btn-primary">Iniciar sesión para reservar</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tour San José -->
                    <div class="tour-card">
                        <img src="../img/tours/san-jose.jpg" alt="Ciudad de San José" class="tour-image" onclick="openImagePopup(this.src, 'San José', 'Recorre la capital y descubre su rica historia, cultura y arquitectura.')">
                        <div class="tour-info">
                            <h3>San José</h3>
                            <p>Recorre la capital y descubre su rica historia, cultura y arquitectura.</p>
                            <ul class="tour-details">
                                <li><i class="far fa-clock"></i> Duración: 1 día</li>
                                <li><i class="fas fa-users"></i> Máximo: 20 personas</li>
                                <li><i class="fas fa-utensils"></i> Incluye almuerzo</li>
                            </ul>
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <a href="reservar_tour.php?tour_id=9" class="btn-primary">Reservar Tour</a>
                            <?php else: ?>
                                <a href="login.php" class="btn-primary">Iniciar sesión para reservar</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal para el popup de imágenes -->
    <div id="imageModal" class="modal">
        <span class="close">&times;</span>
        <div class="modal-content">
            <div class="modal-image-container">
                <img id="modalImage" src="" alt="">
            </div>
            <div class="modal-info">
                <div class="modal-header">
                    <h3 id="modalTitle"></h3>
                    <div class="tour-price">
                        <span class="price-label">Desde</span>
                        <span class="price-amount">$99</span>
                        <span class="price-person">por persona</span>
                    </div>
                </div>
                <p id="modalDescription"></p>
                <div class="modal-details">
                    <div class="details-column">
                        <h4>Detalles del Tour</h4>
                        <ul class="tour-details-list">
                            <li><i class="far fa-clock"></i> <span id="modalDuration"></span></li>
                            <li><i class="fas fa-users"></i> <span id="modalGroupSize"></span></li>
                            <li><i class="fas fa-utensils"></i> <span id="modalMeals"></span></li>
                            <li><i class="fas fa-map-marker-alt"></i> <span id="modalLocation">Punto de encuentro: Centro de la ciudad</span></li>
                        </ul>
                    </div>
                    <div class="details-column">
                        <h4>Incluye</h4>
                        <ul class="includes-list">
                            <li><i class="fas fa-check"></i> Transporte ida y vuelta</li>
                            <li><i class="fas fa-check"></i> Guía bilingüe certificado</li>
                            <li><i class="fas fa-check"></i> Entradas a los sitios</li>
                            <li><i class="fas fa-check"></i> Seguro de viaje</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-actions">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="#" class="btn-reserve" id="modalReserveButton">Reservar Tour</a>
                    <?php else: ?>
                        <a href="login.php" class="btn-reserve">Iniciar sesión para reservar</a>
                    <?php endif; ?>
                    <div class="tour-rating">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="rating-text">4.5 (128 reseñas)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <script src="../js/main.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const userToggle = document.querySelector('.user-toggle');
        const userMenu = document.querySelector('.user-menu');
        let currentTourId = null;

        // Función para abrir el popup con la información del tour
        function openImagePopup(src, title, description) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            const modalTitle = document.getElementById('modalTitle');
            const modalDescription = document.getElementById('modalDescription');
            const modalReserveButton = document.getElementById('modalReserveButton');

            modalImg.src = src;
            modalTitle.textContent = title;
            modalDescription.textContent = description;

            // Asignar el ID del tour basado en el título
            const tourIds = {
                'Volcán Arenal': '1',
                'Guanacaste': '2',
                'Cerro Chirripó': '3',
                'Manuel Antonio': '4',
                'Monteverde': '5',
                'Puerto Viejo': '6',
                'Río Celeste': '7',
                'Cahuita': '8',
                'San José': '9'
            };
            
            currentTourId = tourIds[title];
            
            if (modalReserveButton) {
                modalReserveButton.href = `reservar_tour.php?tour_id=${currentTourId}`;
            }

            modal.style.display = "block";
        }

        // Resto del código existente para el menú de usuario...
        if (userToggle && userMenu) {
            userToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                userMenu.classList.toggle('active');
            });

            document.addEventListener('click', function(e) {
                if (!userMenu.contains(e.target)) {
                    userMenu.classList.remove('active');
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && userMenu.classList.contains('active')) {
                    userMenu.classList.remove('active');
                }
            });
        }

        // Asignar la función openImagePopup al objeto window para que esté disponible globalmente
        window.openImagePopup = openImagePopup;
    });
    </script>
</body>
</html> 