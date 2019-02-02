# features/healthcheck.feature

Feature: To ensure the API is responding in a simple manner

  In order to offer a working product
  As a conscientious software developer
  I need to ensure my JSON API is functioning

  Scenario: Basic healthcheck
    When I go to "/ping"
    Then the response status code should be 200