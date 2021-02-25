<?php

namespace User\Storages;

use User\Entities\Entity;

interface Storage
{

    public function getById($id);

    public function getBy($field, $value);

    public function getAll();

    public function save(Entity $entity): Entity;

    public function create(Entity $entity): Entity;

    public function update(Entity $entity): Entity;

    public function delete(Entity $entity): void;

}