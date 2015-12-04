<?php

namespace PhpHocon\Token\Parser;

use PhpHocon\Token\Tokens;

class WhitespaceParser implements Parser
{
    /**
     * @param ParserState $state
     * @return boolean
     */
    public function canParse(ParserState $state)
    {
        return $state->getHeadCharacter() === Tokens::SPACE
            || $state->getHeadCharacter() === Tokens::NEW_LINE;
    }

    /**
     * @param ParserState $state
     * @return ParseResult
     */
    public function parse(ParserState $state)
    {
        $parsingKey = $state->isParsingKey();

        if ($state->getHeadCharacter() === Tokens::NEW_LINE) {
            $parsingKey = true;
        }

        return new ParseResult(
            new ParserState(
                array_slice($state->getCharacters(), 1),
                $state->getBraceCount(),
                $state->isParsingString(),
                $parsingKey
            ),
            null
        );
    }
}
