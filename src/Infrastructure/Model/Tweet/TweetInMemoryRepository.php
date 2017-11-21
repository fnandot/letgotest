<?php

namespace LetShout\Infrastructure\Model\Tweet;

use Abraham\TwitterOAuth\TwitterOAuth;
use GuzzleHttp\ClientInterface;
use LetShout\Domain\Model\Tweet\Tweet;
use LetShout\Domain\Model\Tweet\TweetRepository;
use LetShout\Domain\Model\User\User;
use LetShout\Infrastructure\Model\Tweet\Translator\TwitterTweetToTweetTranslator;

class TweetInMemoryRepository implements TweetRepository
{
    /** @var Tweet[] */
    private $tweets;

    public function __construct(array $entities = [])
    {
        $this->setTweets($entities);
    }

    public function setTweets(array $tweets): void
    {
        $this->tweets = $tweets;
    }

    /**
     * {@inheritdoc}
     */
    public function findByUser(User $user, int $limit): array
    {
        return array_slice(
            array_filter(
                $this->tweets,
                function (Tweet $tweet) use ($user) {
                    return $tweet->user()->identity()->equals($user->identity());
                }
            ),
            0,
            $limit
        );
    }
}
