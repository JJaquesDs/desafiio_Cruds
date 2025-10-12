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

        }
    }
?>