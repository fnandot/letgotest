<?php


namespace LetShout\Infrastructure\Service\Twitter\OAuth;

use Abraham\TwitterOAuth\TwitterOAuth;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use LetShout\Infrastructure\Service\Twitter\TwitterClient;

/**
 * Class TwitterOAuthClientFactory
 */
class TwitterOAuthClientFactory
{
    /** @var string  */
    private $baseUri;

    /** @var string */
    private $consumerKey;

    /** @var string */
    private $consumerSecret;

    /** @var string  */
    private $token;

    /** @var string */
    private $tokenSecret;

    public function __construct(
        string $baseUri,
        string $consumerKey,
        string $consumerSecret,
        string $token,
        string $tokenSecret
    ) {
        $this->baseUri = $baseUri;
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->token = $token;
        $this->tokenSecret = $tokenSecret;
    }

    public function create(): TwitterClient
    {
        $oauthAuthentificationMiddleware = new Oauth1([
            'consumer_key'    => $this->consumerKey,
            'consumer_secret' => $this->consumerSecret,
            'token'           => $this->token,
            'token_secret'    => $this->tokenSecret,
            'signature_method' => Oauth1::SIGNATURE_METHOD_HMAC,
        ]);

        $middlewareStack = HandlerStack::create();

        $middlewareStack->push($oauthAuthentificationMiddleware);

        $guzzleClient = new Client([
            'base_uri' => "{$this->baseUri}/1.1/",
            'auth' => 'oauth',
            'handler' => $middlewareStack
        ]);

        return new TwitterOAuthClient($guzzleClient);
    }
}
