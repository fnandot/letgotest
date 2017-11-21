<?php

namespace LetShout\Domain\Model\User;

use LetShout\Domain\Model\Entity;
use LetShout\Domain\Model\Identity;
use LetShout\Domain\Model\Tweet\Tweet;
use LetShout\Domain\Model\User\ValueObject\ExternalUserIdentity;
use LetShout\Domain\Model\User\ValueObject\UserIdentity;

class User implements Entity
{
    /** @var UserIdentity */
    private $identity;

    /** @var ExternalUserIdentity */
    private $externalUserIdentity;

    /** @var string */
    private $name;

    public function __construct(
        UserIdentity $identity,
        ExternalUserIdentity $externalUserIdentity,
        string $name
    ) {
        $this->identity = $identity;
        $this->externalUserIdentity = $externalUserIdentity;
        $this->name = $name;
    }


    /**
     * @return UserIdentity
     */
    public function identity(): Identity
    {
        return $this->identity;
    }

    public function externalUserIdentity(): ExternalUserIdentity
    {
        return $this->externalUserIdentity;
    }

    public function name(): string
    {
        return $this->name;
    }
}
