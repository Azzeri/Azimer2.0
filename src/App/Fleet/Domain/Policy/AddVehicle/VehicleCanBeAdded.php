<?php

declare(strict_types=1);

namespace App\Fleet\Domain\Policy\AddVehicle;

use App\Fleet\Application\Command\AddVehicleCommand;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;

/**
 * Policy checking if all business rules to create a vehicle are valid
 *
 * @author Mariusz Waloszczyk
 */
interface VehicleCanBeAdded
{
    /**
     * Check if all business rules to create a vehicle are valid, and return a collection of violations
     *
     * @param AddVehicleCommand $command
     * @return BusinessRulesNotificationsCollection
     * @author Mariusz Waloszczyk
     */
    public function checkBusinessRules(AddVehicleCommand $command): BusinessRulesNotificationsCollection;
}
