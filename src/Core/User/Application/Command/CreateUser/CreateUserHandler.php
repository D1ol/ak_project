<?php

declare(strict_types=1);

namespace App\Core\User\Application\Command\CreateUser;

use App\Core\User\Domain\Exception\UserExistException;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(CreateUserCommand $command): void
    {
        if($this->userRepository->findOneByEmail($command->getEmail()))
            throw new UserExistException();

        $this->userRepository->save(new User(
            $command->getEmail()
        ));

        $this->userRepository->flush();
    }
}