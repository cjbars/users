<?php

namespace User\Repositories;


use Psr\Log\LoggerInterface;
use User\Entities\Entity;
use User\Exceptions\ValidationException;
use User\Storages\Storage;

class Repository
{
    protected Storage $storage;

    protected LoggerInterface $logger;

    /**
     * Repository constructor.
     * @param Storage $storage
     * @param LoggerInterface $logger
     */
    public function __construct(Storage $storage, LoggerInterface $logger)
    {
        $this->storage = $storage;
        $this->logger = $logger;
    }

    public function getAll(): ?array
    {
        return $this->storage->getAll();
    }

    public function getById($id): ?Entity
    {
        return $this->storage->getById($id);
    }

    /**
     * @param $id
     * @param Entity $entity
     * @return Entity|bool
     * @throws ValidationException
     */
    public function update($id, Entity $entity): ?Entity
    {
        /**
         * @var Entity|bool $oldEntity
         */
        $oldEntity = $this->storage->getById($id);
        if (!$oldEntity) return false;
        $this->validate($entity, true);
        $saved = $this->storage->update($oldEntity->getPrimaryKey(), $entity);
        $this->logger->notice('User updated', $saved->toArray());
        return $saved;
    }

    /**
     * @param Entity $entity
     * @param bool $isUpdate
     * @throws ValidationException
     */
    public function validate(Entity $entity, $isUpdate = false): void
    {
        foreach ($this->rules() as $field => $validators) {
            if (!property_exists($entity, $field)) {
                throw new ValidationException('Property no exists in entity');
            }

            foreach ($validators as $validator) {
                if (!$validator->isValid($entity->$field, $isUpdate)) {
                    throw new ValidationException($validator->getErrorMessage());
                }
            }
        }
    }

    public function rules(): array
    {
        return [];
    }

    /**
     * @param Entity $entity
     * @return Entity
     * @throws ValidationException
     */
    public function create(Entity $entity): Entity
    {
        $this->validate($entity);
        return $this->storage->create($entity);
    }
}