<?php
require_once __DIR__ . '/Model.php';

class Reservacion extends Model {
    protected $table = 'reservaciones';
    protected $fillable = [
        'tour_id',
        'nombre_cliente',
        'email_cliente',
        'telefono',
        'fecha_reserva',
        'num_personas',
        'estado',
        'comentarios'
    ];

    public function __construct() {
        parent::__construct();
    }

    // Obtener reservaciones por tour
    public function getPorTour($tourId) {
        $sql = "SELECT * FROM {$this->table} WHERE tour_id = ? ORDER BY fecha_reserva DESC";
        return $this->db->select($sql, [$tourId]);
    }

    // Obtener reservaciones por estado
    public function getPorEstado($estado) {
        $sql = "SELECT * FROM {$this->table} WHERE estado = ? ORDER BY fecha_reserva DESC";
        return $this->db->select($sql, [$estado]);
    }

    // Obtener reservaciones por fecha
    public function getPorFecha($fecha) {
        $sql = "SELECT * FROM {$this->table} WHERE fecha_reserva = ? ORDER BY creado DESC";
        return $this->db->select($sql, [$fecha]);
    }

    // Obtener reservaciones con información del tour
    public function getConTour() {
        $sql = "SELECT r.*, t.titulo as tour_titulo, t.precio as tour_precio 
                FROM {$this->table} r 
                LEFT JOIN tours t ON r.tour_id = t.id 
                ORDER BY r.fecha_reserva DESC";
        return $this->db->select($sql);
    }

    // Cambiar estado de una reservación
    public function cambiarEstado($id, $estado) {
        $sql = "UPDATE {$this->table} SET estado = ? WHERE id = ?";
        return $this->db->update($sql, [$estado, $id]);
    }
} 