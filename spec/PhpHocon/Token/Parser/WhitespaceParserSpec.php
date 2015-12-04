<?php

namespace spec\PhpHocon\Token\Parser;

use PhpHocon\Token\Parser\ParserState;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WhitespaceParserSpec extends ObjectBehavior
{
    function it_should_be_a_parser()
    {
        $this->shouldHaveType('PhpHocon\Token\Parser\Parser');
    }

    function it_should_be_able_to_parse_a_space()
    {
        $state = new ParserState([' '], 0);

        $this->canParse($state)->shouldReturn(true);
    }

    function it_should_be_able_to_parse_a_new_line()
    {
        $state = new ParserState(["\n"], 0);

        $this->canParse($state)->shouldReturn(true);
    }

    function it_should_set_parsing_key_to_true_when_it_finds_a_new_line()
    {
        $state = new ParserState(["\n"], 0, false, false);

        $this->parse($state)->getState()->isParsingKey()->shouldReturn(true);
    }
}
