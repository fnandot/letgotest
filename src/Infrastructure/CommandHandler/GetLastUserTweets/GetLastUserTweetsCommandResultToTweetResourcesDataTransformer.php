<?php


namespace LetShout\Infrastructure\CommandHandler\GetLastUserTweets;

use LetShout\Application\CommandHandler\GetLastUserTweets\GetLastUserTweetsCommandResult;
use LetShout\Application\CommandHandler\GetLastUserTweets\GetLastUserTweetsCommandResultDataTransformer;
use LetShout\Domain\Model\Tweet\Tweet;
use LetShout\Infrastructure\Model\Tweet\TweetResource;
use LetShout\Infrastructure\Model\Tweet\TweetToTweetResourceDataTransformer;

class GetLastUserTweetsCommandResultToTweetResourcesDataTransformer implements GetLastUserTweetsCommandResultDataTransformer
{
    /** @var TweetToTweetResourceDataTransformer */
    private $tweetResourceDataTransformer;

    public function __construct(TweetToTweetResourceDataTransformer $tweetResourceDataTransformer)
    {
        $this->tweetResourceDataTransformer = $tweetResourceDataTransformer;
    }

    /**
     * @return TweetResource
     */
    public function transform(GetLastUserTweetsCommandResult $commandResult)
    {
        return array_map(
            $this->transformTweetToTweetResource(),
            $commandResult->tweets()
        );
    }

    private function transformTweetToTweetResource(): \Closure
    {
        return \Closure::bind(
            function (Tweet $tweet): TweetResource {
                return $this->tweetResourceDataTransformer->transform($tweet);
            },
            $this
        );
    }
}
