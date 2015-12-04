<?php

namespace PhpHocon\Token\Parser;

interface Parser
{
    /**
     * @param ParserState $state
     * @return boolean
     */
    public function canParse(ParserState $state);

    /**
     * @param ParserState $state
     * @return ParseResult
     */
    public function parse(ParserState $state);
}
