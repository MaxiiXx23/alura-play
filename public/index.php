<?php

use Max\Aluraplay\Controllers\Error404Controller;
use Max\Aluraplay\Infra\Database\ConnectionDB;
use Max\Aluraplay\Infra\Repositories\VideoRepository\VideoRepository;

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
if (array_key_exists($key, $routes)) {
    $controllerClass = $routes[$key];

    $controller = new $controllerClass($connectionBD);
} else {
    $controller = new Error404Controller();
}
/** @var Controller $controller */
$controller->execute();
