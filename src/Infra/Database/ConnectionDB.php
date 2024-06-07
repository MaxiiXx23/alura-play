<?php

namespace Max\Aluraplay\Infra\Database;

use PDO;

class ConnectionDB
{
    // Pattern Static Create Method
    public static function execute(): PDO
    {

        // exemplo com MYSQL
        $pdo = new PDO(
            dsn: 'mysql:host=localhost;dbname=aluraplay',
            username: 'maxdev',
            password: '2323'
        );

        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    }
}
