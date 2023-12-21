<?php

declare(strict_types=1);

namespace App\Core\User\Application\Command\CreateUser;

class CreateUserCommand
{
    public function __construct(
        private readonly string $email
    )
    {
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }


}