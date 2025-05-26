<?php
class Libros
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function all()
    {
        $stmt = $this->db->query("
            SELECT l.id_libro, l.titulo, l.numero_paginas, l.anio_edicion, l.precio,
                   a.nombre_autor, e.nombre_editorial, g.nombre_genero
            FROM libros l
            JOIN autores a ON l.id_autor = a.id_autor
            JOIN editoriales e ON l.id_editorial = e.id_editorial
            JOIN generos g ON l.id_genero = g.id_genero
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("
            SELECT l.id_libro, l.titulo, l.numero_paginas, l.anio_edicion, l.precio,
                   a.nombre_autor, e.nombre_editorial, g.nombre_genero
            FROM libros l
            JOIN autores a ON l.id_autor = a.id_autor
            JOIN editoriales e ON l.id_editorial = e.id_editorial
            JOIN generos g ON l.id_genero = g.id_genero
            WHERE l.id_libro = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO libros (titulo, id_autor, id_editorial, id_genero, numero_paginas, anio_edicion, precio)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['titulo'],
            $data['id_autor'],
            $data['id_editorial'],
            $data['id_genero'],
            $data['numero_paginas'],
            $data['anio_edicion'],
            $data['precio']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE libros
            SET titulo = ?, id_autor = ?, id_editorial = ?, id_genero = ?, numero_paginas = ?, anio_edicion = ?, precio = ?
            WHERE id_libro = ?
        ");
        return $stmt->execute([
            $data['titulo'],
            $data['id_autor'],
            $data['id_editorial'],
            $data['id_genero'],
            $data['numero_paginas'],
            $data['anio_edicion'],
            $data['precio'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM libros WHERE id_libro = ?");
        return $stmt->execute([$id]);
    }
}
