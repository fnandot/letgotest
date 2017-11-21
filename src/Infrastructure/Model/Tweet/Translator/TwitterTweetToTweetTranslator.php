<?php


namespace LetShout\Infrastructure\Model\Tweet\Translator;

use LetShout\Domain\Model\Tweet\Tweet;
use LetShout\Domain\Model\Tweet\ValueObject\ExternalTweetIdentity;
use LetShout\Domain\Model\Tweet\ValueObject\TweetIdentity;
use LetShout\Infrastructure\Model\User\Translator\TwitterUserToUserTranslator;
use Ramsey\Uuid\Uuid;

class TwitterTweetToTweetTranslator implements TweetTranslator
{
    private const TWITTER_OID_DOT_NOTATION = '1.3.6.1.4.1.34748';

    /** @var TwitterUserToUserTranslator */
    private $userTranslator;

    public function __construct(TwitterUserToUserTranslator $userTranslator)
    {
        $this->userTranslator = $userTranslator;
    }

    public function translate($data): Tweet
    {
        return new Tweet(
            $this->buildTweetIdentity($data),
            new ExternalTweetIdentity((string) $data['id']),
            $this->userTranslator->translate($data['user']),
            $this->buildCreatedAt($data),
            (string) $data['text']
        );
    }

    private function buildTweetIdentity($data): TweetIdentity
    {
        return new TweetIdentity(
            (string) Uuid::uuid5(
                Uuid::NAMESPACE_OID,
                self::TWITTER_OID_DOT_NOTATION . ".{$data['id']}"
            )
        );
    }

    private function buildCreatedAt($data)
    {
        return \DateTimeImmutable::createFromFormat('D M d H:i:s O Y', $data['created_at']);
    }
}
