<?php


namespace LetShout\Domain\Model\User\Exception;

use Exception;

/**
 * Class UserByNameNotFoundException
 */
class UserByNameNotFoundException extends \Exception
{
    public function __construct(string $name, $code = 0, Exception $previous = null)
    {
        parent::__construct(
            sprintf('User with name "%s" could not be found.', $name),
            $code,
            $previous
        );
    }
}
