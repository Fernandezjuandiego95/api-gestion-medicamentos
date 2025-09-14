<?php

class Database {
    private $host = "localhost";
    private $db_name = "gestion_medicamentos";
    private $username = "root";
    private $password = "";
    public $connection;

    public function getConnection() {
        $this->connection = null;
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
                $this->username,
                $this->password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            
        } catch(PDOException $e) {
            echo json_encode(["error" => "Conección Fallida: " . $e->getMessage()]);
            exit;
        }
        return $this->connection;
    }
}

?>