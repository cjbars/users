<?php

namespace User\Validators;


interface Validator
{
    public function __construct(array $options = []);

    public function isValid($field): bool;

    public function getErrorMessage(): string;
}