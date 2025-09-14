<?php

class Usuario {
    private $connection;
    private $table_usuarios = 'usuarios';

    public $id;
    public $username;
    public $password_hash;

    public function __construct($db) {
        $this->connection = $db;
    }

    public function registrar($username, $password_hash) {
        $query = "INSERT INTO {$this->table_usuarios} (username, password_hash) VALUES (:username, :password_hash)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password_hash', $password_hash);
        return $stmt->execute();
    }

   public function consultarUsuario($username) {
        $query = "SELECT * FROM {$this->table_usuarios} WHERE username = :username LIMIT 1";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } 
}
