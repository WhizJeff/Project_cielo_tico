<?php
require_once 'database.php';
require_once 'functions.php';

class Auth {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function login($email, $password) {
        $email = sanitizeInput($email);
        
        $sql = "SELECT id, nombre, email, password, rol FROM usuarios WHERE email = ?";
        $user = $this->db->selectOne($sql, [$email]);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            $_SESSION['user_role'] = $user['rol'];
            return true;
        }
        return false;
    }

    public function register($nombre, $apellidos, $email, $password, $telefono = null) {
        $nombre = sanitizeInput($nombre);
        $apellidos = sanitizeInput($apellidos);
        $email = sanitizeInput($email);
        $telefono = sanitizeInput($telefono);
        
        // Verificar si el email ya existe
        $sql = "SELECT id FROM usuarios WHERE email = ?";
        if ($this->db->selectOne($sql, [$email])) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO usuarios (nombre, apellidos, email, password, telefono) VALUES (?, ?, ?, ?, ?)";
        return $this->db->insert($sql, [$nombre, $apellidos, $email, $hashedPassword, $telefono]);
    }

    public function logout() {
        session_destroy();
        session_start();
    }

    public function getCurrentUser() {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        $sql = "SELECT id, nombre, apellidos, email, rol FROM usuarios WHERE id = ?";
        return $this->db->selectOne($sql, [$_SESSION['user_id']]);
    }
}
?> 