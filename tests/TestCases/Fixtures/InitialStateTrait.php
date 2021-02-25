<?php

namespace TestCases\Fixtures;

use DateTime;
use User\Entities\UserEntity;

trait InitialStateTrait
{
    public function getInitialState(): array
    {
        return [
            1 => serialize(
                new UserEntity(
                    [
                        'id' => 1,
                        'name' => 'testtest',
                        'email' => 'test@example.com',
                        'created' => new DateTime(),
                        'deleted' => null,
                        'notes' => 'some text notes'
                    ]))
        ];
    }
}