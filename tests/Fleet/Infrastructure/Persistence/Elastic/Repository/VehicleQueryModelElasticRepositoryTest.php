<?php

declare(strict_types=1);

namespace App\Tests\Fleet\Infrastructure\Persistence\Elastic\Repository;

use App\Fleet\Domain\Dto\VehicleQueryModel;
use App\Fleet\Domain\ValueObject\VehiclePlateNumber;
use App\Fleet\Infrastructure\Persistence\Elastic\Repository\VehicleQueryModelElasticRepository;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Mockery;
use Ramsey\Collection\Collection;

it('returns vehicle found by a plate number', function () {
    // Arrange
    $vehicleQueryModel = new VehicleQueryModel(
        '',
        '',
        '',
        '',
        '',
        1,
        '',
        2
    );
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
});

it('returns null if vehicle not found by a plate number', function () {
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
});

it('searches for all vehicles', function () {
    // Arrange
    $vehicleQueryModel = new VehicleQueryModel(
        '',
        '',
        '',
        '',
        '',
        1,
        '',
        2
    );
    $plateNumber = VehiclePlateNumber::fromString('ONY1234');
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
});
