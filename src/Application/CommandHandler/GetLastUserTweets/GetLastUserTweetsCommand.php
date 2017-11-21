<?php

namespace LetShout\Application\CommandHandler\GetLastUserTweets;

/**
 * Class GetUserTweetsRequest
 */
class GetLastUserTweetsCommand
{
    /** @var string */
    private $username;

    /** @var int */
    private $numberOfTweets;

    public function __construct(string $username, int $numberOfTweets)
    {
        $this->username = $username;
        $this->numberOfTweets = $numberOfTweets;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function numberOfTweets(): int
    {
        return $this->numberOfTweets;
    }
}
