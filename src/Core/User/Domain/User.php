<?php

namespace App\Core\User\Domain;

use App\Common\EventManager\EventsCollectorTrait;
use App\Core\User\Domain\Event\UserCreatedEvent;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    use EventsCollectorTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true}, nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=300, nullable=false)
     */
    private string $email;

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    private bool $active;


    public function __construct(string $email)
    {
        $this->id = null;
        $this->email = $email;
        $this->active = false;

        $this->record(new UserCreatedEvent($this));
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }



    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function isNotActive(): bool
    {
        return !$this->isActive();
    }

}
