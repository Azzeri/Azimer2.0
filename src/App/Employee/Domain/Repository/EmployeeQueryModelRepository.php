<?php

declare(strict_types=1);

namespace App\Employee\Domain\Repository;

use App\Employee\Domain\Dto\EmployeeQueryModel;
use App\Employee\Domain\ValueObject\EmployeeEmail;
use App\Employee\Domain\ValueObject\EmployeeId;

/**
 * Repository to get employee's query model
 * TODO - implement search criteria
 * @author Mariusz Waloszczyk
 */
interface EmployeeQueryModelRepository
{
    /**
     * @param EmployeeId $identifier
     * @return EmployeeQueryModel|null
     * @author Mariusz Waloszczyk
     */
    public function findByIdentifier(EmployeeId $identifier): ?EmployeeQueryModel;

    /**
     * @param EmployeeEmail $email
     * @return EmployeeQueryModel|null
     * @author Mariusz Waloszczyk
     */
    public function findByEmail(EmployeeEmail $email): ?EmployeeQueryModel;

}
