<?php
class AutoresController {
    public function index() {
        $autor = new Autores();
        $data = $autor->all();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        $autor = new Autores();
        $success = $autor->create($data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $autor = new Autores();
        $success = $autor->update($id, $data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function show($id) {
        $autor = new Autores();
        $data = $autor->find($id);

        if ($data) {
            echo json_encode($data);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Autor no encontrado']);
        }
    }

    public function destroy($id) {
        $autor = new Autores();
        $success = $autor->delete($id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }
}
