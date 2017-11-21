<?php

namespace LetShout\Domain\Model\User\ValueObject;

use LetShout\Domain\Model\Identity;
use Ramsey\Uuid\Uuid;

/**
 * Class UserId
 */
final class UserIdentity implements Identity
{
    /** @var string */
    private $id;

    public function __construct(string $id = null)
    {
        $this->id = null === $id ? Uuid::uuid4()->toString() : $id;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function equals(UserIdentity $userId): bool
    {
        return $this->id() === $userId->id();
    }

    public function __toString()
    {
        return $this->id();
    }
}
