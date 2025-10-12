<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once 'vendor/autoload.php';
require_once 'db/db.php';
require_once 'routes/tarefas.php';

$db = new DataBase();
$routerTarefas = new Tarefas($db);

// Cria o aplicativo Slim
$app = AppFactory::create();

// Adiciona um Middleware de Roteamento.
$app->addRoutingMiddleware();

$app->get('/', function (Request $request, Response $response, $args) {
    $payload = json_encode(['message' => 'API online']);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

// Executa o Slim
$app->run();
