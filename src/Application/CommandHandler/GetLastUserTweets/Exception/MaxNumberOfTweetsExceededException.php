<?php


namespace LetShout\Application\CommandHandler\GetLastUserTweets\Exception;

class MaxNumberOfTweetsExceededException extends \Exception
{
    public function __construct(int $requested, int $max)
    {
        parent::__construct(
            sprintf(
                'Requested tweet number "%s" exceeds maximum "50".',
                $requested,
                $max
            )
        );
    }
}
