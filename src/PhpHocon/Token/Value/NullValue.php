<?php

namespace PhpHocon\Token\Value;

class NullValue implements SimpleValue
{
    /**
     * @return null
     */
    public function getContent()
    {
        return null;
    }
}
