<?php


namespace LetShout\Domain\Model\Tweet;

use LetShout\Domain\Model\User\User;

interface TweetRepository
{
    /**
     * @return Tweet[]
     */
    public function findByUser(User $user, int $limit): array;
}
