<?php

namespace User\Entities;

use DateTimeImmutable;

class UserEntity extends Entity
{
    public ?int $id = null;

    public string $name = '';

    public string $email = '';

    public ?DateTimeImmutable $deleted = null;

    public ?string $notes = null;

    public DateTimeImmutable $created;

    /**
     * UserEntity constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        if (!isset($data['created'])) {
            $this->created = new DateTimeImmutable();
        }
    }

    public function setPrimaryKey($key)
    {
        $this->id = (int)$key;
    }

    public function getPrimaryKey(): ?int
    {
        return $this->id;
    }

}