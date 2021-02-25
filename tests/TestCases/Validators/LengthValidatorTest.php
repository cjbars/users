<?php
namespace User\Validators;

use PHPUnit\Framework\TestCase;

class LengthValidatorTest extends TestCase
{

    /**
     * @dataProvider dataProvider
     * @param $value
     * @param $len
     * @param $expected
     */
    public function testIsValid($value, $len, $expected)
    {
        $validator = new LengthValidator(['min' => $len, 'max' => 256]);
        $this->assertEquals($expected, $validator->isValid($value));
    }

    public function dataProvider(): array
    {
        $len = 2;
        return [
            ['', $len, false],
            ['a', $len, false],
            ['ab', $len, true],
            ['abc', $len, true],
            ['こ', $len, false],
            ['こん', $len, true],
            [1, $len, false],
            [12, $len, true],
            [123, $len, true],
            [false, $len, false],
        ];
    }
}
