<?php
class Usuarios
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function all()
    {
        //  $stmt = $this->db->query("SELECT id_usuario, nombre, email, id_rol FROM usuarios");
        $stmt = $this->db->query("SELECT * FROM usuarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function find($id)
    {
        $stmt = $this->db->prepare("
        SELECT u.id_usuario, u.nombre, u.email, r.nombre_rol 
        FROM usuarios u
        JOIN roles r ON u.id_rol = r.id_rol
        WHERE u.id_usuario = ?
    ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, email, password, id_rol) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['nombre'],
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $data['id_rol']
        ]);
    }
public function findByUsername($email)
{
    $stmt = $this->db->prepare("SELECT id_usuario, nombre, email, password, id_rol FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}




    public function update($id, $data)
    {
        // Si password no está definido o vacío, no se actualiza la contraseña
        if (!empty($data['password'])) {
            $stmt = $this->db->prepare("UPDATE usuarios SET nombre = ?, email = ?, password = ?, id_rol = ? WHERE id_usuario = ?");
            return $stmt->execute([
                $data['nombre'],
                $data['email'],
                password_hash($data['password'], PASSWORD_BCRYPT),
                $data['id_rol'],
                $id
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE usuarios SET nombre = ?, email = ?, id_rol = ? WHERE id_usuario = ?");
            return $stmt->execute([
                $data['nombre'],
                $data['email'],
                $data['id_rol'],
                $id
            ]);
        }
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
        return $stmt->execute([$id]);
    }

}
