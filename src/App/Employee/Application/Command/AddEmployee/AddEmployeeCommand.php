<?php

declare(strict_types=1);

namespace App\Employee\Application\Command\AddEmployee;

/**
 * Command creating a new Employee
 *
 * @author Mariusz Waloszczyk
 */
final readonly class AddEmployeeCommand
{
    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $employeeUnitId
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $employeeUnitId
    ) {
    }
}
