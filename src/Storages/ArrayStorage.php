<?php

namespace User\Storages;


use DateTime;
use User\Entities\Entity;

class ArrayStorage implements Storage
{

    private array $data = [];


    public function __construct(array $initialState)
    {
        $this->data = $initialState;
    }

    public function save(Entity $entity): Entity
    {
        if ($entity->getPrimaryKey()) {
            return $this->update($entity);
        }
        return $this->create($entity);
    }

    public function update(Entity $entity): Entity
    {
        $this->data[$entity->getPrimaryKey()] = $entity;
        return $entity;
    }

    public function create(Entity $entity): Entity
    {
        $key = count($this->data) + 1;
        $entity->setPrimaryKey($key);
        $this->data[$key] = (array)$entity;
        return $entity;
    }

    public function getById($id): ?array
    {
        return isset($this->data[$id]) ? $this->data[$id] : null;
    }

    public function getBy($field, $value): array
    {
        return array_filter($this->data, function ($item) use ($field, $value) {
            return $item[$field] == $value;
        });
    }

    public function getAll(): array
    {
        return $this->data;
    }

    public function delete(Entity $entity): void
    {
        $entity->deleted = new DateTime();
        $this->update($entity);
    }


}