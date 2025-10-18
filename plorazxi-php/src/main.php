<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once 'vendor/autoload.php';
require_once 'db/DataBase.php';
require_once 'routes/Tarefas.php';

$db = new DataBase();
$routerTarefas = new Tarefas($db);

// Cria o aplicativo Slim
$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

$app->get('/', function (Request $request, Response $response, $args) {
    $payload = json_encode(['message' => 'API online']);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/tarefas', [$routerTarefas, 'get']);

$app->post('/tarefas', [$routerTarefas, 'post']);

$app->put('/tarefas/{id}', [$routerTarefas, 'put']);

// Executa o Slim
$app->run();
