<?php


namespace LetShout\Infrastructure\Model\Tweet;

use LetShout\Domain\Model\Tweet\Tweet;
use LetShout\Infrastructure\Service\String\Format\StringFormatter;

class TweetToTweetResourceDataTransformer
{
    /** @var StringFormatter */
    private $formatter;

    public function __construct(StringFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    public function transform(Tweet $tweet): TweetResource
    {
        return new TweetResource(
            $tweet->identity()->id(),
            $tweet->externalIdentity()->id(),
            $tweet->createdAt(),
            $this->formatter->format($tweet->text())
        );
    }
}
