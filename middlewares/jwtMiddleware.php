<?php

require_once __DIR__ . "/../helpers/jwtHandler.php";

function getAuthorizationHeader(){
    $headers = null;
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    } 
    else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { 
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } 
    elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        
        if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
        }
    }
    return $headers;
}

function getBearerToken() {
    $headers = getAuthorizationHeader();
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(.*)$/i', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

function verificarToken($db) {
    $token = getBearerToken();
    if (!$token) {
        http_response_code(401);
        echo json_encode(['message' => 'Token no encontrado']);
        exit;
    }
    $data = JwtHandler::validateToken($token);
    if (!$data) {
        http_response_code(401);
        echo json_encode(['message' => 'Token inválido o expirado']);
        exit;
    }
    return $data;
}

