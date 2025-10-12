<?php
    require_once "vendor/autoload.php";
    require_once "queries.php";

    $dotenv = Dotenv\Dotenv::createUnsafeImmutable(dirname(__DIR__, 2));
    $dotenv->load();

    class DataBase {
        private string $host;
        private string $dbname;
        private string $username;
        private string $password;

        private PDO $conn;
        private Queries $queries;

        public function __construct() {
            $this->host = getenv('HOST_DB');
            $this->dbname = getenv('NAME_DB');
            $this->username = getenv('USER_DB');
            $this->password = getenv('PASSWORD_DB');
            $this->queries = new Queries();

            $this->connect();
            $this->create();
        }

        private function connect() {
            try{
                $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Erro de conexão: ".$e->getMessage();
                exit();
            }
        }

        private function create() {
            try {
                $stmt = $this->conn->prepare($this->queries->create);
                $stmt->execute();
            } catch (PDOException $e) {
                echo "Falha na criação da tabela: " . $e->getMessage();
            }
        }
    }
?>