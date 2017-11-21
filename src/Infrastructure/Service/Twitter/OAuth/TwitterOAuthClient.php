<?php


namespace LetShout\Infrastructure\Service\Twitter\OAuth;

use GuzzleHttp\Client;
use LetShout\Infrastructure\Service\Twitter\TwitterClient;

class TwitterOAuthClient implements TwitterClient
{
    private $oAuthClient;

    public function __construct(Client $twitterOAuth)
    {
        $this->oAuthClient = $twitterOAuth;
    }

    public function get(string $endpoint, array $parameters = [])
    {
        $response = $this->oAuthClient->get("{$endpoint}.json", [
            'query' => $parameters
        ]);

        $contents = json_decode($response->getBody()->getContents(), true);


        return $contents;
    }
}
