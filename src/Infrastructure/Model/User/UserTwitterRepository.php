<?php

namespace LetShout\Infrastructure\Model\User;

use GuzzleHttp\Exception\ClientException;
use LetShout\Domain\Model\User\Exception\UserByNameNotFoundException;
use LetShout\Domain\Model\User\User;
use LetShout\Domain\Model\User\UserRepository;
use LetShout\Infrastructure\Model\User\Translator\TwitterUserToUserTranslator;
use LetShout\Infrastructure\Service\Twitter\TwitterClient;

class UserTwitterRepository implements UserRepository
{
    /** @var TwitterClient */
    private $client;

    /** @var TwitterUserToUserTranslator */
    private $translator;

    public function __construct(
        TwitterClient $client,
        TwitterUserToUserTranslator $translator
    ) {
        $this->client = $client;
        $this->translator = $translator;
    }

    public function getOneByName(string $name): User
    {
        try {
            $twitterUser = $this->client->get('users/show', [
                'screen_name' => $name
            ]);
        } catch (ClientException $e) {
            throw new UserByNameNotFoundException($name);
        }

        return $this->translator->translate($twitterUser);
    }
}
