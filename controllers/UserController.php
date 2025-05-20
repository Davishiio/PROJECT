<?php
class UserController {
    public function index() {
        $user = new User();
        $data = $user->all();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        $user = new User();
        $success = $user->create($data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $user = new User();
        $success = $user->update($id, $data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }
    public function show($id) {
    $user = new User();
    $data = $user->find($id);

    if ($data) {
        echo json_encode($data);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Usuario no encontrado']);
    }
}


    public function destroy($id) {
        $user = new User();
        $success = $user->delete($id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }
}
