<?php

namespace Max\Aluraplay\Controllers;

use Max\Aluraplay\Domain\Models\User;
use Max\Aluraplay\Infra\Repositories\UserRepository\UserRepository;
use PDO;

class LoginController extends RenderHTMLController
{
    private UserRepository $userRepository;

    public function __construct(PDO $connectionBD)
    {

        $this->userRepository = new UserRepository($connectionBD);
    }

    public function execute(): void
    {
        // caso o usuário já esteja logado, eu não permito que ele acesse a tela de login
        // assim, o redirecionando para a Home da aplicação;
        if (array_key_exists('logado', $_SESSION) && $_SESSION['logado']) {
            header("Location: /");
            return;
        }

        echo $this->renderTemplate('login');
    }

    public function auth(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        $user = new User(null, $email, $password);

        $userAuth = $this->userRepository->auth($user);

        if (!$userAuth) {
            $_SESSION['error-message'] = "E-mail ou senha incorretos";
            header('Location: /login');
            return;
        }
        $_SESSION['logado'] = true;
        header('Location: /');
    }

    public function logout(): void
    {
        session_destroy();
        // Obs: em vez de destruir a sessão, seria possível inválidar o dado
        // Por exemplo:
        // 1° opção:
        // $_SESSION['logado'] = false;
        // ou 2°:
        // unset($_SESSION['logado']);

        header("Location: /login");
    }
}
