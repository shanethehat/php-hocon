<?php

namespace PhpHocon\Token\Parser;

use PhpHocon\Token\Element;

class ParseResult
{
    /**
     * @var ParserState
     */
    private $state;

    /**
     * @var Element
     */
    private $element;

    /**
     * @param ParserState $state
     * @param Element $element
     */
    public function __construct(ParserState $state, Element $element = null)
    {
        $this->state = $state;
        $this->element = $element;
    }

    /**
     * @return ParserState
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return Element
     */
    public function getElement()
    {
        return $this->element;
    }
}
