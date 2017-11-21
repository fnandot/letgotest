<?php

namespace LetShoutTest\Unit\Infrastructure\Model\User\Translator;

use LetShout\Domain\Model\User\ValueObject\ExternalUserIdentity;
use LetShout\Domain\Model\User\ValueObject\UserIdentity;
use LetShout\Infrastructure\Model\User\Translator\TwitterUserToUserTranslator;
use LetShoutTest\Unit\Domain\Model\User\UserTestBuilder;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class TwitterUserToUserTranslatorTest extends TestCase
{
    /**
     * @test
     */
    public function givenATwitterUserItShouldTranslateToDomainUser()
    {

        $userData = [
            'id' => '1234',
            'screen_name' => 'letgo',
        ];

        $translator = new TwitterUserToUserTranslator();

        $tweet = $translator->translate($userData);

        $expectedUser = (new UserTestBuilder())
            ->withName('letgo')
            ->withExternalUserIdentity(new ExternalUserIdentity('1234'))
            ->withIdentity(new UserIdentity(
                Uuid::uuid5(
                    Uuid::NAMESPACE_OID,
                    "1.3.6.1.4.1.34748.1234"
                )
            ))
            ->build();

        $this->assertEquals($expectedUser, $tweet);
    }
}
