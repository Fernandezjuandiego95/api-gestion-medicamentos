<?php

require_once __DIR__ . "/../models/Producto.php";

class ProductoController {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    

    //Listar productos
    public function listar() {
        $model = new Producto($this->db);
        $rows = $model->listar();
        echo json_encode($rows);
    }


    //Registrar producto
    public function registrar() {
        $data = json_decode(file_get_contents('php://input'), true);
        $required = ['codigo','nombre','descripcion','estado','laboratorio'];
        foreach($required as $r) {
            if (empty($data[$r])) {
                http_response_code(400);
                echo json_encode(['message' => 'Faltan campos requeridos: ' . $r]);
                return;
            }
        }
        $model = new Producto($this->db);
        $model->codigo = $data['codigo'];
        $model->nombre = $data['nombre'];
        $model->descripcion = $data['descripcion'] ?? null;
        $model->estado = $data['estado'] ?? 'Activo';
        $model->laboratorio = $data['laboratorio'];

        try {
            if ($model->registrar()) {
                echo json_encode(['message' => 'Producto creado exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Error al crear producto']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
        }
    }


    //Actualizar producto
    public function actualizar() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'El campo id es requerido']);
            return;
        }

        $model = new Producto($this->db);
        $model->id = $data['id'];
        $model->codigo = $data['codigo'] ?? '';
        $model->nombre = $data['nombre'] ?? '';
        $model->descripcion = $data['descripcion'] ?? null;
        $model->estado = $data['estado'] ?? 'Activo';
        $model->laboratorio = $data['laboratorio'] ?? '';

        try {
            if ($model->actualizar()) {
                echo json_encode(['message' => 'Producto actualizado exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Error al actualizar producto']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
        }
    }

    //Eliminar producto
    public function eliminar() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'El campo id es requerido']);
            return;
        }

        $model = new Producto($this->db);
        $model->id = $data['id'];

        try {
            $resultado = $model->eliminar();

            if ($resultado > 0) {
                echo json_encode(['message' => 'Producto eliminado exitosamente']);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Producto no encontrado con id ' . $data['id']]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
