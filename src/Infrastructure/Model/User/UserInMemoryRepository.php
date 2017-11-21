<?php

namespace LetShout\Infrastructure\Model\User;

use Abraham\TwitterOAuth\TwitterOAuth;
use GuzzleHttp\ClientInterface;
use LetShout\Domain\Model\User\Exception\UserByNameNotFoundException;
use LetShout\Domain\Model\User\User;
use LetShout\Domain\Model\User\UserRepository;
use LetShout\Infrastructure\Model\User\Translator\TwitterUserToUserTranslator;

class UserInMemoryRepository implements UserRepository
{
    /** @var User[] */
    private $users;

    public function __construct(array $entities = [])
    {
        $this->setUsers($entities);
    }

    public function setUsers(array $users): void
    {
        $this->users = $users;
    }

    public function getOneByName(string $name): User
    {
        foreach ($this->users as $entity) {
            if ($name === $entity->name()) {
                return $entity;
            }
        }

        throw new UserByNameNotFoundException($name);
    }
}
