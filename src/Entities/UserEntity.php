<?php

namespace User\Entities;

use DateTime;

class UserEntity extends Entity
{
    public ?int $id = null;

    public string $name = '';

    public string $email = '';

    public ?DateTime $deleted = null;

    public ?string $notes = null;

    public DateTime $created;

    /**
     * UserEntity constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        if (!isset($data['created'])) {
            $this->created = new DateTime();
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