<?php

namespace Max\Aluraplay\Infra\Repositories\UserRepository;

use Max\Aluraplay\Domain\Models\User;
use Max\Aluraplay\Infra\Repositories\UserRepository\IUserRepository;
use PDO;

class UserRepository implements IUserRepository
{

    private PDO $pdo;

    public function __construct(PDO $connection)
    {
        $this->pdo = $connection;
    }

    public function create(User $user): void
    {
        $email = $user->get_email();
        $passwordHash = password_hash($user->get_password(), PASSWORD_ARGON2I);

        $sqlQuery = "INSERT INTO users (email, password) VALUES (:email, :password);";

        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute([
            ":email" => $email,
            ":password" => $passwordHash
        ]);
    }

    public function auth(User $user): ?User
    {
        $email = $user->get_email();

        $sqlQuery = "SELECT id, email, password FROM users WHERE email=:email;";

        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute([
            ":email" => $email,
        ]);

        $userData = $stmt->fetch();

        $password =  $user->get_password();

        $passwordMatched = password_verify($password, $userData['password'] ?? '');

        if ($passwordMatched) {
            $user->set_id($userData['id']);
            return $user;
        }
        return null;
    }
}
