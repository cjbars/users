<?php


namespace User\Validators;


class DisallowedWordsValidator implements Validator
{
    private array $words = [];

    /**
     * DisallowedWordsValidator constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        if (isset($options['words'])) {
            $this->words = $options['words'];
        }
    }

    public function isValid($field, $isUpdate = false): bool
    {
        return !in_array($field, $this->words);
    }

    public function getErrorMessage(): string
    {
        return 'word in disallowed';
    }
}