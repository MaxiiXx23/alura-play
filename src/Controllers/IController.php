<?php

namespace Max\Aluraplay\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

// Interface para utilizar a PSR-7: HTTP messages interface
// https://www.php-fig.org/psr/psr-7/

// Esta interface é um exemplo para implentação da interface da psr-15
interface IController
{
    // Em resumo é basicamento a interface Request do Express, mas para PHP
    public function request(ServerRequestInterface $request): ResponseInterface;
}
