<?php
require_once 'core/Controller.php'; 

class LibroController extends Controller
{
    
    public function __construct()
    {
        parent::__construct(); 
    }
    public function index()
    {
        $id_usuario = $this->user['id'];
        $rol = $this->user['role'];
        $this->authorize([1, 2], $id_usuario); 

        $libro = new Libros();

        if ($rol == 2) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'No tienes permisos']);
            return;
        } else {
            $data = $libro->all();
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function store()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $libro = new Libros();
        $success = $libro->create($data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $libro = new Libros();
        $success = $libro->update($id, $data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function show($id)
    {
        $libro = new Libros();
        $data = $libro->find($id);

        if ($data) {
            echo json_encode($data);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Libro no encontrado']);
        }
    }

    public function destroy($id)
    {
        $libro = new Libros();
        $success = $libro->delete($id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }
}
