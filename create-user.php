<?php

// Esse arquivo é usado para criar um usuário, pois, não há frontend/tela de cadastro.

use Max\Aluraplay\Domain\Models\User;
use Max\Aluraplay\Infra\Database\ConnectionDB;
use Max\Aluraplay\Infra\Repositories\UserRepository\UserRepository;

require_once 'vendor/autoload.php';

$connection = ConnectionDB::execute();

$userRepository = new UserRepository($connection);

$user = new User(null, 'max.dev23@gmail.com', 'max2323');

$userRepository->create($user);

echo "Novo usuário criado";
