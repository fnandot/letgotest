<?php


namespace LetShout\Domain\Model\User;

/**
 * Interface UserRepository
 */
interface UserRepository
{
    public function getOneByName(string $name): User;
}
