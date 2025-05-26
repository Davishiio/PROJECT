<?php
class EditorialesController {
    public function index() {
        $editorial = new Editoriales();
        $data = $editorial->all();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        $editorial = new Editoriales();
        $success = $editorial->create($data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $editorial = new Editoriales();
        $success = $editorial->update($id, $data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function show($id) {
        $editorial = new Editoriales();
        $data = $editorial->find($id);

        if ($data) {
            echo json_encode($data);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Editorial no encontrada']);
        }
    }

    public function destroy($id) {
        $editorial = new Editoriales();
        $success = $editorial->delete($id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }
}
