<?php
require_once 'core/Controller.php'; // Asegúrate de ajustar el path según tu estructura
require_once 'models/Prestamos.php';
require_once 'vendor/autoload.php';
require_once 'core/PDFGeneratorTrait.php';
use Core\PDFGeneratorTrait;
class PrestamosController extends Controller
{
    public function __construct()
    {
        parent::__construct(); // Muy importante para cargar $this->user
    }

    use PDFGeneratorTrait;

    public function generarPDF()
    {
        $this->generarPDFBase('Prestamos', 'Reporte de Préstamos');
    }
    public function index()
    {
        $id_usuario = $this->user['id'];
        $rol = $this->user['role'];
        $this->authorize([1, 2], $id_usuario); // Validamos acceso

        $prestamos = new Prestamos();

        if ($rol == 2) {
            // Si es cliente, sólo muestra sus préstamos
            $data = $prestamos->findByUser($id_usuario);
        } else {
            // Si es admin, muestra todos
            $data = $prestamos->all();
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    }


    public function show($id)
    {
        $id_usuario = $this->user['id'];
        $rol = $this->user['role'];
        $this->authorize([1, 2], $id_usuario);

        $prestamos = new Prestamos();
        if ($rol == 1) {
            $data = $prestamos->find($id);
            header('Content-Type: application/json');
            if ($data) {
                echo json_encode($data);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Préstamo no encontrado']);
            }
        } else {

        }

    }


    public function devuelto($valor)
    {
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

    public function devolucion($id_usuario)
    {
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

    public function store()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $prestamos = new Prestamos();
        $success = $prestamos->create($data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $prestamos = new Prestamos();
        $success = $prestamos->update($id, $data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function destroy($id)
    {
        $prestamos = new Prestamos();
        $success = $prestamos->delete($id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }
}
