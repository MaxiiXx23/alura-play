<?php

use Max\Aluraplay\Controllers\Error404Controller;
use Max\Aluraplay\Infra\Database\ConnectionDB;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Container\ContainerInterface;

// Sempre que eu for trabalhar com sessions preciso iniciar a session;
// Aqui estou ativando a session de forma GLOBALMENTE
session_start();
// sempre que uma session for iniciada o seu ID será regerado
// para evitar possível ataques de roubo de session
session_regenerate_id();

// Com Frontend Controll consigo importar somente uma vez o autoload
// funcionando assim para todos os arquivos que precisariam dele
require_once __DIR__ . '/../vendor/autoload.php';

$routes = require_once __DIR__ . '/../config/routes.php';

/** @var ContainerInterface */
$diContainer = require_once __DIR__ . '/../config/dependencies.php';

// $connectionBD = ConnectionDB::execute();

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
    $controller = $diContainer->get($controllerClass);
    // $controller = new $controllerClass($connectionBD);
} else {
    $controller = new Error404Controller();
}

$psr17Factory = new Psr17Factory();

$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$serverRequest = $creator->fromGlobals();

// Essa Condicional só existe pois, decidi usar além do método handle, métodos adicionais
// como por exemplo o "auth" ou "logout"
$response;
if ($key == "POST|/login") {

    $response = $controller->auth($serverRequest);
} else if ($key == "GET|/logout") {

    $response = $controller->logout($serverRequest);
} else {
    $response =  $controller->handle($serverRequest);
}

http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();
