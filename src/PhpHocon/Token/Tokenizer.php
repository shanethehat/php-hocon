<?php

namespace PhpHocon\Token;

interface Tokenizer
{
    /**
     * @param string $input
     * @return Collection
     */
    public function tokenize($input);
}
