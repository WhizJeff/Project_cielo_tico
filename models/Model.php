<?php

abstract class Model {
    protected $db;
    protected $table;
    protected $fillable = [];

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Obtener todos los registros
    public function getAll() {
        $sql = "SELECT * FROM {$this->table}";
        return $this->db->select($sql);
    }

    // Obtener un registro por ID
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->db->selectOne($sql, [$id]);
    }

    // Crear un nuevo registro
    public function create($data) {
        $fields = array_intersect_key($data, array_flip($this->fillable));
        
        if (empty($fields)) {
            throw new Exception("No hay campos válidos para insertar");
        }

        $columns = implode(', ', array_keys($fields));
        $values = implode(', ', array_fill(0, count($fields), '?'));
        
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
        return $this->db->insert($sql, array_values($fields));
    }

    // Actualizar un registro
    public function update($id, $data) {
        $fields = array_intersect_key($data, array_flip($this->fillable));
        
        if (empty($fields)) {
            throw new Exception("No hay campos válidos para actualizar");
        }

        $set = implode(' = ?, ', array_keys($fields)) . ' = ?';
        $sql = "UPDATE {$this->table} SET $set WHERE id = ?";
        
        $values = array_values($fields);
        $values[] = $id;
        
        return $this->db->update($sql, $values);
    }

    // Eliminar un registro
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->db->delete($sql, [$id]);
    }
} 