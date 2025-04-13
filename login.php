<?php
$pageTitle = "Iniciar Sesión";
require_once 'includes/database.php';
require_once 'models/Usuario.php';
require_once 'includes/functions.php';

$errores = [];
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validaciones
    if (empty($email)) {
        $errores[] = "El email es obligatorio";
    }
    if (empty($password)) {
        $errores[] = "La contraseña es obligatoria";
    }

    if (empty($errores)) {
        $usuario = new Usuario();
        $usuarioData = $usuario->buscarPorEmail($email);

        if ($usuarioData && password_verify($password, $usuarioData['password'])) {
            // Iniciar sesión
            session_start();
            $_SESSION['user_id'] = $usuarioData['id'];
            $_SESSION['user_name'] = $usuarioData['nombre'];
            $_SESSION['user_role'] = $usuarioData['rol'];

            // Redirigir según el rol
            if ($usuarioData['rol'] === 'admin') {
                header("Location: admin/");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $errores[] = "Email o contraseña incorrectos";
        }
    }
}

require_once 'templates/header.php';
?>

<div class="container">
    <section class="registro-section">
        <h2>Iniciar Sesión</h2>
        
        <?php if (!empty($errores)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" class="form-registro">
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn-primary">Iniciar Sesión</button>
        </form>

        <div class="login-link">
            ¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>
        </div>
    </section>
</div>

<?php require_once 'templates/footer.php'; ?> 