<?php


namespace User\Validators;


class DisallowedDomainsValidator implements Validator
{
    private array $domains = [];

    /**
     * DisallowedWordsValidator constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        if (isset($options['domains'])) {
            $this->domains = $options['domains'];
        }
    }

    public function isValid($field, $isUpdate = false): bool
    {
        $email = explode('@', $field);
        return !in_array($email[1], $this->domains);
    }

    public function getErrorMessage(): string
    {
        return 'word in disallowed';
    }
}