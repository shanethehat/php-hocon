<?php

namespace PhpHocon\Token\Parser;

use PhpHocon\Token\Value\ObjectValue;

class ParserState
{
    /**
     * @var string[]
     */
    private $characters;

    /**
     * @var int
     */
    private $braceCount;
    /**
     * @var bool
     */
    private $parsingString;
    /**
     * @var bool
     */
    private $parsingKey;

    /**
     * @param string[] $characters
     * @param int $braceCount
     * @param bool $parsingString
     * @param bool $parsingKey
     */
    public function __construct(
        array $characters,
        $braceCount,
        $parsingString = false,
        $parsingKey = false
    ) {
        $this->characters = $characters;
        $this->braceCount = $braceCount;
        $this->parsingString = $parsingString;
        $this->parsingKey = $parsingKey;
    }

    /**
     * @return boolean
     */
    public function isParsingString()
    {
        return $this->parsingString;
    }

    /**
     * @return boolean
     */
    public function isParsingKey()
    {
        return $this->parsingKey;
    }

    /**
     * @return int
     */
    public function getBraceCount()
    {
        return $this->braceCount;
    }

    /**
     * @return string[]
     */
    public function getCharacters()
    {
        return $this->characters;
    }

    /**
     * @return string
     */
    public function getHeadCharacter()
    {
        return $this->characters[0];
    }
}
