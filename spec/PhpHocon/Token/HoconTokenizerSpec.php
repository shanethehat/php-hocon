<?php

namespace spec\PhpHocon\Token;

use PhpHocon\Exception\ParseException;
use PhpHocon\Token\Field;
use PhpHocon\Token\Key;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HoconTokenizerSpec extends ObjectBehavior
{
    function it_should_be_a_tokenizer()
    {
        $this->shouldImplement('PhpHocon\Token\Tokenizer');
    }

    function it_should_ignore_outermost_braces()
    {
        $collection = $this->tokenize($this->getSingleValueWithOuterBraces());
        $collection->shouldContainATypedValue('key', 'PhpHocon\Token\Value\StringValue', 'value');
    }

    function it_should_return_tokens_for_a_simple_key_and_string_value_pair()
    {
        $collection = $this->tokenize('key = "value"');
        $collection->shouldContainATypedValue('key', 'PhpHocon\Token\Value\StringValue', 'value');
    }

    function it_should_return_tokens_for_a_simple_key_and_integer_value_pair()
    {
        $collection = $this->tokenize('key = 3');
        $collection->shouldContainATypedValue('key', 'PhpHocon\Token\Value\NumberValue', 3);
    }

    function it_should_return_tokens_for_a_simple_key_and_float_value_pair()
    {
        $collection = $this->tokenize('key = 3.5');
        $collection->shouldContainATypedValue('key', 'PhpHocon\Token\Value\NumberValue', 3.5);
    }

    function it_should_return_tokens_for_a_simple_key_and_true_boolean_value_pair()
    {
        $collection = $this->tokenize('key = true');
        $collection->shouldContainATypedValue('key', 'PhpHocon\Token\Value\BooleanValue', true);
    }

    function it_should_return_tokens_for_a_simple_key_and_false_boolean_value_pair()
    {
        $collection = $this->tokenize('key = false');
        $collection->shouldContainATypedValue('key', 'PhpHocon\Token\Value\BooleanValue', false);
    }

    function it_should_return_tokens_for_a_simple_key_and_null_value_pair()
    {
        $collection = $this->tokenize('key = null');
        $collection->shouldContainATypedValue('key', 'PhpHocon\Token\Value\NullValue', null);
    }

    function it_should_handle_strings_containing_spaces()
    {
        $collection = $this->tokenize('key = "my value"');
        $collection->shouldContainATypedValue('key', 'PhpHocon\Token\Value\StringValue', 'my value');
    }

    function it_should_throw_an_exception_if_braces_are_not_balanced()
    {
        $input = substr($this->getSingleValueWithOuterBraces(), 0, -1);
        $this->shouldThrow(new ParseException('Brace count is not equal'))->during('tokenize', [$input]);
    }

    function it_should_parse_multiple_simple_key_value_pairs()
    {
        $collection = $this->tokenize($this->getTwoSimpleValues());
        $collection->shouldContainATypedValue('key1', 'PhpHocon\Token\Value\StringValue', 'value1');
        $collection->shouldContainATypedValue('key2', 'PhpHocon\Token\Value\StringValue', 'value2');
    }

    function getMatchers()
    {
        return ['containATypedValue' => function ($subject, $key, $type, $value) {
                for ($i = 0, $max = count($subject); $i < $max; $i++) {
                    if ($subject[$i] instanceof Key && $subject[$i]->getName() === $key) {
                        $valueElement = $subject[$i+1];
                        return $valueElement instanceof $type && $valueElement->getContent() === $value;
                    }
                }
                return false;
            },
        ];
    }

    /**
     * @return string
     */
    private function getSingleValueWithOuterBraces()
    {
        return <<<EOT
{
    key = "value"
}
EOT;
    }

    private function getTwoSimpleValues()
    {
        return <<<EOT
key1 = "value1"
key2 = "value2"
EOT;
    }
}
