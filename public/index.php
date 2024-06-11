<?php

use Max\Aluraplay\Controllers\Error404Controller;
use Max\Aluraplay\Infra\Database\ConnectionDB;

// Sempre que eu for trabalhar com sessions preciso iniciar a session;
// Aqui estou ativando a session de forma GLOBALMENTE
session_start();

// Com Frontend Controll consigo importar somente uma vez o autoload
// funcionando assim para todos os arquivos que precisariam dele
require_once __DIR__ . '/../vendor/autoload.php';

$routes = require_once __DIR__ . '/../config/routes.php';

$connectionBD = ConnectionDB::execute();

// se caminho/endpoint não for informado redirecionamos para a "/"
$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
// Capturamos o método http
$httpMethod = $_SERVER['REQUEST_METHOD'];

$key = "$httpMethod|$pathInfo";

$isLoginRoute = $pathInfo === "/login";

// Aqui seria basicamento um "Midlleware" que verifica se o usuário está logado
// Um middleware GLOBAL para todas as rotas da aplicação
if (!array_key_exists('logado', $_SESSION) && !$isLoginRoute) {
    header('Location: /login');
    return;
}


if (array_key_exists($key, $routes)) {
    $controllerClass = $routes[$key];

    $controller = new $controllerClass($connectionBD);
} else {
    $controller = new Error404Controller();
}

if ($key == "POST|/login") {

    $controller->auth();
} else if ($key == "GET|/logout") {
    // echo "olá";
    // exit();
    $controller->logout();
} else {
    $controller->execute();
}
