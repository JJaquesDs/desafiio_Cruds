<?php
    require_once "vendor/autoload.php";
    require_once "queries.php";

    class DataBase {
        private string $host;
        private string $dbname;
        private string $username;
        private string $password;

        public PDO $conn;

        public function __construct() {
            $this->host = getenv('HOST_DB');
            $this->dbname = getenv('NAME_DB');
            $this->username = getenv('USER_DB');
            $this->password = getenv('PASSWORD_DB');

            $this->connect();
            $this->create();
        }

        private function connect() {
            try{
                $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Erro de conexão: ".$e->getMessage();
                exit();
            }
        }

        private function create() {
            try {
                $query = new queries();
                $stmt = $this->conn->prepare($query->create);
                $stmt->execute();
                echo "criou";
            } catch (PDOException $e) {
                echo "Falha na criação da tabela: " . $e->getMessage();
            }
        }
    }
?>