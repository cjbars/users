<?php

namespace User\Validators;

use PHPUnit\Framework\TestCase;

class RegexValidatorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     * @param $string
     * @param $expected
     */
    public function testIsValid($string, $expected)
    {
        $validator = new RegexValidator(['regex' => '/^[a-z0-9]+$/']);
        $this->assertEquals($expected, $validator->isValid($string));
    }

    public function dataProvider(): array
    {
        return [
            ['abcde', true],
            ['123', true],
            ['abc123', true],
            ['Abc', false],
            ['Abc+', false],
            ['123+', false],
        ];
    }
}
