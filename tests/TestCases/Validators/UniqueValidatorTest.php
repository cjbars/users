<?php

namespace TestCases\Validators;

use PHPUnit\Framework\TestCase;
use TestCases\Fixtures\initialStateTrait;
use User\Storages\ArrayStorage;
use User\Validators\UniqueValidator;

class UniqueValidatorTest extends TestCase
{

    use InitialStateTrait;

    /**
     * @dataProvider dataProvider
     * @param $string
     * @param $expected
     */
    public function testIsValid($string, $expected)
    {
        $storage = new ArrayStorage($this->getInitialState());
        $validator = new UniqueValidator(['fieldName' => 'name', 'storage' => $storage]);
        $this->assertEquals($expected, $validator->isValid($string, false));
    }


    public function dataProvider(): array
    {
        return [
            ['validname', true],
            ['testtest', false],
        ];
    }
}
