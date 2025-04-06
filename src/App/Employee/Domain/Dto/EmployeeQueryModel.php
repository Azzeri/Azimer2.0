<?php

declare(strict_types=1);

namespace App\Employee\Domain\Dto;

/**
 * Query model representing a single employee
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EmployeeQueryModel
{
    /**
     * @param string $id
     * @param string $lastName
     * @param string $firstName
     * @param string $email
     * @param string $employeeUnitId
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        public string $id,
        public string $lastName,
        public string $firstName,
        public string $email,
        public string $employeeUnitId
    ) {
    }
}
