<?php
session_start();
require_once __DIR__ . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    
    // Validaciones básicas
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Por favor complete todos los campos.";
        header("Location: ../html/login.php");
        exit();
    }
    
    try {
        // Crear conexión
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Preparar la consulta
        $stmt = $conn->prepare("SELECT id, nombre, email, password FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usuario && password_verify($password, $usuario['password'])) {
            // Login exitoso
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_name'] = $usuario['nombre'];
            $_SESSION['user_email'] = $usuario['email'];
            
            header("Location: ../html/index.php");
            exit();
        } else {
            // Credenciales incorrectas
            $_SESSION['error'] = "Credenciales incorrectas.";
            header("Location: ../html/login.php");
            exit();
        }
    } catch(PDOException $e) {
        $_SESSION['error'] = "Error de conexión: " . $e->getMessage();
        header("Location: ../html/login.php");
        exit();
    }
} else {
    // Si no es POST, redirigir al login
    header("Location: ../html/login.php");
    exit();
}
?> 