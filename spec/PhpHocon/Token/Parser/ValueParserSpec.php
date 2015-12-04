<?php

namespace spec\PhpHocon\Token\Parser;

use PhpHocon\Token\Parser\ParserState;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ValueParserSpec extends ObjectBehavior
{
    function it_should_be_a_parser()
    {
        $this->shouldImplement('PhpHocon\Token\Parser\Parser');
    }

    function it_should_not_parse_a_value_when_a_key_is_being_parsed()
    {
        $state = new ParserState(['1'], 0, false, true);

        $this->canParse($state)->shouldReturn(false);
    }

    function it_should_not_start_parsing_on_an_equals()
    {
        $state = new ParserState(['='], 0, false, false);

        $this->canParse($state)->shouldReturn(false);
    }

    function it_should_not_start_parsing_on_a_colon()
    {
        $state = new ParserState([':'], 0, false, false);

        $this->canParse($state)->shouldReturn(false);
    }

    function it_should_not_start_parsing_on_a_space()
    {
        $state = new ParserState([' '], 0, false, false);

        $this->canParse($state)->shouldReturn(false);
    }

    function it_should_not_start_parsing_on_a_new_line()
    {
        $state = new ParserState(["\n"], 0, false, false);

        $this->canParse($state)->shouldReturn(false);
    }

    function it_should_parse_a_double_quoted_string_value()
    {
        $state = new ParserState(['"', 'v', 'a', 'l', '"', ' '], 0);

        $element = $this->parse($state)->getElement();
        $element->shouldHaveType('PhpHocon\Token\Value\StringValue');
        $element->getContent()->shouldReturn('val');
    }

    function it_should_parse_a_single_quoted_string_value()
    {
        $state = new ParserState(["'", 'v', 'a', 'l', "'", ' '], 0);

        $element = $this->parse($state)->getElement();
        $element->shouldHaveType('PhpHocon\Token\Value\StringValue');
        $element->getContent()->shouldReturn('val');
    }

    function it_should_parse_an_unquoted_string_value()
    {
        $state = new ParserState(['v', 'a', 'l', ' '], 0);

        $element = $this->parse($state)->getElement();
        $element->shouldHaveType('PhpHocon\Token\Value\StringValue');
        $element->getContent()->shouldReturn('val');
    }

    function it_should_parse_an_integer_value()
    {
        $state = new ParserState(['3', '4', '5', ' '], 0);

        $element = $this->parse($state)->getElement();
        $element->shouldHaveType('PhpHocon\Token\Value\NumberValue');
        $element->getContent()->shouldReturn(345);
    }

    function it_should_parse_a_float_value()
    {
        $state = new ParserState(['3', '.', '5', ' '], 0);

        $element = $this->parse($state)->getElement();
        $element->shouldHaveType('PhpHocon\Token\Value\NumberValue');
        $element->getContent()->shouldReturn(3.5);
    }

    function it_should_parse_a_boolean_true_value()
    {
        $state = new ParserState(['t', 'r', 'u', 'e', ' '], 0);

        $element = $this->parse($state)->getElement();
        $element->shouldHaveType('PhpHocon\Token\Value\BooleanValue');
        $element->getContent()->shouldReturn(true);
    }

    function it_should_parse_a_boolean_false_value()
    {
        $state = new ParserState(['f', 'a', 'l', 's', 'e', ' '], 0);

        $element = $this->parse($state)->getElement();
        $element->shouldHaveType('PhpHocon\Token\Value\BooleanValue');
        $element->getContent()->shouldReturn(false);
    }

    function it_should_parse_a_null_value()
    {
        $state = new ParserState(['n', 'u', 'l', 'l', ' '], 0);

        $element = $this->parse($state)->getElement();
        $element->shouldHaveType('PhpHocon\Token\Value\NullValue');
    }
}
