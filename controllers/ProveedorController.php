<?php

require_once __DIR__ . "/../models/Proveedor.php";

class ProveedorController {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }


    //listar proveedores
    public function listar() {
        $model = new Proveedor($this->db);
        $rows = $model->listar();
        echo json_encode($rows);
    }

    //registrar proveedor
    public function registrar() {
        $data = json_decode(file_get_contents('php://input'), true);
        $required = ['tipo_identificacion','numero_identificacion','razon_social','direccion','nombre_contacto','celular', 'actividad_economica'];
        foreach($required as $r) {
            if (empty($data[$r])) {
                http_response_code(400);
                echo json_encode(['message' => 'Faltan campos requeridos: ' . $r]);
                return;
            }
        }
        $model = new Proveedor($this->db);
        $model->tipo_identificacion = $data['tipo_identificacion'];
        $model->numero_identificacion = $data['numero_identificacion'];
        $model->razon_social = $data['razon_social'];
        $model->direccion = $data['direccion'] ?? null;
        $model->nombre_contacto = $data['nombre_contacto'] ?? null;
        $model->celular = $data['celular'] ?? null;
        $model->actividad_economica = $data['actividad_economica'] ?? null;

        try {
            if ($model->registrar()) {
                echo json_encode(['message' => 'Proveedor creado exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Error al crear proveedor']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
        }
    }


    //Actualizar proveedor
    public function actualizar() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'El campo id es requerido']);
            return;
        }

        $model = new Proveedor($this->db);
        $model->id = $data['id'];
        $model->tipo_identificacion = $data['tipo_identificacion'] ?? '';
        $model->numero_identificacion = $data['numero_identificacion'] ?? '';
        $model->razon_social = $data['razon_social'] ?? '';
        $model->direccion = $data['direccion'] ?? null;
        $model->nombre_contacto = $data['nombre_contacto'] ?? null;
        $model->celular = $data['celular'] ?? null;
        $model->actividad_economica = $data['actividad_economica'] ?? null;

        try {
            if ($model->actualizar()) {
                echo json_encode(['message' => 'Proveedor actualizado exitosamente']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Error al actualizar proveedor']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
        }
    }

    //Eliminar proveedor
    public function eliminar() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'El campo id es requerido']);
            return;
        }

        $model = new Proveedor($this->db);
        $model->id = $data['id'];

        try {
            $resultado = $model->eliminar();

            if ($resultado > 0) {
                echo json_encode(['message' => 'Proveedor eliminado exitosamente']);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Proveedor no encontrado con id ' . $data['id']]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
