Feature: Authenticate

    As an unauthenticated user
    I want to log in to the system
    To be able to use it

    Background:
        Given an unauthenticated user with email "joe@azimer.com"

    Scenario: User doesn't have an account in the system
        Given non-existing credentials
        When "joe@azimer.com" does not have account in system
        Then "joe@azimer.com" should see a 401 error
        And an unsuccessful LoginHistoryEntry should be created

    Scenario: User provides incorrect credentials
        Given incorrect credentials
        When "joe@azimer.com" has an account in system
        Then "joe@azimer.com" should see a 401 error
        And an unsuccessful LoginHistoryEntry should be created

    Scenario: User provides correct credentials but account is inactive
        Given correct credentials
        And "joe@azimer.com" status is INACTIVE
        When "joe@azimer.com" attempts to log in
        Then "joe@azimer.com" should see a 401 error
        And an unsuccessful LoginHistoryEntry should be created

    Scenario: User provides correct credentials
        Given correct credentials
        And "joe@azimer.com" status is ACTIVE
        When "joe@azimer.com" attempts to log in
        Then "joe@azimer.com" should be authenticated
        And a successful LoginHistoryEntry should be created
