<?php

namespace PhpHocon\Token;

class Field
{
    /**
     * @var Key
     */
    private $key;

    /**
     * @var Value
     */
    private $value;

    /**
     * @param Key $key
     * @param Value $value
     */
    public function __construct(Key $key, Value $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return Key
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return Value
     */
    public function getValue()
    {
        return $this->value;
    }
}
