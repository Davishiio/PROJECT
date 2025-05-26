<?php
class Controller
{
    protected $user;

    public function __construct()
    {
        // Leer encabezados
        $headers = getallheaders();

        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            $data = Auth::validateToken($token);

            if ($data) {
                // Guardar datos del usuario autenticado
                $this->user = [
                    'id' => $data->id_usuario,
                    'role' => $data->rol
                ];
            }
        }
    }

    protected function authorize(array $roles, $id_usuario = null)
    {
        if (!$this->user || !in_array($this->user['role'], $roles)) {
            http_response_code(403);
            echo json_encode(['error' => 'No autorizado']);
            exit;
        }
    }
}
