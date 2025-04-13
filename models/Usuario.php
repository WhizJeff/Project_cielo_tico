<?php
require_once __DIR__ . '/Model.php';

class Usuario extends Model {
    protected $table = 'usuarios';
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol'
    ];

    public function __construct() {
        parent::__construct();
    }

    // Buscar usuario por email
    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        return $this->db->selectOne($sql, [$email]);
    }

    // Verificar si el email ya existe
    public function emailExiste($email) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE email = ?";
        $resultado = $this->db->selectOne($sql, [$email]);
        return $resultado['total'] > 0;
    }

    // Actualizar contraseña
    public function actualizarPassword($id, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE {$this->table} SET password = ? WHERE id = ?";
        return $this->db->update($sql, [$hashedPassword, $id]);
    }

    // Obtener usuarios por rol
    public function getPorRol($rol) {
        $sql = "SELECT * FROM {$this->table} WHERE rol = ?";
        return $this->db->select($sql, [$rol]);
    }
} 