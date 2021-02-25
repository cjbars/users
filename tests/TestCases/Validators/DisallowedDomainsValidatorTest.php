<?php

namespace User\Validators;

use PHPUnit\Framework\TestCase;

class DisallowedDomainsValidatorTest extends TestCase
{

    private array $disallowed = ['bad.com', 'not.ru'];

    /**
     * @dataProvider wordsProvider
     * @param $domain
     * @param $expected
     */
    public function testIsValid($domain, $expected)
    {
        $validator = new DisallowedDomainsValidator(['domains' => $this->disallowed]);
        $this->assertEquals($expected, $validator->isValid($domain));
    }

    public function wordsProvider(): array
    {
        return [
            ['test@bad.com', false],
            ['test@not.ru', false],
            ['test@example.com', true],
            ['test@1234', true],
        ];
    }

}
