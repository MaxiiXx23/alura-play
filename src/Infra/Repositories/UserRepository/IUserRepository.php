<?php

namespace Max\Aluraplay\Infra\Repositories\UserRepository;

use Max\Aluraplay\Domain\Models\User;

interface IUserRepository
{
    public function create(User $user): void;
    public function auth(User $user): ?User;
}
