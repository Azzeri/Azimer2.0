Feature: Assign Vehicle to Unit

    As a fleet manager
    I want to reassign a vehicle to another unit
    To enable trading vehicles between units

    Background:
        Given a fire brigade unit "Opole"
        And a fire brigade unit "Nysa"
        And an authenticated employee "Joe"
        And a vehicle with plate number "ONY1234" assigned to the "Nysa" unit

    Scenario: Employee is not permitted
        Given "Joe" does not have permission to reassign vehicles
        When "Joe" attempts to reassign "ONY1234" from the "Nysa" unit to the "Opole" unit
        Then "Joe" should see a 403 error

    Scenario: Employee reassigns a vehicle between units
        Given "Joe" has the required permission to reassign vehicles
        When "Joe" attempts to reassign "ONY1234" from the "Nysa" unit to the "Opole" unit
        Then "ONY1234" is reassigned from the "Nysa" unit to the "Opole" unit
