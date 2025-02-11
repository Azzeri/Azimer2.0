<?php

declare(strict_types=1);

namespace App\Tests\SampleProvider\Fleet;

use App\Fleet\Application\Command\AddVehicleCommand;
use App\Fleet\Domain\Dto\VehicleInputData;
use App\Fleet\Domain\Enum\FleetPermission;
use App\Fleet\Domain\Enum\VehicleStatus;
use App\Fleet\Domain\Enum\VehicleType;
use App\Fleet\Domain\Policy\AddVehicle\VehicleCanBeAdded;
use App\Fleet\Domain\ValueObject\AssignedUnit;
use App\Fleet\Domain\ValueObject\AssignedUnitId;
use App\Fleet\Domain\ValueObject\FleetManager;
use App\Fleet\Domain\Vehicle;
use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Mockery;
use Symfony\Component\Uid\Uuid;

use function Pest\Faker\fake;

/**
 * Generates sample fleet data
 *
 * @author Mariusz Waloszczyk
 */
final readonly class FleetSamples
{
    /**
     * @return Vehicle
     * @throws InvalidDataException|BusinessRuleViolationException
     * @author Mariusz Waloszczyk
     */
    public static function vehicleAggregate(): Vehicle
    {
        $policy = Mockery::mock(VehicleCanBeAdded::class);
        $policy->shouldReceive("isSatisfiedBy")
            ->andReturn(BusinessRulesNotificationsCollection::create());

        $inputData = new VehicleInputData(
            fake()->numerify('ONY####'),
            VehicleStatus::IN_USE->value,
            VehicleType::TRUCK->value,
            fake()->company(),
            fake()->word(),
            (int)fake()->year(),
            (int)fake()->month(),
            Uuid::v4()->toString()
        );
        return Vehicle::fromInputData(new AddVehicleCommand($inputData), $policy);
    }

    /**
     * @param FleetPermission[] $permissions
     * @return FleetManager
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public static function fleetManager(array $permissions): FleetManager
    {
        $assignedUnit = AssignedUnit::create(AssignedUnitId::fromString(Uuid::v4()->toString()));
        return FleetManager::create($assignedUnit, $permissions);
    }

    /**
     * @return AssignedUnit
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public static function assignedUnit(): AssignedUnit
    {
        return AssignedUnit::create(AssignedUnitId::fromString(Uuid::v4()->toString()));
    }
}
