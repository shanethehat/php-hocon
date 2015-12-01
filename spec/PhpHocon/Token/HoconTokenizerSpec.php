<?php

namespace spec\PhpHocon\Token;

use PhpHocon\Token\Field;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HoconTokenizerSpec extends ObjectBehavior
{
    function it_should_be_a_tokenizer()
    {
        $this->shouldImplement('PhpHocon\Token\Tokenizer');
    }


    function it_should_return_tokens_for_a_simple_key_and_string_value_pair()
    {
        $collection = $this->tokenize('key = "value"');
        $collection->shouldContainAFieldWithKey('key');
        $collection->shouldContainATypedValue('key', 'PhpHocon\Token\Value\StringValue', 'value');
    }

    function it_should_return_tokens_for_a_simple_key_and_integer_value_pair()
    {
        $collection = $this->tokenize('key = 3');
        $collection->shouldContainAFieldWithKey('key');
        $collection->shouldContainATypedValue('key', 'PhpHocon\Token\Value\NumberValue', 3);
    }

    function it_should_return_tokens_for_a_simple_key_and_float_value_pair()
    {
        $collection = $this->tokenize('key = 3.5');
        $collection->shouldContainAFieldWithKey('key');
        $collection->shouldContainATypedValue('key', 'PhpHocon\Token\Value\NumberValue', 3.5);
    }

    function it_should_return_tokens_for_a_simple_key_and_true_boolean_value_pair()
    {
        $collection = $this->tokenize('key = true');
        $collection->shouldContainAFieldWithKey('key');
        $collection->shouldContainATypedValue('key', 'PhpHocon\Token\Value\BooleanValue', true);
    }

    function it_should_return_tokens_for_a_simple_key_and_false_boolean_value_pair()
    {
        $collection = $this->tokenize('key = false');
        $collection->shouldContainAFieldWithKey('key');
        $collection->shouldContainATypedValue('key', 'PhpHocon\Token\Value\BooleanValue', false);
    }

    function it_should_return_tokens_for_a_simple_key_and_null_value_pair()
    {
        $collection = $this->tokenize('key = null');
        $collection->shouldContainAFieldWithKey('key');
        $collection->shouldContainATypedValue('key', 'PhpHocon\Token\Value\NullValue', null);
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
            'containATypedValue' => function ($subject, $key, $type, $value) {
                foreach ($subject as $token) {
                    if ($token instanceof Field &&
                        $token->getKey()->getName() === $key &&
                        $token->getValue() instanceof $type &&
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
