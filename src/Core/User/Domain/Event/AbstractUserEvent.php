<?php

declare(strict_types=1);

namespace App\Core\User\Domain\Event;

use App\Common\EventManager\EventInterface;
use App\Core\User\Domain\User;

abstract class AbstractUserEvent implements EventInterface
{
    public function __construct(private readonly User $user)
    {
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
