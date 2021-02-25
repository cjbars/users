<?php


namespace User\Validators;


use User\Entities\Entity;
use User\Storages\Storage;

class UniqueValidator implements Validator
{
    private Storage $storage;
    private string $fieldName;

    public function __construct(array $options = [])
    {
        $this->storage = $options['storage'];
        $this->fieldName = $options['fieldName'];
    }

    public function isValid($field, $options = []): bool
    {
        $entities = $this->storage->getBy($this->fieldName, $field);

        if(isset($options['primaryKey'])){
            $entities = array_filter($entities, function ($entity) use ($options){
                return $entity->getPrimaryKey() != $options['primaryKey'];
            });
        }
        return empty($entities);
    }

    public function getErrorMessage(): string
    {
        return sprintf('%s has been unique', $this->fieldName);
    }
}