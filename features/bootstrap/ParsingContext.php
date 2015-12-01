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
        assert($resultValue === $value);
    }

    /**
     * @Then the result key :key should have the number value :value
     */
    public function theResultKeyShouldHaveTheNumberValue($key, $value)
    {
        $resultValue = $this->parserResult[$key];
        assert($resultValue === (int)$value);
    }

    /**
     * @Then the result key :key should have the boolean value :value
     */
    public function theResultKeyShouldHaveTheBooleanValue($key, $value)
    {
        $resultValue = $this->parserResult[$key];
        assert($resultValue === ($value === 'true'));
    }

    /**
     * @Then the result key :key should have a null value
     */
    public function theResultKeyShouldHaveANullValue($key)
    {
        $resultValue = $this->parserResult[$key];
        assert($resultValue === null);
    }
}
