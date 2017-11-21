<?php


namespace LetShout\Infrastructure\Service\Twitter;

interface TwitterClient
{
    public function get(string $endpoint, array $parameters);
}
