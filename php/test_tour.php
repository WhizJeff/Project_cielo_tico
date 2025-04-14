<?php
require_once 'config/config.php';
require_once 'includes/database.php';
require_once 'models/Tour.php';

echo "=== Prueba del Modelo Tour ===\n";

try {
    $tour = new Tour();
    
    // Crear un tour de prueba
    $nuevoTour = [
        'titulo' => 'Tour Volcán Arenal',
        'descripcion' => 'Explora uno de los volcanes más activos de Costa Rica',
        'precio' => 99.99,
        'duracion' => '8 horas',
        'incluye' => 'Transporte, Almuerzo, Guía',
        'no_incluye' => 'Propinas, Bebidas alcohólicas',
        'activo' => true
    ];
    
    $id = $tour->create($nuevoTour);
    echo "✓ Tour creado con ID: $id\n";
    
    // Obtener el tour creado
    $tourCreado = $tour->getById($id);
    echo "✓ Tour recuperado: {$tourCreado['titulo']}\n";
    
    // Actualizar el tour
    $actualizacion = [
        'precio' => 109.99,
        'duracion' => '9 horas'
    ];
    $tour->update($id, $actualizacion);
    echo "✓ Tour actualizado\n";
    
    // Obtener todos los tours
    $todos = $tour->getAll();
    echo "✓ Total de tours: " . count($todos) . "\n";
    
    // Buscar por título
    $busqueda = $tour->buscarPorTitulo('Arenal');
    echo "✓ Tours encontrados con 'Arenal': " . count($busqueda) . "\n";
    
    // Obtener tours con reservaciones
    $conReservaciones = $tour->getConReservaciones();
    echo "✓ Tours con conteo de reservaciones: " . count($conReservaciones) . "\n";
    
    // Eliminar el tour de prueba
    $tour->delete($id);
    echo "✓ Tour eliminado correctamente\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 