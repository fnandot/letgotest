<?php


namespace LetShout\Infrastructure\CommandHandler\GetLastUserTweets;

use LetShout\Application\CommandHandler\GetLastUserTweets\GetLastUserTweetsCommandResult;
use LetShout\Application\CommandHandler\GetLastUserTweets\GetLastUserTweetsCommandResultDataTransformer;

class GetLastUserTweetsCommandResultNoOpDataTransformer implements GetLastUserTweetsCommandResultDataTransformer
{
    /**
     * @return GetLastUserTweetsCommandResult
     */
    public function transform(GetLastUserTweetsCommandResult $commandResult)
    {
        return $commandResult;
    }
}
