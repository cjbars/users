<?php

namespace User\Storages;


use User\Entities\Entity;

class ArrayStorage implements Storage
{

    private array $data;

    public function __construct(array $initialState = [])
    {
        $this->data = $initialState;
    }

    public function getById($id): ?Entity
    {
        return isset($this->data[$id]) ? unserialize($this->data[$id]) : null;
    }

    public function getBy($field, $value): array
    {
        return array_filter($this->data, function ($item) use ($field, $value) {
            $entity = unserialize($item);
            return isset($entity->$field) ? $entity->$field === $value : false;
        });
    }

    public function getAll(): array
    {
        return $this->data;
    }

    public function create(Entity $entity): Entity
    {
        $key = count($this->data) + 1;
        $entity->setPrimaryKey($key);
        $this->data[$key] = serialize($entity);
        return $entity;
    }

    public function update($id, Entity $entity): ?Entity
    {
        if (!isset($this->data[$id])) return null;
        $this->data[$id] = serialize($entity);
        return $entity;
    }

    public function delete(Entity $entity): void
    {
        if (!isset($this->data[$entity->getPrimaryKey()])) return;
        unset($this->data[$entity->getPrimaryKey()]);
    }

    public function read($conditions)
    {
        // TODO: Implement read() method.
    }
}