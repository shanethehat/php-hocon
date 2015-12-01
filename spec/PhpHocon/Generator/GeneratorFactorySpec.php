<?php

namespace spec\PhpHocon\Generator;

use PhpHocon\Generator\GeneratorFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GeneratorFactorySpec extends ObjectBehavior
{
    function it_should_throw_an_error_if_the_generator_does_not_exist()
    {
        $this->shouldThrow('PhpHocon\Exception\UndefinedGeneratorException')->during('getGeneratorForType', ['foo']);
    }

    function it_should_return_an_array_generator()
    {
        $this->getGeneratorForType(GeneratorFactory::ARRAY_TYPE)->shouldHaveType('PhpHocon\Generator\ArrayGenerator');
    }
}
