<?php

namespace LetShout\Infrastructure\Model\Tweet;

use Abraham\TwitterOAuth\TwitterOAuth;
use GuzzleHttp\ClientInterface;
use LetShout\Domain\Model\Tweet\Tweet;
use LetShout\Domain\Model\Tweet\TweetRepository;
use LetShout\Domain\Model\User\User;
use LetShout\Infrastructure\Model\Tweet\Translator\TwitterTweetToTweetTranslator;
use LetShout\Infrastructure\Service\Twitter\TwitterClient;

class TweetTwitterRepository implements TweetRepository
{
    /** @var TwitterClient */
    private $client;

    /** @var TwitterTweetToTweetTranslator */
    private $translator;

    public function __construct(
        TwitterClient $client,
        TwitterTweetToTweetTranslator $translator
    ) {
        $this->client = $client;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function findByUser(User $user, int $limit): array
    {
        $tweets = $this->client->get('statuses/user_timeline', [
            'screen_name' => $user->name(),
            'count' => $limit
        ]);

        return array_map($this->twitterTweetTranslator(), $tweets);
    }

    private function twitterTweetTranslator(): \Closure
    {
        return \Closure::bind(
            function ($twitterTweet): Tweet {
                return $this->translator->translate($twitterTweet);
            },
            $this
        );
    }
}
