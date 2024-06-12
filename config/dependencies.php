<?php

use Max\Aluraplay\Infra\Database\ConnectionDB;
use Psr\Container\ContainerInterface;

$builder = new DI\ContainerBuilder();

$builder->addDefinitions([
    PDO::class => function () {
        return ConnectionDB::execute();
    },
]);

$container = $builder->build();

return $container;
