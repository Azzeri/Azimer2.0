<?php

declare(strict_types=1);

namespace App\Tests\Fleet\Infrastructure\Factory;

use App\Fleet\Domain\Enum\FleetPermission;
use App\Fleet\Domain\Factory\AssignedUnitFactory;
use App\Fleet\Domain\ValueObject\AssignedUnit;
use App\Fleet\Domain\ValueObject\FleetManager;
use App\Fleet\Infrastructure\Factory\FleetManagerFactoryImpl;
use App\Security\Application\Service\SecurityApiService;
use App\Shared\CommonUtilities\ReflectionUtils;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use App\Tests\SampleProvider\Fleet\FleetSamples;
use App\Tests\SampleProvider\Security\SecuritySamples;
use Mockery;
use ReflectionException;

it(
    'creates fleet manager from an authenticated user with fleet permissions only',
    /**
     * @throws ReflectionException
     * @throws InvalidDataException
     * @throws ResourceNotFoundException
     */
    function () {
        // Arrange
        $securityApiService = Mockery::mock(SecurityApiService::class);
        $securityApiService->shouldReceive('getAuthenticatedUser')
            ->andReturn(SecuritySamples::apiUser([FleetPermission::ADD_SUBSERVIENT->value, 'other']));

        $assignedUnitFactory = Mockery::mock(AssignedUnitFactory::class);
        $assignedUnitFactory->shouldReceive('createFromIdentifier')
            ->andReturn(FleetSamples::assignedUnit());

        $factory = new FleetManagerFactoryImpl($securityApiService, $assignedUnitFactory);

        // Act
        $manager = $factory->fromAuthenticatedUser();

        // Assert
        $permissions = ReflectionUtils::getReflectionPropertyValue($manager, 'permissions');
        expect($manager)->toBeInstanceOf(FleetManager::class)
            ->and($permissions)->toContainOnlyInstancesOf(FleetPermission::class);
    }
);
