<?php

declare(strict_types=1);

namespace App\Fleet\Infrastructure\Factory;

use App\FireBrigadeUnit\Application\Service\FireBrigadeUnitApiService;
use App\Fleet\Domain\Factory\AssignedUnitFactory;
use App\Fleet\Domain\ValueObject\AssignedUnit;
use App\Fleet\Domain\ValueObject\AssignedUnitId;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;

/**
 * Implementation of {@see AssignedUnitFactory}
 * Currently handles only one level of hierarchy,
 * meaning superior|subservient of superior or subservient is not mapped to avoid unnecessary recursion
 *
 * @author Mariusz Waloszczyk
 */
final readonly class AssignedUnitFactoryImpl implements AssignedUnitFactory
{
    /**
     * @param FireBrigadeUnitApiService $fireBrigadeUnitApiService
     *
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        private FireBrigadeUnitApiService $fireBrigadeUnitApiService
    ) {
    }

    /**
     * @throws ResourceNotFoundException|InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public function createFromIdentifier(AssignedUnitId $id): AssignedUnit
    {
        $apiUnit = $this->fireBrigadeUnitApiService->findUnitById((string)$id);
        if ($apiUnit === null) {
            throw new ResourceNotFoundException("Fire brigade unit not found");
        }

        $parentUnit = !empty($apiUnit['superiorUnitId'])
            ? AssignedUnit::create(AssignedUnitId::fromString($apiUnit['superiorUnitId']))
            : null;

        $subservientUnits = array_map(
            fn(string $subservientUnitId) => AssignedUnit::create(
                AssignedUnitId::fromString($subservientUnitId)
            ),
            $apiUnit['subservientUnitsIds']
        );

        return AssignedUnit::create(
            AssignedUnitId::fromString($apiUnit['id']),
            $subservientUnits,
            $parentUnit
        );
    }
}
