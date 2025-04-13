<?php
$pageTitle = "Registro";
require_once 'includes/database.php';
require_once 'models/Usuario.php';
require_once 'includes/functions.php';

$errores = [];
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = sanitizeInput($_POST['nombre'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmarPassword = $_POST['confirmar_password'] ?? '';

    // Validaciones
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio";
    }
    if (empty($email)) {
        $errores[] = "El email es obligatorio";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido";
    }
    if (empty($password)) {
        $errores[] = "La contraseña es obligatoria";
    } elseif (strlen($password) < 6) {
        $errores[] = "La contraseña debe tener al menos 6 caracteres";
    }
    if ($password !== $confirmarPassword) {
        $errores[] = "Las contraseñas no coinciden";
    }

    if (empty($errores)) {
        $usuario = new Usuario();
        
        // Verificar si el email ya existe
        if ($usuario->emailExiste($email)) {
            $errores[] = "Este email ya está registrado";
        } else {
            // Crear el usuario
            try {
                $resultado = $usuario->create([
                    'nombre' => $nombre,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'rol' => 'cliente' // Por defecto, todos los registros nuevos son clientes
                ]);

                if ($resultado) {
                    $mensaje = "¡Registro exitoso! Ya puedes iniciar sesión.";
                    // Redirigir después de 3 segundos
                    header("refresh:3;url=login.php");
                }
            } catch (Exception $e) {
                $errores[] = "Error al crear el usuario: " . $e->getMessage();
            }
        }
    }
}

require_once 'templates/header.php';
?>

<div class="container">
    <section class="registro-section">
        <h2>Registro de Usuario</h2>
        
        <?php if (!empty($errores)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($mensaje): ?>
            <div class="alert alert-success">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="form-registro">
            <div class="form-group">
                <label for="nombre">Nombre completo</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo isset($nombre) ? $nombre : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
                <small>La contraseña debe tener al menos 6 caracteres</small>
            </div>

            <div class="form-group">
                <label for="confirmar_password">Confirmar contraseña</label>
                <input type="password" id="confirmar_password" name="confirmar_password" required>
            </div>

            <button type="submit" class="btn-primary">Registrarse</button>
        </form>

        <div class="login-link">
            ¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>
        </div>
    </section>
</div>

<?php require_once 'templates/footer.php'; ?> 