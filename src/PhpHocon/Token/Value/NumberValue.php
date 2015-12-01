<?php

namespace PhpHocon\Token\Value;

class NumberValue implements SimpleValue
{
    /**
     * @var float|int
     */
    private $value;

    /**
     * @param int|float $value
     */
    public function __construct($value)
    {
        if (!is_int($value) && !is_float($value)) {
            throw new \UnexpectedValueException('Number values must be numeric');
        }

        $this->value = $value;
    }

    /**
     * @return float|int
     */
    public function getContent()
    {
        return $this->value;
    }
}
