<?php

namespace PhpHocon\Token\Parser;

use PhpHocon\Token\Tokens;

class AssignmentParser implements Parser
{
    /**
     * @param ParserState $state
     * @return boolean
     */
    public function canParse(ParserState $state)
    {
        $character = $state->getHeadCharacter();
        return $character === Tokens::COLON || $character === Tokens::EQUALS;
    }

    /**
     * @param ParserState $state
     * @return ParseResult
     */
    public function parse(ParserState $state)
    {
        return new ParseResult(new ParserState(array_slice($state->getCharacters(), 1), $state->getBraceCount()), null);
    }
}
