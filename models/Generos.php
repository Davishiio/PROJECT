<?php
class Generos
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function all()
    {
        $stmt = $this->db->query("SELECT id_genero, nombre_genero FROM generos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT id_genero, nombre_genero FROM generos WHERE id_genero = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO generos (nombre_genero) VALUES (?)");
        return $stmt->execute([
            $data['nombre_genero']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE generos SET nombre_genero = ? WHERE id_genero = ?");
        return $stmt->execute([
            $data['nombre_genero'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM generos WHERE id_genero = ?");
        return $stmt->execute([$id]);
    }
}
