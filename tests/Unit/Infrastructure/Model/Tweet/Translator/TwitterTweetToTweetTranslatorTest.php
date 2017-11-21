<?php

namespace LetShoutTest\Unit\Infrastructure\Model\Tweet\Translator;

use LetShout\Domain\Model\Tweet\ValueObject\ExternalTweetIdentity;
use LetShout\Domain\Model\Tweet\ValueObject\TweetIdentity;
use LetShout\Infrastructure\Model\Tweet\Translator\TwitterTweetToTweetTranslator;
use LetShout\Infrastructure\Model\User\Translator\TwitterUserToUserTranslator;
use LetShoutTest\Unit\Domain\Model\Tweet\TweetTestBuilder;
use LetShoutTest\Unit\Domain\Model\User\UserTestBuilder;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Ramsey\Uuid\Uuid;

class TwitterTweetToTweetTranslatorTest extends TestCase
{
    /** @var ObjectProphecy|TwitterUserToUserTranslator */
    private $twitterUserToUserTranslator;

    protected function setUp()
    {
        $this->twitterUserToUserTranslator = $this
            ->prophesize(TwitterUserToUserTranslator::class);
    }

    protected function tearDown()
    {
        $this->twitterUserToUserTranslator = null;
    }

    /**
     * @test
     */
    public function givenATwitterTweetItShouldTranslateToDomainTweet()
    {

        $translator = new TwitterTweetToTweetTranslator(
            $this->twitterUserToUserTranslator->reveal()
        );

        $userData = [
            'id' => '1234',
            'screen_name' => 'letgo'

        ];

        $expectedUser = (new UserTestBuilder())->build();

        $this
            ->twitterUserToUserTranslator
            ->translate($userData)
            ->shouldBeCalled()
            ->willReturn($expectedUser);


        $tweetData = [
            'id' => '1234',
            'created_at' => 'Sat Dec 14 04:35:55 +0000 2013',
            'text' => 'letgo rules!',
            'user' => $userData
        ];

        $tweet = $translator->translate($tweetData);

        $expectedTweet = (new TweetTestBuilder())
            ->withUser($expectedUser)
            ->withCreatedAt(\DateTimeImmutable::createFromFormat('D M d H:i:s O Y', 'Sat Dec 14 04:35:55 +0000 2013'))
            ->withText('letgo rules!')
            ->withExternalTweetIdentity(new ExternalTweetIdentity('1234'))
            ->withIdentity(new TweetIdentity(
                Uuid::uuid5(
                    Uuid::NAMESPACE_OID,
                    "1.3.6.1.4.1.34748.1234"
                )
            ))
            ->build();

        $this->assertEquals($expectedTweet, $tweet);
    }
}
