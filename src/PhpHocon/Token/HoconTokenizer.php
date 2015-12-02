<?php

namespace PhpHocon\Token;

use PhpHocon\Exception\ParseException;
use PhpHocon\Token\Value\BooleanValue;
use PhpHocon\Token\Value\NullValue;
use PhpHocon\Token\Value\NumberValue;
use PhpHocon\Token\Value\StringValue;

class HoconTokenizer implements Tokenizer
{
    /**
     * @var Key
     */
    private $currentKey;

    /**
     * @var string
     */
    private $currentValue;

    /**
     * @var array
     */
    private $tokens;

    /**
     * @var bool
     */
    private $leftSide;

    /**
     * @var bool
     */
    private $foundStart;

    /**
     * @var bool
     */
    private $stringStarted;

    /**
     * @var string
     */
    private $currentStringDeliminator;

    /**
     * @var int
     */
    private $braceCount;

    /**
     * @param string $input
     * @return Collection
     */
    public function tokenize($input)
    {
        $chars = str_split($input);

        $this->startParsing();

        for ($i = 0, $max = count($chars); $i < $max; $i++) {
            switch ($chars[$i]) {
                case Tokens::LEFT_BRACE:
                    $this->handleOpeningBrace();
                    break;
                case Tokens::RIGHT_BRACE:
                    $this->handleClosingBrace();
                    break;
                case Tokens::SPEECH_MARK:
                case Tokens::APOSTROPHE:
                    $this->handleStringDeliminator($chars[$i]);
                    break;
                case Tokens::SPACE:
                    $this->handleSpace($chars[$i]);
                    break;
                case Tokens::EQUALS:
                case Tokens::COLON:
                    $this->leftSide = false;
                    $this->stopCurrentAction();
                    break;
                case Tokens::NEW_LINE:
                    if ($this->stringStarted) {
                        $this->currentValue .= $chars[$i];
                    } else {
                        $this->stopCurrentAction();
                    }
                default:
                    $this->foundStart = true;
                    $this->currentValue .= $chars[$i];
            }
        }

        $this->stopCurrentAction();

        $this->checkParserState();

        return $this->tokens;
        //return new Collection($this->tokens);
    }

    private function startParsing()
    {
        $this->currentValue = '';
        $this->tokens = [];
        $this->leftSide = true;
        $this->foundStart = false;
        $this->stringStarted = false;
        $this->braceCount = 0;
    }

    private function stopCurrentAction()
    {
        if (!$this->foundStart) {
            return;
        }

        $this->foundStart = false;

        if ($this->leftSide) {
            $this->currentKey = new Key($this->currentValue);
            $this->currentValue = '';
            return;
        }

        $this->saveCurrentAsValue();
        $this->currentValue = '';
    }

    private function saveCurrentAsValue()
    {
        if (is_numeric($this->currentValue)) {
            $this->tokens[] = new Field(
                $this->currentKey,
                new NumberValue($this->convertStringToNumber($this->currentValue))
            );
        } elseif ($this->currentValueIsBoolean()) {
            $this->tokens[] = new Field(
                $this->currentKey,
                new BooleanValue($this->currentValue === 'true')
            );
        } elseif ($this->currentValueIsNull()) {
            $this->tokens[] = new Field(
                $this->currentKey,
                new NullValue()
            );
        } else {
            $this->tokens[] = new Field(
                $this->currentKey,
                new StringValue($this->currentValue)
            );
        }
    }

    private function convertStringToNumber($value)
    {
        return strpos($value, '.') === false ? (int)$value : (float)$value;
    }

    private function currentValueIsBoolean()
    {
        return $this->currentValue === 'true' || $this->currentValue === 'false';
    }

    private function currentValueIsNull()
    {
        return $this->currentValue === 'null';
    }

    private function handleStringDeliminator($deliminator)
    {
        if (!$this->stringStarted) {
            $this->stringStarted = true;
            $this->currentStringDeliminator = $deliminator;
            return;
        }

        if ($this->currentStringDeliminator === $deliminator) {
            $this->stringStarted = false;
            return;
        }

        $this->currentValue .= $deliminator;
    }

    /**
     * @param string $character
     */
    private function handleSpace($character)
    {
        if ($this->stringStarted) {
            $this->currentValue .= $character;
        } else {
            $this->stopCurrentAction();
        }
    }

    private function handleOpeningBrace()
    {
        if ($this->stringStarted) {
            $this->currentValue .= Tokens::LEFT_BRACE;
        } else {
            $this->braceCount++;
        }
    }

    private function handleClosingBrace()
    {
        if ($this->stringStarted) {
            $this->currentValue .= Tokens::RIGHT_BRACE;
        } else {
            $this->braceCount--;
        }
    }

    private function checkParserState()
    {
        if ($this->braceCount !== 0) {
            throw new ParseException('Brace count is not equal');
        }
    }
}
