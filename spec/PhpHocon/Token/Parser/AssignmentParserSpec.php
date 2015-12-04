<?php

namespace spec\PhpHocon\Token\Parser;

use PhpHocon\Token\Parser\ParserState;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AssignmentParserSpec extends ObjectBehavior
{
    function it_is_a_parser()
    {
        $this->shouldImplement('PhpHocon\Token\Parser\Parser');
    }

    function it_should_allow_to_parse_an_equals()
    {
        $state = new ParserState(['='], 0);

        $this->canParse($state)->shouldReturn(true);
    }

    function it_should_allow_to_parse_a_colon()
    {
        $state = new ParserState([':'], 0);

        $this->canParse($state)->shouldReturn(true);
    }

    function it_should_remove_an_equals()
    {
        $state = new ParserState(['=', ' '], 0);

        $this->parse($state)->getState()->getCharacters()->shouldReturn([' ']);
    }

    function it_should_remove_a_colon()
    {
        $state = new ParserState([':', ' '], 0);

        $this->parse($state)->getState()->getCharacters()->shouldReturn([' ']);
    }

    function it_should_set_that_a_key_is_no_longer_being_parsed()
    {
        $state = new ParserState(['=', ' '], 0);

        $this->parse($state)->getState()->isParsingKey()->shouldReturn(false);
    }
}
