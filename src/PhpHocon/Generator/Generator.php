<?php

namespace PhpHocon\Generator;

interface Generator
{
    /**
     * @param array $tokens
     * @return mixed
     */
    public function generate(array $tokens);
}
