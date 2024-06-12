<?php

use League\Plates\Engine;
use Max\Aluraplay\Infra\Database\ConnectionDB;
use Psr\Container\ContainerInterface;

$builder = new DI\ContainerBuilder();

$builder->addDefinitions([
    PDO::class => function () {
        return ConnectionDB::execute();
    },
    Engine::class => function () {
        $templatesPath = __DIR__ .  "/../src/views/";
        return new Engine($templatesPath);
    }
]);

$container = $builder->build();

return $container;
