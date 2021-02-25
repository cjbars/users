<?php

namespace User\Validators;


class LengthValidator implements Validator
{

    private int $min = 0;
    private int $max = 256;

    /**
     * LengthValidator constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        if (isset($options['min'])) {
            $this->min = (int)$options['min'];
        }
        if (isset($options['max'])) {
            $this->max = (int)$options['max'];
        }
    }

    public function isValid($field): bool
    {
        $length = mb_strlen((string)$field);
        return $length >= $this->min && $length <= $this->max;
    }

    public function getErrorMessage(): string
    {
        return sprintf('string length is not between %d and %d', $this->min, $this->max);
    }
}