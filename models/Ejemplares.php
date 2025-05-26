<?php
class Ejemplares
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function all()
    {
        $stmt = $this->db->query("
            SELECT e.id_ejemplar, e.numero_serie, e.disponible, l.titulo
            FROM ejemplares e
            JOIN libros l ON e.id_libro = l.id_libro
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("
            SELECT e.id_ejemplar, e.numero_serie, e.disponible, l.titulo
            FROM ejemplares e
            JOIN libros l ON e.id_libro = l.id_libro
            WHERE e.id_ejemplar = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO ejemplares (id_libro, numero_serie, disponible)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([
            $data['id_libro'],
            $data['numero_serie'],
            $data['disponible']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE ejemplares
            SET id_libro = ?, numero_serie = ?, disponible = ?
            WHERE id_ejemplar = ?
        ");
        return $stmt->execute([
            $data['id_libro'],
            $data['numero_serie'],
            $data['disponible'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM ejemplares WHERE id_ejemplar = ?");
        return $stmt->execute([$id]);
    }

    public function setDisponibilidad($id, $estado)
    {
        $stmt = $this->db->prepare("UPDATE ejemplares SET disponible = ? WHERE id_ejemplar = ?");
        return $stmt->execute([$estado, $id]);
    }

    public function getByDisponibilidad($estado)
    {
        $stmt = $this->db->prepare("
            SELECT e.id_ejemplar, e.numero_serie, e.disponible, l.titulo
            FROM ejemplares e
            JOIN libros l ON e.id_libro = l.id_libro
            WHERE e.disponible = ?
        ");
        $stmt->execute([$estado]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
