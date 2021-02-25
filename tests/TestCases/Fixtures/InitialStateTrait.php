<?php

namespace TestCases\Fixtures;

use DateTimeImmutable;
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
                        'created' => new DateTimeImmutable(),
                        'deleted' => null,
                        'notes' => 'some text notes'
                    ]))
        ];
    }
}