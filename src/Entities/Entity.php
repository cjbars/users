<?php

namespace User\Entities;


abstract class Entity
{

    abstract public function setPrimaryKey($key);

    abstract public function getPrimaryKey();

    public function toArray(): array
    {
        return (array)$this;
    }
}