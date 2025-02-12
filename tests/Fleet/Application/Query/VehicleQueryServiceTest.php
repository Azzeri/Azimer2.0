<?php

declare(strict_types=1);

namespace App\Tests\Fleet\Application\Query;

use App\Fleet\Application\Query\Definition\FindVehicleQuery;
use App\Fleet\Application\Query\Definition\SearchVehiclesQuery;
use App\Fleet\Application\Query\VehicleQueryService;
use App\Fleet\Domain\Dto\VehicleQueryModel;
use App\Fleet\Domain\Repository\VehicleQueryModelRepository;
use App\Fleet\Domain\ValueObject\VehiclePlateNumber;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\QueryUtilities\Domain\QueryItem;
use App\Shared\QueryUtilities\Domain\QueryItemCollection;
use App\Tests\SampleProvider\Fleet\FleetSamples;
use Mockery;
use Ramsey\Collection\Collection;

it(
    'returns null if vehicle not found',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $repository = Mockery::mock(VehicleQueryModelRepository::class);
        $repository->shouldReceive('findByPlateNumber')
            ->with(Mockery::on(fn($arg) => $arg->equals(VehiclePlateNumber::fromString('ONY1234'))))
            ->andReturn(null);

        $service = new VehicleQueryService($repository);

        // Act
        $result = $service->findOne(new FindVehicleQuery('ONY1234'));

        // Assert
        expect($result)->toBeNull();
    }
);

it(
    'returns query item with vehicle if found',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $queryModel = FleetSamples::vehicleQueryModel();
        $repository = Mockery::mock(VehicleQueryModelRepository::class);
        $repository->shouldReceive('findByPlateNumber')
            ->with(Mockery::on(fn($arg) => $arg->equals(VehiclePlateNumber::fromString('ONY1234'))))
            ->andReturn($queryModel);

        $service = new VehicleQueryService($repository);

        // Act
        $result = $service->findOne(new FindVehicleQuery('ONY1234'));

        // Assert
        expect($result)->toBeInstanceOf(QueryItem::class)
            ->and($result->data)->toEqual($queryModel);
    }
);
it(
    'returns collection of vehicles',
    function () {
        // Arrange
        $firstQueryModel = FleetSamples::vehicleQueryModel();
        $secondQueryModel = FleetSamples::vehicleQueryModel();

        $repository = Mockery::mock(VehicleQueryModelRepository::class);
        $repository->shouldReceive('search')
            ->andReturn(new Collection(VehicleQueryModel::class, [$firstQueryModel, $secondQueryModel]));

        $service = new VehicleQueryService($repository);

        // Act
        $result = $service->search(new SearchVehiclesQuery());

        // Assert
        expect($result)->toBeInstanceOf(QueryItemCollection::class)
            ->and($result->data[0]->data)->toEqual($firstQueryModel)
            ->and($result->data[1]->data)->toEqual($secondQueryModel);
    }
);
