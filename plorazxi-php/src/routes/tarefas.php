<?php

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;

    class Tarefas {
        private DataBase $db;

        public function __construct(DataBase $db) 
        {
            $this->db = $db;
        }

        public function get(Request $request, Response $response, array $args) {
            $data = $this->db->getAllTasks();
            $response->getBody()->write(json_encode($data));
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function post(Request $request, Response $response, array $args) {
            $parametros = (array) $request->getParsedBody();
            $nome = (string) $parametros['nome'];
            $descricao = (string) $parametros['descricao'];
            $data = $this->db->insertTask($nome, $descricao);
            $response->getBody()->write($data);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function put(Request $request, Response $response, array $args) {
            $parametros = (array) $request->getParsedBody();
            $idTask = (int) $args['id'];
            $nome = $parametros['nome'] ?? null;
            $descricao = $parametros['descricao'] ?? null;
            $concluida = $parametros['concluida'] ?? null;
            if(!is_null($concluida)) $concluida = (bool) $concluida;
            $data = $this->db->updateTask($idTask, $nome, $descricao, $concluida);
            $response->getBody()->write($data);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function delete(Request $request, Response $response, array $args) {
            $idTask = (int) $args['id'];
            $data = $this->db->deleteTask($idTask);
            $response->getBody()->write($data);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>