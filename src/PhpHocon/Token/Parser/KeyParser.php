<?php

namespace PhpHocon\Token\Parser;

use PhpHocon\Token\Key;
use PhpHocon\Token\Tokens;

class KeyParser implements Parser
{
    /**
     * @var array
     */
    private $breakCharacters = [
        Tokens::EQUALS,
        Tokens::COLON,
        Tokens::SPACE
    ];

    /**
     * @param ParserState $state
     * @return boolean
     */
    public function canParse(ParserState $state)
    {
        return $state->isParsingKey() && !in_array($state->getHeadCharacter(), $this->breakCharacters);
    }

    /**
     * @param ParserState $state
     * @return ParseResult
     */
    public function parse(ParserState $state)
    {
        $characters = $state->getCharacters();
        $keyName = '';

        while ($this->canParseKey($characters)) {
            $keyName .= array_shift($characters);
        }

        return new ParseResult(
            new ParserState($characters, $state->getBraceCount(), false, true),
            new Key($keyName)
        );
    }

    /**
     * @param string[] $characters
     * @return bool
     */
    private function canParseKey(array $characters)
    {
        return !empty($characters) && !in_array($characters[0], $this->breakCharacters);
    }
}
