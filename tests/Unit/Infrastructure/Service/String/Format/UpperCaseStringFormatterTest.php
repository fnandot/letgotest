<?php

namespace LetShoutTest\Unit\Infrastructure\Service\String\Format;

use LetShout\Infrastructure\Service\String\Format\UpperCaseStringFormatter;
use PHPUnit\Framework\TestCase;

class UpperCaseStringFormatterTest extends TestCase
{
    /**
     * @test
     */
    public function givenAStringItShouldConvertToUpperCase()
    {
        $formatter = new UpperCaseStringFormatter();

        $upperCaseString = $formatter->format('letgo rules!');

        $this->assertSame('LETGO RULES!', $upperCaseString);
    }
}
