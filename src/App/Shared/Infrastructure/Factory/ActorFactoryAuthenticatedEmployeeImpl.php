<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Factory;

use App\Employee\Application\Service\EmployeeApiService;
use App\Shared\DomainUtilities\Domain\Actor;
use App\Shared\DomainUtilities\Domain\ActorFactory;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use BackedEnum;

/**
 * Implementation of {@see ActorFactory} creating actors based on authenticated employee
 * @template T of Actor
 * @implements ActorFactory<T>
 *
 * @author Mariusz Waloszczyk
 */
abstract readonly class ActorFactoryAuthenticatedEmployeeImpl implements ActorFactory
{
    /**
     * @param EmployeeApiService $employeeApiService
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        private EmployeeApiService $employeeApiService,
    ) {
    }

    /**
     * @inheritDoc
     * @throws ResourceNotFoundException
     * @author Mariusz Waloszczyk
     */
    public function create(): Actor
    {
        $employee = $this->employeeApiService->getAuthenticatedEmployee();

        /** @var array<int, string> $permissions */
        $permissions = array_filter(
            array_map(
                function (string $permission) {
                    $permission = $this->getPermissionEnum()::tryFrom($permission);
                    if ($permission !== null) {
                        return $permission->value;
                    }
                },
                $employee['resources']
            )
        );

        /** @var T */
        return $this->createActorInstance(
            $employee['id'],
            $permissions,
            $employee['fireBrigadeUnitId']
        );
    }

    /**
     * Get enum that represents permissions for actor's actions
     *
     * @return class-string<BackedEnum>
     * @author Mariusz Waloszczyk
     */
    abstract protected function getPermissionEnum(): string;

    /**
     * Create instance of the specific actor implementation
     *
     * @param string $identifier
     * @param array<int, string> $permissions
     * @param string $organizationalUnitId
     */
    abstract protected function createActorInstance(
        string $identifier,
        array $permissions,
        string $organizationalUnitId
    ): Actor;
}
