<?php

namespace LetShout\Application\CommandHandler\GetLastUserTweets;

use LetShout\Domain\Model\Tweet\Tweet;

/**
 * Class GetLastUserTweetsCommandResult
 */
class GetLastUserTweetsCommandResult
{
    /** @var Tweet[] */
    private $tweets;

    public function __construct(array $tweets)
    {
        $this->tweets = $tweets;
    }

    /**
     * @return Tweet[]
     */
    public function tweets(): array
    {
        return $this->tweets;
    }
}
