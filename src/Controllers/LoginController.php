<?php

namespace Max\Aluraplay\Controllers;

use League\Plates\Engine;
use Max\Aluraplay\Domain\Models\User;
use Max\Aluraplay\Infra\Repositories\UserRepository\UserRepository;
use Nyholm\Psr7\Response;
use PDO;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginController implements RequestHandlerInterface
{
    private UserRepository $userRepository;
    private Engine $templateEngine;

    public function __construct(PDO $connectionBD, Engine $templateEngine)
    {

        $this->userRepository = new UserRepository($connectionBD);
        $this->templateEngine = $templateEngine;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // caso o usuário já esteja logado, eu não permito que ele acesse a tela de login
        // assim, o redirecionando para a Home da aplicação;
        if (array_key_exists('logado', $_SESSION) && $_SESSION['logado']) {
            return new Response(401, [
                'Location' => "/",
            ]);
        }

        $response = new Response(status: 200, body: $this->templateEngine->render('login'));
        return  $response;
    }

    public function auth(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();
        $email = filter_var($body['email'], FILTER_VALIDATE_EMAIL);
        $password = filter_var($body['password']);

        $user = new User(null, $email, $password);

        $userAuth = $this->userRepository->auth($user);

        if (!$userAuth) {
            $_SESSION['error-message'] = "E-mail ou senha incorretos";
            return new Response(401, [
                'Location' => '/login'
            ]);
        }

        $_SESSION['logado'] = true;
        return new Response(200, [
            'Location' => '/'
        ]);
    }

    public function logout(ServerRequestInterface $request): ResponseInterface
    {
        session_destroy();
        // Obs: em vez de destruir a sessão, seria possível inválidar o dado
        // Por exemplo:
        // 1° opção:
        // $_SESSION['logado'] = false;
        // ou 2°:
        // unset($_SESSION['logado']);

        return new Response(200, [
            'Location' => '/login'
        ]);
    }
}
