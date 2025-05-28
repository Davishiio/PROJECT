<?php
// Define la base real de tu proyecto, cambia si es necesario
$basePath = '/PROJECT';
$uri = str_replace($basePath, '', $_SERVER['REQUEST_URI']);
$uri = parse_url($uri, PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$segments = explode('/', trim($uri, '/'));
$resource = $segments[0] ?? null;
$controllerMethod = $segments[1] ?? null;
$params = array_slice($segments, 2);
$routes = [
    'usuarios' => 'UsuariosController',
    'libros' => 'LibroController',
    'empresas' => 'EmpresaController',
    'autores' => 'AutoresController',
    'editoriales' => 'EditorialesController',
    'generos' => 'GenerosController',
    'ejemplares' => 'EjemplarController',
    'prestamos' => 'PrestamosController',
    'pdf' => 'PDFController',
];



// Verificar recurso
if (!isset($routes[$resource])) {
    http_response_code(404);
    echo json_encode(['error' => "Recurso '$resource' no encontrado"]);
    exit;
}

$controllerName = $routes[$resource];

// Verificar controlador
if (!class_exists($controllerName)) {
    http_response_code(500);
    echo json_encode(['error' => "Controlador '$controllerName' no encontrado"]);
    exit;
}

// --- AQUI EMPIEZA LA VALIDACION DEL TOKEN JWT ---
// Excluir login y creación de usuario (POST /usuarios y POST /usuarios/login)
if (
    !(
        ($resource === 'usuarios' && $method === 'POST' && $controllerMethod === null) // Crear usuario
        ||
        ($resource === 'usuarios' && $controllerMethod === 'login') // Login
    )
) {
    // Obtener headers (en Apache o nginx puede variar)
    $headers = function_exists('apache_request_headers') ? apache_request_headers() : getallheaders();
    $authHeader = $headers['Authorization'] ?? null;

    $authHeader = $headers['Authorization'] ?? '';

    if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        http_response_code(401);
        echo json_encode(['error' => 'Token no proporcionado']);
        exit;
    }

    $token = $matches[1];

    require_once __DIR__ . '/../core/Auth.php';

    $userData = Auth::validateToken($token);

    if (!$userData) {
        http_response_code(401);
        echo json_encode(['error' => 'Token inválido o expirado']);
        exit;
    }

    $_REQUEST['user'] = (array) $userData;

}
// --- FIN VALIDACION DEL TOKEN JWT ---


// Instanciar el controlador
$controller = new $controllerName();
// Enrutamiento por método HTTP
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
        } elseif ($controllerMethod === 'login') {
            $controller->login();
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
