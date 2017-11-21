<?php


namespace LetShout\Infrastructure\Model\User\Translator;

use LetShout\Domain\Model\User\User;

interface UserTranslator
{
    public function translate($data): User;
}
