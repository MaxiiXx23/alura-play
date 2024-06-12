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
        $passwordHash = password_hash($user->get_password(), PASSWORD_ARGON2ID);

        $sqlQuery = "INSERT INTO users (email, password) VALUES (:email, :password);";

        $stmt = $this->pdo->prepare($sqlQuery);
        $stmt->execute([
            ":email" => $email,
            ":password" => $passwordHash
        ]);
    }

    // Estse métodos abaixo deveriam estar em um AuthRepository
    // mas os deixei aqui para simplificar

    // Aqui verifico se o hash recebido está precisando usar um Algoritmo mais recente de hashing
    // E se precisar a senha é atualiza com o novo Algoritmo
    private function verifyRehashPassword(int $id, string $password)
    {
        if (password_needs_rehash($password, PASSWORD_ARGON2ID)) {
            $sqlQuery = "UPDATE users SET password = :password WHERE id =:id;";
            $passwordRehash = password_hash($password, PASSWORD_ARGON2ID);
            $stmt = $this->pdo->prepare($sqlQuery);
            $stmt->execute([
                ":id" => $id,
                ":password" => $passwordRehash
            ]);
        }
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
            $this->verifyRehashPassword($userData['id'], $userData['password']);
            $user->set_id($userData['id']);
            return $user;
        }
        return null;
    }
}
