<?php

class Proveedor {
    private $connection;
    private $table_proveedores = 'proveedores';

    public $id;
    public $tipo_identificacion;
    public $numero_identificacion;
    public $razon_social;
    public $direccion;
    public $nombre_contacto;
    public $celular;
    public $actividad_economica;

    public function __construct($db) {
        $this->connection = $db;
    }


    //Listar provvedores
    public function listar() {
        $query = "SELECT * FROM {$this->table_proveedores} ORDER BY id DESC";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Registrar proveedores
    public function registrar() {
        $query = "INSERT INTO {$this->table_proveedores}
               (tipo_identificacion, numero_identificacion, razon_social, direccion, nombre_contacto, celular, actividad_economica)
               VALUES (:tipo_identificacion, :numero_identificacion, :razon_social, :direccion, :nombre_contacto, :celular, :actividad_economica)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':tipo_identificacion', $this->tipo_identificacion);
        $stmt->bindParam(':numero_identificacion', $this->numero_identificacion);
        $stmt->bindParam(':razon_social', $this->razon_social);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':nombre_contacto', $this->nombre_contacto);
        $stmt->bindParam(':celular', $this->celular);
        $stmt->bindParam(':actividad_economica', $this->actividad_economica);
        return $stmt->execute();
    }


    //Actualizar proveedor
    public function actualizar() {
        $query = "UPDATE {$this->table_proveedores}
                  SET tipo_identificacion = :tipo_identificacion,
                      numero_identificacion = :numero_identificacion,
                      razon_social = :razon_social,
                      direccion = :direccion,
                      nombre_contacto = :nombre_contacto,
                      celular = :celular,
                      actividad_economica = :actividad_economica
                  WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':tipo_identificacion', $this->tipo_identificacion);
        $stmt->bindParam(':numero_identificacion', $this->numero_identificacion);
        $stmt->bindParam(':razon_social', $this->razon_social);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':nombre_contacto', $this->nombre_contacto);
        $stmt->bindParam(':celular', $this->celular);
        $stmt->bindParam(':actividad_economica', $this->actividad_economica);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    //Eliminar proveedor
    public function eliminar() {
        $query = "DELETE FROM {$this->table_proveedores} WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount(); 
    }
}
