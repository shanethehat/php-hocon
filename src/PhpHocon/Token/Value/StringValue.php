<?php

namespace PhpHocon\Token\Value;

class StringValue implements SimpleValue
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        if (!is_string($value)) {
            throw new \UnexpectedValueException('String value types must be constructed with a string');
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->value;
    }
}
