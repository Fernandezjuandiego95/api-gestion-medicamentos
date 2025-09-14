<?php

class Producto {
    private $connection;
    private $table_productos = 'productos';

    public $id;
    public $codigo;
    public $nombre;
    public $descripcion;
    public $estado;
    public $laboratorio;
    public $fecha_registro;

    public function __construct($db) {
        $this->connection = $db;
    }


    //Leer o listar productos
    public function listar() {
        $query = "SELECT * FROM {$this->table_productos} ORDER BY id DESC";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Agrgar o registrar producto
    public function registrar() {
        $query = "INSERT INTO {$this->table_productos} (codigo, nombre, descripcion, estado, laboratorio)
                VALUES (:codigo, :nombre, :descripcion, :estado, :laboratorio)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':codigo', $this->codigo);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':laboratorio', $this->laboratorio);
        return $stmt->execute();
    }


    //Actualizar un producto
    public function actualizar() {
        $query = "UPDATE {$this->table_productos}
                  SET codigo = :codigo, nombre = :nombre, descripcion = :descripcion, estado = :estado, laboratorio = :laboratorio
                  WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':codigo', $this->codigo);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':laboratorio', $this->laboratorio);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    //Eliminar un producto
    public function eliminar() {
        $query = "DELETE FROM {$this->table_productos} WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount(); 
    }
}
