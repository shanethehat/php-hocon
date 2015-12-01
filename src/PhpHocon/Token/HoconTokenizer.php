<?php

namespace PhpHocon\Token;

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
     * @param string $input
     * @return Collection
     */
    public function tokenize($input)
    {
        $chars = str_split($input);

        $this->startParsing();

        for ($i = 0, $max = count($chars); $i < $max; $i++) {
            switch ($chars[$i]) {
                case Tokens::SPACE:
                    $this->stopCurrentAction();
                    break;
                case Tokens::EQUALS:
                case Tokens::COLON:
                    $this->leftSide = false;
                    $this->stopCurrentAction();
                    break;
                default:
                    $this->foundStart = true;
                    $this->currentValue .= $chars[$i];
            }
        }

        $this->stopCurrentAction();

        return $this->tokens;
        //return new Collection($this->tokens);
    }

    private function startParsing()
    {
        $this->currentValue = '';
        $this->tokens = [];
        $this->leftSide = true;
        $this->foundStart = false;
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
        if ($this->currentValueIsString()) {
            $this->tokens[] = new Field(
                $this->currentKey,
                new StringValue(substr($this->currentValue, 1, -1))
            );
        }
    }

    private function currentValueIsString()
    {
        return $this->startsAndEndsWith('"') || $this->startsAndEndsWith('\'');
    }

    private function startsAndEndsWith($string)
    {
        return $this->currentValue[0] === $string && $this->currentValue[strlen($this->currentValue) - 1] === $string;
    }
}
