<?php

namespace PhpHocon\Token;

use PhpHocon\Exception\ParseException;
use PhpHocon\Token\Parser\AssignmentParser;
use PhpHocon\Token\Parser\KeyParser;
use PhpHocon\Token\Parser\Parser;
use PhpHocon\Token\Parser\ParserState;
use PhpHocon\Token\Parser\ValueParser;
use PhpHocon\Token\Parser\WhitespaceParser;

class HoconTokenizer implements Tokenizer
{
    /**
     * @var array
     */
    private $tokens;

    /**
     * @var Parser[]
     */
    private $parserChain;

    public function __construct()
    {
        $this->parserChain = [
            new KeyParser(),
            new ValueParser(),
            new AssignmentParser(),
            new WhitespaceParser()
        ];
    }

    /**
     * @param string $input
     * @return array
     */
    public function tokenize($input)
    {
        $this->tokens = [];
        $chars = $this->createCharacterList($input);

        $initialState = new ParserState($chars, 0, false, true);
        $endState = $this->parseState($initialState);

        $this->checkParserState($endState);

        return $this->tokens;
    }

    /**
     * @param ParserState $state
     */
    private function checkParserState(ParserState $state)
    {
        if (count($state->getCharacters())) {
            throw new ParseException(
                'Config file was not parsed completely. Remaining: ' . implode($state->getCharacters())
            );
        }
    }

    /**
     * @param $input
     * @return array
     */
    private function createCharacterList($input)
    {
        $chars = str_split($input);

        if ($chars[0] !== Tokens::LEFT_BRACE) {
            return $chars;
        }

        if ($chars[count($chars)-1] !== Tokens::RIGHT_BRACE) {
            throw new ParseException('Brace count is not equal');
        }

        return array_slice($chars, 1, -1);
    }

    private function parseState(ParserState $state)
    {
        if (count($state->getCharacters()) === 0) {
            return $state;
        }

        foreach ($this->parserChain as $parser) {
            if ($parser->canParse($state)) {
                $result = $parser->parse($state);
                if (null !== $element = $result->getElement()) {
                    $this->tokens[] = $result->getElement();
                }
                return $this->parseState($result->getState());
            }
        }

        return $state;
    }
}
