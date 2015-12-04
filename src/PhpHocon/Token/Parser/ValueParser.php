<?php

namespace PhpHocon\Token\Parser;

use PhpHocon\Token\Tokens;
use PhpHocon\Token\Value;
use PhpHocon\Token\Value\BooleanValue;
use PhpHocon\Token\Value\NullValue;
use PhpHocon\Token\Value\NumberValue;
use PhpHocon\Token\Value\StringValue;

class ValueParser implements Parser
{
    /**
     * @var array
     */
    private $illegalCharacters = [
        Tokens::EQUALS,
        Tokens::COLON,
        Tokens::SPACE,
        Tokens::NEW_LINE
    ];

    /**
     * @var bool
     */
    private $isQuotedString;

    /**
     * @var string
     */
    private $quoteCharacter;

    /**
     * @param ParserState $state
     * @return boolean
     */
    public function canParse(ParserState $state)
    {
        return !$state->isParsingKey() && $this->canStartGatheringValue($state);
    }

    /**
     * @param ParserState $state
     * @return ParseResult
     */
    public function parse(ParserState $state)
    {
        $characters = $state->getCharacters();
        $value = '';

        if (true === $this->isQuotedString = $this->isQuotedString($state->getHeadCharacter())) {
            $this->quoteCharacter = array_shift($characters);
        }

        while ($this->canStillParseValue($characters)) {
            $value .= array_shift($characters);
        }

        if (count($characters) && $characters[0] === $this->quoteCharacter) {
            array_shift($characters);
        }

        return new ParseResult(
            new ParserState($characters, $state->getBraceCount()),
            $this->getObjectForValue($value)
        );
    }

    /**
     * @param ParserState $state
     * @return bool
     */
    private function canStartGatheringValue(ParserState $state)
    {
        return !in_array($state->getHeadCharacter(), $this->illegalCharacters);
    }

    /**
     * @param string $character
     * @return bool
     */
    private function isQuotedString($character)
    {
        return in_array($character, [Tokens::APOSTROPHE, Tokens::SPEECH_MARK]);
    }

    /**
     * @param string[] $characters
     * @return bool
     */
    private function canStillParseValue(array $characters)
    {
        if (!count($characters)) {
            return false;
        }

        if ($this->isQuotedString && $characters[0] !== $this->quoteCharacter) {
            return true;
        }

        if ($this->isQuotedString && $characters[0] === $this->quoteCharacter) {
            return false;
        }

        return !in_array($characters[0], $this->illegalCharacters);
    }

    /**
     * @param string $value
     * @return Value
     */
    private function getObjectForValue($value)
    {
        if (is_numeric($value)) {
            return new NumberValue($this->convertStringToNumber($value));
        } elseif ($this->valueIsBoolean($value)) {
            return new BooleanValue($value === 'true');
        } elseif ($this->valueIsNull($value)) {
            return new NullValue();
        }

        return new StringValue($value);
    }

    /**
     * @param string $value
     * @return float|int
     */
    private function convertStringToNumber($value)
    {
        return strpos($value, '.') === false ? (int)$value : (float)$value;
    }

    /**
     * @param string $value
     * @return bool
     */
    private function valueIsBoolean($value)
    {
        return $value === 'true' || $value === 'false';
    }

    /**
     * @param string $value
     * @return bool
     */
    private function valueIsNull($value)
    {
        return $value === 'null';
    }
}
