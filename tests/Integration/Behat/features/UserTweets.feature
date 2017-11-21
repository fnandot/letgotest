Feature: LetShout API
  In order to see if user tweets endpoint works correctly
  I need to be able to request user tweets

  Scenario: I want to see that the requested number is returned
    Given I request "/1.0/users/letgo/tweets.json?count=10"
    Then the response code is 200
    And the response body is a JSON array of length 10

  Scenario: I want to see a bad request if more than 50 tweets is requested
    Given I request "/1.0/users/letgo/tweets.json?count=51"
    Then the response code is 400
    And the response body contains JSON:
      """
      {
        "code": 400,
        "message": "Requested tweet number \"51\" exceeds maximum \"50\"."
      }
      """


  Scenario: I want to see if response is in correct format and text is in uppercase
    Given I request "/1.0/users/letgo/tweets.json?count=1"
    Then the response code is 200
    And the response body contains JSON:
      """
      {
        "[0]": {
          "id": "@variableType(string)",
          "external_id": "@variableType(string)",
          "created_at": "@variableType(string)",
          "text": "@regExp(/^[^\\p{Ll}]+$/u)"
        }
      }
      """

  Scenario: I want to see if a not found request if i specify an non-existent user
    Given I request "/1.0/users/nobody/tweets.json"
    Then the response code is 404
    And the response body contains JSON:
      """
      {
        "code": 404,
        "message": "User with name \"nobody\" could not be found."
      }
      """
