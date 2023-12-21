<?php

namespace App\Core\User\Infrastructure\Persistance;

use App\Core\User\Domain\Exception\UserNotFoundException;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Psr\EventDispatcher\EventDispatcherInterface;

class DoctrineUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly EventDispatcherInterface $eventDispatcher
    )
    {
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getByEmail(string $email): User
    {
        $user = $this->findOneByEmail($email);

        if (null === $user) {
            throw new UserNotFoundException('Użytkownik nie istnieje');
        }

        return $user;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByEmail(string $email): ?User
    {
        return $this->entityManager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :user_email')
            ->setParameter(':user_email', $email)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);

        $events = $user->pullEvents();

        foreach ($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }

    public function getUsersByActiveStatus(bool $active): array
    {
        $qb = $this->entityManager->createQueryBuilder();

        return $qb
            ->select('u')
            ->from(User::class, 'u')
            ->where($qb->expr()->eq('u.active', ':user_active'))
            ->setParameter(':user_active', $active)
            ->getQuery()
            ->getResult();
    }
}
