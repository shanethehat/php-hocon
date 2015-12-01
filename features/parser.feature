Feature:
  In order to get configuration values from a Hocon format string
  As a software developer
  I need to parse a Hocon string to a readable object

  Scenario: Parse a single config value to an array
    Given I have a Hocon string 'foo = "bar"'
    When I parse the string to an array
    Then the result should have a key "foo"
    And the result key "foo" should have the string value "bar"
