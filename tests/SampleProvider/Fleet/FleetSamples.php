<?php

declare(strict_types=1);

namespace Tests\SampleProvider\Fleet;

use App\Fleet\Application\Command\AddVehicleCommand;
use App\Fleet\Domain\Dto\VehicleQueryModel;
use App\Fleet\Domain\Enum\FleetPermission;
use App\Fleet\Domain\Enum\VehicleStatus;
use App\Fleet\Domain\Enum\VehicleType;
use App\Fleet\Domain\Policy\AddVehicle\VehicleCanBeAdded;
use App\Fleet\Domain\ValueObject\FleetManager;
use App\Fleet\Domain\ValueObject\FleetUnitId;
use App\Fleet\Domain\Vehicle;
use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Mockery;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

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
        $policy->shouldReceive("checkBusinessRules")
            ->andReturn(BusinessRulesNotificationsCollection::create());

        $inputData = new AddVehicleCommand(
            fake()->numerify('ONY####'),
            VehicleStatus::IN_USE->value,
            VehicleType::TRUCK->value,
            fake()->company(),
            fake()->word(),
            (int)fake()->year(),
            (int)fake()->month(),
            Uuid::v4()->toString()
        );
        return Vehicle::fromInputData($inputData, $policy);
    }

    /**
     * @return VehicleQueryModel
     * @author Mariusz Waloszczyk
     */
    public static function vehicleQueryModel(): VehicleQueryModel
    {
        return new VehicleQueryModel(
            fake()->numerify('ONY####'),
            VehicleStatus::IN_USE->value,
            VehicleType::TRUCK->value,
            fake()->company(),
            fake()->word(),
            (int)fake()->year(),
            Uuid::v4()->toString(),
            (int)fake()->month(),
        );
    }

    /**
     * @return AddVehicleCommand
     * @author Mariusz Waloszczyk
     */
    public static function vehicleValidInputData(): AddVehicleCommand
    {
        return new AddVehicleCommand(
            fake()->numerify('ONY####'),
            VehicleStatus::IN_USE->value,
            VehicleType::TRUCK->value,
            fake()->company(),
            fake()->word(),
            (int)fake()->year(),
            (int)fake()->month(),
            Uuid::v4()->toString(),
        );
    }

    /**
     * @param FleetPermission[] $permissions
     * @param UuidV4|null $assignedUnitId
     * @return FleetManager
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public static function fleetManager(array $permissions = [], ?UuidV4 $assignedUnitId = null): FleetManager
    {
        $assignedUnitId = $assignedUnitId ?: Uuid::v4();
        $assignedUnit = FleetUnitId::fromString((string)$assignedUnitId);
        return FleetManager::create($assignedUnit, $permissions);
    }
}
