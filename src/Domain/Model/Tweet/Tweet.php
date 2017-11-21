<?php

namespace LetShout\Domain\Model\Tweet;

use LetShout\Domain\Model\Entity;
use LetShout\Domain\Model\Identity;
use LetShout\Domain\Model\Tweet\ValueObject\ExternalTweetIdentity;
use LetShout\Domain\Model\Tweet\ValueObject\TweetIdentity;
use LetShout\Domain\Model\User\User;

/**
 * Class Tweet
 */
class Tweet implements Entity
{
    /** @var TweetIdentity */
    private $identity;

    /** @var ExternalTweetIdentity */
    private $externalIdentity;

    /** @var User */
    private $user;

    /** @var \DateTimeImmutable */
    private $createdAt;

    /** @var string */
    private $text;

    public function __construct(
        TweetIdentity $identity,
        ExternalTweetIdentity $externalIdentity,
        User $user,
        \DateTimeImmutable $createdAt,
        string $text
    ) {
        $this->identity = $identity;
        $this->externalIdentity = $externalIdentity;
        $this->user = $user;
        $this->createdAt = $createdAt;
        $this->text = $text;
    }

    /**
     * @return TweetIdentity
     */
    public function identity(): Identity
    {
        return $this->identity;
    }

    public function externalIdentity(): ExternalTweetIdentity
    {
        return $this->externalIdentity;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function text(): string
    {
        return $this->text;
    }
}
