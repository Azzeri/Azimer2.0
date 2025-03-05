<?php

declare(strict_types=1);

namespace Tests\Unit\App\Fleet\Infrastructure\Persistence\Doctrine\Repository;

use App\Fleet\Domain\Vehicle;
use App\Fleet\Infrastructure\Persistence\Doctrine\Repository\VehicleDoctrineRepository;
use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Tests\SampleProvider\Fleet\FleetSamples;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Mockery;

it('handles Vehicle class but not others', function () {
    // Arrange
    $entityManager = Mockery::mock(EntityManagerInterface::class);
    $repository = new VehicleDoctrineRepository($entityManager);

    // Act // Assert
    expect($repository->canHandle(Vehicle::class))->toBeTrue()
        ->and($repository->canHandle('SomeOtherClass'))->toBeFalse();
});

it(
    'calls entity manager repository and returns vehicle',
    /**
     * @throws BusinessRuleViolationException|InvalidDataException
     */
    function () {
        // Arrange
        $vehicle = FleetSamples::vehicleAggregate();
        $entityManager = Mockery::mock(EntityManagerInterface::class);
        $objectRepository = Mockery::mock(EntityRepository::class);

        $entityManager->shouldReceive('getRepository')
            ->with(Vehicle::class)
            ->andReturn($objectRepository);
        $objectRepository->shouldReceive('find')
            ->with('ABC123')
            ->andReturn($vehicle);

        $repository = new VehicleDoctrineRepository($entityManager);

        // Act // Assert
        expect($repository->findBy(Vehicle::class, ['plateNumber' => 'ABC123']))->toBe($vehicle);
    }
);

it(
    'persists and flushes entity',
    /**
     * @throws BusinessRuleViolationException|InvalidDataException
     */
    function () {
        // Arrange
        $vehicle = FleetSamples::vehicleAggregate();
        $entityManager = Mockery::mock(EntityManagerInterface::class);

        $entityManager->shouldReceive('persist')
            ->with($vehicle)
            ->once();
        $entityManager->shouldReceive('flush')
            ->once();

        $repository = new VehicleDoctrineRepository($entityManager);

        // Act // Assert
        $repository->save(['plateNumber' => 'ABC123'], $vehicle, [], null);
    }
);
