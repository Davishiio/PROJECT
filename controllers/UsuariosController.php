<?php
class UsuariosController
{
    public function index()
    {
        $user = new Usuarios();
        $data = $user->all();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function store()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $user = new Usuarios();
        $success = $user->create($data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $user = new Usuarios();
        $success = $user->update($id, $data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }
    public function show($id)
    {
        $user = new Usuarios();
        $data = $user->find($id);

        if ($data) {
            echo json_encode($data);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Usuario no encontrado']);
        }
    }


    public function destroy($id)
    {
        $user = new Usuarios();
        $success = $user->delete($id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }
    public function login()
    {

        $input = json_decode(file_get_contents('php://input'), true);

        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';

        $usuarioModel = new Usuarios();

        $user = $usuarioModel->findByUsername($email);


        if (!$user || !password_verify($password, $user['password'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Credenciales inválidas']);
            return;
        }


        // Generar token JWT
        $token = Auth::generateToken($user['id_usuario'], $user['id_rol']);


        echo json_encode(['token' => $token]);
    }


}
