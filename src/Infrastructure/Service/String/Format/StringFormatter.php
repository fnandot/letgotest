<?php


namespace LetShout\Infrastructure\Service\String\Format;

interface StringFormatter
{
    public function format(string $string): string;
}
