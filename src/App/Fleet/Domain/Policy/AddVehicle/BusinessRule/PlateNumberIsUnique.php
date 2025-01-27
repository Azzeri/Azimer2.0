<?php

declare(strict_types=1);

namespace App\Fleet\Domain\Policy\AddVehicle\BusinessRule;

/**
 * Plate number has to be unique
 *
 * @author Mariusz Waloszczyk
 */
interface PlateNumberIsUnique extends VehicleCanBeAddedBusinessRule
{
}
