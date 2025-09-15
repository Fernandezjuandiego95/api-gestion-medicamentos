<?php
// controllers/RecepcionController.php
require_once __DIR__ . "/../models/Recepcion.php";

class RecepcionController {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }


    //Listar recepcion
    public function listar() {
        $model = new Recepcion($this->db);
        $rows = $model->listar();
        echo json_encode($rows);
    }


    //Registrar recepcion
    public function registrar() {
        $data = json_decode(file_get_contents('php://input'), true);
        $required = ['numero_factura','cantidad','lote','registro_invima','descripcion_estado_producto','id_producto','id_proveedor'];
        foreach($required as $r) {
            if (!isset($data[$r]) || $data[$r] === '') {
                http_response_code(400);
                echo json_encode(['message' => 'Faltan campos requeridos: ' . $r]);
                return;
            }
        }
        $model = new Recepcion($this->db);
        $model->numero_factura = $data['numero_factura'];
        $model->cantidad = (int)$data['cantidad'];
        $model->lote = $data['lote'] ?? null;
        $model->registro_invima = $data['registro_invima'] ?? null;
        $model->fecha_vencimiento = $data['fecha_vencimiento'] ?? null;
        $model->descripcion_estado_producto = $data['descripcion_estado_producto'] ?? null;
        $model->id_producto = (int)$data['id_producto'];
        $model->id_proveedor = (int)$data['id_proveedor'];

        try {
            if ($model->registrar()) {
                echo json_encode(['message' => 'Recepción creada exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Error al crear la recepción']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
        }
    }


    //Actualizar recepción
    public function actualizar() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'El campo id es requerido']);
            return;
        }

        $model = new Recepcion($this->db);
        $model->id = $data['id'];
        $model->numero_factura = $data['numero_factura'] ?? '';
        $model->cantidad = (int)($data['cantidad'] ?? 0);
        $model->lote = $data['lote'] ?? null;
        $model->registro_invima = $data['registro_invima'] ?? null;
        $model->fecha_vencimiento = $data['fecha_vencimiento'] ?? null;
        $model->descripcion_estado_producto = $data['descripcion_estado_producto'] ?? null;
        $model->id_producto = (int)($data['id_producto'] ?? 0);
        $model->id_proveedor = (int)($data['id_proveedor'] ?? 0);

        try {
            if ($model->actualizar()) {
                echo json_encode(['message' => 'Recepción actualizada exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Error al actualizar la recepción']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
        }
    }

    //Eliminar recepción
    public function eliminar() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'El campo id es requerido']);
            return;
        }

        $model = new Recepcion($this->db);
        $model->id = $data['id'];

        try {
            $resultado = $model->eliminar();

            if ($resultado > 0) {
                echo json_encode(['message' => 'Recepción eliminada exitosamente']);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Recepción no encontrada con id ' . $data['id']]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
