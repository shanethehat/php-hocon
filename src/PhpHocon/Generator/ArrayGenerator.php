<?php

namespace PhpHocon\Generator;

use PhpHocon\Token\Field;

class ArrayGenerator implements Generator
{
    /**
     * @param array $tokens
     * @return array
     */
    public function generate(array $tokens)
    {
        $output = [];

        if (count($tokens)) {
            $output = $this->extractFieldToOutput($tokens[0], $output);
        }

        return $output;
    }

    /**
     * @param Field $field
     * @param array $output
     * @return array
     */
    private function extractFieldToOutput(Field $field, array $output)
    {
        $output[$field->getKey()->getName()] = $field->getValue()->getContent();
        return $output;
    }
}
