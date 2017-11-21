<?php


namespace LetShout\Domain\Model\Tweet\ValueObject;

use LetShout\Domain\Model\Identity;
use Ramsey\Uuid\Uuid;

/**
 * Class TweetId
 */
final class ExternalTweetIdentity implements Identity
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

    public function equals(ExternalTweetIdentity $externalTweetIdentity): bool
    {
        return $this->id() === $externalTweetIdentity->id();
    }
}
