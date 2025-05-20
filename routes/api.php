<?php
$basePath = '/PROJECT_MVC';
$uri = str_replace($basePath, '', $_SERVER['REQUEST_URI']);
$uri = parse_url($uri, PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$segments = explode('/', trim($uri, '/'));
$resource = $segments[0] ?? null;
$id = $segments[1] ?? null;
$extra = $segments[2] ?? null;

// 📦 Mapa de recursos a controladores
$routes = [
    'users' => 'UserController',
    'libros' => 'LibroController',
    'empresas' => 'EmpresaController'
];

// Verificamos si el recurso existe en el mapa
if (!isset($routes[$resource]) || $extra !== null) {
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no válida']);
    exit;
}

$controllerName = $routes[$resource];

if (!class_exists($controllerName)) {
    http_response_code(500);
    echo json_encode(['error' => "Controlador $controllerName no encontrado"]);
    exit;
}

$controller = new $controllerName();

switch ($method) {
    case 'GET':
        if ($id === null) {
            $controller->index();
        } else {
            $controller->show($id);
        }
        break;
    case 'POST':
        if ($id === null) {
            $controller->store();
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'POST no acepta ID']);
        }
        break;
    case 'PUT':
        if ($id !== null) {
            $controller->update($id);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'PUT requiere ID']);
        }
        break;
    case 'DELETE':
        if ($id !== null) {
            $controller->destroy($id);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'DELETE requiere ID']);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
}
