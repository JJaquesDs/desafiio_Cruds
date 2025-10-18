<?php
    require_once "vendor/autoload.php";
    require_once "Queries.php";

    // Comandos para importar a lib para importar as variaveis de ambiente
    $dotenv = Dotenv\Dotenv::createUnsafeImmutable(dirname(__DIR__, 2));
    $dotenv->load();

    // Classe que se relaciona com o Banco de Dados
    class DataBase {
        private string $host;
        private string $dbname;
        private string $username;
        private string $password;

        private PDO $conn;
        private Queries $queries;

        public function __construct() {
            // Carrega as variaveis de ambiente para a conexão com o DB
            $this->host = getenv('HOST_DB');
            $this->dbname = getenv('NAME_DB');
            $this->username = getenv('USER_DB');
            $this->password = getenv('PASSWORD_DB');
            $this->queries = new Queries();

            $this->connect();
            $this->create();
        }

        // Função para a conexão com o Banco
        private function connect() {
            try{
                $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Erro de conexão: ".$e->getMessage();
                exit();
            }
        }

        // Função para a criação das tabelas que serão utilizadas no DB
        private function create() {
            try {
                $stmt = $this->conn->prepare($this->queries->create);
                $stmt->execute();
            } catch (PDOException $e) {
                echo "Falha na criação da tabela: " . $e->getMessage();
            }
        }

        // Funções diretamente ligadas a API
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
            // varificação do que há para atualizar na task
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
            // Se não encontrar nada para alterar responder a requisição com um erro
            if(empty($toUpdate)) 
                return json_encode([
                    'msg' => 'Nenhum dado para alterar'
                ]);
            $condicao = ' WHERE id = ?;';
            $values[] = $id;
            // Criação do SQL
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

        public function deleteTask(int $id) {
            try {
                $stmt = $this->conn->prepare($this->queries->deleteTask);
                $stmt->execute([$id]);
                return json_encode([
                    'msg' => 'Tarefa excluida com sucesso'
                ]);
            } catch (PDOException $e) {
                return json_encode([
                    'msg' => 'Falha ao deletar tarefa',
                    'error' => $e
                ]);
            }
        }
    }
?>