<?php


namespace LetShout\Infrastructure\Service\Twitter;

interface TwitterClientFactory
{
    public function create(): TwitterClient;
}
