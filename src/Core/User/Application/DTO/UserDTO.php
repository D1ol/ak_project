<?php

declare(strict_types=1);

namespace App\Core\User\Application\DTO;

class UserDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
    ) {}

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }


}