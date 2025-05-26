<?php
$basePath = '/PROJECT';
$uri = str_replace($basePath, '', $_SERVER['REQUEST_URI']);
$uri = parse_url($uri, PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$segments = explode('/', trim($uri, '/'));

$resource = $segments[0] ?? null;
$controllerMethod = $segments[1] ?? null;
$params = array_slice($segments, 2);

$routes = [
    'usuarios'     => 'UsuariosController',
    'libros'       => 'LibroController',
    'empresas'     => 'EmpresaController',
    'autores'      => 'AutoresController',
    'editoriales'  => 'EditorialesController',
    'generos'      => 'GenerosController',
    'ejemplares'   => 'EjemplarController',
    'prestamos'   => 'PrestamosController',
];

if (!isset($routes[$resource])) {
    http_response_code(404);
    echo json_encode(['error' => "Recurso '$resource' no encontrado"]);
    exit;
}

$controllerName = $routes[$resource];

if (!class_exists($controllerName)) {
    http_response_code(500);
    echo json_encode(['error' => "Controlador '$controllerName' no encontrado"]);
    exit;
}

$controller = new $controllerName();

switch ($method) {
    case 'GET':
        if ($controllerMethod === null) {
            $controller->index();
        } elseif (is_numeric($controllerMethod)) {
            $controller->show($controllerMethod);
        } else {
            if (method_exists($controller, $controllerMethod)) {
                call_user_func_array([$controller, $controllerMethod], $params);
            } else {
                http_response_code(404);
                echo json_encode(['error' => "Método '$controllerMethod' no disponible en $resource"]);
            }
        }
        break;

    case 'POST':
        if ($controllerMethod === null) {
            $controller->store();
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'POST no acepta ID ni métodos extra']);
        }
        break;

    case 'PUT':
        if ($controllerMethod !== null && is_numeric($controllerMethod)) {
            $controller->update($controllerMethod);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'PUT requiere un ID numérico']);
        }
        break;

    case 'DELETE':
        if ($controllerMethod !== null && is_numeric($controllerMethod)) {
            $controller->destroy($controllerMethod);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'DELETE requiere un ID numérico']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método HTTP no permitido']);
}
