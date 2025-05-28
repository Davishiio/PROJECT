<?php
class PrestamoModel {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function obtenerPrestamosDetallados() {
        $sql = "SELECT 
                    p.id_prestamo,
                    u.nombre AS usuario,
                    e.numero_serie,
                    p.fecha_prestamo,
                    p.fecha_devolucion,
                    p.fecha_entregado,
                    p.devuelto
                FROM prestamos p
                JOIN usuarios u ON p.id_usuario = u.id_usuario
                JOIN ejemplares e ON p.id_ejemplar = e.id_ejemplar";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
