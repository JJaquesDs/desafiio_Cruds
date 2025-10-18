<?php
    class Queries {
        public string $create = "
            CREATE TABLE IF NOT EXISTS tarefas (
                id BIGINT NOT NULL AUTO_INCREMENT,
                nome VARCHAR(50),
                descricao VARCHAR(250),
                concluida BOOLEAN DEFAULT 0,

                PRIMARY KEY (id)
            ); 
        ";

        public string $getAllTasks = "
            SELECT * FROM tarefas;
        ";

        public string $insertTask = "
            INSERT tarefas(nome, descricao) VALUES (?, ?);
        ";

        public string $updateTask = "
            UPDATE tarefas
            SET 
        ";
    }
?>