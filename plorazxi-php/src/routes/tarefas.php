<?php

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;

    class Tarefas {
        private DataBase $db;

        public function __construct(DataBase $db) 
        {
            $this->db = $db;
        }
    }
?>