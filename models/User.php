<?php
class User {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function find($id) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        return $stmt->execute([$data['name'], $data['email']]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['email'], $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
