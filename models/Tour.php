<?php
require_once __DIR__ . '/Model.php';

class Tour extends Model {
    protected $table = 'tours';
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'precio',
        'duracion',
        'incluye',
        'no_incluye',
        'activo'
    ];

    // Obtener tours activos
    public function getActivos() {
        $sql = "SELECT * FROM {$this->table} WHERE activo = 1";
        return $this->db->select($sql);
    }

    // Buscar tours por título
    public function buscarPorTitulo($titulo) {
        $sql = "SELECT * FROM {$this->table} WHERE titulo LIKE ?";
        return $this->db->select($sql, ["%$titulo%"]);
    }

    // Obtener tours con sus reservaciones
    public function getConReservaciones() {
        $sql = "SELECT t.*, COUNT(r.id) as total_reservaciones 
                FROM {$this->table} t 
                LEFT JOIN reservaciones r ON t.id = r.tour_id 
                GROUP BY t.id";
        return $this->db->select($sql);
    }
} 