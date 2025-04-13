<?php
// Funciones de utilidad general

function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function redirectTo($path) {
    header("Location: " . SITE_URL . $path);
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        redirectTo('/login.php');
    }
}

function displayError($message) {
    return "<div class='alert alert-danger'>$message</div>";
}

function displaySuccess($message) {
    return "<div class='alert alert-success'>$message</div>";
}

function formatDate($date) {
    return date('d/m/Y', strtotime($date));
}
?> 