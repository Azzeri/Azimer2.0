<?php

declare(strict_types=1);

namespace App\Fleet\Infrastructure\Factory;

use App\Fleet\Domain\Enum\FleetPermission;
use App\Fleet\Domain\Factory\AssignedUnitFactory;
use App\Fleet\Domain\Factory\FleetManagerFactory;
use App\Fleet\Domain\ValueObject\AssignedUnitId;
use App\Fleet\Domain\ValueObject\FleetManager;
use App\Security\Application\Service\SecurityApiService;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;

/**
 * Implementation of {@see FleetManagerFactory}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class FleetManagerFactoryImpl implements FleetManagerFactory
{
    /**
     * @param SecurityApiService $securityApiService
     * @param AssignedUnitFactory $assignedUnitFactory
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        private SecurityApiService $securityApiService,
        private AssignedUnitFactory $assignedUnitFactory
    ) {
    }

    /**
     * @inheritDoc
     * @throws ResourceNotFoundException|InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public function fromAuthenticatedUser(): FleetManager
    {
        $authenticatedUser = $this->securityApiService
            ->getAuthenticatedUser();
        $fireBrigadeUnit = $this->assignedUnitFactory
            ->createFromIdentifier(AssignedUnitId::fromString($authenticatedUser['fireBrigadeUnitId']));

        $permissions = [];
        foreach ($authenticatedUser['permissions'] as $permission) {
            $fleetPermission = FleetPermission::tryFrom($permission);
            if ($fleetPermission !== null) {
                $permissions[] = $fleetPermission;
            }
        }

        return FleetManager::create(
            $fireBrigadeUnit,
            $permissions
        );
    }
}
