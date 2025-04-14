<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Cielo Tico</title>
    <link rel="icon" type="image/png" href="../img/logo.png" />
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
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
                    <li><a href="acerca.html">Acerca de</a></li>
                    <li><a href="servicios.html">Servicios</a></li>
                    <li><a href="ubicacion.html">Ubicación</a></li>
                    <li><a href="contacto.html">Contacto</a></li>
                    <li><a href="login.html" class="btn-login">Iniciar Sesión</a></li>
                    <li><a href="registro.html" class="btn-register">Registro</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="auth-section">
            <div class="auth-container">
                <h2>Iniciar Sesión</h2>
                <?php if(isset($_SESSION['error'])): ?>
                    <div class="alert alert-error">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
                <form id="loginForm" action="../php/login_process.php" method="POST">
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn-primary">Iniciar Sesión</button>
                    <div class="register-link">
                        <p>¿No tienes una cuenta? <a href="registro.html">Regístrate aquí</a></p>
                    </div>
                </form>
            </div>
        </section>
    </main>

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

    <script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        
        if (!email || !password) {
            e.preventDefault();
            alert('Por favor, complete todos los campos');
            return;
        }
    });
    </script>
</body>
</html> 