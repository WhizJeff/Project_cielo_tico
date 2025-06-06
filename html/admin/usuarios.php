<?php
session_start();

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['user_id']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: /cielotico/html/login.php');
    exit();
}

// Incluir la conexión a la base de datos
require_once '../../php/config/database.php';

// Procesar la búsqueda
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_rol = isset($_GET['rol']) ? $_GET['rol'] : '';

// Construir la consulta SQL base
$sql = "SELECT id, nombre, email, rol, fecha_registro FROM usuarios WHERE 1=1";
$params = array();

// Añadir condiciones de búsqueda si existen
if (!empty($search)) {
    $sql .= " AND (nombre LIKE ? OR email LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($filter_rol)) {
    $sql .= " AND rol = ?";
    $params[] = $filter_rol;
}

$sql .= " ORDER BY fecha_registro DESC";

// Obtener la lista de usuarios
try {
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $error = "Error al obtener los usuarios: " . $e->getMessage();
}

// Obtener roles únicos para el filtro
try {
    $stmt = $conn->query("SELECT DISTINCT rol FROM usuarios");
    $roles = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch(PDOException $e) {
    $roles = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Cielo Tico</title>
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
            color: #000000;
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.5rem;
            background-clip: text;
        }
        .users-controls {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }
        .search-box {
            flex: 1;
            min-width: 200px;
            display: flex;
            gap: 0.5rem;
        }
        .search-box input {
            flex: 1;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        .filter-box {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
        .filter-box select {
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
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
        .users-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .users-table th,
        .users-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .users-table th {
            background-color: #f5f5f5;
            font-weight: 600;
            color: #333;
        }
        .users-table tr:last-child td {
            border-bottom: none;
        }
        .users-table tr:hover {
            background-color: #f9f9f9;
        }
        .user-actions {
            display: flex;
            gap: 0.5rem;
        }
        .role-badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .role-admin {
            background-color: #40E0D0;
            color: white;
        }
        .role-cliente {
            background-color: #2ecc71;
            color: white;
        }
        .role-admin:hover,
        .role-cliente:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .no-results {
            text-align: center;
            padding: 2rem;
            color: #666;
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
                <h1>Gestión de Usuarios</h1>
                <a href="crear_usuario.php" class="btn-add">
                    <i class="fas fa-user-plus"></i> Nuevo Usuario
                </a>
            </div>

            <div class="users-controls">
                <form class="search-box" method="GET">
                    <input type="text" name="search" placeholder="Buscar por nombre o email..." 
                           value="<?php echo htmlspecialchars($search); ?>">
                    <select name="rol">
                        <option value="">Todos los roles</option>
                        <?php foreach ($roles as $rol): ?>
                            <option value="<?php echo htmlspecialchars($rol); ?>" 
                                    <?php echo $filter_rol === $rol ? 'selected' : ''; ?>>
                                <?php echo ucfirst(htmlspecialchars($rol)); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn-add">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </form>
            </div>

            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php else: ?>
                <?php if (empty($usuarios)): ?>
                    <div class="no-results">
                        <i class="fas fa-search" style="font-size: 3rem; color: #ddd; margin-bottom: 1rem;"></i>
                        <p>No se encontraron usuarios que coincidan con tu búsqueda.</p>
                    </div>
                <?php else: ?>
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Fecha de Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                    <td>
                                        <span class="role-badge role-<?php echo htmlspecialchars($usuario['rol']); ?>">
                                            <?php echo ucfirst(htmlspecialchars($usuario['rol'])); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($usuario['fecha_registro']); ?></td>
                                    <td class="user-actions">
                                        <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>" 
                                           class="btn-edit" title="Editar usuario">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="eliminar_usuario.php?id=<?php echo $usuario['id']; ?>" 
                                           class="btn-delete" title="Eliminar usuario"
                                           onclick="return confirm('¿Está seguro de que desea eliminar este usuario?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>

    <footer role="contentinfo">
        <div class="footer-content">
            <p>&copy; 2025 Cielo Tico - Panel de Administración</p>
        </div>
    </footer>
</body>
</html> 