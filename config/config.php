<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'cielotico_db');
define('DB_USER', 'cielotico_user');
define('DB_PASS', 'CieloUser2024!');

// Configuración general del sitio
define('SITE_URL', 'http://localhost/cielotico');
define('SITE_NAME', 'Cielo Tico');

// Configuración de correo (para futura implementación)
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', 'tu_correo@gmail.com');
define('MAIL_PASSWORD', 'tu_contraseña');

// Configuración de sesión
session_start();

// Zona horaria
date_default_timezone_set('America/Costa_Rica');

// Mostrar errores en desarrollo, comentar en producción
error_reporting(E_ALL);
ini_set('display_errors', 1);
?> 