<?php
class EjemplarController {
    public function index() {
        $ejemplar = new Ejemplares();
        $data = $ejemplar->all();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        $ejemplar = new Ejemplares();
        $success = $ejemplar->create($data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $ejemplar = new Ejemplares();
        $success = $ejemplar->update($id, $data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function show($id) {
        $ejemplar = new Ejemplares();
        $data = $ejemplar->find($id);

        if ($data) {
            echo json_encode($data);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Ejemplar no encontrado']);
        }
    }

    public function destroy($id) {
        $ejemplar = new Ejemplares();
        $success = $ejemplar->delete($id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    // 👇 MÉTODO EXTRA: Cambiar disponibilidad
    public function cambiarDisponibilidad($id, $estado) {
        $ejemplar = new Ejemplares();
        $success = $ejemplar->setDisponibilidad($id, $estado);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    // 👇 MÉTODO EXTRA: Obtener solo ejemplares disponibles o no disponibles
    public function disponibles($estado) {
        $ejemplar = new Ejemplares();
        $data = $ejemplar->getByDisponibilidad($estado);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
