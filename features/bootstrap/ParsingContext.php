<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use PhpHocon\PhpHocon;

class ParsingContext implements SnippetAcceptingContext
{
    private $hoconString;
    private $parserResult;

    /**
     * @Given I have a Hocon string :hoconString
     */
    public function iHaveAHoconString($hoconString)
    {
        $this->hoconString = $hoconString;
    }

    /**
     * @When I parse the string to an array
     */
    public function iParseTheStringToAnArray()
    {
        $parser = new PhpHocon();
        $this->parserResult = $parser->parseToArray($this->hoconString);
    }

    /**
     * @Then the result should have a key :key
     */
    public function theResultShouldHaveAKey($key)
    {
        assert(array_key_exists($key, $this->parserResult));
    }

    /**
     * @Then the result key :key should have the string value :value
     */
    public function theResultKeyShouldHaveTheStringValue($key, $value)
    {
        $resultValue = $this->parserResult[$key];
        assert(is_string($value));
        assert($resultValue === $value);
    }
}
