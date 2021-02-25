<?php


namespace User\Validators;


class RegexValidator implements Validator
{

    const ALPHA = '/^[a-z]+$/';
    const NUM = '/^[0-9]+$/';
    const ALPHA_NUM = '/^[a-z0-9]+$/';

    private string $regex;

    /**
     * RegexValidator constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->regex = $options['regex'];
    }

    public function isValid($field): bool
    {
        return preg_match($this->regex, (string)$field) == 1;
    }

    public function getErrorMessage(): string
    {
        return 'String contain Incorrect symbols';
    }
}