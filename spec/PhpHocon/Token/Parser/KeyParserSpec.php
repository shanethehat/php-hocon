<?php

namespace spec\PhpHocon\Token\Parser;

use PhpHocon\Token\Parser\ParserState;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Yaml\Exception\ParseException;

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

    function it_should_return_keys_containing_periods()
    {
        $state = new ParserState(['a', '.', 'b', '.', 'c'], 0, false, true);

        $element = $this->parse($state)->getElement();
        $element->shouldHaveType('PhpHocon\Token\Key');
        $element->getName()->shouldReturn('a.b.c');
    }

    function it_should_reject_keys_ending_in_a_period()
    {
        $state = new ParserState(['a', '.', 'b', '.', ' '], 0, false, true);

        $this->shouldThrow(new ParseException('Malformed key: a.b.'))->during('parse', [$state]);
    }
}
