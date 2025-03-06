Feature: Add a New Vehicle

    As a fleet manager
    I want to add new vehicles to the system
    So they can be managed

    Background:
        Given a superior fire brigade unit "Opole"
        And its subservient fire brigade unit "Nysa"
        And an unrelated "Warszawa" unit
        And an authenticated employee "Joe" assigned to the "Opole" unit

    Scenario: Employee is not a fleet manager
        Given "Joe" does not have any fleet management permissions
        When "Joe" attempts to add a vehicle
        Then "Joe" should see a 403 error

    Scenario: Fleet manager adds a vehicle with invalid data
        Given "Joe" has permission to add vehicles to his own unit
        And invalid vehicle data
        When "Joe" attempts to add a vehicle to the "Opole" unit
        Then "Joe" should see an invalid data error

    Scenario: Fleet manager adds a vehicle to a unit he is assigned to
        Given "Joe" has permission to add vehicles to his own unit
        And valid vehicle data
        When "Joe" attempts to add a vehicle to the "Opole" unit
        Then the vehicle is added to the "Opole" unit

    Scenario: Fleet manager adds a vehicle to a unit he is not assigned to
        Given "Joe" has permission to add vehicles to his own unit
        When "Joe" attempts to add a vehicle to the "Warszawa" unit
        Then "Joe" should see a 403 error

    Scenario: Fleet manager tries to add a vehicle to a subservient unit without permission
        Given "Joe" has permission to add vehicles to his own unit only
        When "Joe" attempts to add a vehicle to the "Nysa" unit
        Then "Joe" should see a 403 error

    Scenario: Fleet manager tries to add a vehicle to a subservient unit with permission
        Given "Joe" has permission to add vehicles to subservient units
        And valid vehicle data
        When "Joe" attempts to add a vehicle to the "Nysa" unit
        Then the vehicle is added to the "Nysa" unit
