<?php

namespace LetShout\Domain\Model\User\ValueObject;

use LetShout\Domain\Model\Identity;

/**
 * Class ExternalUserIdentity
 */
final class ExternalUserIdentity implements Identity
{
    /** @var string */
    private $id;

    public function __construct(string $id = null)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function equals(ExternalUserIdentity $userId): bool
    {
        return $this->id() === $userId->id();
    }
}
