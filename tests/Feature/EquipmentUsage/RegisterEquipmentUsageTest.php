<?php

declare(strict_types=1);

namespace Tests\Feature\EquipmentRegister\EquipmentCategory;

use App\EquipmentRegister\Domain\Equipment\Builder\EquipmentBuilder;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentOwnerId;
use App\EquipmentRegister\Domain\Shared\Enum\EquipmentPermission;
use App\EquipmentUsage\Domain\Builder\EquipmentUsageBuilder;
use App\EquipmentUsage\Domain\EquipmentUsage;
use App\EquipmentUsage\Domain\ValueObject\EquipmentUsagePeriod;
use App\EquipmentUsage\Domain\ValueObject\UsedEquipmentId;
use App\FireBrigadeUnit\Domain\FireBrigadeUnit;
use App\FireBrigadeUnit\Domain\ValueObject\FireBrigadeUnitId;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Tests\SampleProvider\EquipmentUsage\Dto\EquipmentUsageInputDataBuilder;

it(
    'fails if user tries to record usage for own unit\'s equipment, but is not authorized',
    function () {
        // Arrange
        $ownerId = EquipmentOwnerId::generate()->toString();
        $unit = new FireBrigadeUnit(FireBrigadeUnitId::fromString($ownerId));
        $usedEquipment = (new EquipmentBuilder())
            ->withOwner(EquipmentOwnerId::fromString($unit->getId()->toString()))
            ->build();

        $this->saveEntities([$unit, $usedEquipment]);

        $inputData = (new EquipmentUsageInputDataBuilder())
            ->withUsedEquipmentId($usedEquipment->getId()->toString())
            ->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment-usage',
            [EquipmentPermission::EQUIPMENT_USAGE_REGISTER_SUBSERVIENT_UNITS->value],
            $ownerId
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(403, $response->getContent())
            ->and($response->getContent())
            ->toContain('Equipment manager is not authorized to register usage for the requested equipment');

        $equipment = $this->entityManager->getRepository(EquipmentUsage::class)
            ->findAll();

        expect($equipment)
            ->toBeEmpty();
    }
);

it(
    'can record usage for own unit\'s equipment if authorized',
    function () {
        // Arrange
        $ownerId = EquipmentOwnerId::generate()->toString();
        $unit = new FireBrigadeUnit(FireBrigadeUnitId::fromString($ownerId));
        $usedEquipment = (new EquipmentBuilder())
            ->withOwner(EquipmentOwnerId::fromString($unit->getId()->toString()))
            ->build();

        $this->saveEntities([$unit, $usedEquipment]);

        $inputData = (new EquipmentUsageInputDataBuilder())
            ->withUsedEquipmentId($usedEquipment->getId()->toString())
            ->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment-usage',
            [EquipmentPermission::EQUIPMENT_USAGE_REGISTER_OWN_UNIT->value],
            $ownerId
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(201);

        $equipment = $this->entityManager->getRepository(EquipmentUsage::class)
            ->findAll();

        expect($equipment[0])
            ->not()
            ->toBeEmpty();
    }
);

it(
    'fails if user tries to record usage for subservient unit\'s equipment, but is not authorized',
    function () {
        // Arrange
        $ownerId = EquipmentOwnerId::generate()->toString();
        $unit = new FireBrigadeUnit(FireBrigadeUnitId::fromString($ownerId));
        $subservientUnit = new FireBrigadeUnit(FireBrigadeUnitId::generate(), $unit);
        $usedEquipment = (new EquipmentBuilder())
            ->withOwner(EquipmentOwnerId::fromString($subservientUnit->getId()->toString()))
            ->build();

        $this->saveEntities([$unit, $subservientUnit, $usedEquipment]);

        $inputData = (new EquipmentUsageInputDataBuilder())
            ->withUsedEquipmentId($usedEquipment->getId()->toString())
            ->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment-usage',
            [EquipmentPermission::EQUIPMENT_USAGE_REGISTER_OWN_UNIT->value],
            $ownerId
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(403, $response->getContent())
            ->and($response->getContent())
            ->toContain('Equipment manager is not authorized to register usage for the requested equipment');

        $equipment = $this->entityManager->getRepository(EquipmentUsage::class)
            ->findAll();

        expect($equipment)
            ->toBeEmpty();
    }
);

it(
    'can record usage for subservient unit\'s equipment if authorized',
    function () {
        // Arrange
        $ownerId = EquipmentOwnerId::generate()->toString();
        $unit = new FireBrigadeUnit(FireBrigadeUnitId::fromString($ownerId));
        $subservientUnit = new FireBrigadeUnit(FireBrigadeUnitId::generate(), $unit);
        $usedEquipment = (new EquipmentBuilder())
            ->withOwner(EquipmentOwnerId::fromString($subservientUnit->getId()->toString()))
            ->build();

        $this->saveEntities([$unit, $subservientUnit, $usedEquipment]);

        $inputData = (new EquipmentUsageInputDataBuilder())
            ->withUsedEquipmentId($usedEquipment->getId()->toString())
            ->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment-usage',
            [EquipmentPermission::EQUIPMENT_USAGE_REGISTER_OWN_UNIT->value],
            $ownerId
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(403, $response->getContent())
            ->and($response->getContent())
            ->toContain('Equipment manager is not authorized to register usage for the requested equipment');

        $equipment = $this->entityManager->getRepository(EquipmentUsage::class)
            ->findAll();

        expect($equipment)
            ->toBeEmpty();
    }
);

it(
    'records equipment usage with different time ranges and detects overlaps',
    function (
        string $from,
        string $to,
        int $expectedStatus,
        int $expectedUsagesCount,
        ?string $expectedError = null
    ) {
        // Arrange
        $ownerId = EquipmentOwnerId::generate()->toString();
        $unit = new FireBrigadeUnit(FireBrigadeUnitId::fromString($ownerId));
        $usedEquipment = (new EquipmentBuilder())
            ->withOwner(EquipmentOwnerId::fromString($unit->getId()->toString()))
            ->build();

        $existingFrom = Carbon::yesterday()->setTime(11, 15, 00);
        $existingTo = Carbon::yesterday()->setTime(11, 17, 00);

        $existingUsage = (new EquipmentUsageBuilder())
            ->withUsedEquipmentId(UsedEquipmentId::fromString($usedEquipment->getId()->toString()))
            ->withPeriod(EquipmentUsagePeriod::create(CarbonPeriod::create($existingFrom, $existingTo)))
            ->build();

        $this->saveEntities([$unit, $usedEquipment, $existingUsage]);

        $inputData = (new EquipmentUsageInputDataBuilder())
            ->withUsedEquipmentId($usedEquipment->getId()->toString())
            ->withUsedFrom($from)
            ->withUsedTo($to)
            ->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment-usage',
            [EquipmentPermission::EQUIPMENT_USAGE_REGISTER_ALL_UNITS->value],
            $ownerId
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe($expectedStatus, $response->getContent());

        if ($expectedError !== null) {
            expect($response->getContent())->toContain($expectedError);
        }

        $usages = $this->entityManager->getRepository(EquipmentUsage::class)->findAll();
        expect($usages)->toHaveCount($expectedUsagesCount);
    }
)->with([
    'no overlap - before' => [
        'from' => Carbon::yesterday()->setTime(10, 00, 00)->format('Y-m-d H:i:s'),
        'to' => Carbon::yesterday()->setTime(10, 30, 00)->format('Y-m-d H:i:s'),
        'expectedStatus' => 201,
        'expectedUsagesCount' => 2,
        'expectedError' => null,
    ],
    'no overlap - after' => [
        'from' => Carbon::yesterday()->setTime(12, 00, 00)->format('Y-m-d H:i:s'),
        'to' => Carbon::yesterday()->setTime(12, 30, 00)->format('Y-m-d H:i:s'),
        'expectedStatus' => 201,
        'expectedUsagesCount' => 2,
        'expectedError' => null,
    ],
    'exact overlap' => [
        'from' => Carbon::yesterday()->setTime(11, 15, 00)->format('Y-m-d H:i:s'),
        'to' => Carbon::yesterday()->setTime(11, 17, 00)->format('Y-m-d H:i:s'),
        'expectedStatus' => 422,
        'expectedUsagesCount' => 1,
        'expectedError' => 'Overlapping usage periods detected',
    ],
    'partial overlap - start' => [
        'from' => Carbon::yesterday()->setTime(11, 00, 00)->format('Y-m-d H:i:s'),
        'to' => Carbon::yesterday()->setTime(11, 16, 00)->format('Y-m-d H:i:s'),
        'expectedStatus' => 422,
        'expectedUsagesCount' => 1,
        'expectedError' => 'Overlapping usage periods detected',
    ],
    'partial overlap - end' => [
        'from' => Carbon::yesterday()->setTime(11, 16, 00)->format('Y-m-d H:i:s'),
        'to' => Carbon::yesterday()->setTime(11, 30, 00)->format('Y-m-d H:i:s'),
        'expectedStatus' => 422,
        'expectedUsagesCount' => 1,
        'expectedError' => 'Overlapping usage periods detected',
    ],
    'within existing' => [
        'from' => Carbon::yesterday()->setTime(11, 16, 00)->format('Y-m-d H:i:s'),
        'to' => Carbon::yesterday()->setTime(11, 16, 30)->format('Y-m-d H:i:s'),
        'expectedStatus' => 422,
        'expectedUsagesCount' => 1,
        'expectedError' => 'Overlapping usage periods detected',
    ],
    'outside existing' => [
        'from' => Carbon::yesterday()->setTime(11, 14, 00)->format('Y-m-d H:i:s'),
        'to' => Carbon::yesterday()->setTime(11, 20, 30)->format('Y-m-d H:i:s'),
        'expectedStatus' => 422,
        'expectedUsagesCount' => 1,
        'expectedError' => 'Overlapping usage periods detected',
    ],
    'invalid dates range' => [
        'from' => Carbon::yesterday()->setTime(11, 14, 00)->format('Y-m-d H:i:s'),
        'to' => Carbon::yesterday()->setTime(11, 13, 30)->format('Y-m-d H:i:s'),
        'expectedStatus' => 422,
        'expectedUsagesCount' => 1,
        'expectedError' => 'Start date must not be after end date.',
    ],
]);
