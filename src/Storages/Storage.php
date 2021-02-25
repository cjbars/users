<?php

namespace User\Storages;

use User\Entities\Entity;

interface Storage
{

    public function getById($id): ?Entity;

    public function getBy($field, $value);

    public function getAll();

    public function create(Entity $entity): Entity;

    public function update($id, Entity $entity): ?Entity;

}