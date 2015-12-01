<?php

namespace PhpHocon\Generator;

use PhpHocon\Exception\UndefinedGeneratorException;

class GeneratorFactory
{
    const ARRAY_TYPE = 'Array';

    /**
     * @param string $type
     * @return Generator
     */
    public function getGeneratorForType($type)
    {
        $className = sprintf('PhpHocon\\Generator\\%sGenerator', $type);

        if (!class_exists($className)) {
            throw new UndefinedGeneratorException("The generator $className was not found");
        }

        return new $className;
    }
}
