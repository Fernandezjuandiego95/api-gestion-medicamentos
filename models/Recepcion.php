<?php

class Recepcion {
    private $connection;
    private $table_recepciones = 'recepciones';

    public $id;
    public $fecha_hora;
    public $numero_factura;
    public $cantidad;
    public $lote;
    public $registro_invima;
    public $fecha_vencimiento;
    public $descripcion_estado_producto;
    public $id_producto;
    public $id_proveedor;

    public function __construct($db) {
        $this->connection = $db;
    }

    
    //Listar proveedor
    public function listar() {
        $query = "SELECT r.*, p.nombre AS producto, pr.nombre_contacto AS proveedor
            FROM {$this->table_recepciones} r
            JOIN productos p ON r.id_producto = p.id
            JOIN proveedores pr ON r.id_proveedor = pr.id
            ORDER BY r.id DESC";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Registrar proveedor
    public function registrar() {
        $query = "INSERT INTO {$this->table_recepciones}
                (fecha_hora, numero_factura, cantidad, lote, registro_invima, fecha_vencimiento, descripcion_estado_producto, id_producto, id_proveedor)
                VALUES (NOW(), :numero_factura, :cantidad, :lote, :registro_invima, :fecha_vencimiento, :descripcion_estado_producto, :id_producto, :id_proveedor)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':numero_factura', $this->numero_factura);
        $stmt->bindParam(':cantidad', $this->cantidad);
        $stmt->bindParam(':lote', $this->lote);
        $stmt->bindParam(':registro_invima', $this->registro_invima);
        $stmt->bindParam(':fecha_vencimiento', $this->fecha_vencimiento);
        $stmt->bindParam(':descripcion_estado_producto', $this->descripcion_estado_producto);
        $stmt->bindParam(':id_producto', $this->id_producto);
        $stmt->bindParam(':id_proveedor', $this->id_proveedor);
        return $stmt->execute();
    }


    //Actualizar recepción
    public function actualizar() {
        $query = "UPDATE {$this->table_recepciones}
                  SET numero_factura = :numero_factura,
                      cantidad = :cantidad,
                      lote = :lote,
                      registro_invima = :registro_invima,
                      fecha_vencimiento = :fecha_vencimiento,
                      descripcion_estado_producto = :descripcion_estado_producto,
                      id_producto = :id_producto,
                      id_proveedor = :id_proveedor
                  WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':numero_factura', $this->numero_factura);
        $stmt->bindParam(':cantidad', $this->cantidad);
        $stmt->bindParam(':lote', $this->lote);
        $stmt->bindParam(':registro_invima', $this->registro_invima);
        $stmt->bindParam(':fecha_vencimiento', $this->fecha_vencimiento);
        $stmt->bindParam(':descripcion_estado_producto', $this->descripcion_estado_producto);
        $stmt->bindParam(':id_producto', $this->id_producto);
        $stmt->bindParam(':id_proveedor', $this->id_proveedor);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    //Eliminar recepción
    public function eliminar() {
        $query = "DELETE FROM {$this->table_recepciones} WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount(); 
    }
}
