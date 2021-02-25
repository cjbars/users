<?php


namespace User\Validators;


class EmailValidator implements Validator
{

    public function __construct(array $options = [])
    {
    }

    public function isValid($field, $isUpdate = false): bool
    {
        // данный метод сработает только на латинских адресах, намеренно упрощено
        return filter_var($field, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function getErrorMessage(): string
    {
        return 'Email is incorrect';
    }
}