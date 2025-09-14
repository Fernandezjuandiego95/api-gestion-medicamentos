<?php
require_once __DIR__ . "/../models/Usuario.php";
require_once __DIR__ . "/../helpers/jwtHandler.php";

class AuthController {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function login() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['username']) || empty($data['password'])) {
            http_response_code(400);
            echo json_encode(['message' => 'username and password required']);
            return;
        }

        $userModel = new Usuario($this->db);
        $user = $userModel->consultarUsuario($data['username']);
        if (!$user) {
            http_response_code(401);
            echo json_encode(['message' => 'credenciales incorrectas']);
            return;
        }
        if (!password_verify($data['password'], $user['password_hash'])) {
            http_response_code(401);
            echo json_encode(['message' => 'credenciales incorrectas']);
            return;
        }
        $token = JwtHandler::generateToken($user);
        echo json_encode(['token' => $token, 'user' => ['id'=>$user['id'], 'username'=>$user['username']]]);
    }

    public function registrar_user() {

        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['username']) || empty($data['password'])) {
            http_response_code(400);
            echo json_encode(['message' => 'usuario y contraseña requiredo']);
            return;
        }
        $userModel = new Usuario($this->db);
        $existing = $userModel->consultarUsuario($data['username']);
        if ($existing) {
            http_response_code(400);
            echo json_encode(['message' => 'Nombre de usuario existente, porfavor elija otro usuario']);
            return;
        }

        $password_hash = password_hash($data['password'], PASSWORD_BCRYPT);
        $userModel->registrar($data['username'], $password_hash);
        echo json_encode(['message' => 'Usuario creado exitosamente']);
    }
}
