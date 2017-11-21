<?php

namespace LetShout\Application\CommandHandler\GetLastUserTweets;

use LetShout\Application\CommandHandler\GetLastUserTweets\Exception\MaxNumberOfTweetsExceededException;
use LetShout\Domain\Model\Tweet\TweetRepository;
use LetShout\Domain\Model\User\UserRepository;

class GetLastUserTweetsCommandHandler
{
    private const MAX_NUMBER_OF_TWEETS = 50;

    /** @var UserRepository */
    private $userRepository;

    /** @var TweetRepository */
    private $tweetRepository;

    /** @var GetLastUserTweetsCommandResultDataTransformer */
    private $dataTransformer;

    public function __construct(
        UserRepository $userRepository,
        TweetRepository $tweetRepository,
        GetLastUserTweetsCommandResultDataTransformer $dataTransformer
    ) {
        $this->userRepository = $userRepository;
        $this->tweetRepository = $tweetRepository;
        $this->dataTransformer = $dataTransformer;
    }

    public function handle(GetLastUserTweetsCommand $command)
    {
        $this->assertMaxNumberOfTweets($command);

        $user = $this
            ->userRepository
            ->getOneByName($command->username());

        $tweets = $this
            ->tweetRepository
            ->findByUser($user, $command->numberOfTweets());

        return $this
            ->dataTransformer
            ->transform(new GetLastUserTweetsCommandResult($tweets));
    }

    /**
     * @throws MaxNumberOfTweetsExceededException
     */
    private function assertMaxNumberOfTweets(GetLastUserTweetsCommand $command): void
    {
        if ($command->numberOfTweets() > self::MAX_NUMBER_OF_TWEETS) {
            throw new MaxNumberOfTweetsExceededException(
                $command->numberOfTweets(),
                self::MAX_NUMBER_OF_TWEETS
            );
        }
    }
}
