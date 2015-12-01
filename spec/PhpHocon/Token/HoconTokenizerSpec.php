<?php

namespace spec\PhpHocon\Token;

use PhpHocon\Token\Field;
use PhpHocon\Token\Value\StringValue;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HoconTokenizerSpec extends ObjectBehavior
{
    function it_should_be_a_tokenizer()
    {
        $this->shouldImplement('PhpHocon\Token\Tokenizer');
    }

//    function it_should_return_a_token_collection_object()
//    {
//        $this->tokenize('')->shouldBeAnInstanceOf('PhpHocon\Token\Collection');
//    }
//
//    function it_should_return_an_empty_collection_for_an_empty_string()
//    {
//        $collection = $this->tokenize('');
//        $collection->isEmpty()->shouldReturn(true);
//    }

    function it_should_return_tokens_for_a_simple_key_value_pair()
    {
        $collection = $this->tokenize('key = "value"');
        $collection->shouldContainAFieldWithKey('key');
        $collection->shouldContainAStringValue('key', 'value');
    }

    function getMatchers()
    {
        return [
            'containAFieldWithKey' => function ($subject, $key) {
                foreach ($subject as $token) {
                    if ($token instanceof Field && $token->getKey()->getName() === $key) {
                        return true;
                    }
                }
                return false;
            },
            'containAStringValue' => function ($subject, $key, $value) {
                foreach ($subject as $token) {
                    if ($token instanceof Field &&
                        $token->getKey()->getName() === $key &&
                        $token->getValue() instanceof StringValue &&
                        $token->getValue()->getContent() === $value
                    ) {
                        return true;
                    }
                }
                return false;
            },
        ];
    }
}
