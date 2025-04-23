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
    <title>Gestión de Reservas - Cielo Tico</title>
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
            text-align: center;
            border: 3px solid #40E0D0;
            box-shadow: 0 4px 15px rgba(64, 224, 208, 0.15);
        }
        .admin-header h1 {
            color: #333;
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            background-clip: text;
        }
        .filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        .filter-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .filter-group select, .filter-group input {
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.9rem;
        }
        .reservations-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .reservations-table th, .reservations-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .reservations-table th {
            background-color: #f8f9fa;
            font-weight: 500;
            color: #333;
        }
        .reservations-table tr:last-child td {
            border-bottom: none;
        }
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
        }
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-confirm {
            background-color: #2ecc71;
            color: white;
        }
        .btn-confirm:hover {
            background-color: #27ae60;
            box-shadow: 0 4px 8px rgba(46, 204, 113, 0.3);
        }
        .btn-cancel {
            background-color: #f44336;
            color: white;
        }
        .btn-cancel:hover {
            background-color: #da190b;
        }
        .btn-view {
            background-color: #40E0D0;
            color: white;
        }
        .btn-view:hover {
            background-color: #20B2AA;
        }
        .status-badge:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .actions {
            display: flex;
            gap: 0.5rem;
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
                <h1>Gestión de Reservas</h1>
            </div>

            <div class="filters">
                <div class="filter-group">
                    <label for="status">Estado:</label>
                    <select id="status" name="status">
                        <option value="">Todos</option>
                        <option value="pending">Pendiente</option>
                        <option value="confirmed">Confirmada</option>
                        <option value="cancelled">Cancelada</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="date">Fecha:</label>
                    <input type="date" id="date" name="date">
                </div>
                <div class="filter-group">
                    <label for="tour">Tour:</label>
                    <select id="tour" name="tour">
                        <option value="">Todos los tours</option>
                        <option value="1">Tour al Volcán Poás</option>
                        <option value="2">Catarata La Paz</option>
                        <option value="3">Monteverde Cloud Forest</option>
                    </select>
                </div>
            </div>

            <table class="reservations-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Tour</th>
                        <th>Fecha</th>
                        <th>Personas</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Reserva de ejemplo 1 -->
                    <tr>
                        <td>#001</td>
                        <td>Juan Pérez</td>
                        <td>Tour al Volcán Poás</td>
                        <td>2025-03-15</td>
                        <td>2</td>
                        <td><span class="status-badge status-pending">Pendiente</span></td>
                        <td class="actions">
                            <a href="#" class="btn btn-view">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a href="#" class="btn btn-confirm">
                                <i class="fas fa-check"></i> Confirmar
                            </a>
                            <a href="#" class="btn btn-cancel">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </td>
                    </tr>
                    <!-- Reserva de ejemplo 2 -->
                    <tr>
                        <td>#002</td>
                        <td>María González</td>
                        <td>Catarata La Paz</td>
                        <td>2025-03-16</td>
                        <td>4</td>
                        <td><span class="status-badge status-confirmed">Confirmada</span></td>
                        <td class="actions">
                            <a href="#" class="btn btn-view">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a href="#" class="btn btn-cancel">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </td>
                    </tr>
                    <!-- Reserva de ejemplo 3 -->
                    <tr>
                        <td>#003</td>
                        <td>Carlos Rodríguez</td>
                        <td>Monteverde Cloud Forest</td>
                        <td>2025-03-17</td>
                        <td>3</td>
                        <td><span class="status-badge status-cancelled">Cancelada</span></td>
                        <td class="actions">
                            <a href="#" class="btn btn-view">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <footer role="contentinfo">
        <div class="footer-content">
            <p>&copy; 2025 Cielo Tico - Panel de Administración</p>
        </div>
    </footer>
</body>
</html> 