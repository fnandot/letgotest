<?php


namespace LetShout\Infrastructure\Service\String\Format;

class UpperCaseStringFormatter implements StringFormatter
{
    public function format(string $string): string
    {
        $string = mb_convert_case($string, MB_CASE_UPPER);

        return $string;
    }
}
