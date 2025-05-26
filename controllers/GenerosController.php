<?php
class GenerosController {
    public function index() {
        $genero = new Generos();
        $data = $genero->all();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        $genero = new Generos();
        $success = $genero->create($data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $genero = new Generos();
        $success = $genero->update($id, $data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function show($id) {
        $genero = new Generos();
        $data = $genero->find($id);

        if ($data) {
            echo json_encode($data);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Género no encontrado']);
        }
    }

    public function destroy($id) {
        $genero = new Generos();
        $success = $genero->delete($id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }
}
