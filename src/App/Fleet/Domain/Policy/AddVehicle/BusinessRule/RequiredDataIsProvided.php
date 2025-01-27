<?php

declare(strict_types=1);

namespace App\Fleet\Domain\Policy\AddVehicle\BusinessRule;

/**
 * All required data has to be provided and valid
 *
 * @author Mariusz Waloszczyk
 */
interface RequiredDataIsProvided extends VehicleCanBeAddedBusinessRule
{
}
