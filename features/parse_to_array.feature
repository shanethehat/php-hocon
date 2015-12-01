Feature:
  In order to get configuration values from a Hocon format string as an array
  As a software developer
  I need to parse a Hocon string to an array

  Scenario: Parse a single string config value to an array
    Given I have a Hocon string 'foo = "bar"'
    When I parse the string to an array
    Then the result should have a key "foo"
    And the result key "foo" should have the string value "bar"

  Scenario: Parse a single number config value to an array
    Given I have a Hocon string 'foo = 5'
    When I parse the string to an array
    Then the result should have a key "foo"
    And the result key "foo" should have the number value "5"

  Scenario: Parse a single boolean config value to an array
    Given I have a Hocon string 'foo = true'
    When I parse the string to an array
    Then the result should have a key "foo"
    And the result key "foo" should have the boolean value "true"

  Scenario: Parse a single null config value to an array
    Given I have a Hocon string 'foo = null'
    When I parse the string to an array
    Then the result should have a key "foo"
    And the result key "foo" should have a null value
