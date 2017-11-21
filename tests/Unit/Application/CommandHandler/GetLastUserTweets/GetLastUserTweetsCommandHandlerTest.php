<?php

namespace LetShoutTest\Unit\Application\CommandHandler\GetLastUserTweets;

use LetShout\Application\CommandHandler\GetLastUserTweets\Exception\MaxNumberOfTweetsExceededException;
use LetShout\Application\CommandHandler\GetLastUserTweets\GetLastUserTweetsCommand;
use LetShout\Application\CommandHandler\GetLastUserTweets\GetLastUserTweetsCommandHandler;
use LetShout\Application\CommandHandler\GetLastUserTweets\GetLastUserTweetsCommandResult;
use LetShout\Domain\Model\User\Exception\UserByNameNotFoundException;
use LetShout\Infrastructure\CommandHandler\GetLastUserTweets\GetLastUserTweetsCommandResultNoOpDataTransformer;
use LetShout\Infrastructure\Model\Tweet\TweetInMemoryRepository;
use LetShout\Infrastructure\Model\User\UserInMemoryRepository;
use LetShoutTest\Unit\Domain\Model\Tweet\TweetTestBuilder;
use LetShoutTest\Unit\Domain\Model\User\UserTestBuilder;
use PHPUnit\Framework\TestCase;

class GetLastUserTweetsCommandHandlerTest extends TestCase
{
    /** @var UserInMemoryRepository */
    private $userRepository;

    /** @var TweetInMemoryRepository */
    private $tweetRepository;

    /** @var GetLastUserTweetsCommandResultNoOpDataTransformer */
    private $dataTransformer;

    protected function setUp()
    {
        $this->userRepository = new UserInMemoryRepository();
        $this->tweetRepository = new TweetInMemoryRepository();
        $this->dataTransformer = new GetLastUserTweetsCommandResultNoOpDataTransformer();
    }

    protected function tearDown()
    {
        $this->userRepository = null;
        $this->tweetRepository = null;
        $this->dataTransformer = null;
    }

    /**
     * @test
     */
    public function givenAnUsernameAndANumberOfTweetsWhenUserExistsThenItShouldReturnLastUserTweets()
    {

        $anUsername = 'letgo';
        $aNumberOfTweets = 2;

        $anUser = (new UserTestBuilder())
            ->withName($anUsername)
            ->build();

        $firstTweet = (new TweetTestBuilder())
            ->withUser($anUser)
            ->build();

        $secondTweet = (new TweetTestBuilder())
            ->withUser($anUser)
            ->build();

        $thirdTweet = (new TweetTestBuilder())
            ->withUser($anUser)
            ->build();

        $this->userRepository->setUsers([$anUser]);
        $this->tweetRepository->setTweets([$firstTweet, $secondTweet, $thirdTweet]);

        /** @var GetLastUserTweetsCommandResult $commandResult */
        $commandResult = $this
            ->buildCommandHandler()
            ->handle(new GetLastUserTweetsCommand(
                $anUsername,
                $aNumberOfTweets
            ));

        $this->assertEquals(
            [$firstTweet, $secondTweet],
            $commandResult->tweets()
        );
    }

    /**
     * @test
     */
    public function givenAnUsernameAndANumberOfTweetsWhenNumberOfTweetsAreMoreThanMaximumThenItShouldThrowAnException()
    {
        $requested = 51;

        $this->expectException(MaxNumberOfTweetsExceededException::class);
        $this->expectExceptionMessage("Requested tweet number \"{$requested}\" exceeds maximum \"50\"");

        $this
            ->buildCommandHandler()
            ->handle(new GetLastUserTweetsCommand(
                'letgo',
                $requested
            ));
    }

    /**
     * @test
     */
    public function givenAnUsernameWhenUserDoesNotExistsThenItShouldThrowAnException()
    {
        $this->expectException(UserByNameNotFoundException::class);
        $this->expectExceptionMessage('User with name "nobody" could not be found.');

        $this
            ->buildCommandHandler()
            ->handle(new GetLastUserTweetsCommand(
                'nobody',
                0
            ));
    }

    private function buildCommandHandler()
    {
        return new GetLastUserTweetsCommandHandler(
            $this->userRepository,
            $this->tweetRepository,
            $this->dataTransformer
        );
    }
}
