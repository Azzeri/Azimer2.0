Feature: Authenticate

    As an authenticated user
    I want to log out of the system
    To finish working with it

    Scenario: User logs out
        Given an authenticated user with email "joe@azimer.com"
        When "joe@azimer.com" attempts log out operation
        Then "joe@azimer.com" is logged out
