<?php

declare(strict_types=1);

namespace App\Tests\Fleet\Infrastructure\Persistence\Elastic\Repository;

use App\Fleet\Domain\ValueObject\VehiclePlateNumber;
use App\Fleet\Infrastructure\Persistence\Elastic\Repository\VehicleQueryModelElasticRepository;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Tests\SampleProvider\Fleet\FleetSamples;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Mockery;
use Ramsey\Collection\Collection;

it(
    'returns vehicle found by a plate number',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $vehicleQueryModel = FleetSamples::vehicleQueryModel();
        $plateNumber = VehiclePlateNumber::fromString('ONY1234');
        $elasticFinder = Mockery::mock(TransformedFinder::class);
        $elasticFinder->shouldReceive('find')
            ->with((string)$plateNumber)
            ->andReturn([$vehicleQueryModel]);

        $elasticFinder = new VehicleQueryModelElasticRepository($elasticFinder);

        // Act
        $result = $elasticFinder->findByPlateNumber($plateNumber);

        // Assert
        expect($result)->toBe($vehicleQueryModel);
    }
);

it(
    'returns null if vehicle not found by a plate number',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $plateNumber = VehiclePlateNumber::fromString('ONY1234');
        $elasticFinder = Mockery::mock(TransformedFinder::class);
        $elasticFinder->shouldReceive('find')
            ->with((string)$plateNumber)
            ->andReturn([]);

        $elasticFinder = new VehicleQueryModelElasticRepository($elasticFinder);

        // Act
        $result = $elasticFinder->findByPlateNumber($plateNumber);

        // Assert
        expect($result)->toBeNull();
    }
);

it(
    'searches for all vehicles',
    function () {
        // Arrange
        $vehicleQueryModel = FleetSamples::vehicleQueryModel();
        $elasticFinder = Mockery::mock(TransformedFinder::class);
        $elasticFinder->shouldReceive('find')
            ->with('*', 999)
            ->andReturn([$vehicleQueryModel, $vehicleQueryModel]);

        $elasticFinder = new VehicleQueryModelElasticRepository($elasticFinder);

        // Act
        $result = $elasticFinder->search();

        // Assert
        expect($result)->toBeInstanceOf(Collection::class)
            ->and($result->contains($vehicleQueryModel))->toBeTrue()
            ->and($result)->toHaveCount(2);
    }
);
