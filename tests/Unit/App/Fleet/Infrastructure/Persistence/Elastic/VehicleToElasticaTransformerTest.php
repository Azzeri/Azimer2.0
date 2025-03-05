<?php

declare(strict_types=1);

namespace Tests\Unit\App\Fleet\Infrastructure\Persistence\Elastic;

use App\Fleet\Domain\Enum\VehicleStatus;
use App\Fleet\Domain\Enum\VehicleType;
use App\Fleet\Domain\ValueObject\AssignedUnitId;
use App\Fleet\Domain\ValueObject\VehicleName;
use App\Fleet\Domain\ValueObject\VehiclePlateNumber;
use App\Fleet\Domain\ValueObject\VehicleProductionDate;
use App\Fleet\Infrastructure\Persistence\Elastic\VehicleToElasticaTransformer;
use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\CommonUtilities\ReflectionUtils;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Tests\SampleProvider\Fleet\FleetSamples;
use Elastica\Document;
use InvalidArgumentException;
use ReflectionException;
use stdClass;

it(
    'throws exception on invalid data type',
    /**
     * @throws ReflectionException
     */
    function () {
        // Arrange
        $transformer = new VehicleToElasticaTransformer();

        // Act // Assert
        expect(
            fn() => $transformer->transform(new stdClass(), [])
        )->toThrow(InvalidArgumentException::class);
    }
);
it(
    'transforms Vehicle to Elastic Document',
    /**
     * @throws ReflectionException|InvalidDataException|BusinessRuleViolationException
     */
    function () {
        // Arrange
        $vehicle = FleetSamples::vehicleAggregate();

        /** @var VehiclePlateNumber $plateNumber */
        $plateNumber = ReflectionUtils::getReflectionPropertyValue($vehicle, 'plateNumber');

        /** @var VehicleType $type */
        $type = ReflectionUtils::getReflectionPropertyValue($vehicle, 'type');

        /** @var VehicleName $name */
        $name = ReflectionUtils::getReflectionPropertyValue($vehicle, 'name');

        /** @var VehicleStatus $status */
        $status = ReflectionUtils::getReflectionPropertyValue($vehicle, 'status');

        /** @var VehicleProductionDate $productionDate */
        $productionDate = ReflectionUtils::getReflectionPropertyValue($vehicle, 'productionDate');

        /** @var AssignedUnitId $assignedUnitId */
        $assignedUnitId = ReflectionUtils::getReflectionPropertyValue($vehicle, 'assignedUnitId');

        $transformer = new VehicleToElasticaTransformer();

        // Act
        $result = $transformer->transform($vehicle, []);

        // Assert
        expect($result)->toBeInstanceOf(Document::class)
            ->and($result->__get('plateNumber'))->toBe((string)$plateNumber)
            ->and($result->__get('type'))->toBe($type->value)
            ->and($result->__get('make'))->toBe($name->make())
            ->and($result->__get('model'))->toBe($name->model())
            ->and($result->__get('status'))->toBe($status->value)
            ->and($result->__get('productionYear'))->toBe($productionDate->year())
            ->and($result->__get('productionMonth'))->toBe($productionDate->month())
            ->and($result->__get('assignedUnitId'))->toBe((string)$assignedUnitId);
    }
);
