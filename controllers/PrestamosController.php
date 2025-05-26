<?php
class PrestamosController {
    public function index() {
        $prestamos = new Prestamos();
        $data = $prestamos->all();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function show($id) {
        $prestamos = new Prestamos();
        $data = $prestamos->find($id);
        header('Content-Type: application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Préstamo no encontrado']);
        }
    }

    public function devuelto($valor) {
        // valor debe ser '0' o '1'
        if ($valor !== '0' && $valor !== '1') {
            http_response_code(400);
            echo json_encode(['error' => 'Parámetro inválido, debe ser 0 o 1']);
            return;
        }
        $prestamos = new Prestamos();
        $data = $prestamos->filterByDevuelto($valor);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function devolucion($id_usuario) {
        if (!is_numeric($id_usuario)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID usuario inválido']);
            return;
        }
        $prestamos = new Prestamos();
        $data = $prestamos->getByUsuario($id_usuario);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        $prestamos = new Prestamos();
        $success = $prestamos->create($data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $prestamos = new Prestamos();
        $success = $prestamos->update($id, $data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function destroy($id) {
        $prestamos = new Prestamos();
        $success = $prestamos->delete($id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }
}
