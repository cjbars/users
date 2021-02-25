<?php

namespace User\Validators;

use PHPUnit\Framework\TestCase;
use User\Storages\ArrayStorage;

class UniqueValidatorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     * @param $string
     * @param $expected
     */
    public function testIsValid($string, $expected)
    {
        $storage = new ArrayStorage($this->getInitialState());
        $validator = new UniqueValidator(['fieldName' => 'name', 'storage' => $storage]);
        $this->assertEquals($expected, $validator->isValid($string));
    }

    public function getInitialState(): array
    {
        return [
            1 => ['id' => 1,
                'name' => 'testtest',
                'email' => 'test@example.com',
                'created' => new \DateTime(),
                'deleted' => null,
                'notes' => 'some text notes'
            ]
        ];
    }

    public function dataProvider(): array
    {
        return [
            ['validname', true],
            ['testtest', false],
        ];
    }
}
