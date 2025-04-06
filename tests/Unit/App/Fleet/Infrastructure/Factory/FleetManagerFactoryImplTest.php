<?php

declare(strict_types=1);

namespace Tests\Unit\App\Fleet\Infrastructure\Factory;

use App\Employee\Application\Service\EmployeeApiService;
use App\Fleet\Domain\Enum\FleetPermission;
use App\Fleet\Domain\ValueObject\FleetManager;
use App\Fleet\Infrastructure\Factory\FleetManagerFactoryImpl;
use App\Shared\CommonUtilities\ReflectionUtils;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use Mockery;
use ReflectionException;
use Symfony\Component\Uid\Uuid;

it(
    'creates fleet manager from an authenticated user with fleet permissions only',
    /**
     * @throws ReflectionException
     * @throws InvalidDataException
     * @throws ResourceNotFoundException
     */
    function () {
        // Arrange
        $employee = [
            'id' => '1234',
            'fireBrigadeUnitId' => Uuid::v4()->toString(),
            'resources' => [
                'test',
                FleetPermission::ADD_ALL->value,
                FleetPermission::ADD_SUBSERVIENT->value,
            ]
        ];
        $employeeApiService = Mockery::mock(EmployeeApiService::class);
        $employeeApiService->shouldReceive('getAuthenticatedEmployee')
            ->once()
            ->andReturn($employee);

        $factory = new FleetManagerFactoryImpl($employeeApiService);

        // Act
        $manager = $factory->fromAuthenticatedEmployee();

        // Assert
        $permissions = ReflectionUtils::getReflectionPropertyValue($manager, 'permissions');
        expect($manager)->toBeInstanceOf(FleetManager::class)
            ->and($permissions)->toContainOnlyInstancesOf(FleetPermission::class);
    }
);
