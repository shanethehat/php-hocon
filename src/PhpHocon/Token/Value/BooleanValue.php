<?php

namespace PhpHocon\Token\Value;

class BooleanValue implements SimpleValue
{
    /**
     * @var bool
     */
    private $value;

    /**
     * @param bool $value
     */
    public function __construct($value)
    {
        if (!is_bool($value)) {
            throw new \UnexpectedValueException('Boolean Values must be created with a boolean value');
        }

        $this->value = $value;
    }

    /**
     * @return boolean
     */
    public function getContent()
    {
        return $this->value;
    }
}
