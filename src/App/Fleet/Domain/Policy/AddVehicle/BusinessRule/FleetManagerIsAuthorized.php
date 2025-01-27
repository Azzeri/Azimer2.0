<?php

declare(strict_types=1);

namespace App\Fleet\Domain\Policy\AddVehicle\BusinessRule;

/**
 * Fleet manager has to be authorized to add a vehicle to the requested unit
 *
 * @author Mariusz Waloszczyk
 */
interface FleetManagerIsAuthorized extends VehicleCanBeAddedBusinessRule
{
}
