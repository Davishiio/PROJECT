<?php
class Prestamos
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function all()
    {
        $sql = "SELECT 
                    p.*, 
                    u.nombre AS usuario_nombre, 
                    l.titulo AS libro_titulo
                FROM prestamos p
                INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
                INNER JOIN ejemplares e ON p.id_ejemplar = e.id_ejemplar
                INNER JOIN libros l ON e.id_libro = l.id_libro";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM prestamos WHERE id_prestamo = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function filterByDevuelto($valor)
    {
        $stmt = $this->db->prepare("SELECT * FROM prestamos WHERE devuelto = ?");
        $stmt->execute([$valor]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUsuario($id_usuario)
    {
        $stmt = $this->db->prepare("SELECT * FROM prestamos WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO prestamos (id_usuario, id_ejemplar, fecha_prestamo, fecha_devolucion, fecha_entregado, devuelto) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['id_usuario'],
            $data['id_ejemplar'],
            $data['fecha_prestamo'] ?? null,
            $data['fecha_devolucion'] ?? null,
            $data['fecha_entregado'] ?? null,
            $data['devuelto'] ?? 0
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE prestamos SET id_usuario = ?, id_ejemplar = ?, fecha_prestamo = ?, fecha_devolucion = ?, fecha_entregado = ?, devuelto = ? WHERE id_prestamo = ?");
        return $stmt->execute([
            $data['id_usuario'],
            $data['id_ejemplar'],
            $data['fecha_prestamo'] ?? null,
            $data['fecha_devolucion'] ?? null,
            $data['fecha_entregado'] ?? null,
            $data['devuelto'] ?? 0,
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM prestamos WHERE id_prestamo = ?");
        return $stmt->execute([$id]);
    }
   public function findByUser($id_usuario)
{
    $sql = "SELECT 
                p.*, 
                u.nombre AS usuario_nombre, 
                l.titulo AS libro_titulo
            FROM prestamos p
            INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
            INNER JOIN ejemplares e ON p.id_ejemplar = e.id_ejemplar
            INNER JOIN libros l ON e.id_libro = l.id_libro
            WHERE p.id_usuario = ?";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$id_usuario]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
