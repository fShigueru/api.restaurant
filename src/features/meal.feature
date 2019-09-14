# features/meal.feature
Feature: Fetch a meal
  Scenario: Search for meal name Bife a cavalo by id
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/api/meal/3"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    And the JSON node "name" should be equal to the string "Bife a cavalo"