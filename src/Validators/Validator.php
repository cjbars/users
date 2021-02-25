<?php

namespace User\Validators;


interface Validator
{
    public function __construct(array $options = []);

    public function isValid($field, bool $isUpdate): bool;

    public function getErrorMessage(): string;
}