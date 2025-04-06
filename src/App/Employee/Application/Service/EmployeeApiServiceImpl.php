<?php

declare(strict_types=1);

namespace App\Employee\Application\Service;

use App\Employee\Domain\Repository\EmployeeQueryModelRepository;
use App\Employee\Domain\ValueObject\EmployeeEmail;
use App\Security\Application\Tenant\Service\SecurityApiService;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;

/**
 * Implementation of {@see EmployeeApiService}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EmployeeApiServiceImpl implements EmployeeApiService
{
    /**
     * @param SecurityApiService $securityApiService
     * @param EmployeeQueryModelRepository $employeeQueryModelRepository
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        private SecurityApiService $securityApiService,
        private EmployeeQueryModelRepository $employeeQueryModelRepository,
    ) {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getAuthenticatedEmployee(): array
    {
        $tenant = $this->securityApiService->getAuthenticatedTenant();
        $employee = $this->employeeQueryModelRepository->findByEmail(EmployeeEmail::fromString($tenant['id']));
        if ($employee === null) {
            throw new ResourceNotFoundException("Failed to get authenticated employee");
        }

        return [
            'id' => $employee->id,
            'fireBrigadeUnitId' => $employee->employeeUnitId,
            'resources' => $tenant['permissions']
        ];
    }
}
