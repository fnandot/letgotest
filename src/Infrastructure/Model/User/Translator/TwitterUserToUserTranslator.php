<?php


namespace LetShout\Infrastructure\Model\User\Translator;

use LetShout\Domain\Model\User\User;
use LetShout\Domain\Model\User\ValueObject\ExternalUserIdentity;
use LetShout\Domain\Model\User\ValueObject\UserIdentity;
use Ramsey\Uuid\Uuid;

class TwitterUserToUserTranslator implements UserTranslator
{
    private const TWITTER_OID_DOT_NOTATION = '1.3.6.1.4.1.34748';

    public function translate($data): User
    {
        return new User(
            $this->buildUserIdentity($data),
            new ExternalUserIdentity((string) $data['id']),
            (string) $data['screen_name']
        );
    }

    private function buildUserIdentity($data): UserIdentity
    {
        return new UserIdentity(
            (string) Uuid::uuid5(
                Uuid::NAMESPACE_OID,
                self::TWITTER_OID_DOT_NOTATION . ".{$data['id']}"
            )
        );
    }
}
