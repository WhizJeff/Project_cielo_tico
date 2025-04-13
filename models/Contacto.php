<?php
require_once __DIR__ . '/Model.php';

class Contacto extends Model {
    protected $table = 'contactos';
    protected $fillable = [
        'nombre',
        'email',
        'asunto',
        'mensaje',
        'estado'
    ];

    public function __construct() {
        parent::__construct();
    }

    // Obtener mensajes por estado
    public function getPorEstado($estado) {
        $sql = "SELECT * FROM {$this->table} WHERE estado = ? ORDER BY creado DESC";
        return $this->db->select($sql, [$estado]);
    }

    // Obtener mensajes no leídos
    public function getNoLeidos() {
        return $this->getPorEstado('nuevo');
    }

    // Marcar mensaje como leído
    public function marcarLeido($id) {
        $sql = "UPDATE {$this->table} SET estado = 'leido' WHERE id = ?";
        return $this->db->update($sql, [$id]);
    }

    // Marcar mensaje como respondido
    public function marcarRespondido($id) {
        $sql = "UPDATE {$this->table} SET estado = 'respondido' WHERE id = ?";
        return $this->db->update($sql, [$id]);
    }

    // Buscar mensajes por email
    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ? ORDER BY creado DESC";
        return $this->db->select($sql, [$email]);
    }
} 