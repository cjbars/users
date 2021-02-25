<?php

namespace User\Repositories;


use Exception;
use Psr\Log\LoggerInterface;
use User\Entities\Entity;
use User\Exceptions\ValidationException;
use User\Storages\Storage;
use User\Validators\Validator;

abstract class Repository
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

    abstract public function getById($id): ?Entity;

    /**
     * @param Entity $entity
     * @return bool
     * @throws Exception
     */
    public function save(Entity $entity): ?bool
    {
        $this->validate($entity, ['primaryKey' => $entity->getPrimaryKey()]);
        $saved = $this->storage->save($entity);
        $this->logger->notice('User saved', $saved->toArray());
        return true;
    }

    /**
     * @param Entity $entity
     * @param array $options
     * @throws ValidationException
     * @throws Exception
     */
    public function validate(Entity $entity, $options = []): void
    {
        foreach ($this->rules() as $field => $rules) {

            if (!property_exists($entity, $field)) {
                throw new Exception('Property no exists in entity');
            }
            /**
             * @var Validator $rule
             */
            foreach ($rules as $rule) {
                if (!$rule->isValid($entity->$field, $options)) {
                    throw new ValidationException($rule->getErrorMessage());
                }
            }
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @param Entity $entity
     * @return Entity
     * @throws Exception
     */
    public function create(Entity $entity): Entity
    {
        $this->validate($entity);
        return $this->storage->create($entity);
    }
}