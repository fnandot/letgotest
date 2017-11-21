<?php


namespace LetShout\Infrastructure\Model\Tweet\Translator;

use LetShout\Domain\Model\Tweet\Tweet;

interface TweetTranslator
{
    public function translate($data): Tweet;
}
