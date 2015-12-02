<?php

namespace PhpHocon\Token;

interface Tokenizer
{
    /**
     * @param string $input
     * @return array
     */
    public function tokenize($input);
}
