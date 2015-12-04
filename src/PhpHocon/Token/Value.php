<?php

namespace PhpHocon\Token;

interface Value extends Element
{
    /**
     * @return mixed
     */
    public function getContent();
}
