<?php


namespace User\Validators;


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

    public function isValid($field = null, $isUpdate = false): bool
    {
        $entities = $this->storage->getBy($this->fieldName, $field);
        return $isUpdate ? count($entities) <= 1 : empty($entities);
    }

    public function getErrorMessage(): string
    {
        return sprintf('%s has been unique', $this->fieldName);
    }
}