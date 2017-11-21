<?php


namespace LetShoutTest\Unit\Domain\Model\User;

use LetShout\Domain\Model\User\User;
use LetShout\Domain\Model\User\ValueObject\ExternalUserIdentity;
use LetShout\Domain\Model\User\ValueObject\UserIdentity;

class UserTestBuilder
{
    private const DEFAULT_IDENTITY = '00000000-0000-0000-0000-000000000000';

    /** @var UserIdentity */
    private $identity;

    /** @var ExternalUserIdentity */
    private $externalUserIdentity;

    /** @var string */
    private $name;

    public function withIdentity(UserIdentity $identity): UserTestBuilder
    {
        $this->identity = $identity;

        return $this;
    }

    public function withExternalUserIdentity(ExternalUserIdentity $externalUserIdentity): UserTestBuilder
    {
        $this->externalUserIdentity = $externalUserIdentity;
        return $this;
    }

    public function withName(string $name): UserTestBuilder
    {
        $this->name = $name;
        return $this;
    }

    public function build(): User
    {
        return new User(
            $this->identity ?: new UserIdentity(self::DEFAULT_IDENTITY),
            $this->externalUserIdentity ?: new ExternalUserIdentity(self::DEFAULT_IDENTITY),
            $this->name ?: 'letgo'
        );
    }
}
