<?php


namespace LetShout\Application\CommandHandler\GetLastUserTweets;

interface GetLastUserTweetsCommandResultDataTransformer
{
    public function transform(GetLastUserTweetsCommandResult $commandResult);
}
