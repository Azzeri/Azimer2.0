<?php

declare(strict_types=1);

namespace App\Fleet\Domain\Policy\AddVehicle\BusinessRule;

use App\Fleet\Application\Command\AddVehicleCommand;
use App\Fleet\Domain\ValueObject\FleetManager;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/**
 * A single business rule that needs to be valid to create a new vehicle
 *
 * @author Mariusz Waloszczyk
 */
#[AutoconfigureTag(VehicleCanBeAddedBusinessRule::class)]
interface VehicleCanBeAddedBusinessRule
{
    /**
     * A single business rule that needs to be valid to create a new vehicle
     *
     * @param AddVehicleCommand $command
     * @param FleetManager $fleetManager
     * @return BusinessRuleNotification|null
     * @author Mariusz Waloszczyk
     */
    public function check(AddVehicleCommand $command, FleetManager $fleetManager): ?BusinessRuleNotification;
}
