<?php
session_start();

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['user_id']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: /cielotico/html/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tours - Cielo Tico</title>
    <link rel="icon" type="image/png" href="/cielotico/assets/img/logo.png" />
    <link rel="stylesheet" href="/cielotico/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        .admin-container {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .admin-header {
            margin-bottom: 2rem;
            padding: 2.5rem;
            background: white;
            border-radius: 12px;
            text-align: left;
            border: 3px solid #40E0D0;
            box-shadow: 0 4px 15px rgba(64, 224, 208, 0.15);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-header h1 {
            color: #333;
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            background: none;
            background-clip: text;
            -webkit-background-clip: initial;
            -webkit-text-fill-color: initial;
        }
        .tours-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .tour-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .tour-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .tour-content {
            padding: 1.5rem;
        }
        .tour-title {
            margin: 0 0 1rem 0;
            color: #333;
            font-size: 1.25rem;
        }
        .tour-info {
            color: #666;
            margin-bottom: 1rem;
        }
        .tour-price {
            font-weight: bold;
            color: #FF7F50;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
        .tour-actions {
            display: flex;
            gap: 0.5rem;
        }
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }
        .btn-add {
            background-color: #2ecc71;
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }
        .btn-add:hover {
            background-color: #27ae60;
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(46, 204, 113, 0.3);
        }
        .btn-edit,
        .btn-delete {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-edit {
            background-color: #2ecc71;
        }
        .btn-delete {
            background-color: #f44336;
        }
        .btn-edit:hover {
            background-color: #27ae60;
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(46, 204, 113, 0.3);
        }
        .btn-delete:hover {
            background-color: #da190b;
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .empty-state {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .empty-state i {
            font-size: 3rem;
            color: #ddd;
            margin-bottom: 1rem;
        }
        .empty-state p {
            color: #666;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo-container" style="display: flex; align-items: center;">
                <img src="/cielotico/~assets/logo/logo_ctt.png" alt="Cielo Tico Logo" style="width: 60px; height: 60px; margin-right: 15px;">
                <span style="color: white; font-size: 32px; font-weight: bold;">Cielo Tico</span>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Panel de Control</a></li>
                    <li><a href="/cielotico/html/index.php">Volver al Sitio</a></li>
                    <li><a href="/cielotico/php/logout.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="admin-container">
            <div class="admin-header">
                <h1>Gestión de Tours</h1>
                <a href="#" class="btn btn-add">
                    <i class="fas fa-plus"></i> Nuevo Tour
                </a>
            </div>

            <div class="tours-grid">
                <!-- Tour Volcán Arenal -->
                <div class="tour-card">
                    <img src="/cielotico/~assets/img/arenal.jpg" alt="Volcán Arenal" class="tour-image">
                    <div class="tour-content">
                        <h3 class="tour-title">Volcán Arenal</h3>
                        <div class="tour-info">
                            <p><i class="fas fa-clock"></i> Duración: 1 día</p>
                            <p><i class="fas fa-users"></i> Capacidad: 20 personas</p>
                        </div>
                        <p>El majestuoso coloso de Costa Rica, rodeado de aguas termales y bosque tropical.</p>
                        <div class="tour-price">$95 por persona</div>
                        <div class="tour-actions">
                            <a href="#" class="btn btn-edit">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="#" class="btn btn-delete">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tour Guanacaste -->
                <div class="tour-card">
                    <img src="/cielotico/~assets/img/guana.jpg" alt="Guanacaste" class="tour-image">
                    <div class="tour-content">
                        <h3 class="tour-title">Guanacaste</h3>
                        <div class="tour-info">
                            <p><i class="fas fa-clock"></i> Duración: 2 días</p>
                            <p><i class="fas fa-users"></i> Capacidad: 15 personas</p>
                        </div>
                        <p>Playas doradas, puestas de sol espectaculares y cultura guanacasteca.</p>
                        <div class="tour-price">$180 por persona</div>
                        <div class="tour-actions">
                            <a href="#" class="btn btn-edit">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="#" class="btn btn-delete">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tour Cerro Chirripó -->
                <div class="tour-card">
                    <img src="/cielotico/~assets/img/chirripo.jpg" alt="Cerro Chirripó" class="tour-image">
                    <div class="tour-content">
                        <h3 class="tour-title">Cerro Chirripó</h3>
                        <div class="tour-info">
                            <p><i class="fas fa-clock"></i> Duración: 2 días</p>
                            <p><i class="fas fa-users"></i> Capacidad: 12 personas</p>
                        </div>
                        <p>El punto más alto de Costa Rica, donde las nubes tocan la tierra.</p>
                        <div class="tour-price">$200 por persona</div>
                        <div class="tour-actions">
                            <a href="#" class="btn btn-edit">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="#" class="btn btn-delete">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tour Manuel Antonio -->
                <div class="tour-card">
                    <img src="/cielotico/~assets/img/manuel ant.jpg" alt="Manuel Antonio" class="tour-image">
                    <div class="tour-content">
                        <h3 class="tour-title">Manuel Antonio</h3>
                        <div class="tour-info">
                            <p><i class="fas fa-clock"></i> Duración: 1 día</p>
                            <p><i class="fas fa-users"></i> Capacidad: 15 personas</p>
                            <p><i class="fas fa-utensils"></i> Incluye almuerzo</p>
                        </div>
                        <p>Donde el bosque se encuentra con el mar, hogar de una increíble biodiversidad.</p>
                        <div class="tour-price">$120 por persona</div>
                        <div class="tour-actions">
                            <a href="#" class="btn btn-edit">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="#" class="btn btn-delete">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tour Monteverde -->
                <div class="tour-card">
                    <img src="/cielotico/~assets/img/monteverde.jpg" alt="Monteverde" class="tour-image">
                    <div class="tour-content">
                        <h3 class="tour-title">Monteverde</h3>
                        <div class="tour-info">
                            <p><i class="fas fa-clock"></i> Duración: 2 días</p>
                            <p><i class="fas fa-users"></i> Capacidad: 15 personas</p>
                            <p><i class="fas fa-utensils"></i> Incluye todas las comidas</p>
                        </div>
                        <p>Bosque nuboso místico con una biodiversidad única en el mundo.</p>
                        <div class="tour-price">$220 por persona</div>
                        <div class="tour-actions">
                            <a href="#" class="btn btn-edit">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="#" class="btn btn-delete">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tour Puerto Viejo -->
                <div class="tour-card">
                    <img src="/cielotico/~assets/img/cahuita.jpg" alt="Puerto Viejo" class="tour-image">
                    <div class="tour-content">
                        <h3 class="tour-title">Puerto Viejo</h3>
                        <div class="tour-info">
                            <p><i class="fas fa-clock"></i> Duración: 3 días</p>
                            <p><i class="fas fa-users"></i> Capacidad: 12 personas</p>
                            <p><i class="fas fa-utensils"></i> Incluye todas las comidas</p>
                        </div>
                        <p>Paraíso caribeño con rica cultura afrocaribeña y playas paradisíacas.</p>
                        <div class="tour-price">$300 por persona</div>
                        <div class="tour-actions">
                            <a href="#" class="btn btn-edit">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="#" class="btn btn-delete">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tour Río Celeste -->
                <div class="tour-card">
                    <img src="/cielotico/~assets/img/celeste.jpg" alt="Río Celeste" class="tour-image">
                    <div class="tour-content">
                        <h3 class="tour-title">Río Celeste</h3>
                        <div class="tour-info">
                            <p><i class="fas fa-clock"></i> Duración: 1 día</p>
                            <p><i class="fas fa-users"></i> Capacidad: 15 personas</p>
                            <p><i class="fas fa-utensils"></i> Incluye almuerzo</p>
                        </div>
                        <p>Descubre el mágico río de aguas turquesas en el Parque Nacional Volcán Tenorio.</p>
                        <div class="tour-price">$130 por persona</div>
                        <div class="tour-actions">
                            <a href="#" class="btn btn-edit">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="#" class="btn btn-delete">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tour Cahuita -->
                <div class="tour-card">
                    <img src="/cielotico/~assets/img/cahuita.jpg" alt="Cahuita" class="tour-image">
                    <div class="tour-content">
                        <h3 class="tour-title">Cahuita</h3>
                        <div class="tour-info">
                            <p><i class="fas fa-clock"></i> Duración: 2 días</p>
                            <p><i class="fas fa-users"></i> Capacidad: 10 personas</p>
                            <p><i class="fas fa-utensils"></i> Incluye todas las comidas</p>
                        </div>
                        <p>Explora los arrecifes de coral y la exuberante selva tropical del Caribe.</p>
                        <div class="tour-price">$250 por persona</div>
                        <div class="tour-actions">
                            <a href="#" class="btn btn-edit">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="#" class="btn btn-delete">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tour San José -->
                <div class="tour-card">
                    <img src="/cielotico/~assets/img/chepe.jpg" alt="San José" class="tour-image">
                    <div class="tour-content">
                        <h3 class="tour-title">San José</h3>
                        <div class="tour-info">
                            <p><i class="fas fa-clock"></i> Duración: 1 día</p>
                            <p><i class="fas fa-users"></i> Capacidad: 20 personas</p>
                            <p><i class="fas fa-utensils"></i> Incluye almuerzo</p>
                        </div>
                        <p>Recorre la capital y descubre su rica historia, cultura y arquitectura.</p>
                        <div class="tour-price">$80 por persona</div>
                        <div class="tour-actions">
                            <a href="#" class="btn btn-edit">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="#" class="btn btn-delete">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer role="contentinfo">
        <div class="footer-content">
            <p>&copy; 2025 Cielo Tico - Panel de Administración</p>
        </div>
    </footer>
</body>
</html> 