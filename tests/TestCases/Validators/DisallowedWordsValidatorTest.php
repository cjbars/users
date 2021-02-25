<?php

namespace TestCases\Validators;

use PHPUnit\Framework\TestCase;
use User\Validators\DisallowedWordsValidator;

class DisallowedWordsValidatorTest extends TestCase
{

    private array $disallowed = ['foo', 'bar'];

    /**
     * @dataProvider wordsProvider
     * @param $word
     * @param $expected
     */
    public function testIsValid($word, $expected)
    {
        $validator = new DisallowedWordsValidator(['words' => $this->disallowed]);
        $this->assertEquals($expected, $validator->isValid($word));
    }

    public function wordsProvider(): array
    {
        return [
            ['foo', false],
            ['bar', false],
            ['test', true],
            ['1234', true],
        ];
    }

}
