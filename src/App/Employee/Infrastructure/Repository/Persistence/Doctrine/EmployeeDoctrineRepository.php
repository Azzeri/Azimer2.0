<?php

declare(strict_types=1);

namespace App\Employee\Infrastructure\Repository\Persistence\Doctrine;

use App\Employee\Domain\Employee;
use App\Employee\Domain\Repository\EmployeeRepository;
use App\Shared\Infrastructure\Doctrine\StandardRepositoryDoctrineImpl;
use Ecotone\Modelling\Attribute\Repository;

/**
 * Doctrine implementation of {@see EmployeeRepository}
 *
 * @author Mariusz Waloszczyk
 */
#[Repository]
final readonly class EmployeeDoctrineRepository extends StandardRepositoryDoctrineImpl implements
    EmployeeRepository
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getClassName(): string
    {
        return Employee::class;
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getIdentifierPropertyName(): string
    {
        return 'id';
    }
}
