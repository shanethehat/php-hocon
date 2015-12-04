<?php

namespace spec\PhpHocon\Token\Parser;

use PhpHocon\Token\Parser\ParserState;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class KeyParserSpec extends ObjectBehavior
{
    function it_should_be_a_parser()
    {
        $this->shouldImplement('PhpHocon\Token\Parser\Parser');
    }

    function it_should_not_parse_a_state_when_a_key_is_not_being_parsed()
    {
        $state = new ParserState(['='], 0, false, false);

        $this->canParse($state)->shouldReturn(false);
    }

    function it_should_not_parse_an_equals()
    {
        $state = new ParserState(['='], 0, false, true);

        $this->canParse($state)->shouldReturn(false);
    }

    function it_should_not_parse_a_colon()
    {
        $state = new ParserState([':'], 0, false, true);

        $this->canParse($state)->shouldReturn(false);
    }

    function it_should_not_parse_a_space()
    {
        $state = new ParserState([' '], 0, false, true);

        $this->canParse($state)->shouldReturn(false);
    }

    function it_should_stop_parsing_at_a_space()
    {
        $state = new ParserState(['k', 'e', 'y', ' '], 0, false, true);

        $this->parse($state)->getState()->getCharacters()->shouldReturn([' ']);
    }

    function it_should_stop_parsing_at_an_equals()
    {
        $state = new ParserState(['k', 'e', 'y', '='], 0, false, true);

        $this->parse($state)->getState()->getCharacters()->shouldReturn(['=']);
    }

    function it_should_stop_parsing_at_a_colon()
    {
        $state = new ParserState(['k', 'e', 'y', ':'], 0, false, true);

        $this->parse($state)->getState()->getCharacters()->shouldReturn([':']);
    }

    function it_should_return_a_correctly_named_key()
    {
        $state = new ParserState(['k', 'e', 'y', ' '], 0, false, true);

        $element = $this->parse($state)->getElement();
        $element->shouldHaveType('PhpHocon\Token\Key');
        $element->getName()->shouldReturn('key');
    }
}
