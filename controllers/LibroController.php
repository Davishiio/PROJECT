<?php
class LibroController {
    public function index() {
        $libro = new Libros();
        $data = $libro->all();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        $libro = new Libros();
        $success = $libro->create($data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $libro = new Libros();
        $success = $libro->update($id, $data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function show($id) {
        $libro = new Libros();
        $data = $libro->find($id);

        if ($data) {
            echo json_encode($data);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Libro no encontrado']);
        }
    }

    public function destroy($id) {
        $libro = new Libros();
        $success = $libro->delete($id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }
}
