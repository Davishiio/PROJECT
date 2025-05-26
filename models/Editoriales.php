<?php
class Editoriales
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function all()
    {
        $stmt = $this->db->query("SELECT id_editorial, nombre_editorial FROM editoriales");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT id_editorial, nombre_editorial FROM editoriales WHERE id_editorial = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO editoriales (nombre_editorial) VALUES (?)");
        return $stmt->execute([
            $data['nombre_editorial']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE editoriales SET nombre_editorial = ? WHERE id_editorial = ?");
        return $stmt->execute([
            $data['nombre_editorial'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM editoriales WHERE id_editorial = ?");
        return $stmt->execute([$id]);
    }
}
