<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = $_POST['identifier'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Validaciones básicas
    if (empty($identifier) || empty($password)) {
        $_SESSION['error'] = "Por favor complete todos los campos.";
        header("Location: ../html/login.php");
        exit();
    }
    
    try {
        // Buscar usuario por email o nombre de usuario
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ? OR username = ?");
        $stmt->execute([$identifier, $identifier]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Login exitoso
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            $_SESSION['username'] = $user['username'];
            
            header("Location: ../html/index.php");
            exit();
        } else {
            // Credenciales inválidas
            $_SESSION['error'] = "Credenciales inválidas";
            header("Location: ../html/login.php");
            exit();
        }
    } catch(PDOException $e) {
        error_log("Error en login: " . $e->getMessage());
        $_SESSION['error'] = "Error al procesar el login";
        header("Location: ../html/login.php");
        exit();
    }
} else {
    // Si no es POST, redirigir al login
    header("Location: ../html/login.php");
    exit();
} 