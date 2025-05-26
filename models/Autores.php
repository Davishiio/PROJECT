<?php
class Autores
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function all()
    {
        $stmt = $this->db->query("SELECT id_autor, nombre_autor, pais FROM autores");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT id_autor, nombre_autor, pais FROM autores WHERE id_autor = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO autores (nombre_autor, pais) VALUES (?, ?)");
        return $stmt->execute([
            $data['nombre_autor'],
            $data['pais']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE autores SET nombre_autor = ?, pais = ? WHERE id_autor = ?");
        return $stmt->execute([
            $data['nombre_autor'],
            $data['pais'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM autores WHERE id_autor = ?");
        return $stmt->execute([$id]);
    }
}
