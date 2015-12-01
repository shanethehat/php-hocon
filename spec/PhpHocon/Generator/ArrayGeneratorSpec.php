<?php

namespace spec\PhpHocon\Generator;

use PhpHocon\Token\Field;
use PhpHocon\Token\Key;
use PhpHocon\Token\Value\StringValue;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArrayGeneratorSpec extends ObjectBehavior
{
    function it_should_be_a_generator()
    {
        $this->shouldImplement('PhpHocon\Generator\Generator');
    }

    function it_returns_an_empty_array_when_given_no_tokens()
    {
        $this->generate([])->shouldReturn([]);
    }

    function it_returns_a_single_simple_field()
    {
        $field = new Field(new Key('key'), new StringValue('value'));
        $this->generate([$field])->shouldReturn(['key' => 'value']);
    }
}
