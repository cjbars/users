<?php

namespace TestCases\Validators;

use PHPUnit\Framework\TestCase;
use User\Validators\EmailValidator;

class EmailValidatorTest extends TestCase
{

    /**
     * @dataProvider emailProvider
     * @param $email
     * @param $expected
     */
    public function testIsValid($email, $expected)
    {
        $validator = new EmailValidator();
        $this->assertEquals($expected, $validator->isValid($email));
    }

    public function emailProvider(): array
    {
        return [
            ['noemailcom', false],
            ['1234172548762534', false],
            ['test@example.com', true],
            ['a@a.a', true],
            ['test.example.com', false],
            ['test@example@com', false],
        ];
    }
}
