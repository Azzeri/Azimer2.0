<?php

declare(strict_types=1);

namespace App\Tests\Fleet\Infrastructure\Factory;

use App\FireBrigadeUnit\Application\Service\FireBrigadeUnitApiService;
use App\Fleet\Domain\ValueObject\AssignedUnit;
use App\Fleet\Domain\ValueObject\AssignedUnitId;
use App\Fleet\Infrastructure\Factory\AssignedUnitFactoryImpl;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use Mockery;
use Symfony\Component\Uid\Uuid;

it(
    'creates assigned unit from API unit with superior/subservient hierarchy',
    /**
     * @throws InvalidDataException|ResourceNotFoundException
     */
    function () {
        // Arrange
        $createdUnitId = Uuid::v4()->toString();
        $superiorUnitId = Uuid::v4()->toString();
        $firstSubservientUnitId = Uuid::v4()->toString();
        $secondSubservientUnitId = Uuid::v4()->toString();

        $apiUnit = [
            'id' => $createdUnitId,
            'superiorUnitId' => $superiorUnitId,
            'subservientUnitsIds' => [$firstSubservientUnitId, $secondSubservientUnitId]
        ];

        $apiUnitService = Mockery::mock(FireBrigadeUnitApiService::class);
        $apiUnitService->shouldReceive('findUnitById')
            ->with($createdUnitId)
            ->andReturn($apiUnit);

        $factory = new AssignedUnitFactoryImpl($apiUnitService);

        // Act
        $assignedUnit = $factory->createFromIdentifier(AssignedUnitId::fromString($createdUnitId));

        // Assert
        $isSubservientToSuperior = $assignedUnit->isSubservientTo(AssignedUnitId::fromString($superiorUnitId));
        $isSuperiorToFirstSubservient = $assignedUnit->isSuperiorTo(
            AssignedUnitId::fromString($firstSubservientUnitId)
        );
        $isSuperiorToSecondSubservient = $assignedUnit->isSuperiorTo(
            AssignedUnitId::fromString($secondSubservientUnitId)
        );

        expect($assignedUnit)->toBeInstanceOf(AssignedUnit::class)
            ->and((string)$assignedUnit->id())->toEqual($createdUnitId)
            ->and($isSubservientToSuperior)->toBeTrue()
            ->and($isSuperiorToFirstSubservient)->toBeTrue()
            ->and($isSuperiorToSecondSubservient)->toBeTrue();
    }
);

it(
    'creates assigned unit from API unit without any superior/subservient',
    /**
     * @throws InvalidDataException|ResourceNotFoundException
     */
    function () {
        // Arrange
        $createdUnitId = Uuid::v4()->toString();

        $apiUnit = [
            'id' => $createdUnitId,
            'superiorUnitId' => null,
            'subservientUnitsIds' => []
        ];

        $apiUnitService = Mockery::mock(FireBrigadeUnitApiService::class);
        $apiUnitService->shouldReceive('findUnitById')
            ->with($createdUnitId)
            ->andReturn($apiUnit);

        $factory = new AssignedUnitFactoryImpl($apiUnitService);

        // Act
        $assignedUnit = $factory->createFromIdentifier(AssignedUnitId::fromString($createdUnitId));

        // Assert
        expect($assignedUnit)->toBeInstanceOf(AssignedUnit::class)
            ->and((string)$assignedUnit->id())->toEqual($createdUnitId);
    }
);
