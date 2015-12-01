<?php

namespace spec\PhpHocon;

use PhpHocon\Generator\Generator;
use PhpHocon\Generator\GeneratorFactory;
use PhpHocon\Token\Collection;
use PhpHocon\Token\Tokenizer;
use PhpSpec\Exception\Example\PendingException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PhpHoconSpec extends ObjectBehavior
{
    function let(Tokenizer $tokenizer, GeneratorFactory $generatorFactory)
    {
        $this->beConstructedWith($tokenizer, $generatorFactory);
    }

    function it_should_coordinate_tokenizer_and_an_array_generator(
        Tokenizer $tokenizer, GeneratorFactory $generatorFactory, Generator $generator)
    {
        $tokens = ['foo'];
        $result = ['bar'];

        $generatorFactory->getGeneratorForType(GeneratorFactory::ARRAY_TYPE)->willReturn($generator);
        $tokenizer->tokenize(Argument::any())->willReturn($tokens);
        $generator->generate($tokens)->willReturn($result);

        $this->parseToArray('')->shouldReturn($result);
    }
}
