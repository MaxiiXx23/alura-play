<?php

namespace Max\Aluraplay\Domain\Models;

class User
{

    private ?int $id;
    private string $email;
    private string $password;


    public function __construct(?int $id, string $email, string $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }

    public function get_id(): int
    {
        return $this->id;
    }

    public function set_id(int $id): void
    {
        $this->id = $id;
    }

    public function get_email(): string
    {
        return $this->email;
    }

    public function get_password(): string
    {
        return $this->password;
    }
}
