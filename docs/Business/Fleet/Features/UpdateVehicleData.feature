Feature: Update Vehicle Data

    As a fleet manager
    I want to update vehicle data in the system
    To keep it up to date

    Background:
        Given a superior fire brigade unit "Opole"
        And its subservient fire brigade unit "Nysa"
        And an unrelated "Warszawa" unit
        And an authenticated employee "Joe" assigned to the "Opole" unit
        And vehicle data to update, including type, name, status, and production date

    Scenario: Employee is not a fleet manager
        Given "Joe" does not have any fleet management permissions
        When "Joe" attempts to update a vehicle
        Then "Joe" should see a 403 error

    Scenario: Fleet manager updates a vehicle with invalid data
        Given "Joe" has permission to update vehicles assigned to his own unit
        And invalid vehicle data
        When "Joe" attempts to update a vehicle assigned to the "Opole" unit
        Then "Joe" should see an invalid data error

    Scenario: Fleet manager updates a vehicle assigned to a unit he is assigned to
        Given "Joe" has permission to update vehicles assigned to his own unit
        And valid vehicle data
        When "Joe" attempts to update a vehicle assigned to the "Opole" unit
        Then the vehicle is updated with the new data

    Scenario: Fleet manager updates a vehicle assigned to a unit he is not assigned to
        Given "Joe" has permission to update vehicles of his own unit
        When "Joe" attempts to update a vehicle of the "Warszawa" unit
        Then "Joe" should see a 403 error

    Scenario: Fleet manager tries to update a vehicle of a subservient unit without permission
        Given "Joe" has permission to update vehicles of his own unit only
        When "Joe" attempts to update a vehicle of the "Nysa" unit
        Then "Joe" should see a 403 error

    Scenario: Fleet manager tries to update a vehicle of a subservient unit with permission
        Given "Joe" has permission to update vehicles of subservient units
        And valid vehicle data
        When "Joe" attempts to update a vehicle of the "Nysa" unit
        Then the vehicle of the "Nysa" unit is updated
