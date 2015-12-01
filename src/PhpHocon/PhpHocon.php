<?php

namespace PhpHocon;

use PhpHocon\Generator\Generator;
use PhpHocon\Generator\GeneratorFactory;
use PhpHocon\Token\HoconTokenizer;
use PhpHocon\Token\Tokenizer;

class PhpHocon
{
    /**
     * @var Tokenizer
     */
    private $tokenizer;

    /**
     * @var GeneratorFactory
     */
    private $generatorFactory;

    /**
     * @param Tokenizer $tokenizer
     * @param GeneratorFactory $generatorFactory
     */
    public function __construct(Tokenizer $tokenizer = null, GeneratorFactory $generatorFactory = null)
    {
        $this->tokenizer = $tokenizer ?: new HoconTokenizer();
        $this->generatorFactory = $generatorFactory ?: new GeneratorFactory();
    }

    /**
     * @param string $input
     * @return \stdClass
     */
    public function parseToArray($input)
    {
        $generator = $this->generatorFactory->getGeneratorForType(GeneratorFactory::ARRAY_TYPE);
        $tokens = $this->tokenizer->tokenize($input);
        return $generator->generate($tokens);
    }
}
