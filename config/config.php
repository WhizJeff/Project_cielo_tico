<?php
require_once __DIR__ . '/Env.php';

// Cargar variables de entorno
Env::load();

// Configuración de la base de datos
define('DB_HOST', Env::get('DB_HOST', 'localhost'));
define('DB_NAME', Env::get('DB_NAME', 'cielotico_db'));
define('DB_USER', Env::get('DB_USER', 'root'));
define('DB_PASS', Env::get('DB_PASS', ''));

// Configuración general del sitio
define('SITE_URL', Env::get('SITE_URL', 'http://localhost/cielotico'));
define('SITE_NAME', Env::get('SITE_NAME', 'Cielo Tico'));

// Configuración de correo
define('MAIL_HOST', Env::get('MAIL_HOST', 'smtp.gmail.com'));
define('MAIL_PORT', Env::get('MAIL_PORT', 587));
define('MAIL_USERNAME', Env::get('MAIL_USERNAME', ''));
define('MAIL_PASSWORD', Env::get('MAIL_PASSWORD', ''));

// Configuración de entorno
define('APP_ENV', Env::get('APP_ENV', 'development'));
define('APP_DEBUG', Env::get('APP_DEBUG', true));

// Zona horaria
date_default_timezone_set(Env::get('TIMEZONE', 'America/Costa_Rica'));

// Configuración de sesión
session_start();

// Mostrar errores solo en desarrollo
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
?> 