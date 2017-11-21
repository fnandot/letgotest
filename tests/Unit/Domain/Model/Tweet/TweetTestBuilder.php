<?php


namespace LetShoutTest\Unit\Domain\Model\Tweet;


use LetShoutTest\Unit\Domain\Model\User\UserTestBuilder;
use LetShout\Domain\Model\Tweet\Tweet;
use LetShout\Domain\Model\Tweet\ValueObject\ExternalTweetIdentity;
use LetShout\Domain\Model\Tweet\ValueObject\TweetIdentity;
use LetShout\Domain\Model\User\User;

class TweetTestBuilder
{
    private const DEFAULT_IDENTITY = '00000000-0000-0000-0000-000000000000';

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

    public function withIdentity(TweetIdentity $identity): TweetTestBuilder
    {
        $this->identity = $identity;

        return $this;
    }

    public function withExternalTweetIdentity(ExternalTweetIdentity $externalIdentity): TweetTestBuilder
    {
        $this->externalIdentity = $externalIdentity;

        return $this;
    }

    public function withUser(User $user): TweetTestBuilder
    {
        $this->user = $user;

        return $this;
    }

    public function withCreatedAt(\DateTimeImmutable $dateTimeImmutable): TweetTestBuilder
    {
        $this->createdAt = $dateTimeImmutable;

        return $this;
    }

    public function withText(string $text): TweetTestBuilder
    {
        $this->text = $text;

        return $this;
    }

    public function build(): Tweet
    {
        return new Tweet(
            $this->identity ?: new TweetIdentity(self::DEFAULT_IDENTITY),
            $this->externalIdentity ?: new ExternalTweetIdentity(self::DEFAULT_IDENTITY),
            $this->user ?: (new UserTestBuilder())->build(),
            $this->createdAt ?: \DateTimeImmutable::createFromFormat('U', 0),
            $this->text ?: new TweetIdentity('@letgo rules!')
        );
    }
}
