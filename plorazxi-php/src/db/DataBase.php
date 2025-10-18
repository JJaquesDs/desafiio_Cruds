<?php
    require_once "vendor/autoload.php";
    require_once "Queries.php";

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

        public function getAllTasks() {
            $stmt = $this->conn->query($this->queries->getAllTasks);
            $data = $stmt->fetchAll();
            return $data;
        }

        public function insertTask(string $nome, string $descricao) {
            try {
                $stmt = $this->conn->prepare($this->queries->insertTask);
                $stmt->execute([$nome, $descricao]);
                return json_encode(['msg' => 'Tarefa adicionada com sucesso']);
            } catch (PDOException $e) {
                return json_encode([
                    'msg' => 'Erro ao adicionar tarefa',
                    'error' => $e->getMessage()
                ]);
            }
        }

        public function updateTask(int $id, ?string $nome, ?string $descricao, ?bool $concluida) {
            $toUpdate = [];
            $values = [];
            if(!is_null($nome)) {
                $toUpdate[] = 'nome = ?';
                $values[] = $nome;
            }
            if(!is_null($descricao)) {
                $toUpdate[] = 'descricao = ?';
                $values[] = $descricao;
            }
            if(!is_null($concluida)) {
                $toUpdate[] = 'concluida = ?';
                $values[] = (int) $concluida;
            }
            if(empty($toUpdate)) 
                return json_encode([
                    'msg' => 'Nenhum dado para alterar',
                    'array' => $toUpdate
                ]);
            $condicao = ' WHERE id = ?;';
            $values[] = $id;
            $sql = $this->queries->updateTask . implode(', ', $toUpdate) . $condicao;
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->execute($values);
                return json_encode(['msg' => 'Tarefa alterada com sucesso']);
            } catch (PDOException $e) {
                return json_encode([
                    'msg' => 'Falha ao fazer o update',
                    'error' => $e->getMessage()
                ]);
            }
        }
    }
?>