@mod @mod_surveypro @surveyprofield @surveyprofield_select
Feature: make a submission test for "select" item
  In order to test that minimal use of surveypro is guaranteed
  As student1
  I add a select item, I fill it and I go to see responses

  @javascript
  Scenario: test a submission works fine for select item
    Given the following "courses" exist:
      | fullname                        | shortname              | category |
      | Test submission for select item | Select submission test | 0        |
    And the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | teacher  | teacher1@nowhere.net |
      | student1 | Student1  | user1    | student1@nowhere.net |
    And the following "course enrolments" exist:
      | user     | course                 | role           |
      | teacher1 | Select submission test | editingteacher |
      | student1 | Select submission test | student        |
    And the following "activities" exist:
      | activity  | name        | intro                             | course                 | idnumber   |
      | surveypro | Select test | To test submission of select item | Select submission test | surveypro1 |
    And I log in as "teacher1"
    And I follow "Test submission for select item"
    And I follow "Select test"

    And I set the field "typeplugin" to "Select"
    And I press "Add"

    And I expand all fieldsets
    And I set the following fields to these values:
      | Content           | Which summer holidays place do you prefer? |
      | Required          | 1                                          |
      | Indent            | 0                                          |
      | Question position | left                                       |
      | Element number    | 15                                         |
    And I fill the textarea "Options" with multiline content "sea\nmountain\nlake\nhills\ndesert"
    And I press "Add"

    And I log out

    # student1 logs in
    When I log in as "student1"
    And I follow "Test submission for select item"
    And I follow "Select test"
    And I press "New response"

    # student1 submits
    And I set the following fields to these values:
      | 15: Which summer holidays place do you prefer? | hills |

    And I press "Submit"

    And I press "Continue to responses list"
    Then I should see "1" submissions
